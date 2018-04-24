<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Operatorv1 extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if(!($this->session->userdata('id'))){
			redirect('auth');
		}
		else if($this->session->userdata('grup') == 'operator ruangan'){
			redirect('operator/dashboard');
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
		$this->load->model('moperatorv1');
	}

	public function tatib()
	{
		$a['user'] = $this->user;
		$a['grup'] = $this->grup;
		$a['v'] = 'operatorv1/tatib';
		$a['title'] = 'Tata Tertib - Sistem Ujian Online Universitas Diponegoro'; 
		$this->load->view('operatorv1/header_footer',$a);
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
			$cek_pass = $this->moperatorv1->getDataUser($id)->row();
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
				$this->moperatorv1->update_pass($id,$data);
				$return["status"] = "ok";
				$return["msg"] = "Update Password Berhasil !";
			}
			json_send($return);
			exit();
		}
		else{
			$hasil = $this->moperatorv1->getDataUser($id)->row();
			$fetch = $hasil->username;
			$return['data'] = $fetch;
			json_send($return);
			exit();
		}
	}

	public function dashboard()
	{
		$uri3 = $this->uri->segment(3);
		if($uri3 == "progress"){
			$str = "";
			$hasil = $this->moperatorv1->CheckUjian();
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
					$return['angka'] = $i.' dari '.$count.' soal yang diujikan';
					$return['kategori'] = "Belum ada soal yang sudah selesai pada saat ini";
				}
				else{
					$return['angka'] = $i.' dari '.$count.' soal yang diujikan';
					$return['kategori'] = substr($str,0,-1);
				}
			}
			json_send($return);
			exit();
		}
		else{
			$a['user'] = $this->user;
			$a['grup'] = $this->grup;
			$a['v'] = 'operatorv1/dashboard';
			$a['title'] = 'Dashboard - Sistem Ujian Online Universitas Diponegoro'; 
		}

		$this->load->view('operatorv1/header_footer',$a);
	}

	public function daftar_peserta()
	{
		$uri3 = $this->uri->segment(3);
		$uri4 = $this->uri->segment(4);

		if($uri3 == 'data_rekap_rata2'){
			$draw = $this->input->post('draw',TRUE);
			$search = $this->input->post('search',TRUE);
			$length = $this->input->post('length',TRUE);
			$start = $this->input->post('start',TRUE);
			$order = $this->input->post('order',TRUE);
			$category = $this->input->post('data',TRUE);

			$hasil = $this->moperatorv1->getDataNilaiRata($search,$length,$start,$order,$category);

			$send_data = array();
			$baris = ($start + 1);
        	foreach ($hasil as $row) {
	            $data = array();
	            $data[] = $row->id;
	            $data[] = $row->nama;
	            $data[] = $row->no_peserta;
	            $data[] = $row->periode;
	            $data[] = '<a href="'.base_url().'operatorv1/cetaksertif/'.$row->id.'" class="btn btn-danger btn-sm" style="margin-top: 5px;" target="_blank"><i class="fa fa-print" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Cetak Sertifikat</a>';
            	$send_data[] = $data;
        	}

        	$output = array(
                        "draw" => intval($draw),
                        "recordsTotal" => $this->moperatorv1->getAllDataNilaiRata(),
                        "recordsFiltered" => $this->moperatorv1->getDataFilteredNilaiRata($search,$length,$start,$order,$category),
                        "data" => $send_data
                );
			json_send($output);
	       	exit();
		}else{
			$a['user'] = $this->user;
			$a['grup'] = $this->grup;
			$a['v'] = 'operatorv1/list_peserta';
			$a['periode'] = $this->moperatorv1->getPeriode()->result_array();
			$a['title'] = 'List Peserta - Sistem Ujian Online Universitas Diponegoro';
		}

		$this->load->view('operatorv1/header_footer',$a);
	}

	public function cetaksertif()
	{
		$uri3 = $this->uri->segment(3);
		$id = $uri3;
		$hasil = $this->moperatorv1->datarekaprata2($id);
		if ($hasil->num_rows() == 0) {
			exit('404 Page Not Found');
		}
		else{
			$data = $hasil->row(); 
			$datakategori = $this->moperatorv1->getJmlBenar($id)->result();
			require_once(APPPATH.'third_party/fpdf181/fpdf.php');		        
			$pdf = new FPDF('P','mm','A4');
			$judul = array(
				'NAMA' => strtoupper($data->nama),
				'TANGGAL LAHIR' => strtoupper(tanggal_indo($data->tgl_lahir)),
				'NO PESERTA' => $data->no_peserta,
				'TANGGAL UJIAN' => strtoupper(tanggal_indo(date('Y-m-d'))),
				'SKOR NILAI' => $data->sum
			);
			$pdf->AddPage();

			//header
			$pdf->SetFont('Arial','B',20);
			$pdf->Image('./assets/img/logo undip.png',10,10,-300);
			$pdf->Cell(77);$pdf->Cell(20,10,'SELEKSI TEST POTENSI AKADEMIK',0,1,'C');
			$pdf->Cell(64.5);$pdf->Cell(20,12,'UNIVERSITAS DIPONEGORO',0,1,'C');
			$pdf->setLineWidth(1.3);
			$pdf->Line(36,35,197,35);
			$pdf->SetFont('Arial','B',14);

			//title
			$pdf->Cell(84.5);$pdf->Cell(20,32,'SERTIFIKAT',0,1,'C');
			$pdf->Cell(84.5);$pdf->Cell(20,-15,'TEST POTENSI AKADEMIK (TPA)',0,1,'C');
			$pdf->Cell(84.5);$pdf->Cell(20,32,'UNIVERSITAS DIPONEGORO',0,1,'C');
			$pdf->SetFont('Arial','B',12);
			$pdf->Cell(84.5);$pdf->Cell(20,-15,'No.'.$data->no_kursi.'/'.romawi_converter($data->periode).'/'.date('m').'/'.date('Y').'',0,1,'C');
			$pdf->setLineWidth(0.3);
			$pdf->setY(85);
			$pdf->SetFont('Arial','B',10);

			//tabel
			foreach($judul as $key => $value){
				$pdf->Cell(3);
				$pdf->Cell(50,10,'  '.$key,1,0);
				$pdf->Cell(5,10,':',1,0,'C');
				$pdf->Cell(128,10,'  '.$value,1,0);
				$pdf->Ln();
			}

			$pdf->setY(145);
			$pdf->Cell(2);$pdf->Cell(50,10,'Kategori :',0,1);
			//nilai benar
			foreach ($datakategori as $key) {
				$pdf->Cell(3);
				$pdf->Cell(40,10,'  '.ucwords(strtolower($key->kategori)),1,0);
				$pdf->Cell(5,10,':',1,0,'C');
				$pdf->Cell(25,10,'  '.$key->jumlah,1,0);
				$pdf->Ln();
			}

			//ttd
			$pdf->setY(190);
			$pdf->Cell(127);$pdf->Cell(20,20,'Semarang, ',0,0,'C');
			$pdf->Cell(25,20,''.tanggal_indo(date('Y-m-d')).'',0,0,'C');
			$pdf->Cell(-67,50,'Ketua LP2MP',0,1,'C');
			$pdf->Image('./assets/img/ttd.png',137,220,-280);
			$pdf->setX(160);$pdf->Cell(7,0,'Prof. Ir. Edy Rianto, M.Sc, Ph.D',0,1,'C');
			$pdf->setX(155);$pdf->Cell(11,10,'NIP. 19590914 198312 1 001',0,1,'C');

			//footer
			$pdf->SetAutoPageBreak(false);
			$pdf->SetFont('Arial','B',15);
			$pdf->SetDrawColor(179, 179, 179);
	    	$pdf->SetTextColor(220,50,50);
	    	$pdf->SetFillColor(115, 115, 115);
	    	$pdf->SetLineWidth(1.3);
	    	$pdf->setY(262);
			$pdf->Cell(3);$pdf->Cell(184,22,'',1,1,'C',true);
			$pdf->SetFont('Arial','B',10);
			$pdf->SetTextColor(255, 255, 255);
			$pdf->setY(262);
			$pdf->Cell(5);
			$pdf->Cell(124,10,'Gedung ICT, Jl. Prof. Soedharto SH Kampus Undip Tembalang Semarang',0,1,'C');
			$pdf->Cell(78,2,'Telp. (024) 7460031 Faks. (024) 7460033',0,1,'C');
			$pdf->Cell(121,10,'Email : lp2mp@live.undip.ac.id Website : www.lp2mp.undip.ac.id',0,1,'C');
			$pdf->setTitle('Cetak Sertifikat');
			$pdf->Output();
		}
	}

	public function logout()
	{
		$this->session->sess_destroy();
		redirect("authenticate_cat",'refresh');
	}
}

/* End of file Operatorv1.php */
/* Location: ./application/controllers/Operatorv1.php */