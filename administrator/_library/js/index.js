$(function(){
    var myModal = new bootstrap.Modal(document.getElementById('viewModal'), {
        keyboard:false, backdrop:'static', focus:true});

    $('.btn-category').on('click', function(){
        var id = $(this).attr('id').split('-').pop();
        if($('#menu-list-'+id).attr('data-isActive')=='true'){
            $('#menu-list-'+id).slideUp(300);
            $('#menu-list-'+id).attr('data-isActive', 'false');
            $('#iconArrow-'+id).removeClass('arrow-up');
            $('#iconArrow-'+id).addClass('arrow-down');
        }
        else if($('#menu-list-'+id).attr('data-isActive')=='false'){
            $('#menu-list-'+id).slideDown(300);
            $('#menu-list-'+id).attr('data-isActive', 'true');
            $('#iconArrow-'+id).removeClass('arrow-down');
            $('#iconArrow-'+id).addClass('arrow-up');
        }
    });
    $('.btnDescMenu').on('click', function(){
        var id = $(this).attr('id').split('-').pop();
        var srcImg = $('#imgMenu-'+id).attr('src');
        var namaMenu = $('#namaMenu-'+id).text();
        var descMenu = $('#descMenu-'+id).text();
        var hargaMenu = $('#hargaMenu-'+id).text();
        
        $('#gambarMakananModal').attr('src', srcImg);
        $('#namaMakananModal').text(namaMenu);
        $('#deskripsiMakananModal').text(descMenu);
        $('#hargaMakananModal').text(hargaMenu);
        myModal.show();
    });
})