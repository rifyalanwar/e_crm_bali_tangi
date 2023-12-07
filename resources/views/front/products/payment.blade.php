<?php use App\Models\Product; ?>
@extends('front.layout.layout')
@section('content')
<div class="page-style-a">
    <div class="container">
        <div class="page-intro">
            <h2>Pembayaran Transaksi</h2>                
        </div>
</div>
</div>
<!-- Payment-Page -->
<div class="page-checkout u-s-p-t-80">
    <div class="container">
        @if(Session::has('error_message'))
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error: </strong> <?php echo Session::get('error_message'); ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        @endif
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="row">
                        <!-- Payment-->
                        <div class="col-lg-6">
                        <h4 class="section-h4">Alamat Pengiriman</h4>
                                <div><label class="control-label">{{ Auth::user()->name }}, {{ Auth::user()->address }} ({{ Auth::user()->mobile }}) </label>
                                </div>
                            &nbsp;
                            <h4 class="section-h4">Pesanan Anda</h4>
                            <div class="order-table">
                                <table class="u-s-m-b-13">
                                    <thead>
                                        <tr>
                                            <th>Produk</th>
                                            <th>Harga</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @php $total_price = 0 @endphp
                                    @foreach($orderDetails['orders_detail'] as $product)                                   
                                        <tr>
                                            <td>
                                            @php $getProductImage = Product::getProductImage($product['product_id']) @endphp
                                                <a target="_blank" href="{{ url('product/'.$product['product_id']) }}"><img src="{{ asset('front/images/product_images/small/'.$getProductImage) }}"></a>
                                                <h6 class="order-h6">{{ $product['product_name'] }}<br>{{ $product['product_size'] }} × {{ $product['product_qty'] }}</h6></a>
                                            </td>
                                            <td>
                                            </td>
                                        </tr>
                                        @php $total_price = $total_price + ($product['product_price'] * $product['product_qty']) @endphp
                                        @endforeach
                                        <tr>
                                            <td>
                                                <h3 class="order-h3">Subtotal</h3>
                                            </td>
                                            <td>
                                                <h3 class="order-h3">{{ formatRupiah($total_price) }}</h3>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <h6 class="order-h6">Biaya Pengiriman</h6>
                                            </td>
                                            <td>
                                                <h6 class="order-h6" id="text-cost">Rp0</h6>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <h6 class="order-h6">Diskon Kupon</h6>
                                            </td>
                                            <td>
                                                <h6 class="order-h6">@if(Session::has('couponAmount'))
                                                    -{{ formatRupiah(Session::get('couponAmount')) }}
                                                @else
                                                    Rp0
                                                @endif</h6>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <h3 class="order-h3">Grand Total</h3>
                                            </td>
                                            <td>
                                                <h3 class="order-h3">{{ formatRupiah($orderDetails['grand_total']) }}</h3>
                                                <input type="hidden" name="shipping_cost" id="shipping_cost" >
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>                                
                                &nbsp;                                          
                                <button type="submit" class="button button-primary" id="pay-button">Bayar Sekarang</button>
                            </div>
                        </div>
                        <!-- Payment /- -->
                    </div>
                </div>
            </div>
    </div>
</div>
<!-- Payment-Page /- -->

<script type="text/javascript">
    // For example trigger on button clicked, or any time you need
    var payButton = document.getElementById('pay-button');
    payButton.addEventListener('click', function () {
    // Trigger snap popup. @TODO: Replace TRANSACTION_TOKEN_HERE with your transaction token
    window.snap.pay('{{ $snapToken }}', {
        onSuccess: function(result){
        /* You may add your own implementation here */
        alert("payment success!"); console.log(result);
        },
        onPending: function(result){
        /* You may add your own implementation here */
        alert("wating your payment!"); console.log(result);
        },
        onError: function(result){
        /* You may add your own implementation here */
        alert("payment failed!"); console.log(result);
        },
        onClose: function(){
        /* You may add your own implementation here */
        alert('you closed the popup without finishing the payment');
        }
    })
    });
</script>
@endsection