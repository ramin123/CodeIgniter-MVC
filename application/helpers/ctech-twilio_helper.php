<?php

if (!class_exists('Services_Twilio')) {
	/**
	 * The main Twilio.php file contains an autoload method for its dependent
	 * classes, we only need to include the one file manually.
	 */
	include_once(APPPATH.'libraries/Services/Twilio.php');
}

/**
 * Return a twilio services object.
 *
 * Since we don't want to create multiple connection objects we
 * will return the same object during a single page load
 *
 * @return object Services_Twilio
 */
function get_twilio_service() {
	static $twilio_service;

	if (!($twilio_service instanceof Services_Twilio)) {
		//initialize the CI super-object
		$_ci =& get_instance();
		$twilio_account_sid = $twilio_auth_token = '';
		/**
		 * This assumes that you've defined your SID & TOKEN as constants
		 * Replace with a way to get your SID & TOKEN if different
		 */
		//$_ci->config->load('ctech-twilio', TRUE);
		$_ci->load->database();
		$query = 'SELECT * FROM '.$_ci->db->dbprefix('system_settings_fields').' sst INNER JOIN '.$_ci->db->dbprefix('sms_gate_ways').' ssf ON sst.sms_gateway_id = ssf.sms_gateway_id WHERE ssf.sms_gateway_name = "Twilio" ORDER BY field_name';		
		$gateway_details = $_ci->base_model->fetch_records_from_query_object( $query );
		//echo "<pre>";
		//print_r($gateway_details); 
		if(count($gateway_details) > 0) {
			foreach($gateway_details as $selectedgateway) {
				switch(strtolower($selectedgateway->field_key))
				{
					case 'account_sid':
						$twilio_account_sid = $selectedgateway->field_output_value;
					break;
					case 'auth_token':
						$twilio_auth_token = $selectedgateway->field_output_value;
					break;
					case 'api_version':
						$twilio_api_version = $selectedgateway->field_output_value;
					break;
					case 'Twilio_Phone_Number':
						$twilio_number = $selectedgateway->field_output_value;
					break;
				}						
			}
		}
		//echo $twilio_account_sid; 
		//echo $twilio_auth_token; 
		//die();
		$twilio_service = new Services_Twilio($twilio_account_sid, $twilio_auth_token);
		//echo "Good"; die();
	}

	return $twilio_service;
}

function get_twilio_pricing_service() {
	static $twilio_pricing_service;

	if (!($twilio_pricing_service instanceof Services_Twilio)) {
		//initialize the CI super-object
		$_ci =& get_instance();
		$twilio_account_sid = $twilio_auth_token = '';
		
		$_ci->load->database();
		$query = 'SELECT * FROM '.$_ci->db->dbprefix('gateways').' g INNER JOIN '.$_ci->db->dbprefix('gateways_fields').' gf ON g.`gateway_id`=gf.`gateway_id` LEFT JOIN '.$_ci->db->dbprefix('gateways_fields_values').' gfv ON gf.`field_id` = gfv.`gateway_field_id` WHERE g.`gateway_title`="Twilio" ORDER BY gf.field_order ASC';		
		$gateway_details = $_ci->base_model->fetch_records_from_query_object( $query );
		if(count($gateway_details) > 0) {
			foreach($gateway_details as $selectedgateway) {
				switch($selectedgateway->field_key)
				{
					case 'account_sid':
						$twilio_account_sid = $selectedgateway->gateway_field_value;
					break;
					case 'auth_token':
						$twilio_auth_token = $selectedgateway->gateway_field_value;
					break;
					case 'api_version':
						$twilio_api_version = $selectedgateway->gateway_field_value;
					break;
					case 'number':
						$twilio_number = $selectedgateway->gateway_field_value;
					break;
				}						
			}
		}
		$twilio_pricing_service = new Pricing_Services_Twilio($twilio_account_sid, $twilio_auth_token);
	}

	return $twilio_pricing_service;
}

?>