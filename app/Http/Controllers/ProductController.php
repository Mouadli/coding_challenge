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
            $res = $this->productService->saveProduct($req);
            if ($res['errors']) {
                $result = [
                    'status' => 500,
                    'errors' => $res['errors']
                ];
            } else {
                $result = [
                    'status' => 201,
                    'data' => $res
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
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reqData = (object) [
            'prices' => request()->input('prices', []),
            'categories' => request()->input('categories', []),
        ];

        try {
            $result = ProductResource::collection($this->productService->getAllProduct($reqData));
        } catch (Exception $e) {
            $result = response()->json([
                'status' => 500,
                'error' => $e->getMessage()
            ], 500);
        }

        return $result;
    }

    /**
     * Search a specific resourse.
     * 
     * @param $name
     * @return \Illuminate\Http\Response
     */
    public function search(string $name)
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
