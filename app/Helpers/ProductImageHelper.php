<?php

namespace App\Helpers;

use App\Models\ProductDetail;
use App\Models\ProductImage;

class ProductImageHelper
{
    /**
     * Lấy hình ảnh sản phẩm dựa theo màu
     * 
     * @param int $productId
     * @param string|null $color
     * @return mixed
     */
    public static function getImageByColor($productId, $color = null)
    {
        $imageToShow = null;
        
        // Nếu có màu, tìm product detail theo màu
        if ($color) {
            $productDetail = ProductDetail::where('product_id', $productId)
                ->where('color', $color)
                ->first();
            
            // Nếu tìm thấy và có hình ảnh
            if ($productDetail && $productDetail->productImages) {
                return $productDetail->productImages;
            }
        }
        
        // Nếu không tìm thấy, lấy hình đầu tiên của sản phẩm
        $firstImage = ProductImage::where('product_id', $productId)->first();
        
        return $firstImage;
    }
}