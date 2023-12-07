$(function(){
    $('#sehir').on('change', function(){
        var plakaKodu = $(this).val();
        if(plakaKodu){
            $.post('sayfalar/ilanlar/il_ilce.php', {'plakaKodu': plakaKodu}, function(response){
                $('#ilce').html(response).removeAttr('disabled');
            });
        }else{
            $('#ilce').html('<option>- İlçe Seçin -</option>').attr('disabled', 'disabled');
        }
    });
});


