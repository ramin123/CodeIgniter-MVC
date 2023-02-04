<!--Content start-->
         <div class="wrapper">
		 
		 
            <div class="section">
			
               <div class="category-title mb-2"><?php echo get_languageword('offers');?></div>
			   
			   <?php if (isset($offers) && !empty($offers)):
				$currency_symbol = $this->config->item('site_settings')->currency_symbol;
			   ?>
			   
			    <!--SELECTED MENU ITEMS BLOCK-->
               <div class="row">
			   
			   <?php foreach ($offers as $offer) {?>
                <div class="col-sm-6">
                    <div class="cs-card mb-3 cs-product-card">
					
                        <img src="<?php echo get_offer_image($offer->offer_image_name);?>" alt="<?php echo $offer->offer_name;?>" class="img-responsive" title="<?php echo $offer->offer_name;?>">
						
                        <div class="cs-card-content clearfix">
                            
							<div class="pull-left">
							
								<h4 title="<?php echo $offer->offer_name;?>"><?php echo $offer->offer_name;?></h4>
								
								<p><?php echo $currency_symbol.$offer->offer_cost;?></p>
								
							</div>
                            
							
                            <div class="pull-right">
                                <a href="javascript:void(0);" onclick="get_offer_popup('<?php echo $offer->offer_id;?>')" class="btn btn-sm btn-round btn-primary card-btn"> <?php echo get_languageword('view');?> </a>
                            </div>
							
                        </div>
                    </div>
                  </div>
			   <?php } ?>
				
				
				
				
				<div class="more-offers-block">
				
				</div>
				
				
				
				
				
				
				
				
            </div>
            <div class="row">
            <div class="col-sm-12">
            	<div class="text-center">
				
				<a href="javascript:void(0)" id="load_more_offers" onclick="get_more_offers()" style="display:none;" class="btn btn-load-more"><?php echo get_languageword('load_more');?></a>
				
				<input type="hidden" id="total_offers" value="<?php if(isset($total_offers)) echo $total_offers; ?>">	
				<input type="hidden" id="offers_offset" value="<?php if(isset($offset)) echo $offset; ?>">
				
				</div>
            </div>
        </div>
			 <?php else: 
		 
			 echo '<h4>'.get_languageword('no_offers_available').' </h4>';
			 
			 endif;?>
			<!--SELECTED MENU ITEMS BLOCK-->
			
			
			
         </div>
		 
		
		
      </div>
	   <!--Content end-->