<?php use App\Models\Product; ?>
@extends('front.layout.layout')
@section('content')
<div class="page-style-a">
    <div class="container">
        <div class="page-intro">
            <h2>Detail Pesanan #{{ $orderDetails['id'] }} </h2>                
        </div>
    </div>
</div>
<div class="page-cart u-s-p-t-80">
    <div class="container">
        <div class="row">
            <table class="table table-striped table-borderless">
                <tr class="table-secondary"><td colspan="2"><strong>Detail Pesanan</strong></td></tr>
                <tr><td>Tanggal Pemesanan</td><td>{{ date('Y-m-d h:i:s', strtotime($orderDetails['created_at'])); }}</td></tr>
                <tr><td>Status Pesanan</td><td>{{ $orderDetails['order_status']}}</td></tr>
                <tr><td>Total Pesanan</td><td>{{ formatRupiah($orderDetails['grand_total']) }}</td></tr>
                <tr><td>Biaya Pengiriman</td><td>{{ formatRupiah($orderDetails['shipping_charges']) }}</td></tr>
                <tr><td>Kurir</td><td>{{ $orderDetails['courier']}}</td></tr>
                <tr><td>Alamat Pengiriman</td><td><b>({{$orderDetails['name'].' - '.$orderDetails['mobile']}})</b> {{ $orderDetails['destination'].', '.$orderDetails['address'] }}</td></tr>
                <tr><td>Catatan Pesanan</td><td>{{ $orderDetails['note'] ?? '-' }}</td></tr>
                @if($orderDetails['coupon_code']!="")
                <tr><td>Kode Kupon</td><td>{{ $orderDetails['coupon_code']}}</td></tr>
                <tr><td>Potongan Kupon</td><td>{{ $orderDetails['coupon_amount']}}</td></tr>
                @endif
                <tr><td>Metode Pembayaran</td><td>{{ $orderDetails['payment_method']}}</td></tr>
            </table>
            <table class="table table-striped table-borderless">
                <tr class="table-secondary">
                    <th>Gambar Produk</th>
                    <th>Nama Produk</th>
                    <th>Ukuran Produk</th>
                    <th>Jumlah Produk</th>
                </tr>
                @foreach($orderDetails['orders_detail'] as $product)
                    <tr>
                        <td>
                            @php $getProductImage = Product::getProductImage($product['product_id']) @endphp
                            <a target="_blank" href="{{ url('product/'.$product['product_id']) }}"><img style="width:80px" src="{{ asset('front/images/product_images/small/'.$getProductImage) }}"></a>
                        </td>
                        <td>{{ $product['product_name'] }}</td>
                        <td>{{ $product['product_size'] }}</td>
                        <td>{{ $product['product_qty'] }}</td>
                    </tr>
                
                @endforeach   
            </table>
            {{-- <table class="table table-striped table-borderless">
                <tr class="table-secondary"><td colspan="2"><strong>Alamat Pengiriman</strong></td></tr>
                <tr><td>Nama</td><td>{{ $orderDetails['name']}}</td></tr>
                <tr><td>Alamat</td><td>{{ $orderDetails['address']}}</td></tr>
                <tr><td>Nomor Telepon</td><td>{{ $orderDetails['mobile']}}</td></tr>
            </table> --}}
        </div>
            <button onclick="payment()" id="btn-payment" class="btn btn-primary float-right">Bayar Sekarang</button>
    </div>
</div>
@endsection
@section('script')
<script>
    let order_id = "{{$orderDetails['id']}}";
    function payment(){
        $.ajax({
        url: `{{ url('/payment/${order_id}') }}`,
        type: "GET",
        dataType: "json",
        beforeSend: function(){
            $('#btn-payment').text('Memproses data...');
            $('#btn-payment').attr('disabled',true);
        },
        success: function(response) {
            $('#btn-payment').text('Bayar Sekarang');
            $('#btn-payment').attr('disabled',false);
            openSnap(response.data)
        },
        error: function(xhr, status, error) {
            $('#btn-payment').text('Bayar Sekarang');
            $('#btn-payment').attr('disabled',false);
            console.error(status + ': ' + error);
        }
        })
    }

    function openSnap(token){
        window.snap.pay(token, {
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
    }
</script>
@endsection