<?php
	class _bam extends ci_model{
		public $table="bam";
		function getAll($limit=null,$start=null){
			if($limit != null)
			{
				$this->db->limit($limit,($start != null) ? $start : 0);
			}
			$this->db->where('is_delete',false);
			return $this->db->get($this->table)->result();
		}
		//function untuk hanya mengambil list dari mentoring saja tanpa acara general
		function getListMentoring()
		{
			return $this->db->get_where($this->table, array('bam_tipe' => '0', 'is_delete' => false))->result();
		}
		function getListGeneral()
		{
			$this->db->where(array('bam_tipe' => '1', 'is_delete' => false));
			return $this->db->get($this->table)->result();
		}
		function getallpresensi(){
			$this->db->join('kelompok_bam', 'kelompok_bam.bam_id = bam.bam_id');
			$this->db->where(array('bam_tipe' => '1', 'bam.is_delete' => false));
			return $this->db->get($this->table);
		}
		function getKelompok($id){
			$this->db->select('kelompok.kelompok_id, kelompok_nama');
			$this->db->from($this->table);
			$this->db->join('nilai_mentee','bam.bam_id = nilai_mentee.bam_id');
			$this->db->join('mentee','nilai_mentee.mentee_id = mentee.mentee_id');
			$this->db->join('kelompok','mentee.kelompok_id = kelompok.kelompok_id');
			$this->db->where('bam.bam_id',$id);
			$this->db->group_by("kelompok.kelompok_id"); 
			return $this->db->get()->row();
		}
		function getStatusBam($bam, $nim, $kelompok)
		{
			$this->db->select('kelompok_bam.kelompok_bam_id');
			$this->db->join('kelompok_bam','kelompok_bam.bam_id = bam.bam_id');
			$this->db->join('kelompok','kelompok_bam.kelompok_id = kelompok.kelompok_id');
			$this->db->join('kelompok_mentor','kelompok.kelompok_id = kelompok_mentor.kelompok_id');
			$this->db->join('mentor','mentor.mentor_id = kelompok_mentor.mentor_id');
			$this->db->where(array('bam.bam_id' => $bam, 'kelompok.kelompok_id' => $kelompok, 'mentor.mentor_nim' => $nim, 'mentor.is_delete' => false, 'kelompok.is_delete' => false));
			return ($this->db->get($this->table)->num_rows() > 0) ? true : false;
		}
		function getby($query){
			return $this->db->get_where($this->table,$query);
		}
		function getBamData($id){
			return $this->db->get_where($this->table,array('bam_id'=>$id,'is_delete'=>false));
		}
		function get_data(){
			return $this->db->query("SELECT kelompok_id,kelompok_nama,mentor_nama FROM kelompok join mentor using (kelompok_id) where mentor_status='primary' and kelompok.is_delete='0'");
		}
		function getBamRawById($id){
			$this->db->where(array('bam_id' => $id, 'is_delete' => false));
			return $this->db->get($this->table);
		}
		function get_bam($id){
			return $this->db->query("select bam_id from bam join nilai_mentee using(bam_id) join mentee using (mentee_id) join kelompok using(kelompok_id) where kelompok_id='$id' and bam.is_delete=false group by bam_id");
		}
		
		function insertNew($query){
			return $this->db->insert($this->table,$query);
		}
		function updateData($bam_id,$query){
		    $this->db->where('bam_id',$bam_id);
		    return $this->db->update($this->table,$query);
		}
		function deletetmp($id){
			$this->db->where('bam_id',$id);
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
		function getrowpresensi(){
			$this->db->where('is_delete',false);
			$this->db->not_like('bam_nama','Mentoring','after');
			return $this->db->get($this->table)->num_rows();
		}
		function getmentee(){
			$queries=array(
					'bam.is_delete'=>'false',
					'nilai_mentee.is_delete'=>'false',
					'mentee.is_delete'=>'false'
				);
			$this->db->select('mentee_nim,mentee_nama,mentee_kelas,');
			$this->db->from($this->table);
			$this->db->join('nilai_mentee','nilai_mentee.bam_id=bam.bam_id');
			$this->db->join('mentee','nilai_mentee.mentee_id=mentee.mentee_id');
			$this->db->where($queries);
			return $this->db->get();
		}
		function getlastid(){
			$this->db->order_by('bam_id','desc');
			return $this->db->get($this->table)->result();
		}
		function getnilaiall(){
			$this->db->select('kelompok.kelompok_nama, bam.bam_id, bam.bam_nama,mentee_nama.mentee_id ,nilai_mentee.mentee_id, nilai_mentee.nilai_status,
			 nilai_mentee.nilai_status, nilai_mentee.nilai_kultum, nilai_mentee.nilai_kehadiran');
			 $this->db->from('bam');
			$this->db->select('kelompok.kelompok_nama', 'bam.bam_id', 'bam.bam_nama', 'nilai_mentee.mentee_id', 'nilai_mentee.nilai_status',
			 'nilai_mentee.nilai_status', 'nilai_mentee.nilai_kultum', 'nilai_mentee.nilai_kehadiran');
			$this->db->from('bam');
			$this->db->join('nilai_mentee','bam.bam_id=nilai_mentee.bam_id');
			$this->db->join('kelompok_bam','bam.bam_id= kelompok_bam.bam_id');
			$this->db->join('kelompok','kelompok.kelompok_id= kelompok_bam.kelompok_id');	
			return $this->db->get();
		}
	}

?>