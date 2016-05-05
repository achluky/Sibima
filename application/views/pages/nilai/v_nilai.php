<?php $tt = ((($kel_id>= 1) && ($kel_id <= 5)) || (($kel_id >= 72) && ($kel_id <= 84))); ?>

<div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
    <div class="page-header pull-left">
        <div class="page-title">Manajemen Nilai</div>
    </div>
    <ol class="breadcrumb page-breadcrumb pull-right">
        <li><i class="fa fa-home"></i>&nbsp;<a href="<?=base_url();?>">Nilai</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
        <li class="hidden"><a href="#">Nilai</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
        <li class="active">Nilai</li>
    </ol>
    <div class="clearfix">
    </div>
</div>
<section class="page-content" id="page-content-nilai">
	<div class="tab-general">
		<div class="row">
			<div class="col-lg-12">
				<div class="portlet box portlet-trans`">
					<div class="portlet-header">
						<div class="row">
							<div class="col-md-6">
						        <table class="table no-border font-black">
						        	<tr>
						        		<td>Nama</td>
						        		<td>:</td>
						        		<td><?=$nama?></td>
						        	</tr>
						        	<tr>
						        		<td>NIM</td>
						        		<td>:</td>
						        		<td><?=$nim?></td>
						        	</tr>
						        </table>
						    </div>
						    <div class="col-md-6">
						        <table class="table no-border font-black">
						        	<tr>
						        		<td>Mentor</td>
						        		<td>:
						        		<td><?=$mentor?></td>
						        	</tr>
						        	<tr>
						        		<td>Kelompok</td>
						        		<td>:</td>
						        		<td><?=$kelompok?></td>
						        	</tr>
						        </table>
							</div>
						</div>
					</div>
					<div class="portlet-body font-black">
						<div class="row">
							<div class="col-lg-6">
								<div class="box box-primary">
									<div class="box-header"><h4>Nilai Mentoring</h4></div>
								    <div class="box-body table-responsive no-padding">
								        <table class="table table-hover font-black">
								        	<thead>
									            <tr>
									                <th>Mentoring Ke</th>
									                <th>Kehadiran</th>
									                <th>Kultum</th>
									            </tr>
								           </thead>
								           <tbody>
									            <?php $a=0; $sum_mentoring = 0; $max_kultum = 0;
									            	foreach ($nilai->result() as $res) { 
									            		if (($tt) && ($res->bam_nama=='Mentoring 6')) { $mentoring_6 = $res->nilai_kehadiran; break; }else{$mentoring_6=0;}
									            		if (substr($res->bam_nama, 0,4)=="Ment") { $a++; ?>
									            <tr>
									            	<td><?=substr($res->bam_nama, 10)?></td>
									            	<td><?php $sum_mentoring += $res->nilai_kehadiran; echo $res->nilai_kehadiran;?></td>
									            	<td><?php  if ($res->nilai_kultum > $max_kultum) $max_kultum = $res->nilai_kultum; echo $res->nilai_kultum;?></td>
									            </tr>
									            <?php }} ?>

									            <?php if($a==0):  ?>
									            	 <td colspan=3 align=center>Belum ada mentoring</td>
									           	<?php endif?>
								           </tbody>
								        </table>
								    </div>
								</div>
								<small><p style="pull-right"><b>Keterangan: </b>
	                        
	                        <br>Nilai Akhir = (Jumlah Nilai Mentoring + MAX(Nilai Kultum) / 7) * 55%) + <br> ((Opening + Closing) / 2) * 35%) + (Shining Team * 10%)
                  		</p>  </small>
							</div>

							<div class="col-lg-6">
								<div class="box box-primary">
									<div class="box-header"><h4>Nilai Acara General</h4></div>
								    <div class="box-body table-responsive no-padding">
								        <table class="table table-hover font-black">
								        	<thead>
									            <tr>
									                <th>Acara General</th>
									                <th>Kehadiran</th>
									            </tr>
								        	</thead>
								        	<tbody>
									            <tr>
									            	<td>Opening MPAI</td>
									            	<td><?=$opening?></td>
									            </tr>
									            <tr>
									            	<td>Closing MPAI</td>
									            	<td><?=$closing?></td>
									            </tr>
									            <tr>
									            	<td>Shining Team</td>
									            	<td><?php echo ($tt) ? ($mentoring_6!=0) ? $mentoring_6 : 'Nilai belum diinputkan' : $st ?>
									            	</td>
									            </tr>
									            <tr>
									            	<td><i><b style="color : red">Nilai Akhir</b></i></td>
									            	<td><b style="color : red"><i><?php 
									            		// nilai_akhir = [((jumlah nilai mentoring + kultum) / 7) * 0.55] + [((opening + closing)/2) * 0.35] + [shining team * 0.1]
									            		
									            		if ($tt) {
									            			$nilai_akhir = (($sum_mentoring) / 5 * 0.55) + 
										            						(($opening + $closing) / 2 * 0.35) + 
										            						($mentoring_6 * 0.1);
									            		} else {
									            			$nilai_akhir = (($sum_mentoring + $max_kultum) / 7 * 0.55) + 
										            						(($opening + $closing) / 2 * 0.35) + 
										            						($st * 0.1);
									            		}
										            		
									            		echo number_format($nilai_akhir, 2);
									            	?></b></i></td>
									            </tr>
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
	</div>
</section>