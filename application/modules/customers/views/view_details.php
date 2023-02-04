  <div id="page-wrapper">
            <div>
               <div class="row">
                <div class="col-md-12">
                	
				<?php echo $this->session->flashdata('message'); ?>
                    <!-- Form Elements -->
                    <div class="panel panel-default">
						
                        <div class="panel-heading">
                            <?php if(isset($pagetitle)) echo $pagetitle;?>
							
							<a title="<?php echo get_languageword('go_to_list'); ?>" class="btn btn-primary btn-xs pull-right" href="<?php echo URL_CUSTOMERS_INDEX; ?>"><i class="fa fa-list"></i>
							</a>
                        </div>
                        <div class="panel-body">
						 
                            <div class="row">
							
							
                       <div class="col-md-6">
                                 <ul class="table-list ul">
                                 	<li><span><?php echo get_languageword('first_name');?>:</span><?php if(isset($record->first_name)) echo $record->first_name;?></li>
                                 	<li><span><?php echo get_languageword('last_name');?>:</span><?php if(isset($record->last_name)) echo $record->last_name;?></li>
                                 	<li><span><?php echo get_languageword('email');?>:</span><?php if(isset($record->email)) echo $record->email;?></li>
                                 	<li><span><?php echo get_languageword('phone');?>:</span><?php if(isset($record->phone)) echo $record->phone;?></li>
                                 	<li><span><?php echo get_languageword('referral_code');?>:</span><?php if(isset($record->referral_code)) echo $record->referral_code;?></li>
                                 	<li><span><?php echo get_languageword('user_points');?>:</span><?php if(isset($record->user_points)) echo $record->user_points;?></li>
                                 </ul>
					



					 
					 
					  </div>			

						
                            </div>
							
							
							
							
							
                     <div>
					 
					 
					 
				<?php if (isset($addresses) && !empty($addresses)) {?>
					 
                     <div class="row">
					 
					 <?php foreach($addresses as $address) :?>
					 
                      <div class="col-sm-6 col-md-4 col-lg-3">
                         <div class="pb-saved-address">
						 
						 <?php if (isset($address->is_default) && $address->is_default=='Yes') {?>
                            <span class="default-address"><i class="fa fa-check"></i> <?php echo get_languageword('default');?></span>
						 <?php } ?>	
							
                           
							
                            <p> <?php if (isset($address->house_no)) echo $address->house_no;?> </p>
                            <p> <?php if (isset($address->street)) echo $address->street;?> </p>
                            <p> <?php if (isset($address->landmark)) echo $address->landmark;?> </p>
                            <p> <?php if (isset($address->locality)) echo $address->locality;?> </p>
							
							 <p> <?php if (isset($address->city)) echo $address->city;?>  - <?php if (isset($address->pincode)) echo $address->pincode;?></p>
							
							
                        </div>
                      </div>
					  
					<?php endforeach;?>	
					
                     </div>
					 
					  <?php } ?>	
					 
					 
					 
               </div>
                        </div>
                    </div>
                     <!-- End Form Elements -->
                </div>
            </div>
    </div>
        <!-- /. PAGE INNER  -->
            </div>
        <!-- /. PAGE WRAPPER  -->