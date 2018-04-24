<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Operator extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if(!($this->session->userdata('id'))){
			redirect('auth');
		}
		else if($this->session->userdata('grup') == 'operator utama'){
			redirect('operatorv1/dashboard');
		}
		else if($this->session->userdata('grup') == 'administrator'){
			redirect('administrator/dashboard');
		}
		else if($this->session->userdata('id_peserta')){
			redirect('peserta/home');
		}

		$this->sess_id = $this->session->userdata('id');
		$this->sess_ruang = $this->session->userdata('id_ruang');
		$this->periode = $this->session->userdata('periode');
		$this->grup = $this->session->userdata('grup');
		$this->user = $this->session->userdata('username');
		$this->load->model('moperator');

	}

	public function home()
	{
		$a['user'] = $this->user;
		$a['grup'] = $this->grup;
		$a['v'] = 'operator/home';
		$a['title'] = 'Home - Sistem Ujian Online Universitas Diponegoro'; 
		$this->load->view('operator/header_footer',$a);
	}

	public function rubah_password()
	{
		$uri3 = $this->uri->segment(3);
		$id = $this->sess_id;
		if($uri3 == 'simpan'){
			$username = $this->input->post('username',TRUE);
			$pass_lama = $this->input->post('pass_lama',TRUE);
			$pass_baru = $this->input->post('pass_baru',TRUE);
			$pass_konf = $this->input->post('konf_baru',TRUE);
			$cek_pass = $this->moperator->getDataUser($id)->row();
			if($cek_pass->password != md5($pass_lama)){
				$return["status"] = "gagal";
				$return["msg"] = "password lama tidak sama..";
			}
			else if($pass_baru != $pass_konf){
				$return["status"] = "gagal";
				$return["msg"] = "password konfirmasi tidak sama..";
			}
			else if(strlen($pass_baru) < 8){
				$return["status"] = "gagal";
				$return["msg"] = "password yang diisi minimal 8 karakter...";
			}else{
				$data = array(
					'username' => $username,
					'password' => md5($pass_konf)
				);
				$this->moperator->update_pass($id,$data);
				$return["status"] = "ok";
				$return["msg"] = "Update Password Berhasil !";
			}
			json_send($return);
			exit();
		}
		else{
			$hasil = $this->moperator->getDataUser($id)->row();
			$fetch = $hasil->username;
			$return['data'] = $fetch;
			json_send($return);
			exit();
		}
	}

	public function dashboard()
	{
		$uri3 = $this->uri->segment(3);
		$id =  $this->sess_ruang;
		$sess_periode = $this->periode;

		if($uri3 == "progress"){
			$hasil = $this->moperator->getDataLogin($id,$sess_periode)->row();
			if($hasil->semua == '0'){
				$persentase = 0;
				$data['persentase'] = '<div role="progressbar" style="width: '.$persentase.'%" aria-valuenow="'.$persentase.'" aria-valuemin="0" aria-valuemax="100" class="progress-bar progress-bar bg-primary"></div>';
				$data['logged_in'] = 0;
				$data['newvisit'] = '<span>Persentase</span><strong>'.$persentase.'%</strong>';
			}
			else{
				$logged = $hasil->logged;
				$semua = $hasil->semua;
				$persentase = round(($logged/$semua)*100,2);
				$data['persentase'] = '<div role="progressbar" style="width: '.$persentase.'%" aria-valuenow="'.$persentase.'" aria-valuemin="0" aria-valuemax="100" class="progress-bar progress-bar bg-primary"></div>';
				$data['logged_in'] = $logged;
				$data['newvisit'] = '<span>Persentase</span><strong>'.$persentase.'%</strong>';
			}

			json_send($data);
			exit();
		}
		else{
			$a['user'] = $this->user;
			$a['grup'] = $this->grup;
			$a['sess_ruang'] = $this->sess_ruang;
			$a['periode'] = $this->periode; 
			$a['v'] = 'operator/dashboard';
			$a['title'] = 'Dashboard - Sistem Ujian Online Universitas Diponegoro'; 
			$this->load->view('operator/header_footer',$a);
		}
	}

	public function detail_peserta()
	{
		$uri3 = $this->uri->segment(3);

		if($uri3 == "data-list"){
			$draw = $this->input->post('draw',TRUE);
			$search = $this->input->post('search',TRUE);
			$length = $this->input->post('length',TRUE);
			$start = $this->input->post('start',TRUE);

			$sess = array('ruang.id_ruang' => $this->sess_ruang,'peserta.periode' => $this->periode);

			$hasil = $this->moperator->getDetailPeserta($search,$length,$start,$sess);

			$send_data = array();
			$i = ($start + 1);
        	foreach ($hasil as $row) {
	            $data = array();
	            $data[] = $i++;
	            $data[] = $row->nama;
	            $data[] = $row->no_peserta;
	            $data[] = $row->no_kursi;
	            $data[] = $row->periode;
	            if($row->status == '0'){
	            	$data[] = 'belum login';
	            }
	            else{
	            	$data[] = 'sudah login';
	            }
            	$send_data[] = $data;
        	}

        	$output = array(
                        "draw" => intval($draw),
                        "recordsTotal" => $this->moperator->getAllDetailPeserta($sess),
                        "recordsFiltered" => $this->moperator->getFilteredDatailedPeserta($search,$length,$start,$sess),
                        "data" => $send_data
                );

			json_send($output);
	       	exit();
		}
		else{
			$a['user'] = $this->user;
			$a['grup'] = $this->grup;
			$a['v'] = 'operator/detail_peserta';
			$a['title'] = 'Data Peserta - Sistem Ujian Online Universitas Diponegoro';
			$this->load->view('operator/header_footer',$a);
		}
	}

	public function list_peserta()
	{
		$uri3 = $this->uri->segment(3);
		$uri4 = $this->uri->segment(4);

		$sess_id = $this->sess_ruang;
		$sess_periode = $this->periode;

		if($uri3 == "data-list"){
			$draw = $this->input->post('draw',TRUE);
			$search = $this->input->post('search',TRUE);
			$length = $this->input->post('length',TRUE);
			$start = $this->input->post('start',TRUE);

			$sess = array('ruang.id_ruang' => $sess_id,'peserta.periode' => $sess_periode);

			$hasil = $this->moperator->getListPeserta($search,$length,$start,$sess);

			$send_data = array();
			$i = ($start + 1);
        	foreach ($hasil as $row) {
	            $data = array();
	            $data[] = $i++;
	            $data[] = $row->nama;
	            $data[] = $row->no_peserta;
	            $data[] = $row->periode;
	            $data[] = '<a href="'.base_url().'operator/list_peserta/tulis_laporan/'.$row->id.'" class="btn btn-info btn-sm"><i class="fa fa-eye" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Tulis Laporan</a>';
            	$send_data[] = $data;
        	}

        	$output = array(
                        "draw" => intval($draw),
                        "recordsTotal" => $this->moperator->getAllDataPeserta($sess),
                        "recordsFiltered" => $this->moperator->getDataFilteredListPeserta($search,$length,$start,$sess),
                        "data" => $send_data
                );

			json_send($output);
	       	exit();
		}
		else if($uri3 == "tulis_laporan"){
			$id = $uri4;
			$data_check = array(
				'ruang.id_ruang' => $this->sess_ruang,
				'peserta.periode' => $this->periode,
				'peserta.id' => $id
			);
			$check = $this->moperator->checkdataExist($data_check);
			if($check->num_rows() < 1){
				redirect('operator/404');
			}
			else{
				$hasil = $this->moperator->getIsiLaporan($id);
				$fetch = $hasil->row();
				$num_rows = $hasil->num_rows();
				if($num_rows == 0){
					$a['isi'] = "";
				}
				else{
					$a['isi'] = $fetch->laporan;
				}
				$a['user'] = $this->user;
				$a['grup'] = $this->grup;
				$a['username'] = $check->row()->nama;
				$a['no_peserta'] = $check->row()->no_peserta;
				$a['id_unik'] = $id;
				$a['v'] = 'operator/tulis_laporan';
				$a['title'] = 'Data Laporan - Sistem Ujian Online Universitas Diponegoro'; 
			}
		}
		else if($uri3 == "simpan_laporan"){
			$id = $this->input->post('id_laporan',TRUE);
			$post = $this->input->post('laporanpeserta',TRUE);
			$data_check_1 = array(
				'ruang.id_ruang' => $this->sess_ruang,
				'peserta.periode' => $this->periode,
				'peserta.id' => $id
			);
			$check_1 = $this->moperator->checkdataExist($data_check_1);

			$data_check = array('laporan.id_user' => $id);
			$check = $this->moperator->checkDataLaporan($data_check);

			if($check_1->num_rows() < 1){
				$this->session->set_flashdata('gagal', 'maaf inputan tidak valid');
				redirect('operator/list_peserta/tulis_laporan/'.$id.'');
			}
			else if($post == ''){
				$this->session->set_flashdata('gagal', 'maaf inputan harus diisi');
				redirect('operator/list_peserta/tulis_laporan/'.$id.'');
			}
			else{
				if($check->num_rows() == 0){
					$this->moperator->InsertLaporan($id,$post);
					$this->session->set_flashdata('sukses','data berhasil disimpan !');
					redirect('operator/list_peserta/tulis_laporan/'.$id.'');
				}
				else{
					$this->moperator->UpdateLaporan($id,$post);
					$this->session->set_flashdata('sukses','data berhasil di edit !');
					redirect('operator/list_peserta/tulis_laporan/'.$id.'');
				}
			}
		}
		else{
			$a['user'] = $this->user;
			$a['grup'] = $this->grup;
			$a['v'] = 'operator/list_peserta';
			$a['title'] = 'List Peserta - Sistem Ujian Online Universitas Diponegoro'; 
		}	

		$this->load->view('operator/header_footer',$a);
	}

	public function logout()
	{
		$this->session->sess_destroy();
		redirect("authenticate_cat",'refresh');
	}
}

/* End of file Operator.php */
/* Location: ./application/controllers/Operator.php */