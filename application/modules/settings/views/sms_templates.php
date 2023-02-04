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
			<table id="example" class="cell-border example" cellspacing="0" width="100%">
               <thead>
                  <tr>
                     <th>#</th>
                     <th><?php echo get_languageword('subject');?></th>
                     <th><?php echo get_languageword('sms_template');?></th>
                     <th><?php echo get_languageword('action');?></th>
                  </tr>
               </thead>
               <tfoot>
                  <tr>
                     <th>#</th>
					 <th><?php echo get_languageword('subject');?></th>
                     <th><?php echo get_languageword('sms_template');?></th>
                     <th><?php echo get_languageword('action');?></th>
                  </tr>
               </tfoot>
			   <?php if(isset($records) && !empty($records)) {?>
               <tbody>
                  <?php $cnt = 1; foreach($records as $r) { ?>
                  <tr>
                     <td><?php echo $cnt++;?></td>
                     <td><?php echo $r->subject;?></td>
                     <td><?php echo $r->sms_template;?></td>
                     <td>
					 <div class="row">
						<?php 
						 echo form_open(URL_SMS_TEMPLATES);
						
						 echo form_hidden('sms_template_id',$r->sms_template_id);
						 
						 echo '<button type="submit" name="edit_template" class="btn btn-primary"><i class="fa fa-edit"></i></button>';
						 
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