<?php

namespace App\Services;

use App\Repositories\ProductRepository;
use Illuminate\Support\Facades\Validator;


class ProductService
{
    /**
     * @var $productRepository
     */
    protected $productRepository;

    /**
     * Product constructor
     * 
     * @param ProductRepository $productRepository
     */
    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * Validate and store Product data
     * 
     * @param object $data
     * @return String
     */
    public function saveProduct($data)
    {
        $validator = Validator::make($data->all(), [
            'name' => 'required|min:3|max:255',
            'description' => 'min:3',
            'price' => 'regex:/^[0-9]+$/',
            'category_id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'errors' => $validator->errors()]);
        }

        $result = $this->productRepository->save($data);

        return $result;
    }

    /**
     * Get all product.
     * 
     */
    public function getAllProduct()
    {
        return $this->productRepository->getAll();
    }

    /**
     * Get product by name.
     * 
     * @param $name
     * @return String
     */
    public function getByName($name)
    {
        return $this->productRepository->getByName($name);
    }

}