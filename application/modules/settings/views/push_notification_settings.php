  <div id="page-wrapper">
            
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
							<?php
							$attributes = array('name'=>'push_notification_settings_from','id'=>'push_notification_settings_from');
							echo form_open(URL_PUSH_NOTIFICATION_SETTINGS,$attributes);?>
                                <div class="col-md-6">
                                   
                                        <div class="form-group">
                                            <label><?php echo get_languageword('one_signal_server_api_key').required_symbol();?></label>
											<?php
											$val='';
											if(isset($record) && !empty($record))
											{
												$val = $record->one_signal_server_api_key;
											}
											else if(isset($_POST))
											{
												$val = set_value('one_signal_server_api_key');
											}
											
											$element = array('name'=>'one_signal_server_api_key',
											'value'=>$val,
											'class'=>'form-control');
											echo form_input($element).form_error('one_signal_server_api_key');
											?>
                                        </div>
										
										<div class="form-group">
                                            <label><?php echo get_languageword('one_signal_app_id').required_symbol();?></label>
											<?php
											$val='';
											if(isset($record) && !empty($record))
											{
												$val = $record->one_signal_app_id;
											}
											else if(isset($_POST))
											{
												$val = set_value('one_signal_app_id');
											}
											
											$element = array('name'=>'one_signal_app_id',
											'value'=>$val,
											'class'=>'form-control');
											echo form_input($element).form_error('one_signal_app_id');
											?>
                                        </div>
										
                                        <div class="form-group pull-right">
								
										<button type="submit" name="push_notification_settings" value="push_notification_settings" class="btn btn-primary"><?php echo get_languageword('update');?></button>
										<a class="btn btn-warning" href="<?php echo URL_PUSH_NOTIFICATION_SETTINGS;?>"><?php echo get_languageword('cancel');?></a>
										
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

        $('#push_notification_settings_from').bootstrapValidator({
            // To use feedback icons, ensure that you use Bootstrap v3.1.0 or later
            /* feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            }, */
			framework: 'bootstrap',
            excluded: ':disabled',
            fields: {
                one_signal_server_api_key: {
                    validators: {
                        notEmpty: {
                            message: '<?php echo get_languageword('one_signal_server_api_key_required');?>'
                        }
                    }
                },
                one_signal_app_id: {
                    validators: {
                        notEmpty: {
                            message: '<?php echo get_languageword('one_signal_app_id_required');?>'
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