<?php if($this->session->userdata('role')=='mentor'): ?>
<div class="page-title-breadcrumb" id="page-title-kelompok">
  <div class="page-header pull-left">
    <div class="page-title">Manajemen Berita Acara</div>
  </div>
  <ol class="breadcrumb page-breadcrumb pull-right">
    <li><i class="fa fa-home"></i>&nbsp;<a href="<?=base_url();?>">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
    <li class="active">Berita Acara</li>
  </ol>
  <div class="clearfix"></div>
</div>
<section class="content">
  <?php if($status = $this->session->flashdata('status')): ?>
    <div class="alert alert-<?= ($status == 'success') ? 'success' : 'danger' ?>" role="alert"><?= $this->session->flashdata('messages'); ?></div>
  <?php endif; ?>
  <div class="portlet box portlet-trans">
    <div class="portlet-header">
      <button class="btn right btn-bima btn-primary" onclick="new Bima.editable({element : '#btn-ba', editing : true}); return false;" id="btn-ba">Ubah</button></td>
      <h3>Kelompok <?=$namakel?></h3>
    </div>
    <div class="portlet-body">
      <form action="<?= base_url('ba/updateDetail') ?>" method="post" class="form-seeable">
        <input type="hidden" name="kelbam" value="<?= $this->uri->segment(3) ?>">
        <div class="box-header control-group">
          <div class="row">
            <div class="col-md-6">
              <div class="row">
                <div class="col-md-3"><h4>Agenda</h4></div>
                <div class="col-md-1"><h4>:</h4></div>
                <div class="col-md-8">
                  <h4><?= $data_bam->bam_nama ?></h4>
                </div>
              </div>
              <?php $no=1; foreach ($data_mentor as $data) : ?>
              <div class="row">
                <div class="col-md-3"><h4>Mentor <?= $no; ?></h4></div>
                <div class="col-md-1"><h4>:</h4></div>
                <div class="col-md-8">
                  <h4><?= $data->mentor_nama; ?></h4>
                </div>
              </div>
              <?php $no++; endforeach; ?>
              <div class="row">
                <div class="col-md-3"><h4>Hari / Tanggal</h4></div>
                <div class="col-md-1"><h4>:</h4></div>
                <div class="col-md-8">
                  <h4 editable="true"><?= $data_bam->kelompok_bam_tanggal; ?></h4>
                  <div class="form-group">
                    <input type="text" name="tanggal" class="seeable big-seeable" value="<?= $data_bam->kelompok_bam_tanggal ?>" id="mentoringDate" readonly >
                  </div>
                </div>
              </div>
            </div>
            <input type="hidden" name="berita_acara" value="<?= $data_bam->bam_id ?>"/>
            <div class="col-md-6">
              <div class="row">
                <div class="col-md-3"><h4>Tempat</h4></div>
                <div class="col-md-1"><h4>:</h4></div>
                <div class="col-md-8">
                  <h4 editable="true"><?= $data_bam->kelompok_bam_tempat; ?></h4>
                  <div class="form-group">
                    <input type="text" name="tempat" class="seeable big-seeable" value="<?= $data_bam->kelompok_bam_tempat; ?>">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-3"><h4>Materi</h4></div>
                <div class="col-md-1"><h4>:</h4></div>
                <div class="col-md-8">
                  <h4 editable="true"><?= $data_bam->kelompok_bam_materi; ?></h4>
                  <div class="form-group">
                    <input type="text" name="materi" class="seeable big-seeable" value="<?= $data_bam->kelompok_bam_materi; ?>">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-3"><h4>Kultum</h4></div>
                <div class="col-md-1"><h4>:</h4></div>
                <div class="col-md-8">
                  <h4 editable="true"><?= $data_bam->kelompok_bam_kultum; ?></h4>
                  <div class="form-group">
                    <input type="text" name="materi_kultum" class="seeable big-seeable" value="<?= $data_bam->kelompok_bam_kultum; ?>">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <br>
        <div class="box-body table-responsive">
          <table class="table table-hover">
            <thead>
              <tr>
                <th rowspan="2">NIM</th>
                <th rowspan="2">Nama</th>
                <th colspan="2" class="text-center">Nilai</th>
              </tr>
              <tr>
                <th class="text-center">Mentoring</th>
                <th class="text-center">Kultum</th>
              </tr>
            </thead>
            <tbody>
              <?php $no=1; foreach ($data_mentee as $mentee) : ?>
              <tr>
                <td><?= $mentee->mentee_nim ?></td>
                <td><?= $mentee->mentee_nama ?></td>
                <td class="text-center">
                  <span editable='true'><?= ($mentee->nilai_kehadiran == '') ? 0 : $mentee->nilai_kehadiran ?></span>
                  <input type="number" min="0" max="100" step="1" name='kehadiran[<?=$no?>]' class='seeable' value='<?= ($mentee->nilai_kehadiran == '') ? 0 : $mentee->nilai_kehadiran ?>'>
                </td>
                <td class="text-center">
                  <span editable='true'><?= ($mentee->nilai_kultum == '') ? 0 : $mentee->nilai_kultum ?></span>
                  <input type="number" min="0" max="100" step="1" name='kultum[<?=$no?>]' class='seeable' value='<?= ($mentee->nilai_kultum == '') ? 0 : $mentee->nilai_kultum ?>'>
                </td>
                <input type='hidden' name='mentee[<?=$no?>]' value='<?=$mentee->mentee_id?>' >
              </tr>
              <?php $no++; endforeach; ?>
              <tr>
                <td colspan="4" class="text-right">
                  <button class="btn btn-gray btn-big-bima seeable" id="cancel">Batal</button>
                  <button class="btn btn-big-bima btn-primary seeable" onclick="return true">Simpan</button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </form>
    </div>
  </div>
</section>
<?php endif; ?>

<?php if($this->session->userdata('role')=='admin'): ?>
<div class="modal fade" id="modal-bam" data-width-modal="300">
    <!-- <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" id="form_bam" enctype="multipart/form-data" class="form-vertical" action="<?php echo base_url('ba/addnew')?>">
                <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title">Tambah Berita Acara</h4>
                </div>
                <div class="modal-body">
                    <div class="control-group">
                        <span class="text-group">Nama Agenda</span>
                        <div class="form-group">
                                          <input type="text" name="nama" id="bamNama">
                            <div class="err-msg"><span></span></div>
                        </div>
                    </div>
                    <div class="control-group">
                        <span class="text-group">Tipe Agenda</span>
                        <div class="form-group">
                              <select name="tipe" class="form-control">
                                    <option value="0">Mentoring</option>
                                    <option value="1">General</option>
                              </select>
                        </div>
                    </div>
                    <div class="control-group">
                        <span class="text-group">Tanggal berakhir</span>
                        <div class="form-group">
                            <input type="text" id="mentoringDate" readonly name="tanggal" />
                            <div class="err-msg"><span></span></div>
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
    </div> -->
</div>
<div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
    <div class="page-header pull-left">
        <div class="page-title">Berita Acara Mentoring</div>
    </div>
    <ol class="breadcrumb page-breadcrumb pull-right">
        <li><i class="fa fa-home"></i>&nbsp;<a href="<?=base_url();?>">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
        <li class="active">Berita Acara</li>
    </ol>
    <div class="clearfix">
    </div>
</div>
<section class="content">
      <?php if($status = $this->session->flashdata('status')): ?>
            <div class="alert alert-<?= ($status == 'success') ? 'success' : 'danger' ?>" role="alert"><?= $this->session->flashdata('messages'); ?></div>
      <?php endif; ?>
      <div class="row">
            <div class=" portlet box col-lg-12 portlet-trans">
                  <div class="portlet-header">
                              <h4>List Agenda Mentoring</h4>
                  </div>
                <div class="portlet-body">
                       <!-- <div class="box-header">
                        <div class="box-title form-group">
                                    <form action="" method="post">
                                          <select name="gender" class="form-control" onchange="location = this.options[this.selectedIndex].value;">
                                          <?php echo $option ?>
                                    </select>
                                    </form>
                              </div>
                        </div> -->
                  <div class="box-body table-responsive no-padding">
                        <table class="table table-striped" id="data">
                              <thead>
                                    <tr>
                                          <th>Mentee</th>
                                          <th>OD</th>
                                          <th>M1</th>
                                          <th>M2</th>
                                          <th>M3</th>
                                          <th>MG</th>
                                          <th>M4</th>
                                          <th>M5</th>
                                          <th>M6</th>
                                          <th>ST</th>
                                          <th>ID</th>
                                    </tr>
                              </thead>
                              <tbody>
                                    <tr> 
                                          <td>Muhammad Fajar Anshari</td>
                                          <td>100</td>
                                          <td>100</td>
                                          <td>100</td>
                                          <td>100</td>
                                          <td>100</td>
                                          <td>100</td>
                                          <td>100</td>
                                          <td>100</td>
                                          <td>100</td>
                                          <td>100</td>
                                    </tr>
                                    <tr>
                                          <td>della</td>
                                          <td>100</td>
                                          <td>100</td>
                                          <td>100</td>
                                          <td>100</td>
                                          <td>100</td>
                                          <td>100</td>
                                          <td>100</td>
                                          <td>100</td>
                                          <td>100</td>
                                          <td>100</td>
                                    </tr>
                                          <td>Maidarman</td>
                                          <td>100</td>
                                          <td>100</td>
                                          <td>100</td>
                                          <td>100</td>
                                          <td>100</td>
                                          <td>100</td>
                                          <td>100</td>
                                          <td>100</td>
                                          <td>100</td>
                                          <td>100</td>
                                    </tr>
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

update = function(objek){
      var bam = $(objek).data("bam");
      var datanya="data="+bam;
      $.ajax({
            url:"<?php echo base_url('ba/getEdit'); ?>",
            data:datanya,
            type:"post",
            success:function(data){
                  var result = JSON.parse(data);
                  $("#bamNama").val(result.bam_nama);
                  $("#mentoringDate").val(result.bam_tanggal_akhir);
                  $("#form_bam").attr('action',"<?= base_url('ba/updateAgenda') ?>"+"/"+bam);
            }
      });
}
</script>
<script>
  $('#cancel').click(function(e){
    console.log('clicked')
    e.preventDefault();
    new Bima.editable({element : '#btn-ba', editing : false});
    return false;
  });
</script>
<?php endif; ?>
<script type="text/javascript">
  $(document).ready(function(){
    $("#data").DataTable();
    $('#cancel').click(function(e){
      console.log('clicked')
      e.preventDefault();
      new Bima.editable({element : '#btn-ba', editing : false});
      return false;
    });
  });
  function search(obj){
    // console.log($(obj).val())
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

  update = function(objek){
    var bam = $(objek).data("bam");
    var datanya="data="+bam;
    $.ajax({
      url:"<?php echo base_url('ba/getEdit'); ?>",
      data:datanya,
      type:"post",
      success:function(data){
        var result = JSON.parse(data);
        $("#bamNama").val(result.bam_nama);
        $("#mentoringDate").val(result.bam_tanggal_akhir);
        $("#form_bam").attr('action',"<?= base_url('ba/updateAgenda') ?>"+"/"+bam);
      }
    });
  }
</script

