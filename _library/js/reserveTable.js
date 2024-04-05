$(function(){
    $('#tanggalPesanan').on('focus click', function(){
        $('#tanggalPesananAlert').text('');
    });

    $('#persetujuan').on('focus click', function(){
        $('#persetujuanAlert').text('');
    });

    $.ajax({
        method:'GET',
        url:'_backprocess/getTableInformation.php',
        dataType:'JSON'
    }).done(function(response){
        if(response['table']['jumlah']>0){
            $('#informationTable').empty();
            $('#informationTable').append('<div><p class="m-0" style="text-decoration:underline">Harga:</p><p class="text-break text-wrap">'+response['table']['harga']+'</p></div><div><p class="m-0" style="text-decoration:underline">Kapasitas:</p><p class="text-break text-wrap">'+response['table']['kapasitas']+'</p></div><div><p class="m-0" style="text-decoration:underline">Posisi:</p><p class="text-break text-wrap">'+response['table']['posisi']+'</p></div><div><p class="m-0" style="text-decoration:underline">Deskripsi:</p><p class="text-break text-wrap">'+response['table']['deskripsi']+'</p></div>');
        }
    })

    $('#pilihMeja').on('change', function(){
        var id = $('#pilihMeja').val();
        if(id==null){
            id=0;
        }
        $.ajax({
            method:'GET',
            url:'_backprocess/getTableInformation.php',
            dataType:'JSON',
            data:{'id':id}
        }).done(function(response){
            if(response['table']['jumlah']>0){
                $('#informationTable').empty();
                $('#informationTable').append('<div><p class="m-0" style="text-decoration:underline">Harga:</p><p class="text-break text-wrap">'+response['table']['harga']+'</p></div><div><p class="m-0" style="text-decoration:underline">Kapasitas:</p><p class="text-break text-wrap">'+response['table']['kapasitas']+'</p></div><div><p class="m-0" style="text-decoration:underline">Posisi:</p><p class="text-break text-wrap">'+response['table']['posisi']+'</p></div><div><p class="m-0" style="text-decoration:underline">Deskripsi:</p><p class="text-break text-wrap">'+response['table']['deskripsi']+'</p></div>');
            }
        })
    });

    $('#reserveBtn').on('click', function(){
        var id = $('#pilihMeja').val();
        var tanggalPesanan = $('#tanggalPesanan').val();
        var persetujuan = $('#persetujuan').prop('checked');

        $.ajax({
            method:'POST',
            url:'_backprocess/postReserveNow.php',
            dataType:'JSON',
            data:{
                'id':id,
                'tanggalPesanan':tanggalPesanan,
                'persetujuan':persetujuan
            }
        }).done(function(response){
            $('#notification').html('');
            $('#notification').removeClass('alert-success');
            $('#notification').removeClass('alert-danger');
            $('#notification').removeClass('d-block');
            $('#notification').addClass('d-none');

            if(response['status']==1){
                $('#notification').html('<span>Tempat berhasil disewakan.</span>');
                $('#notification').removeClass('d-none');
                $('#notification').addClass('alert-success');
                $('#notification').addClass('d-block');

                window.location.href = 'reserveTable.php#notification';
                setTimeout(function(){
                    window.location.href = 'reserveTable.php';
                },1000)
            }

            else if(response['status']==2){
                $('#notification').html('<span>Tempat tidak tersedia. Harap memilih tempat yang tersedia.</span><button id="closeBtn" class="clean-btn btn-close-notif" style="color:inherit">Close</button>');
                $('#notification').removeClass('d-none');
                $('#notification').addClass('alert-danger');
                $('#notification').addClass('d-block');
                
                $('#closeBtn').on('click', function(){
                    $(this).parent().empty();
                    $('#notification').addClass('d-none');
                    $('#notification').removeClass('d-block');
                    $('#notification').removeClass('alert-danger');
                });
                window.location.href = 'reserveTable.php#notification';
            }

            else if(response['status']==0){
                if(response['validasi']['persetujuan']==0){
                    $('#persetujuanAlert').text('Harap menyetujui kesepakatan pelanggan');
                    window.location.href = 'reserveTable.php#persetujuanLabel';
                }

                if(response['validasi']['tanggalPesanan']==0){
                    $('#tanggalPesananAlert').text('Harap memilih tanggal');
                    window.location.href = 'reserveTable.php#tanggalPesananLabel';
                }
            }
        });
    });
})