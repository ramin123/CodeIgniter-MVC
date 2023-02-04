 <?php 
 $currency_symbol = $this->config->item('site_settings')->currency_symbol;
 if (isset($items) && !empty($items)) {
 foreach ($items as $item) {?>
<div class="col-sm-6">
	<div class="cs-card mb-3 cs-product-card">
	
		<img src="<?php echo get_item_image($item->item_image_name);?>" alt="<?php echo $item->item_name;?>" class="img-responsive" title="<?php echo $item->item_name;?>">
		
		<div class="cs-card-content clearfix">
			
			<div class="pull-left">
			
				<h4 title="<?php echo $item->item_name;?>"><?php echo $item->item_name;?></h4>
				
				
				<!--
				1.only options
				2.options and addons
				3.only addons
				-->
				
				<?php if (!empty($item->options) || (!empty($item->options) && !empty($item->addons)) ): ?>
				
				<p><?php echo $currency_symbol.$item->options[0]->price;?></p>
				
				<?php else:?>
				
				<p><?php echo $currency_symbol.$item->item_cost;?></p>
				
				<?php endif;?>
			</div>
			
			
			<div class="pull-right">
			<!---add to cart/choose addons,items-->
			
			<?php if (empty($item->addons) && empty($item->options)):?>
			
			<!---->
			<form id="item_form_<?php echo $item->item_id;?>">

			<input type="hidden" id="itemFrom<?php echo $item->item_id;?>" value="items">
			<input type="hidden" id="selected_item_id<?php echo $item->item_id;?>" value="<?php echo $item->item_id;?>">
			<input type="hidden" id="selected_menu_id<?php echo $item->item_id;?>" value="<?php echo $item->menu_id;?>">
			<input type="hidden" id="selected_item_cost<?php echo $item->item_id;?>" value="<?php echo $item->item_cost;?>">
			
			</form>
			<!---->
							
				<a href="javascript:void(0);" onclick="addToCart('<?php echo $item->item_id;?>')" class="btn btn-sm btn-round btn-primary card-btn"><?php echo get_languageword('add_to_cart');?></a>
				
			<?php else: ?>	
			
				<a href="javascript:void(0);" onclick="get_adns_options('<?php echo $item->item_id;?>')" class="btn btn-sm btn-round btn-primary card-btn"><?php echo get_languageword('choose');?> <i class="fa fa-angle-down"></i></a>
				
			<?php endif;?>	
			</div>
			
		</div>
	</div>
  </div>
 <?php } }?>