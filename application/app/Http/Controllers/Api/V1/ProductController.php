<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Return a listing of the resource Product.
     *
     * @return \Illuminate\Database\Eloquent\Collection <\Illuminate\Database\Eloquent\Builder>
     */
    public function index(): \Illuminate\Database\Eloquent\Collection
    {
        return Product::with('images')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $productData = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' =>  'required',
        ]);

        $productImageData = $request->validate([
            'product_image_path' => 'string', // with condition that when image then with path or make dfefault image
            'product_image_caption' => 'string'
        ]);

        $newProduct = Product::create($productData);

        if ($productImageData) {
            $productImageData['product_id'] = $newProduct->id;
            $newProductImage = \App\Models\ProductImage::create($productImageData);
        }

        return response([
                'msg' => $newProduct ? 'success' : 'failed',
                'data' => $newProduct->load('images'),
                ], $newProduct ? 201 : 422) // https://restfulapi.net/http-methods/
            ->header('Content-Type', 'application/json');
    }

    /**
     * Return the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return Product
     */
    public function show(Product $product): Product
    {
        return $product->load('images');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return bool
     */
    public function update(Request $request, Product $product): bool
    {
        //dd($product->update($request->input()));
        return $product->update($request->input());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product $product
     * @return bool
     */
    public function destroy(Product $product): ?bool
    {
        return $product->delete();
    }
}
