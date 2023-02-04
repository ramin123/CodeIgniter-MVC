<!-- /. NAV SIDE  -->
<section class="navbar-side">
   <ul class="nav crunchy-navigation sidebar-menu">
   
      <!--DASHBOARD-->
      <li>
         <a <?php if(isset($activemenu) && $activemenu=='dm_dashboard') echo 'class="active-menu"';?>  href="<?php echo SITEURL;?>"><i class="fa fa-dashboard fa-3x"></i> <?php echo get_languageword('dashboard');?> </a>
      </li>
	  
	  
	  <!--ORDERS-->
	  <li>
         <a <?php if(isset($activemenu) && $activemenu==ACTIVE_ORDERS) echo 'class="active-menu"';?> href="<?php echo URL_DM_ORDERS;?>"><i class="fa fa-list fa-3x"></i> <?php echo get_languageword('orders');?> </a>
      </li>
	  <!--ORDERS-->
      
	  
   </ul>
</section>
<script src="<?php echo JS_ADMIN_SIDEBAR_MENU;?>"></script>
<script>
   $.sidebarMenu($('.sidebar-menu'))
</script>