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
 * @category  Reports
 * @package   MENORAH RESTAURANT
 * @author    DIGISAMARITAN <digisamaritan@gmail.com>
 * @copyright 2018 - 2019, DIGISAMARITAN
 * @license   http://opensource.org/licenses/MIT    MIT License
 * @link      http://codeigniter.com
 * @since     Version 1.0.0
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CodeIgniter Reports Class
 * 
 * Admin can view all Reports.
 *
 * @category  Reports
 * @package   MENORAH RESTAURANT
 * @author    DIGISAMARITAN <digisamaritan@gmail.com>
 * @copyright 2018 - 2019, DIGISAMARITAN
 * @license   http://opensource.org/licenses/MIT    MIT License
 * @link      http://codeigniter.com
 */
class Reports extends MY_Controller
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
    | MODULE:           Reports CONTROLLER
    | -----------------------------------------------------
    | This is Reports module controller file.
    | -----------------------------------------------------
     **/
    function __construct()
    {
        parent::__construct();
        check_access('admin');
    }

   
    /**
     * Date wise Reports
     *
     * @return array
     **/ 
    function index()
    {
        if (isset($_POST['datewise_reports'])) {
            
            $from_date = $this->input->post('from_date');
            $to_date = $this->input->post('to_date');
            
            if ($from_date != '' && $to_date != '') {
                
                $from_date = date('Y-m-d', strtotime($from_date));
                $to_date = date('Y-m-d', strtotime($to_date));
                
                if (strtotime($from_date) > strtotime($to_date)) {
                    
                    $this->prepare_flashmessage(get_languageword('please_select_valid_dates'), 1);
                    redirect(URL_REPORTS_INDEX);
                    
                }
                
                $query="select o.customer_name,o.phone,o.no_of_items,o.total_cost,o.order_date,o.order_time,o.payment_type,o.payment_gateway,o.paid_amount from ".TBL_PREFIX.TBL_ORDERS." o where o.status='delivered' and o.order_date and o.order_date between '".$from_date."' and '".$to_date."' ";
                
                $records = $this->db->query($query)->result();
                
                if (!empty($records)) {
                    
                    $profit = "select SUM(o.paid_amount) as total_profit from ".TBL_PREFIX.TBL_ORDERS." o where o.status='delivered' and o.order_date and o.order_date between '".$from_date."' and '".$to_date."' ";
                    $profit = $this->db->query($profit)->result();
                    
                    if (!empty($profit)) {
                        $this->data['total_profit'] = $profit[0]->total_profit;
                    }
                }
                
                $this->data['records'] = $records;
            } else {
                redirect(URL_REPORTS_INDEX);
            }
        }
        
        $this->data['css_js_files'] = array('data_tables','datepicker','form_validation');
        
        $this->data['activemenu']     = "reports";
        $this->data['actv_submenu'] = 'date_wise';
        
        $this->data['message']         = $this->session->flashdata('message');
        $this->data['pagetitle']     = get_languageword('date_wise_reports');
        $this->data['content']         = PAGE_DATE_WISE_REPORTS;
        $this->_render_page(TEMPLATE_ADMIN, $this->data);
    }
    
    /**
     * CUSTOMER WISE REPORTS
     *
     * @return array
     **/     
    function customer_wise_reports()
    {
        if (isset($_POST['client_wise_reports'])) {
            
            $user_id = $this->input->post('user_id');
            
            if ($user_id > 0) {
                
                $query="select o.no_of_items,o.total_cost,o.order_date,o.order_time,o.payment_type,o.payment_gateway,o.paid_amount from ".TBL_PREFIX.TBL_ORDERS." o where o.status='delivered' and o.user_id=".$user_id." ";
                
                $records = $this->db->query($query)->result();
                
                if (!empty($records)) {
                    
                    $profit = "select SUM(o.paid_amount) as total_profit from ".TBL_PREFIX.TBL_ORDERS." o where o.status='delivered' and o.user_id=".$user_id." ";
                    $profit = $this->db->query($profit)->result();
                    
                    if (!empty($profit)) {
                        $this->data['total_profit'] = $profit[0]->total_profit;
                    }
                }
                $this->data['records'] = $records;
            } else {
                redirect(URL_REPORTS_CLIENT_WISE);
            }
        }
        
        /**
        * 
        * get customers
        **/
        $customers=array();
        $query = "select u.id,CONCAT(u.first_name,' ',u.last_name) as customer_name from ".TBL_PREFIX.TBL_USERS." u inner join ".TBL_PREFIX.TBL_USERS_GROUPS." ug on u.id=ug.user_id where u.active=1 and ug.group_id=2 ";
        $users = $this->db->query($query)->result();
        
        if (!empty($users)) {
            
            $customers = array(''=>get_languageword('select'));
            foreach($users as $c):
                $customers[$c->id]=$c->customer_name;
            endforeach;
            
        } else {
            $customers = array(''=>get_languageword('no_customers_available'));
        }
        $this->data['customers']    = $customers;
        
        $this->data['css_js_files'] = array('data_tables','form_validation');
        
        $this->data['activemenu']     = "reports";
        $this->data['actv_submenu'] = 'customer_wise';
        
        $this->data['message']         = $this->session->flashdata('message');
        $this->data['pagetitle']     = get_languageword('customer_wise_reports');
        $this->data['content']         = PAGE_CLIENT_WISE_REPORTS;
        $this->_render_page(TEMPLATE_ADMIN, $this->data);
    }
    
    
    /**
     * LOCATION WISE REPORTS
     *
     * @return array
     **/ 
    function location_wise_reports()
    {
        if (isset($_POST['location_wise_reports'])) {
            
            $pincode = $this->input->post('locality');
            
            if ($pincode > 0) {
                
                $query="select o.customer_name,o.phone,o.no_of_items,o.total_cost,o.order_date,o.order_time,o.payment_type,o.payment_gateway,o.paid_amount from ".TBL_PREFIX.TBL_ORDERS." o where o.status='delivered' and o.pincode=".$pincode." ";
                
                $records = $this->db->query($query)->result();
                
                if (!empty($records)) {
                    
                    $profit = "select SUM(o.paid_amount) as total_profit from ".TBL_PREFIX.TBL_ORDERS." o where o.status='delivered' and o.pincode=".$pincode." ";
                    $profit = $this->db->query($profit)->result();
                    if(!empty($profit)) {
                        $this->data['total_profit'] = $profit[0]->total_profit;
                    }
                }
                $this->data['records'] = $records;
            } else {
                redirect(URL_REPORTS_LOCATION_WISE);
            }
        }
        
        /**
        * 
        * get cities
        **/
        $cities_options=array();
        $cities = "select * from ".TBL_PREFIX.TBL_CITIES." where status='Active' ";
        $cities = $this->db->query($cities)->result();
        
        if (!empty($cities)) {
            $cities_options = array(''=>get_languageword('select'));
            foreach($cities as $c):
                $cities_options[$c->city_id]=$c->city_name;
            endforeach;
            
        } else {
            $cities_options = array(''=>get_languageword('no_cities_available'));
        }
        $this->data['cities_options']    = $cities_options;
        
        $this->data['css_js_files'] = array('data_tables','form_validation');
        
        $this->data['activemenu']     = "reports";
        $this->data['actv_submenu'] = 'location_wise';
        
        $this->data['message']         = $this->session->flashdata('message');
        $this->data['pagetitle']     = get_languageword('location_wise_reports');
        $this->data['content']         = PAGE_LOCATION_WISE_REPORTS;
        $this->_render_page(TEMPLATE_ADMIN, $this->data);
    }
    
    
    /**
     * AJAX CALL
     * GET LOCALITIES OF SELECTED CITY
     *
     * @return array
     **/ 
    function get_localities()
    {
        if ($this->input->post('city_id')) {
            
            $localities = '';
            $city_id = $this->input->post('city_id');
            
            if ($city_id > 0) {
                
                $records = $this->base_model->fetch_records_from(TBL_SERVICE_PROVIDE_LOCATIONS, array('city_id'=>$city_id,'status'=>'Active'));
                
                if (!empty($records)) {
                    $localities .= '<option value="">'.get_languageword('select').'</option>';
                    foreach ($records as $record):
                        $localities .= '<option value="'.$record->pincode.'">'.$record->locality.' - '.$record->pincode.'</option>';
                    endforeach;
                    
                } else {
                    $localities .= '<option value="">'.get_languageword('no_records_available').'</option>';
                }
                
                echo $localities;
            } else {
                return 0;
            }
        } else {
            echo 999;
        }
    }
    
    
    /**
     * ITEM WISE REPORT
     *
     * @return array
     **/ 
    function item_wise_reports()
    {
        if (isset($_POST['item_wise_reports'])) {
            
            $item_id = $this->input->post('item_id');
            
            if ($item_id > 0) {
                
                $query="select o.customer_name,o.phone,o.no_of_items,o.total_cost,o.order_date,o.order_time,o.payment_type,o.payment_gateway,o.paid_amount,r.item_cost from ".TBL_PREFIX.TBL_ORDERS." o inner join ".TBL_PREFIX.TBL_ORDER_PRODUCTS." r on o.order_id=r.order_id where o.status='delivered' and r.item_id=".$item_id." ";
                
                $records = $this->db->query($query)->result();
                
                if (!empty($records)) {
                    
                    $profit = "select SUM(o.paid_amount) as total_orders_amount,SUM(r.item_cost) as total_items_amount from ".TBL_PREFIX.TBL_ORDERS." o inner join ".TBL_PREFIX.TBL_ORDER_PRODUCTS." r on o.order_id=r.order_id where o.status='delivered' and r.item_id=".$item_id." ";
                    $profit = $this->db->query($profit)->result();
                    
                    if (!empty($profit)) {
                        $this->data['profit'] = $profit[0];
                    }
                }
                $this->data['records'] = $records;
            } else {
                redirect(URL_REPORTS_ITEM_WISE);
            }
        }
        
        /**
        * 
        * get menus
        **/
        $this->data['menus']   = prepare_dropdown(TBL_MENU, 1, 'menu_id', 'menu_name', '', array('status' => 'Active'));
        
        
        $this->data['css_js_files'] = array('data_tables','form_validation');
        
        $this->data['activemenu']     = "reports";
        $this->data['actv_submenu'] = 'item_wise';
        
        $this->data['message']         = $this->session->flashdata('message');
        $this->data['pagetitle']     = get_languageword('item_wise_reports');
        $this->data['content']         = PAGE_ITEM_WISE_REPORTS;
        $this->_render_page(TEMPLATE_ADMIN, $this->data);
    }
}