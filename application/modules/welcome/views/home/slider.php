<section class="ct-slide-banner" >
    <div class="container">
        <div class="ct-home-slider">
            <div class="row text-center">
                <div class="col-sm-12">
                    <div class="header-content">
					
                       <!--  <h1>
                        <?php if(isset($home_page_caption) && $home_page_caption!='') echo $home_page_caption;else echo get_languageword('Best Quality and Tasty Food');?>
                        </h1>
						
                        <p>
						<?php if(isset($home_page_tagline) && $home_page_tagline!='') { 
                           echo $home_page_tagline;
						 } ?>
                        </p> -->
						
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</div>

<div class="cs-header">
<div class="container text-center">
    <div class="search-wrapper">
	
	<?php echo form_open(URL_MENU);?>
	
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-sm-12">
                <div class="cs-searchbar">
                    <div class="input-group">
					
                        <input type="text" name="search_item" class="form-control" placeholder="Search for dishes or cuisines" aria-describedby="basic-addon2" required>
						
						<span class="input-group-addon cs-search-input-group">
						<button type="submit" class=" cs-search-btn" id="basic-addon2">
						
						<span class="hidden-xs"><?php echo get_languageword('search');?></span>
						<span class="pe-7s-search visible-xs"></span>
						
						</button>
						</span>
                    </div>
                </div>
            </div>
        </div>
		<?php echo form_close();?>
        <img src="<?php echo FRONT_IMAGES;?>pizza.png" alt="FoodCourt" class="img-responsive pizza-fixed-img">
    </div>
</div>
</div>
