<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data_mentor extends CI_Controller {
	
	public $page = 'data mentor';
	public function __construct()
	{
	 	parent::__construct();
	 	$this->load->model('_mentor');
	 	
		$this->output->set_header('Last-Modified:'.gmdate('D, d M Y H:i:s').'GMT');
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
		$this->output->set_header('Cache-Control: post-check=0, pre-check=0',false);
		$this->output->set_header('Pragma: no-cache');
	 }

	public function index($kel = null)
	{
		redirect(base_url().'data_mentor/mentor/');
	}
	public function mentor($kel = null){
		if($this->session->userdata('role')!='admin')
		{
			echo "<script>document.location.href='".base_url('notfound')."'</script>";
			return;
		}
		if($kel == 'akhwat' )
		{
			$data['option']="	
			<option value='".base_url()."data_mentor/mentor/ikhwan' >Ikhwan</option>
			<option value='".base_url()."data_mentor/mentor/akhwat'  selected='selected'>Akhwat</option>";
		}
		else
		{
			$data['option']="
			<option value='".base_url()."data_mentor/mentor/ikhwan' selected='selected'>Ikhwan</option>
			<option value='".base_url()."data_mentor/mentor/akhwat'>Akhwat</option>";
		}
		$data['title'] = ucfirst($this->page);
		$select = "mentor_nama, mentor_nim, mentor_telp";
		$jk = ($kel == null) ? "l" : (($kel == "akhwat") ? "p" : "l");
		$data['mentor'] = $this->_mentor->getMentorExcept($jk, $select);
		$this->load->view('default/header',$data);
		$this->load->view('pages/datamen/v_mentor',$data);
		$this->load->view('default/footer');
	}
}