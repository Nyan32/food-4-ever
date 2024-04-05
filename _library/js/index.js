$(function(){
    $('#kategoriContainerFull').overlayScrollbars({
        className: "os-theme-dark"
    });
    $('#kategoriMinList').overlayScrollbars({
        className: "os-theme-dark"
    });
    $('#modalDiaCont').overlayScrollbars({
        className: "os-theme-dark"
    });
    

    $.ajax({
        method:'GET',
        url:'_backprocess/getContentListMenu.php',
        dataType:'JSON'
    }).done(function(response){
        if(response['menu'].length>0){
            $('#titleKategori').text(response['menu'][0]['nama_kategori']);
            $('#menuContainer').empty();
            showMenu('#menuContainer', response);
        }
    });

    $('#checkOutBtn').on('click', function(){
        window.location.href = 'checkout.php';
    });

    var isCloseListMin = true;
    $('.kategoriBtn').on('click', function(){
        var id = $(this).attr('data-idKategori');
        $('#kategoriMinList').removeClass('open-kategori-min');
        $('#kategoriMinList').removeClass('d-block');
        $('#kategoriMinList').removeClass('overflow-auto');
        $('#kategoriMinList').addClass('close-kategori-min');
        $('#kategoriMinList').addClass('overflow-hidden');
        setTimeout(function(){
            $('#kategoriMinList').addClass('d-none');
        },500);
        isCloseListMin = true;
        
        $.ajax({
            method:'GET',
            url:'_backprocess/getContentListMenu.php',
            dataType:'JSON',
            data:{'katID':id}
        }).done(function(response){
            if(response['menu'].length>0){
                $('#titleKategori').text(response['menu'][0]['nama_kategori']);
                $('#menuContainer').empty();
                showMenu('#menuContainer', response);
            }
        }).always(function(){
            window.location.href = 'index.php#titleKategoriScroll';
        });
    });

    $('#kategoriListBtn').on('click', function(){
        if(isCloseListMin==true){
            $('#kategoriMinList').removeClass('close-kategori-min');
            $('#kategoriMinList').removeClass('d-none');
            $('#kategoriMinList').addClass('d-block');
            $('#kategoriMinList').addClass('open-kategori-min');
            setTimeout(function(){
                $('#kategoriMinList').removeClass('overflow-hidden');
                $('#kategoriMinList').addClass('overflow-auto');
            },500);
            isCloseListMin = false;
        }
        else if(isCloseListMin==false){
            $('#kategoriMinList').removeClass('open-kategori-min');
            $('#kategoriMinList').removeClass('d-block');
            $('#kategoriMinList').removeClass('overflow-auto');
            $('#kategoriMinList').addClass('close-kategori-min');
            $('#kategoriMinList').addClass('overflow-hidden');
            setTimeout(function(){
                $('#kategoriMinList').addClass('d-none');
            },500);
            isCloseListMin = true;
        }
    });

    $(window).on('resize', function(){
        $('#kategoriMinList').removeClass('close-kategori-min');
        $('#kategoriMinList').removeClass('open-kategori-min');
        $('#kategoriMinList').removeClass('d-block');
        $('#kategoriMinList').addClass('d-none');
        isCloseListMin = true;
    });
})

function showMenu(target,response){
    var myModal = new bootstrap.Modal(document.getElementById('viewModal'), {
        keyboard:false, backdrop:'static'});
        
    for(var i=0;i<response['menu'].length;i++){
        if(response['pesanan_sementara']==null){
            ammount = 0;
        }
        else{
            var ammount = response['pesanan_sementara'][response['menu'][i]['id']];
            if (ammount == null){
                ammount = 0;
            }
        }
        $(target).append('<div class="bg-light border d-flex flex-column menu-card" style="min-height: 270px;"><div class="p-2" style="height:121px;"><img id="imgMenu-'+response['menu'][i]['id']+'" class="card-img-menu" src="administrator/img/menu/'+response['menu'][i]['gambar_makanan']+'"/></div><hr class="m-0"><div class="card-menu-body flex-grow-1 p-2"><div id="namaMenu-'+response['menu'][i]['id']+'" class="text-center text-wrap text-break">'+response['menu'][i]['nama_makanan']+'</div><div id="hargaMenu-'+response['menu'][i]['id']+'" class="text-center">'+response['menu'][i]['harga_makanan']+'</div><div id="deskMenu-'+response['menu'][i]['id']+'" hidden>'+response['menu'][i]['deskripsi_makanan']+'</div></div><div class="card-menu-footer w-100"><div class="w-100 text-center"><button id="deskMenuBtn-'+response['menu'][i]['id']+'" class="clean-btn p-2 btn-detail">Detail</button></div><div class="d-flex justify-content-between w-100"><button id="substractBtn-'+response['menu'][i]['id']+'" class="clean-btn btn-style-1"><</button><input id="valueInput-'+response['menu'][i]['id']+'" type="text" class="flex-shrink-1 w-100 text-center value-input input-text" value="'+ammount+'" style="font-size:1em"/><button id="addBtn-'+response['menu'][i]['id']+'" class="clean-btn btn-style-1">></button></div></div></div>');

        $('#deskMenuBtn-'+response['menu'][i]['id']).on('click', function(){
            var id = $(this).attr('id').split('-').pop();
            var srcImg = $('#imgMenu-'+id).attr('src');
            var namaMenu = $('#namaMenu-'+id).text();
            var descMenu = $('#deskMenu-'+id).text();
            var hargaMenu = $('#hargaMenu-'+id).text();
            
            $('#gambarMakananModal').attr('src', srcImg);
            $('#namaMakananModal').text(namaMenu);
            $('#deskripsiMakananModal').text(descMenu);
            $('#hargaMakananModal').text(hargaMenu);
            myModal.show();
        });

        $('.value-input').on('input',function(){
            var ammount = $(this).val().replace(/\D/g,'');
            var ammount = ammount.trim();
            $(this).val(ammount);
        });

        $('#valueInput-'+response['menu'][i]['id']).on('change', {'id':response['menu'][i]['id']}, function(event){
            var id = event.data.id;
            var ammount = $(this).val();
            $.ajax({
                method:'POST',
                url:'_backprocess/postPesananSementara.php',
                data:{
                    'id':id,
                    'ammount':ammount
                }
            });
        });

        var delaySubstract = null;
        $('#substractBtn-'+response['menu'][i]['id']).on('click',{'id':response['menu'][i]['id']},function(event){
            clearTimeout(delaySubstract);
            var id = event.data.id;
            var value = $('#valueInput-'+id).val();
            if(value==''){
                value = 0;
            }

            if(isNaN(value)){
                $('#valueInput-'+id).val('0');
            }
            else{
                value = parseInt(value);
                if(value>0){
                    value = value-1;
                }
                $('#valueInput-'+id).val(value);
            }

            delaySubstract = setTimeout(function(){
                $('#valueInput-'+id).trigger('change');
            }, 300);
        })

        var delayAdd = null;
        $('#addBtn-'+response['menu'][i]['id']).on('click',{'id':response['menu'][i]['id']},function(event){
            clearTimeout(delayAdd);
            var id = event.data.id;
            var value = $('#valueInput-'+id).val();
            if(value==''){
                value = 0;
            }

            if(isNaN(value)){
                $('#valueInput-'+id).val('0');
            }
            else{
                value = parseInt(value)+1;
                $('#valueInput-'+id).val(value);
            }
            delayAdd = setTimeout(function(){
                $('#valueInput-'+id).trigger('change');
            }, 300);
        })
    }
}