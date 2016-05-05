<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public $page = 'dashboard';

	 public function __construct()
	 {
	 	parent::__construct();
	 	$this->load->model('_bam');
	 	
		$this->output->set_header('Last-Modified:'.gmdate('D, d M Y H:i:s').'GMT');
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
		$this->output->set_header('Cache-Control: post-check=0, pre-check=0',false);
		$this->output->set_header('Pragma: no-cache');
	 }

	public function index()
	{
		$this->load->model('_kelompok_bam');
		$data['title'] = ucfirst($this->page);
		if ($this->session->userdata('nim') == 'bm_admin')
			$data['kel'] = "";
		else if($this->session->userdata('role') == 'mentor')
		{
			$this->load->model('_kelompok');
			$data['listBam'] = $this->_bam->getListMentoring();
			$data['namakel'] = $this->_kelompok->getNamaKelompok($this->session->userdata('idkel'));
		}
		else
		{
			$this->load->model('_mentee');
			$this->load->model('_mentor');
			$this->load->model('_nmentee');
			$kelId = $this->_mentee->getKelompokIdByNim($this->session->userdata('nim'));
			$data['mentor'] = $this->_mentor->getDataMentorByKelompokId($kelId)->result();
			$data['report'] = $this->_nmentee->getAgendaReportByNim($this->session->userdata('nim'));
			$data['general'] = $this->_nmentee->getNilaiAcaraByNim($this->session->userdata('nim'));
			// echo "<pre>";
			// print_r($data);
			// die();
			$this->session->set_userdata(array('idkel' => $kelId));
		}
		if($this->session->userdata('nim') != 'bm_admin')
		{
			$this->load->model('_user');
			$pwdStatus = $this->_user->getLastUpdate($this->session->userdata('nim'));
			if(is_null($pwdStatus))
			{
				$this->session->set_flashdata('status','warning');
				$this->session->set_flashdata('messages', 'Silahkan ganti password anda di <a href="'.base_url("profile").'">disini</a>');
			}
		}
		$this->load->view('default/header',$data);
		$this->load->view('pages/v_'.$this->page,$data);
		$this->load->view('default/footer');
	}

	public function chooseKelompok()
	{
		$data['title'] = ucfirst('Pilih Kelompok');
		$data['kelompok'] = $this->_kelompok_mentor->getKelompokByMentorNim($this->session->userdata('nim'));
		$this->load->view('pages/v_choose', $data);
	}

	public function chosen($id){
		if($this->session->userdata('idkel') != NULL)
			$this->session->unset_userdata('idkel');
		$this->session->set_userdata(array('idkel' => $id));
		// echo "<script>window.location.history.go(-2)</script>";
		redirect('dashboard');
	}

	public function calender()
	{
		$this->load->view("quickstart");
	}

	// Fungsi untuk mendapatkan feed dari sebuah url, 
	// ini bisa diaplikasikan untuk kedepannya ketika BM sudah memiliki blog yg sudah terurus dengan baik
	public function get_feed(){ 
		try {
			$url = 'http://academiccenter.web.id/feed'; // url yg akan contentnya diambil
			if($this->isDomainAvailible($url)){
				$this->load->library('Rssparser', array('url' => $url, 'life' => 2));
				$data = $this->rssparser->getFeed(6);
				return $data;
			}
			else{
				return 'need';
			}
		} catch (Exception $e) {
			return 'need';
		}
	}

	// Fungsi untuk mengecek apakah url yg akan diambil tersedia atau tidak
   public function isDomainAvailible($domain)
   {
           if(!filter_var($domain, FILTER_VALIDATE_URL))
            	return false;

           $curlInit = curl_init($domain);
           curl_setopt($curlInit,CURLOPT_CONNECTTIMEOUT,10);
           curl_setopt($curlInit,CURLOPT_HEADER,true);
           curl_setopt($curlInit,CURLOPT_NOBODY,true);
           curl_setopt($curlInit,CURLOPT_RETURNTRANSFER,true);

           $response = curl_exec($curlInit);

           curl_close($curlInit);

           return ($response) ? true : false;
   }

}