$(document).ready(function() {
	/* Search */
	$('.button-search').bind('click', function() {
		url = $('base').attr('href') + 'index.php?route=product/search';
				 
		var filter_name = $('input[name=\'search\']').attr('value');
		
		if (filter_name) {
			url += '&search=' + encodeURIComponent(filter_name);
		}
		
		location = url;
	});

	$('#header input[name=\'search\']').bind('keydown', function(e) {
		if (e.keyCode == 13) {
			url = $('base').attr('href') + 'index.php?route=product/search';
			 
			var filter_name = $('input[name=\'search\']').attr('value');
			
			if (filter_name) {
				url += '&search=' + encodeURIComponent(filter_name);
			}
			
			location = url;
		}
	});

	/* Sidebar Search */
	$('.button-sidebarsearch').bind('click', function() {
		url = $('base').attr('href') + 'index.php?route=product/search';
				 
		var filter_name = $('input[name=\'sidebarsearch_name\']').attr('value');
		
		if (filter_name) {
			url += '&search=' + encodeURIComponent(filter_name);
		}

			var filter_category_id = $('select[name=\'filter_category_id\']').attr('value');
	
			if (filter_category_id > 0) {
				url += '&search=' + encodeURIComponent(filter_category_id);
			}
	
			var filter_sub_category = $('input[name=\'filter_sub_category\']:checked').attr('value');
	
			if (filter_sub_category) {
				url += '&search=true';
			}
		
			var filter_description = $('input[name=\'filter_description\']:checked').attr('value');
	
			if (filter_description) {
				url += '&search=true';
			}
		
		location = url;
	});
	
	$('input[name=\'sidebarsearch_name\']').bind('keydown', function(e) {
		if (e.keyCode == 13) {
			url = $('base').attr('href') + 'index.php?route=product/search';
			 
			var filter_name = $('input[name=\'sidebarsearch_name\']').attr('value');
			
			if (filter_name) {
				url += '&search=' + encodeURIComponent(filter_name);
			}
			
			var filter_category_id = $('select[name=\'filter_category_id\']').attr('value');
	
			if (filter_category_id > 0) {
				url += '&search=' + encodeURIComponent(filter_category_id);
			}
	
			var filter_sub_category = $('input[name=\'filter_sub_category\']:checked').attr('value');
	
			if (filter_sub_category) {
				url += '&search=true';
			}
		
			var filter_description = $('input[name=\'filter_description\']:checked').attr('value');
	
			if (filter_description) {
				url += '&search=true';
			}
			
			location = url;
		}
	});
		
	/* Ajax Cart */
	$('#cart > .heading a').live('click', function() {
		$('#cart').addClass('active');
		
		$('#cart').load('index.php?route=module/cart #cart > *');
		
		$('#cart').live('mouseleave', function() {
			$(this).removeClass('active');
		});
	});
	
	/* Mega Menu */
	$('#menu ul > li > a + div').each(function(index, element) {
		// IE6 & IE7 Fixes
		if ($.browser.msie && ($.browser.version == 7 || $.browser.version == 6)) {
			var category = $(element).find('a');
			var columns = $(element).find('ul').length;
			
			$(element).css('width', (columns * 143) + 'px');
			$(element).find('ul').css('float', 'left');
		}		
		
		var menu = $('#menu').offset();
		var dropdown = $(this).parent().offset();
		
		i = (dropdown.left + $(this).outerWidth()) - (menu.left + $('#menu').outerWidth());
		
		if (i > 0) {
			$(this).css('margin-left', '-' + (i + 5) + 'px');
		}
	});

	// IE6 & IE7 Fixes
	if ($.browser.msie) {
		if ($.browser.version <= 6) {
			$('#column-left + #column-right + #content, #column-left + #content').css('margin-left', '195px');
			
			$('#column-right + #content').css('margin-right', '195px');
		
			$('.box-category ul li a.active + ul').css('display', 'block');	
		}
		
		if ($.browser.version <= 7) {
			$('#menu > ul > li').bind('mouseover', function() {
				$(this).addClass('active');
			});
				
			$('#menu > ul > li').bind('mouseout', function() {
				$(this).removeClass('active');
			});	
		}
	}
	
	$('.success img, .warning img, .attention img, .information img').live('click', function() {
		$(this).parent().fadeOut('slow', function() {
			$(this).remove();
		});
	});	
});

function addToCart(product_id, quantity) {
	quantity = typeof(quantity) != 'undefined' ? quantity : 1;

	$.ajax({
		url: 'index.php?route=checkout/cart/add',
		type: 'post',
		data: 'product_id=' + product_id + '&quantity=' + quantity,
		dataType: 'json',
		success: function(json) {
			$('.success, .warning, .attention, .information, .error').remove();
			
			if (json['redirect']) {
				location = json['redirect'];
			}
			
			if (json['success']) {
				$('#notification').html('<div class="success" style="display: none;">' + json['success'] + '<img src="catalog/view/theme/default/image/close.png" alt="" class="close-cam" /></div>');
				
				$('.success').fadeIn('slow');
				
				$('#cart-total').html(json['total']);
				
				$('html, body').animate({ scrollTop: 0 }, 'slow'); 
			}	
		}
	});
}
function addToWishList(product_id,image_url,href,model) {
	$.ajax({
		url: 'index.php?route=account/wishlist/add',
		type: 'post',
		data: 'product_id=' + product_id,
		dataType: 'json',
		success: function(json) {
            if($("#fav-item-1").length == 0){
                $("#fav-place-1").append(""+
                    "<div id='fav-item-1' data-wish-product-id='"+product_id+"'>"+
                    "<a onclick='removeWish("+product_id+")'  style='float: right;margin-top: 70px;'><img src='catalog/view/icons/remove-icon.png' width='30' height='30' /></a>"+
                    "<img src='"+image_url+"' width='150' height='170'  style='float: right;width: 110px;height: 130px;'/>"+
                    "<a href='"+href+"' style='float: right;margin-top: 70px;'><span>"+model+"</span></a>"+
                    "</div>"
                )
            }else if($("#fav-item-2").length == 0){
                $("#fav-place-2").append(""+
                    "<div id='fav-item-2' data-wish-product-id='"+product_id+"'>"+
                    "<a onclick='removeWish("+product_id+")'  style='float: left;margin-top: 70px;'><img src='catalog/view/icons/remove-icon.png' width='30' height='30' /></a>"+
                    "<img src='"+image_url+"' width='150' height='170'  style='float: left;width: 110px;height: 130px;'/>"+
                    "<a href='"+href+"' style='float: left;margin-top: 70px;'><span>"+model+"</span></a>"+
                    "</div>"
                )
            }else if($("#fav-item-3").length == 0){
                $("#fav-place-3").append(""+
                    "<div id='fav-item-3' data-wish-product-id='"+product_id+"'>"+
                    "<a onclick='removeWish("+product_id+")'  style='float: right;margin-top: 70px;'><img src='catalog/view/icons/remove-icon.png' width='30' height='30' /></a>"+
                    "<img src='"+image_url+"' width='150' height='170'  style='float: right;width: 110px;height: 130px;'/>"+
                    "<a href='"+href+"' style='float: right;margin-top: 70px;'><span>"+model+"</span></a>"+
                    "</div>"
                )
            }else if($("#fav-item-4").length == 0){
                $("#fav-place-4").append(""+
                    "<div id='fav-item-4' data-wish-product-id='"+product_id+"'>"+
                    "<a onclick='removeWish("+product_id+")'  style='float: left;margin-top: 70px;'><img src='catalog/view/icons/remove-icon.png' width='30' height='30' /></a>"+
                    "<img src='"+image_url+"' width='150' height='170'  style='float: left;width: 110px;height: 130px;'/>"+
                    "<a href='"+href+"' style='float: left;margin-top: 70px;'><span>"+model+"</span></a>"+
                    "</div>"
                )
            }

            $("#favorite-badge").html(json['total']);


            if(json['shifted'])
            {
                $("#fav-place-1").html($("#fav-place-2").html().replace(/float: left;/g, "float: right;"));
                $("#fav-place-2").html($("#fav-place-3").html().replace(/float: right;/g, "float: left;"));
                $("#fav-place-3").html($("#fav-place-4").html().replace(/float: left;/g, "float: right;"));
                $("#fav-place-4").html(""+
                    "<div id='fav-item-4' data-wish-product-id='"+product_id+"'>"+
                    "<a onclick='removeWish("+product_id+")'  style='float: left;margin-top: 70px;'><img src='catalog/view/icons/remove-icon.png' width='30' height='30' /></a>"+
                    "<img src='"+image_url+"' width='150' height='170'  style='float: left;width: 110px;height: 130px;'/>"+
                    "<a href='"+href+"' style='float: left;margin-top: 70px;'><span>"+model+"</span></a>"+
                    "</div>"
                )
                var rcomparid = '#r-' + $(".compareDiv ul li:first").attr('crid');
                var acomparid = '#a-' + $(".compareDiv ul li:first").attr('crid');
                $(rcomparid).hide();
                $(acomparid).show();
                $(".compareDiv ul li:first").remove();
            }
		}
	});
}
function addToCompare(product_id,image_url,href,model) {
	$.ajax({
		url: 'index.php?route=product/compare/add',
		type: 'post',
		data: 'product_id=' + product_id,
		dataType: 'json',
		success: function(json) {
			if (json['success']) {
				if($("#compare-item-1").length == 0){
					$("#compare-place-1").append(""+
						"<div id='compare-item-1' data-compare-product-id='"+product_id+"'>"+
						"<a onclick='removeCompare("+product_id+")'  style='float: right;margin-top: 70px;'><img src='catalog/view/icons/remove-icon.png' width='30' height='30' /></a>"+
						"<img src='"+image_url+"' width='150' height='170'  style='float: right;width: 110px;height: 130px;'/>"+
						"<a href='"+href+"' style='float: right;margin-top: 70px;'><span>"+model+"</span></a>"+
						"</div>"
					)
				}else if($("#compare-item-2").length == 0){
					$("#compare-place-2").append(""+
						"<div id='compare-item-2' data-compare-product-id='"+product_id+"'>"+
						"<a onclick='removeCompare("+product_id+")'  style='float: left;margin-top: 70px;'><img src='catalog/view/icons/remove-icon.png' width='30' height='30' /></a>"+
						"<img src='"+image_url+"' width='150' height='170'  style='float: left;width: 110px;height: 130px;'/>"+
						"<a href='"+href+"' style='float: left;margin-top: 70px;'><span>"+model+"</span></a>"+
						"</div>"
					)
				}else if($("#compare-item-3").length == 0){
					$("#compare-place-3").append(""+
						"<div id='compare-item-3' data-compare-product-id='"+product_id+"'>"+
						"<a onclick='removeCompare("+product_id+")'  style='float: right;margin-top: 70px;'><img src='catalog/view/icons/remove-icon.png' width='30' height='30' /></a>"+
						"<img src='"+image_url+"' width='150' height='170'  style='float: right;width: 110px;height: 130px;'/>"+
						"<a href='"+href+"' style='float: right;margin-top: 70px;'><span>"+model+"</span></a>"+
						"</div>"
					)
				}else if($("#compare-item-4").length == 0){
					$("#compare-place-4").append(""+
						"<div id='compare-item-4' data-compare-product-id='"+product_id+"'>"+
						"<a onclick='removeCompare("+product_id+")'  style='float: left;margin-top: 70px;'><img src='catalog/view/icons/remove-icon.png' width='30' height='30' /></a>"+
						"<img src='"+image_url+"' width='150' height='170'  style='float: left;width: 110px;height: 130px;'/>"+
						"<a href='"+href+"' style='float: left;margin-top: 70px;'><span>"+model+"</span></a>"+
						"</div>"
					)
				}

				$("#compare-badge").html(json['total']);

				$('.compareDiv ul').append('<li id="cmp'+product_id+'" crid="'+product_id+'" ><img align="center" width="50" height="50" src="'+image_url+'" />' + '<img onclick="removeCompare('+product_id+')" src="catalog/view/theme/default/image/close.png" alt="" class="close-cam" /></li>');

				$('.compare-total').html(json['total']);

                if(json['shifted'])
                {
					$("#compare-place-1").html($("#compare-place-2").html().replace(/float: left;/g, "float: right;"));
					$("#compare-place-2").html($("#compare-place-3").html().replace(/float: right;/g, "float: left;"));
					$("#compare-place-3").html($("#compare-place-4").html().replace(/float: left;/g, "float: right;"));
					$("#compare-place-4").html(""+
						"<div id='compare-item-4' data-compare-product-id='"+product_id+"'>"+
						"<a onclick='removeCompare("+product_id+")'  style='float: left;margin-top: 70px;'><img src='catalog/view/icons/remove-icon.png' width='30' height='30' /></a>"+
						"<img src='"+image_url+"' width='150' height='170'  style='float: left;width: 110px;height: 130px;'/>"+
						"<a href='"+href+"' style='float: left;margin-top: 70px;'><span>"+model+"</span></a>"+
						"</div>"
					)
                    var rcomparid = '#r-' + $(".compareDiv ul li:first").attr('crid');
                    var acomparid = '#a-' + $(".compareDiv ul li:first").attr('crid');
                    $(rcomparid).hide();
                    $(acomparid).show();
                    $(".compareDiv ul li:first").remove();
                }
			}else if(json['error']){
				$("#a-"+product_id).css("display","block");
				$("#r-"+product_id).css("display","none");
				swal({
					title:json['error'],
					text:"آیا تمایل به حذف کالاهای موجود در سبد مقایسه دارید؟",
					type: "warning",
					showCancelButton: true,
					confirmButtonColor: "#DD6B55",
					confirmButtonText: "حدف کالاهای موجود در سبد مقایسه" + " و افزودن کالای جدید به سبد مقایسه",
					closeOnConfirm: false
				},
					function(){
						var quantity = $(".compareDiv ul li").size();
						for(var i=0;i<quantity;i++){
							var rcomparid = '#r-' + $(".compareDiv ul li:first").attr('crid');
							var acomparid = '#a-' + $(".compareDiv ul li:first").attr('crid');
							$(rcomparid).hide();
							$(acomparid).show();
							$(".compareDiv ul li:first").remove();
						}
						$.ajax({
							url: 'index.php?route=product/compare/removeAndAdd',
							type: 'post',
							data: 'product_id=' + product_id,
							dataType: 'json',
							success: function(json) {
								if (json['success']) {
									$("#compare-place-1").html(" ");
									$("#compare-place-2").html(" ");
									$("#compare-place-3").html(" ");
									$("#compare-place-4").html(" ");
									$("#compare-place-1").html(""+
										"<div id='compare-item-4' data-compare-product-id='"+product_id+"'>"+
										"<a onclick='removeCompare("+product_id+")'  style='float: right;margin-top: 70px;'><img src='catalog/view/icons/remove-icon.png' width='30' height='30' /></a>"+
										"<img src='"+image_url+"' width='150' height='170'  style='float: right;width: 110px;height: 130px;'/>"+
										"<a href='"+href+"' style='float: right;margin-top: 70px;'><span>"+model+"</span></a>"+
										"</div>"
									)
									$("#compare-badge").html("1");
									swal("اضافه گردید", "کالای مورد نظر شما به سبد مقایسه اضافه گردید", "success");
								}else if(json['error']){
									swal("خطا", "خطایی رخ داده است")
								}
							}
						});
					}
				);
				//alert(json['error']);
			}
		}
	});
}
function removeCompare(product_id) {
    $.ajax({
        url: 'index.php?route=product/compare/remove&remove='+product_id,
        type: 'get',
        dataType: 'json',
        success: function(json) {
            if (json['success']) {
                id="#cmp"+product_id;
                $(id).remove();
                $('.compare-total').html(json['total']);
                    var rcomparid = '#r-' + product_id;
                    var acomparid = '#a-' + product_id;
                    $(rcomparid).hide();
                    $(acomparid).show();
				$("#compare-badge").html(json['total']);
				location.reload();
            }
        }
    });
}
function removeWish(product_id) {
	$.ajax({
		url: 'index.php?route=account/wishlist/remove&remove='+product_id,
		type: 'get',
		dataType: 'json',
		success: function(json) {
			if (json['success']) {
				id="#cmp"+product_id;
				$(id).remove();
				$('.compare-total').html(json['total']);
				var rcomparid = '#r-' + product_id;
				var acomparid = '#a-' + product_id;
				$(rcomparid).hide();
				$(acomparid).show();
				$("#favorite-badge").html(json['total']);
                location.reload();
			}
		}
	});
}