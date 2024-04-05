$(function(){
    $('#namaMakanan').on('input', function(){
        var nama = $('#namaMakanan').val().replace(/[^0-9a-z\- ]/gi,'');
        $('#namaMakanan').val(nama);
    });
    $('#namaMakanan').on('change', function(){
        var nama = $('#namaMakanan').val().trim();
        $('#namaMakanan').val(nama);
    });

    $('#hargaMakanan').on('input',function(){
        var harga = $('#hargaMakanan').val().replace(/\D/g,'');
        $('#hargaMakanan').val(harga.trim());
    });

    $('#gambarMakananBtn').on('click', function(){
        $('#gambarMakanan').trigger('click');
    });

    $('#gambarMakanan').on('change', function(e){
        if(!$(this).val()){
            if($('#photoStatus').val()!=1){
                $("#imageReview").fadeIn("fast").attr('src', 'img/menu/non.png');
                $('#gambarMakananName').val('');
            }
        }
        else{
            var allowedExt = ['jpg', 'jpeg', 'png'];
            var filename = $('#gambarMakanan')[0].files[0].name;
            var ext = filename.split('.').pop();
            if(allowedExt.indexOf(ext)!==-1){
                $('#gambarMakananName').val(filename); 
                var tmpPath = URL.createObjectURL(e.target.files[0]);
                $("#imageReview").attr('src', tmpPath); 
            }
            else{
                $('#gambarMakanan').val('');
                $('#gambarMakananName').val('Invalid');
                setTimeout(function(){
                    if($('#photoStatus').val()!=1){
                        $('#gambarMakananName').val('');
                    }
                    else{
                        $('#gambarMakananName').val($('#photoStatus').attr('data-image'));
                    }
                },1000);
                if($('#photoStatus').val()!=1){
                    $("#imageReview").attr('src', 'img/menu/non.png');
                } 
            }
        }
        
    });
    $('#deleteGambarBtn').on('click', function(){
        $('#gambarMakanan').val(''); 
        $('#photoStatus').val('0');
        $('#gambarMakananName').val('Dihapus');
        setTimeout(function(){
            $('#gambarMakanan').trigger('change');
        },1000);
    });

    $('#photoStatus').on('change', function(){
        if($('#photoStatus').val()==0){
            $("#imageReview").attr('src', 'img/menu/non.png');
        }  
        else if($('#photoStatus').val()==1){
            var serverImg = $('#photoStatus').attr('data-image');
            $("#imageReview").attr('src', 'img/menu/'+serverImg);
        } 
    })
})