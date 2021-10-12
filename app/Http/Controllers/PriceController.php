<?php

namespace App\Http\Controllers;

use App\Services\PriceService;
use Illuminate\Http\Request;
use App\Repositories\ProductRepository;

class PriceController extends Controller
{

    private $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function index(PriceService $priceService)
    {
        return $this->productRepository->priceIndex($priceService);
    }
}
