<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Quisioner extends CI_Controller {

	public $page = 'quisioner';
	public function __construct(){
		parent::__construct();
		$this->load->model('_quisioner');

		$this->output->set_header('Last-Modified:'.gmdate('D, d M Y H:i:s').'GMT');
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
		$this->output->set_header('Cache-Control: post-check=0, pre-check=0',false);
		$this->output->set_header('Pragma: no-cache');
	}

	public function index()
	{
		$data['data_quisioner']=$this->_quisioner->get_data();
		$data['title'] = ucfirst($this->page);
		if(($data['data_quisioner']->num_rows()==0)and($this->session->userdata('role')=='admin')) redirect(base_url('quisioner/first'));
		$this->load->view('default/header',$data);
		$this->load->view('pages/quisioner/v_'.$this->page,$data);
		$this->load->view('default/footer');
	}
	function addQuisioner(){
		$data=array(
			'kuisioner_nama'=>$this->input->post('judul'),
			'kuisioner_url'=>$this->input->post('link'),
			'kuisioner_responden'=>ucfirst($this->input->post('koresponden'))
		);
		$add=$this->_quisioner->add($data);
		if ($add){
			redirect('../quisioner');
		}else{
			echo "Failed";
		}
		
	}
	function deleteQuisioner($id){
		$del=$this->_quisioner->delete($id);
		if($del){
			redirect('../quisioner');
			
		}else{
			echo "Failed";
		}
	}
	function showedit(){
		$id=$this->input->post('data');
		$data=$this->_quisioner->getby(array('kuisioner_id'=>$id))->result_array();
		echo json_encode($data[0]);
	}
	function saveedit(){
		$id=$this->uri->segment(3);
		$data=array(
			'kuisioner_nama'=>$this->input->post('judul'),
			'kuisioner_url'=>$this->input->post('link'),
			'kuisioner_responden'=>ucfirst($this->input->post('koresponden'))
		);
		$edit=$this->_quisioner->edit($id,$data);
		if($edit){
			redirect('../quisioner');
		}else{
			echo "Failed";
		}
	}

	public function first()
	{
		if($this->session->userdata('role')!='admin')
		{	
			echo "<script>document.location.href='".base_url('notfound')."'</script>";
			return;
		}
		$data['title'] = ucfirst($this->page);
		$this->load->view('default/header',$data);
		$this->load->view('pages/quisioner/e_'.$this->page,$data);
		$this->load->view('default/footer');	
	}
}