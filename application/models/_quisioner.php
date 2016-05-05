<?php
	class _quisioner extends ci_model{
		public $table='kuisioner';
		function add($query){
			return $this->db->insert($this->table,$query);
		}
		function get_data(){
			$this->db->order_by('kuisioner_id', 'asc');
			$this->db->where('is_delete',0);
			return $this->db->get($this->table);
		}
		function getby($query,$limit=10,$start=0){
			$query['is_delete']=false;
			return $this->db->get_where($this->table,$query);
		}
		function delete($id){
			$this->db->where('kuisioner_id',$id);
			return $this->db->update($this->table,array('is_delete'=>true));
		}
		function edit($id,$data){
			$this->db->where('kuisioner_id',$id);
			return $this->db->update($this->table,$data);
		}
	}