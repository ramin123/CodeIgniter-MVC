<?php
/**
 * MENORAH RESTAURANT-DIGISAMARITAN
 * 
 * An online food order system in codeigniter framework
 * 
 * This content is released under the Codecanyon Market License (CML)
 * 
 * Copyright (c) 2018 - 2019, DIGISAMARITAN
 *
 * @category  Referral
 * @package   MENORAH RESTAURANT
 * @author    DIGISAMARITAN <digisamaritan@gmail.com>
 * @copyright 2018 - 2019, DIGISAMARITAN
 * @license   http://opensource.org/licenses/MIT    MIT License
 * @link      http://codeigniter.com
 * @since     Version 1.0.0
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CodeIgniter Referral Class
 * 
 * Referral operations.
 *
 * @category  Referral
 * @package   MENORAH RESTAURANT
 * @author    DIGISAMARITAN <digisamaritan@gmail.com>
 * @copyright 2018 - 2019, DIGISAMARITAN
 * @license   http://opensource.org/licenses/MIT    MIT License
 * @link      http://codeigniter.com
 */
class Referral extends MY_Controller
{

    /**
    | -----------------------------------------------------
    | PRODUCT NAME:     MENORAH RESTAURANT
    | -----------------------------------------------------
    | AUTHOR:           DIGISAMARITAN
    | -----------------------------------------------------
    | EMAIL:            digisamaritan@gmail.com
    | -----------------------------------------------------
    | COPYRIGHTS:       RESERVED BY DIGISAMARITAN
    | -----------------------------------------------------      
    | http://codecanyon.net/user/digisamaritan
    | http://conquerorstech.net/
    | -----------------------------------------------------
    |
    | MODULE:           Referral CONTROLLER
    | -----------------------------------------------------
    | This is Referral module controller file.
    | -----------------------------------------------------
     **/
    function __construct()
    {
        parent::__construct();
        check_access('admin');
    }

    /**
     * Fetch records
     *
     * @return array
     **/ 
    function index()
    {
        redirect(URL_REFERRAL_SETTINGS);
    }
     /**
      * 
      * Fetch records
      * 
      *
      * @return array
      **/ 
    function settings()
    {
        if (isset($_POST['update_referral'])) {
            
            if (DEMO) {
                $this->prepare_flashmessage(get_languageword('CRUD_operations_disabled_in_DEMO_version'), 2);
                redirect(URL_REFERRAL_SETTINGS, REFRESH);
            }
                
            $msg='';
            $status=0;
            
            $this->form_validation->set_rules('points_for_refer_anyone', get_languageword('points_for_refer_anyone'), 'required|numeric|xss_clean');
            $this->form_validation->set_rules('points_for_referred_by_anyone', get_languageword('	points_for_referred_by_anyone'), 'required|numeric|xss_clean');
            
            $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
            
            if ($this->form_validation->run() == TRUE) {
                $data = array();
                $data['points_for_refer_anyone']         = $this->input->post('points_for_refer_anyone');
                $data['points_for_referred_by_anyone']     = $this->input->post('points_for_referred_by_anyone');
                
                $referral_enabled = 'No';
                if ($this->input->post('referral_enabled')=='on') {
                    $referral_enabled = 'Yes';    
                }
            
                $data['referral_enabled'] = $referral_enabled;
                
                
                $where['settings_id'] = 1;
                if ($this->base_model->update_operation($data, TBL_REFERRAL_SETTINGS, $where)) {
                    $msg .= get_languageword('details_saved_successfully');
                    $status = 0;
                } else {
                    $msg .= get_languageword('details_not_saved');
                    $status = 1;
                }
                unset($data, $where);
                
                if ($msg != '') {
                    $this->prepare_flashmessage($msg, $status);
                }
                redirect(URL_REFERRAL_SETTINGS, REFRESH);
            }
        }
        
        $pagetitle = get_languageword('referral_settings');
            
        $record = get_referral_settings();
        $this->data['record'] =    $record;
            
        
        $this->data['css_js_files']  = array('form_validation');
        $this->data['pagetitle']     = $pagetitle;
        $this->data['activemenu']      = ACTIVE_REFERRAL;
        $this->data['actv_submenu']  = 'rsettings';
        $this->data['content']          = PAGE_REFERRAL_SETTINGS;
        $this->_render_page(TEMPLATE_ADMIN, $this->data);    
    }
    
    /**
     * Fetch users
     *
     * @return array
     **/ 
    function users()
    {
        $this->data['ajaxrequest'] = array(
        'url' => GET_AJAX_REFERRAL_USERS,
        'disablesorting' => '-1',
        );
        
        $this->data['css_js_files'] = array('data_tables');
        $this->data['activemenu']     = ACTIVE_REFERRAL;
        $this->data['actv_submenu'] = 'rusers';
        $this->data['pagetitle']     = get_languageword('referral_users');
        $this->data['content']         = PAGE_REFERRAL_USERS;
        $this->_render_page(TEMPLATE_ADMIN, $this->data);
    }
    
    /**
     * Fetch users
     *
     * @return array
     **/ 
    function get_ajax_users()
    {
        if ($this->input->is_ajax_request()) {
            $data = array();
            $no = $_POST['start'];

            $conditions = array();

            $columns = array('r.refer_user_points','r.refer_by_points','u.first_name','u.last_name','u.referral_code','u.username','b.first_name','b.last_name','b.referral_code','b.username');    
            
            $query     = "SELECT r.refer_user_points,r.refer_by_points,r.datetime,CONCAT(u.first_name,' ',u.last_name) as referuser,CONCAT(b.first_name,' ',b.last_name) as referbyuser from ".TBL_PREFIX.TBL_REFERRAL_USERS." r inner join ".TBL_PREFIX.TBL_USERS." u on r.refer_user_id=u.id inner join ".TBL_PREFIX.TBL_USERS." b on r.refer_by=b.id ";
            
            
            $records = $this->base_model->get_datatables($query, 'customnew', $conditions, $columns, array());
            
            if (!empty($records)) {

                foreach ($records as $record) {
                    $no++;
                    $row = array();

                    
                    $row[] = $no;

                    $row[] = '<span>'.$record->referuser.'</span>';
                    $row[] = '<span>'.$record->refer_user_points.'</span>';
                    $row[] = '<span>'.$record->referbyuser.'</span>';
                    $row[] = '<span>'.$record->refer_by_points.'</span>';
                    $row[] = '<span>'.get_date($record->datetime).'</span>';
                    
                    $data[] = $row;
                
                }
            }

            $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->base_model->numrows,
            "recordsFiltered" => $this->base_model->numrows,
            "data" => $data,
            );

            echo json_encode($output);
        }
    }
}