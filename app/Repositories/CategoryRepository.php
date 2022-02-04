<?php

namespace App\Repositories;

use App\Category;

class CategoryRepository
{

    /**
     * @var Category
     */
    protected $category;

    /**
     * Category constructor.
     * 
     * @param Category $category
     */
    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    /**
     * Get All Category.
     */
    public function getAll()
    {
        $data = Category::all();

        return $data;
    }

    /**
     * get count product of category from DB
     */
    public function countAll()
    {
        $data = Category::withCount(['product' => function ($query) {
            $query->withFilters(
                request()->input('prices', []),
                request()->input('categories', []),
            );
        }])
            ->get();

        return $data;
    }
}
