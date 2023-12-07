$(function(){
    $('#marka').on('change', function(){
        var modeladi = $(this).val();
        if(modeladi){
            $.post('marka_model.php', {'modeladi': modeladi}, function(response){
                $('#model').html(response).removeAttr('disabled');
            });
        }else{
            $('#model').html('<option>- Model seçin -</option>').attr('disabled', 'disabled');
        }
    });
});


