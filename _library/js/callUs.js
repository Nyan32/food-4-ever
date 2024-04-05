$(function(){
    $('#masukkan').overlayScrollbars({
        className: "os-theme-dark"
    });  
    
    $('#kirimFeed').on('click', function(){
        var masukkan = $('#masukkan').val().trim();

        $('#masukkan').on('focus', function(){
            $('#masukkanAlert').text('');
        });

        $.ajax({
            method:'POST',
            url:'_backprocess/postFeedback.php',
            dataType:'JSON',
            data:{
                'masukkan':masukkan
            }
        }).done(function(response){
            $('#masukkan').val('');
            $('#notification').html('');
            $('#notification').removeClass('alert-success');
            $('#notification').removeClass('alert-danger');
            $('#notification').removeClass('d-block');
            $('#notification').addClass('d-none');

            if(response['status']==1){
                $('#notification').html('<span>Masukkan berhasil dikirimkan.</span><button id="closeBtn" class="clean-btn btn-close-notif" style="color:inherit">Close</button>');
                $('#notification').removeClass('d-none');
                $('#notification').addClass('alert-success');
                $('#notification').addClass('d-block');
               
                $('#closeBtn').on('click', function(){
                    $(this).parent().empty();
                    $('#notification').addClass('d-none');
                    $('#notification').removeClass('d-block');
                    $('#notification').removeClass('alert-success');
                });
                window.location.href = 'callUs.php#notification';
            }

            else if(response['status']==2){
                $('#notification').html('<span>Terjadi kesalahan.</span><button id="closeBtn" class="clean-btn btn-close-notif" style="color:inherit">Close</button>');
                $('#notification').removeClass('d-none');
                $('#notification').addClass('alert-danger');
                $('#notification').addClass('d-block');
                
                $('#closeBtn').on('click', function(){
                    $(this).parent().empty();
                    $('#notification').addClass('d-none');
                    $('#notification').removeClass('d-block');
                    $('#notification').removeClass('alert-danger');
                });
                window.location.href = 'callUs.php#notification';
            }

            else if(response['status']==0){
                if(response['validasi']['masukkan']==0){
                    $('#masukkanAlert').text('Field tidak boleh kosong.');
                }

                window.location.href = 'callUs.php#masukkanLabel';
            }
        })
    });
})