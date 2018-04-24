<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Import extends CI_Controller {

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
		
		$this->load->model('mimport');
		date_default_timezone_set("Asia/Jakarta");
	}

	public function siswa()
	{
		$filename = $_FILES['import_excel']['name'];
		$tmp = $_FILES['import_excel']['tmp_name'];
		$target_file = './upload/excel/';
        $buat_folder_temp = !is_dir($target_file) ? @mkdir("./upload/excel/") : false;
        $file = explode('.', $filename);
        $length = count($file);

        if($file[$length - 1] == 'xlsx' || $file[$length - 1] == 'xls'){
        	move_uploaded_file($tmp, $target_file.$filename);
        	$temporary = $target_file.$filename;
        	$sql = array();

        	require_once(APPPATH.'third_party/PHPExcel-1.8.1/Classes/PHPExcel.php');
        	require_once(APPPATH.'third_party/PHPExcel-1.8.1/Classes/PHPExcel/IOFactory.php');

        	$read  = PHPExcel_IOFactory::createReaderForFile($temporary);
            $read->setReadDataOnly(true);
            $objPHPExcel  = $read->load($temporary);
            $objWorksheet = $objPHPExcel->setActiveSheetIndex(0); 
            $highestRow = $objPHPExcel->getActiveSheet()->getHighestDataRow();
            $highestColumn = $objPHPExcel->getActiveSheet()->getHighestDataColumn();
            $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
            for ($row = 2; $row <= $highestRow; ++$row) {
				$val=array();
				for ($col = 0; $col <= $highestColumnIndex; ++$col) {
					$cell = $objWorksheet->getCellByColumnAndRow($col, $row);
					if ($col != 6){
				    	$val[] = $cell->getValue();
					}
					else{
						$val[] =  date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($cell->getValue()));
					}
				    
				}
				$sql[] = array( 
					'nama' => strtoupper($val[0]), 
					'no_peserta' => $val[1], 
					'no_kursi' => $val[2],
					'periode' => strtoupper($val[3]),
					'kode_prodi' => $val[4],
					'pilih_prodi' => strtoupper($val[5]),
					'tgl_lahir' => $val[6]
				);
        	}

        	$this->mimport->InsertBatch($sql);
        	$this->session->set_flashdata('sukses','Data berhasil diimport');
			redirect('administrator/datapeserta');
		}
		else{
			$this->session->set_flashdata('gagal', 'Maaf data gagal terunggah , pastikan data anda sesuai dengan aturan di info');
			redirect('administrator/datapeserta/import');
		}
	}

	public function soaltrial()
	{
		$filename = $_FILES['import_trial']['name'];
		$tmp = $_FILES['import_trial']['tmp_name'];
		$target_file = './upload/excel/';
        $buat_folder_temp = !is_dir($target_file) ? @mkdir("./upload/excel/") : false;
        $file = explode('.', $filename);
        $length = count($file);
        if($file[$length - 1] == 'xlsx' || $file[$length - 1] == 'xls'){
        	move_uploaded_file($tmp, $target_file.$filename);
        	$temporary = $target_file.$filename;
        	$sql = array();

        	require_once(APPPATH.'third_party/PHPExcel-1.8.1/Classes/PHPExcel.php');
        	require_once(APPPATH.'third_party/PHPExcel-1.8.1/Classes/PHPExcel/IOFactory.php');

        	$read  = PHPExcel_IOFactory::createReaderForFile($temporary);
            $read->setReadDataOnly(true);
            $objPHPExcel  = $read->load($temporary);
            $objWorksheet = $objPHPExcel->setActiveSheetIndex(0); 
            $highestRow = $objPHPExcel->getActiveSheet()->getHighestDataRow();
            $highestColumn = $objPHPExcel->getActiveSheet()->getHighestDataColumn();
            $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
            for ($row = 2; $row <= $highestRow; ++$row) {
				$val=array();
				for ($col = 0; $col <= $highestColumnIndex; ++$col) {
					$cell = $objWorksheet->getCellByColumnAndRow($col, $row);
				    $val[] = $cell->getValue();				    
				}
				$sql[] = array(
					'kategori' => $val[0],'soal' => $val[1],'opsi_a' => $val[2],'opsi_b' => $val[3],
					'opsi_c' => $val[4],'opsi_d' => $val[5],'jawaban' => strtoupper($val[6]),
					'tgl_input' => date("Y-m-d H:i:s")
				);	
        	}

        	$this->mimport->InsertTrial($sql);

        	$this->session->set_flashdata('sukses','Data berhasil diimport');
			redirect('administrator/soaltrial');
        	
		}
		else{
			$this->session->set_flashdata('gagal', 'Maaf data gagal terunggah , pastikan data anda sesuai dengan aturan di info');
			redirect('administrator/soaltrial/importtrial');	
		}
	}

	public function soal(){
		$kategori = $this->input->post('kategori',TRUE);
		$versi = $this->input->post('versi',TRUE);
		$filename = $_FILES['import_soalversi1']['name'];
		$tmp = $_FILES['import_soalversi1']['tmp_name'];
		$target_file = './upload/excel/';
        $buat_folder_temp = !is_dir($target_file) ? @mkdir("./upload/excel/") : false;
        $file = explode('.', $filename);
        $length = count($file);
        if($file[$length - 1] == 'xlsx' || $file[$length - 1] == 'xls'){
        	move_uploaded_file($tmp, $target_file.$filename);
        	$temporary = $target_file.$filename;
        	$sql = array();

        	require_once(APPPATH.'third_party/PHPExcel-1.8.1/Classes/PHPExcel.php');
        	require_once(APPPATH.'third_party/PHPExcel-1.8.1/Classes/PHPExcel/IOFactory.php');

        	$read  = PHPExcel_IOFactory::createReaderForFile($temporary);
            $read->setReadDataOnly(true);
            $objPHPExcel  = $read->load($temporary);
            $objWorksheet = $objPHPExcel->setActiveSheetIndex(0); 
            $highestRow = $objPHPExcel->getActiveSheet()->getHighestDataRow();
            $highestColumn = $objPHPExcel->getActiveSheet()->getHighestDataColumn();
            $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
            for ($row = 2; $row <= $highestRow; ++$row) {
				$val=array();
				for ($col = 0; $col <= $highestColumnIndex; ++$col) {
					$cell = $objWorksheet->getCellByColumnAndRow($col, $row);
				    $val[] = $cell->getValue();				    
				}
				$sql[] = array(
					'versi' => $versi,'kategori' => $kategori,'soal' => $val[0],'opsi_a' => $val[1],
					'opsi_b' => $val[2],'opsi_c' => $val[3],'opsi_d' => $val[4],
					'jawaban' => strtoupper($val[5]),'tgl_input' => date("Y-m-d H:i:s")
				);	
        	}

        	$this->mimport->InsertSoal($sql);

        	if($versi == '1'){
        		$this->session->set_flashdata('sukses','Data berhasil diimport');
				redirect('administrator/banksoalv1');
        	}
        	else if ($versi == '2'){
        		$this->session->set_flashdata('sukses','Data berhasil diimport');
				redirect('administrator/banksoalv2');
        	}
        	else if($versi == '3'){
        		$this->session->set_flashdata('sukses','Data berhasil diimport');
				redirect('administrator/banksoalv3');
        	}
        	else{
        		exit('not found');
        	}
        	
		}
		else{
			if($versi == '1'){
				$this->session->set_flashdata('gagal', 'Maaf data gagal terunggah , pastikan data anda sesuai dengan aturan di info');
				redirect('administrator/banksoalv1/import');
			}
			else if($versi == '2'){
				$this->session->set_flashdata('gagal', 'Maaf data gagal terunggah , pastikan data anda sesuai dengan aturan di info');
				redirect('administrator/banksoalv2/import');
			}
			else if($versi == '3'){
				$this->session->set_flashdata('gagal', 'Maaf data gagal terunggah , pastikan data anda sesuai dengan aturan di info');
				redirect('administrator/banksoalv3/import');
			}
			else{
				exit('not found');
			}	
		}
	}

	// public function test()
	// {
	// 	$data = $this->mimport->tesawdt();
	// 	json_send($data);
	// }
}

/* End of file Import.php */
/* Location: ./application/controllers/Import.php */