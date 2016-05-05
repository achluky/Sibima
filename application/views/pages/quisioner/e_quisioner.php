<div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
    <div class="page-header pull-left">
        <div class="page-title">Manajemen Quisioner</div>
    </div>
    <ol class="breadcrumb page-breadcrumb pull-right">
        <li><i class="fa fa-home"></i>&nbsp;<a href="<?=base_url();?>">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
        <li class="active">Quisioner</li>
    </ol>
    <div class="clearfix">
    </div>
</div>
<section class="content">
	<div class="portlet portlet-trans box col-md-12">
	    <div class="portlet-body">
	    	<form action="<?= base_url() ?>index.php/quisioner/addQuisioner" method="post" enctype="multipart/form-data" class="form-vertical table-form form-empty">
	    		<h4>Quisioner masih kosong, silahkan menambah dengan form dibawah ini</h3>
	  			<div class="control-group">
	  				<div class="row">
	    				<div class="col-md-2">
	    					<h5 class="form-comp">Nama Quisioner</h5>
	    				</div>
	    				<div class="col-md-1">
	    					<h5 class="form-comp text-center">:</h5>
	    				</div>
	    				<div class="col-md-9">
	    					<div class="form-group">
	    						<?= form_input('judul') ?>
	    					</div>
	    				</div>
	  				</div>
	  				<div class="row">
	  					<div class="col-md-2">
	  						<h5 class="form-comp">Link Quisioner</h5>
	  					</div>
	  					<div class="col-md-1">
	  						<h5 class="text-center form-comp">:</h5>
	  					</div>
	  					<div class="col-md-9">
	  						<div class="form-group">
	      						<?= form_input('link') ?>
	      					</div>
	  					</div>
	  				</div>
	  				<div class="row">
	  					<div class="col-md-2">
	  						<h5 class="form-comp">Koresponden</h5>
	  					</div>
	  					<div class="col-md-1">
	  						<h5 class="text-center form-comp">:</h5>
	  					</div>
	  					<div class="col-md-9">
	  						<div class="form-group">
	      						<?php
									$options = array('Mentor' => 'Mentor', 'Mentee' => 'Mentee');
									echo form_dropdown('koresponden',$options,'Mentor');
								?>
	      					</div>
	  					</div>
	  				</div>
	    		</div>
	    		<div class="control-group">
	    			<div class="row">
	    				<div class="col-md-12">
	    					<?php 
	  							$sub = array('class' => 'btn btn-bima btn-big-bima btn-primary right', 'value' => 'Simpan');
	  							$res = array('class' => 'btn btn-bima btn-big-bima btn-white right', 'value' => 'Reset');
	  							echo form_submit($sub);
	  							echo form_reset($res);
	  						?>		
	    				</div>
	    			</div>
	    		</div>
	    	</form>
	    </div>
	</div>
</section>