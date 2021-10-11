<?php

namespace App\Http\Controllers;

use App\Services\PriceService;
use Illuminate\Http\Request;

class PriceController extends Controller
{
    public function index(PriceService $priceService)
    {
        $prices = $priceService->getPrices(
            request()->input('prices', []),
            request()->input('categories', []),
        );

        return response()->json($prices);
    }
}
