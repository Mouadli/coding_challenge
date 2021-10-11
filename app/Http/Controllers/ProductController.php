<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Product;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

class ProductController extends Controller
{

    public function store(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'name' => 'required|min:3|max:255',
            'description' => 'min:3',
            'price' => 'regex:/^[0-9]+$/',
            'category_id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'errors' => $validator->errors()]);
        }

        $product = new Product();
        $product->name = $req['name'];
        $product->description = $req['description'];
        $product->price = $req['price'];
        $product->category_id = $req['category_id'];

        if ($req->hasFile('image')) {
            $product->image = time() . '_' . $req->image->store('image');
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

    public function search($name)
    {
        $products = Product::where('name', 'LIKE', '%' . $name . '%')->get();
        return $products;
    }
}
