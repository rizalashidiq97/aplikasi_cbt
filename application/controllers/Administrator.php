<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Administrator extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		//Do your magic here
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
		$this->load->model('madmin');
		$this->load->helper('datatables_helper');
		date_default_timezone_set("Asia/Jakarta");
	}

	public function dashboard()
	{
		$uri3 = $this->uri->segment(3);
		if($uri3 == "data"){
			$draw = $this->input->post('draw',TRUE);
			$search = $this->input->post('search',TRUE);
			$length = $this->input->post('length',TRUE);
			$start = $this->input->post('start',TRUE);
			$order = $this->input->post('order',TRUE);

			$hasil = $this->madmin->getDataRekap($search,$length,$start,$order);

			$send_data = array();
			$i = ($start + 1);
        	foreach ($hasil as $row) {
	            $data = array();
	            $data[0] = $i++;
	            $data[1] = $row->pilih_prodi;
	            $data[2] = $row->jumlah."  peserta";
            	$send_data[] = $data;
        	}

        	$output = array(
                        "draw" => intval($draw),
                        "recordsTotal" => $this->madmin->getAllDataRekap(),
                        "recordsFiltered" => $this->madmin->getDataFilteredRekap($search,$length,$start,$order),
                        "data" => $send_data
                );

			json_send($output);
	       	exit();
		}
		else if($uri3 == "progress"){
			$hasil = $this->madmin->LoginData()->row();
			if($hasil->semua == '0'){
				$persentase = 0;
				$data['persentase'] = '<div role="progressbar" style="width: '.$persentase.'%" aria-valuenow="'.$persentase.'" aria-valuemin="0" aria-valuemax="100" class="progress-bar progress-bar bg-primary"></div>';
				$data['logged_in'] = 0;
				$data['newvisit'] = '<span>Persentase</span><strong>'.$persentase.'%</strong>';
				$data['semua'] = 0;
			}
			else{
				$logged = $hasil->logged;
				$semua = $hasil->semua;
				$persentase = round(($logged/$semua)*100,2);
				$data['persentase'] = '<div role="progressbar" style="width: '.$persentase.'%" aria-valuenow="'.$persentase.'" aria-valuemin="0" aria-valuemax="100" class="progress-bar progress-bar bg-primary"></div>';
				$data['logged_in'] = $logged;
				$data['newvisit'] = '<span>Persentase</span><strong>'.$persentase.'%</strong>';
				$data['semua'] = $semua;
			}
			json_send($data);
			exit(); 
		}
		else{
			$hasil = $this->madmin->getCountSoal();
			$a = array(
				'username' => $this->session->userdata('username'),
				'grup' => strtoupper($this->session->userdata('grup')),
				'title' => 'Dashboard - Sistem Ujian Online Universitas Diponegoro',
				'v' => 'admin/dashboard_admin',
				'exist_data' =>$hasil->num_rows(),
				'data' => $hasil->result()
			);
		}

		$this->load->view('admin/header_footer',$a);
	}

	public function datapeserta(){

		$uri3 = $this->uri->segment(3);
		$uri4 = $this->uri->segment(4);

		if($uri3 == "fetch_data_peserta"){
			$draw = $this->input->post('draw',TRUE);
			$search = $this->input->post('search',TRUE);
			$length = $this->input->post('length',TRUE);
			$start = $this->input->post('start',TRUE);
			$order = $this->input->post('order',TRUE);

			$hasil = $this->madmin->getDataPeserta($search,$length,$start,$order);

			$send_data = array();

        	foreach ($hasil as $row) {
	            $data = array();
	            $data[] = $row->id;
	            $data[] = $row->nama;
	            $data[] = $row->no_peserta;
	            $data[] = $row->no_kursi;
	            $data[] = $row->periode;
	            $data[] = $row->kode_prodi;
	            $data[] = $row->pilih_prodi;
	            $data[] = $row->tgl_lahir;
	            $data[] = 
	            		 '<a href="#" onclick="return m_siswa_e('.$row->id.');" class="btn btn-info btn-sm" ><i class="fa fa-pencil" style="margin-left: 0px"></i> &nbsp;&nbsp;Edit</a>
                          <button onclick="return m_siswa_h('.$row->id.');" class="btn btn-danger btn-sm"><i class="fa fa-remove" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Hapus</button>
                         ';
            	$send_data[] = $data;
        	}
        	$output = array(
                        "draw" => intval($draw),
                        "recordsTotal" => $this->madmin->getAllDataPeserta(),
                        "recordsFiltered" => $this->madmin->getDataFilteredPeserta($search,$length,$start,$order),
                        "data" => $send_data
                );
			json_send($output);
	       	exit();
		}
		else if($uri3 == "editdatapeserta"){
			$id['id'] = $uri4;
			if($uri4 == 0){
				$data['judul'] = "Tambah Data Peserta";
				$data['data']['id'] = "ok";
			}
			else{
				$data['judul'] = "Edit Data Peserta";
				$data['data'] = $this->madmin->getEditDataPeserta($id)->row();
			}
			json_send($data);
			exit();
		}
		else if($uri3 == "simpan_data_peserta"){
			$ket ="";
			if($this->input->is_ajax_request()){
				$input_no_peserta = $this->input->post('nopeserta',TRUE);
				$data = array(
					'nama' => strtoupper($this->input->post('nama',TRUE)),
					'periode' => strtoupper($this->input->post('periode',TRUE)),
					'no_peserta' => $input_no_peserta,
					'no_kursi' => $this->input->post('nokursi',TRUE),
					'kode_prodi'=> $this->input->post('kodeprodi',TRUE),
					'pilih_prodi' => strtoupper($this->input->post('pilihprodi',TRUE)),
					'tgl_lahir' => $this->input->post('tgllahir',TRUE)
				);

				$id = $this->input->post('id',TRUE);
				//cek akun ganda
				$check_data = array('no_peserta' => $input_no_peserta);
				$check_ganda = $this->madmin->getEditDataPeserta($check_data)->num_rows();
				$get_data = $this->madmin->getEditDataPeserta(array('id' => $id))->row();

				if($id != 0){
					if($get_data->no_peserta == $input_no_peserta || $check_ganda == 0){
						$this->madmin->DoEditDataPeserta($data,$id);
						$ket = "edit data peserta berhasil";
						$status = "ok";
					}
					else{
						$ket = "akun ini sudah dipakai...";
						$status = "gagal";
					}	
				}
				else{
					if($check_ganda == 0){
						$this->madmin->DoInsertDataPeserta($data);
						$ket = "tambah data peserta berhasil";
						$status = "ok";
					}
					else{
						$ket = "akun ini sudah dipakai...";
						$status = "gagal";
					}
				}
				$return['status'] 	= $status;
				$return['caption']	= $ket;
				json_send($return);
				exit();
			}
			else{
				redirect('administrator/404');
			}
		}
		else if($uri3 == "hapus_Data_Peserta"){
			if($this->input->is_ajax_request()){
				$id = $uri4;
				$this->madmin->DoDeleteDataPeserta($id);
				$return['status'] 	= "ok";
				$return['caption']	= "hapus peserta berhasil";
				json_send($return);
				exit();
			}
			else{
				redirect('administrator/error/403');
			}
		}
		else if($uri3 == "HaPus_D4ta_aLL"){
			if($this->input->is_ajax_request()){
				$this->madmin->DeleteAllDataPeserta();
				$return['status'] 	= "ok";
				$return['caption']	= "semua data berhasil terhapus!";
				json_send($return);
				exit();
			}
			else{
				redirect('administrator/404');
			}	
		}
		else if($uri3 == "import"){
			$p['title'] = 'Import Data Peserta - Sistem Ujian Online Universitas Diponegoro';	
			$p['v'] = "admin/import_peserta" ;
			$p['username'] = $this->session->userdata('username');
			$p['grup'] = strtoupper($this->session->userdata('grup'));
		}
		else if($uri3 == 'akun_ganda'){
			if($this->input->is_ajax_request()){
				$fetch_model = $this->madmin->check_ganda_akun();
				$hasil = $fetch_model->result();
				$num_rows = $fetch_model->num_rows();
				$html = "";
				if($num_rows == 0){
					$html .= "Sudah tidak ada lagi akun ganda";
				}
				else{
					foreach ($hasil as $key) {
						$html .= '<div class="row" style="padding: 6px;">';
						$html .= '<div class="col-md-3" style="padding-top: 8px;font-size: 0.9em;">'.$key->no_peserta.' <div class="pull-right">:</div></div>';
						$html .= '<div class="col-md-9" style="padding-top: 8px;font-size: 0.9em;padding-left: 0;">'.$key->jml.' akun</div>';
						$html .= '</div>';
					}
				}
				
				$return['data'] = $html;
				json_send($return);
				exit();
			}else{
				redirect('administrator/404');
			}
		}
		else{
			$p['check_ganda'] = $this->madmin->check_ganda_akun()->num_rows();
			$p['username'] = $this->session->userdata('username');
			$p['grup'] = strtoupper($this->session->userdata('grup'));
			$p['title'] = 'Data Peserta - Sistem Ujian Online Universitas Diponegoro';	
			$p['v'] = "admin/data_peserta" ;
		}
		
		$this->load->view('admin/header_footer',$p);
	}
	
	public function soaltrial()
	{
		$uri3 = $this->uri->segment(3);
		$uri4 = $this->uri->segment(4);
		$uri5 = $this->uri->segment(5);

		//$post = json_decode(file_get_contents('php://input'));
		if($uri3 == "look_all_d4t4"){
			$draw = $this->input->post('draw',TRUE);
			$search = $this->input->post('search',TRUE);
			$length = $this->input->post('length',TRUE);
			$start = $this->input->post('start',TRUE);
			$order = $this->input->post('order',TRUE);
			$category = $this->input->post('data',TRUE);

			$hasil = $this->madmin->getDataSoalTrial($search,$length,$start,$order,$category);

			$send_data = array();
			$i = $start + 1;
			foreach ($hasil as $row) {
	            $data = array();
	            $data[] = $i++;
	            $data[] = tampil_jawaban($row->soal);
	            $data[] = $row->kategori;
	            $data[] = $row->jawaban;
	            $data[] = 
	            		 '<a href="'.base_url().'administrator/soaltrial/edit/'.$row->id.'" class="btn btn-info btn-sm" ><i class="fa fa-pencil" style="margin-left: 0px"></i> &nbsp;&nbsp;Edit</a>
                          <button href="#" onclick="return soaltrial_h('.$row->id.');" class="btn btn-danger btn-sm"><i class="fa fa-remove" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Hapus</button>
                         ';
            	$send_data[] = $data;
        	}

        	$output = array(
                        "draw" => intval($draw),
                        "recordsTotal" => $this->madmin->getAllDataSoalTrial(),
                        "recordsFiltered" => $this->madmin->getDataFilteredSoalTrial($search,$length,$start,$order,$category),
                        "data" => $send_data
                );
			json_send($output);
	       	exit();
		}
		else if($uri3 == "hapus"){
			if($this->input->is_ajax_request()){
				$id = $uri4;
				$this->madmin->DoDeleteSoalTrial($id);
				$data['status'] = 'ok';
				$data['caption'] = 'data berhasil dihapus';
				json_send($data);
				exit();
			}
			else{
				redirect('administrator/404');
			}
		}
		else if($uri3 == "edit"){
			$hasil = $this->madmin->getDatakategori()->result();
			$p['kategori'] = object_to_array($hasil,"id,kategori");
			$p['huruf_opsi'] = array("A","B","C","D");

			if($uri4 == '0'){
				$p['data'] = array(
					'mode'=>'add' ,'id'=>'0', 'kategori' => '', 'soal' => '','opsi_a' => '' , 
					'opsi_b' => '' , 'opsi_c' => '', 'opsi_d' => '', 'jawaban' => ''
				);
				$p['username'] = $this->session->userdata('username');
				$p['grup'] = strtoupper($this->session->userdata('grup'));
				$p['judul'] = 'Tambah Data Soal Trial';
			}else{
				$d['id'] = $uri4;
				$hasil = $this->madmin->getExistDataSoalTrial($d);
				if($hasil->num_rows() == 0){
					redirect('administrator/error/404');
				}
				else{
					$edittrial = $hasil->row_array();
					$p['data'] = array(
						'mode'=>'edit' ,'id' => $edittrial['id'] ,'kategori' => $edittrial['kategori'], 
						'soal' => $edittrial['soal'],'opsi_a' => $edittrial['opsi_a'] , 
						'opsi_b' => $edittrial['opsi_b'] , 'opsi_c' => $edittrial['opsi_c'], 
						'opsi_d' => $edittrial['opsi_d'] , 'jawaban' => $edittrial['jawaban']
					);
					$p['username'] = $this->session->userdata('username');
					$p['grup'] = strtoupper($this->session->userdata('grup'));
					$p['judul'] = 'Edit Data Soal Trial';
				}
			}

			$p['title'] = 'Edit Soal Trial - Sistem Ujian Online Universitas Diponegoro';
			$p['v'] = "admin/edit_soal_trial";
		}
		else if($uri3 == "importtrial"){
			$p['username'] = $this->session->userdata('username');
			$p['grup'] = strtoupper($this->session->userdata('grup'));
			$p['title'] = 'Import Soal Trial - Sistem Ujian Online Universitas Diponegoro';
			$p['v'] = "admin/importtrial";
		}
		else if($uri3 == "simpan"){
			$data = array(
				'kategori' => $this->input->post('kategori',TRUE),
				'soal' => $this->input->post('soal'),
				'opsi_a' => $this->input->post('opsia'),
				'opsi_b' => $this->input->post('opsib'),
				'opsi_c' => $this->input->post('opsic'),
				'opsi_d' => $this->input->post('opsid'),
				'jawaban'=> $this->input->post('jawaban',TRUE)
			);
			$id = $this->input->post('id',TRUE);
			if($data['soal'] == '' || $data['jawaban'] == ''){
				$this->session->set_flashdata('gagal','Maaf data soal dan jawaban harus diisi');
				redirect('administrator/soaltrial/edit/'.$id.'');
			}else if($data['opsi_a'] == '' || $data['opsi_b'] == '' || $data['opsi_c'] == '' || $data['opsi_d'] == ''){
				$this->session->set_flashdata('gagal','Maaf opsi harus diisi');
				redirect('administrator/soaltrial/edit/'.$id.'');
			}else{
				if($id == '0'){
					$this->madmin->InsertSoalTrial($data);
					$this->session->set_flashdata('sukses','Data berhasil ditambah');
					redirect('administrator/soaltrial');
				}else{
					$this->madmin->UpdateSoalTrial($data,$id);
					$this->session->set_flashdata('sukses','Data berhasil di edit');
					redirect('administrator/soaltrial');
				}
			}
		}
		else if($uri3 == "hapus_all"){
			if($this->input->is_ajax_request()){
				$this->madmin->DeleteAllDataSoalTrial();
				$files = glob('./upload/gambar/*'); //get all file names
				foreach($files as $file){
				    if(is_file($file)){
				    	unlink($file);
				    } //delete file
				}
				$return['status'] 	= "ok";
				$return['caption']	= "semua data soal trial berhasil terhapus!";
				json_send($return);
				exit();
			}
			else{
				redirect('administrator/404');
			}
		}	
		else{
			$p['username'] = $this->session->userdata('username');
			$p['grup'] = strtoupper($this->session->userdata('grup'));
			$p['kategori'] = $this->madmin->getDatakategori()->result_array();
			$p['title'] = 'Soal Trial - Sistem Ujian Online Universitas Diponegoro';	
			$p['v'] = "admin/soal_trial" ;
		}

		$this->load->view('admin/header_footer',$p);
	}

	public function hapusbanksoal(){
		if($this->input->is_ajax_request()){
			$this->madmin->DeleteAllDataSoal();
			$files = glob('./upload/gambarsoal/*'); //get all file names
			foreach($files as $file){
			    if(is_file($file)){
			    	unlink($file);
			    } //delete file
			}
			$return['status'] 	= "ok";
			$return['caption']	= "semua data bank soal berhasil terhapus!";
			json_send($return);
			exit();
		}
		else{
			redirect('administrator/404');
		}
	}

	public function banksoal()
	{
		$p['username'] = $this->session->userdata('username');
		$p['grup'] = strtoupper($this->session->userdata('grup'));
		$p['v'] = 'admin/bank_soal' ;
		$p['title'] = 'Bank Soal - Sistem Ujian Online Universitas Diponegoro';
		$this->load->view('admin/header_footer',$p);
	}

	public function banksoalv1()
	{
		$uri3 = $this->uri->segment(3);
		$uri4 = $this->uri->segment(4);
		$uri5 = $this->uri->segment(5);
		$versi = '1';
		$p['title'] = 'Soal Versi 1 - Sistem Ujian Online Universitas Diponegoro';	
		$p['huruf_opsi'] = array("A","B","C","D");

		//$post = json_decode(file_get_contents('php://input'));
		if($uri3 == "look_all_d4t4"){
			$draw = $this->input->post('draw',TRUE);
			$search = $this->input->post('search',TRUE);
			$length = $this->input->post('length',TRUE);
			$start = $this->input->post('start',TRUE);
			$order = $this->input->post('order',TRUE);
			$category = $this->input->post('data',TRUE);

			$hasil = $this->madmin->getBankSoal($search,$length,$start,$order,$category,$versi);

			$send_data = array();

			$i = $start + 1;
			foreach ($hasil as $row) {
	            $data = array();
	            $data[] = $i++;
	            $data[] = tampil_jawaban($row->soal);
	            $data[] = $row->kategori;
	            $data[] = $row->jawaban;
	            $data[] = 
	            		 '<a href="'.base_url().'administrator/banksoalv1/edit/'.$row->id.'" class="btn btn-info btn-sm" ><i class="fa fa-pencil" style="margin-left: 0px"></i> &nbsp;&nbsp;Edit</a>
                          <button onclick="return soalversi1_h('.$row->id.');" class="btn btn-danger btn-sm"><i class="fa fa-remove" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Hapus</button>
                         ';
            	$send_data[] = $data;
        	}

        	$output = array(
                        "draw" => intval($draw),
                        "recordsTotal" => $this->madmin->getAllDataSoal($versi),
                        "recordsFiltered" => $this->madmin->getDataFilteredSoal($search,$length,$start,$order,$category,$versi),
                        "data" => $send_data
                );
			json_send($output);
	       	exit();
		}
		else if($uri3 == "edit"){
			$hasil = $this->madmin->getDatakategori()->result();
			$p['kategori'] = object_to_array($hasil,"id,kategori");
			if($uri4 == '0'){
				$p['data'] = array(
					'mode'=>'add' ,'versi' => $versi,'id'=>'0', 'kategori' => '', 'soal' => '',
					'opsi_a' => '' ,'opsi_b' => '' , 'opsi_c' => '', 'opsi_d' => '',
					'jawaban' => ''
				);
				$p['judul'] = 'Tambah Data Soal Versi 1';
				$p['username'] = $this->session->userdata('username');
				$p['grup'] = strtoupper($this->session->userdata('grup'));
			}else{
				$id = $uri4;
				$hasil = $this->madmin->getExistDataSoal($id,$versi);
				$edittrial = $hasil->row_array();
				if($hasil->num_rows() == 0){
					redirect('administrator/error/404');
				}
				else{
					$p['data'] = array(
						'mode'=>'edit' ,'versi' => $edittrial['versi'],'id' => $edittrial['id'] ,
						'kategori' => $edittrial['kategori'],'soal' => $edittrial['soal'],
						'opsi_a' => $edittrial['opsi_a'] ,'opsi_b' => $edittrial['opsi_b'] ,
						'opsi_c' => $edittrial['opsi_c'],'opsi_d' => $edittrial['opsi_d'],
						'jawaban' => $edittrial['jawaban']
					);
					$p['judul'] = 'Edit Data Soal Versi 1';
					$p['username'] = $this->session->userdata('username');
					$p['grup'] = strtoupper($this->session->userdata('grup'));
				}
			}

			$p['v'] = "admin/edit_soal_v1";
		}
		else if($uri3 == "simpan"){
			$data = array(
				'kategori' => $this->input->post('kategori',TRUE),
				'soal' => $this->input->post('soal'),
				'opsi_a' => $this->input->post('opsia'),
				'opsi_b' => $this->input->post('opsib'),
				'opsi_c' => $this->input->post('opsic'),
				'opsi_d' => $this->input->post('opsid'),
				'versi' => $this->input->post('versi'),
				'jawaban' => $this->input->post('jawaban',TRUE),
			);
			$id = $this->input->post('id',TRUE);

			if(xss_clean_filter($data['soal']) || xss_clean_filter($data['opsi_a']) || xss_clean_filter($data['opsi_b']) || xss_clean_filter($data['opsi_c']) || xss_clean_filter($data['opsi_d'])){
				$this->session->set_flashdata('gagal','Request dilarang karena ada data berbahaya');
				redirect('administrator/banksoalv1/edit/'.$id.'');
			}
			else if($data['soal'] == '' || $data['jawaban'] == ''){
				$this->session->set_flashdata('gagal','Maaf data soal dan jawaban harus diisi');
				redirect('administrator/banksoalv1/edit/'.$id.'');
			}else if($data['opsi_a'] == '' || $data['opsi_b'] == '' || $data['opsi_c'] == '' || $data['opsi_d'] == ''){
				$this->session->set_flashdata('gagal','Maaf opsi harus diisi');
				redirect('administrator/banksoalv1/edit/'.$id.'');
			}else{
				if($id == '0'){
					$this->madmin->InsertSoal($data);
					$this->session->set_flashdata('sukses','Data berhasil ditambah');
					redirect('administrator/banksoalv1');
				}else{
					$this->madmin->UpdateSoal($data,$id);
					$this->session->set_flashdata('sukses','Data berhasil di edit');
					redirect('administrator/banksoalv1');
				}
			}
		}
		else if($uri3 == "hapus"){
			if($this->input->is_ajax_request()){
				$id = $uri4;
				$this->madmin->DoDeleteSoal($id);
				$data['status'] = 'ok';
				$data['caption'] = 'data berhasil dihapus';
				json_send($data);
				exit();
			}
			else{
				redirect('administrator/404');
			}		
		}
		else if($uri3 == "import"){
			$hasil = $this->madmin->getDatakategori()->result();
			$p['kategori'] = object_to_array($hasil,"id,kategori");
			$p['data'] = array('kategori' => '');
			$p['versi'] = $versi;
			$p['v'] = "admin/import_soal_versi1";
			$p['username'] = $this->session->userdata('username');
			$p['grup'] = strtoupper($this->session->userdata('grup'));
		}
		else{
			$p['username'] = $this->session->userdata('username');
			$p['grup'] = strtoupper($this->session->userdata('grup'));
			$p['kategori'] = $this->madmin->getDatakategori()->result_array();
			$p['v'] = "admin/bank_soal_v1" ;
		}

		$this->load->view('admin/header_footer',$p);
	}

	public function banksoalv2()
	{
		$uri3 = $this->uri->segment(3);
		$uri4 = $this->uri->segment(4);
		$uri5 = $this->uri->segment(5);
		$versi = '2';
		$p['title'] = 'Soal Versi 2 - Sistem Ujian Online Universitas Diponegoro';
		$p['huruf_opsi'] = array("A","B","C","D");	

		//$post = json_decode(file_get_contents('php://input'));
		if($uri3 == "look_all_d4t4"){
			$draw = $this->input->post('draw',TRUE);
			$search = $this->input->post('search',TRUE);
			$length = $this->input->post('length',TRUE);
			$start = $this->input->post('start',TRUE);
			$order = $this->input->post('order',TRUE);
			$category = $this->input->post('data',TRUE);

			$hasil = $this->madmin->getBankSoal($search,$length,$start,$order,$category,$versi);

			$send_data = array();

			$i = $start + 1;
			foreach ($hasil as $row) {
	            $data = array();
	            $data[] = $i++;
	            $data[] = tampil_jawaban($row->soal);
	            $data[] = $row->kategori;
	            $data[] = $row->jawaban;
	            $data[] = 
	            		 '<a href="'.base_url().'administrator/banksoalv2/edit/'.$row->id.'" class="btn btn-info btn-sm" ><i class="fa fa-pencil" style="margin-left: 0px"></i> &nbsp;&nbsp;Edit</a>
                          <button onclick="return soalversi2_h('.$row->id.');" class="btn btn-danger btn-sm"><i class="fa fa-remove" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Hapus</button>
                         ';
            	$send_data[] = $data;
        	}

        	$output = array(
                        "draw" => intval($draw),
                        "recordsTotal" => $this->madmin->getAllDataSoal($versi),
                        "recordsFiltered" => $this->madmin->getDataFilteredSoal($search,$length,$start,$order,$category,$versi),
                        "data" => $send_data
                );
			json_send($output);
	       	exit();
		}
		else if($uri3 == "edit"){
			$hasil = $this->madmin->getDatakategori()->result();
			$p['kategori'] = object_to_array($hasil,"id,kategori");
			if($uri4 == '0'){
				$p['data'] = array(
					'mode'=>'add' ,'versi' => $versi,'id'=>'0', 'kategori' => '', 'soal' => '',
					'opsi_a' => '' ,'opsi_b' => '' , 'opsi_c' => '', 'opsi_d' => '',
					'jawaban' => ''
				);
				$p['judul'] = 'Tambah Data Soal Versi 2';
				$p['username'] = $this->session->userdata('username');
				$p['grup'] = strtoupper($this->session->userdata('grup'));
			}else{
				$id = $uri4;
				$hasil = $this->madmin->getExistDataSoal($id,$versi);
				$edittrial = $hasil->row_array();
				if($hasil->num_rows() == 0){
					redirect('administrator/error/404');
				}
				else{
					$p['data'] = array(
						'mode'=>'edit' ,'versi' => $edittrial['versi'],'id' => $edittrial['id'] ,
						'kategori' => $edittrial['kategori'],'soal' => $edittrial['soal'],
						'opsi_a' => $edittrial['opsi_a'] ,'opsi_b' => $edittrial['opsi_b'] ,
						'opsi_c' => $edittrial['opsi_c'],'opsi_d' => $edittrial['opsi_d'],
						'jawaban' => $edittrial['jawaban']
					);
					$p['judul'] = 'Edit Data Soal Versi 2';
					$p['username'] = $this->session->userdata('username');
					$p['grup'] = strtoupper($this->session->userdata('grup'));
				}
			}
			$p['v'] = "admin/edit_soal_v2";
		}
		else if($uri3 == "simpan"){
			$data = array(
				'kategori' => $this->input->post('kategori',TRUE),
				'soal' => $this->input->post('soal'),
				'opsi_a' => $this->input->post('opsia'),
				'opsi_b' => $this->input->post('opsib'),
				'opsi_c' => $this->input->post('opsic'),
				'opsi_d' => $this->input->post('opsid'),
				'versi' => $this->input->post('versi',TRUE),
				'jawaban' => $this->input->post('jawaban',TRUE),
			);
			$id = $this->input->post('id',TRUE);

			if(xss_clean_filter($data['soal']) || xss_clean_filter($data['opsi_a']) || xss_clean_filter($data['opsi_b']) || xss_clean_filter($data['opsi_c']) || xss_clean_filter($data['opsi_d'])){
				$this->session->set_flashdata('gagal','Request dilarang karena ada data berbahaya');
				redirect('administrator/banksoalv2/edit/'.$id.'');
			}
			else if($data['soal'] == '' || $data['jawaban'] == ''){
				$this->session->set_flashdata('gagal','Maaf data soal dan jawaban harus diisi');
				redirect('administrator/banksoalv2/edit/'.$id.'');
			}else if($data['opsi_a'] == '' || $data['opsi_b'] == '' || $data['opsi_c'] == '' || $data['opsi_d'] == ''){
				$this->session->set_flashdata('gagal','Maaf opsi harus diisi');
				redirect('administrator/banksoalv2/edit/'.$id.'');
			}else{
				if($id == '0'){
					$this->madmin->InsertSoal($data);
					$this->session->set_flashdata('sukses','Data berhasil ditambah');
					redirect('administrator/banksoalv2');
				}else{
					$this->madmin->UpdateSoal($data,$id);
					$this->session->set_flashdata('sukses','Data berhasil di edit');
					redirect('administrator/banksoalv2');
				}
			}
		}
		else if($uri3 == "hapus"){
			if($this->input->is_ajax_request()){
				$id = $uri4;
				$this->madmin->DoDeleteSoal($id);
				$data['status'] = 'ok';
				$data['caption'] = 'data berhasil dihapus';
				json_send($data);
				exit();
			}
			else{
				redirect('administrator/404');
			}
		}
		else if($uri3 == "import"){
			$hasil = $this->madmin->getDatakategori()->result();
			$p['kategori'] = object_to_array($hasil,"id,kategori");
			$p['data'] = array('kategori' => '');
			$p['versi'] = $versi;
			$p['v'] = "admin/import_soal_versi2";
			$p['username'] = $this->session->userdata('username');
			$p['grup'] = strtoupper($this->session->userdata('grup'));
		}
		else{
			$p['username'] = $this->session->userdata('username');
			$p['grup'] = strtoupper($this->session->userdata('grup'));
			$p['kategori'] = $this->madmin->getDatakategori()->result_array();
			$p['v'] = "admin/bank_soal_v2" ;
		}

		$this->load->view('admin/header_footer',$p);
	}

	public function banksoalv3()
	{
		$uri3 = $this->uri->segment(3);
		$uri4 = $this->uri->segment(4);
		$uri5 = $this->uri->segment(5);
		$versi = '3';
		$p['title'] = 'Soal Versi 3 - Sistem Ujian Online Universitas Diponegoro';	
		$p['huruf_opsi'] = array("A","B","C","D");	

		//$post = json_decode(file_get_contents('php://input'));
		if($uri3 == "look_all_d4t4"){
			$draw = $this->input->post('draw',TRUE);
			$search = $this->input->post('search',TRUE);
			$length = $this->input->post('length',TRUE);
			$start = $this->input->post('start',TRUE);
			$order = $this->input->post('order',TRUE);
			$category = $this->input->post('data',TRUE);

			$hasil = $this->madmin->getBankSoal($search,$length,$start,$order,$category,$versi);

			$send_data = array();

			$i = $start + 1;
			foreach ($hasil as $row) {
	            $data = array();
	            $data[] = $i++;
	            $data[] = tampil_jawaban($row->soal);
	            $data[] = $row->kategori;
	            $data[] = $row->jawaban;
	            $data[] = 
	            		 '<a href="'.base_url().'administrator/banksoalv3/edit/'.$row->id.'" class="btn btn-info btn-sm" ><i class="fa fa-pencil" style="margin-left: 0px"></i> &nbsp;&nbsp;Edit</a>
                          <button onclick="return soalversi3_h('.$row->id.');" class="btn btn-danger btn-sm"><i class="fa fa-remove" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Hapus</button>
                         ';
            	$send_data[] = $data;
        	}

        	$output = array(
                        "draw" => intval($draw),
                        "recordsTotal" => $this->madmin->getAllDataSoal($versi),
                        "recordsFiltered" => $this->madmin->getDataFilteredSoal($search,$length,$start,$order,$category,$versi),
                        "data" => $send_data
                );
			json_send($output);
	       	exit();
		}
		else if($uri3 == "edit"){
			$hasil = $this->madmin->getDatakategori()->result();
			$p['kategori'] = object_to_array($hasil,"id,kategori");
			if($uri4 == '0'){
				$p['data'] = array(
					'mode'=>'add' ,'versi' => $versi,'id'=>'0', 'kategori' => '', 'soal' => '',
					'opsi_a' => '' ,'opsi_b' => '' , 'opsi_c' => '', 'opsi_d' => '',
					'jawaban' => ''
				);
				$p['judul'] = 'Tambah Data Soal Versi 3';
				$p['username'] = $this->session->userdata('username');
				$p['grup'] = strtoupper($this->session->userdata('grup'));
			}else{
				$id = $uri4;
				$hasil = $this->madmin->getExistDataSoal($id,$versi);
				$edittrial = $hasil->row_array();
				if($hasil->num_rows() == 0){
					redirect('administrator/error/404');
				}
				else{
					$p['data'] = array(
						'mode'=>'edit' ,'versi' => $edittrial['versi'],'id' => $edittrial['id'] ,
						'kategori' => $edittrial['kategori'],'soal' => $edittrial['soal'],
						'opsi_a' => $edittrial['opsi_a'] ,'opsi_b' => $edittrial['opsi_b'] ,
						'opsi_c' => $edittrial['opsi_c'],'opsi_d' => $edittrial['opsi_d'],
						'jawaban' => $edittrial['jawaban']
					);
					$p['judul'] = 'Edit Data Soal Versi 3 ';
					$p['username'] = $this->session->userdata('username');
					$p['grup'] = strtoupper($this->session->userdata('grup'));
				}
			}
			$p['v'] = "admin/edit_soal_v3";
		}
		else if($uri3 == "simpan"){
			$data = array(
				'kategori' => $this->input->post('kategori',TRUE),
				'soal' => $this->input->post('soal'),
				'opsi_a' => $this->input->post('opsia'),
				'opsi_b' => $this->input->post('opsib'),
				'opsi_c' => $this->input->post('opsic'),
				'opsi_d' => $this->input->post('opsid'),
				'versi' => $this->input->post('versi'),
				'jawaban' => $this->input->post('jawaban',TRUE),
			);
			$id = $this->input->post('id',TRUE); 

			if(xss_clean_filter($data['soal']) || xss_clean_filter($data['opsi_a']) || xss_clean_filter($data['opsi_b']) || xss_clean_filter($data['opsi_c']) || xss_clean_filter($data['opsi_d'])){
				$this->session->set_flashdata('gagal','Request dilarang karena ada data berbahaya');
				redirect('administrator/banksoalv3/edit/'.$id.'');
			}
			else if($data['soal'] == '' || $data['jawaban'] == ''){
				$this->session->set_flashdata('gagal','Maaf data soal dan jawaban harus diisi');
				redirect('administrator/banksoalv3/edit/'.$id.'');
			}else if($data['opsi_a'] == '' || $data['opsi_b'] == '' || $data['opsi_c'] == '' || $data['opsi_d'] == ''){
				$this->session->set_flashdata('gagal','Maaf opsi harus diisi');
				redirect('administrator/banksoalv3/edit/'.$id.'');
			}else{
				if($id == '0'){
					$this->madmin->InsertSoal($data);
					$this->session->set_flashdata('sukses','Data berhasil ditambah');
					redirect('administrator/banksoalv3');
				}else{
					$this->madmin->UpdateSoal($data,$id);
					$this->session->set_flashdata('sukses','Data berhasil di edit');
					redirect('administrator/banksoalv3');
				}
			}
		}
		else if($uri3 == "hapus"){
			if($this->input->is_ajax_request()){
				$id = $uri4;
				$this->madmin->DoDeleteSoal($id);
				$data['status'] = 'ok';
				$data['caption'] = 'data berhasil dihapus';
				json_send($data);
				exit();
			}
			else{
				redirect('administrator/404');
			}
		}
		else if($uri3 == "import"){
			$hasil = $this->madmin->getDatakategori()->result();
			$p['kategori'] = object_to_array($hasil,"id,kategori");
			$p['data'] = array('kategori' => '');
			$p['versi'] = $versi;
			$p['username'] = $this->session->userdata('username');
			$p['grup'] = strtoupper($this->session->userdata('grup'));
			$p['v'] = "admin/import_soal_versi3";
		}
		else{
			$p['username'] = $this->session->userdata('username');
			$p['grup'] = strtoupper($this->session->userdata('grup'));
			$p['kategori'] = $this->madmin->getDatakategori()->result_array();
			$p['v'] = "admin/bank_soal_v3" ;
		}

		$this->load->view('admin/header_footer',$p);
	}

	public function kategorisoal()
	{
		$uri3 = $this->uri->segment(3);
		$uri4 = $this->uri->segment(4);
		$post = json_decode(file_get_contents('php://input'));

		if($uri3 == "data"){
			$draw = $this->input->post('draw',TRUE);
			$search = $this->input->post('search',TRUE);
			$length = $this->input->post('length',TRUE);
			$start = $this->input->post('start',TRUE);
			$order = $this->input->post('order',TRUE);

			$hasil = $this->madmin->getKategoriDatatables($search,$length,$start,$order);

			$send_data = array();
        	foreach ($hasil as $row) {
	            $data = array();
	            $data[0] = $row->id;
	            $data[1] = $row->kategori;
	            $data[2] = 
						 '<a href="#" onclick="return m_kategori('.$row->id.');" class="btn btn-info btn-sm" ><i class="fa fa-pencil" style="margin-left: 0px"></i> &nbsp;&nbsp;Edit</a>
                          <button onclick="return hapus_kategori('.$row->id.');" class="btn btn-danger btn-sm"><i class="fa fa-remove" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Hapus</button>
                         ';
            	$send_data[] = $data;
        	}

        	$output = array(
                        "draw" => intval($draw),
                        "recordsTotal" => $this->madmin->getAllDataKategori(),
                        "recordsFiltered" => $this->madmin->getDataFilteredKategori($search,$length,$start,$order),
                        "data" => $send_data
                );

			json_send($output);
	       	exit();
		}
		else if($uri3 == "editdatakategori"){
			$id['id'] = $uri4;
			if($uri4 == 0){
				$data['judul'] = "Tambah Data Kategori";
				$data['data']['id'] = "ok";
			}
			else{
				$data['judul'] = "Edit Data Kategori";
				$data['data'] = $this->madmin->EditDataKategori($id)->row();
			}
			json_send($data);
			exit();
		}
		else if($uri3 == "simpan_data_kategori"){
			if($this->input->is_ajax_request()){
				$ket ="";
				$data['kategori'] = $this->input->post('kategori',TRUE);
				$id = $this->input->post('id',TRUE);
				if($id != 0){
					$this->madmin->DoEditDataKategori($data,$id);
					$ket = "edit data";
				}
				else{
					$this->madmin->DoInsertDataKategori($data);
					$ket = "tambah data";
				}
				$return['status'] 	= "ok";
				$return['caption']	= $ket." kategori berhasil";
				json_send($return);
				exit();
			}
			else{
				redirect('administrator/404');
			}
		}
		else if($uri3 == "hapus"){
			if($this->input->is_ajax_request()){
				$id = $uri4;
				$this->madmin->DoDeleteDataKategori($id);
				$return['status'] 	= "ok";
				$return['caption']	= "hapus kategori berhasil";
				json_send($return);
				exit();
			}
			else{
				redirect('administrator/404');
			}
		}
		else{
			$a = array(
				'username' => $this->session->userdata('username'),
				'grup' => strtoupper($this->session->userdata('grup')),
				'title' => 'Data Kategori - Sistem Ujian Online Universitas Diponegoro',
				'v' => 'admin/data_kategori'
			);
		}

		$this->load->view('admin/header_footer', $a);
	}

	public function dataoperator()
	{
		$uri3 = $this->uri->segment(3);
		$uri4 = $this->uri->segment(4);
		$post = json_decode(file_get_contents('php://input'));

		if($uri3 == "data"){
			$draw = $this->input->post('draw',TRUE);
			$search = $this->input->post('search',TRUE);
			$length = $this->input->post('length',TRUE);
			$start = $this->input->post('start',TRUE);
			$order = $this->input->post('order',TRUE);

			$hasil = $this->madmin->getOperatorDatatables($search,$length,$start,$order);

			$send_data = array();
        	foreach ($hasil as $row) {
	            $data = array();
	            $data[] = $row->id;
	            $data[] = $row->username;
	            $data[] = $row->id_ruang;
	            $data[] = $row->periode;
	            $data[] = $row->grup;
	            $data[] = 
						 '<a href="#" onclick="return m_operator('.$row->id.');" class="btn btn-info btn-sm" ><i class="fa fa-pencil" style="margin-left: 0px"></i> &nbsp;&nbsp;Edit</a>
                          <button onclick="return hapus_operator('.$row->id.');" class="btn btn-danger btn-sm"><i class="fa fa-remove" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Hapus</button>
                         ';
            	$send_data[] = $data;
        	}

        	$output = array(
                        "draw" => intval($draw),
                        "recordsTotal" => $this->madmin->getAllDataOperator(),
                        "recordsFiltered" => $this->madmin->getDataFilteredOperator($search,$length,$start,$order),
                        "data" => $send_data
                );

			json_send($output);
	       	exit();
		}else if($uri3 == "editdataoperator"){
			$id['id'] = $uri4;
			if($uri4 == 0){
				$data['judul'] = "Tambah Data Operator";
				$data['id'] = "ok";
				$data['label'] = "Password Baru";
				$data['username'] = "";
				$data['id_ruang'] = "";
				$data['periode'] = "";
				$data['grup'] = "";
			}
			else{
				$data['judul'] = "Edit Data Operator";
				$hasil = $this->madmin->EditDataOperator($id)->row();
				$data['label'] = "Ganti Password";
				$data['username'] = $hasil->username;
				$data['id'] = $hasil->id;
				$data['id_ruang'] = $hasil->id_ruang;
				$data['periode'] = $hasil->periode;
				$data['grup'] = $hasil->grup;
			}
			json_send($data);
			exit();
		}
		else if($uri3 == "simpan_data_operator"){
			if($this->input->is_ajax_request()){
				$ket ="";
				$username = $this->input->post('username',TRUE);
				$data = array(
						'username' => $username, 
						'grup' => $this->input->post('peran',TRUE)  
				); 

				$id = $this->input->post('id',TRUE);
				$post_pass = $this->input->post('password',TRUE);
				$periode = $this->input->post('periode',TRUE);
				$id_ruang = $this->input->post('idruang',TRUE);
				if(!empty($post_pass)){
					$password = md5($post_pass);
				}
				else{
					$password = '';
				}

				if($data['grup'] == 'operator utama'){
					$idruang = '-';
					$periode = '-';
				}
				else{
					$idruang = $id_ruang;
					$periode = $periode; 
				}

				$arr_data = array('username' => $username);
				$check_ganda = $this->madmin->EditDataOperator($arr_data)->num_rows();
				$get_data =  $this->madmin->EditDataOperator(array('id' => $id))->row();

				if($id != 0){
					if($get_data->username == $username || $check_ganda == 0){
						$this->madmin->DoEditDataOperator($data,$id,$periode,$idruang,$password);
						$ket = "edit data operator berhasil";
						$status = "ok";
					}
					else{
						$status = "gagal";
						$ket = "akun ini sudah dipakai...";
					}
					
				}
				else{
					if($check_ganda == 0){
						$this->madmin->DoInsertDataOperator($data,$periode,$idruang,$password);
						$ket = "tambah data operator berhasil";
						$status = "ok";
					}
					else{
						$status = "gagal";
						$ket = "akun ini sudah dipakai...";
					}
				}

				$return['status'] = $status;
				$return['caption']	= $ket;
				json_send($return);
				exit();
			}
			else{
				redirect('administrator/404');
			}
		}
		else if($uri3 == "hapus"){
			if($this->input->is_ajax_request()){
				$id = $uri4;
				$this->madmin->DoDeleteDataOperator($id);
				$return['status'] 	= "ok";
				$return['caption']	= "hapus data operator berhasil";
				json_send($return);
				exit();
			}
			else{
				redirect('administrator/404');
			}
		}
		else{
			$hasil = $this->madmin->getIdRuang()->result();
			$a = array(
				'username' => $this->session->userdata('username'),
				'grup' => strtoupper($this->session->userdata('grup')),
				'title' => 'Data Operator - Sistem Ujian Online Universitas Diponegoro',
				'v' => 'admin/data_operator',
				'id_ruang' => object_to_array($hasil,"id_ruang,id_ruang")
			);
		}

		$this->load->view('admin/header_footer',$a);
	}

	public function dataruang()
	{
		$uri3 = $this->uri->segment(3);
		$uri4 = $this->uri->segment(4);
		$post = json_decode(file_get_contents('php://input'));
		$a['title'] = 'Data Ruang - Sistem Ujian Online Universitas Diponegoro';

		if($uri3 == "data"){
			$draw = $this->input->post('draw',TRUE);
			$search = $this->input->post('search',TRUE);
			$length = $this->input->post('length',TRUE);
			$start = $this->input->post('start',TRUE);
			$order = $this->input->post('order',TRUE);

			$hasil = $this->madmin->getRuang($search,$length,$start,$order);

			$send_data = array();
        	foreach ($hasil as $row) {
	            $data = array();
	            $data[] = $row->id_ruang;
	            $data[] = $row->min." - ".$row->max;
	            $data[] = 
						 '<button onclick="return m_ruang(\''.$row->id_ruang.'\');" class="btn btn-info btn-sm" ><i class="fa fa-pencil" style="margin-left: 0px"></i> &nbsp;&nbsp;Edit</button>
                          <button onclick="return hapus_ruang(\''.$row->id_ruang.'\');" class="btn btn-danger btn-sm"><i class="fa fa-remove" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Hapus</button>
                         ';
            	$send_data[] = $data;
        	}

        	$output = array(
                        "draw" => intval($draw),
                        "recordsTotal" => $this->madmin->getAllDataRuang(),
                        "recordsFiltered" => $this->madmin->getDataFilteredRuang($search,$length,$start,$order),
                        "data" => $send_data
                );

			json_send($output);
	       	exit();
		}
		else if($uri3 == 'editdataruang'){
			$id['id_ruang'] = $uri4;
			if($uri4 == '0'){
				$data['judul'] = "Tambah Data Ruang";
				$data['status'] = "tambah";
			}
			else{
				$data['judul'] = "Edit Data Ruang";
				$data['status'] = "edit";
				$data['data'] = $this->madmin->EditRuang($id)->row();
			}
			json_send($data);
			exit();
		}
		else if($uri3 == 'simpan'){
			if($this->input->is_ajax_request()){
				$ruang = $this->input->post('idruang',TRUE);
				$inputmin = $this->input->post('idruangmin',TRUE);
				$inputmax = $this->input->post('idruangmax',TRUE);
				$id = $this->input->post('id',TRUE);

				if($inputmin > $inputmax){
					$data['msg'] = 'Input tidak valid' ;
					$data['status'] = 'error'; 
				}
				else if($inputmin == $inputmax){
					$data['msg'] = 'Maaf, input no kursi tidak boleh sama' ;
					$data['status'] = 'error'; 
				}
				else{
					if($id == 'tambah'){
						$hasil = $this->madmin->checkExistRuangadd($ruang,$inputmin,$inputmax);
						if($hasil->num_rows() > 0){
							$data['msg'] = 'Maaf, no kursi atau ruangan sudah dipakai' ;
							$data['status'] = 'error'; 
						}
						else{
							$val = array();
							for($i = $inputmin;$i <= $inputmax;$i++){
								$val[] = array('no_kursi' => $i, 'id_ruang' => $ruang);
							}
							$this->madmin->InsertBatch($val);
							$data['msg'] = 'Data ruang berhasil ditambah !';
							$data['status'] = 'ok';
						}	
					}
					else{
						$query = $this->madmin->distinctruang($inputmin,$inputmax)->row();
						$dataruang = $query->id_ruang;
						$hasil = $this->madmin->checkExistRuang($dataruang,$inputmin,$inputmax);
						if($hasil->num_rows() != 0){
							$data['msg'] = 'Maaf, no kursi atau ruangan sudah dipakai' ;
							$data['status'] = 'error'; 
						}
						else{
							$val = array();
							$this->madmin->deleteRuang($dataruang); //dihapus untuk di replace
							for($i = $inputmin;$i <= $inputmax;$i++){
								$val[] = array('no_kursi' => $i, 'id_ruang' => $ruang);
							}
							$this->madmin->InsertBatch($val);
							$data['msg'] = 'Data ruang berhasil diedit !';
							$data['status'] = 'ok';
						}
					}
				}
				json_send($data);
				exit();
			}
			else{
				redirect('administrator/404');
			}
		}
		else if($uri3 == 'hapus'){
			if($this->input->is_ajax_request()){
				$id = $uri4;
				$this->madmin->deleteRuang($id);
				$data['msg'] = 'Hapus data ruang berhasil !';
				$data['status'] = 'ok';
				json_send($data);
				exit();
			}
			else{
				redirect('administrator/404');
			}
		}
		else{
			$a['username'] = $this->session->userdata('username');
			$a['grup'] = strtoupper($this->session->userdata('grup'));
			$a['v'] = 'admin/data_ruang';
		}

		$this->load->view('admin/header_footer',$a);
	}

	public function aktivasisoal()
	{
		$uri3 = $this->uri->segment(3);
		$uri4 = $this->uri->segment(4);
		$post = json_decode(file_get_contents('php://input'));
		$a['title'] = 'Aktivasi Soal - Sistem Ujian Online Universitas Diponegoro';

		//kategori
		$hasil = $this->madmin->getDatakategori()->result();
		$a['kategori'] = object_to_array($hasil,"id,kategori");

		if($uri3 == "data"){
			$draw = $this->input->post('draw',TRUE);
			$search = $this->input->post('search',TRUE);
			$length = $this->input->post('length',TRUE);
			$start = $this->input->post('start',TRUE);

			$hasil = $this->madmin->getAktivasiSoaltabel($search,$length,$start);

			$send_data = array();
        	foreach ($hasil as $row) {
	            $data = array();
	            $data[] = $row->id;
	            if($row->nama_ujian == "Test Trial"){
	            	$data[] = $row->nama_ujian;
	            	$data[] = '';
	            	$data[] = 'Waktu ('.$row->waktu.' menit)';
	            	$data[] = '<button onclick="return set_trial(\''.$row->id.'\');" class="btn btn-info btn-sm" ><i class="fa fa-pencil" style="margin-left: 0px"></i> &nbsp;&nbsp;Edit</button>
	            			<button onclick="return hapus_aktif(\''.$row->id.'\');" class="btn btn-danger btn-sm"><i class="fa fa-times" style="margin-left:0px"></i>&nbsp;&nbsp;Hapus</button>';
	            }
	            else{
		            $data[] = $row->nama_ujian;
		            $data[] = $row->kategori;
		            $data[] = timehelper($row->tgl_mulai,"s").'<br>Waktu ('.$row->waktu.' menit)<br>Terlambat ('.$row->terlambat.' menit)';
		            $data[] = 
							 '<button onclick="return m_editactive(\''.$row->id.'\');" class="btn btn-info btn-sm" ><i class="fa fa-pencil" style="margin-left: 0px"></i> &nbsp;&nbsp;Edit</button>
	                         <button onclick="return hapus_aktif(\''.$row->id.'\');" class="btn btn-danger btn-sm"><i class="fa fa-times" style="margin-left:0px;"></i>&nbsp;&nbsp;Hapus</button>';
                }
            	$send_data[] = $data;
        	}

        	$output = array(
                        "draw" => intval($draw),
                        "recordsTotal" => $this->madmin->getAllDataAktivasiSoal(),
                        "recordsFiltered" => $this->madmin->getDataFilteredAktivasiSoal($search,$length,$start),
                        "data" => $send_data
                );

			json_send($output);
	       	exit();
		}
		else if($uri3 == 'getwaktu'){
			$id['id'] = $uri4;
			$hasil = $this->madmin->getAktifSoal($id)->row();
			if(!empty($hasil)){
				$data['id'] = $hasil->id;
				$data['waktu'] = $hasil->waktu;
				$data['judul'] = "Edit Waktu Trial";
			}
			else{
				$data['id'] = "";
				$data['waktu'] = "";
				$data['judul'] = "Set Waktu Trial";
			}
			json_send($data);
			exit();
		}
		else if($uri3 == 'editdata'){
			$id['id'] = $uri4;
			$data = array();

			$hasil = $this->madmin->getAktifSoal($id)->row();

			if(!empty($hasil)){
				$array_tgl = explode(" ",$hasil->tgl_mulai);
				$data['id'] = $hasil->id;
				$data['nama_ujian'] = $hasil->nama_ujian;
				$data['idkategori'] = $hasil->idkategori;
				$data['waktu'] = $hasil->waktu;
				$data['terlambat'] = $hasil->terlambat;
				$data['tanggal'] = $array_tgl[0];
				$data['jam'] = substr($array_tgl[1],0,5);
				$data['judul'] = 'Edit Data Aktivasi Soal' ; 
 			}else{
				$data['id'] = "";
				$data['nama_ujian'] = "";
				$data['idkategori'] = "";
				$data['waktu'] = "";
				$data['terlambat'] = "";
				$data['tanggal'] = "";
				$data['jam'] = "";
				$data['judul'] = 'Tambah Data Aktivasi Soal' ; 
			}

			json_send($data);
			exit();
		}
		else if($uri3 == 'simpan_trial'){
			if($this->input->is_ajax_request()){
				$ket = '';
				$waktu = $this->input->post('waktu_trial',TRUE);
				$id = $this->input->post('id_trial',TRUE);
				$data = array('nama_ujian' => 'Test Trial', 'waktu' => $waktu);
				$hasil = $this->madmin->cek_trial()->num_rows();
				if($id == 0){
					if($hasil > 0){
						$status = "gagal";
						$ket = "Anda sudah aktivasi soal trial";
					}	
					else{
						$this->madmin->InsertDataAktifSoal($data);
						$ket = "Waktu soal trial sudah di set !";
						$status = "ok";
					}
				}
				else{
					$this->madmin->EditDataAktifSoal($id,$data);
					$ket ="Edit data berhasil !";
					$status = "ok";
				}

				$return['status'] = $status;
				$return['caption']	= $ket;
				json_send($return);
				exit();
			}
			else{
				redirect('administrator/404');
			}
		}
		else if($uri3 == 'simpan'){
			if($this->input->is_ajax_request()){
				$ket = '';		
				$tgl =  $this->input->post('tgl',TRUE);
				$time = $this->input->post('time',TRUE);
				$kategori = $this->input->post('kategori',TRUE);
				$data = array(	'nama_ujian' => $this->input->post('nmujian',TRUE),
								'idkategori' => $kategori,
								'waktu' => $this->input->post('waktu',TRUE), 
								'terlambat' => $this->input->post('terlambat',TRUE),
								'tgl_mulai' => $tgl." ".$time
						);
				$id = $this->input->post('id',TRUE);
				$id_tes['idkategori'] = $kategori;
				$hasil = $this->madmin->getAktifSoal($id_tes);
				if($id != 0){
					$this->madmin->EditDataAktifSoal($id,$data);
					$ket ="Edit data berhasil !";
					$status = 'ok';
				}
				else if($hasil->num_rows() > 0){
					$ket ="Anda sudah aktivasi soal ini";
					$status = 'gagal';
				}
				else if($id == 0){
					$this->madmin->InsertDataAktifSoal($data);
					$ket = "Tambah data berhasil !";
					$status = 'ok';
				}

				$return['status'] 	= $status;
				$return['caption']	= $ket;
				json_send($return);
				exit();
			}
			else{
				redirect('administrator/404');
			}
		}
		else if($uri3 == 'hapus'){
			if($this->input->is_ajax_request()){
				$this->madmin->hapusAktifSoal($uri4);
				$return['status'] = "ok";
				$return['caption'] = "Hapus data berhasil!";
				json_send($return);
				exit();
			}
			else{
				redirect('administrator/404');
			}
		}
		else{
			$a['username'] = $this->session->userdata('username');
			$a['grup'] = strtoupper($this->session->userdata('grup'));
			$a['v'] = 'admin/aktivasi_soal';
		}
		$this->load->view('admin/header_footer',$a);
	}

	public function lihat_laporan()
	{
		$uri3 = $this->uri->segment(3);
		$uri4 = $this->uri->segment(4);
		if($uri3 == "data_rekap"){
			$draw = $this->input->post('draw',TRUE);
			$search = $this->input->post('search',TRUE);
			$length = $this->input->post('length',TRUE);
			$start = $this->input->post('start',TRUE);
			$order = $this->input->post('order',TRUE);
			$id = $this->input->post('data',TRUE);

			$hasil = $this->madmin->getDataLaporan($search,$length,$start,$order,$id);

			$send_data = array();
        	foreach ($hasil as $row) {
	            $data = array();
	            $data[] = $row->id;
	            $data[] = $row->nama;
	            $data[] = $row->no_peserta;
	            $data[] = $row->pilih_prodi;
	            $data[] = $row->periode;
	            $data[] = '<button onclick="return modal_laporan(\''.$row->id.'\');" class="btn btn-info btn-sm"><i class="fa fa-eye" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Detail Laporan</button>';
            	$send_data[] = $data;
        	}

        	$output = array(
                        "draw" => intval($draw),
                        "recordsTotal" => $this->madmin->getAllDataLaporan(),
                        "recordsFiltered" => $this->madmin->getDataFilteredLaporan($search,$length,$start,$order,$id),
                        "data" => $send_data
                );
			json_send($output);
	       	exit();
		}
		else if($uri3 == 'laporan_data'){
			$hasil = $this->madmin->Laporan($uri4)->row();
			$response['data'] = $hasil->laporan;
			json_send($response);
			exit();
		}
		else if($uri3 == 'hapus_all'){
			if($this->input->is_ajax_request()){
				$this->madmin->deleteRekapLap();
				$return['status'] = "ok";
				$return['caption'] = "Semua data berhasil terhapus!";
				json_send($return);
				exit();
			}
			else{
				redirect('administrator/404');
			}
		}
		else{
			$a['periode'] = $this->madmin->getPeriode()->result();
			$a['username'] = $this->session->userdata('username');
			$a['grup'] = strtoupper($this->session->userdata('grup'));
			$a['v'] = 'admin/lihat_laporan';
			$a['title'] = 'Rekap Data Laporan - Sistem Ujian Online Universitas Diponegoro';
		}

		$this->load->view('admin/header_footer',$a);
	}

	public function rekapnilai()
	{
		$uri3 = $this->uri->segment(3);
		$uri4 = $this->uri->segment(4);
		$post = json_decode(file_get_contents('php://input'));

		if($uri3 == 'data_rekap_rata2'){
			$draw = $this->input->post('draw',TRUE);
			$search = $this->input->post('search',TRUE);
			$length = $this->input->post('length',TRUE);
			$start = $this->input->post('start',TRUE);
			$order = $this->input->post('order',TRUE);

			$hasil = $this->madmin->getDataNilaiRata($search,$length,$start,$order);

			$send_data = array();
			$baris = ($start + 1);
        	foreach ($hasil as $row) {
	            $data = array();
	            $data[] = $row->id;
	            $data[] = $row->nama;
	            $data[] = $row->no_peserta;
	            $data[] = $row->pilih_prodi;
	            $data[] = $row->periode;
	            $data[] = $row->sum;
	            $data[] = '<button onclick="return detail_nilai(\''.$row->id.'\');" class="btn btn-info btn-sm"><i class="fa fa-eye" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Detail Nilai</button>';
            	$send_data[] = $data;
        	}

        	$output = array(
                        "draw" => intval($draw),
                        "recordsTotal" => $this->madmin->getAllDataNilaiRata(),
                        "recordsFiltered" => $this->madmin->getDataFilteredNilaiRata($search,$length,$start,$order),
                        "data" => $send_data
                );
			json_send($output);
	       	exit();
		}
		else if($uri3 == "data_rekap_trial"){
			$draw = $this->input->post('draw',TRUE);
			$search = $this->input->post('search',TRUE);
			$length = $this->input->post('length',TRUE);
			$start = $this->input->post('start',TRUE);
			$order = $this->input->post('order',TRUE);

			$hasil = $this->madmin->getDataNilaiTrial($search,$length,$start,$order);

			$send_data = array();
			$baris = ($start + 1);
        	foreach ($hasil as $row) {
	            $data = array();
	            $data[] = $row->id;
	            $data[] = $row->nama;
	            $data[] = $row->no_peserta;
	            $data[] = $row->pilih_prodi;
	            $data[] = $row->periode;
	            $data[] = $row->nilai;
	            $data[] = $row->state == 'Y' ? "belum selesai" : "sudah selesai";
            	$send_data[] = $data;
        	}

        	$output = array(
                        "draw" => intval($draw),
                        "recordsTotal" => $this->madmin->getAllDataNilaiTrial(),
                        "recordsFiltered" => $this->madmin->getDataFilteredNilaiTrial($search,$length,$start,$order),
                        "data" => $send_data
                );
			json_send($output);
	       	exit();
		}
		else if($uri3 == 'look_nilai'){
			$id = $uri4;
			$html = "";
			$hasil = $this->madmin->detail_nilai($id)->result();
			$getnama = $this->madmin->getnama($id)->row();
			if(!empty($hasil)){
				$nama = $getnama->nama;
				$no_peserta = $getnama->no_peserta;
				foreach ($hasil as $key) {
					$html .= '<div class="row" style="padding: 6px;">';
					$html .= '<div class="col-md-3" style="padding-top: 8px;font-size: 0.9em;">'.$key->kategori.' <div class="pull-right">:</div></div>';
					$html .= '<div class="col-md-9" style="padding-top: 8px;font-size: 0.9em;padding-left: 0;">'.$key->jml_benar.'</div>';
					$html .= '</div>';
				}
			}
			$data['nama'] = $nama;
			$data['no_peserta'] = $no_peserta;
			$data['html'] = $html;
			json_send($data);
			exit();
		}
		else if($uri3 == 'progress'){
			$str = "";
			$hasil = $this->madmin->CheckUjian();
			$fetch = $hasil->result();
			$count = $hasil->num_rows();	
			if($count == 0){
				$return['angka'] = 'Belum ada soal';
				$return['kategori'] = "Belum ada kategori soal yang di aktifkan saat ini";
			}
			else{
				$i = 0;
				foreach ($fetch as $row) {
					if($row->status == "sudah selese"){
						$i++;
						$str .= $row->kategori." ,";
					}
				}

				if($i == 0){
					$return['angka'] = $i.' dari '.$count.' soal telah diujikan';
					$return['kategori'] = "Belum ada soal yang sudah selesai pada saat ini";
				}
				else{
					$return['angka'] = $i.' dari '.$count.' soal telah diujikan';
					$return['kategori'] = substr($str,0,-1);
				}
			}
			json_send($return);
			exit();
		}
		else if($uri3 == 'hapus_all'){
			if($this->input->is_ajax_request()){
				$this->madmin->deleteRekapAktif();
				$return['status'] = "ok";
				$return['caption'] = "Semua data berhasil terhapus!";
				json_send($return);
				exit();
			}
			else{
				redirect('administrator/404');
			}	
		}
		else{
			$a['username'] = $this->session->userdata('username');
			$a['grup'] = $this->session->userdata('grup');
			$a['v'] = 'admin/rekap_rata2';
			$a['title'] = 'Rekap Nilai - Sistem Ujian Online Universitas Diponegoro';
		}		
		$this->load->view('admin/header_footer',$a);
	}

	public function logout()
	{
		$this->session->sess_destroy();
		redirect("authenticate_cat",'refresh');
	}

	public function rubah_password()
	{
		$uri3 = $this->uri->segment(3);
		$id['id'] = $this->session->userdata('id');
		if($uri3 == 'simpan'){
			$username = $this->input->post('username',TRUE);
			$pass_lama = $this->input->post('pass_lama',TRUE);
			$pass_baru = $this->input->post('pass_baru',TRUE);
			$pass_konf = $this->input->post('konf_baru',TRUE);
			$cek_pass = $this->madmin->EditDataOperator($id)->row();
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
				$this->madmin->update_pass($id,$data);
				$return["status"] = "ok";
				$return["msg"] = "Update Password Berhasil !";
			}
			json_send($return);
			exit();
		}
		else{
			$hasil = $this->madmin->EditDataOperator($id)->row();
			$fetch = $hasil->username;
			$return['data'] = $fetch;
			json_send($return);
			exit();
		}
	}
}

/* End of file controllername.php */
/* Location: ./application/controllers/controllername.php */
