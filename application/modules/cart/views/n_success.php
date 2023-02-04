<?php if(isset($order_id)) {?>
<section class="fc-identity fc-bottom fc-menu-wrapper">
		<div class="container">
			<div class="search-wrapper contact-overlay">
				<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12 text-center">
				<div class="cs-sucess-msg"> <span class="pe pe-7s-like2"></span> <span><?php echo get_languageword('order_successful');?></span></div>
				<img class="img-responsive center-block suc-img" src="<?php echo base_url();?>assets/front/images/success.png" alt="success-page">    
				<h4 class="fc-order-no"><?php echo get_languageword('your_order_no_is');?> : <span><?php if(isset($order_id)) echo $order_id;?></span></h4>
				
				
				<p class="fc-success-text"><?php echo get_languageword('your_order_is_received_we_will_contact_you_soon');?></p>
				
				
				<?php
				if ($this->config->item('point_settings')->points_enabled=='Yes' && $this->config->item('point_settings')->maximum_earning_points_for_customer > 0) {												echo '<p class="fc-success-text"> '.get_languageword('you_will_get').'<i class="cpe pe-7s-wallet"></i>&nbsp;'.$this->config->item('point_settings')->maximum_earning_points_for_customer.' '.get_languageword('points_if_this_order_is_delivered_to_you_successfully').' </p>';
				
				} ?>
				
				
				<a href="<?php echo URL_USER_MY_ORDERS;?>" class="btn btn-warning"><?php echo get_languageword('view_all');?></a>
				
				
			</div>
		</div>
			</div>
			<div class="mb-2">&nbsp;</div>
		</div>
</section>
<?php } ?>