<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MPeserta extends CI_Model {

	public function getDataPribadi($id)
	{
		$this->db->where("id",$id);
		$query = $this->db->get("peserta");
		return $query->row_array();
	}

	public function getListUjian($id,$data)
	{
		$this->db->select("test.*,kategori.kategori,COUNT(soal.kategori) as jumlah_soal, 
			IF((hasil_tes.status='Y' AND NOW() BETWEEN hasil_tes.tgl_mulai AND hasil_tes.tgl_selesai),'Sedang Tes', 
			IF(hasil_tes.status='Y' AND NOW() NOT BETWEEN hasil_tes.tgl_mulai AND hasil_tes.tgl_selesai,'Waktu Habis',
			IF(hasil_tes.status='N','Selesai','Belum Ikut'))) as status ");
		$this->db->from('test');
		$this->db->join('kategori','test.idkategori = kategori.id');
		$this->db->join('soal','test.idkategori = soal.kategori');
		$this->db->join('hasil_tes',"CONCAT(".$id.",test.id) = CONCAT(hasil_tes.id_user,hasil_tes.id_tes)","left");
		$this->db->where($data);
		$this->db->group_by('test.id');
		$this->db->order_by('test.id',"ASC");
		$query= $this->db->get();
		return $query;
	}

	public function getPersiapanUjian($idtes,$versi)
	{
		$this->db->select("test.*,COUNT(soal.kategori) as jumlah_soal");
		$this->db->from('test');
		$this->db->join('kategori','test.idkategori = kategori.id','inner');
		$this->db->join('soal','test.idkategori = soal.kategori','inner');
		$this->db->where('test.id',$idtes);
		$this->db->where('soal.versi',$versi);
		$query= $this->db->get();
		return $query;	
	}

	public function getKategoriTes($id_tes)
	{
		$this->db->select('kategori.kategori');
		$this->db->from('kategori');
		$this->db->join('test','kategori.id = test.idkategori','inner');
		$this->db->where('test.idkategori',$id_tes);
		$query= $this->db->get();
		return $query;	
	}

	public function check_data_token($data)
	{
		$this->db->where($data);
		$query= $this->db->get('hasil_tes');
		return $query;	
	}

	public function ambil_data_soal($data,$get_list_soal)
	{
		$this->db->select('*');
		$this->db->from('soal');
		$this->db->where($data);
		$this->db->order_by('FIELD(id,'.$get_list_soal.')');
		$query= $this->db->get();
		return $query;
	}

	public function status_ujian($id_user,$uri)
	{
		$this->db->select('test.*,hasil_tes.status'); 
		$this->db->from('test');
		$this->db->join('hasil_tes',"CONCAT(".$id_user.",test.id) = CONCAT(hasil_tes.id_user,hasil_tes.id_tes)","left");
		$this->db->where('test.id',$uri); 
		$query= $this->db->get();
		return $query;	
	}

	public function getDataSoal($idtes,$versi)
	{
		$this->db->select('soal.*');
		$this->db->from('soal');
		$this->db->join('test','test.idkategori = soal.kategori','inner');
		$this->db->where('test.id',$idtes);
		$this->db->where('soal.versi',$versi);
		$this->db->order_by('id','RANDOM');
		$query= $this->db->get();
		return $query;	
	}

	public function InsertDataSoal($data)
	{
		$this->db->insert('hasil_tes',$data);
	}

	public function setWaktu($data,$now,$selesai)
	{
		$this->db->set('tgl_selesai','ADDTIME("'.$now.'","'.$selesai.'")',FALSE);
		$this->db->set('tgl_mulai',$now);
		$this->db->where($data);
		$this->db->update('hasil_tes');
	}
	
	public function updateJawaban($data,$data2)
	{
		$this->db->where($data2);
		$this->db->update('hasil_tes',$data);
	}

	public function getDataJawaban($data)
	{
		$this->db->select('list_jawaban');
		$this->db->from('hasil_tes');
		$this->db->where($data);
		$query= $this->db->get();
		return $query;
	}

	public function getJawabanDariSoal($id_soal)
	{
		$this->db->select('jawaban');
		$this->db->from('soal');
		$this->db->where('id',$id_soal);
		$query= $this->db->get();
		return $query;
	}

	public function getHasilUjian($id)
	{
		$this->db->select("hasil_tes.*,kategori.kategori,test.nama_ujian");
		$this->db->from('hasil_tes');
		$this->db->join('test','hasil_tes.id_tes = test.id','inner');
		$this->db->join('kategori','test.idkategori = kategori.id','inner');
		$this->db->where('hasil_tes.id_user',$id);
		$query= $this->db->get();
		return $query;
	}

	public function getNilai($id)
	{
		$this->db->select("(200+(6*sum(hasil_tes.jml_benar))) as nilai,sum(hasil_tes.jml_benar) as total");
		$this->db->from('hasil_tes');
		$this->db->where('id_user',$id);
		$this->db->group_by('id_user');
		$query= $this->db->get();
		return $query;	
	}

	public function getPersiapanTrialUjian($id_user)
	{
		$this->db->select("test.id, test.nama_ujian, test.waktu,hasil_tes_trial.nilai,hasil_tes_trial.status");
		$this->db->from('test');
		$this->db->join('hasil_tes_trial','CONCAT('.$id_user.',test.id) = CONCAT(hasil_tes_trial.id_user,hasil_tes_trial.id_tes)','left');
		$this->db->where('test.nama_ujian','Test Trial');
		$query= $this->db->get();
		return $query;	 	
	}

	public function count_soal()
	{
		$this->db->select("COUNT(soal_trial.kategori) as jumlah_soal_trial");
		$this->db->from('soal_trial');
		$query= $this->db->get();
		return $query;
	}

	public function check_trial($data)
	{
		$this->db->where($data);
		$query = $this->db->get('hasil_tes_trial');
		return $query;
	}

	public function getkategori($value)
	{
		$this->db->select('kategori');
		$this->db->from('soal_trial');
		$this->db->where('id',$value);
		$query = $this->db->get();
		return $query;
	}

	public function get_soaltrial()
	{
		$this->db->select('id');
		$this->db->from('soal_trial');
		$this->db->order_by('id','RANDOM');
		$query = $this->db->get();
		return $query;
	}

	public function InsertDataSoalTrial($data,$now,$selesai)
	{
		$this->db->set('tgl_selesai','ADDTIME("'.$now.'","'.$selesai.'")',FALSE);
		$this->db->insert('hasil_tes_trial',$data);
	}

	public function ambil_soal_trial($data)
	{
		$this->db->select('*');
		$this->db->from('soal_trial');
		$this->db->order_by('FIELD(id,'.$data.')');
		$query= $this->db->get();
		return $query;
	}

	public function updateJawabanTrial($data,$data2)
	{
		$this->db->where($data2);
		$this->db->update('hasil_tes_trial',$data);
	}

	public function getDataJawabanTrial($data)
	{
		$this->db->select('list_jawaban');
		$this->db->from('hasil_tes_trial');
		$this->db->where($data);
		$query= $this->db->get();
		return $query;
	}

	public function getJawabanDariSoalTrial($id_soal)
	{
		$this->db->select('jawaban');
		$this->db->from('soal_trial');
		$this->db->where('id',$id_soal);
		$query= $this->db->get();
		return $query;
	}

	public function update_status($id)
	{
		$this->db->where('id',$id);
		$this->db->update('peserta',array('status' => '0'));
	}
}

/* End of file MPeserta.php */
/* Location: ./application/models/MPeserta.php */