<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use App\Repositories\ProductRepository;
use App\Services\ProductService;
use Exception;

class ProductController extends Controller
{

    /**
     * @var $productService
     */
    protected $productService;

    /**
     * Product constructor
     * 
     * @param ProductService $productService
     */
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * Store a new product.
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $req)
    {
        try {
            $result = [
                'status' => 201,
                'data' => $this->productService->saveProduct($req)
            ];
        } catch (Exception $e) {
            $result = [
                'status' => "error",
                'error' => $e->getMessage()
            ];
        }

        dd("error");

        return response()->json($result);
    }

    /**
     * Retrieve all Product.
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $result = ProductResource::collection($this->productService->getAllProduct());
        } catch (Exception $e) {
            $result = [
                'status' => "error",
                'error' => $e->getMessage()
            ];
        }

        return $result;
    }

    /**
     * Search a specific resourse.
     * 
     * @param $name
     * @return \Illuminate\Http\Response
     */
    public function search($name)
    {
        try {
            $result = [
                'status' => 200,
                'data' => $this->productService->getByName($name)
            ];
        } catch (Exception $e) {
            $result = [
                'status' => "error",
                'error' => $e->getMessage()
            ];
        }

        return response()->json($result);
    }
}
