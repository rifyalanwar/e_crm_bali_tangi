<?php 
if (strpos(url()->full(), '?') !== false) {
    $haveParams = true;
}else{
    $haveParams = false;
}
$page = app()->request->page;
$search = app()->request->search;
?>
@extends('front.layout.layout')
@section('content')
<div class="page-style-a">
        <div class="container">
                    <div class="page-intro">
                        <h2>Katalog Produk</h2>     
                        @if(app()->request->filled('search'))      
                        <h6>Hasil pencarian untuk kata kunci : <span class="text-primary">{{  app()->request->search }}</span></h6>
                        @endif     
                    </div>
        </div>
    </div>
    <!-- Shop-Page -->
    <div class="page-shop ">
        <div class="container">
            <div class="row">
                <!-- Shop-Left-Side-Bar-Wrapper -->
                <div class="col-lg-3 col-md-3 col-sm-12 mt-5">
                    <!-- Filter-Brand -->
                    <div class="facet-filter-associates " >
                        <h3 class="title-name">Pilih Kategori Produk</h3>
                        <form class="facet-form" action="#" method="post">
                            <div class="associate-wrapper">
                                   <div class="form-group">
                                    <input type="checkbox" class="check-box brand" name="cat_all" id="id_all" checked value="">
                                    <label class="label-text" for="id_all">Semua Kategori</label>
                                </div>
                                @foreach ($categories as $item)
                                <div class="form-group">
                                    <input type="checkbox" class="check-box brand" name="categories" id="id_{{$item->id}}" value="">
                                    <label class="label-text" for="id_{{$item->id}}">{{$item->category_name}}</label>
                                </div>
                                @endforeach
                            </div>
                        </form>
                        <button class="btn btn-primary btn-sm mt-2 float-right"><i class="fa fa-filter"></i>Terapkan Filter</button>
                    </div>
                </div>
                <!-- Shop-Left-Side-Bar-Wrapper /- -->
                <!-- Shop-Right-Wrapper -->
                <div class="col-lg-9 col-md-9 col-sm-12">
                    <!-- Page-Bar -->                   
                    <div class="page-bar clearfix">                        
                        <!-- Toolbar Sorter 1  -->                        
                        <!-- //end Toolbar Sorter 1  -->
                        <!-- Toolbar Sorter 2  -->
                        <div class="toolbar-sorter-2 d-flex flex-row">
                            <input type="text" id="search-box" class="form-control" value="{{ app()->request->search }}" placeholder="Cari sesuatu ...">
                            <button class="btn btn-primary ml-1" onclick="search()">
                                <i class="fa fa-search"></i>
                            </button>
                            {{-- <div class="select-box-wrapper ml-2" style="width: 150px">
                                <label class="sr-only" for="show-records">Page </label>
                                <select class=" form-control" id="show-records">
                                    <option selected="selected" value="">10</option>
                                    <option value="">25</option>
                                    <option value="">50</option>
                                    <option value="">100</option>
                                </select>
                            </div> --}}
                        </div>
                        <!-- //end Toolbar Sorter 2  -->
                    </div>
                    <!-- Page-Bar /- -->
                    <!-- Row-of-Product-Container -->
                    <div class="row product-container list-style">
                        @foreach($productsListing->data as $product)
                        <div class="product-item col-lg-4 col-md-6 col-sm-6">
                            <div class="item">
                                <div class="image-container">
                                    <a class="item-img-wrapper-link" href="{{ url('produk/'.$product->id) }}">
                                        <?php $product_image_path = 'front/images/product_images/small/'.$product->product_image; ?>
                                        @if(!empty($product->product_image) && file_exists($product_image_path))
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
                                                <a href="listing.html">{{ $product->category ->category_name }}</a>
                                            </li>
                                        </ul>
                                        <h6 class="item-title">
                                            <a href="{{ url('produk/'.$product->id) }}" class="item-name">{{ $product->product_name }}</a>
                                        </h6>
                                        <div class="item-description">
                                            <p>
                                            {{ $product->description }}    
                                            </p>
                                        </div>
                                        <div class="item-stars">
                                            <div class="star" title=" out of 0 - based on Reviews">
                                            </div>
                                            <span>(0)</span>
                                        </div>
                                    </div>
                                    @foreach($product->attributes as $attribute)
                                    @if($product->product_disc)
                                    <div class="price-template">
                                         <div class="item-new-price">
                                            {{ formatRupiah($product->product_disc->final_price) }}                                         
                                        </div>
                                        <div class="item-old-price" style="color:red">
                                            {{ formatRupiah($attribute->price) }}
                                        </div>
                                    </div>
                                    @else
                                    <div class="price-template">
                                            <div class="item-new-price">
                                            {{ formatRupiah($attribute->price) }}
                                            </div>
                                    </div>
                                    @endif
                                    @endforeach
                                </div>                                
                            </div>
                        </div>
                       @endforeach
                    </div>                    
                </div>
                {{-- {{ dd($productsListing) }} --}}
                <!-- Shop-Right-Wrapper /- -->
                <!-- Shop-Pagination -->          
            </div>
            <nav aria-label="Page navigation example float-right">
                <ul class="pagination justify-content-end">
                    @php 
                        $lastPage = $productsListing->last_page;
                    @endphp
                    <li class="page-item {{ $productsListing->prev_page_url == null ? 'disabled' : '' }}">
                           <a class="page-link" href="{{ $productsListing->prev_page_url }}">Sebelumnya</a>
                    </li>
                    @for($i=1; $i <= $lastPage; $i++)
                        <li class="page-item"><a class="page-link" href="{{$productsListing->path.'?page='.$i}}">{{ $i }}</a></li>
                    @endfor
                    <li class="page-item {{ $productsListing->next_page_url == null ? 'disabled' : '' }}">
                     <a class="page-link" href="{{ $productsListing->next_page_url }}">Selanjutnya</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
    <!-- Shop-Page /- -->
@endsection
@section('script')
<script>
    let haveParams = "{{$haveParams}}";
    let page = "{{$page}}";
    let spr = haveParams ? '&' : '?';
    let url = `{{url()->current() }}`;
    url += haveParams ? `?page=${page}` : ``;
    function search(){
    let search_text = $('#search-box').val();

        let searchUrl = url+spr+`search=${search_text}`;

        window.location.href=searchUrl
    }

    function mount(type, arr = null) {
        if(type == 'all'){
                const urlString = "{{url()->full()}}";

                const url = new URL(urlString);
                const searchParams = url.searchParams;

                // Remove the 'cat_filter' parameter
                searchParams.delete('cat_filter');

                // Get the updated URL without 'cat_filter'
                const updatedURL = url.origin + url.pathname + '?' + searchParams.toString();

                console.log(updatedURL);
        }
    }

    $(document).ready(function() {
        $('input[name="cat_all"]').on('click', function() {
            if(this.checked){
                $('input[name="categories"]').prop('checked', false);
                mount('all');
            }
        })
        $('input[name="categories"]').on('click', function() {
            if(this.checked){
                $('input[name="cat_all"]').prop('checked', false);
            }
            let selectedCategories = [];
            $('input[name="categories"]:checked').each(function() {
                selectedCategories.push($(this).attr('id').split('_')[1]);
            });

            // Perform any action with the selected categories
            console.log(selectedCategories);
        })
    })
</script>
@endsection
