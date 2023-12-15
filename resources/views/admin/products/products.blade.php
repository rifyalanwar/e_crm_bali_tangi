@extends('admin.layout.layout')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                    @if(Session::has('success_message'))
                          <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Success: </strong> {{ Session::get('success_message')}}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                        @endif
                        <h4 class="card-title">Daftar Produk</h4>
                        <!-- <p class="card-description">
                            Add class <code>.table-bordered</code>
                        </p> -->
                        <a style="max-width: 150px; float: right; display: inline-block;" href="{{ url('admin/add-edit-product') }}" class="btn btn-block btn-primary">Tambah Produk</a>
                        <div class="table-responsive pt-3">
                            <table id="products" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>
                                            ID
                                        </th>
                                        <th>
                                            Nama Produk
                                        </th>                                    
                                        <th>
                                            Gambar Produk
                                        </th>
                                        <th>
                                            Kategori
                                        </th>
                                        <th>
                                            Status
                                        </th>
                                        <th>
                                            Aksi
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                  @foreach($products as $product)
                                    
                                    <tr>
                                        <td>
                                            {{ $product['id'] }}
                                        </td>
                                        <td>
                                            {{ $product['product_name'] }}
                                        </td>                                        
                                        <td>
                                            @if(!empty($product['product_image']))
                                                <img style="width: 120px; height: 120px;" src="{{ asset('front/images/product_images/small/'.$product['product_image']) }}">
                                            @else
                                                <img style="width: 120px; height: 120px;" src="{{ asset('front/images/product_images/small/no-image.png') }}">
                                            @endif
                                        </td>
                                        <td>
                                            {{ $product['category']['category_name'] }}
                                        </td>
                                        <td>
                                            @if($product['status']==1)
                                              <a class="updateProductStatus" id="product-{{ $product['id'] }}" product_id="{{ $product['id'] }}" href="javascript:void(0)"><i style="font-size:25px;" class="mdi mdi-bookmark-check" status="Aktif"></i></a>
                                            @else
                                              <a class="updateProductStatus" id="product-{{ $product['id'] }}" product_id="{{ $product['id'] }}" href="javascript:void(0)"><i style="font-size:25px;" class="mdi mdi-bookmark-outline" status="Non-aktif"></i></a>
                                            @endif
                                        </td>
                                        <td>
                                            <a title="Edit Product" href="{{ url('admin/add-edit-product/'.$product['id']) }}"><i style="font-size:25px;" class="mdi mdi-pencil-box"></i></a>
                                            <a title="Add Attributes" href="{{ url('admin/add-edit-attributes/'.$product['id']) }}"><i style="font-size:25px;" class="mdi mdi-plus-box"></i></a>
                                            <a title="Add Images" href="{{ url('admin/add-images/'.$product['id']) }}"><i style="font-size:25px;" class="mdi mdi-library-plus"></i></a>
                                            <?php /* <a title="Product" class="confirmDelete" href="{{ url('admin/delete-product/'.$product['id']) }}"><i style="font-size:25px;" class="mdi mdi-file-excel-box"></i></a> */ ?>
                                            <a href="javascript:void(0)" class="confirmDelete" module="product" moduleid="{{ $product['id'] }}"><i style="font-size:25px;" class="mdi mdi-file-excel-box"></i></a>
                                        </td>
                                    </tr>
                                   @endforeach 
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- content-wrapper ends -->
    <!-- partial:../../partials/_footer.html -->
    @include('admin.layout.footer')
    <!-- partial -->
</div>
@endsection