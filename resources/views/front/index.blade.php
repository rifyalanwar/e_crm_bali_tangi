<?php use App\Models\Product; ?>
@extends('front.layout.layout')
@section('content')
<!-- Main-Slider -->
<div class="default-height ph-item">
    <div class="slider-main owl-carousel">
        @foreach($sliderBanners as $banner)
        <div class="bg-image">
            <div class="slide-content">
                <h1>
                    <a>
                    {{-- <a @if(!empty($banner['link'])) href="{{ url($banner['link']) }}" @else href="javascript:;" @endif> --}}
                        <img title="{{ $banner['title'] }}" alt="{{ $banner['title'] }}" src="{{ asset('front/images/banner_images/'.$banner['image']) }}">
                    </a>
                </h1>
                <h2>{{ $banner['title'] }}</h2>
            </div>
        </div>
        @endforeach
    </div>
</div>
<!-- Main-Slider /- -->
@if(isset($fixBanners[0]['image']))
<!-- Banner-Layer -->
<div class="banner-layer">
    <div class="container">
        <div class="image-banner">
            <a target="_blank" rel="nofollow" href="{{ url($fixBanners[0]['link']) }}" class="mx-auto banner-hover effect-dark-opacity">
                <img class="img-fluid" src="{{ asset('front/images/banner_images/'.$fixBanners[0]['image']) }}" alt="{{ $fixBanners[0]['alt'] }}" title="{{ $fixBanners[0]['title'] }}">
            </a>
        </div>
    </div>
</div>
<!-- Banner-Layer /- -->
@endif
    <!-- Top Collection -->
    <section class="section-maker">
        <div class="container">
            <div class="sec-maker-header text-center">
                <h3 class="page-intro">Produk Kami</h3>
                <ul class="nav tab-nav-style-1-a justify-content-center">                 
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#men-best-selling-products">Produk Terlaris</a>
                    </li>             
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#men-featured-products">Produk Pilihan</a>
                    </li>
                </ul>
            </div>
            <div class="wrapper-content">
                <div class="outer-area-tab">
                    <div class="tab-content">
                    <div class="tab-pane show fade" id="men-best-selling-products">
                        <div class="slider-fouc">
                            <div class="products-slider owl-carousel" data-item="4">
                                @foreach($bestSellers as $product)
                                <?php $product_image_path = 'front/images/product_images/small/'.$product['product_image']; ?>
                                <div class="item">
                                    <div class="image-container">
                                        <a class="item-img-wrapper-link" href="{{ url('product/'.$product['id']) }}">
                                            @if(!empty($product['product_image']) && file_exists($product_image_path))
                                            <img class="img-fluid" src="{{ asset($product_image_path) }}" alt="Product">
                                            @else
                                            <img class="img-fluid" src="{{ asset('front/images/product_images/small/no-image.png') }}" alt="Product">
                                            @endif
                                        </a>                                        
                                    </div>
                                    <div class="item-content">
                                        <div class="what-product-is">
                                            <ul class="bread-crumb">
                                                <li>
                                                    <a href="{{ url('product/'.$product['id']) }}">{{ $product['product_code'] }}</a>
                                                </li>
                                            </ul>
                                            <h6 class="item-title">
                                                <a href="{{ url('product/'.$product['id']) }}">{{ $product['product_name'] }}</a>
                                            </h6>
                                            <div class="item-stars">
                                                <div class='star' title="0 out of 5 - based on 0 Reviews">
                                                    <span style='width:0'></span>
                                                </div>
                                                <span>(0)</span>
                                            </div>
                                        </div>
                                        <?php $getDiscountAttributePrice = Product::getDiscountAttributePrice($product['id']); ?>
                                            @foreach($product['attributes'] as $attribute)
                                            @if($getDiscountAttributePrice['discount']>0)
                                            <div class="price-template">
                                                <div class="item-new-price">
                                                    {{ formatRupiah($getDiscountAttributePrice['final_price']) }} 
                                                </div>
                                                <div class="item-old-price" style="color:red">
                                                    {{ formatRupiah($attribute['price']) }}
                                                </div>
                                            </div>
                                            @else
                                            <div class="price-template">
                                                <div class="item-new-price">
                                                    {{ formatRupiah($attribute['price']) }}
                                                </div>
                                            </div>
                                        @endif
                                        @endforeach
                                    </div>                                    
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                        <div class="tab-pane active show fade" id="men-featured-products">
                            <div class="slider-fouc">
                                <div class="products-slider owl-carousel" data-item="4">
                                @foreach($featuredProducts as $product)
                                <?php $product_image_path = 'front/images/product_images/small/'.$product['product_image']; ?>
                                    <div class="item">
                                        <div class="image-container">
                                            <a class="item-img-wrapper-link" href="{{ url('produk/'.$product['id']) }}">
                                            @if(!empty($product['product_image']) && file_exists($product_image_path))
                                                <img class="img-fluid" src="{{asset ($product_image_path) }}" alt="Product">
                                             @else
                                                <img class="img-fluid" src="{{ asset('front/images/product_images/small/no-image.png') }}" alt="Product">
                                            @endif
                                            </a>
                                            
                                        </div>                                        
                                        <div class="item-content">
                                            <div class="what-product-is">
                                            <ul class="bread-crumb">                                        
                                            <li>
                                                <a href="listing.html">{{ $product['category'] ['category_name'] }}</a>
                                            </li>
                                             </ul>                                             
                                                <h6 class="item-title">
                                                    <a href="{{ url('produk/'.$product['id']) }}" class="item-name">{{ $product['product_name'] }}</a>
                                                </h6>
                                                <div class="item-stars">
                                                    <div class='star' title="0 out of 0 - based on 0 Reviews">
                                                    </div>
                                                    <span>(0)</span>
                                                </div>
                                            </div>
                                            <?php $getDiscountAttributePrice = Product::getDiscountAttributePrice($product['id']); ?>
                                            @foreach($product['attributes'] as $attribute)
                                            @if($getDiscountAttributePrice['discount']>0)
                                            <div class="price-template">
                                                <div class="item-new-price">
                                                    {{ formatRupiah($getDiscountAttributePrice['final_price']) }} 
                                                </div>
                                                <div class="item-old-price" style="color:red">
                                                    {{ formatRupiah($attribute['price']) }}
                                                </div>
                                            </div>
                                            @else
                                            <div class="price-template">
                                                <div class="item-new-price">
                                                    {{ formatRupiah($attribute['price']) }}
                                                </div>
                                            </div>
                                            @endif
                                            @endforeach
                                        </div>                   
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Top Collection /- -->
    <!-- Site-Priorities -->
    <section class="app-priority">
        <div class="container">
            <div class="sec-maker-header text-center">
                <h3 class="page-intro">Keunggulan Kami</h3>                
            </div>
            <div class="priority-wrapper u-s-p-b-80">
                <div class="row">
                    <div class="col-lg-3 col-md-3 col-sm-3">
                        <div class="single-item-wrapper">
                            <div class="single-item-icon">
                                <i class="ion ion-md-star"></i>
                            </div>
                            <h2>
                                Great Value
                            </h2>
                            <p>Kami menawarkan harga produk yang kompetitif.</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-3">
                        <div class="single-item-wrapper">
                            <div class="single-item-icon">
                                <i class="ion ion-md-cash"></i>
                            </div>
                            <h2>
                                Shop with Confidence
                            </h2>
                            <p>Kami dapat melayani Anda dengan cepat.</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-3">
                        <div class="single-item-wrapper">
                            <div class="single-item-icon">
                                <i class="ion ion-ios-card"></i>
                            </div>
                            <h2>
                                Safe Payment
                            </h2>
                            <p>Pembayaran dapat Anda lakukan dengan keamanan terjamin.</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-3">
                        <div class="single-item-wrapper">
                            <div class="single-item-icon">
                                <i class="ion ion-md-contacts"></i>
                            </div>
                            <h2>
                                24/7 Help Center
                            </h2>
                            <p>Layanan pelanggan kami dapat membantu setiap kebutuhan Anda.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Site-Priorities /- -->
@endsection