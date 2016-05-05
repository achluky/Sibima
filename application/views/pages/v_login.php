<!DOCTYPE html>
<html >
    <head>
        <meta charset="UTF-8">
        <title>SIBIMA | <?= $title ?></title>
        <link href='http://fonts.googleapis.com/css?family=Raleway' rel='stylesheet' type='text/css'>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <link rel="shortcut icon" href="images/icons/favicon.ico">
        <link rel="apple-touch-icon" href="images/icons/favicon.png">
        <link type="text/css" rel="stylesheet" href="<?= css_url('font-awesome.min.css');?>">
        <link type="text/css" rel="stylesheet" href="<?= css_url('animate.css');?>">
        <link type="text/css" rel="stylesheet" href="<?= css_url('pace.css');?>">
        <link type="text/css" rel="stylesheet" href="<?= css_url('bima-style.css');?>">
        <link type="text/css" rel="stylesheet" href="<?= css_url('bima.css');?>">
        <link href="<?= css_url('bootstrap.min.css') ?>" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <div class="form-box" id="login-box">
            <div id="bima-look">
                <div id="head-look"></div>
                <div id="hand-look"></div>
            </div>
            <div class="header text-center">
                <h1 style="font-family:'norwester'; color:#2B2F3E; font-size:40px;">SIBIMA</h1>
                <h5 style="font-family:'glober'; color:#2B2F3E; margin-bottom:20px;">Sistem Informasi Badan Mentoring<br/>Telkom University</h5>

            </div>
            <form action="<?=base_url('auth/login')?>" method="post">
                <div class="body">
                    <div class="form-group">
                        <input type="text" name="userid" class="form-control" placeholder="NIM"/>
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" class="form-control" placeholder="Password"/>
                    </div>          
                    <div class="form-group">

                        <input type="checkbox" name="remember_me"/> Ingat saya
                        
                            
                            <a class="pull-right" onclick="myFunction()" href="#">Lupa Password</a>
                    
                    </div>
                </div>
                <div class="footer">                                                               
                    <button type="submit" class="btn btn-primary btn-block">Masuk</button>  
                    
                    <script>
                        function myFunction() {
                            alert("Hubungi admin SIBIMA");
                        }
                    </script>
                </div>
            </form>


        </div>
        <script src="<?= libraries_url('jquery-1.10.2.min.js'); ?>"></script>
        <script src="<?=base_url('asset/js/plugins/bootstrap.min.js')?>" type="text/javascript"></script>
        <script src="<?= libraries_url('pace.min.js'); ?>"></script>
        <script src="<?= libraries_url('html5shiv.js'); ?>"></script>
        <script src="<?= libraries_url('respond.min.js'); ?>"></script>
        <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
      ga('create', 'UA-59443895-1', 'auto');
      ga('send', 'pageview');
    </script>
    </body>
</html>