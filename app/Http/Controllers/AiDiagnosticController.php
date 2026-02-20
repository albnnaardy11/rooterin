<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Artesaos\SEOTools\Facades\SEOTools;

class AiDiagnosticController extends Controller
{
    public function index()
    {
        SEOTools::setTitle('AI Visual Pipe Diagnostics - Deteksi Mampet Otomatis');
        SEOTools::setDescription('Gunakan teknologi AI (Computer Vision) Rooterin untuk mendeteksi masalah pipa Anda hanya dengan foto. Cepat, akurat, dan canggih.');
        
        return view('ai-diagnostic.index');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'result_label' => 'required|string',
            'confidence_score' => 'required|integer',
            'audio_label' => 'nullable|string',
            'audio_confidence' => 'nullable|integer',
            'survey_data' => 'nullable|array',
            'recommended_tools' => 'nullable|string',
            'city_location' => 'nullable|string',
            'metadata' => 'nullable|array',
        ]);

        // --- ROOTERIN INFERENCE ENGINE (WEIGHTED MULTI-INPUT) ---
        $vScore = $validated['confidence_score'];
        $aScore = $validated['audio_confidence'] ?? 0;
        $sScore = !empty($validated['survey_data']) ? 90 : 0; // Simple survey importance

        // Composite Weighted Score Calculation
        $compositeScore = ($vScore * 0.5) + ($aScore * 0.3) + ($sScore * 0.2);
        
        // Deep Ranking Logic (A-E)
        $deepRanking = 'E'; // Bottom-tier
        if ($compositeScore >= 90) $deepRanking = 'A';
        elseif ($compositeScore >= 75) $deepRanking = 'B';
        elseif ($compositeScore >= 50) $deepRanking = 'C';
        elseif ($compositeScore >= 25) $deepRanking = 'D';

        // Generate ID: #RT-YYYY-XXXX
        $year = date('Y');
        $count = \App\Models\AiDiagnose::whereYear('created_at', $year)->count() + 1;
        $diagnoseId = "#RT-{$year}-" . str_pad($count, 4, '0', STR_PAD_LEFT);

        $diagnose = \App\Models\AiDiagnose::create([
            'diagnose_id' => $diagnoseId,
            'result_label' => $validated['result_label'],
            'audio_label' => $validated['audio_label'] ?? 'No Audio Capture',
            'audio_confidence' => $validated['audio_confidence'] ?? 0,
            'survey_data' => $validated['survey_data'] ?? [],
            'final_deep_score' => $deepRanking,
            'analysis_version' => '3.0-Inference',
            'recommended_tools' => $validated['recommended_tools'] ?? 'Standard Rooter',
            'confidence_score' => $vScore,
            'city_location' => $validated['city_location'] ?? 'Global/Auto',
            'metadata' => $validated['metadata'] ?? [],
            'status' => 'pending'
        ]);

        return response()->json([
            'success' => true,
            'diagnose_id' => $diagnose->diagnose_id,
            'deep_ranking' => $deepRanking,
            'data' => $diagnose
        ]);
    }
}
