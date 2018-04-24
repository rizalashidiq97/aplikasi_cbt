<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Export extends CI_Controller {

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
		
		$this->load->model('mexport');
	}

	public function excel()
	{
		$uri3 = $this->uri->segment(3);
		$hasil = $this->mexport->datarekap($uri3);
		if ($hasil->num_rows() == 0){
			exit('belum ada data yang akan di export');// redirect('administrator/404');
		}
		else{
			require_once(APPPATH.'third_party/PHPExcel-1.8.1/Classes/PHPExcel.php');
			require_once(APPPATH.'third_party/PHPExcel-1.8.1/Classes/PHPExcel/Writer/Excel2007.php');

			$fetch = $hasil->result();

			$Excel = new PHPExcel();
			$Excel->setActiveSheetIndex(0);
			if(isset($uri3)){
				$Excel->getActiveSheet()->setCellValue('A1','REKAP DATA LAPORAN PERIODE '.romawi_converter($uri3).'');
				$filename = 'Rekap Data Laporan TPA Periode '.romawi_converter($uri3).'.xlsx';
			}
			else{
				$Excel->getActiveSheet()->setCellValue('A1','REKAP DATA LAPORAN LENGKAP');
				$filename = 'Rekap Data Laporan TPA.xlsx';
			}
			
			$Excel->getActiveSheet()->setCellValue('A2','TEST POTENSI AKADEMIK (TPA)');
			$Excel->getActiveSheet()->setCellValue('A3','UNIVERSITAS DIPONEGORO');
			$Excel->getActiveSheet()->mergeCells('A1:F1');
			$Excel->getActiveSheet()->mergeCells('A2:F2');
			$Excel->getActiveSheet()->mergeCells('A3:F3');
			$Excel->getActiveSheet()
				->setCellValue('A5','Id')
				->setCellValue('B5','Nama')
				->setCellValue('C5','No Peserta')
				->setCellValue('D5','Prodi Pilihan')
				->setCellValue('E5','Periode')
				->setCellValue('F5','Laporan');

			$baris = 6;
			foreach ($fetch as $row) {
				$Excel->getActiveSheet()
					->setCellValue('A'.$baris,$row->id)
		           	->setCellValue('B'.$baris,$row->nama)
		          	->setCellValue('C'.$baris,$row->no_peserta)
		           	->setCellValue('D'.$baris,$row->pilih_prodi)
		           	->setCellValue('E'.$baris,$row->periode)
		           	->setCellValue('F'.$baris,removetag($row->laporan));
		        $baris++;
			}
				
			$Excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
			$Excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
			$Excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
			$Excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
			$Excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
			$Excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);

			$Excel->getActiveSheet()->getStyle('A5:F'.($baris - 1))->applyFromArray(
				array(
					'borders' => array(
						'outline' => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN
						),
						'vertical' => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN
						),
						'alignment' => array(
			            	'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
			        	)
					)
				)
			);

			$Excel->getActiveSheet()->getStyle('A5:F'.($baris - 1))->getAlignment()->setWrapText(true);
			$Excel->getActiveSheet()->getStyle('A1:A3')->applyFromArray(
				array(
					'font' =>array(
						'size' => '12',
						'bold' => true
					),
					'alignment' => array(
			            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			        ),
				)
			);

			$Excel->getActiveSheet()->getStyle('A5:F5')->applyFromArray(
				array(
					'font' => array(
						'bold' => true
					),
					'borders' => array(
						'allborders' => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN
						)
					),
					'alignment' => array(
			            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			        ) 
				)
			);

			
			ob_clean();
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'); 
			header('Content-Disposition: attachment;filename="'.$filename.'"'); 
			header('Cache-Control: max-age=0'); 
			$objWriter = PHPExcel_IOFactory::createWriter($Excel,'Excel2007'); 
			$objWriter->save('php://output');
			exit();
		}
	}

	public function excelrata2()
	{
		$uri3 = $this->uri->segment(3);
		$id = $uri3;
		$hasil = $this->mexport->datarekaprata2($id);
		if ($id != ""){
			exit('data yang anda cari tidak ada');
		}
		else{
			require_once(APPPATH.'third_party/PHPExcel-1.8.1/Classes/PHPExcel.php');
			require_once(APPPATH.'third_party/PHPExcel-1.8.1/Classes/PHPExcel/Writer/Excel2007.php');

			$fetch = $hasil->result();

			$Excel = new PHPExcel();
			$Excel->setActiveSheetIndex(0);

			$Excel->getActiveSheet()->setCellValue('A1','REKAP NILAI UJIAN');
			$Excel->getActiveSheet()->setCellValue('A2','TEST POTENSI AKADEMIK (TPA)');
			$Excel->getActiveSheet()->setCellValue('A3','UNIVERSITAS DIPONEGORO');
			$Excel->getActiveSheet()->mergeCells('A1:G1');
			$Excel->getActiveSheet()->mergeCells('A2:G2');
			$Excel->getActiveSheet()->mergeCells('A3:G3');
			$Excel->getActiveSheet()
				->setCellValue('A5','Id')
				->setCellValue('B5','Nama')
				->setCellValue('C5','No Peserta')
				->setCellValue('D5','Kode Prodi')
				->setCellValue('E5','Prodi Pilihan')
				->setCellValue('F5','Periode')
				->setCellValue('G5','Nilai');

			$baris = 6;
			foreach ($fetch as $row) {
				$Excel->getActiveSheet()
					->setCellValue('A'.$baris,$row->id)
		           	->setCellValue('B'.$baris,$row->nama)
		          	->setCellValue('C'.$baris,$row->no_peserta)
		           	->setCellValue('D'.$baris,$row->kode_prodi)
		           	->setCellValue('E'.$baris,$row->pilih_prodi)
		           	->setCellValue('F'.$baris,$row->periode)
		           	->setCellValue('G'.$baris,$row->sum);
		        $baris++;
			}
				
			$Excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
			$Excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
			$Excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
			$Excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
			$Excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
			$Excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
			$Excel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);

			$Excel->getActiveSheet()->getStyle('A5:G'.($baris - 1))->applyFromArray(
				array(
					'borders' => array(
						'outline' => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN
						),
						'vertical' => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN
						)
					),
					'alignment' => array(
			            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
			        )
				)
			);

			$Excel->getActiveSheet()->getStyle('A1:A3')->applyFromArray(
				array(
					'font' =>array(
						'size' => '12',
						'bold' => true
					),
					'alignment' => array(
			            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			        ),
				)
			);

			$Excel->getActiveSheet()->getStyle('A5:G5')->applyFromArray(
				array(
					'font' => array(
						'bold' => true
					),
					'borders' => array(
						'allborders' => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN
						)
					),
					'alignment' => array(
			            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			        ) 
				)
			);

			$filename = 'Rekap Nilai TPA.xlsx';
			ob_clean();
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'); 
			header('Content-Disposition: attachment;filename="'.$filename.'"'); 
			header('Cache-Control: max-age=0'); 
			$objWriter = PHPExcel_IOFactory::createWriter($Excel,'Excel2007'); 
			$objWriter->save('php://output');
			exit();
		}
	}

	public function exceltrial()
	{
		$uri3 = $this->uri->segment(3);
		$id = $uri3;
		$hasil = $this->mexport->datatrial();
		if ($id != ""){
			exit('data yang anda cari tidak ada');
		}
		else{
			require_once(APPPATH.'third_party/PHPExcel-1.8.1/Classes/PHPExcel.php');
			require_once(APPPATH.'third_party/PHPExcel-1.8.1/Classes/PHPExcel/Writer/Excel2007.php');

			$fetch = $hasil->result();

			$Excel = new PHPExcel();
			$Excel->setActiveSheetIndex(0);

			$Excel->getActiveSheet()->setCellValue('A1','REKAP NILAI TRIAL');
			$Excel->getActiveSheet()->setCellValue('A2','TEST POTENSI AKADEMIK (TPA)');
			$Excel->getActiveSheet()->setCellValue('A3','UNIVERSITAS DIPONEGORO');
			$Excel->getActiveSheet()->mergeCells('A1:G1');
			$Excel->getActiveSheet()->mergeCells('A2:G2');
			$Excel->getActiveSheet()->mergeCells('A3:G3');
			$Excel->getActiveSheet()
				->setCellValue('A5','Id')
				->setCellValue('B5','Nama')
				->setCellValue('C5','No Peserta')
				->setCellValue('D5','Kode Prodi')
				->setCellValue('E5','Prodi Pilihan')
				->setCellValue('F5','Periode')
				->setCellValue('G5','Nilai');

			$baris = 6;
			foreach ($fetch as $row) {
				$Excel->getActiveSheet()
					->setCellValue('A'.$baris,$row->id)
		           	->setCellValue('B'.$baris,$row->nama)
		          	->setCellValue('C'.$baris,$row->no_peserta)
		           	->setCellValue('D'.$baris,$row->kode_prodi)
		           	->setCellValue('E'.$baris,$row->pilih_prodi)
		           	->setCellValue('F'.$baris,$row->periode)
		           	->setCellValue('G'.$baris,$row->nilai);
		        $baris++;
			}
				
			$Excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
			$Excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
			$Excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
			$Excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
			$Excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
			$Excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
			$Excel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);

			$Excel->getActiveSheet()->getStyle('A5:G'.($baris - 1))->applyFromArray(
				array(
					'borders' => array(
						'outline' => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN
						),
						'vertical' => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN
						)
					),
					'alignment' => array(
			            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
			        )
				)
			);

			$Excel->getActiveSheet()->getStyle('A1:A3')->applyFromArray(
				array(
					'font' =>array(
						'size' => '12',
						'bold' => true
					),
					'alignment' => array(
			            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			        ),
				)
			);

			$Excel->getActiveSheet()->getStyle('A5:G5')->applyFromArray(
				array(
					'font' => array(
						'bold' => true
					),
					'borders' => array(
						'allborders' => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN
						)
					),
					'alignment' => array(
			            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			        ) 
				)
			);

			$filename = 'Rekap Nilai Trial.xlsx';
			ob_clean();
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'); 
			header('Content-Disposition: attachment;filename="'.$filename.'"'); 
			header('Cache-Control: max-age=0'); 
			$objWriter = PHPExcel_IOFactory::createWriter($Excel,'Excel2007'); 
			$objWriter->save('php://output');
			exit();
		}
	}
}

/* End of file Export.php */
/* Location: ./application/controllers/Export.php */