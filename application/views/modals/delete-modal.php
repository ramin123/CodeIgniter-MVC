
  <div class="modal-warning modal fade" id="commonModal" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span></button>
            <h3 class="modal-title" id="modal_title"><?php echo get_languageword('warning'); ?></h3>
          </div>
          <div class="modal-body">
            <p class="f_size_19" id="mdl_bdy_hdng"><?php echo get_languageword('are_you_sure_to_delete').'?'; ?></p>
          </div>
          <div class="modal-footer" id="modal_footer">
            
            <?php
            		echo form_open('', 'id="delete_form"'); 
            		echo '<div id="hidden_fieldz"></div>';
            ?>
            <button type="submit" class="btn btn-outline crunch-bnt crunch-primary"><?php echo get_languageword('yes'); ?></button>
			
			<button type="button" class="btn btn-outline crunch-no crunch-bnt crunch-primary" data-dismiss="modal"><?php echo get_languageword('no'); ?></button>
            <?php echo form_close(); ?>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
  </div>


  <script type="text/javascript">
    function set_fields(param1, param2)
    {
      if(!param1 || !param2)
        return;

      field1 = "";
      field2 = "";

      document.getElementById('commonModal').removeAttribute("class");
      document.getElementById('modal_title').innerHTML  = "<?php echo get_languageword('Warning'); ?>";
      document.getElementById('modal_footer').style.display = "block";

      if(param1 == "delete_selected") { /* If wants to delete selected records */

        if(document.querySelectorAll('input[name="check_rows[]"]:checked').length > 0) { /* If selected atleast one record */

          document.getElementById('commonModal').setAttribute("class", "modal-danger modal fade");
          document.getElementById('mdl_bdy_hdng').innerHTML = "<?php echo get_languageword('are_you_sure_to_delete_selected_records').'?'; ?>";

          selected_vals = get_selected('check_rows[]');
          field1 = '<input type="hidden" name="param1" value="'+param1+'" />';
          field2 = '<input type="hidden" name="param2" value="'+selected_vals+'" />';

        } else { /* If no record selected */

          no_record_selected_alert("<?php echo get_languageword('please_select_records_to_be_deleted'); ?>");
        }

      } else if(param1 == "delete") { /* If wants to delete individual record */

        document.getElementById('commonModal').setAttribute("class", "modal-danger modal fade");
        document.getElementById('mdl_bdy_hdng').innerHTML = "<?php echo get_languageword('are_you_sure_to_delete').'?'; ?>";

        field1 = '<input type="hidden" name="param1" value="'+param1+'" />';
        field2 = '<input type="hidden" name="param2" value="'+param2+'" />';

      } else if(param1 == "activate_selected") { /* If wants to activate selected records */

        if(document.querySelectorAll('input[name="check_rows[]"]:checked').length > 0) { /* If selected atleast one record */

          document.getElementById('commonModal').setAttribute("class", "modal-primary modal fade");
          document.getElementById('modal_title').innerHTML  = "<?php echo get_languageword('confirm'); ?>";
          document.getElementById('mdl_bdy_hdng').innerHTML = "<?php echo get_languageword('are_you_sure_to_activate_selected_records').'?'; ?>";

          selected_vals = get_selected('check_rows[]');
          field1 = '<input type="hidden" name="param1" value="'+param1+'" />';
          field2 = '<input type="hidden" name="param2" value="'+selected_vals+'" />';

        } else { /* If no record selected */

          no_record_selected_alert("<?php echo get_languageword('please_select_records_to_be_activated'); ?>");
        }

      } else if(param1 == "deactivate_selected") { /* If wants to deactivate selected records */

        if(document.querySelectorAll('input[name="check_rows[]"]:checked').length > 0) { /* If selected atleast one record */

          document.getElementById('commonModal').setAttribute("class", "modal-primary modal fade");
          document.getElementById('mdl_bdy_hdng').innerHTML = "<?php echo get_languageword('are_you_sure_to_deactivate_selected_records').'?'; ?>";

          selected_vals = get_selected('check_rows[]');
          field1 = '<input type="hidden" name="param1" value="'+param1+'" />';
          field2 = '<input type="hidden" name="param2" value="'+selected_vals+'" />';

        } else { /* If no record selected */

          no_record_selected_alert("<?php echo get_languageword('please_select_records_to_be_deactivated'); ?>");
        }

      }

      content = (field1+field2);

      the_div = document.getElementById("hidden_fieldz");
      the_div.innerHTML = content;
    }



    function get_selected(name)
    {
      var select1 = document.getElementsByName(name);
      var selected1 = [];
      for (var i = 0; i <select1.length; i++) {
        if(select1[i].checked)
          selected1.push(select1[i].value);
      }

      return selected1;
    }


    function no_record_selected_alert(info_txt)
    {
        document.getElementById('commonModal').setAttribute("class", "modal-info modal fade");
        document.getElementById('mdl_bdy_hdng').innerHTML = info_txt;
        document.getElementById('modal_title').innerHTML  = "<?php echo get_languageword('information'); ?>";
        document.getElementById('modal_footer').style.display = "none";
    }

	

	
function toggle_check_all(ele)
{	
	if(!ele)
	  return;

	var checkboxes = $('input[type=checkbox]');
	
	if (ele.checked) 
	{
		for (var i = 0; i < checkboxes.length; i++) {
		   //if (checkboxes[i].type == 'checkbox') {
				checkboxes[i].checked = true;
		   //}
		}
	} 
	else 
	{
		for (var i = 0; i < checkboxes.length; i++) {
		   //if (checkboxes[i].type == 'checkbox') {
				 checkboxes[i].checked = false;
		   //}
		}
	}
}
</script>