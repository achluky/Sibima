<div class="modal fade" id="modal-tugas" data-width-modal="300">
	<div class="modal-dialog">
		<div class="modal-content">
			<form id="form-presensi" action="<?=base_url('presensi/inserttugas')?>" method="post" class="form-vertical">
				<div class="modal-header">
					<button class="close" data-dismiss='modal' aria-label="close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Edit Presensi</h4>
				</div>
				<div class="modal-body">
					<div class="control-group">
						<span class="text-group">NIM</span>
						<div class="form-group">
							<input class="form-control" id="disabledInput" type="text" placeholder="" disabled>
							<?php
								$data = array('name' => 'nim', 'maxlength' => 20, 'class' => 'input-pop','id'=>'nim');
								echo form_input($data);
								echo form_input(array('name'=>'id','type'=>'hidden','value'=>$id));
							?>
							

						</div>
					</div>
					<div class="control-group">
						<span class="text-group">Nilai</span>
						<div class="form-group">
							<?php
								$data = array('name' => 'nilai', 'maxlength' => 20, 'class' => 'input-pop','id'=>'nilai');
								echo form_input($data);
							?>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<?php 
						$sub = array('class' => 'btn btn-bima btn-primary', 'value' => 'Simpan');
						$res = array('class' => 'btn btn-bima btn-green', 'value' => 'Reset');
						echo form_submit($sub);
						echo form_reset($res);
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
        <li><a href="<?= base_url('presensi');?>">Presensi Mentoring</a> &nbsp;<i class="fa fa-angle-right"></i> &nbsp;</li>
        <li class="active">Detail</li>
    </ol>
    <div class="clearfix">
    </div>
</div>
<section class="content">
	<div class="portlet portlet-trans  box">
		<div class="portlet-body">
			<div class="box-header">
		        <div class="box-title">
		        	<button class="btn btn-bima btn-big-bima btn-primary" data-controls-modal="modal-tugas" data-backdrop="static">Tambah Nilai</button>
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
		                <th>Nilai</th>
		                <th>Aksi</th>
		            </tr>
		        </thead>
		        <tbody>
		        <?php $a=0; foreach ($query->result() as $data): $a++;?>
			        <tr>
		            	<td><?=$a?></td>
		            	<td><?=$data->mentee_nim?></td>
		            	<td><?=$data->mentee_nama?></a></td>
		            	<td>
		        		<?php if($data->nilai_status=='Hadir'):?>
		        			<span class='label label-block label-success'>
		        		<?php elseif($data->nilai_status=='Tidak Hadir'):?>
		        			<span class='label label-block label-danger'>
		        		<?php else:?>
		        			<span class='label label-block label-warning'> <?php endif; ?>
		        		<?=$data->nilai_status?></span>
		        		</td>
		        		<td><?=$data->nilai_kehadiran?></td>
		            	<td>
		        		<?php if($data->nilai_status!='Tidak hadir'):?>
			            	<a href='#' class='editpresensi' onclick="update(this);return false" data-idpresensi='<?=$data->nilai_mantee_id?>'><button class='btn btn-bima btn-primary'  
			            	data-controls-modal='modal-tugas' data-backdrop='static'>Edit</button></a>
			            <?php endif; ?>
			            </td>
		            </tr>
		        <?php endforeach; ?>
		        </tbody>
		        </table>
		    </div>
		</div>
	</div>
</section>
<script>
$(document).ready(function(){
	$("#data").DataTable();
});
var available=[];
<?php
  foreach ($mentee as $result) {
?>
available.push("<?=$result['mentee_nim']?>");
<?php
  }
?>
$(function(){
	console.log(available);
    $("#nim").bind("change paste input focus",function(){
      find("#nim");
    });
    $(".ui-autocomplete").bind("click keyup",function(){
      find("#nim");
    });
    $("#nim").autocomplete({
      source:available,
      focus:function(event,ui){
        $( "#nim" ).val( ui.item.label );
        find("#nim");
      }
    });
})
update = function(objek){
	console.log('clicked');
	var id=$(objek).data("idpresensi");
	var datanya="data="+id;
	console.log('datanya : '+datanya);
	$.ajax({
		url:"<?=base_url('presensi/showedit')?>",
		data:datanya,
		type:"post",
		success:function(datas){
			var coba = JSON.parse(datas);
			$("#nim").val(coba['mentee_nim']);
			$("#nilai").val(coba['nilai_kehadiran']);
			$("#form-presensi").attr('action',"<?=base_url('presensi/saveedit')?>"+"/<?=$this->uri->segment(3)?>/"+id);
			console.log($("#form-presensi").attr("action"));
		}
	});
}
function updatenilai(obj){
	$.ajax({
		type:"post",
		url:"<?=base_url('presensi/inserttugas')?>",
		data:$(obj).serialize,
		success:function(html){
			if(html=='success'){
				alert('Nilai berhasil di update');
				new Bima.LightBox({elemet:'#lb-presensi'}).doClose();
			}else{
				alert('Terjadi kesalahan pada saat update nilai');
			}
		}
	});
}

var find=function(e){
    $("#nama").removeClass("has-error");
    $("#nama").removeClass("has-warning");
    $("#nama").removeClass("has-success");
    if($(e).val()!=''){
      $("#msg").html("<img height='30px' src='<?=base_url('asset/images/LTE/ajax-loader.gif') ?>'/>");
      $.ajax({
        url:"<?=base_url('presensi/findnim')?>",
        type:'post',
        data:{nim:+$(e).val(),id:"<?=$id?>"},
        success:function(data){
          console.log(data);
          if(data=='duplicate'){
            $("#nama").addClass("has-error");
            $("#msg").html("<i class='fa fa-times-circle-0'></i>NIM sudah hadir");
          }
          else if(data=='notfound'){
            $("#nama").addClass("has-warning");
            $("#msg").html("<i class='fa fa-warning'></i>NIM tidak ditemukan");
          }else{
            $("#nama").addClass("has-success");
            $("#msg").html("<i class='fa fa-check'></i>"+data);
          }
        }
      });
    }else{
      $("#msg").html("");
    }
}
</script>