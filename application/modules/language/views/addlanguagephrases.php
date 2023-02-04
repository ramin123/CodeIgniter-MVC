<div id="page-wrapper">
   
      <div class="row">
         <div class="col-md-12">
            <!-- Form Elements -->                     
            <div class="panel panel-default">
               <div class="panel-heading">                            <?php
                  if (!empty($pagetitle))
                      echo $pagetitle;
                  ?>                             <a title="<?php
                  echo get_languageword('go_to_list');
                  ?>" class="btn btn-primary btn-xs pull-right" href="<?php
                  echo URL_LANGUAGE_INDEX;
                  ?>"><i class="fa fa-list"></i>                            </a>                        </div>
               <div class="panel-body">
                  <?php
                     $attributes = array(
                         'name' => 'tokenform',
                         'id' => 'tokenform',
                         'enctype' => 'multipart/form-data'
                     );
                     echo form_open(URL_LANGUAGE_ADDLANGUEGEPHRASES, $attributes);
                     ?>                                                 
                  <div class="row">
				
				  
		<input type="hidden" name="id" value="<?php echo $id;?>"> 
						
                     <?php
                        foreach ($languagewords as $row) {
							
							$md_class = 'col-md-6';
							$str_length = strlen($row->lang_key);
							
							if($str_length>60)
							{
								$md_class = 'col-md-12';
							}
							
                        ?>     

						
                     <div class="<?php echo $md_class;?> form-group">
                        <div class="group ap">                    <label class="digiEffectLabel"><?php
                           echo $row->english;
                           ?> (<?php
                           echo $row->lang_key;
                           ?>)</label>                  
						   <?php
                           $val = '';
                           if ((isset($_POST['submitbutt']) && $_POST['submitbutt'])) 
						   {
                               $words = $this->input->post('word');
                               $val   = $words[$row->lang_key];
                           } 
						   elseif (isset($row->$id)) 
						   {
                               $val = $row->$id;
                           }
						   
                           // $lang_key = str_replace(' ','_',$row->lang_key);
						   $lang_key = $row->lang_id;
						   
                           $element  = array(
                               'name' => 'word['.$lang_key.']',
                               'id' => 'word['.$lang_key.']',
                               'value' => $val,
                               'class' => 'form-control'
                           );
                           echo form_input($element);
                           ?>                                    <span class="highlight"></span> <span class="bar"></span>                                  </div>
                     </div>
					 
					 
                     <?php
                       
						}
                        ?>               
							
                  </div>
				  
                  <div class="form-group pull-right">  
				  
				<button type="submit" name="add_language" value="add_language" class="btn btn-primary"><?php
                     echo get_languageword('save');
                     ?></button>                                                <a class="btn btn-warning" href="<?php
                     echo URL_LANGUAGE_INDEX;
                     ?>"><?php
                     echo get_languageword('cancel');
                     ?></a>                    
					 
			
				</div>
               </div>
               <?php
                  echo form_close();
                  ?>                             
            </div>
         </div>
      </div>
      <!-- End Form Elements -->                 
   
</div>
<!-- /. ROW  -->                   </div>             <!-- /. PAGE INNER  -->            </div>         <!-- /. PAGE WRAPPER  -->                 <!-- Form Validation Plugins /Start --><?php
   if (!empty($css_js_files) && in_array('form_validation', $css_js_files)) {
   ?> 
<link href="<?php
   echo CSS_ADMIN_OR_BOOTSTRAP_VALIDATOR;
   ?>" rel="stylesheet">
<script type="text/javascript" src="<?php
   echo JS_ADMIN_BOOTSTRAP_VALIDATOR;
   ?>"></script><script type="text/javascript">    $(document).ready(function () {                $('#language_form').bootstrapValidator({            // To use feedback icons, ensure that you use Bootstrap v3.1.0 or later            /* feedbackIcons: {                valid: 'glyphicon glyphicon-ok',                invalid: 'glyphicon glyphicon-remove',                validating: 'glyphicon glyphicon-refresh'            }, */            framework: 'bootstrap',            excluded: ':disabled',            fields: {                title: {                    validators: {                        notEmpty: {                            message: '<?php
   echo get_languageword('language_name_required');
   ?>'                        }                    }                }                        },             submitHandler: function(validator, form, submitButton) {                form.submit();            }        })    });</script><?php
   }
   ?>