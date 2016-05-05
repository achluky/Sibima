<?php if($this->session->userdata('role')=='admin'): ?>
	<div class="modal fade" id="modal-materi" data-width-modal="300">
	  	<div class="modal-dialog">
	    	<div class="modal-content">
	    		<form method="post" id="form_materi" enctype="multipart/form-data" class="form-vertical" action="<?php echo base_url('materi/addnew')?>">
		      		<div class="modal-header">
		        		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        		<h4 class="modal-title">Tambah Materi</h4>
		      		</div>
		      		<div class="modal-body">
		        		<div class="control-group">
							<span class="text-group">Nama Materi</span>
							<div class="form-group">
								<?php
									$data = array('name' => 'materi', 'maxlength' => 20, 'class' => 'input-pop', 'id'=>'nama_materi');
									echo form_input($data);
								?>
							</div>
						</div>
						<div class="control-group">
							<span class="text-group">Upload Materi</span>
							<div class="form-group">
								<?=form_upload('file');?>
								<h6>Allowed types : *.pdf | *.ppt | *.pptx</h6>
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
<?php endif; ?>
<div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
    <div class="page-header pull-left">
        <div class="page-title">Manajemen Materi</div>
    </div>
    <ol class="breadcrumb page-breadcrumb pull-right">
        <li><i class="fa fa-home"></i>&nbsp;<a href="<?=base_url();?>">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
        <li class="active">Materi</li>
    </ol>
    <div class="clearfix">
    </div>
</div>
<div class="page-content">
    <div class="tab-general">
    	<?php if($status = $this->session->flashdata('status')): ?>
			<div class="alert alert-<?= ($status == 'success') ? 'success' : 'danger' ?>" role="alert"><?= $this->session->flashdata('messages'); ?></div>
  		<?php endif; ?>
	    <div class="row">
	    	<div class="col-lg-12 col-xs-12">
	    		<div class="portlet box bg-white portlet-trans">
	    			<div class="portlet-header">
	    				<h4>List Materi</h4>
	    			</div>
		    		<div class="portlet-body">
						<?php if($this->session->userdata('role')=='admin'): ?>
			    		<div class="box">
							<div class="box-header">
					        	<button class="btn btn-bima btn-primary left" data-controls-modal="modal-materi" data-backdrop="static">Upload</button>
						    </div>
			    		</div>
				        <?php endif; ?>
			    		<div class="box">
				    		<table class="table table-hover" id="materi">
				    			<thead>
						            <tr>
						                <th>#</th>
						                <th>Judul Materi</th>
					                	<th>Aksi</th>
						            </tr>
				    			</thead>
				    			<tbody>
						            <?php $a=1;
						            foreach ($value->result() as $materi) { ?>
						            <tr>
						            	<td><?=$a?></td>
						            	<td><?=$materi->materi_nama?></td>
						            	<td>
							            	<a href="<?=base_url('./uploads/materi/'.$materi->materi_file)?>" download>
							            		<button class="btn btn-primary btn-bima">Unduh</button>
							            	</a>
							            <?php if($this->session->userdata('role')=='admin'): ?>
						            		<a onclick="update(this); return false" data-idmateri="<?=$materi->materi_id?>">
							            		<button class="btn btn-primary btn-bima" data-controls-modal="modal-materi" data-backdrop="static">Ubah</button>
							            	</a>
							            	<a href="<?=base_url('materi/delete/'.$materi->materi_id)?>">
							            		<button class="btn btn-bima btn-danger" onclick="return confirm('Apakah anda yakin ingin menghapus?')">Hapus</button>
							            	</a>
								        <?php endif; ?>
							            </td>
						            </tr>
						            <?php $a++; }?>
				    			</tbody>
					        </table>
			    		</div>
		    		</div>
	    		</div>
	    	</div>
	    </div>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$("#materi").DataTable();
});
update = function(objek){
	var id=$(objek).data("idmateri");
	var datanya="data="+id;
	$.ajax({
		url:"<?php echo base_url('materi/showedit'); ?>",
		data:datanya,
		type:"post",
		success:function(data){
			var coba = JSON.parse(data);
			$("#nama_materi").val(coba['materi_nama']);
			$("#form_materi").attr('action',"<?=base_url('materi/saveedit')?>"+"/"+id);
			new Bima.LightBox({element : '#lb-materi'});
		}
	});
}
</script>