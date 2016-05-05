<div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
  <div class="page-header pull-left">
    <div class="page-title">Preview Nilai</div>
</div>
<ol class="breadcrumb page-breadcrumb pull-right">
    <li><i class="fa fa-home"></i>&nbsp;<a href="<?= base_url(); ?>">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
    <?php if($this->session->userdata('role')=='admin'): ?><li><a href="<?= base_url('kelompok'); ?>">List</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li><?php endif; ?>
    <li class="active">Nilai</li>
</ol>
<div class="clearfix">
</div>
</div>
<section class="content">
      <div class="portlet box">
            <div class="portlet-header">     
                  <button id="save" class="btn btn-success btn-block pull-right">Download</button>  
                  <!-- <h3>Kelompok <?=ucfirst($namakel)?></h3> -->
            </div>
            <div class="portlet-body">
                  <div class="box-body table-responsive">
                        <table id="nilai" class="table table-hover form-seeable">
                              <thead>
                                    <tr>
                                          <th>No</th>
                                          <th>NIM</th>
                                          <th>Nama</th>
                                          <th>Kelas</th>
                                          <th>M1</th>
                                          <th>K1</th>
                                          <th>M2</th>
                                          <th>K2</th>
                                          <th>M3</th>
                                          <th>K3</th>
                                          <th>M4</th>
                                          <th>K4</th>
                                          <th>M5</th>
                                          <th>K5</th>
                                          <th>M6</th>
                                          <th>K6</th>
                                          <th>Opening</th>
                                          <th>Closing</th>
                                          <th>ST</th>
                                          <th><b style="color:#D9534F"<i>NA</b></i></th>
                                    </tr>
                              </thead>
                              <tbody>
                                   
                                    <?php $i=1; foreach ($nim_mentee as $val) { 
                                          $kel_id = $mentee[$val->mentee_nim]['kelompok_id']; 
                                          $tt = ((($kel_id >= 1) && ($kel_id <= 5)) || (($kel_id >= 72) && ($kel_id <= 84))) ?>
                                          <tr>
                                          <td><?=$i++?></td>
                                          <td><?=$val->mentee_nim?></td>
                                          <td><?=$mentee[$val->mentee_nim]['mentee_nama']?></td>
                                          <td><?=$mentee[$val->mentee_nim]['mentee_kelas']?></td>
                                          <td><?=$mentee[$val->mentee_nim]['mentoring_1']?></td>
                                          <td><?=$mentee[$val->mentee_nim]['kultum_1']?></td>
                                          <td><?=$mentee[$val->mentee_nim]['mentoring_2']?></td>
                                          <td><?=$mentee[$val->mentee_nim]['kultum_2']?></td>
                                          <td><?=$mentee[$val->mentee_nim]['mentoring_3']?></td>
                                          <td><?=$mentee[$val->mentee_nim]['kultum_3']?></td>
                                          <td><?=$mentee[$val->mentee_nim]['mentoring_4']?></td>
                                          <td><?=$mentee[$val->mentee_nim]['kultum_4']?></td>
                                          <td><?=$mentee[$val->mentee_nim]['mentoring_5']?></td>
                                          <td><?=$mentee[$val->mentee_nim]['kultum_5']?></td>
                                          <?php if (!$tt) : ?>
                                                <td><?=$mentee[$val->mentee_nim]['mentoring_6']?></td>
                                                <td><?=$mentee[$val->mentee_nim]['kultum_6']?></td>
                                          <?php else: ?>
                                                <td>-</td>
                                                <td>-</td>
                                          <?php endif ?>
                                          
                                          <td><?=$mentee[$val->mentee_nim]['opening_mpai']?></td>
                                          <td><?=$mentee[$val->mentee_nim]['closing_mpai']?></td>
                                          <td>
                                                <?php echo $tt ? $mentee[$val->mentee_nim]['mentoring_6'] : $mentee[$val->mentee_nim]['shining_team']; ?>
                                          </td>



                                          <td><b style="color:#D9534F"><i><?php
                                                $sum_mentoring =  ($mentee[$val->mentee_nim]['mentoring_1']+
                                                                  $mentee[$val->mentee_nim]['mentoring_2']+
                                                                  $mentee[$val->mentee_nim]['mentoring_3']+
                                                                  $mentee[$val->mentee_nim]['mentoring_4']+
                                                                  $mentee[$val->mentee_nim]['mentoring_5']+
                                                                  $mentee[$val->mentee_nim]['mentoring_6']); 

                                                $max_kultum = max($mentee[$val->mentee_nim]['kultum_1'],
                                                                  $mentee[$val->mentee_nim]['kultum_2'],
                                                                  $mentee[$val->mentee_nim]['kultum_3'],
                                                                  $mentee[$val->mentee_nim]['kultum_4'],
                                                                  $mentee[$val->mentee_nim]['kultum_5'],
                                                                  $mentee[$val->mentee_nim]['kultum_6']);
                                                
                                                if ($tt) {
                                                      $nilai_akhir =    ((($sum_mentoring - $mentee[$val->mentee_nim]['mentoring_6']) / 5) * 0.55) + 
                                                                        ((($mentee[$val->mentee_nim]['closing_mpai'] + $mentee[$val->mentee_nim]['opening_mpai']) / 2) * 0.35) +
                                                                        ($mentee[$val->mentee_nim]['mentoring_6'] * 0.1);
                                                } else {
                                                      $nilai_akhir =    ((($sum_mentoring + $max_kultum)/ 7) * 0.55) + 
                                                                        ((($mentee[$val->mentee_nim]['closing_mpai'] + $mentee[$val->mentee_nim]['opening_mpai']) / 2) * 0.35) +
                                                                        ($mentee[$val->mentee_nim]['shining_team'] * 0.1);      
                                                }
                                                
                                                echo number_format($nilai_akhir,2);
                                          ?></b></i></td>
                                    </tr>
                                    <?php } ?>
                        </tbody>
                  </table>
                  <small><p style="pull-right"><b>Keterangan: </b>
                        <br>M : Mentoring &nbsp&nbsp K : Kultum &nbsp&nbsp ST : Shining Team &nbsp&nbspNA : Nilai Akhir
                        <br>NA = (Jumlah Nilai Mentoring + MAX(Nilai Kultum) / 7) * 55%) + ((Opening + Closing) / 2) * 35%) + (Shining Team * 10%)
                  </p></small>
            </div>
      </div>
</div>
</section>
<a id="dlink" style="display: none;"></a>
<script type="text/javascript">
$(document).ready(function(){
      $("#save").click(function(){
            $("#nilai").tableExport({tableName:"Rekap Nilai MPAI <?=date('Y')?>",type:'excel',escape:'false'});
            document.location.href="<?=base_url('ba')?>";
      });
});
</script>