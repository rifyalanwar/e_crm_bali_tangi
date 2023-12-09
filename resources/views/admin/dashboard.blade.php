@extends('admin.layout.layout')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="row">
                    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                        <h3 class="font-weight-bold">Selamat Datang {{ Auth::guard('admin')->user()->name }}</h3>
                        <h6 class="font-weight-normal mb-0">Sistem dapat berjalan dengan baik.</h6>
                    </div>                    
                </div>
            </div>
        </div>
        <div class="row">            
            <div class="col-md-12 grid-margin transparent">
                <div class="row">
                 
                    <div class="col-md-3  stretch-card transparent">
                        <div class="card card-dark-blue">
                            <div class="card-body">
                                <p class="mb-4">Pelanggan Baru</p>
                                <p class="fs-30 mb-2">{{$pelanggan_baru}}</p>
                            </div>
                        </div>
                    </div>
                       <div class="col-md-3  stretch-card transparent">
                        <div class="card card-tale">
                            <div class="card-body">
                                <p class="mb-4">Pesanan Baru</p>
                                <p class="fs-30 mb-2">{{$pesanan_baru}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3  stretch-card transparent">
                        <div class="card card-light-blue">
                            <div class="card-body">
                                <p class="mb-4">Transaksi Lunas</p>
                                <p class="fs-30 mb-2">{{$total_transaksi_perlu_lunas}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3  stretch-card transparent">
                        <div class="card card-light-blue">
                            <div class="card-body">
                                <p class="mb-4">Total Transaksi Berhasil</p>
                                <p class="fs-30 mb-2">{{$total_transaksi_berhasil}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>            
    </div>
    <!-- content-wrapper ends -->
    <!-- partial:partials/_footer.html -->
    @include('admin.layout.footer')
    <!-- partial -->
</div>
@endsection