<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Resources\CategoryResource;

class CategoryController extends Controller
{
    public function getCategories()
    {
        $categories = Category::all();
        return response()->json(['status' => 'success', 'categories' => $categories]);
    }


    public function index()
    {
        $categories = Category::withCount(['product' => function ($query) {
            $query->withFilters(
                request()->input('prices', []),
                request()->input('categories', []),
            );
        }])
            ->get();

        return CategoryResource::collection($categories);
    }
}
