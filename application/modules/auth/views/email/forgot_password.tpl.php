<html>
<body>
	<h1><?php echo sprintf(lang('email_forgot_password_heading'), $identity);?></h1>
	<p><?php echo sprintf(lang('email_forgot_password_subheading'), '<a href="'.URL_RESET_PASSWORD.DS.$forgotten_password_code.'">'.lang('email_forgot_password_link').'</a>');?></p>
</body>
</html>