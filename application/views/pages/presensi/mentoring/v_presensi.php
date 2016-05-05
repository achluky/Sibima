<div class="modal fade" id="modal-agenda" data-width-modal="300">
  	<div class="modal-dialog">
    	<div class="modal-content">
    		<form action="<?=base_url('presensi/addagenda')?>" method="post" class="form-vertical">
	      		<div class="modal-header">
	        		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        		<h4 class="modal-title">Tambah Agenda</h4>
	      		</div>
	      		<div class="modal-body">
	        		<div class="control-group">
						<span class="text-group">Nama Agenda</span>
						<div class="form-group">
							<?php
								$options['first'] = '- Pilih Agenda -';
    							foreach ($bam as $value) {
    								$options[$value->bam_id] = $value->bam_nama;
    							}
								echo form_dropdown('nama',$options,'first',"id='jenis'");
							?>
						</div>
					</div>
					<div class="control-group">
						<span class="text-group">Hari / Tanggal</span>
						<div class="form-group">
							<input type="text" id="eventDate" readonly data-provide="datepicker" name="tanggal"/>
							<div class="err-msg">
								<span></span>
							</div>
						</div>
					</div>
					<div class="control-group">
						<span class="text-group">Tempat</span>
						<div class="form-group">
							<?=form_input('tempat');?>
							<div class="err-msg">
								<span></span>
							</div>
						</div>
					</div>
					<div class="control-group">
						<span class="text-group">Tema</span>
						<div class="form-group">
							<?=form_input('tema');?>
							<div class="err-msg">
								<span></span>
							</div>
						</div>
					</div>
	      		</div>
			    <div class="modal-footer">
			        <?php 
						$sub = array('class' => 'btn btn-bima btn-primary', 'value' => 'Simpan');
						$res = array('class' => 'btn btn-bima btn-white', 'value' => 'Reset');
						echo form_reset($res);
						echo form_submit($sub);
					?>
			    </div>
		    </form>
		</div>
	</div>
</div>
<div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
    <div class="page-header pull-left">
        <div class="page-title">Manajemen Presensi Mentoring</div>
    </div>
    <ol class="breadcrumb page-breadcrumb pull-right">
        <li><i class="fa fa-home"></i>&nbsp;<a href="<?=base_url();?>">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
        <li class="active">Presensi Mentoring</li>
    </ol>
    <div class="clearfix">
    </div>
</div>
<section class="content">
	<div class="box portlet portlet-trans">
		<div class="portlet-header">
			<h4>List Agenda Mentoring</h4>
		</div>
		<div class="portlet-body">
			<div class="box-header">
	        	<button class="btn btn-bima btn-big-bima btn-primary left" data-controls-modal="modal-agenda" data-backdrop="static">Tambah Agenda</button>
		       
			</div>
			<div class="box-body table-responsive no-padding">
		        <table class="table table-hover" id="presensi">
		        	<thead>
			            <tr>
			                <th>#</th>
			                <th>Agenda</th>
			                <th>Tanggal</th>
			                <th>Tempat</th>
			                <th>Materi</th>
			                <th>Aksi</th>
			            </tr>
		        	</thead>
		        	<tbody>
			            <?php
			            	$a=1;
			            	foreach ($data as $result) {
				            	$day=date('l',strtotime($result->bam_tanggal_akhir));
				            	switch ($day) {
				            		case 'Sunday':$day='Ahad'; break;
				            		case 'Monday':$day='Senin'; break;
				            		case 'Tuesday':$day='Selasa'; break;
				            		case 'Wednesday':$day='Rabu'; break;
				            		case 'Thursday':$day='Kamis'; break;
				            		case 'Friday':$day='Jumat'; break;
				            		case 'Saturday':$day='Sabtu'; break;
				            	}
			            ?>
			            <tr>
			            	<td><?=$a?></td>
			            	<td><?=$result->bam_nama?></td>
			            	<td><?=$day.', '.date('d-M-Y',strtotime($result->kelompok_bam_tanggal))?></td>
			            	<td><?=$result->kelompok_bam_tempat?></td>
			            	<td><?=$result->kelompok_bam_materi?></td>
			            	<td style="min-width:320px;">
				            	<a href="<?=base_url()?>presensi/input/<?=$result->bam_id?>">
				            		<button class="btn btn-green btn-bima">Presensi</button>
				            	</a>
				            	<a href="<?=base_url()?>presensi/detail/<?=$result->bam_id?>">
				            		<button class="btn btn-primary btn-bima">Detail</button>
				            	</a>
				            	<a href="<?=base_url('presensi/delete')?>/<?=$result->bam_id?>"/>
				            		<button class="btn btn-danger btn-bima" onclick="return confirm('Apakah anda yakin ingin menghapus?')">Hapus</button>
				            	</a>
				            </td>
			            </tr>
			            <?php
			            	$a++;
			            }
			            ?>
		        	</tbody>
		        </table>
		    </div>
		</div>
	</div>
</section>

<script>
$(document).ready(function(){
	$("#presensi").DataTable();
})
function search(obj){
	console.log($(obj).val())
	var datas="like="+$(obj).val();
	$.ajax({
		url:"<?=base_url('presensi/ajax_page')?>",
		data:datas,
		type:"POST",
		success:function(html){
			$(".box-body").html(html);
		}
	});
}
</script>
