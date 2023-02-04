  <div id="page-wrapper">
           
               
               <div class="row">
                <div class="col-md-12">
				<?php echo $this->session->flashdata('message'); ?>
                    <!-- Form Elements -->
                    <div class="panel panel-default">
						
                        <div class="panel-heading">
                            <?php if(isset($pagetitle)) echo $pagetitle;?>
							
							<a title="<?php echo get_languageword('go_to_list'); ?>" class="btn btn-primary btn-xs pull-right" href="<?php echo URL_DELIVERY_LOCATIONS; ?>"><i class="fa fa-list"></i>
							</a>
                        </div>
                        <div class="panel-body">
						 
                            <div class="row">
							<?php
						$attributes = array('name'=>'location_form','id'=>'location_form');
						echo form_open(URL_ADDEDIT_DELIVERY_LOCATION,$attributes);?>
							
                       <div class="col-md-6">
					   
                      <div class="form-group">
						<label><?php echo get_languageword('city').required_symbol();?></label>
						<?php
						$val='';
						if(isset($record) && !empty($record))
						{
							$val = $record->city_id;
						}
						else if(isset($_POST))
						{
							$val = set_value('city_id');
						}
						echo form_dropdown('city_id',$cities_options,$val,'class="chzn-select form-control"').form_error('city_id');
						?>
					  </div>
					  
					<div class="form-group">
						<label><?php echo get_languageword('locality').required_symbol();?></label>
						<?php
						$val='';
						if(isset($record) && !empty($record))
						{
							$val = $record->locality;
						}
						else if(isset($_POST))
						{
							$val = set_value('locality');
						}
						
						$element = array('name'=>'locality',
						'value'=>$val,
						'class'=>'form-control');
						echo form_input($element).form_error('locality');
						?>
					  </div>
					  
					<div class="form-group">
					   <label><?php echo get_languageword('pincode').required_symbol();?></label>
						<?php
						$val='';
						if(isset($record) && !empty($record))
						{
							$val = $record->pincode;
						}
						else if(isset($_POST))
						{
							$val = set_value('pincode');
						}
						
						$element = array('name'=>'pincode',
						'value'=>$val,
						'class'=>'form-control');
						echo form_input($element).form_error('pincode');
						?>
					</div>
					
					<div class="form-group">
						<label><?php echo get_languageword('status').required_symbol();?></label>
						<?php
						$val='';
						if(isset($record) && !empty($record))
						{
							$val = $record->status;
						}
						else if(isset($_POST))
						{
							$val = set_value('status');
						}
						echo form_dropdown('status',activeinactive(),$val,'class="chzn-select form-control"').form_error('status');
						?>
					  </div>
					  
					  </div>
					  
					  
					   <div class="col-md-6">
					   
					  
					  <div class="form-group">
					   <label><?php echo get_languageword('delivery_fee')?></label>
						<?php
						$val='';
						if(isset($record) && !empty($record))
						{
							$val = $record->delivery_fee;
						}
						else if(isset($_POST))
						{
							$val = set_value('delivery_fee');
						}
						
						$element = array('name'=>'delivery_fee',
						'value'=>$val,
						'class'=>'form-control');
						echo form_input($element).form_error('delivery_fee');
						?>
					</div>
										<div class="form-group">						<label><?php echo get_languageword('delivery_time_units').required_symbol();?></label>						<?php						$options=array(						'minutes'=>get_languageword('minutes'),						'hours'=>get_languageword('hours'));						$val='';						if(isset($record) && !empty($record))						{							$val = $record->delivery_time_units;						}						else if(isset($_POST))						{							$val = set_value('delivery_time_units');						}						echo form_dropdown('delivery_time_units',$options,$val,'class="chzn-select form-control"').form_error('delivery_time_units');						?>					  </div>
					<div class="form-group">
					   <label><?php echo get_languageword('delivery_from_time')?></label>
						<?php
						$val='';
						if(isset($record) && !empty($record))
						{
							$val = $record->delivery_from_time;
						}
						else if(isset($_POST))
						{
							$val = set_value('delivery_from_time');
						}
						
						$element = array('name'=>'delivery_from_time',
						'value'=>$val,
						'class'=>'form-control');
						echo form_input($element).form_error('delivery_from_time');
						?>
					</div>
					
					<div class="form-group">
					   <label><?php echo get_languageword('delivery_to_time')?></label>
						<?php
						$val='';
						if(isset($record) && !empty($record))
						{
							$val = $record->delivery_to_time;
						}
						else if(isset($_POST))
						{
							$val = set_value('delivery_to_time');
						}
						
						$element = array('name'=>'delivery_to_time',
						'value'=>$val,
						'class'=>'form-control');
						echo form_input($element).form_error('delivery_to_time');
						?>
					</div>
					<div class="form-group pull-right">
						<?php 
						$value='';
						if(isset($record))
						{
							$value = $record->service_provide_location_id;
						}
						echo form_hidden('service_provide_location_id',$value);?>
						
						<button type="submit" name="addedit_location" value="addedit_location" class="btn btn-primary"><?php echo get_languageword('save');?></button>
						
						<a class="btn btn-warning" href="<?php echo URL_DELIVERY_LOCATIONS;?>"><?php echo get_languageword('cancel');?></a>
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
		
		
<!-- Form Validation Plugins /Start -->
<?php if(!empty($css_js_files) && in_array('form_validation', $css_js_files)) { ?>

<link href="<?php echo CSS_ADMIN_OR_BOOTSTRAP_VALIDATOR;?>" rel="stylesheet">
<script type="text/javascript" src="<?php echo JS_ADMIN_BOOTSTRAP_VALIDATOR;?>"></script>
<script type="text/javascript">
    $(document).ready(function () {
		
        $('#location_form').bootstrapValidator({
            // To use feedback icons, ensure that you use Bootstrap v3.1.0 or later
            /* feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            }, */
			framework: 'bootstrap',
            excluded: ':disabled',
            fields: {
                city_id: {
                    validators: {
                        notEmpty: {
                            message: '<?php echo get_languageword('city_required');?>'
                        }
                    }
                },
				locality: {
                    validators: {
                        notEmpty: {
                            message: '<?php echo get_languageword('locality_required');?>'
                        }
                    }
                },
				pincode: {
                    validators: {
                        notEmpty: {
                            message: '<?php echo get_languageword('pincode_required');?>'
                        }
                    }
                }
            },
			 submitHandler: function(validator, form, submitButton) {
				form.submit();
			}
        })
    });
</script>
<?php } ?>