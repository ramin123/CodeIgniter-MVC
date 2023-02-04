<div id="page-wrapper">
           
            <div class="row">
                <div class="col-md-12">
				
            	<a title="<?php echo get_languageword('Add_New_Record'); ?>" class="btn btn-primary btn-xs pull-right" href="<?php echo URL_ADD_LANGUAGE;?>"><i class="fa fa-plus"></i> </a>
				
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
						<th>#</th>
						<th><?php echo get_languageword('language');?></th>												<th><?php echo get_languageword('language_code');?></th>
						<th><?php echo get_languageword('actions');?></th>
					</tr>
				</thead>

				<tfoot>
					<tr>
						<th>#</th>
						<th><?php echo get_languageword('language');?></th>												<th><?php echo get_languageword('language_code');?></th>						
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