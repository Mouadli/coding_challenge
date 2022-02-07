<?php

namespace App\Repositories;

use App\Category;
use Illuminate\Database\Eloquent\Collection;

class CategoryRepository
{
    /**
     * Get All Category.
     */
    public function getAll(): Collection
    {
        $data = Category::all();

        return $data;
    }

    /**
     * get count product of category from DB
     */
    public function countAll(array $reqData): Collection
    {
        $data = Category::withCount(['products' => function ($query) use ($reqData) {
            $query->withFilters(
                $reqData['prices'],
                $reqData['categories'],
            );
        }])
            ->get();

        return $data;
    }
}
