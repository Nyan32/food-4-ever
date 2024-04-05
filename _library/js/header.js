$(function(){
    var toggleHeader = false;
    $('#toggleMenuBtn').on('click', function(){
        $('#menuContVer').slideToggle();
        if(toggleHeader == false){
            $('#toggleIconHeader').removeClass('icon-header-close');
            $('#toggleIconHeader').addClass('icon-header-open');
            toggleHeader = true;
        }
        else if(toggleHeader == true){
            $('#toggleIconHeader').removeClass('icon-header-open');
            $('#toggleIconHeader').addClass('icon-header-close');
            toggleHeader = false;
        }
    });

    $('.pesanMenuBtn').on('click', function(){
        window.location.href = 'index.php';
    });

    $('.pesanTempatBtn').on('click', function(){
        window.location.href = 'reserveTable.php';
    });

    $('.aboutUsBtn').on('click', function(){
        window.location.href = 'aboutUs.php';
    });

    $('.calllUsBtn').on('click', function(){
        window.location.href = 'callUs.php';
    })

    $(window).on('resize', function(){
        $('#menuContVer').attr('style','display:none');
        $('#toggleIconHeader').removeClass('icon-header-open');
        $('#toggleIconHeader').addClass('icon-header-close');
        toggleHeader = false;
    });

    $('.loginBtn').on('click', function(){
        window.location.href = 'login.php';
    });

    $('.profilBtn').on('click', function(){
        window.location.href = 'profil.php';
    });

    $('#homeBtn').on('click', function(){
        window.location.href = 'index.php';
    });
});