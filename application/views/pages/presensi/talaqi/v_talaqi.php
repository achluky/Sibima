<div class="modal fade" id="modal-talaqi" data-width-modal="300">
	<div class="modal-dialog">
		<div class="modal-content">
			<form action="<?=base_url('talaqi/addagenda')?>" method="post" class="form-vertical">
				<div class="modal-header">
					<button class="close" data-dismiss='modal' aria-label="close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Tambah Agenda</h4>
				</div>
				<div class="modal-body">
					<div class="control-group">
						<span class="text-group">Nama Agenda</span>
						<div class="form-group">
							<?php
								$options = array('first'=>'-Pilih Agenda-',
									'Talaqi Mada 1'=>'Talaqi Mada 1',
									'Talaqi Mada 2'=>'Talaqi Mada 2',
									'Talaqi Mada 3'=>'Talaqi Mada 3'
									);
								echo form_dropdown('nama',$options,'first',"id='jenis'");
							?>
						</div>
					</div>
					<div class="control-group">
						<span class="text-group">Hari / Tanggal</span>
						<div class="form-group">
							<input type="text" id="eventDate" readonly name="tanggal"/>
						</div>
					</div>
					<div class="control-group">
						<span class="text-group">Tempat</span>
						<div class="form-group">
							<?=form_input('tempat');?>
						</div>
					</div>
					<div class="control-group">
						<span class="text-group">Tema</span>
						<div class="form-group">
							<?=form_input('tema');?>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<?php 
						$sub = array('class' => 'btn noborder btn-primary btn-pop', 'value' => 'Simpan');
						$res = array('class' => 'btn btn-white btn-pop', 'value' => 'Reset');
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
        <div class="page-title">Manajemen Presensi Talaqi</div>
    </div>
    <ol class="breadcrumb page-breadcrumb pull-right">
        <li><i class="fa fa-home"></i>&nbsp;<a href="<?=base_url();?>">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
        <li class="active">Presensi Talaqi</li>
    </ol>
    <div class="clearfix">
    </div>
</div>

<section class="content">
	<div class="portlet portlet-trans box">
		<div class="portlet-header">
			<h4>List Agenda Talaqi</h4>
		</div>
		<div class="portlet-body">
			<div class="box-header">
	        	<button class="btn btn-bima btn-big-bima btn-primary left" data-controls-modal="modal-talaqi" data-backdrop="static">Tambah Agenda</button>
		       
		    </div>
		    <div class="box-body table-responsive no-padding">
		        <table class="table table-hover" id="talaqi">
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
			            	foreach ($data->result() as $result) {
			            	$day=date('l',strtotime($result->bat_tanggal));
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
			            	<td><?=$result->bat_nama?></td>
			            	<td><?=$day.', '.date('d-M-Y',strtotime($result->bat_tanggal))?></td>
			            	<td><?=$result->bat_tempat?></td>
			            	<td><?=$result->bat_materi?></td>
			            	<td>
				            	<a href="<?=base_url()?>talaqi/formpresent/<?=$result->bat_id?>">
				            		<button class="btn btn-green btn-bima">Presensi</button>
				            	</a>
			            		<a href="<?=base_url()?>talaqi/detail/<?=$result->bat_id?>">
				            		<button class="btn btn-primary btn-bima">Detail</button>
				            	</a>
				            	<a href="<?=base_url('talaqi/delete')?>/<?=$result->bat_id?>"/>
				            		<button class="btn btn-bima btn-danger" onclick="return confirm('Apakah anda yakin ingin menghapus?')">Hapus</button>
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
<script type="text/javascript">
	$(document).ready(function(){
		$("#talaqi").DataTable();
	})
</script>
