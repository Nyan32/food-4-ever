$(function(){
    $('#alamat').on('input', function(){
        $('#alamat').overlayScrollbars({
            className: "os-theme-dark"
        });

        var alamat = $('#alamat').val().replace(/[^a-z0-9.\- \/,]/gi,'');
        alamat = alamat.toUpperCase();
        $('#alamat').val(alamat);
    });
    $('#alamat').on('change', function(){
        var alamat = $('#alamat').val().trim();
        alamat = alamat.toUpperCase();
        $('#alamat').val(alamat);
    });
    
    $('#alamat').on('focus', function(){
        $('#alamatAlert').text('');
    });
    
    $('#dataAlamatBtn').on('click', function(){
        $.ajax({
            method:'GET',
            url:'_backprocess/getSavedAddress.php',
            dataType:'JSON'
        }).done(function(response){
            $('#alamat').val(response['alamat']);
        }); 
    });

    $('#orderNowBtn').on('click', function(){
        var alamat = $('#alamat').val();
        $.ajax({
            method:'POST',
            url:'_backprocess/postOrderNow.php',
            dataType:'JSON',
            data:{
                'alamat':alamat
            }
        }).done(function(response){
            $('#notification').html('');
            $('#notification').removeClass('alert-success');
            $('#notification').removeClass('alert-danger');
            $('#notification').removeClass('d-block');
            $('#notification').addClass('d-none');

            if(response['status']==1){
                $('#notification').html('Pesanan telah terkirim.');
                $('#notification').removeClass('d-none');
                $('#notification').removeClass('alert-danger');
                $('#notification').addClass('alert-success');
                $('#notification').addClass('d-block');
                window.location.href = 'checkout.php#notification';
                setTimeout(function(){
                    window.location.href = 'index.php';
                }, 1500);
            }

            else if(response['status']==2){
                $('#notification').html('Tidak ada pesanan yang ditambahkan.');
                $('#notification').removeClass('d-none');
                $('#notification').removeClass('alert-succes');
                $('#notification').addClass('alert-danger');
                $('#notification').addClass('d-block');
                window.location.href = 'checkout.php#notification';
            }

            else if(response['status']==0){
                var targetError = null;
                if(response['validasi']['alamat']==0){
                    $('#alamatAlert').text('Field tidak boleh kosong.');
                    targetError = 'alamat';
                }
                else if(response['validasi']['alamat']==2){
                    $('#alamatAlert').text('Field menerima format alamat yang baik dan benar.');
                    targetError = 'alamat';
                }
                window.location.href = 'checkout.php#'+targetError+'Label';
            }
        })
    })
})
