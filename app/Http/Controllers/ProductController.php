<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Get all products
    public function index()
    {
        return response()->json([
            'products' => Product::all()
        ]);
    }

    // Create product
            public function store(Request $request)
        {
            $request->validate([
                'name' => 'required',
                'description' => 'nullable',
                'price' => 'required|numeric',
                'stock_quantity' => 'required|integer|min:0',
                'category' => 'required',
                'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            ]);

            $imagePath = null;

            if ($request->hasFile('image')) {
                // $imagePath = $request->file('image')->getClientOriginalName();
               // pela original naam nu karyu tu pan name duplicate thay sake mate name generate karavyu 
                $imagePath = $request->file('image')->store('products', 'public');
            }

            $product = Product::create([
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
                'stock_quantity' => $request->stock_quantity,
                'category' => $request->category,
                'image' => $imagePath,
            ]);

            return response()->json([
                'message' => 'Product created successfully',
                'product' => $product
            ], 201);
        }

    // Get single product
    public function show(Product $product)
    {
        return response()->json([
            'product' => $product
        ]);
    }

    // Update product
        public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'sometimes|required',
            'description' => 'nullable',
            'price' => 'sometimes|required|numeric',
            'stock_quantity' => 'sometimes|required|integer|min:0',
            'category' => 'sometimes|required',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $data['image'] = $imagePath;
        }

        $product->update($data);

        return response()->json([
            'message' => 'Product updated successfully',
            'product' => $product
        ]);
    }
    // Delete product
    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json([
            'message' => 'Product deleted successfully'
        ]);
    }
        public function lowStock()
    {
        $products = Product::where('stock_quantity', '<', 5)->get();

        return response()->json([
            'message' => 'Low stock products',
            'products' => $products
        ]);
    }
}