<?php

namespace App\Services;

use App\Repositories\ProductRepository;
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
     * @param object $data
     * @return String
     */
    public function saveProduct(object $data)
    {
        $validator = Validator::make($data->all(), [
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
     * Get all product.
     * 
     * @param object $reqData
     * @return 
     */
    public function getAllProduct(object $reqData)
    {
        return $this->productRepository->getAll($reqData->prices, $reqData->categories);
    }

    /**
     * Get product by name.
     * 
     * @param mixed $name
     * @return String
     */
    public function getByName(string $name)
    {
        return $this->productRepository->getByName($name);
    }
}
