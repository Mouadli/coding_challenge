<?php

namespace App\Repositories;

use App\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;

class ProductRepository
{
    /**
     * Save a product to DB.
     * 
     * @param $data
     * @return Product
     */
    public function save(array $data): Product
    {
        $product = new Product();

        $product->name = $data['name'];
        $product->description = $data['description'];
        $product->price = $data['price'];
        $product->category_id = $data['category_id'];
        // $product->image = $data['image'];

        $product->save();

        return $product->fresh();
    }

    /**
     * Add image to product
     */
    public function saveImage(int $id, string $name): Product
    {
        $product = Product::find($id);

        $product->image = $name;

        $product->update();

        return $product;
    }

    /**
     * Get all products from DB
     * 
     * @return Product
     */
    public function getAll(array $prices, array $categories): Collection
    {
        $products = Product::withFilters($prices, $categories)->get();

        return $products;
    }

    /**
     * Get Product by name
     * 
     * @param string $name
     * @return Product
     */
    public function getByName(string $name): Collection
    {
        return Product::where('name', 'LIKE', '%' . $name . '%')->get();
    }
}
