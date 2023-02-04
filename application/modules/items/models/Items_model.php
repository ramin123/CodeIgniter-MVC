<?php 
/**
 * MENORAH RESTAURANT-DIGISAMARITAN * 
 * An online food order system in codeigniter framework
 * 
 * This content is released under the Codecanyon Market License (CML)
 * 
 * Copyright (c) 2018 - 2019, DIGISAMARITAN
 *
 * @category  Itemsmodel
 * @package   MENORAH RESTAURANT
 * @author    DIGISAMARITAN <digisamaritan@gmail.com>
 * @copyright 2018 - 2019, DIGISAMARITAN
 * @license   http://opensource.org/licenses/MIT    MIT License
 * @link      http://codeigniter.com
 * @since     Version 1.0.0
 */
if (! defined('BASEPATH')) { exit('No direct script access allowed');
}

/**
 * CodeIgniter Items_Model
 * 
 * Items_Model operations.
 *
 * @category  Itemsmodel
 * @package   MENORAH RESTAURANT
 * @author    DIGISAMARITAN <digisamaritan@gmail.com>
 * @copyright 2018 - 2019, DIGISAMARITAN
 * @license   http://opensource.org/licenses/MIT    MIT License
 * @link      http://codeigniter.com
 */
class Items_model extends CI_Model
{
    /**
     * [$column_order description]
     * @var array
     */

   

    // default order 
    /**
    | -----------------------------------------------------
    | PRODUCT NAME:     MENORAH RESTAURANT
    | -----------------------------------------------------
    | AUTHOR:           DIGISAMARITAN
    | -----------------------------------------------------
    | EMAIL:            digisamaritan@gmail.com
    | -----------------------------------------------------
    | COPYRIGHTS:       RESERVED BY CONQUERORS MARKET
    | -----------------------------------------------------      
    | http://codecanyon.net/user/digisamaritan
    | http://conquerorstech.net/
    | -----------------------------------------------------
    |
    | MODULE:           Items_Model
    | -----------------------------------------------------
    | This is Items_Model file.
    | -----------------------------------------------------
     **/
    function __construct()
    {

        parent::__construct();

        $this->load->database();

    }

    /**
     * Get Item Options
     * 
     * @param int $item_id             
     *
     * @return array
     */  
    function get_item_options($item_id)
    {
        $query="select io.*,o.* from ".TBL_PREFIX.TBL_ITEM_OPTIONS." io inner join ".TBL_PREFIX.TBL_OPTIONS." o on io.option_id=o.option_id where io.item_id=".$item_id." and o.status='Active'";

        $records = $this->db->query($query)->result();

        return $records;
    }
    
    /**
     * Get Item Addons
     * 
     * @param int $item_id             
     *
     * @return array
     */ 
    function get_item_addons($item_id)
    {
        $query="select ia.*,a.* from ".TBL_PREFIX.TBL_ITEM_ADDONS." ia inner join ".TBL_PREFIX.TBL_ADDONS." a on ia.addon_id=a.addon_id where ia.item_id=".$item_id." and a.status='Active'";

        $records = $this->db->query($query)->result();

        return $records;
    }

    
    /**
     *  Add Options to Item
     * 
     * @param int   $item_id             
     * @param int   $option_count 
     * @param array $options_data 
     *
     * @return array
     */ 
    function addOptions($item_id,$option_count,$options_data = array())
    {
        $item_details = $this->base_model->fetch_records_from(TBL_ITEMS, array('item_id'=>$item_id));

        
        if (!empty($item_details)) {

            $option_details = $this->base_model->fetch_records_from(TBL_ITEM_OPTIONS, array('item_id'=>$item_id));

        
            if (!empty($option_details)) {
                $where['item_id'] = $item_id;

                $this->base_model->delete_record_new(TBL_ITEM_OPTIONS, $where);
            }

               

            $batch_data = array();

            for ($i=1;$i<$option_count;$i++) {
                $data['option_id']   = $options_data['option_id'.$i];

                $data['item_id']     = $item_id;

                $data['price']       = $options_data['price'.$i];

                array_push($batch_data, $data);
            }

            if ($this->db->insert_batch(TBL_PREFIX.TBL_ITEM_OPTIONS, $batch_data)) {
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        } 
    }
    
    
    /**
     * Ajax data tables 
     *
     * @return array
     **/ 
    private function _get_datatables_query()
    {
          $this->db->select(TBL_PREFIX.'items.*,'.TBL_PREFIX.'menu.menu_name,'.TBL_PREFIX.'item_types.item_type');
       
        $this->db->from($this->db->dbprefix('items'));
        $this->db->join($this->db->dbprefix('menu'), $this->db->dbprefix('menu').'.menu_id = '.$this->db->dbprefix('items').'.menu_id');
        $this->db->join($this->db->dbprefix('item_types'), $this->db->dbprefix('item_types').'.item_type_id = '.$this->db->dbprefix('items').'.item_type_id');
        $query = $this->db->get();
                           
        $i = 0;
     
        foreach ($this->column_search as $item) {
            
            if ($_POST['search']['value']) {
                 
                if ($i===0) {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
 
                if (count($this->column_search) - 1 == $i) { //last loop
                    $this->db->group_end(); //close bracket
                }
            }
            $i++;
        }
         
        if (isset($_POST['order'])) {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
    
     /**
      * Ajax data tables 
      *
      * @return array
      **/ 
    function get_datatables()
    {
        $this->_get_datatables_query();
        
        if ($_POST['length'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $this->db->select(TBL_PREFIX.'items.*,'.TBL_PREFIX.'menu.menu_name,'.TBL_PREFIX.'item_types.item_type');
        
        $this->db->from($this->db->dbprefix('items'));
        $this->db->join($this->db->dbprefix('menu'), $this->db->dbprefix('menu').'.menu_id = '.$this->db->dbprefix('items').'.menu_id');
        $this->db->join($this->db->dbprefix('item_types'), $this->db->dbprefix('item_types').'.item_type_id = '.$this->db->dbprefix('items').'.item_type_id');
        $query = $this->db->get();
        
        return $query->result();
    }
    
    /**
     * Count filtered 
     *
     * @return int
     **/ 
    function count_filtered()
    {
        $this->_get_datatables_query();
        $this->db->select(TBL_PREFIX.'items.*,'.TBL_PREFIX.'menu.menu_name,'.TBL_PREFIX.'item_types.item_type');
        
        $this->db->from($this->db->dbprefix('items'));
        $this->db->join($this->db->dbprefix('menu'), $this->db->dbprefix('menu').'.menu_id = '.$this->db->dbprefix('items').'.menu_id');
        $this->db->join($this->db->dbprefix('item_types'), $this->db->dbprefix('item_types').'.item_type_id = '.$this->db->dbprefix('items').'.item_type_id');
        $query = $this->db->get();
        return $query->num_rows();
    }
    
    /**
     * Count All 
     *
     * @return int
     **/
    public function count_all()
    {
        $this->db->select(TBL_PREFIX.'items.*,'.TBL_PREFIX.'menu.menu_name,'.TBL_PREFIX.'item_types.item_type');
        
        $this->db->from($this->db->dbprefix('items'));
        $this->db->join($this->db->dbprefix('menu'), $this->db->dbprefix('menu').'.menu_id = '.$this->db->dbprefix('items').'.menu_id');
        $this->db->join($this->db->dbprefix('item_types'), $this->db->dbprefix('item_types').'.item_type_id = '.$this->db->dbprefix('items').'.item_type_id');
        $query = $this->db->get();
        return $this->db->count_all_results();
    }
}