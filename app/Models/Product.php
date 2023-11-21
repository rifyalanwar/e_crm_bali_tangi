<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\ProductsAttribute;

class Product extends Model
{
    use HasFactory;


    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'category_id');
    }

    public function images()
    {
        return $this->hasMany('App\Models\ProductsImage');
    }

    public function attributes()
    {
        return $this->hasMany('App\Models\ProductsAttribute');
    }

    public static function getDiscountAttributePrice($product_id)
    {
        $proAttrPrice = ProductsAttribute::where(['product_id' => $product_id])->first()->toArray();
        $proDetails = Product::select('product_discount', 'category_id')->where('id', $product_id)->first();
        $proDetails = json_decode(json_encode($proDetails), true);
        $catDetails = Category::select('category_discount')->where('id', $proDetails['category_id'])->first();
        $catDetails = json_decode(json_encode($catDetails), true);
        if ($proDetails['product_discount'] > 0) {
            // If product discount is added from the admin panel
            $final_price = $proAttrPrice['price'] - ($proAttrPrice['price'] * $proDetails['product_discount'] / 100);
            $discount = $proAttrPrice['price'] - $final_price;
        } else if ($catDetails['category_discount'] > 0) {
            // If product discount is not added but category discount added from the admin panel
            $final_price = $proAttrPrice['price'] - ($proAttrPrice['price'] * $catDetails['category_discount'] / 100);
            $discount = $proAttrPrice['price'] - $final_price;
        } else {
            $final_price = $proAttrPrice['price'];
            $discount = 0;
        }
        return array('product_price' => $proAttrPrice['price'], 'final_price' => $final_price, 'discount' => $discount);
    }


    public static function getProductStock($product_id)
    {
        $getProductStock = Product::select('stock')->where('id', $product_id)->first();
        return $getProductStock->stock;
    }

    public static function getProductImage($product_id)
    {
        $getProductImage = Product::select('product_image')->where('id', $product_id)->first()->toArray();
        return $getProductImage['product_image'];
    }
}
