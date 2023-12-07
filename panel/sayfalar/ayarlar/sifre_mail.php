<?php
	if(re("action")=="sifre_yenile"){
		/*  href="?modul=ayarlar&sayfa=sifre_mail&id=<?=$uyeleri_oku['id'] ?>" */
		$response=[];
		$gelen_id=re("id");
		$sorgu=mysql_query("select * from user where id='".$gelen_id."'");
		$row=mysql_fetch_array($sorgu);
		$ad=$row["ad"];
		$mail=$row["mail"];
		$yeni_sifre=md5(uniqid(mt_rand() , true));
		$yeni_sifre=substr($yeni_sifre,0,9);
		$yeni_sifre_md5=md5($yeni_sifre);
		$guncelle=mysql_query("update user set sifre='".$yeni_sifre_md5."' where id='".$gelen_id."' ");
		if($guncelle){
			$messageBody = '';
			$messageBody .= '<b>'.ucfirst($ad). '</b> şifre yenileme isteğiniz tarafımızca alınmıştır.Yeni şifreniz ile giriş yapabilir ve şifrenizi dilerseniz değiştirebilirsiniz.<br>';
			$messageBody .= '<strong>Yeni Şifreniz: </strong> '. $yeni_sifre;
			$messageBody .= '<br><strong>Pert Dünyası</strong> ';
			sendEmail($mail, "Pert Dünyası", "Pert Dünyası Şifre Yenileme", $messageBody);
			$response=["message"=>"","status"=>200];
		}
		echo json_encode($response);

	
	}
	if(re("action")=="dogrulama_yenile"){
		/*  href="?modul=ayarlar&sayfa=sifre_mail&id=<?=$uyeleri_oku['id'] ?>" */
		$response=[];
		$gelen_id=re("id");
		$sorgu=mysql_query("select * from user where id='".$gelen_id."'");
		$row=mysql_fetch_array($sorgu);
		$ad=$row["ad"];
		$mail=$row["mail"];
		$yeni_onay = substr(str_shuffle("0123456789"),0,6);
		$guncelle=mysql_query("update onayli_kullanicilar set kod='".$yeni_onay."' where user_id='".$gelen_id."' ");
		if($guncelle){
			$messageBody = '';
			$messageBody .= '<b>'.ucfirst($ad). '</b> doğrulama yenileme isteğiniz tarafımızca alınmıştır.Yeni doğrulama kodunuz ile hesabınızı aktif edebilirsiniz.<br>';
			$messageBody .= '<strong>Yeni onay kodunuz: </strong> '. $yeni_onay;
			$messageBody .= '<br><strong>Pert Dünyası</strong> ';
			sendEmail($mail, "Pert Dünyası", "Pert Dünyası Doğrulama Kodu Yenileme", $messageBody);
			$response=["message"=>"","status"=>200];
		}
		echo json_encode($response);

	
	}
	
	
 ?>