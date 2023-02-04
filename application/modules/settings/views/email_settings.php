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

							$attributes = array('name'=>'email_settings_from','id'=>'email_settings_from');

							echo form_open(URL_EMAIL_SETTINGS,$attributes);?>

                                <div class="col-md-6">

								<div class="form-group">

									<div class="radio">

										<label> <?php echo get_languageword('web_mail').required_symbol();?>

										

										<input type="radio" name="mail_config" value="webmail" <?php if (isset($record->mail_config) && $record->mail_config == 'webmail') echo 'checked="checked" '; ?>>

										</label>

									 </div>

								</div>

								

                                   

                                        <div class="form-group">

                                            <label><?php echo get_languageword('smtp_host').required_symbol();?></label>

											<?php

											$val='';

											if(isset($record) && !empty($record))

											{

												$val = $record->smtp_host;

											}

											else if(isset($_POST))

											{

												$val = set_value('smtp_host');

											}

											

											$element = array('name'=>'smtp_host',

											'value'=>$val,

											'class'=>'form-control');

											echo form_input($element).form_error('smtp_host');

											?>

                                        </div>

										

										<div class="form-group">

                                            <label><?php echo get_languageword('smtp_port').required_symbol();?></label>

											<?php

											$val='';

											if(isset($record) && !empty($record))

											{

												$val = $record->smtp_port;

											}

											else if(isset($_POST))

											{

												$val = set_value('smtp_port');

											}

											

											$element = array('name'=>'smtp_port',

											'value'=>$val,

											'class'=>'form-control');

											echo form_input($element).form_error('smtp_port');

											?>

                                        </div>

										

                                        <div class="form-group">

                                            <label><?php echo get_languageword('smtp_user').required_symbol();?></label>

											<?php

											$val='';

											if(isset($record) && !empty($record))

											{

												$val = $record->smtp_user;

											}

											else if(isset($_POST))

											{

												$val = set_value('smtp_user');

											}

											

											$element = array('name'=>'smtp_user',

											'value'=>$val,

											'class'=>'form-control');

											echo form_input($element).form_error('smtp_user');

											?>

                                        </div>

										

										

									<div class="form-group">

										<label><?php echo get_languageword('smtp_password').required_symbol();?></label>

										<?php

										$val='';

										if(isset($record) && !empty($record))

										{

											$val = $record->smtp_password;

										}

										else if(isset($_POST))

										{

											$val = set_value('smtp_password');

										}

										

										$element = array('name'=>'smtp_password',

										'value'=>$val,

										'class'=>'form-control',

										'type'=>'password');

										echo form_input($element).form_error('smtp_password');

										?>

									</div>

										

								</div>

								

								<div class="col-md-6">

								

								<div class="form-group">

									<div class="radio">

										<label> <?php echo get_languageword('mandrill').required_symbol();?>

										

										<input type="radio" name="mail_config" value="mandrill" <?php if (isset($record->mail_config) && $record->mail_config == 'mandrill') echo 'checked="checked" ';?>>

										</label>

									 </div>

								</div>

								

								<div class="form-group">

										<label><?php echo get_languageword('api_key').required_symbol();?></label>

										<?php

										$val='';

										if(isset($record) && !empty($record))

										{

											$val = $record->api_key;

										}

										else if(isset($_POST))

										{

											$val = set_value('api_key');

										}

										

										$element = array('name'=>'api_key',

										'value'=>$val,

										'class'=>'form-control');

										echo form_input($element).form_error('api_key');

										?>

									</div>

									

								

								<div class="form-group">

								

								<button type="submit" name="email_settings" value="email_settings" class="btn btn-primary"><?php echo get_languageword('update');?></button>

                                <a class="btn btn-warning" href="<?php echo URL_EMAIL_SETTINGS;?>"><?php echo get_languageword('cancel');?></a>

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



        $('#email_settings_from').bootstrapValidator({

            // To use feedback icons, ensure that you use Bootstrap v3.1.0 or later

            /* feedbackIcons: {

                valid: 'glyphicon glyphicon-ok',

                invalid: 'glyphicon glyphicon-remove',

                validating: 'glyphicon glyphicon-refresh'

            }, */

			framework: 'bootstrap',

            excluded: ':disabled',

            fields: {

                smtp_host: {

                    validators: {

                        notEmpty: {

                            message: '<?php echo get_languageword('smtp_host_required');?>'

                        }

                    }

                },

                smtp_port: {

                    validators: {

                        notEmpty: {

                            message: '<?php echo get_languageword('smtp_port_required');?>'

                        }

                        

                    }

                },

				smtp_user: {

                    validators: {

                        notEmpty: {

                            message: '<?php echo get_languageword('smtp_user_required');?>'

                        }

                        

                    }

                },

				smtp_password: {

                    validators: {

                        notEmpty: {

                            message: '<?php echo get_languageword('smtp_password_required');?>'

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