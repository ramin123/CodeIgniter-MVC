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
							$attributes = array('name'=>'point_settings_form','id'=>'point_settings_form');
							echo form_open(URL_POINTS_SETTINGS,$attributes);?>
                                <div class="col-md-6">
                                   
                                        <div class="form-group">
                                            <label><?php echo get_languageword('points_label_redeem_placeholder').required_symbol();?></label>
											<?php
											$val='';
											if(isset($record) && !empty($record))
											{
												$val = $record->points_label_redeem_placeholder;
											}
											else if(isset($_POST))
											{
												$val = set_value('points_label_redeem_placeholder');
											}
											
											$element = array('name'=>'points_label_redeem_placeholder',
											'value'=>$val,
											'class'=>'form-control');
											echo form_input($element).form_error('points_label_redeem_placeholder');
											?>
                                        </div>
										
										 <div class="form-group">
                                            <label><?php echo get_languageword('points_label_earn').required_symbol();?></label>
											<?php
											$val='';
											if(isset($record) && !empty($record))
											{
												$val = $record->points_label_earn;
											}
											else if(isset($_POST))
											{
												$val = set_value('points_label_earn');
											}
											
											$element = array('name'=>'points_label_earn',
											'value'=>$val,
											'class'=>'form-control');
											echo form_input($element).form_error('points_label_earn');
											?>
                                        </div>
										
										 <div class="form-group">
                                            <label><?php echo get_languageword('points_label_template').required_symbol();?></label>
											<?php
											$val='';
											if(isset($record) && !empty($record))
											{
												$val = $record->points_label_template;
											}
											else if(isset($_POST))
											{
												$val = set_value('points_label_template');
											}
											
											$element = array('name'=>'points_label_template',
											'value'=>$val,
											'class'=>'form-control');
											echo form_input($element).form_error('points_label_template');
											?>
                                        </div>
										
										<div class="form-group">
                                            <label><?php echo get_languageword('earning_points_for_customer_for_an_order').required_symbol();?></label>
											<?php
											$val='';
											if(isset($record) && !empty($record))
											{
												$val = $record->maximum_earning_points_for_customer;
											}
											else if(isset($_POST))
											{
												$val = set_value('maximum_earning_points_for_customer');
											}
											
											$element = array('name'=>'maximum_earning_points_for_customer',
											'value'=>$val,
											'class'=>'form-control');
											echo form_input($element).form_error('maximum_earning_points_for_customer');
											?>
                                        </div>
									
									
								<!--div class="form-group">
									<label><?php //echo get_languageword('points_earn_apply_only_on_the_following_payment_options').required_symbol();?></label>
									<?php
									/* $val='';
									if(isset($record) && !empty($record))
									{
										$val = explode(",",$record->payment_options);
									}
									else if(isset($_POST))
									{
										$val = set_value('payment_options');
									}
									
									$options = array(
									'cash' => get_languageword('cash on delivery'),
									'paypal' => get_languageword('paypal'),
									'stripe' => get_languageword('stripe'),
									);
									
								 echo form_dropdown('payment_options[]',$options,$val,'class="chzn-select" multiple').form_error('payment_options'); */
									?>
								</div-->
										
										
								<legend><?php  echo get_languageword('earning points conversion settings');?></legend>
								
								<div class="form-group">
									<label><?php echo get_languageword('earning_point').required_symbol();?></label>
									<?php
									$val='';
									if(isset($record) && !empty($record))
									{
										$val = $record->earning_point;
									}
									else if(isset($_POST))
									{
										$val = set_value('earning_point');
									}
									
									$element = array('name'=>'earning_point',
									'value'=>$val,
									'class'=>'form-control');
									echo form_input($element).form_error('earning_point');
									?>
								</div>
								
								<div class="form-group">
									<label><?php echo get_languageword('earning_point_value_in_').$this->config->item('site_settings')->currency_symbol.required_symbol();?></label>
									<?php
									$val='';
									if(isset($record) && !empty($record))
									{
										$val = $record->earning_point_value;
									}
									else if(isset($_POST))
									{
										$val = set_value('earning_point_value');
									}
									
									$element = array('name'=>'earning_point_value',
									'value'=>$val,
									'class'=>'form-control');
									echo form_input($element).form_error('earning_point_value');
									?>
								</div>
								
								<legend><?php  echo get_languageword('redeeming_points_conversion_settings');?></legend>
								
								
								<div class="form-group">
									<label><?php echo get_languageword('redeeming_point').required_symbol();?></label>
									<?php
									$val='';
									if(isset($record) && !empty($record))
									{
										$val = $record->redeeming_point;
									}
									else if(isset($_POST))
									{
										$val = set_value('redeeming_point');
									}
									
									$element = array('name'=>'redeeming_point',
									'value'=>$val,
									'class'=>'form-control');
									echo form_input($element).form_error('redeeming_point');
									?>
								</div>
								
								<div class="form-group">
									<label><?php echo get_languageword('redeeming_point_value_in_').$this->config->item('site_settings')->currency_symbol.required_symbol();?></label>
									<?php
									$val='';
									if(isset($record) && !empty($record))
									{
										$val = $record->redeeming_point_value;
									}
									else if(isset($_POST))
									{
										$val = set_value('redeeming_point_value');
									}
									
									$element = array('name'=>'redeeming_point_value',
									'value'=>$val,
									'class'=>'form-control');
									echo form_input($element).form_error('redeeming_point_value');
									?>
								</div>

								
								
								
								
								
								<div class="form-group">
									<label><?php echo get_languageword('enable_redeeming').required_symbol();?></label>
									<?php
									$checked=false;
									if(isset($record) && $record->enable_redeeming=='Yes')
									{
										$checked='checked';
									}
									?>
									<div class="digiCrud">
									<div class="slideThree slideBlue">
									<input type="checkbox" class="crunch-vanish" id="enable_redeeming" name="enable_redeeming" <?php echo $checked;?> />
									<label for="enable_redeeming"></label>
									</div>
									</div>
								</div>
								
								
								</div>
								
								<div class="col-md-6">
									
								 <legend><?php echo get_languageword('points_earned_for_actions');?></legend>
								
								 
								<div class="form-group">
									<label><?php echo get_languageword('reward_points_for_account_signup').required_symbol();?></label>
									<?php
									$val='';
									if(isset($record) && !empty($record))
									{
										$val = $record->reward_points_for_account_signup;
									}
									else if(isset($_POST))
									{
										$val = set_value('reward_points_for_account_signup');
									}
									
									$element = array('name'=>'reward_points_for_account_signup',
									'value'=>$val,
									'class'=>'form-control');
									echo form_input($element).form_error('reward_points_for_account_signup');
									?>
								</div>
								 
								<div class="form-group">
									<label><?php echo get_languageword('reward_points_for_first_order').required_symbol();?></label>
									<?php
									$val='';
									if(isset($record) && !empty($record))
									{
										$val = $record->points_for_first_order;
									}
									else if(isset($_POST))
									{
										$val = set_value('points_for_first_order');
									}
									
									$element = array('name'=>'points_for_first_order',
									'value'=>$val,
									'class'=>'form-control');
									echo form_input($element).form_error('points_for_first_order');
									?>
								</div>
								
								<div class="form-group">
									<label><?php echo get_languageword('reward_points_for_sharing_app').required_symbol();?></label>
									<?php
									$val='';
									if(isset($record) && !empty($record))
									{
										$val = $record->points_for_sharing_app;
									}
									else if(isset($_POST))
									{
										$val = set_value('points_for_sharing_app');
									}
									
									$element = array('name'=>'points_for_sharing_app',
									'value'=>$val,
									'class'=>'form-control');
									echo form_input($element).form_error('points_for_sharing_app');
									?>
								</div>
								
								<div class="form-group">
									<label><?php echo get_languageword('minimum_points_can_be_used').required_symbol();?></label>
									<?php
									$val='';
									if(isset($record) && !empty($record))
									{
										$val = $record->minimum_points_can_be_used;
									}
									else if(isset($_POST))
									{
										$val = set_value('minimum_points_can_be_used');
									}
									
									$element = array('name'=>'minimum_points_can_be_used',
									'value'=>$val,
									'class'=>'form-control');
									echo form_input($element).form_error('minimum_points_can_be_used');
									?>
								</div>
								
								<div class="form-group">
									<label><?php echo get_languageword('maximum_points_can_be_used').required_symbol();?></label>
									<?php
									$val='';
									if(isset($record) && !empty($record))
									{
										$val = $record->maximum_points_can_be_used;
									}
									else if(isset($_POST))
									{
										$val = set_value('maximum_points_can_be_used');
									}
									
									$element = array('name'=>'maximum_points_can_be_used',
									'value'=>$val,
									'class'=>'form-control');
									echo form_input($element).form_error('maximum_points_can_be_used');
									?>
								</div>
								
								<div class="form-group">
									<label><?php echo get_languageword('enabled_points_system').required_symbol();?></label>
									<?php
									$checked=false;
									if(isset($record) && $record->points_enabled=='Yes')
									{
										$checked='checked';
									}
									?>
									<div class="digiCrud">
									<div class="slideThree slideBlue">
									<input type="checkbox" class="crunch-vanish" id="points_enabled" name="points_enabled" <?php echo $checked;?> />
									<label for="points_enabled"></label>
									</div>
									</div>
								</div>
								
								
								
								<div class="form-group pull-right">
								
								<button type="submit" name="point_settings" value="point_settings" class="btn btn-primary"><?php echo get_languageword('update');?></button>
                                <a class="btn btn-warning" href="<?php echo URL_POINTS_SETTINGS;?>"><?php echo get_languageword('cancel');?></a>
								
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

        $('#point_settings_form').bootstrapValidator({
            // To use feedback icons, ensure that you use Bootstrap v3.1.0 or later
            /* feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            }, */
			framework: 'bootstrap',
            excluded: ':disabled',
            fields: {
                points_label_redeem_placeholder: {
                    validators: {
                        notEmpty: {
                            message: '<?php echo get_languageword('points_label_redeem_placeholder_required');?>'
                        }
                    }
                },
                points_label_earn: {
                    validators: {
                        notEmpty: {
                            message: '<?php echo get_languageword('points_label_earn_required');?>'
                        }
                    }
                },
				points_label_template: {
                    validators: {
                        notEmpty: {
                            message: '<?php echo get_languageword('points_label_template_required');?>'
                        }
                    }
                },
				maximum_earning_points_for_customer: {
                    validators: {
                        notEmpty: {
                            message: '<?php echo get_languageword('maximum_earning_points_for_customer_required');?>'
                        }
                    }
                },
				earning_point: {
                    validators: {
                        notEmpty: {
                            message: '<?php echo get_languageword('earning_point_required');?>'
                        }
                    }
                },
				earning_point_value: {
                    validators: {
                        notEmpty: {
                            message: '<?php echo get_languageword('earning_point_value_required');?>'
                        },						regexp: {							regexp: /(?:\d*\.)?\d+/,							message: '<?php echo get_languageword('please_enter_valid_value');?>'						}
                    }
                },
				redeeming_point: {
                    validators: {
                        notEmpty: {
                            message: '<?php echo get_languageword('redeeming_point_required');?>'
                        }
                    }
                },
				redeeming_point_value: {
                    validators: {
                        notEmpty: {
                            message: '<?php echo get_languageword('redeeming_point_value_required');?>'
                        },						regexp: {							regexp: /(?:\d*\.)?\d+/,							message: '<?php echo get_languageword('please_enter_valid_value');?>'						}
                    }
                },
				reward_points_for_account_signup: {
                    validators: {
                        notEmpty: {
                            message: '<?php echo get_languageword('reward_points_for_account_signup_required');?>'
                        }
                    }
                },
				points_for_first_order: {
                    validators: {
                        notEmpty: {
                            message: '<?php echo get_languageword('points_for_first_order_required');?>'
                        }
                    }
                },
				points_for_sharing_app: {
                    validators: {
                        notEmpty: {
                            message: '<?php echo get_languageword('points_for_sharing_app_required');?>'
                        }
                    }
                },
				minimum_points_can_be_used: {
                    validators: {
                        notEmpty: {
                            message: '<?php echo get_languageword('minimum_points_can_be_used_required');?>'
                        }
                    }
                },
				maximum_points_can_be_used: {
                    validators: {
                        notEmpty: {
                            message: '<?php echo get_languageword('maximum_points_can_be_used_required');?>'
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