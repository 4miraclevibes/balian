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
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
        ]);

        $imageUrl = $this->serviceController->uploadImage($request->file('image'));

        if($request->is_active) {
            $is_active = true;
        } else {
            $is_active = false;
        }
        
        Banner::create([
            ...$request->except('image'),
            'image' => $imageUrl,
            'is_active' => $is_active
        ]);
        return redirect()->route('dashboard.banner.index');
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
