<?php 

$user_addresses = $this->cart_model->get_user_address();

?>

<!--Check Out Page Section-->
<div class="container pt-8 pb-8">
	<div class="row">
	
	<?php echo $this->session->flashdata('message'); ?>
	
	<?php echo form_open('',array('name'=>'cart-form','id'=>'cart-form'));?>
	
		<div class="col-sm-9">
		
			<div class="cs-card cart-card card-show">
      			<div class="card-header bordered clearfix"><span class="stat-count">2</span><?php echo get_languageword('delivery_details');?> <button type="button" data-toggle="modal" data-target="#address-modal" class="btn btn-outline-primary pull-right"><i class="pe-7s-plus"></i> <?php echo get_languageword('add_new_address');?></button></div>
      			<div class="cs-card-content card-items-list address-y-flow clearfix">
      				
      				<!-- Radio Checkbox -->
      				<div class="address-box-header"><?php echo get_languageword('select_delivery_address');?></div>
					
					
					
      				<div class="row">
					
					
					<?php 

					if(!empty($user_addresses)) {
						
						$k=0;
						foreach ($user_addresses as $address):
						$k++;
						
						$checked="";	
						if($address->is_default=='Yes') {
							$checked = "checked='checked'";	
						}
						
						?>
	
                    <div class="col-lg-4 col-md-4 col-sm-6">
                        <div class="pb-delivery-address" onclick="check_address('<?php echo $address->ua_id;?>');">
                            <div class="address">
                               
                            <p> <?php if (isset($address->house_no)) echo $address->house_no;?> </p>
							
                            <p> <?php if (isset($address->street)) echo $address->street;?> </p>
							
                            <p> <?php if (isset($address->landmark)) echo $address->landmark;?> </p>
							
                            <p> <?php if (isset($address->locality)) echo $address->locality;?> </p>
							
							<p> <?php if (isset($address->city)) echo $address->city;?>  - <?php if (isset($address->pincode)) echo $address->pincode;?></p>
							 
							 
                            </div>
							
							
                            <input id="address<?php echo $k;?>" class="pb-radio-custom pb-radio-address" name="zipcode" type="radio" value="<?php echo $address->ua_id;?>" <?php echo $checked;?>>
							
                            <label for="address<?php echo $k;?>" class="pb-radio-custom-label pb-radio-address-label"> <?php echo get_languageword('deliver_to_this_address');?> </label>
							
							
                        </div>
                    </div>
					
					<?php endforeach; } ?>
					
                    
					
					
					
					
                    <div class="clearfix"></div>
                </div>
				
				
					
      				<div class="clearfix"></div>
					
      			</div>
      		</div>

			
			
			
			
			
			
			
			<!--POINTS-->
			<?php 
			
			$pay_no=3;
			if(isset($redeem_points) && !empty($redeem_points)) {
			$pay_no=4;
			
			
			$redm_sentnc='';
			
			$redeem_points = explode("=",$redeem_points);
			if(!empty($redeem_points)) {
				$redm_sentnc .= get_languageword('would_you_like_to_redeem_your_earned_points?');
				
				$redm_sentnc .= '<br>';
				$redm_sentnc .= get_languageword('you_have_').$redeem_points[1].' '.get_languageword('points');
			
				if($redeem_points[1] > $redeem_points[2]) {
					
					$redm_sentnc .= ',';
					$redm_sentnc .= get_languageword('you_can_redeem_maximum_of_').$redeem_points[2].' '.get_languageword('points');
				}
			}
				
			?>
			<div class="cs-card cart-card mt-2 payment-card-hide">
      			<div class="card-header bordered"><span class="stat-count">3</span><?php echo get_languageword('redeem_points');?></div>
      			<div class="cs-card-content card-items-list">
      				<div class="row">
					
					
					<div class="col-lg-6 col-md-7 col-sm-12">
                        <div class="pb-delivery-address pb-radeem-points">
                            <div class="address">
                               
                            <div class="points-radeem"> <i class="pe pe-7s-wallet"></i> <b><?php echo $redeem_points[2];?> <?php echo get_languageword('points');?> </b> </div>
                            <div class="points-radeem-text"> <?php echo $redm_sentnc;?>  </div>
							
                            </div>
							
							
                            <input id="user_points" class="pb-radio-custom pb-radio-address" name="user_redeem_points" type="checkbox" value="<?php echo $redeem_points[0];?>" onclick="check_points();">
							
                            <label for="user_points" class="pb-radio-custom-label pb-radio-address-label"> <?php echo get_languageword('redeem');?> </label>
							
							
                        </div>
                    </div>
					
					
					</div>
      			</div>
      		</div>
			
			
			<?php } ?>
			<!--POINTS-->
			
			
			
			
			
			
			
      		<!--Payment-->
      		<div class="cs-card cart-card mt-2 payment-card-hide">
      			<div class="card-header bordered"><span class="stat-count"><?php echo $pay_no;?></span><?php echo get_languageword('payment');?></div>
      			<div class="cs-card-content card-items-list">
      				<div class="row">
					
					
				<?php 
				 $admn_prvd_paymnts = $this->config->item('site_settings')->payment_methods;
				 
				 if($admn_prvd_paymnts != '')
				 $admn_prvd_paymnts = explode(',',$admn_prvd_paymnts);
				 ?>	
				 
				 
				 <?php if(count($admn_prvd_paymnts) > 0) {?>
				  
				  
				   <?php if(in_array('online',$admn_prvd_paymnts) && !empty($this->config->item('paypal_settings'))) {?>
				   
				  <div class="col-md-5 col-sm-12" onclick="show_cards()">
                        <div class="pb-radio-netbanking">
                            <input id="online" class="pb-radiobox-popular pb-radio-address" name="payment_type" type="radio" value="online">
                            <label for="online" class="pb-radiobox-popular-label pb-radio-address-label"> &nbsp; <img src="<?php echo FRONT_IMAGES;?>p-paypal.png" alt="Paypal" class="pb-netbanking-icons" title="Paypal"></label>
                        </div>
                    </div>
					
				   <?php } if(in_array('cash_on_delivery',$admn_prvd_paymnts) && !empty($card_types)) {?>
				   
				   </div>
				   <div class="row">
				   <div class="col-md-5 col-sm-12" onclick="show_cards()">
                        <div class="pb-radio-netbanking">
                            <input id="cash" class="pb-radiobox-popular pb-radio-address" name="payment_type" type="radio" value="cash">
                            <label for="cash" class="pb-radiobox-popular-label pb-radio-address-label"> &nbsp; <?php echo get_languageword('cash_on_delivery');?> </label>
                        </div>
                    </div>
					
				   
				   <?php } if(in_array('card_on_delivery',$admn_prvd_paymnts) && !empty($card_types)) {?>
				   
				   </div>
				   <div class="row">
				    <div class="col-md-5 col-sm-12">
                        <div class="pb-radio-netbanking" onclick="show_cards()">
                            <input id="cashCard" class="pb-radiobox-popular pb-radio-address" name="payment_type" type="radio" value="cashCard">
                            <label for="cashCard" class="pb-radiobox-popular-label pb-radio-address-label"> &nbsp; <?php echo get_languageword('card_on_delivery');?> </label>
                        </div>
                    
					
					
					
					 <?php if(!empty($card_types)) { ?>
						<li class="dm-noborder dm-itemcards" style="display:none;">
							<?php foreach ($card_types as $key => $value) { ?>
							<div class="dm-cardtype">
								<label>
									<input type="radio" name="payment_card" value="<?php echo $value->alt_text;?>" id="<?php echo $value->card_image_id;?>" <?php if($key == 0) echo "checked"; ?> />
									<?php
									$img_src = "";
									if(!empty($value->image_name) && file_exists(CARD_IMG_UPLOAD_PATH_URL.$value->image_name)) {
										$img_src = CARD_IMG_PATH.$value->image_name;
									}
									?>
								<img class="pb-netbanking-icons" src="<?php echo $img_src;?>" alt="<?php echo $value->alt_text; ?>">
								</label>
							</div>
							<?php } ?>
						</li>
					<?php } ?>
					
					</div>
					
					
				   <?php } ?>
				   
					
					
				 <?php }  else echo '<h4>'.get_languageword('no_payment_methods_available').'</h4>';?>
					
					
                    <div class="clearfix"></div>
					
					
					
      			</div>
      			</div>
      		</div>
			
		</div>
		
		
		
		
		
		<!--CART SUMMARY DIV-->
		<div class="col-sm-3" id="item-sidebar">
      	<div class="cs-card card-y-auto cart-card ml-lg-2 item-sidebar" >
      	<div class="card-header bordered"><?php echo get_languageword('your_cart');?></div>
			
			
		<div id="cart-div">
		
		</div>
		<button type="submit" name="submit_type" value="save_order" class="btn btn-primary btn-block btn-checkout" id="book_order" > <?php echo get_languageword('continue');?> </button>
		</div>

		
       </div>
		<!--CART SUMMARY DIV-->
	  
	  
	  
	
	  
	  <?php echo form_close();?>
	</div>
	<div class="clearfix"></div>
</div>


<script>
// A $( document ).ready() block.
$( document ).ready(function() {
	
	<?php if (!empty($this->cart->contents())) {?>
	load_cart_summary_div();
	<?php } ?>
	
});
</script>


<script type="text/javascript">
$('#book_order').click(function() {
	
	var selcted_adress = $("input[name='zipcode']").is(":checked");
    if(selcted_adress==false)
	{
		checkNotify('CART','<?php echo get_languageword('please_provide_delivery_address')?>','error');
		return false;
	}
	
	var pymnt_option = $("input[name='payment_type']").is(":checked");
	if(pymnt_option==false)
	{
		checkNotify('CART','<?php echo get_languageword('please_select_payment_method')?>','error');
		return false;
	}
});


//cards
function show_cards()
{
	var payment_type = $("input[name='payment_type']:checked").val();
	
	if (payment_type=='cashCard') {
		$(".dm-itemcards").show();
	} else {
		$(".dm-itemcards").hide();
	}
}

</script> 
<script type="text/javascript">
	//Radio selects on "div" click
    $(".pb-delivery-address").on('click', function () {
        $('input[type=radio]', this).prop("checked", true);
    });
    $(".btn-nxt-step").on('click',function(){
    	$('.card-show').removeClass("card-show").addClass("card-hide");
    	$('.payment-card-hide').removeClass("card-hide").addClass("card-show");
    });
</script>