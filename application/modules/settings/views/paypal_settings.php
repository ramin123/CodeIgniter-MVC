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

							$attributes = array('name'=>'paypal_settings_from','id'=>'paypal_settings_from');

							echo form_open(URL_PAYPAL_SETTINGS,$attributes);?>
							
                                <div class="col-md-6">
                                	

                                   <small><?php echo get_languageword('paypal_details_for_app');?></small>

                                        <div class="form-group">

                                            <label><?php echo get_languageword('paypal_environment_production').required_symbol();?></label>

											<?php

											$val='';

											if(isset($record) && !empty($record))

											{

												$val = $record->PayPalEnvironmentProduction;

											}

											else if(isset($_POST))

											{

												$val = set_value('PayPalEnvironmentProduction');

											}

											

											$element = array('name'=>'PayPalEnvironmentProduction',

											'value'=>$val,

											'class'=>'form-control');

											echo form_input($element).form_error('PayPalEnvironmentProduction');

											?>

                                        </div>

										

										<div class="form-group">

                                            <label><?php echo get_languageword('paypal_environment_sandbox').required_symbol();?></label>

											<?php

											$val='';

											if(isset($record) && !empty($record))

											{

												$val = $record->PayPalEnvironmentSandbox;

											}

											else if(isset($_POST))

											{

												$val = set_value('PayPalEnvironmentSandbox');

											}

											

											$element = array('name'=>'PayPalEnvironmentSandbox',

											'value'=>$val,

											'class'=>'form-control');

											echo form_input($element).form_error('PayPalEnvironmentSandbox');

											?>

                                        </div>

										

                                        <div class="form-group">

                                            <label><?php echo get_languageword('merchant_name').required_symbol();?></label>

											<?php

											$val='';

											if(isset($record) && !empty($record))

											{

												$val = $record->merchantName;

											}

											else if(isset($_POST))

											{

												$val = set_value('merchantName');

											}

											

											$element = array('name'=>'merchantName',

											'value'=>$val,

											'class'=>'form-control');

											echo form_input($element).form_error('merchantName');

											?>

                                        </div>

										

										<div class="form-group">

                                            <label><?php echo get_languageword('merchant_privacy_policy_url').required_symbol();?></label>

											<?php

											$val='';

											if(isset($record) && !empty($record))

											{

												$val = $record->merchantPrivacyPolicyURL;

											}

											else if(isset($_POST))

											{

												$val = set_value('merchantPrivacyPolicyURL');

											}

											

											$element = array('name'=>'merchantPrivacyPolicyURL',

											'value'=>$val,

											'class'=>'form-control');

											echo form_input($element).form_error('merchantPrivacyPolicyURL');

											?>

                                        </div>

										

										<div class="form-group">

										<label><?php echo get_languageword('merchant_user_agreement_url').required_symbol();?></label>

										<?php

										$val='';

										if(isset($record) && !empty($record))

										{

											$val = $record->merchantUserAgreementURL;

										}

										else if(isset($_POST))

										{

											$val = set_value('merchantUserAgreementURL');

										}

										

										$element = array('name'=>'merchantUserAgreementURL',

										'value'=>$val,

										'class'=>'form-control');

										echo form_input($element).form_error('merchantUserAgreementURL');

										?>

									</div>

										

								</div>

								
								<div class="col-md-6">

								

									<div class="form-group">

										<label><?php echo get_languageword('paypal_email').required_symbol();?></label>

										<?php

										$val='';

										if(isset($record) && !empty($record))

										{

											$val = $record->paypal_email;

										}

										else if(isset($_POST))

										{

											$val = set_value('paypal_email');

										}

										

										$element = array('name'=>'paypal_email',

										'value'=>$val,

										'class'=>'form-control');

										echo form_input($element).form_error('paypal_email');

										?>

									</div>

										

								<div class="form-group">

									<label><?php echo get_languageword('currency').required_symbol();?></label>

									<?php

									$val='';

									if(isset($record) && !empty($record))

									{

										$val = $record->currency;

									}

									else if(isset($_POST))

									{

										$val = set_value('currency');

									}

									

									echo form_dropdown('currency',$currency_options,$val,'class="form-control chzn-select"');

									echo form_error('currency');

									?>

								</div>

									

								<div class="form-group">

									<label><?php echo get_languageword('account_type').required_symbol();?></label>

									<?php

									$options = array('sandbox'=>get_languageword('sandbox'),

									'production'=>get_languageword('production'));

									$val='';

									if(isset($record) && !empty($record))

									{

										$val = $record->account_type;

									}

									else if(isset($_POST))

									{

										$val = set_value('account_type');

									}

									

									echo form_dropdown('account_type',$options,$val,'class="form-control chzn-select" ');

									echo form_error('account_type');

									?>

								</div>

								

								<div class="form-group">

									<label><?php echo get_languageword('status').required_symbol();?></label>

									<?php

									$options = array('Active'=>get_languageword('active'),

									'Inactive'=>get_languageword('inactive'));

									$val='';

									if(isset($record) && !empty($record))

									{

										$val = $record->status;

									}

									else if(isset($_POST))

									{

										$val = set_value('status');

									}

									

									echo form_dropdown('status',$options,$val,'class="form-control chzn-select" ');

									echo form_error('status');

									?>

								</div>

								

								<div class="form-group">

								

								<button type="submit" name="paypal_settings" value="paypal_settings" class="btn btn-primary"><?php echo get_languageword('update');?></button>

                                <a class="btn btn-warning" href="<?php echo URL_PAYPAL_SETTINGS;?>"><?php echo get_languageword('cancel');?></a>

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



        $('#paypal_settings_from').bootstrapValidator({

            // To use feedback icons, ensure that you use Bootstrap v3.1.0 or later

            /* feedbackIcons: {

                valid: 'glyphicon glyphicon-ok',

                invalid: 'glyphicon glyphicon-remove',

                validating: 'glyphicon glyphicon-refresh'

            }, */

			framework: 'bootstrap',

            excluded: ':disabled',

            fields: {

                PayPalEnvironmentProduction: {

                    validators: {

                        notEmpty: {

                            message: '<?php echo get_languageword('paypal_environment_production_required');?>'

                        }

                    }

                },

                PayPalEnvironmentSandbox: {

                    validators: {

                        notEmpty: {

                            message: '<?php echo get_languageword('paypal_environment_sandbox_required');?>'

                        }

                        

                    }

                },

				merchantName: {

                    validators: {

                        notEmpty: {

                            message: '<?php echo get_languageword('merchant_name_required');?>'

                        }

                        

                    }

                },

				merchantPrivacyPolicyURL: {

                    validators: {

                        notEmpty: {

                            message: '<?php echo get_languageword('merchant_privacy_policy_url_required');?>'

                        }

                        

                    }

                },

				merchantUserAgreementURL: {

                    validators: {

                        notEmpty: {

                            message: '<?php echo get_languageword('merchant_user_agreement_url_required');?>'

                        }

                        

                    }

                },

				paypal_email: {

                    validators: {

                        notEmpty: {

                            message: '<?php echo get_languageword('paypal_email_required');?>'

                        }

                        

                    }

                },

				currency: {

                    validators: {

                        notEmpty: {

                            message: '<?php echo get_languageword('currency_required');?>'

                        }

                        

                    }

                },

				account_type: {

                    validators: {

                        notEmpty: {

                            message: '<?php echo get_languageword('account_type_required');?>'

                        }

                        

                    }

                },

				status: {

                    validators: {

                        notEmpty: {

                            message: '<?php echo get_languageword('status_required');?>'

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