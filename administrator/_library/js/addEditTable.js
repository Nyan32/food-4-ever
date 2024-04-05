$(function(){
    $('#namaTable').on('input', function(){
        var nama = $('#namaTable').val().replace(/[^0-9a-z\- ]/gi,'');
        $('#namaTable').val(nama);
    });
    $('#namaTable').on('change', function(){
        var nama = $('#namaTable').val().trim();
        $('#namaTable').val(nama);
    });

    $('#kapasitasTable').on('input',function(){
        var harga = $('#kapasitasTable').val().replace(/\D/g,'');
        $('#kapasitasTable').val(harga.trim());
    });

    $('#hargaTable').on('input',function(){
        var harga = $('#hargaTable').val().replace(/\D/g,'');
        $('#hargaTable').val(harga.trim());
    });

    $('#posisiTable').on('change', function(){
        var posTable = $('#posisiTable').val().trim();
        $('#posisiTable').val(posTable);
    });

    $('#deskripsiTable').on('change', function(){
        var posTable = $('#deskripsiTable').val().trim();
        $('#deskripsiTable').val(posTable);
    });
})