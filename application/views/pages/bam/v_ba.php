<div class="modal fade" id="modal-bam" data-width-modal="300">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" id="form_bam" enctype="multipart/form-data" class="form-vertical" action="<?php echo base_url('ba/addnew')?>">
                <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title">Tambah Berita Acara</h4>
                </div>
                <div class="modal-body">
                    <div class="control-group">
                        <span class="text-group">Nama Agenda</span>
                        <div class="form-group">
							<input type="text" name="nama" id="bamNama">
                            <div class="err-msg"><span></span></div>
                        </div>
                    </div>
                    <div class="control-group">
                    	<span class="text-group">Tipe Agenda</span>
                    	<div class="form-group">
                    		<select name="tipe" class="form-control">
                    			<option value="0">Mentoring</option>
                    			<option value="1">General</option>
                    		</select>
                    	</div>
                    </div>
                    <div class="control-group">
                        <span class="text-group">Tanggal berakhir</span>
                        <div class="form-group">
                            <input type="text" id="mentoringDate" readonly name="tanggal" />
                            <div class="err-msg"><span></span></div>
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
<div class="modal fade" id="modal-edit" data-width-modal="300">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" id="form_edit_bam" enctype="multipart/form-data" class="form-vertical" action="<?php echo base_url('ba/addnew')?>">
                <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title">Tambah Berita Acara</h4>
                </div>
                <div class="modal-body">
                    <div class="control-group">
                        <span class="text-group">Nama Agenda</span>
                        <div class="form-group">
							<input type="text" name="nama" id="bamEditNama">
                            <div class="err-msg"><span></span></div>
                        </div>
                    </div>
                    <div class="control-group">
                    	<span class="text-group">Tipe Agenda</span>
                    	<div class="form-group">
                    		<select name="tipe" class="form-control" id="bamEditTipe">
                    			<option value="0">Mentoring</option>
                    			<option value="1">General</option>
                    		</select>
                    	</div>
                    </div>
                    <div class="control-group">
                        <span class="text-group">Tanggal berakhir</span>
                        <div class="form-group">
                            <input type="text" id="editMentoringDate" readonly name="tanggal" />
                            <div class="err-msg"><span></span></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                  	<?php 
                        $sub = array('class' => 'btn btn-bima btn-primary', 'value' => 'Simpan');
                        // echo "<button type='button' class='btn btn-white btn-bima close' data-dismiss='modal' aria-label='Close'>Cancel</button>";
                        echo form_submit($sub);
                  	?>
                </div>
            </form>
        </div>
    </div>
</div>
<div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
    <div class="page-header pull-left">
        <div class="page-title">Manajemen Berita Acara Mentoring</div>
    </div>
    <ol class="breadcrumb page-breadcrumb pull-right">
        <li><i class="fa fa-home"></i>&nbsp;<a href="<?=base_url();?>">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
        <li class="active">Berita Acara</li>
    </ol>
    <div class="clearfix">
    </div>
</div>
<section class="content">
	<?php if($status = $this->session->flashdata('status')): ?>
		<div class="alert alert-<?= ($status == 'success') ? 'success' : 'danger' ?>" role="alert"><?= $this->session->flashdata('messages'); ?></div>
  	<?php endif; ?>
	<div class="row">
		<div class="col-md-6">
			<div class="portlet box portlet-trans">
				<div class="portlet-header">
						<h4>List Agenda Mentoring</h4>
				</div>
				<div class="portlet-body">
					<div class="box-header">
						<div class="box-title form-group">
				       		<button class="btn btn-primary btn-bima pull-left" data-controls-modal="modal-bam" data-backdrop="static">Add</button>
				        </div>
					</div>
					<div class="box-body table-responsive no-padding">
						<table class="table table-hover">
							<thead>
								<th>#</th>
								<th>Berita Acara</th>
								<th>Berakhir</th>
								<th></th>
							</thead>
							<tbody>
								<?php $i = 1; foreach ($bam as $row) : ?>
									<tr>
										<td><?= $i++ ?></td>
 										<td><?= $row->bam_nama ?></td>
										<td><?= date('d-m-Y', strtotime($row->bam_tanggal_akhir)) ?></td>
										<td>
											<a href="#" onclick="update(this); return false" data-bam="<?=$row->bam_id?>">
							            		<button class="btn btn-bima btn-info" data-controls-modal="modal-edit" data-backdrop="static">Edit</i></button>
							            	</a>
								            <a href="<?=base_url('ba/delete/'.$row->bam_id)?>">
								            	<button class="btn btn-bima btn-danger" onclick="return confirm('Apakah anda yakin ingin menghapus?')">Hapus</button>
								            </a>
										</td>
									</tr>
								<?php endforeach; ?>
								<?php if($i <= 1) : ?>
									<tr>
										<td colspan="4">Berita acara masih kosong</td>
									</tr>
								<?php endif; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="portlet box portlet-trans">
				<div class="portlet-header">
					<h4>List Berita Acara Mentor</h4>
				</div>
				<div class="portlet-body">
					<div class="box-header">
				        <div class="box-title form-group">
				       		<form action="" method="post">
								<select name="gender" class="form-control" onchange="location = this.options[this.selectedIndex].value;">
									<?php echo $option ?>
								</select>
				       		</form>
				        </div>
				        <div class="pull-right">
		                    <button class="btn btn-primary" style="padding:5px 10px" onclick="document.location.href='<?=base_url('ba/preview_nilai')?>'">Export Nilai</i></button>
				        </div>
				    </div>
				    <div class="box-body table-responsive no-padding">
			            <table class="table table-hover" id="data">
				    		<thead>
					            <tr>
					                <th>Kel</th>
					                <th>Mentor</th>
					                <th>Berita Acara</th>
					            </tr>
					        </thead>
					        <tbody>
					        <?php foreach ($query as $res): ?>
					        	<tr>
					            	<td><?=strtoupper($res->kelompok_nama)?></td>
					            	<td style='min-width:200px;'><?=$res->mentor_nama?></td>
					            	<td style='width:180px;'>
						            	<a href="<?=base_url("ba/daftar/".$res->kelompok_id)?>">
						            		<button class="btn btn-primary btn-bima">Detail</i></button>
						            	</a>
							            <a href="<?=base_url("ba/preview_nilai/".$res->kelompok_id)?>">
							            	<button class="btn btn-info btn-bima">Rekap</i></button>
							            </a>
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
</section>
<script type="text/javascript">
	$(document).ready(function(){
		$("#data").DataTable();
	});
	function search(obj){
		console.log($(obj).val())
		var datas="like="+$(obj).val();
		$.ajax({
			url:"<?=base_url('ba/ajax_page').'/'.$this->uri->segment(3)?>",
			data:datas,
			type:"POST",
			success:function(html){
				$(".box-body").html(html);
			}
		});
	}

	update = function(objek){
		console.log("clidk");
		var bam = $(objek).data("bam");
		var datanya="data="+bam;
		console.log('datanya : '+datanya);
		$.ajax({
			url:"<?php echo base_url('ba/getEdit'); ?>",
			data:datanya,
			type:"post",
			success:function(data){
				var result = JSON.parse(data);
				$("#bamEditNama").val(result.bam_nama);
				$("#editMentoringDate").val(result.bam_tanggal_akhir);
				$("#bamEditTipe").val(result.bam_tipe);
				$("#form_edit_bam").attr('action',"<?= base_url('ba/updateAgenda') ?>"+"/"+bam);
			}
		});
	}
</script>