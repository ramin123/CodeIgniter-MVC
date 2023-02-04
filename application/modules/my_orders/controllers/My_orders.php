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
 * @category  MyOrders
 * @package   MENORAH RESTAURANT
 * @author    DIGISAMARITAN <digisamaritan@gmail.com>
 * @copyright 2018 - 2019, DIGISAMARITAN
 * @license   http://opensource.org/licenses/MIT    MIT License
 * @link      http://codeigniter.com
 * @since     Version 1.0.0
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CodeIgniter My_Orders Class
 * 
 * User can view his Orders.
 *
 * @category  MyOrders
 * @package   MENORAH RESTAURANT
 * @author    DIGISAMARITAN <digisamaritan@gmail.com>
 * @copyright 2018 - 2019, DIGISAMARITAN
 * @license   http://opensource.org/licenses/MIT    MIT License
 * @link      http://codeigniter.com
 */
class My_orders extends MY_Controller
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
    | MODULE:           MY_ORDERS CONTROLLER
    | -----------------------------------------------------
    | This is MY_ORDERS module controller file.
    | -----------------------------------------------------
     **/
    function __construct()
    {
        parent::__construct();
        
        $this->load->library('Ajax_pagination');
        $this->load->model('my_orders_model');
        
        check_access('user');
    }
    
    /**
     * FETCH MY ORDERS 
     *
     * @return array
     **/ 
    function index() 
    {
        
        $user=getUserRec();
        
        $this->data['offset'] = $this->input->post('offset');
        
        $ajax = $this->input->post('ajax');
        if (empty($this->data['offset'])) {
            $this->data['offset'] = 0;
        }
        $this->data['start'] = ($this->data['offset']+1);
        $this->load->library('pagination');
        
        
        $data = array();
        $this->load->model('crunchy_model');
        $orders = $this->crunchy_model->get_my_orders($this->data['offset'], $user->id);
        $numrows = $this->crunchy_model->numrows;
        
        
        $this->data['activemenu']     = 'my_orders';
        $this->data['pagetitle']     = get_languageword('my_orders');
        
        $this->data['data']            = $orders;
        $this->data['content']         = 'my_orders'; 
    
        $this->set_pagination('my_orders/index', $this->data['offset'], $numrows, PER_PAGE, 'fetch_more');
        
        
        if ($ajax == 1) {
            $this->load->view($this->data['content'], $this->data);
        } else {
            $this->_render_page(getTemplate(), $this->data);
        }
    }
    
    
    /**
     * VIEW ORDER DETAILS 
     * AJAX CALL
     *
     * @return page
     **/    
    function get_order_details() 
    {
       
        if ($this->ion_auth->logged_in()) {
           
            $page='';
           
            $order_id = $this->input->post('order_id');
           
            $order = $this->base_model->fetch_records_from(TBL_ORDERS, array('order_id'=>$order_id));
           
            if (!empty($order)) {
                $order = $order[0];
               
                //order products
                $order_products = $this->base_model->fetch_records_from(TBL_ORDER_PRODUCTS, array('order_id'=>$order->order_id));
                
                
                //order addons
                $order_addons = $this->base_model->fetch_records_from(TBL_ORDER_ADDONS, array('order_id'=>$order->order_id));
                
                
                
                //order offers
                $order_offers = $this->base_model->fetch_records_from(TBL_ORDER_OFFERS, array('order_id'=>$order->order_id));
                
                
                if (!empty($order_products)) {
                
                    $page .= '<p>'.get_languageword('order_products').'</p>';
                
                    $p=0;
                    $page .= '<div class="modal-table"><table class="table-bordered">';
                
                    $page .= '<thead>
						  <tr>
						  <th>#</th>
						  <th>'.get_languageword('item_name').'</th>
						  <th>'.get_languageword('option').'</th>
						  <th>'.get_languageword('item_cost').'</th>
						  <th>'.get_languageword('quantity').'</th>
						  <th>'.get_languageword('total_cost').'</th>
						  <th>'.get_languageword('is_deleted').'</th>
						  </tr>
						  </thead> <tbody>';
                          
                    foreach ($order_products as $product):
                        $p++;
                
                        $dlt='No';
                        if ($product->is_deleted==1) {
                            $dlt='Yes';
                        }
                        $page .= '<tr>
						  <td>'.$p.'</td>
						  <td>'.$product->item_name.'</td>
						  <td>'.$product->size_name.'</td>
						  <td>'.$product->item_cost.'</td>
						  <td>'.$product->item_qty.'</td>
						  <td>'.$product->final_cost.'</td>
						  <td>'.$dlt.'</td>
				</tr>'; 
                  
                    endforeach;
                
                    $page .= '</tbody> </table> </div>';
                
                }
                
                
                
                
                
                if (!empty($order_addons)) {
                    
                    $page .= '<br>';    
                
                    $page .= '<p>'.get_languageword('order_addons').'</p>';
                
                    $p=0;
                    $page .= '<div class="modal-table"><table class="table-bordered">';
                
                    $page .= '<thead>
						  <tr>
						  <th>#</th>
						  <th>'.get_languageword('item_name').'</th>
						  <th>'.get_languageword('item_cost').'</th>
						  <th>'.get_languageword('quantity').'</th>
						  <th>'.get_languageword('total_cost').'</th>
						  <th>'.get_languageword('is_deleted').'</th>
						  </tr>
						  </thead> <tbody>';
                    $a=0;          
                    foreach ($order_addons as $addon):
                        $a++;
                
                        $dlt='No';
                        if ($addon->is_deleted==1) {
                            $dlt='Yes';
                        }
                        $page .= '<tr>
						  <td>'.$a.'</td>
						  <td>'.$addon->addon_name.'</td>
						  <td>'.$addon->price.'</td>
						  <td>'.$addon->quantity.'</td>
						  <td>'.$addon->final_cost.'</td>
						  <td>'.$dlt.'</td>
				</tr>'; 
                  
                    endforeach;
                
                    $page .= '</tbody> </table></div>';
                
                }
                
                
                
                
                if (!empty($order_offers)) {
                
                    $page .= '<br>';
                    $page .= '<p>'.get_languageword('order_offers').'</p>';
                
                    $p=0;
                    $page .= '<div class="modal-table"><table class="table-bordered">';
                
                    $page .= '<thead>
						  <tr>
						  <th>#</th>
						  <th>'.get_languageword('offer_name').'</th>
						  <th>'.get_languageword('item_cost').'</th>
						  <th>'.get_languageword('quantity').'</th>
						  <th>'.get_languageword('total_cost').'</th>
						  <th>'.get_languageword('no_of_products').'</th>
						  <th>'.get_languageword('is_deleted').'</th>
						  </tr>
						  </thead> <tbody>';
                    $o=0;          
                    foreach ($order_offers as $offer):
                        $o++;
                
                        $dlt='No';
                        if ($offer->is_deleted==1) {
                            $dlt='Yes';
                        }
                        $page .= '<tr>
						  <td>'.$o.'</td>
						  <td>'.$offer->offer_name.'</td>
						  <td>'.$offer->offer_cost.'</td>
						  <td>'.$offer->offer_quantity.'</td>
						  <td>'.$offer->offer_final_cost.'</td>
						  <td>'.$offer->no_of_products.'</td>
						  <td>'.$dlt.'</td>
				</tr>'; 
                  
                    endforeach;
                
                    $page .= '</tbody> </table></div>';
                
                }
                
            }
           
            echo $page;
           
        } else {
            echo 999;
        }
    }
}