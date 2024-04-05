$(function(){
    $('#makananBtn').on('click', function(){
        $('#contRiwayat').empty();
        $.ajax({
            method:'GET',
            url:'_backprocess/getPurchaseHistory.php',
            dataType:'JSON'
        }).done(function(response){
            if(response.length>0){
                for(var i=0;i<response.length;i++){
                    $('#contRiwayat').append('<div class="d-flex py-2 flex-wrap align-items-stretch w-100"style="border-bottom:solid 1px #aa4400"><div class="d-flex flex-column p-2 col-12 col-sm-10 col-md-11"><div class="text-wrap text-break w-100">'+response[i]['alamat']+'</div><div class="text-truncate w-100">'+response[i]['tanggal_beli']+'</div><div class="text-truncate w-100 d-inline-block">Receipt: '+response[i]['receipt_code']+'</div></div><a class="clean-btn btn-style-2 ft-white-1 p-2 receipt-btn flex-grow-1 col-12 col-sm-2 col-md-1 d-flex justify-content-center align-items-center" style="text-decoration:none; color:white !important" href="administrator/receipt/makanan/'+response[i]['filename']+'" download>Receipt</a></div>');
                }
            }
            else{
                $('#contRiwayat').append('Tidak ada riwayat pembelian.');
            }
        })
    });
    
    $('#tempatBtn').on('click', function(){
        $('#contRiwayat').empty();
        $.ajax({
            method:'GET',
            url:'_backprocess/getReserveHistory.php',
            dataType:'JSON'
        }).done(function(response){
            if(response.length>0){
                for(var i=0;i<response.length;i++){
                    $('#contRiwayat').append('<div class="d-flex py-2 flex-wrap align-items-stretch w-100"style="border-bottom:solid 1px #aa4400"><div class="d-flex flex-column p-2 col-12 col-sm-10 col-md-11 justify-content-center"><div class="text-truncate w-100">Tanggal Dipesan: '+response[i]['tanggal_dipesan']+'</div><div class="text-truncate w-100 d-inline-block">Tanggal Pemesanan: '+response[i]['tanggal']+'</div><div class="text-truncate w-100 d-inline-block">Receipt: '+response[i]['receipt_code']+'</div></div><a class="clean-btn btn-style-2 ft-white-1 p-2 receipt-btn flex-grow-1 col-12 col-sm-2 col-md-1 d-flex justify-content-center align-items-center" style="text-decoration:none; color:white !important" href="administrator/receipt/tempat/'+response[i]['filename']+'" download>Receipt</a></div>');
                }
            }
            else{
                $('#contRiwayat').append('Tidak ada riwayat pemesanan tempat.');
            }
        })
    })
})