$(function(){
    $('#restoranBtn').on('click', function(){
        $('#restoranCont').addClass('d-flex');
        $('#developerCont').addClass('d-none');
        $('#restoranCont').removeClass('d-none');
        $('#developerCont').removeClass('d-flex');
    })

    $('#devBtn').on('click', function(){
        $('#developerCont').addClass('d-flex');
        $('#restoranCont').addClass('d-none');
        $('#developerCont').removeClass('d-none');
        $('#restoranCont').removeClass('d-flex');
    })
})