<div id="page-wrapper">
            <div class="row">
                <div class="col-md-12">
			
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
						<th><?php echo get_languageword('s_no');?></th>
						<th><?php echo get_languageword('refer_user');?></th>
						<th><?php echo get_languageword('points');?></th>
						<th><?php echo get_languageword('referred_by');?></th>
						<th><?php echo get_languageword('points');?></th>
						<th><?php echo get_languageword('date');?></th>
					</tr>
				</thead>

				<tfoot>
					<tr>
						<th><?php echo get_languageword('s_no');?></th>
						<th><?php echo get_languageword('refer_user');?></th>
						<th><?php echo get_languageword('points');?></th>
						<th><?php echo get_languageword('referred_by');?></th>
						<th><?php echo get_languageword('points');?></th>
						<th><?php echo get_languageword('date');?></th>
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