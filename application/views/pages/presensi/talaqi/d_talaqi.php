<div class="page-title-breadcrumb" id="page-title-kelompok">
      <div class="page-header pull-left">
            <div class="page-title">Manajemen Presensi Talaqi</div>
      </div>
      <ol class="breadcrumb page-breadcrumb pull-right">
            <li><i class="fa fa-home"></i>&nbsp;<a href="<?=base_url();?>">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li><a href="<?= base_url('presensi');?>">Presensi Talaqi</a>&nbsp;<i class="fa fa-angle-right"></i> &nbsp;</li>
            <li class="active">Detail</li>
      </ol>
      <div class="clearfix"></div>
</div>
<section class="content">
	<div class="portlet portlet-trans box col-md-12">
		<div class="portlet-body">
			<div class="box-header">
		        <div class="box-tools">
		            <div class="input-group">
		                <input type="text" name="table_search" class="form-control input-sm pull-right" style="width: 150px;" placeholder="Search" onkeyup="search(this);" />
		                <div class="input-group-btn">
		                    <button class="btn btn-sm btn-default"><i class="fa fa-search"></i></button>
		                </div>
		            </div>
		        </div>
		    </div>
		    <div class="box-body table-responsive no-padding">
		    	<table class="table table-hover" id="data">
		            <thead>
		            <tr>
		                <th>#</th>
		                <th>Nim</th>
		                <th>Nama</th>
		                <th>Status</th>
		                <th>Aksi</th>
		            </tr>
		            </thead>
		            <tbody>
		            <?php $a=0;
		            foreach ($query->result() as $data): $a++; ?>
			            <tr>
			            	<td><?=$a?></td>
			            	<td><?=$data->mentor_nim?></td>
			            	<td><?=$data->mentor_nama?></a></td>
			            	<td>
			        		<?php if($data->nilai_mentor_status=='Hadir'): ?>
			        			<span class='label label-block label-success'>
			        		<?php elseif($data->nilai_mentor_status=='Tidak Hadir'): ?>
			        			<span class='label label-block label-danger'>
			        		<?php else:?>
			        			<span class='label label-block label-warning'>
			        		<?php endif; ?>
			        		<?=$data->nilai_mentor_status?>
			        			</span>
			        		</td>
			            	<td>
				            	<a href='#' class='editpresensi' onclick='update(this); return false' data-idpresensi='<?=$data->nilai_mentor_id?>'>
				            	<button class='btn btn-primary btn-bima'>Edit</button></a>
				            </td>
			            </tr>
			        <?php endforeach; ?>
		            </tbody>
		    </div>
		</div>
	</div>
</section>
<script>
$(document).ready(function(){
	$("#data").DataTable();
});
function search(obj){
	var datas="like="+$(obj).val();
	$.ajax({
		url:"<?=base_url('talaqi/ajax_page').'/'.$id?>",
		data:datas,
		type:"POST",
		success:function(html){
			$("#data").html(html);
		}
	});
}
function update(obj){
	var data="id="+$(obj).data('idpresensi');
	$.ajax({
		url:"<?=base_url('talaqi/change').'/'.$this->uri->segment(3)?>",
		data:data,
		type:"post",
		success:function(html){
			$("#data").html(html);
		},
		error:function(e){
			console.log(e);
		}
	})
}
</script>