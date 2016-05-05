<?php
	class _materi extends ci_model{
		public $tabel="materi";
		function getall(){
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

		function saveUpdate($id,$query){
			$this->db->where('materi_id',$id);
			return $this->db->update($this->tabel,$query);
		}
		
		function deletetmp($id){
			$this->db->where('materi_id',$id);
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
	}
?>