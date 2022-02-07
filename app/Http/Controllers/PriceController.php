<?php

namespace App\Http\Controllers;

use App\Services\PriceService;
use Illuminate\Http\Request;
use App\Repositories\ProductRepository;
use Exception;

class PriceController extends Controller
{

    /**
     * @var $priceService
     */
    protected $priceService;

    /**
     * Constructor
     * 
     * @param PriceService $priceService
     */
    public function __construct(PriceService $priceService)
    {
        $this->priceService = $priceService;
    }

    /**
     * Filters
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = ['status' => 200];

        $prices = request()->input('prices', []);
        $categories = request()->input('categories', []);
        try {
            $result['prices'] = $this->priceService->priceIndex($prices, $categories);
        } catch (Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }
}
