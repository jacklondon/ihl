<?php 
    $sistem_devam_bilgileri_cek = mysql_query("SELECT * FROM `user` WHERE kurumsal_user_token = '$uye_token'");
    while($devam_etsin = mysql_fetch_array($sistem_devam_bilgileri_cek)){
        if($devam_etsin['paket'] != 1){
            if($devam_etsin['tc_kimlik']=="" || $devam_etsin['mail']==""  || $devam_etsin['telefon']=="" || $devam_etsin['sehir']==""|| $devam_etsin['ad']=="" || $devam_etsin['cinsiyet']==""  || $devam_etsin['kargo_adresi']=="" ){
              
			  // echo'<script>swal("Lütfen Bilgilerinizi Eksiksiz Doldurun. Yoksa işlem yapamazsınız.")</script>';
                echo"<script>window.location.href = 'profili_duzenle.php';</script>";                
            }
        }       
     }
?>