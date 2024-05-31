<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function productIndex()
    {
        $products = Products::all();
        return response()->json(['products' => $products]);
    }

    public function showProduct($id)
    {
        $product = Products::findOrFail($id);
        return response()->json($product);
    }

    public function storeProduct(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_name' => 'required|string|max:255',
            'product_description' => 'nullable|string',
            'product_price' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $productData = $request->all();
        $productData['user_id'] = Auth::id();

        $product = Products::create($productData);
        return response()->json($product, 201);
    }

    public function editProduct(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'product_name' => 'required|string|max:255',
            'product_description' => 'nullable|string',
            'product_price' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $productData = $request->all();
        $productData['user_id'] = Auth::id();

        $product = Products::findOrFail($id);
        $product->update($productData);
        return response()->json($product);
    }

    public function deleteProduct($id)
    {
        $product = Products::findOrFail($id);
        $product->delete();
        return response()->json(null, 204);
    }
}
