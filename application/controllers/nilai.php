<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Nilai extends CI_Controller {

	public $page = 'nilai';
	public function __construct()
	{
		parent::__construct();
		$this->load->model('_nmentee');
		$this->load->model('_kelompok');
		$this->load->model('_st');

		$this->output->set_header('Last-Modified:'.gmdate('D, d M Y H:i:s').'GMT');
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
		$this->output->set_header('Cache-Control: post-check=0, pre-check=0',false);
		$this->output->set_header('Pragma: no-cache');
	}
	public function index()
	{
		if($this->session->userdata('role')!='mentee')
		{	
			echo "<script>document.location.href='".base_url('notfound')."'</script>";
			return;
		}
		$data['title'] = ucfirst($this->page);
		$data['nilai'] = $this->_nmentee->getjoinby(array('mentee_nim'=>$this->session->userdata('nim')));
		$data['opening'] = 0;
		$query = $this->_nmentee->getjoinby(array('mentee_nim'=>$this->session->userdata('nim'),'bam_nama'=>'Opening MPAI'));
			foreach ($query->result() as $res) {
				$data['opening']=$res->nilai_kehadiran;
			}
		$data['closing'] = 0;
		$query = $this->_nmentee->getjoinby(array('mentee_nim'=>$this->session->userdata('nim'),'bam_nama'=>'Closing MPAI'));
			foreach ($query->result() as $res) {
				$data['closing']=$res->nilai_kehadiran;
			}
		$data['general'] = 0;
		$query = $this->_nmentee->getjoinby(array('mentee_nim'=>$this->session->userdata('nim'),'bam_nama'=>'General Mentoring'));
			foreach ($query->result() as $res) {
				$data['general']=$res->nilai_kehadiran;
			}
		$query=$this->_kelompok->getmentormentee($this->session->userdata('nim'));
		$data['nama']=$query->mentee_nama;
		$data['st']=$this->_st->nilai_mentee($this->session->userdata('nim'));
		echo "<script>console.log('".$query->mentee_nama."')</script>";
		$data['nim']=$query->mentee_nim;
		$data['kelompok']=$query->kelompok_nama;
		$data['mentor']=$query->mentor_nama;
		$data['kel_id']=$query->kelompok_id;
		$this->load->view('default/header',$data);
		$this->load->view('pages/nilai/v_'.$this->page,$data);
		$this->load->view('default/footer');
	}
}