<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ProductImage;
use App\Models\VariantStock;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'category_id' => 2,
                'name' => 'Selada Keriting Organik',
                'slug' => 'selada-keriting-organik',
                'thumbnail' => 'https://ik.imagekit.io/dcjlghyytp1/ec47f3a852e1fe5c7df8b5748585758f?tr=f-auto,w-1000',
                'description' => 'Selada Keriting Organik',
            ],
            [
                'category_id' => 2,
                'name' => 'Selada Romaine',
                'slug' => 'selada-romaine',
                'thumbnail' => 'https://ik.imagekit.io/dcjlghyytp1/f76c43e835a198d319b6ebbcc56a29ac?tr=f-auto,w-1000',
                'description' => 'Product 2 description',
            ],
            [
                'category_id' => 2,
                'name' => 'Selada Air',
                'slug' => 'selada-air',
                'thumbnail' => 'https://ik.imagekit.io/dcjlghyytp1/c1473db9ba6f9b4ad637f1a814c5c4c8?tr=f-auto,w-360',
                'description' => 'Product 3 description',
            ],
            [
                'category_id' => 2,
                'name' => 'Selada Romaine Hidroponik',
                'slug' => 'selada-romaine-hidroponik',
                'thumbnail' => 'https://ik.imagekit.io/dcjlghyytp1/98954be200236bbcf6812b45e56b5d89?tr=f-auto,w-1000',
                'description' => 'Product 4 description',
            ],
            [
                'category_id' => 1,
                'name' => 'Cabai Merah Besar',
                'slug' => 'cabai-merah-besar',
                'thumbnail' => 'https://ik.imagekit.io/dcjlghyytp1/4b322210d94741fc807ef9f4d8fc665d?tr=f-auto,w-1000',
                'description' => 'Product 5 description',
            ],
            [
                'category_id' => 1,
                'name' => 'Cabai Hijau Besar',
                'slug' => 'cabai-hijau-besar',
                'thumbnail' => 'https://ik.imagekit.io/dcjlghyytp1/9d779017d2ba8de8dfb2d730be0503c2?tr=f-auto,w-1000',
                'description' => 'Product 6 description',
            ],
        ];

        foreach ($products as $product) {
            $createdProduct = Product::create($product);

            $this->createProductVariants($createdProduct->id);
            $this->createProductImages($createdProduct->id);
        }
    }

    private function createProductVariants($productId)
    {
        $variants = [
            [
                ['name' => '10 gram', 'price' => 10000, 'is_visible' => 1],
                ['name' => '20 gram', 'price' => 20000, 'is_visible' => 1],
            ],
            [
                ['name' => '100 Gram', 'price' => 10000, 'is_visible' => 1],
                ['name' => '200 Gram', 'price' => 20000, 'is_visible' => 1],
            ],
            [
                ['name' => '100 Gram', 'price' => 10000, 'is_visible' => 1],
                ['name' => '200 Gram', 'price' => 20000, 'is_visible' => 1],
            ],
            [
                ['name' => '1 kg', 'price' => 10000, 'is_visible' => 1],
                ['name' => '1.5 kg', 'price' => 20000, 'is_visible' => 1],
            ],
            [
                ['name' => '1 kg', 'price' => 10000, 'is_visible' => 1],
                ['name' => '1.5 kg', 'price' => 20000, 'is_visible' => 1],
            ],
            [
                ['name' => '2 kg', 'price' => 10000, 'is_visible' => 1],
                ['name' => '2 kg', 'price' => 20000, 'is_visible' => 1],
            ],
        ][$productId - 1];

        foreach ($variants as $variant) {
            $createdVariant = ProductVariant::create(array_merge(['product_id' => $productId], $variant));
            $variantStock = VariantStock::create([
                'product_variant_id' => $createdVariant->id,
                'quantity' => mt_rand(5, 10),
            ]);
            for ($i = 0; $i < $variantStock->quantity; $i++) {
                $variantStock->stockDetails()->create([
                    'variant_stock_id' => $variantStock->id,
                    'capital_price' => $variant['price'] - ($variant['price'] * 0.2),
                    'price' => 0,
                    'status' => 'ready',
                ]);
            }
        }
    }

    private function createProductImages($productId)
    {
        $images = [
            [
                'https://ik.imagekit.io/dcjlghyytp1/ec47f3a852e1fe5c7df8b5748585758f?tr=f-auto,w-1000',
                'https://ik.imagekit.io/dcjlghyytp1/8ed1bc771fc39cbc3bd1576abbdaa010?tr=f-auto,w-1000',
                'https://ik.imagekit.io/dcjlghyytp1/9d639f90fac68deef9dbddec3453fa9c?tr=f-auto,w-1000',
                'https://ik.imagekit.io/dcjlghyytp1/ec47f3a852e1fe5c7df8b5748585758f?tr=f-auto,w-1000',
            ],
            [
                'https://ik.imagekit.io/dcjlghyytp1/f76c43e835a198d319b6ebbcc56a29ac?tr=f-auto,w-1000',
                'https://ik.imagekit.io/dcjlghyytp1/42dfd8edf5dc718584eb362320cf5698?tr=f-auto,w-1000',
                'https://ik.imagekit.io/dcjlghyytp1/076ba3582fa2629f1245cf34809c5678?tr=f-auto,w-1000',
                'https://ik.imagekit.io/dcjlghyytp1/dd66f8072e94672c84c46c733e4d4d29?tr=f-auto,w-1000',
                'https://ik.imagekit.io/dcjlghyytp1/bea1d92be1a5d1fec90f713632cc9f42?tr=f-auto,w-1000',
            ],
            [
                'https://ik.imagekit.io/dcjlghyytp1/76cecf714d9af4a9d86ebccfa725dcd9?tr=f-auto,w-1000',
                'https://ik.imagekit.io/dcjlghyytp1/c1473db9ba6f9b4ad637f1a814c5c4c8?tr=f-auto,w-1000',
                'https://ik.imagekit.io/dcjlghyytp1/2b5bf169894bce3451f753d55179a395?tr=f-auto,w-1000',
                'https://ik.imagekit.io/dcjlghyytp1/a7a03650c1004af0e7a4864d6766aa2e?tr=f-auto,w-1000',
            ],
            [
                'https://ik.imagekit.io/dcjlghyytp1/98954be200236bbcf6812b45e56b5d89?tr=f-auto,w-1000',
                'https://ik.imagekit.io/dcjlghyytp1/2c84966db1645920e198b6c090f84778?tr=f-auto,w-1000',
                'https://ik.imagekit.io/dcjlghyytp1/712f0597a78ca0d41ff813400a306bf8?tr=f-auto,w-1000',
                'https://ik.imagekit.io/dcjlghyytp1/98954be200236bbcf6812b45e56b5d89?tr=f-auto,w-1000',
            ],
            [
                'https://ik.imagekit.io/dcjlghyytp1/4b322210d94741fc807ef9f4d8fc665d?tr=f-auto,w-1000',
                'https://ik.imagekit.io/dcjlghyytp1/dfe5cd0e3cefb511581fd97423980828?tr=f-auto,w-1000',
                'https://ik.imagekit.io/dcjlghyytp1/75c1c470d36ed62a47edca55db306fd4?tr=f-auto,w-1000',
                'https://ik.imagekit.io/dcjlghyytp1/c99b075e15c8d586fead78b9ec76dffb?tr=f-auto,w-1000',
            ],
            [
                'https://ik.imagekit.io/dcjlghyytp1/9d779017d2ba8de8dfb2d730be0503c2?tr=f-auto,w-1000',
                'https://ik.imagekit.io/dcjlghyytp1/9f4f7b11aaeb558ff02c1865610169e3?tr=f-auto,w-1000',
                'https://ik.imagekit.io/dcjlghyytp1/b6f5913699b40826975f724fa74d945e?tr=f-auto,w-1000',
                'https://ik.imagekit.io/dcjlghyytp1/b5dbf919332b4479783d70d5df358654?tr=f-auto,w-1000',
                'https://ik.imagekit.io/dcjlghyytp1/79c49a1fa3439b8409dadc76f2210c10?tr=f-auto,w-1000',
            ],
        ][$productId - 1];

        foreach ($images as $image) {
            ProductImage::create([
                'product_id' => $productId,
                'image' => $image,
            ]);
        }
    }
}
