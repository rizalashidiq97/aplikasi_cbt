<?php
defined('BASEPATH') OR exit('No direct script access allowed');

	function json_send($data) {
		header('Content-Type: application/json');
		echo json_encode($data);
	}

	function object_to_array($object,$pilihan){
		$pilih = explode(",", $pilihan);
		$array = array("" => "-");
		foreach ($object as $obj) {
			$pilih1 = $pilih[0];
			$fetch_pilih1 = $obj->$pilih1;
			$pilih2 = $pilih[1];

			$array[$fetch_pilih1] = $obj->$pilih2;
		}

		return $array;
	}

	function convert_menit_to_jam($menit) {
		$str = "";
		if ($menit < 60) {
			$str = "00:".str_pad($menit, 2, "0", STR_PAD_LEFT).":00";
		} else if ($menit >= 60) {
			$mod = $menit % 60;
			$bg = floor($menit / 60);
			$str = str_pad($bg, 2, "0", STR_PAD_LEFT).":".str_pad($mod, 2, "0", STR_PAD_LEFT).":00";
		} 
		return $str;
	}

	function timehelper ($tgl, $tipe) {
		if ($tgl != "0000-00-00 00:00:00") {
			$tanggal	= explode(" ", $tgl);
			if (count($tanggal) < 2) {	
				$ambiltgl	= $tanggal[0];
				$waktu		= "";
			} else {
				$waktu		= $tanggal[1];
				$ambiltgl	= $tanggal[0];
			}

			$temptgl	= explode("-", $ambiltgl);
			$tglbaru	= $temptgl[2];
			$blnbaru	= $temptgl[1];
			$thnbaru	= $temptgl[0];

			$bln_pendek		= array("Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Ags", "Sep", "Okt", "Nov", "Des");
			$bln_panjang	= array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");

			$bln_angka		= intval($blnbaru) - 1;

			if ($tipe == "l") {
				$bln_txt = $bln_panjang[$bln_angka];
			} else if ($tipe == "s") {
				$bln_txt = $bln_pendek[$bln_angka];
			}

			return $tglbaru." ".$bln_txt." ".$thnbaru." ".$waktu;
		} else {
			return "Tgl Salah";
		}
	}

	function tanggal_indo($tanggal, $cetak_hari = false)
	{
		$hari = array ( 1 => 'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu');	
		$bulan = array (1 => 'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus',
				'September','Oktober','November','Desember');
		$split 	  = explode('-', $tanggal);
		$tgl_indo = $split[2] . ' ' . $bulan[(int)$split[1]] . ' ' . $split[0];
	
		if ($cetak_hari) {
			$num = date('N', strtotime($tanggal));
			return $hari[$num] . ', ' . $tgl_indo;
		}
		return $tgl_indo;
	}
	
	function xss_clean_filter($data){
		if(strpos($data,'script') !== FALSE){
			return true;
		}
		else{
			return false;
		}
	}
	function tampil_jawaban($data,$froala = false){
		if($froala){
			return $data;
		}
		else{
			$html = $data;
			$dom = new DOMDocument('1.0','UTF-8');
			$dom->loadHTML($html,LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
			$xpath = new DOMXPath($dom);
			$imgs = $xpath->query('//img');

			foreach ($imgs as $img) {
				$img->removeAttribute('style');
				$img->removeAttribute('class');
			}

			$fetch = $dom->saveHTML();
			return '<div>'.$fetch.'</div>';
		}
	}

	function removetag($data){
		return strip_tags($data);
	}

	function romawi_converter($n){
		$hasil = "";
		$iromawi = array("","I","II","III","IV","V","VI","VII","VIII","IX","X",20 => "XX",30 => "XXX",40 => "XL", 50 => "L",60=>"LX",70=>"LXX",80=>"LXXX",90=>"XC",100=>"C",200=>"CC",
			300=>"CCC",400=>"CD",500=>"D",600=>"DC",700=>"DCC",800=>"DCCC",900=>"CM",1000=>"M",
			2000=>"MM",3000=>"MMM",4000=>"MMMM");

		if(array_key_exists($n,$iromawi)){
			$hasil = $iromawi[$n];
		}elseif($n >= 11 && $n <= 99){
			$i = $n % 10;
			$hasil = $iromawi[$n-$i].romawi_converter($n % 10);
		}elseif($n >= 101 && $n <= 999){
			$i = $n % 100;
			$hasil = $iromawi[$n-$i].romawi_converter($n % 100);
		}elseif($n >= 1001 && $n <= 4999){
			$i = $n % 1000;
			$hasil = $iromawi[$n-$i].romawi_converter($n % 1000);
		}
		else{
			$hasil = "data hanya dari 1 - 4999";
		}

		return $hasil;
	}

/* End of file my_helper.php */
/* Location: ./application/helpers/my_helper.php */