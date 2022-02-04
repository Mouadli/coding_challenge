<?php

namespace App\Repositories;

use App\Product;
use Illuminate\Http\UploadedFile;

class ProductRepository
{
    /**
     * @var Product
     */
    protected $product;

    /**
     * Product constructor
     * 
     * @param Product $product
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * Save a product to DB.
     * 
     * @param $data
     * @return Product
     */
    public function save($data)
    {
        $product = new $this->product;

        $product->name = $data['name'];
        $product->description = $data['description'];
        $product->price = $data['price'];
        $product->category_id = $data['category_id'];

        if ($data->hasFile('image')) {
            $product->image = $data->image->store('image');
        }

        $product->save();

        return $product->fresh();
    }

    /**
     * Get all products from DB
     * 
     * @return mixed
     */
    public function getAll()
    {
        $products = Product::withFilters(
            request()->input('prices', []),
            request()->input('categories', []),
        )->get();

        return $products;
    }

    /**
     * Get Product by name
     * 
     * @param string $name
     * @return mixed
     */
    public function getByName($name)
    {
        return $this->product->where('name', 'LIKE', '%' . $name . '%')->get();
    }
}