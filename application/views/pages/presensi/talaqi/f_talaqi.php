<!DOCTYPE html>
<html lang="en" class="lockscreen">
    <head>
        <meta charset="UTF-8">
        <title>BIMEB | <?= $title ?></title>
        <?php
            if($this->session->userdata('role')==NULL){
                redirect(base_url('auth'));
            }
        ?>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- <link href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet" > -->
        <link href="<?= css_url('bima-style.css') ?>" rel="stylesheet" type="text/css" />
        <link href="<?= css_url('bima.css') ?>" rel="stylesheet" type="text/css" />
        <link type="text/css" rel="stylesheet" href="<?= css_url('bootstrap.min.css');?>">
        <link type="text/css" rel="stylesheet" href="<?= css_url('jquery-ui.min.css');?>">
        <link type="text/css" rel="stylesheet" href="<?= css_url('style-responsive.css');?>">
        <link type="text/css" rel="stylesheet" href="<?= css_url('pace.css');?>">
        <script src="<?= libraries_url('jquery-1.10.2.min.js'); ?>"></script>
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
        <style>
          .control-group input{border-radius: 5px;}
        </style>
    </head>
<body>
  <h1 id="time" class='text-right'></h1>
  <div class="container lock-content">
    <div class="row">
      <div class="col-md-12">
        <h1><?=$agenda?></h1>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="control-group">
          <div class="form-group">
              <form action="<?= base_url('talaqi/insertabsen') ?>" method="post" class="form-vertical one-row" onsubmit="submitform(this);return false;">
                <input type="text" placeholder="Masukkan NIM" id="suswanto" name='nim' />
                <?= form_input(array('name'=>'id','type'=>'hidden','value'=>$id,'id'=>'id')) ?>
                <h3><label class="col-xs-12 text-center text-capitalize" for="inputWarning" id="msg">
                </label></h3>
              </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="btn-danger btn" id="btn-telat">Telat</div>
  <script src="<?= libraries_url('jquery-ui.min.js'); ?>"></script>
  <script type="text/javascript">
  var available=[];
  <?php
    foreach ($mentor as $result) {
  ?>
  available.push("<?=$result['mentor_nim']?>");
  <?php
    }
  ?>

  $(function() {
      startTime();
      $("#suswanto").bind("change paste input focus",function(){
        find("#suswanto");
      });
      $(".ui-autocomplete").bind("click keyup",function(){
        find("#suswanto");
      });
      $("#suswanto").autocomplete({
        source:available,
        focus: function( event, ui ) {
          $( "#suswanto" ).val( ui.item.label );
          find("#suswanto");
        }
      });
      $('#btn-telat').bind('click', function(){
        console.log('oke')
        $(this).css('display', 'none');
        $('.lockscreen body').addClass('telat');
      });
  });

  /*  */
  function startTime()
  {
      var today = new Date();
      var h = today.getHours();
      var m = today.getMinutes();
      var s = today.getSeconds();

      // add a zero in front of numbers<10
      m = checkTime(m);
      s = checkTime(s);

      //Check for PM and AM
      var day_or_night = (h > 11) ? "PM" : "AM";

      //Convert to 12 hours system
      if (h > 12)
          h -= 12;

      //Add time to the headline and update every 500 milliseconds
      $('#time').html(h + ":" + m + ":" + s + " " + day_or_night);
      setTimeout(function() {
          startTime()
      }, 500);
  }

  function checkTime(i)
  {
      if (i < 10)
      {
          i = "0" + i;
      }
      return i;
  }
  var find=function(e){
    //if(e.which===13) return false;
      $(".form-group").removeClass("has-error");
      $(".form-group").removeClass("has-warning");
      $(".form-group").removeClass("has-success");
      if($(e).val()!=''){
        $("#msg").html("<img height='30px' src='<?=base_url('asset/images/LTE/ajax-loader.gif') ?>'/>");
        $.ajax({
          url:"<?=base_url('talaqi/findnim')?>",
          type:'post',
          data:{nim:+$(e).val(),id:$("#id").val()},
          success:function(data){
            if(data=='duplicate'){
              $(".form-group").addClass("has-error");
              $("#msg").html("<i class='fa fa-times-circle-0'></i>NIM sudah hadir");
            }
            else if(data=='notfound'){
              $(".form-group").addClass("has-warning");
              $("#msg").html("<i class='fa fa-warning'></i>NIM tidak ditemukan");
            }else{
              $(".form-group").addClass("has-success");
              $("#msg").html("<i class='fa fa-check'></i>"+data);
            }
          }
        });
      }else{
        $("#msg").html("");
      }
  }
  var submitform=function(e){
    $("#msg").html("<img height='30px' src='<?=base_url('asset/images/LTE/ajax-loader.gif') ?>'/>");
    $(".form-group").removeClass("has-error");
    $(".form-group").removeClass("has-warning");
    $(".form-group").removeClass("has-success");
    $.ajax({
      url:$(e).attr('action'),
      data:$(e).serializeArray(),
      type:"post",
      success:function(data){
        $("#suswanto").val("");
        if(data=='success'){
          $(".form-group").addClass("has-success");
          $("#msg").html("<i class='fa fa-check'></i>Selamat Datang");
        }else{
          $(".form-group").addClass("has-error");
          $("#msg").html("<i class='fa fa-times-circle-0'></i>Terjadi kesalahan pada saat insert data");
        }
  		}
  	})
  }
 
  </script>
  <script src="<?= libraries_url('bootstrap.min.js') ?>" type="text/javascript"></script>
  <script src="<?= libraries_url('app.js') ?>" type="text/javascript"></script>
  <script src="<?= js_url('bima-script.js') ?>" type="text/javascript"></script>
  </body>
</html>