<?php

namespace App\Http\Controllers\Api\V1;

use App\Facades\CartHelper;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return CartHelper::get();
    }

    /**
     * Add new or increase, decrease allready existing product item
     * in the user cart.
     *
     * @param Request $request
     * @return array <array>
     */
    public function store(Request $request): array
    {
        $product = Product::with('images')->findOrFail($request->input('product_id'));
        if ($request->input('action') == 1) {
            CartHelper::add($product);
        } else {
            CartHelper::decrease($product);
        }

        return CartHelper::get();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $product_id
     * @return Response
     */
    public function destroy(int $product_id): Response
    {
        $product = Product::where('id', $product_id)->first();
        if (! $product) {
            return response(null, 404);
        }

        CartHelper::remove($product_id);
        return response([
            'msg' => 'success',
            'data' => null,
            ], 200)
        ->header('Content-Type', 'application/json');
    }

    /**
     * Remove the entire User Cart
     *
     * @return response
     */
    public function clear(): Response
    {
        CartHelper::clear();
        return response(null, 200);
    }
}
