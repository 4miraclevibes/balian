<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use App\Http\Controllers\Service\ServiceController;
class BannerController extends Controller
{
    protected $serviceController;

    public function __construct(ServiceController $serviceController)
    {
        $this->serviceController = $serviceController;
    }
    public function index()
    {
        $banners = Banner::all();
        return view('pages.dashboard.banners.index', compact('banners'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'files' => 'required|array|min:1',
            'files.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
        ]);

        $is_active = $request->is_active ? true : false;
        $results = [];

        foreach ($request->file('files') as $file) {
            $fileUrl = $this->serviceController->uploadImage($file);

            $banner = Banner::create([
                ...$request->except('files'),
                'image' => $fileUrl,
                'is_active' => $is_active
            ]);

            $results[] = [
                'type' => 'image',
                'record' => $banner,
                'url' => $fileUrl
            ];
        }

        return response()->json([
            'message' => 'Files uploaded successfully',
            'data' => $results,
        ], 201);
    }

    public function update(Request $request, Banner $banner)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
        ]);

        if ($request->hasFile('image')) {
            $imageUrl = $this->serviceController->uploadImage($request->file('image'));
        }

        if($request->is_active) {
            $is_active = true;
        } else {
            $is_active = false;
        }

        $banner->update([
            ...$request->except('image'),
            'image' => $imageUrl ?? $banner->image,
            'is_active' => $is_active
        ]);

        return redirect()->route('dashboard.banner.index');
    }

    public function destroy(Banner $banner)
    {
        $banner->delete();
        return redirect()->route('dashboard.banner.index');
    }
}
