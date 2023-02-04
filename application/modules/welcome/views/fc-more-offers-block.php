 <?php 
 $currency_symbol = $this->config->item('site_settings')->currency_symbol;
 if (isset($offers) && !empty($offers)) {
 foreach ($offers as $offer) {?>
<div class="col-sm-6">
	<div class="cs-card mb-3 cs-product-card">
	
		<img src="<?php echo get_offer_image($offer->offer_image_name);?>" alt="<?php echo $offer->offer_name;?>" class="img-responsive" title="<?php echo $offer->offer_name;?>">
		
		<div class="cs-card-content clearfix">
			
			<div class="pull-left">
				<h4 title="<?php echo $offer->offer_name;?>"><?php echo $offer->offer_name;?></h4>
				
				<p><?php echo $currency_symbol.$offer->offer_cost;?></p>
				
			</div>
			
			
			<div class="pull-right">
				<a href="javascript:void(0);" onclick="get_offer_popup('<?php echo $offer->offer_id;?>')" class="btn btn-sm btn-round btn-primary card-btn"> <?php echo get_languageword('view');?>  </a>
			</div>
			
		</div>
	</div>
  </div>
 <?php } }?>