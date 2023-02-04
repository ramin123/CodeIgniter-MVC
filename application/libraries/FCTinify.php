<?php defined('BASEPATH') OR exit('No direct script access allowed');
/*
	Class to send image to tinify to Resize Images or Compressing images the image

	Example usage
	-----------------------
	$an = new FCTinify();
	$an->imageResize($from,$source,$dest,$width,$height,$method);
	-----------------------
	
	$apiKey Your Tinify api key
	@author Gollapalli John Peter
	@Date  23-09-2017
	
	CODEIGNETER LIBRARY

*/
require_once("tinify/Tinify/Exception.php");
require_once("tinify/Tinify/ResultMeta.php");
require_once("tinify/Tinify/Result.php");
require_once("tinify/Tinify/Source.php");
require_once("tinify/Tinify/Client.php");
require_once("tinify/Tinify.php");

class FCTinify {
	var $serverApiKey;
	public function __construct(){
		$CI =& get_instance();
		$this->serverApiKey = $CI->config->item('tinify_settings')->API_Key; 
		\Tinify\setKey($this->serverApiKey);
	}	
	
	/*
	* Function name : imageResize
	* Params $from: from can be  url or file	
	* 		 $source: source url of file	
	*        $destination : Destination where file need to be saved
	*        $width       : width of the file need to be resize ex:150,200 
	*        $height      : height of the file need to be resize ex:150,200 
	*        $method      : Methods available are scale,fit and cover
	*      Scale: Scales the image down proportionally. You must provide either a target width or a target height, but not both. The scaled image will have exactly the provided width or height	
	*     Fit : Scales the image down proportionally so that it fits within the given dimensions. You must provide both a width and a height. The scaled image will not exceed either of these dimensions.
	*    Cover : Scales the image proportionally and crops it if necessary so that the result has exactly the given dimensions. You must provide both a width and a height. Which parts of the image are cropped away is determined automatically. An intelligent algorithm determines the most important areas and leaves these intact.
	*/
	
	function imageResize($sourch,$destination,$width,$height,$method)
	{
		
		$source =  \Tinify\fromUrl($sourch);
		
		if($method=='scale'){
			if($width!='' && $height!=''){
				$resized = $source->resize(array(
				"method" => $method,
				"width" => $width
			));
			}
		}else{
						
			$resized = $source->resize(array(
				"method" => $method,
				"width" => $width,
				"height" => $height
			));
		}
		$resized->toFile($destination);
		
		return $resized;
			
		
	}
	
	/***IMAGE COMPRESSING ****/
	function imageCompress($source,$destination)
	{
		$source = \Tinify\fromUrl($source);
		$result = $source->toFile($destination);
		return $result;
	}
	
	
	/***TO GET THE COMPRESSION COUNT FOR THE MONTH****/
	
	function tinifyCompressionCount()
	{
		\Tinify\validate();
		$compressionsThisMonth = \Tinify\compressionCount();
		return $compressionsThisMonth;
		
	}
}