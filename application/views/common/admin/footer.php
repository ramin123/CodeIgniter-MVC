 <!--Footer   Section-->
        <footer class="footer crunccy-footre">
         <div class="container">
           <div class="row"> 
             <div class="col-md-6 col-sm-6 col-xs-6 crunchy-foot">
                <p><a href="<?php echo SITEURL;?>"> <?php // echo $this->config->item('site_settings')->rights_reserved_content;?> </a> </p>
             </div>
             <div class="col-md-3 col-sm-3 col-xs-3 crunchy-foot">
                 <p><a href="<?php echo SITEURL;?>"> <!--  APP VERSION 1.0.0 --> </a> </p>
             </div>
             <div class="col-md-3 col-sm-3 col-xs-3 crunchy-foot">
             	<p><a href="javascript:void(0)"> Rohullah Amin <?php // echo get_languageword('CI_VERSION'). CI_VERSION; ?></a></p>
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
	
	
    <!-- MORRIS CHART SCRIPTS -->
    <!--script src="<?php //echo JS_ADMIN_MIRROR_RAPHAEL;?>"></script>
    <script src="<?php //echo JS_ADMIN_MIRROR_MIRROR;?>"></script-->
    
      <!-- CUSTOM SCRIPTS -->
    <!--script src="<?php //echo JS_ADMIN_CUSTOM;?>"></script-->
    
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

<!--full calender-->
<?php  
$method = $this->uri->segment(2);
if ($method === "orders-overview") {
?>
<!--FULL CALENDAR-->
<link href="<?php echo CSS_FULLCALENDAR_MIN;?>" rel="stylesheet">
<link href="<?php echo CSS_FULLCALENDAR_PRINT_MIN;?>" rel="stylesheet">
<!--FULL CALENDAR-->
   
<script src='<?php echo JS_FULLCALENDAR_MOMENT_MIN;?>'></script>
<script src='<?php echo JS_FULLCALENDAR_MIN;?>'></script>

<!--full calender-->
<script>
var ajaxResult=[];
var eventss=[];

	$(document).ready(function() 
	{
		$.ajax({
			type: "post",
			url: "<?php echo base_url();?>admin/fetch_orders_overview",
			data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash();?>&',
			cache: false,
			async : false,  
			dataType:"json",
			success: function(data) 
			{
				$.each(data, function(i) {
					ajaxResult[i] = data[i];
				});
			}		
		}); 
		
		for(j=0;j < ajaxResult.length;j++)
		{
			eventss.push(
			{
				title  : ajaxResult[j].title,
				start  : ajaxResult[j].start,
				end    : ajaxResult[j].end,
				color  :  "#FFB347",
				backgroundColor :"#FFB347"
			}
			);
		}
		
		
		$('#calendar_test').fullCalendar({
			
			// timeFormat: 'H(:mm)T',
			// lang: 'es',
			timeFormat: 'hh:mm a',
			displayEventEnd : true,
			header: {
				left: 'prev,next today',
				center: 'title',
				// right: 'month,agendaWeek,agendaDay'
				right: 'month,basicWeek,basicDay'
			},
			defaultDate: new Date(),
			editable: true,
			eventLimit: true, // allow "more" link when too many events
			events: eventss
		});
		
	});



</script>
<?php } ?>


<!--MODAL-->
<div id="notfn_modal" class="modal fade" role="dialog">
  <div class="order-modal-dialog">

  
  <?php echo form_open(URL_VIEW_ORDER);?>
    <!-- Modal content-->
    <div class="modal-content order-content">
      <div class="order-modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo get_languageword('new_order');?></h4>
      </div>
      <div class="modal-body">
		<p class="text-dark"><?php echo get_languageword('you_have_new_order_would_you_like_to_view');?>?</p>
		
		
		<input type="hidden" name="order_id" id="ord_id" value="">
		
		<input type="hidden" name="order_type" value="new">
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



<!--KM SENT TO DM MODAL-->
<div id="km_dm_modal" class="modal fade" role="dialog">
  <div class="order-modal-dialog">
  
<?php echo form_open(URL_VIEW_ORDER);?>
    <!-- Modal content-->
    <div class="modal-content order-content">
      <div class="order-modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo get_languageword('new_order');?></h4>
      </div>
      <div class="modal-body">
		<p><?php echo get_languageword('kitchen_manager_has_been_sent_an_order_to_delivery_manager');?></p>
		<p><?php echo get_languageword('would_you_like_to_view');?>?</p>
		
		<input type="hidden" name="order_id" id="km_sent_order_id" value="">
		
		<input type="hidden" name="order_type" value="out_to_deliver">
      </div>
      
	  <div class="order-modal-footer modal-footer">
		
		<button type="submit" class="btn btn-primary" name="view_order"><?php echo get_languageword('yes');?></button>
	
	  <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo get_languageword('no');?></button>
	</div>
		
    </div>
<?php echo form_close();?>
  </div>
</div>
<!--KM SENT TO DM MODAL-->





<!--DM UPATED DELIVERD STATUS MODAL-->
<div id="dm_admin_modal" class="modal fade" role="dialog">
  <div class="order-modal-dialog">
<?php echo form_open(URL_VIEW_ORDER);?>
    <!-- Modal content-->
    <div class="modal-content order-content">
      <div class="order-modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo get_languageword('new_order');?></h4>
      </div>
      <div class="modal-body">
		<p><?php echo get_languageword('delivery_manager_has_been_updated_an_order_status_as_delivered');?></p>
		<p><?php echo get_languageword('would_you_like_to_view');?>?</p>
		
		<input type="hidden" name="order_id" id="dm_delivered_ord_id" value="">
		
		<input type="hidden" name="order_type" value="delivered">
      </div>
      
	  <div class="order-modal-footer modal-footer">
		
		<button type="submit" class="btn btn-primary" name="view_order"><?php echo get_languageword('yes');?></button>
	
	  <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo get_languageword('no');?></button>
	</div>
		
    </div>
<?php echo form_close();?>
  </div>
</div>
<!--DM UPATED DELIVERD STATUS MODAL-->


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
		
	//NEW ORDER BOOKED	
    var channel = pusher.subscribe('my-channel');
    channel.bind('my_event', function(data) {
		
		var ord_id = data.order_id;
		$('#ord_id').val(ord_id);
		
		$('#notfn_modal').modal('show');
		playAudio();
	});
	//NEW ORDER BOOKED	
	
	
	
	//KM SENT TO DM
	var channel = pusher.subscribe('my-channel');
    channel.bind('km_admin_event', function(data) {
		
		var ord_id = data.order_id;
		$('#km_sent_order_id').val(ord_id);
		
		$('#km_dm_modal').modal('show');
		playAudio();
	});
	//KM SENT TO DM
	
	
	
	//DM UPDATED DELIVERED STATUS
	var channel = pusher.subscribe('my-channel');
    channel.bind('dm_delivered_event', function(data) {
		
		var ord_id = data.order_id;
		
		$('#dm_delivered_ord_id').val(ord_id);
		$('#dm_admin_modal').modal('show');
		playAudio();
	});
	//DM UPDATED DELIVERED STATUS
	
	
	
var x = document.getElementById("myAudio");
function playAudio() 
{
	x.play();
}
</script>
<?php } ?>


</body>
</html>