<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class talaqi extends CI_Controller {

	public $page = 'talaqi';

	public function __construct(){
		parent::__construct();
		$this->load->model('_bat');
		$this->load->model('_nmentor');
		$this->load->model('_mentor');
		$this->load->model('_kelompok');

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
		$jml=$this->_bat->getrow();
		$data['data']=$this->_bat->getall();
		$data['title'] = ucfirst($this->page);
		if($this->_kelompok->getallnolimit()->num_rows()>0){
			$view='pages/presensi/talaqi/v_'.$this->page;
			if($jml==0) redirect(base_url('talaqi/first'));
		}else
			$view='pages/kelompok/e_kelompok';
		$this->load->view('default/header',$data);
		$this->load->view($view,$data);
		$this->load->view('default/footer');
	}
	public function first()
	{
		$data['title'] = ucfirst($this->page);
		$this->load->view('default/header',$data);
		$this->load->view('pages/presensi/talaqi/e_'.$this->page,$data);
		$this->load->view('default/footer');	
	}
	public function detail($id)
	{
		if($this->session->userdata('role')!='admin')
		{	
			echo "<script>document.location.href='".base_url('notfound')."'</script>";
			return;
		}
		$data['title'] = "detail ".ucfirst($this->page);
		$data['id']=$id;
		$data['mentor']=$this->_mentor->getallnolimit()->result_array();
		$data['query']=$this->_nmentor->getjoinby(array('bat.bat_id'=>$id));
		$this->load->view('default/header',$data);
		$this->load->view('pages/presensi/talaqi/d_'.$this->page,$data);
		$this->load->view('default/footer');
	}

	function ajax_page($param,$offset = 0)
	{
		$limit = 10;
		$like=$this->input->post('like');
		$jml=$this->_nmentor->getjoinby(array('bat.bat_id'=>$param),$like)->num_rows();
		$config['base_url'] = base_url('talaqi/ajax_page/'.$param.'/'.$like.'/');
		$config['div'] = "#data";
		$config['total_rows'] = $jml;
	    $config['per_page'] = $limit;
	    $config['uri_segment']=4;

	    $this->jquery_pagination->initialize($config);
		$query2=$this->_nmentor->getjoinby(array('bat.bat_id'=>$param),$like,$limit,$offset);
	    $html = '<table class="table table-hover">
	            <thead>
	            <tr>
	                <th>#</th>
	                <th>Nim</th>
	                <th>Nama</th>
	                <th>Status</th>
	                <th>Aksi</th>
	            </tr>
	            </thead>';
        $a=0;
        foreach ($query2->result() as $data) {
        	$a++;
        	$html.="
				<tr>
	            	<td>".$a."</td>
	            	<td>".$data->mentor_nim."</td>
	            	<td>".$data->mentor_nama."</a></td><td>";
	        if($data->nilai_mentor_status=='Hadir') $html.="<span class='label label-block label-success'>";
	        else if($data->nilai_mentor_status='Tidak Hadir') $html.="<span class='label label-block label-danger'>";
	        else $html.="<span class='label label-block label-warning'>";
	        $html.=$data->nilai_mentor_status."</span></td>
	            	<td>
		            	<a href='#' class='editpresensi' onclick='update(this); return false' data-idpresensi='".$data->nilai_mentor_id."'><button class='btn btn-primary btn-bima'>Edit</button></a>
		            </td>
	            </tr>
			";
        }
        $html.='<tr><td colspan="6" align="center">'.$this->jquery_pagination->create_links().'</td></tr></table>';
		echo $html;
	}
	public function addagenda()
	{
		$time=$this->input->post('tanggal');
		$data=array(
				'bat_nama'=>$this->input->post('nama'),
				'bat_tanggal'=>date('Y-m-d',strtotime($time)),
				'bat_tempat'=>$this->input->post('tempat'),
				'bat_materi'=>$this->input->post('tema')
			);
		if($this->_bat->insertnew($data)){
			$idnya=$this->_bat->getlastid();
			foreach ($idnya as $result) {
				$id=$result->bat_id;
				break;
			}
			$query=$this->_mentor->getallnolimit();
			foreach ($query->result() as $result) {
				$nilai=array(
						'bat_id'=>$id,
						'mentor_id'=>$result->mentor_id
					);
				$this->_nmentor->insertnew($nilai);
			}
				echo "<script>
					alert('Data berhasil di inputkan');
				</script>";
		}else
			echo "<script>
				alert('Terjadi kesalahan pada saat input data');
			</script>";
		echo "<script>document.location.href='".base_url('talaqi')."'</script>";
	}
	public function delete($id){
		if($this->_bat->deletetmp($id)){
			$this->_nmentor->deletetmp($id);
			echo"<script>alert('Data berhasil dihapus');
			document.location.href='".base_url('talaqi')."'
			</script>";
		}
	}
	public function formpresent($id)
	{
		if($this->session->userdata('role')!='admin')
		{	
			echo "<script>document.location.href='".base_url('notfound')."'</script>";
			return;
		}
		$dat=$this->_bat->getby(array('bat_id'=>$id));
		if($dat->num_rows()>0){
			foreach ($dat->result() as $result) {
				$data['id']=$result->bat_id;
				$data['agenda']=$result->bat_nama;
			}
			$data['title'] = "Form Presensi ".ucfirst($data['agenda']);
			$data['mentor']=$this->_mentor->getallnolimit()->result_array();
			$this->load->view('pages/presensi/talaqi/f_'.$this->page,$data);
		}
	}
	public function	findnim(){
		$nim=$this->input->post('nim');
		$id=$this->input->post('id');
		$query=$this->_mentor->getby(array('mentor_nim'=>$nim));
		if($query->num_rows()>0){
			foreach ($query->result() as $result) {
				$idm=$result->mentor_id;
				$query2=$this->_nmentor->getby(array('mentor_id'=>$idm,'bat_id'=>$id));
				foreach ($query2->result() as $result2) {
					if($result2->nilai_mentor_status=='Hadir') echo "duplicate";
						else
					echo $result->mentor_nama;
				}
			}
		}else{
			echo "notfound";
		}
	}
	public function insertabsen(){
		$nim=$this->input->post('nim');
		$query=$this->_mentor->getby(array('mentor_nim'=>$nim));
		foreach ($query->result() as $result) {
			$id=$result->mentor_id;
		}
		$where = array('mentor_id' => $id);
		$data = array('nilai_mentor_status' => 'Hadir');
		if($this->_nmentor->updateby($where,$data)){
			echo "success";
		}else{
			echo "failed";
		}
	}
	public function change(){
		$idtal=$this->uri->segment(3);
		$id=$this->input->post("id");
		$edit=$this->_nmentor->saveUpdate($id);
		if($edit){
			echo $this->ajax_page($idtal,0);
		}else{
			echo "Failed";
		}
	}

}

/* End of file talaqi.php */
/* Location: ./application/controllers/talaqi.php */