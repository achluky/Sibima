<div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
    <div class="page-header pull-left">
        <div class="page-title">Data Mentor</div>
    </div>
    <ol class="breadcrumb page-breadcrumb pull-right">
        <li><i class="fa fa-home"></i>&nbsp;<a href="<?=base_url();?>">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
        <li class="active">Data Mentor</li>
    </ol>
    <div class="clearfix">
    </div>
</div>
<section class="content">
	<div class="portlet box col-md-12 portlet-trans">
		<div class="portlet-header">
			<h4>List Mentor</h4>
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
		    	<div class="tab-pane">
		            <table class="table table-striped" id="data">
			    		<thead>
							<tr>
								<th>#</th>
								<th>NIM</th>
								<th>Nama</th>
								<!-- <th>FAKULTAS</th> -->
								<th>No HP</th>
							</tr>
						</thead>
						<tbody>
							<?php 
							$i = 1;
							foreach ($mentor as $row) : 
							?>
							<tr>
								<td><?= $i; ?></td>
								<td><?= $row['mentor_nim'] ?></td>
								<td><?= $row['mentor_nama'] ?></td>
								<td><?= $row['mentor_telp'] ?></td>
							</tr>
							<?php $i++; endforeach; ?>
						</tbody>
		       		</table>
		       	</div>
		    </div>
		</div>
	</div>
</section>
<script>
$(document).ready(function(){
	$("#data").DataTable();
});
</script>