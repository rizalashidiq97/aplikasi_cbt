<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Authenticate_cat extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		//Do your magic here
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

	public function index()
	{
		$data['title'] = 'Login Administrative - Sistem Ujian Online Universitas Diponegoro';	
		$this->load->view('auth_backend/auth',$data);
	}

	public function cek_login()
	{
		$data_login = array(
							'username' => $this->input->post('formusername',TRUE),
							'password' => md5($this->input->post('formpassword',TRUE)),
							'grup' => $this->input->post('level',TRUE)
					  );
		$query = $this->mauth->cek_user($data_login);
		$hasil = $query->row();

		if($query->num_rows() === 1){
			$set_sess['id'] = $hasil->id; 
			$set_sess['username'] = $hasil->username;
			$set_sess['id_ruang'] = $hasil->id_ruang;
			$set_sess['periode'] = $hasil->periode;
			$set_sess['grup'] = $hasil->grup;		
			$this->session->set_userdata($set_sess);
			if($hasil->grup == 'administrator'){
				redirect('administrator/dashboard');
			}
			else if($hasil->grup == 'operator ruangan'){
				redirect('operator/dashboard');
			}
			else if($hasil->grup == 'operator utama'){
				redirect('operatorv1/dashboard');
			}
			else{
				exit();
			}
		}
		else{
			$this->session->set_flashdata('gagal', 'cek kembali username dan password anda');
			redirect('authenticate_cat');
		}
	}

}

/* End of file Auth.php */
/* Location: ./application/controllers/Auth.php */