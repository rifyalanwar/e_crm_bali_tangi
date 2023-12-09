<?php use App\Models\Product; ?>  
  <!-- Products-List-Wrapper -->
  <div class="table-wrapper u-s-m-b-60">
            <table>
                <thead>
                    <tr>
                        <th class="text-center" style="width: 400px">Produk</th>
                        <th class="text-right" >Harga Unit</th>
                        <th class="text-center" >Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php $total_price = 0 @endphp
                    @foreach($getWishlistItems as $item)
                    <?php $getDiscountAttributePrice = Product::getDiscountAttributePrice($item['product_id'],$item['size']);
                    ?>
                    <tr>
                        <td class="text-center">
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
                                @php
                                    $stok_ready = ($item['product']['stock'] == null || $item['product']['stock'] < 1);
                                @endphp
                                <div class="d-flex justify-content-end {{ $stok_ready ? 'text-danger' : 'text-success' }}">
                                    <i>{{ $stok_ready ? 'Stok Tidak Tersedia' : 'Stok Tersedia' }}</i>
                                </div>
                            </div>
                        </td>
    
                        <td class="text-center">
                            <div class="action-wrapper">
                                <form action="{{ url('cart/add') }}" class="post-form" method="Post">@csrf
                                   
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