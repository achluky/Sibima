<div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
  <div class="page-header pull-left">
    <div class="page-title">Presensi</div>
</div>
<ol class="breadcrumb page-breadcrumb pull-right">
    <li><i class="fa fa-home"></i>&nbsp;<a href="<?=base_url();?>">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
    <li><a href="<?= base_url('presensi');?>">Presensi Mentoring</a> &nbsp;<i class="fa fa-angle-right"></i> &nbsp;</li>
    <li class="active">Input</li>
</ol>
<div class="clearfix">
</div>
</div>
<section class="page-content">
      <div class="tab-general">
            <div class="row">
                  <div class="col-lg-12">
                        <div class="col-lg-8 portlet  box">
                              <div class="portlet-body">
                                <div class="box-body table-responsive no-padding">
                                    <table class="table table-hover" id="data">
                                          <thead>
                                                <tr>
                                                  <th>#</th>
                                                  <th>Nim</th>
                                                  <th>Nama</th>
                                                  <!-- <th>Status</th> -->
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
                                                <span class='label label-block label-success'>OK</span>
                                                <?php else: ?>
                                                <a href="<?=base_url("presensi/updateabsen?nim=$data->mentee_nim&bam=$data->bam_id")?>" class='btn btn-bima btn-danger'>Hadir</a>
                                                <?php endif; ?>
                                          </td>
                                    </tr>
                              <?php endforeach; ?>
                        </tbody>
                  </table>
            </div>
      </div>
</div>


<!-- Last -->
<div class="col-lg-4 portlet portlet-trans box" style="clear:none">
      <div class="portlet-body">
            <div class="box-body table-responsive no-padding">
                  <table class="table table-hover" id="data">
                        <thead><tr><th><center>Terakhir Presensi</center></th></tr></thead>
                        <tbody>
                            <?php $a=0; foreach ($last->result() as $data): $a++;?>
                            <tr>
                              <td><?=$data->mentee_nama?></a></td>
                        </tr>
                  <?php endforeach; ?>
            </tbody>
      </table>
</div>
</div>
</div>
<!-- / Last  -->

</div>
</div>
</div>
</section>
<script>
$(document).ready(function(){
      $("#data").DataTable(
            {"bLengthChange": false, "oLanguage": { "sSearch": "Cari : " } });

      $(".dataTables_filter [type='search']").width('620px');
      $(".dataTables_filter [type='search']").height('25px');
      $(".dataTables_filter [type='search']").attr("placeholder", "Masukkan NIM / Nama Anda");
});

</script>