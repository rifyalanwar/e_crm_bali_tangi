<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;
use Session;

class Wishlist extends Model
{
    use HasFactory;

    public static function countWishlist($product_id)
    {
        $countWishlist = Wishlist::where(['user_id' => Auth::user()->id, 'product_id' => $product_id])->count();
        return $countWishlist;
    }


    public static function getWishlistItems()
    {
        if (Auth::check()) {
            //if user logged in
            $getWishlistItems = Wishlist::with(['product' => function ($query) {
                $query->select('id', 'category_id', 'product_name', 'product_image', 'stock');
            }])->orderBy('id', 'Desc')->where('user_id', Auth::user()->id)->get()->toArray();
        } else {
            //if user not logged in
            $getWishlistItems = Wishlist::with(['product' => function ($query) {
                $query->select('id', 'category_id', 'product_name', 'product_code', 'product_color', 'product_image', 'stock');
            }])->orderby('id', 'Desc')->where('session_id', Session::get('session_id'))->get()->toArray();
        }
        return $getWishlistItems;
    }

    public function product()
    {
        return $this->belongsTo('App\Models\Product', 'product_id');
    }
}
