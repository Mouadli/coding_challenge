<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use App\Repositories\CategoryRepository;

class CategoryController extends Controller
{
    
    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function getCategories()
    {
        $categories = Category::all();
        return response()->json(['status' => 'success', 'categories' => $categories]);
    }


    public function index()
    {
        return $this->categoryRepository->index();
    }
}
