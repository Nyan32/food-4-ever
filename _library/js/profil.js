$(function(){
    $('#logoutBtn').on('click', function(){
        $.ajax({
            method:'POST',
            url:'_backprocess/postLogout.php'
        }).done(function(){
            window.location.href = 'login.php';
        });
    });

    $('#editBtn').on('click', function(){
        window.location.href = 'editProfil.php';
    });

    $('#historyBtn').on('click', function(){
        window.location.href = 'history.php';
    });
})