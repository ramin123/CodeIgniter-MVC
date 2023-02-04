// JavaScript Document
function fetch_more(url,offset,search)
{
	var token = '';
	if($('[name="system_csrf"]').length > 0)
	var token = document.tokenform.system_csrf.value;
	
	$.ajax({
		   type:'POST',
		   url:url,
		   data:'ajax=1&offset='+offset+'&system_csrf='+token+search,
		   success:function(data){
				   $('#content').html(data); 
		   }
		   });
}

function update_cost()
{
	var final_cost = 0;
	var addon_cost = 0;
	
	
	var item_id	   = 0;
	var item_cost  = 0;
	var item_option_price=0;
	
	
	var modl = "#addons-options-modal";
	
	item_id 	= $(""+modl+" #selected_item_id").val();
	item_cost 	= $(""+modl+" #selected_item_price").val();
	
	if($(''+modl+' input[name="item_option_id"]:checked').attr('data-val')) {
		
		item_option_price = parseFloat($(''+modl+' input[name="item_option_id"]:checked').attr('data-val'));
		
		item_cost = item_option_price;
	
	}
	
	
	$(''+modl+' .dm-add-qty input:checked').each(function() {
	
		addon_cost += parseFloat($(this).attr('data-val'));
	});

	
	final_cost = parseFloat(final_cost)+parseFloat(addon_cost)+parseFloat(item_cost);

	final_cost = (final_cost).toFixed(2);
	
	$('#hp_final_cost').html(final_cost);

}

function cart_update_cost()
{
	var final_cost = 0;
	var addon_cost = 0;
	
	
	var item_id	   = 0;
	var item_cost  = 0;
	var item_option_price=0;
	var itm_qty=1;
	
	
	var modl = "#addons-options-modal";
	
	item_id 	= $(""+modl+" #selected_item_id").val();
	item_cost 	= $(""+modl+" #selected_item_price").val();
	
	itm_qty 	= $(""+modl+" #itm_qty").val();
	
	if($(''+modl+' input[name="item_option_id"]:checked').attr('data-val')) {
		
		item_option_price = parseFloat($(''+modl+' input[name="item_option_id"]:checked').attr('data-val'));
		
		item_cost = item_option_price;
	
	}
	
	
	item_cost = item_cost*itm_qty;

	$(''+modl+' .dm-add-qty input:checked').each(function() {
	
		addon_cost += itm_qty*(parseFloat($(this).attr('data-val')));
	});
	
	
	final_cost = (final_cost + addon_cost + item_cost).toFixed(2);

	$('#hpp_final_cost').html(final_cost);
}


function update_qty(rowid,type) {
	
	if (rowid!='' && type!='') {
		
		var min = 0;
		var max = 99;
		
		var token = '';

		if($('[name="csrf_digi_name"]').length)
			token = document.getElementsByName('csrf_digi_name')[0].value;
		
		var targeturl = update_cart_target_url;
		
		$("body").addClass("ajax-load");

		$.post(targeturl, { rowid: rowid, type: type, csrf_digi_name: token, ajax: '1' },
			function(data) {
				
				$("body").removeClass("ajax-load");

				if (data>0) {
					
					load_cart_div();
					
					if (data!=9999) {
						$('#items_cnt').text(data);
					} else {
						$('#items_cnt').text(0);
					}
					
					message = "Item successfully updated to your cart";
					checkNotify('CART',message,'success');
						
				} else {	
					message = "Item has not updated";
					checkNotify('CART',message,'error');
				}
			}); 
	}
}


//UPDATE TO CART - POPUP - CUSTOMIZE
function updateToCart() {
	
	var message  = "";
	
	var itemFrom   = 'items';
	var item_id	   = 0;
	
	var item_option_id=0;
	var itm_qty=1;
	
	
	var addon_ids = [];
	
	var index = 0;
	
	
	var modl = "#addons-options-modal";
	
	item_id 	= $(""+modl+" #selected_item_id").val();
	
	itm_qty 	= $(""+modl+" #itm_qty").val();
	
	var rowid 	= $(""+modl+" #rowid").val();
	
	
	if($(''+modl+' input[name="item_option_id"]:checked')) {
			
		item_option_id = $(''+modl+' input[name="item_option_id"]:checked').val();
	}
	
	
	
	//Prepare Add-ons array
	$('.dm-add-qty input:checked').each(function() {
		
		addon_ids[index++] = $(this).attr('id');
	});
	
	
	
	
	if (rowid!='' && item_id>0 && item_option_id>=0 && itm_qty>0) {
	
	var token = '';

	if($('[name="csrf_digi_name"]').length)
		token = document.getElementsByName('csrf_digi_name')[0].value;
	
	var targeturl = add_cart_target_url;
	
	$("body").addClass("ajax-load");
	
	$.post(targeturl, { item_id: item_id, quantity: itm_qty, item_option_id: item_option_id, addon_ids: addon_ids, csrf_digi_name: token, ajax: '1',item_from:itemFrom,rowid:rowid },
		function(data) {

			$("body").removeClass("ajax-load");
			
		    if (data>0) {
				
				if( $('#addons-options-modal').hasClass('in') ) {
					$('#addons-options-modal').modal('hide');
				}
					
				load_cart_div();
				message = "Item successfully updated to your cart";
				checkNotify('CART',message,'success');
					
			} else {	
				message = "Item has not updated";
				checkNotify('CART',message,'error');
			}
		});  
	}
	else {
		message = "Invalid Operation";
		checkNotify('CART',message,'error');
	}
}





// ADD TO CART function
function addToCart(ref)
{
	var message  = "";
	
	
	var itemFrom   = 'items';
	var item_id	   = 0;
	var menu_id	   = 0;
	var item_cost  = 0;
	var item_option_price=0;
	var item_option_id=0;
	
	var addon_ids = [];

	var index = 0;
	
	if (ref>0) {
		
		var frm = "#item_form_"+ref+"";
		
		item_id 	= ref;
		/*menu_id		= $(""+frm+" #selected_menu_id").val();
		item_cost 	= $(""+frm+" #selected_item_cost").val();
		itemFrom    = $(""+frm+" #itemFrom").val();*/

		menu_id		= $(""+frm+" #selected_menu_id"+ref+"").val();
		item_cost 	= $(""+frm+" #selected_item_cost"+ref+"").val();
		itemFrom    = $(""+frm+" #itemFrom"+ref+"").val();
		
	} else {
		
		var modl = "#addons-options-modal";
	
		item_id 	= $(""+modl+" #selected_item_id").val();
		menu_id		= $(""+modl+" #selected_menu_id").val();
		item_cost 	= $(""+modl+" #selected_item_price").val();
		itemFrom    = $(""+modl+" #itemFrom").val();
		
		if($(''+modl+' input[name="item_option_id"]:checked').attr('data-val')) {
			
			item_option_price = parseFloat($(''+modl+' input[name="item_option_id"]:checked').attr('data-val'));
			
			item_option_id = $(''+modl+' input[name="item_option_id"]:checked').val();
		}
		
		
		//Prepare Add-ons array
		$('.dm-add-qty input:checked').each(function() {
			
			addon_ids[index++] = $(this).attr('id');
			
		});
	}
	
	
	var quantity=1;
	
	if (itemFrom!='' && item_id>0 && menu_id>0 && quantity>0 && item_option_id>=0) {
	
	var token = '';

	if($('[name="csrf_digi_name"]').length)
		token = document.getElementsByName('csrf_digi_name')[0].value;
	
	if(!quantity)
		quantity = 1;
	
	var targeturl = add_cart_target_url;
	
	// $(".main-wrapper").html('<img class="abs-loader" src="http://localhost/mn-restaurant/Menorah_Restaurant/assets/front/images/loader.gif" alt="Loader" align="middle">');
	
	$("body").addClass("ajax-load");
	
	$.post(targeturl, { item_id: item_id, quantity: quantity, item_option_id: item_option_id, addon_ids: addon_ids, csrf_digi_name: token, ajax: '1',item_from:itemFrom },
		function(data) {

			$("body").removeClass("ajax-load");
			
			if (data==999) {
				message = "Item already existed in Cart";
 				checkNotify('CART',message,'info');
				
			} else if (data!=999 && data>0) {

				if( $('#addons-options-modal').hasClass('in') ) {
					$('#addons-options-modal').modal('hide');
				}
				
				$('#items_cnt').text(data);
				
				load_cart_div();
				
			    message = "Item successfully added to your cart";
			    checkNotify('CART',message,'success');
				
 			} else if (data!=999 && data<=0) {
				
				message = "Item not added to your cart";
 				checkNotify('CART',message,'error');
				
			} else {

 				message = "Item does not exist";
 				checkNotify('CART',message,'error');
 			}
		});
	} else {
		message = "Invalid Operation";
 		checkNotify('CART',message,'error');
	}
		
}


function addOfferToCart() {
	
	var message  = "";
	
	var itemFrom   = '';
	var item_id	   = 0;
	var item_cost  = 0;
	
	var modl = "#offr-modal";
	
	item_id 	= $(""+modl+" #selected_offer_id").val();
	item_cost 	= $(""+modl+" #selected_offer_price").val();
	itemFrom    = $(""+modl+" #itemFrom").val();
		
	if (itemFrom=='offers' && item_id>0) {
		
		
		quantity = 1;
		
		var targeturl = add_cart_target_url;
		
		var token = '';

		if($('[name="csrf_digi_name"]').length)
			token = document.getElementsByName('csrf_digi_name')[0].value;
		
		$("body").addClass("ajax-load");

		$.post(targeturl, { item_id: item_id, quantity: quantity, csrf_digi_name: token, ajax: '1',item_from:itemFrom },
		
		function(data) {
			
			$("body").removeClass("ajax-load");

			if (data==999) {
				message = "Item already existed in Cart";
				checkNotify('CART',message,'info');
				
			} else if (data!=999 && data>0) {

				if( $('#offr-modal').hasClass('in') ) {
					$('#offr-modal').modal('hide');
				}
				
				$('#items_cnt').text(data);
				
				load_cart_div();
				
				message = "Item successfully added to your cart";
				checkNotify('CART',message,'success');
				
			} else if (data!=999 && data<=0) {
				
				message = "Item not added to your cart";
				checkNotify('CART',message,'error');
				
			} else {

				message = "Item does not exist";
				checkNotify('CART',message,'error');
			}
		});
	} else {
		message = "Invalid Operation";
 		checkNotify('CART',message,'error');
	}
}


//type='decr/incr', id='id_rowid', qty, offers/''
function update_cart(type, id, qty,itemFrom='')
{
	
	var qty_ref = ('#'+id);//quantity id
	
	var qty = qty;
	var min = parseInt($(qty_ref).attr('min'));
	var max = parseInt($(qty_ref).attr('max'));
	var flag = 0;
	
	var qtyn = qty;
	
	if((type > 0 || type == "incr") && qty >= min && qty < max) {

		if(type > 0)
			qtyn = qty + type;
		if(type == "incr")
			qtyn = qty + 1;

		flag = 1;

	} else if(type == "decr" && qty > min && qty <= max) {

		qtyn = qty - 1;

		flag = 1;
	}
	
	
	$(qty_ref).val(qtyn);
	
	
	if(qtyn != qty) {

		itemids = id.split('_');
		item_id   = parseInt(itemids[0]);//item_id or offer_id
		item_id1  = itemids[1];//rowid
		
		
		var token = '';

		if($('[name="csrf_digi_name"]').length)
			token = document.getElementsByName('csrf_digi_name')[0].value;

		var targeturl = add_cart_target_url;

		$("body").addClass("ajax-load");

	 	$.post(targeturl, { item_id: item_id, item_id1: item_id1, quantity: qtyn, csrf_digi_name: token, ajax: '1',item_from:itemFrom },
			function(data) {

				$("body").removeClass("ajax-load");

	 			if(data > 0) {

				    message = "Item quantity updated to your cart";
				    refresh_cart();
					
				    checkNotify('CART',message,'success');

	 			} else {

	 				message = "Item quantity not updated";
					
	 				checkNotify('CART',message,'error');
	 			}

			});
 	}
}


function remove_cart_item(id)
{
	if(!id)//rowid
		return;

	var token = '';

	if($('[name="csrf_digi_name"]').length)
		token = document.getElementsByName('csrf_digi_name')[0].value;

	var targeturl = remove_cart_target_url;

	$("body").addClass("ajax-load");

 	$.post(targeturl, { item_row_id: id, csrf_digi_name: token, ajax: '1' },
		function(data) {

			$("body").removeClass("ajax-load");
			
 			if(data >= 0) {

			    if (data > 0 && data!=999) {
					
					$('#items_cnt').text(data);
					message = "Item successfully removed from your cart";

				    refresh_cart();
					address_cart();//when item_remove - refresh cart div, summary div

				    checkNotify('CART',message,'success');

				} else if(data <=0) {

					
					message = "Item not removed from your cart";
					checkNotify('CART',message,'error');
					location.reload();
					
				} else if(data==999) {
					
					message = "No Items available in your cart";
					checkNotify('CART',message,'error');
					location.reload();
				}

 			} else {

 				message = "Item does not exist";
 				checkNotify('CART',message,'error');
 			}

		});
}
