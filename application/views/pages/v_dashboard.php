<div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
    <div class="page-header pull-left">
        <div class="page-title">Dashboard</div>
    </div>

    <ol class="breadcrumb page-breadcrumb pull-right">
        <li><i class="fa fa-home"></i>&nbsp;<a href="<?= base_url() ?>">Dashboard</a></li>
    </ol>
    <div class="clearfix">
    </div>
</div>

<?php if($this->session->userdata('role')=='mentor'): ?>
<div class="modal fade" id="modal-bam">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <form method="post" id="form_materi" enctype="multipart/form-data" class="form-vertical" action="<?php echo base_url('ba/addDetail')?>">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Berita Acara</h4>
                </div>
                <div class="modal-body">
                    <div class="control-group">
                        <span class="text-group">Mentoring ke :</span>
                        <div class="form-group">
                            <select class="form-control" name="nama" id="agendaOption">
                                <?php  foreach ($listBam as $bam ) : ?>
                                    <option value="<?= $bam->bam_id ?>"><?= $bam->bam_nama ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="control-group">
                        <span class="text-group">Hari Tanggal</span>
                        <div class="form-group">
                            <input type="text" id="mentoringDate" readonly name="tanggal"/>
                            <div class="err-msg"><span></span></div>
                        </div>
                    </div>
                    <div class="control-group">
                        <span class="text-group">Tempat</span>
                        <div class="form-group">
                            <?= form_input('tempat'); ?>
                            <div class="err-msg"><span></span></div>
                        </div>
                    </div>
                    <div class="control-group">
                        <span class="text-group">Materi</span>
                        <div class="form-group">
                            <?= form_input('materi'); ?>
                            <div class="err-msg"><span></span></div>
                        </div>
                    </div>
                    <div class="control-group">
                        <span class="text-group">Kultum</span>
                        <div class="form-group">
                            <?= form_input('kultum'); ?>
                            <div class="err-msg"><span></span></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <?php
                        $sub = array('class' => 'btn btn-primary btn-bima', 'value' => 'simpan');
                        $res = array('class' => 'btn btn-white btn-bima', 'value' => 'reset');
                        echo form_reset($res);
                        echo form_submit($sub);
                    ?>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="content">
    <div id="tab-general">
        <?php if(!is_null($this->session->flashdata('status'))): ?>
            <div class="callout callout-<?= $this->session->flashdata('status')?>">
                <p><?= $this->session->flashdata('messages'); ?></p>
            </div>
        <?php endif; ?>
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="portlet portlet-trans box">
                            <div class="portlet-header">
                                  <h3>Kelompok <?= $namakel ?></h3>
                            </div>
                            <div class="portlet-body">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Berita Acara</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; foreach ($listBam as $bam) : ?>
                                        <tr>
                                            <td><?= $i++ ?></td>
                                            <td><?= $bam->bam_nama ?></td>
                                            <?php $status = $this->_bam->getStatusBam($bam->bam_id, $this->session->userdata('nim'), $this->session->userdata('idkel')); ?>
                                            <td><span class="label label-<?= ($status) ? 'success' : 'danger' ?> btn-bima"><?= ($status) ? 'Sudah' : 'Belum' ?></span>
                                            </td>
                                            <td>
                                                <?php if($status): ?>
                                                    <a href="<?= base_url('ba/detail/'.$this->_kelompok_bam->getIdByBamAndKelompok($bam->bam_id, $this->session->userdata('idkel'))); ?>">
                                                        <button type="button" class="btn btn-info btn-bima">Lihat</button>
                                                    </a>
                                                <?php else : ?>
                                                    <a href="#" onclick="agenda(<?= $bam->bam_id ?>); return false;">
                                                        <button class="btn btn-primary btn-bima" data-toggle="modal" data-controls-modal="modal-bam" data-backdrop="static">Buat</button>
                                                    </a>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                        <?php if($i <= 1): ?>
                                            <tr>
                                                <td colspan="4">Belum ada berita acara yg disediakan dari BM</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>     
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="portlet portlet-trans box">
                            <div class="portlet-header">
                                <h4>Kalender ICB</h4>
                            </div>
                            <div class="portlet-body">
                                Maaf saat ini fitur belum tersedia
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
function agenda(bam)
{
    var opt = document.getElementById("agendaOption");
    for (i = 0; i < opt.length; i++)
        if(opt.options[i].value == bam)
            opt.selectedIndex = i;
}
</script>
<?php endif; ?>

<?php if($this->session->userdata('role')=='mentee'): ?>
<div class="content">
    <div id="tab-general">
        <?php if(!is_null($this->session->flashdata('status'))): ?>
            <div class="callout callout-<?= $this->session->flashdata('status')?>">
                <p><?= $this->session->flashdata('messages'); ?></p>
            </div>
        <?php endif; ?>
        <div class="row">
            <div class="col-lg-8">
                <div class="portlet portlet-trans box ">
                    <div class="portlet-header">
                        <h4>Kalender ICB</h4>
                    </div>
                    <div class="portlet-body">
                        Maaf saat ini fitur belum tersedia
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="info-box bg-aqua">
                    <span class="info-box-icon"><i class="icon ion-person"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Mentor 1</span>
                        <span class="info-box-number"><?= $mentor[0]->mentor_nama ?></span>
                        <span class="info-box-text"><?= $mentor[0]->mentor_telp ?></span>
                    </div>
                </div>
                <?php if(sizeof($mentor) > 1) : ?>
                    <div class="info-box bg-green">
                    <span class="info-box-icon"><i class="icon ion-person"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Mentor 2</span>
                        <span class="info-box-number"><?= $mentor[1]->mentor_nama ?></span>
                        <span class="info-box-text"><?= $mentor[1]->mentor_telp ?></span>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="portlet portlet-trans box nilaidash">
                    <div class="portlet-body infonilai">       
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="col-lg-6">
                                    <h3><b>Informasi Nilai</b></h3>
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <td><h4>Agenda</h4></td>
                                                <td><h4>Kehadiran</h4></td>
                                                <td><h4>Kultum</h4></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if(sizeof($report) > 0) : ?>
                                                <?php foreach ($report as $row) : ?>
                                                    <tr>
                                                        <td><?= $row->bam_nama ?></td>
                                                        <td><?= $row->nilai_kehadiran ?></td>
                                                        <td><?= $row->nilai_kultum ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else : ?>
                                                <tr>
                                                    <td colspan="3"><h5 class="text-center"><b>Belum ada nilai yang dimasukkan</b></h5></td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>   
                                </div>
                                <div class="col-lg-6">
                                    <h3><b>Nilai Acara General</b></h3>
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <td><h4>Acara General</h4></td>
                                                <td><h4>Kehadiran</h4></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if(sizeof($general) > 0) : ?>
                                                <?php foreach ($general as $row) : ?>
                                                    <tr>
                                                        <td><?= $row->bam_nama ?></td>
                                                        <td><?= $row->nilai_kehadiran ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else : ?>
                                                <tr>
                                                    <td colspan="3"><h5 class="text-center"><b>Belum ada nilai yang dimasukkan</b></h5></td>
                                                </tr>
                                            <?php endif; ?>
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
<?php endif; ?>