<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Simplecroper {

	private $CI;
	private $error;

	public function __construct(){

		$this->CI =& get_instance();
		$config['image_library'] = 'gd2';
		$config['maintain_ratio'] = FALSE;
		$this->CI->load->library('image_lib', $config);
		$this->error = FALSE;
	}

	public function crop($source_height,$source_width,$source,$final_height,$final_width,$destination){

		$source_ratio = $source_width / $source_height;
		$final_ratio = $final_width / $final_height;

		if($source_ratio < $final_ratio){

			$newheight = $source_width / $final_ratio;

			$config['width'] = $source_width;
			$config['height'] = $newheight;

			$config['y_axis'] = ($source_height - $newheight) / 2;
		}
		elseif ($source_ratio > $final_ratio) {
			$newwidth = $source_height * $final_ratio;

			$config['width'] = $newwidth;
			$config['height'] = $source_height;

			$config['x_axis'] = ($source_width - $newwidth) / 2;
		}
		
		$config['source_image'] = $source;
		$config['new_image'] = $destination;

		if($source_ratio != $final_ratio){

			$this->CI->image_lib->initialize($config);
			if ( ! $this->CI->image_lib->crop()){
				return FALSE;
				$this->error = 'crop failed!';
			}
			else{
				return TRUE;
			}
		}

		$config['width'] = $width;
		$config['height'] = $height;

		$this->CI->image_lib->initialize($config);

		if ( ! $this->CI->image_lib->resize()){
			return FALSE;
			$this->error = 'resize failed!';
		}
		else{
			return TRUE;
		}
	}

	public function get_error(){

		if($this->error){
			return $this->error;
		}
		else{
			return FALSE;
		}
	}

}