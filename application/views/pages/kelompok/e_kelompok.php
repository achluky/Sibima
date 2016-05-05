<div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
    <div class="page-header pull-left">
        <div class="page-title">Manajemen Materi</div>
    </div>
    <ol class="breadcrumb page-breadcrumb pull-right">
        <li><i class="fa fa-home"></i>&nbsp;<a href="<?= base_url(); ?>">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
        <li class="active">Kelompok</li>
    </ol>
    <div class="clearfix">
    </div>
</div>
<section class="content">
    <div class="portlet box col-md-8">
    	<div class="portlet-body">
          	<form action="<?=base_url('kelompok/addnew')?>" method="post" enctype="multipart/form-data" class="form-vertical table-form form-empty">
          		<h4>Kelompok masih kosong, silahkan upload dengan form dibawah ini</h4>
          		<div class="control-group">
	          		<div class="row">
	          			<div class="col-md-3">
	          				<h5 class="form-comp">Ikhwan</h5>
	          			</div>
	          			<div class="col-md-1">
	          				<h5 class="form-comp">:</h5>
	          			</div>
	          			<div class="col-md-8">
		          			<div class="form-group">
		          				<?= form_upload('kelompok') ?>
		          			</div>
	          			</div>
	          		</div>
          			<div class="row">
          				<div class="col-md-3">
          					<h5 class="form-comp">Jenis Kelamin</h5>
          				</div>
          				<div class="col-md-1">
          					<h5 class="form-comp">:</h5>
          				</div>
          				<div class="col-md-8">
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
          		</div>
          		<div class="control-group">
          			<div class="row">
          				<div class="col-md-12 text-right">
		          			<?php 
      								$sub = array('class' => 'btn btn-bima btn-primary', 'value' => 'Simpan');
      								$res = array('class' => 'btn btn-white', 'value' => 'Reset');
      								echo form_reset($res);
      								echo form_submit($sub);
      							?>
          				</div>
          			</div>
          		</div>
          	</form>
    	</div>
	</div>
</section>