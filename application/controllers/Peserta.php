<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Peserta extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if(!($this->session->userdata('id_peserta'))){
			redirect(base_url());
		}
		else if($this->session->userdata('grup') == 'operator ruangan'){
			redirect('operator/dashboard');
		}
		else if($this->session->userdata('grup') == 'operator utama'){
			redirect('operatorv1/dashboard');
		}
		else if($this->session->userdata('grup') == 'administrator'){
			redirect('administrator/dashboard');
		}
		$this->load->model('mpeserta');
		date_default_timezone_set('Asia/Jakarta');
		$this->jmlopsi = 4; // banyaknya opsi tersedia
	}

	public function get_servertime()
	{
		$now = new DateTime(); 
        $dt = $now->format("M j, Y H:i:s O"); 
        json_send($dt);
        exit();
	}

	public function home()
	{
		$a['title'] = 'Beranda - Sistem Ujian Online Pasca Sarjana Universitas Diponegoro';
		$a['v'] = 'peserta/home';
		$a['nama'] = $this->session->userdata('nama_peserta');
		$a['no_ujian'] = $this->session->userdata('no_peserta');
		$this->load->view('peserta/header_footer',$a);
	}

	public function data_pribadi()
	{
		$id_user = $this->session->userdata('id_peserta');
		$hasil = $this->mpeserta->getDataPribadi($id_user);
		$a['title'] = 'Data Pribadi - Sistem Ujian Online Pasca Sarjana Universitas Diponegoro';
		$a['v'] = 'peserta/data_pribadi';
		$a['peserta'] = $hasil;
		$a['nama'] = $this->session->userdata('nama_peserta');
		$a['no_ujian'] = $this->session->userdata('no_peserta');
		$this->load->view('peserta/header_footer',$a);
	}

	public function list_ujian()
	{
		$id_user = $this->session->userdata('id_peserta');
		$no_kursi = $this->session->userdata('kursi_peserta');
		$versi = ($no_kursi % 3) + 1; 
		$data = array('soal.versi' => $versi);
		$hasil = $this->mpeserta->getListUjian($id_user,$data);
		$a['title'] = 'List Ujian - Sistem Ujian Online Pasca Sarjana Universitas Diponegoro';
		$a['v'] = 'peserta/list_ujian';
		$a['hitung'] = $hasil->num_rows();
		$a['list_ujian'] = $hasil->result_array();
		$a['nama'] = $this->session->userdata('nama_peserta');
		$a['no_ujian'] = $this->session->userdata('no_peserta');
		$this->load->view('peserta/header_footer',$a);
	}

	public function persiapan_ujian()
	{
		$uri3 = $this->uri->segment(3);
		$id_user = $this->session->userdata('id_peserta');
		$no_kursi = $this->session->userdata('kursi_peserta');
		$versi = ($no_kursi % 3) + 1;
		$data = array('soal.versi' => $versi,'test.id' => $uri3);
		//cek jika sudah ambil token 
		$session_data = array('hasil_tes.id_tes' => $uri3,'hasil_tes.id_user' => $id_user,'hasil_tes.status' => 'Y'); 
		$check_token = $this->mpeserta->check_data_token($session_data);

		//cek jika ada data soal  
		$check_data = $this->mpeserta->getListUjian($id_user,$data);

		//ambil data aktivasi tes
		$hasil = $this->mpeserta->getPersiapanUjian($uri3,$versi);

		//cek status ujian peserta
		$check_status = $this->mpeserta->status_ujian($id_user,$uri3)->row();

		$fetch = $hasil->row();
		$tgl_mulai = strtotime($fetch->tgl_mulai);
		$tgl_mulai_new = date('F j, Y H:i:s',$tgl_mulai);

		$tgl_terlambat = strtotime("+".$fetch->terlambat." minutes",$tgl_mulai);
		$tgl_terlambat_new = date('F j, Y H:i:s',$tgl_terlambat);

		if($check_data->num_rows() < 1){//cek jika tidak ada data
			redirect('peserta/404','refresh');
		}
		else if($check_token->num_rows() == 1){//cek jika sudah ambil token
			redirect('peserta/soal_ujian/'.$uri3.'');
		}
		else{
			$a['title'] = 'Persiapan Ujian - Sistem Ujian Online Pasca Sarjana Universitas Diponegoro';
			$a['v'] = 'peserta/persiapan_ujian';
			$a['hitung'] = $hasil->num_rows();
			$a['persiapan'] = $hasil->row_array();
			$a['waktu_mulai'] = $tgl_mulai_new;
			$a['waktu_terlambat'] = $tgl_terlambat_new;
			$a['status'] = $check_status->status;
			$a['nama'] = $this->session->userdata('nama_peserta');
			$a['no_ujian'] = $this->session->userdata('no_peserta');
			$this->load->view('peserta/header_footer',$a);
		}
	}

	public function konfirmasi_data()
	{
		$uri3 = $this->uri->segment(3);
		$id_user = $this->session->userdata('id_peserta');
		$no_kursi = $this->session->userdata('kursi_peserta');
		$versi = ($no_kursi % 3) + 1;

		if($this->input->is_ajax_request()){
			$hasil = $this->mpeserta->getPersiapanUjian($uri3,$versi)->row();
			$ambil_data_soal = $this->mpeserta->getDataSoal($uri3,$versi)->result();
			$kategori = $hasil->idkategori;

			//waktu mulai
			$waktu_mulai = new DateTime($hasil->tgl_mulai);
			$waktu_mulai->format("Y-m-d H:i:s");

			//toleransi terlambat
			$waktu_terlambat = new DateTime($hasil->tgl_mulai);
			$menit_terlambat = $hasil->terlambat;
			$waktu_terlambat->modify("+{$menit_terlambat} minutes")->format("Y-m-d H:i:s");

			//waktu sekarang
			$tgl_sekarang = new DateTime("now");
			$tgl_sekarang->format("Y-m-d H:i:s");

			if($waktu_mulai > $tgl_sekarang){
				$data['status'] = 'gagal';
				$data['msg'] = 'Maaf belum saatnya untuk mulai...';
			}
			else if($waktu_terlambat < $tgl_sekarang){
				$data['status'] = 'gagal';
				$data['msg'] = 'Maaf akses ujian sudah ditutup karena anda sudah terlambat...';
			}
			else{
				$list_soal = "";
				$list_jawaban = "";
				if(!empty($ambil_data_soal)){
					foreach ($ambil_data_soal as $soal) {
						$list_soal .= $soal->id.",";
						$list_jawaban .= $soal->id.":,";
					}
				}	

				$list_soal = substr($list_soal,0,-1);
				$list_jawaban = substr($list_jawaban,0,-1);
				$data = array(
					'id_tes' => $uri3, 'id_kategori' => $kategori,'id_user' => $id_user,
					'list_soal' => $list_soal, 'list_jawaban' => $list_jawaban,
					'jml_benar' => '0','status' => 'Y'
				);

				$this->mpeserta->InsertDataSoal($data);

				$data['status'] = 'ok';
				$data['id'] = $hasil->id;
			}

			json_send($data);
			exit();
		}
		else{
			redirect('peserta/404','refresh');
		}
	}

	public function soal_ujian()
	{
		$uri3 = $this->uri->segment(3);
		$id_user = $this->session->userdata('id_peserta');
		$no_kursi = $this->session->userdata('kursi_peserta');
		$versi = ($no_kursi % 3) + 1;

		$opsi_def = array("a","b","c","d");
		$opsi_non_acak = array("a","b","c","d");

		//set session acak jawaban
		if(!($this->session->userdata('acak'))){
			shuffle($opsi_def);
			$this->session->set_userdata('acak',$opsi_def);
			$opsi_acak = $this->session->userdata('acak');
		}
		else{
			$opsi_acak = $this->session->userdata('acak');
		}

		$session_data = array('hasil_tes.id_tes' => $uri3,'hasil_tes.id_user' => $id_user);

		//query check jika sudah ambil token 
		$q_check_token = $this->mpeserta->check_data_token($session_data);
		$ambil_check_token = $q_check_token->row();
		$check_token = $q_check_token->num_rows();

		//query check jika sudah ujian 
		$data_hasil_ujian = array('hasil_tes.id_tes' => $uri3,'hasil_tes.id_user' => $id_user,'hasil_tes.status' => 'N');
		$q_check_sdh_ujian = $this->mpeserta->check_data_token($data_hasil_ujian);
		$check_sdh_ujian = $q_check_sdh_ujian->num_rows();

		if($check_sdh_ujian > 0){ //check jika sudah ujian 
			redirect('peserta/hasil_ujian');
		}
		else if($check_token < 1){//check jika peserta belum konfirmasi token
			redirect('peserta/persiapan_ujian/'.$uri3.'');
		}
		else{//check jika sudah ambil token

			//set waktu
			if($ambil_check_token->tgl_mulai == '0000-00-00 00:00:00'){//jika belum di set
				$hasil = $this->mpeserta->getPersiapanUjian($uri3,$versi)->row();
				$now = date("Y-m-d H:i:s");
				$selesai = convert_menit_to_jam($hasil->waktu);
				$this->mpeserta->setWaktu($session_data,$now,$selesai);
			}
			
			//ambil data
			$session_data = array('hasil_tes.id_tes' => $uri3,'hasil_tes.id_user' => $id_user);
			$q_check_token = $this->mpeserta->check_data_token($session_data);
			$ambil_data = $q_check_token->row();
			$ambil_data_jawaban = explode(',',$ambil_data->list_jawaban);
			$ambil_data_list_soal = $ambil_data->list_soal;
			$ambil_data_kategori = $ambil_data->id_kategori;
			$arr_kondisi = array('versi' => $versi,'kategori' => $ambil_data_kategori);
			$ambil_data_soal = $this->mpeserta->ambil_data_soal($arr_kondisi,$ambil_data_list_soal)->result();

			$ambil_data_tes = $ambil_data;

			$arr_jawab = array();
			foreach($ambil_data_jawaban as $ambil){
				$get_soaljwb = explode(":",$ambil);
				$index = $get_soaljwb[0];
				$value = $get_soaljwb[1];
				if(!empty($value)){
					$value = explode("-", $value);
					$arr_jawab[$index] = $value[0];
				}
				else{
					$arr_jawab[$index] = "";
				}
			}

			$html = '';
			$no = 1;
			if(!empty($ambil_data_soal)){
				foreach ($ambil_data_soal as $soal) {
					$html .= '<div class="step" id="soal_'.$no.'">'.tampil_jawaban($soal->soal).'
							  <input type="hidden" name="id_soal_'.$no.'" value="'.$soal->id.'">
							  <div class="funkyradio">';
					for($j = 0; $j < $this->jmlopsi; $j++){
						$radio = strtoupper($opsi_acak[$j]).'-'.strtoupper($opsi_non_acak[$j]);
						$opsi = 'opsi_'.$opsi_acak[$j];
						$checked = $arr_jawab[$soal->id] == strtoupper($opsi_acak[$j]) ? "checked" : "";
						$html .= '<div class="funkyradio-success">
									<input type="radio" id="opsi_'.strtoupper($opsi_non_acak[$j]).'_'.$soal->id.'" name="opsi_'.$no.'" value="'.$radio.'" '.$checked.'/>
									<label for="opsi_'.strtoupper($opsi_non_acak[$j]).'_'.$soal->id.'" class="radio-jawaban">
									<div class="huruf-opsi">'.strtoupper($opsi_non_acak[$j]).'</div>
								 '.tampil_jawaban($soal->$opsi).'</label></div>';
					}
					$html .= '</div></div>';
					$no++; 
				}	
			}

			$a['jam_mulai'] = $ambil_data->tgl_mulai;
			$a['jam_selesai'] = $ambil_data->tgl_selesai;
			$a['id_tes'] = $ambil_data->id_tes;
			$a['html'] = $html;
			$a['no'] = $no;
			$a['kategori'] = $this->mpeserta->getKategoriTes($ambil_data->id_kategori)->row();
			$a['nama'] = $this->session->userdata('nama_peserta');
			$a['no_ujian'] = $this->session->userdata('no_peserta');
			$this->load->view('peserta/main_ujian',$a);
		}
	}

	public function simpan_jwb()
	{
		$id_user = $this->session->userdata('id_peserta');
		$uri3 = $this->uri->segment(3);
		if($this->input->is_ajax_request()){
			$update = '';
			$jml_soal = $this->input->post('jml_soal',TRUE);
			for($i = 1; $i < $jml_soal; $i++){
				$input_jwb = "opsi_".$i;
				$input_idsoal = "id_soal_".$i;
				$data_jwb = $this->input->post($input_jwb,TRUE);
				$data_idsoal =  $this->input->post($input_idsoal,TRUE);
				$jawaban = empty($data_jwb) ? "" : $data_jwb;
				$update .= "".$data_idsoal.":".$jawaban.",";
			}

			$update = substr($update,0,-1);
			$data['list_jawaban'] = $update;
			$data2 = array('id_tes' => $uri3,'id_user' => $id_user);
			$this->mpeserta->updateJawaban($data,$data2);

			$return_data = $this->mpeserta->getDataJawaban($data2)->row_array();
			$get_only_value = explode(",",$return_data['list_jawaban']);
			$hasil = array();
			foreach ($get_only_value as $key => $value) {
				$pc_value = explode(":", $value);
				if(!empty($pc_value[1])){
					$value = explode("-",$pc_value[1]);
					$hasil[] = $value[1];
				}
				else{
					$hasil[] = "";
				}
			}

			$a['data'] = $hasil;
			$a['status'] = 'ok';
			json_send($a);
			exit();
		}
		else{
			redirect('peserta/404','refresh');
		}
	}

	public function hitung_nilai()
	{
		$id_user = $this->session->userdata('id_peserta');
		$uri3 = $this->uri->segment(3);
		$jumlah_benar = 0;
		if($this->input->is_ajax_request()){
			$this->session->unset_userdata('acak'); // unset session

			//check jika sudah submit
			$dataif_has_submit = array('hasil_tes.id_tes' => $uri3,'hasil_tes.id_user'=>$id_user,'hasil_tes.status'=>'N');
	    	$q_check_if_has_submit = $this->mpeserta->check_data_token($dataif_has_submit);
	    	$check_sudah_submit = $q_check_if_has_submit->num_rows();

	    	if($check_sudah_submit > 0){
	    		$return['status'] = 'gagal';
	    		$return['msg'] = 'Anda sudah submit soal sebelumnya...';
	    	}
	    	else{
				$update = "";
				$jml_soal = $this->input->post('jml_soal',TRUE);
				for($i = 1; $i < $jml_soal; $i++){
					$input_jwb = "opsi_".$i;
					$input_idsoal = "id_soal_".$i;
					$data_jwb = $this->input->post($input_jwb,TRUE);
					$data_idsoal =  $this->input->post($input_idsoal,TRUE);
					if(!empty($data_jwb)){
						$data_jwb = explode("-",$data_jwb);
						$jawaban = $data_jwb[0];
					}
					else{
						$jawaban = "";
					}

					//cek jawaban
					$q_get_jawaban_soal = $this->mpeserta->getJawabanDariSoal($data_idsoal)->row();
					$get_jawaban_soal = $q_get_jawaban_soal->jawaban;
					if($get_jawaban_soal == $jawaban){
						$jumlah_benar++;
					}

					$update .= "".$data_idsoal.":".$jawaban.",";
				}

				$update = substr($update,0,-1);
				$data = array('list_jawaban' => $update,'jml_benar' => $jumlah_benar,'status' => 'N');

				$data2 = array('id_tes' => $uri3,'id_user' => $id_user);
				$this->mpeserta->updateJawaban($data,$data2);
				$return['status'] = 'ok';
			}

			json_send($return);
			exit();
		}
		else{
			redirect('peserta/404','refresh');
		}
	}

	public function hasil_ujian()
	{
		$id_user = $this->session->userdata('id_peserta');
		$hasil=$this->mpeserta->getHasilUjian($id_user);
		$nilai = $this->mpeserta->getNilai($id_user);
		$html = '';
		$fetch_data = $hasil->result_array();
		$i = 1;
        foreach ($fetch_data as $h) {
	        $fetch_soal = explode(",",$h['list_soal']);
			$banyak_soal = count($fetch_soal); 
            $html .= '<tr>';   
            $html .= '<td class="ctr">'.$i++.'</td>';
            $html .= '<td>'.$h['nama_ujian'].'</td>';
            $html .= '<td>'.$h['kategori'].'</td>';
            $html .= '<td>'.$banyak_soal.'</td>';
            $html .= '<td>'.$h['jml_benar'].'</td>';
            $html .= '</tr>';    
        }

        $data['html'] = $html;
        $data['title'] = 'Hasil Ujian - Sistem Ujian Online Pasca Sarjana Universitas Diponegoro';
        $data['jumlah_baris'] = $hasil->num_rows();
        $data['nilai']= $nilai->row();
        $data['jumlah_nilai'] = $nilai->num_rows();
        $data['v'] = 'peserta/hasil_ujian';
        $data['nama'] = $this->session->userdata('nama_peserta');
		$data['no_ujian'] = $this->session->userdata('no_peserta');
		$this->load->view('peserta/header_footer',$data);
    }

    public function persiapan_trial_ujian()
    {
    	$id_user = $this->session->userdata('id_peserta');
    	$hasil = $this->mpeserta->getPersiapanTrialUjian($id_user);
    	$ambil_data = $hasil->row_array();

    	if($ambil_data['status'] == 'Y'){
    		redirect('peserta/main_soal_trial');
    	}
    	else{
    		$data['trial']= $ambil_data;
			$data['trial1']=$this->mpeserta->count_soal()->row_array();
			$data['v'] = 'peserta/persiapan_trial';
			$data['title'] = 'Persiapan Trial - Sistem Ujian Online Pasca Sarjana Universitas Diponegoro';
			$data['nama'] = $this->session->userdata('nama_peserta');
			$data['no_ujian'] = $this->session->userdata('no_peserta');
			$this->load->view('peserta/header_footer',$data);
    	}
    }

    public function main_soal_trial()
    {
    	$id_user = $this->session->userdata('id_peserta');

    	$opsi_non_acak = array("a","b","c","d");
    	$hasil = $this->mpeserta->getPersiapanTrialUjian($id_user)->row();

    	$checksudahtrial = array('hasil_tes_trial.id_user'=>$id_user,'hasil_tes_trial.status'=>'N');
    	$q_check_sudah_trial = $this->mpeserta->check_trial($checksudahtrial);
    	$check_sudah_trial = $q_check_sudah_trial->num_rows();

    	$checkbelumtrial = array('hasil_tes_trial.id_user'=>$id_user,'hasil_tes_trial.status'=>'Y');
    	$q_check_belum_trial = $this->mpeserta->check_trial($checkbelumtrial);
    	$check_belum_trial = $q_check_belum_trial->num_rows();

    	$q_get_soaltrial = $this->mpeserta->get_soaltrial()->result();

    	if($check_sudah_trial > 0){
    		redirect('peserta/persiapan_trial_ujian');
    	}
    	else{
    		//memasukkan soal
    		if($check_belum_trial < 1){
    			$list_soal = "";
				$list_jawaban_trial = "";
	    		if(!empty($q_get_soaltrial)){
	    			foreach($q_get_soaltrial as $datatrial){
	    				$list_soal .= $datatrial->id.",";
						$list_jawaban_trial .= $datatrial->id.":,";
	    			}
	    		}

	    		$list_soal = substr($list_soal,0,-1);
				$list_jawaban_trial = substr($list_jawaban_trial,0,-1);
				$now = date('Y-m-d H:i:s');
				$trial = array(
						'id_tes' => $hasil->id,'id_user' => $id_user,'list_soal' => $list_soal, 
						'list_jawaban' => $list_jawaban_trial,'nilai'=>'0','jumlah_benar' => '0',
						'tgl_mulai' => $now,'status' => 'Y'
				);

				$selesai = convert_menit_to_jam($hasil->waktu);
				$this->mpeserta->InsertDataSoalTrial($trial,$now,$selesai);
			}

			//mengambil data soal
			$checkbelumtrial = array('hasil_tes_trial.id_user'=>$id_user,'hasil_tes_trial.status'=>'Y');
    		$q_check_belum_trial = $this->mpeserta->check_trial($checkbelumtrial);
			$ambil_trial = $q_check_belum_trial->row();
			$ambil_data_jawaban = explode(',',$ambil_trial->list_jawaban);
			$ambil_data_list_soal = $ambil_trial->list_soal;//
			$ambil_data_soal = $this->mpeserta->ambil_soal_trial($ambil_data_list_soal)->result();

			$arr_jawab = array();
			foreach($ambil_data_jawaban as $ambil){
				$get_soaljwb = explode(":",$ambil);
				$index = $get_soaljwb[0];
				$value = $get_soaljwb[1];
				$arr_jawab[$index] = $value;
			}

			$html = '';
			$no = 1;
			if(!empty($ambil_data_soal)){
				foreach ($ambil_data_soal as $soal) {
					$html .= '<div class="step" id="soal_'.$no.'">'.tampil_jawaban($soal->soal).'
							  <input type="hidden" name="id_soal_'.$no.'" value="'.$soal->id.'">
							  <div class="funkyradio">';
					for($j = 0; $j < $this->jmlopsi; $j++){
						$radio = strtoupper($opsi_non_acak[$j]);
						$opsi = 'opsi_'.$opsi_non_acak[$j];
						$checked = $arr_jawab[$soal->id] == strtoupper($opsi_non_acak[$j]) ? "checked" : "";
						$html .= '<div class="funkyradio-success">
								  <input type="radio" id="opsi_'.strtoupper($opsi_non_acak[$j]).'_'.$soal->id.'" name="opsi_'.$no.'" value="'.$radio.'" '.$checked.'/>
								  <label for="opsi_'.strtoupper($opsi_non_acak[$j]).'_'.$soal->id.'" class="radio-jawaban">  
								  <div class="huruf-opsi">'.strtoupper($opsi_non_acak[$j]).'</div>
									 '.tampil_jawaban($soal->$opsi).'</label></div>';
					}
					$html .= '</div></div>';
					$no++; 
				}	
			}

			$a['jam_mulai'] = $ambil_trial->tgl_mulai;
			$a['jam_selesai'] = $ambil_trial->tgl_selesai;
			$a['html'] = $html;
			$a['no'] = $no;
			$a['nama'] = $this->session->userdata('nama_peserta');
			$a['no_ujian'] = $this->session->userdata('no_peserta');
			$this->load->view('peserta/main_trial',$a);
    	}
    }

    public function simpan_jwb_trial()
    {
    	$id_user = $this->session->userdata('id_peserta');
		if($this->input->is_ajax_request()){
			$update = "";
			$jml_soal = $this->input->post('jml_soal',TRUE);
			for($i = 1; $i < $jml_soal; $i++){
				$input_jwb = "opsi_".$i;
				$input_idsoal = "id_soal_".$i;
				$data_jwb = $this->input->post($input_jwb,TRUE);
				$data_idsoal =  $this->input->post($input_idsoal,TRUE);
				$jawaban = empty($data_jwb) ? "" : $data_jwb;
				$update .= "".$data_idsoal.":".$jawaban.",";
			}

			$update = substr($update,0,-1);
			$data['list_jawaban'] = $update;
			$data2 = array('id_user' => $id_user);
			$this->mpeserta->updateJawabanTrial($data,$data2);

			$return_data = $this->mpeserta->getDataJawabanTrial($data2)->row_array();
			$get_only_value = explode(",",$return_data['list_jawaban']);
			$hasil = array();
			foreach ($get_only_value as $key => $value) {
				$pc_value = explode(":", $value);
				$val = $pc_value[1];
				$hasil[] = $val;
			}

			$a['data'] = $hasil;
			$a['status'] = 'ok';
			json_send($a);
			exit();
		}
		else{
			redirect('peserta/404','refresh');
		}
    }

    public function hitung_nilai_trial()
    {
    	$id_user = $this->session->userdata('id_peserta');
		$jumlah_benar = 0;
		if($this->input->is_ajax_request()){
			$dataif_has_submit = array('hasil_tes_trial.id_user'=>$id_user,'hasil_tes_trial.status'=>'N');
	    	$q_check_if_has_submit = $this->mpeserta->check_trial($dataif_has_submit);
	    	$check_sudah_submit = $q_check_if_has_submit->num_rows();
	    	if($check_sudah_submit > 0){
	    		$return['status'] = 'gagal';
	    		$return['msg'] = 'Anda sudah submit soal sebelumnya...';
	    	}
	    	else{
				$update = "";
				$jml_soal = $this->input->post('jml_soal',TRUE);
				for($i = 1; $i < $jml_soal; $i++){
					$input_jwb = "opsi_".$i;
					$input_idsoal = "id_soal_".$i;
					$data_jwb = $this->input->post($input_jwb,TRUE);
					$data_idsoal =  $this->input->post($input_idsoal,TRUE);
					$jawaban = empty($data_jwb) ? "" : $data_jwb;

					//cek jawaban
					$q_get_jawaban_soal = $this->mpeserta->getJawabanDariSoalTrial($data_idsoal)->row();
					$get_jawaban_soal = $q_get_jawaban_soal->jawaban;
					if($get_jawaban_soal == $jawaban){
						$jumlah_benar++;
					}

					$update .= "".$data_idsoal.":".$jawaban.",";
				}

				$nilai = ($jumlah_benar/($jml_soal-1))*100;
				$update = substr($update,0,-1);
				$data = array('list_jawaban' => $update,'nilai' => $nilai,
							  'jumlah_benar' => $jumlah_benar,'status' => 'N');
				$data2 = array('id_user' => $id_user);
				$this->mpeserta->updateJawabanTrial($data,$data2);
				$return['status'] = 'ok';
				$return['msg'] = 'Hasil Nilai Soal Trial :'.$nilai.'';
			}

			json_send($return);
			exit();
		}
		else{
			redirect('peserta/404','refresh');
		}
    }

    public function logout()
    {
    	$id_user = $this->session->userdata('id_peserta');
    	$this->mpeserta->update_status($id_user);
    	$this->session->sess_destroy();
		redirect(base_url());
    }
}

/* End of file Peserta.php */
/* Location: ./application/controllers/Peserta.php */