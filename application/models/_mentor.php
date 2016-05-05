<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class _mentor extends CI_Model {
	public $table="mentor";
	function getall($limit=null,$start=null){
		if($limit != null){
			if($start != null)
				$this->db->limit($limit,$start);
			else
				$this->db->limit($limit);
		}
		$this->db->where('is_delete',false);
		return $this->db->get($this->table);
	}
	function getby($query,$limit=10,$start=0){
		$query['is_delete']=false;
		return $this->db->get_where($this->table,$query);
	}

	function getMentorExcept($jenis_kelamin, $select=null, $mentor_id=null){
		if($select != null){
			$this->db->select($select);
		}
		$this->db->where('mentor_jenis_kelamin',$jenis_kelamin);
		if($mentor_id != null){
			$this->db->where_not_in('mentor_id', $mentor_id);
		}
		return $this->db->get($this->table)->result_array();
	}

	function getDataMentorByKelompokId($id){
		$this->db->join('kelompok_mentor','kelompok_mentor.mentor_id = mentor.mentor_id');
		$this->db->where('kelompok_id',$id);
		return $this->db->get($this->table);
	}
	function insertnew($query){
		return $this->db->insert($this->table,$query);
	}
	function getidbynim($nim){
		return $this->db->query("select ".$this->table."_id from ".$this->table." where ".$this->table."_nim=".$nim."")->row()->mentor_id;
	}
	function saveUpdate($id,$query){
		$this->db->where('mentor_id',$id);
		return $this->db->update($this->table,$query);
	}
	function deletetmp($id){
		$this->db->where('kelompok_id',$id);
		return $this->db->update($this->table,array('is_delete'=>true));
	}
	function deleteall(){
		$this->db->where('is_delete',true);
		return $this->db->delete($this->table);
	}
	function getrow(){
		$this->db->where('is_delete',false);
		return $this->db->get($this->table)->num_rows();
	}
	function getallnolimit(){
		$this->db->where('is_delete',false);
		return $this->db->get($this->table);
	}
	function getkelid($nim){
		return $this->db->query("select kelompok_id from ".$this->table." where is_delete=false and ".$this->table."_nim='".$nim."'")->row()->kelompok_id;
	}
}

/* End of file _mentor.php */
/* Location: ./application/models/_mentor.php */