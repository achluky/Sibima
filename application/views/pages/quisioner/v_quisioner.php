<?php if($this->session->userdata('role')=='admin'): ?>
<div class="modal fade" id="modal-quisioner" data-width-modal="300">
	<div class="modal-dialog">
		<div class="modal-content">
			<form id="form_kuisioner" action="<?= base_url('quisioner/addQuisioner') ?>" method="post" enctype="multipart/form-data" class="form-vertical">
				<div class="modal-header">
					<button class="close" data-dismiss='modal' aria-label="close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Tambah Quisioner</h4>
				</div>
				<div class="modal-body">
					<div class="control-group">
						<span class="text-group">Judul Quisioner</span>
						<div class="form-group">
							<?php
								$data = array('name' => 'judul', 'maxlength' => 20, 'class' => 'input-pop','id'=>'judul');
								echo form_input($data);
							?>
						</div>
					</div>
					<div class="control-group">
						<span class="text-group">Link Quisioner</span>
						<div class="form-group">
							<?php
								$data = array('name' => 'link', 'maxlength' => 20, 'class' => 'input-pop','id'=>'link');
								echo form_input($data);
							?>
						</div>
					</div>
					<div class="control-group">
						<span class="text-group">Koresponden</span>
						<div class="form-group">
							<?php
								$options = array('Mentor' => 'Mentor', 'Mentee' => 'Mentee');
								echo form_dropdown('koresponden',$options,'Mentor',"id='koresponden'");
							?>
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
<?php endif; ?>
<div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
    <div class="page-header pull-left">
        <div class="page-title">Manajemen Quisioner</div>
    </div>
    <ol class="breadcrumb page-breadcrumb pull-right">
        <li><i class="fa fa-home"></i>&nbsp;<a href="<?=base_url();?>">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
        <li class="active">Berita Acara</li>
    </ol>
    <div class="clearfix">
    </div>
</div>
<section class="content">
	<div class="portlet portlet-trans box col-md-12">
		<div class="portlet-header">
			<h4>List Quisioner</h4>
		</div>
		<div class="portlet-body">
			<div class="box-header">
			<?php if($this->session->userdata('role')=='admin'): ?>
	        	<button class="btn btn-bima btn-primary left" data-controls-modal="modal-quisioner" data-backdrop="static">Tambah</button>
	       	<?php endif; ?>
		    </div>
		    <div class="box-body table-responsive no-padding">
		        <table class="table table-hover" id="data">
		        	<thead>
			            <tr>
			                <th>No.</th>
			                <th>Judul</th>
			                <th>Koresponden</th>
						<?php if($this->session->userdata('role')=='admin'): ?>
			                <th>Aksi</th>
			            <?php endif; ?>
			            </tr>
		        	</thead>
		        	<tbody>
			        	<?php
						$no=0; 
						foreach($data_quisioner->result() as $data) : 
								if(($this->session->userdata('role')=='admin')or($this->session->userdata('role')==$data->kuisioner_responden)):
								$no++;
								?>
				            <tr>
				            	<td><?=$no?></td>
				            	<td><?=$data->kuisioner_nama?></td>
				            	<td><?=$data->kuisioner_responden?></td>
				            	<td>
					            	<a href='<?=$data->kuisioner_url?>'>
					            		<button class="btn btn-success btn-bima">Isi</button>
					            	</a>
				            	<?php if($this->session->userdata('role')=='admin'): ?>
					            	<a href='#' class='editkuisioner' onclick="update(this); return false" data-idkuisioner="<?=$data->kuisioner_id?>">
					            		<button class="btn btn-primary btn-bima" data-controls-modal="modal-quisioner" data-backdrop="static">Ubah</button>
					            	</a>
					            	<a href="<?=base_url()."quisioner/deletequisioner/".$data->kuisioner_id?> ">
					            		<button class="btn btn-danger btn-bima" onclick="return confirm('Apakah anda yakin ingin menghapus?')">Hapus</button>
					            	</a>
					            <?php endif; ?>
					            </td>
				            </tr>
			            <?php
			            endif;
			            endforeach; ?>
		        	</tbody>
		        </table>
		    </div>
		</div>
	</div>
</section>
<script>
$(document).ready(function(){
	$("#data").DataTable();
})
update = function(objek){
	console.log('clicked');
	var id=$(objek).data("idkuisioner");
	var datanya="data="+id;
	console.log('datanya : '+datanya);
	$.ajax({
		url:"<?=base_url('quisioner/showedit')?>",
		data:datanya,
		type:"post",
		success:function(datas){
			var coba = JSON.parse(datas);
			$("#judul").val(coba['kuisioner_nama']);
			$("#link").val(coba['kuisioner_url']);
			$("#koresponden").val(coba['kuisioner_responden']);
			$("#form_kuisioner").attr('action',"<?=base_url('quisioner/saveedit')?>"+"/"+id);
			console.log($("#form_kuisioner").attr("action"));
			new Bima.LightBox({element : '#lb-quisioner'});
		}
	});
}
</script>