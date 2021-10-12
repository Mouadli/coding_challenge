<?php

namespace App\Repositories;

use App\Product;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\ProductResource;
use Illuminate\Http\UploadedFile;

class ProductRepository
{

    public function store($request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|max:255',
            'description' => 'min:3',
            'price' => 'regex:/^[0-9]+$/',
            'category_id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'errors' => $validator->errors()]);
        }

        $product = new Product();
        $product->name = $request['name'];
        $product->description = $request['description'];
        $product->price = $request['price'];
        $product->category_id = $request['category_id'];

        if ($request->hasFile('image')) {
            $product->image = $request->image->store('image');
        }

        $product->save();
    }

    public function index()
    {
        $products = Product::withFilters(
            request()->input('prices', []),
            request()->input('categories', []),
        )->get();

        return ProductResource::collection($products);
    }

    public function priceIndex($priceService)
    {
        $prices = $priceService->getPrices(
            request()->input('prices', []),
            request()->input('categories', []),
        );

        return response()->json($prices);
    }
}