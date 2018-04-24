<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MAuth extends CI_Model {

	public function cek_user($data)
	{
		$query = $this->db->get_where('user',$data);
		return $query;
	}

	public function cek_user_peserta($data)
	{
		$query = $this->db->get_where('peserta',$data);
		return $query;
	}

	public function update_status($data)
	{
		$this->db->where($data);
		$this->db->update('peserta', array('status' => '1'));
	}

	public function check()
	{
		return $this->db->query("SELECT * FROM test where id = 1")->row();
	}
}

/* End of file MAuth.php */
/* Location: ./application/models/MAuth.php */