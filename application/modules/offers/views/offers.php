<div id="page-wrapper">
            <div class="row">
                <div class="col-md-12">
				
				<a title="<?php echo get_languageword('add_single_record'); ?>" class="btn btn-primary btn-xs pull-right" href="<?php echo URL_ADD_OFFER;?>"><i class="fa fa-plus"></i> </a>
				
					<?php $this->load->view('common_sections/multi_action_section'); ?>

					<!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                             <?php if(!empty($pagetitle)) echo $pagetitle;?>
                        </div>
                        <div class="panel-body">
                            
							
			<?php echo $this->session->flashdata('message'); ?>

			<div class="table-responsive">
			<table id="example" class="display responsive nowrap" width="100%" cellspacing="0">
			  	<thead>
					<tr>
						<th><input type="checkbox" class="ip_check_all" name="check_all" id="check_all" onclick="toggle_check_all(this);"> </th>
						<th><?php echo get_languageword('offer_name');?></th>
						<th><?php echo get_languageword('offer_price');?></th>
						<th><?php echo get_languageword('offer_start_date');?></th>
						<th><?php echo get_languageword('offer_valid_date');?></th>
						<th><?php echo get_languageword('no_of_items');?></th>
						<th><?php echo get_languageword('status');?></th>
						<th><?php echo get_languageword('actions');?></th>
					</tr>
				</thead>

				<tfoot>
					<tr>
						<th><input type="checkbox" class="ip_check_all" name="check_all" id="check_all" onclick="toggle_check_all(this);"> </th>
						<th><?php echo get_languageword('offer_name');?></th>
						<th><?php echo get_languageword('offer_price');?></th>
						<th><?php echo get_languageword('offer_start_date');?></th>
						<th><?php echo get_languageword('offer_valid_date');?></th>
						<th><?php echo get_languageword('no_of_items');?></th>
						<th><?php echo get_languageword('status');?></th>
						<th><?php echo get_languageword('actions');?></th>
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
				
				
 	<?php $this->load->view('modals/delete-modal'); ?>