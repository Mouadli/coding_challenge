<?php

namespace App\Services;

use App\Product;
use App\Repositories\ProductRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;

class ProductService
{
    /**
     * @var $productRepository
     */
    protected $productRepository;

    /**
     * ProductService constructor
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
     * @param array $data
     * @return Product
     */
    public function saveProduct(array $data): Product
    {
        $validator = Validator::make($data, [
            'name' => 'required|min:3|max:255',
            'description' => 'min:3',
            'price' => 'regex:/^[0-9]+$/',
            'category_id' => 'required'
        ]);

        if ($validator->fails()) {
            return [
                'errors' => $validator->errors()
            ];
        }

        $result = $this->productRepository->save($data);

        return $result;
    }

    /**
     * Upload Image of product
     */
    public function updateImage(string $name, $id): Product
    {
        return $this->productRepository->saveImage($id, $name);
    }

    /**
     * Get all product.
     * 
     * @param array $reqData
     * @return Product
     */
    public function getAllProduct(array $reqData): Collection
    {
        return $this->productRepository->getAll($reqData['prices'], $reqData['categories']);
    }

    /**
     * Get product by name.
     * 
     * @param mixed $name
     * @return Collection
     */
    public function getByName(string $name): Collection
    {
        return $this->productRepository->getByName($name);
    }
}
