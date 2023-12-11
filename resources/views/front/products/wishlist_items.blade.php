<?php use App\Models\Product; ?>  
  <!-- Products-List-Wrapper -->
    @if(Session::has('success_message'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Berhasil </strong> {{ Session::get('success_message')}}.
        <a class="text-primary" href="{{url('cart')}}">buka keranjang</a>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif
    @if(Session::has('error_message'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Perhatian: </strong> {{ Session::get('error_message')}}.
        <a class="text-primary" href="{{url('cart')}}">buka keranjang</a>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
    @endif
  <div class="table-wrapper u-s-m-b-60">
            <table>
                <thead>
                    <tr>
                        <th class="text-left" style="width: 400px">Produk</th>
                        <th class="text-center" >Harga Unit</th>
                        <th class="text-center" >Status Ketersediaan</th>
                        <th class="text-center" >Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php $total_price = 0 @endphp
                    @foreach($getWishlistItems as $item)
                    <?php $getDiscountAttributePrice = Product::getDiscountAttributePrice($item['product_id'],$item['size']);
                    ?>
                    <tr>
                        <td class="text-left">
                            <div class="cart-anchor-image">
                                <a href="{{ url('produk/'.$item['product_id'])}}">
                                    <img src="{{ asset('front/images/product_images/small/'.$item['product']['product_image']) }}" alt="Product">
                                    <h6>
                                        <b>{{ $item['product']['product_name'] }}</b> <br>
                                        Ukuran: {{ $item['size'] }}
                                    </h6>
                                </a>
                            </div>
                        </td>
                        <td>
                            <div class="cart-price">
                                @if($getDiscountAttributePrice['discount']>0)
                                    <div class="price-template d-flex justify-content-end">
                                        <div class="item-new-price ">
                                            {{ formatRupiah($getDiscountAttributePrice['final_price']) }}
                                        </div>
                                        <div class="item-old-price" style="margin-left:15px">
                                            {{ formatRupiah($getDiscountAttributePrice['product_price']) }}
                                        </div>
                                    </div>
                                    @else
                                    <div class="price-template">
                                        <div class="item-new-price">
                                            {{ formatRupiah($getDiscountAttributePrice['final_price']) }}
                                        </div>
                                    </div>
                                @endif
                          
                            </div>
                        </td>
                        <td class="text-center">
                            @php
                                $stok_ready = ($item['product']['stock'] == null || $item['product']['stock'] < 1);
                            @endphp
                            <div class="d-flex justify-content-center {{ $stok_ready ? 'text-danger' : 'text-success' }}">
                                <span>{{ $stok_ready ? 'Tidak Tersedia' : 'Tersedia' }}</span>
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="action-wrapper">
                                <form action="{{ url('cart/add') }}" class="post-form" method="Post">@csrf
                                    <input type="hidden" value="{{$item['id']}}" name="att_id">
                                    <input type="hidden" value="{{$item['product']['id']}}" name="product_id">
                                    <input type="hidden" value="1" name="quantity">
                                    <button class="button button-primary" type="submit">Add to cart</button>
                                </form>                                             
                            </div>
                        </td>
                        <td class="text-left">
                        <div class="action-wrapper">
                            <button class="button button-outline-secondary fas fa-trash deleteWishlistItem" data-wishlistid="{{ $item['id'] }}"></button>                                    
                        </div>
                        </td>   
                    </tr> 
                    @endforeach                   
                </tbody>
            </table>
        </div>
        <!-- Products-List-Wrapper /- -->