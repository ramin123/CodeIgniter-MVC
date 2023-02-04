<div id="page-wrapper">
           
               
            <div class="row">
                <div class="col-md-12">
				
					<!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                             <?php if(!empty($pagetitle)) echo $pagetitle;?>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
							
			<?php echo $this->session->flashdata('message'); ?>

			<table id="example" class="cell-border example" cellspacing="0" width="100%">
               <thead>
                  <tr>
                     <th>#</th>
                     <th><?php echo get_languageword('sms_gateway_name');?></th>
                     <th><?php echo get_languageword('is_default');?></th>
                     <th><?php echo get_languageword('action');?></th>
                  </tr>
               </thead>
               <tfoot>
                  <tr>
                     <th>#</th>
                     <th><?php echo get_languageword('sms_gateway_name');?></th>
                     <th><?php echo get_languageword('is_default');?></th>
                     <th><?php echo get_languageword('action');?></th>
                  </tr>
               </tfoot>
			   <?php if(isset($records) && !empty($records)) {?>
               <tbody>
                  <?php $cnt = 1; foreach($records as $r) { ?>
                  <tr>
                     <td><?php echo $cnt++;?></td>
                     <td><?php echo $r->sms_gateway_name;?></td>
                     <td><?php echo $r->is_default;?></td>
                     <td>
					 <div class="row">
						<?php 
						 echo form_open(URL_UPDATE_SMS_FIELD_VALUDS);
						
						 echo form_hidden('sms_gateway_id',$r->sms_gateway_id);
						 
						 echo '<button type="submit" name="edit_sms_gateway" class="btn btn-primary"><i class="fa fa-edit"></i></button>';
						 
						 echo form_close();
						?>
					 
                         <?php 
                          
						   
						   echo form_open(URL_MAKE_DEFAULT);
				
						   echo form_hidden('sms_gateway_id',$r->sms_gateway_id);
						   
						   echo '<button type="submit" name="sms_gateway" class="btn btn-warning" title="Make Default Gateway"><i class="fa fa-hand-o-right"></i></button>';
						   echo form_close();
                           ?> 
					</div>  
                     </td>
                  </tr>
                  <?php } ?>
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
				
				
 	<?php $this->load->view('modals/delete-modal'); ?>