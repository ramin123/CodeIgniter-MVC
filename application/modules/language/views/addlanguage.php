<div id="page-wrapper">
  
      <div class="row">
         <div class="col-md-12">
            <!-- Form Elements -->                    
            <div class="panel panel-default">
               <div class="panel-heading">                            <?php if(!empty($pagetitle)) echo $pagetitle;?>							 <a title="<?php echo get_languageword('go_to_list'); ?>" class="btn btn-primary btn-xs pull-right" href="<?php echo URL_LANGUAGE_INDEX; ?>"><i class="fa fa-list"></i>							</a>                        </div>
               <div class="panel-body">
                  <div class="row">
                     <?php						$attributes = array('name'=>'language_form','id'=>'language_form');						echo form_open(URL_ADD_LANGUAGE,$attributes);?>							                       
                     <div class="col-md-6">
                        <div class="form-group">						 <label><?php echo get_languageword('language').required_symbol();?></label>						<?php						$val='';												if(isset($_POST))						{							$val = set_value('language');						}												$element = array('name'=>'title',						'value'=>$val,						'class'=>'form-control');						echo form_input($element).form_error('title');						?>					  </div>
                        <div class="form-group">						 <label><?php echo get_languageword('language_code').required_symbol();?></label>						<?php						$val='';												if(isset($_POST))						{							$val = set_value('language_code');						}												$element = array('name'=>'language_code',						'value'=>$val,						'class'=>'form-control');						echo form_input($element).form_error('language_code');						?>					  </div>
                        <div class="form-group pull-right">												<button type="submit" name="add_language" value="add_language" class="btn btn-primary"><?php echo get_languageword('save');?></button>												<a class="btn btn-warning" href="<?php echo URL_LANGUAGE_INDEX;?>"><?php echo get_languageword('cancel');?></a>					</div>
                     </div>
                     <?php echo form_close();?>                            
                  </div>
               </div>
            </div>
            <!-- End Form Elements -->                
         </div>
      </div>
      <!-- /. ROW  -->                   
  
   <!-- /. PAGE INNER  -->            
</div>
<!-- /. PAGE WRAPPER  -->		 		<!-- Form Validation Plugins /Start --><?php if(!empty($css_js_files) && in_array('form_validation', $css_js_files)) { ?>
<link href="<?php echo CSS_ADMIN_OR_BOOTSTRAP_VALIDATOR;?>" rel="stylesheet">
<script type="text/javascript" src="<?php echo JS_ADMIN_BOOTSTRAP_VALIDATOR;?>"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#language_form').bootstrapValidator({
            framework: 'bootstrap',
            excluded: ':disabled',
            fields: {
                title: {
                    validators: {
                        notEmpty: {
                            message: 'language required'
                        }
                    }
                },
                language_code: {
                    validators: {
                        notEmpty: {
                            message: 'language_code_required'
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