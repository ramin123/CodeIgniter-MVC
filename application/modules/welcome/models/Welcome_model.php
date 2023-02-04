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
 * @category  Welcomemodel
 * @package   MENORAH RESTAURANT
 * @author    DIGISAMARITAN <digisamaritan@gmail.com>
 * @copyright 2018 - 2019, DIGISAMARITAN
 * @license   http://opensource.org/licenses/MIT    MIT License
 * @link      http://codeigniter.com
 * @since     Version 1.0.0
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CodeIgniter Welcome Model
 * 
 * Welcome_Model perform operations.
 *
 * @category  Welcomemodel
 * @package   MENORAH RESTAURANT
 * @author    DIGISAMARITAN <digisamaritan@gmail.com>
 * @copyright 2018 - 2019, DIGISAMARITAN
 * @license   http://opensource.org/licenses/MIT    MIT License
 * @link      http://codeigniter.com
 */
class Welcome_model extends CI_Model
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
    | MODULE:           Welcome_Model
    | -----------------------------------------------------
    | This is Welcome_Model file.
    | -----------------------------------------------------
     **/
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    
    /**
     * Get Item options
     *
     * @param int $item_id 
     * @param int $item_option_id               
     *
     * @return array
     */   
    function getItemOptions($item_id, $item_option_id = "")
    {
        $cond1 = "";
            
        if ($item_option_id > 0) {
            $cond1 = " AND io.item_option_id=".$item_option_id." ";
        }

        return $this->base_model->get_query_result("SELECT o.*,io.* FROM ".TBL_PREFIX.TBL_OPTIONS." o inner join ".TBL_PREFIX.TBL_ITEM_OPTIONS." io on o.option_id=io.option_id WHERE io.item_id=".$item_id." AND o.status='Active' ".$cond1." ");
    }
    
    /**
     * Get Item addons
     *
     * @param int $item_id 
     *
     * @return array
     */  
    function getItemAddons($item_id)
    {
        return $this->base_model->get_query_result("SELECT a.*,i.* FROM ".TBL_PREFIX.TBL_ADDONS." a inner join ".TBL_PREFIX.TBL_ITEM_ADDONS." i on a.addon_id=i.addon_id WHERE i.item_id=".$item_id." AND a.status='Active' ");
    }
    
    /**
     * Get Items
     *
     * @param int $offset 
     * @param int $menu_id             
     *
     * @return array
     */ 
    function getItems($offset,$menu_id)
    {
        $limit = ITEMS_PER_PAGE;
        
        $query = "select i.* from ".TBL_PREFIX.TBL_ITEMS." i where i.menu_id=".$menu_id." and i.item_cost > 0 and i.status='Active' order by i.item_id desc ";
        
        $items = $this->db->query($query);
        $this->numrows = $this->db->affected_rows();
        
        if (count($items)>=0) {
            $query  = $query." LIMIT ".$offset.", ".$limit." ";
            $items = $this->db->query($query);
        }
        $items =  $items->result();
        
        return $items;
    }
    
    
    
    /**
     * Get selected menu items
     *
     * @param int $offset 
     * @param int $menu_id             
     *
     * @return array
     */
    function get_menu_items($offset,$menu_id)
    {
        $limit = MENU_ITEMS_PER_PAGE;
        
        $query = "select i.* from ".TBL_PREFIX.TBL_ITEMS." i where i.menu_id=".$menu_id." and i.item_cost > 0 and i.status='Active' order by i.item_id desc ";
        
        $items = $this->db->query($query);
        $this->numrows = $this->db->affected_rows();
        
        if (count($items)>=0) {
            $query  = $query." LIMIT ".$offset.", ".$limit." ";
            $items = $this->db->query($query);
        }
        $items =  $items->result();
        
        //get items addons and options
        if (!empty($items)) {
            foreach ($items as $item) {
                
                $addons = array();
                $addons = $this->base_model->get_query_result("select ia.item_addon_id,a.addon_id,a.addon_name,a.price from ".TBL_PREFIX.TBL_ITEM_ADDONS." ia inner join ".TBL_PREFIX.TBL_ADDONS." a on ia.addon_id=a.addon_id where ia.item_id=".$item->item_id." and a.status='Active' ");
                
                
                $options = array();
                $options = $this->base_model->get_query_result("select io.item_option_id,io.price,o.option_id,o.option_name from ".TBL_PREFIX.TBL_ITEM_OPTIONS." io inner join ".TBL_PREFIX.TBL_OPTIONS." o on io.option_id=o.option_id where io.item_id=".$item->item_id." and o.status='Active' ");
                
                
                $item->addons  = $addons;
                $item->options = $options;
            }
        }
        
        return $items;
    }
    
    
    
    
    /**
     * Get selected menu items
     *
     * @param int $offset 
     * @param int $menu_id             
     *
     * @return array
     */
    function get_home_menu_items($offset,$menu_id)
    {
        $limit = HOME_MENU_ITEMS_PER_PAGE;
        
        $query = "select i.* from ".TBL_PREFIX.TBL_ITEMS." i where i.menu_id=".$menu_id." and i.item_cost > 0 and i.status='Active' order by i.is_most_selling_item ";
        
        $items = $this->db->query($query);
        $this->numrows = $this->db->affected_rows();
        
        if (count($items)>=0) {
            $query  = $query." LIMIT ".$offset.", ".$limit." ";
            $items = $this->db->query($query);
        }
        $items =  $items->result();
        
        //get items addons and options
        if (!empty($items)) {
            foreach ($items as $item) {
                
                $addons = array();
                $addons = $this->base_model->get_query_result("select ia.item_addon_id,a.addon_id,a.addon_name,a.price from ".TBL_PREFIX.TBL_ITEM_ADDONS." ia inner join ".TBL_PREFIX.TBL_ADDONS." a on ia.addon_id=a.addon_id where ia.item_id=".$item->item_id." and a.status='Active' ");
                
                
                $options = array();
                $options = $this->base_model->get_query_result("select io.item_option_id,io.price,o.option_id,o.option_name from ".TBL_PREFIX.TBL_ITEM_OPTIONS." io inner join ".TBL_PREFIX.TBL_OPTIONS." o on io.option_id=o.option_id where io.item_id=".$item->item_id." and o.status='Active' ");
                
                
                $item->addons  = $addons;
                $item->options = $options;
            }
        }
        
        return $items;
    }
    
    
    /**
     * Get menu offers
     *
     * @param int $offset 
     *
     * @return array
     */
    function get_menu_offers($offset)
    {
        $limit = MENU_ITEMS_PER_PAGE;
        
        $records = array();
        
        $query = "select * from ".TBL_PREFIX.TBL_OFFERS." where status='Active' and CURDATE() between offer_start_date and offer_valid_date order by offer_id desc ";
        
        $offers = $this->db->query($query);
        $this->numrows = $this->db->affected_rows();
        
        if (count($offset)>=0) {
            $query  = $query." LIMIT ".$offset.", ".$limit." ";
            $offers = $this->db->query($query);
        }
        $offers =  $offers->result();
        
        
        if (!empty($offers)) {
            
            foreach($offers as $offer):
            
                //get offer items
                $items = array();
                $items = $this->base_model->get_query_result("select * from ".TBL_PREFIX.TBL_OFFER_PRODUCTS." where offer_id=".$offer->offer_id." and quantity > 0 ");
            
                if (!empty($items)) {
                
                    $record = array();
                    $record = (object) $record;
                    $record->offer_id     = $offer->offer_id;
                    $record->offer_name = $offer->offer_name;
                    $record->offer_cost = $offer->offer_cost;
                    $record->offer_image_name = $offer->offer_image_name;
                    $record->offer_conditions = $offer->offer_conditions;
                    $record->product_id          = $offer->product_id;
                    $record->items = $items;
                
                    array_push($records, $record);
                    unset($record, $items);
                }
            endforeach;
        }
        
        return $records;
    }
    
    
    
    /**
     * Get popular items
     *
     * @param int $offset 
     *
     * @return array
     */
    function get_popular_items($offset)
    {
        $limit = MENU_ITEMS_PER_PAGE;
        
        $query = "select i.* from ".TBL_PREFIX.TBL_ITEMS." i where i.is_most_selling_item='Yes' and i.item_cost > 0 and i.status='Active' order by i.item_id desc ";
        
        $items = $this->db->query($query);
        $this->numrows = $this->db->affected_rows();
        
        if (count($items)>=0) {
            $query  = $query." LIMIT ".$offset.", ".$limit." ";
            $items = $this->db->query($query);
        }
        $items =  $items->result();
        
        //get items addons and options
        if (!empty($items)) {
            foreach ($items as $item) {
                
                $addons = array();
                $addons = $this->base_model->get_query_result("select ia.item_addon_id,a.addon_id,a.addon_name,a.price from ".TBL_PREFIX.TBL_ITEM_ADDONS." ia inner join ".TBL_PREFIX.TBL_ADDONS." a on ia.addon_id=a.addon_id where ia.item_id=".$item->item_id." and a.status='Active' ");
                
                
                $options = array();
                $options = $this->base_model->get_query_result("select io.item_option_id,io.price,o.option_id,o.option_name from ".TBL_PREFIX.TBL_ITEM_OPTIONS." io inner join ".TBL_PREFIX.TBL_OPTIONS." o on io.option_id=o.option_id where io.item_id=".$item->item_id." and o.status='Active' ");
                
                
                $item->addons  = $addons;
                $item->options = $options;
            }
        }
        
        return $items;
    }
    
    
    /**
     * Get Search items
     *
     * @param int $offset 
     * @param int $search_string        
     *
     * @return array
     */
    function get_search_items($offset,$search_string)
    {
        $limit = MENU_ITEMS_PER_PAGE;
        
        $query = "select i.* from ".TBL_PREFIX.TBL_ITEMS." i where i.item_name like '%".$search_string."%'  and i.item_cost > 0 and i.status='Active' order by i.item_id desc ";
        
        $items = $this->db->query($query);
        $this->numrows = $this->db->affected_rows();
        
        if (count($items)>=0) {
            $query  = $query." LIMIT ".$offset.", ".$limit." ";
            $items = $this->db->query($query);
        }
        $items =  $items->result();
        
        //get items addons and options
        if (!empty($items)) {
            foreach ($items as $item) {
                
                $addons = array();
                $addons = $this->base_model->get_query_result("select ia.item_addon_id,a.addon_id,a.addon_name,a.price from ".TBL_PREFIX.TBL_ITEM_ADDONS." ia inner join ".TBL_PREFIX.TBL_ADDONS." a on ia.addon_id=a.addon_id where ia.item_id=".$item->item_id." and a.status='Active' ");
                
                
                $options = array();
                $options = $this->base_model->get_query_result("select io.item_option_id,io.price,o.option_id,o.option_name from ".TBL_PREFIX.TBL_ITEM_OPTIONS." io inner join ".TBL_PREFIX.TBL_OPTIONS." o on io.option_id=o.option_id where io.item_id=".$item->item_id." and o.status='Active' ");
                
                
                $item->addons  = $addons;
                $item->options = $options;
            }
        }
        
        return $items;
    }
}