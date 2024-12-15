<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Banner;
use App\Models\Asset;
use App\Models\Faq;

class LandingController extends Controller
{
    public function home(Request $request)
    {
        $categories = Category::all();
        $banners = Banner::where('is_active', true)->get();
        $assets = Asset::where('is_active', true)->get();
        $products = Product::orderBy('name', 'asc')->whereHas('variants', function($query) {
                $query->where('is_visible', true);
            })
            ->with(['variants' => function($query) {
                $query->where('is_visible', true);
            }])
            ->get();

        return view('pages.landing.home', compact('products', 'categories', 'banners', 'assets'));
    }

    public function productDetail($slug)
    {
        $assets = Asset::where('is_active', true)->get();
        $product = Product::where('slug', $slug)->with('variants')->firstOrFail();
        return view('pages.landing.productDetail', compact('product', 'assets'));
    }

    public function userDetail()
    {
        $assets = Asset::where('is_active', true)->get();
        return view('pages.landing.userDetails', compact('assets'));
    }

    public function faq()
    {
        $assets = Asset::where('is_active', true)->get();
        $faqs = Faq::all();
        return view('pages.landing.faq', compact('assets', 'faqs'));
    }
}
