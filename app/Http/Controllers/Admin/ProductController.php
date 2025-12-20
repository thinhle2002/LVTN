<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Service\Brand\BrandServiceInterface;
use App\Service\Product\ProductServiceInterface;
use App\Service\ProductCategory\ProductCategoryServiceInterface;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private $productService;
    private $brandService;
    private $categoryService;

    public function __construct(ProductServiceInterface $productService, 
                                BrandServiceInterface $brandService, 
                                ProductCategoryServiceInterface $categoryService)
    {
        $this->productService = $productService;
        $this->brandService = $brandService;
        $this->categoryService = $categoryService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $products = $this->productService->searchAndPaginate('name', $request->get('search'));
        return view('admin.product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $brands = $this->brandService->all();
        $categories = $this->categoryService->all();
        $tags = $this->productService->getDistinctTags();
        return view('admin.product.create', compact('brands', 'categories','tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'brand_id'            => 'required|exists:brands,id',
            'product_category_id' => 'required|exists:product_categories,id',
            'name'                => 'required|string|max:255',
            'sku'                 => 'required|string|max:50|unique:products,sku',
            'tag'                 => 'nullable|string|max:50',
            'new_tag'             => 'nullable|string|max:50',
            'price'               => 'required|numeric|min:0',
            'weight'              => 'required|numeric|min:0',
            'description'         => 'nullable|string',
            'featured'            => 'nullable|boolean',
        ], [
            'brand_id.required' => 'Vui lòng chọn thương hiệu',
            'name.required'     => 'Tên sản phẩm không được để trống',
            'price.numeric'     => 'Giá sản phẩm phải là số',
            'weight.numeric'    => 'Trọng lượng phải là số',
        ]);
        
        $data = $request->except(['new_tag']);
        dd($data);
        if ($request->filled('new_tag')) {
            $data['tag'] = strtolower(trim($request->new_tag));
        }

        if ($request->filled('weight')) {
            $data['weight'] = str_replace(',', '.', $request->weight);
        }

        $data['qty'] = 0;

        $product = $this->productService->create($data);

        return redirect('admin/product/' . $product->id);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = $this->productService->find($id);

        return view('admin.product.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = $this->productService->find($id);
        $brands = $this->brandService->all();
        $categories = $this->categoryService->all();
        $tags = $this->productService->getDistinctTags();
        return view('admin.product.edit', compact('product', 'brands', 'categories','tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'brand_id'            => 'required|exists:brands,id',
            'product_category_id' => 'required|exists:product_categories,id',
            'name'                => 'required|string|max:255',
            'sku'                 => 'required|string|max:50|unique:products,sku,' . $id,
            'tag'                 => 'nullable|string|max:50',
            'new_tag'             => 'nullable|string|max:50',
            'price'               => 'required|numeric|min:0',
            'weight'              => 'required|numeric|min:0',
            'description'         => 'nullable|string',
            'featured'            => 'nullable|boolean',
        ]);

         $data = $request->except(['new_tag']);

        if ($request->filled('new_tag')) {
            $data['tag'] = strtolower(trim($request->new_tag));
        }

        if ($request->filled('weight')) {
            $data['weight'] = str_replace(',', '.', $request->weight);
        }

        $this->productService->update($data, $id);

        return redirect('admin/product/' . $id);
    }

}
