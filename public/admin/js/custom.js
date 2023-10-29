$(document).ready(function(){

	// call datatable class
	$('#admins').DataTable();
	$('#categories').DataTable();
	$('#products').DataTable();
	$('#banners').DataTable();
	$('#users').DataTable();
	$('#orders').DataTable();
	$('#coupons').DataTable();
	$('#reports').DataTable();

	$(".nav-item").removeClass("active");
	$(".nav-link").removeClass("active");
	// Check Admin Password is correct or not
	$("#current_password").keyup(function(){
		var current_password = $("#current_password").val();
		/*alert(current_password);*/
		$.ajax({
			headers: {
        		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    		},
			type:'post',
			url:'/admin/check-admin-password',
			data:{current_password:current_password},
			success:function(resp){
				if(resp=="false"){
					$("#check_password").html("<font color='red'>Current Password is Incorrect!</font>");
				}else if(resp=="true"){
					$("#check_password").html("<font color='green'>Current Password is Correct!</font>");
				}
			},error:function(){
				alert('Error');
			}

		});
	})

	// Update Admin Status
	$(document).on("click",".updateAdminStatus",function(){
		var status = $(this).children("i").attr("status");
		var admin_id = $(this).attr("admin_id");
		$.ajax({
			headers: {
        		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    		},
			type:'post',
			url:'/admin/update-admin-status',
			data:{status:status,admin_id:admin_id},
			success:function(resp){
				// alert(resp);
				if(resp['status']==0){
					$("#admin-"+admin_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-outline' status='Inactive'></i>");
				}else if(resp['status']==1){
					$("#admin-"+admin_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-check' status='Active'></i>");
				}
			},error:function(){
				alert("Error");
			}
		})
	});

	// Update Category Status
	$(document).on("click",".updateCategoryStatus",function(){
		var status = $(this).children("i").attr("status");
		var category_id = $(this).attr("category_id");
		$.ajax({
			headers: {
        		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    		},
			type:'post',
			url:'/admin/update-category-status',
			data:{status:status,category_id:category_id},
			success:function(resp){
				// alert(resp);
				if(resp['status']==0){
					$("#category-"+category_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-outline' status='Inactive'></i>");
				}else if(resp['status']==1){
					$("#category-"+category_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-check' status='Active'></i>");
				}
			},error:function(){
				alert("Error");
			}
		})
	});

	// Update Product Status
	$(document).on("click",".updateProductStatus",function(){
		var status = $(this).children("i").attr("status");
		var product_id = $(this).attr("product_id");
		$.ajax({
			headers: {
        		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    		},
			type:'post',
			url:'/admin/update-product-status',
			data:{status:status,product_id:product_id},
			success:function(resp){
				// alert(resp);
				if(resp['status']==0){
					$("#product-"+product_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-outline' status='Inactive'></i>");
				}else if(resp['status']==1){
					$("#product-"+product_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-check' status='Active'></i>");
				}
			},error:function(){
				alert("Error");
			}
		})
	});

// Update Coupon Status
$(document).on("click",".updateCouponStatus",function(){
	var status = $(this).children("i").attr("status");
	var coupon_id = $(this).attr("coupon_id");
	$.ajax({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},
		type:'post',
		url:'/admin/update-coupon-status',
		data:{status:status,coupon_id:coupon_id},
		success:function(resp){
			// alert(resp);
			if(resp['status']==0){
				$("#coupon-"+coupon_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-outline' status='Inactive'></i>");
			}else if(resp['status']==1){
				$("#coupon-"+coupon_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-check' status='Active'></i>");
			}
		},error:function(){
			alert("Error");
		}
	})
});

// Show/Hide Coupon field for Manual/Automatic
$("#ManualCoupon").click(function(){
	$("#couponField").show();
});

$("#AutomaticCoupon").click(function(){
	$("#couponField").hide();
});


// Update Attribute Status
$(document).on("click",".updateAttributeStatus",function(){
	var status = $(this).children("i").attr("status");
	var attribute_id = $(this).attr("attribute_id");
	$.ajax({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},
		type:'post',
		url:'/admin/update-attribute-status',
		data:{status:status,attribute_id:attribute_id},
		success:function(resp){
			// alert(resp);
			if(resp['status']==0){
				$("#attribute-"+attribute_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-outline' status='Inactive'></i>");
			}else if(resp['status']==1){
				$("#attribute-"+attribute_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-check' status='Active'></i>");
			}
		},error:function(){
			alert("Error");
		}
	})
});

// Update Review Status
$(document).on("click",".updateReviewStatus",function(){
	var status = $(this).children("i").attr("status");
	var review_id = $(this).attr("review_id");
	$.ajax({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},
		type:'post',
		url:'/admin/update-review-status',
		data:{status:status,review_id:review_id},
		success:function(resp){
			// alert(resp);
			if(resp['status']==0){
				$("#review-"+review_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-outline' status='Inactive'></i>");
			}else if(resp['status']==1){
				$("#review-"+review_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-check' status='Active'></i>");
			}
		},error:function(){
			alert("Error");
		}
	})
});

// Update Image Status
$(document).on("click",".updateImageStatus",function(){
	var status = $(this).children("i").attr("status");
	var image_id = $(this).attr("image_id");
	$.ajax({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},
		type:'post',
		url:'/admin/update-image-status',
		data:{status:status,image_id:image_id},
		success:function(resp){
			// alert(resp);
			if(resp['status']==0){
				$("#image-"+image_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-outline' status='Inactive'></i>");
			}else if(resp['status']==1){
				$("#image-"+image_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-check' status='Active'></i>");
			}
		},error:function(){
			alert("Error");
		}
	})
});

// Update Banner Status
$(document).on("click",".updateBannerStatus",function(){
	var status = $(this).children("i").attr("status");
	var banner_id = $(this).attr("banner_id");
	$.ajax({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},
		type:'post',
		url:'/admin/update-banner-status',
		data:{status:status,banner_id:banner_id},
		success:function(resp){
			// alert(resp);
			if(resp['status']==0){
				$("#banner-"+banner_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-outline' status='Inactive'></i>");
			}else if(resp['status']==1){
				$("#banner-"+banner_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-check' status='Active'></i>");
			}
		},error:function(){
			alert("Error");
		}
	})
});

	// Confirm Deletion (Simple Javascript)
	/*$(".confirmDelete").click(function(){
		var title = $(this).attr("title");
		if(confirm("Are you sure to delete this "+title+"?")){
			return true;
		}else{
			return false;
		}
	})*/

	// Confirm Deletion (SweetAlert Library)
	$(".confirmDelete").click(function(){
		var module = $(this).attr('module');
		var moduleid = $(this).attr('moduleid');
		Swal.fire({
		  title: 'Are you sure?',
		  text: "You won't be able to revert this!",
		  icon: 'warning',
		  showCancelButton: true,
		  confirmButtonColor: '#3085d6',
		  cancelButtonColor: '#d33',
		  confirmButtonText: 'Yes, delete it!'
		}).then((result) => {
		  if (result.isConfirmed) {
		    Swal.fire(
		      'Deleted!',
		      'Your file has been deleted.',
		      'success'
		    )
		    window.location = "/admin/delete-"+module+"/"+moduleid;
		  }
		})
	})

		// Products Attributes Add/Remove Script
		var maxField = 10; //Input fields increment limitation
		var addButton = $('.add_button'); //Add button selector
		var wrapper = $('.field_wrapper'); //Input field wrapper
		var fieldHTML = '<div><div style="height:10px;"></div><input type="text" name="size[]" placeholder="Size" style="width: 120px;"/>&nbsp;<input type="text" name="sku[]" placeholder="SKU" style="width: 120px;"/>&nbsp;<input type="text" name="price[]" placeholder="Price" style="width: 120px;"/>&nbsp;<a href="javascript:void(0);" class="remove_button">Remove</div>'; //New input field html 
		var x = 1; //Initial field counter is 1
		
		//Once add button is clicked
		$(addButton).click(function(){
			//Check maximum number of input fields
			if(x < maxField){ 
				x++; //Increment field counter
				$(wrapper).append(fieldHTML); //Add field html
			}
		});
	

    //Once add button is clicked
    $(addButton).click(function(){
        //Check maximum number of input fields
        if(x < maxField){ 
            x++; //Increment field counter
            $(wrapper).append(fieldHTML); //Add field html
        }
    });
    
    //Once remove button is clicked
    $(wrapper).on('click', '.remove_button', function(e){
        e.preventDefault();
        $(this).parent('div').remove(); //Remove field html
        x--; //Decrement field counter
    });


});