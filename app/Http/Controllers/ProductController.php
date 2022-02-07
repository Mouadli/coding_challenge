<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Product;
use Illuminate\Http\Request;
use App\Services\ProductService;
use Exception;
use Illuminate\Http\JsonResponse as Response;

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
     */
    public function store(Request $req): Response
    {
        $data = $req->all();

        try {
            $res = $this->productService->saveProduct($data);

            if ($req->hasFile('image')) {
                $imageName = $req->image->store('image');
                $res = $this->productService->updateImage($imageName, $res['id']);
            }

            if ($res['errors']) {
                $result = [
                    'status' => 500,
                    'errors' => $res['errors']
                ];
            } else {
                $result = [
                    'status' => 201,
                    'data' => $res,
                    'req' => $req
                ];
            }
        } catch (Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    /**
     * Retrieve all Product.
     */
    public function index(): Response
    {
        $reqData = [
            'prices' => request()->input('prices', []),
            'categories' => request()->input('categories', []),
        ];

        try {
            $result = [
                'status' => 200,
                'data' => $this->productService->getAllProduct($reqData)
            ];
        } catch (Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    /**
     * Search a specific resourse.
     * 
     * @param $name
     */
    public function search(string $name): Response
    {
        try {
            $result = [
                'status' => 200,
                'data' => $this->productService->getByName($name)
            ];
        } catch (Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }
}
