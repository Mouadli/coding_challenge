<?php

namespace App\Repositories;

use App\Category;
use App\Http\Resources\CategoryResource;
use Illuminate\Http\UploadedFile;

class CategoryRepository
{

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
