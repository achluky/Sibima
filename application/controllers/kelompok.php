<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Kelompok extends CI_Controller {

	public $page = 'kelompok';
	public function __construct(){
		parent::__construct();
		$this->load->model('_kelompok');
		$this->load->model('_user');
		$this->load->model('_mentor');
		$this->load->model('_mentee');

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
		$data['dataIkhwan'] = $this->_kelompok_mentor->getKelompokMentor('IT')->result();
		$data['dataAkhwat'] = $this->_kelompok_mentor->getKelompokMentor('AT')->result();
		$data['title'] = ucfirst($this->page);
		$this->load->view('default/header',$data);
		$this->load->view('pages/kelompok/v_'.$this->page,$data);
		$this->load->view('default/footer');
	}

	public function detail($idkel)
	{
		if(($this->session->userdata('role')=='mentor') or ($this->session->userdata('role')=='mentee'))
		{	
			$idkel=$this->session->userdata('idkel');
		}
		$data['data'] = $this->_kelompok->getKelompokMentee($idkel)->result();
		$kelompok = $this->_kelompok_mentor->getKelompokMentor(null,$idkel)->result();
		foreach ($kelompok as $result) {
			$data['id']=$result->kelompok_id;
			$data['namakel']=$result->kelompok_nama;
			($result->mentor_status=='mentor') ? $data['mentor1'] = $result->mentor_nama : $data['mentor2'] = $result->mentor_nama;
		}
		if(!isset($data['mentor2']))$data['mentor2']='-';
		$data['title'] = ucfirst($this->page);
		$data['kelompok']=$this->_kelompok->getAllNoLimit()->result();
		$this->load->view('default/header',$data);
		$this->load->view('pages/kelompok/d_'.$this->page,$data);
		$this->load->view('default/footer',$data);
	}

	public function first()
	{
			$data['title'] = ucfirst($this->page);
			$this->load->view('default/header',$data);
			$this->load->view('pages/kelompok/e_'.$this->page,$data);
			$this->load->view('default/footer');
	}

	public function addnew()
	{
		$config['upload_path'] = './uploads';
		$config['allowed_types'] = 'csv';
		$config['overwrite'] = TRUE;
		$config['file_name']= (strtoupper(substr($this->input->post('gender'),0,1)) == 'I') ? 'kelompok-ikhwan' : 'kelompok-akhwat';
		$jenis_kelamin = (strtoupper(substr($this->input->post('gender'),0,1)) == 'I') ? 'L' : 'P';

		$this->load->library('upload', $config);
		if (!($this->upload->do_upload('kelompok'))){
			echo "<script>alert('".strip_tags($this->upload->display_errors())."')</script>";
		}
		else{
			$data = $this->csvreader->parse_text(file_get_contents('./uploads/'.$config['file_name'].'.csv'));
			foreach ($data as $result) 
			{
				// echo "<pre>";
				// print_r($result);
				// die();
				$nokel = ($result['No Kelompok'] < 10) ? '0'.$result['No Kelompok'] : $result['No Kelompok'];
				$kelompok['kelompok_nama'] = strtoupper(substr($this->input->post('gender'),0,1)).'T-'.$nokel;
				if (($this->_mentee->getby(array('mentee_nim'=>$result['NIM Mentee']))->num_rows()==0))
				{
					//mengecek apakah kelompok sudah terbuat atau belum
					if($this->_kelompok->getby(array('kelompok_nama'=>$kelompok['kelompok_nama']))->num_rows()==0)
					{
						$this->_kelompok->insertnew($kelompok);
					}
					//mendapatkan id dari kelompok berdasarkan nama kelompok
					$kelompok_id = $this->_kelompok->getby(array('kelompok_nama'=>$kelompok['kelompok_nama']))->result()[0]->kelompok_id;
					//mengecek apakah nim mentor sudah ada atau belum
					if($this->_mentor->getby(array('mentor_nim'=>$result['NIM Mentor']))->num_rows()==0)
					{
						$mentor = array(
								'mentor_nim'			=>	$result['NIM Mentor'],
								'mentor_nama'			=>	ucwords(strtolower($result['Nama Mentor'])),
								'mentor_telp'			=>	(substr($result['No HP 1'],0,1) != 0) ? '0'.$result['No HP 1'] : $result['No HP 1'],
								'mentor_jenis_kelamin'	=> 	$jenis_kelamin
						);
						$this->_mentor->insertnew($mentor);
						//mengecek apakah username dengan nim mentor sudah terbentuk atau belum
						if($this->_user->getby(array('user_username'=>$result['NIM Mentor']))->num_rows()==0)
						{
							$mentor_user = array (
								'user_username' => $mentor['mentor_nim'],
								'user_password'	=> md5('hamasahmentor'), 
								'user_role'		=> 'mentor'
							);
							$this->_user->insertnew($mentor_user);
						}
					}
					//mengambil id dari mentor berdasarkan nim
					$mentor_id = $this->_mentor->getidbynim($result['NIM Mentor']);
					//mengecek apakah kelompok dan mentor sudah terbentuk atau belum
					if($this->_kelompok_mentor->getBy(array('kelompok_id' => $kelompok_id, 'mentor_id' => $mentor_id))->num_rows() == 0)
					{	
						$kelompok_mentor = array(
							'mentor_id' 	=> $mentor_id,
							'kelompok_id' 	=> $kelompok_id,
							'mentor_status'		=> 'mentor'
						);
						$this->_kelompok_mentor->insertNew($kelompok_mentor);
					}
					

					//mengecek apakah ada data untuk mentor 2
					if($result['NIM Mentor 2'] != '-' && $result['NIM Mentor 2'] != ''){
						//mengecek apakah mentor nim 2 eksis atau tidak
						if(($this->_mentor->getby(array('mentor_nim'=>$result['NIM Mentor 2']))->num_rows()==0)and($result['NIM Mentor 2']!='unknown'))
						{
							$mentor2 = array(
									'mentor_nim'	=> $result['NIM Mentor 2'],
									'mentor_nama'	=> ucwords(strtolower($result['Nama Mentor 2'])),
									'mentor_telp'	=> (substr($result['No Hp 2'],0,1) != 0) ? '0'.$result['No Hp 2'] : $result['No Hp 2'],
									'mentor_jenis_kelamin'	=> $jenis_kelamin
								);
							$this->_mentor->insertnew($mentor2);
							$mentor2_id = $this->_mentor->getidbynim($result['NIM Mentor 2']);
							//mengecek apakah kelompok dan mentor sudah terbentuk
							if($this->_kelompok_mentor->getBy(array('kelompok_id' => $kelompok_id, 'mentor_id' => $mentor2_id))->num_rows() == 0)
							{	
								$kelompok_mentor2 = array(
										'mentor_id' 	=> $mentor2_id,
										'kelompok_id' 	=> $kelompok_id,
										'mentor_status'		=> 'astor'
									);
								$this->_kelompok_mentor->insertNew($kelompok_mentor2);
							}
							//mengecek apakah username dengan nim mentor 2 sudah terbentuk atau belum
							if($this->_user->getby(array('user_username'=>$result['NIM Mentor 2']))->num_rows()==0)
							{
								$astor_user = array(
										'user_username' => $mentor2['mentor_nim'],
										'user_password'	=> md5('hamasahmentor'),
										'user_role'		=> 'mentor'
							 		);
								$this->_user->insertnew($astor_user);
							}
						}
						
					}

					// mengecek apakah mentee sudah ada atau belum di database
					if($this->_mentee->getby(array('mentee_nim'=>$result['NIM Mentee']))->num_rows()==0)
					{
						// Data mentee
						$mentee = array(
								'mentee_nim' 			=> $result['NIM Mentee'],
								'mentee_nama'			=> ucwords(strtolower($result['Nama Mentee'])),
								'mentee_kelas'			=> strtoupper($result['Kelas Mentee']),
								'mentee_telp'			=> (substr($result['Telp Mentee'],0,1) != 0) ? '0'.$result['Telp Mentee'] : $result['Telp Mentee'],
								'mentee_jurusan'		=> $result['Jurusan Mentee'],
								'mentee_jenis_kelamin'	=> $jenis_kelamin,
								'kelompok_id'			=> $kelompok_id
							);
						$this->_mentee->insertnew($mentee);
						//mengecek apakah username dengan nim mentee sudah terbentuk atau belum
						if($this->_user->getby(array('user_username'=>$result['NIM Mentee']))->num_rows()==0)
						{
							$mentee_user = array(
									'user_username' => $mentee['mentee_nim'],
									'user_password'	=> md5('bismillah'),
									'user_role'		=> 'mentee'
						 		);
							$this->_user->insertnew($mentee_user);
						}
					}
				}
			}
			unlink('./uploads/kelompok.csv');
			echo "<script>alert('Berhasil insert kelompok')</script>";
		}
		echo "<script>document.location.href='".base_url('kelompok')."'</script>";
	}

	public function update($id){
		$nim=$this->input->post('id'.$id);
		$data = array('mentee_nama' => ucwords(strtolower($this->input->post('nama'.$id))),
			'mentee_kelas'=>strtoupper($this->input->post('kelas'.$id)),
			'mentee_telp'=>$this->input->post('telp'.$id)
		 );
		if ($this->_mentee->saveUpdate($nim,$data)){
			$query=$this->_mentee->getby(array('mentee_id'=>$nim))->result_array();
			echo json_encode($query[0]);
		}
	}
	public function delete($id){
		$query=$this->_mentee->getby(array('kelompok_id'=>$id))->result();
		foreach ($query as $result) {
			$this->_user->deletetmp(array('user_username'=>$result->mentee_nim));
		}
		$query=$this->_mentor->getby(array('kelompok_id'=>$id))->result();
		foreach ($query as $result) {
			$this->_user->deletetmp(array('user_username'=>$result->mentor_nim));
		}
		$this->_mentee->deletetmp($id);
		$this->_mentor->deletetmp($id);
		$this->_kelompok->deletetmp($id);
		echo "<script>
			alert('Proses delete data berhasil');
			document.location.href='".base_url('kelompok')."'
		</script>";
	}

	public function showEdit($jk = null, $id = null){
		$data = null;
		$select = "mentor_id, mentor_nama";
		if($jk != null){
			if($id != null)
				$data['data'] = $this->_mentor->getMentorExcept($jk, $select, $id);		
			else
				$data['data'] = $this->_mentor->getMentorExcept($jk, $select);
		}else{
			$jenis = $this->input->post('data');
			$data = $this->_mentor->getMentorExcept($jenis[0], $jenis[1]);
		}
		echo json_encode($data);
	}

	public function pindahKelompok(){
		$kelompok_id = $this->input->post('kelompok');
		$mentor_asal = $this->input->post('mentor');
		$mentor_tujuan = $this->input->post('mentor_tujuan');
		$report = $this->_kelompok_mentor->changeKelompok($kelompok_id, $mentor_asal, $mentor_tujuan);
		if($report) {
			$this->session->set_flashdata('status','success');
			$this->session->set_flashdata('messages', 'Alhamdulillah pemindahan mentor berhasil dilakukan');
		}
		else {
			$this->session->set_flashdata('status','failed');
			$this->session->set_flashdata('messages','Maaf, ada kesalahan disaat pemindahan mentor');
		}
		redirect('kelompok/');
	}

	public function change(){
		$id=$this->input->post('id_modal');
		$idkel=$this->uri->segment(3);
		$tujuan=$this->input->post('tujuan');
		if($this->_mentee->saveUpdate($id,array('kelompok_id'=>$tujuan))){
			echo"<script>
				alert('Mentee berhasil pindah kelompok');
				document.location.href='".base_url('kelompok/detail'.'/'.$idkel)."';
			</script>";
		}
	}
	public function deletementee(){
		$id=$this->input->post('data');
		if($this->_mentee->deletetmp($id)){
			echo 'berhasil';
		}else{
			echo "gagal";
		}
	}
}
?>