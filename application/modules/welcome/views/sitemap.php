<!--About Us Page-->
<section class="fc-identity fc-bottom fc-menu-wrapper">
   <div class="container">
   	<div class="row">
            <div class="col-sm-12">
             <div class="section-header">
                 <h1><?php if(isset($pagetitle)) echo $pagetitle;?></h1>
             </div>
             </div>
           </div>
	<div class="row">
	
	<div class="col-md-4 col-sm-6 col-xs-6">
                
                <ul class="cs-footer-links cs-footer-links-color">
					
					<li><a href="<?php echo SITEURL;?>" target="_blank"><i class="fa fa-angle-right"></i> <?php echo get_languageword('home');?></a></li>
					
                    <li><a href="<?php echo URL_ABOUT_US;?>" target="_blank"> <i class="fa fa-angle-right"></i> <?php echo get_languageword('about_us');?></a></li>
					
					<li><a href="<?php echo URL_CONTACT_US;?>" target="_blank"><i class="fa fa-angle-right"></i> <?php echo get_languageword('contact_us');?></a></li>
					
					
					<li><a href="<?php echo URL_FAQS;?>" target="_blank"><i class="fa fa-angle-right"></i> <?php echo get_languageword('faqs');?></a></li>
					
                </ul>
            </div>
	
	
            <div class="col-md-4 col-sm-6 col-xs-6">
                
               <ul class="cs-footer-links cs-footer-links-color">
			   
					<li><a href="<?php echo URL_HOW_IT_WORKS;?>" target="_blank"><i class="fa fa-angle-right"></i> <?php echo get_languageword('how_it_works');?></a></li>
					
					<li><a href="<?php echo URL_TERMS_CONDITIONS;?>" target="_blank"><i class="fa fa-angle-right"></i> <?php echo get_languageword('terms_and_conditions');?> </a></li>

					<li><a href="<?php echo URL_PRIVACY_POLICY;?>" target="_blank"><i class="fa fa-angle-right"></i> <?php echo get_languageword('privacy_and_policy');?></a></li>
					
					<li><a href="<?php echo URL_DOWNLOAD_APP;?>" target="_blank"><i class="fa fa-angle-right"></i> <?php echo get_languageword('download_app');?></a></li>
					
				</ul>

            </div>
			
			
			
	
		  <div class="col-md-4 col-sm-6 col-xs-6">
                
               <ul class="cs-footer-links cs-footer-links-color">
			   
					<li><a href="<?php echo URL_MENU;?>" target="_blank"><i class="fa fa-angle-right"></i> <?php echo get_languageword('menu');?></a></li>
					
					<li><a href="<?php echo URL_MENU;?>" target="_blank"><i class="fa fa-angle-right"></i> <?php echo get_languageword('offers');?> </a></li>

					<li><a href="<?php echo URL_MENU;?>" target="_blank"><i class="fa fa-angle-right"></i> <?php echo get_languageword('popular_items');?></a></li>
					
					<li><a href="<?php echo URL_SITE_MAP;?>" target="_blank"><i class="fa fa-angle-right"></i> <?php echo get_languageword('site_map');?></a></li>
					
				</ul>

            </div>
			
			
			
            <!--div class="col-md-4 col-sm-6 col-xs-6">
                <h4 class="footer-head">Site Links</h4>
                <ul class="cs-footer-links cs-footer-links-color">
                    <li><a href="http://conquerorslabs.com/foodcourt/">Home</a>
                    </li>
					<li><a href="http://conquerorslabs.com/foodcourt/faqs">FAQs</a>
                    </li>
                    <li><a href="http://conquerorslabs.com/foodcourt/contact-us">Contact Us</a>
                    </li>
                    <li><a href="http://conquerorslabs.com/foodcourt/site-map">Site map</a>
                    </li>
                </ul>
            </div-->
			
			
	 
	 
	</div>
  </div>
</section>

<?php $this->load->view('home/our_services');?>
