<?php
class _ba extends ci_model{
		function get_data(){
			return $this->db->query("SELECT kelompok_id,kelompok_nama,mentor_nama FROM kelompok join mentor using (kelompok_id) where mentor_status='primary' and kelompok.is_delete='0'");
		}
		function get_bam($id){
			return $this->db->query("select distinct bam_nama,b.bam_id from bam b, nilai_mentee nm, mentee m, kelompok k where nm.bam_id=b.bam_id and nm.mentee_id=m.mentee_id and m.kelompok_id = k.kelompok_id and k.kelompok_id=".$id." and b.is_delete=0 and k.is_delete=0 and nm.is_delete=0 and m.is_delete=0 and bam_nama like 'Mentoring%' order by bam_nama");
		}
		function get_nilai($id){
			$this->db->select('nilai_mantee_id, mentee_nim, mentee_nama, nilai_kultum, nilai_kehadiran, kelompok_id');
			$this->db->from('nilai_mentee');
			$this->db->join('mentee','mentee.mentee_id=nilai_mentee.mentee_id');
			$this->db->where('nilai_mentee.kelompok_bam_id',$id);
			$this->db->where('nilai_mentee.is_delete',0);
			$this->db->where('mentee.is_delete',0);
			return  $this->db->get();
		}

		function get_data_export($kelompok_id = ''){
			if ($kelompok_id != '')
				$where = " AND m.kelompok_id = $kelompok_id";
			else 
				$where = "";

			return $this->db->query("SELECT
								m.kelompok_id,
								m.mentee_nama, 
								m.mentee_nim,
								m.mentee_kelas,
								bm.bam_id,
								bm.bam_nama,
								nm.*,
								st.st_nilai
							FROM
								nilai_mentee nm,
								mentee m,
								bam bm,
								shining_team st,
								kelompok k
							WHERE
								nm.bam_id IN (SELECT bam_id FROM bam) AND
								nm.bam_id = bm.bam_id AND
							    m.mentee_id = nm.mentee_id AND
							    (st.kelompok_nama = k.kelompok_nama AND k.kelompok_id = m.kelompok_id) AND
							    bm.is_delete = 0 AND
								nm.is_delete = 0". $where ."
							ORDER BY m.mentee_nim, bm.bam_nama ASC")->result();
		}
}