<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Service\Product\ProductService;
use App\Service\Product\ProductServiceInterface;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    private $productService;

    public function __construct(ProductServiceInterface $productService)
    {
        $this->productService = $productService;
    }

    public function index()
    {
        $featuredProducts = $this->productService->getFeaturedProducts();
        $categoriesWithTags = $this->productService->getTagsByCategory();
        
        return view('front.index', compact('featuredProducts', 'categoriesWithTags'));
    }
}