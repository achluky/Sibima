<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class _nmentee extends CI_Model {
	public $table="nilai_mentee";
	function getall($limit,$start){
		$this->db->limit($limit,$start);
		$this->db->where('is_delete',false);
		return $this->db->get($this->table);
	}
	function getby($query){
		$query['is_delete']=false;
		return $this->db->get_where($this->table,$query);
	}
	function insertNew($query){
		return $this->db->insert($this->table,$query);
	}
	function saveUpdate($id,$query){
		$this->db->where('nilai_mantee_id',$id);
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
	// function getAllNoLimit($bam_id){
	// 	$this->db->join('mentee', 'mentee.mentee_id = nilai_mentee.mentee_id', 'inner');
	// 	$this->db->where(array('bam_id' => $bam_id, 'nilai_mentee.is_delete' => false));
	// 	return $this->db->get($this->table);
	// }
	function getDetailMenteeKelompok($bam_id, $kelompok_id)
	{
		$this->db->select('mentee.mentee_id, mentee_nama, mentee_nim, nilai_kultum, nilai_kehadiran');
		$this->db->join('mentee', 'mentee.mentee_id = nilai_mentee.mentee_id', 'right');
		$this->db->where(array('bam_id' => $bam_id, 'kelompok_id' => $kelompok_id,'nilai_mentee.is_delete' => false));
		return $this->db->get($this->table);
	}
	//function untuk mengambil nilai mentee dari bam berdasarkan nim
	function getNilaiNim($bam_id, $mentee_nim)
	{
		$this->db->join('mentee','mentee.mentee_id = nilai_mentee.mentee_id','inner');
		$this->db->where(array('bam_id' => $bam_id, 'mentee_nim' => $nim, 'nilai_mentee.is_delete' => false));
		return $this->db->get($this->table);
	}
	//function untuk mengambil nilai mentee dari bam berdasarkan id kelompok
	function getNilaiByKelompok($bam_id, $kelompok_id)
	{
		$this->db->join('mentee','mentee.mentee_id = nilai_mentee.mentee_id', 'inner');
		$this->db->where(array('bam_id' => $bam_id, 'kelompok_id' => $kelompok_id, 'nilai_mentee.is_delete' => false));
		return $this->db->get($this->table);
	}

	function updateby($where,$data){
		$this->db->where($where);
		return $this->db->update($this->table,$data);
	}

	// function untuk mendapatkan nilai keseluruhan acara mentoring dari mentee berdasarkan nim
	function getAgendaReportByNim($nim)
	{
		$this->db->select('bam_nama, nilai_kehadiran, nilai_kultum');
		$this->db->join('mentee','mentee.mentee_id = nilai_mentee.mentee_id');
		$this->db->join('bam','nilai_mentee.bam_id = bam.bam_id');
		$this->db->where(array('mentee_nim' => $nim, 'bam_tipe' => false));
		$this->db->order_by('bam_nama','ASC');
		return $this->db->get($this->table)->result();
	}
	//function untuk mendapatkan nilai dari acara yg didefinisikan dan berdasarkan nim
	function getNilaiByAcaraByNim($acara, $nim)
	{
		$this->db->select('bam_nama, nilai_kehadiran');
		$this->db->join('mentee','mentee.mentee_id = nilai_mentee.mentee_id');
		$this->db->join('kelompok_bam','nilai_mentee.kelompok_bam_id = kelompok_bam.kelompok_bam_id');
		$this->db->join('bam','nilai_mentee.bam_id = bam.bam_id');
		$this->db->where(array('mentee_nim' => $nim, 'bam_tipe' => '1', 'bam_nama' => $acara));
		$this->db->get($this->table)->result();
	}
	//function untuk mendapatkan semua nilai dari acara berdasarkan nim mentee
	function getNilaiAcaraByNim($nim)
	{
		$this->db->select('bam_nama, nilai_kehadiran');
		$this->db->join('mentee','mentee.mentee_id = nilai_mentee.mentee_id');
		$this->db->join('bam','nilai_mentee.bam_id = bam.bam_id');
		$this->db->where(array('mentee_nim' => $nim, 'bam_tipe' => '1'));
		$this->db->get($this->table)->result();
	}
	//function untuk update nilai mentee berdasarkan kelompok_bam_id dan mentee_id
	function updateNilai($bam_id,$mentee_id, $data)
	{
		$this->db->where(array('bam_id' => $bam_id, 'mentee_id' => $mentee_id));
		return $this->db->update($this->table, $data);
	}

	function getjoinby($data){
		$this->db->from('mentee');
		$this->db->join($this->table, 'mentee.mentee_id = nilai_mentee.mentee_id');
		$this->db->join('bam', 'bam.bam_id = nilai_mentee.bam_id');
		$this->db->where($this->table.'.is_delete',false);
		$this->db->where('bam.is_delete',false);
		$this->db->where($data);
		$this->db->order_by('bam.bam_nama asc');
		return $this->db->get();
	}
	
	function getlastpresence($data){
		$this->db->from('mentee');
		$this->db->join($this->table, 'mentee.mentee_id = nilai_mentee.mentee_id');
		$this->db->join('bam', 'bam.bam_id = nilai_mentee.bam_id');
		$this->db->where($this->table.'.is_delete',false);
		$this->db->where($data);
		$this->db->limit(20);
		$this->db->order_by('nilai_mentee.updated_at desc');
		return $this->db->get();
	}

	// method untuk mengupdate kehadiran dari presensi mentee
	function updatePresensiHadir($bamid, $nim, $telat = null){
		// untuk mengecek apakah nim yang diinputkan ada
		$this->db->select('mentee_id');
		$query = $this->db->get_where('mentee',array('mentee_nim' => $nim, 'is_delete' => false));
		if($query == '') return 'nim tidak dapat ditemukan';
		$result = $query->result();
		$mentee_id = $result[0]->mentee_id;

		// untuk mengecek apakah id bam yang dimasukkan ada
		$this->db->select('bam_id');
		$query2 = $this->db->get_where('bam', array('bam_id' => $bamid, 'is_delete' => false));
		if($query2 == '') return 'BAM tidak dapat ditemukan';
		
		$where = array('mentee_id' => $mentee_id,'bam_id'=>$bamid);
		$nilai = (!is_null($telat)) ? 70 : 100;
		$now = date('Y-m-d H:i:s',time());
		$data = array('nilai_status' => 'Hadir', 'nilai_kehadiran'=> $nilai, 'updated_at' => $now);
		$this->updateby($where,$data);
		return "Berhasil di inputkan";
	}

}

/* End of file _nmentee.php */
/* Location: ./application/models/_nmentee.php */