<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require(APPPATH.'libraries/REST_Controller.php');

class Api extends REST_Controller{

	function mentee_get(){
		$this->load->model('_mentee');
		$result = $this->_mentee->getOneByNim($this->get('nim'));
		$status = ($result == FALSE) ? 'Gagal, Data tidak dapat ditemukan' : 'Sukses';
		$this->response(array('status' => $status, 'Data : ' => $result));
	}

	function mentees_get(){
		$this->load->model('_mentee');
		$result = $this->_mentee->getallnolimit();
		$this->response(array('status' => 'sukses', 'Data : ' => $result->result()));
	}

	function nims_get(){
		$this->load->model('_mentee');
		$result = $this->_mentee->getNimAllMentee();
		$this->response(array('status' => 'sukses', 'Data : ' => $result));
	}

	//update an existing presence and respond with status/errors
	function presence_post()
	{
		$this->load->model('_nmentee');
		$result = $this->_nmentee->updatePresensiHadir($this->post('bam_id'), $this->post('nim'));
		$this->response(array('bam : '.$this->post('bam_id'), 'nim : '.$this->post('nim') , 'status : '.$result));
	}

}

?>