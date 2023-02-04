 <!--Footer Section-->
        <footer class="footer crunccy-footre">
         <div class="container">
           <div class="row">
             <div class="col-md-12 col-sm-12 col-xs-12 crunchy-foot">

             	
                 <p><a href="<?php echo SITEURL;?>"> <?php echo $this->config->item('site_settings')->rights_reserved_content;?> </a></p>
             </div>
           </div>
         </div>
        </footer>
        </div>
     <!-- /. WRAPPER  -->
    <!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
   
    <!-- METISMENU SCRIPTS -->
    <script type="text/javascript" src="<?php echo JS_ADMIN_METIMENU;?>"></script>

	<!--CHOSEN JS-->
	<script type="text/javascript" src="<?php echo JS_CHOSEN_JQUERY_MIN;?>"></script>
	
<!--DATATABLES-->
<?php if(!empty($css_js_files) && in_array('data_tables', $css_js_files)) { ?>

<?php if($this->config->item('site_settings')->admin_css=='orange') {?>
<link href="<?php echo TBL_CSS_ADMIN_ORANGE_DATATABLE_BOOTSTRAP;?>" rel="stylesheet" />
<?php } ?>

<script type="text/javascript"  src="<?php echo TBL_JS_ADMIN_DATATABLES;?>"></script> 
<script type="text/javascript"  src="<?php echo TBL_JS_ADMIN_DATATABLES_BOOTSTRAP;?>"></script> 

<script type="text/javascript" src="<?php echo ADMIN_DATA_TBL_JS;?>"></script> 

<script type="text/javascript" language="javascript" class="init">
$(document).ready(function() {
  <?php if(!empty($ajaxrequest["url"])) { ?>
	get_tableData('example','<?php echo $ajaxrequest["url"];?>','<?php if(!empty($ajaxrequest["conditions"])) echo $ajaxrequest["conditions"]; ?>','<?php if(!empty($ajaxrequest["disablesorting"])) echo $ajaxrequest["disablesorting"]; ?>',[[ 0, "desc" ]],'<?php if(!empty($ajaxrequest["type"])) echo $ajaxrequest["type"];?>');
  <?php } else { ?>
  $('#example').dataTable();
  <?php } ?>
});
</script>
<!--DATATABLES-->
 <?php } ?>

 <!--CHOSEN CLASS-->
<script type="text/javascript">
$(document).ready(function() {


	 $(".chzn-select").chosen();
});  
function photo(input,name)
{
	if (input.files && input.files[0]) 
	{
		var reader = new FileReader();
		reader.onload = function (e) 
		{
			input.style.width = '50%';
			$('#'+name+'').attr('src', e.target.result);
			$('#'+name+'').fadeIn();
		};
		reader.readAsDataURL(input.files[0]);
	}
}
</script>

<!-- CK Editor Scripts /Start -->
<?php if(!empty($css_js_files) && in_array('ckeditor', $css_js_files)) { ?>
<script type="text/javascript" src='<?php echo ADMIN_CKEDITOR_JS;?>'></script>
<?php } ?>
<!-- CK Editor Scripts /End -->	

<!-- DATEPICKER Scripts Start -->
<?php if(!empty($css_js_files) && in_array('datepicker', $css_js_files)) { ?>
<script type="text/javascript" src="<?php echo BOOTSTRAP_DATEPICKER_JS;?>"></script>
<script type="text/javascript">
$(document).ready(function() {
	
	var formatt = '<?php echo get_datepicker_format();?>';
	$('.dta').datepicker({format:formatt}).on('changeDate', function(ev)
	{
		$('.datepicker').hide();
	});
	
	
	var nowTemp = new Date();
	var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
	
	var checkin = $('.dpd1').datepicker({
		format:formatt,
	  onRender: function(date) {
		return date.valueOf() < now.valueOf() ? 'disabled' : '';
	  }
	}).on('changeDate', function(ev)
	{
		$('.datepicker').hide();
	});
}); 
</script>
<?php } ?>
<!-- DATEPICKER Scripts /End -->	



<style>
.modal-footer .btn + .btn {
    margin-bottom: 5px;
}
</style>
<!--MODAL-->
<div id="km_notfn_modal" class="modal fade" role="dialog">
  <div class="order-modal-dialog">

  <?php echo form_open(URL_KM_VIEW_ORDER);?>
    <!-- Modal content-->
    <div class="modal-content order-content">
      <div class="order-modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title pt-title"><?php echo get_languageword('new_order');?></h4>
      </div>
      <div class="modal-body">
		<p><?php echo get_languageword('admin_has_been_sent_an_order');?></p>
		<p><?php echo get_languageword('would_you_like_to_view');?>?</p>
		
		<input type="hidden" name="order_id" id="ord_id" value="">
	
      </div>
      
	  <div class="order-modal-footer modal-footer">
		
		<button type="submit" class="btn btn-primary" name="view_order"><?php echo get_languageword('yes');?></button>
	
	  <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo get_languageword('no');?></button>
	</div>
		
    </div>
	<?php echo form_close();?>

  </div>
</div>
<!--MODAL-->

<?php 
$pusher_keyy = $this->config->item('site_settings')->pusher_key;

if ($pusher_keyy!="" && $pusher_keyy!=="KEY") { ?>

<audio id="myAudio" loop>
<script src="<?php echo JS_ADMIN;?>pusher.min.js"></script>

<script>
    // Enable pusher logging - don't include this in production
     Pusher.logToConsole = true;
	 var pusher_key= '<?php echo $pusher_keyy;?>';
			
    var pusher = new Pusher(pusher_key, {
     cluster: 'ap2',
      encrypted: true
    });
		
		
		
	/*ADMIN SENT TO KM*/
    var channel = pusher.subscribe('my-channel');
    channel.bind('km_event', function(data) {
		
		var ord_id = data.order_id;
		
		$('#ord_id').val(ord_id);
		$('#km_notfn_modal').modal('show');
		playAudio();
	});
	/*ADMIN SENT TO KM*/
	
	
	
	
	
	
var x = document.getElementById("myAudio");
function playAudio() 
{
	x.play();
}
</script>

<?php } ?>
</body>
</html>