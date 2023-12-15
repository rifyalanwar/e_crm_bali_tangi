@extends('admin.layout.layout')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        @php
                            $filter = app()->request->query('filter') ;
                        @endphp
                        <h4 class="card-title">Laporan Pelanggan</h4>      
                        <button onclick="filter('all')" class="btn {{ $filter == 'all' || !$filter ? 'btn-primary' : 'btn-outline-primary' }}">
                            Semua Transaksi
                        </button>               
                        <button onclick="filter('transaksi_terbanyak')" class="btn {{ $filter == 'transaksi_terbanyak' || !$filter ? 'btn-primary' : 'btn-outline-primary' }}">
                            Transaksi Terbanyak
                        </button>               
                        <button onclick="filter('pelanggan_lama')" class="btn {{ $filter == 'pelanggan_lama' || !$filter ? 'btn-primary' : 'btn-outline-primary' }}">
                            Pelanggan Lama
                        </button>               
                        <button onclick="filter('belanja_terbanyak')" class="btn {{ $filter == 'belanja_terbanyak' || !$filter ? 'btn-primary' : 'btn-outline-primary' }}">
                            Total Belanja Terbanyak
                        </button>               
                        <div class="table-responsive pt-3">
                            {{-- <table id="reports" class="table table-bordered"> --}}
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nama</th>                                    
                                        <th>E-mail</th>
                                        <th>No. Telepon</th>
                                        <th>Agama</th>
                                        <th>Tanggal Lahir</th>
                                        @if(!$filter || $filter == 'all' || $filter == 'transaksi_terbanyak')
                                        <th>Jumlah Transaksi</th>
                                        @endif
                                        @if(!$filter || $filter == 'all' || $filter == 'belanja_terbanyak')
                                        <th>Total Belanja</th>
                                        @endif
                                        @if(!$filter || $filter == 'all' || $filter == 'pelanggan_lama')
                                        <th>Tanggal Pembelian Terakhir</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>                                                                    
                                    @foreach ($data as $d)
                                        <tr>
                                            <td>#{{$d->id}}</td>
                                            <td>{{$d->name}}</td>
                                            <td>{{$d->email}}</td>
                                            <td>{{$d->mobile}}</td>
                                            <td>{{$d->religion}}</td>
                                            <td>{{$d->birthdate}}</td>
                                            @if(!$filter || $filter == 'all' || $filter == 'transaksi_terbanyak')
                                                <td class="text-center">{{$d->total_pembelian}}</td>
                                            @endif
                                            @if(!$filter || $filter == 'all' || $filter == 'belanja_terbanyak')
                                                <td class="text-center">{{formatRupiah(@$d->total_belanja ?? 0)}}</td>
                                            @endif
                                            @if(!$filter || $filter == 'all' || $filter == 'pelanggan_lama')
                                                <td>{{$d->tgl_pembelian_trkhr}}</td>
                                            @endif
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
<script>
    function filter(t){
        let url = "{{ url('/admin/customer-reports') }}";
        window.location.href=url+'?filter='+t;
    }
</script>
@endsection
