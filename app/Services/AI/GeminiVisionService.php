<?php

namespace App\Services\AI;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class GeminiVisionService
{
    protected $apiKeys = [];
    protected $models = [
        'gemini-2.0-flash',
        'gemini-2.5-flash',
        'gemini-flash-latest',
        'gemini-pro-latest'
    ];

    /**
     * UNICORP-GRADE: Neural Core (Centralized AI Gatekeeper)
     */
    private function getKey()
    {
        $guard = app(\App\Services\Ai\AiQuotaGuardService::class);
        $key = $guard->getActiveKey();
        
        return $key ? [
            'key' => $key,
            'index' => Cache::get('sentinel_ai_current_key_index', 0) + 1
        ] : null;
    }

    /**
     * FORENSIC GUARD v2.0 — 5-Layer AI Validation System
     */
    public function analyzePipeImage(string $base64Image, string $mimeType, string $material, string $location): ?array
    {
        $guard = app(\App\Services\Ai\AiQuotaGuardService::class);
        $keys = $guard->getKeys();
        
        if (empty($keys) && !config('ai.groq_key')) {
            Log::error('Neural Pool Exhausted: No API keys (Gemini/Groq) configured.');
            throw new \Exception('429');
        }

        $materialLabel = match(strtolower($material)) {
            'pvc'        => 'PVC / Plastik',
            'besi'       => 'Besi / Cast Iron',
            'fleksibel'  => 'Selang Fleksibel',
            default      => 'Tidak Diketahui',
        };

        $prompt = <<<PROMPT
Anda adalah Master Insinyur Forensik Plumbing Senior dengan pengalaman 50 tahun di lapangan, spesialis dalam kegagalan sistem perpipaan kritis (Forensic Plumbing Expert). 
Anda tidak memberikan jawaban generik. Anda berpikir sangat kritis, skeptis, dan mendeteksi detail yang dilewatkan orang awam.

=== TUGAS ANDA ===
Analisis foto secara forensik. Jangan tertipu oleh visual permukaan. 
Cari tanda-tanda: korosi mikro, kelelahan material (material fatigue), pola sedimentasi yang menunjukkan aliran air yang salah, atau degradasi struktural akibat tekanan.

=== KONTEKS SYSTEM ===
- Material yang Diklaim: {$materialLabel}
- Lokasi: {$location}

=== PROTOKOL ANALISIS KRITIS ===
1. [VISUAL SCAN]: Apakah ini benar-benar pipa? (Jika tidak, tolak dengan tegas namun profesional).
2. [QUALITY AUDIT]: Apakah pencahayaan cukup untuk melihat tekstur material?
3. [MATERIAL FINGERPRINT]: Verifikasi jika visual cocok dengan {$materialLabel}. Jika Anda melihat karat merah pada klaim PVC, sebutkan itu anomali!
4. [FORENSIC DIAGNOSIS]: 
   - Jangan hanya bilang "mampet". Jelaskan APA yang menyumbat (lemak membatu, kalsium, atau benda asing).
   - Estimasi persentase penyempitan diameter pipa.
   - Evaluasi resiko pecah/kebocoran dalam waktu dekat.
5. [TECHNICAL ACTION]: Berikan instruksi teknis level profesional (misal: "Gunakan hydro-jet dengan tekanan 3000 PSI" atau "Lakukan descaling mekanis segera"). Rekomendasikan minimal 2 alat spesifik.

PENTING: Gunakan bahasa teknis yang berwibawa namun tetap bisa dipahami oleh klien (Bahasa Indonesia). Jangan gunakan kata-kata seperti "sepertinya" atau "mungkin". Gunakan "Analisis teknis menunjukkan..." atau "Terdeteksi secara visual...".

=== FORMAT OUTPUT ===
PENTING: Hanya berikan JSON valid berikut, TANPA teks di luar JSON:

{
  "is_plumbing_subject": true|false,
  "rejection_reason": "string atau null",
  "image_quality": "GOOD|BLURRY|TOO_DARK|POOR_ANGLE",
  "quality_message": "string atau null",
  "detected_material": "PVC|BESI|TEMBAGA|BETON|TIDAK_TERLIHAT",
  "material_mismatch": true|false,
  "material_warning": "string atau null",
  "diagnosis": "string (judul diagnosa)",
  "problem_explanation": "string (penjelasan 2-3 kalimat)",
  "blockage_percentage": 0,
  "degradation_percentage": 0,
  "technical_report": "string (3-4 langkah mekanis)",
  "recommended_service_type": "MAMPET|REPARASI|CUCI_TOREN|INSTALASI"
}
PROMPT;

        $attempts = 0;
        $maxAttempts = count($keys);
        $lastException = null;

        while ($attempts < $maxAttempts) {
            $keyData = $this->getKey();
            if (!$keyData) break;

            $startTime = microtime(true);
            $apiKey = $keyData['key'];
            $nodeId = $keyData['index'];
            $keyFingerprint = substr($apiKey, 0, 8) . '...';

            try {
                // HYPER-RESILIENT MULTI-MODEL FAILOVER (Per Node)
                foreach ($this->models as $modelName) {
                    Log::info("[SENTINEL] Inference Attempt via NODE-{$nodeId} Model: {$modelName}");
                    $endpoint = "https://generativelanguage.googleapis.com/v1beta/models/{$modelName}:generateContent";
                    
                    $response = $this->callGemini($apiKey, $endpoint, $prompt, $mimeType, $base64Image);

                    if ($response->successful()) {
                        $result = $response->json();
                        if (isset($result['candidates'][0]['content']['parts'][0]['text'])) {
                            $rawText = $result['candidates'][0]['content']['parts'][0]['text'];
                            if (preg_match('/\{.*\}/s', $rawText, $matches)) {
                                $data = json_decode($matches[0], true);
                                if (json_last_error() === JSON_ERROR_NONE) {
                                    $data['performance'] = [
                                        'latency_ms' => (int)((microtime(true) - $startTime) * 1000),
                                        'key_used'   => "NODE-{$nodeId} ($modelName)",
                                        'timestamp'  => now()->toIso8601String(),
                                        'status'     => $attempts > 0 ? 'FAILOVER_STABLE' : 'STABLE'
                                    ];
                                    return $data;
                                }
                            }
                        }
                    }

                    // Log failure but continue to next model on same key if not 429
                    if ($response->status() !== 429) {
                        Log::warning("[SENTINEL] NODE-{$nodeId} Model {$modelName} failed ($response->status()). Swapping model...");
                        continue;
                    } else {
                        // If 429, don't spam other models on same key, move to next node
                        break; 
                    }
                }

                // If we reach here, this key (all models) failed or hit 429
                $attempts++;
                
                // Track 429 Block if last response was 429
                if ($response->status() === 429) {
                    $errMsg = strtolower($response->json('error.message') ?? '');
                    $cooldownMinutes = (str_contains($errMsg, 'quota') || str_contains($errMsg, 'exhausted')) ? 5 : 1;
                    $until = now()->addMinutes($cooldownMinutes);
                    
                    Cache::put("sentinel_ai_key_blocked_at_" . ($nodeId - 1), $until, $until);
                    Cache::put("gemini_limit_{$nodeId}", $until->toIso8601String(), $until);
                    Log::warning("[SENTINEL] NODE-{$nodeId} hit 429 Quota. Cooldown for {$cooldownMinutes}m.");
                    
                    usleep(300000); // Wait 0.3s before trying next key
                    continue; 
                }

                throw new \Exception("Node-{$nodeId} Exhuasted: " . ($response->json('error.message') ?? 'Unknown Error'));

            } catch (\Exception $e) {
                $lastException = $e;
                Log::error("[SENTINEL] Fatal Attempt {$attempts} on NODE-{$nodeId}: " . $e->getMessage());
                $attempts++;
            }
        }

        // --- ULTIMATE FAILOVER: Groq Cloud (Vision Protocol) ---
        $groqKey = config('ai.groq_key');
        if ($groqKey) {
            $models = ['llama-3.2-90b-vision-preview', 'llama-3.2-11b-vision-preview'];
            
            foreach ($models as $currentModel) {
                try {
                    Log::info("[SENTINEL] PROCEEDING TO ULTIMATE FAILOVER: GROQ NODE ({$currentModel})");
                    $startTime = microtime(true);
                    
                    $response = Http::timeout(35)->withToken($groqKey)->post("https://api.groq.com/openai/v1/chat/completions", [
                        'model' => $currentModel,
                        'messages' => [
                            [
                                'role' => 'user', 
                                'content' => [
                                    ['type' => 'text', 'text' => $prompt],
                                    ['type' => 'image_url', 'image_url' => ['url' => "data:$mimeType;base64,$base64Image"]]
                                ]
                            ]
                        ],
                        'response_format' => ['type' => 'json_object'],
                        'temperature' => 0.1
                    ]);

                    if ($response->successful()) {
                        $data = $response->json('choices.0.message.content');
                        if (is_string($data)) $data = json_decode($data, true);
                        
                        if ($data) {
                            $data['performance'] = [
                                'latency_ms' => (int)((microtime(true) - $startTime) * 1000),
                                'key_used'   => "GROQ-FALLBACK ({$currentModel})",
                                'timestamp'  => now()->toIso8601String(),
                                'status'     => 'FAILOVER_STABLE'
                            ];
                            return $data;
                        }
                    }
                    
                    Log::error("[SENTINEL] Groq ({$currentModel}) Error: " . ($response->json('error.message') ?: $response->body()));
                    
                    // If model decommissioning is the error, try next model
                    if ($response->status() !== 429) continue;
                    else break; // If rate limit on Groq, don't spam other models

                } catch (\Exception $e) {
                    Log::error("[SENTINEL] Groq ({$currentModel}) Exception: " . $e->getMessage());
                }
            }
        }

        throw $lastException ?? new \Exception('429');
    }

    protected function callGemini($apiKey, $endpoint, $prompt, $mimeType, $base64Image)
    {
        return Http::timeout(45)->withHeaders([
            'Content-Type' => 'application/json',
            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/' . rand(110, 120) . '.0.0.0 Safari/537.36',
        ])->post("{$endpoint}?key={$apiKey}", [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $prompt],
                        ['inline_data' => ['mime_type' => $mimeType, 'data' => $base64Image]]
                    ]
                ]
            ],
            'generationConfig' => ['temperature' => 0.1, 'topK' => 16, 'topP' => 0.6]
        ]);
    }
}
