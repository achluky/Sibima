<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile extends CI_Controller {
	public $page = 'profile';

	public function __construct(){
		parent::__construct();
		$this->load->model('_user');
		$this->load->model('_mentee');
		$this->load->model('_mentor');
	}

	public function index(){
		$data['title'] = ucfirst($this->page);
		if($this->session->userdata('role')!='admin'){
			if($this->session->userdata('role')=='mentor'){
				$query=$this->_mentor->getby(array('mentor_nim'=>$this->session->userdata('nim')));
				foreach ($query->result() as $result) {
					$data['nim']=$result->mentor_nim;
					$data['nama']=$result->mentor_nama;
					$data['telp']=$result->mentor_telp;
				}
			}else{
				$query=$this->_mentee->getby(array('mentee_nim'=>$this->session->userdata('nim')));
				foreach ($query->result() as $result) {
					$data['nim']=$result->mentee_nim;
					$data['nama']=$result->mentee_nama;
					$data['telp']=$result->mentee_telp;
					$data['kelas']=$result->mentee_kelas;
					$data['jurusan']=$result->mentee_jurusan;
				}
			}
		}
		$this->load->view('default/header', $data);
		$this->load->view('pages/v_profile', $data);
		$this->load->view('default/footer');
	}

	public function edit(){
		$_print = "";
		if($this->session->userdata('role') != 'admin'){
			if ($this->session->userdata('role')=='mentor')
			{
				$data['mentor_nama']=strip_tags($this->input->post('nama'));
				$data['mentor_telp']=$this->input->post('telp');
				$this->_mentor->saveUpdate($this->_mentor->getidbynim($this->session->userdata('nim')),$data);
				$_print = "profile";
			}
			else if($this->session->userdata('role')=='mentee')
			{
				$data['mentee_nama']=strip_tags($this->input->post('nama'));
				$data['mentee_telp']=$this->input->post('telp');				
				$data['mentee_kelas']=strip_tags($this->input->post('kelas'));				
				$data['mentee_jurusan']=strip_tags($this->input->post('jurusan'));
				$this->_mentee->saveUpdate($this->_mentee->getidbynim($this->session->userdata('nim')),$data);
				$_print = "profile";
			}
			$this->session->unset_userdata('nama');
			$this->session->set_userdata('nama', $this->input->post('nama'));
		}

		if($this->input->post('old_pass') != ""){
			$pass = $this->input->post('old_pass');
			$newpass= $this->input->post('new_pass');
			$query = $this->_user->getby(array('user_id'=>$this->session->userdata('id')))->row();
			$passgg = $query->user_password;
			if(md5($pass)==$passgg)
			{
				if ($this->_user->saveUpdate($this->session->userdata('id'),array('user_password'=>md5($newpass),'last_update' => date('Y-m-d H:i:s', strtotime('now')))))
					$_print="password"; 
				else $_print="fail";
			}
			else
				$_print="passfail";	
		}
		
		echo json_encode($_print);
	}
}