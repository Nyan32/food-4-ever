$(function(){
    $('#namaLengkap').on('input', function(){
        var nama = $('#namaLengkap').val().replace(/[^a-z. ]/gi,'');
        $('#namaLengkap').val(nama);
    });
    $('#namaLengkap').on('change', function(){
        var nama = $('#namaLengkap').val().trim();
        $('#namaLengkap').val(nama);
    });

    var tempNoTelp = null;
    $('#nomorTelepon').on('input',function(){
        var noTelp = $('#nomorTelepon').val().replace(/\D/g,'');
        var noTelp = noTelp.trim();
        var noTelpLength = noTelp.length;
        if(noTelpLength>12){
            $('#nomorTelepon').val(tempNoTelp);
        }
        else{
            tempNoTelp = noTelp;
            $('#nomorTelepon').val(noTelp);
        }
    });

    $('#email').on('input', function(){
        var email = $('#email').val().toLowerCase().trim();
        $('#email').val(email);
    });

    $('#namaLengkap').on('focus', function(){
        $('#namaLengkapAlert').text('');
    });

    $('#nomorTelepon').on('focus', function(){
        $('#nomorTeleponAlert').text('');
    });

    $('#email').on('focus', function(){
        $('#emailAlert').text('');
    });

    $('#password').on('focus', function(){
        $('#passwordAlert').text('');
    });

    $('#submitBtn').on('click', function(){
        var namaLengkap = $('#namaLengkap').val();
        var nomorTelepon = $('#nomorTelepon').val();
        var email = $('#email').val();
        var password = $('#password').val();

        $.ajax({
            method:'POST',
            url:'_backprocess/postRegister.php',
            data:{
                'namaLengkap':namaLengkap,
                'nomorTelepon':nomorTelepon,
                'email':email,
                'password':password
            },
            dataType:'JSON'
        }).done(function(response){
            $('#notification').html('');
            $('#notification').removeClass('alert-success');
            $('#notification').removeClass('alert-danger');

            if(response['status']==1){
                $('#notification').html('Akun berhasil dibuat.');
                $('#notification').removeClass('alert-danger');
                $('#notification').addClass('alert-success');
                window.location.href = 'register.php#notification';
                setTimeout(function(){
                    window.location.href = 'login.php';
                }, 1500);
            }

            else if(response['status']==2){
                $('#notification').html('Email telah terdaftar. Silahkan menggunakan alamat email yang lain atau <a href="login.php">login</a>');
                $('#notification').removeClass('alert-succes');
                $('#notification').addClass('alert-danger');
                window.location.href = 'register.php#notification';
            }

            else if(response['status']==0){
                var targetError = null;

                if(response['validasi']['password']==0){
                    $('#passwordAlert').text('Field tidak boleh kosong.');
                    targetError = 'password';
                }
                else if(response['validasi']['password']==2){
                    $('#passwordAlert').text('Field harus memiliki minimal 8 karakter.');
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

                if(response['validasi']['nomorTelepon']==0){
                    $('#nomorTeleponAlert').text('Field tidak boleh kosong.');
                    targetError = 'nomorTelepon';
                }
                else if(response['validasi']['nomorTelepon']==2){
                    $('#nomorTeleponAlert').text('Field hanya menerima angka.');
                    targetError = 'nomorTelepon';
                }

                if(response['validasi']['namaLengkap']==0){
                    $('#namaLengkapAlert').text('Field tidak boleh kosong.');
                    targetError = 'namaLengkap';
                }
                else if(response['validasi']['namaLengkap']==2){
                    $('#namaLengkapAlert').text('Field hanya menerima huruf dan titik.');
                    targetError = 'namaLengkap';
                }

                window.location.href = 'register.php#'+targetError+'Label';
            }
        });
    });
})