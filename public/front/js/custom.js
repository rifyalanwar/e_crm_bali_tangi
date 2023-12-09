$(document).ready(function(){

  
    $("#getPrice").change(function(){
        var size = $(this).val();
        var product_id = $(this).attr("product-id");        
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url:'/get-product-price',
            data:{size:size,product_id:product_id},
            type:'post',
            success:function(resp){
                if(resp['discount']>0){
                    $(".getAttributePrice").html("<div class='price'><h4>Rp"+resp['final_price']+"</h4></div><div class='original-price'><span>Harga sebelumnya: </span><span>Rp"+resp['product_price']+"</span></div>");
                }else{
                    $(".getAttributePrice").html("<div class='price'><h4>Rp"+resp['final_price']+"</h4></div>");
                }
            }, error:function(){
                alert("Error");
            }
        });
    });

    //Update Cart items quantity
    $(document).on('click','.updateCartItem', function(){
        if($(this).hasClass('plus-a')){
            // Get Qty
            var quantity = $(this).data('qty');
            // Increase quantity by 1
            new_qty = parseInt(quantity) + 1;
        }
        if($(this).hasClass('minus-a')){
            // Get Qty
            var quantity = $(this).data('qty');
            //Check quantity at least 1
            if(quantity<=1){
                alert("Jumlah barang harus 1 atau lebih");
                return false;
            }
            // Decrease quantity by 1
            new_qty = parseInt(quantity) - 1;
        }
        var cartid = $(this).data('cartid');
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data:{cartid:cartid,qty:new_qty},
            url:'/cart/update',
            type:'post',
            success:function(resp){
                if(resp.status==false){
                    alert(resp.message);
                }
                $("#appendCartItems").html(resp.view);
            }, error:function(){
                alert("Error");
            }
        });
    });

    //Delete Cart items quantity
    $(document).on('click','.deleteCartItem', function(){
       var cartid = $(this).data('cartid');
       var result = confirm("Apakah Anda ingin menghapus barang ini dari keranjang Anda?");
       if(result){
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data:{cartid:cartid},
                url:'/cart/delete',
                type:'post',
                success:function(resp){        
                    $("#appendCartItems").html(resp.view);
                }, error:function(){
                    alert("Error");
                }
        })
       }
    });

    //Delete Wishlist items quantity
    $(document).on('click','.deleteWishlistItem', function(){
        var wishlistid = $(this).data('wishlistid');
        var result = confirm("Apakah Anda ingin menghapus barang ini dari wishlist Anda?");
        if(result){
             $.ajax({
                 headers: {
                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                 },
                 data:{wishlistid:wishlistid},
                 url:'/wishlist/delete',
                 type:'post',
                 success:function(resp){        
                     $("#appendWishlistItems").html(resp.view);
                 }, error:function(){
                     alert("Error");
                 }
         })
        }
     });

    // Apply Coupon
    $("#ApplyCoupon").submit(function(){
    	var user = $(this).attr("user");
    	/*alert(user);*/
    	if(user==1){
    		// do nothing
    	}else{
    		alert("Silahkan log in untuk menggunakan kupon.");
    		return false;
    	}
    	var code = $("#code").val();
    	$.ajax({
    		headers: {
        		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    		},
    		type:'post',
    		data:{code:code},
    		url:'/apply-coupon',
    		success:function(resp){
    			if(resp.message!=""){
    				alert(resp.message);
    			}
				$("#appendCartItems").html(resp.view);
				if(resp.couponAmount>0){
					$(".couponAmount").text(""+resp.formatRupiah(couponAmount));
				}else{
					$(".couponAmount").text("Rp0");
				}
				if(resp.grand_total>0){
					$(".grand_total").text(""+resp.formatRupiah(grand_total));
				}
    		},error:function(){
    			alert("Error");
    		}
    	})
    });

        // Register Form Validation
	$("#registerForm").submit(function(){
		var formdata = $(this).serialize();
		$.ajax({
			url:"/user/register",
			type:"POST",
			data:formdata,
			success:function(resp){
				window.location.href = resp.url;				
			},error:function(){
				alert("Error");
			}
		})
	});

    
      //Account form validation
      $("#accountForm").submit(function(){
        var formdata = $(this).serialize();
        $.ajax({
            url:"/user/account",
            type:"POST",
            data:formdata,
            success:function(resp){
                if(resp.type=="error"){
                    $.each(resp.errors,function(i,error){
                        $("#account-"+i).attr('style','color:red');
                        $("#account-"+i).html(error);                    
                    setTimeout(function(){
                        $("#account-"+i).css({
                            'display':'none'
                        });
                    },3000);
                    });                    
                }else if(resp.type=="success"){
                    $("#account-success").attr('style','color:green');
                    $("#account-success").html(resp.message);                   
                }   
            }, error:function(){
                alert("Error");
            }
        })
    });
    
    //Login form validation
    $("#loginForm").submit(function(){
        var formdata = $(this).serialize();
        $.ajax({
            url:"/user/login",
            type:"POST",
            data:formdata,
            success:function(resp){
                if(resp.type=="error"){
                    $.each(resp.errors,function(i,error){
                        $("#login-"+i).attr('style','color:red');
                        $("#login-"+i).html(error);
                    
                    setTimeout(function(){
                        $("#login-"+i).css({
                            'display':'none'
                        });
                    },3000);
                });                    
                }else if(resp.type=="incorrect"){
                    $("#login-error").attr('style','color:red');
                    $("#login-error").html(resp.message);
                } else if(resp.type=="inactive"){
                    $("#login-error").attr('style','color:red');
                    $("#login-error").html(resp.message);
                } else if(resp.type=="success"){
                    window.location.href = resp.url;
                }
            }, error:function(e){
                // alert("Error");
                console.warn("Error login : "+e);
            }
        })
    });

    // Password Form Validation
	$("#passwordForm").submit(function(){
		$(".loader").show();
		var formdata = $(this).serialize();
		$.ajax({
			url:"/user/update-password",
			type:"POST",
			data:formdata,
			success:function(resp){
				if(resp.type=="error"){
					$(".loader").hide();
					$.each(resp.errors,function(i,error){
						$("#password-"+i).attr('style','color:red');
						$("#password-"+i).html(error);
					setTimeout(function(){
						$("#password-"+i).css({
							'display':'none'
						});
					},3000);
					});
				}else if(resp.type=="incorrect"){
					$(".loader").hide();
					$("#password-error").attr('style','color:red');
					$("#password-error").html(resp.message);
					setTimeout(function(){
						$("#password-error").css({
							'display':'none'
						});
					},3000);
				}else if(resp.type=="success"){
					/*alert(resp.message);*/
					$(".loader").hide();
					$("#password-success").attr('style','color:green');
					$("#password-success").html(resp.message);
					setTimeout(function(){
						$("#password-success").css({
							'display':'none'
						});
					},3000);
				}
				
			},error:function(){
				alert("Error");
			}
		})
	});

    function checkCost() {
        var origin = '{{ $data["shipping_address"]->city_id }}';
        // var destination = $('#city_id option:selected').data('id');
        var weight = "{{ $data['carts']->sum('total_weight_per_product') }}";
        var courier = $('#courier option:selected').val();

        let _url = `/rajaongkir/cost`;
        let _token = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            url: _url,
            type: "POST",
            data: {
                origin: origin,
                destination: destination,
                weight: weight,
                courier: courier,
                _token: _token
            },
            dataType: "json",
            success: function(response) {
                if (response) {
                    $('#shipping_method').empty();
                    $('#shipping_method').append(
                        'option value="" selected disabled>-- Pilih Jenis Pengiriman --</option>');
                    $.each(response[0].costs, function(key, cost) {
                        $('select[name="shipping_method"]').append('<option value="' + cost.service + ' Rp.' + cost.cost[0].value + ' Estimasi ' +
                            cost.cost[0].etd +
                            '" data-ongkir="'+cost.cost[0].value+'">' + cost.service + ' Rp.' + cost.cost[0].value + ' Estimasi ' +
                            cost.cost[0].etd +
                            '</option>');
                        if (key == 0) {
                            countCost(cost.cost[0].value)
                        }
                    });
                } else {
                    $('#shipping_method').append(
                        'option value="" selected disabled>-- Pilih Jenis Pengiriman --</option>');
                }
            },
        });
    }

    // $('#province_id').on('change', function() {
    //     var provinceId = $('#province_id option:selected').data('id');
    //     $('#city_id').empty();
    //     $('#city_id').append('<option value="">-- Loading Data --</option>');
    //     $.ajax({
    //         url: '/rajaongkir/province/' + provinceId,
    //         type: "GET",
    //         dataType: "json",
    //         success: function(data) {
    //             if (data) {
    //                 $('#city_id').empty();
    //                 $('#city_id').removeAttr('disabled');
    //                 $('select[name="city_id"]').append(
    //                     'option value="" selected>-- Select City --</option>');
    //                 $.each(data, function(key, city) {
    //                     $('select[name="city_id"]').append('<option value="' + city
    //                         .city_name + '" data-id="'+city.city_id+'">' + city.type + ' ' + city.city_name +
    //                         '</option>');
    //                 });
    //                 checkCost();
    //             } else {
    //                 $('#city_id').empty();
    //             }
    //         }
    //     });
    // });

    // $('#city_id').on('change', function() {
    //     checkCost();
    // });
    // $('#courier').on('change', function() {
    //     checkCost();
    // });

    // $('#shipping_method').on('change',function(){
    //     var ongkir = parseInt($('#shipping_method option:selected').data('ongkir'));
    //     countCost(ongkir);
    // })

    function countCost(ongkir)
    {
        var subtotal = `{{ $data['carts']->sum('total_price_per_product') }}`;
        var total = parseInt(subtotal) + ongkir;
        $('#text-cost').text(rupiah(ongkir));
        $('#shipping_cost').val(ongkir);
        $('#total').text(rupiah(total))
    }
});