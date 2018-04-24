<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MImport extends CI_Model {

	public function execQuery($data)
	{
		$this->db->query($data);
	}

	public function InsertBatch($data)
	{
		$this->db->insert_batch('peserta',$data);
	}

	public function InsertTrial($data)
	{
		$this->db->insert_batch('soal_trial',$data);
	}

	public function InsertSoal($data)
	{
		$this->db->insert_batch('soal',$data);
	}

}

/* End of file MImport.php */
/* Location: ./application/models/MImport.php */