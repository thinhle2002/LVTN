<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDetail extends Model
{
    use HasFactory;

    protected $table = 'product_details';
    protected $primaryKey = 'id';
    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function productImages()
    {
        return $this->belongsTo(ProductImage::class, 'image_id', 'id');
    }

    protected static function booted()
    {
        static::saved(function ($detail) {
            if ($detail->product) {
                $detail->product->update(['qty' => $detail->product->productDetails()->sum('qty')]);
            }
            if ($detail->wasChanged('product_id')) {
                $originalProductId = $detail->getOriginal('product_id');
                if ($originalProductId) {
                    $original = Product::find($originalProductId);
                    if ($original) {
                        $original->update(['qty' => $original->productDetails()->sum('qty')]);
                    }
                }
            }
        });

        static::deleted(function ($detail) {
            if ($detail->product) {
                $detail->product->update(['qty' => $detail->product->productDetails()->sum('qty')]);
            }
        });
    }
}
