$(function(){
    $('#email').on('input', function(){
        var email = $('#email').val().toLowerCase().trim();
        $('#email').val(email);
    });

    $('#email').on('focus', function(){
        $('#emailAlert').text('');
    });

    $('#password').on('focus', function(){
        $('#passwordAlert').text('');
    });

    $('#btnLogin').on('click', function(){
        var email = $('#email').val();
        var password = $('#password').val();
        $.ajax({
            method:'POST',
            url:'_backprocess/postLogin.php',
            data:{
                'email':email,
                'password':password
            },
            dataType:'JSON'
        }).done(function(response){
            $('#notification').html('');
            $('#notification').removeClass('alert-success');
            $('#notification').removeClass('alert-danger');
            if(response['status']==1){
                $('#notification').html('Login berhasil, sedang pindah ke halaman utama.');
                $('#notification').removeClass('alert-danger');
                $('#notification').addClass('alert-success');
                window.location.href = 'login.php#notification';
                setTimeout(function(){
                    window.location.href = 'index.php';
                }, 1500);
            }
            else if(response['status']==2){
                $('#notification').html('Email atau password salah. Silahkan coba lagi atau <a href="register.php">daftar</a>');
                $('#notification').removeClass('alert-succes');
                $('#notification').addClass('alert-danger');
                window.location.href = 'login.php#notification';
            }
            else if(response['status']==0){
                var targetError = null;

                if(response['validasi']['password']==0){
                    $('#passwordAlert').text('Field tidak boleh kosong.');
                    targetError = 'password';
                }

                if(response['validasi']['email']==0){
                    $('#emailAlert').text('Field tidak boleh kosong.');
                    targetError = 'email';
                }
                else if(response['validasi']['email']==2){
                    $('#emailAlert').text('Field hanya menerima format email yang umum. Contoh: john.doe@company.co.md');
                    targetError = 'email';
                }

                window.location.href = 'login.php#'+targetError+'Label';
            }
        });
    });
});