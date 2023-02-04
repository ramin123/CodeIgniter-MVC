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

							$attributes = array('name'=>'pusher_notification_settings_from','id'=>'pusher_notification_settings_from');

							echo form_open(URL_PUSHER_NOTIFICATION_SETTINGS,$attributes);?>

                                <div class="col-md-6">

                                   

                                        <div class="form-group">

                                            <label><?php echo get_languageword('APP_ID').required_symbol();?></label>

											<?php

											$val='';

											if(isset($record) && !empty($record))

											{

												$val = $record->pusher_app_id;

											}

											else if(isset($_POST))

											{

												$val = set_value('pusher_app_id');

											}

											

											$element = array('name'=>'pusher_app_id',

											'value'=>$val,

											'class'=>'form-control');

											echo form_input($element).form_error('pusher_app_id');

											?>

                                        </div>

										

										<div class="form-group">

                                            <label><?php echo get_languageword('KEY').required_symbol();?></label>

											<?php

											$val='';

											if(isset($record) && !empty($record))

											{

												$val = $record->pusher_key;

											}

											else if(isset($_POST))

											{

												$val = set_value('pusher_key');

											}

											

											$element = array('name'=>'pusher_key',

											'value'=>$val,

											'class'=>'form-control');

											echo form_input($element).form_error('pusher_key');

											?>

                                        </div>
										
										
										<div class="form-group">

                                            <label><?php echo get_languageword('SECRET').required_symbol();?></label>

											<?php

											$val='';

											if(isset($record) && !empty($record))

											{

												$val = $record->pusher_secret;

											}

											else if(isset($_POST))

											{

												$val = set_value('pusher_secret');

											}

											

											$element = array('name'=>'pusher_secret',

											'value'=>$val,

											'class'=>'form-control');

											echo form_input($element).form_error('pusher_secret');

											?>

                                        </div>

										

                                        <div class="form-group pull-right">

								

										<button type="submit" name="pusher_notification_settings" value="pusher_notification_settings" class="btn btn-primary"><?php echo get_languageword('update');?></button>

										<a class="btn btn-warning" href="<?php echo URL_PUSHER_NOTIFICATION_SETTINGS;?>"><?php echo get_languageword('cancel');?></a>

										

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

        $('#pusher_notification_settings_from').bootstrapValidator({

            // To use feedback icons, ensure that you use Bootstrap v3.1.0 or later

            /* feedbackIcons: {

                valid: 'glyphicon glyphicon-ok',

                invalid: 'glyphicon glyphicon-remove',

                validating: 'glyphicon glyphicon-refresh'

            }, */

			framework: 'bootstrap',

            excluded: ':disabled',

            fields: {

                pusher_app_id: {

                    validators: {

                        notEmpty: {

                            message: '<?php echo get_languageword('pusher_app_id_required');?>'

                        }

                    }

                },

                pusher_key: {

                    validators: {

                        notEmpty: {

                            message: '<?php echo get_languageword('pusher_key_required');?>'

                        }

                        

                    }

                },
				
				pusher_secret: {

                    validators: {

                        notEmpty: {

                            message: '<?php echo get_languageword('pusher_secret_required');?>'

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