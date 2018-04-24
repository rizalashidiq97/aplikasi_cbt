<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Coba extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		// if($this->session->userdata('valid') == FALSE){
		// 	redirect('administrator');
		// }
		$this->load->model('mauth');
		date_default_timezone_set('Asia/Jakarta');
	}

	public function check()
	{
		$hasil = $this->mauth->check();
		$dateTime = new DateTime($hasil->tgl_mulai);
		$tgl_mulai = new DateTime($hasil->tgl_mulai);
		$now = new DateTime("now");
		$mintuesToAdd = $hasil->terlambat;

		echo 'terlambat = '.$dateTime->modify("+{$mintuesToAdd} minutes")->format("Y-m-d H:i:s").'<br>';
		echo 'waktu mulai ='.$tgl_mulai->format("Y-m-d H:i:s").'<br>';
		echo 'sekarang = '.$now->format("Y-m-d H:i:s").'<br>';
		if($tgl_mulai > $now){
			echo "belum saatnya untuk mulai";
		}
		else if($dateTime < $now){
			echo "waktu sudah lewat anda tidak boleh ujian";
		}
		else{
			echo "anda boleh ujian";
		}
	}

	public function test()
	{	
		$opsi = array("a","b","c","d","e");
		if (! ($this->session->has_userdata('acak'))){
			shuffle($opsi);
			$this->session->set_userdata('acak',$opsi);
			$acak = $this->session->userdata('acak');
		}else{
			$acak = $this->session->userdata('acak');
		}

		print_r($acak);
	}

	public function lihat($value='')
	{
		# code...
	}

}

/* End of file Coba.php */
/* Location: ./application/controllers/Coba.php */