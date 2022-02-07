<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Resources\CategoryResource;
use Illuminate\Http\Request;
use App\Repositories\CategoryRepository;
use App\Services\CategoryService;
use Exception;
use Illuminate\Http\JsonResponse as Response;

class CategoryController extends Controller
{

    /**
     * @var $categoryService
     */
    protected $categoryService;

    /**
     * Category constructor
     * 
     * @param CategoryService $productService
     */
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * Default select of Categories.
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
                'data' => $this->categoryService->getCountAllCategory($reqData)
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
     * Retrieve all Categories
     */
    public function getCategories():Response
    {
        try {
            $result = [
                'status' => 200,
                'categories' => $this->categoryService->getAllCategory()
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
