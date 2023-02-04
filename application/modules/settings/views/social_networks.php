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
							$attributes = array('name'=>'social_networks_form','id'=>'social_networks_form');
							echo form_open(URL_SOCIAL_NETWORKS,$attributes);?>
                                <div class="col-md-6">
                                   
                                        <div class="form-group">
                                            <label><?php echo get_languageword('facebook');?></label>
											<?php
											$val='';
											if(isset($record) && !empty($record))
											{
												$val = $record->facebook;
											}
											else if(isset($_POST))
											{
												$val = set_value('facebook');
											}
											
											$element = array('name'=>'facebook',
											'value'=>$val,
											'class'=>'form-control');
											echo form_input($element).form_error('facebook');
											?>
                                        </div>
										
										 <div class="form-group">
                                            <label><?php echo get_languageword('twitter');?></label>
											<?php
											$val='';
											if(isset($record) && !empty($record))
											{
												$val = $record->twitter;
											}
											else if(isset($_POST))
											{
												$val = set_value('twitter');
											}
											
											$element = array('name'=>'twitter',
											'value'=>$val,
											'class'=>'form-control');
											echo form_input($element).form_error('twitter');
											?>
                                        </div>
										
										 <div class="form-group">
                                            <label><?php echo get_languageword('google_plus');?></label>
											<?php
											$val='';
											if(isset($record) && !empty($record))
											{
												$val = $record->google_plus;
											}
											else if(isset($_POST))
											{
												$val = set_value('google_plus');
											}
											
											$element = array('name'=>'google_plus',
											'value'=>$val,
											'class'=>'form-control');
											echo form_input($element).form_error('google_plus');
											?>
                                        </div>
										
										<div class="form-group">
                                            <label><?php echo get_languageword('tumblr');?></label>
											<?php
											$val='';
											if(isset($record) && !empty($record))
											{
												$val = $record->tumblr;
											}
											else if(isset($_POST))
											{
												$val = set_value('tumblr');
											}
											
											$element = array('name'=>'tumblr',
											'value'=>$val,
											'class'=>'form-control');
											echo form_input($element).form_error('tumblr');
											?>
                                        </div>
										
								</div>
								
								<div class="col-md-6">
								
								<div class="form-group">
									<label><?php echo get_languageword('linked_in');?></label>
									<?php
									$val='';
									if(isset($record) && !empty($record))
									{
										$val = $record->linked_in;
									}
									else if(isset($_POST))
									{
										$val = set_value('linked_in');
									}
									
									$element = array('name'=>'linked_in',
									'value'=>$val,
									'class'=>'form-control');
									echo form_input($element).form_error('linked_in');
									?>
								</div>
								
								<div class="form-group">
									<label><?php echo get_languageword('instagram');?></label>
									<?php
									$val='';
									if(isset($record) && !empty($record))
									{
										$val = $record->instagram;
									}
									else if(isset($_POST))
									{
										$val = set_value('instagram');
									}
									
									$element = array('name'=>'instagram',
									'value'=>$val,
									'class'=>'form-control');
									echo form_input($element).form_error('instagram');
									?>
								</div>
								
								
								<div class="form-group">
									<label><?php echo get_languageword('pinterest');?></label>
									<?php
									$val='';
									if(isset($record) && !empty($record))
									{
										$val = $record->pinterest;
									}
									else if(isset($_POST))
									{
										$val = set_value('pinterest');
									}
									
									$element = array('name'=>'pinterest',
									'value'=>$val,
									'class'=>'form-control');
									echo form_input($element).form_error('pinterest');
									?>
								</div>
										
								<div class="form-group">
								
								<button type="submit" name="social_networks" value="social_networks" class="btn btn-primary"><?php echo get_languageword('update');?></button>
                                <a class="btn btn-warning" href="<?php echo URL_SOCIAL_NETWORKS;?>"><?php echo get_languageword('cancel');?></a>
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

        $('#social_networks_form').bootstrapValidator({
            // To use feedback icons, ensure that you use Bootstrap v3.1.0 or later
            /* feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            }, */
			framework: 'bootstrap',
            excluded: ':disabled',
            fields: {
                facebook: {
                    validators: {
                        uri: {
                            message: '<?php echo get_languageword('facebook_url_not_valid');?>'
                        }
                    }
                },
                twitter: {
                    validators: {
                        uri: {
                            message: '<?php echo get_languageword('twitter_url_not_valid');?>'
                        }
                    }
                },
				google_plus: {
                    validators: {
                        uri: {
                            message: '<?php echo get_languageword('google_plus_url_not_valid');?>'
                        }
                    }
                },
				linked_in: {
                    validators: {
                        uri: {
                            message: '<?php echo get_languageword('linked_in_url_not_valid');?>'
                        }
                    }
                },
				instagram: {
                    validators: {
                        uri: {
                            message: '<?php echo get_languageword('instagram_url_not_valid');?>'
                        }
                    }
                },
				pinterest: {
                    validators: {
                        uri: {
                            message: '<?php echo get_languageword('pinterest_url_not_valid');?>'
                        }
                    }
                },
				tumblr: {
                    validators: {
                        uri: {
                            message: '<?php echo get_languageword('tumblr_url_not_valid');?>'
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