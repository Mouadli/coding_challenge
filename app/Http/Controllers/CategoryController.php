<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Resources\CategoryResource;
use Illuminate\Http\Request;
use App\Repositories\CategoryRepository;
use App\Services\CategoryService;
use Exception;

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
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reqData = (object) [
            'prices' => request()->input('prices', []),
            'categories' => request()->input('categories', []),
        ];

        try{
            $result = CategoryResource::collection($this->categoryService->getCountAllCategory($reqData));
        } catch (Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }

        return $result;
    }

    /**
     * Retrieve all Categories
     * 
     * @return \Illuminate\Http\Response
     */
    public function getCategories()
    {
        try{
            $result = ['status' => 'success', 'categories' => $this->categoryService->getAllCategory()];
        } catch (Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }

        return response()->json($result);
    }
}
