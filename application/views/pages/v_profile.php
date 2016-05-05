<div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
    <div class="page-header pull-left">
        <div class="page-title">Profile Page</div>
    </div>
    <ol class="breadcrumb page-breadcrumb pull-right">
        <li><i class="fa fa-home"></i>&nbsp;<a href="<?= base_url();?>">Dashboard</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
        <li class="active">Profile</li>
    </ol>
    <div class="clearfix">
    </div>
</div>
<!-- Main content -->
<section class="content" id="content-profile">
    <div class="portlet box portlet-trans">
        <div class="portlet-body">
            <form method="post" class="form-seeable" id="form">
                <div class="row">
                    <div class="col-md-12 text-right">
                    	<input type="submit" class="btn btn-bima btn-primary seeable" id="btn-profile-save" onclick="saveUpdate(); return false;" value="Simpan" tabindex="8"/>   
                        <button class="btn btn-bima btn-danger seeable" onclick="new Bima.editable({element: '#btn-profile-edit', editing: false}); return false" id="btn-profile-save" tabindex="9">Cancel</button>
                        <button class="btn btn-bima btn-primary" onclick="new Bima.editable({element : '#btn-profile-edit', editing : true}); return false;" id="btn-profile-edit" >Edit</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3 text-center">
                        <div class="row">
                            <div class="col-md-12">
                                <img src="<?= (strtoupper($this->session->userdata('jk'))=='I') ? img_url('profile/avatar-sibima03.png') : img_url('profile/avatar-sibimi01.png')?>" class="profpic">
                            </div>
                        </div>

                    </div>
                    <?php if($this->session->userdata('role')!='admin'): ?>
                    <div class="col-lg-9">
                        <div class="row">
                            <div class="col-lg-5">
                                <H4>NIM:</H4><h4><?=$nim?></h4>
                                <H4>NAMA:</H4>
                                    <h4 editable="true"><?=$nama?></h4>
                                    <input type="text" value="<?=$nama?>" name="nama" class="seeable" tabindex="1">
                                <?php if($this->session->userdata('role') == 'mentee') : ?>
                                <H4>JURUSAN:</H4>
                                    <h4 editable="true"><?=$jurusan?></h4>
                                    <input type="text" class="seeable" name="jurusan" value="<?=$jurusan?>" tabindex="3">
                                    <h4 editable="true"><?=$kelas?></h4>
                                    <input type="text" class="seeable" name="kelas" value="<?=$kelas?>" tabindex="4">
                                <?php endif; ?>
                                <H4>NO. TELP:</H4>
                                    <h4 editable="true"><?=$telp?></h4>
                                    <input type="text" value="<?=$telp?>" name="telp" class="seeable" tabindex="1">
                            </div>
                            <div class="col-lg-6">
                               <H4>CHANGE PASSWORD</H4>
                               <div class="col-lg-6"> 
                                    <div class="control-group">
                                        <span class="text-group">Old Password:</span>
                                            <div class="form-group">
                                                <input type="password" name="old_pass" class="pass-input" disabled="disabled" id="p" tabindex="5">
                                            </div>
                                    </div>
                                    <div class="control-group">
                                        <span class="text-group">New Password:</span>
                                            <div class="form-group disabled">
                                            <input type="password" name="new_pass" class="pass-input" disabled="disabled" id="np" tabindex="6">
                                            </div>
                                    </div>
                                    <div class="control-group">
                                        <span class="text-group">Confirm New Password:</span>
                                            <div class="form-group disabled">
                                              <input type="password" name="new_pass" class="pass-input" disabled="disabled" id="cnp" tabindex="6">
                                            </div>
                                    </div>
                                </div> 
                            </div>

                                <div class="alert hidden" id="alert"></div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                </div>

                </div>
            </form>
        </div>
    </div>
</section>
<script>
    var saveUpdate = function()
    {

        if(($("#p").val()!='')&&($("#np").val()!=$("#cnp").val())){
            alert('Confirmasi password tidak sesuai');
            return false;
        }else{
            $.ajax({
                url:"<?=base_url('profile/edit')?>",
                type:'post',
                data:$("#form").serialize(),
                success:function(data){
                    var msg = '';
                    var location = 'profile';
                    if(data=='"profile"')
                        msg = 'Profil berhasil dirubah';
                    else if(data == '"password"'){
                        location = 'auth/logout';
                        msg = 'Password anda telah berhasil dirubah';
                    }
                    else if(data == '"passfail"')
                        msg = 'Password lama yang anda masukkan salah';
                    else if(data == '"fail"')
                        msg = 'Maaf, ada kesalahan saat pengubahan data';
                    alert(msg);
                    window.setTimeout(function(){
                        document.location.href="<?=base_url('"+location+"')?>";
                    },500);
                }
            })
        }
    }
</script>