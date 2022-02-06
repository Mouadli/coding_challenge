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
    public function getAll(): object
    {
        $data = $this->category->all();

        return $data;
    }

    /**
     * get count product of category from DB
     */
    public function countAll(object $reqData): object
    {
        $data = $this->category->withCount(['products' => function ($query) use ($reqData) {
            $query->withFilters(
                $reqData->prices,
                $reqData->categories,
            );
        }])
            ->get();

        return $data;
    }
}
