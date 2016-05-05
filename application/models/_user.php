<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class _user extends CI_Model {
	public $table="user";
	function getall($limit,$start){
		$this->db->limit($limit,$start);
		$this->db->where('is_delete',false);
		return $this->db->get($this->table);
	}
	function getby($query){
		$query['is_delete']=false;
		return $this->db->get_where($this->table,$query);
	}
	function insertnew($query){
		return $this->db->insert($this->table,$query);
	}
	function saveUpdate($id,$query){
		$this->db->where('user_id',$id);
		return $this->db->update($this->table,$query);
	}
	function getLastUpdate($username)
	{
		$this->db->select('last_update');
		return $this->db->get_where($this->table, array('user_username' => $username));
	}
	function deletetmp($id){
		$this->db->where($id);
		$this->db->update($this->table,array('is_delete'=>true));
		return $this->deleteall();
	}
	function deleteall(){
		$this->db->where('is_delete',true);
		return $this->db->delete($this->table);
	}
	function getrow(){
		$this->db->where('is_delete',false);
		return $this->db->get($this->table)->num_rows();
	}
}

/* End of file _user.php */
/* Location: ./application/models/_user.php */