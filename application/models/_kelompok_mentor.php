<?php
class _kelompok_mentor extends ci_model{
	public $table="kelompok_mentor";
	function getAll($limit,$start){
		$this->db->limit($limit,$start);
		$this->db->where('is_delete',false);
		return $this->db->get($this->table);
	}
	function getBy($query){
		$query['is_delete']=false;
		return $this->db->get_where($this->table,$query);
	}
	function insertNew($query){
		return $this->db->insert($this->table, $query);
	}
	
	function changeKelompok($kelompok_id, $mentor_asal, $mentor_tujuan){
		$this->db->trans_start();
		$data['mentor_id'] = $mentor_tujuan;
		$this->db->where(array('mentor_id'=>$mentor_asal, 'kelompok_id'=>$kelompok_id));
		$this->db->update($this->table, $data);
		$this->db->trans_complete();
	    return ($this->db->affected_rows() == 1) ? TRUE : ($this->db->trans_status() === FALSE) ? FALSE : TRUE;
	}

	function getKelompokMentor($team, $kelompok_id=null){
		$this->db->select('kelompok.kelompok_id, kelompok_nama, mentor.mentor_id, mentor_nama, mentor_nim, mentor_status');
		$this->db->join('mentor','kelompok_mentor.mentor_id = mentor.mentor_id');
		$this->db->join('kelompok', 'kelompok_mentor.kelompok_id = kelompok.kelompok_id');
		$this->db->where(array('kelompok_mentor.is_delete'=>false, 'kelompok.is_delete' => false,'mentor.is_delete'=>false));
		$this->db->order_by('kelompok_nama','ASC');
		if($kelompok_id==null)
		{
			$this->db->where('mentor_status','mentor');
			$this->db->like('kelompok.kelompok_nama',$team);
		}
		else
			$this->db->where('kelompok.kelompok_id',$kelompok_id);
		return $this->db->get($this->table);
	}

	function getAstor($id)
	{
		$this->db->select('mentor.mentor_id, mentor_nama, mentor_nim');
		$this->db->join('mentor', 'mentor.mentor_id = kelompok_mentor.mentor_id');
		$this->db->where(array('kelompok_id' => $id, 'mentor_status' => 'astor'));
		return $this->db->get($this->table)->row();
	}

	function getKelompokIdByMentorNim($nim)
	{
		$this->db->select('kelompok.kelompok_id');
		$this->db->join('kelompok','kelompok_mentor.kelompok_id = kelompok.kelompok_id');
		$this->db->join('mentor','kelompok_mentor.mentor_id = mentor.mentor_id');
		$this->db->where(array('mentor_nim' => $nim, 'kelompok.is_delete' => false, 'mentor.is_delete' => 'false'));
		return $this->db->get($this->table)->row()->kelompok_id;
	}

	function getKelompokByMentorNim($nim)
	{
		$this->db->select('kelompok.kelompok_id, kelompok_nama, mentor.mentor_id, mentor_nama, mentor_nim, mentor_status');
		$this->db->join('kelompok','kelompok_mentor.kelompok_id = kelompok.kelompok_id');
		$this->db->join('mentor','kelompok_mentor.mentor_id = mentor.mentor_id');
		$this->db->where(array('mentor_nim' => $nim, 'kelompok.is_delete' => false, 'mentor.is_delete' => 'false'));
		return $this->db->get($this->table)->result();
	}
	function getSumKelompokByMentorNim($nim)
	{
		$this->db->join('mentor','kelompok_mentor.mentor_id = mentor.mentor_id');
		$this->db->where(array('mentor_nim' => $nim, 'mentor.is_delete' => false));
		return $this->db->get($this->table)->num_rows();
	}
	function getNamaKelompokByMentorNim($nim)
	{
		$this->db->select('kelompok_nama');
		$this->db->from($this->table);
		$this->db->join('kelompok','kelompok_mentor.kelompok_id = kelompok.kelompok_id');
		$this->db->join('mentor','kelompok_mentor.mentor_id = mentor.mentor_id');
		$this->db->where(array('mentor.mentor_nim' => $nim, 'kelompok.is_delete' => false, 'mentor.is_delete' => false));
		return $this->db->get()->row()->kelompok_nama;
	}
}
?>