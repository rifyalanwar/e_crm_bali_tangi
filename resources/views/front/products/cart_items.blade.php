<?php use App\Models\Product; ?>

<!-- Products-List-Wrapper -->
<div class="table-wrapper u-s-m-b-60">
    <table>
        <thead>
            <tr>
                <th class="text-left">Produk</th>
                <th class="text-left">Harga</th>
                <th class="text-center">Jumlah</th>
                <th class="text-center">Subtotal</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
        @php $total_price = 0 @endphp
            @foreach($getCartItems as $item)
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
                            <div class="price-template">
                                <div class="item-new-price">
                                    {{ formatRupiah($getDiscountAttributePrice['final_price']) }}
                                </div>
                                <div class="item-old-price" style="margin-left:-40px;">
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
                    <div class="cart-quantity">
                        <div class="quantity">
                            <input type="text" class="quantity-text-field" value="{{ $item['quantity'] }}">
                            <a class="plus-a updateCartItem" data-cartid="{{ $item['id'] }}" data-qty="{{ $item['quantity'] }}" data-max="1000">&#43;</a>
                            <a class="minus-a updateCartItem" data-cartid="{{ $item['id'] }}" data-qty="{{ $item['quantity'] }}" data-min="1">&#45;</a>
                        </div>
                    </div>
                </td>
                <td class="text-center">
                    <div class="cart-price">
                        {{ formatRupiah($getDiscountAttributePrice['final_price'] * $item['quantity']) }}
                    </div> 
                </td>
                <td class="text-center">
                    <div class="action-wrapper">
                        <button class="button button-outline-secondary fas fa-trash deleteCartItem" data-cartid="{{ $item['id'] }}"></button>
                    </div>
                </td>
            </tr>
            @php $total_price = $total_price + ($getDiscountAttributePrice['final_price'] * $item['quantity']) @endphp
            @endforeach                                 
        </tbody>
    </table>
</div>
<!-- Products-List-Wrapper /- -->
<!-- Billing -->
<div class="calculation u-s-m-b-60">
<div class="table-wrapper-2">
    <table>
        <thead>
            <tr>
                <th colspan="2">Total Keranjang</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <h3 class="calc-h3 u-s-m-b-0">Sub Total</h3>
                </td>
                <td>
                    <span class="calc-text">{{ formatRupiah($total_price) }}</span>
                </td>
            </tr>
            <tr>
                <td>
                    <h3 class="calc-h3 u-s-m-b-0">Diskon Kupon</h3>
                </td>
                <td>
                    <span class="calc-text couponAmount">
                    @if(Session::has('couponAmount'))
                        -{{ formatRupiah(Session::get('couponAmount')) }}
                    @else
                        Rp0
                    @endif
                    </span>
                </td>
            </tr>
            <tr>
                <td>
                    <h3 class="calc-h3 u-s-m-b-0">Grand Total</h3>
                </td>
                <td>
                    <span class="calc-text grand_total">{{ formatRupiah($total_price - Session::get('couponAmount')) }}</span>
                </td>
            </tr>
        </tbody>
    </table>
</div>
</div>
<!-- Billing /- -->
