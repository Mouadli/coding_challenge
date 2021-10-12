<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use App\Repositories\ProductRepository;

class ProductController extends Controller
{

    private $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function store(Request $req)
    {
        $this->productRepository->store($req);
    }

    public function index()
    {
        return $this->productRepository->index();
    }

    public function search($name)
    {
        $products = Product::where('name', 'LIKE', '%' . $name . '%')->get();
        return $products;
    }
}
