<div id="page-wrapper">


            <div class="row">

			  

				<div class="col-md-12">

				<?php echo $this->session->flashdata('message'); ?>


					<!-- Advanced Tables -->

                    <div class="panel panel-default">

                        <div class="panel-heading">

                             <?php if(!empty($pagetitle)) echo $pagetitle;?>

                        </div>

                        <div class="panel-body">
						
						
						<!---->
						<div class="row">
						 <div class="col-md-12 reports clearfix">

			<?php

				$attributes = array('name'=>'report_form','id'=>'report_form');

				echo form_open(URL_REPORTS_LOCATION_WISE,$attributes);?>

            

				

				

				<div class="form-group col-md-3">

				 <label><?php echo get_languageword('cities').required_symbol();?></label>

				<?php 

				$val='';

				if(isset($_POST['location_wise_reports']))

				{

					$val=$_POST['city_id'];

				}

				echo form_dropdown('city_id',$cities_options,$val,'class="chzn-select" onchange="get_localities(this.value)" id="city_id"');

				?>

				</div>

				

				<div class="form-group col-md-3">

				 <label><?php echo get_languageword('locality').required_symbol();?></label>

				<?php 

				$locality_options=array();

				$val='';

				if(isset($_POST['location_wise_reports']))

				{

					$val=$_POST['locality'];

				}

				echo form_dropdown('locality',$locality_options,$val,'class="chzn-select" id="locality"');

				?>

				</div>

				

				

				<div class="form-group col-md-3">

				<button type="submit" name="location_wise_reports" value="location_wise_reports" class="btn btn-primary btn-lg"><?php echo get_languageword('submit');?></button>

				</div>

				

				<?php if(isset($_POST['location_wise_reports']) && isset($total_profit)) {?>

				<div class="form-group  col-md-3">

				<div class="order-summary"><strong><?php echo get_languageword('total_amount').'  '.$this->config->item('site_settings')->currency_symbol.$total_profit;?></strong>
				</div>

				</div>

				<?php } ?>

				

				<?php echo form_close();?>

				</div>
						
						</div>
						<!---->

                            <div class="table-responsive">

							

			


			<table id="example" class="display responsive nowrap" width="100%" cellspacing="0">

			  	<thead>

					<tr>

						<th><?php echo get_languageword('s_no');?></th>

						<th><?php echo get_languageword('customer_name');?></th>

						<th><?php echo get_languageword('phone');?></th>

						<th><?php echo get_languageword('no_of_items');?></th>

						<th><?php echo get_languageword('order_cost');?></th>

						<th><?php echo get_languageword('booked_date');?></th>

						<th><?php echo get_languageword('payment');?></th>

						<th><?php echo get_languageword('paid_amount');?></th>

					</tr>

				</thead>

				<?php if(isset($records) && !empty($records)) {?>

				<tbody>

				<?php 

				$i=0;

				foreach($records as $r):

				$i++;?>

				<tr>

				<td><?php echo $i;?></td>

				<td><?php if(isset($r->customer_name)) echo $r->customer_name;?></td>

				<td><?php if(isset($r->phone)) echo $r->phone;?></td>

				<td><?php if(isset($r->no_of_items)) echo $r->no_of_items;?></td>

				<td><?php if(isset($r->total_cost)) echo $r->total_cost;?></td>

				<td><?php if(isset($r->order_date)) echo get_date($r->order_date).' - '.$r->order_time;?></td>

				<td><?php if(isset($r->payment_type)) echo $r->payment_type;?><?php if($r->payment_gateway != '') echo ' - '.$r->payment_gateway;?></td>

				<td><?php echo $r->paid_amount;?></td>

				</tr>

				<?php endforeach;?>

				</tbody>

				<?php } ?>

				<tfoot>

					<tr>

						<th><?php echo get_languageword('s_no');?></th>

						<th><?php echo get_languageword('customer_name');?></th>

						<th><?php echo get_languageword('phone');?></th>

						<th><?php echo get_languageword('no_of_items');?></th>

						<th><?php echo get_languageword('order_cost');?></th>

						<th><?php echo get_languageword('booked_date');?></th>

						<th><?php echo get_languageword('payment');?></th>

						<th><?php echo get_languageword('paid_amount');?></th>

					</tr>

				</tfoot>



				<tbody>



				</tbody>

			</table>

			</div>

			</div>

			</div>

		 </div>

                        </div>

                  

                    <!--End Advanced Tables -->

                </div>

				

				

<!-- Form Validation Plugins /Start -->

<?php if(!empty($css_js_files) && in_array('form_validation', $css_js_files)) { ?>



<link href="<?php echo CSS_ADMIN_OR_BOOTSTRAP_VALIDATOR;?>" rel="stylesheet">

<script type="text/javascript" src="<?php echo JS_ADMIN_BOOTSTRAP_VALIDATOR;?>"></script>

<script type="text/javascript">

    $(document).ready(function () {

		

        $('#report_form').bootstrapValidator({

            // To use feedback icons, ensure that you use Bootstrap v3.1.0 or later

            /* feedbackIcons: {

                valid: 'glyphicon glyphicon-ok',

                invalid: 'glyphicon glyphicon-remove',

                validating: 'glyphicon glyphicon-refresh'

            }, */

			framework: 'bootstrap',

            excluded: ':disabled',

            fields: {

                city_id: {

                    validators: {

                        notEmpty: {

                            message: '<?php echo get_languageword('city_required');?>'

                        }

                    }

                },

				locality: {

                    validators: {

                        notEmpty: {

                            message: '<?php echo get_languageword('locality_required');?>'

                        }

                    }

                }

                

            },

			 submitHandler: function(validator, form, submitButton) {

				form.submit();

			}

        })

    });

	

function get_localities(city_id)

{

	$("#locality").empty();

	$("#locality").trigger('liszt:updated');

	if(city_id > 0)

	{

		$.ajax({			 

			 type: 'POST',			  

			 async: false,

			 cache: false,	

			 url: "<?php echo base_url();?>reports/get_localities",

			 data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash();?>&city_id='+city_id,

			 success: function(data) 

			 {

				if(data != '' && data != 0)

				{

					$('#locality').empty();

					$('#locality').append(data);

				}

				else if(data==999)

				{

					window.location = '<?php echo SITEURL;?>';

				} 

				<?php if(isset($_POST['location_wise_reports'])) {?>

				var locality = '<?php echo $_POST['locality'];?>';

				$("#locality").val(locality);

				<?php } ?>

				$("#locality").trigger("liszt:updated");

			 }		  		

		});

	}

}



$(document).ready(function(){

	<?php if(isset($_POST['location_wise_reports'])) {?>

	var city_id = $("#city_id option:selected").val();

	get_localities(city_id);

	<?php } ?>

});	

</script>

<?php } ?>