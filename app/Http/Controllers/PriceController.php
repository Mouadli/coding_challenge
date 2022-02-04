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
        try{
            $result = $this->priceService->priceIndex();
        } catch (Exception $e) {
            $result =[
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }

        return response()->json($result);
    }
}
