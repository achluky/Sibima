<?php if($this->session->userdata('role')=='admin'): ?>
<div class="modal fade" id="modal-chkelompok" data-width-modal="300">
      <div class="modal-dialog">
      <div class="modal-content">
            <form action="<?=base_url('kelompok/change').'/'.$id?>" method="post" class="form-vertical">
                  <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Form Pindah Kelompok</h4>
                        </div>
                        <div class="modal-body">
                              <div class="control-group">
                                    <span class="text-group"><h5>Kelompok Asal : Kelompok <?=ucfirst($namakel)?></h5></span>
                              </div>
                              <div class="control-group">
                                    <span class="text-group">Kelompok Tujuan</span>
                                    <div class="form-group">
                                          <input type="hidden" name="id_modal" id="id_modal"/>
                                          <select name="tujuan" required>
                                                <?php foreach ($kelompok as $result){ 
                                                      if($result->kelompok_id!=$id){?>
                                                      <option value="<?=$result->kelompok_id?>"><?=$result->kelompok_nama?></option>
                                                <?php }
                                                } ?>
                                          </select>
                                          <div class="err-msg"><span></span></div>
                                    </div>
                              </div>
                        </div>
                        <div class="modal-footer">
                              <?php 
                                    $sub = array('class' => 'btn btn-bima btn-primary btn-pop', 'value' => 'Simpan');
                                    $res = array('class' => 'btn btn-bima btn-white btn-pop', 'value' => 'Reset');
                                    echo form_reset($res);
                                    echo form_submit($sub);
                              ?>
                      </div>
                </form>
            </div>
      </div>
</div>
<?php endif; ?>
<div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
    <div class="page-header pull-left">
        <div class="page-title">Manajemen Materi</div>
    </div>
    <ol class="breadcrumb page-breadcrumb pull-right">
        <li><i class="fa fa-home"></i>&nbsp;<a href="<?= base_url(); ?>">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
        <?php if($this->session->userdata('role')=='admin'): ?><li><a href="<?= base_url('kelompok'); ?>">List</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li><?php endif; ?>
        <li class="active">Kelompok</li>
    </ol>
    <div class="clearfix">
    </div>
</div>
<section class="content">
      <div class="portlet box">
            <div class="portlet-header">
                  <h3>Kelompok <?=ucfirst($namakel)?></h3>
            </div>
            <div class="portlet-body">
                  <div class="box-header">
                        <table style="width:40%;">
                              <tr>
                                    <td><h4>Mentor 1</h4></td>
                                    <td style="width:5%;"><h4>    :</h4></td>
                                    <td><h4><?=$mentor1?></h4></td>
                              </tr>
                              <tr>
                                    <td><h4>Mentor 2</h4></td>
                                    <td>:</td>
                                    <td><h4><?=$mentor2?></h4></td>
                              </tr>
                        </table>
                  </div>
                  <br>
                  <div class="box-body table-responsive">
                        <table id="mentee" class="table table-hover form-seeable">
                              <thead>
                                    <tr>
                                          <th>No</th>
                                          <th>NIM</th>
                                          <th>Nama</th>
                                          <th>Kelas</th>
                                          <th>No. HP</th>
                                          <th>Jurusan</th>
                                    <?php if($this->session->userdata('role')!='mentee'): ?>
                                          <th>Aksi</th>
                                    <?php endif; ?>
                                    </tr>
                              </thead>
                              <tbody>
                                    <?php 
                                    $a=1;
                                    foreach ($data as $result) { ?>
                                          <tr>
                                    <form onSubmit="saveForm(<?=$a?>); return false" class="" id="form<?=$a?>" action="<?=base_url('kelompok/update/'.$a)?>" method="post">
                                                <td><?=$a?></td>
                                                <td> 
                                                      <label for="nim<?=$a?>">
                                                            <?=$result->mentee_nim?>
                                                      </label>
                                                      <input type="hidden" name="id<?=$a?>" value="<?=$result->mentee_id?>"/>
                                                      <input type="text" name="nim<?=$a?>" value="<?=$result->mentee_nim?>" class="big-seeable seeable">
                                                      
                                                </td>
                                                <td>
                                                      <label for="nama<?=$a?>">
                                                            <?=$result->mentee_nama?>
                                                      </label>
                                                      <input type="text" name="nama<?=$a?>" value="<?=$result->mentee_nama?>" class="big-seeable seeable">
                                                </td>
                                                <td>
                                                      <label for="kelas<?=$a?>">
                                                            <?=$result->mentee_kelas?>
                                                      </label>
                                                      <input type="text" name="kelas<?=$a?>" value="<?=$result->mentee_kelas?>" class="big-seeable seeable">
                                                </td>
                                                <td>
                                                      <label for="telp<?=$a?>">
                                                            <?=$result->mentee_telp?>
                                                      </label>
                                                      <input type="text" name="telp<?=$a?>" value="<?=$result->mentee_telp?>" class="big-seeable seeable">
                                                </td>
                                                <td>
                                                      <label for="jurusan<?=$a?>">
                                                            <?=$result->mentee_jurusan?>
                                                      </label>
                                                      <input type="text" name="jurusan<?=$a?>" value="<?=$result->mentee_jurusan?>" class="big-seeable seeable">
                                                </td>
                                                <?php if($this->session->userdata('role')!='mentee'): ?>
                                                <td style="min-width:250px;">
                                                      <button class="btn btn-bima btn-info btn-kel-edit" onclick="editForm(this.id, <?=$a?>); return false;" id="btn-kel-edit<?= $a ?>">Edit</button>
                                                      <input type="submit" class="btn btn-bima btn-primary seeable" id="btn-kel-save<?= $a ?>" value="Simpan"/>
                                                      <button class="btn btn-bima btn-white seeable" id="btn-kel-cancel" onclick="backToNature(<?=$a?>);return false;">Cancel</button>
                                                <?php if($this->session->userdata('role')=='admin'): ?>
                                                      <button class="btn btn-bima btn-success" data-controls-modal="modal-chkelompok" data-backdrop="dynamic" onclick="changeId(<?=$result->mentee_id?>);" id="btn-kel-pindah">Pindah</button>
                                                      <button class="btn btn-bima btn-danger" onclick="deleteMentee(<?=$result->mentee_id?>);return false;" id="btn-kel-hapus">Hapus</button>
                                                <?php endif; ?>
                                                </td>
                                                <?php endif; ?>
                                    </form>
                                          </tr>
                                    <?php $a++; } ?>
                              </tbody>
                        </table>
                  </div>
            </div>
      </div>
</section>
<script>
$(document).ready(function(){
      $("#mentee").DataTable();
})
var changeId = function(id)
{
      $("#id_modal").val(id);
}
var editForm = function(btn, seq)
{
      var fnama = "nama"+seq;
      var ftelp = "telp"+seq;
      var fkls = "kelas"+seq;
      var fjurusan = "jurusan"+seq;
      $('label[for="'+fnama+'"]').hide(0, function(){
            $('input.seeable[name="'+fnama+'"]').show(0);
      });
      $('label[for="'+ftelp+'"]').hide(0,function(){
            $('input.seeable[name="'+ftelp+'"]').show(0);
      });
      $('label[for="'+fkls+'"]').hide(0,function(){
            $('input.seeable[name="'+fkls+'"]').show(0);
      });
      $('label[for="'+fjurusan+'"]').hide(0,function(){
            $('input.seeable[name="'+fjurusan+'"]').show('fast');
      });
      $("#edit"+seq).hide(0, function(){
            $('#save'+seq).show(0);
      });
      $(document.getElementById(btn)).hide(0, function(){
            $(document.getElementById(btn)).siblings('.seeable').show(0);
      });
}

var updateData = function(e){
      var dataform=$("#form"+e).serialize();
      console.log(dataform);
      $.ajax({
            url:$("#form"+e).attr("action"),
            data:dataform,
            type:"post",
            success:function(data){
                  var hasil=JSON.parse(data);
                  $('label[for="nama'+e+'"]').html(hasil['mentee_nama']);
                  $('label[for="kelas'+e+'"]').html(hasil['mentee_kelas']);
                  $('label[for="telp'+e+'"]').html(hasil['mentee_telp']);
                  $('label[for="jurusan'+e+'"]').html(hasil['mentee_jurusan']);
            }
      });
}

var saveForm = function(seq)
{
      updateData(seq);
      backToNature(seq);
}

var backToNature = function(seq)
{
      var fnama = "nama"+seq;
      var ftelp = "telp"+seq;
      var fkls = "kelas"+seq;
      var fjurusan = "jurusan"+seq;
      $('label[for="'+fnama+'"]').show(0);
      $('label[for="'+ftelp+'"]').show(0);
      $('label[for="'+fkls+'"]').show(0);
      $('label[for="'+fjurusan+'"]').show(0);
      $('input.seeable[name="'+fnama+'"]').hide(0);
      $('input.seeable[name="'+ftelp+'"]').hide(0);
      $('input.seeable[name="'+fkls+'"]').hide(0);
      $('input.seeable[name="'+fjurusan+'"]').hide(0);
      $('input.seeable[name="'+fnama+'"]').hide(0);
      $('input.seeable[name="'+ftelp+'"]').hide(0);
      $('input.seeable[name="'+fkls+'"]').hide(0);
      $('input.seeable[name="'+fjurusan+'"]').hide(0);
      $('#btn-kel-save'+seq).hide(0);
      $('#btn-kel-save'+seq).siblings('button.seeable').hide(0, function(){
            $("#btn-kel-edit"+seq).show(0);
            $("#btn-kel-save"+seq).siblings().not('.seeable').show(0);
      });
}

var deleteMentee= function(num)
{
      if(confirm("Apakah anda yakin ingin menghapus?"))
      {
            $.ajax({
                  url:"<?=base_url('kelompok/deletementee')?>",
                  data:"data="+num,
                  type:"post",
                  success:function(data){
                        console.log(data);
                        if(data=='berhasil'){
                              setTimeout(function(){
                                    location.reload();
                              },0001);
                        }else{
                              console.log('err');
                        }
                  }
            });
      }else
      {
            console.log('wow')
      }
}
</script>