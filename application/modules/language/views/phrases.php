<div id="page-wrapper">
            <div class="row">
                <div class="col-md-12">
				
				
            	<a title="<?php echo get_languageword('Add_New_Record'); ?>" class="btn btn-primary btn-xs pull-right" href="<?php echo URL_LANGUAGE_ADDEDIT_PHRASE; ?>"><i class="fa fa-plus"></i> </a>

				<?php $this->load->view('common_sections/multi_action_section', array('only_delete' => true)); ?>
				
                   
					<!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                             <?php if(!empty($pagetitle)) echo $pagetitle;?>
                        </div>
                        <div class="panel-body">
                            
							
				

			<?php echo $this->session->flashdata('message'); ?>

			<div class="table-responsive">
			<table id="example" class="display responsive nowrap" width="100%" cellspacing="0" cellpadding="0">
			  	<thead>
					<tr>
						<th><input type="checkbox" class="ip_check_all" name="check_all" id="check_all" onclick="toggle_check_all(this);"> </th>
						<th><?php echo get_languageword('Phrase_For'); ?></th>

						<th><?php echo get_languageword('Lang_Key'); ?></th>

						<th><?php echo get_languageword('english'); ?></th>
						
						<th style="min-width:80px !important;"><?php echo get_languageword('actions'); ?></th>
					</tr>
				</thead>

				<tfoot>
					<tr>
						
						<th><input type="checkbox" class="ip_check_all" name="check_all" id="check_all" onclick="toggle_check_all(this);"> </th>

						<th><?php echo get_languageword('Phrase_For'); ?></th>

						<th><?php echo get_languageword('Lang_Key'); ?></th>

						<th><?php echo get_languageword('english'); ?></th>
						
						<th><?php echo get_languageword('actions'); ?></th>
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