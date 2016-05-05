<?php
	class _bat extends ci_model{
		public $tabel="bat";
		function getall(){
			$this->db->where('is_delete',false);
			return $this->db->get($this->tabel);
		}
		function getby($query){
			return $this->db->get_where($this->tabel,$query);
		}
		function insertnew($query){
			return $this->db->insert($this->tabel,$query);
		}
		function saveUpdate($id,$query){
			$this->db->where('bat_id',$id);
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
		function getmentor(){
			$queries=array(
					'bat.is_delete'=>'false',
					'nilai_mentor.is_delete'=>'false',
					'mentor.is_delete'=>'false'
				);
			$this->db->select('mentor_nim,mentor_nama,mentor_kelas,');
			$this->db->from($this->tabel);
			$this->db->join('nilai_mentor','nilai_mentor.bam_id=bam.bam_id');
			$this->db->join('mentor','nilai_mentor.mentor_id=mentor.mentor_id');
			$this->db->where($queries);
			return $this->db->get();
		}
		function getlastid(){
			$this->db->order_by('bat_id','desc');
			return $this->db->get($this->tabel)->result();
		}
	}
?>