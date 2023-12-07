<?php use App\Models\Product; ?>
<?php use App\Models\Wishlist; ?>
<?php use App\Models\Review; ?>
@extends('front.layout.layout')
@section('content')
        <!-- Single-Product-Full-Width-Page -->
        <div class="page-detail u-s-p-t-80">
        <div class="container">
            <!-- Product-Detail -->
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <!-- Product-zoom-area -->
                    <div class="zoom-area">
                    <img id="zoom-pro" class="img-fluid" src="{{ asset('front/images/product_images/large/'.$productDetails['product_image']) }}" data-zoom-image="{{ asset('front/images/product_images/large'.$productDetails['product_image']) }}" alt="Zoom Image">
                        <div id="gallery" class="u-s-m-t-10">
                            <a class="active" data-image="{{ asset('front/images/product_images/large/'.$productDetails['product_image']) }}" data-zoom-image="{{ asset('front/images/product_images/large/'.$productDetails['product_image']) }}">
                                <img src="{{ asset('front/images/product_images/large/'.$productDetails['product_image']) }}" alt="Product">
                            </a>
                            @foreach($productDetails['images'] as $image)
                                <a data-image="{{ asset('front/images/product_images/large/'.$image['image']) }}" data-zoom-image="{{ asset('front/images/product_images/large/'.$image['image']) }}">
                                    <img src="{{ asset('front/images/product_images/large/'.$image['image']) }}" alt="Product">
                                </a>
                            @endforeach                            
                        </div>
                    </div>
                    <!-- Product-zoom-area /- -->
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <!-- Product-details -->
                    <div class="all-information-wrapper">
                    @if(Session::has('error_message'))
                      <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?php echo Session::get('error_message'); ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                  @endif

                  @if(Session::has('success_message'))
                  <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?php echo Session::get('success_message'); ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  @endif
                        <div class="section-1-title-breadcrumb-rating">
                        <div class="product-title">
                                <h1>
                                    <a href="javascript:;" class="item-name">{{ $productDetails['product_name'] }}</a>
                                </h1>
                            </div>
                            <ul class="bread-crumb">
                            <li>
                                {{ $productDetails['category']['category_name'] }}
                             </li>
                            </ul>
                            <div class="product-rating">
                            @if($avgStarRating>0)
                                <div class="rate">
                                    <?php
                                    $star = 1;
                                    while($star<=$avgStarRating){ ?>
                                    <span>&#9733;</span>
                                    <?php $star++; } ?>({{ $avgRating }})
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="section-2-short-description u-s-p-y-14">
                        <h6 class="information-heading u-s-m-b-8">Deskripsi Produk:</h6>
                            <p class="item-name"> {{ $productDetails['description'] }}</p>
                            </p>
                        </div>
                        <div class="section-3-price-original-discount u-s-p-y-14">
                            <?php $getDiscountAttributePrice = Product::getDiscountAttributePrice($productDetails['id']); ?>
                            @foreach($productDetails['attributes'] as $attribute)
                            @if($getDiscountAttributePrice['discount']>0)
                                <div class="price">
                                    <h4> {{ formatRupiah($getDiscountAttributePrice['final_price']) }} </h4>
                                </div>
                                <div class="original-price">
                                    <span class="item-name">Harga Sebelumnya:</span>
                                    <span class="item-name" style="color:red">{{ formatRupiah($attribute['price']) }}</span>                                
                                </div>
                            @else
                            <div class="price">
                                <h4> {{ formatRupiah($attribute['price']) }} </h4>
                            </div>
                            @endif
                            @endforeach
                        </div>
                        <div class="section-4-sku-information u-s-p-y-14">
                            <div class="availability">
                                    <span class="item-name">Status ketersediaan:</span>
                                        @if($getProductStock>0)
                                    <span><b>Tersedia</b></span>                                
                                @else
                                    <span style="color:red;"><b>Habis</b></span>
                                @endif
                            </div>
                            @if($getProductStock>0)
                                <div class="left">
                                    <span class="item-name">Jumlah stok:</span>
                                    <span class="item-name">{{ $getProductStock }}</span>
                            </div>
                            @endif
                        </div>
                        <form action="{{ url('cart/add') }}" class="post-form" method="Post">@csrf
                        <input type="hidden" name="product_id" value="{{ $productDetails['id'] }}"> 
                        <div class="sizes u-s-m-b-11" style="margin-top: 20px;">
                            <span class="item-name information-heading u-s-m-b-8">Ukuran:</span>
                            <div class="size-variant select-box-wrapper">
                                <select name="att_id" id="getPrice" product-id="{{ $productDetails['id'] }}" class="select-box product-size" readonly="">
                                    @foreach($productDetails['attributes'] as $attribute)
                                        <option value="{{ $attribute['id'] }}">{{ $attribute['size'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>       
                        <div class="section-6-social-media-quantity-actions u-s-p-y-14">
                                <?php /* <div class="quick-social-media-wrapper u-s-m-b-22">
                                    <span>Share:</span>
                                    <ul class="social-media-list">
                                        <li>
                                            <a href="#">
                                                <i class="fab fa-facebook-f"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <i class="fab fa-twitter"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <i class="fab fa-google-plus-g"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <i class="fas fa-rss"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <i class="fab fa-pinterest"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div> */ ?>
                                    <div class="quantity-wrapper u-s-m-b-22">
                                        <span class="item-name information-heading u-s-m-b-8">Pilih jumlah:</span>
                                        <div class="quantity">
                                            <input type="text" class="quantity-text-field" value="1" name="quantity">
                                            <a class="plus-a" data-max="1000">&#43;</a>
                                            <a class="minus-a" data-min="1">&#45;</a>
                                        </div>
                                    </div>
                                    <div>
                                        @if(auth()->check())
                                        <button class="button button-primary" type="submit">Add to cart</button>                                    
                                        @else
                                        <a href="{{url('/user/login-or-register')}}" class="button button-primary" >Add to cart</a>                                    
                                        @endif
                                    </div>                                                                                          
                            </div>
                        </form>
                        <form action="{{ url('wishlist/add') }}" class="post-form" method="Post">@csrf
                            <input type="hidden" name="product_id" value="{{ $productDetails['id'] }}">
                            @foreach($productDetails['attributes'] as $attribute)
                            <input type="hidden" name="size" value="{{ $attribute['size'] }}">
                            <input type="hidden" name="weight" value="{{ $attribute['weight'] }}">
                            @endforeach  
                            @if(auth()->check())
                            <button class="button button-outline-secondary userLogin far fa-heart u-s-m-l-6" title="Tambah ke Wishlist"></button>                                        
                            @else
                            <a href="{{url('/user/login-or-register')}}" class="button button-outline-secondary userLogin far fa-heart u-s-m-l-6" title="Tambah ke Wishlist" ></a>                                    
                            @endif
                        </form>                         
                    </div>
                    <!-- Product-details /- -->
                </div>
            </div>
            <!-- Product-Detail /- -->
            <!-- Detail-Tabs -->
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="detail-tabs-wrapper u-s-p-t-80">
                        <div class="detail-nav-wrapper u-s-m-b-30">
                            <ul class="nav single-product-nav justify-content-center">
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#description">Deskripsi</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#specification">Spesifikasi</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#review">Ulasan</a>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-content">
                            <!-- Description-Tab -->
                            <div class="tab-pane fade" id="description">
                                <div class="description-whole-container">
                                    <p class="desc-p u-s-m-b-26">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
                                    </p>
                                </div>
                            </div>
                            <!-- Description-Tab /- -->
                            <!-- Specifications-Tab -->
                            <div class="tab-pane fade" id="specification">
                                <div class="specification-whole-container">                                
                                    <div class="spec-table u-s-m-b-50">
                                        <h4 class="spec-heading">Informasi Produk</h4>
                                        <table>
                                            <tr>
                                                <td>Petunjuk Pemakaian</td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>Komposisi</td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>Peringatan</td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                            <tr>
                                                <td>Berat bersih</td>
                                                <td></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- Specifications-Tab /- -->
                            <!-- Reviews-Tab -->
                            <div class="tab-pane active show fade" id="review">
                                <div class="review-whole-container">                                    
                                    <div class="row r-2 u-s-m-b-26 u-s-p-b-22">
                                        <div class="col-lg-12">
                                            <div class="your-rating-wrapper">
                                                <h6 class="review-h6">Penilaian produk yang Anda beli akan sangat membantu kami.</h6>
                                                <h6 class="review-h6">Bagaimana penilaian Anda terhadap produk kami?</h6>
                                                <br>
                                                <form method="POST" action="{{ url('/add-review') }}" name="reviewForm" id="reviewForm">@csrf
                                                <input type="hidden" name="product_id" value="{{ $productDetails['id'] }}">
                                                <div class="star-wrapper u-s-m-b-8">
                                                <div class="rate">
                                                    <input type="radio" id="star5" class="rate-radio" name="rating" value="5" />
                                                    <label for="star5">5 stars</label>
                                                    <input type="radio" id="star4" class="rate-radio" name="rating" value="4" />
                                                    <label for="star4">4 stars</label>
                                                    <input type="radio" id="star3" class="rate-radio" name="rating" value="3" />
                                                    <label for="star3">3 stars</label>
                                                    <input type="radio" id="star2" class="rate-radio" name="rating" value="2" />
                                                    <label for="star2">2 stars</label>
                                                    <input type="radio" id="star1" class="rate-radio" name="rating" value="1" />
                                                    <label for="star1">1 star</label>
                                                </div>
                                                </div>
                                                &nbsp;
                                                    <div class="u-s-m-b-30">
                                                    <label for="review-title" class="label-title">Judul
                                                        <span class="astk"> *</span>
                                                    </label>
                                                    <input id="review-title" type="text" class="text-field" placeholder="Judul Ulasan" name="title">
                                                    </div>
                                                    <div class="u-s-m-b-30">
                                                    <label for="review-text-area" class="label-title">Isi Ulasan
                                                        <span class="astk"> *</span>
                                                    </label>
                                                    <textarea class="text-area u-s-m-b-8" id="review-text-area" placeholder="Review" name="review"></textarea>
                                                    </div>
                                                    <button class="button button-outline-secondary" type="submit">Kirim Ulasan</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Get-Reviews -->
                                    <div class="get-reviews u-s-p-b-22">
                                        <!-- Review-Options -->
                                        <div class="review-options u-s-m-b-16">
                                            <div class="review-option-heading">
                                                <h6>Ulasan</h6>                                                
                                            </div>                                            
                                        </div>
                                        <!-- Review-Options /- -->
                                        <!-- All-Reviews -->
                                        <div class="reviewers">
                                            @if(count($reviews)>0)
                                            @foreach($reviews as $review)
                                            <div class="review-data">
                                                <div class="reviewer-name-and-date">
                                                    <h6 class="reviewer-name">{{ $review['user']['name'] }}</h6>
                                                    <h6 class="review-posted-date">{{ date("d-m-Y", strtotime($review['created_at'])) }}</h6>
                                                </div>
                                                <div class="reviewer-stars-title-body">
                                                    <div class="reviewer-stars">
                                                            <?php
                                                            $count=1;
                                                            while($count<$review['rating']){ ?>
                                                            <span>&#9733;</span>
                                                            <?php $count++; } ?>
                                                        <span class="review-title">{{ $review['title'] }}</span>
                                                    </div>
                                                    <p class="review-body">
                                                        {{ $review['review'] }}
                                                    </p>
                                                </div>
                                            </div>
                                            @endforeach
                                            @else
                                                <p> Tidak ada ulasan untuk produk ini.</p>
                                            @endif                                            
                                        </div> 
                                        <!-- All-Reviews /- -->
                                        <!-- Pagination-Review -->
                                        <!-- <div class="pagination-review-area">
                                            <div class="pagination-review-number">
                                                <ul>
                                                    <li style="display: none">
                                                        <a href="single-product.html" title="Previous">
                                                            <i class="fas fa-angle-left"></i>
                                                        </a>
                                                    </li>
                                                    <li class="active">
                                                        <a href="single-product.html">1</a>
                                                    </li>
                                                    <li>
                                                        <a href="single-product.html">2</a>
                                                    </li>
                                                    <li>
                                                        <a href="single-product.html">3</a>
                                                    </li>
                                                    <li>
                                                        <a href="single-product.html">...</a>
                                                    </li>
                                                    <li>
                                                        <a href="single-product.html">10</a>
                                                    </li>
                                                    <li>
                                                        <a href="single-product.html" title="Next">
                                                            <i class="fas fa-angle-right"></i>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div> -->
                                        <!-- Pagination-Review /- -->
                                    </div>
                                    <!-- Get-Reviews /- -->
                                </div>
                            </div>
                            <!-- Reviews-Tab /- -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- Detail-Tabs /- -->
        </div>
    </div>
    <!-- Single-Product-Full-Width-Page /- -->
@endsection