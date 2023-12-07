$(function(){
    $('#teklifler').on('change', function(){
        var teklif = $(this).val();
        if(teklif){
            $.post('sayfalar/ilanlar/teklif_bul.php', {'teklif': teklif}, function(response){
                $('#kazandigi_tutar').val(response.teklif) ;
            },'json');
        }else{
            $('#kazandigi_tutar').val() = "";
        }
    });
});


