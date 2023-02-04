  <div id="page-wrapper">
            <div >
                
               <div class="row">
                <div class="col-md-12">
				<?php echo $this->session->flashdata('message'); ?>
                    <!-- Form Elements -->
                    <div class="panel panel-default">
						
                        <div class="panel-heading">
                            <?php if(isset($pagetitle)) echo $pagetitle;?>
                        </div>
                        <div class="panel-body">
						 
                            <div class="row">
							
							
             <div class="col-md-6">
                                   
				<div class="form-group">
				
				<label><?php echo get_languageword('service_url');?>: 
				</label>
				
				<?php echo SITEURL.'service/';?>
				</div>
				
				
				
				
				
				<div class="form-group">
				<label><?php echo get_languageword('menu_image_url');?> :
				</label>
				<?php echo MENU_IMG_PATH;?>
				</div>
				
				<div class="form-group">
				<label><?php echo get_languageword('menu_image_thumb_url');?> :
				</label>
				<?php echo MENU_IMG_THUMB_PATH;?>
				</div>
				
				
				
				<div class="form-group">
				<label><?php echo get_languageword('item_image_url');?> :
				</label>
				<?php echo ITEM_IMG_PATH;?>
				</div>	

				
				<div class="form-group">
				<label><?php echo get_languageword('item_image_thumb_url');?> :
				</label>
				<?php echo ITEM_IMG_THUMB_PATH;?>
				</div>
				
				
				
               <div class="form-group">
					<label><?php echo get_languageword('addon_image_url');?> :
					</label>
					<?php echo ADDON_IMG_PATH;?>
			  </div>
				
				
				
			  <div class="form-group">
					<label><?php echo get_languageword('addon_image_thumb_url');?> :
					</label>
					<?php echo ADDON_IMG_THUMB_PATH;?>
			  </div>
				
				
				
				
			  <div class="form-group">
					<label><?php echo get_languageword('offer_image_url');?> :
					</label>
					<?php echo OFFER_IMG_PATH;?>
			  </div>
			  
			  
			  <div class="form-group">
					<label><?php echo get_languageword('offer_image_thumb_url');?> :
					</label>
					<?php echo OFFER_IMG_THUMB_PATH;?>
			  </div>
			  
				
				
								</div>
							
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