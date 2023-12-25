
"use strict"; 

$(document).ready(function() {
	//"use strict";
	if($('#currency_datable').length > 0){
		$('#currency_datable').DataTable({
			responsive: true
		});
	}
	
	if($('#special_offer_datable').length > 0){
		$('#special_offer_datable').DataTable({
			responsive: true
		});
	}

	if($('#room-table').length > 0){		
		$('#room-table').DataTable({
			responsive: true,
		});
	}

	if($('#roomtypeTable').length > 0){
		$('#roomtypeTable').DataTable({
			responsive: true
		});
	}

	if($('#room-capacity').length > 0){
		$('#room-capacity').DataTable({
			responsive: true
		});
	}

	if($('#block-table').length > 0){
		$('#block-table').DataTable({
			responsive: true
		});
	}

	if($('#room_table').length > 0){
		$('#room_table').DataTable({
			responsive: true
		});
	}

	if($('#customer_table').length > 0){
		$('#customer_table').DataTable({
			responsive: true
		});
	}

	if($('#client_booking_list').length > 0){
		$('#client_booking_list').DataTable({
			responsive: true
		});
	}


	$('#roomtypeTable').delegate('#delete_roomtype', 'click', function(){
		var roomtype_id = $(this).attr('data-id');  
		lnv.confirm({
			title: 'Confirm',
			content: 'Are you sure you want to delete this roomtype ?',
			confirmBtnText: 'Yes',
			confirmHandler: function(){
				$.ajax({
					type: 'POST',
					url: base +'rest/delete_roomtype',
					data: {roomtype_id : roomtype_id},
					dataType  : 'json',
					success: function(response){
						if(response.type == "success"){
							 $("#roomtypeTable").load(location.href + " #roomtypeTable");
							 $('#AjaxResponse').html('<div class="alert alert-success alert-dismissable alert-style-1"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="zmdi zmdi-check"></i>'+response.message+'</div>');
						 }else{
							 $('#AjaxResponse').html('<div class="alert alert-info alert-dismissable alert-style-1"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="zmdi zmdi-info-outline"></i>'+response.message+'</div>');
						 }
					}
				}); 				
			},
			cancelBtnText: 'No',
			cancelHandler: function(){
		
			}
		})	
	});
	
	
	$('#room-table').delegate('#delete_room', 'click', function(){
		var roomtype_id = $(this).attr('data-rid'); 
		var capacity_id = $(this).attr('data-cid'); 
		lnv.confirm({
			title: 'Confirm',
			content: 'Are you sure you want to delete this room ?',
			confirmBtnText: 'Yes',
			confirmHandler: function(){
				$.ajax({
					type: 'POST',
					url: base +'rest/delete_room',
					data: {roomtype_id : roomtype_id, capacity_id : capacity_id},
					dataType  : 'json',
					success: function(response){
						if(response.type == "success"){
							 $("#room-table").load(location.href + " #room-table");
							 $('#AjaxResponse').html('<div class="alert alert-success alert-dismissable alert-style-1"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="zmdi zmdi-check"></i>'+response.message+'</div>');
						 }else{
							 $('#AjaxResponse').html('<div class="alert alert-info alert-dismissable alert-style-1"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="zmdi zmdi-info-outline"></i>'+response.message+'</div>');
						 }
					}
				}); 		
			},
			cancelBtnText: 'No',
			cancelHandler: function(){
		
			}
		})	
	});

	$('#special_offer_datable').delegate('#delete_special_offer', 'click', function(){
		var special_offer_id = $(this).attr('data-id'); 
		lnv.confirm({
			title: 'Confirm',
			content: 'Are you sure you want to delete this special_offer ?',
			confirmBtnText: 'Yes',
			confirmHandler: function(){
				$.ajax({
					type: 'POST',
					url: base +'rest/delete_special_offer',
					data: {special_offer_id : special_offer_id},
					dataType  : 'json',
					success: function(response){
						if(response.type == "success"){
							 $("#special_offer_datable").load(location.href + " #special_offer_datable");
							 $('#AjaxResponse').html('<div class="alert alert-success alert-dismissable alert-style-1"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="zmdi zmdi-check"></i>'+response.message+'</div>');
						 }else{
							 $('#AjaxResponse').html('<div class="alert alert-info alert-dismissable alert-style-1"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="zmdi zmdi-info-outline"></i>'+response.message+'</div>');
						 }
					}
				}); 		
			},
			cancelBtnText: 'No',
			cancelHandler: function(){
		
			}
		})
	});

	$('#currency_datable').delegate('#delete_currency', 'click', function(){
		var currency_id = $(this).attr('data-id'); 
		lnv.confirm({
			title: 'Confirm',
			content: 'Are you sure you want to delete this currency ?',
			confirmBtnText: 'Yes',
			confirmHandler: function(){
				$.ajax({
					type: 'POST',
					url: base +'rest/delete_currency',
					data: {currency_id : currency_id},
					dataType  : 'json',
					beforeSend: function() {
						$(".page-overlay").addClass('is-loading');
					},
					success: function(response){
						if(response.type == "success"){
							setTimeout(function(){
								$(".page-overlay").removeClass('is-loading');
						    },1000);
							$("#currency_datable").load(location.href + " #currency_datable");
							$('#AjaxResponse').html('<div class="alert alert-success alert-dismissable alert-style-1"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="zmdi zmdi-check"></i>'+response.message+'</div>');
						}else{
							$('#AjaxResponse').html('<div class="alert alert-info alert-dismissable alert-style-1"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="zmdi zmdi-info-outline"></i>'+response.message+'</div>');
						}
					}
				}); 				
			},
			cancelBtnText: 'No',
			cancelHandler: function(){
		
			}
		})
	});


	$('#price_plan_updator').delegate('#delete_price_plan', 'click', function(){
		 var price_plan_id = $(this).attr('data-id'); 
		 lnv.confirm({
			title: 'Confirm',
			content: 'Are you sure you want to delete this price plan ?',
			confirmBtnText: 'Yes',
			confirmHandler: function(){
				$.ajax({
					type: 'POST',
					url: base +'rest/delete_price_plan',
					data: {price_plan_id : price_plan_id},
					dataType  : 'json',
					success: function(response){
						if(response.type == "success"){
							 location.reload();
						 }
					}
				}); 
			},
			cancelBtnText: 'No',
			cancelHandler: function(){
		
			}
		})
	});

	$('#room-capacity').delegate('#delete_capacity', 'click', function(){
		var capacity_id = $(this).attr('data-id'); 
		lnv.confirm({
		   title: 'Confirm',
		   content: 'Are you sure you want to delete this?',
		   confirmBtnText: 'Yes',
		   confirmHandler: function(){
			   $.ajax({
				   type: 'POST',
				   url: base +'rest/delete_capacity',
				   data: {capacity_id : capacity_id},
				   dataType  : 'json',
				   success: function(response){
					   if(response.type == "success"){
							location.reload();
						}
				   }
			   }); 
		   },
		   cancelBtnText: 'No',
		   cancelHandler: function(){
	   
		   }
	   })
   });

	$("#save_roomtype").click( function() {
		var roomtype_title = $("#roomtype_title").val();
		var description    = $("#description").val();
		if(roomtype_title.length > 0 && description.length){
			$('#errors').html('');
			$.ajax({
				type: 'POST',
				url: base +'rest/create_roomtype',
				data: {roomtype_title : roomtype_title, description : description},
				dataType  : 'json',
				success: function(response){
					if(response.type == "success"){
						$('#roomTypeForm')[0].reset();
						$('#roomTypeModal').modal('hide');
						$("#roomtypeTable").load(location.href + " #roomtypeTable");
						$('#AjaxResponse').html('<div class="alert alert-success alert-dismissable alert-style-1"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="zmdi zmdi-check"></i>'+response.message+'</div>');
					 }
				}
			}); 
		}else{
			$('#errors').html('<div class="alert alert-info alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> You must fill in all of the fields</div>');
		}
	});

	$("#save_capacity").click( function() {
		var capacity_title = $("#capacity_title").val();
		var no_adult       = $("#no_adult").val();
		if(capacity_title.length > 0 && no_adult.length){
			$('#errors').html('');
			$.ajax({
				type: 'POST',
				url: base +'rest/create_capacity',
				data: {capacity_title : capacity_title, no_adult : no_adult},
				dataType  : 'json',
				success: function(response){
					if(response.type == "success"){
						$('#capacityForm')[0].reset();
						$('#capacityeModal').modal('hide');
						$("#room-capacity'").load(location.href + " #room-capacity'");
						$('#AjaxResponse').html('<div class="alert alert-success alert-dismissable alert-style-1"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="zmdi zmdi-check"></i>'+response.message+'</div>');
					 }
				}
			}); 
		}else{
			$('#errors').html('<div class="alert alert-info alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> You must fill in all of the fields</div>');
		}
	});

	$("#save_currency").click( function() {
		var currency_code = $("#currency_code").val();
		var currency_symbol = $("#currency_symbol").val();
		var exchange_rate = $("#exchange_rate").val();
		var default_currency = ($('#default_currency').is(":checked")) ? 1 : 0;
		if(currency_symbol.length > 0 && currency_code.length > 0 && exchange_rate.length > 0 ){
			$('#errors').html('');
			$.ajax({
				type: 'POST',
				url: base +'rest/create_currency',
				data: {currency_code : currency_code, currency_symbol : currency_symbol, exchange_rate : exchange_rate, default_currency : default_currency},
				dataType  : 'json',
				beforeSend: function() {
					$(".page-overlay").addClass('is-loading');
				},
				success: function(response){
					if(response.type == "success"){
					  setTimeout(function(){
							$(".page-overlay").removeClass('is-loading');
					  },1000);

						 $('#currencyForm')[0].reset();
						 $('#myModal').modal('hide');
						 $("#currency_datable").load(location.href + " #currency_datable");
						 $('#AjaxResponse').html('<div class="alert alert-success alert-dismissable alert-style-1"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="zmdi zmdi-check"></i>'+response.message+'</div>');
					 }
				}
			}); 
		}else{
			 $('#errors').html('<div class="alert alert-info alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>You must fill in all of the fields</div>');
		}
	});

	$("#update_currency").click( function() {
		var currency_code = $("#currency_code").val();
		var api_key =  "ceea9ef777d049829a87f2974b25a746";
		if(currency_code.length > 0){
			$('#errors').html('');
			$.ajax({
				type: 'GET',
				url: 'https://openexchangerates.org/api/latest.json?app_id='+api_key,
				dataType  : 'json',
				success: function(response){
					for (var i in response.rates) {
						if (response.rates.hasOwnProperty(i)) {
							if(currency_code == i){
								$("#exchange_rate").val(response.rates[i])
							}
					   }
					}     		 
				}
			});
		}else{
			$('#errors').html('<div class="alert alert-info alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Currency code is required</div>');
		}
	});

	if($('#roomtype').val() == 0){
		$('#price_plan_updator').html('<div class="alert alert-info alert-dismissable alert-style-1"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="zmdi zmdi-info-outline"></i>Please Select Room Type First!</div>');
	}
	
	$('#roomtype').change(function() { 
		if($('#roomtype').val() == 0){
			$('#price_plan_updator').html('<div class="alert alert-info alert-dismissable alert-style-1"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="zmdi zmdi-info-outline"></i>Please Select Room Type First!</div>');
		}
		var roomtype_id = $('#roomtype').val();
		$.ajax({
			type: 'POST',
			url: base +'rest/get_price_plan_list',
			data: {roomtype_id : roomtype_id},
			dataType  : 'json',
			beforeSend: function() {
				$(".page-overlay").addClass('is-loading');
			},			
			success: function(response){
				if(response.errorcode == 0){ 
					setTimeout(function(){
						$(".page-overlay").removeClass('is-loading');
					},500);
					$('#price_plan_updator').html(response.strhtml)
				}else{
					$('#price_plan_updator').html('<div class="alert alert-info alert-dismissable alert-style-1"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="zmdi zmdi-info-outline"></i>No available data found!</div>');
					$(".page-overlay").removeClass('is-loading');
				}
			}
		}); 

	 });

	 $('#roomtype_id').change(function() {
		var roomtype_id =  $('#roomtype_id').val();
		if($('#roomtype_id').val() != 0){
			$.ajax({
				type: 'POST',
				url: base +'rest/get_default_capacity',
				data: {roomtype_id : roomtype_id},
				dataType  : 'json',
				beforeSend: function() {
					$(".page-overlay").addClass('is-loading');
				},	
				success: function(response){
					if(response.errorcode == 0){ 
						setTimeout(function(){
							$(".page-overlay").removeClass('is-loading');
						},500);
						$('#price_plan_updator').html(response.strhtml)
					}else{
						$('#price_plan_updator').html('<div class="alert alert-info alert-dismissable alert-style-1"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="zmdi zmdi-info-outline"></i>No available data found!</div>');
					}
				}
			}); 
		}
	 });

	// $('#room_gallery').change(function(){
	// 	var room_gallery_id =  $('#room_gallery').val();
	// 	if($('#room_gallery').val() != 0){
	// 		console.log(room_gallery_id);
	// 	}
	// });

	if($('#startdate').length > 0){
		$('#startdate').datetimepicker({
			format: 'L',
			minDate : moment().subtract(0, 'days')
		});

		$("#startdate").on("change.datetimepicker", function (e) {
			$('#closingdate').datetimepicker('minDate', e.date);
        });
	}

	if($('#closingdate').length > 0){
		$('#closingdate').datetimepicker({
			format: 'L',
			minDate : moment().subtract(0, 'days'),
			useCurrent: false
		});

		$("#closingdate").on("change.datetimepicker", function (e) {
			$('#startdate').datetimepicker('maxDate', e.date);
        });
	}

	
	if($('#startdate').length > 0){
		$('#startdate').datetimepicker({
			format: 'L',
			minDate : moment().subtract(0, 'days')
		});

		$("#startdate").on("change.datetimepicker", function (e) {
			$('#closingdate').datetimepicker('minDate', e.date);
        });
	}


	if($('#start_date').length > 0){
		$('#start_date').datetimepicker({
			format: 'L'
		});
	}

	if($('#closing_date').length > 0){
		$('#closing_date').datetimepicker({
			format: 'L',
		});
	}
	
	if($('#blockstartdate').length > 0){
		$('#blockstartdate').datetimepicker({
			format: 'L',
			minDate : moment().subtract(0, 'days')
		});
				
		$("#blockstartdate").on("change.datetimepicker", function (e) {
			$('#blockclosingdate').datetimepicker('minDate', e.date);;
    });
	}

	if($('#blockclosingdate').length > 0){
		$('#blockclosingdate').datetimepicker({
			format: 'L',
			minDate : moment().subtract(0, 'days'),
			useCurrent: false
		});

		$("#blockclosingdate").on("change.datetimepicker", function (e) {
			$('#blockstartdate').datetimepicker('maxDate', e.date);
        });
	}

	if($('#startdatebooking').length > 0){
		$('#startdatebooking').datetimepicker({
			format: 'L'
		});
	}

	if($('#closingdatebooking').length > 0){
		$('#closingdatebooking').datetimepicker({
			format: 'L'
		});
	}

	if($('#room_image').length > 0){
		$('#room_image').orakuploader({
			site_url :  base ,
			orakuploader_path : 'assets/orakuploader/',
			orakuploader_main_path : 'assets/images/rooms',
			orakuploader_thumbnail_path : 'assets/images/rooms/thumbnail',
			orakuploader_add_label : "Upload Images",
			orakuploader_add_image : base+'assets/orakuploader/images/add.svg',
			orakuploader_use_main : true,
			orakuploader_use_sortable : true,
			orakuploader_use_dragndrop : true,
			orakuploader_use_rotation: true,
			//orakuploader_resize_to : 800,
			//orakuploader_thumbnail_size  : 250,
			orakuploader_maximum_uploads : 5,
			//orakuploader_max_exceeded : max_image_upload,
			orakuploader_hide_on_exceed : true,
			orakuploader_resize_to : 600,
			orakuploader_thumbnail_size : 150,
			orakuploader_main_changed    : function (filename) {
				$("#mainlabel-images").remove();
				$("div").find("[filename='" + filename + "']").append("<div id='mainlabel-images' class='maintext'>Main Image</div>");
			},
			orakuploader_max_exceeded : function() {
				lnv.alert({
					title: 'Hold on!',
					alertBtnText: 'Ok',
					content: 'You exceeded the max. limit of 5 images!'
		    });  
			}
		});
	}

	$('#room_gallery').change(function(){
		if( $(".image-container").length > 0){
			$(".image-container").html("");
		}
		if($('#room_gallery').val() != "0"){
			var room_cap_id = $('#room_gallery').val();
			var $images = "";
			var $imagesCount = 0;
			var $screen2 = [];
			var $maxImgLength = 3;

			$.ajax({
				type: 'GET',
				url: base +'rest/get_capacity',
				dataType  : 'json',
				cache: false,
				data: {room_cap_id : room_cap_id},
				beforeSend: function() {
					$(".page-overlay").addClass('is-loading');
				},	
				success: function(response){
					if(response.message.capacity){
						setTimeout(function(){
							$(".page-overlay").removeClass('is-loading');
					  },1000);

						$images = response.message.capacity.img_path.split(",");  
						for(var i = 0; i < $images.length; i++) {
							// console.log($images[i]);
							$(".image-container").append('<div class="col-md-3"><li class="mkdf-blog-slider-item"><div class="mkdf-blog-slider-item-inner"><div class="mkdf-item-image"><img src="'+base+'assets/images/rooms/'+$images[i]+'" class="img-responsive gallery-images" sizes="(max-width: 172px) 100vw, 172px" width="172" height="172"></div><div class="mkdf-post-info-bottom clearfix"> <div class="mkdf-post-read-more-button"><a  href="javascript:void(0)" data-id="'+response.message.capacity.pic_id+'" data-name="'+$images[i]+'" class="mkdf-btn mkdf-btn-medium mkdf-btn-simple mkdf-btn-icon mkdf-blog-list-button"><span class="mkdf-btn-text">Delete</span><span aria-hidden="true" class="mkdf-icon-font-elegant arrow_right "></span></a></div></div></div></li></div>');
            }
					}else{
						$('#AjaxResponse').html('<div class="alert alert-info alert-dismissable alert-style-1"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="zmdi zmdi-info-outline"></i>No available data found!</div>');
						setTimeout(function(){
							$(".page-overlay").removeClass('is-loading');
					  },1000);
					}
				}
			});
		}	
		if($('#room_gallery').val() == "0"){
			$('#AjaxResponse').html('<div class="alert alert-info alert-dismissable alert-style-1"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="zmdi zmdi-info-outline"></i>No available data found!</div>');
		}
	});

	$('.image-container').delegate('.mkdf-blog-list-button', 'click', function(){ 
		var picture_id   = $(this).attr('data-id'); 
		var picture_name = $(this).attr('data-name'); 
	
		lnv.confirm({
				title: 'Confirm',
				content: 'Are you sure you want to delete this image?',
				confirmBtnText: 'Yes',
				confirmHandler: function(){
					$.ajax({
						type: 'POST',
						url: base +'rest/delete_image',
						data: {picture_id : picture_id, picture_name : picture_name},
						dataType  : 'json',
						beforeSend: function() {
							$(".page-overlay").addClass('is-loading');
						},	
						success: function(response){
							if(response.type == "success"){
								setTimeout(function(){
									$(".page-overlay").removeClass('is-loading');
								},1000);
								location.reload();
								$('#AjaxResponse').html('<div class="alert alert-success alert-dismissable alert-style-1"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="zmdi zmdi-check"></i>'+response.message+'</div>');
							}
						}
					}); 
				},
				cancelBtnText: 'No',
				cancelHandler: function(){
			
				}
			})
	
	
	});

	$('#block-table').delegate('#unblock', 'click', function(){
		var booking_id = $(this).attr('data-bid'); 
		var roomtype_id = $(this).attr('data-rti'); 
		var capacity_id = $(this).attr('data-cid');

		lnv.confirm({
			title: 'Confirm',
			content: 'Are you sure you want to un-block this rooms?',
			confirmBtnText: 'Yes',
			confirmHandler: function(){		
				$.ajax({
					type: 'POST',
					url: base +'rest/unblock_rooms',
					data: {booking_id : booking_id, roomtype_id : roomtype_id, capacity_id : capacity_id},
					dataType  : 'json',
					success: function(response){
						if(response.type == "success"){
							$("#block-table").load(location.href + " #block-table");
							$('#AjaxResponse').html('<div class="alert alert-success alert-dismissable alert-style-1"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="zmdi zmdi-check"></i>'+response.message+'</div>');
						 }
					}
				});
			},
			cancelBtnText: 'No',
			cancelHandler: function(){
		
			}
		});

	});
	
	if($('.payment-switch').length > 0){
		var switchSelector = document.querySelector('.payment-switch');
		var switchery = new Switchery(switchSelector);
		$(switchSelector).on("change" , function(e) {
		 var status = switchSelector.value;
		 $.ajax({
			type: 'POST',
			url: base +'rest/advance_payment_switcher',
			data: {status : status},
			dataType  : 'json',
			beforeSend: function() {
				$(".page-overlay").addClass('is-loading');
			},	
			success: function(response){
				if(response.type == "success"){
					setTimeout(function(){
						$(".page-overlay").removeClass('is-loading');
					},1900);
					location.reload();
				}}
		 });

		});
	}
	
	$('#room_table').delegate('#delete_booking_room', 'click', function(){
		var booking_id = $(this).attr('data-id'); 
		lnv.confirm({
			title: 'Confirm',
			content: 'Are you sure you want to delete this booking?',
			confirmBtnText: 'Yes',
			confirmHandler: function(){		
				$.ajax({
					type: 'POST',
					url: base +'rest/delete_room_booking',
					data: {booking_id : booking_id},
					dataType  : 'json',
					beforeSend: function() {
						$(".page-overlay").addClass('is-loading');
					},	
					success: function(response){
						if(response.type == "success"){
							setTimeout(function(){
								$(".page-overlay").removeClass('is-loading');
							},1900);
							location.reload();
						}}
				 });
			},
			cancelBtnText: 'No',
			cancelHandler: function(){
		
			}
		});
	});

	$('#client_booking_list').delegate('#delete_booking_by_client', 'click', function(){
		var booking_id = $(this).attr('data-id'); 
		lnv.confirm({
			title: 'Confirm',
			content: 'Are you sure you want to delete this booking?',
			confirmBtnText: 'Yes',
			confirmHandler: function(){		
				$.ajax({
					type: 'POST',
					url: base +'rest/delete_room_booking',
					data: {booking_id : booking_id},
					dataType  : 'json',
					beforeSend: function() {
						$(".page-overlay").addClass('is-loading');
					},	
					success: function(response){
						if(response.type == "success"){
							setTimeout(function(){
								$(".page-overlay").removeClass('is-loading');
							},1900);
							location.reload();
						}}
				 });
			},
			cancelBtnText: 'No',
			cancelHandler: function(){
		
			}
		});
	});

	$('#room_table').delegate('#cancel_room', 'click', function(){
		var booking_id = $(this).attr('data-id'); 
		lnv.confirm({
			title: 'Confirm',
			content: 'Are you sure you want to cancel this booking?',
			confirmBtnText: 'Yes',
			confirmHandler: function(){		
				$.ajax({
					type: 'POST',
					url: base +'rest/cancel_room_booking',
					data: {booking_id : booking_id},
					dataType  : 'json',
					beforeSend: function() {
						$(".page-overlay").addClass('is-loading');
					},	
					success: function(response){
						if(response.type == "success"){
							setTimeout(function(){
								$(".page-overlay").removeClass('is-loading');
							},1900);
							location.reload();
						}}
				 });
			},
			cancelBtnText: 'No',
			cancelHandler: function(){
		
			}
		});
	});

	$('#client_booking_list').delegate('#cancel_room_by_client', 'click', function(){
		var booking_id = $(this).attr('data-id'); 
		lnv.confirm({
			title: 'Confirm',
			content: 'Are you sure you want to cancel this booking?',
			confirmBtnText: 'Yes',
			confirmHandler: function(){		
				$.ajax({
					type: 'POST',
					url: base +'rest/cancel_room_booking',
					data: {booking_id : booking_id},
					dataType  : 'json',
					beforeSend: function() {
						$(".page-overlay").addClass('is-loading');
					},	
					success: function(response){
						if(response.type == "success"){
							setTimeout(function(){
								$(".page-overlay").removeClass('is-loading');
							},1900);
							location.reload();
						}}
				 });
			},
			cancelBtnText: 'No',
			cancelHandler: function(){
		
			}
		});
	});

	if($('#booking_form_cp').length > 0){
		$("#booking_form_cp").validate();
	}

	$('.modal#view_booking_modal').on('hidden.bs.modal', function (e) {
		$(this).removeData();
		//$("#demo-1").html("");
  });

	if($('#view_single_booking').length > 0){
  	$('#room_table').delegate('#view_single_booking', 'click', function(){
			var booking_id = $(this).attr('data-id'); 
			$.ajax({
				type: 'GET',
				url: base +'rest/get_single_booking',
				data: {booking_id : booking_id},
				dataType  : 'json',
				success: function(response){
					if(response.type == "success"){
						$("#name").text(response.message.title + response.message.first_name + response.message.surname);
						$("#email").text(response.message.email);
						$("#phone").text(response.message.phone);
						$("#address").text(response.message.street_addr);
						$("#city").text(response.message.city);
						$("#country").text(response.message.country);
						$("#zip_code").text(response.message.zip);
					  $("#i_type").text(response.message.id_type);
					  $("#i_number").text(response.message.id_number);
						$("#ar").text(response.message.special_requests);
						$("#invoice").html(response.message.invoice);
						$('#view_booking_modal').modal('show');
					 }
				}
			});			
		});
	}

	$('#view_booking_modal').on('shown.bs.modal', function (e) {	
		$('#invoice_ws').hide();
		$("#showinfo").click( function(e) {
		 	$('#invoice_ws').slideToggle('slow');
		});
	})
	

});
