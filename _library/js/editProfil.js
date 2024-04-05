$(function(){
    $('#alamat').overlayScrollbars({
        className: "os-theme-dark"
    });  
    $('#namaLengkap').on('input', function(){
        var nama = $('#namaLengkap').val().replace(/[^a-z. ]/gi,'');
        $('#namaLengkap').val(nama);
    });
    $('#namaLengkap').on('change', function(){
        var nama = $('#namaLengkap').val().trim();
        $('#namaLengkap').val(nama);
    });

    $('#alamat').on('input', function(){
        var alamat = $('#alamat').val().replace(/[^a-z0-9.\- \/,]/gi,'');
        alamat = alamat.toUpperCase();
        $('#alamat').val(alamat);
    });
    $('#alamat').on('change', function(){
        var alamat = $('#alamat').val().trim();
        alamat = alamat.toUpperCase();
        $('#alamat').val(alamat);
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

    $('#alamat').on('focus', function(){
        $('#alamatAlert').text('');
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

    $('#ubahFotoProfil').on('click', function(){
        $('#fotoFileSubmit').trigger('click');
    });

    $('#hapusFotoProfil').on('click', function(){
        $(this).val('');
        $("#imgProfilReview").attr('src', 'administrator/img/profil/no-photo.png');
        $('#imgStatus').val('2');
    });

    $('#fotoFileSubmit').on('change', function(e){
        var savedImg = $('#imgStatus').attr('data-imageProfil');
        if(!$(this).val()){
            $("#imgProfilReview").attr('src', 'administrator/img/profil/'+savedImg);
            $('#imgStatus').val('0');
        }
        else{
            var allowedExt = ['jpg', 'jpeg', 'png'];
            var filename = $(this)[0].files[0].name;
            var ext = filename.split('.').pop();
            if(allowedExt.indexOf(ext)!==-1){
                $('#imgStatus').val('1');
                var tmpPath = URL.createObjectURL(e.target.files[0]);
                $("#imgProfilReview").attr('src', tmpPath); 
            }
            else{
                $(this).val('');
                $("#imgProfilReview").attr('src', 'administrator/img/profil/'+savedImg);
                $('#imgStatus').val('0');
            }
        }
    });

    $('#saveEditBtn').on('click', function(){
        var namaLengkap = $('#namaLengkap').val();
        var nomorTelepon = $('#nomorTelepon').val();
        var email = $('#email').val();
        var password = $('#password').val();
        var file = $('#fotoFileSubmit')[0].files[0];
        var imgStatus = $('#imgStatus').val();
        var alamat = $('#alamat').val();

        var formData = new FormData();

        formData.append('namaLengkap',namaLengkap);
        formData.append('nomorTelepon',nomorTelepon);
        formData.append('email',email);
        formData.append('password',password);
        formData.append('gambarProfil',file);
        formData.append('imgStatus',imgStatus);
        formData.append('alamat',alamat);
        $.ajax({
            method:'POST',
            url:'_backprocess/postEditProfile.php',
            dataType:'JSON',
            contentType:false,
            processData:false,
            cache:false,
            data:formData
        }).done(function(response){
            $('#notification').html('');
            $('#notification').removeClass('alert-success');
            $('#notification').removeClass('alert-danger');
            $('#notification').removeClass('d-block');
            $('#notification').addClass('d-none');

            if(response['status']==1){
                $('#notification').html('<span>Informasi berhasil diubah</span><button id="closeBtn" class="clean-btn btn-close-notif" style="color:inherit">Close</button>');
                $('#notification').removeClass('d-none');
                $('#notification').addClass('alert-success');
                $('#notification').addClass('d-block');
               
                $('#closeBtn').on('click', function(){
                    $(this).parent().empty();
                    $('#notification').addClass('d-none');
                    $('#notification').removeClass('d-block');
                    $('#notification').removeClass('alert-success');
                });
                window.location.href = 'editProfil.php#notification';
                $.ajax({
                    method:'GET',
                    url:'_backprocess/getPhotoAfterEdit.php',
                    dataType:'JSON'
                }).done(function(response){
                    $('#fotoProfilHor').attr('src','administrator/img/profil/'+response['gambar_profil']);
                    $('#fotoProfilVer').attr('src','administrator/img/profil/'+response['gambar_profil']);
                    $('#imgProfilReview').attr('src', 'administrator/img/profil/'+response['gambar_profil']);
                    $('#imgStatus').attr('data-imageProfil', response['gambar_profil']);
                });
            }

            else if(response['status']==2){
                $('#notification').html('<span>Harap menggunakan email yang lain</span><button id="closeBtn" class="clean-btn btn-close-notif" style="color:inherit">Close</button>');
                $('#notification').removeClass('d-none');
                $('#notification').addClass('alert-danger');
                $('#notification').addClass('d-block');
                
                $('#closeBtn').on('click', function(){
                    $(this).parent().empty();
                    $('#notification').addClass('d-none');
                    $('#notification').removeClass('d-block');
                    $('#notification').removeClass('alert-danger');
                });
                window.location.href = 'editProfil.php#notification';
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

                if(response['validasi']['alamat']==2){
                    $('#alamatAlert').text('Field menerima format alamat yang baik dan benar.');
                    targetError = 'alamat';
                }

                if(response['validasi']['namaLengkap']==0){
                    $('#namaLengkapAlert').text('Field tidak boleh kosong.');
                    targetError = 'namaLengkap';
                }
                else if(response['validasi']['namaLengkap']==2){
                    $('#namaLengkapAlert').text('Field hanya menerima huruf dan titik.');
                    targetError = 'namaLengkap';
                }

                window.location.href = 'editProfil.php#'+targetError+'Label';
            }
        });
    });
})