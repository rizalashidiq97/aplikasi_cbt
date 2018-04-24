<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Madmin extends CI_Model {
//dashboard region

    public function LoginData()
    {
        $this->db->select("COUNT(status) as semua,SUM(peserta.status = '1') as logged");
        $query = $this->db->get('peserta');
        return $query;
    }
    //untuk record banyaknya soal terunggah 
    public function getCountSoal()
    {
        $this->db->select('kategori.kategori,
                           COUNT(CASE when versi = 1 THEN 1 END) as versi1,
                           COUNT(CASE when versi = 2 THEN 1 END) as versi2,
                           COUNT(CASE when versi = 3 THEN 1 END) as versi3');
        $this->db->from('soal');
        $this->db->join('kategori','soal.kategori = kategori.id','inner');
        $this->db->group_by('kategori.id');
        $query = $this->db->get();
        return $query;
    }
    //untuk data rekap prodi
    var $column_order = array('','pilih_prodi','jumlah');
    var $def_order = array('jumlah' => 'DESC');
	private function QueryDataProdi($search,$length,$start,$order)
	{
		$this->db->select('pilih_prodi, COUNT(*) as jumlah');
        $this->db->from('peserta');

        if($search['value']){
            $this->db->like('pilih_prodi', $search['value']);
        }

        $this->db->group_by('pilih_prodi');

        if(isset($order)) // here order processing
        {
            $this->db->order_by($this->column_order[$order['0']['column']],$order['0']['dir']);
        } 
        else if(isset($this->def_order))
        {
            $do_order = $this->def_order;
            $this->db->order_by(key($do_order), $do_order[key($do_order)]);
        }
	}	

    function getDataRekap($search,$length,$start,$order)
    {
        $this->QueryDataProdi($search,$length,$start,$order);
        $this->db->limit($length, $start);
        $query = $this->db->get();
        return $query->result();
    }
 
    function getDataFilteredRekap($search,$length,$start,$order)
    {
        $this->QueryDataProdi($search,$length,$start,$order);
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function getAllDataRekap()
    {
        $this->db->from('peserta');
        return $this->db->count_all_results();
    }
    //end data rekap prodi

//peserta region
	//Untuk data peserta datatable
	var $table1 = 'peserta';
    var $column_order1 = array('id','nama','no_peserta','no_kursi','periode','kode_prodi','pilih_prodi','tgl_lahir'); 
    var $column_search1 = array('id','nama','periode','no_peserta','no_kursi','kode_prodi','pilih_prodi','tgl_lahir');
    var $order_default = array('id' => 'ASC');
	private function QueryDataPeserta($search,$length,$start,$order)
    {        
        $this->db->from($this->table1);
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
        if(isset($order)) // here order processing
        {
            $this->db->order_by($this->column_order1[$order['0']['column']], $order['0']['dir']);
        } 
        else if(isset($this->order_default))
        {
            $do_order = $this->order_default;
            $this->db->order_by(key($do_order), $do_order[key($do_order)]);
        }
    }
 
    function getDataPeserta($search,$length,$start,$order)
    {
        $this->QueryDataPeserta($search,$length,$start,$order);
        $this->db->limit($length, $start);
        $query = $this->db->get();
        return $query->result();
    }
 
    function getDataFilteredPeserta($search,$length,$start,$order)
    {
        $this->QueryDataPeserta($search,$length,$start,$order);
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function getAllDataPeserta()
    {
        $this->db->from($this->table1);
        return $this->db->count_all_results();
    }

    //end data table peserta

    //crud data peserta
    public function getEditDataPeserta($data){
    	$query = $this->db->get_where('peserta',$data);
		return $query;
    }

    public function check_ganda_akun()
    {
        $this->db->select('no_peserta,COUNT(no_peserta) as jml');
        $this->db->from('peserta');
        $this->db->group_by('no_peserta');
        $this->db->having('jml > 1');
        $query = $this->db->get();
        return $query;
    }

    public function DoEditDataPeserta($data,$id){
        $this->db->where('id', $id);
        $this->db->update('peserta', $data);
    }

    public function DoInsertDataPeserta($data){
        $this->db->insert('peserta', $data);
    }

    public function DoDeleteDataPeserta($id){
        $this->db->where('id', $id);
        $this->db->delete('peserta');
    }

    public function DeleteAllDataPeserta()
    {
        $this->db->truncate('peserta');
    }
    //end crud data peserta
//end data peserta

// begin data soal trial
    //begin datatables soaltrial
    var $column_search2 = array('soal_trial.soal','soal_trial.kategori');
    private function QueryDataSoalTrial($search,$length,$start,$order,$data)
    {   
        $this->db->select('soal_trial.*');
        $this->db->from('soal_trial');

        if(isset($data)){
            $this->db->where('kategori.id',$data);
        }

        $i = 0;
     
        foreach ($this->column_search2 as $item) // loop column 
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
                if(count($this->column_search2) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }        
    }

    function getDataSoalTrial($search,$length,$start,$order,$data)
    {
        $this->QueryDataSoalTrial($search,$length,$start,$order,$data);
        $this->db->limit($length, $start);
        $query = $this->db->get();
        return $query->result();
    }
 
    function getDataFilteredSoalTrial($search,$length,$start,$order,$data)
    {
        $this->QueryDataSoalTrial($search,$length,$start,$order,$data);
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function getAllDataSoalTrial()
    {
        $this->db->from("soal_trial");
        return $this->db->count_all_results();
    }
    //end datatables soaltrial

    //begin crud soaltrial
    public function getExistDataSoalTrial($id)
    {
        $query = $this->db->get_where('soal_trial',$id);
        return $query;
    }

    public function InsertSoalTrial($data)
    {
        $this->db->set('tgl_input','NOW()',FALSE);
        $this->db->insert('soal_trial',$data);
    }

    public function UpdateSoalTrial($data,$id)
    {

        $this->db->where('id',$id);
        $this->db->update('soal_trial',$data);
    }

    public function DoDeleteSoalTrial($id)
    {
        $this->db->where('id',$id);
        $this->db->delete('soal_trial');
    }

    public function DeleteAllDataSoalTrial()
    {
        $this->db->truncate('soal_trial');
    }
    //end crud soal trial

//end data soal trial

//begin bank soal
    //datatables bank soal
    var $column_search3 = array('soal.soal','soal.jawaban','kategori.kategori');
    private function QueryDataSoalVersi1($search,$length,$start,$order,$data,$versi)
    {   
        $this->db->select('soal.*,kategori.kategori');
        $this->db->from('soal');
        $this->db->join('kategori','soal.kategori = kategori.id','inner');
        $this->db->where('soal.versi',$versi);

        if(isset($data)){
            $this->db->where('kategori.id',$data);
        }

        $i = 0;     
        foreach ($this->column_search3 as $item) // loop column 
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
                if(count($this->column_search3) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }        
    }

    function getBankSoal($search,$length,$start,$order,$data,$versi)
    {
        $this->QueryDataSoalVersi1($search,$length,$start,$order,$data,$versi);
        $this->db->limit($length, $start);
        $query = $this->db->get();
        return $query->result();
    }
 
    function getDataFilteredSoal($search,$length,$start,$order,$data,$versi)
    {
        $this->QueryDataSoalVersi1($search,$length,$start,$order,$data,$versi);
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function getAllDataSoal($versi)
    {
        $this->db->from('soal');
        $this->db->where('versi',$versi);
        return $this->db->count_all_results();
    }
    //end datatables bank soal

    //crud bank soal 
    public function getExistDataSoal($id,$versi)
    {
        $data = array(
            'versi' => $versi,
            'id' => $id
        );
        $query = $this->db->get_where('soal',$data);
        return $query;
    }

    public function InsertSoal($data)
    {
        $this->db->set('tgl_input','NOW()',FALSE);
        $this->db->insert('soal',$data);
    }

    public function UpdateSoal($data,$id)
    {

        $this->db->where('id',$id);
        $this->db->update('soal',$data);
    }

    public function DoDeleteSoal($id)
    {
        $this->db->where('id',$id);
        $this->db->delete('soal');
    }

    public function DeleteAllDataSoal()
    {
        $this->db->truncate('soal');
    }
    //end crud bank soal
//end bank soal

//begin data kategori
    //data tables kategori
    var $column_order_kategori = array('id','kategori'); 
    var $column_search_kategori = array('id','kategori');
    var $order_default_kategori = array('id' => 'ASC');
    private function QueryDataKategori($search,$length,$start,$order)
    {        
        $this->db->from('kategori');
        $i = 0;
     
        foreach ($this->column_search_kategori as $item) // loop column 
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
                if(count($this->column_search_kategori) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }        
        if(isset($order)) // here order processing
        {
            $this->db->order_by($this->column_order_kategori[$order['0']['column']], $order['0']['dir']);
        } 
        else if(isset($this->order_default_kategori))
        {
            $do_order = $this->order_default_kategori;
            $this->db->order_by(key($do_order), $do_order[key($do_order)]);
        }
    }

    function getKategoriDatatables($search,$length,$start,$order)
    {
        $this->QueryDataKategori($search,$length,$start,$order);
        $this->db->limit($length, $start);
        $query = $this->db->get();
        return $query->result();
    }
 
    function getDataFilteredKategori($search,$length,$start,$order)
    {
        $this->QueryDataKategori($search,$length,$start,$order);
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function getAllDataKategori()
    {
        $this->db->from('kategori');
        return $this->db->count_all_results();
    }
    //end data tables kategori

    //crud data kategori
    public function getDatakategori()
    {
        $query = $this->db->get('kategori');
        return $query;
    }

    public function EditDataKategori($id){
        $query = $this->db->get_where('kategori',$id);
        return $query;
    }

    public function DoEditDataKategori($data,$id)
    {
        $this->db->where('id',$id);
        $this->db->update('kategori',$data);
    }

    public function DoInsertDataKategori($data)
    {
        $this->db->insert('kategori',$data);
    }

    public function DoDeleteDataKategori($id)
    {
        $this->db->where('id',$id);
        $this->db->delete('kategori');
    }
    //end crud kategori
//end data kategori

//begin data operator
    //data table operator
    var $column_order_operator = array('id','username','id_ruang','periode','grup'); 
    var $column_search_operator = array('id','username','id_ruang','periode','grup');
    var $order_default_operator = array('id' => 'ASC');
    private function QueryDataOperator($search,$length,$start,$order)
    {        
        $this->db->from('user');
        $this->db->where('grup !=','administrator');
        $i = 0;
     
        foreach ($this->column_search_operator as $item) // loop column 
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
                if(count($this->column_search_operator) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }        
        if(isset($order)) // here order processing
        {
            $this->db->order_by($this->column_order_operator[$order['0']['column']], $order['0']['dir']);
        } 
        else if(isset($this->order_default_operator))
        {
            $do_order = $this->order_default_operator;
            $this->db->order_by(key($do_order), $do_order[key($do_order)]);
        }
    }

    function getOperatorDatatables($search,$length,$start,$order)
    {
        $this->QueryDataOperator($search,$length,$start,$order);
        $this->db->limit($length,$start);
        $query = $this->db->get();
        return $query->result();
    }
 
    function getDataFilteredOperator($search,$length,$start,$order)
    {
        $this->QueryDataOperator($search,$length,$start,$order);
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function getAllDataOperator()
    {
        $this->db->from('user');
         $this->db->where('grup !=','administrator');
        return $this->db->count_all_results();
    }
    //end datatable operator

    //crud data operator
    public function EditDataOperator($id)
    {
        $query = $this->db->get_where('user',$id);
        return $query;
    }

    public function DoEditDataOperator($data,$id,$periode,$idruang,$password)
    {
        if(!empty($password)){
            $this->db->set('password',$password);
        }
        $this->db->set('id_ruang',$idruang);
        $this->db->set('periode',$periode);
        $this->db->where('id',$id);
        $this->db->update('user',$data);
    }

    public function DoInsertDataOperator($data,$periode,$idruang,$password)
    {
        $this->db->set('password',$password);
        $this->db->set('periode',$periode);
        $this->db->set('id_ruang',$idruang);
        $this->db->insert('user',$data);
    }

    public function DoDeleteDataOperator($id){
        $this->db->where('id',$id);
        $this->db->delete('user');
    }

    public function getIdRuang()
    {
        $this->db->distinct();
        $this->db->select('id_ruang');
        $query = $this->db->get('ruang');
        return $query;
    }
    //end crud data operator
//end data operator

//begin data ruang
    //data table data ruang
    private function QueryDataRuang($search,$length,$start,$order)
    {        
        $this->db->select('id_ruang,MIN(no_kursi) as min,MAX(no_kursi) as max');
        $this->db->from('ruang');
        if($search['value']){
            $this->db->like('id_ruang', $search['value']);
        }
        $this->db->group_by('id_ruang');       
    }
    function getRuang($search,$length,$start,$order)
    {
        $this->QueryDataRuang($search,$length,$start,$order);
        $this->db->limit($length,$start);
        $query = $this->db->get();
        return $query->result();
    } 
    function getDataFilteredRuang($search,$length,$start,$order)
    {
        $this->QueryDataRuang($search,$length,$start,$order);
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function getAllDataRuang()
    {
        $this->db->from('ruang');
        return $this->db->count_all_results();
    }
    //end table data ruang

    //crud data ruang 
    public function distinctruang($min,$max)
    {
        $this->db->distinct();
        $this->db->select('id_ruang');
        $this->db->where('no_kursi >=',$min);
        $this->db->where('no_kursi <=',$max);
        $query = $this->db->get('ruang');
        return $query;
    }
    public function EditRuang($id)
    {
        $this->db->select('id_ruang,MIN(no_kursi) as min,MAX(no_kursi) as max');
        $this->db->group_by('id_ruang');
        $query = $this->db->get_where('ruang',$id);
        return $query;  
    }
    public function deleteRuang($ruang)
    {
        $this->db->where('id_ruang',$ruang);
        $this->db->delete('ruang');
    }

    public function InsertBatch($value)
    {
        $this->db->insert_batch('ruang',$value);
    }

    public function checkExistRuangadd($ruang,$min,$max)
    {
        $this->db->where('no_kursi >=',$min);
        $this->db->where('no_kursi <=',$max);
        $this->db->or_where('id_ruang',$ruang);
        $query = $this->db->get('ruang');
        return $query;
    }

    public function checkExistRuang($ruang,$min,$max)
    {
        $array = array(
            'no_kursi >=' => $min,
            'no_kursi <=' => $max,
            'id_ruang !=' => $ruang
        );
        $query = $this->db->get_where('ruang',$array);
        return $query;
    }
    //crud data ruang
//end data ruang

//begin aktivasi soal 
    // data tabel aktivasi soal 
    var $column_search_aktif = array('test.id','nama_ujian','kategori','waktu','terlambat','tgl_mulai');
    private function QueryAktivasiSoal($search,$length,$start)
    {
        $this->db->select('test.*,kategori.kategori');
        $this->db->from('test');
        $this->db->join('kategori','test.idkategori = kategori.id','left');
        $i = 0;
     
        foreach ($this->column_search_aktif as $item) // loop column 
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
                if(count($this->column_search_aktif) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        $this->db->order_by('test.id','ASC');
    }

    function getAktivasiSoaltabel($search,$length,$start)
    {
        $this->QueryAktivasiSoal($search,$length,$start);
        $this->db->limit($length,$start);
        $query = $this->db->get();
        return $query->result();
    }
    
    function getDataFilteredAktivasiSoal($search,$length,$start)
    {
        $this->QueryAktivasiSoal($search,$length,$start);
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function getAllDataAktivasiSoal()
    {
        $this->db->from('test');
        return $this->db->count_all_results();
    }

    //crud aktivasi soal
    public function cek_trial()
    {
        $data = array('nama_ujian' => 'Test Trial');
        $query = $this->db->get_where('test',$data);
        return $query;
    }

    public function getAktifSoal($id)
    {
        $query = $this->db->get_where('test',$id);
        return $query;
    }

    public function EditDataAktifSoal($id,$data)
    {
        $this->db->where('id',$id);
        $this->db->update('test',$data);
    }

    public function InsertDataAktifSoal($data)
    {
        $this->db->insert('test',$data);
    }

    public function hapusAktifSoal($id)
    {
        $this->db->where('id',$id);
        $this->db->delete('test');
    }

//end aktivasi soal

//begin data laporan
    var $column_search_laporan = array('laporan.id','peserta.nama','peserta.no_peserta','peserta.pilih_prodi','peserta.periode');
    var $order_default_laporan = array('laporan.id' => 'ASC');
    private function QueryDataLaporan($search,$length,$start,$order,$id)
    {        
        $this->db->select('laporan.*,peserta.nama,peserta.no_peserta,peserta.pilih_prodi,peserta.periode');
        $this->db->from('laporan');
        $this->db->join('peserta','laporan.id_user = peserta.id','inner');
        if(isset($id)){
            $this->db->where('peserta.periode',$id);
        }

        $i = 0;
        foreach ($this->column_search_laporan as $item) // loop column 
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
                if(count($this->column_search_laporan) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }        
    }

    function getDataLaporan($search,$length,$start,$order,$id)
    {
        $this->QueryDataLaporan($search,$length,$start,$order,$id);
        $this->db->limit($length,$start);
        $query = $this->db->get();
        return $query->result();
    }
 
    function getDataFilteredLaporan($search,$length,$start,$order,$id)
    {
        $this->QueryDataLaporan($search,$length,$start,$order,$id);
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function getAllDataLaporan()
    {
        $this->db->select('laporan.*,peserta.*');
        $this->db->from('laporan');
        $this->db->join('peserta','laporan.id_user = peserta.id','inner');
        return $this->db->count_all_results();
    }

    public function deleteRekapLap()
    {
        $this->db->truncate('laporan');
    }

    public function getPeriode()
    {
        $this->db->distinct();
        $this->db->select('periode');
        $query = $this->db->get('peserta');
        return $query;
    }

    public function Laporan($id){
        $this->db->select('laporan');
        $this->db->where('id',$id);
        $query = $this->db->get('laporan');
        return $query;
    }
//end data laporan

//begin rekap nilai rata2
    var $column_order_rata = array('peserta.id','nama','no_peserta','pilih_prodi','periode','sum');
    var $column_search_rata = array('peserta.id','nama','no_peserta','pilih_prodi');
    var $order_default_rata = array('sum' => 'DESC');
    private function QueryDataRekapRata($search,$length,$start,$order)
    {        
        $this->db->select('peserta.*,(200 + (6 * SUM(hasil_tes.jml_benar))) as sum');
        $this->db->from('hasil_tes');
        $this->db->join('peserta','hasil_tes.id_user = peserta.id','inner');
        $i = 0;
     
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

    function getDataNilaiRata($search,$length,$start,$order)
    {
        $this->QueryDataRekapRata($search,$length,$start,$order);
        $this->db->limit($length,$start);
        $query = $this->db->get();
        return $query->result();
    }
 
    function getDataFilteredNilaiRata($search,$length,$start,$order)
    {
        $this->QueryDataRekapRata($search,$length,$start,$order);
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

    public function deleteRekapAktif()
    {
        $this->db->truncate('hasil_tes');
        $this->db->truncate('hasil_tes_trial');
    }

    public function detail_nilai($id)
    {
        $this->db->select('hasil_tes.*,kategori.kategori');
        $this->db->join('kategori','hasil_tes.id_kategori = kategori.id','inner');
        $this->db->where('hasil_tes.id_user',$id);
        $query = $this->db->get('hasil_tes');
        return $query;
    }

    public function getnama($id)
    {
        $this->db->select('peserta.nama,peserta.no_peserta');
        $this->db->from('peserta');
        $this->db->join('hasil_tes','peserta.id = hasil_tes.id_user','inner');
        $this->db->where('hasil_tes.id_user',$id);
        $query = $this->db->get();
        return $query;
    }
//end rekap nilai

//begin rekap nilai trial
    var $column_order_trial = array('peserta.id','nama','no_peserta','pilih_prodi','periode','nilai');
    var $column_search_trial = array('peserta.id','nama','no_peserta','pilih_prodi','periode','nilai');
    var $order_default_trial = array('sum' => 'DESC');
    private function QueryDataRekapTrial($search,$length,$start,$order)
    {        
        $this->db->select('peserta.*,hasil_tes_trial.nilai,hasil_tes_trial.status as state');
        $this->db->from('hasil_tes_trial');
        $this->db->join('peserta','hasil_tes_trial.id_user = peserta.id','inner');
        $i = 0;
     
        foreach ($this->column_search_trial as $item) // loop column 
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
                if(count($this->column_search_trial) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if(isset($order)) // here order processing
        {
            $this->db->order_by($this->column_order_trial[$order['0']['column']], $order['0']['dir']);
        } 
        else if(isset($this->order_default_trial))
        {
            $do_order = $this->order_default_trial;
            $this->db->order_by(key($do_order), $do_order[key($do_order)]);
        }
    }

    function getDataNilaiTrial($search,$length,$start,$order)
    {
        $this->QueryDataRekapTrial($search,$length,$start,$order);
        $this->db->limit($length,$start);
        $query = $this->db->get();
        return $query->result();
    }
 
    function getDataFilteredNilaiTrial($search,$length,$start,$order)
    {
        $this->QueryDataRekapTrial($search,$length,$start,$order);
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function getAllDataNilaiTrial()
    {
        $this->db->select('peserta.*,hasil_tes_trial.nilai,hasil_tes_trial.status as state');
        $this->db->from('hasil_tes_trial');
        $this->db->join('peserta','hasil_tes_trial.id_user = peserta.id','inner');
        return $this->db->count_all_results();
    }
//end hasil rekap nilai trial

//pass
    public function update_pass($id,$data)
    {
        $this->db->where($id);
        $this->db->update('user',$data);
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
}

/* End of file Madmin.php */
/* Location: ./application/models/Madmin.php */