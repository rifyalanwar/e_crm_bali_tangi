<?php use App\Models\Product; ?>
@extends('front.layout.layout')
@section('content')
<div class="page-style-a">
    <div class="container">
        <div class="page-intro">
            <h2>Checkout</h2>                
        </div>
</div>
</div>
<!-- Checkout-Page -->
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
                        <!-- Billing-&-Shipping-Details -->
                        <div class="col-lg-6" id="deliveryAddresses">
                            <h4 class="section-h4">Alamat Pengiriman</h4>
                                <div><label class="control-label">{{ Auth::user()->name }}, {{ Auth::user()->address }} ({{ Auth::user()->mobile }}) </label>
                                </div>
                                <br>
                                <br>
                                <br>
                                <h4 class="section-h4 deliveryText">Cek Biaya Pengiriman</h4>
                               
                                <div id="showdifferent">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">Provinsi</label>
                                                <div id="box-load-province_id"></div>
                                                <select class="form-control select2 w-100" id="province_id" disabled="disabled" name="province_id">
                                                    <option value="" selected disabled>Pilih Provinsi</option>                                                                                       
                                                </select>  
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">Kota</label>
                                                <div id="box-load-city_id"></div>
                                                <select class="form-control select2 w-100" id="city_id" disabled="disabled" name="city_id">
                                                    <option value="" selected disabled>Pilih Kota</option>                                                                                       
                                                </select>  
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">Kecamatan</label>
                                                <div id="box-load-subdistrict_id"></div>
                                                <select class="form-control select2 w-100" id="subdistrict_id"  disabled="disabled" name="subdistrict_id">
                                                    <option value="" selected disabled>Pilih Kecamatan</option>                                                                                       
                                                </select>  
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="weight">Berat (gr)</label>
                                                <input disabled="true" type="text" name="weight" class="form-control" style="max-height: 28px !important; text-align: right" id="weight">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">Kurir</label>
                                                <div id="box-load-kurir"></div>
                                                <select class="form-control select2 w-100" id="kurir" disabled="disabled" name="kurir">
                                                    <option value="" selected disabled>Pilih Kurir</option>                                                                                       
                                                </select>  
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">Layanan</label>
                                                <div id="box-load-layanan"></div>
                                                <select class="form-control select2 w-100" id="layanan" disabled="disabled" name="layanan">
                                                    <option value="" selected disabled>Pilih Layanan</option>                                                                                       
                                                </select>  
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                &nbsp;
                                &nbsp;
                                <div>
                                    <label for="order-notes">Catatan Pemesanan</label>
                                    <textarea class="text-area" id="order-notes" placeholder="Catatan untuk pemesanan Anda"></textarea>
                                </div>
                        </div>
                        <!-- Billing-&-Shipping-Details /- -->
                        <!-- Checkout -->
                        <div class="col-lg-6">
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
                                        @php 
                                            $total_price = 0 ;
                                            $total_weight = 0 ;
                                        @endphp
                                        @foreach($getCartItems as $item)
                                        <?php $getDiscountAttributePrice = Product::getDiscountAttributePrice($item['product_id'],$item['size']);
                                        ?>
                                        <tr>
                                            <td>
                                                <a href="{{ url('produk/'.$item['product_id'])}}"><img width="50" src="{{ asset('front/images/product_images/small/'.$item['product']['product_image']) }}" alt="Product">
                                                <h6 class="order-h6">{{ $item['product']['product_name'] }}<br>{{ $item['size'] }} × {{ $item['quantity'] }}</h6></a>
                                            </td>
                                            <td>
                                                <h6 class="order-h6">{{ formatRupiah($getDiscountAttributePrice['final_price'] * $item['quantity']) }}</h6>
                                            </td>
                                        </tr>
                                        @php 
                                            $total_price += ($getDiscountAttributePrice['final_price'] * $item['quantity']);
                                            $total_weight += ((float)$item['weight'] * (float)$item['quantity']) ;
                                        @endphp
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
                                                <h3 class="order-h3" id="total-text">{{ formatRupiah($total_price - Session::get('couponAmount')) }}</h3>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>   
                                &nbsp;                                          
                                <button type="button" id="button-click-checkout" class="button button-primary">Lanjutkan ke Pembayaran</button>
                            </div>
                        </div>
                        <!-- Checkout /- -->
                    </div>
                </div>
            </div>
    </div>
</div>
<!-- Checkout-Page /- -->
@endsection
@section('script')
<link rel="stylesheet" href="{{ asset('/css/select2.min.css') }}"/>
<script type="text/javascript" src="{{ asset('/js/select2.min.js') }}"></script>
<script>
    let berat = "{{ @$total_weight ?? 0 }}";
    let total_price = "{{ @$total_price ?? 0 }}";
    let total_voc = "{{ @Session::get('couponAmount') ?? 0 }}";
    let fix_cost = 0
    let data_fix = {};
    $(document).ready(function() {
        $('.select2').select2();
        loadProv();
        setTimeout(() => {
            $('#weight').val(berat);
        }, 500);
    });
    function loadProv() {
        const key = 'province_id'
        const name = 'province'
        $.ajax({
            url: `{{ url('/ongkir/provinces') }}`,
            type: 'GET',
            dataType: 'json', 
            beforeSend: function() {
                $('#'+key).prop('disabled', true);
                $('#box-load-'+key).html('memuat data...');
            },
            success: function(response) {
                setDataSelect(response, key, name);
                $('#'+key).prop('disabled', false);
                $('#box-load-'+key).hide();
            },
            error: function(xhr, status, error) {
                console.error(status + ': ' + error);
            }
        });
    }
    // prov change
    $('#province_id').change(function() {
        const val = $(this).val();
        loadCity(val);
    });

    function loadCity(id) {
        const key = 'city_id'
        const name = 'city_name'
        const name_id = 'city'
        $.ajax({
            url: `{{ url('/ongkir/cities') }}/`+id,
            type: 'GET',
            dataType: 'json', 
            beforeSend: function() {
                $('#'+key).prop('disabled', true);
                $('#box-load-'+key).html('memuat data...');
            },
            success: function(response) {
                setDataSelect(response, key, name,name_id);
                $('#'+key).prop('disabled', false);
                $('#box-load-'+key).hide();
            },
            error: function(xhr, status, error) {
                console.error(status + ': ' + error);
            }
        });
    }
    // city change
    $('#city_id').change(function() {
        const val = $(this).val();
        loadDistrict(val);
    });

    function loadDistrict(id) {
        const key = 'subdistrict_id'
        const name = 'subdistrict_name'
        const name_id = 'subdistrict'
        $.ajax({
            url: `{{ url('/ongkir/districts') }}/`+id,
            type: 'GET',
            dataType: 'json', 
            beforeSend: function() {
                $('#'+key).prop('disabled', true);
                $('#box-load-'+key).html('memuat data...');
            },
            success: function(response) {
                setDataSelect(response, key, name, name_id);
                $('#'+key).prop('disabled', false);
                $('#box-load-'+key).hide();
            },
            error: function(xhr, status, error) {
                console.error(status + ': ' + error);
            }
        });
    }

    // subdistrict change
    $('#subdistrict_id').change(function() {
        loadKurir();
    });

    function loadKurir() {
        const key = 'kurir'
        $('#'+key).prop('disabled', true);
        $('#box-load-'+key).html('memuat data...');
        const data = [
            {
                'kurir_id' : 'jnt',
                'kurir' : 'JNT'
            },
            {
                'kurir_id' : 'jne',
                'kurir' : 'JNE'
            }
        ]
        setDataSelect(data,key,key)
        setTimeout(()=>{
                $('#'+key).prop('disabled', false);
                $('#box-load-'+key).hide();
        }, 500)
    }

    // kurir change
    $('#kurir').change(function() {
        loadCost()
    });

    function setDataSelect(data, type, name, name_id = null){
        const formattedData = data.map(function(item) {
            return {
                id: item[`${name_id ?? name}_id`], 
                text: item[`${name}`]
            };
        });
        $(`#${type}`).select2({
            data: formattedData
        });
    }

    function loadCost(){
        var destination = $('#subdistrict_id option:selected').val();
        var kurir = $('#kurir option:selected').val();

        let _url = `{{url('/ongkir/cost')}}`;
        let _token = $('meta[name="csrf-token"]').attr('content');
        const data =  {
            destination: destination,
            weight: berat,
            courier: kurir,
            _token: _token
        }
        $.ajax({
            url: _url,
            type: "POST",
            data,
            dataType: "json",
            beforeSend: function(){
                $('#layanan').val(null)
                $(`#layanan`).select2({
                    data: []
                });
            },
            success: function(response) {
                if (response.length) {
                    let formattedData = []
                    response[0].costs.forEach((v) => {
                        formattedData.push({
                            id: v.cost[0]['value'],
                            text: v.service+' (etd: '+v.cost[0]['etd']+' Hari) - '+v.cost[0]['value']
                        })
                    });
                    $(`#layanan`).select2({
                        data: formattedData
                    });
                    $('#layanan').prop('disabled', false);
                    $('#box-load-layanan').hide();
                }
            },
            error: function(xhr, status, error) {
                console.error(status + ': ' + error);
            }
        })

    }
    // layanan select
    $('#layanan').change(function() {
        let ongkir = $(this).val()
        ongkir = Number(ongkir)
        var subtotal = total_price-total_voc
        var total = subtotal + ongkir;
        $('#text-cost').text(formatRP(ongkir));
        $('#shipping_cost').val(ongkir);
        $('#total-text').text(formatRP(total))

        // set the data before post
        const prov =  $('#province_id').select2('data');
        const city =  $('#city_id').select2('data');
        const subdistrict =  $('#subdistrict_id').select2('data');
        data_fix.destination = `${prov[0].text}, ${city[0].text}, ${subdistrict[0].text}`;
        data_fix.courier = $('#kurir option:selected').val();
        data_fix.shipping_cost = ongkir;
    });

    // PROCESS CHECKOUT
    $('#button-click-checkout').click(()=>{
        if(!data_fix.shipping_cost) {
            return alert('pilih alamat tujuan anda terlebih dahulu');
        }
        data_fix.note = $('#order-notes').val();
        const data = data_fix;
        $.ajax({
            url: "{{ url('/checkout') }}",
            type: "POST",
            data:{
                ...data,
                "_token": "{{ csrf_token() }}"
            },
            dataType: "json",
            beforeSend: function(){
                $('#button-click-checkout').text('Memproses data...');
                $('#button-click-checkout').attr('disabled',true);
            },
            success: function(response) {
                $('#button-click-checkout').text('Lanjutkan ke Pembayaran');
                $('#button-click-checkout').attr('disabled',false);
                window.location.href=response.redirect
            },
            error: function(xhr, status, error) {
                $('#button-click-checkout').text('Lanjutkan ke Pembayaran');
                $('#button-click-checkout').attr('disabled',false);
                console.error(status + ': ' + error);
            }
        })
    });

    function formatRP(number){
        const formattedNumber = new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0,
        }).format(number);
        return formattedNumber
    }
</script>
@endsection