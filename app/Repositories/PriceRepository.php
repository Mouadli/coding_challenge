<?php

namespace App\Repositories;

use App\Product;

class PriceRepository
{
    
    /**
     * Get count of each product by price
     * 
     * @param $index
     * @param $prices
     * @param $category
     * @return integer
     */
    public function getProductCount($index, $prices, $categories)
    {
        return Product::withFilters($prices, $categories)
            ->when($index == 0, function ($query) {
                $query->where('price', '<', '50');
            })
            ->when($index == 1, function ($query) {
                $query->whereBetween('price', ['50', '100']);
            })
            ->when($index == 2, function ($query) {
                $query->whereBetween('price', ['100', '500']);
            })
            ->when($index == 3, function ($query) {
                $query->where('price', '>', '500');
            })
            ->count();
    }
}
