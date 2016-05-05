<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class _mentee extends CI_Model {
	public $table="mentee";
	function getall($limit,$start){
		$this->db->limit($limit,$start);
		$this->db->where('is_delete',false);
		return $this->db->get($this->table);
	}
	function getby($query,$limit=10,$start=0){
		$query['is_delete']=false;
		return $this->db->get_where($this->table,$query);
	}
	function getidbynim($nim){
		return $this->db->query("select ".$this->table."_id from ".$this->table." where ".$this->table."_nim=".$nim."")->row()->mentee_id;
	}
	function getOneByNim($nim){
		$query = $this->db->get_where('mentee', array('mentee_nim' => $nim, 'is_delete' => false));
		return $query->result();
	}
	function getNimAllMentee(){
		$this->db->select('mentee_nim');
		$query = $this->db->get_where('mentee', array('is_delete' => false));
		return $query->result();
	}
	function insertnew($query){
		return $this->db->insert($this->table,$query);
	}
	function saveUpdate($id,$query){
		$this->db->where('mentee_id',$id);
		return $this->db->update($this->table,$query);
	}
	function deletetmp($id){
		$this->db->where('mentee_id',$id);
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
	function getbynolimit($data){
		$this->db->where($data);
		$this->db->where('is_delete',false);
		return $this->db->get($this->table);
	}
	function getKelompokIdByNim($nim){
		return $this->db->get_where($this->table,array('mentee_nim' => $nim, 'is_delete' => false))->row()->kelompok_id;
	}
	function getkelid($nim){
		return $this->db->query('select kelompok_id from '.$this->table.' where is_delete=false and '.$this->table.'_nim='.$nim)->row()->kelompok_id;
	}
	function getnamakel($nim){
		return $this->db->query('select kelompok_nama from '.$this->table.',kelompok where '.$this->table.'.is_delete=false and kelompok.is_delete=false and '.$this->table.'.kelompok_id = kelompok.kelompok_id and '.$this->table.'_nim='.$nim)->row()->kelompok_nama;
	}
	function getallnim($kelompok_id = ''){
		$where = $kelompok_id != '' ? " AND kelompok_id = '$kelompok_id'" : "";
		
		$query = "SELECT mentee_nim, mentee_kelas
				  FROM mentee 
				  WHERE is_delete = '0' $where
				  ORDER BY mentee_kelas";

		return $this->db->query($query)->result();
	}

	function get_all_telp(){
		$query = "SELECT mentee_telp FROM mentee";
		return $this->db->query($query)->result();
	}
}

/* End of file _mentee.php */
/* Location: ./application/models/_mentee.php */