  <div id="page-wrapper">  
  <div class="row">                
  <div class="col-md-12">                   
  <!-- Form Elements -->                    
  <div class="panel panel-default">                      
  <div class="panel-heading">                   
  <?php

	if (!empty($pagetitle)) echo $pagetitle; ?>							 

	<a title="<?php echo get_languageword('go_to_list'); ?>" class="btn btn-primary btn-xs pull-right" href="<?php echo URL_LANGUAGE_PHRASES; ?>"><i class="fa fa-list"></i></a>               
			 
	</div>          

	
<div class="panel-body">						                             
<div class="row">							

<?php
$attributes = array(
	'name' => 'phrase_form',
	'id' => 'phrase_form'
);
echo form_open(URL_LANGUAGE_ADDEDIT_PHRASE, $attributes);?>

					<div class="col-md-6">                                 						<div class="form-group">

					<label><?php echo get_languageword('phrase_for') . required_symbol(); ?></label>						<?php
					$options = array(
						'Web' => get_languageword('web') ,
						'App' => get_languageword('app')
					);
					$val = '';

					if (isset($record))
						{
						$val = $record->phrase_for;
						}
					  else
					if (isset($_POST))
						{
						$val = set_value('phrase_for');
						}

					echo form_dropdown('phrase_for', $options, $val, 'class="chzn-select form-control"'); ?>					 

					</div>


					<div class="form-group">

					<label><?php echo get_languageword('lang_key') . required_symbol(); ?></label>						<?php
					$val = '';

					if (isset($record))
						{
						$val = $record->lang_key;
						}
					  else
					if (isset($_POST))
						{
						$val = set_value('lang_key');
						}

					$element = array(
						'name' => 'lang_key',
						'value' => $val,
						'class' => 'form-control'
					);
					echo form_input($element) . form_error('lang_key');?>					  </div>										



<?php

if (!empty($details))
	{
	unset($details[0]);
	unset($details[1]);
	unset($details[2]);
	foreach($details as $key => $value)
		{ ?>					  					    
		
		<div class="form-group">						 
		
		<label><?php
		echo get_languageword($value); ?> <?php
		if ($value == "english") echo required_symbol(); ?></label>	
		
		<?php
		$val = set_value($value, (isset($record->$value)) ? $record->$value : '');
		$element = array(
			'name' => $value,
			'id' => $value,
			'value' => $val,
			'class' => 'form-control',
		);
		echo form_input($element) . form_error($value); ?>
		</div>					  					 
		
		<?php
		}
	} ?>		 					
	
	<div class="form-group pull-right">						
	
	<?php

	if (!empty($record))
	{
		echo form_hidden('id', $record->lang_id);
	} ?>						
	
	<button type="submit" name="addedit_phrase" value="addedit_phrase" class="btn btn-primary"><?php echo get_languageword('save');?></button>	
	
	<a class="btn btn-warning" href="<?php echo URL_LANGUAGE_INDEX; ?>"><?php echo get_languageword('cancel'); ?></a>	
	</div>	
	</div>		
	<?php
echo form_close(); ?>      
                      </div>                       
					  </div>				
					  </div>                    
					  <!-- End Form Elements -->               
					  </div>           
					  </div>                
					  <!-- /. ROW  -->                           
					  <!-- /. PAGE INNER  -->            
					  </div>      
					  <!-- /. PAGE WRAPPER  -->		 		
					  <!-- Form Validation Plugins /Start -->
					  
<?php if (!empty($css_js_files) && in_array('form_validation', $css_js_files))
	{ ?>

<link href="<?php echo CSS_ADMIN_OR_BOOTSTRAP_VALIDATOR; ?>" rel="stylesheet">
	
<script type="text/javascript" src="<?php echo JS_ADMIN_BOOTSTRAP_VALIDATOR; ?>"></script>

<script type="text/javascript">    


$(document).ready(function () {		        

$('#phrase_form').bootstrapValidator({            

// To use feedback icons, ensure that you use Bootstrap v3.1.0 or later            
/* feedbackIcons: {               
 valid: 'glyphicon glyphicon-ok',               
 invalid: 'glyphicon glyphicon-remove',               
 validating: 'glyphicon glyphicon-refresh'            }, */

 framework: 'bootstrap',            
 excluded: ':disabled',            
 fields: {                
 phrase_for: {                    
 validators: {                        
 notEmpty: {                            
 message: '<?php
	echo get_languageword('phrase_for_required'); ?>'
	}                    
	}               
	},				
	lang_key: {                   
	validators: {                        
	notEmpty: {                            
	message: '<?php
	echo get_languageword('lang_key_required'); ?>' 
	}                    
	}                
	}           
	},			 
	submitHandler: function(validator, form, submitButton) {		form.submit();			
	}        
	})    
	});
</script>
<?php } ?>