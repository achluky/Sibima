<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* Shining Team Controller */

class St extends CI_Controller {

	public $page = 'st';
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('general');
		$this->load->model('_ba');
		$this->load->model('_kelompok');
		$this->load->model('_bam');
		$this->load->model('_mentor');
		$this->load->model('_nmentee');
		$this->load->model('_mentee');
		$this->load->model('_st');

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
		echo "<script>document.location.href='".base_url('st/nilai/i')."'</script>";
	}

	public function nilai()
	{
		$this->load->model('_st');

		$id=$this->uri->segment(3);

		$data['query'] = $this->_st->get_kelompok($id);

		if($id=='i'){
			$data['option']="	
			<option value='".base_url()."st/nilai/i' selected='selected'>Ikhwan</option>
			<option value='".base_url()."st/nilai/a'>Akhwat</option>";
		}else{
			$data['option']="	
			<option value='".base_url()."st/nilai/i' >Ikhwan</option>
			<option value='".base_url()."st/nilai/a'  selected='selected'>Akhwat</option>";
		}
		$data['title'] = "Shining Team";
		$this->load->view('default/header',$data);
		$this->load->view('pages/st/v_st',$data);
		$this->load->view('default/footer');
	}

	public function update_nilai(){
		$this->db->where(array("kelompok_nama" => $this->input->post('kelompok_nama')));
		$this->db->update('shining_team', array("st_judul" => $this->input->post('judul'), "st_nilai" => $this->input->post('nilai')));
		echo"<script>alert('Data berhasil diubah');
			document.location.href='".base_url("st/nilai/i")."'
			</script>";
	}

	public function generate($id){
		$sql = "SELECT k.kelompok_nama, m.mentor_nama FROM kelompok k, mentor m WHERE m.mentor_status = 'primary' and m.kelompok_id = k.kelompok_id and k.kelompok_nama like '$id%' ";
		$query = $this->db->query($sql)->result();

		if ($id == "i")
			$mentee = $this->csvreader->parse_text(file_get_contents('./uploads/st-ikhwan.csv'));
		else
			$mentee = $this->csvreader->parse_text(file_get_contents('./uploads/st-akhwat.csv'));
		// print_r($mentee);

		foreach ($query as $data) {
			$st = array(
						"kelompok_nama" => $data->kelompok_nama,
						"mentor_nama"  	=> $data->mentor_nama,
					);	
			$found = false;
			foreach ($mentee as $val) {
				if ($data->kelompok_nama == $id.$val['No Kelompok']){
					$st['st_nilai'] = $val['Nilai'];
					$st["st_judul"] = $val['Judul Shining Team'];
					$found = true;
				} 
			}
			if (!$found) {
				$st['st_nilai'] = 0;
				$st["st_judul"] = "-"; 
			}
			echo "$st[kelompok_nama] - $st[mentor_nama] - $st[st_judul] - $st[st_nilai]<br>";
			$this->db->insert('shining_team', $st);
		}
	}
}