<?php
class _kelompok_bam extends ci_model{
  public $table="kelompok_bam";

  function insertNew($data){
  	$this->db->insert($this->table, $data);
  	return $this->db->insert_id();
  }

  function getDetailBamData($id)
  {
  	$this->db->select('bam.bam_id, kelompok_bam_id, bam_nama, kelompok_nama, kelompok_bam_tempat, kelompok_bam_tanggal, kelompok_bam_materi, kelompok_bam_kultum');
  	$this->db->join('bam','bam.bam_id = kelompok_bam.bam_id');
  	$this->db->join('kelompok', 'kelompok_bam.kelompok_id = kelompok.kelompok_id');
  	$this->db->where(array('kelompok_bam_id' => $id, 'kelompok_bam.is_delete' => false));
  	return $this->db->get($this->table);
  }

  function updateData($kelompok_bam_id,$query){
      $this->db->where('kelompok_bam_id',$kelompok_bam_id);
      return $this->db->update($this->table,$query);
  }

  function getIdByBamAndKelompok($bam_id, $kelompok_id)
  {
  	$this->db->select('kelompok_bam_id');
  	$this->db->where(array('bam_id' => $bam_id, 'kelompok_id' => $kelompok_id));
  	return $this->db->get($this->table)->row()->kelompok_bam_id;
  }

  function cekBam($id, $kelompokId, $mentorNim){
  	$this->db->select('kelompok_bam_id');
  	$this->db->join('kelompok_mentor', 'kelompok_mentor.kelompok_id = kelompok_bam.kelompok_id');
  	$this->db->join('mentor','mentor.mentor_id = kelompok_mentor.mentor_id');
  	$this->db->where(array('kelompok_bam_id' => $id ,'kelompok_bam.kelompok_id' => $kelompokId, 'mentor_nim' => $mentorNim ,'kelompok_bam.is_delete' => false));
  	return $this->db->get($this->table)->num_rows();
  }

  function getLastId()
  {
    $this->db->select('kelompok_bam_id');
    $this->db->order_by('kelompok_bam_id', 'desc');
    $this->db->limit('1');
    $this->db->get($this->table)->kelompok_bam_id;
  }

}
?>