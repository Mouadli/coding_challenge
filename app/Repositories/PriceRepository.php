<?php

namespace App\Repositories;

use App\Product;

class PriceRepository
{

    /**
     * Get count of each product by price
     * 
     * @param int $index
     * @param array $prices
     * @param array $category
     * @return integer
     */
    public function getProductCount(int $index, array $prices, array $categories): int
    {
        return Product::withFilters($prices, $categories)
            ->when($index == 0, function ($query) {
                $query->where('price', '<', '5000');
            })
            ->when($index == 1, function ($query) {
                $query->whereBetween('price', ['5000', '10000']);
            })
            ->when($index == 2, function ($query) {
                $query->whereBetween('price', ['10000', '50000']);
            })
            ->when($index == 3, function ($query) {
                $query->where('price', '>', '50000');
            })
            ->count();
    }
}
