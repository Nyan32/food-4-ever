$(function(){
    $('#namaKategori').on('input', function(){
        var nama = $('#namaKategori').val().replace(/[^0-9a-z\- ]/gi,'');
        $('#namaKategori').val(nama);
    });
    $('#namaKategori').on('change', function(){
        var nama = $('#namaKategori').val().trim();
        $('#namaKategori').val(nama);
    });

    $('#gambarKategoriBtn').on('click', function(){
        $('#gambarKategori').trigger('click');
    });

    $('#gambarKategori').on('change', function(e){
        if(!$(this).val()){
            if($('#photoStatus').val()!=1){
                $("#imageReview").fadeIn("fast").attr('src', 'img/kategori_menu/non.png');
                $('#gambarKategoriName').val('');
            }
        }
        else{
            var allowedExt = ['jpg', 'jpeg', 'png'];
            var filename = $('#gambarKategori')[0].files[0].name;
            var ext = filename.split('.').pop();
            if(allowedExt.indexOf(ext)!==-1){
                $('#gambarKategoriName').val(filename); 
                var tmpPath = URL.createObjectURL(e.target.files[0]);
                $("#imageReview").attr('src', tmpPath); 
            }
            else{
                $('#gambarKategori').val('');
                $('#gambarKategoriName').val('Invalid');
                setTimeout(function(){
                    if($('#photoStatus').val()!=1){
                        $('#gambarKategoriName').val('');
                    }
                    else{
                        $('#gambarKategoriName').val($('#photoStatus').attr('data-image'));
                    }
                },1000);
                if($('#photoStatus').val()!=1){
                    $("#imageReview").attr('src', 'img/kategori_menu/non.png');
                } 
            }
        }
        
    });
    $('#deleteGambarBtn').on('click', function(){
        $('#gambarKategori').val(''); 
        $('#photoStatus').val('0');
        $('#gambarKategoriName').val('Dihapus');
        setTimeout(function(){
            $('#gambarKategori').trigger('change');
        },1000);
    });

    $('#photoStatus').on('change', function(){
        if($('#photoStatus').val()==0){
            $("#imageReview").attr('src', 'img/kategori_menu/non.png');
        }  
        else if($('#photoStatus').val()==1){
            var serverImg = $('#photoStatus').attr('data-image');
            $("#imageReview").attr('src', 'img/kategori_menu/'+serverImg);
        } 
    })
})