<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Service\Brand\BrandServiceInterface;
use App\Service\Product\ProductService;
use App\Service\Product\ProductServiceInterface;
use App\Service\ProductCategory\ProductCategoryServiceInterface;
use App\Service\ProductComment\ProductCommentServiceInterface;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    private $productService;
    private $productCommentService;
    private $productCategoryService;
    private $brandService;

    public function __construct(ProductServiceInterface $productService,
                                ProductCommentServiceInterface $productCommentService,
                                ProductCategoryServiceInterface $productCategoryService,
                                BrandServiceInterface $brandService ){
        $this->productService = $productService;
        $this->productCommentService = $productCommentService;
        $this->productCategoryService = $productCategoryService;
        $this->brandService = $brandService;
    }

    public function show($id)
    {
        $categories = $this->productCategoryService->all();
        $brands = $this->brandService->all();
        $product = $this->productService->find($id);
        $relatedProducts = $this->productService->getRelatedProducts($product);
        return view('front.shop.show', compact('product', 'relatedProducts', 'categories', 'brands'));
    }

    public function postComment(Request $request){
        $this->productCommentService->create($request->all());
        return redirect()->back();
    }
    public function index(Request $request)
    {
        $categories = $this->productCategoryService->all();
        $brands = $this->brandService->all();
        $request = $this->processPriceFilter($request);
        $products = $this->productService->getProductOnIndex($request);
        return view('front.shop.index', compact('products', 'categories', 'brands'));
    }
    public function category($categoryName, Request $request){
        $categories = $this->productCategoryService->all();
        $brands = $this->brandService->all();
        $request = $this->processPriceFilter($request);
        $products = $this->productService->getProductByCategory($categoryName, $request);
        return view('front.shop.index', compact('products', 'categories', 'brands'));
    }
    protected function processPriceFilter(Request $request)
    {
        if ($request->has('price_min') && $request->has('price_max')) {
            
            $min = (int)$request->price_min;
            $max = (int)$request->price_max;

            $dbMin = $min / 1000;
            $dbMax = $max / 1000;

            $request->merge([
                'price_min' => $dbMin,
                'price_max' => $dbMax, 
            ]);
        }
        return $request;
    }
}
