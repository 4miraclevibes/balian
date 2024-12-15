<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use Illuminate\Http\Request;
use App\Http\Controllers\Service\ServiceController;
class AssetController extends Controller
{
    protected $serviceController;

    public function __construct(ServiceController $serviceController)
    {
        $this->serviceController = $serviceController;
    }

    public function index()
    {
        $assets = Asset::all(); 
        return view('pages.dashboard.assets.index', compact('assets'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
            'name' => 'required',
        ]);

        if($request->is_active) {
            $is_active = true;
        } else {
            $is_active = false;
        }

        $imageUrl = $this->serviceController->uploadImage($request->file('image'));
        Asset::create([
            ...$request->except('image'),
            'image' => $imageUrl,
            'is_active' => $is_active,
        ]);
        return redirect()->route('dashboard.asset.index');
    }   

    public function update(Request $request, Asset $asset)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
            'name' => 'required',
        ]);

        if ($request->hasFile('image')) {
            $imageUrl = $this->serviceController->uploadImage($request->file('image'));
        }

        if($request->is_active) {
            $is_active = true;
        } else {
            $is_active = false;
        }

        $asset->update([
            ...$request->except('image'),
            'image' => $imageUrl ?? $asset->image,
            'is_active' => $is_active,
        ]);
        return redirect()->route('dashboard.asset.index');
    }
}
