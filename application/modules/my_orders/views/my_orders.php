<div id="content">

<div class="container pt-8 pb-8">
   <div class="row">
   
      <div class="col-md-3">
	  
        <ul class="dash-menu">
          <li><a href="<?php echo URL_USER_PROFILE;?>" title="My Profile"><i class="pe pe-7s-user"></i><?php echo get_languageword('my_profile');?></a></li>
          <li class="active"><a href="<?php echo URL_USER_MY_ORDERS;?>" title="My Orders"><i class="pe pe-7s-box1"></i><?php echo get_languageword('my_orders');?></a></li>
          <li><a href="<?php echo URL_USER_MY_POINTS;?>" title="My Points"><i class="pe pe-7s-wallet"></i><?php echo get_languageword('my_points');?></a></li>
          <li><a href="<?php echo base_url();?>address"><i class="pe pe-7s-notebook"></i><?php echo get_languageword('my_addresses');?></a></li>
		  <li><a href="<?php echo URL_USER_CHANGE_PASSWORD;?>"><i class="pe pe-7s-unlock"></i><?php echo get_languageword('change_password');?></a></li>
        </ul>
		
      </div>
	  
	  
	  
      <div class="col-md-9">
         <div class="cs-card cart-card card-show">
               <div class="card-header bordered card-header-lg"><?php if (isset($pagetitle)) echo $pagetitle;?> 
			   
			   </div>
			   
			   <?php if (isset($data) && !empty($data)) { ?>
               <div class="cs-card-content card-items-list">
			   
               		<div class="panel-group" id="accordion">
					
				   <?php 
				   $i=0;
				   $currency_symbol=$this->config->item('site_settings')->currency_symbol;
				   
				   foreach ($data as $order): 
				   
				   $items_cost=0;
				   $i++;
				   ?>
					
				    <div class="panel panel-default">
				      <div class="panel-heading">
				        <h4 class="panel-title">
				          <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $i;?>">
				          	<div class="order-history">
				          		<h4> <span>(<?php echo get_languageword('order');?> # : <?php echo $order->order_id;?>)</span> <span class="oh-price"><?php echo $currency_symbol.$order->total_cost;?></span></h4>
				          		<p class="text-danger"> <?php echo ucwords(str_replace('_',' ',$order->status));?> </p>
				          	</div>
				          </a>
				        </h4>
				      </div>
				      <div id="collapse<?php echo $i;?>" class="panel-collapse collapse">
				        <div class="panel-body">
				        	<div class="row">
				        		<div class="col-sm-4">
				        			<div class="oh-details">
				        				<h4><?php echo get_languageword('payment_details');?></h4>
				        				<ul class="ul">
										
				        					<li><?php echo get_languageword('items_total');?>:<span><?php echo $currency_symbol;?><?php echo $order->total_cost - $order->delivery_fee;?></span></li>
											
				        					<li><?php echo get_languageword('delivery_charges');?>:<span><?php echo $currency_symbol;?><?php if($order->delivery_fee >0) echo $order->delivery_fee;else echo 0;?></span></li>
											
				        					
				        					<li><?php echo get_languageword('is_points_redeemed');?>:<span><?php if(isset($order->is_points_redeemed)) echo $order->is_points_redeemed;?></span></li>
											
											
											<?php if($order->is_points_redeemed=='Yes') {?>
											
											<li><?php echo get_languageword('no_of_points_redeemed');?>:<span><?php if(isset($order->no_of_points_redeemed)) echo $order->no_of_points_redeemed;?></span></li>
											
											
											<li><?php echo get_languageword('points_value');?>:<span><?php echo $currency_symbol;?>
											<?php if(isset($order->points_value)) echo $order->points_value;?></span></li>
											
											<?php } ?>
											
											
											
				        					
											
				        					<li><?php echo get_languageword('payment_mode');?>:<span><?php

											$paytype='';
											
											if ($order->payment_type=='cashCard'):
												$paytype='Card on Delivery';
											elseif ($order->payment_type=='cash'):
												$paytype='Cash on Delivery';
											else:
												$paytype=$order->payment_type;
											endif;
											
											
											echo $paytype;?></span></li>
											
											
				        				</ul>
				        			</div>
				        		</div>
								
				        		<div class="col-sm-4">
				        			<div class="oh-details">
									
										<ul class="ul">
										
				        					<li><?php echo get_languageword('booked_date');?>:<span><?php if(isset($order->order_date) && $order->order_date != '') echo get_date($order->order_date);?> <?php if(isset($order->order_time) && $order->order_time != '') echo $order->order_time;?></span></li>
											
											
											
											
											<li><?php echo get_languageword('delivered_date');?>:<span><?php if(isset($order->delivered_status_datetime) && $order->delivered_status_datetime != '') echo get_date($order->delivered_status_datetime).' '.date('H:i',strtotime($order->delivered_status_datetime));?></span></li>
											
										</ul>	
										
										<br>
								
				        				<h4><?php echo get_languageword('delivery_details');?></h4>
				        				<p>
										<?php if(isset($order->house_no)) echo $order->house_no;?>
										<?php if(isset($order->street)) echo $order->street;?>
										<?php if(isset($order->landmark)) echo $order->landmark;?>
										<?php if(isset($order->locality)) echo $order->locality;?>
										<?php if(isset($order->city)) echo $order->city.' '.$order->pincode;?>
										</p>
				        			</div>
				        		</div>
								
								
								
								<div class="col-sm-4">
								<a href="javascript:void(0);" class="btn btn-primary" onclick="get_order_details('<?php echo $order->order_id;?>')"> <?php echo get_languageword('details');?> </a>
								</div>
								
								
				        	</div>
				        </div>
				      </div>
				    </div>
					
					<?php endforeach;?>
					
					
					
				  </div> 
               </div>
			   <?php } ?>
			   
			   
            </div>
			
			
			
			
			<div class="text-center">
			 <nav aria-label="...">
				<ul class="pagination dm-pagination">
				   <li>
					  <?php echo $this->pagination->page_links(); ?>
				   </li>
				</ul>
			 </nav>
		  </div>
		  
		  
         </div>
		 
		 
		 
		 
		 
		 
		 
		 
      </div>
   </div>
   
   
   
   </div>
   
   
   
   
  
<!--Item Details Popup-->
<div id="order-details-modal" class="modal fade login-component" role="dialog">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-body">
       <div class="login-block">
	   
		<button type="button" class="close modal-close" data-dismiss="modal">&times;</button>
		
		
		<div id="order-details-block">
		
		</div>
			
        </div>
      </div>
    </div>
  </div>
</div>
<!--Item Details Popup-->

<script>
function showOrderDetails(orderId)
{
	// console.log('Order ID',orderId);
	
	$("body").addClass("ajax-load");
	$.ajax({
		'type':'POST',
		'url':'<?php echo base_url();?>order/order_details',
		'data': '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash();?>&order_id='+order_id,
		success:function(data){
			$("body").removeClass("ajax-load");
			// console.log('Response',JSON.parse(data));
		}

	});
}


function get_order_details(order_id) {
	
	if (order_id>0) {
		
		$("#order-details-block").empty();
		$('#order-details-modal').modal('hide');
		
		$("body").addClass("ajax-load");

		$.ajax({
			url:'<?php echo base_url();?>my_orders/get_order_details',
			type:'POST',
			data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash();?>&order_id='+order_id,
			success :function(response){
				
				$("body").removeClass("ajax-load");

				if (response!='' && response!=999) {
					
					$("#order-details-block").html(response);
					$('#order-details-modal').modal('show');
					
				} else {
					
					$("#order-details-block").empty();
					$('#order-details-modal').modal('hide');
				} 
			}
		});
	}
	
}
</script>
