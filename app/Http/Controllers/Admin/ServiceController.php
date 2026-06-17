<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\ServiceRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    protected $serviceRepo;

    public function __construct(ServiceRepositoryInterface $serviceRepo)
    {
        $this->serviceRepo = $serviceRepo;
    }

    public function index()
    {
        $services = $this->serviceRepo->paginate(10);
        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        return view('admin.services.create');
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|max:255',
                'icon' => 'required',
                'description_short' => 'required',
                'description_full' => 'required',
                'price' => 'nullable|numeric',
                'is_active' => 'boolean',
            ]);

            $validated['slug'] = Str::slug($request->name);
            $validated['is_active'] = $request->has('is_active');

            if ($request->hasFile('hover_image')) {
                $path = $request->file('hover_image')->store('services', 'public');
                $validated['gallery'] = ['/storage/' . $path];
            }

            $service = $this->serviceRepo->create($validated);

            if ($request->has('seo')) {
                $service->seo()->create($request->seo);
            }

            return redirect()->route('admin.services.index')->with('success', 'Service created successfully.');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Service Store Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal membuat layanan. Silakan coba lagi.')->withInput();
        }
    }

    public function edit($id)
    {
        $service = $this->serviceRepo->find($id);
        return view('admin.services.edit', compact('service'));
    }

    public function update(Request $request, $id)
    {
        try {
            $service = $this->serviceRepo->find($id);
            
            $validated = $request->validate([
                'name' => 'required|max:255',
                'icon' => 'required',
                'description_short' => 'required',
                'description_full' => 'required',
                'price' => 'nullable|numeric',
                'is_active' => 'boolean',
            ]);

            $validated['slug'] = Str::slug($request->name);
            $validated['is_active'] = $request->has('is_active');

            if ($request->hasFile('hover_image')) {
                $path = $request->file('hover_image')->store('services', 'public');
                $validated['gallery'] = ['/storage/' . $path];
            }

            $this->serviceRepo->update($id, $validated);

            if ($request->has('seo')) {
                $service->seo()->updateOrCreate([], $request->seo);
            }

            return redirect()->route('admin.services.index')->with('success', 'Service updated successfully.');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Service Update Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal memperbarui layanan. Silakan coba lagi.')->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $this->serviceRepo->delete($id);
            return redirect()->route('admin.services.index')->with('success', 'Service deleted successfully.');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Service Delete Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menghapus layanan.');
        }
    }

    public function toggleActive($id)
    {
        try {
            $service = $this->serviceRepo->find($id);
            $this->serviceRepo->update($id, ['is_active' => !$service->is_active]);
            return redirect()->back()->with('success', 'Status layanan berhasil diubah.');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Service Toggle Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal mengubah status.');
        }
    }
}
