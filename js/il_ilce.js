$(function(){
    $('#sehir').on('change', function(){
        var plakaKodu = $(this).val();
        if(plakaKodu){
            $.post('il_ilce.php', {'plakaKodu': plakaKodu}, function(response){
                $('#ilce').html(response).removeAttr('disabled');
            });
        }else{
            $('#ilce').html('<option>- İlçe Seçin -</option>').attr('disabled', 'disabled');
        }
    });
});
$(function(){
    $('#kurumsal_city').on('change', function(){
        var plakaKodu = $(this).val();
        if(plakaKodu){
            $.post('il_ilce.php', {'plakaKodu': plakaKodu}, function(response){
                $('#kurumsal_ilce').html(response).removeAttr('disabled');
            });
        }else{
            $('#kurumsal_ilce').html('<option>- İlçe Seçin -</option>').attr('disabled', 'disabled');
        }
    });
});


