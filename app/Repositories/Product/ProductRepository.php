<?php

namespace App\Repositories\Product;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Repositories\BaseRepositories;
use \Illuminate\Http\Request;

class ProductRepository extends BaseRepositories implements ProductRepositoryInterface
{

    public function getModel()
    {
        return Product::class;
    }
     public function getRelatedProducts($product, $litmit = 4)
     {
         return $this->model->where('product_category_id', $product->product_category_id)
             ->where('tag',  $product->tag)
             ->limit($litmit)
             ->get();
     }

     public function getFeaturedProductsByCategory(int $categoryId)
     {
         return $this->model->where('featured', true)
             ->where('product_category_id', $categoryId)
             ->get();
     }

     public function getProductOnIndex($request)
     {
         $search = $request->search ?? '';
         $products = $this->model->where('name', 'like', '%' . $search . '%');
         $products = $this->filter($products, $request);
         $products = $this->sortAndPagination($products, $request);

         return $products;
     }
     public function getProductsByCategory($categoryName, $request)
     {
        $products = ProductCategory::where('name', $categoryName)->first()->product->toQuery();
        $products = $this->filter($products, $request);
        $products = $this->sortAndPagination($products, $request);

        return $products;
     }
     public function getTagsByCategory()
    {
        return ProductCategory::with(['product' => function($query) {
            $query->select('tag', 'product_category_id')
                ->distinct()
                ->whereNotNull('tag')
                ->where('tag', '!=', '');
        }])->get()->map(function($category) {
            return [
                'id' => $category->id,
                'name' => $category->name,
                'tags' => $category->product->pluck('tag')->unique()->values()
            ];
        });
    }
     private function sortAndPagination($products, Request $request)
     {
         $perPage = $request->show ?? 9;
         $sortBy = $request->sort_by ?? 'latest';

         switch ($sortBy) {
             case 'latest':
                 $products = $products->orderBy('id');
                 break;
             case 'oldest':
                 $products = $products->orderByDesc('id');
                 break;
             case 'name-ascending':
                 $products = $products->orderBy('name');
                 break;
             case 'name-descending':
                 $products = $products->orderByDesc('name');
                 break;
             case 'price-ascending':
                 $products = $products->orderBy('price');
                 break;
             case 'price-descending':
                 $products = $products->orderByDesc('price');
                 break;
             default:
                 $products = $products->orderBy('id');
         }

         $products = $products->paginate($perPage);
         $products->appends(['sort_by' => $sortBy, 'show' => $perPage]);
         return $products;
     }
     private function filter($products, Request $request)
    {
        // 1. BRAND
        $brands = $request->brand ?? [];
        $brand_ids = array_keys($brands);
        
        if (!empty($brand_ids)) {
            $products = $products->whereIn('brand_id', $brand_ids);
        }
        // 2. TAGS
        $tag = $request->tag;
        
        if ($tag) {
            $products = $products->where('tag', $tag);
        }
        // 3. PRICE 
        $priceMin = $request->price_min; 
        $priceMax = $request->price_max; 

        if ($priceMin !== null && $priceMax !== null) {
            $products = $products->whereBetween('price', [(float)$priceMin, (float)$priceMax]);
        }
        // 4. COLOR
        $color = $request->color;

        if ($color) {
            $products = $products->whereHas('productDetails', function ($query) use ($color) {
                $query->where('color', $color)->where('qty','>',0);
            });
        }
        // 5. SIZE
        $size = $request->size;
        
        if ($size) {
            $products = $products->whereHas('productDetails', function ($query) use ($size) {           
                $query->where('size', $size)->where('qty','>',0);
            });
        }
        return $products;
    }

    public function getProductDetail($product, $color, $size)
    {
        return $product->productDetails()
            ->with('productImages')
            ->where('color', $color)
            ->where('size', $size)
            ->where('product_id', $product->id)
            ->first();
    }
    public function getDistinctTags()
    {
        return Product::select('tag')
            ->distinct()
            ->whereNotNull('tag')
            ->where('tag', '!=', '')
            ->orderBy('tag', 'asc')
            ->pluck('tag');
    }
}
