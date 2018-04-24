<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MExport extends CI_Model {

	public function datarekap($uri3)
	{
		$this->db->select('peserta.nama,peserta.no_peserta,peserta.pilih_prodi,peserta.periode,laporan.*');
        $this->db->from('laporan');
        $this->db->join('peserta','laporan.id_user = peserta.id','inner');
        if(isset($uri3)){
            $this->db->where('peserta.periode',$uri3);
        }        
        $query = $this->db->get();
        return $query;
    }
    
    public function datarekaprata2($id)
    {
        $this->db->select('peserta.*,(200 + (6 * SUM(hasil_tes.jml_benar))) as sum');
        $this->db->from('peserta');
        $this->db->join('hasil_tes','peserta.id = hasil_tes.id_user','inner');
        if(isset($id)){
            $this->db->where('hasil_tes.id_user',$id);
        }
        $this->db->group_by('hasil_tes.id_user');
        $query = $this->db->get();
        return $query;
    }

    public function datatrial()
    {
        $this->db->select('peserta.*,hasil_tes_trial.nilai');
        $this->db->from('hasil_tes_trial');
        $this->db->join('peserta','hasil_tes_trial.id_user = peserta.id','inner');
        $query = $this->db->get();
        return $query;
    }
}

/* End of file MExport.php */
/* Location: ./application/models/MExport.php */