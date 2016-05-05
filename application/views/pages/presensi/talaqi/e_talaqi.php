<div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
    <div class="page-header pull-left">
        <div class="page-title">Manajemen Presensi Talaqi</div>
    </div>
    <ol class="breadcrumb page-breadcrumb pull-right">
        <li><i class="fa fa-home"></i>&nbsp;<a href="<?= base_url(); ?>">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
        <li class="active">Presensi Talaqi</li>
    </ol>
    <div class="clearfix">
    </div>
</div>
<section class="content">
	<div class="portlet portlet-trans box col-md-12">
	    <div class="portlet-body">
          	<form action="<?=base_url('talaqi/addagenda')?>" method="post" enctype="multipart/form-data" class="form-vertical table-form form-empty">
	    		<h4>Presensi talaqi masih kosong, silahkan menambah dengan form dibawah ini</h3>
	  			<div class="control-group">
	  				<div class="row">
	    				<div class="col-md-2">
	    					<h5 class="form-comp">Nama Agenda</h5>
	    				</div>
	    				<div class="col-md-1">
	    					<h5 class="form-comp text-center">:</h5>
	    				</div>
	    				<div class="col-md-9">
	    					<div class="form-group">
	    						<?php
									$options = array('first'=>'-Pilih Agenda-',
										'Talaqi Mada 1'=>'Talaqi Mada 1',
										'Talaqi Mada 2'=>'Talaqi Mada 2',
										'Talaqi Mada 3'=>'Talaqi Mada 3'
									);
									echo form_dropdown('nama',$options,'first',"id='jenis'");
								?>
	    					</div>
	    				</div>
	  				</div>
	  				<div class="row">
	  					<div class="col-md-2">
	  						<h5 class="form-comp">Hari / Tanggal</h5>
	  					</div>
	  					<div class="col-md-1">
	  						<h5 class="text-center form-comp">:</h5>
	  					</div>
	  					<div class="col-md-9">
	  						<div class="form-group">
	      						<input type="text" id="eventDate" readonly name="tanggal"/>
	      					</div>
	  					</div>
	  				</div>
	  				<div class="row">
	  					<div class="col-md-2">
	  						<h5 class="form-comp">Tempat</h5>
	  					</div>
	  					<div class="col-md-1">
	  						<h5 class="text-center form-comp">:</h5>
	  					</div>
	  					<div class="col-md-9">
	  						<div class="form-group">
	      						<?=form_input('tempat');?>
	      					</div>
	  					</div>
	  				</div>
	  				<div class="row">
	  					<div class="col-md-2">
	  						<h5 class="form-comp">Tema</h5>
	  					</div>
	  					<div class="col-md-1">
	  						<h5 class="text-center form-comp">:</h5>
	  					</div>
	  					<div class="col-md-9">
	  						<div class="form-group">
	      						<?=form_input('tema');?>
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
	</div>
</section>