<?php
/**
 * Menorah Restaurant-DIGISAMARITAN
 * 
 * An online food order system in codeigniter framework
 * 
 * This content is released under the Codecanyon Market License (CML)
 * 
 * Copyright (c) 2018 - 2019, DIGISAMARITAN
 *
 * @category  Cartmodel
 * @package   Menorah Restaurant
 * @author    DIGISAMARITAN <digisamaritan@gmail.com>
 * @copyright 2018 - 2019, DIGISAMARITAN
 * @license   http://opensource.org/licenses/MIT    MIT License
 * @link      http://codeigniter.com
 * @since     Version 1.0.0
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CodeIgniter Cart Model
 * 
 * Cart Model operations.
 *
 * @category  Cartmodel
 * @package   Menorah Restaurant
 * @author    DIGISAMARITAN <digisamaritan@gmail.com>
 * @copyright 2018 - 2019, DIGISAMARITAN
 * @license   http://opensource.org/licenses/MIT    MIT License
 * @link      http://codeigniter.com
 */
class Cart_model extends CI_Model
{
    
    /**
    | -----------------------------------------------------
    | PRODUCT NAME:     Menorah Restaurant
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
    | MODULE:           Cart_Model
    | -----------------------------------------------------
    | This is Cart_Model file.
    | -----------------------------------------------------
     **/
    function __construct()
    {
        parent::__construct();
        // $this->load->database();
        $this->load->library(array('session'));
        $this->load->library(array('ion_auth','form_validation','cart'));
    }
    
    /**
     * Add/Update an item to the cart
     *
     * @return boolean
     **/  
    function validate_add_cart_item()
    {
        $id   = $this->input->post('item_id');//item_id
        
        $qty  = $this->input->post('quantity');// quantity
        $flag = TRUE;
        $extra_costs_total = 0;

        $this->db->where('item_id', $id); // Select where id matches the posted id
        $query = $this->db->get($this->db->dbprefix('items'), 1); // Select the items where a match is found and limit the query by 1

        // Check if a row has matched our item id
        if ($query->num_rows() > 0) {
            
            // We have a match!
            foreach ($query->result() as $row) {

                $item_cost = $row->item_cost;//item_cost from cr_items table	
                
                
                $item_option_id = ($this->input->post('item_option_id')) ? $this->input->post('item_option_id') : "";
                $addon_ids      = $this->input->post('addon_ids');
                // $addon_ids_to_check = array();
                
                /* if(!empty($addon_ids)) {
                foreach ($addon_ids as $key => $value) {
                  $addon_ids_to_check[] = explode('_', $value)[0];
                }
                } */
                
                
                
                //Check if items already exists and if so, update item
                if (($this->cart->contents()) && $this->input->post('rowid')!='') { 

                    $item_id1 = $this->input->post('rowid');//rowid
                    
                    
                    
                    foreach ($this->cart->contents() as $item) {
                        if ($item['id'] == $id && $item['options']['is_offer'] == 0) {

                            if ($item['rowid'] == $item_id1) {

                                $dat = array(
                                   'rowid' => $item['rowid'],
                                   'qty'   => $qty//new quantity
                                );

                                
                                //ITEM OPTION START
                                $cond1="";
                                if ($item_option_id > 0) {
                                    $cond1 = " AND i.item_option_id=".$item_option_id." ";
                            
                                    $option_details = $this->base_model->get_query_result("SELECT o.*,i.item_option_id,i.item_id,i.price FROM ".TBL_PREFIX.TBL_OPTIONS." o inner join ".TBL_PREFIX.TBL_ITEM_OPTIONS." i on o.option_id=i.option_id WHERE i.item_id=".$id." AND o.status='Active' ".$cond1." ");
                                
                                
                                
                                    if (!empty($option_details)) {

                                        $option_details = $option_details[0];

                                        if ($option_details->price > 0) {
                                            $dat['price'] = $option_details->price;//item_cost included selected option -
                                        }

                                    
                                        $dat['options']['item_option_name']     = $option_details->option_name;
                                        $dat['options']['item_option_id']         = $item_option_id;//cr_item_options table -item_option_id-primary_key
                                        $dat['options']['option_id']             = $option_details->option_id;//cr_options table - option_id - primary_key
                                        $dat['options']['item_option_price']     = $option_details->price;
                                    }
                                    //ITEM OPTION END
                                }
                                
                                
                                
                                //ADD ONS START
                                if (!empty($addon_ids)) {

                                    $addons_cost_per_item = 0;

                                    foreach ($addon_ids as $addon_id) {
                                        
                                        
                                        $addon_qty=$qty;
                                        
                                        /* $addonid_qty = explode('_', $value);
                                        $addon_id    = $addonid_qty[0];
                                        $addon_qty   = $addonid_qty[1]; */

                                        
                                        $addon_det=array();
                                        if ($addon_id > 0) {
                                            $addon_det = $this->db->get_where(TBL_ADDONS, array('addon_id' => $addon_id, 'status' => 'Active'))->row();
                                        }
                    
                                        
                                        if (!empty($addon_det)) {

                                            $addons_cost_per_item += ($addon_det->price) * $addon_qty;

                                            $dat['options']['addons_cost_per_item'] = $addons_cost_per_item;
                                            
                                            $dat['options']['addons'][] = $addon_id."=".$addon_det->price."=".$addon_qty."=".$addon_det->addon_name."=".$addon_det->addon_image;
                                        }
                                    }
                                    
                                    
                                    $extra_costs_total += ($addons_cost_per_item);//only addons cost

                                    $dat['options']['extra_costs_total'] = $extra_costs_total;//addons cost
                                }
                                //ADD ONS END
                    
                    
                               
                                /* $dat = array('options' => array('description' => $row->item_description, 'image' => $row->item_image_name, 'item_cost' => $item_cost, 'menu_id' => $row->menu_id, 'is_offer' => 0)); */
                                
                                
                                $dat['options']['description'] = $row->item_description;
                                $dat['options']['image']      = $row->item_image_name;
                                $dat['options']['item_cost'] = $item_cost;
                                $dat['options']['menu_id']   = $row->menu_id;
                                $dat['options']['is_offer']  = 0;
                                
                                
                                
                                
                                $this->cart->update($dat);
                                $flag = FALSE;
                                break;
                            }
                        }
                    }
                    
                    
                    if (!$flag) {
                        return TRUE;
                    } else {
                        return FALSE;
                    }
                    
                }
                
                


                
                
                if ($flag) {
                    
                    //Check Item already exist in cart
                    $existed_item=FALSE;
                    if ($this->cart->contents()) { 
                        foreach ($this->cart->contents() as $item) {
                            if ($item['id'] == $id && $item['options']['is_offer']==0) {
                                // Already existed! Return FALSE! 
                                $existed_item=TRUE;
                                break;
                            }
                        }
                        
                        if ($existed_item) {
                            return 999;
                        }
                    }
                    
                    
                    
                    
                    // Create an array with item information
                    $data = array(
                     'id'      => $id,//Item_id
                     'qty'     => $qty,
                     'price'   => $item_cost,//item_cost from cr_items table
                     'name'    => $row->item_name,
                     'options' => array('description' => $row->item_description, 'image' => $row->item_image_name, 'item_cost' => $item_cost, 'menu_id' => $row->menu_id, 'is_offer' => 0)
                    );

                    
                    
                    
                    //ITEM OPTION START
                    
                    
                    
                    $cond1="";
                    if ($item_option_id > 0) {
                        $cond1 = " AND i.item_option_id=".$item_option_id." ";
                    }
                
                    $option_details = $this->base_model->get_query_result("SELECT o.*,i.item_option_id,i.item_id,i.price FROM ".TBL_PREFIX.TBL_OPTIONS." o inner join ".TBL_PREFIX.TBL_ITEM_OPTIONS." i on o.option_id=i.option_id WHERE i.item_id=".$id." AND o.status='Active' ".$cond1." ");
                    
                    
                    
                    if (!empty($option_details)) {

                        $option_details = $option_details[0];

                        if ($option_details->price > 0) {
                            $data['price'] = $option_details->price;//item_cost included selected option -
                        }

                        $data['options']['item_option_name']     = $option_details->option_name;
                        $data['options']['item_option_id']         = $item_option_id;//cr_item_options table -item_option_id-primary_key
                        $data['options']['option_id']             = $option_details->option_id;//cr_options table - option_id - primary_key
                        $data['options']['item_option_price']     = $option_details->price;
                    }
                    //ITEM OPTION END


                    
                    
                    
                    
                    //ADD ONS START
                    if (!empty($addon_ids)) {

                        $addons_cost_per_item = 0;

                        foreach ($addon_ids as $addon_id) {
                            
                            $addon_qty=1;
                            
                            /* $addonid_qty = explode('_', $value);
                            $addon_id    = $addonid_qty[0];
                            $addon_qty   = $addonid_qty[1]; */

                            
                            $addon_det=array();
                            if ($addon_id > 0) {
                                $addon_det = $this->db->get_where(TBL_ADDONS, array('addon_id' => $addon_id, 'status' => 'Active'))->row();
                            }
        
                            
                            if (!empty($addon_det)) {

                                $addons_cost_per_item += ($addon_det->price) * $addon_qty;

                                $data['options']['addons_cost_per_item'] = $addons_cost_per_item;
                                $data['options']['addons'][] = $addon_id."=".$addon_det->price."=".$addon_qty."=".$addon_det->addon_name."=".$addon_det->addon_image;
                            }
                        }
                        
                        
                        $extra_costs_total += ($addons_cost_per_item);//only addons cost

                        $data['options']['extra_costs_total'] = $extra_costs_total;//addons cost
                    }
                    //ADD ONS END
                    

                    // Add the data to the cart using the insert function that is available because we loaded the cart library
                    if ($this->cart->insert($data)) {
                        
                        return count($this->cart->contents());
                    } else {
                        return FALSE;
                    }
                }
                /* else {
                return TRUE; // Finally return TRUE
                } */
            }

        } else {
            // Nothing found! Return FALSE! 
            return FALSE;
        }
    }
    
    /**
     * Update an item to the cart
     *
     * @return boolean
     **/
    function update_cart_item() 
    {
        
        $rowid = $this->input->post('rowid');
        $type  = $this->input->post('type');
        
        $extra_costs_total = 0;
         
        $is_updated=0;
        
        if ($rowid!='' && $type!='') {
            
            
            if (!empty($this->cart->contents())) {
                
                foreach ($this->cart->contents() as $item) {
                    
                    if ($rowid==$item['rowid']) {
                        
                        $qty = $item['qty'];
                        
                        
                        if ($type=='decr') {
                            
                            // echo 'QUANLSDFKF '.$qty;die();
                            if ($qty==1) {//remove item from cart
                            
                                $this->cart->remove($rowid);
                                $is_updated=1;
                                break;
                                
                            } else {
                                
                                if ($item['options']['is_offer']==1) {
                                    //offer	
                                
                                    $dat = array('rowid'=>$item['rowid'],'id'=>$item['id'],'qty'=>$qty-1,'price'=>$item['price'],'name'=>$item['name']);
                                
                                    $dat['options'] = $item['options'];
                                    
                                    $this->cart->update($dat);
                                    $is_updated=1;
                                    break;
                                    
                                } else {
                                    //item
                                    
                                    
                                    $dat = array('rowid'=>$item['rowid'],'id'=>$item['id'],'qty'=>$qty-1,'price'=>$item['price'],'name'=>$item['name']);
                                    
                                    
                                    $dat['options']['description'] = $item['options']['description'];
                                    $dat['options']['image'] = $item['options']['image'];    
                                    $dat['options']['item_cost'] = $item['options']['item_cost'];
                                    $dat['options']['menu_id'] = $item['options']['menu_id'];
                                    $dat['options']['is_offer'] = $item['options']['is_offer'];
                                    
                                    if (isset($item['options']['item_option_name'])) {
                                        
                                        $dat['options']['item_option_name'] = $item['options']['item_option_name'];
                                        $dat['options']['item_option_id'] = $item['options']['item_option_id'];    
                                        $dat['options']['option_id'] = $item['options']['option_id'];    
                                        $dat['options']['item_option_price'] = $item['options']['item_option_price'];
                                    
                                    }

                                    
                                        
                                    //ADD ONS START
                                    if (!empty($item['options']['addons'])) {

                                        $addons_cost_per_item = 0;

                                        foreach ($item['options']['addons'] as $key=>$val) {
                                        
                                            $addon_qty=$qty-1;
                                        
                                            $addonid = explode('=', $val);
                                            $addon_id    = $addonid[0];
                                        
                                            $addon_det=array();
                                            if ($addon_id > 0) {
                                                $addon_det = $this->db->get_where(TBL_ADDONS, array('addon_id' => $addon_id, 'status' => 'Active'))->row();
                                            }
                    
                                        
                                            if (!empty($addon_det)) {

                                                $addons_cost_per_item += ($addon_det->price) * $addon_qty;

                                            
                                                $dat['options']['addons_cost_per_item'] = $addons_cost_per_item;
                                            
                                            
                                                $dat['options']['addons'][] = $addon_id."=".$addon_det->price."=".$addon_qty."=".$addon_det->addon_name."=".$addon_det->addon_image;
                                            }
                                        }
                                    
                                    
                                        $extra_costs_total += ($addons_cost_per_item);//only addons cost

                                        $dat['options']['extra_costs_total'] = $extra_costs_total;//addons cost
                                    }
                                    //ADD ONS END
                                        
                                    
                                    $this->cart->update($dat);
                                    $is_updated=1;
                                    break;    
                                    
                                    
                                }
                                
                            }
                            
                        } else {
                            //incr
                            
                            if ($item['options']['is_offer']==1) {
                                //offer	
                                
                                $dat = array('rowid'=>$item['rowid'],'id'=>$item['id'],'qty'=>$qty+1,'price'=>$item['price'],'name'=>$item['name']);
                                
                                $dat['options'] = $item['options'];
                                
                                $this->cart->update($dat);
                                $is_updated=1;
                                break;
                                
                            } else {
                                
                                //item
                                    
                                $dat = array('rowid'=>$item['rowid'],'id'=>$item['id'],'qty'=>$qty+1,'price'=>$item['price'],'name'=>$item['name']);
                                    
                                    
                                $dat['options']['description'] = $item['options']['description'];
                                $dat['options']['image'] = $item['options']['image'];    
                                $dat['options']['item_cost'] = $item['options']['item_cost'];
                                $dat['options']['menu_id'] = $item['options']['menu_id'];
                                $dat['options']['is_offer'] = $item['options']['is_offer'];
                                    
                                    
                                if (isset($item['options']['item_option_name'])) {
                                        
                                    $dat['options']['item_option_name'] = $item['options']['item_option_name'];
                                    $dat['options']['item_option_id'] = $item['options']['item_option_id'];    
                                    $dat['options']['option_id'] = $item['options']['option_id'];    
                                    $dat['options']['item_option_price'] = $item['options']['item_option_price'];
                                    
                                }
                                    

                                    
                                        
                                //ADD ONS START
                                if (!empty($item['options']['addons'])) {

                                    $addons_cost_per_item = 0;

                                    foreach ($item['options']['addons'] as $key=>$val) {
                                        
                                        $addon_qty=$qty+1;
                                        
                                        $addonid = explode('=', $val);
                                        $addon_id    = $addonid[0];
                                        
                                        $addon_det=array();
                                        if ($addon_id > 0) {
                                            $addon_det = $this->db->get_where(TBL_ADDONS, array('addon_id' => $addon_id, 'status' => 'Active'))->row();
                                        }
                    
                                        
                                        if (!empty($addon_det)) {

                                            $addons_cost_per_item += ($addon_det->price) * $addon_qty;

                                            
                                            $dat['options']['addons_cost_per_item'] = $addons_cost_per_item;
                                            
                                            
                                            $dat['options']['addons'][] = $addon_id."=".$addon_det->price."=".$addon_qty."=".$addon_det->addon_name."=".$addon_det->addon_image;
                                        }
                                    }
                                    
                                    
                                    $extra_costs_total += ($addons_cost_per_item);//only addons cost

                                    $dat['options']['extra_costs_total'] = $extra_costs_total;//addons cost
                                }
                                //ADD ONS END
                                        
                                
                                $this->cart->update($dat);
                                $is_updated=1;
                                break;    
                                    
                                    
                            }
                            
                        }
                        
                        
                        
                    }
                }
                
                
                
                if ($is_updated>0) {
                    
                    // return true;
                    $total_itms = count($this->cart->contents());
                    if ($total_itms<=0) {
                        return 9999;//no items cart
                    } else {
                        return $total_itms;
                    }
                } else {
                    return FALSE;
                }
                
            } else {
                return FALSE;
            }
            
        } else {
            return FALSE;
        }
       
    }
    
    

    /**
     * Update an offer to the cart
     *
     * @return boolean
     **/
    function validate_add_cart_offer()
    {
        $id   = $this->input->post('item_id');//$this->input->post('offer_id');		
        $qty  = $this->input->post('quantity');
        $flag = TRUE;


        $this->db->where('offer_id', $id); // Select where id matches the posted id
        $query = $this->db->get($this->db->dbprefix('offers'), 1); // Select the offers where a match is found and limit the query by 1
        
        // Check if a row has matched our item id
        if ($query->num_rows() > 0) {
            
            // We have a match!
            foreach ($query->result() as $row) {

                $offer_cost = $row->offer_cost;

                
                
                //Check if offer already exists and if so, do not do anything as it is already added to the cart
                if (($this->cart->contents()) && $this->input->post('item_id1')!='') {

                    $item_id1 = $this->input->post('item_id1');//rowid
                    
                    foreach ($this->cart->contents() as $item) {
                        
                        if ($item['id'] == $id && $item['options']['is_offer'] == 1 && $item['rowid'] == $item_id1) {
                            
                            $dat = array(
                            'rowid' => $item['rowid'],
                            'qty'   => $qty//new quantity
                            );

                            $this->cart->update($dat);
                                
                            $flag = FALSE;
                            break;
                        }
                    }
                    
                    if (!$flag) {
                        return TRUE;
                    } else {
                        return FALSE;
                    }
                    
                }
                
                
                


                if ($flag) {
                    
                    //Check Offer already exist in cart
                    $existed_item=FALSE;
                    if ($this->cart->contents()) { 
                        foreach ($this->cart->contents() as $item) {
                            if ($item['id'] == $id && $item['options']['is_offer']==1) {
                                // Already existed! Return FALSE! 
                                $existed_item=TRUE;
                                break;
                            }
                        }
                        
                        if ($existed_item) {
                            return 999;
                        }
                    }
                    
                    
                    // Create an array with item information
                    $data = array(
                     'id'      => $id,
                     'qty'     => $qty,
                     'price'   => $offer_cost,
                     'name'    => $row->offer_name,
                     'options' => array('description' => $row->offer_conditions, 'image' => $row->offer_image_name, 'is_offer' => 1)
                    );                    

                    $this->load->model('crunchy_model');                    
                    $offer_products = $this->crunchy_model->getOfferProducts($id);                                        

                    if (!empty($offer_products)) {
                        
                        foreach ($offer_products as $key => $value) {
                            $data['options']['offers'][] = $value->quantity."=".$value->item_name;
                        }
                    }

                    
                    
                    if ($this->cart->insert($data)) {
                        return count($this->cart->contents());
                    } else {
                        return FALSE;
                    }
                    
                    
                }

                // return TRUE; // Finally return TRUE
            }

        } else {
            // Nothing found! Return FALSE! 
            return FALSE;
        }
    }
    
    
    /**
     * 
     * 
     * 
     * 
     * 
     * Get User Address
     * 
     * 
     * 
     *
     * @param  int    $user_id 
     * @param  string $zipcode 
     *                         
     * @return array
     */       
    function get_user_address($user_id='',$zipcode='')
    {
        if (empty($user_id)) {
            $user_id = $this->ion_auth->get_user_id();
        }
        
        
        if (empty($user_id)) {
            $this->prepare_flashmessage("Please Login to Continue", 2);
            redirect(URL_AUTH_LOGIN);
        }
            

        $cond1 = "";
        if (!empty($zipcode)) {
            $cond1 = " AND ua.pincode='".$zipcode."'";
        }

        $query = "SELECT ua.*,s.delivery_fee,s.delivery_from_time, s.delivery_to_time,s.delivery_time_units FROM ".TBL_PREFIX.TBL_USER_ADDRESS." ua INNER JOIN ".TBL_PREFIX.TBL_SERVICE_PROVIDE_LOCATIONS." s ON ua.location_id = s.service_provide_location_id WHERE ua.user_id =".$user_id." ".$cond1." AND s.status='Active' ";

        $user_address = $this->db->query($query)->result();

        return $user_address;
    }
    
    
     /**
     * Get DELIVERY Fee
     *
     * @param       int $ua_id Input int
     * @return      boolean
     */
    function get_addrs_delivery_fee($ua_id)
    {
        $delivery_fee=0;
        
        $user_id = $this->ion_auth->get_user_id();
            
        $query = "SELECT s.delivery_fee FROM ".TBL_PREFIX.TBL_USER_ADDRESS." ua INNER JOIN ".TBL_PREFIX.TBL_SERVICE_PROVIDE_LOCATIONS." s ON ua.location_id = s.service_provide_location_id WHERE ua.user_id =".$user_id." AND ua.ua_id=".$ua_id." AND s.status='Active' ";

        $user_address = $this->db->query($query)->result();
        
        
        if (!empty($user_address) && ($user_address[0]->delivery_fee>0)) {
            $delivery_fee = $user_address[0]->delivery_fee;
        }
    
        return $delivery_fee;
    }
    
    
     /**
     * Get User Delivery Address
     *
     * @param       int $user_id Input int
     * @param       int $ua_id   Input string
     * @return      array
     */ 
    function get_user_shipping_address($user_id='',$ua_id='')
    {
        if (empty($user_id)) {
            $user_id = $this->ion_auth->get_user_id();
        }
        
        if (empty($user_id)) {
            $this->prepare_flashmessage("Please Login to Continue", 2);
            redirect(URL_AUTH_LOGIN);
        }
        

        $query = "SELECT ua.*,s.city_id,s.delivery_fee,s.delivery_from_time, s.delivery_to_time,s.delivery_time_units FROM ".TBL_PREFIX.TBL_USER_ADDRESS." ua INNER JOIN ".TBL_PREFIX.TBL_SERVICE_PROVIDE_LOCATIONS." s ON ua.location_id = s.service_provide_location_id WHERE ua.user_id =".$user_id."  AND ua.ua_id=".$ua_id." AND s.status='Active' ";

        $user_address = $this->db->query($query)->result();

        return $user_address;
    }
    
    /**
     * Check Redeem Points 
     *
     * @return array
     **/  
    function check_redeem_points()
    {
        $point_settings = $this->base_model->fetch_records_from(TBL_LOYALITY_POINTS, array('enable_redeeming'=>'Yes'));
        
        if (!empty($point_settings)) {
            
            $point_settings = $point_settings[0];
            $user=getUserRec();
            $user_points = $user->user_points;
            
            $usable_points =0;
            
            $redeem_points_value = $point_settings->redeeming_point_value;
            
            if ($user_points >= $point_settings->minimum_points_can_be_used && $redeem_points_value > 0) {
                
                if ($user_points >= $point_settings->maximum_points_can_be_used) {
                    $usable_points = $point_settings->maximum_points_can_be_used;
                    
                    $discount = $usable_points*$redeem_points_value;
                } else {
                    $usable_points = $user_points;
                    $discount = $user_points*$redeem_points_value;
                }
                return $discount.'='.$user_points.'='.$usable_points;//discount - user total points - usable points for this order
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }
}