<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MOperator extends CI_Model {

	var $column_search = array('peserta.id','peserta.nama','peserta.no_peserta','peserta.pilih_prodi','peserta.periode');
    private function QueryDataListPeserta($search,$length,$start,$sess)
    {   
        $this->db->select('peserta.id,nama,no_peserta,pilih_prodi,periode');
		$this->db->from('peserta');
		$this->db->join('ruang','peserta.no_kursi = ruang.no_kursi','inner');
		$this->db->where($sess);	

        $i = 0;     
        foreach ($this->column_search as $item) // loop column 
        {
            if($search['value']) // if datatable send POST for search
            {              
                if($i===0) // first loop
                {
                    $this->db->group_start(); 
                    $this->db->like($item, $search['value']);
                }
                else
                {
                    $this->db->or_like($item, $search['value']);
                }
                if(count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }        
    }

    public function getListPeserta($search,$length,$start,$sess)
    {
        $this->QueryDataListPeserta($search,$length,$start,$sess);
        $this->db->limit($length, $start);
        $query = $this->db->get();
        return $query->result();
    }
 
    function getDataFilteredListPeserta($search,$length,$start,$sess)
    {
        $this->QueryDataListPeserta($search,$length,$start,$sess);
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function getAllDataPeserta($sess)
    {
         $this->db->select('peserta.id,nama,no_peserta,pilih_prodi,periode');
        $this->db->from('peserta');
        $this->db->join('ruang','peserta.no_kursi = ruang.no_kursi','inner');
		$this->db->where($sess);
        return $this->db->count_all_results();
    }

    public function checkdataExist($check){
        $this->db->select('peserta.id,nama,no_peserta,pilih_prodi,periode');
        $this->db->from('peserta');
        $this->db->join('ruang','peserta.no_kursi = ruang.no_kursi','inner');
        $this->db->where($check);
        $query = $this->db->get();
        return $query;
    }

    public function checkDataLaporan($check)
    {
        $this->db->select('laporan.*');
        $this->db->from('laporan');
        $this->db->where($check);
        $query = $this->db->get();
        return $query;
    }

    public function getIsiLaporan($id)
    {
    	$this->db->select('laporan,peserta.nama,peserta.no_peserta');
        $this->db->join('peserta','laporan.id_user = peserta.id','inner');
    	$this->db->where('id_user',$id);
    	$query = $this->db->get('laporan');
    	return $query;
    }

    public function UpdateLaporan($id,$data)
    {
    	$this->db->set('laporan',$data);
    	$this->db->where('id_user',$id);
    	$this->db->update('laporan');
    }

    public function InsertLaporan($id,$laporan)
    {
        $data = array('laporan' => $laporan,'id_user' => $id);
        $this->db->insert('laporan',$data);
    }

	public function getDataLogin($id,$periode)
	{
		$this->db->select("COUNT(peserta.status) as semua,SUM(peserta.status = '1') as logged");
		$this->db->from('peserta');
		$this->db->join('ruang','peserta.no_kursi = ruang.no_kursi','inner');
		$this->db->where('ruang.id_ruang',$id);
		$this->db->where('peserta.periode',$periode);
        $query = $this->db->get();
        return $query;
	}

    public function getDataUser($id)
    {
        $this->db->where('id',$id);
        $query = $this->db->get('user');
        return $query;
    }

    public function update_pass($id,$data)
    {
        $this->db->where('id',$id);
        $this->db->update('user',$data);
    }

    var $column_search1 = array('peserta.id','peserta.nama','peserta.no_kursi','peserta.periode','peserta.status');
    private function QueryDetailPeserta($search,$length,$start,$sess)
    {   
        $this->db->select('*');
        $this->db->from('peserta');
        $this->db->join('ruang','peserta.no_kursi = ruang.no_kursi','inner');
        $this->db->where($sess);      

        $i = 0;     
        foreach ($this->column_search1 as $item) // loop column 
        {
            if($search['value']) // if datatable send POST for search
            {              
                if($i===0) // first loop
                {
                    $this->db->group_start(); 
                    $this->db->like($item, $search['value']);
                }
                else
                {
                    $this->db->or_like($item, $search['value']);
                }
                if(count($this->column_search1) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }        
    }

    public function getDetailPeserta($search,$length,$start,$sess)
    {
        $this->QueryDetailPeserta($search,$length,$start,$sess);
        $this->db->limit($length, $start);
        $query = $this->db->get();
        return $query->result();
    }
 
    function getFilteredDatailedPeserta($search,$length,$start,$sess)
    {
        $this->QueryDetailPeserta($search,$length,$start,$sess);
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function getAllDetailPeserta($sess)
    {
        $this->db->select('*');
        $this->db->from('peserta');
        $this->db->join('ruang','peserta.no_kursi = ruang.no_kursi','inner');
        $this->db->where($sess);
        return $this->db->count_all_results();
    }
}

/* End of file MOperator.php */
/* Location: ./application/models/MOperator.php */