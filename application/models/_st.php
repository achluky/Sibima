<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class _st extends ci_model{
		public function get_kelompok($id){
			$sql = "SELECT * FROM shining_team WHERE kelompok_nama like '$id%' ";
			return $this->db->query($sql)->result();
		}

		public function nilai_mentee($id){
			return $this->db->query("select st_nilai from shining_team st,kelompok k, mentee m where st.kelompok_nama = k.kelompok_nama and m.kelompok_id = k.kelompok_id and m.mentee_nim='$id';")->first_row()->st_nilai;
		}
	}

?>