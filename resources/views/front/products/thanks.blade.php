<?php use App\Models\Product; ?>
@extends('front.layout.layout')
@section('content')
<div class="page-style-a">
    <div class="container">
        <div class="page-intro">
            <h2>Terima Kasih</h2>                
        </div>
    </div>
</div>
<!-- Cart-Page -->
<div class="page-cart u-s-p-t-80">
    <div class="container">
        <div class="row">
            <div class="col-lg-12" align="center">
                <h3>Pesanan Anda sudah berhasil diproses.</h3>
                <p>No. Pesanan Anda adalah {{ Session::get('order_id') }}</p>
            </div>
        </div>
    </div>
</div>
<!-- Cart-Page /- -->
@endsection