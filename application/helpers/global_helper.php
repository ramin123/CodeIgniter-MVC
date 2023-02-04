<?php 
/**
 * Restaurant-Conquerors Market
 * 
 * An online food order system in codeigniter framework
 * 
 * This content is released under the Codecanyon Market License (CML)
 * 
 * Copyright (c) 2018 - 2019, Conquerors Market
 *
 * @category  Helper
 * @package   Restaurant
 * @author    Conquerors Market <conquerorsmarket@gmail.com>
 * @copyright 2018 - 2019, Conquerors Market
 * @license   http://opensource.org/licenses/MIT    MIT License
 * @link      http://codeigniter.com
 * @since     Version 1.0.0
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter Helper
 * 
 * Helper operations.
 *
 * @category  Helper
 * @package   Restaurant
 * @author    Conquerors Market <conquerorsmarket@gmail.com>
 * @copyright 2018 - 2019, Conquerors Market
 * @license   http://opensource.org/licenses/MIT    MIT License
 * @link      http://codeigniter.com
 */



if ( ! function_exists('sendEmail'))
{	
	/**
	 * [sendEmail description]
	 * @param  [type] $from       [description]
	 * @param  [type] $to         [description]
	 * @param  [type] $sub        [description]
	 * @param  [type] $msg        [description]
	 * @param  [type] $cc         [description]
	 * @param  [type] $bcc        [description]
	 * @param  [type] $attachment [description]
	 * @param  [type] $multiuser  [description]
	 * @return [type]             [description]
	 */
	function sendEmail($from = NULL, $to = NULL, $sub = NULL, $msg = NULL, $cc = NULL, $bcc = NULL, $attachment = NULL, $multiuser = NULL)
	{

		if (!filter_var($from, FILTER_VALIDATE_EMAIL) || !filter_var($to, FILTER_VALIDATE_EMAIL)) {
			return FALSE;
		}
		$CI =& get_instance();

		/**sendEmail through Webmail settings **/
		if ($msg != "") {


			$CI->load->library('email');
			$CI->email->clear();
			$config = Array(
						'protocol' 	=> 'smtp',//smtp
						'smtp_host' => $CI->config->item('email_settings')->smtp_host,
						'smtp_port' => $CI->config->item('email_settings')->smtp_port,
						'smtp_user' => $CI->config->item('email_settings')->smtp_user,
						'smtp_pass' => $CI->config->item('email_settings')->smtp_password,
						'charset' 	=> 'utf-8',
						'mailtype' 	=> 'html',
						'newline' 	=> "\r\n",
						'wordwrap' 	=> TRUE
					);

			if ($CI->config->item('email_settings')->mail_config == "webmail"){

				$CI->email->initialize($config);

				$CI->email->from($CI->config->item('email_settings')->smtp_user, $CI->config->item('site_settings')->site_title);

				$CI->email->reply_to($from);

				$CI->email->to($to);

				if ($cc != "" && filter_var($cc, FILTER_VALIDATE_EMAIL))
					$CI->email->cc($cc);
				if ($bcc != "" && filter_var($bcc, FILTER_VALIDATE_EMAIL))
					$CI->email->bcc($bcc);

				if ($attachment != "")
					$CI->email->attach($attachment);

				$CI->email->subject($sub);
				$CI->email->message($msg);


				if ( $CI->email->send() )
					return TRUE;
				else {
					return FALSE;
					// echo "<pre>";print_r($CI->email->print_debugger());die();
				}
				
			} else { /*sendEmail through mandrill**/

				$CI->load->config('mandrill');

				$CI->load->library('mandrill');

				$mandrill_ready = NULL;

				try {
					$CI->mandrill->init($CI->config->item('mandrill_api_key'));
					$mandrill_ready = TRUE;
				} catch(Mandrill_Exception $e) {
					$mandrill_ready = FALSE;
				}

				if ( $mandrill_ready ) {

					$to_list = array(array('email' => $to ));
					if ($multiuser)
						$to_list = $to;

					//Send us some email!
					$email = array(
						'html' => $msg, //Consider using a view file
						'text' => '',
						'subject' => $sub,
						'from_email' => $from,
						'from_name' => $CI->config->item('site_settings')->site_title,
						'to' => $to_list
						);

						$result = $CI->mandrill->messages_send($email);
						
						if ($result[0]['status']=='sent')
						return TRUE;
						else
						return FALSE;
				}
			}
		}
		return FALSE;
	}
}





if ( ! function_exists('getUserRec'))
{
	/**
	 * [getUserRec description]
	 * @param  string $userId [description]
	 * @return [type]         [description]
	 */
	function getUserRec($userId='')
	{			
		$CI =& get_instance();
		$user = $CI->ion_auth->user()->row();
		if ($userId!='' && is_numeric($userId))
		{
			$user = $CI->ion_auth->user($userId)->row();
		}			
		return $user;
	}
}



if ( ! function_exists('getUserType'))
{
	/**
	 * [getUserType description]
	 * @param  string $user_id [description]
	 * @return [type]          [description]
	 */
	function getUserType($user_id='')
	{
		$CI =& get_instance();
		$user_type='';
		if($user_id=='')
		{
			$user_id = getUserRec()->id;
		}
		$user_groups = $CI->ion_auth->get_users_groups($user_id)->result();
		switch($user_groups[0]->id)
		{
			case 1: $user_type='admin';
				break;
			case 2: $user_type='user';
				break;
			case 3: $user_type='kitchen_manager';
				break;
			case 4: $user_type='delivery_manager';
				break;					
			default:
				break;
		} 
		return $user_type;
	}
}



if ( ! function_exists('getUserTypeId'))
{
	/**
	 * [getUserTypeId description]
	 * @param  string $user_id [description]
	 * @return [type]          [description]
	 */
	function getUserTypeId($user_id='')
	{
		$CI =& get_instance();
		$user_type='';
		if(getUserRec() != NULL)
		{
		if($user_id=='') 
		{
			$user_id = getUserRec()->id;
		}
		$user_groups = $CI->ion_auth->get_users_groups($user_id)->result();
		if(count($user_groups))
			return $user_groups[0]->id;
		else
			return 0;
		}else
		{
			return 0;
		}
	}
}




if( ! function_exists('getTemplate'))
{
	/**
	 * [getTemplate description]
	 * @return [type] [description]
	 */
	function getTemplate()
	{
		$CI =& get_instance();
		$user_type='';
		$template='';
		
		if($CI->ion_auth->logged_in())
		{
			$user_id = getUserRec()->id;
		
			$user_groups = $CI->ion_auth->get_users_groups($user_id)->result();
			switch($user_groups[0]->id)
			{
				case 1: 
					$user_type='admin';
					$template = TEMPLATE_ADMIN;
					break;
				case 2: 
					$user_type='user';
					$template = TEMPLATE_SITE;
					break;
				case 3: 
					$user_type='kitchen_manager';
					$template = TEMPLATE_KM;
					break;
				case 4: 
					$user_type='delivery_manager';
					$template = TEMPLATE_DM;
					break;	
				default:
					$template = TEMPLATE_SITE;
					break;
			} 
		}
		else
		{
			$template = TEMPLATE_SITE;
		}
		return $template;
	}
}




if ( ! function_exists('get_languageword'))
{
	/**
	 * [get_languageword description]
	 * @param  string $phrase    [description]
	 * @param  array  $variables [description]
	 * @return [type]            [description]
	 */
	function get_languageword($phrase = '', $variables = array()) 
	{
		$phrase = strip_tags($phrase);
		$CI	=&	get_instance();
		$CI->load->database();
		$current_language	=	strtolower($CI->session->userdata('current_language'));	
		$sitedefault = $CI->config->item('site_settings')->site_language;
		//echo $current_language;die();
		if ( $current_language	==	'') {				
			if ($sitedefault != '') {				
				$CI->session->set_userdata('current_language', $sitedefault);
			}
			else {
				$CI->session->set_userdata('current_language', 'english');
			}

			$CI->session->set_userdata('current_language', 'english');
			$current_language	=	strtolower($CI->session->userdata('current_language'));
		} 
		elseif ($current_language != $sitedefault)
		{
			if ($sitedefault != '') {
				$CI->session->set_userdata('current_language', $sitedefault);
			}
			else {
				$CI->session->set_userdata('current_language', 'english');
			}
		}
		$query = $CI->db->get_where('languagewords', array('lang_key' => $phrase));
		$row   	=	$query->row();
		
		if ($row == NULL)
		{
			/*
			$apiKey = '<paste your API key here>';
			$url = 'https://www.googleapis.com/language/translate/v2?key=' . $apiKey . '&q=' . rawurlencode($phrase) . '&source=en&target=fr';
			$handle = curl_init($url);
			curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
			$response = curl_exec($handle);                 
			$responseDecoded = json_decode($response, true);
			curl_close($handle);

			echo 'Source: ' . $text . '<br>';
			echo 'Translation: ' . $responseDecoded['data']['translations'][0]['translatedText'];
			*/

			$data = array(
				'lang_key' => $phrase,
				'english' => ucfirst(str_replace('_', ' ', $phrase)),
			);
			$CI->db->insert('languagewords', $data); //If word is not found in database we are inserting it as new word
		}
		
		if (isset($row->$current_language) && $row->$current_language !="")
		{
			if (empty($variables))
			{
				return $row->$current_language;
			}
			else
			{
				return sprintf($row->$current_language, implode($variables));
			}
		}
			
		else
		{
			return str_replace('_', ' ', $phrase);
		}
		
	}
}




if ( ! function_exists('prepare_message'))
{
	/**
	 * [prepare_message description]
	 * @param  [type]  $msg  [description]
	 * @param  integer $type [description]
	 * @return [type]        [description]
	 */
    function prepare_message($msg,$type = 2)
    {
		$returnmsg='';
		switch($type){
			case 0: $returnmsg = " <div class='col-md-12'>
										<div class='alert alert-success'>
											<a href='#' class='close' data-dismiss='alert'>&times;</a>
											<strong>".get_languageword('success')."!</strong> ". $msg."
										</div>
									</div>";
				break;
			case 1: $returnmsg = " <div class='col-md-12'>
										<div class='alert alert-danger'>
											<a href='#' class='close' data-dismiss='alert'>&times;</a>
											<strong>".get_languageword('error')."!</strong> ". $msg."
										</div>
									</div>";
				break;
			case 2: $returnmsg = " <div class='col-md-12'>
										<div class='alert alert-info'>
											<a href='#' class='close' data-dismiss='alert'>&times;</a>
											<strong>".get_languageword('info')."!</strong> ". $msg."
										</div>
									</div>";
				break;
			case 3: $returnmsg = " <div class='col-md-12'>
										<div class='alert alert-warning'>
											<a href='#' class='close' data-dismiss='alert'>&times;</a>
											<strong>".get_languageword('warning')."!</strong> ". $msg."
										</div>
									</div>";
				break;
		}
		
		return $returnmsg;
    }
}



if ( ! function_exists('check_access'))
{
	/**
	 * [check_access description]
	 * @param  string $type [description]
	 * @return [type]       [description]
	 */
	function check_access( $type = 'admin')
	{
		$CI	=&	get_instance();
		
		if (!$CI->ion_auth->logged_in())
		{
			$CI->prepare_flashmessage(get_languageword('Please_login_to_continue'), 2);
			redirect(SITEURL);
		}
		elseif ($type == 'admin')
		{
			if (!$CI->ion_auth->is_admin())
			{
				$CI->prepare_flashmessage(get_languageword('MSG_NO_ENTRY'), 2);
				redirect(SITEURL);
			}
		}
		elseif ($type == 'user')
		{
			if (!$CI->ion_auth->is_member())
			{
				$CI->prepare_flashmessage(get_languageword('Please_login_to_continue'), 2);
				redirect(SITEURL);
			}
		}
		elseif ($type == 'kitchen_manager')
		{
			if (!$CI->ion_auth->is_kitchen_manager())
			{
				$CI->prepare_flashmessage(get_languageword('MSG_NO_ENTRY'), 2);
				redirect(SITEURL);
			}
		}
		elseif ($type == 'delivery_manager')
		{
			if (!$CI->ion_auth->is_delivery_manager())
			{
				$CI->prepare_flashmessage(get_languageword('MSG_NO_ENTRY'), 2);
				redirect(SITEURL);
			}
		}
	}
}


if ( ! function_exists('get_date'))
{
	/**
	 * [get_date description]
	 * @param  [type] $date [description]
	 * @return [type]       [description]
	 */
	function get_date($date) 
	{
		$CI	=&	get_instance();
		
		if ($date=='')
			return FALSE;
		else
		{
			$format = $CI->config->item('site_settings')->date_format;
			if ($format=='' || $format=='Y-m-d')
				return $date;
			else
			{
				return date($format, strtotime($date));
			}
		}
	}
}


if (!function_exists('get_datepicker_format'))
{
	/**
	 * [get_datepicker_format description]
	 * @return [type] [description]
	 */
	function get_datepicker_format()
	{
		$format='yyyy-mm-dd';
		
		$CI	=&	get_instance();
		$set_format = $CI->config->item('site_settings')->date_format;
		
		switch($set_format)
		{
			case 'Y-m-d':
			$format = 'yyyy-mm-dd';
    break;
			
			case 'Y/m/d':
			$format = 'yyyy/mm/dd';
    break;
			
			case 'Y.m.d':
			$format = 'yyyy.mm.dd';
    break;
			
			case 'd-m-Y':
			$format = 'dd-mm-yyyy';
    break;
			
			case 'd/m/Y':
			$format = 'dd/mm/yyyy';
    break;
			
			case 'd.m.Y':
			$format = 'dd.mm.YYYY';
    break;
			
			case 'm-d-Y':
			$format = 'mm-dd-yyyy';
    break;
			
			case 'm/d/Y':
			$format = 'mm/dd/yyyy';
    break;
			
			case 'm.d.Y':
			$format = 'mm.dd.yyyy';
    break;
			
			default:
			$format = 'yyyy-mm-dd';
    break;
			
		}
		return $format;	
	}
}



if ( ! function_exists('activeinactive'))
{
	/**
	 * [activeinactive description]
	 * @return [type] [description]
	 */
	function activeinactive()
	{
		return array('Active' => get_languageword('active'), 'Inactive' => get_languageword('inactive'));
	}
}



if ( ! function_exists('noyes'))
{
	/**
	 * [noyes description]
	 * @return [type] [description]
	 */
	function noyes()
	{
		return array('No' => get_languageword('no'), 'Yes' => get_languageword('yes'));
	}
}



if ( ! function_exists('yesno'))
{
	/**
	 * [yesno description]
	 * @return [type] [description]
	 */
	function yesno()
	{
		return array('Yes' => get_languageword('yes'), 'No' => get_languageword('no'));
	}
}



if ( ! function_exists('required_symbol'))
{
	/**
	 * [required_symbol description]
	 * @return [type] [description]
	 */
	function required_symbol()
	{
		return '&nbsp;<font color="red">*</font>';
	}
}




if ( ! function_exists('get_user_image'))
{
	/**
	 * [get_user_image description]
	 * @param  string $image [description]
	 * @return [type]        [description]
	 */
	function get_user_image($image='')
	{
		if ($image != '')
			$image = $image;
		else
		{
			$user = getUserRec();
			if (!empty($user))
			$image = $user->photo;
		}
		
		if (!empty($image)) 
		{
			if (file_exists(USER_IMG_UPLOAD_PATH_URL.$image))
				return USER_IMG_PATH.$image;
			else
				return DEFAULT_USER_IMAGE;
		}
		else 
		{
			return DEFAULT_USER_IMAGE;
		}
	}
}



if ( ! function_exists('clean_string'))
{
	/**
	 * [clean_string description]
	 * @param  string $string [description]
	 * @return [type]         [description]
	 */
	function clean_string($string = "")
	{
		if (empty($string))
			return "";

		$string = strtolower($string);
		$string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
   		$string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.

   		$string = preg_replace('/-+/', '-', $string); // Replaces multiple hyphens with single one.

		return $string;
	}
}




if ( ! function_exists('prepare_slug'))
{
	/**
	 * [prepare_slug description]
	 * @param  string $string               [description]
	 * @param  string $column_to_be_checked [description]
	 * @param  string $table_name           [description]
	 * @return [type]                       [description]
	 */
	function prepare_slug($string = "", $column_to_be_checked = "", $table_name = "")
	{
		if (empty($string) || empty($column_to_be_checked) || empty($table_name))
			return "";

		$string = clean_string($string);

		$CI	=&	get_instance();
		$duplicate_rec_cnt = $CI->db->where($column_to_be_checked, $string)->count_all_results($table_name);

		if ($duplicate_rec_cnt > 0) {
			$string .= '-'.$duplicate_rec_cnt;
		}

		return $string;
	}
}



if ( ! function_exists('filter_slug'))
{
	/**
	 * [filter_slug description]
	 * @param  string $slug [description]
	 * @return [type]       [description]
	 */
	function filter_slug($slug = "")
	{
		if (empty($slug))
			return "";

		$slug = str_replace('_', '-', $slug);

		return $slug;
	}
}



if ( ! function_exists('get_language_opts'))
{
	/**
	 * [get_language_opts description]
	 * @return [type] [description]
	 */
	function get_language_opts()
	{

		$CI	=&	get_instance();
		/* $query  = "SELECT distinct(column_name) FROM information_schema.columns WHERE table_name='".TBL_PREFIX."languagewords' AND column_name!= 'lang_id' AND column_name!= 'phrase_for' AND column_name!= 'lang_key' "; */
		
		$query  = "SELECT distinct(tds.column_name),c.code FROM information_schema.columns tds,cr_language_codes c WHERE table_name='".TBL_PREFIX."languagewords' AND tds.column_name!= 'lang_id' AND tds.column_name!= 'phrase_for' AND tds.column_name!= 'lang_key' AND c.language=tds.column_name "; 
		
		$languages = $CI->db->query($query)->result();

		$lang_opts = array('' => get_languageword('no_records_available'));
		if (!empty($languages)) {

			$lang_opts = array();

			foreach ($languages as $key => $value) {
				$lang_opts[$value->column_name] = ucwords($value->column_name);
			}
		}

		return $lang_opts;
	}
}



if ( ! function_exists('get_currency_opts'))
{
	/**
	 * [get_currency_opts description]
	 * @return [type] [description]
	 */
	function get_currency_opts()
	{

		$CI	=&	get_instance();
		$currencies = $CI->db->get('currency')->result();

		$currency_opts = array('' => get_languageword('no_records_available'));
		if (!empty($currencies)) {

			$currency_opts = array(''=>get_languageword('select'));

			foreach ($currencies as $key => $value) {
				$currency_opts[$value->currency_code_alpha] = ucwords($value->currency_name);
			}
		}

		return $currency_opts;
	}
}



if ( ! function_exists('clean_text'))
{
	/**
	 * [clean_text description]
	 * @param  [type] $string [description]
	 * @return [type]         [description]
	 */
	function clean_text($string) 
	{
	   $string = str_replace(' ', '_', $string); // Replaces all spaces with hyphens.

	   return preg_replace('/[^A-Za-z0-9\_]/', '', $string); // Removes special chars.
	}	
}




if( ! function_exists('prepare_dropdown')) {

	/**
	 * [prepare_dropdown description]
	 * @param  string  $table_name      [description]
	 * @param  string  $isSelect        [description]
	 * @param  string  $col_value       [description]
	 * @param  [type]  $first_col_text  [description]
	 * @param  string  $second_col_text [description]
	 * @param  array   $cond            [description]
	 * @param  string  $order_by        [description]
	 * @param  boolean $include_all     [description]
	 * @return [type]                   [description]
	 */
	function prepare_dropdown($table_name='', $isSelect='',$col_value='',$first_col_text,$second_col_text='', $cond = array(),$order_by = '',$include_all=FALSE)
 {
		
		$CI =& get_instance();
		
		$catRecords = $CI->base_model->fetch_records_from(
		$table_name, is_array($cond)? $cond : '', '', $order_by);
		if($isSelect) {
			$catOptions[''] = 'Select';
		}

		if($include_all){
			$catOptions['All'] = 'All';
		}
		
		if($second_col_text != '') {
			foreach ($catRecords as $key => $val) {
				$catOptions[$val->$col_value]=$val->$first_col_text.' - '.$val->$second_col_text;	
			}
		} else {
			foreach ($catRecords as $key => $val) {
				$catOptions[$val->$col_value]=$val->$first_col_text;	
			}
		}
		return $catOptions;
	}
}



if( ! function_exists('get_loyality_points'))
{
	/**
	 * [get_loyality_points description]
	 * @return [type] [description]
	 */
	function get_loyality_points()
	{			
		$CI =& get_instance();
		
		$record = $CI->db->get(TBL_LOYALITY_POINTS)->row();
					
		return $record;
	}
}




if( ! function_exists('get_referral_settings'))
{
	/**
	 * [get_referral_settings description]
	 * @return [type] [description]
	 */
	function get_referral_settings()
	{			
		$CI =& get_instance();
		
		$record = $CI->db->get(TBL_REFERRAL_SETTINGS)->row();
					
		return $record;
	}
}

if( ! function_exists('get_accepted_cards'))
{
	/**
	 * [get_accepted_cards description]
	 * @return [type] [description]
	 */
	function get_accepted_cards()
	{
		$CI =& get_instance();
		
		$record = $CI->db->get_where(TBL_CARD_IMAGES,array('status'=>'Active'))->result();
					
		return $record;
	}
}



if( ! function_exists('get_fevicon'))
{
	/**
	 * [get_fevicon description]
	 * @return [type] [description]
	 */
	function get_fevicon()
	{
		$CI	=&	get_instance();
		
		$fevicon_img='';
		
		if($CI->config->item('site_settings')->fevicon != '' && file_exists(FEVICON_IMG_UPLOAD_PATH_URL.$CI->config->item('site_settings')->fevicon)) 
		{
			$fevicon_img = FEVICON_IMG_PATH.$CI->config->item('site_settings')->fevicon;
		}
		else
		{
			$fevicon_img = FEVICON;
		}
		
		return $fevicon_img;
	}
}



if ( ! function_exists('get_site_logo'))
{
	/**
	 * [get_site_logo description]
	 * @return [type] [description]
	 */
	function get_site_logo()
	{
		$CI	=&	get_instance();
		
		$site_img='';
		
		if($CI->config->item('site_settings')->site_logo != '' && file_exists(LOGO_IMG_UPLOAD_PATH_URL.$CI->config->item('site_settings')->site_logo)) 
		{
			$site_img = LOGO_IMG_PATH.$CI->config->item('site_settings')->site_logo;
		}
		else
		{
			$site_img = DEFAULT_SITE_LOGO;
		}
		
		return $site_img;
	}
}



if ( ! function_exists('get_second_site_logo'))
{
	/**
	 * [get_second_site_logo description]
	 * @return [type] [description]
	 */
	function get_second_site_logo()
	{
		$CI	=&	get_instance();
		
		$site_img='';
		
		if($CI->config->item('site_settings')->second_site_logo != '' && file_exists(LOGO_IMG_UPLOAD_PATH_URL.$CI->config->item('site_settings')->second_site_logo)) 
		{
			$site_img = LOGO_IMG_PATH.$CI->config->item('site_settings')->second_site_logo;
		}
		else
		{
			$site_img = SECOND_DEFAULT_SITE_LOGO;
		}
		
		return $site_img;
	}
}



if ( ! function_exists('get_item_image'))
{
	/**
	 * [get_item_image description]
	 * @param  string $image [description]
	 * @return [type]        [description]
	 */
	function get_item_image($image='')
	{
		$item_img='';
		if($image=='')
		{
			$item_img=IMG_DEFAULT;
		}
		else
		{
			$CI	=&	get_instance();
			
			if($image != '' && file_exists(ITEM_IMG_UPLOAD_PATH_URL.$image)) 
			{
				$item_img = ITEM_IMG_PATH.$image;
			}
			else
			{
				$item_img = IMG_DEFAULT;
			}
		}
		return $item_img;
	}
}



if ( ! function_exists('get_item_thumb_image'))
{
	/**
	 * [get_item_thumb_image description]
	 * @param  string $image [description]
	 * @return [type]        [description]
	 */
	function get_item_thumb_image($image='')
	{
		$item_img='';
		if($image=='')
		{
			$item_img=IMG_DEFAULT;
		}
		else
		{
			$CI	=&	get_instance();
			
			if($image != '' && file_exists(ITEM_IMG_UPLOAD_THUMB_PATH_URL.$image)) 
			{
				$item_img = ITEM_IMG_THUMB_PATH.$image;
			}
			else
			{
				$item_img = IMG_DEFAULT;
			}
		}
		return $item_img;
	}
}



if ( ! function_exists('get_offer_image'))
{
	/**
	 * [get_offer_image description]
	 * @param  string $image [description]
	 * @return [type]        [description]
	 */
	function get_offer_image($image='')
	{
		$offer_img='';
		if($image=='')
		{
			$offer_img=OFFER_IMG_DEFAULT;
		}
		else
		{
			$CI	=&	get_instance();
			
			if ($image != '' && file_exists(OFFER_IMG_UPLOAD_PATH_URL.$image)) 
			{
				$offer_img = OFFER_IMG_PATH.$image;
			}
			else
			{
				$offer_img = OFFER_IMG_DEFAULT;
			}
		}
		return $offer_img;
	}
}


if ( ! function_exists('get_offer_thumb_image'))
{
	/**
	 * [get_offer_thumb_image description]
	 * @param  string $image [description]
	 * @return [type]        [description]
	 */
	function get_offer_thumb_image($image='')
	{
		$offer_img='';
		if($image=='')
		{
			$offer_img=OFFER_IMG_DEFAULT;
		}
		else
		{
			$CI	=&	get_instance();
			
			if ($image != '' && file_exists(OFFER_IMG_UPLOAD_THUMB_PATH_URL.$image)) 
			{
				$offer_img = OFFER_IMG_THUMB_PATH.$image;
			}
			else
			{
				$offer_img = OFFER_IMG_DEFAULT;
			}
		}
		return $offer_img;
	}
}



if ( ! function_exists('get_addon_image'))
{
	/**
	 * [get_addon_image description]
	 * @param  string $image [description]
	 * @return [type]        [description]
	 */
	function get_addon_image($image='')
	{
		$item_img='';
		if ($image=='')
		{
			$item_img=IMG_DEFAULT;
		}
		else
		{
			$CI	=&	get_instance();
			
			if ($image != '' && file_exists(ADDON_IMG_UPLOAD_PATH_URL.$image)) 
			{
				$item_img = ADDON_IMG_PATH.$image;
			}
			else
			{
				$item_img = IMG_DEFAULT;
			}
		}
		return $item_img;
	}
}




if ( ! function_exists('get_home_page_img'))
{
	/**
	 * [get_home_page_img description]
	 * @return [type] [description]
	 */
	function get_home_page_img()
	{
		$CI	=&	get_instance();
		
		$img='';
		
		if ($CI->config->item('site_settings')->home_page_img != '' && file_exists(HOME_PAGE_IMG_UPLOAD_PATH_URL.$CI->config->item('site_settings')->home_page_img)) 
		{
			$img = HOME_PAGE_IMG_PATH.$CI->config->item('site_settings')->home_page_img;
		}
		else
		{
			$img = DEFAULT_IMG_HOME_PAGE;
		}
		
		return $img;
	}
}




if ( ! function_exists('get_android_img'))
{
	/**
	 * [get_android_img description]
	 * @return [type] [description]
	 */
	function get_android_img()
	{
		$CI	=&	get_instance();
		
		$android_img = SITEURL.RESOURCES.DS.'admin'.DS.'img'.DS.'android.png';
		
		return $android_img;
	}
}


if ( ! function_exists('get_ios_img'))
{
	/**
	 * [get_ios_img description]
	 * @return [type] [description]
	 */
	function get_ios_img()
	{
		$CI	=&	get_instance();
		
		$ios_img = SITEURL.RESOURCES.DS.'admin'.DS.'img'.DS.'appleios.png';
		
		return $ios_img;
	}
}


if ( ! function_exists('sendSMS'))
{
	/**
	 * [sendSMS description]
	 * @param  string $mobile_number [description]
	 * @param  string $message       [description]
	 * @return [type]                [description]
	 */
	function sendSMS($mobile_number='',$message='')
	{
		if ($mobile_number=='' || $message=='') 
		{
			return array('result' => 0, 'message' => 'Please enter mobile number');
		}
		
		$CI =& get_instance();
		$query = 'SELECT * FROM '.$CI->db->dbprefix('sms_gate_ways').'  WHERE  status="Active" AND is_default = "Yes"';
		$sms_settings = $CI->db->query($query)->result();
		//echo "<pre>";
		//print_r($sms_settings); 
		
		if (count($sms_settings) == 0) //If there is no default SMS gateway, we will pick the any one gateway to send the SMS
		{
			$query = 'SELECT sst2.* FROM '.$CI->db->dbprefix('sms_gate_ways').' sst1 INNER JOIN '.$CI->db->dbprefix('system_settings_fields').' sst2 ON sst1.sms_gateway_id = sst2.sms_gateway_id WHERE  sst1.status="Active" ORDER BY sms_gateway_name LIMIT 1';
			$sms_settings = $CI->db->query($query)->result();
		}
		
	    if (count($sms_settings)>0 && $sms_settings[0]->status=='Active') 
		{
			$fields = $CI->db->query('SELECT * FROM  '.$CI->db->dbprefix('system_settings_fields').' sf WHERE sms_gateway_id = '.$sms_settings[0]->sms_gateway_id)->result();
			$to = $CI->config->item('site_settings')->country_code.$mobile_number;			
			if (count($fields) > 0)
			{
				$result = array();
				if ($sms_settings[0]->sms_gateway_name == 'Cliakatell') 
				{

					$CI->load->library('clickatell');

					$response = $CI->clickatell->send_message($to, $message);
					
					if ($response === FALSE)
					{
						$result = array('result' => 0, 'message' => $CI->clickatell->error_message);
					}
					else
					{
						$result = array('result' => 1, 'message' => 'Message sent successfully');
					}
				}
				elseif ($sms_settings[0]->sms_gateway_name == 'Nexmo') 
				{
					$CI->load->library('nexmo');
					$CI->nexmo->set_format('json');
					$from = '1234567890';
					$smstext = array(
							'text' => $message,
						);
					$response = $CI->nexmo->send_message($from, $to, $smstext);
					
					$other_details = serialize($response);
					$status = $response['messages'][0]['status'];
					if ($status == 0) {
						$result = array('result' => 1, 'message' => 'Message sent successfully');
					} else {
						$result = array('result' => 0, 'message' => $response['messages'][0]['error-text']);
					}
				}
				elseif ($sms_settings[0]->sms_gateway_name == 'Plivo') 
				{
					$CI->load->library('plivo');
					$sms_data = array(
							'src' => '919700376656', //The phone number to use as the caller id (with the country code). E.g. For USA 15671234567
							'dst' => $to, // The number to which the message needs to be send (regular phone numbers must be prefixed with country code but without the ‘+’ sign) E.g., For USA 15677654321.
							'text' => $message, // The text to send
							'type' => 'sms', //The type of message. Should be 'sms' for a text message. Defaults to 'sms'
						);
					$response = $CI->plivo->send_sms($sms_data);
					$other_details = serialize($response);
					if ($response[0] == '202') //Success
					{
						$result = array('result' => 1, 'message' => 'Message sent successfully');
					}
					else
					{
						$response2 = json_decode($response[1], TRUE);
						//print_r($response2);print_r($response);die();
						$result = array('result' => 0, 'message' => $response2["error"]);
					}
				}
				elseif ($sms_settings[0]->sms_gateway_name == 'Solutionsinfini') 
				{
					$CI->load->helper('solutionsinfini');
					$solution_object = new sendsms();
					$response = $solution_object->send_sms($to, $message, current_url());
					if (strpos($response, 'Message GID') === FALSE) //Failed
					{
						$result = array('result' => 0, 'message' => $response);
					}
					else
					{
						$result = array('result' => 1, 'message' => 'Message sent successfully');
					}
				}
				elseif ($sms_settings[0]->sms_gateway_name == 'Twilio') 
				{
					$CI->load->helper('ctech-twilio');
					$client = get_twilio_service();
					$twilio_number = '';
					//print_r($fields); die();
					foreach ($fields as $field)
					{
						if($field->field_key == 'Twilio_Phone_Number')
							$twilio_number = $field->field_output_value;
					}
					try {
						$response = $client->account->messages->sendMessage($twilio_number, '+'.$to, $message);
						//print_r($response);die();
						$result = array('result' => 1, 'message' => 'Message sent successfully');
					} catch (Exception $e ){
						$result = array('result' => 0, 'message' => $e->getMessage());
					}
				}
				else if ($sms_settings[0]->sms_gateway_name == 'MSG91')
				{
					$CI->load->helper('msgnineone'); 
					$msgnineone = new msgnineone();
					$result = $msgnineone->sendSMS($to, $message);
					if (!empty($result))
					{
						$result = array('result' => 1, 'message' => 'Message sent successfully');
					}
					else {
						$result = array('result' => 0, 'message' => 'Message not sent successfully');
					}
				}
				return $result;
			}
			else
			{
				return array('result' => 0, 'message' => 'No SMS gateway configured. Please contact administrator');
			}
			
     }
		else
		{
			return array('result' => 0, 'message' => 'No SMS gateway configured. Please contact administrator'); 
		}
		
	}
}



if( ! function_exists('get_pages'))
{
	/**
	 * [get_fevicon description]
	 * @return [type] [description]
	 */
	function get_pages()
	{
		$CI	=&	get_instance();
		
		$query  = "SELECT slug FROM cr_pages WHERE status='Active' "; 
		
		$pages = $CI->db->query($query)->result();

		$page_opts = array();
		if (!empty($pages)) {
			foreach ($pages as $page) {
				array_push($page_opts, $page->slug);
			}
		}

		return $page_opts;
	}
}


/**************************************
23-02-2019
**************************************/
if (! function_exists('language_type'))
{
	function language_type()
	{
		$CI	=&	get_instance();
		$CI->load->database();

		$textdir='ltr';

		$default_language =  $CI->session->userdata('current_language');

		if ($default_language=='') {

			$default_language = $CI->config->item('site_settings')->site_language;

			if ($default_language=='') {

				$CI->session->set_userdata('current_language' , 'english');
			}
		}
		
		$default_language =  $CI->session->userdata('current_language');
		
		$rtl = array('arabic','hebrew','urdu','aramaic','azeri','kurdish','persian');

		if (in_array($default_language,$rtl)) { //is this a rtl language?
			    $textdir = 'rtl'; //switch the direction
		}
		return $textdir; 
	}
}

if (!function_exists('get_language_code')) 
{
	function get_language_code()
	{
		$CI	=&	get_instance();
		$CI->load->database();

		$code='en';

		$current_language = $CI->session->userdata('current_language');

		$original_name = $current_language;
		if ($original_name) {
			//get target language short code
			$lang_record = $CI->db->query("SELECT code FROM cr_language_codes WHERE language='".$original_name."' ")->result();
			if (!empty($lang_record)) {
				$lang_record = $lang_record[0];
				$code = $lang_record->code;
			}
		}
		return $code;
	}
}