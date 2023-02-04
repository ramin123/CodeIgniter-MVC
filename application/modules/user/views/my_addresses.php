
<div class="container pt-8 pb-8">
   <div class="row">
      <div class="col-md-3">
	  
        <ul class="dash-menu">
		
          <li><a href="<?php echo URL_USER_PROFILE;?>"><i class="pe pe-7s-user"></i><?php echo get_languageword('my_profile');?></a></li>
		  
          <li><a href="<?php echo URL_USER_MY_ORDERS;?>"><i class="pe pe-7s-box1"></i><?php echo get_languageword('my_orders');?></a></li>
		  
          <li><a href="<?php echo URL_USER_MY_POINTS;?>"><i class="pe pe-7s-wallet"></i><?php echo get_languageword('my_points');?></a></li>
		  
          <li class="active"><a href="<?php echo URL_ADD_USER_ADDRESS;?>"><i class="pe pe-7s-notebook"></i><?php echo get_languageword('my_addresses');?></a></li>
		  
		  <li><a href="<?php echo URL_USER_CHANGE_PASSWORD;?>"><i class="pe pe-7s-unlock"></i><?php echo get_languageword('change_password');?></a></li>
		  
        </ul>
		
      </div>
	  
	  
      <div class="col-md-9">
	  
	   <?php echo $this->session->flashdata('message'); ?>
	   
         <div class="cs-card cart-card card-show">
               <div class="card-header bordered card-header-lg"><?php if (isset($pagetitle)) echo $pagetitle;?> <a class="btn btn-outline-primary pull-right" data-toggle="modal" data-target="#add-address-modal"><i class="pe-7s-plus"></i> <?php echo get_languageword('add_new_address');?></a></div>
			   
			   <?php if (isset($addresses) && !empty($addresses)) {?>
			   
               <div class="cs-card-content card-items-list">
                     <div class="row">
					 
					 
					 <?php foreach($addresses as $address) :?>
                      <div class="col-md-6 col-lg-4">
                           <div class="pb-saved-address">
						   
						   <?php if($address->is_default=='Yes') { ?>
                              <span class="default-address"><i class="pe-7s-check"></i> <?php echo get_languageword('default');?></span>
						   <?php } ?>
						   
                            
                            <p> <?php echo $address->house_no;?> </p>
                            <p> <?php echo $address->street;?> </p>
                            <p> <?php echo $address->landmark;?> </p>
                            <p> <?php echo $address->locality;?> </p>
							<p> <?php echo $address->city.' '.$address->pincode;?> </p>
							
							
                            <ul class="pw-address-actions">
							
                                <li><a data-toggle="modal" data-target="#address-delete-modal" onclick="delete_address('<?php echo $address->ua_id;?>')"><i class="pe-7s-trash"></i></a></li>
								
								<?php if($address->is_default!='Yes') {?>
								
                                <li><a data-toggle="modal" data-target="#default-address-modal" onclick="default_address('<?php echo $address->ua_id;?>')"><i class="pe-7s-check"></i></a></li>
								
								<?php } ?>
								
                            </ul>
                        </div>
                        </div>
						
						<?php endforeach;?>
						
						
                     </div>
					 
               </div>
			   
			   <?php } ?>
            </div>
         </div>
		 
      </div>
   </div>
   
   
 <!--Delete Address Modal-->
<div id="address-delete-modal" class="modal fade login-component" role="dialog">
  <div class="modal-dialog ">
    <!-- Modal content-->
    <div class="modal-content">
	
	<?php 			
			 echo form_open(URL_DELETE_USER_ADDRESS);?>
			 
      <div class="modal-body">
       <div class="login-block">
	   
		   <button type="button" class="close modal-close" data-dismiss="modal">&times;</button>
		   
		   <div class="login-block-header text-center"><?php echo get_languageword('delete_address');?></div>
			
			
			<div class="form-group">
			
				<p><?php echo get_languageword('are_you_sure_to_delete_address?');?></p>
				
				<input type="hidden" name="ua_id" id="ua_id" value="0">
				
			</div>
				
			<div class="form-group">
			
				<button type="submit" name="delete_address" class="btn btn-primary"><b><?php echo get_languageword('yes');?></b></button>
				
				 <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo get_languageword('no');?></button>
				 
			</div>
			
		</div>
      </div>
	  <?php echo form_close();?>
	  
    </div>
  </div>
</div>
<!--Delete Address Modal-->  



<!--Add Address Modal-->
<div id="add-address-modal" class="modal fade login-component" role="dialog">
  <div class="modal-dialog ">
    <!-- Modal content-->
    <div class="modal-content">
	
	
	<?php 
	 $attributes = array('name'=>'address_form',
						'id'=>'address_form',
						'class'=>'form-horizontal');
	 echo form_open(URL_USER_ADD_ADDRESS,$attributes);?>
	 
					 
      <div class="modal-body">
       <div class="login-block">
	   
               <button type="button" class="close modal-close" data-dismiss="modal">&times;</button>
			   
               <div class="login-block-header text-center"><?php echo get_languageword('add_address');?></div>
				
				<?php echo $this->session->flashdata('message'); ?>
				
               
				
					 
                    <div class="form-group">
					<?php 
					 $cities = $this->base_model->get_cities();
					 $val=array();
					 
					 echo form_dropdown('city_id',$cities,$val,'class="form-control form-control-lg chzn-select" placeholder="city" id="city_id" onchange="get_localities()"');	
					 ?>
                    </div>
					
					
					
                    <div class="form-group">
					<?php 
					$val=array();
						
					echo form_dropdown('locality','',$val,'class="form-control form-control-lg chzn-select" id="locality" placeholder="locality" onchange="get_pincode()"');
					
					?>  
                    </div>
					
					
					<div class="form-group">
					<?php 
					$element = array('type'=>'text',
									'name'=>'pincode',
									'id'=>'pincode',
									'readonly'=>true,
									'class'=>'form-control form-control-lg',
									'placeholder'=>get_languageword('pincode')
									);
						
					echo form_input($element);
					?>  
                    </div>
					
					
					<div class="form-group">
					<?php 
					$element = array('type'=>'text',
									'name'=>'house_no',
									'id'=>'house_no',
									'class'=>'form-control form-control-lg',
									'placeholder'=>get_languageword('house_no')
									);
						
					echo form_input($element);
					?>  
                    </div>
					
					<div class="form-group">
					<?php 
					$element = array('type'=>'text',
									'name'=>'street',
									'id'=>'street',
									'class'=>'form-control form-control-lg',
									'placeholder'=>get_languageword('street')
									);
						
					echo form_input($element);
					?>  
                    </div>
					
					<div class="form-group">
					<?php 
					$element = array('type'=>'text',
									'name'=>'landmark',
									'id'=>'landmark',
									'class'=>'form-control form-control-lg',
									'placeholder'=>get_languageword('landmark')
									);
						
					echo form_input($element);
					?>  
                    </div>
					
					
                    <div class="form-group">
                        <button type="submit" name="add_address" class="btn btn-primary btn-block "><b><?php echo get_languageword('add');?></b></button>
                    </div>
					
                
				 
            </div>
      </div>
	  
	   <?php echo form_close();?>
    </div>
  </div>
</div>
<!--Add Address Modal-->



   
 <!--Default Address Modal-->
<div id="default-address-modal" class="modal fade login-component" role="dialog">
  <div class="modal-dialog ">
    <!-- Modal content-->
    <div class="modal-content">
	
	
	<?php 			
			 echo form_open(URL_USER_DEFAULT_ADDRESS);?>
			 
      <div class="modal-body">
       <div class="login-block">
	   
		   <button type="button" class="close modal-close" data-dismiss="modal">&times;</button>
		   
		   <div class="login-block-header text-center"><?php echo get_languageword('default_address');?></div>
			
			
			
			
			 
			<div class="form-group">
			
				<p><?php echo get_languageword('are_you_sure_to_set_this_address_as_your_default_address?');?> </p>
				
				<input type="hidden" name="default_adrs_id" id="default_adrs_id" value="0">
				
			</div>
				
			<div class="form-group">
			
				<button type="submit" name="default_address" class="btn btn-primary"><b><?php echo get_languageword('yes');?></b></button>
				
				 <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo get_languageword('no');?></button>
				 
			</div>
			
			
			 
		</div>
      </div>
	   <?php echo form_close();?>
	  
    </div>
  </div>
</div>
<!--Default Address Modal--> 


<script>
function delete_address(ua_id) {
	
	if (ua_id > 0) {
		$("#ua_id").val(ua_id);
	} else {
		$("#address-delete-modal").modal('hide');
	}
}

function default_address(ua_id) {
	
	if (ua_id > 0) {
		$("#default_adrs_id").val(ua_id);
	} else {
		$("#default-address-modal").modal('hide');
	}
}
</script>