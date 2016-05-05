<div class="modal fade" id="modal-mentor">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <form role="form" action="<?= base_url('kelompok/pindahKelompok')?>" method="post">
	            <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal">&times;</button>
	                <h4 class="modal-title">Pindah Mentor</h4>
	            </div>
	            <div class="modal-body">
	                    <div class="form-group">
	                    	<div class="control-group">
	                    		<input type="hidden" name="kelompok" id="kelompok">
	                    		<span class="text-group"><h5>Kelompok : <strong id="kelompok_mentor"></strong></h5></span>
	                    	</div>
	                        <div class="control-group">
	                        	<input type="hidden" name="mentor" id="mentor">
	                            <span class="text-group"><h5>Mentor Asal : <strong id="mentor_asal"></strong></h5></span>
	                        </div>
	                        <div class="control-group">
	                            <span class="form"><h5>Mentor Tujuan</h5></span>
	                            <div class="form-group">
	                            	<select name="mentor_tujuan" class="form-control" id="mentor_tujuan"></select>
	                            	<div class="err-msg"><span></span></div>
	                            </div>
	                        </div>
	                    </div>
	            </div>
	            <div class="modal-footer">
	            	<?php
	            		$sub = array('class' => 'btn btn-bima btn-primary btn-pop', 'value' => 'Submit');
	            		echo form_submit($sub);
	            	?>
	            </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-upkelompok">
  	<div class="modal-dialog modal-sm">
    	<div class="modal-content">
    		<form action="<?=base_url('kelompok/addnew')?>" method="post" enctype="multipart/form-data" class="form-vertical">
	      		<div class="modal-header">
	        		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        		<h4 class="modal-title">Form Tambah Kelompok</h4>
	      		</div>
	      		<div class="modal-body">
	        		<div class="control-group">
						<span class="text-group">File Kelompok</span>
						<div class="form-group">
							<?=form_upload('kelompok');?>
						</div>
					</div>
					<div class="control-group">
						<div class="form-group">
							<?php
								$ikhwan = array('name' => 'gender', 'value' => 'ikhwan', 'checked' => TRUE);
								$akhwat = array('name' => 'gender', 'value' => 'akhwat');
								echo form_radio($ikhwan); echo " Ikhwan ";
								echo form_radio($akhwat); echo " Akhwat";
							?>
						</div>
					</div>
	      		</div>
			    <div class="modal-footer">
			        <?php 
						$sub = array('class' => 'btn btn-bima btn-primary btn-pop', 'value' => 'Simpan');
						$res = array('class' => 'btn btn-bima btn-white btn-pop', 'value' => 'Reset');
						echo form_reset($res);
						echo form_submit($sub);
					?>
			    </div>
		    </form>
		</div>
	</div>
</div>
<div class="page-title-breadcrumb" id="page-title-kelompok">
    <div class="page-header pull-left">
        <div class="page-title">Manajemen Kelompok</div>
    </div>
    <ol class="breadcrumb page-breadcrumb pull-right">
        <li><i class="fa fa-home"></i>&nbsp;<a href="<?=base_url();?>">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
        <li class="active">Kelompok</li>
    </ol>
    <div class="clearfix"></div>
</div>
<section class="page-content" id="page-content-kelompok">
	<div class="tab-general">
  		<?php if($status = $this->session->flashdata('status')) : ?>
  			<div class="alert alert-<?= ($status == 'success') ? 'success' : 'danger' ?>" role="alert"><?= $this->session->flashdata('messages'); ?></div>
  		<?php endif; ?>
		<div class="row">
			<div class="col-lg-12">
				<div class="box-header">
			        <div class="box-title">
			        	<button class="btn btn-bima btn-primary" data-controls-modal="modal-upkelompok" data-backdrop="static">Upload</button>
			        </div>
			    </div>
				<div class="row">
					<div class="col-lg-6">
						<div class="portlet box bg-white portlet-trans">
			    			<div class="portlet-header">
			    				<h4 class="">List Ikhwan</h4>
			    			</div>
				    		<div class="portlet-body">
				    			<div class="tab-pane">
		                            <table class="table table-hover display" id="tab_1">
										<thead>
								            <tr>
								                <th>Kel.</th>
								                <th>Mentor</th>
								                <th>Aksi</th>
								            </tr>
							            </thead>
							            <tbody>
							            <?php foreach ($dataIkhwan as $res): ?>
											<tr>
								            	<td><?= $res->kelompok_nama ?></td>
								            	<td><p class="ellipsis"><?= $res->mentor_nama ?></p></td>
								            	<td class="act-col">
									            	<a href='<?=base_url('kelompok/detail/'.$res->kelompok_id)?>'><button class='btn btn-bima btn-primary'>Detail</button></a>
									            	<!-- <a href='<?=base_url('kelompok/delete/'.$res->kelompok_id)?>'><button class='btn btn-bima btn-danger' onclick="return confirm('Apakah anda yakin ingin menghapus?');">Hapus</button></a> -->
									            	<a onclick="showPindah(this); return false" data-kelompok="<?= $res->kelompok_id ?>,<?= $res->kelompok_nama?>,<?= $res->mentor_id ?>,<?= $res->mentor_nama ?>"><button type="button" class="btn btn-info btn-bima btn-info" data-toggle="modal" data-controls-modal="modal-mentor">Pindah</button></a>
									            </td>
								            </tr>
								        <?php endforeach; ?>
								       	</tbody>
								    </table>
		                        </div>
				    		</div>
			    		</div>
					</div>
					<div class="col-lg-6">
						<div class="portlet box bg-white portlet-trans">
			    			<div class="portlet-header">
			    				<h4 class="">List Akhwat</h4>
			    			</div>
				    		<div class="portlet-body">
				    			<div class="tab-pane">
		                            <table class="table table-hover display" id="tab_2">
										<thead>
								            <tr>
								                <th>Kel.</th>
								                <th>Mentor</th>
								                <th>Aksi</th>
								            </tr>
							            </thead>
							            <tbody>
							            <?php foreach ($dataAkhwat as $res):?>
											<tr>
								            	<td><?= $res->kelompok_nama ?></td>
								            	<td><?= $res->mentor_nama ?></td>
								            	<td style='width:150px;'>
									            	<a href='<?=base_url('kelompok/detail/'.$res->kelompok_id)?>'><button class='btn btn-bima btn-primary'>Detail</button></a>
									            	<!-- <a href='<?=base_url('kelompok/delete/'.$res->kelompok_id)?>'><button class='btn btn-bima btn-danger' onclick="return confirm('Apakah anda yakin ingin menghapus?');">Hapus</button></a> -->
									            	<a onclick="showPindah(this); return false" data-kelompok="<?= $res->kelompok_id ?>,<?= $res->kelompok_nama?>,<?= $res->mentor_id ?>,<?= $res->mentor_nama ?>"><button type="button" class="btn btn-info btn-bima btn-info" data-toggle="modal" data-controls-modal="modal-mentor">Pindah</button></a>
									            </td>
								            </tr>
								        <?php endforeach; ?>
								       	</tbody>
								    </table>
								</div>
				    		</div>
			    		</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<script type="text/javascript">
	$(document).ready(function(){
		$("#tab_1").DataTable();
		$("#tab_2").DataTable();
	})
	showPindah = function(objek){
		var temp = $(objek).data('kelompok');
		var kelompok = temp.split(',');
		var tag = (kelompok[1].substring(0,2) == "IT") ? "L" : "P";
		var datanya = new Array(tag, kelompok[2]);
		// console.log("datanya : "+datanya);
		console.log(datanya);
		$.ajax({
			url:"<?php echo base_url('kelompok/showEdit'); ?>",
			data:"data="+datanya,
			type:"post",
			success:function(data){
				var coba = JSON.parse(data);
				// console.log(coba);
				$.each(coba, function( index, value ) {
					$('#mentor_tujuan').append("<option value='"+value['mentor_id']+"'>"+value['mentor_nama']+"</option>")
				});
			}
		});
		$('#kelompok').val(kelompok[0]);
		$('#kelompok_mentor').html(kelompok[1]);
		$('#mentor').val(kelompok[2]);
		$('#mentor_asal').html(kelompok[3]);
	}
</script>