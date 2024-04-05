$(function(){
    var myModal = new bootstrap.Modal(document.getElementById('viewModal'), {
        keyboard:false, backdrop:'static', focus:true});

    $('.btnDescTable').on('click', function(){
        var id = $(this).attr('id').split('-').pop();
        var namaTable = $('#namaTable-'+id).text();
        var kapasitasTable = $('#kapasitasTable-'+id).text();
        var descTable = $('#descTable-'+id).text();
        var posisiTable = $('#posisiTable-'+id).text();
        var hargaTable = $('#hargaTable-'+id).text();
        var statusTable = $('#statusTable-'+id).text();
        
        $('#namaTableModal').text(namaTable);
        $('#deskripsiTableModal').text(descTable);
        $('#kapasitasTableModal').text(kapasitasTable);
        $('#posisiTableModal').text(posisiTable);
        $('#statusTableModal').text(statusTable);
        $('#hargaTableModal').text(hargaTable);
        myModal.show();
    });
})