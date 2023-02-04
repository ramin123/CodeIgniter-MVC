var dtable;
function get_tableData(tbl_id, url,conditions, disablesorting,default_order,type='') 
{
	try
	{
			$('#'+tbl_id).dataTable().fnDestroy();

	}
	catch(e)
	{
		
	}
	
	var parts = new Array();
	if(typeof(disablesorting) != 'undefined')
	{
		parts = disablesorting.split(',').map(function(item) {
			return parseInt(item);
		});
	}
	//console.log(parts); 
	dtable=$('#'+tbl_id).DataTable({
			"aoColumnDefs": [
			  { 'bSortable': false, 'aTargets': parts }
			],
			"order": default_order,
			"processing": true,
			"serverSide": true,
			"bDestroy": true,
			"ajax": {
				"url": url,
				"type": "POST",
				"async":true,
				"data": function(d){ d.conditions = conditions;d.type=type },
				"error": function(data, statusText, xhr){ if(xhr.status==303) location.reload(); console.log(xhr.status);}
			},			
			"language": {
				"lengthMenu": "Display _MENU_ records per page",
				"zeroRecords": "No records found!",
				"info": "Displaying _START_ to _END_ of _TOTAL_ records",
				"infoEmpty": "No records available",
				"infoFiltered": "(Filtration of _MAX_ records)"
			},
			
	});
	// console.log(" URL : "+url);
	// console.log(" TABLEID : "+tbl_id);
	// console.log(" Conditions : "+conditions);
	$('#'+tbl_id).dataTable();
	return false;
}

function in_array(needle, haystack, argStrict) {
  var key = '',
    strict = !! argStrict;
  if (strict) {
    for (key in haystack) {
      if (haystack[key] === needle) {
        return true;
      }
    }
  } else {
    for (key in haystack) {
      if (haystack[key] == needle) {
        return true;
      }
    }
  }

  return false;
}