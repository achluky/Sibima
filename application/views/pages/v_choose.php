<html>
  <head>
    <meta charset="UTF-8">
    <title><?= $title ?> - SIBIMA</title>
    <?php
        if($this->session->userdata('role') == NULL || $this->session->userdata('role') != 'mentor' ){
            redirect(base_url('auth'));
        }
    ?>
    <meta charset="utf-8">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="images/icons/favicon.ico">
    <link rel="apple-touch-icon" href="images/icons/favicon.png">
    <link rel='stylesheet' href='http://fonts.googleapis.com/css?family=Raleway' type='text/css'>
    <link type="text/css" rel="stylesheet" href="<?= css_url('font-awesome.min.css');?>">
    <link type="text/css" rel="stylesheet" href="<?= css_url('bootstrap.min.css');?>">
    <link type="text/css" rel="stylesheet" href="<?= css_url('animate.css');?>">
    <link type="text/css" rel="stylesheet" href="<?= css_url('pace.css');?>">
    <link type="text/css" rel="stylesheet" href="<?= css_url('style-responsive.css');?>">
    <link type="text/css" rel="stylesheet" href="<?= css_url('bima-style.css');?>">
    <link type="text/css" rel="stylesheet" href="<?= css_url('bima.css');?>">
    <link type="text/css" rel="stylesheet" href="<?= css_url('bima-new.css');?>">
    <script src="<?= libraries_url('jquery-1.10.2.min.js'); ?>"></script>
  </head>
  <body class="chooseKelompok">
    <div class="container">
      <div class="row">
        <div class="naone">
          <div class="row">
            <h3>Pilih Kelompok : </h3>
            <div class="col-lg-12">
              <?php foreach ($kelompok as $row) : ?>
                <a href="<?= base_url('dashboard/chosen/'.$row->kelompok_id) ?>" class="btn btn-info btn-choose">
                  <?= $row->kelompok_nama; ?>
                </a>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>