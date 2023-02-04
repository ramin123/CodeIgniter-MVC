  <div id="page-wrapper">
          
                
               <div class="row">
                <div class="col-md-12">
				<?php echo $this->session->flashdata('message'); ?>
                    <!-- Form Elements -->
                    <div class="panel panel-default">
						
                        <div class="panel-heading">
                            <?php if(isset($pagetitle)) echo $pagetitle;?>														<a title="<?php echo get_languageword('go_to_list'); ?>" class="btn btn-primary btn-xs pull-right" href="<?php echo URL_SMS_GATEWAYS;?>"><i class="fa fa-list"></i>							</a>
                        </div>
                        <div class="panel-body">
						 
                            <div class="row">
							<?php
							$attributes = array('name'=>'sms_fields_from','id'=>'sms_fields_from');
							echo form_open(URL_UPDATE_SMS_FIELD_VALUDS,$attributes);?>
							
                                <div class="col-md-6">
                                   
					<?php 
                    foreach($sms_gateway_details as $row):?>
						
					<div class="form-group">
                     <label><?php echo $row->field_name; ?><span style="color:red;">*</span></label>
                     <?php
                     if($row->is_required == 'No') {
							$element = array(
								'type' => 'text',
								'name'	=>	'setting_'.$row->field_id,
								'id'	=>	'setting_'.$row->field_id,
								'value'	=>	(isset($row->field_output_value)) ? $row->field_output_value : '',
								'class'=>'form-control'
							);
						} else {
							$element = array(
								'type' => 'text',
								'name'	=>	'setting_'.$row->field_id,
								'id'	=>	'setting_'.$row->field_id,
								'value'	=>	(isset($row->field_output_value)) ? $row->field_output_value : '',
								'required' => 'required',
								'class'=>'form-control'
							);
						}
						echo form_input($element);
						?>
                  </div>
                  <?php endforeach; ?>
					
					<div class="form-group pull-right">
					<button type="submit" name="update_sms_gateway" value="update_sms_gateway" class="btn btn-primary"><?php echo get_languageword('update');?></button>
					
					<a class="btn btn-warning" href="<?php echo URL_SMS_GATEWAYS;?>"><?php echo get_languageword('cancel');?></a>
					</div>
					
					
                           </div>
								<?php echo form_close();?>
                            </div>
                        </div>
                    </div>
                     <!-- End Form Elements -->
                </div>
            </div>
   
        <!-- /. PAGE INNER  -->
            </div>
        <!-- /. PAGE WRAPPER  -->