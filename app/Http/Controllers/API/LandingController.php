<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Banner;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function home(Request $request)
    {
        try {
            $categorySlug = $request->query('category');
            $categories = Category::all();
            $banners = Banner::where('is_active', true)->get();

            if ($categorySlug) {
                $category = Category::where('slug', $categorySlug)->firstOrFail();
                $products = Product::where('category_id', $category->id)
                    ->with([
                        'variants' => function($query) {
                            $query->where('is_visible', true);
                        },
                        'variants.variantStocks' => function($query) {
                            $query->select('id', 'product_variant_id', 'quantity')
                                  ->withCount(['stockDetails as available_stock' => function($q) {
                                      $q->where('status', 'ready');
                                  }]);
                        },
                        'category',
                    ])
                    ->get();
                $activeCategory = $category;
            } else {
                $products = Product::with([
                    'variants' => function($query) {
                        $query->where('is_visible', true);
                    },
                    'variants.variantStocks' => function($query) {
                        $query->select('id', 'product_variant_id', 'quantity')
                              ->withCount(['stockDetails as available_stock' => function($q) {
                                  $q->where('status', 'ready');
                              }]);
                    },
                    'category',
                ])
                ->get();
                $activeCategory = null;
            }

            return response()->json([
                'code' => 200,
                'status' => 'success',
                'message' => 'Data retrieved successfully',
                'data' => [
                    'banners' => $banners,
                    'categories' => $categories,
                    'products' => $products,
                    'activeCategory' => $activeCategory
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'code' => 500,
                'status' => 'error',
                'message' => 'An error occurred while retrieving data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function productDetail($slug)
    {
        try {
            $product = Product::where('slug', $slug)->with([
                'variants' => function($query) {
                    $query->where('is_visible', true);
                },
                'variants.variantStocks' => function($query) {
                    $query->select('id', 'product_variant_id', 'quantity')
                          ->withCount(['stockDetails as available_stock' => function($q) {
                              $q->where('status', 'ready');
                          }]);
                },
                'category',
                'images'
            ])->firstOrFail();
            
            return response()->json([
                'code' => 200,
                'status' => 'success',
                'message' => 'Product detail retrieved successfully',
                'data' => $product
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'code' => 404,
                'status' => 'error',
                'message' => 'Product not found',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'code' => 500,
                'status' => 'error',
                'message' => 'An error occurred while retrieving product detail',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
