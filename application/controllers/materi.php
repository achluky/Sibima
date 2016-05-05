<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class materi extends CI_Controller {

	public $page = 'materi';
	public function __construct(){
		parent::__construct();
		$this->load->model('_materi');

		$this->output->set_header('Last-Modified:'.gmdate('D, d M Y H:i:s').'GMT');
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
		$this->output->set_header('Cache-Control: post-check=0, pre-check=0',false);
		$this->output->set_header('Pragma: no-cache');
	}
	public function index()
	{
		$data['value']=$this->_materi->getall();
		if(($data['value']->num_rows()==0)and($this->session->userdata('role')=='admin')) echo "<script>document.location.href='".base_url('materi/first')."'</script>";
		else{
		$data['title'] = ucfirst($this->page);
		$this->load->view('default/header',$data);
		$this->load->view('pages/materi/v_'.$this->page,$data);
		$this->load->view('default/footer');
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
		$this->load->view('pages/materi/e_'.$this->page,$data);
		$this->load->view('default/footer');	
	}
	public function addnew(){
		if(!empty($_FILES['file'])){
			$nama = $this->input->post('materi').substr($_FILES['file']['name'], strlen($_FILES['file']['name']) - (substr($_FILES['file']['name'], -1) == 'x') ? 5 : 4);
			$data=array(
					'materi_nama'=>$this->input->post('materi'),
					'materi_file'=>$nama
				);
			$config['upload_path'] = './uploads/materi';
			$config['allowed_types'] = 'pdf|pptx|ppt';
			$config['file_name']= $nama;
			$config['max_size']='2048';
			$this->load->library('upload', $config);
			if ($this->upload->do_upload("file"))
				if($this->_materi->insertnew($data)) redirect(base_url('materi'),'refresh');
				else echo "gagal insert";
			else
				echo "
				<script>
					alert('".strip_tags($this->upload->display_errors())."');
					document.location.href='".base_url('materi')."';
				</script>";
		}
	}
	public function delete($id){
		if ($this->_materi->deletetmp($id)){
			redirect(base_url('materi'));
		}
	}
	public function deleteperma(){
		$data=$this->_materi->getby(array('is_delete'=>true));
		if($data->num_rows()>0){
			foreach ($data->result() as $m) {
				unlink('./uploads/materi/'.$m->materi_file);
			}
			$this->_materi->deleteall();
		}
		redirect(base_url('materi'));
	}
	public function showedit(){
		$id=$this->input->post('data');
		$data=$this->_materi->getby(array('materi_id'=>$id))->result_array();
		echo json_encode($data[0]);
	}
	public function saveedit($id){
		$datas=$this->_materi->getby(array('materi_id'=>$id));
		$nama=$this->input->post('materi').substr($_FILES['file']['name'], strlen($_FILES['file']['name'])-4);
		$data=array(
				'materi_nama'=>$this->input->post('materi')
			);
		if(!empty($_FILES['file']['name'])){
			$data['materi_file']=$nama;
			$config['upload_path'] = './uploads/materi';
			$config['allowed_types'] = 'pdf|ppt|pptx';
			$config['file_name']=$nama;
			$config['overwrite']=TRUE;
			$config['max_size']=102400;
			$this->load->library('upload', $config);
			if ($this->upload->do_upload("file"))
			{
				if($this->_materi->saveUpdate($id,$data))
					echo "<script>alert('Data berhasil di update');</script>";
				else echo "<script>alert('Terjadi kesalahan pada saat update')</script>";
			}else{
				echo "<script>alert('".strip_tags($this->upload->display_errors())."');
				document.location.href='".base_url('materi')."'
				</script>";
			}
		}else{
			if($this->_materi->saveUpdate($id,$data))
				echo "<script>alert('Data berhasil di update');</script>";
			else echo "<script>alert('Terjadi kesalahan pada saat update')</script>";
		}
		echo "<script>document.location.href='".base_url('materi')."'</script>";
	}
}