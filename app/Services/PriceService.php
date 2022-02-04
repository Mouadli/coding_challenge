<?php

namespace App\Services;

use App\Product;
use App\Repositories\PriceRepository;

class PriceService
{
    /**
     * @var $priceRepository
     * @var $prices
     * @var $categories
     */
    protected $priceRepository;
    protected $prices;
    protected $categories;

    /**
     * constructor
     * 
     * @param PriceRepository $priceRepository
     */
    public function __construct(PriceRepository $priceRepository)
    {
        $this->priceRepository = $priceRepository;
    }

    /**
     * get count of product by price.
     * 
     * @param Array $prices
     * @param Array $category
     * @return Array
     */
    public function getPrices($prices, $categories)
    {
        $this->prices = $prices;
        $this->categories = $categories;
        $formattedPrices = [];

        foreach(Product::PRICES as $index => $name) {
            $formattedPrices[] = [
                'name' => $name,
                'products_count' => $this->priceRepository->getProductCount($index, $this->prices, $this->categories)
            ];
        }

        return $formattedPrices;
    }

    /**
     * filter by prices or/and categories
     * 
     * @return String
     */
    public function priceIndex()
    {
        $prices = $this->getPrices(
            request()->input('prices', []),
            request()->input('categories', []),
        );

        return $prices;
    }
}
