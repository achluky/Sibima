<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <link rel="shortcut icon" href="<?= img_url('sibima-logo_16x16.png'); ?>">
        <title><?= $title ?> - SIBIMA</title>
        <?php
            if($this->session->userdata('role') == NULL)
                redirect(base_url('auth'));
            else if($this->session->userdata('role') == 'mentor')
            {
                if($this->session->userdata('nkel') > 1)
                {
                    if($this->session->userdata('idkel') == NULL)
                        redirect(base_url('dashboard/chooseKelompok'));
                    else
                        $listKelompok = $this->_kelompok_mentor->getKelompokByMentorNim($this->session->userdata('nim'));
                }
            }
        ?>
        <meta charset="utf-8">
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href='http://fonts.googleapis.com/css?family=Raleway' rel='stylesheet' type='text/css'>
        <link rel="shortcut icon" href="images/icons/favicon.ico">
        <link rel="apple-touch-icon" href="images/icons/favicon.png">
        <link type="text/css" rel="stylesheet" href="<?= css_url('font-awesome.min.css');?>">
        <link type="text/css" rel="stylesheet" href="<?= css_url('bootstrap.min.css');?>">
        <link type="text/css" rel="stylesheet" href="<?= css_url('jquery.dataTables.min.css');?>">
        <link type="text/css" rel="stylesheet" href="<?= css_url('jquery-ui.min.css');?>">
        <link type="text/css" rel="stylesheet" href="<?= css_url('animate.css');?>">
        <link type="text/css" rel="stylesheet" href="<?= css_url('pace.css');?>">
        <link type="text/css" rel="stylesheet" href="<?= css_url('style-responsive.css');?>">
        <link type="text/css" rel="stylesheet" href="<?= css_url('jquery.news-ticker.css');?>">
        <link type="text/css" rel="stylesheet" href="<?= css_url('bima-style.css');?>">
        <link type="text/css" rel="stylesheet" href="<?= css_url('bima.css');?>">
        <link type="text/css" rel="stylesheet" href="<?= css_url('bima-new.css');?>">
        <link type="text/css" rel="stylesheet" href="<?= css_url('datepicker.css');?>">
        <link type="text/css" rel="stylesheet" href="<?= css_url('jquery-ui.theme.min.css');?>">
        <link type="text/css" rel="stylesheet" href="<?= css_url('ionicons.min.css');?>">
        <script src="<?= libraries_url('jquery-1.10.2.min.js'); ?>"></script>
        <script src="<?= libraries_url('jquery.base64.js'); ?>"></script>
        <script src="<?= libraries_url('tableExport.js'); ?>"></script>
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="wysihtml5-supported pace-done">
        <!--BEGIN BACK TO TOP-->
        <a id="totop" href="#"><i class="fa fa-angle-up"></i></a>
        <!--END BACK TO TOP-->
        <!--BEGIN TOPBAR-->
        <nav id="sidebar" role="navigation" data-step="2" data-cond="big" class="navbar-default navbar-static-side">
            <div class="navbar-header">
                <a id="logo" href="<?= base_url();?>">
                    <img src="<?= img_url('sibima-logo.png'); ?>" alt="SIBIMA">
                </a>
                <h1 class="logo-title">SIBIMA</h1>
                <h5 class="logo-subtitle">Sistem Informasi Badan Mentoring</h5>
            </div>
            <ul id="side-menu" class="nav">
                <!-- <img src="<?= img_url('nav-sibima.png'); ?>" alt="" id="bottom-navbar"> -->
                <div class="clearfix"></div>
                <li class="<?= ($this->uri->segment(1) == 'dashboard' || $this->uri->segment(1) == FALSE) ? 'active' : ''; ?>">
                    <a href="<?= base_url(); ?>">
                        <i class="fa fa-tachometer fa-fw"><div class="icon-bg bg-orange"></div></i>
                        <span class="menu-title">DASHBOARD</span>
                    </a>
                </li>
            <?php //if($this->session->userdata('role')!='mentee'): ?>
                <!-- <li class="<?= ($this->uri->segment(1) == 'ba') ? 'active' : ''; ?>">
                    <a href="<?= ($this->session->userdata('role')=='admin')?base_url('ba'):base_url('ba/daftar').'/'.$this->session->userdata('idkel'); ?>">
                        <i class="fa fa-file-text-o fa-fw"><div class="icon-bg bg-pink"></div></i>
                        <span class="menu-title">BERITA ACARA</span>
                    </a>
                </li> -->
            <?php //endif; ?>
            <?php if($this->session->userdata('role') == 'admin') : ?>
                <li class="<?= ($this->uri->segment(1) == 'ba') ? 'active' : ''; ?>">
                    <a href="<?= base_url('ba') ?>">
                        <i class="fa fa-file-text-o fa-fw"><div class="icon-bg bg-pink"></div></i>
                        <span class="menu-title">BERITA ACARA</span>
                    </a>
                </li>
            <?php endif; ?>
                <li class="<?= ($this->uri->segment(1) == 'kelompok') ? 'active' : ''; ?>">
                    <a href="<?= ($this->session->userdata('role')=='admin')?base_url('kelompok'):base_url('kelompok/detail').'/'.$this->session->userdata('idkel') ?>">
                        <i class="fa fa-users fa-fw">
                        <div class="icon-bg bg-red"></div></i>
                        <span class="menu-title">KELOMPOK</span>
                    </a>
                </li>
            <?php if($this->session->userdata('role')=='admin'): ?>
                <li class="<?= ($this->uri->segment(1) == 'presensi') ? 'active' : ''; ?>">
                    <a href="<?= base_url('presensi') ?>">
                        <i class="fa fa-check fa-fw"><div class="icon-bg bg-violet"></div></i>
                        <span class="menu-title">PRESENSI</span>
                    </a>  
                </li>
            <?php endif; ?>
            <?php if($this->session->userdata('role')=='admin'): ?>
                <li class="<?= ($this->uri->segment(1) == 'data_mentor') ? 'active' : ''; ?>">
                    <a href="<?= base_url('data_mentor') ?>">
                        <i class ="fa fa-database fa-fw"><div class="icon-bg bg-violet"></div></i>
                        <span class="menu-title">DATA</span>
                    </a>
                </li>
            <?php endif; ?>
            <?php if($this->session->userdata('role')=='admin'): ?>
                <li class="<?= ($this->uri->segment(1) == 'st') ? 'active' : ''; ?>">
                    <a href="<?= base_url('st') ?>">
                        <i class="fa fa-briefcase fa-fw"><div class="icon-bg bg-violet"></div></i>
                        <span class="menu-title">SHINING TEAM</span>
                    </a>  
                </li>
            <?php endif; ?>
            <?php if($this->session->userdata('role')!='mentee'): ?>
                <li class="<?= ($this->uri->segment(1) == 'materi') ? 'active' : ''; ?>">
                    <a href="<?= base_url('materi') ?>">
                        <i class="fa fa-book fa-fw"><div class="icon-bg bg-blue"></div></i>
                        <span class="menu-title">MATERI</span>
                    </a>
                </li>
            <?php endif; ?>
                <li class="<?= ($this->uri->segment(1) == 'quisioner') ? 'active' : ''; ?>">
                    <a href="<?= base_url('quisioner'); ?>">
                        <i class="fa fa-pencil-square fa-fw">
                        <div class="icon-bg bg-red"></div></i>
                        <span class="menu-title">QUISIONER</span>
                    </a>
                </li>
            <?php if($this->session->userdata('role')=='admin'): ?>
                <li class="<?= ($this->uri->segment(1) == 'talaqi') ? 'active' : ''; ?>">
                    <a href="<?= base_url('talaqi') ?>">
                        <i class="fa fa-edit fa-fw"><div class="icon-bg bg-violet"></div></i>
                        <span class="menu-title">TALAQI</span>
                    </a>  
                </li>
            <?php endif; ?>
            </ul>
        </nav>
        <!-- <img src="<?= img_url('tes-sibima03.png');?>" alt="" id="backdrop"> -->
        <div id="content-wrapper">
            <header class="page-header-topbar">  
                <img src="<?= img_url('header-sibima.png'); ?>" alt="" id="top-navbar">
                <nav id="topbar" role="navigation" data-step="3" class="navbar navbar-default navbar-static-top">
                    <div class="topbar-main">
                        <a id="menu-toggle" href="#" class="hidden-xs"><i class="fa fa-bars"></i></a>
                        <div class="news-update-box hidden-xs">
                            <ul id="news-update" class="ticker list-unstyled">
                                <li>Selamat datang di SIBIMA - Sistem Informasi Badan Mentoring Telkom University</li>
                            </ul>
                        </div>
                        <ul class="nav navbar-top-links navbar-right">                    
                            <li class="dropdown topbar-user">
                                <a data-hover="dropdown" href="#" class="dropdown-toggle">
                                    <img src="<?=(strtoupper($this->session->userdata('jk'))=='I')?img_url('profile/avatar-sibima01.png'):img_url('profile/avatar-sibimi01.png')?>" alt="" class="img-responsive img-circle"/>
                                    <span class="hidden-xs"><?= $this->session->userdata('nama'); ?></span>
                                    <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu dropdown-user pull-right">
                                    <li><a href="<?= base_url('profile');?>"><i class="fa fa-user"></i>My Profile</a></li>
                                    <li><a href="<?= base_url('auth/logout');?>"><i class="fa fa-key"></i>Log Out</a></li>
                                </ul>
                            </li>
                        </ul>
                        <?php if($this->session->userdata('role')=='mentor' && $this->session->userdata('nkel') > 1): ?>
                            <ul class="nav navbar-top-links navbar-right">
                                <li class="dropdown topbar-user">
                                    <a data-hover="dropdown" href="#" class="dropdown-toggle">
                                        <span class="fa fa-group fa-lg"></span>
                                    </a>
                                    <ul class="dropdown-menu dropdown-user pull-right choose-group">
                                        <?php foreach ($listKelompok as $kel) : ?>
                                            <li class="<?= ($this->session->userdata('idkel') == $kel->kelompok_id) ? 'chosen' : ''?>"><a href="<?= base_url('dashboard/chosen/'.$kel->kelompok_id) ?>"><?= $kel->kelompok_nama ?></a></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </li>
                            </ul>
                        <?php endif; ?>
                    </div>
                </nav>
            </header>
            <div id="page-wrapper">