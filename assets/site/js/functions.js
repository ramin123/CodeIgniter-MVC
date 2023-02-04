$(document).ready(function() {
  $('input[name="search"]').autoComplete({
  	  minChars:1,
      source: function(term, response) {
		  targeturl = search_target_url;
	
          $.getJSON(targeturl, { search: term }, function(data){ response(data);});
      },
      
  });
});

function getitemAddons(itemId,itemFrom)
{
	var token = '';

	if($('[name="csrf_digi_name"]').length)

	token = document.getElementsByName('csrf_digi_name')[0].value;

	targeturl = itemaddons_target_url;

	$.ajax({

		   type:'POST',

		   url:targeturl,

		   data:{

			   ajax:1,

			   csrf_digi_name:token,

			   id:itemId,

			   from:itemFrom

		   },

		   success:function(data){				   

				   var t = $.parseJSON(data);
		
			if(t['is_small']=='small_modal'){
				$('#modal_type').attr('class','modal-dialog small-modal');
				
			}else{
				$('#modal_type').attr('class','modal-dialog');
			}	   

			if(t['action']=='success'){

				 $('#test_Modal .modal-body').html(t['data']);

				 $("#test_Modal").modal();

			}

		   }
	});
}

function update_qty(type, qty_ref)
{
	if(qty_ref != "") {
		var qty_ref = $('#'+qty_ref);
	} else {
		var form_ref = $('form#itemForm');
		var qty_ref  = $(form_ref).find('input[name=quantity]');
	}

	var qty = parseInt($(qty_ref).val());
	var min = parseInt($(qty_ref).attr('min'));
	var max = parseInt($(qty_ref).attr('max'));
	var flag = 0;


	if((type > 0 || type == "incr") && qty >= min && qty < max) {

		if(type > 0)
			qty = qty + type;
		if(type == "incr")
			qty = qty + 1;

		flag = 1;

	} else if(type == "decr" && qty > min && qty <= max) {

		qty = qty - 1;

		flag = 1;
	}

	
	$(qty_ref).val(qty);

	if(flag == 1)
		update_cost_popup();
}

function update_addon_qty(type, id)
{
	var flag = 0;

	var qty_ref  = $('#'+id);

	var qty = parseInt($(qty_ref).val());
	var min = parseInt($(qty_ref).attr('min'));
	var max = parseInt($(qty_ref).attr('max'));

	if(type == "incr" && qty >= min && qty < max) {

		qty = qty + 1;
		
		flag = 1;

	} else if(type == "decr" && qty > min && qty <= max) {

		qty = qty - 1;

		flag = 1;
	}
	
	$(qty_ref).val(qty);

	if(flag == 1)
		update_cost_popup();
	
}

function update_cost_popup()
{
	var final_cost = 0;
	var addon_cost = 0;
	var item_cost  = 0;

	var item_quantity =  parseFloat($('input[name="quantity"]').val());

	$('.dm-add-qty input').each(function() {

			addon_cost += parseFloat($(this).val()) * parseFloat($(this).attr('data-val'));
	});
	
	if($('input[name="item_option_id"]:checked').attr('data-val')) {
		item_cost += item_quantity * parseFloat($('input[name="item_option_id"]:checked').attr('data-val'));

	} else {

		item_cost += item_quantity * parseFloat($('#item_cost').val());
	}

	final_cost = (final_cost + addon_cost + item_cost).toFixed(2);

	$('#hp_final_cost').html(final_cost);

}

function update_cart(type, id, qty,itemFrom='')
{
	update_qty(type, id);

	var qtyn = $('#'+id).val();

	if(qtyn != qty) {

		itemids = id.split('_');
		item_id   = parseInt(itemids[0]);
		item_id1  = itemids[1];
		
		
		var token = '';

		if($('[name="csrf_digi_name"]').length)
			token = document.getElementsByName('csrf_digi_name')[0].value;

		var targeturl = add_cart_target_url;

	 	$.post(targeturl, { item_id: item_id, item_id1: item_id1, quantity: qtyn, csrf_digi_name: token, ajax: '1',item_from:itemFrom },
			function(data) {

	 			if(data >= 0) {

				    message = "Item successfully updated to your cart";
				    refresh_cart();
				    alertify.success(message);

	 			} else {

	 				message = "Item does not exist";
	 				alertify.error(message);
	 			}

			});
 	}
}

$(document).on('click', 'input[name="use_redeem_points"]', function() {
	refresh_cart();
});

function refresh_cart()
{			// $("#cart_content").html('<div><img src="\''.LOADER.'\'"></div>');
	var df = $('input[name="zipcode"]:checked').attr('id');

	var redeem_points = $('input[name="use_redeem_points"]:checked').val();		
	
	//df = delivery fee
	// Get the contents of the url cart/show_cart
	$.get( "show_cart", { df: df,discount:redeem_points } )
	  .done(function( data ) {	
	    $("#cart_content").html(data); // Replace the information in the div #cart_content with the retrieved data	
	  });
}




function remove_cart_item(id)
{
	
	if(!id)
		return;

	var token = '';

	if($('[name="csrf_digi_name"]').length)
		token = document.getElementsByName('csrf_digi_name')[0].value;

	var targeturl = remove_cart_target_url;

 	$.post(targeturl, { item_row_id: id, csrf_digi_name: token, ajax: '1' },
		function(data) {

 			if(data >= 0) {

			    $('#items_cnt').text(data);
			    message = "Item successfully removed from your cart";

			    if(data > 0) {

				    refresh_cart();

				    alertify.success(message);

				} else {

					alertify.success(message);
					location.reload();
				}

 			} else {

 				message = "Item does not exist";
 				alertify.error(message);
 			}

		});

}

$(function() {
	$('form#itemForm').submit(function() {
		return false;
	});
});


// ADD TO CART function
function addToCart(itemFrom)
{
	var message  = "";

	var form_ref = $('form#itemForm');
	
	var addon_ids = [];

	var index = 0;
	
	//Prepare Add-ons array
	$('.dm-add-qty input').each(function() {
		selected_qty = parseFloat($(this).val());
		if(selected_qty > 0) {
			addonid  	= $(this).attr('id');
			addon_ids[index++] = addonid+"_"+selected_qty;
		}
	});
	
	var token = '';

	if($('[name="csrf_digi_name"]').length)
		token = document.getElementsByName('csrf_digi_name')[0].value;
	
	var id  = $(form_ref).find('input[name=item_id]').val();
	var qty = $(form_ref).find('input[name=quantity]').val();
	var item_option_id = $(form_ref).find('input[name=item_option_id]:checked').val();

	if(!qty)
		qty = 1;
	
	var targeturl = add_cart_target_url;
	
	$.post(targeturl, { item_id: id, quantity: qty, item_option_id: item_option_id, addon_ids: addon_ids, csrf_digi_name: token, ajax: '1',item_from:itemFrom },
		function(data) {

 			if(data >= 0) {

				$('#items_cnt').text(data);

			    message = "Item successfully added to your cart";
			    alertify.success(message);
				$("#test_Modal").modal('hide');
 			} else {

 				message = "Item does not exist";
 				alertify.error(message);
 			}
		});
}
function fetch_more(url,offset,search)
{
	var token = '';
	if($('[name="system_csrf"]').length > 0)
	var token = document.tokenform.system_csrf.value;
	$.ajax({
		   type:'POST',
		   url:url,
		   data:'ajax=1&&offset='+offset+'&system_csrf='+token+search,
		   success:function(data)		   {
				$('#content').html(data); 
		   }
	 });
}