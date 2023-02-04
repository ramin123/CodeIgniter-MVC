  <div class="btn-group pull-right">
    <button data-toggle="dropdown" class="btn btn-danger btn-xs margin-right-5 dropdown-toggle" type="button">
      <span class="caret"></span></button>
      <ul class="dropdown-menu menu-drop bg-grey" role="menu" aria-labelledby="dLabel">

		<?php if(empty($delete)) {?>
         <li>
          <a data-toggle="modal" data-target="#commonModal" title="<?php echo get_languageword('Delete_Selected'); ?>" onclick="set_fields('delete_selected', 'delete_selected');"><i class="fa fa-trash"></i> <?php echo get_languageword('delete'); ?></a>
         </li>
		 
		<?php } if(empty($only_delete)) { ?>
         <li>
          <a data-toggle="modal" data-target="#commonModal" title="<?php echo get_languageword('Activate_Selected'); ?>" onclick="set_fields('activate_selected', 'activate_selected');"><i class="fa fa-check"></i> <?php echo get_languageword('activate'); ?></a>
         </li>
         <li>
          <a data-toggle="modal" data-target="#commonModal" title="<?php echo get_languageword('Deactivate_Selected'); ?>" onclick="set_fields('deactivate_selected', 'deactivate_selected');"><i class="fa fa-ban"></i> <?php echo get_languageword('deactivate'); ?></a>
         </li>
         <?php } ?>

      </ul>
 </div>