<div id="content">

<div class="container pt-8 pb-8">
   <div class="row">
      <div class="col-md-3">
	  
        <ul class="dash-menu">
		
          <li><a href="<?php echo URL_USER_PROFILE;?>"><i class="pe pe-7s-user"></i><?php echo get_languageword('my_profile');?></a></li>
		  
          <li><a href="<?php echo URL_USER_MY_ORDERS;?>"><i class="pe pe-7s-box1"></i><?php echo get_languageword('my_orders');?></a></li>
		  
          <li class="active"><a href="<?php echo URL_USER_MY_POINTS;?>"><i class="pe pe-7s-wallet"></i><?php echo get_languageword('my_points');?></a></li>
		  
          <li><a href="<?php echo URL_ADD_USER_ADDRESS;?>"><i class="pe pe-7s-notebook"></i><?php echo get_languageword('my_addresses');?></a></li>
		  
		  <li><a href="<?php echo URL_USER_CHANGE_PASSWORD;?>"><i class="pe pe-7s-unlock"></i><?php echo get_languageword('change_password');?></a></li>
		  
        </ul>
		
      </div>
      <div class="col-md-9">
         <div class="cs-card cart-card card-show">
               <div class="card-header bordered card-header-lg"><?php if (isset($pagetitle)) echo $pagetitle;?> <a  class="btn btn-outline-primary pull-right no-border"><i class="pe-7s-wallet"></i> <?php echo get_languageword('balance');?> : <?php if (isset($user_total_points)) echo $user_total_points;?> <?php echo get_languageword('points');?> </a></div>
			   
			   <?php if (isset($user_points) && !empty($user_points)) { ?>
               <div class="cs-card-content card-items-list">
			   
                    <div class="panel-group" id="accordion">
					
					
					
					<?php foreach ($user_points as $point) :
					$cls='';
					if($point->transaction_type=='Earned') {
						$cls='wallet-earn';
					} else if ($point->transaction_type=='Redeem') {
						$cls='wallet-radeem';
					}
					?>
                    <div class="panel panel-default">
                      <div class="panel-heading">
                        <h4 class="panel-title">
                         
                            <div class="order-history oh-points">
                                <h4 class="<?php echo $cls;?>"> <?php if (isset($point->transaction_type)) echo $point->transaction_type;?> <span> <?php if ($point->order_id>0) echo '(Order #: '.$point->order_id.')'; ?></span> <span class="oh-price"> <?php if ($point->transaction_type=='Earned') echo '+';else echo '-';?><?php echo $point->points;?></span></h4>
                                <p><?php echo $point->description;?></p>
                            </div>
                         
                        </h4>
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