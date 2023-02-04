  <div id="page-wrapper">

           

               <div class="row">

                <div class="col-md-12">

				<?php echo $this->session->flashdata('message'); ?>

                    <!-- Form Elements -->

                    <div class="panel panel-default">

						

                        <div class="panel-heading">

                            <?php if(isset($pagetitle)) echo $pagetitle;?>

							

							<a title="<?php echo get_languageword('go_to_list');?>" class="btn btn-primary btn-xs pull-right" href="<?php echo URL_USERS_DELIVERY_MANAGERS; ?>"><i class="fa fa-list"></i>

							</a>

                        </div>

                        <div class="panel-body">

						 

                            <div class="row">

							<?php

						$attributes = array('name'=>'dm_form','id'=>'dm_form');

						echo form_open(URL_ADDEDIT_DELIVERY_MANAGER,$attributes);?>

							

                       <div class="col-md-6">

                                 

						<div class="form-group">

						 <label><?php echo get_languageword('first_name').required_symbol();?></label>

						<?php

						$val='';

						if(isset($record) && !empty($record))

						{

							$val = $record->first_name;

						}

						else if(isset($_POST))

						{

							$val = set_value('first_name');

						}

						

						$element = array('name'=>'first_name',

						'value'=>$val,

						'class'=>'form-control');

						echo form_input($element).form_error('first_name');

						?>

					  </div>

					
					<div class="form-group">

						 <label><?php echo get_languageword('last_name').required_symbol();?></label>

						<?php

						$val='';

						if(isset($record) && !empty($record))

						{

							$val = $record->last_name;

						}

						else if(isset($_POST))

						{

							$val = set_value('last_name');

						}

						

						$element = array('name'=>'last_name',

						'value'=>$val,

						'class'=>'form-control');

						echo form_input($element).form_error('last_name');

						?>

					  </div>
					  
					 
					  
					  <div class="form-group">

						 <label><?php echo get_languageword('email').required_symbol();?></label>

						<?php

						$val='';

						if(isset($record) && !empty($record))

						{

							$val = $record->email;

						}

						else if(isset($_POST))

						{

							$val = set_value('email');

						}

						

						$element = array('name'=>'email',

						'value'=>$val,

						'class'=>'form-control');
						
						if(isset($record) && !empty($record))
						{
							$element['readonly']=true;
						}
						
						echo form_input($element).form_error('email');

						?>

					  </div>
					  
					  
					  <div class="form-group">

						 <label><?php echo get_languageword('phone').required_symbol();?></label>

						<?php

						$val='';

						if(isset($record) && !empty($record))

						{

							$val = $record->phone;

						}

						else if(isset($_POST))

						{

							$val = set_value('phone');

						}

						

						$element = array('name'=>'phone',

						'value'=>$val,

						'class'=>'form-control');

						echo form_input($element).form_error('phone');

						?>

					  </div>
					  
					  
					   <?php if(!isset($cities_options)) {?>
					   
					   <div class="form-group pull-right">

						<?php 

						$value='';

						if(isset($record))

						{

							$value = $record->id;

						}

						echo form_hidden('id',$value);?>

						

						<button type="submit" name="addedit_dm" value="addedit_dm" class="btn btn-primary"><?php echo get_languageword('save');?></button>

						

						<a class="btn btn-warning" href="<?php echo URL_USERS_DELIVERY_MANAGERS;?>"><?php echo get_languageword('cancel');?></a>

					</div>
					
					   
					   <?php } ?>
					   
                        </div>
						
						
						
						 <?php if(isset($cities_options)) {?>
						 <div class="col-md-6">
						 
						
						   <div class="form-group">

						 <label><?php echo get_languageword('assigned_cities');?></label>

						<?php

						$val=array();

						if(isset($record) && !empty($record))
						{
							if($record->assigned_cities != '')
							{
								$val = explode(',',$record->assigned_cities);
							}	
						}
						else if(isset($_POST))
						{
							$val = set_value('assigned_cities');
						}

						echo form_multiselect('assigned_cities[]',$cities_options,$val,'class="chzn-select"');

						?>

					  </div>
						   
					<div class="form-group pull-right">

						<?php 

						$value='';

						if(isset($record))

						{

							$value = $record->id;

						}

						echo form_hidden('id',$value);?>

						

						<button type="submit" name="addedit_dm" value="addedit_dm" class="btn btn-primary"><?php echo get_languageword('save');?></button>

						

						<a class="btn btn-warning" href="<?php echo URL_USERS_DELIVERY_MANAGERS;?>"><?php echo get_languageword('cancel');?></a>

					</div>

						  </div>
						 <?php } ?>

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

<script type="text/javascript" src="<?php echo JS_VALIDATE_MIN;?>"></script>

<script type="text/javascript">

(function($,W,D)

{

      var JQUERY4U = {};

   

      JQUERY4U.UTIL =

      {

          setupFormValidation: function()

          {

              //Additional Methods

			//form validation rules

              $("#dm_form").validate({

					ignore: "",

                  rules: {

					 first_name: {

						 required: true

					 },

                     last_name: {

						required: true

					 },

					 email: {

						 required: true,

						 email: true

						
					 },

					 phone: {

						 required: true

					 }

                  },

				 messages: {

					 first_name: {

						 required: "<?php echo get_languageword('first_name_required');?>"

					 },

                     last_name: {

						required: "<?php echo get_languageword('last_name_required');?>"

					 },

					 email: {

						 required: "<?php echo get_languageword('email_required');?>"

					 },

					 phone: {

						 required: "<?php echo get_languageword('phone_required');?>"

					 }

					
   			},

                  

                  submitHandler: function(form) {

                      form.submit();

                  }

              });

          }

      }

   

      //when the dom has loaded setup form validation rules

      $(D).ready(function($) {

          JQUERY4U.UTIL.setupFormValidation();

      });

   

   })(jQuery, window, document); 

</script>

<?php } ?>