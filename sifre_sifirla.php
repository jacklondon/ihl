<?php 
session_start();
include 'ayar.php';
$response = [];
$statusCode = 404;
?>
<?php 
// ENTRY FAVLAMA

if(re("action")=="mail_sifre")
{

    $hatirlatilacak_mail = re('hatirlatilacak_mail');

    $gsm=re("gsm");

    $kullanici_cek = mysql_query("select * from user where mail = '".$hatirlatilacak_mail."' and telefon='".$gsm."'");
    $kullanici_say=mysql_num_rows($kullanici_cek);

    if($kullanici_say==1)
    {
		$kullanici_oku = mysql_fetch_assoc($kullanici_cek);
		$yeni_sifre = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789"),0,6);
		$sifre_guncelle = mysql_query("update user set sifre = '".md5($yeni_sifre)."' where mail = '".$hatirlatilacak_mail."'");
		if($sifre_guncelle){
			$messageBody = '';
			$messageBody .= '<b>'.ucfirst($ad). '</b> şifre yenileme isteğiniz tarafımızca alınmıştır.Yeni şifreniz ile giriş yapabilir ve şifrenizi dilerseniz değiştirebilirsiniz.<br>';
			$messageBody .= '<strong>Yeni Şifreniz: </strong> '. $yeni_sifre;
			$messageBody .= '<br><strong>Pert Dünyası</strong> ';

			$sifrem="Pertdunyasi.com kullanıcı girişi bilgileriniz:Onaylı cep No:".$gsm." Şifre:". $yeni_sifre;
			coklu_sms_gonder($kullanici_oku["id"],$sifrem,4);   

			// sendEmail($hatirlatilacak_mail, "Pert Dünyası", "Pert Dünyası Şifre Yenileme", $messageBody);
			echo json_encode(["message" => "Sms Gönderildi", "mail" => $hatirlatilacak_mail,"status" => 200]);
		}else{
			echo json_encode(["message" => "Sms Gönderilemedi", "mail" => $hatirlatilacak_mail,"status" => 201]);
		}
    }
    else {
        echo json_encode(["message" => "Kullanıcı bulunamadı, alanları eksiksiz ve hatasız doldurmalısınız.", "mail" => $hatirlatilacak_mail,"status" => 202]);
    }

}
   /* if(re("action")=="sms_sifre")
    {
        $hatiralatilacak_gsm=re("hatiralatilacak_gsm");

        $select=mysql_query("Select * from user where telefon='".$hatiralatilacak_gsm."'");
        $uye_cek=mysql_fetch_assoc($select);

        $yeni_sifre = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789"),0,6);
        $sifre="Pert Dünyası Ekibi --   Yeni Şifreniz:". $yeni_sifre;
        $sifre_guncelle = mysql_query("update user set sifre = '".md5($yeni_sifre)."' where telefon = '".$hatiralatilacak_gsm."'");

        

 

       
    }*/

if(re("action")=="yeni_kullanici")
{
    $telefon=re("telefon");

	$dogrulama_durumu_cek=mysql_query("Select * from dogrulama_durumu where id='1' ");
    $dogrulama_durumu_oku=mysql_fetch_assoc($dogrulama_durumu_cek);
	if($dogrulama_durumu_oku["dogrulama_durumu"]==1){
		$select=mysql_query("Select * from user where telefon='".$telefon."'");
		$kullanici_cek=mysql_fetch_assoc($select);

		//$yeni_onay = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789"),0,6);
		$yeni_onay = substr(str_shuffle("0123456789"),0,6);
		$onay_mesaj="Pertdunyasi.com kullanıcı onay bilgileriniz:Onaylı cep No:".$telefon." Onay Kodunuz:". $yeni_onay .". Üyeliğinizin tamamlanabilmesi için lütfen cep telefonunuza gönderilen kodu giriniz.";
		$date_time=date("Y-m-d H:i:s");

		$uye_kontrol=mysql_query("Select * from onayli_kullanicilar where user_id='".$kullanici_cek["id"]."'");
		$kontrol=mysql_num_rows($uye_kontrol);

		if($kontrol!=0)
		{
			$update=mysql_query("Update onayli_kullanicilar set kod='".$yeni_onay."',durum='0' where user_id='".$kullanici_cek["id"]."'");
		}
		else {
			$onayli_kullanicilar = mysql_query("INSERT INTO `onayli_kullanicilar` (`user_id`, `kod`, `e_tarihi`,`durum`) VALUES ( '".$kullanici_cek["id"]."', '".$yeni_onay."','".$date_time."','0');");
		}

		coklu_sms_gonder($kullanici_cek["id"],$onay_mesaj,5);      
		$response=["message"=>"Onay kodu telefon numaranıza başarıyla gönderildi","modal" => 1,"status"=>200];
	}else{
		
		$select=mysql_query("Select * from user where telefon='".$telefon."'");
		$kullanici_cek=mysql_fetch_assoc($select);

		$yeni_onay = substr(str_shuffle("0123456789"),0,6);
		$date_time=date("Y-m-d H:i:s");

		$uye_kontrol=mysql_query("Select * from onayli_kullanicilar where user_id='".$kullanici_cek["id"]."'");
		$kontrol=mysql_num_rows($uye_kontrol);

		if($kontrol!=0)
		{
			$update=mysql_query("Update onayli_kullanicilar set kod='".$yeni_onay."',durum='1' where user_id='".$kullanici_cek["id"]."'");
		}
		else {
			$onayli_kullanicilar = mysql_query("INSERT INTO `onayli_kullanicilar` (`user_id`, `kod`, `e_tarihi`,`durum`) VALUES ( '".$kullanici_cek["id"]."', '".$yeni_onay."','".$date_time."','1');");
		}
		$_SESSION['u_token'] = $kullanici_cek["user_token"];
		$_SESSION['k_token'] = $kullanici_cek["kurumsal_user_token"];
		$response=["message"=>"Üyeliğiniz başarıyla tamamlandı.","modal" => 0,"status"=>200,"user_token" => $kullanici_cek["user_token"], "kurumsal_token" => $kullanici_cek["kurumsal_user_token"]];
	}
	echo json_encode($response);
}

?>