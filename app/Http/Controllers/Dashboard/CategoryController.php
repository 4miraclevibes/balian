<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Service\ServiceController;

class CategoryController extends Controller
{
    protected $serviceController;

    public function __construct(ServiceController $serviceController)
    {
        $this->serviceController = $serviceController;
    }

    public function index()
    {
        $categories = Category::all();
        return view('pages.dashboard.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('pages.dashboard.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
        ]);

        $data = $request->except(['image', 'banner']);

        if ($request->hasFile('image')) {
            $data['image'] = $this->serviceController->uploadImage($request->file('image'));
        }

        if ($request->hasFile('banner')) {
            $data['banner'] = $this->serviceController->uploadImage($request->file('banner'));
        }

        Category::create($data);
        return redirect()->route('dashboard.category.index');
    }

    public function edit(Category $category)
    {
        return view('pages.dashboard.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
        ]);

        $data = $request->except(['image', 'banner']);

        if ($request->hasFile('image')) {
            $data['image'] = $this->serviceController->uploadImage($request->file('image'));
        }

        if ($request->hasFile('banner')) {
            $data['banner'] = $this->serviceController->uploadImage($request->file('banner'));
        }
        $category->update($data);
        return redirect()->route('dashboard.category.index');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('dashboard.category.index')->with('success', 'Kategori berhasil dihapus');
    }
}
