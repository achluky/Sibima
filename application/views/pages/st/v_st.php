<div class="modal fade" id="modal-st" data-width-modal="300">
  	<div class="modal-dialog">
    	<div class="modal-content">
    		<form action="<?=base_url("st/update_nilai")?>" method="post" class="form-vertical">
	      		<div class="modal-header">
	        		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        		<h4 class="modal-title">Ubah Nilai</h4>
	      		</div>
	      		<div class="modal-body">
					<div class="control-group">
						<span class="text-group">Judul</span>
						<div class="form-group">
							
							<input type="text" name="judul" id="st-judul"/>
							<input type="hidden" name="kelompok_nama" id="st-kel"/>
							<div class="err-msg">
								<span></span>
							</div>
						</div>
					</div>
					<div class="control-group">
						<span class="text-group">Nilai</span>
						<div class="form-group">
							<input type="text" name="nilai" id="st-nilai"/>
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
        <div class="page-title">Nilai Shining Team</div>
    </div>
    <ol class="breadcrumb page-breadcrumb pull-right">
        <li><i class="fa fa-home"></i>&nbsp;<a href="<?=base_url();?>">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
        <li class="active">Shining Team</li>
    </ol>
    <div class="clearfix">
    </div>
</div>
<section class="content">

	<div class="portlet box col-md-12 portlet-trans">
		<div class="portlet-header">
			<h4>Daftar Nilai Shining Team</h4>
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
		    </div>
		    <div class="box-body table-responsive no-padding">
		            <table class="table table-hover" id="data">
			    		<thead>
				            <tr>
				          
				                <th>Kelompok</th>
				                <th>Mentor</th>
				                <th>Judul</th>
				                <th>Nilai</th>
				                <th>Aksi</th>
				            </tr>
				        </thead>
				        <tbody>
				        	<?php $i = 1; foreach ($query as $st) : ?>
						        <tr> 
						        	<td><?=$st->kelompok_nama?></td>
						        	<td><?=$st->mentor_nama?></td>
						        	<td><?=$st->st_judul?></td>
						        	<td><?=$st->st_nilai?></td>
						        	<td><button 
						        		class="btn btn-bima btn-bima btn-primary left btn-st" 
						        		data-nilai="<?=$st->st_nilai?>" 
						        		data-judul="<?=$st->st_judul?>" 
						        		data-kel="<?=$st->kelompok_nama?>"
						        		data-controls-modal="modal-st" data-backdrop="static">Edit</button></td>
						        </tr>
						    <?php endforeach ?>
				        </tbody>
		       		</table>
		    </div>
		</div>
	</div>
</section>
<script>
$(document).ready(function(){
	$("#data").DataTable({"bLengthChange": false});

	
});

$(".btn-st").click(function(e){
	$("#st-nilai").val($(this).data("nilai"))
	$("#st-judul").val($(this).data("judul"))
	$("#st-kel").val($(this).data("kel"))
})

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
</script>
