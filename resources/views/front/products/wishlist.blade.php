<?php use App\Models\Product; ?>
@extends('front.layout.layout')
@section('content')
<div class="page-style-a">
    <div class="container">
                <div class="page-intro">
                    <h2>Wishlist</h2>                
                </div>
    </div>
</div>
<!-- Wishlist-Page -->
<div class="page-wishlist u-s-p-t-80">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div id="appendWishlistItems">
                     @include('front.products.wishlist_items')
                </div>
            </div>
            
        </div>
    </div>
</div>    
<!-- Wishlist-Page /- -->
@endsection