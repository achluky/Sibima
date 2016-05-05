<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Presensi extends CI_Controller {

	public $page = 'presensi';

	public function __construct(){
		parent::__construct();
		$this->load->model('_bam');
		$this->load->model('_nmentee');
		$this->load->model('_mentee');
		$this->load->model('_kelompok');

		$this->output->set_header('Last-Modified:'.gmdate('D, d M Y H:i:s').'GMT');
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
		$this->output->set_header('Cache-Control: post-check=0, pre-check=0',false);
		$this->output->set_header('Pragma: no-cache');
	}

	public function index()
	{
		if($this->session->userdata('role')!='admin')
		{	
			echo "<script>document.location.href='".base_url('notfound')."'</script>";
			return;
		}
		$bam = $this->_bam->getallpresensi();
		$data['data'] = $bam->result();
		$data['bam'] = $this->_bam->getListGeneral();
		$jml = $bam->num_rows();
		$data['title'] = ucfirst($this->page);
		if($this->_kelompok->getallnolimit()->num_rows()>0){
			$view ='pages/presensi/mentoring/v_'.$this->page;
			if($jml==0) redirect(base_url('presensi/first'));
		}else
			$view='pages/kelompok/e_kelompok';
		$this->load->view('default/header',$data);
		$this->load->view($view,$data);
		$this->load->view('default/footer');
	}
	public function first()
	{
		if($this->session->userdata('role')!='admin')
		{	
			echo "<script>document.location.href='".base_url('notfound')."'</script>";
			return;
		}
		$data['bam'] = $this->_bam->getListGeneral();
		$data['title'] = ucfirst($this->page);
		$this->load->view('default/header',$data);
		$this->load->view('pages/presensi/mentoring/e_'.$this->page,$data);
		$this->load->view('default/footer');	
	}
	public function detail($id)
	{
		if($this->session->userdata('role')!='admin')
		{	
			echo "<script>document.location.href='".base_url('notfound')."'</script>";
			return;
		}
		$data['title'] = "detail ".ucfirst($this->page);
		$data['id']=$id;
		$data['query']=$this->_nmentee->getjoinby(array('bam.bam_id'=>$id));
		$data['mentee']=$this->_mentee->getallnolimit()->result_array();
		$this->load->view('default/header',$data);
		$this->load->view('pages/presensi/mentoring/d_'.$this->page,$data);
		$this->load->view('default/footer');
	}
	
	public function addagenda()
	{
		$this->load->model('_kelompok_bam');
		$data=array(
				'bam_id'=>$this->input->post('nama'),
				'kelompok_bam_tanggal'	=> date('Y-m-d',strtotime($this->input->post('tanggal'))),
				'kelompok_bam_tempat'	=> $this->input->post('tempat'),
				'kelompok_bam_materi'	=> $this->input->post('tema'),
				'kelompok_bam_kultum'	=> '-'
		);
		if($this->_kelompok_bam->insertnew($data)){
			$query = $this->_mentee->getallnolimit();
			foreach ($query->result() as $result) {
				$nilai=array(
						'bam_id'		=> $this->input->post('nama'),
						'mentee_id' 	=> $result->mentee_id,
						'materi_kultum' => '-',
						'nilai_status' 	=> 'Tidak Hadir',
						'nilai_kultum' 	=> 0,
						'nilai_kehadiran'	=>0,
					);
				$this->_nmentee->insertnew($nilai);
			}
				echo "<script>
					alert('Data berhasil di inputkan');
				</script>";
		}else
			echo "<script>
				alert('Terjadi kesalahan pada saat input data');
			</script>";
		echo "<script>document.location.href='".base_url('presensi')."'</script>";
	}
	public function delete($id){
		if($this->_bam->deletetmp($id)){
			$this->_nmentee->deletetmp($id);
			echo"<script>alert('Data berhasil dihapus');
			document.location.href='".base_url('presensi')."'
			</script>";
		}
	}

	public function input($id)
	{
		if($this->session->userdata('role')!='admin')
		{	
			echo "<script>document.location.href='".base_url('notfound')."'</script>";
			return;
		}
		$data['title'] = "Form Presensi";
		$data['id']=$id;
		$data['query']=$this->_nmentee->getjoinby(array('bam.bam_id'=>$id, 'nilai_mentee.nilai_status !='=>'Hadir'));
		$data['last'] = $this->_nmentee->getlastpresence(array('bam.bam_id'=>$id, 'nilai_mentee.nilai_status'=>'Hadir'));
		$this->load->view('default/header',$data);
		$this->load->view('pages/presensi/mentoring/m_presensi',$data);
		$this->load->view('default/footer');
	}

	public function formpresent($id)
	{
		if($this->session->userdata('role')!='admin')
		{	
			echo "<script>document.location.href='".base_url('notfound')."'</script>";
			return;
		}
		$dat=$this->_bam->getby(array('bam_id'=>$id));
		if($dat->num_rows()>0){
			foreach ($dat->result() as $result) {
				$data['id']=$result->bam_id;
				$data['agenda']=$result->bam_nama;
			}
			$data['title'] = "Form Presensi ".ucfirst($data['agenda']);
			$data['mentee']=$this->_mentee->getallnolimit()->result_array();
			$this->load->view('pages/presensi/mentoring/f_'.$this->page,$data);
		}
	}
	public function	findnim(){
		$nim=$this->input->post('nim');
		$id=$this->input->post('id');
		$query=$this->_mentee->getby(array('mentee_nim'=>$nim));
		if($query->num_rows()>0){
			foreach ($query->result() as $result) {
				$idm=$result->mentee_id;
				$query2=$this->_nmentee->getby(array('mentee_id'=>$idm,'bam_id'=>$id));
				foreach ($query2->result() as $result2) {
					if($result2->nilai_status=='Hadir') echo "duplicate";
					else echo $result->mentee_nama;
				}
			}
		}else{
			echo "notfound";
		}
	}
	public function insertabsen($telat=null){
		$nim=$this->input->post('nim');
		$query=$this->_mentee->getby(array('mentee_nim'=>$nim));
		$bamid=$this->input->post('id');
		foreach ($query->result() as $result) {
			$id=$result->mentee_id;
		}
		$where = array('mentee_id' => $id,'bam_id'=>$bamid);
		$nilai = (!is_null($telat)) ? 70 : 100;
		$data = array('nilai_status' => 'Hadir',
		'nilai_kehadiran'=> $nilai);
		if($this->_nmentee->updateby($where,$data)){
			echo "success";
		}else{
			echo "failed";
		}
	}

	public function updateabsen($telat=null){
		date_default_timezone_set('Asia/Jakarta');

		$bamid = $_GET['bam'];
		$nim = $_GET['nim'];

		$query=$this->_mentee->getby(array('mentee_nim'=>$nim));
		
		foreach ($query->result() as $result) {
			$id=$result->mentee_id;
		}

		$where = array('mentee_id' => $id,'bam_id'=>$bamid);
		$nilai = (!is_null($telat)) ? 70 : 100;
		$now = date('Y-m-d H:i:s',time());
		$data = array('nilai_status' => 'Hadir', 'nilai_kehadiran'=> $nilai, 'updated_at' => $now);

		$update = $this->_nmentee->updateby($where,$data);

		redirect(base_url()."presensi/input/".$bamid);
		// $url = base_url()."presensi/input/".$bamid;

		// echo "<script>alert('Selamat Datang');window.location.href=\'$url\';</script>";
	}

	public function inserttugas(){
		$nim=$this->input->post('nim');
		$nilai=$this->input->post('nilai');
		$bamid=$this->input->post('id');
		$query=$this->_mentee->getby(array('mentee_nim'=>$nim));
		foreach ($query->result() as $result) {
			$id=$result->mentee_id;
		}
		$where = array('mentee_id' => $id,'bam_id'=>$bamid);
		$data = array('nilai_status' => 'Tugas',
		'nilai_kehadiran'=>$nilai);
		if($this->_nmentee->updateby($where,$data)){
			echo "<script>alert('Berhasil update nilai');
			document.location.href='".base_url('presensi/detail')."/".$bamid."'</script>";
		}else{
			echo "<script> alert('Maaf ada kegagalan disaat update tugas');";
		}
	}
	function showedit(){
		$id=$this->input->post('data');
		$data=$this->_nmentee->getjoinby(array('nilai_mantee_id'=>$id))->result_array();
		echo json_encode($data[0]);
	}
	function saveedit(){
		$id=$this->uri->segment(4);
		$data=array(
			'nilai_kehadiran'=>$this->input->post('nilai')
		);
		$edit=$this->_nmentee->saveUpdate($id,$data);
		if($edit){
			redirect('../presensi/detail/'.$this->uri->segment(3));
		}else{
			echo "Failed";
		}
	}
}