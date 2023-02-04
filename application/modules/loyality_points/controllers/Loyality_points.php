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
 * @category  LoyalityPoints
 * @package   MENORAH RESTAURANT
 * @author    DIGISAMARITAN <digisamaritan@gmail.com>
 * @copyright 2018 - 2019, DIGISAMARITAN
 * @license   http://opensource.org/licenses/MIT    MIT License
 * @link      http://codeigniter.com
 * @since     Version 1.0.0
 */
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * CodeIgniter Loyality Points Class
 * 
 * Loyality Points operations.
 *
 * @category  LoyalityPoints
 * @package   MENORAH RESTAURANT
 * @author    DIGISAMARITAN <digisamaritan@gmail.com>
 * @copyright 2018 - 2019, DIGISAMARITAN
 * @license   http://opensource.org/licenses/MIT    MIT License
 * @link      http://codeigniter.com
 */
class Loyality_points extends MY_Controller
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
    | MODULE:           LOYALITY POINTS CONTROLLER
    | -----------------------------------------------------
    | This is Loyality Points module controller file.
    | -----------------------------------------------------
     **/
    function __construct()
    {
        parent::__construct();
        check_access('admin');
    }
    
    /**
     * Fetch loyality_points
     *
     * @return page
     **/
    function index()
    {
        redirect(URL_POINTS_SETTINGS);
    }
    
    /**
     * Fetch loyality_points
     *
     * @return page
     **/
    function points_settings()
    {
        if (isset($_POST['point_settings'])) {
            
            if (DEMO) {
                $this->prepare_flashmessage(get_languageword('CRUD_operations_disabled_in_DEMO_version'), 2);
                redirect(URL_POINTS_SETTINGS, REFRESH);
            }
                
            $msg='';
            $status=0;
            
            $this->form_validation->set_rules('points_label_redeem_placeholder', get_languageword('points_label_redeem_placeholder'), 'required|xss_clean');
            $this->form_validation->set_rules('points_label_earn', get_languageword('points_label_earn'), 'required|xss_clean');
            $this->form_validation->set_rules('points_label_template', get_languageword('points_label_template'), 'required|xss_clean');
            $this->form_validation->set_rules('maximum_earning_points_for_customer', get_languageword('maximum_earning_points_for_customer'), 'required|xss_clean');
            $this->form_validation->set_rules('earning_point', get_languageword('earning_point'), 'required|xss_clean');
            $this->form_validation->set_rules('earning_point_value', get_languageword('earning_point_value'), 'required|xss_clean');
            $this->form_validation->set_rules('redeeming_point', get_languageword('redeeming_point'), 'required|xss_clean');
            $this->form_validation->set_rules('redeeming_point_value', get_languageword('redeeming_point_value'), 'required|xss_clean');
            
            $this->form_validation->set_rules('reward_points_for_account_signup', get_languageword('reward_points_for_account_signup'), 'required|numeric|xss_clean');
            
            // $this->form_validation->set_rules('points_for_restaurant_review',get_languageword('points_for_restaurant_review'),'required|numeric');
            
            $this->form_validation->set_rules('points_for_first_order', get_languageword('points_for_first_order'), 'required|numeric|xss_clean');
            $this->form_validation->set_rules('points_for_sharing_app', get_languageword('points_for_sharing_app'), 'required|numeric|xss_clean');
            
            $this->form_validation->set_rules('minimum_points_can_be_used', get_languageword('minimum_points_can_be_used'), 'required|numeric|xss_clean');
            $this->form_validation->set_rules('maximum_points_can_be_used', get_languageword('maximum_points_can_be_used'), 'required|numeric|xss_clean');
            
            $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
            
            if ($this->form_validation->run()==TRUE) {
                $data['points_label_redeem_placeholder']     = $this->input->post('points_label_redeem_placeholder');
                $data['points_label_earn']                     = $this->input->post('points_label_earn');
                $data['points_label_template']                 = $this->input->post('points_label_template');
                $data['maximum_earning_points_for_customer']= $this->input->post('maximum_earning_points_for_customer');
                
                
                /* $payment_options = $this->input->post('payment_options');
                $payment_options = implode(",",$payment_options);
                $data['payment_options'] = $payment_options; */
                
                $data['earning_point']             = $this->input->post('earning_point');
                $data['earning_point_value']     = $this->input->post('earning_point_value');
                $data['redeeming_point']         = $this->input->post('redeeming_point');
                $data['redeeming_point_value']    = $this->input->post('redeeming_point_value');
                
                
                $disabled_redeeming = 'No';
                if ($this->input->post('disabled_redeeming')=='on') {
                    $disabled_redeeming = 'Yes';    
                }
            
                $data['disabled_redeeming'] = $disabled_redeeming;
                
                
                $enable_redeeming = 'No';
                if ($this->input->post('enable_redeeming')=='on') {
                    $enable_redeeming = 'Yes';    
                }
            
                $data['enable_redeeming'] = $enable_redeeming;
                
                
                $data['reward_points_for_account_signup'] = $this->input->post('reward_points_for_account_signup');
                // $data['points_for_restaurant_review'] 	= $this->input->post('points_for_restaurant_review');
                $data['points_for_first_order']         = $this->input->post('points_for_first_order');
                $data['points_for_sharing_app']         = $this->input->post('points_for_sharing_app');
                
                
                // $data['points_expiry'] 					= $this->input->post('points_expiry');
                
                
                $data['minimum_points_can_be_used'] = $this->input->post('minimum_points_can_be_used');
                $data['maximum_points_can_be_used'] = $this->input->post('maximum_points_can_be_used');
                
                
                $points_enabled = 'No';
                if ($this->input->post('points_enabled')=='on') {
                    $points_enabled = 'Yes';    
                }
                $data['points_enabled'] = $points_enabled;
                
                $where['lp_id'] = 1;
                if ($this->base_model->update_operation($data, TBL_LOYALITY_POINTS, $where)) {
                    $msg .= get_languageword('details_saved_successfully');
                    $status = 0;
                } else {
                    $msg .= get_languageword('details_not_saved');
                    $status = 1;
                }
                
                if ($msg != '') {
                    $this->prepare_flashmessage($msg, $status);
                }
                redirect(URL_POINTS_SETTINGS, REFRESH);
            }
            
        }
        
        $loyality_points             = get_loyality_points();
        $this->data['record']         = $loyality_points;
        
        $this->data['css_js_files']  = array('form_validation');
        $this->data['pagetitle']     = get_languageword('point_settings');
        $this->data['activemenu']      = ACTIVE_LOYALITY_POINTS;
        $this->data['actv_submenu']  = 'point_settings';
        $this->data['content']          = PAGE_POINT_SETTINGS;
        $this->_render_page(TEMPLATE_ADMIN, $this->data);    
    }
    
    /**
     * Fetch User Reward Points
     *
     * @return array
     **/
    function user_reward_points()
    {
        $this->data['ajaxrequest'] = array(
        'url' => GET_AJAX_USER_REWARD_POINTS,
        'disablesorting' => '-1',
        );
        
        $this->data['css_js_files']     = array('data_tables');
        $this->data['activemenu']       = ACTIVE_LOYALITY_POINTS;
        $this->data['actv_submenu']     = 'reward_points';
        $this->data['message']          = $this->session->flashdata('message');
        $this->data['pagetitle']        = get_languageword('user_reward_points');
        $this->data['content']          = PAGE_REWARD_POINTS;
        $this->_render_page(TEMPLATE_ADMIN, $this->data);
    }
    
    /**
     * Fetch User Reward Points
     *
     * @return array
     **/
    function get_ajax_user_reward_points()
    {
        if ($this->input->is_ajax_request()) {
            $data = array();
            $no = $_POST['start'];

            $conditions = array();

            $columns = array('u.first_name','u.last_name','u.username','u.email','u.user_points');    
            
            $query     = "SELECT u.id,CONCAT(u.first_name,' ',u.last_name) as username,u.email,u.user_points from ".TBL_PREFIX.TBL_USERS." u inner join ".TBL_PREFIX.TBL_USERS_GROUPS." ug on u.id=ug.user_id WHERE ug.group_id=2 ";
            
            
            $records = $this->base_model->get_datatables($query, 'customnew', $conditions, $columns, array('id'=>'desc'));
            
            if (!empty($records)) {

                foreach ($records as $record) {
                    $no++;
                    $row = array();

                    
                    $row[] = $no;

                    $row[] = '<span>'.$record->username.'</span>';
                    $row[] = '<span>'.$record->email.'</span>';
                    $row[] = '<span>'.$record->user_points.'</span>';
                    
                    $dta ='';
                    $dta .= '<span>';
                    $dta .= form_open(URL_POINT_LOGS);
                    $dta .= '<input type="hidden" name="user_id" value="'.$record->id.'">';
                    $dta .= '<button type="submit" name="point_logs" class="'.CLASS_VIEW_BTN.'"><i class="'.CLASS_ICON_VIEW.'" ></i></button>';
                    $dta .= form_close();
                    $dta .= '</span>';
                    
                    $str = $dta;
                    $row[] = $str;
                    
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
    
    /**
     * Fetch Point Logs
     *
     * @return array
     **/
    function point_logs()
    {
        if (isset($_POST['point_logs'])) {
            $user_id = $this->input->post('user_id');
            $user=getUserRec($user_id);
            
            
            
            if ($user_id > 0) {
                $records = $this->base_model->get_query_result("select p.points,p.transaction_type,p.description from ".TBL_PREFIX.TBL_USER_POINTS." p WHERE p.user_id=".$user_id." order by p.customer_reward_id asc ");
                
                
                $this->data['css_js_files'] = array('data_tables');
                $this->data['records']         = $records;
                $this->data['activemenu']     = ACTIVE_LOYALITY_POINTS;
                $this->data['actv_submenu'] = 'reward_points';
        
                $this->data['pagetitle']     = get_languageword('point_logs_of').' '.$user->username;
                $this->data['content']         = PAGE_POINT_LOGS;
                $this->_render_page(TEMPLATE_ADMIN, $this->data);
            } else {
                redirect(URL_USER_REWARD_POINTS);
            }
        } else {
            redirect(URL_USER_REWARD_POINTS);
        }
    }
}