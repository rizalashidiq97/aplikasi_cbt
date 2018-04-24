<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Importimage extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if(!($this->session->userdata('id'))){
			redirect('auth');
		}
		else if($this->session->userdata('grup') == 'operator ruangan'){
			redirect('operator/dashboard');
		}
		else if($this->session->userdata('grup') == 'operator utama'){
			redirect('operatorv1/dashboard');
		}
		else if($this->session->userdata('id_peserta')){
			redirect('peserta/home');
		}
		
		//Do your magic here
	}

	public function upload()
	{
		require_once(APPPATH.'third_party/wysiwyg-editor-php-sdk-master/lib/FroalaEditor.php');

		$buat_folder_temp = !is_dir("./upload/gambar/") ? @mkdir("./upload/gambar/") : false;
		$options = array(
		  'validation' => array(
		      'allowedExts' => array('gif', 'jpeg', 'jpg', 'png', 'svg', 'blob'),
		      'allowedMimeTypes' => array('image/gif', 'image/jpeg', 'image/pjpeg', 'image/x-png', 'image/png', 'image/svg+xml')
		  )
		);
		try {
		  $response = FroalaEditor_Image::upload('/Aplikasi_CBT/upload/gambar/',$options);
		  echo stripslashes(json_encode($response));
		} 
		catch (Exception $e) {
		  echo $e->getMessage();
		  http_response_code(404);
		}
	}

	public function uploadsoal()
	{
		require_once(APPPATH.'third_party/wysiwyg-editor-php-sdk-master/lib/FroalaEditor.php');

		$buat_folder_temp = !is_dir("./upload/gambarsoal/") ? @mkdir("./upload/gambarsoal/") : false;
		$options = array(
		  'validation' => array(
		      'allowedExts' => array('gif', 'jpeg', 'jpg', 'png', 'svg', 'blob'),
		      'allowedMimeTypes' => array('image/gif', 'image/jpeg', 'image/pjpeg', 'image/x-png', 'image/png', 'image/svg+xml')
		  )
		);
		try {
		  $response = FroalaEditor_Image::upload('/Aplikasi_CBT/upload/gambarsoal/',$options);
		  echo stripslashes(json_encode($response));
		} 
		catch (Exception $e) {
		  echo $e->getMessage();
		  http_response_code(404);
		}
	}
}

/* End of file Importimage.php */
/* Location: ./application/controllers/Importimage.php */