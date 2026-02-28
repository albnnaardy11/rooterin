<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    protected $imageService;

    public function __construct(\App\Services\Image\ImageOptimizationService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function index()
    {
        $files = Media::latest()->paginate(24);
        return view('admin.media.index', compact('files'));
    }

    public function store(Request $request)
    {
        $request->validate(['file' => 'required|image|max:5120']);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fullPath = $this->imageService->optimize($file, 'uploads');
            $relativePath = str_replace('/storage/', '', $fullPath);

            Media::create([
                'filename' => basename($relativePath),
                'original_name' => $file->getClientOriginalName(),
                'mime_type' => 'image/webp',
                'size' => Storage::disk('public')->size($relativePath),
                'path' => $relativePath,
                'disk' => 'public',
            ]);
        }

        return back()->with('success', 'File uploaded and optimized to WebP.');
    }

    public function destroy($id)
    {
        $media = Media::findOrFail($id);
        Storage::disk($media->disk)->delete($media->path);
        $media->delete();

        return back()->with('success', 'File removed from library.');
    }
}
