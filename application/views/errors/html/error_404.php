<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>404 Page Not Found</title>


<script>
function goBack()
{
window.history.back()
}
</script>
</head>

<body>
  <div id="container">
	
	
	<div class="row">
	
	<div class="form-group">
	<img src="<?php echo SITEURL;?>assets/front/images/404-foodcourt.png" alt="404 IMAGE">
	</div>
	
	
	<div class="form-group">
	<button type="button" class="btn btn-default" onclick="goBack()">Go Back </button>
	</div>
	
	
	<div class="form-group">
	<a href="<?php echo SITEURL;?>" class="btn btn-warning" title="Home">Home </a>
	</div>
	
	</div>


	
			
	</div>
   </div>
</body>
</html>