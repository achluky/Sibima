<?php
	class _kelompok extends ci_model{
		public $tabel="kelompok";
		function getall($limit,$start){
			$this->db->limit($limit,$start);
			$this->db->where('is_delete',false);
			return $this->db->get($this->tabel);
		}
		function getby($query){
			$query['is_delete']=false;
			return $this->db->get_where($this->tabel,$query);
		}
		function insertnew($query){
			return $this->db->insert($this->tabel,$query);
		}
		function saveUpdate($id,$query){
			$this->db->where('kelompok_id',$id);
			return $this->db->update($this->tabel,$query);
		}
		function deletetmp($id){
			$this->db->where('kelompok_id',$id);
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
		function getidmax(){
			$this->db->select('max(kelompok_id) as id');
			return $this->db->get($this->tabel);
		}
		function getNamaKelompok($id){
			$this->db->select('kelompok_nama');
			return $this->db->get_where($this->tabel,array('kelompok_id' => $id))->row()->kelompok_nama;
		}
		function getIdKelompok($kelompok_nama)
		{
			$this->db->select('kelompok_id');
			$data = $this->db->get_where($this->tabel, array('kelompok_nama' => $kelompok_nama))->row()->kelompok_id;
			
		}
		function getKelompokMentee($kelompok_id){
			$this->db->select('mentee_id,mentee_nim,mentee_nama,mentee_telp,mentee_kelas,mentee_jurusan');
			$this->db->from($this->tabel);
			$this->db->join('mentee', 'mentee.kelompok_id = kelompok.kelompok_id');
			$this->db->where(array('kelompok.is_delete'=>false,'kelompok.kelompok_id'=>$kelompok_id,'mentee.is_delete'=>false));
			return $this->db->get();
		}
		function getAllNoLimit(){
			$this->db->where('is_delete',false);
			return $this->db->get($this->tabel);
		}
		function getmentormentee($id){
			$query="select * from mentee,mentor,kelompok where mentee.kelompok_id=kelompok.kelompok_id and mentor.kelompok_id=kelompok.kelompok_id and mentee.mentee_nim=".$id." and mentor_status='primary'";
			return $this->db->query($query)->row();
		}
		function getKelompokIdByNama($kelompok_nama){
			return $this->db->query("select kelompok_id from kelompok where kelompok_nama='".$kelompok_nama."'")->row()->kelompok_id;
		}
	}
?>