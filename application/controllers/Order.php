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
 * @category  Order
 * @package   Restaurant
 * @author    Conquerors Market <conquerorsmarket@gmail.com>
 * @copyright 2018 - 2019, Conquerors Market
 * @license   http://opensource.org/licenses/MIT    MIT License
 * @link      http://codeigniter.com
 * @since     Version 1.0.0
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CodeIgniter Order Class
 * 
 * Order operations.
 *
 * @category  Order
 * @package   Restaurant
 * @author    Conquerors Market <conquerorsmarket@gmail.com>
 * @copyright 2018 - 2019, Conquerors Market
 * @license   http://opensource.org/licenses/MIT    MIT License
 * @link      http://codeigniter.com
 */
class Order extends MY_Controller
{
    /**
    | -----------------------------------------------------
    | PRODUCT NAME:     RESTAURANT
    | -----------------------------------------------------
    | AUTHOR:           CONQUERORS MARKET
    | -----------------------------------------------------
    | EMAIL:            conquerorsmarket@gmail.com
    | -----------------------------------------------------
    | COPYRIGHTS:       RESERVED BY CONQUERORS MARKET
    | -----------------------------------------------------      
    | http://codecanyon.net/user/conquerorsmarket
    | http://conquerorstech.net/
    | -----------------------------------------------------
    |
    | MODULE:           Order CONTROLLER
    | -----------------------------------------------------
    | This is Order module controller file.
    | -----------------------------------------------------
     **/
    function __construct()
    {
        parent::__construct();
        $this->load->library(array('session'));
        $this->load->library(array('ion_auth','form_validation'));
        check_access('user');
    }
    
    /**
     * User Orders 
     * Fetch records
     *
     * @return array
     **/  
    function my_orders_old()
    {
        
        $this->load->library('pagination');
        $config = array();
        $config["base_url"] = base_url() . "order/my-orders";
        $config["total_rows"] = $this->record_count();
        $config["per_page"] = ORDERS_PER_PAGE;
        $config["uri_segment"] = 3;
        $config['num_tag_open'] = '<li>';

        $config['num_tag_close'] = '</li>';
        $config['first_link'] = 'First';

        $config['last_link'] = 'Last';
        
        $this->pagination->initialize($config);
        //echo "<pre>";
        //print_r($config); die();
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $this->data["orders"] = $this
            ->fetch_orders($config["per_page"], $page);
        $this->data["links"] = $this->pagination->create_links();
        
        
        $this->data['activemenu']     = "home";
        $this->data['message']         = $this->session->flashdata('message');
        $this->data['pagetitle']     = get_languageword('your orders');
        $this->data['content']         = 'welcome/your_orders';
        $this->_render_page(getTemplate(), $this->data); 
    }
    
    /**
     * User Orders count 
     * Fetch records
     *
     * @return int
     **/  
    public function record_count() 
    {
        $user_id = $this->ion_auth->get_user_id();
        $query = $this->db->get_where($this->db->dbprefix("orders"), array('user_id'=>$user_id));
        return $query->num_rows();
    }
    
    
    
    /**
     * User Orders
     * @param  [int] $limit [description]
     * @param  [int] $start [description]
     * @return [boolean]        [description]
     */
    public function fetch_orders($limit, $start) 
    {
        $user_id = $this->ion_auth->get_user_id();
        $query = $this->db->get_where($this->db->dbprefix("orders"), array('user_id'=>$user_id), $limit, $start);

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }
   
    /**
     * Order Details 
     * Fetch record
     *
     * @return array
     **/ 
    function order_details()
    {
        $order_id = $this->input->post('order_id');
        $order = $this->base_model->fetch_records_from(TBL_ORDERS, array('order_id'=>$order_id));
        $data = array();
        
        if (!empty($order)) {        
            //order items
            $order_products = $this->base_model->fetch_records_from(TBL_ORDER_PRODUCTS, array('order_id'=>$order_id,'is_deleted'=>0));
            
            if (!empty($order_products)) {
                foreach ($order_products as $index=>$product):
                    //order addons
                    $order_addons = $this->base_model->fetch_records_from(TBL_ORDER_ADDONS, array('order_id'=>$order_id,'item_id'=>$product->item_id));
                
                    $order_products[$index]->addons = $order_addons;
                endforeach;
            }
            
            //order offers
            $order_offers = $this->base_model->fetch_records_from(TBL_ORDER_OFFERS, array('order_id'=>$order_id));
            
            if (!empty($order_offers)) {
                foreach($order_offers as $index=>$offer):
                    //order addons
                    $offer_products = $this->base_model->fetch_records_from('order_offer_products', array('order_id'=>$order_id,'offer_id'=>$offer->offer_id));
                
                    $order_offers[$index]->offer_products = $offer_products;
                endforeach;
            }
            
            $data['products'] =  $order_products;
            $data['order_offers'] =  $order_offers;
            
            echo json_encode($data);
            
        } else {
            echo 999;
        } 
    }
}