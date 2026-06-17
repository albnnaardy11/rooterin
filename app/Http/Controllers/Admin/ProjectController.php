<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\ProjectRepositoryInterface;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    protected $projectRepo;
    protected $imageService;

    public function __construct(
        ProjectRepositoryInterface $projectRepo,
        \App\Services\Image\ImageOptimizationService $imageService
    ) {
        $this->projectRepo = $projectRepo;
        $this->imageService = $imageService;
    }

    public function index()
    {
        $residential = Project::where('category', 'Residential')->latest()->paginate(10, ['*'], 'residential_page');
        $commercial = Project::where('category', 'Commercial')->latest()->paginate(10, ['*'], 'commercial_page');
        $specialized = Project::where('category', 'Specialized')->latest()->paginate(10, ['*'], 'specialized_page');
        
        $stats = [
            'total' => Project::count(),
            'residential' => Project::where('category', 'Residential')->count(),
            'commercial' => Project::where('category', 'Commercial')->count(),
            'specialized' => Project::where('category', 'Specialized')->count(),
            'featured' => Project::where('is_featured', true)->count()
        ];

        return view('admin.projects.index', compact('residential', 'commercial', 'specialized', 'stats'));
    }

    public function create()
    {
        return view('admin.projects.create');
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|max:255',
                'category' => 'required|in:Residential,Commercial,Specialized',
                'location' => 'nullable',
                'image' => 'required|image|max:2048',
                'is_featured' => 'nullable|boolean',
            ]);

            $validated['is_featured'] = $request->boolean('is_featured');

            if ($request->hasFile('image')) {
                $path = $this->imageService->optimize($request->file('image'), 'projects');
                $validated['images'] = [$path];
            }

            unset($validated['image']);
            $this->projectRepo->create($validated);

            return redirect()->route('admin.projects.index')->with('success', 'Project created successfully.');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Project Store Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal membuat proyek. Silakan coba lagi.')->withInput();
        }
    }

    public function edit($id)
    {
        $project = $this->projectRepo->find($id);
        $project->image_url = $project->images[0] ?? null;
        return view('admin.projects.edit', compact('project'));
    }

    public function update(Request $request, $id)
    {
        try {
            $project = $this->projectRepo->find($id);
            
            $validated = $request->validate([
                'title' => 'required|max:255',
                'category' => 'required|in:Residential,Commercial,Specialized',
                'location' => 'nullable',
                'image' => 'nullable|image|max:2048',
                'is_featured' => 'nullable|boolean',
            ]);

            $validated['is_featured'] = $request->boolean('is_featured');

            if ($request->hasFile('image')) {
                // Delete old image
                $oldImages = $project->images;
                if ($oldImages && isset($oldImages[0]) && strpos($oldImages[0], '/storage/') === 0) {
                    Storage::disk('public')->delete(str_replace('/storage/', '', $oldImages[0]));
                }
                $path = $this->imageService->optimize($request->file('image'), 'projects');
                $validated['images'] = [$path];
            }

            unset($validated['image']);
            $this->projectRepo->update($id, $validated);

            return redirect()->route('admin.projects.index')->with('success', 'Project updated successfully.');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Project Update Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal memperbarui proyek. Silakan coba lagi.')->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $project = $this->projectRepo->find($id);
            $oldImages = $project->images;
            if ($oldImages) {
                foreach ($oldImages as $img) {
                    if (strpos($img, '/storage/') === 0) {
                        Storage::disk('public')->delete(str_replace('/storage/', '', $img));
                    }
                }
            }
            $this->projectRepo->delete($id);

            return redirect()->route('admin.projects.index')->with('success', 'Project deleted successfully.');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Project Delete Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menghapus proyek. Data mungkin digunakan di tempat lain.');
        }
    }
}
