<?php ob_start();
class MY_Controller extends CI_Controller
{

	/* 
    | -----------------------------------------------------
    | PRODUCT NAME:     DIGI RESTAURENT SYSTEM (DRS)
    | -----------------------------------------------------
    | AUTHOR:           DIGITAL VIDHYA TEAM
    | -----------------------------------------------------
    | EMAIL:            digitalvidhya4u@gmail.com
    | -----------------------------------------------------
    | COPYRIGHTS:       RESERVED BY DIGITAL VIDHYA
    | -----------------------------------------------------
    | WEBSITE:          http://digitalvidhya.com
    |                   http://codecanyon.net/user/digitalvidhya
    |                   http://conquerorstech.net/
    | -----------------------------------------------------
    |
    | MODULE:             MY_CONTROLLER
    | -----------------------------------------------------
    |
    | -----------------------------------------------------
    */
	
	protected $data;
	function __construct()
	{
		parent::__construct();	

		$this->data['message'] = '';
		
		$this->load->library('ion_auth');
		$site_country = $this->config->item('site_settings')->site_country;
		if($site_country != '')
			setlocale(LC_MONETARY, "en_".strtoupper($site_country)."");
		else
			setlocale(LC_MONETARY, "en_IN");
		
		
		$timezone = $this->config->item('site_settings')->time_zone;
		if($timezone != '')
		{
			// date_default_timezone_set('Asia/Kolkata');
			date_default_timezone_set($timezone);
		}
		else
		{
			$timezone = 'Asia/Kolkata';
			date_default_timezone_set($timezone);
		}
	}
	function languages()
	{
	   extract($_POST);
	   $this->session->set_userdata('language', $dlang);
	   $redirect_url = base_url().$current;
	   redirect($redirect_url);	
	
	}

    function create_thumbnail($sourceimage,$newpath, $width, $height)
	{	
		$this->load->library('image_lib');
		$this->image_lib->clear();
		
		$config['image_library'] = 'gd2';
		$config['source_image'] = $sourceimage;
		$config['create_thumb'] = TRUE;
		$config['new_image'] = $newpath;
		$config['dynamic_output'] = FALSE;
		$config['maintain_ratio'] = TRUE;
		$config['width'] = $width;
		$config['height'] = $height;
	    $config['thumb_marker'] = '';
		
		$this->image_lib->initialize($config); 
		return $this->image_lib->resize();
	}

    /**
	 * Displays the specified view
	 * @param array $data
	**/
	/* function _render_page($view, $data=null, $returnhtml=false)
	{
		$this->viewdata = (empty($data)) ? $this->data: $data;
		$view_html = $this->load->view($view, $this->viewdata, $returnhtml);
		if ($returnhtml) return $view_html;//This will return html on 3rd argument being true
	} */
	
	public function _render_page($view, $data=null, $returnhtml=false)//I think this makes more sense
	{

		$this->viewdata = (empty($data)) ? $this->data: $data;

		$view_html = $this->load->view($view, $this->viewdata, $returnhtml);

		if ($returnhtml) return $view_html;//This will return html on 3rd argument being true
	}

    function set_pagination($url,$offset,$numrows,$perpage,$pagingfunction='')
	{
		$config['base_url'] = SITEURL.$url;  //Setting Pagination parameters
		$config['per_page'] = $perpage;
		$config['offset'] = $offset;
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['num_links'] = 4; // numlinks before and after current page
		$config['total_rows'] =  $numrows;
		
		$config['first_link'] = 'First';
		$config['last_link'] = 'Last';
		if(!empty($pagingfunction))
			$config['paging_function'] = $pagingfunction; 
		else	$config['paging_function'] = 'ajax_paging';
		$this->pagination->initialize($config);  
	}
	
	/**
	 * Prepare flash message
	 *
	 */
	function prepare_flashmessage($msg,$type = 2)
	{
		$returnmsg='';
		switch($type){
			case 0: $returnmsg = " <!-- <div class='col-md-12'> -->
										<div class='alert alert-success'>
											<a href='#' class='close' data-dismiss='alert'>&times;</a>
											<strong>".get_languageword('success')."!</strong> ". $msg."
										</div>
									<!-- </div> -->";
				break;
			case 1: $returnmsg = " <!-- <div class='col-md-12'> -->
										<div class='alert alert-danger'>
											<a href='#' class='close' data-dismiss='alert'>&times;</a>
											<strong>".get_languageword('error')."!</strong> ". $msg."
										</div>
									<!-- </div> -->";
				break;
			case 2: $returnmsg = " <!-- <div class='col-md-12'> -->
										<div class='alert alert-info'>
											<a href='#' class='close' data-dismiss='alert'>&times;</a>
											<strong>".get_languageword('info')."!</strong> ". $msg."
										</div>
									<!-- </div> -->";
				break;
			case 3: $returnmsg = " <!-- <div class='col-md-12'> -->
										<div class='alert alert-warning'>
											<a href='#' class='close' data-dismiss='alert'>&times;</a>
											<strong>".get_languageword('warning')."!</strong> ". $msg."
										</div>
									<!-- </div> -->";
				break;
		}
		$this->session->set_flashdata("message",$returnmsg);
	}
	/**
	 * Generates Random String
	 *
	 * @access    public
	 * @param    integer
	 * @return    string
	**/
	function randomString($length = 6)
	{
		$chars =  'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'.'0123456789';

		$str = '';
		$max = strlen($chars) - 1;

		for ($i=0; $i < $length; $i++)
		  $str .= $chars[rand(0, $max)];

		return $str;
   }
}
?>