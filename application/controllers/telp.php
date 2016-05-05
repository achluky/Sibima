<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Telp extends CI_Controller {
	function index(){
		$this->load->model("_mentee");
		$telp = $this->_mentee->get_all_telp();
		
		foreach ($telp as $row) {
			echo $row->mentee_telp."<br>";
		}
	}
}