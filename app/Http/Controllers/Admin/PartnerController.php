<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PartnerController extends Controller
{
    protected $imageService;

    public function __construct(\App\Services\Image\ImageOptimizationService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function index()
    {
        $partners = Partner::orderBy('order')->get();
        return view('admin.partners.index', compact('partners'));
    }

    public function create()
    {
        return view('admin.partners.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'website_url' => 'nullable|url',
            'is_active' => 'boolean',
            'order' => 'integer'
        ]);

        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = $this->imageService->optimize($request->file('logo'), 'partners', 500, 90);
        }

        Partner::create([
            'name' => $request->name,
            'logo_path' => $logoPath,
            'website_url' => $request->website_url,
            'is_active' => $request->is_active ?? true,
            'order' => $request->order ?? 0
        ]);

        return redirect()->route('admin.partners.index')->with('success', 'Partner added to the alliance.');
    }

    public function edit($id)
    {
        $partner = Partner::findOrFail($id);
        return view('admin.partners.edit', compact('partner'));
    }

    public function update(Request $request, $id)
    {
        $partner = Partner::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'website_url' => 'nullable|url',
            'is_active' => 'boolean',
            'order' => 'integer'
        ]);

        $data = [
            'name' => $request->name,
            'website_url' => $request->website_url,
            'is_active' => $request->is_active ?? true,
            'order' => $request->order ?? 0
        ];

        if ($request->hasFile('logo')) {
            // Delete old logo
            if ($partner->logo_path) {
                // Remove /storage/ or the path relative to public/
                $oldPath = str_replace(['/storage/', 'storage/'], '', $partner->logo_path);
                if (Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->delete($oldPath);
                } elseif (file_exists(public_path($partner->logo_path))) {
                    unlink(public_path($partner->logo_path));
                }
            }

            $data['logo_path'] = $this->imageService->optimize($request->file('logo'), 'partners', 500, 90);
        }

        $partner->update($data);

        return redirect()->route('admin.partners.index')->with('success', 'Partner profile synchronized.');
    }

    public function destroy($id)
    {
        $partner = Partner::findOrFail($id);
        if ($partner->logo_path) {
            $oldPath = str_replace(['/storage/', 'storage/'], '', $partner->logo_path);
            if (Storage::disk('public')->exists($oldPath)) {
                Storage::disk('public')->delete($oldPath);
            } elseif (file_exists(public_path($partner->logo_path))) {
                unlink(public_path($partner->logo_path));
            }
        }
        $partner->delete();

        return redirect()->route('admin.partners.index')->with('success', 'Partner removed from network.');
    }
}
