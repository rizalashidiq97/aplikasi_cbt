<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MOperatorv1 extends CI_Model {

	var $column_order_rata = array('peserta.id','nama','no_peserta','pilih_prodi','periode','sum');
    var $column_search_rata = array('peserta.id','nama','no_peserta','pilih_prodi');
    var $order_default_rata = array('sum' => 'DESC');
    private function QueryDataRekapRata($search,$length,$start,$order,$data)
    {        
        $this->db->select('peserta.*,(200 + (6 * SUM(hasil_tes.jml_benar))) as sum');
        $this->db->from('hasil_tes');
        $this->db->join('peserta','hasil_tes.id_user = peserta.id','inner');
        $i = 0;

        if(isset($data)){
        	$this->db->where('peserta.periode',$data);
        }
     
        foreach ($this->column_search_rata as $item) // loop column 
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
                if(count($this->column_search_rata) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        $this->db->group_by('hasil_tes.id_user');

        if(isset($order)) // here order processing
        {
            $this->db->order_by($this->column_order_rata[$order['0']['column']], $order['0']['dir']);
        } 
        else if(isset($this->order_default_rata))
        {
            $do_order = $this->order_default_rata;
            $this->db->order_by(key($do_order), $do_order[key($do_order)]);
        }
    }

    function getDataNilaiRata($search,$length,$start,$order,$data)
    {
        $this->QueryDataRekapRata($search,$length,$start,$order,$data);
        $this->db->limit($length,$start);
        $query = $this->db->get();
        return $query->result();
    }
 
    function getDataFilteredNilaiRata($search,$length,$start,$order,$data)
    {
        $this->QueryDataRekapRata($search,$length,$start,$order,$data);
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function getAllDataNilaiRata()
    {
        $this->db->select('peserta.*,(200 + (6 * SUM(hasil_tes.jml_benar))) as sum');
        $this->db->from('hasil_tes');
        $this->db->join('peserta','hasil_tes.id_user = peserta.id','inner');
        $this->db->group_by('hasil_tes.id_user');
        return $this->db->count_all_results();
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

    public function getJmlBenar($id)
    {
        $this->db->select('kategori.kategori,hasil_tes.jml_benar as jumlah');
        $this->db->from('test');
        $this->db->join('hasil_tes','test.id = hasil_tes.id_tes','inner');
        $this->db->join('kategori','test.idkategori = kategori.id','inner');
        $this->db->where('hasil_tes.id_user',$id);
        $this->db->group_by('test.id');
        $query = $this->db->get();
        return $query;
    }

    public function getPeriode()
    {
    	$this->db->distinct();
    	$this->db->select('periode');
    	$query = $this->db->get('peserta');
    	return $query;
    }

    public function CheckUjian()
    {
        $this->db->select("IF((ADDTIME(tgl_mulai,SEC_TO_TIME(MOD(waktu*60,86400))) < NOW()),
                            'sudah selese','blum selese') as status,kategori.kategori");
        $this->db->from("test");
        $this->db->join("kategori","test.idkategori = kategori.id","inner");
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
}

/* End of file MOperatorv1.php */
/* Location: ./application/models/MOperatorv1.php */