  <!-- Slide Banner Section -->
   <?php $this->load->view('slider');?>
   <!-- Slide Banner Section -->

       <!--ITEMS-->
		   
		<!-- Title Section -->
       <section class="fc-identity">
        <!--  <div class="container">
          <div class="row">
            <div class="col-sm-12">
             <div class="section-header">
                 <h1><?php echo get_languageword('special_food_items');?></h1>
                 <p><?php echo get_languageword('we_have_the_glory_beginning_in_restaurant_business');?></p>
             </div>
             </div>
           </div>
          </div> -->
         </section>
        <!-- Title Section -->
		
		 <?php 
		if(isset($menus) && !empty($menus)) { ?>
		   
        <section class="relative">
		
          <div class="container">
		  
            <div class="row">
                <div class="col-sm-12">
				
                    <ul class="featured-list-ul">
						<?php 
						$n=0;
						
						$element=array('type'=>'hidden',
								'id'=>'fc_hme_first_menu',
								'value'=>$menus[0]->menu_id);
							echo form_input($element);	
							
						foreach ($menus as $menu) {
						$clas='';
							$n++;
							if ($n==1)
								$clas='active';
							
							?>
							
                        <li class="home-itms <?php echo $clas;?>" onclick="get_home_menu_items_block('<?php echo $menu->menu_id;?>')" id="<?php echo $menu->menu_id;?>">
						
						<a href="javascript:void(0);"><?php echo isset($menu->menu_name) ? $menu->menu_name : '';?></a>
						
						</li>
						
						
						<?php } ?>
                    </ul>
                </div>
            </div>
			
			
            <div class="row fc-home-items-block">
			
			</div>
             
               </div>
             </section>
       <?php } else { 
	   
		echo '<h4 style="text-align:center;">'.get_languageword('no_items_available').' </h4>';
		
	    } ?>
       <!--ITEMS-->




    <!--services section-->
    <?php $this->load->view('our_services');?>
    <!--services section-->


    
	
	
	
	
	
	
	
	
	
	
	
<script>

// A $( document ).ready() block.
$( document ).ready(function() {
	
	<?php if (!empty($menus)) { ?>
	var hm_menu = $("#fc_hme_first_menu").val();
	
	
	if (hm_menu>0) {
		
		get_home_menu_items_block(hm_menu);
	}
	<?php } ?>
});

//get menu-items-block
function get_home_menu_items_block(menu_id) {
	
	
	//attribute class need to change
	$('.home-itms').removeClass("active");
    $('#'+menu_id+'').addClass('active');
	
	
	$(".fc-home-items-block").html('<img class="abs-loader pt-1" src="<?php echo LOADER_IMG;?>" alt="Loader" align="middle">');
	
	if (menu_id>0) {
	$.ajax({
		url:'<?php echo base_url();?>welcome/get_home_menu_items_block',
		type:'POST',
		data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash();?>&menu_id='+menu_id,
		success :function(response){
			
			$(".fc-home-items-block").empty();	
			$(".fc-home-items-block").html(response);
			
		}
	});
	
	}
}	
</script>