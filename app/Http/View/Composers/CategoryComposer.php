<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use App\Service\Product\ProductServiceInterface;

class CategoryComposer
{
    protected $productService;

    public function __construct(ProductServiceInterface $productService)
    {
        $this->productService = $productService;
    }

    public function compose(View $view)
    {
        $categoriesWithTags = $this->productService->getTagsByCategory();
        
        $categoryNames = config('categories.names');
        $categoriesWithTags = $categoriesWithTags->map(function($category) use ($categoryNames) {
            $category['display_name'] = $categoryNames[$category['name']] ?? $category['name'];
            return $category;
        });
        
        $view->with('categoriesWithTags', $categoriesWithTags);
    }
}