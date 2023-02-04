<div id="page-wrapper">
           
            <div class="row">
                <div class="col-md-12">
			<a title="<?php echo get_languageword('go_to_list'); ?>" class="btn btn-primary btn-xs pull-right" href="<?php echo URL_USER_REWARD_POINTS; ?>"><i class="fa fa-list"></i></a>			
					<!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                             <?php if(!empty($pagetitle)) echo $pagetitle;?>							
                        </div>						
                        <div class="panel-body">
                            <div class="table-responsive">
							
			<?php echo $this->session->flashdata('message'); ?>

			<table id="example" class="display responsive nowrap" width="100%" cellspacing="0">
			  	<thead>
					<tr>
						<th><?php echo get_languageword('s_no');?></th>
						<th><?php echo get_languageword('points');?></th>
						<th><?php echo get_languageword('transaction_type');?></th>
						<th><?php echo get_languageword('description');?></th>
					</tr>
				</thead>

				<tfoot>
					<tr>
						<th><?php echo get_languageword('s_no');?></th>
						<th><?php echo get_languageword('points');?></th>
						<th><?php echo get_languageword('transaction_type');?></th>
						<th><?php echo get_languageword('description');?></th>
					</tr>
				</tfoot>

				<?php if(isset($records) && !empty($records)) {?>
				<tbody>
				<?php $i=0;
				foreach($records as $record):
				$i++;?>
				<tr>
				<td><?php echo $i;?></td>
				<td><?php echo $record->points;?></td>
				<td><?php echo $record->transaction_type;?></td>
				<td><?php echo $record->description;?></td>
				</tr>
				<?php endforeach;?>
				</tbody>
				<?php } ?>
				
			</table>
			</div>
			</div>
			</div>
		 </div>
                        </div>
                    
                    <!--End Advanced Tables -->
                </div>