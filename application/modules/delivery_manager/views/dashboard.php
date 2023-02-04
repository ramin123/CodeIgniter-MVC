
<div id="page-wrapper" class="bg-silver" >

            <div>

               <div class="row">
			   
                <div class="col-md-4 col-lg-3">
				 <a href="<?php echo URL_DM_ORDERS;?>" title="<?php echo get_languageword('orders');?>">
					<div class="media stats-media-white bg-white">
						<div class="media-left">
							<img src="<?php echo FRONT_IMAGES;?>dashboard-list.svg" width="50" height="50" alt="Orders">
						</div>
						<div class="media-body text-right">
							<p><?php echo get_languageword('orders');?></p>
							<h4><?php if(isset($orders_count)) echo $orders_count;?></h4>
						</div>
					</div>
					</a>		
                   </div>
					
					
                </div>
				
           </div>   

    </div>
