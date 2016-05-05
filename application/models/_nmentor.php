<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class _nmentor extends CI_Model {
	public $tabel="nilai_mentor";
	function getall($limit,$start){
		$this->db->limit($limit,$start);
		$this->db->where('is_delete',false);
		return $this->db->get($this->tabel);
	}
	function getby($query,$limit=10,$start=0){
		$query['is_delete']=false;
		return $this->db->get_where($this->tabel,$query);
	}
	function insertnew($query){
		return $this->db->insert($this->tabel,$query);
	}
	function saveUpdate($id){
		$data=$this->db->query('select * from '.$this->tabel.' where nilai_mentor_id='.$id)->row()->nilai_mentor_status;
		if($data=='Hadir')
			$query=array('nilai_mentor_status'=>'Tidak Hadir');
		else
			$query=array('nilai_mentor_status'=>'Hadir');
		$this->db->where('nilai_mentor_id',$id);
		return $this->db->update($this->tabel,$query);
	}
	function deletetmp($id){
		$this->db->where('bat_id',$id);
		return $this->db->update($this->tabel,array('is_delete'=>true));
	}
	function deleteall(){
		$this->db->where('is_delete',true);
		return $this->db->delete($this->tabel);
	}
	function getrow(){
		$this->db->where('is_delete',false);
		return $this->db->get($this->tabel)->num_rows();
	}
	function getallnolimit(){
		$this->db->where('is_delete',false);
		return $this->db->get($this->tabel);
	}
	function updateby($where,$data){
		$this->db->where($where);
		return $this->db->update($this->tabel,$data);
	}
	function getjoinby($data){
		$this->db->from('mentor');
		$this->db->join($this->tabel, 'mentor.mentor_id = nilai_mentor.mentor_id');
		$this->db->join('bat', 'bat.bat_id = nilai_mentor.bat_id');
		$this->db->order_by('mentor.mentor_nim asc');
		$this->db->where($this->tabel.'.is_delete',false);
		$this->db->where($data);
		return $this->db->get();
	}
}

/* End of file _nmentor.php */
/* Location: ./application/models/_nmentor.php */