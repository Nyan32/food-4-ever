$(function(){
    $('#gambarFotoBtn').on('click', function(){
        $('#gambarFoto').trigger('click');
    });

    $('#gambarFoto').on('change', function(e){
        if(!$(this).val()){
            $("#imageReview").fadeIn("fast").attr('src', 'img/kategori_menu/non.png');
            $('#gambarFotoName').val('');
        }
        else{
            var allowedExt = ['jpg', 'jpeg', 'png'];
            var filename = $('#gambarFoto')[0].files[0].name;
            var ext = filename.split('.').pop();
            if(allowedExt.indexOf(ext)!==-1){
                $('#gambarFotoName').val(filename); 
                var tmpPath = URL.createObjectURL(e.target.files[0]);
                $("#imageReview").attr('src', tmpPath); 
            }
            else{
                $('#gambarFoto').val('');
                $('#gambarFotoName').val('Invalid');
                setTimeout(function(){
                    $('#gambarFotoName').val('');
                },1000);
                $("#imageReview").attr('src', 'img/kategori_menu/non.png');
            }
        }
    });
    
    $('#deleteGambarBtn').on('click', function(){
        $('#gambarFoto').val('');
        $('#gambarFotoName').val('Dihapus');
        setTimeout(function(){
            $('#gambarFoto').trigger('change');
        },1000);
    });
})