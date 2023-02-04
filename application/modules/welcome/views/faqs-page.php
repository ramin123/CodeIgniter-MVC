
<div class="container pt-8 pb-8">
   <div class="row">
   
   
	<?php if (isset($categories) && !empty($categories)):?>
      <div class="col-md-3">
	  
        <ul class="dash-menu">
		
		
		<?php 
		$c=0;
		foreach ($categories as $key=>$val) {
		$c++;
		
		$class='';
		if ($c==1) {
			$class='active';
			
			$element=array('type'=>'hidden',
							'id'=>'first_fc_id',
							'value'=>$key);
			echo form_input($element);
		}
		?>
		
          <li class="<?php echo $class;?>" id="<?php echo $key;?>">
		  
		  <a href="javascript:void(0);" onclick="get_faqs_block('<?php echo $key;?>')"> <?php echo $val;?></a>
		  
		  </li>
		  <?php } ?>
		  
		  
        </ul>
		
      </div>
	  
		<div class="col-md-9">
         <div class="cs-card cart-card card-show">
               <div class="card-header bordered card-header-lg"><?php if (isset($pagetitle)) echo $pagetitle;?> </div>
			   
			   <div id="faqs_block">
			   
			   </div>
			   
			   
            </div>
         </div>
		 
	<?php else: ?> 
	
	<div class="col-md-9">
	 <div class="cs-card cart-card card-show">
		   <div class="card-header bordered card-header-lg"> <?php echo get_languageword('no_faqs_available');?> </div>
		   
		</div>
	 </div>
		 
	
	<?php endif;?>
		 
      </div>
   </div>

   
   
   
   
   
   
   
   
<script>
// A $( document ).ready() block.
$( document ).ready(function() {
	
	var fc_id=$("#first_fc_id").val();
	
	if (fc_id > 0) {
		get_faqs_block(fc_id);
	}
});


//get faqs-list-block
function get_faqs_block(fc_id) {
	
	//li attribute class need to change
	$('li').removeClass();
    $('#'+fc_id+'').addClass('active');
	
	
	$("#faqs_block").html('<img class="fixed-loader" src="<?php echo LOADER_IMG;?>" alt="Loader" align="middle">');
	
	$.ajax({
		url:'<?php echo base_url();?>welcome/get_faqs_list',
		type:'POST',
		data:{
		fc_id :fc_id
		},
		success :function(response){
			
			$("#faqs_block").empty();	
			$("#faqs_block").html(response);
		}
	});
	
}

</script>