<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Authpeserta extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if($this->session->userdata('grup') == 'administrator'){
			redirect('administrator/dashboard');
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
		$this->load->model('mauth');
	}

	public function login()
	{
		$a['title'] = 'Login Peserta - Sistem Ujian Online Universitas Diponegoro';
		$this->load->view('peserta/login',$a);
	}

	public function cek_login_peserta()
	{
		$data_login = array(
			'no_peserta' => $this->input->post('formusername',TRUE),
			'tgl_lahir' => $this->input->post('formpassword',TRUE),
		);

		$query = $this->mauth->cek_user_peserta($data_login);
		$hasil = $query->row();

		if($query->num_rows() === 1){
			$set_sess['id_peserta'] = $hasil->id; //$hasil['id']
			$set_sess['nama_peserta'] = $hasil->nama;
			$set_sess['no_peserta'] = $hasil->no_peserta;
			$set_sess['kursi_peserta'] = $hasil->no_kursi;	
			$this->session->set_userdata($set_sess);
			$this->mauth->update_status($data_login);
			redirect('peserta/home');
		}
		else{
			$this->session->set_flashdata('gagal', 'cek kembali username dan password anda');
			redirect(base_url());
		}
	}

}

/* End of file Peserta.php */
/* Location: ./application/controllers/Peserta.php */