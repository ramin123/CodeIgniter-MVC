<div class="container pt-8 pb-8">

	<?php echo $this->session->flashdata('message'); ?>
   <div class="row" >
      <div class="col-sm-3 hidden-xs">
        <div class="left-sidebox">
        <div  class="search cs-searchbox mb-2" >
          <div  class="search-innerwrapper ">


		  
              <input  style="width: 100%" type="text" id="search-inp" name="search-inp" placeholder="<?php echo get_languageword('search');?>" onkeyup="search_item();"><i class="pe-7s-search"></i>
              <div class="search-results">
			  
			  </div>
          </div>
        </div>
		
		
		
			<!--Display Menus-->
			<div class="list-group">
			<?php
			$n=0;
			if (isset($menus) && !empty($menus)) {
				
				$element=array('type'=>'hidden',
								'id'=>'first_menu',
								'value'=>$menus[0]->menu_id.'='.$menus[0]->menu_name);
				echo form_input($element);	
				
			foreach ($menus as $menu) {
			$clas='';
			$n++;
			if ($n==1)
				$clas='active';
				
			?>
			
              <a href="javascript:void(0);" class="list-group-item <?php echo $clas;?>" onclick="get_menu_items_block('<?php echo $menu->menu_id;?>','<?php echo $menu->menu_name;?>')" id="<?php echo $menu->menu_id;?>"> <span style="font-weight: bolder;"> <?php echo $menu->menu_name;?></span></a>
			   
			<?php } } ?>   
            
			
			
			<a href="javascript:void(0);" class="list-group-item" onclick="get_offers_block()" id="offers"> <span style="font-weight: bolder;"><?php echo get_languageword('offers');?> </span></a>
			
			<a href="javascript:void(0);" class="list-group-item" onclick="get_popular_items_block()" id="popular_items"><span style="font-weight: bolder;"><?php echo get_languageword('popular_items');?></span></a>
			
			</div>
			<!--Display Menus-->
			
			
			
			
			
         </div>
      </div>
	  
	  
	  
	  <!--ITEMS DIV-->
      <div class="col-sm-6 items-block">
	  
	
	   
      </div>
	  <!--ITEMS DIV-->
	  
	  
	  
	  
	  
	  
	  <!--CART DIV-->
	  <div class="col-sm-3" id="item-sidebar">
      	<div class="cs-card cart-card card-y-auto ml-lg-2 item-sidebar" >
      		<div class="card-header bordered"><?php echo get_languageword('your_cart');?></div>
			
			
			
			<div id="fc-cart-div">
			</div>
			
			<div class="checkout-btn">
      			<a href="<?php echo URL_CART_INDEX;?>" class="btn btn-primary btn-block btn-checkout"> <?php echo get_languageword('checkout');?> </a>
      		</div>
			
      	</div>

      </div>
	  
	  <!--CART DIV-->
	  
	  
   </div>
</div>







<script>
// A $( document ).ready() block.
$( document ).ready(function() {
	
	<?php if($search_item!='') { ?>
	$("#search-inp").val('<?php echo $search_item;?>');
	search_item();
	<?php } else {
		
	if (!empty($menus)):?>
	var menu = $("#first_menu").val();
	var arr = menu.split('=');
	
	if (arr.length>0) {
		
		var menu_id   = arr[0];
		var menu_name = arr[1];
		
		get_menu_items_block(menu_id,menu_name);
	}
	
	<?php else: ?>
	get_offers_block();
	<?php endif; ?>
	
	<?php } ?>
	
	
	load_cart_div();
	
	
	
});


//get menu-items-block
function get_menu_items_block(menu_id,menu_name) {
	
	//attribute class need to change
	$(".list-group-item").removeClass("active");
    $('#'+menu_id+'').addClass('active');
	
	
	$(".items-block").html('<img  class="fixed-loader" src="<?php echo LOADER_IMG;?>" alt="Loader" align="middle">');
	
	if (menu_id>0) {
	$.ajax({
		url:'<?php echo base_url();?>welcome/get_menu_items_block',
		type:'POST',
		data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash();?>&menu_id='+menu_id+'&menu_name='+menu_name,
		success :function(response){
			
			$(".items-block").empty();	
			$(".items-block").html(response);
			
			
			
			var offset = $('#offset').val();
			var total_items = $("#total_items").val();
			
			if (parseInt(total_items) <= parseInt(offset)) {	
				$("#load_more").fadeOut();
			} else {
				$("#load_more").fadeIn();
			}
	
		}
	});
	}
	
}



function get_more_items(menu_id) {
	
	
	var offset = $('#offset').val();
	
	var new_offset = parseInt(offset)+parseInt('<?php echo MENU_ITEMS_PER_PAGE;?>');
	
	var total_items = $("#total_items").val();
	
	$("body").addClass("ajax-load");

	if (menu_id>0) {

	$.ajax({
		url:'<?php echo base_url();?>welcome/get_menu_more_items_block',
		type:'POST',
		data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash();?>&menu_id='+menu_id+'&offset='+offset,
		success :function(response){
			
			$("body").removeClass("ajax-load");

			$(".more-items-block").last().append(response);
			
			
			
			$('#offset').val(new_offset);
			
			if (total_items<=new_offset) {		
				$("#load_more").fadeOut();
			}
	
		}
	});
	}
}







function get_offers_block() {
	//attribute class need to change
	$(".list-group-item").removeClass("active");
    $('#offers').addClass('active');
	
	
	$(".items-block").html('<img class="fixed-loader" src="<?php echo LOADER_IMG;?>" alt="Loader" align="middle">');
	
	
	$.ajax({
		url:'<?php echo base_url();?>welcome/get_offers_block',
		type:'POST',
		data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash();?>',
		success :function(response){
			
			$(".items-block").empty();	
			$(".items-block").html(response);
			
			
			
			var offset = $('#offers_offset').val();
			var total_offers = $("#total_offers").val();
			
			if (parseInt(total_offers) <= parseInt(offset)) {	
				$("#load_more_offers").fadeOut();
			} else {
				$("#load_more_offers").fadeIn();
			}
	
		}
	});
}

function get_more_offers() {
	
	var offset = $('#offers_offset').val();
	
	var new_offset = parseInt(offset)+parseInt('<?php echo MENU_ITEMS_PER_PAGE;?>');
	
	var total_offers = $("#total_offers").val();
	
	
	$("body").addClass("ajax-load");
	$.ajax({
		url:'<?php echo base_url();?>welcome/get_more_offers',
		type:'POST',
		data:{
		offset: offset
		},
		success :function(response){
			
			$("body").removeClass("ajax-load");

			$(".more-offers-block").last().append(response);
			
			$('#offers_offset').val(new_offset);
			
			if (total_offers<=new_offset) {		
				$("#load_more_offers").fadeOut();
			}
	
		}
	});
}












function get_popular_items_block() {
	
	//attribute class need to change
	$(".list-group-item").removeClass("active");
    $('#popular_items').addClass('active');
	
	
	$(".items-block").html('<img class="fixed-loader" src="<?php echo LOADER_IMG;?>" alt="Loader" align="middle">');
	
	$.ajax({
		url:'<?php echo base_url();?>welcome/get_popular_items_block',
		type:'POST',
		data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash();?>',
		success :function(response){
			
			$(".items-block").empty();	
			$(".items-block").html(response);
			
			
			
			var offset = $('#popular_items_offset').val();
			var total_items = $("#total_popular_items").val();
			
			if (parseInt(total_items) <= parseInt(offset)) {	
				$("#popular_load_more").fadeOut();
			} else {
				$("#popular_load_more").fadeIn();
			}
	
		}
	});
}

function get_more_popular_items() {

	var offset = $('#popular_items_offset').val();
	
	var new_offset = parseInt(offset)+parseInt('<?php echo MENU_ITEMS_PER_PAGE;?>');
	
	var total_items = $("#total_popular_items").val();
	
	$("body").addClass("ajax-load");
	
	$.ajax({
		url:'<?php echo base_url();?>welcome/get_more_popular_items',
		type:'POST',
		data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash();?>&offset='+offset,
		success :function(response){

			$("body").removeClass("ajax-load");
			
			$(".popular-items-block").last().append(response);
			
			$('#popular_items_offset').val(new_offset);
			
			if (total_items<=new_offset) {		
				$("#popular_load_more").fadeOut();
			}
	
		}
	});
}



//search item
function search_item() {
	
	//attribute class need to change
	$(".list-group-item").removeClass("active");
    // $('#popular_items').addClass('active');
	
	
	$(".items-block").html('<img class="fixed-loader" src="<?php echo LOADER_IMG;?>" alt="Loader" align="middle">');
	
	
	var search_strng = $("#search-inp").val();
	// console.log(search_strng);
	
	if(search_strng!='') {
	$.ajax({
		url:'<?php echo base_url();?>welcome/get_search_items_block',
		type:'POST',
		data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash();?>&strng='+search_strng,
		success :function(response){
			
			// console.log(response);
			
			$(".items-block").empty();	
			$(".items-block").html(response);
			
			
			
			var offset = $('#search_items_offset').val();
			var total_items = $("#total_search_items").val();
			
			if (parseInt(total_items) <= parseInt(offset)) {	
				$("#search_load_more").fadeOut();
			} else {
				$("#search_load_more").fadeIn();
			} 
	 
		}
	});
	} else {
		
		<?php if (!empty($menus)) :?>
			var menu = $("#first_menu").val();
			var arr = menu.split('=');
			
			if (arr.length>0) {
				
				var menu_id   = arr[0];
				var menu_name = arr[1];
				
				get_menu_items_block(menu_id,menu_name);
			}
			
			<?php else : ?>
			get_offers_block();
			<?php endif; ?>
			
			
			load_cart_div();
	}
}



function get_more_search_items() {
	
	var offset = $('#search_items_offset').val();
	
	var new_offset = parseInt(offset)+parseInt('<?php echo MENU_ITEMS_PER_PAGE;?>');
	
	var total_items = $("#total_search_items").val();
	
	var search_strng = $("#search-inp").val();
	
	if(search_strng!='') {
	
	$("body").addClass("ajax-load");

	$.ajax({
		url:'<?php echo base_url();?>welcome/get_more_search_items',
		type:'POST',
		data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash();?>&strng='+search_strng+'&offset='+offset,
		success :function(response){

			$("body").removeClass("ajax-load");
			
			$(".search-items-block").last().append(response);
			
			$('#search_items_offset').val(new_offset);
			
			if (total_items<=new_offset) {		
				$("#search_load_more").fadeOut();
			}
	
		}
	});
	
	} else {
		<?php if (!empty($menus)) :?>
			var menu = $("#first_menu").val();
			var arr = menu.split('=');
			
			if (arr.length>0) {
				
				var menu_id   = arr[0];
				var menu_name = arr[1];
				
				get_menu_items_block(menu_id,menu_name);
			}
			
			<?php else : ?>
			get_offers_block();
			<?php endif; ?>
			
			
			load_cart_div();
	}
}
</script>

