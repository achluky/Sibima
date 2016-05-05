<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ba extends CI_Controller {

	public $page = 'ba';
	public function __construct()
	{
		parent::__construct();
		$this->load->model('_ba');
		$this->load->model('_kelompok');
		$this->load->model('_bam');
		$this->load->model('_mentor');
		$this->load->model('_nmentee');
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
		echo "<script>document.location.href='".base_url('ba/kelompok/it')."'</script>";
	}

	public function kelompok()
	{
		if($this->session->userdata('role')!='admin')
		{	
			echo "<script>document.location.href='".base_url('notfound')."'</script>";
			return;
		}
		$team = $this->uri->segment(3);
		$data['query'] = $this->_kelompok_mentor->getKelompokMentor($team)->result();
		if( $team == 'at' )
		{
			$data['option']="	
			<option value='".base_url()."ba/kelompok/it' >Ikhwan</option>
			<option value='".base_url()."ba/kelompok/at'  selected='selected'>Akhwat</option>";
		}
		else
		{
			$data['option']="
			<option value='".base_url()."ba/kelompok/it' selected='selected'>Ikhwan</option>
			<option value='".base_url()."ba/kelompok/at'>Akhwat</option>";
		}
		$data['bam'] = $this->_bam->getAll();
		$data['title'] = ucfirst($this->page);
		$this->load->view('default/header',$data);
		$this->load->view('pages/bam/v_'.$this->page,$data);
		$this->load->view('default/footer');
	}

	public function daftar()
	{
		
		$id=$this->uri->segment(3);
		if($this->session->userdata('role')=='mentee')
		{	
			echo "<script>document.location.href='".base_url('notfound')."'</script>";
			return;
		}elseif($this->session->userdata('role')=='mentor'){
			$id=$this->session->userdata('idkel');
		}
		if ($id!=""){
			$data['id']=$id;
			$data['data_mentor']=$this->_mentor->getDataMentorByKelompokId($id)->result();
			$data['bam']=$this->_ba->get_bam($id)->result();
			//$data['nama_mentee']=$this->_bam->;
			//print_r($this->_kelompok->getnamakelompok($id));
			$data['namakel'] = ucfirst($this->_kelompok->getnamakelompok($id));
			$data['kel_id'] = $this->_kelompok->getIdKelompok($data['namakel']);
			$data['title'] = ucfirst($this->page);
			$this->load->view('default/header',$data);
			$this->load->view('pages/bam/d_'.$this->page,$data); //tadinya l_
			$this->load->view('default/footer');
		}else{
			if ($id=='') redirect(base_url('ba'));
		}
	}

	public function detail($kelbam_id = null)
	{
		if(!is_null($kelbam_id))
		{
			$this->load->model('_kelompok_bam');
			// if( $this->session->userdata('role')=='mentee' and $this->_bam->getby(array('bam_id'=>$kelbam_id))->num_rows() < 1)
			// {	
			// 	echo "mentee";
			// 	echo "<script>document.location.href='".base_url('notfound')."'</script>";
			// 	return;
			// }
			if(($this->session->userdata('role')=='mentor') )
			{
				if($this->_kelompok_bam->cekBam($kelbam_id, $this->session->userdata('idkel'), $this->session->userdata('nim')) < 1)
				{
					echo "<script>document.location.href='".base_url('notfound')."'</script>";
					return;
				}
			}
			else
			{
				echo "<script>document.location.href='".base_url('notfound')."'</script>";
				return;
			}
			$bam = $this->_kelompok_bam->getDetailBamData($kelbam_id)->row();
			$data = array(
					'idkel'		=> $this->session->userdata('idkel'),
					'namakel'	=> strtoupper($bam->kelompok_nama),
					'data_bam'	=> $bam
				);
			$data['data_mentor'] = $this->_mentor->getDataMentorByKelompokId($this->session->userdata('idkel'))->result();
			$data['data_mentee'] = $this->_nmentee->getDetailMenteeKelompok($bam->bam_id, $this->session->userdata('idkel'))->result();
			$data['title'] = ucfirst($this->page);
			$this->load->view('default/header',$data);
			$this->load->view('pages/bam/d_'.$this->page,$data);
			$this->load->view('default/footer');
		}
		else
			echo "<script>document.location.href='".base_url('notfound')."'</script>";
		
	}

	public function updateAgenda($id){
		$this->load->model('_bam');
		$data = array(
				'bam_nama'			=> $this->input->post('nama'),
				'bam_tipe'			=> $this->input->post('tipe'),
				'bam_tanggal_akhir'	=> date('Y-m-d', strtotime($this->input->post('tanggal')))
			);
		$result = $this->_bam->updateData($id,$data);
		if($result) {
			$this->session->set_flashdata('status','success');
			$this->session->set_flashdata('messages', 'Alhamdulillah pemindahan mentor berhasil dilakukan');
		}
		else {
			$this->session->set_flashdata('status','failed');
			$this->session->set_flashdata('messages','Maaf, ada kesalahan disaat pemindahan mentor');
		}
		redirect('ba/kelompok/it');
	}

	public function updateDetail(){
		$this->load->model('_kelompok_bam');
		$kelompok_bam_id = $this->input->post('kelbam');
		$bam_id = $this->input->post('berita_acara');
		$dataBam = array(
				'kelompok_bam_tanggal' 	=> date('Y-m-d',strtotime($this->input->post('tanggal'))) ,
				'kelompok_bam_tempat'	=> $this->input->post('tempat'),
				'kelompok_bam_materi'	=> $this->input->post('materi'), 
				'kelompok_bam_kultum'	=> $this->input->post('materi_kultum')
			);
		$saveBam = $this->_kelompok_bam->updateData($kelompok_bam_id,$dataBam); 
		$no=1;

		foreach ($this->input->post('mentee') as $mentee_id) 
		{
			$kul = $this->input->post('kultum');
			$kultum = $kul[$no];
			$hadir = $this->input->post('kehadiran');
			$kehadiran = $hadir[$no];
			$dataNilai = array(
					'nilai_kultum'		=> ($kultum > 100) ? 100 : (($kultum < 0) ? 0 : $kultum),
					'nilai_kehadiran'	=> ($kehadiran > 100) ? 100 : (($kehadiran < 0) ? 0 : $kehadiran),
					'nilai_status'		=> 'Hadir'
				);
			$saveNilai = $this->_nmentee->updateNilai($bam_id, $mentee_id, $dataNilai);
			$no++;
		}
		if($saveBam && $saveNilai)
		{
			$this->session->set_flashdata('status','success');
			$this->session->set_flashdata('messages', 'Alhamdulillah data berhasil disimpan');
		}
		else
		{
			$this->session->set_flashdata('status','failed');
			$this->session->set_flashdata('messages','Maaf, ada kesalahan disaat penyimpanan data');
		}
		redirect('ba/detail/'.$kelompok_bam_id);
	}

	public function getEdit(){
		$id = $this->input->post('data');
		$data = $this->_bam->getBamRawById($id)->result_array();
		echo json_encode($data[0]);
	}

	public function addnew(){
		$data['bam_nama'] = $this->input->post('nama');
		$data['bam_tipe'] = $this->input->post('tipe');
		$data['bam_tanggal_akhir'] = date('Y-m-d',strtotime($this->input->post('tanggal')));
		$action = $this->_bam->insertnew($data);
		if($action)
		{
			$this->session->set_flashdata('status','success');
			$this->session->set_flashdata('messages', 'Alhamdulillah data berhasil disimpan');
		}
		else
		{
			$this->session->set_flashdata('status','failed');
			$this->session->set_flashdata('messages','Maaf, ada kesalahan disaat penyimpanan data');
		}
		$tipe = $this->uri->segment(4);
		redirect('ba/kelompok/'.$tipe);
	}

	public function addDetail(){
		$this->load->model('_kelompok_bam');
		$this->load->model('_nmentee');
		$bam['bam_id'] = $this->input->post('nama');
		$bam['kelompok_id'] = $this->session->userdata('idkel');
		$bam['kelompok_bam_tanggal'] = date('Y-m-d', strtotime($this->input->post('tanggal')));
		$bam['kelompok_bam_tempat'] = $this->input->post('tempat');
		$bam['kelompok_bam_materi'] = $this->input->post('materi');
		$bam['kelompok_bam_kultum'] = $this->input->post('kultum');
		$mentee = $this->_kelompok->getKelompokMentee($bam['kelompok_id'])->result();
		// echo "<pre>";
		// print_r($mentee);
		// die();
		$id = $this->_kelompok_bam->insertNew($bam);
		foreach ($mentee as $m) {
			$this->_nmentee->insertNew(array('bam_id' => $bam['bam_id'], 'mentee_id' => $m->mentee_id));
		}
		echo "<script>alert('Berita Acara berhasil dibuat</script>";
		redirect('ba/detail/'.$id);
	}

	public function delete($id){
		$delete = $this->_bam->deletetmp($id);
		if($delete)
		{
			$this->session->set_flashdata('status','success');
			$this->session->set_flashdata('messages', 'Alhamdulillah data berhasil dihapus');
		}
		else
		{
			$this->session->set_flashdata('status','failed');
			$this->session->set_flashdata('messages','Maaf, ada kesalahan disaat penghapusan data');
		}
		redirect('ba/kelompok/');
	}

	public function preview_nilai($kelompok_id=''){
		$data_nilai = $this->_ba->get_data_export($kelompok_id);
		$list_mentee = array();
		foreach ($data_nilai as $val) {
			$list_mentee[$val->mentee_nim]['mentee_nim'] = $val->mentee_nim;
			$list_mentee[$val->mentee_nim]['mentee_nama'] = $val->mentee_nama;
			$list_mentee[$val->mentee_nim]['mentee_kelas'] = $val->mentee_kelas;
			$list_mentee[$val->mentee_nim]['kelompok_id'] = $val->kelompok_id;
			$list_mentee[$val->mentee_nim]['opening_mpai'] = $val->nilai_kehadiran;
			$list_mentee[$val->mentee_nim]['shining_team'] = $val->st_nilai;

			$list_mentee[$val->mentee_nim]['kelompok_id'] = $val->kelompok_id;

			if (!isset($list_mentee[$val->mentee_nim]['flag'])){
				$list_mentee[$val->mentee_nim]['mentoring_1'] = 0;
				$list_mentee[$val->mentee_nim]['kultum_1'] = 0;

				$list_mentee[$val->mentee_nim]['mentoring_2'] = 0;
				$list_mentee[$val->mentee_nim]['kultum_2'] = 0;
				
				$list_mentee[$val->mentee_nim]['mentoring_3'] = 0;
				$list_mentee[$val->mentee_nim]['kultum_3'] = 0;
				
				$list_mentee[$val->mentee_nim]['mentoring_4'] = 0;
				$list_mentee[$val->mentee_nim]['kultum_4'] = 0;
				
				$list_mentee[$val->mentee_nim]['mentoring_5'] = 0;
				$list_mentee[$val->mentee_nim]['kultum_5'] = 0;
				
				$list_mentee[$val->mentee_nim]['mentoring_6'] = 0;
				$list_mentee[$val->mentee_nim]['kultum_6'] = 0;
				
				$list_mentee[$val->mentee_nim]['closing_mpai'] = 0;
				
				$list_mentee[$val->mentee_nim]['flag'] = false;					
			}
			
			
			if ($val->bam_nama) {
				switch ($val->bam_nama) {
					case 'Opening MPAI':
					$list_mentee[$val->mentee_nim]['opening_mpai'] = $val->nilai_kehadiran;
					break;
					case 'Mentoring 1':
					$list_mentee[$val->mentee_nim]['mentoring_1'] = $val->nilai_kehadiran;
					$list_mentee[$val->mentee_nim]['kultum_1'] = $val->nilai_kultum;
					break;
					case 'Mentoring 2':
					$list_mentee[$val->mentee_nim]['mentoring_2'] = $val->nilai_kehadiran;
					$list_mentee[$val->mentee_nim]['kultum_2'] = $val->nilai_kultum;
					break;
					case 'Mentoring 3':
					$list_mentee[$val->mentee_nim]['mentoring_3'] = $val->nilai_kehadiran;
					$list_mentee[$val->mentee_nim]['kultum_3'] = $val->nilai_kultum;
					break;
					case 'Mentoring 4':
					$list_mentee[$val->mentee_nim]['mentoring_4'] = $val->nilai_kehadiran;
					$list_mentee[$val->mentee_nim]['kultum_4'] = $val->nilai_kultum;
					break;
					case 'Mentoring 5':
					$list_mentee[$val->mentee_nim]['mentoring_5'] = $val->nilai_kehadiran;
					$list_mentee[$val->mentee_nim]['kultum_5'] = $val->nilai_kultum;
					break;
					case 'Mentoring 6':
					$list_mentee[$val->mentee_nim]['mentoring_6'] = $val->nilai_kehadiran;
					$list_mentee[$val->mentee_nim]['kultum_6'] = $val->nilai_kultum;
					break;
					case 'Closing MPAI':
					$list_mentee[$val->mentee_nim]['closing_mpai'] = $val->nilai_kehadiran;
					break;
				}	
			}
		}
		
		// echo json_encode($list_mentee);
		$data['nim_mentee'] = $this->_mentee->getallnim($kelompok_id);
		
		// echo json_encode($data['nim_mentee']);
		$data['mentee'] = $list_mentee;
		$data['title'] = 'Preview Nilai';
		$this->load->view('default/header',$data);
		$this->load->view('pages/nilai/d_preview_nilai',$data);
		$this->load->view('default/footer');
	}



	

}