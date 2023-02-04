<?php 
$total_orders  		= $this->base_model->get_orders_count();
$total_items 		= $this->base_model->get_items_count();
$delivered_orders   = $this->base_model->get_delivered_orders_count();
?>

<div class="row text-center mt-3">
        <div class="col-sm-4"></div>
        <div class="col-sm-4">
        	<div class="abt-icon">
        		<img src="<?php echo FRONT_IMAGES;?>about1.svg" alt="Total Orders" class="img-responsive center-block">
        		<h1><?php echo $total_orders;?></h1>
        		<h4><?php echo get_languageword('ordered_online');?></h4>
        	</div>
        </div>
        <div class="col-sm-4"></div>
       </div>
	   
	   <div class="row">
       	<div class="col-sm-4">
        	<div class="abt-icon">
        		<img src="<?php echo FRONT_IMAGES;?>about2.svg" alt="Dishes Served" class="img-responsive center-block">
        		<h1><?php echo $total_items;?></h1>
        		<h4><?php echo get_languageword('dishes_served');?></h4>
        	</div>
        </div>
        <div class="col-sm-4">
        		<img src="<?php echo FRONT_IMAGES;?>about4.svg" alt="FoodCourt" class="img-responsive center-block abt-ef-img">
        </div>
        <div class="col-sm-4">
        	<div class="abt-icon">
        		<img src="<?php echo FRONT_IMAGES;?>about3.svg" alt="Delivered Orders" class="img-responsive center-block">
        		<h1><?php echo $delivered_orders;?></h1>
        		<h4><?php echo get_languageword('home_delivered');?></h4>
        	</div>
        </div>
       </div>