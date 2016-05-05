<div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
    <div class="page-header pull-left">
        <div class="page-title">Manajemen Materi</div>
    </div>
    <ol class="breadcrumb page-breadcrumb pull-right">
        <li><i class="fa fa-home"></i>&nbsp;<a href="<?= base_url(); ?>">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
        <li class="active">Materi</li>
    </ol>
    <div class="clearfix">
    </div>
</div>
<div class="page-content" id="materi-content">
  <div class="portlet box col-md-12 portlet-trans">
    <div class="portlet-body">
    	<form action="<?=base_url('materi/addnew')?>" method="post" enctype="multipart/form-data" class="form-vertical table-form form-empty">
    		<h4>Data Materi masih kosong, silahkan upload dengan form dibawah ini</h3>
  			<div class="control-group">
  				<div class="row">
    				<div class="col-md-2">
    					<h5 class="form-comp">Nama Materi</h5>
    				</div>
    				<div class="col-md-1">
    					<h5 class="form-comp text-center">:</h5>
    				</div>
    				<div class="col-md-9">
    					<div class="form-group">
    						<?= form_input('materi') ?>
    					</div>
    				</div>
  				</div>
  				<div class="row">
  					<div class="col-md-2">
  						<h5 class="form-comp">File Materi</h5>
  					</div>
  					<div class="col-md-1">
  						<h5 class="text-center form-comp">:</h5>
  					</div>
  					<div class="col-md-9">
  						<div class="form-group">
      						<?= form_upload('file') ?>
              <h6>Allowed types : *.pdf | *.ppt | *.pptx</h6>
      					</div>
  					</div>
  				</div>
    		</div>
    		<div class="control-group">
    			<div class="row">
    				<div class="col-md-12">
    					<?php 
  							$sub = array('name' => 'upload', 'class' => 'btn btn-bima btn-big-bima btn-primary right', 'value' => 'Simpan');
  							$res = array('class' => 'btn btn-white btn-bima btn-big-bima right', 'value' => 'Reset');
  							echo form_submit($sub);
  							echo form_reset($res);
  						?>		
    				</div>
    			</div>
    		</div>
    	</form>
    </div>
  </div>
</div>