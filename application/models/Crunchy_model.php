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
 * @category  Crunchymodel
 * @package   Restaurant
 * @author    Conquerors Market <conquerorsmarket@gmail.com>
 * @copyright 2018 - 2019, Conquerors Market
 * @license   http://opensource.org/licenses/MIT    MIT License
 * @link      http://codeigniter.com
 * @since     Version 1.0.0
 */  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter Crunchymodel
 * 
 * Crunchymodel operations.
 *
 * @category  Crunchymodel
 * @package   Restaurant
 * @author    Conquerors Market <conquerorsmarket@gmail.com>
 * @copyright 2018 - 2019, Conquerors Market
 * @license   http://opensource.org/licenses/MIT    MIT License
 * @link      http://codeigniter.com
 */
class Crunchy_model extends CI_Model
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
    | MODULE:           CRUNCHY MODEL
    | -----------------------------------------------------
    | This is CRUNCHY MODEL file.
    | -----------------------------------------------------
     **/
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
		
		
	
	/**
	 * [getServiceDeliveryLocation description]
	 * @param  [type] $city_id [description]
	 * @return [type]          [description]
	 */
	 function getServiceDeliveryLocation($city_id)
	 {
	 	return $serviceLocations = $this->base_model->get_query_result('SELECT sl.*,c.city_name FROM '.DBPREFIX.'service_provide_locations sl,'.DBPREFIX.'cities c WHERE sl.status="Active" AND c.city_id=sl.city_id AND c.status="Active" and sl.city_id='.$city_id);
  }


	
	
	/**
	 * [getServiceDeliveryCities description]
	 * @return [type] [description]
	 */
	 function getServiceDeliveryCities()
	 {
	 	return $serviceLocations = $this->base_model->get_query_result('SELECT distinct c.city_name,c.city_id FROM '.DBPREFIX.'service_provide_locations sl,'.DBPREFIX.'cities c WHERE  sl.status="Active" AND c.city_id=sl.city_id AND c.status="Active" order by c.city_name asc');
  }
	
	/**
	 * [deleteUserPoints description]
	 * @param  [type] $order_id [description]
	 * @return [type]           [description]
	 */
	function deleteUserPoints($order_id)
	{
		$msg = "<ul>";
		$user_points_log = $this->base_model->fetch_records_from(TBL_USER_POINTS, array('order_id'=>$order_id));
		if(!empty($user_points_log)){
			foreach($user_points_log as $points_log){
				
				if($points_log->transaction_type=='Earned'){
					$this->db->where('id', $points_log->user_id);
					$this->db->set('user_points', 'user_points-'.$points_log->points, FALSE);
					$this->db->update($this->db->dbprefix('users'));
					$msg .= "<li>".$points_log->points." Points debited from User</li>";
				}else if($points_log->transaction_type=='Redeem'){
					$this->db->where('id', $points_log->user_id);
					$this->db->set('user_points', 'user_points+'.$points_log->points, FALSE);
					$this->db->update($this->db->dbprefix('users'));
					$msg .= "<li>".$points_log->points." Points credited back to user</li>";
				}
			}
		
		}else{
			$msg = "<li>No Points gained</li>";
		}
		
			return $msg."</ul>";
	}
	
	/**
	 * [add_points_to_user_for_sharing description]
	 * @param [type] $user_id [description]
	 * @return  [boolean]
	 */
	function add_points_to_user_for_sharing($user_id)
	{
		$is_points_enabled = $this->config->item('points_settings')->points_enabled;
		
		if($is_points_enabled==1){
			$points_for_sharing_app = $this->config->item('points_settings')->points_for_sharing_app;
			$data['user_id'] 	 		 = $user_id;
			$data['transaction_type'] 	 = "Earned";
			$data['description'] = "Points for sharing";
			$data['points'] 	 = $points_for_sharing_app;
			//$data['date_added']  = date('Y-m-d H:i:s');
			
			if($this->base_model->insert_operation($data, TBL_USER_POINTS)){
				$this->db->where('id', $user_id);
				$this->db->set('user_points', 'user_points+'.$points_for_sharing_app, FALSE);
				$this->db->update($this->db->dbprefix('users'));
				return TRUE;
			}else{
				return FALSE;
			}
		}else{
			return TRUE;
		}
	}

	
	/**
	 * [add_points_to_user_for_review description]
	 * @param [type] $user_id [description]
	 * @return boolean [<description>]
	 */
	function add_points_to_user_for_review($user_id)
	{
		$is_points_enabled = $this->config->item('points_settings')->points_enabled;
		
		if($is_points_enabled==1){
			$points_for_restaurant_review = $this->config->item('points_settings')->points_for_restaurant_review;
			$data['user_id'] 	 		 = $user_id;
			$data['transaction_type'] 	 = "Earned";
			$data['description'] = "Points for review the restaurant";
			$data['points'] 	 = $points_for_restaurant_review;
			//$data['date_added']  = date('Y-m-d H:i:s');
			
			if($this->base_model->insert_operation($data, TBL_USER_POINTS)){
				$this->db->where('id', $user_id);
				$this->db->set('user_points', 'user_points+'.$points_for_restaurant_review, FALSE);
				$this->db->update($this->db->dbprefix('users'));
				return TRUE;
			}else{
				return FALSE;
			}
		}else{
			return TRUE;
		} 
	}
    
    
    /**
     * [getCustomers description]
     * @return [type] [description]
     */
    function getCustomers()
    {
        return $this->base_model->run_query('SELECT u.*,g.name as role FROM '.DBPREFIX.TBL_USERS.' u,'.DBPREFIX.TBL_USER_GROUPS.' ug,'.DBPREFIX.TBL_GROUPS.' g where u.id=ug.user_id AND ug.group_id=2 AND g.id=ug.group_id');
    }
	
	/**
	 * [getUsers description]
	 * @return [type] [description]
	 */
	function getUsers()
	{
		 return $this->base_model->run_query('SELECT u.*,g.name as role FROM '.DBPREFIX.TBL_USERS.' u,'.DBPREFIX.TBL_USER_GROUPS.' ug,'.DBPREFIX.TBL_GROUPS.' g where u.id=ug.user_id AND ug.group_id!=2 AND g.id=ug.group_id');
	}
     

    /**
     * [getUserDetials description]
     * @param  [type] $user_id [description]
     * @return [type]          [description]
     */
    function getUserDetials($user_id)
    {
        return  $this->base_model->run_query('SELECT u.*,g.name,g.id as role_id FROM '.DBPREFIX.TBL_USERS.' u,'.DBPREFIX.TBL_USER_GROUPS.' ug,'.DBPREFIX.TBL_GROUPS.' g where u.id=ug.user_id AND u.id="'.$user_id.'" AND g.id=ug.group_id');
        
    }
	

	/**
	 * [getAddonGroupsDropdown description]
	 * @return [type] [description]
	 */
	function getAddonGroupsDropdown()
	{
		$addonGroups = $this->base_model->run_query('SELECT ag.adgrp_id,ag.addon_group_name  FROM dn_groups_addons ga,dn_addon_groups ag WHERE ag.adgrp_id=ga.adgrp_id group by ag.adgrp_id');
		$option_data = array(
            '' => 'Select'
        );
		if(!empty($addonGroups)){
			foreach ($addonGroups as $key => $val) {
				$option_data[$val->adgrp_id] = $val->addon_group_name;
			}
  }
		return $option_data;
	}
	

	/**
	 * [getItemAddons description]
	 * @param  [type] $item_id [description]
	 * @return [type]          [description]
	 */
	function getItemAddons($item_id)
	{
		return $this->base_model->get_query_result('SELECT a.*,ia.* FROM '.TBL_PREFIX.TBL_ADDONS.' a,'.TBL_PREFIX.TBL_ITEM_ADDONS.' ia WHERE ia.item_id='.$item_id.' AND a.status="Active" AND ia.addon_id=a.addon_id');
	}
	

	/**
	 * [get_addon_details description]
	 * @param  string $addon_id [description]
	 * @return [type]           [description]
	 */
	function get_addon_details($addon_id = "")
	{
		if(!($addon_id > 0))
			return array();

		$addon_details = $this->db->get_where(TBL_ADDONS, array('addon_id' => $addon_id, 'status' => 'Active'))->row();

		return $addon_details;
	}
	

	/**
	 * [getOfferProducts description]
	 * @param  [type] $offer_id         [description]
	 * @param  string $offer_product_id [description]
	 * @return [type]                   [description]
	 */
	function getOfferProducts($offer_id, $offer_product_id = "")
	{
		$cond1 = "";

		if($offer_product_id > 0)
			$cond1 = " AND op.offer_product_id=".$offer_product_id;

		return $this->base_model->get_query_result('SELECT o.*,op.* FROM '.TBL_PREFIX.TBL_OFFERS.' o,'.TBL_PREFIX.TBL_OFFER_PRODUCTS.' op WHERE op.offer_id='.$offer_id.' AND o.status="Active" AND op.offer_id=o.offer_id  AND op.quantity > 0 '.$cond1.' ');
	}
	

	/**
	 * [getItemOptions description]
	 * @param  [type] $item_id        [description]
	 * @param  string $item_option_id [description]
	 * @return [type]                 [description]
	 */
	function getItemOptions($item_id,$item_option_id='')
	{
		$cond1 = "";
			
		if($item_option_id > 0)
			$cond1 = " AND i.option_id=".$item_option_id." ";
		
		
		$record = $this->base_model->get_query_result("SELECT o.*,i.* FROM ".TBL_PREFIX.TBL_OPTIONS." o inner join ".TBL_PREFIX.TBL_ITEM_OPTIONS." i on o.option_id=i.option_id WHERE i.item_id=".$item_id." AND o.status='Active' ".$cond1." ");
		
		return $record;
	}
	

	/**
	 * [saveUserPoints description]
	 * @param  [type] $user_id          [description]
	 * @param  [type] $points           [description]
	 * @param  [type] $transaction_type [description]
	 * @param  string $order_id         [description]
	 * @param  string $purpose          [description]
	 * @return [type]                   [description]
	 */
	function saveUserPoints($user_id,$points,$transaction_type,$order_id='',$purpose='')
	{
		$user=getUserRec();
		
		$input_data['user_id'] 			= $user_id;
		$input_data['points'] 			= $points;
		$input_data['transaction_type'] = $transaction_type;
		
		$input_data['order_id'] 		= $order_id;
		
		if($order_id > 0)
		{
			$input_data['description'] 	= get_languageword("Points redeemed by buy item Order");
		}
		else
		{
			//signup
			//check for maximum earning points
		}
		
		
		 if($this->base_model->insert_operation($input_data, TBL_USER_POINTS))
		 {
			if($transaction_type=='Earned' && $this->config->item('point_settings')->points_enabled=='Yes')
			{
				$check = $this->check_max_points_reached();
				if($check)
				{
					$this->db->where('id', $user_id);
					$this->db->set('user_points', 'user_points+'.$points, FALSE);
					return $this->db->update($this->db->dbprefix('users'));
				}
				else
					return FALSE;
			}
			else
			{
				if($this->config->item('point_settings')->disabled_redeeming=='No') 
				{
					$this->db->where('id', $user_id);  
					$this->db->set('user_points', 'user_points-'.$points, FALSE);
					return $this->db->update($this->db->dbprefix('users'));
				}
				else
					return FALSE;
			} 
		 }
		 else
			 return FALSE;
	}
	
	
	/**
	 * [check_max_points_reached description]
	 * @return [type] [description]
	 */
	function check_max_points_reached()
	{
		$user = getUserRec();
		if(!empty($user))
		{
			if($user->user_points >= $this->config->item('point_settings')->maximum_earning_points_for_customer)
				return FALSE;
			else
				return TRUE;
		}
		else
			return FALSE;
	}
	
	
	/**
	 * [get_my_orders description]
	 * @param  [type] $offset  [description]
	 * @param  [type] $user_id [description]
	 * @return [type]          [description]
	 */
	function get_my_orders($offset,$user_id)
	{
		$query = "SELECT * FROM ".TBL_PREFIX.TBL_ORDERS." WHERE user_id=".$user_id." ORDER BY order_id DESC";
		
		$this->db->query($query)->result();
		$this->numrows = $this->db->affected_rows();
		
		$query = $query . ' LIMIT '.$offset.','.PER_PAGE;
		
		return $this->db->query($query)->result();
	}
	
	

	/**
	 * [get_user_points description]
	 * @param  [type] $offset  [description]
	 * @param  [type] $user_id [description]
	 * @return [type]          [description]
	 */
	function get_user_points($offset,$user_id)
	{
		$query = "SELECT * FROM ".TBL_PREFIX.TBL_USER_POINTS." WHERE user_id=".$user_id."";
		
		$this->db->query($query)->result();
		$this->numrows = $this->db->affected_rows();
		
		$query = $query . ' LIMIT '.$offset.','.PER_PAGE;
		
		return $this->db->query($query)->result();
	}
	
	/**
	 * [get_count_points description]
	 * @return [type] [description]
	 */
	function get_count_points()
	{
		$this->db->select('user_points');
		$id = $this->ion_auth->get_user_id();
		$result = $this->db->get_where($this->db->dbprefix('users'), array('id' => $id))->result();
		$data = 0;
		if(!empty($result)){
			$data = $result[0]->user_points;
		}
		return $data;
	}
	
	/**
	 * [get_user_total_orders description]
	 * @return [type] [description]
	 */
	function get_user_total_orders()
	{
		$id = $this->ion_auth->get_user_id();
		$result = $this->db->get_where($this->db->dbprefix('orders'), array('user_id' => $id))->result();
		$total_orders = 0;
		if(!empty($result))
		$total_orders = $this->db->affected_rows();
	
		return $total_orders;
	}
}
