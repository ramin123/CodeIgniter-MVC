
			<div>
      		<div class="cs-card-content card-items-list">
			
			<?php 
			$total_pay=0;
			$currency_symbol = $this->config->item('site_settings')->currency_symbol;
			$cart_total=0;
			
			
			if (!empty($this->cart->contents())) { ?>
			
      			<ul class="list-left-right">
				
				<?php foreach ($this->cart->contents() as $items) { 
				
				$cart_total += $items['subtotal'];
				if (isset($items['options']['extra_costs_total'])) {
					$cart_total += $items['options']['extra_costs_total'];
				}
				?>
				
				
      				<li class="clearfix">
      					<div class="list-left">
      						<div class="cart-item-title"><?php echo $items['name'];?></div>
							
							<?php 
							if ((isset($items['options']['addons_cost_per_item']) || isset($items['options']['item_option_name'])) && $items['options']['is_offer'] == 0) { ?>
							
      						<div class="cart-item-cutomize mt-08">
							<a href="javascript:void(0);" class="btn-cutomize" onclick="get_item_popup('<?php echo $items['id'];?>')"><?php echo get_languageword('view');?></a>
							</div>
							
							<?php } else if ($items['options']['is_offer'] == 1) { ?>
							
							<div class="cart-item-cutomize mt-08">
							<a href="javascript:void(0);" onclick="get_offer_popup('<?php echo $items['id'];?>','cart')" class="btn-cutomize"><?php echo get_languageword('view');?></a>
							</div>
							
							<?php } ?>
							
							
      					</div>
						
						<?php 
						$itm_total=$items['subtotal'];
						if (isset($items['options']['extra_costs_total'])) 
							$itm_total += $items['options']['extra_costs_total'];
						
						?>
      					<div class="list-right">
      						<div class="card-item-price"><?php echo $currency_symbol;?><span><?php echo $itm_total;?></span></div>
							
      						<div class="card-item-actions mt-08">
      							<span><?php echo $items['qty'];?></span>
      						</div>
							
      					</div>
      				</li>
					
					
					
              <!--li class="clearfix">
                <div class="list-left">
                  <div class="cart-item-title">Veg Burger</div>
                  <div class="cart-item-cutomize"></div>
                </div>
                <div class="list-right">
                  <div class="card-item-price">$25</div>
                  <div class="card-item-actions">
                    <i class="pe-7s-less"></i><span>1</span><i class="pe-7s-plus"></i>
                  </div>
                </div>
              </li-->
			  
				<?php } ?>
			  
			  
      			</ul>
				
			<?php } ?>
				
      		</div>
			
			
			<?php 
			
			
			
			$deliverfee=0;
			if (isset($delivery_fee) && $delivery_fee>0)
				$deliverfee = $delivery_fee;
				
			$no_ofpoints=0;
			if (isset($no_of_points) && $no_of_points>0)
				$no_ofpoints=$no_of_points;
			
			
			$points_dscnt=0;
			if (isset($points_discount) && $points_discount>0)
				$points_dscnt=$points_discount;
			
			
			
			$total_pay = $cart_total+$deliverfee-$points_dscnt;
			?>
					
		
      		<div class="cs-card-content">
      			<ul class="list-left-right cart-total-details">
      				<li class="clearfix">
      					<div class="list-left">Items Total</div>
      					<div class="list-right"><?php echo $currency_symbol;?><?php echo $cart_total;?></div>
      				</li>
					
					
      				
      				<li class="clearfix">
      					<div class="list-left">Delivery Charges</div>
      					<div class="list-right"><?php echo $currency_symbol;?><span id="delivery_fee"><?php echo $deliverfee;?></span> </div>
      				</li>
					
					
					
					<?php if (isset($no_of_points) && $no_of_points>0) { ?>
					<li class="clearfix">
      					<div class="list-left">No.of Points</div>
      					<div class="list-right"><?php echo $no_ofpoints;?></div>
      				</li>
					
					<li class="clearfix">
      					<div class="list-left">Points Discount</div>
      					<div class="list-right"><?php echo $currency_symbol;?><?php echo $points_dscnt;?> </div>
      				</li>
					
					<input type="hidden" name="no_of_redeemed_points" value="<?php echo $no_ofpoints;?>">
					
					<?php } ?>
					
					
					
      			</ul>
				
      			<ul class="list-left-right">
      				<li class="clearfix">
      					<div class="list-left"><strong class="text-success">Total Pay</strong></div>
      					<div class="list-right"><strong class="text-success"><?php echo $currency_symbol;?><?php echo $total_pay;?></strong></div>
      				</li>
      			</ul>
				
      		</div>
			
			</div>
			
			
      	