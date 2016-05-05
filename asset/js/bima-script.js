document.onload = (function(){
    var d = new Date(); 
    $(document).on('focus','#eventDate',function(){
        $("#eventDate" ).datepicker({
            changeMonth: true,
            changeYear: true,
            showAnim : 'slideDown',
            dateFormat : 'dd-mm-yy',
            yearRange : d.getFullYear()+':'+(d.getFullYear()+1),
            minDate : '0',
        });
        // $('#datepicker').datepicker('option','yearRange','1990:'+d.getFullYear());
    });
    $(document).on('focus','#mentoringDate', function(){
        $('#mentoringDate').datepicker({
            changeMonth : true,
            changeYear : true,
            showAnim : 'slideDown',
            dateFormat : 'dd-mm-yy',
            yearRange : (d.getFullYear()-1)+':'+(d.getFullYear()+1),
            maxDate : '0'
        });
    });
    //BEGIN JQUERY NEWS UPDATE
    // $('#news-update').ticker({
    //     controls: false,
    //     titleText: ''
    // });
     //BEGIN BACK TO TOP
    $(window).scroll(function(){
        if ($(this).scrollTop() < 200) {
            $('#totop') .fadeOut();
        } else {
            $('#totop') .fadeIn();
        }
    });
    $('#totop').on('click', function(){
        $('html, body').animate({scrollTop:0}, 'fast');
        return false;
    });
    //END BACK TO TOP
    //BEGIN PORTLET
    $(".portlet").each(function(index, element) {
        var me = $(this);
        $(">.portlet-header>.tools>i", me).click(function(e){
            if($(this).hasClass('fa-chevron-up')){
                $(">.portlet-body", me).slideUp('fast');
                $(this).removeClass('fa-chevron-up').addClass('fa-chevron-down');
            }
            else if($(this).hasClass('fa-chevron-down')){
                $(">.portlet-body", me).slideDown('fast');
                $(this).removeClass('fa-chevron-down').addClass('fa-chevron-up');
            }
            else if($(this).hasClass('fa-cog')){
                //Show modal
            }
            else if($(this).hasClass('fa-refresh')){
                //$(">.portlet-body", me).hide();
                $(">.portlet-body", me).addClass('wait');

                setTimeout(function(){
                    //$(">.portlet-body>div", me).show();
                    $(">.portlet-body", me).removeClass('wait');
                }, 1000);
            }
            else if($(this).hasClass('fa-times')){
                me.remove();
            }
        });
    });
    //END PORTLET
    //BEGIN TOPBAR DROPDOWN
    $('.dropdown-slimscroll').slimScroll({
        "height": '250px',
        "wheelStep": 5
    });
    //END TOPBAR DROPDOWN

    //BEGIN TOOTLIP
    $("[data-toggle='tooltip'], [data-hover='tooltip']").tooltip();
    //END TOOLTIP

    //BEGIN POPOVER
    $("[data-toggle='popover'], [data-hover='popover']").popover();
    //END POPOVER

    $('#menu-toggle').on('click',function(e){
        e.preventDefault();
        if($('#sidebar').data('cond') == 'big')
        {
            $('#sidebar').data('cond','small');
            $('#sidebar.navbar-static-side').animate({width : '70px'},'fast');
            $('#top-navbar').animate({width : '1295px'},'slow');
            $('#content-wrapper').animate({'margin-left':'70px'},'slow');
            $('#logo img').animate({'width' : '57px', 'height' : '57px'},'slow');
            $('#logo ~ .logo-title').animate({'font-size' : '20px'}, 'slow');
            $('#logo ~ .logo-subtitle').fadeOut('fast');
            $('#side-menu .menu-title').fadeOut('fast', function(){
                $('#side-menu li a i').css('display','block').animate({'font-size' : '25px'},'slow', function(){
                    $(this).css('margin','auto');
                });
            });
        }
        else
        {
            $('#sidebar').data('cond','big');
            $('#side-menu li a i').animate({'font-size' : '16px'},'fast');
            $('#content-wrapper').animate({'margin-left':'250px'},'slow');
            $('#top-navbar').animate({width : '1115px'},'slow');
            $('#sidebar.navbar-static-side').animate({width : '250px'},'fast', function(){
                $('#logo ~ .logo-title').animate({'font-size' : '36px'}, 'slow');
                $('#side-menu .menu-title').fadeIn('slow');
                $('#logo ~ .logo-subtitle').fadeIn('slow');
            });
            $('#logo img').animate({'width' : '87px', 'height' : '87px'},'slow');
            $('#side-menu li a i').css({'display':'initial', 'margin' : '0'});
        }
    })

    if($('.modal').length != 0)
    {
        var modal = $('.modal');
        (modal.data('width-modal') != "") ? modal.children('.modal-dialog').css('width',modal.data('width-modal')) : '';
    }
    
    $('#btn-profile-edit').on('click', function(){
        $('.pass-input[name="old_pass"]').removeAttr('disabled');
        $('.pass-input[name="new_pass"]').removeAttr('disabled');
        $('.pass-input[name="conf_new_pass"]').removeAttr('disabled');
    });
    $('#btn-profile-save').on('click', function(){
        $('.pass-input[name="old_pass"]').attr('disabled','disabled');
        $('.pass-input[name="new_pass"]').attr('disabled','disabled'); 
        $('.pass-input[name="conf_new_pass"]').attr('disabled','disabled'); 
    });
    if($('button.btn-kel-edit').length > 0)
    {
        $('button[id *= "btn-kel-edit"').on('click', function(){
            var dis = $(this);
            $(dis).siblings('#btn-kel-pindah').hide(0);
            $(dis).siblings('#btn-kel-hapus').hide(0);
            $(dis).siblings('.seeable').show(0);
        });
    }
    if($('#button-kel-cancel').length > 0)
    {
        $('#button-kel-cancel').on('click', function(){
            var dis = $(this);
            $(dis).siblings('#button-kel-pindah').show(0);
            $(dis).siblings('#button-kel-hapus').show(0);
            $(dis).hide(0);
        });
    }
})();


// dipanggil jika ingin mengetahui bahwa callback itu adalah function
function isFunction(fn){
    return (fn != null && fn != "undefined" && typeof fn == "function") ? fn : false;
}

var Bima = function(){
    console.log('Init Bima');
}

Bima.prototype = {
    openWindow : function(url,type){
        window.open(url,type);
    },
    tesId : function(inp){
        var idRegx = /(#-?[_a-zA-Z]+[_a-zA-Z0-9-])\w+/g;
        var isId = false;
        return (idRegx.test(inp)) ? true : false;
    }
}

var elemEditable = {
    "element" : null,
    "editing" : false, //true or false
    "isId" : false
};

Bima.editable = function(opt)
{
    var b = new Bima();
    var optKeys = Object.keys(opt);
    for(i = 0; i < optKeys.length; i++){
        if(elemEditable.hasOwnProperty(optKeys[i]))
            elemEditable[optKeys[i]] = opt[optKeys[i]];
    }
    elemEditable.element = (elemEditable.element.tagName) ? opt.id : ((b.tesId(elemEditable.element)) ?  elemEditable.element.replace("#","") : opt); //cek element
    (elemEditable.editing) ? this.doAble() : this.doClose();
}

Bima.editable.prototype = {
    doAble : function()
    {
        $("span[editable='true']").hide('fast');
        $("h4[editable='true']").hide('fast');
        $('#' + elemEditable.element).hide('fast',function(){
            if($('input').hasClass('seeable'))
            {
                $('input.seeable').show('fast');
                $('select.seeable').show('fast');
                $('button.seeable').show('fast');
            }
        });
    },
    doClose : function()
    {
        $('select.seeable').hide('fast');
        $('input.seeable').hide('fast', function(){
            $("span[editable='true']").show('fast');
            $("h4[editable='true']").show('fast');    
        });
        $('button.seeable').hide('fast', function(){
            $('#' + elemEditable.element).show('fast');
        });
        
    }
}