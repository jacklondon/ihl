<?php 
if(re('emaili')=='Kaydet'){
    $konu = re('mail_konusu');   
    $icerik = nl2br(htmlspecialchars($_POST['icerik']));
    $alicilar = $_POST['gonderilecek_kisiler'];    
    $alici_sayi = count($alicilar);
    if($alici_sayi > 0){
        echo '<script> confirm("Silmek istediğinize emin misiniz ?"); </script>';
        
    }
    echo $alici_sayi;
    foreach($alicilar as $alici){
        sendEmail($alici,$alici,$konu,$icerik,'');
    }
    echo '<script>alert("Email Gönderildi");</script>';
   
}
?>