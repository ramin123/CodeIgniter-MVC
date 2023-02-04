<?php
/*
	Class to send push notifications using One Signal

	Example usage
	-----------------------
	$an = new OneSignalPush();
	$an->setDevices($devices);
	$response = $an->send($message);
	-----------------------
	
	$apiKey Your One Signal api key
	$appId is your One Signal app id
	$devices An array or string of registered device tokens
	$message The mesasge you want to push out

	@author Gollapalli John Peter
	@Date  30-09-2016
	
	

*/
class OneSignalPush {
	var $url = 'https://onesignal.com/api/v1/notifications';
	var $serverApiKey;
	var $appId;
	var $devices = array();
	
	public function __construct(){
		$CI =& get_instance();
		$this->serverApiKey = $CI->config->item('site_settings')->one_signal_server_api_key; 
		
		$this->appId = 
		$CI->config->item('site_settings')->one_signal_app_id;  
	}
	
	function setDevices($deviceIds){
	
		if(is_array($deviceIds)){
			$this->devices = $deviceIds;
		} else {
			$this->devices = array($deviceIds);
		}
	
	}
	
	/*
		Send the message to the device
		@param $message The message to send
		@param $data Array of data to accompany the message
	*/
	function send($content=array(), $data = array()){
				
		if(!is_array($this->devices) || count($this->devices) == 0){
			$this->error("No devices set");
		}
		
		if(strlen($this->appId) < 8){
			$this->error("Server API Key not set");
		}
		
		
		
		$fields = array(
			'app_id'  => $this->appId,
			'include_player_ids'  => $this->devices,
			'data'=>$data,
			'contents'=>$content,
		);
										
		$headers = array( 
			'Authorization: Basic=' . $this->serverApiKey,
			'Content-Type: application/json; charset=utf-8'
		);
		
		$ch = curl_init();
		
		// Set the url, number of POST vars, POST data
		curl_setopt( $ch, CURLOPT_URL, $this->url );
		
		curl_setopt( $ch, CURLOPT_POST, true );
		curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		
		curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode( $fields ) );
		
		// Avoids problem with https certificate
		curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false);
		
		// Execute post
		$result = curl_exec($ch);
		
		// Close connection
		curl_close($ch);
		
		return $result;
	}
	
	// send notifications to all active users
	
	function sendToAll($content = array(),$data =  array())
	{
				
		if(strlen($this->appId) < 8){
			$this->error("Server API Key not set");
		}
		
		$fields = array(
			'app_id'  => $this->appId,
			'included_segments' => array('Active Users'),
			'data'=>$data,
			'contents'=>$content,
		);
										
		$headers = array( 
			'Authorization: Basic ' . $this->serverApiKey,
			'Content-Type: application/json; charset=utf-8'
		);
		
		$ch = curl_init();
		
		// Set the url, number of POST vars, POST data
		curl_setopt( $ch, CURLOPT_URL, $this->url );
		
		curl_setopt( $ch, CURLOPT_POST, true );
		curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		
		curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode( $fields ) );
		
		// Avoids problem with https certificate
		curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false);
		
		// Execute post
		$result = curl_exec($ch);
		
		// Close connection
		curl_close($ch);
		
		return $result;
	}
	
	function viewNotifications()
	{
		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => $this->url."?app_id=".$this->appId."&limit=50&offset=0",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "GET",
		  CURLOPT_HTTPHEADER => array(
			"authorization: Basic  ". $this->serverApiKey,
		  ),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);
		return $response;
		
	}
	
	function error($msg){
		echo "Android send notification failed with error:";
		echo "\t" . $msg;
		exit(1);
	}
}