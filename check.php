<?php
    include "ayar.php";    
	if($_SESSION['u_token'] != "" && $_SESSION['k_token'] == ""){
		$uye_token = $_SESSION['u_token'];
		$kullanici_grubu=kullanici_grubu_cek($uye_token);
    }elseif($_SESSION['u_token'] == "" && $_SESSION['k_token'] != ""){
		$uye_token = $_SESSION['k_token'];
		$kullanici_grubu=kullanici_grubu_cek($uye_token);
    }
	function str_split_unicode($str, $length = 1) {
		$tmp = preg_split('~~u', $str, -1, PREG_SPLIT_NO_EMPTY);
		if ($length > 1) {
			$chunks = array_chunk($tmp, $length);
			foreach ($chunks as $i => $chunk) {
				$chunks[$i] = join('', (array) $chunk);
			}
			$tmp = $chunks;
		}
		return $tmp;
	}
	if(re("action")=="otomatik_sure_uzat"){
		$response=[];
		$id=re("id");
		$ilan_getir=mysql_query("select * from ilanlar where id='".$id."'");
		$ilan_oku=mysql_fetch_object($ilan_getir);
		$sigorta_cek=mysql_query("select * from sigorta_ozellikleri where id='".$ilan_oku["sigorta"]."'");
		$sigorta_oku=mysql_fetch_object($sigorta_cek);
		$sigorta_saniyenin_altinda=$sigorta_oku->saniyenin_altinda;
		$sigorta_saniye_uzar=$sigorta_oku->saniye_uzar;

		$bitis_tarihi=$ilan_oku->ihale_tarihi." ".$ilan_oku->ihale_saati;
		$yeni_tarih_str=strtotime($bitis_tarihi)+$sigorta_saniye_uzar;//Belirlenen saniye eklendi
		$yeni_tarih=date("Y-m-d H:i:s",$yeni_tarih_str);
		$duzenli_yeni_tarih=date("d-m-Y H:i:s",strtotime($yeni_tarih));
		$parcala=explode(" ",$yeni_tarih);
		$yeni_ihale_tarihi=$parcala[0];
		$yeni_ihale_saati=$parcala[1];	
		
		$son_teklif=mysql_query("select * from teklifler where ilan_id='".$id."' and durum=1 order by teklif_zamani limit 1");
		$son_teklif_oku=mysql_fetch_object($son_teklif);
		if($ilan_oku->ihale_turu=="1"){
			$son_teklif=mysql_query("select * from teklifler where ilan_id='".$id."' and durum=1 order by teklif_zamani limit 1");
			$son_teklif_oku=mysql_fetch_object($son_teklif);
			$son_teklif_uye_id=$son_teklif_oku->uye_id;
		}else{
			$son_teklif=mysql_query("select * from teklifler where durum=1 and ilan_id='".$id."' group by uye_id order by teklif_zamani");
			while($son_teklifler_oku=mysql_fetch_array($son_teklif)){
				$uye_son_teklif=mysql_query("select * from teklifler where durum=1 and uye_id='".$son_teklifler_oku["uye_id"]."' and ilan_id='".$id."' order by teklif_zamani limit 1");
				$uye_son_teklif_oku=mysql_fetch_array($uye_son_teklif);
				if($ilan_oku->son_teklif==$uye_son_teklif_oku["teklif"]){
					$son_teklif_uye_id=$uye_son_teklif_oku["uye_id"];
				}
			}
		}
		if($ilan_oku->sistem_sure_uzatma_durumu==0 && $son_teklif_uye_id !='283' && mysql_num_rows($son_teklif)!=0 ){//Kaynak firma uye_id 283
			$gosterilme_tarih=strtotime($yeni_tarih)+300; //Gösterilme süresi 5 dk fazla olması istendi
			$gosterilme_tarih=date("Y-m-d H:i:s",$gosterilme_tarih);
			$guncelle=mysql_query("update ilanlar set ihale_tarihi='$yeni_ihale_tarihi',ihale_saati='$yeni_ihale_saati',sistem_sure_uzatma_durumu='1',ihale_son_gosterilme='$gosterilme_tarih' where id='".$id."' ");
			$response=["ads"=>"güncellendi ","tarih"=>$duzenli_yeni_tarih,"sss"=>$bitis_tarihi,"status"=>200];
		}else{
			$response=["ads"=>"koşullar uygun değil ","status"=>500];
		}
		echo json_encode($response);
	}
	if(re("action")=="sure_doldu"){
		$response=[];
		$id=re("id");
		$sorgu=mysql_query("update ilanlar set vitrin='',durum=-1 where concat(ilanlar.ihale_tarihi,' ',ilanlar.ihale_saati) < '".date("Y-m-d H:i:s")."' and durum=1");
		if($sorgu){
			$response=["xx"=>$id,"status"=>200];
		}
		else{
			$response=[""=>"hata ","status"=>500];
		}
		echo json_encode($response);
	}
	if(re("action")=="enyuksek_yenile_arac_detay"){
		$response=[];
		$id=re("id");
		if($uye_token!=""){
			$kazanilan_sorgu=mysql_query("SELECT * FROM kazanilan_ilanlar WHERE ilan_id = '".$id."' and durum != 0 ");
			if(mysql_num_rows($kazanilan_sorgu)==1){
				$response=["status"=>501];
			}else{
				$sorgu=mysql_query("SELECT * FROM ilanlar WHERE id = '".$id."' ");
				$cek=mysql_fetch_object($sorgu);
				// $teklifler_sql=mysql_query("select * from teklifler where teklif='".$cek->son_teklif."' and (user_token='".$uye_token."' or kurumsal_token='".$uye_token."') and ilan_id='".$id."' and durum=1");
				$teklifler_sql=mysql_query("select * from teklifler where teklif='".$cek->son_teklif."' and ilan_id='".$id."' and durum=1");
				$teklifler_oku = mysql_fetch_object($teklifler_sql);
				if($teklifler_oku->user_token == $uye_token || $teklifler_oku->kurumsal_token == $uye_token){
					$en_yuksek_benim = 1;
				}else{
					$en_yuksek_benim = 0;
				}
				// var_dump("select * from teklifler where teklif='".$cek->son_teklif."' and (user_token='".$uye_token."' or kurumsal_token='".$uye_token."') and ilan_id='".$id."' and durum=1");
				if($cek->ihale_turu == 1){
					if(mysql_num_rows($teklifler_sql)!=0){
						$response=["status"=>200,"teklif"=>$cek->son_teklif,"en_yuksek_benim" => $en_yuksek_benim];
					}else{
						$response=["status"=>502];
					}
				}else{
					$response=["status"=>503];
				}
			}
		}
		echo json_encode($response);
	}
	if(re("action")=="enyuksek_yenile"){
		$response=[];
		$id=re("id");
		$sorgu=mysql_query("SELECT * FROM ilanlar WHERE id = '".$id."' ");
		if($uye_token!=""){
			$cek=mysql_fetch_object($sorgu);
			$teklifler_sql=mysql_query("select * from teklifler where teklif='".$cek->son_teklif."' and (user_token='".$uye_token."' or kurumsal_token='".$uye_token."') and ilan_id='".$id."' and durum=1");
			if($cek->ihale_turu == 1 ){
				if(mysql_num_rows($teklifler_sql)==0){
					$response=["status"=>200,"teklif"=>$cek->son_teklif];
				}else{
					$response=["status"=>500];
				}
			}else{
				$response=["status"=>500];
			}	
		}else{
			$response=["status"=>500];
		}
		echo json_encode($response);
	}
	if(re("action")=="dogrudan_arttir"){
		$response=[];
		$ilan_id=re("ilan_id");
		$ip=re("ip");
		$kontrol=mysql_query("select * from dogrudan_goruntulenme where ilan_id='".$ilan_id."' and ip='".$ip."' ");
		if(mysql_num_rows($kontrol)<1){
			$kaydet=mysql_query("insert into dogrudan_goruntulenme (id,ilan_id,ip,tarih)
			values (null,'".$ilan_id."','".$ip."','".date("Y-m-d H:i:s")."')
			");
		}
		echo json_encode($response);
	}
	if(re("action")=="ihale_arttir"){
		$response=[];
		$ilan_id=re("ilan_id");
		$ip=re("ip");
		$kontrol=mysql_query("select * from ihale_goruntulenme where ilan_id='".$ilan_id."' and ip='".$ip."' ");
		if(mysql_num_rows($kontrol)<1){
			$kaydet=mysql_query("insert into ihale_goruntulenme (id,ilan_id,ip,tarih)
			values (null,'".$ilan_id."','".$ip."','".date("Y-m-d H:i:s")."')
			");
		}
	}
	if(re("action")=="tc_kontrol"){
		$response=[];
		$tc_kimlik=re("tc_kimlik");
		$id=re("id");
		$kullaniciyi_getir = mysql_query("SELECT * FROM user WHERE id = '".$id."'");
		$kullaniciyi_getir_gel = mysql_fetch_assoc($kullaniciyi_getir);
		$sorgu=mysql_query("select * from user where tc_kimlik='".$tc_kimlik."' ");
		if($tc_kimlik!=""){
			if(strlen($tc_kimlik)!=11){
			$response=["message"=>"TC kimlik numaranız 11 rakamdan oluşmalıdır","status"=>500];
			}
			else
			{
				if($kullaniciyi_getir_gel["tc_kimlik"] != $tc_kimlik ){
					if(mysql_num_rows($sorgu)==1){
						$response=["message"=>"TC Kimlik numara kullanıldığı için uygun değil.","status"=>500];
					}
					else{
						$response=["message"=>"TC Kimlik numara kullanılmak için uygun.","status"=>200];
					}
				}else{
					if(mysql_num_rows($sorgu)==2){
						$response=["message"=>"TC Kimlik numara kullanıldığı için uygun değil.","status"=>500];
					}
					else{
						$response=["message"=>"TC Kimlik numara kullanılmak için uygun.","status"=>200];
					}
				}
			}
		}else{
			$response=["message"=>"","status"=>200];
		}
		echo json_encode($response);
	}
	if(re("action")=="email_kontrol"){			
		$response=[];
		$email=re("email");
		$id=re("id");
		$kullaniciyi_getir = mysql_query("SELECT * FROM user WHERE id = '".$id."'");
		$kullaniciyi_getir_gel = mysql_fetch_assoc($kullaniciyi_getir);
		$sorgu=mysql_query("select * from user where mail='".$email."' ");
		$str="ÜĞŞÇÖğıüşöçİ";
		$a=str_split_unicode($email,1);
		$b=str_split_unicode($str,1);
		if(count($a)>count($b)){
			$v=count($a);
		}else{
			$v=count($b);
		}
		$sayi=0;
		for($i=0;$i<$v;$i++){
			for($j=0;$j<$v;$j++){
				if($a[$j]==$b[$i]){
					$sayi++;
				}
			}
		}
		if($sayi != 0){
			$response=["message"=>"Email alanında türkçe karakter olmamalıdır.","status"=>500];
		}
		else if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$response=["message"=>"Email formatına uygun değil.","status"=>500];
		}
		else
		{
			$response=["message"=>"Email formatına uygun.","status"=>200];
			if($kullaniciyi_getir_gel["mail"] != $email ){
				if(mysql_num_rows($sorgu)==1){
					$response=["message"=>"Email kullanıldığı için uygun değil.","status"=>500];
				}
				else{
					$response=["message"=>"Email kullanılmak için uygun.","status"=>200];
				}
			}else{
				if(mysql_num_rows($sorgu)==2){
					$response=["message"=>"Email kullanıldığı için uygun değil.","status"=>500];
				}
				else{
					$response=["message"=>"Email kullanılmak için uygun.","status"=>200];
				}
			}
		}
		echo json_encode($response);
	}
		if(re("action")=="tel_kontrol"){
		$response=[];
		$id=re("id");
		$kullaniciyi_getir = mysql_query("SELECT * FROM user WHERE id = '".$id."'");
		$kullaniciyi_getir_gel = mysql_fetch_assoc($kullaniciyi_getir);
		$onayli_cep=re("tel");
		$sorgu=mysql_query("select * from user where telefon='".$onayli_cep."' ");
		if(strlen($onayli_cep)!=14) {
			$response=["message"=>"Telefon numaranız 11 rakamdan oluşmalıdır","status"=>500];
		}
		else
		{
			if($kullaniciyi_getir_gel["telefon"] != $onayli_cep ){
				if(mysql_num_rows($sorgu)==1){
					$response=["message"=>"Telefon numarası kullanıldığı için uygun değil.","status"=>500];
				}
				else{
					$response=["message"=>"Telefon numarası kullanılmak için uygun.","status"=>200];
				}
			}
			else{
				if(mysql_num_rows($sorgu)==2){
					$response=["message"=>"Telefon numarası kullanıldığı için uygun değil.","status"=>500];
				}
				else{
					$response=["message"=>"Telefon numarası kullanılmak için uygun.","status"=>200];
				}
			}
		}
		echo json_encode($response);
	}
	if(re("action")=="sabit_tel_kontrol"){
		
		$response=[];
		$id=re("id");
		$kullaniciyi_getir = mysql_query("SELECT * FROM user WHERE id = '".$id."'");
		$kullaniciyi_getir_gel = mysql_fetch_assoc($kullaniciyi_getir);
		$sabit_tel=re("sabit_tel");
		$sorgu=mysql_query("select * from user where sabit_tel='".$sabit_tel."' ");
		if((strlen($sabit_tel)>4 || $sabit_tel =="") && strlen($sabit_tel)!=14) {
			$response=["message"=>"Sabit telefon numaranız 11 rakamdan oluşmalıdır","status"=>500];
		}
		else
		{
			if($kullaniciyi_getir_gel["sabit_tel"] != $sabit_tel ){
				if(mysql_num_rows($sorgu)==1){
					$response=["message"=>"Sabit telefon numarası kullanıldığı için uygun değil.","status"=>500];
				}
				else{
					$response=["message"=>"Sabit telefon numarası kullanılmak için uygun.","status"=>200];
				}
			}else{
				if(mysql_num_rows($sorgu)==2){
					$response=["message"=>"Sabit telefon numarası kullanıldığı için uygun değil.","status"=>500];
				}
				else{
					$response=["message"=>"Sabit telefon numarası kullanılmak için uygun.","status"=>200];
				}
			}
		}
		
		echo json_encode($response);
	}
	if(re("action")=="vergi_no_kontrol"){
	
		$response=[];
		$id=re("id");
		$kullaniciyi_getir = mysql_query("SELECT * FROM user WHERE id = '".$id."'");
		$kullaniciyi_getir_gel = mysql_fetch_assoc($kullaniciyi_getir);
		$vergi_no=re("vergi_no");
		$sorgu=mysql_query("select * from user where vergi_dairesi_no='".$vergi_no."' ");
		if(strlen($vergi_no)!=10) {
			$response=["message"=>"Vergi numaranız 10 rakamdan oluşmalıdır","status"=>500];
		}
		else
		{
			if($kullaniciyi_getir_gel["vergi_dairesi_no"] != $vergi_no ){
				if(mysql_num_rows($sorgu)==1){
					$response=["message"=>"Vergi numarası kullanıldığı için uygun değil.","status"=>500];
				}
				else{
					$response=["message"=>"Vergi numarası kullanılmak için uygun.","status"=>200];
				}
			}else{
				if(mysql_num_rows($sorgu)==2){
					$response=["message"=>"Vergi numarası kullanıldığı için uygun değil.","status"=>500];
				}
				else{
					$response=["message"=>"Vergi numarası kullanılmak için uygun.","status"=>200];
				}
			}
		}
		
		echo json_encode($response);
	}
		/* else if(str_word_count($firma_unvani) < 2 ){
		 	$response=["message"=>"Firma Unvanı en az 2 kelime olmalıdır","status"=>500];
		 }*/
	 if(re("action")=="panel_guncelle"){
		$response=[];
        $gelen_id = re('user_id');
        $ad = ucwords(re('ad_soyad'));
        $firma_unvani = ucwords(re('firma_unvani'));
        $tc = re('tc_kimlik');
        $dogum_tarihi = re('dogum_tarihi');
        $sebep = re('sebep');
        $cinsiyet = re('cinsiyet');
        $email = re('email');
        $telefon = re('tel');
        $sabit_tel = re('sabit_tel');
        $sehir = re('sehir');
        $ilce = re('ilce');
        $meslek = re('meslek');
        //$ilgiler = re('ilgilendigi_turler'); 
		$ilgilendigi = $_POST["ilgilendigi"];//Array;		
        $adres = re('kargo_adresi');
        $kargo_adresi = re('kargo_adresi');
        $fatura_adresi = re('fatura_adresi');
        $vergi_dairesi = re('vergi_dairesi');
        $vergi_no = re('vergi_no');
		
        $yedek_kisi = $_POST["yedek_kisi"];//Array;
		$yedek_kisi_tel = $_POST["yedek_kisi_tel"];//Array;
	
        $mevcut_sifre = re('mevcut_sifre');
        $sifre = re('yeni_sifre');
        $sifre_tekrar = re('sifre_tekrar');
	

		$kullaniciyi_getir = mysql_query("SELECT * FROM user WHERE id = '".$gelen_id."'");
		$kullaniciyi_getir_gel = mysql_fetch_array($kullaniciyi_getir);
		
		$sorgu=mysql_query("select * from user where telefon='".$telefon."' ");

		$sorgu2=mysql_query("select * from user where sabit_tel='".$sabit_tel."' ");
		$sorgu3=mysql_query("select * from user where mail='".$email."' ");
		$sorgu4=mysql_query("select * from user where vergi_dairesi_no='".$vergi_no."' ");
		$sorgu5=mysql_query("select * from user where tc_kimlik='".$tc."' ");
		
		$yedek_tel_durum=true;
		$yedek_ad="";
		$yedek_tel="";
		$yedekler=count($yedek_kisi);
		for($b=0;$b<$yedekler;$b++)
		{
			if($yedek_kisi_tel[$b] !="" && $yedek_kisi[$b] !=""){
				ltrim(rtrim($yedek_kisi[$b]));
				ltrim(rtrim($yedek_kisi_tel[$b]));
			}else{
				array_splice($yedek_kisi_tel, $b, 1);
				array_splice($yedek_kisi, $b, 1);
			}
		}

		$yedek_sayi=count($yedek_kisi);
		for($i=0;$i<count($yedek_kisi);$i++)
		{
			if($yedek_kisi_tel[$i]!="" && $yedek_kisi[$i]!=""){
				if(strlen($yedek_kisi_tel[$i])!=14){
					$yedek_tel_durum=false;
				}
				
				if($i!=$yedek_sayi-1){
					$yedek_ad.=$yedek_kisi[$i].",";
					$yedek_tel.=$yedek_kisi_tel[$i].",";
				}else{
					$yedek_ad.=$yedek_kisi[$i];
					$yedek_tel.=$yedek_kisi_tel[$i];
				}	
			}
		}
		$ilg_turler="";
		$ilg_sayi=count($ilgilendigi);
		for($j=0;$j<count($ilgilendigi);$j++){
			if($ilgilendigi[$j]!=""){
				if($j!=$ilg_sayi-1){
					$ilg_turler.=$ilgilendigi[$j].",";
				}else{
					$ilg_turler.=$ilgilendigi[$j];
				}	
			}
		}
	

		
		if(str_word_count($ad) < 2 ){
			$response=["message"=>"Ad Soyad en az 2 kelime olmalıdır","status"=>500];
		}
		else if(strlen($telefon)!=14){
			$response=["message"=>" Telefon numaranız 11 rakamdan oluşmalıdır","status"=>500];
		
		} /*else if((strlen($sabit_tel)>4 || $sabit_tel =="") && strlen($sabit_tel)!=14){
			$response=["message"=>"Sabit telefon numaranız 11 rakamdan oluşmalıdır","status"=>500];
		} */ else if($sifre !="" && strlen($sifre)<6){
			$response=["message"=>"Şifre en az 6 haneli olmalı","status"=>500];
		}else if($sifre !="" && $sifre_tekrar !="" && $sifre != $sifre_tekrar){
			$response=["message"=>"Şifre ve şifre tekrar alanları aynı 121212","status"=>500];
		}
		 else if($tc!="" && strlen($tc)!=11){
			$response=["message"=>"TC kimlik numaranız 11 rakamdan oluşmalıdır","status"=>500];
		}
		else if($yedek_tel_durum==false){
			$response=["message"=>"Yedek kişi telefon numarası 11 rakamdan oluşmalıdır ","status"=>500];
		}
		else if($vergi_no!="" && strlen($vergi_no)!=10){
			$response=["message"=>"Vergi numarası 10 rakamdan oluşmalıdır","status"=>500];
		}
		else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$response=["message"=>"Email formatına uygun değil.","status"=>500];
		}	
		 else if(mysql_num_rows($sorgu)==1 && $kullaniciyi_getir_gel["telefon"] != $telefon){	
			$response=["message"=>" Telefon numarası kullanılmakta","status"=>500];
		}
		else if(mysql_num_rows($sorgu)==2 && $kullaniciyi_getir_gel["telefon"] == $telefon){
			$response=["message"=>"Telefon numarası kullanılmakta","status"=>500];
		}
		 else if( (strlen($sabit_tel)>4 || $sabit_tel =="") && mysql_num_rows($sorgu2)==1 && $kullaniciyi_getir_gel["sabit_tel"] != $sabit_tel){
			$response=["message"=>"Sabit telefon numarası kullanılmakta","status"=>500];
		}
		else if((strlen($sabit_tel)>4 || $sabit_tel =="") && mysql_num_rows($sorgu2)==2 && $kullaniciyi_getir_gel["sabit_tel"] == $sabit_tel){
			$response=["message"=>"Sabit telefon numarası kullanılmakta","status"=>500];
		}
		 else if(mysql_num_rows($sorgu3)==1 && $kullaniciyi_getir_gel["mail"] != $email){
			$response=["message"=>"Email kullanılmakta","status"=>500];
		}
		else if(mysql_num_rows($sorgu3)==2 && $kullaniciyi_getir_gel["mail"] == $email){
			$response=["message"=>"Email kullanılmakta","status"=>500];
		}
		  else if($vergi_no !="" && (mysql_num_rows($sorgu4)==1 && $kullaniciyi_getir_gel["vergi_dairesi_no"] != $vergi_no)){
			$response=["message"=>"Vergi no kullanılmakta","status"=>500];
		}
		else if($vergi_no !="" && (mysql_num_rows($sorgu4)==2  && $kullaniciyi_getir_gel["vergi_dairesi_no"] == $vergi_no)){
			$response=["message"=>"Vergi no kullanılmakta","status"=>500];
		}
		 else if($tc!="" &&  mysql_num_rows($sorgu5)==1 && $kullaniciyi_getir_gel["tc_kimlik"] != $tc){
			$response=["message"=>"TC kimlik numarası kullanılmakta","status"=>500];
		}
		 else if($tc!="" &&  mysql_num_rows($sorgu5)==2 && $kullaniciyi_getir_gel["tc_kimlik"] == $tc){
			$response=["message"=>"TC kimlik numarası kullanılmakta","status"=>500];
		} 
		else{
			$sehir_adi = mysql_query("SELECT * FROM sehir WHERE sehirID = $sehir");
			if($sehir_adi){
				while($sehir_gel = mysql_fetch_array($sehir_adi)){
					$il = $sehir_gel["sehiradi"];
				}
				if($sifre == ""){
					$a=mysql_query("UPDATE `user` SET 
						`ad` = '$ad', 
						`tc_kimlik` = '$tc', 
						`uye_olma_sebebi` = '$sebep', 
						`cinsiyet` = '$cinsiyet', 
						`mail` = '$email', 
						`telefon` = '$telefon', 
						`sabit_tel` = '$sabit_tel', 
						`sehir` = '$il', 
						`ilce` = '$ilce', 
						`meslek` = '$meslek', 
						`ilgilendigi_turler` = '$ilg_turler', 
						`adres` = '$adres', 
						`kargo_adresi` = '$kargo_adresi', 
						`fatura_adresi` = '$fatura_adresi', 
						`unvan` = '$firma_unvani', 
						`vergi_dairesi` = '$vergi_dairesi', 
						`vergi_dairesi_no` = '$vergi_no',
						`yedek_kisi` = '$yedek_ad',
						`yedek_kisi_tel` = '$yedek_tel'
						 WHERE `user`.`id` = $gelen_id;
					  "); 
					mysql_query("UPDATE dogum_tarihi SET dogum_tarihi = '".$dogum_tarihi."' WHERE uye_id = '".$gelen_id."'");

					  $response=["message"=>"Güncelleme Başarılı","status"=>200];
					  
				}else {
					$sifre_son = md5($sifre);
					$a=mysql_query("UPDATE `user` SET 
						`ad` = '$ad', 
						`tc_kimlik` = '$tc', 
						`uye_olma_sebebi` = '$sebep', 
						`cinsiyet` = '$cinsiyet', 
						`mail` = '$email', 
						`telefon` = '$telefon', 
						`sabit_tel` = '$sabit_tel', 
						`sehir` = '$il', 
						`ilce` = '$ilce', 
						`meslek` = '$meslek', 
						`ilgilendigi_turler` = '$ilg_turler', 
						`sifre` = '$sifre_son', 
						`adres` = '$adres', 
						`kargo_adresi` = '$kargo_adresi', 
						`fatura_adresi` = '$fatura_adresi', 
						`unvan` = '$firma_unvani', 
						`vergi_dairesi` = '$vergi_dairesi', 
						`vergi_dairesi_no` = '$vergi_no',
						`yedek_kisi` = '$yedek_ad',
						`yedek_kisi_tel` = '$yedek_tel'
						 WHERE `user`.`id` = $gelen_id;
					  "); 
					  		mysql_query("UPDATE dogum_tarihi SET dogum_tarihi = '".$dogum_tarihi."' WHERE uye_id = '".$gelen_id."'");
						$response=["message"=>"Güncelleme Başarılı","status"=>200];
					
				
				} 
				
			}
			
		}

       echo json_encode($response);
	}
	if(re("action")=="modal_sayfalandır"){
		$response=[];
		$gelen_id=re("ilan_id");
		
		$teklif_sayi = mysql_query("SELECT * FROM teklifler WHERE ilan_id ='".$gelen_id."' and durum=1");
		$toplam_teklif=mysql_num_rows($teklif_sayi);
		
		if($toplam_teklif < 10){ $toplam_teklif=10; } 
		$limit1=re("limit1");
		if($limit1<0){
			$limit1=0;
			$limit2=10;
		}		
		if($limit1 % 10 != 0){
			$sonuc=$limit1 % 10;
			$sonuc2=10-$sonuc;
			$limit1=$limit1+$sonuc2;
		}
		$output .= '';

    $teklif = mysql_query("SELECT * FROM teklifler WHERE ilan_id ='".$gelen_id."'  and durum=1 ORDER BY teklif DESC LIMIT ".$limit1.",10");

    $sorgu = mysql_query("SELECT * FROM ilan_komisyon WHERE ilan_id ='".$gelen_id."'");

	$cek=mysql_fetch_object($sorgu);
	//$hizmet_bedeli=$cek->toplam;
	
	$sorgu2 = mysql_query("SELECT * FROM ilanlar WHERE id ='".$gelen_id."'");
	$cek2=mysql_fetch_object($sorgu2);
		$output .='
		<style>
			.pagination {
			display: -webkit-box;
			display: -ms-flexbox;
			display: flex;
			padding-left: 0;
			list-style: none;
			border-radius: 0.25rem;
		}.page-link {
			position: relative;
			display: block;
			padding: 0.5rem 0.75rem;
			margin-left: -1px;
			line-height: 1.25;
			color: #007bff;
			background-color: #fff;
			border: 1px solid #dee2e6;
		}
		.disabled {
		  color: currentColor;
		  cursor: not-allowed;
		  opacity: 0.5;
		  text-decoration: none;
		}

      </style>
		
		';
		 $output .= '
		 <div id="table">
        <table class="table table-bordered">
        <thead>
            <tr>
				<th>Teklif Zamanı</th>
				<th>Üye Grubu / Cayma Bedeli</th>
				<th>Üye İsmi</th>
				<th>Onaylı GSM No</th>
				<th>Teklif</th>
				<th>Hizmet Bedeli</th>
				<th>Detaylar</th>
				<th>Sil</th>
			</tr>
        </thead>'; 
		$output .= '<tbody> ';

		while($offer = mysql_fetch_array($teklif)){
			
			if($cek2->pd_hizmet=="" || $cek2->pd_hizmet==0){
				$hizmet_bedeli=$offer["hizmet_bedeli"];
			}else{
				$hizmet_bedeli=$cek2->pd_hizmet;
			}
			
			$query = mysql_query("SELECT * FROM `cayma_bedelleri` WHERE uye_id='".$offer["uye_id"]."' ORDER BY NET DESC LIMIT 1 ");	
			$row=mysql_fetch_object($query);
			//$cayma_bedeli=$row->net;
			
			/*$toplam_aktif = mysql_query('SELECT SUM(net) AS net FROM cayma_bedelleri WHERE uye_id = "'.$offer["uye_id"].'" and durum=1'); 
			$toplam_getir = mysql_fetch_assoc($toplam_aktif); 
			$toplam_cayma = $toplam_getir['net'];
				  
			$toplam_borc = mysql_query('SELECT SUM(net) AS net FROM cayma_bedelleri WHERE uye_id = "'.$offer["uye_id"].'" and durum=2'); 
			$toplam_borc_getir = mysql_fetch_assoc($toplam_borc); 
			$toplam_borc_cayma = $toplam_getir['net'];
			$cayma_bedeli=$toplam_cayma+toplam_borc_cayma;*/
			$aktif_cayma_toplam=mysql_query("
				SELECT 
					SUM(tutar) as toplam_aktif_cayma
				FROM
					cayma_bedelleri
				WHERE
					uye_id='".$kullanici_oku['id']."' AND
					durum=1
			");
			$toplam_aktif_cayma=mysql_fetch_assoc($aktif_cayma_toplam);
			$iade_talepleri_toplam=mysql_query("
				SELECT 
					SUM(tutar) as toplam_iade_talepleri
				FROM
					cayma_bedelleri
				WHERE
					uye_id='".$kullanici_oku['id']."' AND
					durum=2
			");
			$toplam_iade_talepleri=mysql_fetch_assoc($iade_talepleri_toplam);
			$borclar_toplam=mysql_query("
				SELECT 
					SUM(tutar) as toplam_borclar
				FROM
					cayma_bedelleri
				WHERE
					uye_id='".$kullanici_oku['id']."' AND
					durum=6
			");
			$toplam_borclar=mysql_fetch_assoc($borclar_toplam);
			$cayma_bedeli=$toplam_aktif_cayma["toplam_aktif_cayma"]-$toplam_iade_talepleri["toplam_iade_talepleri"]-$toplam_borclar["toplam_borclar"];
			
			
			
			$query2 = mysql_query("SELECT * FROM `user` WHERE id='".$offer["uye_id"]."' ");
			$row2=mysql_fetch_object($query2);
		
			
			
			$uye_grubu_id=$row2->paket;
				
			$sorgu3=mysql_query("select * from uye_grubu where id='".$uye_grubu_id."'");
			
			$row3=mysql_fetch_object($sorgu3);
			$uye_grubu=$row3->grup_adi;
			$telefon=$row2->telefon;

			if(empty($row2->kurumsal_user_token)){
				$uye_ismi=$row2->ad;
			}else{
				$uye_ismi=$row2->ad."/".$row2->unvan;
			}
		
				$teklif_date=$offer['teklif_zamani'];
				$teklif_zamani=date('d-m-Y H:i:s', strtotime($teklif_date));
				$output .= '
				<tr id="teklif_id'.$offer["id"].'">
					<td>'.$teklif_zamani.'</td>
					<td>'.$uye_grubu."/".$cayma_bedeli.'</td>
					<td>'.$uye_ismi.'</td>
					<td><a href="https://ihale.pertdunyasi.com/panel/sistem.php?modul=uyeler&sayfa=sms_gonder&id='.$offer["uye_id"].'" target="_blank" >'.$telefon.'</a></td>
					<td>'.$offer["teklif"].'</td>
					<td>'.$hizmet_bedeli.'</td>
					<td><a href="https://ihale.pertdunyasi.com/pdf.php?teklif_id='.$offer["id"].'&ihale_id='.$gelen_id.'&q=pdf" target="_blank" >PDF</a></td>
					<td><a href="#" onclick="teklif_sil('.$offer["id"].')">Sil</a></td>
				</tr>  ';
		} 
		$output .='
		</tbody>
		</table>
			
		'; 
		$sayi1=0;
		$sayi3=$limit1-10;
		//if($sayi3 <= 0){ $yaz1="disabled"; } else{ $yaz1="" ; }
		$sayi5=$limit1+10;
		//if($sayi5 >= $toplam_teklif){ $yaz="disabled"; } else{ $yaz="" ; }
		if($toplam_teklif % 10 == 0)
		{ 
			$sayi7=$toplam_teklif-10; 
					
		}
		else{
			$sonuc=$toplam_teklif % 10;
			$sayi7=$toplam_teklif-$sonuc;
		}
		

		$output .='
		
			 <nav aria-label="Page navigation example">
				<ul class="pagination justify-content-end">
				   <li class="page-item">
					  <a class="page-link" onclick="sayfalandir('.$sayi1.','.$gelen_id.')" aria-disabled="true">İlk</a>
				   </li>
				   <li class="page-item '.$yaz1.' " >
					  <a class="page-link" onclick="sayfalandir('.$sayi3.','.$gelen_id.')"  >Önceki</a>
				   </li>
				   <li class="page-item '.$yaz.' " >
					  <a class="page-link" onclick="sayfalandir('.$sayi5.','.$gelen_id.')" >Sonraki</a>
				   </li>
				   <li class="page-item" >
					  <a class="page-link" onclick="sayfalandir('.$sayi7.','.$gelen_id.')" >Son</a>
				   </li>
				</ul>
			 </nav>
			 </div>
		
		';
		$response=["data"=>$output,"teklif_sayisi"=>mysql_num_rows($teklif),"sql"=>"SELECT * FROM teklifler WHERE ilan_id ='".$gelen_id."' and durum=1  ORDER BY teklif DESC LIMIT ".$limit1.",10"];
		echo json_encode($response);
	}
	if(re("action")=="detay"){
		$response=[];
		$gelen_id=re("ilan_id");
		$uye_id=re("uye_id");
		$sorgu = mysql_query("SELECT * FROM ilan_komisyon WHERE ilan_id ='".$gelen_id."'");
		$cek=mysql_fetch_object($sorgu);
		$hizmet_bedeli=$cek->toplam;
		$teklif_3=mysql_query("select * from teklifler where ilan_id='".$gelen_id."' and durum=1 and uye_id='".$uye_id."' order by teklif_zamani desc");
		$teklif_max=mysql_query("select * from teklifler where ilan_id='".$gelen_id."' and durum=1 and uye_id='".$uye_id."' order by teklif_zamani desc limit 1 ");
		$cek2=mysql_fetch_object($teklif_max);
		$en_yuksek=$cek2->teklif;
		$output.='<tr>
					<th>Teklif Zamanı</th>
					<th>Teklif</th>
					<th>Hizmet Bedeli</th>
					<th>Detaylar</th>
					<th>Sil</th>
				</tr>
		';

		while($offer2 = mysql_fetch_array($teklif_3)){
		
			
				if(mysql_num_rows($teklif_3) > 1){
					if($en_yuksek!=$offer2["teklif"]){
					$teklif_date=$offer2['teklif_zamani'];
					$teklif_zamani=date('d-m-Y H:i:s', strtotime($teklif_date));
					$output .='
					
					<tr>
						<td>'.$teklif_zamani.'</td>
						<td>'.$offer2["teklif"].'</td>
						<td>'.$hizmet_bedeli.'</td>
						<td><a href="https://ihale.pertdunyasi.com/pdf.php?teklif_id='.$offer2["id"].'&ihale_id='.$gelen_id.'&q=pdf" target="_blank" >PDF</a></td>
						<td><a href="#" onclick="teklif_sil('.$offer2["id"].')" >Sil</a></td>
					<tr>  
					';
					}
				}else{
					$output .='
						<tr>
							<td colspan="4">
							Teklif bulunamadı.
							</td>	
						<tr> 
					
					
					';
				}

			
		}

		$response=["data"=>$output,""=>$sayi];
		echo json_encode($response);
		
	}
	if(re('action')=="satilan_guncelle"){
		$response = [];
		$id = re('satilan_id');
		$aciklama = re('iade_aciklama');
		$a = mysql_query("UPDATE satilan_araclar SET durum=1, aciklayici_not = '".$aciklama."' WHERE id = '".$id."'");
		$response=["data"=>""];
		echo json_encode($response);
	}
	if(re("action")=="panel_mesaj_cevapla"){
		$response=[];
	
		$ilan_id=re("ilan_id");
		$gonderen_id=re("gonderen_id");
		$mesaj=re("admin_mesaj");
		$eski_mesaj=re("eski_mesaj");
		$eski_mesaj_tarih=re("eski_mesaj_tarih");
		$admin_id=re("admin_id");
		$uye_sorgu=mysql_query("select * from user where id='".$gonderen_id."' ");
		$uye_row=mysql_fetch_object($uye_sorgu);
		if($uye_row->user_token != ""){
			$gonderen_token=$uye_row->user_token;
		}else if($uye_row->kurumsal_user_token != ""){
			$gonderen_token=$uye_row->kurumsal_user_token;
		}
		$adate=date("Y-m-d H:i:s");
		$duration=1;
		$dateinsec=strtotime($adate);
		$newdate=$dateinsec+$duration;
		$adate=date('Y-m-d H:i:s',$newdate);
		$sorgu=mysql_query("select * from kullanicilar where id='".$admin_id."' ");
		$row=mysql_fetch_object($sorgu);
		$admin_token=$row->token;
		/*$eski_kaydet=mysql_query("insert into mesajlar
			(id,ilan_id,gonderen_id,alan_id,dogrudan_satis_id,mesaj,gonderme_zamani,gonderen_token,alan_token) 
			values
			(null,'".$ilan_id."','".$gonderen_id."','0','','".$eski_mesaj."','".$eski_mesaj_tarih."','".$gonderen_token."','".$admin_token."') ");*/
		$kaydet=mysql_query("insert into mesajlar
			(id,ilan_id,gonderen_id,alan_id,dogrudan_satis_id,mesaj,gonderme_zamani,gonderen_token,alan_token) 
			values
			(null,'".$ilan_id."','0','".$gonderen_id."','','".$mesaj."','".date("Y-m-d H:i:s")."','".$admin_token."','".$gonderen_token."') ");
		
	echo json_encode($response);
	}
	if(re("action")=="panel_mesaj_cevapla_yeni"){
		$response=[];
	
		$ilan_id=re("ilan_id");
		$gonderen_id=re("gonderen_id");
		$mesaj=re("admin_mesaj");
		$eski_mesaj=re("eski_mesaj");
		$eski_mesaj_tarih=re("eski_mesaj_tarih");
		$admin_id=re("admin_id");
		$alan_id=re("alan_id");
		$uye_sorgu=mysql_query("select * from user where id='".$alan_id."' ");
		$uye_row=mysql_fetch_object($uye_sorgu);
		if($uye_row->user_token != ""){
			$gonderen_token=$uye_row->user_token;
		}else if($uye_row->kurumsal_user_token != ""){
			$gonderen_token=$uye_row->kurumsal_user_token;
		}
		$adate=date("Y-m-d H:i:s");
		$duration=1;
		$dateinsec=strtotime($adate);
		$newdate=$dateinsec+$duration;
		$adate=date('Y-m-d H:i:s',$newdate);
		$sorgu=mysql_query("select * from kullanicilar where id='".$admin_id."' ");
		$row=mysql_fetch_object($sorgu);
		$admin_token=$row->token;
		/*$eski_kaydet=mysql_query("insert into mesajlar
			(id,ilan_id,gonderen_id,alan_id,dogrudan_satis_id,mesaj,gonderme_zamani,gonderen_token,alan_token) 
			values
			(null,'".$ilan_id."','".$gonderen_id."','0','','".$eski_mesaj."','".$eski_mesaj_tarih."','".$gonderen_token."','".$admin_token."') ");*/
		$kaydet=mysql_query("insert into mesajlar
			(id,ilan_id,gonderen_id,alan_id,dogrudan_satis_id,mesaj,gonderme_zamani,gonderen_token,alan_token,durum,is_admin_see) 
			values
			(null,'".$ilan_id."','0','".$alan_id."','0','".$mesaj."','".date("Y-m-d H:i:s")."','".$admin_token."','".$gonderen_token."',1,1) ");
		
	echo json_encode($response);
	}

	if(re('action') == "panel_mesaj_cevapla_son"){		
		$room_id = re('room_id');
		$admin_id = re('admin_id');
		$admin_mesaj = re('admin_mesaj');
		$add_time = date('Y-m-d H:i:s');
		$sql = mysql_query("insert into chat_messages(room_id,gonderen_id,gonderen_type,mesaj,add_time,status) values ('".$room_id."','".$admin_id."',2,'".$admin_mesaj."','".$add_time."',1)");
		if($sql){
			mysql_query("update chat_room set last_message = '".$admin_mesaj."', last_message_time = '".$add_time."' where id = '".$room_id."'");
			$response = ["status" => 200];
		}else{
			$response = ["status" => 300, "message" => "İşlem sırasında bir hata oluştu. Lütfen daha sonra tekrar deneyiniz."];
		}
		echo json_encode($response);
	}



	if(re("action")=="panel_dogrudan_mesaj_cevapla"){
		$response=[];
	
		$ilan_id=re("ilan_id");
		$gonderen_id=re("gonderen_id");
		$mesaj=re("admin_mesaj");
		$eski_mesaj=re("eski_mesaj");
		$eski_mesaj_tarih=re("eski_mesaj_tarih");
		$admin_id=re("admin_id");
		$uye_sorgu=mysql_query("select * from user where id='".$gonderen_id."' ");
		$uye_row=mysql_fetch_object($uye_sorgu);
		if($uye_row->user_token != ""){
			$gonderen_token=$uye_row->user_token;
		}else if($uye_row->kurumsal_user_token != ""){
			$gonderen_token=$uye_row->kurumsal_user_token;
		}
		$adate=date("Y-m-d H:i:s");
		$duration=1;
		$dateinsec=strtotime($adate);
		$newdate=$dateinsec+$duration;
		$adate=date('Y-m-d H:i:s',$newdate);
		$sorgu=mysql_query("select * from kullanicilar where id='".$admin_id."' ");
		$row=mysql_fetch_object($sorgu);
		$admin_token=$row->token;
		$kaydet=mysql_query("insert into mesajlar
			(id,ilan_id,gonderen_id,alan_id,dogrudan_satis_id,mesaj,gonderme_zamani,gonderen_token,alan_token) 
				values
			(null,'','0','".$gonderen_id."','".$ilan_id."','".$mesaj."','".date("Y-m-d H:i:s")."','".$admin_token."','".$gonderen_token."') ");
		
	echo json_encode($response);
	}
	if(re("action")=="panel_admin_mesaj_cevapla"){
		$response=[];
	
		$mesaj_id=re("mesaj_id");
		$ilan_id=re("ilan_id");
		$gonderen_id=re("gonderen_id");
		$mesaj=re("admin_mesaj");
		$eski_mesaj=re("eski_mesaj");
		$eski_mesaj_tarih=re("eski_mesaj_tarih");
		$admin_id=re("admin_id");
		$uye_sorgu=mysql_query("select * from user where id='".$gonderen_id."' ");
		$uye_row=mysql_fetch_object($uye_sorgu);
		if($uye_row->user_token != ""){
			$gonderen_token=$uye_row->user_token;
		}else if($uye_row->kurumsal_user_token != ""){
			$gonderen_token=$uye_row->kurumsal_user_token;
		}
		/*$adate=date("Y-m-d H:i:s");
		$duration=1;
		$dateinsec=strtotime($adate);
		$newdate=$dateinsec+$duration;
		$adate=date('Y-m-d H:i:s',$newdate);*/
		$sorgu=mysql_query("select * from kullanicilar where id='".$admin_id."' ");
		$row=mysql_fetch_object($sorgu);
		$admin_token=$row->token;
		
		$kaydet=mysql_query("insert into mesajlar
			(id,ilan_id,gonderen_id,alan_id,dogrudan_satis_id,mesaj,gonderme_zamani,gonderen_token,alan_token) 
			values
			(null,'".$ilan_id."','0','".$gonderen_id."','','".$mesaj."','".date("Y-m-d H:i:s")."','".$admin_token."','".$gonderen_token."') ");
		$guncelle=mysql_query("update mesajlar set durum=1 where id='".$mesaj_id."'");
		
	echo json_encode($response);
}
	if(re("action")=="cikis_yap"){
		$response=[];
		$token=re("token");
		$sorgu=mysql_query("select * from user where user_token='".$token."' or kurumsal_user_token='".$token."'  ");
		$row=mysql_fetch_object($sorgu);
		$son_islem=$row->son_islem_zamani;
		$son_islem_str = strtotime($son_islem);
		$suan = date("Y-m-d H:i:s");
		$suan_str = strtotime($suan);
		if($suan_str-$son_islem_str>299 ){
			if($token != ""){
				$guncelle=mysql_query("update user set online_durum=0 where user_token='".$token."' or kurumsal_user_token='".$token."'  ");	
				if($guncelle){
					$response=[""=>"Durum 0 oldu"];
				}
			}else{
				$response=[""=>$token];
			}
			
		}else{
			$response=[""=>"Durum 1"];
		}
		echo json_encode($response);
	}
	if(re("action")=="son_islem"){
		$response=[];
		$token=re("token");
		$a1 = $_SERVER['HTTP_USER_AGENT'];    
		$os= getOS();
		if($token != ""){
			$guncelle=mysql_query("update user set son_islem_zamani='".date("Y-m-d H:i:s")."',online_durum=1,son_islem_isletim_sistemi='".$os."' where user_token='".$token."' or kurumsal_user_token='".$token."'  ");	
			
		}
		echo json_encode($response);
	}
	if(re("action")=="panel_teklif"){	
		$response=[];
		$uyari_kabul=re("uyari_durum");
		$verilen_teklif = re("teklif");
		$ilanID = re('ilan_id');
		/*$uyeID=re('uye_id');*/
		$uye_id=re('uye_id');
		$kaynak_id=re('kaynak_id');
		$date = date('Y-m-d H:i:s');
		$ip=re("ip");
		$tarayici=re("tarayici");
		$isletim_sistemi=re("isletim_sistemi");
		$yeni_saat=re("yeni_saat");
		$admin_id=re("admin_id");
		//$hizmet_bedel=re("hizmet_bedel");
		//Hurda Belgeli
		if($kaynak_id !="" && $uye_id !=""){
			$response=["message"=>"Sadece 1 üye seçmelisiniz","status"=>500];
		}else if($kaynak_id =="" && $uye_id ==""){
			$response=["message"=>"Üye seçmelisiniz","status"=>500];
		}
		else{
			if($kaynak_id !="" && $uye_id == "" ){
				$uyeID=re('kaynak_id');
			}else if($uye_id != ""  && $kaynak_id == "" ){
				$uyeID=re('uye_id');
			}
			$u_sql=mysql_query("select * from user where id='".$uyeID."' ");
			$u_row=mysql_fetch_object($u_sql);
			$token=$u_row->user_token;
			$k_token=$u_row->kurumsal_user_token;
		
			$sorgu=mysql_query("select * from ilanlar where id='".$ilanID."' ");
			$row=mysql_fetch_object($sorgu);

			if($row->pd_hizmet>0){
				$hizmet_bedel=$row->pd_hizmet;
			}else{
				$hesaplama=$row->hesaplama;
				$sorgu = mysql_query("SELECT * FROM komisyon_oranlari WHERE sigorta_id = '".$row->sigorta."'");
				$oran = array();
				$standart_net = array();
				$luks_net = array();
				$standart_onbinde = array();
				$luks_onbinde = array();
				while($sonuc = mysql_fetch_array($sorgu)){
					array_push($oran, $sonuc['komisyon_orani']);
					array_push($standart_net, $sonuc['net']);
					array_push($luks_net, $sonuc['lux_net']);
					array_push($standart_onbinde, $sonuc['onbinde']);
					array_push($luks_onbinde, $sonuc['lux_onbinde']);
				}
				$oran_sayisi=count($oran);
				if($hesaplama=="Standart"){
					$durum=false;
					for ($i = 0; $i < $oran_sayisi; $i++) {
						if($verilen_teklif <= $oran[$i]){
							$oran1 = $oran[$i];
							$standart_net1 = $standart_net[$i];
							$standart_onbinde1 = $standart_onbinde[$i];
							$ek_gider = $verilen_teklif * $standart_onbinde1 / 10000;							
							$son_komisyon = ceil($ek_gider + $standart_net1);  
							break;
						}else{
							$durum=true;
						}
					} 
					$max_index=0;
					for ($j = 0; $j < $oran_sayisi; $j++) {
						if($oran[$j] == max($oran) ){
							$max_index=$j;
						}
					}
				
					if($durum==true){
						if($verilen_teklif > max($oran) ){
							$oran1 = max($oran);
							$standart_net1 = $standart_net[$max_index];
							$standart_onbinde1 = (int)$standart_onbinde[$max_index];					
							$ek_gider = $verilen_teklif * $standart_onbinde1 / 10000;
							
							$son_komisyon = ceil($ek_gider + $standart_net1);   	
						}
					}
				} 
				else{
					$durum=false;
					for($i = 0; $i < $oran_sayisi; $i++) {
						if($verilen_teklif <= $oran[$i]){
							$oran1 = $oran[$i];
							$luks_net1 = $luks_net[$i];
							$luks_onbinde1 = $luks_onbinde[$i];
							$ek_gider = $verilen_teklif * $luks_onbinde1 / 10000;
							$son_komisyon = ceil($ek_gider + $luks_net1);  
							break;
						}else{
							$durum=true;
						}
					} 
					$max_index=0;
					for ($j = 0; $j < $oran_sayisi; $j++) {
						if($oran[$j] == max($oran) ){
							$max_index=$j;
						}
					}
					if($durum==true){
						if($verilen_teklif > max($oran) ){
							$oran1 = max($oran);
							$luks_net1 = $luks_net[$max_index];
							$luks_onbinde1 = (int)$luks_onbinde[$max_index];					
							$ek_gider = $verilen_teklif * $luks_onbinde1 / 10000;
							$son_komisyon = ceil($ek_gider + $luks_net1);   	
						}
					}
				}
				
				$hizmet_bedel=$son_komisyon;
			}	
			
			
			$sigorta_id=$row->sigorta;
			$i_tarihi=$row->ihale_tarihi;
			$i_saati=$row->ihale_saati;
			$sorgu2=mysql_query("select * from teklif_limiti where uye_id='".$uyeID."' ");
			$row2=mysql_fetch_object($sorgu2);

			$uyenin_durumu_cek = mysql_query("SELECT * FROM uye_durumlari WHERE uye_id = '".$uyeID."'");
			$uyenin_durumu = mysql_fetch_assoc($uyenin_durumu_cek);
			$otomatik_teklif_engelle = $uyenin_durumu['otomatik_teklif_engelle'];
			
			
			$engelli_sigorta="false";

			$uye_engelli_sigortalar = explode(",",$uyenin_durumu['yasak_sigorta']);
			for($h=0;$h<count($uye_engelli_sigortalar);$h++){
				if($sigorta_id==$uye_engelli_sigortalar[$h]){
					$engelli_sigorta="true";
				}
			}
			
			
			$teklif_engelle = $uyenin_durumu['teklif_engelle'];
			$engelleme_nedeni = $uyenin_durumu['engelleme_nedeni'];
			$hurda_teklif = $uyenin_durumu['hurda_teklif'];
			$ilan_durumu_cek = mysql_query("SELECT * FROM ilanlar WHERE id = '".$ilanID."'");
			$ilan_durumu_oku = mysql_fetch_assoc($ilan_durumu_cek);
			$hurda_durumu = $ilan_durumu_oku['profil'];	
			$sorgu3=mysql_query("select * from sigorta_ozellikleri where id='".$sigorta_id."'");
			$row3=mysql_fetch_object($sorgu3);
			$sigorta_min_artis=$row3->minumum_artis;
			
			
			// $toplam_borc = mysql_query('SELECT SUM(net) AS net FROM cayma_bedelleri WHERE uye_id = "'.$uyeID.'" and durum=2'); 
			// $toplam_borc_getir = mysql_fetch_assoc($toplam_borc); 
			// $toplam_borc_cayma = $toplam_getir['net'];
			// $cayma=$toplam_cayma+toplam_borc_cayma;
			/*
			$aktif_cayma_toplam=mysql_query("SELECT SUM(tutar) as toplam_aktif_cayma FROM cayma_bedelleri WHERE uye_id='".$kullanici_oku['id']."' AND durum=1 ");
			$toplam_aktif_cayma=mysql_fetch_assoc($aktif_cayma_toplam);
			$iade_talepleri_toplam=mysql_query("SELECT SUM(tutar) as toplam_iade_talepleri FROM cayma_bedelleri WHERE uye_id='".$kullanici_oku['id']."' AND durum=2 ");
			$toplam_iade_talepleri=mysql_fetch_assoc($iade_talepleri_toplam);
			$borclar_toplam=mysql_query("SELECT SUM(tutar) as toplam_borclar FROM cayma_bedelleri WHERE uye_id='".$kullanici_oku['id']."' AND durum=6 ");
			$toplam_borclar=mysql_fetch_assoc($borclar_toplam);
			$cayma=$toplam_aktif_cayma["toplam_aktif_cayma"]-$toplam_iade_talepleri["toplam_iade_talepleri"]-$toplam_borclar["toplam_borclar"];
			*/


			$aktif_cayma_toplam=mysql_query("SELECT COALESCE(SUM(tutar),0) as toplam_aktif_cayma FROM cayma_bedelleri WHERE uye_id='".$uyeID."' AND durum=1");
			$toplam_aktif_cayma=mysql_fetch_assoc($aktif_cayma_toplam);		
			$iade_talepleri_toplam=mysql_query("SELECT COALESCE(SUM(tutar),0) as toplam_iade_talepleri FROM cayma_bedelleri WHERE uye_id='".$uyeID."' AND durum=2");
			$toplam_iade_talepleri=mysql_fetch_assoc($iade_talepleri_toplam);
			$borclar_toplam=mysql_query("SELECT COALESCE(SUM(tutar),0) as toplam_borclar FROM cayma_bedelleri WHERE uye_id='".$uyeID."' AND durum=6");
			$toplam_borclar=mysql_fetch_assoc($borclar_toplam);
			$cayma=$toplam_aktif_cayma["toplam_aktif_cayma"]-$toplam_iade_talepleri["toplam_iade_talepleri"]-$toplam_borclar["toplam_borclar"];


			
			$uye_paket=$u_row->paket;
			$uye_paket_cek=mysql_query("select * from uye_grubu where id='".$uye_paket."'");
			$uye_paket_oku=mysql_fetch_object($uye_paket_cek);
			
			if($row->hesaplama=="Standart"){
				if($row2->standart_limit>0){
					$teklif_limiti=$row2->standart_limit;
				}else{
					$teklif_limiti = 0;
					//$teklif_limiti=$uye_paket_oku->standart_ust_limit;
					$grup_cek=mysql_query("select * from uye_grubu_detaylari where grup_id='".$uye_paket."' and cayma_bedeli <= '".$cayma."' order by cayma_bedeli desc limit 1");
					$grup_oku = mysql_fetch_object($grup_cek);
					$teklif_limiti =$grup_oku->standart_ust_limit;	
					/*
					$grup_cek=mysql_query("select * from uye_grubu_detaylari where grup_id='".$uye_paket."' order by cayma_bedeli asc");
					while($grup_oku=mysql_fetch_array($grup_cek)){
						if($cayma>=$grup_oku["cayma_bedeli"]){
							$teklif_limiti =$grup_oku["standart_ust_limit"];		
						}
					}
					*/
				}
			}else{
				if($row2->luks_limit>0){
					$teklif_limiti=$row2->luks_limit;
				}else{
					$teklif_limiti = 0;		
					//$teklif_limiti=$uye_paket_oku->luks_ust_limit;
					$grup_cek=mysql_query("select * from uye_grubu_detaylari where grup_id='".$uye_paket."' and cayma_bedeli <= '".$cayma."' order by cayma_bedeli desc limit 1");
					$grup_oku = mysql_fetch_object($grup_cek);
					$teklif_limiti =$grup_oku->luks_ust_limit;	
					/*
					$grup_cek=mysql_query("select * from uye_grubu_detaylari where grup_id='".$uye_paket."' order by cayma_bedeli asc");
					while($grup_oku=mysql_fetch_array($grup_cek)){
						if($cayma>=$grup_oku["cayma_bedeli"]){
							$teklif_limiti =$grup_oku["luks_ust_limit"];		
						}
					}
					*/
				}
			}
			if(re('kaynak_id') == 283){
				$teklif_limiti = 2147483647;
			}

			if($row->ihale_turu==1){
				if($hurda_durumu=="Hurda Belgeli"){
						if($hurda_teklif != "on"){
							$islem_durum = 0;
							$response = ["message"=>"Hurda araçlara teklif veremez.","status"=>500];
						}elseif($teklif_engelle=="on"){
							$islem_durum = 0;
							if($engelleme_nedeni ==""){
								$response = ["message"=>"Teklif verme yetkileriniz geçici olarak durdurulmuştur.","status"=>500];
							}else{
								$response = ["message"=>"$engelleme_nedeni","status"=>500];
							}
						}else if($otomatik_teklif_engelle=="on" ){
							$islem_durum = 0;
							$response = ["message"=>"Sistem tarafından teklif vermeniz kısıtlanmıştır.Müşteri temsilcileri ile iletişimi geçebilirsiniz.","status"=>500];
						}else if($engelli_sigorta=="true" ){
							$response = ["message"=>"İlanın sigorta şirketine ait olan araçlara teklif vermeniz kısıtlanmıştır.","status"=>500];
						}else{
							if($verilen_teklif == ""){
								if($yeni_saat != ""){
									if((date("Y-m-d H:i:s")>$i_tarihi." ".$yeni_saat.":00") && ($row->ihale_tarihi." ".$row->ihale_saati > date("Y-m-d H:i:s"))  ){
										if($uyari_kabul!=1){
											$islem_durum = 0;
											$response = ["message"=>"Belirlemek istediğiniz saat ihalenin kapanmasına neden oluyor.İşlemi yapmak için uyarıları kabul etmelisiniz.","status"=>500,"ihale_durum"=>1];
										}else{
											$y_trh=$i_tarihi." ".$yeni_saat.":00";
											$gosterilme_tarih=strtotime($y_trh)+300; //Gösterilme süresi 5 dk fazla olması istendi
											$gosterilme_tarih=date("Y-m-d H:i:s",$gosterilme_tarih);
											mysql_query("update ilanlar set ihale_saati='".$yeni_saat."',ihale_son_gosterilme='".$gosterilme_tarih."' where id='".$ilanID."' ");
											$response=["message"=>"","status"=>200];
											$islem_durum = 1;
										}
									}else if( ($row->ihale_tarihi." ".$row->ihale_saati < date("Y-m-d H:i:s")) && (date("Y-m-d H:i:s") < $i_tarihi." ".$yeni_saat.":00")){
										if($uyari_kabul!=1){
											$islem_durum = 0;
											$response=["message"=>"Belirlemek istediğiniz saat ihalenin açılamasına neden oluyor.İşlemi yapmak için uyarıları kabul etmelisiniz.","status"=>500,"ihale_durum"=>1];
										}else{
											$y_trh=$i_tarihi." ".$yeni_saat.":00";
											$gosterilme_tarih=strtotime($y_trh)+300; //Gösterilme süresi 5 dk fazla olması istendi
											$gosterilme_tarih=date("Y-m-d H:i:s",$gosterilme_tarih);
											mysql_query("update ilanlar set ihale_saati='".$yeni_saat."',ihale_son_gosterilme='".$gosterilme_tarih."' where id='".$ilanID."' ");
											$ilan_cek = mysql_query("SELECT * FROM ilanlar WHERE id = '".$ilanID."'");
											$islem_durum = 1;
											$response=["message"=>"","status"=>200];
										}
									}else{
										$y_trh=$i_tarihi." ".$yeni_saat.":00";
										$gosterilme_tarih=strtotime($y_trh)+300; //Gösterilme süresi 5 dk fazla olması istendi
										$gosterilme_tarih=date("Y-m-d H:i:s",$gosterilme_tarih);
										mysql_query("update ilanlar set ihale_saati='".$yeni_saat."',ihale_son_gosterilme='".$gosterilme_tarih."' where id='".$ilanID."' ");
										$response=["message"=>"","status"=>200];
										$islem_durum = 1;
									}
								}else{
									$islem_durum = 0;
									$response=["message"=>"Teklifiniz boş olamaz","status"=>500];
								}
							}  
							else if($verilen_teklif % $sigorta_min_artis != 0){
								$islem_durum = 0;
								$response=["message"=>"Teklifiniz $sigorta_min_artis ₺ katları olmalı","status"=>500];
							} 
							else if($verilen_teklif <= $row->acilis_fiyati  ){
								$islem_durum = 0;
								$response=["message"=>"Teklifiniz taban fiyat koşulunu sağlamamaktadır. İhalenin taban fiyatı $row->acilis_fiyati ₺'dir. ","status"=>500];
							} 
							
							else if($verilen_teklif >  $teklif_limiti  ){
								$islem_durum = 0;
								$response=["message"=>"Teklif limitiniz aştınız. Mevcut paketinizin teklif limiti '".money($teklif_limiti)."' ₺'dir. ","status"=>501];
							} 
							else if($verilen_teklif < $row->son_teklif+$sigorta_min_artis){
								$islem_durum = 0;
								$response=["message"=>"Teklfiniz en yüksek teklifden en az $sigorta_min_artis ₺ fazla olmalı ","status"=>500];
							}  
							else{
								if($yeni_saat != ""){
									if((date("Y-m-d H:i:s")>$i_tarihi." ".$yeni_saat.":00") && ($row->ihale_tarihi." ".$row->ihale_saati > date("Y-m-d H:i:s"))  ){
										if($uyari_kabul!=1){
											$islem_durum = 0;
											$response = ["message"=>"Belirlemek istediğiniz saat ihalenin kapanmasına neden oluyor.İşlemi yapmak için uyarıları kabul etmelisiniz.","status"=>500,"ihale_durum"=>1];
										}else{
											$y_trh=$i_tarihi." ".$yeni_saat.":00";
											$gosterilme_tarih=strtotime($y_trh)+300; //Gösterilme süresi 5 dk fazla olması istendi
											$gosterilme_tarih=date("Y-m-d H:i:s",$gosterilme_tarih);
											mysql_query("update ilanlar set ihale_saati='".$yeni_saat."',ihale_son_gosterilme='".$gosterilme_tarih."' where id='".$ilanID."' ");
											$ilan_cek = mysql_query("SELECT * FROM ilanlar WHERE id = '".$ilanID."'");
											while($ilan_oku = mysql_fetch_array($ilan_cek)){
												$teklif = $ilan_oku['son_teklif'];
												if($verilen_teklif > $teklif){
													$ihale_bitis=$ilan_oku["ihale_tarihi"]." ".$ilan_oku["ihale_saati"];
													$sigorta_sure_uzatma_durumu=$row3->sure_uzatma;
													$sigorta_dakikanin_altinda=$row3->dakikanin_altinda;
													$sigorta_dakika_uzar=$row3->dakika_uzar;
													if($sigorta_sure_uzatma_durumu=="1"){
														$yeni_trh=strtotime("+".$sigorta_dakika_uzar." minutes",strtotime($ihale_bitis));
														$yeni_trh=date("Y-m-d H:i:s",$yeni_trh);
														$explode=explode(" ",$yeni_trh);
														$yeni_t=$explode[0];
														$yeni_s=$explode[1];
														$date=date("Y-m-d H:i:s");
														$tarih=strtotime("-".$sigorta_dakikanin_altinda." minutes",strtotime($ihale_bitis));
														$tarih=date("Y-m-d H:i:s",$tarih);
														if($date>$tarih){
															$gosterilme_tarih=strtotime($yeni_trh)+300; //Gösterilme süresi 5 dk fazla olması istendi
															$gosterilme_tarih=date("Y-m-d H:i:s",$gosterilme_tarih);
															mysql_query("UPDATE ilanlar SET son_teklif = '".$verilen_teklif."',ihale_tarihi='".$yeni_t."', ihale_saati='".$yeni_s."' , ihale_son_gosterilme='".$gosterilme_tarih."' WHERE id='".$ilanID."'");
														}else{
															mysql_query("UPDATE ilanlar SET son_teklif = '".$verilen_teklif."' WHERE id='".$ilanID."'");
														}
													}else{
														mysql_query("UPDATE ilanlar SET son_teklif = '".$verilen_teklif."' WHERE id='".$ilanID."'");
													}
												}
											}
											if($token != ""){
												mysql_query("INSERT INTO `teklifler`(`id`,`ilan_id`,`uye_id`,`teklif`,`hizmet_bedeli`,`teklif_zamani`,`user_token`,`dogrudan_satisli_ilan_id`,`kurumsal_token`,ip,tarayici,isletim_sistemi,admin_teklif,admin_id,durum) 
												VALUES (NULL,'".$ilanID."','".$uyeID."','".$verilen_teklif."','".$hizmet_bedel."','".$date."','".$token."','','0','".$ip."','".$tarayici."','".$isletim_sistemi."','1','".$admin_id."','1')");
											}elseif($k_token !=""){
												mysql_query("INSERT INTO `teklifler`(`id`,`ilan_id`,`uye_id`,`teklif`,`hizmet_bedeli`,`teklif_zamani`,`user_token`,`dogrudan_satisli_ilan_id`,`kurumsal_token`,ip,tarayici,isletim_sistemi,admin_teklif,admin_id,durum) 
												VALUES (NULL,'".$ilanID."','".$uyeID."','".$verilen_teklif."','".$hizmet_bedel."','".$date."','','0','".$k_token."','".$ip."','".$tarayici."','".$isletim_sistemi."','1','".$admin_id."','1')");
											}
											$response=["message"=>"","status"=>200];
											$islem_durum = 1;
										}
									}else if( ($row->ihale_tarihi." ".$row->ihale_saati < date("Y-m-d H:i:s")) && (date("Y-m-d H:i:s") < $i_tarihi." ".$yeni_saat.":00")){
										if($uyari_kabul!=1){
											$islem_durum = 0;
											$response=["message"=>"Belirlemek istediğiniz saat ihalenin açılamasına neden oluyor.İşlemi yapmak için uyarıları kabul etmelisiniz.","status"=>500,"ihale_durum"=>1];
										}else{
											$y_trh=$i_tarihi." ".$yeni_saat.":00";
											$gosterilme_tarih=strtotime($y_trh)+300; //Gösterilme süresi 5 dk fazla olması istendi
											$gosterilme_tarih=date("Y-m-d H:i:s",$gosterilme_tarih);
											mysql_query("update ilanlar set ihale_saati='".$yeni_saat."',ihale_son_gosterilme='".$gosterilme_tarih."' where id='".$ilanID."' ");
											$ilan_cek = mysql_query("SELECT * FROM ilanlar WHERE id = '".$ilanID."'");
											while($ilan_oku = mysql_fetch_array($ilan_cek)){
												$teklif = $ilan_oku['son_teklif'];
												if($verilen_teklif > $teklif){
													$ihale_bitis=$ilan_oku["ihale_tarihi"]." ".$ilan_oku["ihale_saati"];
													$sigorta_sure_uzatma_durumu=$row3->sure_uzatma;
													$sigorta_dakikanin_altinda=$row3->dakikanin_altinda;
													$sigorta_dakika_uzar=$row3->dakika_uzar;
													if($sigorta_sure_uzatma_durumu=="1"){
														$yeni_trh=strtotime("+".$sigorta_dakika_uzar." minutes",strtotime($ihale_bitis));
														$yeni_trh=date("Y-m-d H:i:s",$yeni_trh);
														$explode=explode(" ",$yeni_trh);
														$yeni_t=$explode[0];
														$yeni_s=$explode[1];
														$date=date("Y-m-d H:i:s");
														$tarih=strtotime("-".$sigorta_dakikanin_altinda." minutes",strtotime($ihale_bitis));
														$tarih=date("Y-m-d H:i:s",$tarih);
														if($date>$tarih){
															$gosterilme_tarih=strtotime($yeni_trh)+300; //Gösterilme süresi 5 dk fazla olması istendi
															$gosterilme_tarih=date("Y-m-d H:i:s",$gosterilme_tarih);
															mysql_query("UPDATE ilanlar SET son_teklif = '".$verilen_teklif."',ihale_tarihi='".$yeni_t."', ihale_saati='".$yeni_s."',ihale_son_gosterilme='".$gosterilme_tarih."' WHERE id='".$ilanID."'");
														}else{
															mysql_query("UPDATE ilanlar SET son_teklif = '".$verilen_teklif."' WHERE id='".$ilanID."'");
														}
													}else{
														mysql_query("UPDATE ilanlar SET son_teklif = '".$verilen_teklif."' WHERE id='".$ilanID."'");
													}
												}
											}
											if($token != ""){
											mysql_query("INSERT INTO `teklifler`(`id`,`ilan_id`,`uye_id`,`teklif`,`hizmet_bedeli`,`teklif_zamani`,`user_token`,`dogrudan_satisli_ilan_id`,`kurumsal_token`,ip,tarayici,isletim_sistemi,admin_teklif,admin_id,durum) 
											VALUES (NULL,'".$ilanID."','".$uyeID."','".$verilen_teklif."','".$hizmet_bedel."','".$date."','".$token."','','0','".$ip."','".$tarayici."','".$isletim_sistemi."','1','".$admin_id."','1')");
											
											}elseif($k_token !=""){
												mysql_query("INSERT INTO `teklifler`(`id`,`ilan_id`,`uye_id`,`teklif`,`hizmet_bedeli`,`teklif_zamani`,`user_token`,`dogrudan_satisli_ilan_id`,`kurumsal_token`,ip,tarayici,isletim_sistemi,admin_teklif,admin_id,durum) 
												VALUES (NULL,'".$ilanID."','".$uyeID."','".$verilen_teklif."','".$hizmet_bedel."','".$date."','','0','".$k_token."','".$ip."','".$tarayici."','".$isletim_sistemi."','1','".$admin_id."','1')");
											
											}
											$response=["message"=>"","status"=>200];
											$islem_durum = 1;
										}
									}else{
										$y_trh=$i_tarihi." ".$yeni_saat.":00";
										$gosterilme_tarih=strtotime($y_trh)+300; //Gösterilme süresi 5 dk fazla olması istendi
										$gosterilme_tarih=date("Y-m-d H:i:s",$gosterilme_tarih);
										mysql_query("update ilanlar set ihale_saati='".$yeni_saat."',ihale_son_gosterilme='".$gosterilme_tarih."' where id='".$ilanID."' ");

										$ilan_cek = mysql_query("SELECT * FROM ilanlar WHERE id = '".$ilanID."'");
										while($ilan_oku = mysql_fetch_array($ilan_cek)){
											$teklif = $ilan_oku['son_teklif'];
											if($verilen_teklif > $teklif){
												$ihale_bitis=$ilan_oku["ihale_tarihi"]." ".$ilan_oku["ihale_saati"];
												$sigorta_sure_uzatma_durumu=$row3->sure_uzatma;
												$sigorta_dakikanin_altinda=$row3->dakikanin_altinda;
												$sigorta_dakika_uzar=$row3->dakika_uzar;
												if($sigorta_sure_uzatma_durumu=="1"){
													$yeni_trh=strtotime("+".$sigorta_dakika_uzar." minutes",strtotime($ihale_bitis));
													$yeni_trh=date("Y-m-d H:i:s",$yeni_trh);
													$explode=explode(" ",$yeni_trh);
													$yeni_t=$explode[0];
													$yeni_s=$explode[1];
													$date=date("Y-m-d H:i:s");
													$tarih=strtotime("-".$sigorta_dakikanin_altinda." minutes",strtotime($ihale_bitis));
													$tarih=date("Y-m-d H:i:s",$tarih);
													if($date>$tarih){
														$y_trh=$i_tarihi." ".$yeni_saat.":00";
														$gosterilme_tarih=strtotime($y_trh)+300; //Gösterilme süresi 5 dk fazla olması istendi
														$gosterilme_tarih=date("Y-m-d H:i:s",$gosterilme_tarih);
														mysql_query("update ilanlar set ihale_saati='".$yeni_saat."',ihale_son_gosterilme='".$gosterilme_tarih."' where id='".$ilanID."' ");
													}else{
														mysql_query("UPDATE ilanlar SET son_teklif = '".$verilen_teklif."' WHERE id='".$ilanID."'");
													}
												}else{
													mysql_query("UPDATE ilanlar SET son_teklif = '".$verilen_teklif."' WHERE id='".$ilanID."'");
												}
											}
										}
										if($token != ""){
										mysql_query("INSERT INTO `teklifler`(`id`,`ilan_id`,`uye_id`,`teklif`,`hizmet_bedeli`,`teklif_zamani`,`user_token`,`dogrudan_satisli_ilan_id`,`kurumsal_token`,ip,tarayici,isletim_sistemi,admin_teklif,admin_id,durum) 
										VALUES (NULL,'".$ilanID."','".$uyeID."','".$verilen_teklif."','".$hizmet_bedel."','".$date."','".$token."','','0','".$ip."','".$tarayici."','".$isletim_sistemi."','1','1')");
										
										}elseif($k_token !=""){
											mysql_query("INSERT INTO `teklifler`(`id`,`ilan_id`,`uye_id`,`teklif`,`hizmet_bedeli`,`teklif_zamani`,`user_token`,`dogrudan_satisli_ilan_id`,`kurumsal_token`,ip,tarayici,isletim_sistemi,admin_teklif,admin_id,durum) 
											VALUES (NULL,'".$ilanID."','".$uyeID."','".$verilen_teklif."','".$hizmet_bedel."','".$date."','','0','".$k_token."','".$ip."','".$tarayici."','".$isletim_sistemi."','1','".$admin_id."','1')");
										}
										$islem_durum = 1;
										$response=["message"=>"","status"=>200];
									}
								}else{
									if($row->ihale_tarihi." ".$row->ihale_saati < date("Y-m-d H:i:s")){
										$islem_durum = 0;
										$response=["message"=>"İhalenin süresi dolmuştur.","status"=>500];
									}else{
										$ilan_cek = mysql_query("SELECT * FROM ilanlar WHERE id = '".$ilanID."'");
										while($ilan_oku = mysql_fetch_array($ilan_cek)){
											$teklif = $ilan_oku['son_teklif'];
											if($verilen_teklif > $teklif){
												$ihale_bitis=$ilan_oku["ihale_tarihi"]." ".$ilan_oku["ihale_saati"];
												$sigorta_sure_uzatma_durumu=$row3->sure_uzatma;
												$sigorta_dakikanin_altinda=$row3->dakikanin_altinda;
												$sigorta_dakika_uzar=$row3->dakika_uzar;
												if($sigorta_sure_uzatma_durumu=="1"){
													$yeni_trh=strtotime("+".$sigorta_dakika_uzar." minutes",strtotime($ihale_bitis));
													$yeni_trh=date("Y-m-d H:i:s",$yeni_trh);
													$explode=explode(" ",$yeni_trh);
													$yeni_t=$explode[0];
													$yeni_s=$explode[1];
													$date=date("Y-m-d H:i:s");
													$tarih=strtotime("-".$sigorta_dakikanin_altinda." minutes",strtotime($ihale_bitis));
													$tarih=date("Y-m-d H:i:s",$tarih);
													if($date>$tarih){
														$gosterilme_tarih=strtotime($yeni_trh)+300; //Gösterilme süresi 5 dk fazla olması istendi
														$gosterilme_tarih=date("Y-m-d H:i:s",$gosterilme_tarih);
														mysql_query("UPDATE ilanlar SET son_teklif = '".$verilen_teklif."',ihale_tarihi='".$yeni_t."', ihale_saati='".$yeni_s."' , ihale_son_gosterilme='".$gosterilme_tarih."' WHERE id='".$ilanID."'");
													}else{
														mysql_query("UPDATE ilanlar SET son_teklif = '".$verilen_teklif."' WHERE id='".$ilanID."'");
													}
												}else{
													mysql_query("UPDATE ilanlar SET son_teklif = '".$verilen_teklif."' WHERE id='".$ilanID."'");
												}
											}
										}
										if($token != ""){
										mysql_query("INSERT INTO `teklifler`(`id`,`ilan_id`,`uye_id`,`teklif`,`hizmet_bedeli`,`teklif_zamani`,`user_token`,`dogrudan_satisli_ilan_id`,`kurumsal_token`,ip,tarayici,isletim_sistemi,admin_teklif,admin_id,durum) 
										VALUES (NULL,'".$ilanID."','".$uyeID."','".$verilen_teklif."','".$hizmet_bedel."','".$date."','".$token."','','0','".$ip."','".$tarayici."','".$isletim_sistemi."','1','".$admin_id."','1')");
										}elseif($k_token !=""){
											mysql_query("INSERT INTO `teklifler`(`id`,`ilan_id`,`uye_id`,`teklif`,`hizmet_bedeli`,`teklif_zamani`,`user_token`,`dogrudan_satisli_ilan_id`,`kurumsal_token`,ip,tarayici,isletim_sistemi,admin_teklif,admin_id,durum) 
											VALUES (NULL,'".$ilanID."','".$uyeID."','".$verilen_teklif."','".$hizmet_bedel."','".$date."','','0','".$k_token."','".$ip."','".$tarayici."','".$isletim_sistemi."','1','".$admin_id."','1')");
										}
										$islem_durum = 1;
										$response=["message"=>"","status"=>200];
									}
								}
							}
						}
				}else{
					if($teklif_engelle=="on"){
						$islem_durum = 0;
						if($engelleme_nedeni ==""){
							$response = ["message"=>"Teklif verme yetkileriniz geçici olarak durdurulmuştur.","status"=>500];
						}else{
							$response = ["message"=>"$engelleme_nedeni","status"=>500];
						}
					}else if($otomatik_teklif_engelle=="on" ){
						$islem_durum = 0;
						$response = ["message"=>"Sistem tarafından teklif vermeniz kısıtlanmıştır.Müşteri temsilcileri ile iletişimi geçebilirsiniz.","status"=>500];
					}else if($engelli_sigorta=="true"){
						$islem_durum = 0;
						$response = ["message"=>"İlanın sigorta şirketine ait olan araçlara teklif vermeniz kısıtlanmıştır.","status"=>500];
					}else{
						if($verilen_teklif == ""){
							if($yeni_saat != ""){
								if((date("Y-m-d H:i:s")>$i_tarihi." ".$yeni_saat.":00") && ($row->ihale_tarihi." ".$row->ihale_saati > date("Y-m-d H:i:s"))  ){
									if($uyari_kabul!=1){
										$islem_durum = 0;
										$response = ["message"=>"Belirlemek istediğiniz saat ihalenin kapanmasına neden oluyor.İşlemi yapmak için uyarıları kabul etmelisiniz.","status"=>500,"ihale_durum"=>1];
									}else{
										$y_trh=$i_tarihi." ".$yeni_saat.":00";
										$gosterilme_tarih=strtotime($y_trh)+300; //Gösterilme süresi 5 dk fazla olması istendi
										$gosterilme_tarih=date("Y-m-d H:i:s",$gosterilme_tarih);
										mysql_query("update ilanlar set ihale_saati='".$yeni_saat."',ihale_son_gosterilme='".$gosterilme_tarih."' where id='".$ilanID."' ");
										$response=["message"=>"","status"=>200];
										$islem_durum = 1;
									}
								}else if( ($row->ihale_tarihi." ".$row->ihale_saati < date("Y-m-d H:i:s")) && (date("Y-m-d H:i:s") < $i_tarihi." ".$yeni_saat.":00")){
									if($uyari_kabul!=1){
										$islem_durum = 0;
										$response=["message"=>"Belirlemek istediğiniz saat ihalenin açılamasına neden oluyor.İşlemi yapmak için uyarıları kabul etmelisiniz.","status"=>500,"ihale_durum"=>1];
									}else{
										$y_trh=$i_tarihi." ".$yeni_saat.":00";
										$gosterilme_tarih=strtotime($y_trh)+300; //Gösterilme süresi 5 dk fazla olması istendi
										$gosterilme_tarih=date("Y-m-d H:i:s",$gosterilme_tarih);
										mysql_query("update ilanlar set ihale_saati='".$yeni_saat."',ihale_son_gosterilme='".$gosterilme_tarih."' where id='".$ilanID."' ");
										$ilan_cek = mysql_query("SELECT * FROM ilanlar WHERE id = '".$ilanID."'");

										$response=["message"=>"","status"=>200];
										$islem_durum = 1;
									}
								}else{
									$y_trh=$i_tarihi." ".$yeni_saat.":00";
									$gosterilme_tarih=strtotime($y_trh)+300; //Gösterilme süresi 5 dk fazla olması istendi
									$gosterilme_tarih=date("Y-m-d H:i:s",$gosterilme_tarih);
									mysql_query("update ilanlar set ihale_saati='".$yeni_saat."',ihale_son_gosterilme='".$gosterilme_tarih."' where id='".$ilanID."' ");
									$response=["message"=>"","status"=>200];
									$islem_durum = 1;
								}
							}else{
								$islem_durum = 0;
								$response=["message"=>"Teklifiniz boş olamaz","status"=>500];
							}
						}  
						else if($verilen_teklif % $sigorta_min_artis != 0){
							$islem_durum = 0;
							$response=["message"=>"Teklifiniz $sigorta_min_artis ₺ katları olmalı","status"=>500];
						} 
						else if($verilen_teklif <= $row->acilis_fiyati  ){
							$islem_durum = 0;
							$response=["message"=>"Teklifiniz taban fiyat koşulunu sağlamamaktadır. İhalenin taban fiyatı $row->acilis_fiyati ₺'dir. ","status"=>500];
						} 			
						else if($verilen_teklif > $teklif_limiti  ){
							$islem_durum = 0;
							$response=["message"=>"Teklif limitiniz aştınız. Mevcut paketinizin teklif limiti '".money($teklif_limiti)."' ₺'dir. ","status"=>502,"cayma" => $cayma];
						} 
						else if($verilen_teklif < $row->son_teklif+$sigorta_min_artis){
							$response=["message"=>"Teklfiniz en yüksek teklifden en az $sigorta_min_artis ₺ fazla olmalı  ","status"=>500];
							$islem_durum = 0;
						}  
						else{
							if($yeni_saat != ""){
								if((date("Y-m-d H:i:s")>$i_tarihi." ".$yeni_saat.":00") && ($row->ihale_tarihi." ".$row->ihale_saati > date("Y-m-d H:i:s"))  ){
									if($uyari_kabul!=1){
										$response = ["message"=>"Belirlemek istediğiniz saat ihalenin kapanmasına neden oluyor.İşlemi yapmak için uyarıları kabul etmelisiniz.","status"=>500,"ihale_durum"=>1];
										$islem_durum = 0;
									}else{
										$y_trh=$i_tarihi." ".$yeni_saat.":00";
										$gosterilme_tarih=strtotime($y_trh)+300; //Gösterilme süresi 5 dk fazla olması istendi
										$gosterilme_tarih=date("Y-m-d H:i:s",$gosterilme_tarih);
										mysql_query("update ilanlar set ihale_saati='".$yeni_saat."',ihale_son_gosterilme='".$gosterilme_tarih."' where id='".$ilanID."' ");
										$ilan_cek = mysql_query("SELECT * FROM ilanlar WHERE id = '".$ilanID."'");
										while($ilan_oku = mysql_fetch_array($ilan_cek)){
											$teklif = $ilan_oku['son_teklif'];
											if($verilen_teklif > $teklif){
												$ihale_bitis=$ilan_oku["ihale_tarihi"]." ".$ilan_oku["ihale_saati"];
												$sigorta_sure_uzatma_durumu=$row3->sure_uzatma;
												$sigorta_dakikanin_altinda=$row3->dakikanin_altinda;
												$sigorta_dakika_uzar=$row3->dakika_uzar;
												if($sigorta_sure_uzatma_durumu=="1"){
													$yeni_trh=strtotime("+".$sigorta_dakika_uzar." minutes",strtotime($ihale_bitis));
													$yeni_trh=date("Y-m-d H:i:s",$yeni_trh);
													$explode=explode(" ",$yeni_trh);
													$yeni_t=$explode[0];
													$yeni_s=$explode[1];
													$date=date("Y-m-d H:i:s");
													$tarih=strtotime("-".$sigorta_dakikanin_altinda." minutes",strtotime($ihale_bitis));
													$tarih=date("Y-m-d H:i:s",$tarih);
													if($date>$tarih){
														$gosterilme_tarih=strtotime($yeni_trh)+300; //Gösterilme süresi 5 dk fazla olması istendi
														$gosterilme_tarih=date("Y-m-d H:i:s",$gosterilme_tarih);
														mysql_query("UPDATE ilanlar SET son_teklif = '".$verilen_teklif."',ihale_tarihi='".$yeni_t."', ihale_saati='".$yeni_s."' , ihale_son_gosterilme='".$gosterilme_tarih."' WHERE id='".$ilanID."'");
													}else{
														mysql_query("UPDATE ilanlar SET son_teklif = '".$verilen_teklif."' WHERE id='".$ilanID."'");
													}
												}else{
													mysql_query("UPDATE ilanlar SET son_teklif = '".$verilen_teklif."' WHERE id='".$ilanID."'");
												}
											}
										}
										if($token != ""){
											mysql_query("INSERT INTO `teklifler`(`id`,`ilan_id`,`uye_id`,`teklif`,`hizmet_bedeli`,`teklif_zamani`,`user_token`,`dogrudan_satisli_ilan_id`,`kurumsal_token`,ip,tarayici,isletim_sistemi,admin_teklif,admin_id,durum) 
											VALUES (NULL,'".$ilanID."','".$uyeID."','".$verilen_teklif."','".$hizmet_bedel."','".$date."','".$token."','','0','".$ip."','".$tarayici."','".$isletim_sistemi."','1','".$admin_id."','1')");
										}elseif($k_token !=""){
											mysql_query("INSERT INTO `teklifler`(`id`,`ilan_id`,`uye_id`,`teklif`,`hizmet_bedeli`,`teklif_zamani`,`user_token`,`dogrudan_satisli_ilan_id`,`kurumsal_token`,ip,tarayici,isletim_sistemi,admin_teklif,admin_id,durum) 
											VALUES (NULL,'".$ilanID."','".$uyeID."','".$verilen_teklif."','".$hizmet_bedel."','".$date."','','0','".$k_token."','".$ip."','".$tarayici."','".$isletim_sistemi."','1','".$admin_id."','1')");
										}
										$response=["message"=>"","status"=>200];
										$islem_durum = 1;
									}
								}else if( ($row->ihale_tarihi." ".$row->ihale_saati < date("Y-m-d H:i:s")) && (date("Y-m-d H:i:s") < $i_tarihi." ".$yeni_saat.":00")){
									if($uyari_kabul!=1){
										$response=["message"=>"Belirlemek istediğiniz saat ihalenin açılamasına neden oluyor.İşlemi yapmak için uyarıları kabul etmelisiniz.","status"=>500,"ihale_durum"=>1];
										$islem_durum = 0;
									}else{
										$y_trh=$i_tarihi." ".$yeni_saat.":00";
										$gosterilme_tarih=strtotime($y_trh)+300; //Gösterilme süresi 5 dk fazla olması istendi
										$gosterilme_tarih=date("Y-m-d H:i:s",$gosterilme_tarih);
										mysql_query("update ilanlar set ihale_saati='".$yeni_saat."',ihale_son_gosterilme='".$gosterilme_tarih."' where id='".$ilanID."' ");
										$ilan_cek = mysql_query("SELECT * FROM ilanlar WHERE id = '".$ilanID."'");
										while($ilan_oku = mysql_fetch_array($ilan_cek)){
											$teklif = $ilan_oku['son_teklif'];
											if($verilen_teklif > $teklif){
												$ihale_bitis=$ilan_oku["ihale_tarihi"]." ".$ilan_oku["ihale_saati"];
												$sigorta_sure_uzatma_durumu=$row3->sure_uzatma;
												$sigorta_dakikanin_altinda=$row3->dakikanin_altinda;
												$sigorta_dakika_uzar=$row3->dakika_uzar;
												if($sigorta_sure_uzatma_durumu=="1"){
													$yeni_trh=strtotime("+".$sigorta_dakika_uzar." minutes",strtotime($ihale_bitis));
													$yeni_trh=date("Y-m-d H:i:s",$yeni_trh);
													$explode=explode(" ",$yeni_trh);
													$yeni_t=$explode[0];
													$yeni_s=$explode[1];
													/*$mevcut_saat=$ilan_oku["ihale_saati"];
													$explode=explode(":",$mevcut_saat);
													$yeni_s=$explode[0]+$sigorta_dakika_uzar;
													$yeni_s=$yeni_saat.":".$explode[1];*/
													$date=date("Y-m-d H:i:s");
													$tarih=strtotime("-".$sigorta_dakikanin_altinda." minutes",strtotime($ihale_bitis));
													$tarih=date("Y-m-d H:i:s",$tarih);
													if($date>$tarih){
														$gosterilme_tarih=strtotime($yeni_trh)+300; //Gösterilme süresi 5 dk fazla olması istendi
														$gosterilme_tarih=date("Y-m-d H:i:s",$gosterilme_tarih);
														mysql_query("UPDATE ilanlar SET son_teklif = '".$verilen_teklif."',durum='1',ihale_saati='".$yeni_s."',ihale_son_gosterilme='".$gosterilme_tarih."' WHERE id='".$ilanID."'");
													}else{
														mysql_query("UPDATE ilanlar SET son_teklif = '".$verilen_teklif."' WHERE id='".$ilanID."'");
													}
												}else{
													mysql_query("UPDATE ilanlar SET son_teklif = '".$verilen_teklif."',durum='1' WHERE id='".$ilanID."'");
												}
											}
										}
										if($token != ""){
											mysql_query("INSERT INTO `teklifler`(`id`,`ilan_id`,`uye_id`,`teklif`,`hizmet_bedeli`,`teklif_zamani`,`user_token`,`dogrudan_satisli_ilan_id`,`kurumsal_token`,ip,tarayici,isletim_sistemi,admin_teklif,admin_id,durum) 
											VALUES (NULL,'".$ilanID."','".$uyeID."','".$verilen_teklif."','".$hizmet_bedel."','".$date."','".$token."','','0','".$ip."','".$tarayici."','".$isletim_sistemi."','1','".$admin_id."','1')");
										}elseif($k_token !=""){
											mysql_query("INSERT INTO `teklifler`(`id`,`ilan_id`,`uye_id`,`teklif`,`hizmet_bedeli`,`teklif_zamani`,`user_token`,`dogrudan_satisli_ilan_id`,`kurumsal_token`,ip,tarayici,isletim_sistemi,admin_teklif,admin_id,durum) 
											VALUES (NULL,'".$ilanID."','".$uyeID."','".$verilen_teklif."','".$hizmet_bedel."','".$date."','','0','".$k_token."','".$ip."','".$tarayici."','".$isletim_sistemi."','1','".$admin_id."','1')");
										}
										$response=["message"=>"","status"=>200];
										$islem_durum = 1;
									}
								}else{
									$y_trh=$i_tarihi." ".$yeni_saat.":00";
									$gosterilme_tarih=strtotime($y_trh)+300; //Gösterilme süresi 5 dk fazla olması istendi
									$gosterilme_tarih=date("Y-m-d H:i:s",$gosterilme_tarih);
									mysql_query("update ilanlar set ihale_saati='".$yeni_saat."',ihale_son_gosterilme='".$gosterilme_tarih."' where id='".$ilanID."' ");
									$ilan_cek = mysql_query("SELECT * FROM ilanlar WHERE id = '".$ilanID."'");
									while($ilan_oku = mysql_fetch_array($ilan_cek)){
										$teklif = $ilan_oku['son_teklif'];
										if($verilen_teklif > $teklif){
											$ihale_bitis=$ilan_oku["ihale_tarihi"]." ".$ilan_oku["ihale_saati"];
											$sigorta_sure_uzatma_durumu=$row3->sure_uzatma;
											$sigorta_dakikanin_altinda=$row3->dakikanin_altinda;
											$sigorta_dakika_uzar=$row3->dakika_uzar;
											if($sigorta_sure_uzatma_durumu=="1"){
												$yeni_trh=strtotime("+".$sigorta_dakika_uzar." minutes",strtotime($ihale_bitis));
												$yeni_trh=date("Y-m-d H:i:s",$yeni_trh);
												$explode=explode(" ",$yeni_trh);
												$yeni_t=$explode[0];
												$yeni_s=$explode[1];
												$date=date("Y-m-d H:i:s");
												$tarih=strtotime("-".$sigorta_dakikanin_altinda." minutes",strtotime($ihale_bitis));
												$tarih=date("Y-m-d H:i:s",$tarih);
												if($date>$tarih){
													$gosterilme_tarih=strtotime($yeni_trh)+300; //Gösterilme süresi 5 dk fazla olması istendi
													$gosterilme_tarih=date("Y-m-d H:i:s",$gosterilme_tarih);
													mysql_query("UPDATE ilanlar SET son_teklif = '".$verilen_teklif."',ihale_tarihi='".$yeni_t."', ihale_saati='".$yeni_s."' , ihale_son_gosterilme='".$gosterilme_tarih."' WHERE id='".$ilanID."'");
												}else{
													mysql_query("UPDATE ilanlar SET son_teklif = '".$verilen_teklif."' WHERE id='".$ilanID."'");
												}
											}else{
												mysql_query("UPDATE ilanlar SET son_teklif = '".$verilen_teklif."' WHERE id='".$ilanID."'");
											}
										}
									}
									if($token != ""){
										mysql_query("INSERT INTO `teklifler`(`id`,`ilan_id`,`uye_id`,`teklif`,`hizmet_bedeli`,`teklif_zamani`,`user_token`,`dogrudan_satisli_ilan_id`,`kurumsal_token`,ip,tarayici,isletim_sistemi,admin_teklif,admin_id,durum) 
										VALUES (NULL,'".$ilanID."','".$uyeID."','".$verilen_teklif."','".$hizmet_bedel."','".$date."','".$token."','','0','".$ip."','".$tarayici."','".$isletim_sistemi."','1','".$admin_id."','1')");
									}elseif($k_token !=""){
										mysql_query("INSERT INTO `teklifler`(`id`,`ilan_id`,`uye_id`,`teklif`,`hizmet_bedeli`,`teklif_zamani`,`user_token`,`dogrudan_satisli_ilan_id`,`kurumsal_token`,ip,tarayici,isletim_sistemi,admin_teklif,admin_id,durum) 
										VALUES (NULL,'".$ilanID."','".$uyeID."','".$verilen_teklif."','".$hizmet_bedel."','".$date."','','0','".$k_token."','".$ip."','".$tarayici."','".$isletim_sistemi."','1','".$admin_id."','1')");
									}
									$response=["message"=>"","status"=>200];
									$islem_durum = 1;
								}
							}else{
								if($row->ihale_tarihi." ".$row->ihale_saati < date("Y-m-d H:i:s")){
									$response=["message"=>"İhalenin süresi dolmuştur.","status"=>500];
									$islem_durum = 0;
								}else{
									$ilan_cek = mysql_query("SELECT * FROM ilanlar WHERE id = '".$ilanID."'");
									while($ilan_oku = mysql_fetch_array($ilan_cek)){
										$teklif = $ilan_oku['son_teklif'];
										if($verilen_teklif > $teklif){
											$ihale_bitis=$ilan_oku["ihale_tarihi"]." ".$ilan_oku["ihale_saati"];
											$sigorta_sure_uzatma_durumu=$row3->sure_uzatma;
											$sigorta_dakikanin_altinda=$row3->dakikanin_altinda;
											$sigorta_dakika_uzar=$row3->dakika_uzar;
											if($sigorta_sure_uzatma_durumu=="1"){
												$yeni_trh=strtotime("+".$sigorta_dakika_uzar." minutes",strtotime($ihale_bitis));
												$yeni_trh=date("Y-m-d H:i:s",$yeni_trh);
												$explode=explode(" ",$yeni_trh);
												$yeni_t=$explode[0];
												$yeni_s=$explode[1];
												$date=date("Y-m-d H:i:s");
												$tarih=strtotime("-".$sigorta_dakikanin_altinda." minutes",strtotime($ihale_bitis));
												$tarih=date("Y-m-d H:i:s",$tarih);
												if($date>$tarih){
													$gosterilme_tarih=strtotime($yeni_trh)+300; //Gösterilme süresi 5 dk fazla olması istendi
													$gosterilme_tarih=date("Y-m-d H:i:s",$gosterilme_tarih);
													mysql_query("UPDATE ilanlar SET son_teklif = '".$verilen_teklif."',ihale_tarihi='".$yeni_t."', ihale_saati='".$yeni_s."' , ihale_son_gosterilme='".$gosterilme_tarih."' WHERE id='".$ilanID."'");
												}else{
													mysql_query("UPDATE ilanlar SET son_teklif = '".$verilen_teklif."' WHERE id='".$ilanID."'");
												}
											}else{
												mysql_query("UPDATE ilanlar SET son_teklif = '".$verilen_teklif."' WHERE id='".$ilanID."'");
											}
											/*if($sigorta_sure_uzatma_durumu=="1"){
												$mevcut_saat=$ilan_oku["ihale_saati"];
												$explode=explode(":",$mevcut_saat);
												$yeni_s=$explode[1]+$sigorta_dakika_uzar;
												if($yeni_s>60){
													$yeni_s=yeni_s-60;
													$eklenecek=$yeni_s % 60;
													$explode[0]=$explode[0]+$eklenecek;
												}
												$yeni_s=$explode[0].":".$yeni_s;
												$date=date("Y-m-d H:i:s");
												$tarih=strtotime("-".$sigorta_dakikanin_altinda." minutes",strtotime($ihale_bitis));
												$tarih=date("Y-m-d H:i:s",$tarih);
										
												if($date>$tarih){
													mysql_query("UPDATE ilanlar SET son_teklif = '".$verilen_teklif."',ihale_saati='".$yeni_s."' WHERE id='".$ilanID."'");
												}else{
													mysql_query("UPDATE ilanlar SET son_teklif = '".$verilen_teklif."' WHERE id='".$ilanID."'");
												}
											}else{
												mysql_query("UPDATE ilanlar SET son_teklif = '".$verilen_teklif."' WHERE id='".$ilanID."'");
											}*/
										}
									}
									if($token != ""){
										mysql_query("INSERT INTO `teklifler`(`id`,`ilan_id`,`uye_id`,`teklif`,`hizmet_bedeli`,`teklif_zamani`,`user_token`,`dogrudan_satisli_ilan_id`,`kurumsal_token`,ip,tarayici,isletim_sistemi,admin_teklif,admin_id,durum) 
										VALUES (NULL,'".$ilanID."','".$uyeID."','".$verilen_teklif."','".$hizmet_bedel."','".$date."','".$token."','','0','".$ip."','".$tarayici."','".$isletim_sistemi."','1','".$admin_id."','1')");
									}elseif($k_token !=""){
										mysql_query("INSERT INTO `teklifler`(`id`,`ilan_id`,`uye_id`,`teklif`,`hizmet_bedeli`,`teklif_zamani`,`user_token`,`dogrudan_satisli_ilan_id`,`kurumsal_token`,ip,tarayici,isletim_sistemi,admin_teklif,admin_id,durum) 
										VALUES (NULL,'".$ilanID."','".$uyeID."','".$verilen_teklif."','".$hizmet_bedel."','".$date."','','0','".$k_token."','".$ip."','".$tarayici."','".$isletim_sistemi."','1','".$admin_id."','1')");
									}
									$response=["message"=>"","status"=>200];
									$islem_durum = 1;
								}
							}
						}
					}
				}
			}else if($row->ihale_turu==2) {
				if($hurda_durumu=="Hurda Belgeli"){
					if($hurda_teklif == "on"){
						if($teklif_engelle=="on"){
							if($engelleme_nedeni ==""){
								$response = ["message"=>"Teklif verme yetkileriniz geçici olarak durdurulmuştur.","status"=>500];
								$islem_durum = 0;
							}else{
								$response = ["message"=>"$engelleme_nedeni","status"=>500];
								$islem_durum = 0;
							}
						}else if($otomatik_teklif_engelle=="on" ){
							$response = ["message"=>"Sistem tarafından teklif vermeniz kısıtlanmıştır.Müşteri temsilcileri ile iletişimi geçebilirsiniz.","status"=>500];
							$islem_durum = 0;
						}else{
							if($verilen_teklif == ""){
								if($yeni_saat != ""){
									if((date("Y-m-d H:i:s")>$i_tarihi." ".$yeni_saat.":00") && ($row->ihale_tarihi." ".$row->ihale_saati > date("Y-m-d H:i:s"))  ){
										if($uyari_kabul!=1){
											$response = ["message"=>"Belirlemek istediğiniz saat ihalenin kapanmasına neden oluyor.İşlemi yapmak için uyarıları kabul etmelisiniz.","status"=>500,"ihale_durum"=>1];
											$islem_durum = 0;
										}else{
											$y_trh=$i_tarihi." ".$yeni_saat.":00";
											$gosterilme_tarih=strtotime($y_trh)+300; //Gösterilme süresi 5 dk fazla olması istendi
											$gosterilme_tarih=date("Y-m-d H:i:s",$gosterilme_tarih);
											mysql_query("update ilanlar set ihale_saati='".$yeni_saat."',ihale_son_gosterilme='".$gosterilme_tarih."' where id='".$ilanID."' ");
											$response=["message"=>"","status"=>200];
											$islem_durum = 1;
										}
									}else if( ($row->ihale_tarihi." ".$row->ihale_saati < date("Y-m-d H:i:s")) && (date("Y-m-d H:i:s") < $i_tarihi." ".$yeni_saat.":00")){
										if($uyari_kabul!=1){
											$response=["message"=>"Belirlemek istediğiniz saat ihalenin açılamasına neden oluyor.İşlemi yapmak için uyarıları kabul etmelisiniz.","status"=>500,"ihale_durum"=>1];
											$islem_durum = 0;
										}else{
											$y_trh=$i_tarihi." ".$yeni_saat.":00";
											$gosterilme_tarih=strtotime($y_trh)+300; //Gösterilme süresi 5 dk fazla olması istendi
											$gosterilme_tarih=date("Y-m-d H:i:s",$gosterilme_tarih);
											mysql_query("update ilanlar set ihale_saati='".$yeni_saat."',ihale_son_gosterilme='".$gosterilme_tarih."' where id='".$ilanID."' ");
											$ilan_cek = mysql_query("SELECT * FROM ilanlar WHERE id = '".$ilanID."'");
											$response=["message"=>"","status"=>200];
											$islem_durum = 1;
										}
									}else{
										$y_trh=$i_tarihi." ".$yeni_saat.":00";
										$gosterilme_tarih=strtotime($y_trh)+300; //Gösterilme süresi 5 dk fazla olması istendi
										$gosterilme_tarih=date("Y-m-d H:i:s",$gosterilme_tarih);
										mysql_query("update ilanlar set ihale_saati='".$yeni_saat."',ihale_son_gosterilme='".$gosterilme_tarih."' where id='".$ilanID."' ");
										$response=["message"=>"","status"=>200];
										$islem_durum = 1;
									}
								}else{
									$response=["message"=>"Teklifiniz boş olamaz","status"=>500];
									$islem_durum = 0;
								}
							} 
							else if($verilen_teklif <= $row->acilis_fiyati  ){
								$response=["message"=>"Teklifiniz taban fiyat koşulunu sağlamamaktadır. İhalenin taban fiyatı $row->acilis_fiyati ₺'dir. ","status"=>500];
								$islem_durum = 0;
							}
							else if($verilen_teklif % $sigorta_min_artis != 0){
								$response=["message"=>"Teklifiniz $sigorta_min_artis ₺ katları olmalı","status"=>500];
								$islem_durum = 0;
							}					
							else if($verilen_teklif > $teklif_limiti  ){
								$response=["message"=>"Teklif limitiniz aştınız. Mevcut paketinizin teklif limiti '".money($teklif_limiti)."' ₺'dir. ","status"=>503];
								$islem_durum = 0;
							} 
							else if($verilen_teklif < $row->acilis_fiyati+$sigorta_min_artis){
								$response=["message"=>"Teklfiniz taban fiyattan en az $sigorta_min_artis ₺ fazla olmalı ","status"=>500];
								$islem_durum = 0;
							}  
							else if($engelli_sigorta=="true" ){
								$response = ["message"=>"İlanın sigorta şirketine ait olan araçlara teklif vermeniz kısıtlanmıştır.","status"=>500];
								$islem_durum = 0;
							}	
							else{
								if($yeni_saat != ""){
									if((date("Y-m-d H:i:s")>$i_tarihi." ".$yeni_saat.":00") && ($row->ihale_tarihi." ".$row->ihale_saati > date("Y-m-d H:i:s"))  ){
										if($uyari_kabul!=1){
											$response = ["message"=>"Belirlemek istediğiniz saat ihalenin kapanmasına neden oluyor.İşlemi yapmak için uyarıları kabul etmelisiniz.","status"=>500,"ihale_durum"=>1];
										}else{
											if($token != ""){
												mysql_query("INSERT INTO `teklifler`(`id`,`ilan_id`,`uye_id`,`teklif`,`hizmet_bedeli`,`teklif_zamani`,`user_token`,`dogrudan_satisli_ilan_id`,`kurumsal_token`,ip,tarayici,isletim_sistemi,admin_teklif,admin_id,durum) 
												VALUES (NULL,'".$ilanID."','".$uyeID."','".$verilen_teklif."','".$hizmet_bedel."','".$date."','".$token."','','0','".$ip."','".$tarayici."','".$isletim_sistemi."','1','".$admin_id."','1')");
											
											}elseif($k_token !=""){
												mysql_query("INSERT INTO `teklifler`(`id`,`ilan_id`,`uye_id`,`teklif`,`hizmet_bedeli`,`teklif_zamani`,`user_token`,`dogrudan_satisli_ilan_id`,`kurumsal_token`,ip,tarayici,isletim_sistemi,admin_teklif,admin_id,durum) 
												VALUES (NULL,'".$ilanID."','".$uyeID."','".$verilen_teklif."','".$hizmet_bedel."','".$date."','','0','".$k_token."','".$ip."','".$tarayici."','".$isletim_sistemi."','1','".$admin_id."','1')");
											}
											
											$y_trh=$i_tarihi." ".$yeni_saat.":00";
											$gosterilme_tarih=strtotime($y_trh)+300; //Gösterilme süresi 5 dk fazla olması istendi
											$gosterilme_tarih=date("Y-m-d H:i:s",$gosterilme_tarih);
											mysql_query("update ilanlar set ihale_saati='".$yeni_saat."',ihale_son_gosterilme='".$gosterilme_tarih."' where id='".$ilanID."' ");
											
											$teklifler_array=array();
											$teklifler_cek=mysql_query("select * from teklifler where ilan_id='".$ilanID."' and durum=1 group by uye_id order by teklif_zamani desc");
											while($teklifler_oku=mysql_fetch_object($teklifler_cek)){
												$teklif_getir=mysql_query("select * from teklifler where ilan_id='".$teklifler_oku->ilan_id."' and uye_id='".$teklifler_oku->uye_id."' and durum=1 order by teklif_zamani desc limit 1 ");
												$teklif_oku=mysql_fetch_object($teklif_getir);
												array_push($teklifler_array,$teklif_oku->teklif);
											}
											
											$guncelle=mysql_query("UPDATE ilanlar SET son_teklif = '".max($teklifler_array)."',durum='-1' WHERE id='".$ilanID."'");
											
											$ilan_cek = mysql_query("SELECT * FROM ilanlar WHERE id = '".$ilanID."'");
											while($ilan_oku = mysql_fetch_array($ilan_cek)){
												$ihale_bitis=$ilan_oku["ihale_tarihi"]." ".$ilan_oku["ihale_saati"];
												$sigorta_sure_uzatma_durumu=$row3->sure_uzatma;
												$sigorta_dakikanin_altinda=$row3->dakikanin_altinda;
												$sigorta_dakika_uzar=$row3->dakika_uzar;
												if($sigorta_sure_uzatma_durumu=="1"){
													$yeni_trh=strtotime("+".$sigorta_dakika_uzar." minutes",strtotime($ihale_bitis));
													$yeni_trh=date("Y-m-d H:i:s",$yeni_trh);
													$explode=explode(" ",$yeni_trh);
													$yeni_t=$explode[0];
													$yeni_s=$explode[1];
													$date=date("Y-m-d H:i:s");
													$tarih=strtotime("-".$sigorta_dakikanin_altinda." minutes",strtotime($ihale_bitis));
													$tarih=date("Y-m-d H:i:s",$tarih);
													if($date>$tarih){
														$gosterilme_tarih=strtotime($yeni_trh)+300; //Gösterilme süresi 5 dk fazla olması istendi
														$gosterilme_tarih=date("Y-m-d H:i:s",$gosterilme_tarih);
														mysql_query("UPDATE ilanlar SET ihale_tarihi='".$yeni_t."', ihale_saati='".$yeni_s."' , ihale_son_gosterilme='".$gosterilme_tarih."' WHERE id='".$ilanID."'");

														
													}
												}
											}
											$guncelle=mysql_query("UPDATE ilanlar SET son_teklif = '".max($teklifler_array)."',durum='1' WHERE id='".$ilanID."'");
											if($guncelle){
												$response=["message"=>"Başarılı","status"=>200];
												$islem_durum = 1;
											}else{
												$response=["message"=>"Hata","status"=>500];
												$islem_durum = 0;
											}
										}
									}else if( ($row->ihale_tarihi." ".$row->ihale_saati < date("Y-m-d H:i:s")) && (date("Y-m-d H:i:s") < $i_tarihi." ".$yeni_saat.":00") ){
										if($uyari_kabul!=1){
											$response=["message"=>"Belirlemek istediğiniz saat ihalenin açılamasına neden oluyor.İşlemi yapmak için uyarıları kabul etmelisiniz.","status"=>500,"ihale_durum"=>1];
											$islem_durum = 0;
										}else{
											if($token != ""){
												mysql_query("INSERT INTO `teklifler`(`id`,`ilan_id`,`uye_id`,`teklif`,`hizmet_bedeli`,`teklif_zamani`,`user_token`,`dogrudan_satisli_ilan_id`,`kurumsal_token`,ip,tarayici,isletim_sistemi,admin_teklif,admin_id,durum) 
												VALUES (NULL,'".$ilanID."','".$uyeID."','".$verilen_teklif."','".$hizmet_bedel."','".$date."','".$token."','','0','".$ip."','".$tarayici."','".$isletim_sistemi."','1','".$admin_id."','1')");
											
											}elseif($k_token !=""){
												mysql_query("INSERT INTO `teklifler`(`id`,`ilan_id`,`uye_id`,`teklif`,`hizmet_bedeli`,`teklif_zamani`,`user_token`,`dogrudan_satisli_ilan_id`,`kurumsal_token`,ip,tarayici,isletim_sistemi,admin_teklif,admin_id,durum) 
												VALUES (NULL,'".$ilanID."','".$uyeID."','".$verilen_teklif."','".$hizmet_bedel."','".$date."','','0','".$k_token."','".$ip."','".$tarayici."','".$isletim_sistemi."','1','".$admin_id."','1')");
											}
											
											$y_trh=$i_tarihi." ".$yeni_saat.":00";
											$gosterilme_tarih=strtotime($y_trh)+300; //Gösterilme süresi 5 dk fazla olması istendi
											$gosterilme_tarih=date("Y-m-d H:i:s",$gosterilme_tarih);
											mysql_query("update ilanlar set ihale_saati='".$yeni_saat."',ihale_son_gosterilme='".$gosterilme_tarih."' where id='".$ilanID."' ");


											
											$teklifler_array=array();
											$teklifler_cek=mysql_query("select * from teklifler where ilan_id='".$ilanID."' and durum=1 group by uye_id order by teklif_zamani desc");
											while($teklifler_oku=mysql_fetch_object($teklifler_cek)){
												$teklif_getir=mysql_query("select * from teklifler where ilan_id='".$teklifler_oku->ilan_id."' and uye_id='".$teklifler_oku->uye_id."' and durum=1 order by teklif_zamani desc limit 1 ");
												$teklif_oku=mysql_fetch_object($teklif_getir);
												array_push($teklifler_array,$teklif_oku->teklif);
											}
											
											$ilan_cek = mysql_query("SELECT * FROM ilanlar WHERE id = '".$ilanID."'");
											while($ilan_oku = mysql_fetch_array($ilan_cek)){
												$ihale_bitis=$ilan_oku["ihale_tarihi"]." ".$ilan_oku["ihale_saati"];
												$sigorta_sure_uzatma_durumu=$row3->sure_uzatma;
												$sigorta_dakikanin_altinda=$row3->dakikanin_altinda;
												$sigorta_dakika_uzar=$row3->dakika_uzar;
												if($sigorta_sure_uzatma_durumu=="1"){
													$yeni_trh=strtotime("+".$sigorta_dakika_uzar." minutes",strtotime($ihale_bitis));
													$yeni_trh=date("Y-m-d H:i:s",$yeni_trh);
													$explode=explode(" ",$yeni_trh);
													$yeni_t=$explode[0];
													$yeni_s=$explode[1];
													$date=date("Y-m-d H:i:s");
													$tarih=strtotime("-".$sigorta_dakikanin_altinda." minutes",strtotime($ihale_bitis));
													$tarih=date("Y-m-d H:i:s",$tarih);
													if($date>$tarih){
														$gosterilme_tarih=strtotime($yeni_trh)+300; //Gösterilme süresi 5 dk fazla olması istendi
														$gosterilme_tarih=date("Y-m-d H:i:s",$gosterilme_tarih);
														mysql_query("UPDATE ilanlar SET ihale_tarihi='".$yeni_t."', ihale_saati='".$yeni_s."' , ihale_son_gosterilme='".$gosterilme_tarih."' WHERE id='".$ilanID."'");
													}
												}
											}
											$guncelle=mysql_query("UPDATE ilanlar SET son_teklif = '".max($teklifler_array)."',durum='1' WHERE id='".$ilanID."'");
											if($guncelle){
												$response=["message"=>"Başarılı","status"=>200];
												$islem_durum = 1;
											}else{
												$response=["message"=>"Hata","status"=>500];
												$islem_durum = 0;
											}
										}
									}else{
										if($token != ""){
											mysql_query("INSERT INTO `teklifler`(`id`,`ilan_id`,`uye_id`,`teklif`,`hizmet_bedeli`,`teklif_zamani`,`user_token`,`dogrudan_satisli_ilan_id`,`kurumsal_token`,ip,tarayici,isletim_sistemi,admin_teklif,admin_id,durum) 
											VALUES (NULL,'".$ilanID."','".$uyeID."','".$verilen_teklif."','".$hizmet_bedel."','".$date."','".$token."','','0','".$ip."','".$tarayici."','".$isletim_sistemi."','1','".$admin_id."','1')");
										
										}elseif($k_token !=""){
											mysql_query("INSERT INTO `teklifler`(`id`,`ilan_id`,`uye_id`,`teklif`,`hizmet_bedeli`,`teklif_zamani`,`user_token`,`dogrudan_satisli_ilan_id`,`kurumsal_token`,ip,tarayici,isletim_sistemi,admin_teklif,admin_id,durum) 
											VALUES (NULL,'".$ilanID."','".$uyeID."','".$verilen_teklif."','".$hizmet_bedel."','".$date."','','0','".$k_token."','".$ip."','".$tarayici."','".$isletim_sistemi."','1','".$admin_id."','1')");
										}
										
										$y_trh=$i_tarihi." ".$yeni_saat.":00";
										$gosterilme_tarih=strtotime($y_trh)+300; //Gösterilme süresi 5 dk fazla olması istendi
										$gosterilme_tarih=date("Y-m-d H:i:s",$gosterilme_tarih);
										mysql_query("update ilanlar set ihale_saati='".$yeni_saat."',ihale_son_gosterilme='".$gosterilme_tarih."' where id='".$ilanID."' ");

										
										
										$teklifler_array=array();
										$teklifler_cek=mysql_query("select * from teklifler where ilan_id='".$ilanID."' and durum=1 group by uye_id order by teklif_zamani desc");
										while($teklifler_oku=mysql_fetch_object($teklifler_cek)){
											$teklif_getir=mysql_query("select * from teklifler where ilan_id='".$teklifler_oku->ilan_id."' and uye_id='".$teklifler_oku->uye_id."' and durum=1 order by teklif_zamani desc limit 1 ");
											$teklif_oku=mysql_fetch_object($teklif_getir);
											array_push($teklifler_array,$teklif_oku->teklif);
										}
										
										
										$ilan_cek = mysql_query("SELECT * FROM ilanlar WHERE id = '".$ilanID."'");
										while($ilan_oku = mysql_fetch_array($ilan_cek)){
											$ihale_bitis=$ilan_oku["ihale_tarihi"]." ".$ilan_oku["ihale_saati"];
											$sigorta_sure_uzatma_durumu=$row3->sure_uzatma;
											$sigorta_dakikanin_altinda=$row3->dakikanin_altinda;
											$sigorta_dakika_uzar=$row3->dakika_uzar;
											if($sigorta_sure_uzatma_durumu=="1"){
												$yeni_trh=strtotime("+".$sigorta_dakika_uzar." minutes",strtotime($ihale_bitis));
												$yeni_trh=date("Y-m-d H:i:s",$yeni_trh);
												$explode=explode(" ",$yeni_trh);
												$yeni_t=$explode[0];
												$yeni_s=$explode[1];
												$date=date("Y-m-d H:i:s");
												$tarih=strtotime("-".$sigorta_dakikanin_altinda." minutes",strtotime($ihale_bitis));
												$tarih=date("Y-m-d H:i:s",$tarih);
												if($date>$tarih){
													$gosterilme_tarih=strtotime($yeni_trh)+300; //Gösterilme süresi 5 dk fazla olması istendi
													$gosterilme_tarih=date("Y-m-d H:i:s",$gosterilme_tarih);
													mysql_query("UPDATE ilanlar SET ihale_tarihi='".$yeni_t."', ihale_saati='".$yeni_s."', ihale_son_gosterilme='".$gosterilme_tarih."' WHERE id='".$ilanID."'");
												}
											}
										}
										$guncelle=mysql_query("UPDATE ilanlar SET son_teklif = '".max($teklifler_array)."' WHERE id='".$ilanID."'");
										if($guncelle){
											$response=["message"=>"Başarılı","status"=>200];
											$islem_durum = 1;
										}else{
											$response=["message"=>"Hata","status"=>500];
											$islem_durum = 0;
										}
									}
								}else{
									if($row->ihale_tarihi." ".$row->ihale_saati < date("Y-m-d H:i:s")){
										$response=["message"=>"İhalenin süresi dolmuştur.","status"=>500];
										$islem_durum = 0;
									}else{
										if($token != ""){
											mysql_query("INSERT INTO `teklifler`(`id`,`ilan_id`,`uye_id`,`teklif`,`hizmet_bedeli`,`teklif_zamani`,`user_token`,`dogrudan_satisli_ilan_id`,`kurumsal_token`,ip,tarayici,isletim_sistemi,admin_teklif,admin_id,durum) 
											VALUES (NULL,'".$ilanID."','".$uyeID."','".$verilen_teklif."','".$hizmet_bedel."','".$date."','".$token."','','0','".$ip."','".$tarayici."','".$isletim_sistemi."','1','".$admin_id."','1')");
										
										}elseif($k_token !=""){
											mysql_query("INSERT INTO `teklifler`(`id`,`ilan_id`,`uye_id`,`teklif`,`hizmet_bedeli`,`teklif_zamani`,`user_token`,`dogrudan_satisli_ilan_id`,`kurumsal_token`,ip,tarayici,isletim_sistemi,admin_teklif,admin_id,durum) 
											VALUES (NULL,'".$ilanID."','".$uyeID."','".$verilen_teklif."','".$hizmet_bedel."','".$date."','','0','".$k_token."','".$ip."','".$tarayici."','".$isletim_sistemi."','1','".$admin_id."','1')");
										}
										
										$teklifler_array=array();
										$teklifler_cek=mysql_query("select * from teklifler where ilan_id='".$ilanID."' and durum=1 group by uye_id order by teklif_zamani desc");
										while($teklifler_oku=mysql_fetch_object($teklifler_cek)){
											$teklif_getir=mysql_query("select * from teklifler where ilan_id='".$teklifler_oku->ilan_id."' and uye_id='".$teklifler_oku->uye_id."' and durum=1 order by teklif_zamani desc limit 1 ");
											$teklif_oku=mysql_fetch_object($teklif_getir);
											array_push($teklifler_array,$teklif_oku->teklif);
										}
										
										$ilan_cek = mysql_query("SELECT * FROM ilanlar WHERE id = '".$ilanID."'");
										while($ilan_oku = mysql_fetch_array($ilan_cek)){
											$ihale_bitis=$ilan_oku["ihale_tarihi"]." ".$ilan_oku["ihale_saati"];
											$sigorta_sure_uzatma_durumu=$row3->sure_uzatma;
											$sigorta_dakikanin_altinda=$row3->dakikanin_altinda;
											$sigorta_dakika_uzar=$row3->dakika_uzar;
											if($sigorta_sure_uzatma_durumu=="1"){
												$yeni_trh=strtotime("+".$sigorta_dakika_uzar." minutes",strtotime($ihale_bitis));
												$yeni_trh=date("Y-m-d H:i:s",$yeni_trh);
												$explode=explode(" ",$yeni_trh);
												$yeni_t=$explode[0];
												$yeni_s=$explode[1];
												$date=date("Y-m-d H:i:s");
												$tarih=strtotime("-".$sigorta_dakikanin_altinda." minutes",strtotime($ihale_bitis));
												$tarih=date("Y-m-d H:i:s",$tarih);
												if($date>$tarih){
													$gosterilme_tarih=strtotime($yeni_trh)+300; //Gösterilme süresi 5 dk fazla olması istendi
													$gosterilme_tarih=date("Y-m-d H:i:s",$gosterilme_tarih);
													mysql_query("UPDATE ilanlar SET ihale_tarihi='".$yeni_t."', ihale_saati='".$yeni_s."' , ihale_son_gosterilme='".$gosterilme_tarih."' WHERE id='".$ilanID."'");
												}
											}
										}
										
										$guncelle=mysql_query("UPDATE ilanlar SET son_teklif = '".max($teklifler_array)."' WHERE id='".$ilanID."'");
										if($guncelle){
											$response=["message"=>"Başarılı","status"=>200];
											$islem_durum = 1;
										}else{
											$response=["message"=>"Hata","status"=>500];
											$islem_durum = 0;
										}
									}
								}
							}
						}
					}else{
						$response = ["message"=>"Hurda belgeli araçlara teklif verebilmek için lütfen bizimle iletişime geçin.","status"=>500];	
						$islem_durum = 0;
					}
				}else{
					if($teklif_engelle=="on"){
						if($engelleme_nedeni ==""){
							$response = ["message"=>"Teklif verme yetkileriniz geçici olarak durdurulmuştur.","status"=>500];
							$islem_durum = 0;
						}else{
							$response = ["message"=>"$engelleme_nedeni","status"=>500];
							$islem_durum = 0;
						}
					}else if($otomatik_teklif_engelle=="on" ){
							$response = ["message"=>"Sistem tarafından teklif vermeniz kısıtlanmıştır.Müşteri temsilcileri ile iletişimi geçebilirsiniz.","status"=>500];
							$islem_durum = 0;
					}else{
						if($verilen_teklif == ""){
							if($yeni_saat != ""){
								if((date("Y-m-d H:i:s")>$i_tarihi." ".$yeni_saat.":00") && ($row->ihale_tarihi." ".$row->ihale_saati > date("Y-m-d H:i:s"))  ){
									if($uyari_kabul!=1){
										$response = ["message"=>"Belirlemek istediğiniz saat ihalenin kapanmasına neden oluyor.İşlemi yapmak için uyarıları kabul etmelisiniz.","status"=>500,"ihale_durum"=>1];
										$islem_durum = 0;
									}else{
										$y_trh=$i_tarihi." ".$yeni_saat.":00";
										$gosterilme_tarih=strtotime($y_trh)+300; //Gösterilme süresi 5 dk fazla olması istendi
										$gosterilme_tarih=date("Y-m-d H:i:s",$gosterilme_tarih);
										mysql_query("update ilanlar set ihale_saati='".$yeni_saat."',ihale_son_gosterilme='".$gosterilme_tarih."' where id='".$ilanID."' ");
										$response=["message"=>"","status"=>200];
										$islem_durum = 1;
									}
								}else if( ($row->ihale_tarihi." ".$row->ihale_saati < date("Y-m-d H:i:s")) && (date("Y-m-d H:i:s") < $i_tarihi." ".$yeni_saat.":00")){
									if($uyari_kabul!=1){
										$response=["message"=>"Belirlemek istediğiniz saat ihalenin açılamasına neden oluyor.İşlemi yapmak için uyarıları kabul etmelisiniz.","status"=>500,"ihale_durum"=>1];
										$islem_durum = 0;
									}else{
										$y_trh=$i_tarihi." ".$yeni_saat.":00";
										$gosterilme_tarih=strtotime($y_trh)+300; //Gösterilme süresi 5 dk fazla olması istendi
										$gosterilme_tarih=date("Y-m-d H:i:s",$gosterilme_tarih);
										mysql_query("update ilanlar set ihale_saati='".$yeni_saat."',ihale_son_gosterilme='".$gosterilme_tarih."' where id='".$ilanID."' ");
										$ilan_cek = mysql_query("SELECT * FROM ilanlar WHERE id = '".$ilanID."'");

										$response=["message"=>"","status"=>200];
										$islem_durum = 1;
									}
								}else{
									$y_trh=$i_tarihi." ".$yeni_saat.":00";
									$gosterilme_tarih=strtotime($y_trh)+300; //Gösterilme süresi 5 dk fazla olması istendi
									$gosterilme_tarih=date("Y-m-d H:i:s",$gosterilme_tarih);
									mysql_query("update ilanlar set ihale_saati='".$yeni_saat."',ihale_son_gosterilme='".$gosterilme_tarih."' where id='".$ilanID."' ");
									$response=["message"=>"","status"=>200];
									$islem_durum = 1;
								}
							}else{
								$response=["message"=>"Teklifiniz boş olamaz","status"=>500];
								$islem_durum = 0;
							}
						} 
						else if($verilen_teklif <= $row->acilis_fiyati  ){
							$response=["message"=>"Teklifiniz taban fiyat koşulunu sağlamamaktadır. İhalenin taban fiyatı $row->acilis_fiyati ₺'dir. ","status"=>500];
							$islem_durum = 0;
						} 
						else if($verilen_teklif % $sigorta_min_artis != 0){
							$response=["message"=>"Teklifiniz $sigorta_min_artis ₺ katları olmalı","status"=>500];
							$islem_durum = 0;
						}
						else if($verilen_teklif > $teklif_limiti  ){
							$response=["message"=>"Teklif limitiniz aştınız. Mevcut paketinizin teklif limiti '".money($teklif_limiti)."' ₺'dir. ","status"=>504];
							$islem_durum = 0;
						}
						else if($verilen_teklif < $row->acilis_fiyati+$sigorta_min_artis){
								$response=["message"=>"Teklfiniz taban fiyattan en az $sigorta_min_artis ₺ fazla olmalı ","status"=>500];
								$islem_durum = 0;
						}  		
						else if($engelli_sigorta=="true" ){
							$response = ["message"=>"İlanın sigorta şirketine ait olan araçlara teklif vermeniz kısıtlanmıştır.","status"=>500];
							$islem_durum = 0;
						}		
						else{
							if($yeni_saat != ""){
								if((date("Y-m-d H:i:s")>$i_tarihi." ".$yeni_saat.":00") && ($row->ihale_tarihi." ".$row->ihale_saati > date("Y-m-d H:i:s"))  ){
									if($uyari_kabul!=1){
										$response = ["message"=>"Belirlemek istediğiniz saat ihalenin kapanmasına neden oluyor.İşlemi yapmak için uyarıları kabul etmelisiniz.","status"=>500,"ihale_durum"=>1];
										$islem_durum = 0;
									}else{
										if($token != ""){
											mysql_query("INSERT INTO `teklifler`(`id`,`ilan_id`,`uye_id`,`teklif`,`hizmet_bedeli`,`teklif_zamani`,`user_token`,`dogrudan_satisli_ilan_id`,`kurumsal_token`,ip,tarayici,isletim_sistemi,admin_teklif,admin_id,durum) 
											VALUES (NULL,'".$ilanID."','".$uyeID."','".$verilen_teklif."','".$hizmet_bedel."','".$date."','".$token."','','0','".$ip."','".$tarayici."','".$isletim_sistemi."','1','".$admin_id."','1')");
										
										}elseif($k_token !=""){
											mysql_query("INSERT INTO `teklifler`(`id`,`ilan_id`,`uye_id`,`teklif`,`hizmet_bedeli`,`teklif_zamani`,`user_token`,`dogrudan_satisli_ilan_id`,`kurumsal_token`,ip,tarayici,isletim_sistemi,admin_teklif,admin_id,durum) 
											VALUES (NULL,'".$ilanID."','".$uyeID."','".$verilen_teklif."','".$hizmet_bedel."','".$date."','','0','".$k_token."','".$ip."','".$tarayici."','".$isletim_sistemi."','1','".$admin_id."','1')");
										}
										
										$y_trh=$i_tarihi." ".$yeni_saat.":00";
										$gosterilme_tarih=strtotime($y_trh)+300; //Gösterilme süresi 5 dk fazla olması istendi
										$gosterilme_tarih=date("Y-m-d H:i:s",$gosterilme_tarih);
										mysql_query("update ilanlar set ihale_saati='".$yeni_saat."',ihale_son_gosterilme='".$gosterilme_tarih."' where id='".$ilanID."' ");

										$teklifler_array=array();
										$teklifler_cek=mysql_query("select * from teklifler where ilan_id='".$ilanID."' and durum=1 group by uye_id order by teklif_zamani desc");
										while($teklifler_oku=mysql_fetch_object($teklifler_cek)){
											$teklif_getir=mysql_query("select * from teklifler where ilan_id='".$teklifler_oku->ilan_id."' and uye_id='".$teklifler_oku->uye_id."' and durum=1 order by teklif_zamani desc limit 1 ");
											$teklif_oku=mysql_fetch_object($teklif_getir);
											array_push($teklifler_array,$teklif_oku->teklif);
										}
										
										$ilan_cek = mysql_query("SELECT * FROM ilanlar WHERE id = '".$ilanID."'");
										while($ilan_oku = mysql_fetch_array($ilan_cek)){
											$ihale_bitis=$ilan_oku["ihale_tarihi"]." ".$ilan_oku["ihale_saati"];
											$sigorta_sure_uzatma_durumu=$row3->sure_uzatma;
											$sigorta_dakikanin_altinda=$row3->dakikanin_altinda;
											$sigorta_dakika_uzar=$row3->dakika_uzar;
											if($sigorta_sure_uzatma_durumu=="1"){
												$yeni_trh=strtotime("+".$sigorta_dakika_uzar." minutes",strtotime($ihale_bitis));
												$yeni_trh=date("Y-m-d H:i:s",$yeni_trh);
												$explode=explode(" ",$yeni_trh);
												$yeni_t=$explode[0];
												$yeni_s=$explode[1];
												$date=date("Y-m-d H:i:s");
												$tarih=strtotime("-".$sigorta_dakikanin_altinda." minutes",strtotime($ihale_bitis));
												$tarih=date("Y-m-d H:i:s",$tarih);
												if($date>$tarih){
													$gosterilme_tarih=strtotime($yeni_trh)+300; //Gösterilme süresi 5 dk fazla olması istendi
													$gosterilme_tarih=date("Y-m-d H:i:s",$gosterilme_tarih);
													mysql_query("UPDATE ilanlar SET ihale_tarihi='".$yeni_t."', ihale_saati='".$yeni_s."' , ihale_son_gosterilme='".$gosterilme_tarih."'  WHERE id='".$ilanID."'");
												}
											}
										}
								
										$guncelle=mysql_query("UPDATE ilanlar SET son_teklif = '".max($teklifler_array)."',durum='-1' WHERE id='".$ilanID."'");
										if($guncelle){
											$islem_durum = 1;
											$response=["message"=>"Başarılı","status"=>200];
										}else{
											$islem_durum = 0;
											$response=["message"=>"Hata","status"=>500];
										}
										
									}
								}else if( ($row->ihale_tarihi." ".$row->ihale_saati < date("Y-m-d H:i:s")) && (date("Y-m-d H:i:s") < $i_tarihi." ".$yeni_saat.":00") ){
									if($uyari_kabul!=1){
										$response=["message"=>"Belirlemek istediğiniz saat ihalenin açılamasına neden oluyor.İşlemi yapmak için uyarıları kabul etmelisiniz.","status"=>500,"ihale_durum"=>1];
										$islem_durum = 0;
									}else{
										if($token != ""){
											mysql_query("INSERT INTO `teklifler`(`id`,`ilan_id`,`uye_id`,`teklif`,`hizmet_bedeli`,`teklif_zamani`,`user_token`,`dogrudan_satisli_ilan_id`,`kurumsal_token`,ip,tarayici,isletim_sistemi,admin_teklif,admin_id,durum) 
											VALUES (NULL,'".$ilanID."','".$uyeID."','".$verilen_teklif."','".$hizmet_bedel."','".$date."','".$token."','','0','".$ip."','".$tarayici."','".$isletim_sistemi."','1','".$admin_id."','1')");
										
										}elseif($k_token !=""){
											mysql_query("INSERT INTO `teklifler`(`id`,`ilan_id`,`uye_id`,`teklif`,`hizmet_bedeli`,`teklif_zamani`,`user_token`,`dogrudan_satisli_ilan_id`,`kurumsal_token`,ip,tarayici,isletim_sistemi,admin_teklif,admin_id,durum) 
											VALUES (NULL,'".$ilanID."','".$uyeID."','".$verilen_teklif."','".$hizmet_bedel."','".$date."','','0','".$k_token."','".$ip."','".$tarayici."','".$isletim_sistemi."','1','".$admin_id."','1')");
										}
										
										$y_trh=$i_tarihi." ".$yeni_saat.":00";
										$gosterilme_tarih=strtotime($y_trh)+300; //Gösterilme süresi 5 dk fazla olması istendi
										$gosterilme_tarih=date("Y-m-d H:i:s",$gosterilme_tarih);
										mysql_query("update ilanlar set ihale_saati='".$yeni_saat."',ihale_son_gosterilme='".$gosterilme_tarih."' where id='".$ilanID."' ");
										
										$teklifler_array=array();
										$teklifler_cek=mysql_query("select * from teklifler where ilan_id='".$ilanID."' and durum=1 group by uye_id order by teklif_zamani desc");
										while($teklifler_oku=mysql_fetch_object($teklifler_cek)){
											$teklif_getir=mysql_query("select * from teklifler where ilan_id='".$teklifler_oku->ilan_id."' and uye_id='".$teklifler_oku->uye_id."' and durum=1 order by teklif_zamani desc limit 1 ");
											$teklif_oku=mysql_fetch_object($teklif_getir);
											array_push($teklifler_array,$teklif_oku->teklif);
										}
										
										$ilan_cek = mysql_query("SELECT * FROM ilanlar WHERE id = '".$ilanID."'");
										while($ilan_oku = mysql_fetch_array($ilan_cek)){
											$ihale_bitis=$ilan_oku["ihale_tarihi"]." ".$ilan_oku["ihale_saati"];
											$sigorta_sure_uzatma_durumu=$row3->sure_uzatma;
											$sigorta_dakikanin_altinda=$row3->dakikanin_altinda;
											$sigorta_dakika_uzar=$row3->dakika_uzar;
											if($sigorta_sure_uzatma_durumu=="1"){
												$yeni_trh=strtotime("+".$sigorta_dakika_uzar." minutes",strtotime($ihale_bitis));
												$yeni_trh=date("Y-m-d H:i:s",$yeni_trh);
												$explode=explode(" ",$yeni_trh);
												$yeni_t=$explode[0];
												$yeni_s=$explode[1];
												$date=date("Y-m-d H:i:s");
												$tarih=strtotime("-".$sigorta_dakikanin_altinda." minutes",strtotime($ihale_bitis));
												$tarih=date("Y-m-d H:i:s",$tarih);
												if($date>$tarih){
													$gosterilme_tarih=strtotime($yeni_trh)+300; //Gösterilme süresi 5 dk fazla olması istendi
													$gosterilme_tarih=date("Y-m-d H:i:s",$gosterilme_tarih);
													mysql_query("UPDATE ilanlar SET ihale_tarihi='".$yeni_t."', ihale_saati='".$yeni_s."', ihale_son_gosterilme='".$gosterilme_tarih."' WHERE id='".$ilanID."'");
												}
											}
										}
										
										$guncelle=mysql_query("UPDATE ilanlar SET son_teklif = '".max($teklifler_array)."',durum='1' WHERE id='".$ilanID."'");
										if($guncelle){
											$islem_durum = 1;
											$response=["message"=>"Başarılı","status"=>200];
										}else{
											$islem_durum = 1;
											$response=["message"=>"Hata","status"=>500];
										}
									}
								}else{
									if($token != ""){
										mysql_query("INSERT INTO `teklifler`(`id`,`ilan_id`,`uye_id`,`teklif`,`hizmet_bedeli`,`teklif_zamani`,`user_token`,`dogrudan_satisli_ilan_id`,`kurumsal_token`,ip,tarayici,isletim_sistemi,admin_teklif,admin_id,durum) 
										VALUES (NULL,'".$ilanID."','".$uyeID."','".$verilen_teklif."','".$hizmet_bedel."','".$date."','".$token."','','0','".$ip."','".$tarayici."','".$isletim_sistemi."','1','".$admin_id."','1')");
									
									}elseif($k_token !=""){
										mysql_query("INSERT INTO `teklifler`(`id`,`ilan_id`,`uye_id`,`teklif`,`hizmet_bedeli`,`teklif_zamani`,`user_token`,`dogrudan_satisli_ilan_id`,`kurumsal_token`,ip,tarayici,isletim_sistemi,admin_teklif,admin_id,durum) 
										VALUES (NULL,'".$ilanID."','".$uyeID."','".$verilen_teklif."','".$hizmet_bedel."','".$date."','','0','".$k_token."','".$ip."','".$tarayici."','".$isletim_sistemi."','1','".$admin_id."','1')");
									}
									
									$y_trh=$i_tarihi." ".$yeni_saat.":00";
									$gosterilme_tarih=strtotime($y_trh)+300; //Gösterilme süresi 5 dk fazla olması istendi
									$gosterilme_tarih=date("Y-m-d H:i:s",$gosterilme_tarih);
									mysql_query("update ilanlar set ihale_saati='".$yeni_saat."',ihale_son_gosterilme='".$gosterilme_tarih."' where id='".$ilanID."' ");

									
									$teklifler_array=array();
									$teklifler_cek=mysql_query("select * from teklifler where ilan_id='".$ilanID."' and durum=1 group by uye_id order by teklif_zamani desc");
									while($teklifler_oku=mysql_fetch_object($teklifler_cek)){
										$teklif_getir=mysql_query("select * from teklifler where ilan_id='".$teklifler_oku->ilan_id."' and uye_id='".$teklifler_oku->uye_id."' and durum=1 order by teklif_zamani desc limit 1 ");
										$teklif_oku=mysql_fetch_object($teklif_getir);
										array_push($teklifler_array,$teklif_oku->teklif);
									}

									$ilan_cek = mysql_query("SELECT * FROM ilanlar WHERE id = '".$ilanID."'");
									while($ilan_oku = mysql_fetch_array($ilan_cek)){
										$ihale_bitis=$ilan_oku["ihale_tarihi"]." ".$ilan_oku["ihale_saati"];
										$sigorta_sure_uzatma_durumu=$row3->sure_uzatma;
										$sigorta_dakikanin_altinda=$row3->dakikanin_altinda;
										$sigorta_dakika_uzar=$row3->dakika_uzar;
										if($sigorta_sure_uzatma_durumu=="1"){
											$yeni_trh=strtotime("+".$sigorta_dakika_uzar." minutes",strtotime($ihale_bitis));
											$yeni_trh=date("Y-m-d H:i:s",$yeni_trh);
											$explode=explode(" ",$yeni_trh);
											$yeni_t=$explode[0];
											$yeni_s=$explode[1];
											$date=date("Y-m-d H:i:s");
											$tarih=strtotime("-".$sigorta_dakikanin_altinda." minutes",strtotime($ihale_bitis));
											$tarih=date("Y-m-d H:i:s",$tarih);
											if($date>$tarih){
												$gosterilme_tarih=strtotime($yeni_trh)+300; //Gösterilme süresi 5 dk fazla olması istendi
												$gosterilme_tarih=date("Y-m-d H:i:s",$gosterilme_tarih);
												mysql_query("UPDATE ilanlar SET ihale_tarihi='".$yeni_t."', ihale_saati='".$yeni_s."', ihale_son_gosterilme='".$gosterilme_tarih."' WHERE id='".$ilanID."'");
											}
										}
									}
									$guncelle=mysql_query("UPDATE ilanlar SET son_teklif = '".max($teklifler_array)."' WHERE id='".$ilanID."'");
									if($guncelle){
										$islem_durum = 1;
										$response=["message"=>"Başarılı","status"=>200];
									}else{
										$islem_durum = 0;
										$response=["message"=>"Hata","status"=>500];
									}
								}
							}else{
								if($row->ihale_tarihi." ".$row->ihale_saati < date("Y-m-d H:i:s")){
									$response=["message"=>"İhalenin süresi dolmuştur.","status"=>500];
									$islem_durum = 0;
								}else{
									if($token != ""){
										mysql_query("INSERT INTO `teklifler`(`id`,`ilan_id`,`uye_id`,`teklif`,`hizmet_bedeli`,`teklif_zamani`,`user_token`,`dogrudan_satisli_ilan_id`,`kurumsal_token`,ip,tarayici,isletim_sistemi,admin_teklif,admin_id,durum) 
										VALUES (NULL,'".$ilanID."','".$uyeID."','".$verilen_teklif."','".$hizmet_bedel."','".$date."','".$token."','','0','".$ip."','".$tarayici."','".$isletim_sistemi."','1','".$admin_id."','1')");
									
									}elseif($k_token !=""){
										mysql_query("INSERT INTO `teklifler`(`id`,`ilan_id`,`uye_id`,`teklif`,`hizmet_bedeli`,`teklif_zamani`,`user_token`,`dogrudan_satisli_ilan_id`,`kurumsal_token`,ip,tarayici,isletim_sistemi,admin_teklif,admin_id,durum) 
										VALUES (NULL,'".$ilanID."','".$uyeID."','".$verilen_teklif."','".$hizmet_bedel."','".$date."','','0','".$k_token."','".$ip."','".$tarayici."','".$isletim_sistemi."','1','".$admin_id."','1')");
									}
									
									$teklifler_array=array();
									$teklifler_cek=mysql_query("select * from teklifler where ilan_id='".$ilanID."' and durum=1 group by uye_id order by teklif_zamani desc");
									while($teklifler_oku=mysql_fetch_object($teklifler_cek)){
										$teklif_getir=mysql_query("select * from teklifler where ilan_id='".$teklifler_oku->ilan_id."' and uye_id='".$teklifler_oku->uye_id."' and durum=1 order by teklif_zamani desc limit 1 ");
										$teklif_oku=mysql_fetch_object($teklif_getir);
										array_push($teklifler_array,$teklif_oku->teklif);
									}

									$ilan_cek = mysql_query("SELECT * FROM ilanlar WHERE id = '".$ilanID."'");
									while($ilan_oku = mysql_fetch_array($ilan_cek)){
										$ihale_bitis=$ilan_oku["ihale_tarihi"]." ".$ilan_oku["ihale_saati"];
										$sigorta_sure_uzatma_durumu=$row3->sure_uzatma;
										$sigorta_dakikanin_altinda=$row3->dakikanin_altinda;
										$sigorta_dakika_uzar=$row3->dakika_uzar;
										if($sigorta_sure_uzatma_durumu=="1"){
											$yeni_trh=strtotime("+".$sigorta_dakika_uzar." minutes",strtotime($ihale_bitis));
											$yeni_trh=date("Y-m-d H:i:s",$yeni_trh);
											$explode=explode(" ",$yeni_trh);
											$yeni_t=$explode[0];
											$yeni_s=$explode[1];
											$date=date("Y-m-d H:i:s");
											$tarih=strtotime("-".$sigorta_dakikanin_altinda." minutes",strtotime($ihale_bitis));
											$tarih=date("Y-m-d H:i:s",$tarih);
											if($date>$tarih){
												$gosterilme_tarih=strtotime($yeni_trh)+300; //Gösterilme süresi 5 dk fazla olması istendi
												$gosterilme_tarih=date("Y-m-d H:i:s",$gosterilme_tarih);
												mysql_query("UPDATE ilanlar SET ihale_tarihi='".$yeni_t."', ihale_saati='".$yeni_s."', ihale_son_gosterilme='".$gosterilme_tarih."' WHERE id='".$ilanID."'");
											}
										}
									}
									$guncelle=mysql_query("UPDATE ilanlar SET son_teklif = '".max($teklifler_array)."' WHERE id='".$ilanID."'");
									if($guncelle){
										$islem_durum = 1;
										$response=["message"=>"Başarılı","status"=>200];
									}else{
										$islem_durum = 0;
										$response=["message"=>"Hata","status"=>500];
									}
								}
							}
						}
					}
				}
			}
		}

		
		if($islem_durum == 1){
			$ilan_cek = mysql_query("select * from ilanlar where id = '".$ilanID."'");
			$ilan_oku = mysql_fetch_object($ilan_cek);
			$ilan_sigorta = $ilan_oku->sigorta;
			$sigorta_cek = mysql_query("select * from sigorta_ozellikleri where id = '".$ilan_sigorta."'");
			$sigorta_oku = mysql_fetch_object($sigorta_cek);
			if($sigorta_oku->sure_uzatma == 1){
				$kac_dakikanin_altinda = $sigorta_oku->dakikanin_altinda;
				$kac_saniyenin_altinda = $kac_dakikanin_altinda * 60;
				$uzayacak_dikaka = $sigorta_oku->dakika_uzar;
				$ilan_bitis = strtotime($ilan_oku->ihale_tarihi." ".$ilan_oku->ihale_saati);
				$suan = strtotime(date('Y-m-d H:i:s'));
				$fark = $ilan_bitis - $suan;
				if($fark < $kac_saniyenin_altinda){
					$yeni_trh=strtotime("+".$uzayacak_dikaka." minutes",strtotime($ilan_bitis));
					$yeni_trh=date("Y-m-d H:i:s",$yeni_trh);
					$yeni_trh = date('Y-m-d H:i:s', strtotime('+'.$uzayacak_dikaka.' minutes', strtotime($ilan_oku->ihale_tarihi." ".$ilan_oku->ihale_saati)));
					$explode=explode(" ",$yeni_trh);
					$yeni_t=$explode[0];
					$yeni_s=$explode[1];
					$gosterilme_tarih=strtotime($yeni_trh)+300; //Gösterilme süresi 5 dk fazla olması istendi
					$gosterilme_tarih = date('Y-m-d H:i:s',$gosterilme_tarih);
					mysql_query("UPDATE ilanlar SET ihale_tarihi='".$yeni_t."', ihale_saati='".$yeni_s."', ihale_son_gosterilme='".$gosterilme_tarih."' WHERE id='".$ilanID."'");
				}
			}
		}
		
		/*
		if($islem_durum == 1){}
		$kac_saniyenin_altinda = $sigorta_dakikanin_altinda * 60;
		$bitis_first = strtotime(date($ilan_oku["ihale_tarihi"]." ".$ilan_oku["ihale_saati"]));
		$suan = strtotime(date('Y-m-d H:i:s'));
		$fark = $bitis_first - $suan;	
		if($fark<$kac_saniyenin_altinda){}
		*/



		echo json_encode($response);
	}
	if(re("action")=="cikis_yap_2"){
		$response=[];
		$token=re("token");
		$sorgu=mysql_query("select * from user where user_token='".$token."' or kurumsal_user_token='".$token."'  ");
		$row=mysql_fetch_object($sorgu);
			if($token != ""){
				$guncelle=mysql_query("update user set online_durum=0 where user_token='".$token."' or kurumsal_user_token='".$token."'  ");	
				if($guncelle){
					$response=[""=>"Durum 0 oldu"];
				}
			}else{
				$response=[""=>$token];
			}
			
		
		echo json_encode($plaka);
	}	
	if(re("action")=="panel_plaka_sorgu"){
		$response=[];
		$str="";
		$plaka=ucwords(re("plaka"));
		$sorgu=mysql_query("select * from ilanlar where plaka='".ucwords(re("plaka"))."' ");
		$sayi=mysql_num_rows($sorgu);
		$sira=1;
		if($sayi != 0){
			while($row=mysql_fetch_object($sorgu)){
				$statu_durumu='';
				$statu_cek=mysql_query("select * from kazanilan_ilanlar where ilan_id='".$row->id."'");
				if(mysql_num_rows($statu_cek)!=0){
					$statu_oku=mysql_fetch_object($statu_cek);
					if($statu_oku->durum=="0"){
						$statu_durumu='<span style="color:red;">Onay Bekliyor</span>';
					}else if($statu_oku->durum=="1"){
						$statu_durumu='<span style="color:red;">Ödeme Bekliyor</span>';
					}else if($statu_oku->durum=="2"){
						$statu_durumu='<span style="color:red;">Son İşlemde</span>';
					}else if($statu_oku->durum=="3"){
						$statu_durumu='<span style="color:red;">Satıldı</span>';
					}else if($statu_oku->durum=="4"){
						$statu_durumu='<span style="color:red;">İptal Edildi</span>';
					}else{
						$statu_durumu='';
					}
				}
				$marka=$row->marka;
				$model=$row->model;
				$sehir=$row->sehir;
				$profil=$row->profil;
				$model_yili=$row->model_yili;
				$sorgu2=mysql_query("select * from marka where markaID='".$marka."'");
				$row2=mysql_fetch_object($sorgu2);
				$marka_adi=$row2->marka_adi;
				
			
				$str .= $sira. " - " .$model_yili . "/" . $marka_adi . "/" . $model . "/" . $sehir . "/". $profil ."/".$statu_durumu."<br>";
				$sira++;
			}
			$response=["data"=>$str,"status"=>200];
		}else{
			$response=[""=>"","status"=>500];
		}
	
		echo json_encode($response);
	}
	if(re("action")=="panel_arac_kodu_sorgu"){
		$response=[];
		$str="";
		$arac_kodu=re("arac_kodu");
		$sorgu=mysql_query("select * from ilanlar where arac_kodu='".$arac_kodu."' ");
		$sayi=mysql_num_rows($sorgu);
		$sira=1;
		if($sayi != 0){
			while($row=mysql_fetch_object($sorgu)){
				$statu_durumu='';
				$statu_cek=mysql_query("select * from kazanilan_ilanlar where ilan_id='".$row->id."'");
				if(mysql_num_rows($statu_cek)!=0){
					$statu_oku=mysql_fetch_object($statu_cek);
					if($statu_oku->durum=="0"){
						$statu_durumu='<span style="color:red;">Onay Bekliyor</span>';
					}else if($statu_oku->durum=="1"){
						$statu_durumu='<span style="color:red;">Ödeme Bekliyor</span>';
					}else if($statu_oku->durum=="2"){
						$statu_durumu='<span style="color:red;">Son İşlemde</span>';
					}else if($statu_oku->durum=="3"){
						$statu_durumu='<span style="color:red;">Satıldı</span>';
					}else if($statu_oku->durum=="4"){
						$statu_durumu='<span style="color:red;">İptal Edildi</span>';
					}else{
						$statu_durumu='';
					}
				}

				$marka=$row->marka;
				$model=$row->model;
				$sehir=$row->sehir;
				$profil=$row->profil;
				$model_yili=$row->model_yili;
				$sorgu2=mysql_query("select * from marka where markaID='".$marka."'");
				$row2=mysql_fetch_object($sorgu2);
				$marka_adi=$row2->marka_adi;
				
			
				$str .= $sira. " - " .$model_yili . "/" . $marka_adi . "/" . $model . "/" . $sehir . "/". $profil ."/".$statu_durumu."<br>";
				$sira++;
			}
			$response=["data"=>$str,""=>$row,"status"=>200];
		}else{
			$response=[""=>"","status"=>500];
		}
	
		echo json_encode($response);
	}
	if(re("action")=="panel_tarih_sorgu"){
		$response=[];

		$ihale_tarihi=re("ihale_tarihi");
		$ihale_saati=re("ihale_saati");
		$gun_25=date("Y-m-d H:i:s",strtotime("+25 days"));
		if($ihale_tarihi != "" && $ihale_saati != ""){
			if(date("Y-m-d H:i:s") > $ihale_tarihi." ".$ihale_saati){
				$text="Geçmiş tarih girdiniz.";
				$response=["message"=>$text,""=>$ihale_tarihi." ".$ihale_saati,"status"=>200,"yayin_durum"=>0];
			}else if($gun_25< $ihale_tarihi." ".$ihale_saati){
				$text="Girilen tarihi kontrol ediniz..";
				$response=["message"=>$text,""=>$row,"status"=>200,"yayin_durum"=>1];
			}else{
				$response=[""=>"","status"=>500,"yayin_durum"=>1];
			}
		}

		echo json_encode($response);
	}
	if(re("action")=="panel_sigorta"){
		$response=[];
		$id=re("sigorta");
		$sorgu=mysql_query("select * from sigorta_ozellikleri where id='".$id."'");
		$row=mysql_fetch_object($sorgu);
		$sigorta_dosya_masrafi=$row->sigorta_dosya_masrafi;
		$sigort_pd=$row->pd_hizmeti;
		
		$sigorta_bitis_saati=$row->sigorta_bitis_saati;
		$sigorta_cekici_ucreti=$row->sigorta_cekici_ucreti;
		$sigorta_otopark_ucreti=$row->park_ucreti;
		$sigorta_vitrin = $row->vitrin;
		
		$response=["cekici_ucreti"=>$sigorta_cekici_ucreti,"otopark_ucreti"=>$sigorta_otopark_ucreti,"dosya_masrafi"=>$sigorta_dosya_masrafi,"pd"=>$sigort_pd,"saat"=>$sigorta_bitis_saati, "vitrindemi" => $sigorta_vitrin ,"status"=>200];
		echo json_encode($response);
	}	
	if(re("action")=="panel_zaman_duzenle2"){
		$response=[];
		$json_array=$_POST["json_array"];
		$tarih=re("secili_tarih");
		$saat=re("secili_saat");
		$array_decode=json_decode($json_array,true);
		$boyut=count($array_decode);
		for($i=0;$i<$boyut;$i++){
			$y_trh=$tarih." ".$saat.":00";
			$gosterilme_tarih=strtotime($y_trh)+300; //Gösterilme süresi 5 dk fazla olması istendi
			$gosterilme_tarih=date("Y-m-d H:i:s",$gosterilme_tarih);

			$a=mysql_query("UPDATE ilanlar SET ihale_tarihi = '".$tarih."', ihale_saati = '".$saat.":00"."', ihale_son_gosterilme='".$gosterilme_tarih."' WHERE id = '".$array_decode[$i]["a"]."' ");
		}
		if($a){
			$response=["message"=>"Başarılı","status"=>200];
		}else{
			$response=["message"=>"Güncelleme Başarısız","status"=>500];
		}
	
		echo json_encode($response);
	}	
	if(re("action")=="panel_zaman_duzenle"){
		$response=[];
	
		$uyari_kabul=re("uyari_durum");
		$yeni_saat=re("secili_saat");
		$tarih=re("secili_tarih");
	
		$array_decode=$_POST["json_array"];

		$boyut=count($array_decode);
		$status="true";
	
		for($i=0;$i<$boyut;$i++){
			$ilan_id=$array_decode[$i];
			$sorgu=mysql_query("select * from ilanlar where id='".$ilan_id."' ");
			$row=mysql_fetch_object($sorgu);
			if((date("Y-m-d H:i:s")>$tarih." ".$yeni_saat.":00") && ($row->ihale_tarihi." ".$row->ihale_saati > date("Y-m-d H:i:s"))){
				if($uyari_kabul!=1){
					$status="false";
					$response_text = ["message"=>"Belirlemek istediğiniz saat ve tarih ihalenin kapanmasına neden oluyor.İşlemi yapmak için uyarıları kabul etmelisiniz.","status"=>500,"ihale_durum"=>1];
				}else{
					$y_trh=$tarih." ".$yeni_saat.":00";
					$gosterilme_tarih=strtotime($y_trh)+300; //Gösterilme süresi 5 dk fazla olması istendi
					$gosterilme_tarih=date("Y-m-d H:i:s",$gosterilme_tarih);
				}
			}else if( ($row->ihale_tarihi." ".$row->ihale_saati < date("Y-m-d H:i:s")) && (date("Y-m-d H:i:s") < $tarih." ".$yeni_saat.":00")){
				if($uyari_kabul!=1){
					$status="false";
					$response_text=["message"=>"Belirlemek istediğiniz saat ihalenin açılmasına neden oluyor.İşlemi yapmak için uyarıları kabul etmelisiniz.","status"=>500,"ihale_durum"=>1];
					
				}else{
					$y_trh=$tarih." ".$yeni_saat.":00";
					$gosterilme_tarih=strtotime($y_trh)+300; //Gösterilme süresi 5 dk fazla olması istendi
					$gosterilme_tarih=date("Y-m-d H:i:s",$gosterilme_tarih);
				}
			}else{
				$y_trh=$tarih." ".$yeni_saat.":00";
				$gosterilme_tarih=strtotime($y_trh)+300; //Gösterilme süresi 5 dk fazla olması istendi
				$gosterilme_tarih=date("Y-m-d H:i:s",$gosterilme_tarih);
			}
		}
		if($status=="true"){
			if((date("Y-m-d H:i:s")>$tarih." ".$yeni_saat.":00")){
				$durum = -1;
			}else{
				$durum = 1;
			}
			for($i=0;$i<$boyut;$i++){
				$ilan_id=$array_decode[$i];
				$guncelle=mysql_query("UPDATE ilanlar SET ihale_tarihi = '".$tarih."', ihale_saati = '".$yeni_saat.":00"."',durum='".$durum."',ihale_son_gosterilme='".$gosterilme_tarih."' WHERE id = '".$ilan_id."' ");	
			}
			$response=["message"=>"Başarılı","status"=>200];
		}else{
			$response=$response_text;
		}
		
		echo json_encode($response);
	}
	if(re("action")=="panel_model"){
		$response=[];
		$json_array=$_POST["json_array"];
		
		$array_decode=json_decode($json_array,true);		
		$array_count=count($array_decode);
		$model_array=array();
		$a=0;
		$str='<input type="text" class="span4" id="model_filter_input" style="width: 100%;" placeholder="Model Arayın" onkeyup="search_in_div(\'filter_model\',\'model_filter_input\')">';
		for($i=0;$i<$array_count;$i++){
			$array_decode[$i]["marka_id"]=str_replace('"','',$array_decode[$i]["marka_id"]);
			$parcala=explode("_",$array_decode[$i]["marka_id"]);
			$sorgu=mysql_query("select * from model where marka_id = '".$parcala[1]."'");
			// var_dump("select * from model where marka_id = '".$parcala[1]."'");
			while($row=mysql_fetch_object($sorgu)){
				$model_say=mysql_query("select * from ilanlar where durum=1 and model='".$row->model_adi."'");
				$model_sayisi=mysql_num_rows($model_say);
				$model_array[$a]="";
				if($model_sayisi > 0){
					$model_array[$a]="true";
				}

				if($model_array[$a]=="true"){
					$str .=
					'<div class="filter_model filter_check_box modelmarka_'.$row->marka_id.'"  >
						<input type="checkbox" name="model[]" id="model_'.$row->model_adi.'" value="'.$row->model_adi.'" >'.$row->model_adi.'
					</div> ';
				}
				$a++;
				
				/*$str .='<label for="'.$row->modelID.'">
					<input type="checkbox" name="model[]" value="'.$row->modelID.'" />'.$row->model_adi.'</label>
					';*/
		
			}
		}
		$response=["str"=>$str,"status"=>200];
		echo json_encode($response);
	}	
	if(re("action")=="yedek_sil"){
		$response=[];
		$gelen=re("yedek_id");
		$gelen_user=re("user_id");
		$sorgu=mysql_query("select * from user where id='".$gelen_user."'");
		$kullaniciyi_getir_gel=mysql_fetch_assoc($sorgu);
		$yedek_ad=$kullaniciyi_getir_gel["yedek_kisi"];
		$yedek_tel=$kullaniciyi_getir_gel["yedek_kisi_tel"];
		$yedek_ad=explode(",",$yedek_ad);
		$yedek_tel=explode(",",$yedek_tel);
		unset($yedek_ad[$gelen]);
		unset($yedek_tel[$gelen]);
		$yeni_yedek_ad = implode(",", $yedek_ad);
		$yeni_yedek_tel = implode(",", $yedek_tel);
		$guncelle=mysql_query(" update user set yedek_kisi='".$yeni_yedek_ad."',yedek_kisi_tel='".$yeni_yedek_tel."' where id = '".$gelen_user."'" );
		if($guncelle){
			$response=["message"=>"Başarılı","status"=>200];
		}else{
			$response=["message"=>"Hata","status"=>500];
		}
	
		echo json_encode($response);
	}
	if(re("action")=="panel_tarih_guncelle"){
		$response=[];
		$ilan_id=re("ilan_id");
		$uyari_kabul=re("uyari_durum");
		$yeni_saat=re("saat");
		$tarih=re("tarih");
		$sorgu=mysql_query("select * from ilanlar where id='".$ilan_id."' ");
		$row=mysql_fetch_object($sorgu);
		if((date("Y-m-d H:i:s")>$tarih." ".$yeni_saat.":00") && ($row->ihale_tarihi." ".$row->ihale_saati > date("Y-m-d H:i:s"))){
			if($uyari_kabul!=1){
				$response = ["message"=>"Belirlemek istediğiniz saat ve tarih ihalenin kapanmasına neden oluyor.İşlemi yapmak için uyarıları kabul etmelisiniz.","status"=>500,"ihale_durum"=>1];
			}else{
				$y_trh=$tarih." ".$yeni_saat.":00";
				$gosterilme_tarih=strtotime($y_trh)+300; //Gösterilme süresi 5 dk fazla olması istendi
				$gosterilme_tarih=date("Y-m-d H:i:s",$gosterilme_tarih);
				$guncelle=mysql_query("UPDATE ilanlar SET ihale_tarihi = '".$tarih."', ihale_saati = '".$yeni_saat.":00"."',durum=-1,ihale_son_gosterilme='".$gosterilme_tarih."' WHERE id = '".$ilan_id."' ");
				if($guncelle){
					$response=["message"=>"Başarılı","status"=>200];
				}else{
					$response=["message"=>"Hata","status"=>500];
				}
			}
		}else if( ($row->ihale_tarihi." ".$row->ihale_saati < date("Y-m-d H:i:s")) && (date("Y-m-d H:i:s") < $tarih." ".$yeni_saat.":00")){
			if($uyari_kabul!=1){
				$response=["message"=>"Belirlemek istediğiniz saat ihalenin açılmasına neden oluyor.İşlemi yapmak için uyarıları kabul etmelisiniz.","status"=>500,"ihale_durum"=>1];
			}else{
				$y_trh=$tarih." ".$yeni_saat.":00";
				$gosterilme_tarih=strtotime($y_trh)+300; //Gösterilme süresi 5 dk fazla olması istendi
				$gosterilme_tarih=date("Y-m-d H:i:s",$gosterilme_tarih);
				$guncelle=mysql_query("UPDATE ilanlar SET ihale_tarihi = '".$tarih."', ihale_saati = '".$yeni_saat.":00"."',durum=1,ihale_son_gosterilme='".$gosterilme_tarih."' WHERE id = '".$ilan_id."' ");
				if($guncelle){
					$response=["message"=>"Başarılı","status"=>200];
				}else{
					$response=["message"=>"Hata","status"=>500];
				}
				
			}
		}else{
			$y_trh=$tarih." ".$yeni_saat.":00";
			$gosterilme_tarih=strtotime($y_trh)+300; //Gösterilme süresi 5 dk fazla olması istendi
			$gosterilme_tarih=date("Y-m-d H:i:s",$gosterilme_tarih);
			$guncelle=mysql_query("UPDATE ilanlar SET ihale_tarihi = '".$tarih."', ihale_saati = '".$yeni_saat.":00"."',ihale_son_gosterilme='".$gosterilme_tarih."' WHERE id = '".$ilan_id."' ");
			if($guncelle){
				$response=["message"=>"Başarılı","status"=>200];
			}else{
				$response=["message"=>"Hata","status"=>500];
			}
			
		}
		echo json_encode($response);
	}
	if(re("action")=="ilan_resim_ekle"){
		$response=[];
		$resim=$_FILES["resim"];
		$ilan_id=re("id");
		if ($_FILES['resim']['name'] != "")
		{	
			include ('simpleimage.php');
			$dosya_sayi = count($_FILES['resim']['name']);
			$yukleme_durum=true; 
			$ad_array=[];
			$resim_id_array=[];

			for ($i = 0;$i < $dosya_sayi;$i++)
			{
				if (!empty($_FILES['resim']['name'][$i]))
				{
					$dosya_adi = $_FILES["resim"]["name"][$i]; 
					$dizim = array("iz","et","se","du","yr","nk");
					$uzanti = substr($dosya_adi, -4, 4);
					$rasgele = rand(1, 1000000);
					$ad = $dizim[rand(0, 5) ] . $rasgele . ".png";
					$yeni_ad = "images/" . $ad;
					$a=move_uploaded_file($_FILES["resim"]['tmp_name'][$i], $yeni_ad);

					$image_info = getimagesize($_FILES["resim"]["tmp_name"][$i]);
					$image_width = $image_info[0];
					
					copy($yeni_ad, $k_ad);
					$image = new SimpleImage();
					$image->load($yeni_ad);
					// $image->resizeToWidth(1000);
					$image->resizeToWidth($image_width);
					$image->save($yeni_ad);
					$ad_array[]=["sira"=>$i,"ad"=>$ad];
					
					$kaydet=mysql_query("INSERT INTO ilan_resimler (`id`,`ilan_id`,`resim`) VALUES (NULL, '" . $ilan_id . "', '" . $ad . "')");
					$eklenen_resim=mysql_query("select * from ilan_resimler where ilan_id='".$ilan_id."' and resim='".$ad."' ");
					$eklenen_resim_cek=mysql_fetch_object($eklenen_resim);
					$eklenen_resim_id=$eklenen_resim_cek->id;
					$resim_id_array[]=["sira"=>$i,"resim_id"=>$eklenen_resim_id];
				}
			}
			$response=["message"=>"Resimler başarıyla eklendi","yukleme_sayisi"=>$dosya_sayi,"resim"=>$ad_array,"resim_id"=>$resim_id_array,"status"=>200 ];
		}
		else{
			$response=["message"=>"Dosya bulunamadı","status"=>500 ];
		}
		
		echo json_encode($response);
	}
	if(re("action")=="ilan_resim_sil"){
		$response=[];
		$id=re("id");
		$sil= mysql_query("DELETE FROM ilan_resimler WHERE id='".$id."'"); 
		if($sil==true){
			$response=["message"=>"Resimler başarıyla silindi","status"=>200 ];
		}
		echo json_encode($response);
	}
	if(re("action")=="ilan_resimleri_sil"){
		$response=[];
		$id=re("id");
		$sil=mysql_query("DELETE FROM ilan_resimler WHERE ilan_id = '".$id."'");
		if($sil==true){
			$response=["message"=>"Resimler başarıyla silindi","status"=>200 ];
		}else{
			$response=["message"=>"hata","status"=>500 ];
		}
		echo json_encode($response);
	}
	
	if(re("action")=="dogrudan_ilan_resim_ekle"){
		$response=[];
		$resim=$_FILES["resim"];
		$ilan_id=re("id");
		if ($_FILES['resim']['name'] != "")
		{	
			include ('simpleimage.php');
			$dosya_sayi = count($_FILES['resim']['name']);
			$yukleme_durum=true; 
			$ad_array=[];
			$resim_id_array=[];

			for ($i = 0;$i < $dosya_sayi;$i++)
			{
				if (!empty($_FILES['resim']['name'][$i]))
				{
					$dosya_adi = $_FILES["resim"]["name"][$i]; 
					$dizim = array("iz","et","se","du","yr","nk");
					$uzanti = substr($dosya_adi, -4, 4);
					$rasgele = rand(1, 1000000);
					$ad = $dizim[rand(0, 5) ] . $rasgele . ".png";
					$yeni_ad = "images/" . $ad;
					$a=move_uploaded_file($_FILES["resim"]['tmp_name'][$i], $yeni_ad);

					$image_info = getimagesize($_FILES["resim"]["tmp_name"][$i]);
					$image_width = $image_info[0];
					
					copy($yeni_ad, $k_ad);
					$image = new SimpleImage();
					$image->load($yeni_ad);
					// $image->resizeToWidth(1000);
					$image->resizeToWidth($image_width);
					$image->save($yeni_ad);
					$ad_array[]=["sira"=>$i,"ad"=>$ad];
					
					$kaydet=mysql_query("INSERT INTO dogrudan_satisli_resimler (`id`,`ilan_id`,`resim`) VALUES (NULL, '" . $ilan_id . "', '" . $ad . "')");
					$eklenen_resim=mysql_query("select * from dogrudan_satisli_resimler where ilan_id='".$ilan_id."' and resim='".$ad."' ");
					$eklenen_resim_cek=mysql_fetch_object($eklenen_resim);
					$eklenen_resim_id=$eklenen_resim_cek->id;
					$resim_id_array[]=["sira"=>$i,"resim_id"=>$eklenen_resim_id];
				}
			}
			$response=["message"=>"Resimler başarıyla eklendi","yukleme_sayisi"=>$dosya_sayi,"resim"=>$ad_array,"resim_id"=>$resim_id_array,"status"=>200 ];
		}
		else{
			$response=["message"=>"Dosya bulunamadı","status"=>500 ];
		}
		
		echo json_encode($response);
	}
	if(re("action")=="dogrudan_resim_sil"){
		$response=[];
		$id=re("id");
		$sil= mysql_query("DELETE FROM dogrudan_satisli_resimler WHERE id='".$id."'"); 
		if($sil==true){
			$response=["message"=>"Resimler başarıyla silindi","status"=>200 ];
		}
		echo json_encode($response);
	}
	if(re("action")=="dogrudan_resimleri_sil"){
		$response=[];
		$id=re("id");
		$sil=mysql_query("DELETE FROM dogrudan_satisli_resimler WHERE ilan_id = '".$id."'");
		if($sil==true){
			$response=["message"=>"Resimler başarıyla silindi","status"=>200 ];
		}else{
			$response=["message"=>"hata","status"=>500 ];
		}
		echo json_encode($response);
	}
	
	
	
	if(re("action")=="panel_teklif_sil"){
		$response=[];
		$id=re("teklif_id");
		$teklif_cek=mysql_query("select * from teklifler where id='".$id."' ");
		$teklif_oku=mysql_fetch_object($teklif_cek);
		$teklif=$teklif_oku->teklif;
		$ilan_cek=mysql_query("select * from ilanlar where id='".$teklif_oku->ilan_id."'");
		$ilan_oku=mysql_fetch_object($ilan_cek);
	
		$ilan_son_teklif=$ilan_oku->son_teklif;
		//if($teklif==$ilan_son_teklif){
		
		$update=mysql_query("update teklifler set durum=0 WHERE id = '".$id."'");
		
		$teklif_say_sql=mysql_query("select * from teklifler where ilan_id='".$teklif_oku->ilan_id."' and durum=1 ");
		$teklif_cek2=mysql_query("select * from teklifler where ilan_id='".$teklif_oku->ilan_id."' and durum=1 group by uye_id order by teklif_zamani ");
		$teklif_say=mysql_num_rows($teklif_say_sql);
		
		if($teklif_say!=0){
			$teklifler_array=array();
			while($teklif_oku2=mysql_fetch_object($teklif_cek2)){
				$teklifleri_cek=mysql_query("select * from teklifler where ilan_id='".$teklif_oku2->ilan_id."' and uye_id='".$teklif_oku2->uye_id."' and durum=1 order by teklif_zamani desc limit 1 ");
				$teklifleri_oku=mysql_fetch_object($teklifleri_cek);
				$pushla=array_push($teklifler_array,$teklifleri_oku->teklif);
			}
			$ilani_guncelle=mysql_query("update ilanlar set son_teklif='".max($teklifler_array)."' where id='".$teklif_oku->ilan_id."'");
			if($ilani_guncelle){
				$response=["message"=>"Teklif başarıyla silindi ","status"=>200 ];
			}else{
				$response=["message"=>"hata","status"=>500 ];
			}
			
		}else{
			// mysql_query("UPDATE ilanlar SET son_teklif = '0' WHERE id='".$teklif_oku->ilan_id."'");
			mysql_query("UPDATE ilanlar SET son_teklif = '".$ilan_oku->acilis_fiyati."' WHERE id='".$teklif_oku->ilan_id."'");
			if($update){
				$response=["message"=>"Teklif silindi","status"=>200 ];
			}else{
				$response=["message"=>"hata","status"=>500 ];
			}
			
		}
			
		/*} else{
			$update=mysql_query("update teklifler set durum=0 WHERE id = '".$id."'");
			if($update){
				$response=["message"=>"Teklif silindi","status"=>200 ];
			}else{
				$response=["message"=>"hata","status"=>500 ];
			}
		}*/
	
		echo json_encode($response);
	}
	if(re("action")=="panel_admin_mesaj_okundu"){
		$response=[];	
		$dizi= $_POST["dizi"];
		for($i=0;$i<count($_POST["dizi"]);$i++){
			$guncelle=mysql_query("update mesajlar set durum=1 where id='".$_POST["dizi"][$i]."'");
		}
		echo json_encode($response);
	}
	if(re("action")=="statuleri_getir"){
		$response=[];	
	
		$serbest_secim_k_id=re("serbest_secim_k_id");
		$teklif_id=re("teklif_id");
		$statu_secim=re("statu_secim");	
		$ilan_id=re("ilan_id");
		$teklif_cek=mysql_query("select * from teklifler where id='".$teklif_id."'");
		$teklif_oku=mysql_fetch_object($teklif_cek);
		$uye_id="";
		
		// $kazanilan_sql=mysql_query("select * from kazanilan_ilanlar where ilan_id <>'".$ilan_id."'");
		$kazanilan_sql=mysql_query("select * from kazanilan_ilanlar where ilan_id = '".$ilan_id."'");
		$kazanilan_fetch=mysql_fetch_array($kazanilan_sql);
		
		
		$ilan_sql=mysql_query("select * from ilanlar where id='".$ilan_id."'");
		$ilan_fetch=mysql_fetch_assoc($ilan_sql);
		$arac_kodu=$ilan_fetch["arac_kodu"];
		$plaka=$ilan_fetch["plaka"];
		$marka_sql=mysql_query("select * from marka where markaID='".$ilan_fetch["marka"]."' ");
		$marka_fetch=mysql_fetch_assoc($marka_sql);
		$marka_model=$ilan_fetch["model_yili"]." / ".$marka_fetch["marka_adi"]." / ".$ilan_fetch["model"]." ".$ilan_fetch["tip"];
		
		$statu_sms_cek=mysql_query("select * from statu_smsleri where statu_id='".$statu_secim."'");
		/*var_dump("select * from statu_smsleri where statu_id='".$statu_secim."'");*/		
		$statu_sms_fetch=mysql_fetch_assoc($statu_sms_cek);
		$statu_sms=$statu_sms_fetch["sms_icerigi"];
		$statu_sms=str_replace("%1%",$arac_kodu,$statu_sms); //araç kodu
		$statu_sms=str_replace("%2%",$plaka,$statu_sms); //plaka
		$statu_sms=str_replace("%3%",$marka_model,$statu_sms); //model_yili / marka / model tip
		
		if(mysql_num_rows($kazanilan_sql)>0 && $kazanilan_fetch["son_odeme_tarihi"]!="0000-00-00" ){
			$statu_sms=str_replace("%4%",date('d-m-Y',strtotime($kazanilan_fetch["son_odeme_tarihi"])),$statu_sms); //Son ödeme tarihi 
		}else{
			if(date('N', strtotime(date('Y-m-d'))) < 6){
				$hesaplanmis_tarih = date ( 'Y-m-d' , strtotime ( '2 weekdays' ) );
			}else{
				$hesaplanmis_tarih = date ( 'Y-m-d' , strtotime ( '3 weekdays' ) );
			}

			$gun=3;
			$gun_ekle='+'.$gun.' days';
			//$hesaplanmis_tarih=date('Y-m-d', strtotime($gun_ekle));
			$str=(string) date('D',strtotime($gun_ekle));
			$array=array("Sat","Sun");
			$sayi=0;
			$durum=true;
			while($durum){
				if(in_array($str,$array)){
					$gun=$gun+1;
					$gun_ekle='+'.$gun.' days';
					$hesaplanmis_tarih=date('Y-m-d',strtotime($gun_ekle));
					$str=(string) date('D',strtotime($gun_ekle));
				}else{
					$durum=false;
				}
			} 
			$statu_sms=str_replace("%4%",date('d-m-Y',strtotime($hesaplanmis_tarih)),$statu_sms); //Son ödeme tarihi 
		}
		
		// $odeme_bildirimi_url="https://ihale.pertdunyasi.com/images/pdf/".rawurlencode($kazanilan_fetch["odeme_bildirimi"]);
		$odeme_bildirimi_url="https://ihale.pertdunyasi.com/odeme_bildirimi_pdf.php?ilan_id=".$ilan_id;
		$statu_sms=str_replace("%5%",$odeme_bildirimi_url,$statu_sms); //Ödeme bildirimi
		
		
	
		if($serbest_secim_k_id!=""){
			$uye_id=$serbest_secim_k_id;
		}else{
			$uye_id=$teklif_oku->uye_id;
		}

		if($teklif_id !="" && $serbest_secim_k_id !="" ){
			$response=["message"=>"Sadece bir üye seçmelisiniz","statu_sms"=>$statu_sms,"status"=>500];
		} else if($teklif_id =="" && $serbest_secim_k_id==""){
			
			$response=["message"=>"Üye seçmelisiniz","statu_sms"=>$statu_sms,"status"=>500];
		}else if($statu_secim==""){
			$response=["message"=>"Statü seçmelisiniz","statu_sms"=>$statu_sms,"status"=>500];
		} else{	
			$otomatik_engelle=false;
			$onay_bekleyen_cek=mysql_query("select * from kazanilan_ilanlar where durum=0 and uye_id='".$uye_id."' and ilan_id !='".$ilan_id."' ");
			$onay_bekleyen_say=mysql_num_rows($onay_bekleyen_cek);
			$odeme_bekleyen_cek=mysql_query("select * from kazanilan_ilanlar where durum=1 and uye_id='".$uye_id."' and ilan_id !='".$ilan_id."' ");
			$odeme_bekleyen_say=mysql_num_rows($odeme_bekleyen_cek);
			$son_islemde_cek=mysql_query("select * from kazanilan_ilanlar where durum=2 and uye_id='".$uye_id."' and ilan_id !='".$ilan_id."' ");
			$son_islemde_say=mysql_num_rows($son_islemde_cek);
			$satin_alinan_cek=mysql_query("select * from kazanilan_ilanlar where durum=3 and uye_id='".$uye_id."' and ilan_id !='".$ilan_id."' ");
			$satin_alinan_say=mysql_num_rows($satin_alinan_cek);
			$iptal_edilen_cek=mysql_query("select * from kazanilan_ilanlar where durum=4 and uye_id='".$uye_id."' and ilan_id !='".$ilan_id."' ");
			$iptal_edilen_say=mysql_num_rows($iptal_edilen_cek);			
			if($statu_secim==0){
				$onay_bekleyen_say=$onay_bekleyen_say+1;
			}
			if($statu_secim==1){
				$odeme_bekleyen_say=$odeme_bekleyen_say+1;
			}
			if($statu_secim==2){
				$son_islemde_say=$son_islemde_say+1;
			}	
			if($statu_secim==3){
				$satin_alinan_say=$satin_alinan_say+1;
			}
			if($statu_secim==4){
				$iptal_edilen_say=$iptal_edilen_say+1;
			}

			if($onay_bekleyen_say>=3 || $odeme_bekleyen_say>=1 ){
				$otomatik_engelle=true;
			}
			$response=[
				"otamatik_engelle"=>$otomatik_engelle,
				"onay_bekleyen"=>$onay_bekleyen_say,
				"odeme_bekleyen"=>$odeme_bekleyen_say,
				"son_islemde"=>$son_islemde_say,
				"satin_alinan"=>$satin_alinan_say,
				"iptal_edilenler"=>$iptal_edilen_say,
				"statu_sms"=>$statu_sms,
				"status"=>200
			];
		}
		echo json_encode($response);
	}	
	if(re("action")=="statu_guncelle"){
		$admin_id = $_SESSION['kid'];
		$admin_yetki_cek=mysql_query("Select * from kullanicilar where id='".$admin_id."' ");
		$admin_yetki_oku=mysql_fetch_assoc($admin_yetki_cek);
		$yetkiler=$admin_yetki_oku["yetki"];
		$yetki_parcala=explode("|",$yetkiler);
	
		$response=[];
		$ilan_id=re("ilan_id");
		$teklif_id=re("teklifler");
		$serbest_secim=re("serbest_secim");
		$kazandigi_tutar=re("kazandigi_tutar");
		$statu_bilgileri=re("statu_bilgileri");
		$aciklama=re("aciklama");
		$son_odeme_tarihi=re("son_odeme_tarihi");
		$otomatik_mesaj=re("otomatik_mesaj");
		$mtv=re("mtv");
		$mtv_not=re("mtv_not");
		$pd_hizmet=re("pd_hizmet");
		$parca_1=re("parca_1");
		$parca_1_not=re("parca_1_not");
		$parca_2=re("parca_2");
		$parca_2_not=re("parca_2_not");
		$parca_3=re("parca_3");
		$parca_3_not=re("parca_3_not");
		$noter_takipci=re("noter_takipci");
		
		$teklif_getir=mysql_query("select * from teklifler where id='".$teklif_id."'");
		$teklif_cek=mysql_fetch_object($teklif_getir);
		$ilan_cek=mysql_query("select * from ilanlar where id='".$ilan_id."'");
		$ilan_oku=mysql_fetch_object($ilan_cek);
		$ilan_sigorta_id=$ilan_oku->sigorta;
		
		$sigorta_cek=mysql_query("select * from sigorta_ozellikleri where id='".$ilan_sigorta_id."'");
		$sigorta_oku=mysql_fetch_object($sigorta_cek);
		//$dosya_masrafi=$sigorta_oku->sigorta_dosya_masrafi;
		$dosya_masrafi=$ilan_oku->dosya_masrafi;
		
		if(re("teklifler")!=""){
			$uye_id=$teklif_cek->uye_id;
			$secim_turu=0; //Teklif verenlerden seçim yaptıysa
		}else{
			$uye_id=re("serbest_secim");
			$secim_turu=1; //Üyelerden seçim yaptıysa
		}
		if($statu_bilgileri!=1){
			$son_odeme_tarihi="";
		}
		$toplam_odenecek = (int) $kazandigi_tutar + (int) $dosya_masrafi + (int) $pd_hizmet + (int) $noter_takipci;
		$toplam_parcalar=(int) $parca_1 + (int) $parca_2 + (int) $parca_3;
		if(!in_array(3, $yetki_parcala)){
			$response=["message"=>"Statü güncelleme yetkiniz bulunmamaktadır.","status"=>500];
		}
		else if($teklif_id !="" && $serbest_secim !="" ){
			$response=["message"=>"Sadece bir üye seçmelisiniz","status"=>500];
		} else if($teklif_id =="" && $serbest_secim==""){
			$kazan_ilan=mysql_query("SELECT * FROM kazanilan_ilanlar WHERE ilan_id='".$ilan_id."'");
			if(mysql_num_rows($kazan_ilan)>0){
				$delete=mysql_query("delete from kazanilan_ilanlar where ilan_id='".$ilan_id."'");
				$response=["message"=>"Atama işlemi başarıyla kaldırıldı","kaldırma_islemi"=>"true","status"=>200];
			}else{
				$response=["message"=>"Üye seçmelisiniz","status"=>500];
			}
		}else if($statu_bilgileri==""){
			$response=["message"=>"Statü seçmelisiniz","status"=>500];
		}else if($statu_bilgileri==1 && $son_odeme_tarihi==""){
			$response=["message"=>"Son tarih belirlemelisiniz","status"=>500];
		}else if($toplam_odenecek!=$toplam_parcalar && $statu_bilgileri==1 ){
			$response=["message"=>"Toplam parça tutarları ile toplam ödenecek miktarı eşit değil. Toplam ödenecek tutar $toplam_odenecek ₺ olmalı","status"=>500];
		}else if($otomatik_mesaj==""){
			$response=["message"=>"Otomatik mesaj kısmını doldurmalısınız.","status"=>500];
		}else if($parca_1=="" && $statu_bilgileri==1 ){
			$response=["message"=>"Parça 1 kısmını doldurunuz","status"=>500];
		}else if($parca_2=="" && $statu_bilgileri==1 ){
			$response=["message"=>"Parça 2 kısmını doldurunuz","status"=>500];
		}else if($parca_3=="" && $statu_bilgileri==1 ){
			$response=["message"=>"Parça 3 kısmını doldurunuz","status"=>500];
		}else if($kazandigi_tutar==""){
			$response=["message"=>"Kazandığı tutarı belirlemelisiniz","status"=>500];
		} /* else if($statu_bilgileri==1 && $mtv==""){
			$response=["message"=>"MTV tutarı belirlemelisiniz","status"=>500];
		} */ else{
			$kazanilan_ilanlar_cek=mysql_query("select * from kazanilan_ilanlar where ilan_id='".$ilan_id."'");
			$kazanilan_ilanlar_say=mysql_num_rows($kazanilan_ilanlar_cek);
			if($kazanilan_ilanlar_say==0){
				if($statu_bilgileri!=1){
					$kaydet=mysql_query("INSERT INTO `kazanilan_ilanlar` (`id`, `uye_id`, `ilan_id`, `kazanilan_teklif`, `dosya_masrafi`, `pd_hizmet`, `noter_takipci_gideri`, `mtv`, `mtv_not`,`durum`, `son_odeme_tarihi`, `aciklama`, `otomatik_mesaj`, 
					`e_tarih`,`secim_turu`) VALUES (NULL, '".$uye_id."', '".$ilan_id."', '".$kazandigi_tutar."', '".$dosya_masrafi."', '".$pd_hizmet."', '".(int)$noter_takipci."', '".(int)$mtv."','".$mtv_not."', '".$statu_bilgileri."','".$son_odeme_tarihi."',
					'".$aciklama."', '".$otomatik_mesaj."', '".date("Y-m-d H:i:s")."','".$secim_turu."')");
				}else{
					$kaydet=mysql_query("INSERT INTO `kazanilan_ilanlar` (`id`, `uye_id`, `ilan_id`, `kazanilan_teklif`, `dosya_masrafi`, `pd_hizmet`, `noter_takipci_gideri`, `durum`, `son_odeme_tarihi`, `aciklama`, `otomatik_mesaj`, `e_tarih`,
					`secim_turu`,`parca_1`,`parca_1_not`,`parca_2`,`parca_2_not`,`parca_3`,`parca_3_not`) VALUES (NULL, '".$uye_id."', '".$ilan_id."', '".$kazandigi_tutar."', '".$dosya_masrafi."', '".$pd_hizmet."', '".(int)$noter_takipci."', 
					'".$statu_bilgileri."','".$son_odeme_tarihi."','".$aciklama."','".$otomatik_mesaj."','".date("Y-m-d H:i:s")."','".$secim_turu."','".$parca_1."','".$parca_1_not."','".$parca_2."','".$parca_2_not."','".$parca_3."','".$parca_3_not."')");
				}
				$uye_onay_bekleyen_cek=mysql_query("select * from kazanilan_ilanlar where durum=0 and uye_id='".$uye_id."'");
				$uye_onay_bekleyen_say=mysql_num_rows($uye_onay_bekleyen_cek);
				$uye_odeme_bekleyen_cek=mysql_query("select * from kazanilan_ilanlar where durum=1 and uye_id='".$uye_id."'");
				$uye_odeme_bekleyen_say=mysql_num_rows($uye_odeme_bekleyen_cek);
				if($uye_odeme_bekleyen_say>=1 || $uye_onay_bekleyen_say>=3){
					$otomatik_engelle="on";
				}else{
					$otomatik_engelle="";
				}
				/*$guncelle=mysql_query("update uye_durumlari set otomatik_teklif_engelle='".$otomatik_engelle."' where uye_id='".$uye_id."'");*/
				$guncelle=mysql_query("update uye_durumlari set otomatik_teklif_engelle='".re("riske_gore_teklif")."' where uye_id='".$uye_id."'");
				if($kaydet && $guncelle){
					$response=["message"=>"İşlem başarılı","status"=>200];
				}else{
					$response=["message"=>"Hata","status"=>500];
				}
			}else{
				if($statu_bilgileri!=1){
					$guncelle_kaydet=mysql_query("UPDATE kazanilan_ilanlar SET uye_id = '".$uye_id."',kazanilan_teklif='".$kazandigi_tutar."',pd_hizmet='".(int)$pd_hizmet."',durum='".$statu_bilgileri."',noter_takipci_gideri = '".(int)$noter_takipci."',
					son_odeme_tarihi='".$son_odeme_tarihi."',aciklama='".$aciklama."',dosya_masrafi = '".$dosya_masrafi."',otomatik_mesaj='".$otomatik_mesaj."',e_tarih='".date("Y-m-d H:i:s")."',secim_turu='".$secim_turu."' WHERE ilan_id = '".$ilan_id."'");					
				}else{
					$guncelle_kaydet=mysql_query("UPDATE kazanilan_ilanlar SET uye_id = '".$uye_id."',kazanilan_teklif='".$kazandigi_tutar."',pd_hizmet='".(int)$pd_hizmet."',mtv='".$mtv."',mtv_not='".$mtv_not."',durum='".$statu_bilgileri."',
					son_odeme_tarihi='".$son_odeme_tarihi."',aciklama='".$aciklama."',dosya_masrafi = '".$dosya_masrafi."',otomatik_mesaj='".$otomatik_mesaj."',e_tarih='".date("Y-m-d H:i:s")."',secim_turu='".$secim_turu."',parca_1='".$parca_1."',parca_1_not='".$parca_1_not."',
					parca_2='".$parca_2."',parca_2_not='".$parca_2_not."',parca_3='".$parca_3."',parca_3_not='".$parca_3_not."',noter_takipci_gideri = '".(int)$noter_takipci."' WHERE ilan_id = '".$ilan_id."'");
				}
				$uye_onay_bekleyen_cek=mysql_query("select * from kazanilan_ilanlar where durum=0 and uye_id='".$uye_id."'");
				$uye_onay_bekleyen_say=mysql_num_rows($uye_onay_bekleyen_cek);
				$uye_odeme_bekleyen_cek=mysql_query("select * from kazanilan_ilanlar where durum=1 and uye_id='".$uye_id."'");
				$uye_odeme_bekleyen_say=mysql_num_rows($uye_odeme_bekleyen_cek);
				if($uye_odeme_bekleyen_say>=1 || $uye_onay_bekleyen_say>=3){
					$otomatik_engelle="on";
				}else{
					$otomatik_engelle="";
				}
				/*$guncelle=mysql_query("update uye_durumlari set otomatik_teklif_engelle='".$otomatik_engelle."' where uye_id='".$uye_id."'");*/
				$guncelle=mysql_query("update uye_durumlari set otomatik_teklif_engelle='".re("riske_gore_teklif")."' where uye_id='".$uye_id."'");
				if($guncelle_kaydet && $guncelle){
					$response=["message"=>"İşlem başarılı","toplam_tutar"=>$toplam_odenecek,"status"=>200];
				}else{
					$response=["message"=>"Hata","status"=>500];
				}
			}
		}
		echo json_encode($response);
	}	
	if(re("action")=="mesaj_durum_guncelle"){
		$response=[];
		$ilan_id=re("ilan_id");
		$kullanici_token=re("kullanici_token");
		$gonderen_token=re("gonderen_token");
		$guncelle=mysql_query("update mesajlar set durum=1 where ilan_id='".$ilan_id."' and gonderen_token='".$gonderen_token."' and alan_token='".$kullanici_token."' ");
		$response=["message"=>"başarılı","status"=>200];
		echo json_encode($response);
	}
	if(re("action")=="dogrudan_mesaj_durum_guncelle"){
		$response=[];
		$ilan_id=re("ilan_id");
		$kullanici_token=re("kullanici_token");
		$gonderen_token=re("gonderen_token");
		$guncelle=mysql_query("update mesajlar set durum=1 where dogrudan_satis_id='".$ilan_id."' and gonderen_token='".$gonderen_token."' and alan_token='".$kullanici_token."' ");
		$response=["message"=>"başarılı","status"=>200];
		echo json_encode($response);
	}
	if(re("action")=="statu_sms_gonder"){
		$response=[];
		
		$teklif_id=re("teklif_id");
		$secim_id=re("secim_id");
		$otomatik_mesaj=re("otomatik_mesaj");
		
		if($secim_id!=""){
			$uye_id=$secim_id;
		}else{
			$teklif_getir=mysql_query("select * from teklifler where id='".$teklif_id."'");
			$teklif_oku=mysql_fetch_object($teklif_getir);
			$uye_id=$teklif_oku->uye_id;
		}

		if($uye_id==""){
			$response=["message"=>"Üye seçmelisiniz.","statu"=>500];
		}else{
			$sms_gonder=true;
			coklu_sms_gonder($uye_id,$otomatik_mesaj,1);
			//3.parametre kategori statü olduğu için 1 olarak belirlendi.
			
			
			if($sms_gonder){
				$response=["message"=>"İşlem Başarılı","sms"=>$sms_gonder,"statu"=>200];
			
			}else{
				$response=["message"=>"Hata","statu"=>500];
			}
		}

		
		echo json_encode($response);
		
	}
	if(re("action")=="toplam_tutar_guncelle"){
		$response=[];
		$kazandigi_tutar=re("kazandigi_tutar");
		$dosya_masrafi=re("dosya_masrafi");
		$statu_bilgileri=re("statu_bilgisi");
		$mtv=re("mtv");
		$parca_1=re("parca_1");
		$parca_2=re("parca_2");
		$parca_3=re("parca_3");
		$noter_takipci=re("noter");
		$pd_hizmet=re("pd_hizmet");
		
		if($noter_takipci>0){
			
			$toplam_odenecek=(int) $kazandigi_tutar+(int) $dosya_masrafi+(int) $pd_hizmet + (int) $noter_takipci;
		
		}else{
			
			
			$toplam_odenecek=(int) $kazandigi_tutar+(int) $dosya_masrafi+(int) $pd_hizmet;
			
		}
		$toplam_parca=(int) $parca_1+(int) $parca_2+(int) $parca_3;
		if($statu_bilgileri=="1"){
			if($toplam_odenecek==$toplam_parca){
				$durum=1;
				$response=["message"=>"","durum"=>$durum,"toplam_odenecek_tutar"=>$toplam_odenecek,"status"=>200];
			}else{
				$durum=0;
				$response=["asd"=>$toplam_parca,"message"=>"Toplam ödenecek tutar ile parçaların toplamı eşit olmalı","durum"=>$durum,"toplam_odenecek_tutar"=>$toplam_odenecek,"status"=>500];
			}
		}else{
			$durum=1;
			$response=["message"=>"","durum"=>$durum,"toplam_odenecek_tutar"=>$toplam_odenecek,"status"=>200];
		}
		
		
		echo json_encode($response);
	}
	if(re("action")=="ilan_notu_kaydet"){
		$admin_id = re("admin_id");
		$eklenecek_not = re('eklenecek_not');
		$gelen_id = re('gelen_id');    
		$gizlilik = re('gizlilik');
		$tarih = date('Y-m-d H:i:s');
		$dosya_sayisi=count($_FILES['files']);
		for($i=0;$i<$dosya_sayisi;$i++){ 
			$dosya_adi =$_FILES['files']['name'][$i]; 		// uzantiya beraber dosya adi 
			$dosya_boyutu =$_FILES['files']['size'][$i];    		// byte cinsinden dosya boyutu 
			$dosya_gecici =$_FILES['files']['tmp_name'][$i];		//gecici dosya adresi 
			$yenisim=md5(microtime()).$dosya_adi; 				//karmasik yeni isim.pdf 
								 
			$klasor="../assets"; // yuklenecek dosyalar icin yeni klasor 
			$test=move_uploaded_file($dosya_gecici,"$klasor/".$yenisim);//yoksa yeni ismiyle kaydet 
			if($test==true){
				$yol='assets/'.$yenisim;
				$a=mysql_query("INSERT INTO `ilan_notlari` (`id`, `ilan_id`, `ekleyen`, `ilan_notu`, `gizlilik`, `tarih`, `dosya`) 
				VALUES (NULL, '".$gelen_id."', '".$admin_id."', '".$eklenecek_not."', '".$gizlilik."', '".$tarih."', '".$yenisim."')")or die(mysql_error()); 
			
				mysql_query("INSERT INTO `yapilan_is` (`id`, `admin_id`, `yaptigi`,`aciklama`, `ekleme_zamani`, `ilan_id`, `dogrudan_id`, `uye_id`) VALUES 
				(NULL, '".$admin_id."', '2','".$eklenecek_not."', '".$tarih."','".$gelen_id."','','".$gelen_id."');"); 
				
			}
			else {
				$a=mysql_query("INSERT INTO `ilan_notlari` (`id`, `ilan_id`, `ekleyen`, `ilan_notu`, `gizlilik`, `tarih`, `dosya`) 
				VALUES (NULL, '".$gelen_id."', '".$admin_id."', '".$eklenecek_not."', '".$gizlilik."', '".$tarih."', '1')")or die(mysql_error()); 
			
				mysql_query("INSERT INTO `yapilan_is` (`id`, `admin_id`, `yaptigi`,`aciklama`, `ekleme_zamani`, `ilan_id`, `dogrudan_id`, `uye_id`) VALUES 
					(NULL, '".$admin_id."', '2','".$eklenecek_not."', '".$tarih."','".$gelen_id."','','".$gelen_id."');"); 
				header("Location:?modul=ihaleler&sayfa=tum_ihaleler");
			}
		}
		$response=["message"=>"İşlem başarılı","status"=>200];
		echo json_encode($response);
	}
	if(re("action")=="panel_ilanlar_guncelle"){
		$response=[];
		$ilan_cek=mysql_query("SELECT * FROM ilanlar ORDER BY concat(ihale_tarihi,' ',ihale_saati) asc");
		$t=0;
		while($ilan_oku=mysql_fetch_object($ilan_cek)){
			$response[$t]=["id"=>$ilan_oku->id,"son_teklif"=>$ilan_oku->son_teklif];
			$t++;
		}
		echo json_encode($response);
	}
	if(re("action")=="panel_ilan_guncelle"){
		$response=[];
		$ilan_id=re("ilan_id");
		$kapanis_zamani=re("kapanis_zamani");
		$duzenli_kapanis_zamani=date("Y-m-d H:i:s",strtotime($kapanis_zamani));
		
		$ilan_getir=mysql_query("select * from ilanlar where id='".$ilan_id."'");
		$ilan_getirilen=mysql_fetch_object($ilan_getir);
		
		$ilan_sigorta=mysql_query("select * from sigorta_ozellikleri where id='".$ilan_getirilen->sigorta."'");
		$ilan_sigorta_oku=mysql_fetch_object($ilan_sigorta);
		$belirlenen=$ilan_sigorta_oku->bu_sure_altinda_teklif;
		$sigorta_saniyenin_altinda=$ilan_sigorta_oku->saniyenin_altinda;
		$sigorta_saniye_uzar=$ilan_sigorta_oku->saniye_uzar;
		
		$bitis_tarihi=$ilan_getirilen->ihale_tarihi." ".$ilan_getirilen->ihale_saati;
		$yeni_tarih_str=strtotime($bitis_tarihi)+$sigorta_saniye_uzar;//Belirlenen saniye eklendi
		$yeni_tarih=date("Y-m-d H:i:s",$yeni_tarih_str);
		$duzenli_yeni_tarih=date("d-m-Y H:i:s",strtotime($yeni_tarih));
		$parcala=explode(" ",$yeni_tarih);
		$yeni_ihale_tarihi=$parcala[0];
		$yeni_ihale_saati=$parcala[1];
		
		if($ilan_getirilen->ihale_turu=="1"){
			$son_teklif=mysql_query("select * from teklifler where ilan_id='".$ilan_id."' and durum=1 order by teklif_zamani limit 1");
			$son_teklif_oku=mysql_fetch_object($son_teklif);
			$son_teklif_uye_id=$son_teklif_oku->uye_id;
		}else{
			$son_teklif=mysql_query("select * from teklifler where durum=1 and ilan_id='".$ilan_id."' group by uye_id order by teklif_zamani");
			while($son_teklifler_oku=mysql_fetch_array($son_teklif)){
				$uye_son_teklif=mysql_query("select * from teklifler where durum=1 and uye_id='".$son_teklifler_oku["uye_id"]."' and ilan_id='".$ilan_id."' order by teklif_zamani limit 1");
				$uye_son_teklif_oku=mysql_fetch_array($uye_son_teklif);
				if($ilan_getirilen->son_teklif==$uye_son_teklif_oku["teklif"]){
					$son_teklif_uye_id=$uye_son_teklif_oku["uye_id"];
				}
			}
		}
		
		$ihale_son_str = strtotime($bitis_tarihi);
		$suan_str = strtotime(date("Y-m-d H:i:s"));
		//$sonuc=($ihale_son_str-$suan_str)/60;
		$sonuc=$ihale_son_str-$suan_str;

		if($sonuc<$sigorta_saniyenin_altinda && $ilan_getirilen->sistem_sure_uzatma_durumu==0 && $son_teklif_uye_id !='283' && mysql_num_rows($son_teklif)!=0 ){//Kaynak firma uye_id 283
			$y_trh=$yeni_ihale_tarihi." ".$yeni_ihale_saati.":00";
			$gosterilme_tarih=strtotime($y_trh)+300; //Gösterilme süresi 5 dk fazla olması istendi
			$gosterilme_tarih=date("Y-m-d H:i:s",$gosterilme_tarih);
			$guncelle=mysql_query("update ilanlar set ihale_tarihi='$yeni_ihale_tarihi',ihale_saati='$yeni_ihale_saati',sistem_sure_uzatma_durumu='1',ihale_son_gosterilme='".$gosterilme_tarih."' where id='".$ilan_id."' ");
		}
		
		$ilan_cek=mysql_query("SELECT * FROM ilanlar where id='".$ilan_id."' ");
		$ilan_oku=mysql_fetch_object($ilan_cek);
		$ilan_bitis=$ilan_oku->ihale_tarihi." ".$ilan_oku->ihale_saati;

		$milisaniye=1000*(strtotime($ilan_bitis)-strtotime($duzenli_kapanis_zamani));
		
		
		$tablo_rengi="";
		$teklif_cek = mysql_query("SELECT * FROM teklifler WHERE ilan_id = '".$ilan_id."' and durum=1 order by teklif_zamani desc limit 1");
		$teklifini_oku = mysql_fetch_assoc($teklif_cek);
		$teklifler=mysql_query("select * from teklifler where ilan_id='".$ilan_id."' and durum=1 order by teklif_zamani desc ");
		$toplam_teklif = mysql_num_rows($teklifler);
		$admin_gormedigi_teklif = mysql_num_rows(mysql_query("select * from teklifler where ilan_id='".$ilan_id."' and durum=1 and is_admin_see = 0 and uye_id <> 283 order by teklif_zamani desc "));
		$statu_cek = mysql_query("SELECT * FROM kazanilan_ilanlar WHERE ilan_id = '".$ilan_id."'");
		$statu_oku = mysql_fetch_assoc($statu_cek);
		if($toplam_teklif>0){
			if($statu_oku['durum'] == "0" || $statu_oku['durum'] == "1" || $statu_oku['durum'] == "2" || $statu_oku['durum'] == "3" || $statu_oku['durum'] == "4"){
				$tablo_rengi = "#1b8d3d"; //Koyu yeşil
			}else if($ilan_oku->ihale_turu == "1" && $teklifini_oku['uye_id']!='283'){
				if($ilan_oku->durum == "-1"){
					$tablo_rengi = "#00a2ff"; //Açık mavi       
				}else{
					$tablo_rengi = "#b4e61d"; //Açık yeşil      
				}
			}else if($ilan_oku->ihale_turu== "1" && $teklifini_oku['uye_id']=='283'){
				$tablo_rengi = "#feadc8";  //Toz pembe
			}else {
				if($ilan_oku->ihale_turu== "2" && $teklifini_oku['uye_id']=='283'){
					$tablo_rengi = "#ffd0b0";//Krem rengi
				}else{
					$tablo_rengi = "#ffd0b0";//Krem rengi
				}
			}
		}else{
			$tablo_rengi = "#fff"; //Beyaz
		}
		$ilan_son_gosterilme=$ilan_oku->ihale_son_gosterilme;
		
		if($ilan_bitis>date("Y-m-d H:i:s")){
			/*if($toplam_teklif>0){
				$ilan_durum="true";
				
			}else{
				$ilan_durum="false";
			}*/
			$ilan_durum="true";
			
		}else{
			if($toplam_teklif>0){
				if($ilan_son_gosterilme > date("Y-m-d H-i-s")){
					$ilan_durum="true";
				}else{
					$ilan_durum="false";
				}
			}else{
				$ilan_durum="false";
			}
		}

		if($ilan_bitis > date('Y-m-d H:i:s')){
			$ilan_yeni_durum = 1;
		}else{
			if($ilan_bitis<date("Y-m-d H:i:s") && $toplam_teklif == 0){
				$ilan_yeni_durum = 0;
			}else{			
				$new_time = date("Y-m-d H:i:s", strtotime('+5 minutes', strtotime($ilan_bitis)));		
				if($toplam_teklif == 0){
					$ilan_yeni_durum = 0;
				}else{
					if($new_time > date('Y-m-d H:i:s')){
						$ilan_yeni_durum = 1;					
					}else{
						$ilan_yeni_durum = 0;
					}
				}
				
			}
		}
		
		//$ilan_durum="true";
		$suan=date("Y-m-d H:i:s");
		$gosterilme_sonuc=strtotime($ilan_son_gosterilme)-strtotime($suan);
		if($gosterilme_sonuc>0 && $son_teklif_uye_id !='283'){
			$gosterilme="true";
		}else{
			$gosterilme="false";
		}
		/*
		$mesaj_cek = mysql_query("select * from mesajlar where ilan_id = '".$ilan_id."'");
		$mesaj_sayi = mysql_num_rows($mesaj_cek);
		$okunmamis_mesaj_cek = mysql_query("select * from mesajlar where ilan_id = '".$ilan_id."' and is_admin_see = 0");
		if(mysql_num_rows($okunmamis_mesaj_cek) == 0){
			$okunmamis_mesaj_var_mi = 0;
		}else{
			$okunmamis_mesaj_var_mi = 1;
		}
		*/
		$mesaj_cek = mysql_query("select * from chat_room where ilan_id = '".$ilan_id."' and status = 1");
		$mesaj_sayi = mysql_num_rows($mesaj_cek);
		$okunmamis_sayi = 0;
		while($mesaj_oku = mysql_fetch_object($mesaj_cek)){
			$okunmamis_sayi += mysql_num_rows(mysql_query("select* from chat_messages where room_id = '".$mesaj_oku->id."' and gonderen_type = 1 and is_admin_see = 0"));
		}
		if($okunmamis_sayi > 0){
			$okunmamis_mesaj_var_mi = 1;
		}else{
			$okunmamis_mesaj_var_mi = 0;
		}
		$onay_bekleyen_teklif_cek = mysql_query("select * from teklifler where durum = 2 and ilan_id = '".$ilan_id."'");		
		if(mysql_num_rows($onay_bekleyen_teklif_cek) == 0){
			$onay_bekleyen_teklif_var_mi = 0;
		}else{
			$kaynak_teklif_cek = mysql_query("select * from teklifler where durum = 2 and ilan_id = '".$ilan_id."' and uye_id = '283'");
			if(mysql_num_rows($kaynak_teklif_cek) == 0){
				$onay_bekleyen_teklif_var_mi = 1;
			}else{
				$onay_bekleyen_teklif_var_mi = 0;
			}		
		}
		$onaydaki_cek = mysql_query("select * from teklifler WHERE ilan_id ='".$ilan_id."' and durum = 2");
		$onaydaki_oku = mysql_num_rows($onaydaki_cek);
		if(mysql_num_rows($onaydaki_cek) == 0){
			$onaydaki_sayi = 0;
		}else{
			$onaydaki_sayi = 1;
		}
		if(date('Y-m-d H:i:s') >= $duzenli_kapanis_zamani){
			$sure_bitmis = 1;
			$son_teklif_yeni = '<i style="color:#000" class="fas fa-lock"></i>';
		}else{
			$sure_bitmis = 0;
			if($ilan_oku->ihale_turu == 1){
				$son_teklif_yeni = money($ilan_oku->son_teklif)." ₺";
			}else{
				$son_teklif_yeni = money($ilan_oku->acilis_fiyati)." ₺";
			}
	
		}
		
		$bitis_tarihi=$ilan_bitis;
		$ihale_son_str = strtotime($bitis_tarihi);
		$suan_str = strtotime(date("Y-m-d H:i:s"));
		$sonuc=($ihale_son_str-$suan_str)/60;
		
		$u_token = $_SESSION["u_token"];
		$k_token = $_SESSION["k_token"];
		if($u_token != ""){
			$uye_token = $u_token;
			$uye_cek = mysql_query("select * from user where user_token = '".$uye_token."'");
		}else{
			$uye_token = $k_token;
			$uye_cek = mysql_query("select * from user where kurumsal_user_token = '".$uye_token."'");
		}
		$uye_oku = mysql_fetch_object($uye_cek);
		$uye_id = $uye_oku->id;
		if($uye_token!=""){	
			if($sonuc<30){ 
				$kullanici_grubu = kullanici_grubu_cek($uye_token);
				if($kullanici_grubu==1){
					$user_package_status=true;
				}else{
					$user_package_status=false;
				}
				$kazanilan_sorgu=mysql_query("select * from kazanilan_ilanlar where ilan_id='".$ilan_id."' ");
				if(mysql_num_rows($kazanilan_sorgu)==0){
					$ilan_status=1;
				}else{
					$ilan_status=0;
				}					
			}else{
				$ilan_status=1;
				$user_package_status=true;					
			}			
			if($ilan_oku->son_teklif>0){
				$teklif=$ilan_oku->son_teklif;
			}else{
				$teklif=$ilan_oku->acilis_fiyati;
			}
			if($ilan_oku->ihale_son_gosterilme >= date('Y-m-d H:i:s')){
				$ilan_status=1;
			}else{
				$ilan_status = 0;
			}
		}else{			
			if($sonuc<30){ 
				$ilan_status=0;
				$user_package_status=false;
			}else{
				$ilan_status=1;
				$user_package_status=true;
			}
			
			if($ilan_oku->son_teklif>0){
				$teklif=$ilan_oku->son_teklif;
			}else{
				$teklif=$ilan_oku->acilis_fiyati;
			}
			if($ilan_oku->ihale_son_gosterilme >= date('Y-m-d H:i:s')){
				$ilan_status=1;
			}else{
				$ilan_status = 0;
			}			
		}
		
		$benim_son_teklif_cek = mysql_query("select * from teklifler where ilan_id = '".$ilan_oku->id."' and uye_id = '".$uye_id."' and durum = 1 order by teklif desc");
		if(mysql_num_rows($benim_son_teklif_cek) == 0){
			$en_yuksek_benim = 0;
		}else{
			$benim_son_teklif_oku = mysql_fetch_object($benim_son_teklif_cek);
			$benim_son_teklif = $benim_son_teklif_oku->teklif;
			if($benim_son_teklif == $ilan_oku->son_teklif){
				$en_yuksek_benim = 1;
			}else{
				$en_yuksek_benim = 0;
			}
		}


		
		$response=[
			"id"=>$ilan_oku->id,
			"son_teklif"=>$ilan_oku->son_teklif,
			"en_yuksek_benim"=>$en_yuksek_benim,
			"son_teklif_yeni" => $son_teklif_yeni,
			"ihale_tarihi"=>date("d-m-Y H:i:s",strtotime($ilan_bitis)),		
			"milisaniye"=>$milisaniye, 
			"belirlenen"=>$belirlenen, 
			"renk"=>$tablo_rengi,
			"ilan_durumu"=>$ilan_durum,
			"gosterilme"=>$gosterilme,
			"gosterilme_sonuc"=>$gosterilme_sonuc,
			"toplam_teklif" => $toplam_teklif,
			"mesaj_sayi" => $mesaj_sayi,
			"okunmamis_mesaj_var_mi" => $okunmamis_mesaj_var_mi,
			"onay_bekleyen_teklif_var_mi" => $onay_bekleyen_teklif_var_mi,
			"onaydaki_sayi" => $onaydaki_sayi,
			"yeni_teklif" => $admin_gormedigi_teklif,
			"ilan_yeni_durum" => $ilan_yeni_durum,
			"sure_bitmis_mi" => $sure_bitmis,
			"arac_detay_ihale_saati" => $ilan_bitis,
			"son_gosterilme" => $ilan_oku->ihale_son_gosterilme,
			"suan" => date('Y-m-d H:i:s'),
			"user_package_status" => $user_package_status,
			"ilan_status" => $ilan_status,
		];
		echo json_encode($response);
	}
	
	if(re("action")=="panel_bugun_bitenler_guncelle"){
		$response=[];
		$ilan_cek=mysql_query("SELECT * FROM ilanlar WHERE ihale_tarihi = '$bugun'  ORDER BY concat(ihale_tarihi,' ',ihale_saati) asc");
		while($ilan_oku=mysql_fetch_object($ilan_cek)){
			$response[]=["id"=>$ilan_oku->id,"son_teklif"=>$ilan_oku->son_teklif];
		}
		echo json_encode($response);
	}
	if(re("action")=="panel_bugun_eklenenler_guncelle"){
		$response=[];
		$ilan_cek=mysql_query("SELECT * FROM ilanlar WHERE eklenme_zamani = '".$bugun."'  ORDER BY id asc");
		while($ilan_oku=mysql_fetch_object($ilan_cek)){
			$response[]=["id"=>$ilan_oku->id,"son_teklif"=>$ilan_oku->son_teklif];
		}
		echo json_encode($response);
	}
	if(re("action")=="panel_mail_gonder"){
		$response=[];
		$mailler=re("mailler");
		$konu=re("mail_konusu");
		$icerik=re("mail_icerik");
		$mailler=str_replace('[\\','[',$mailler);
		$mailler=str_replace('\\"','"',$mailler);
		$mailler=str_replace(']"',']',$mailler);
		$maillers=json_decode($mailler);
		
		foreach($maillers as $alici){
			$a=sendEmail($alici,$alici,$konu,$icerik,'');
		}
		echo json_encode($response);
	}
	if(re('action')=="daha_sonra_yap"){
		$response=[];
		$kullanici_id=re("uye_id");
		$ilan_id=re("ilan_id");
		$update=mysql_query("update kazanilan_ilanlar set modal_durum=1 where uye_id='".$kullanici_id."' and ilan_id='".$ilan_id."'");
		if($update){
			$response=["message"=>"Daha sonra 'Satın Alınanlar' kısmından 7 gün içersinde yorum yapabilirsiniz.","status"=>200];
		}else{
			$response=["message"=>"Hata.","status"=>500];
		}
		echo json_encode($response);
	}
	if(re('action')=="modal_yorum_yap"){
		$response=[];
		$kullanici_id=re("uye_id");
		$ilan_id=re("ilan_id");
		$yorum=re("yorum");
		if($yorum==""){
			$yorum="İyi bir alışverişti güvenle siteden araç satın alabilirsiniz.";
		}
		$update=mysql_query("
			update
				kazanilan_ilanlar 
			set
				modal_durum=1
			where
				uye_id='".$kullanici_id."' and 
				ilan_id='".$ilan_id."'
		");
		if(mysql_num_rows($sorgula)==0){
			$kazanma_sorgula=mysql_query("select * from kazanilan_ilanlar where ilan_id='".$ilan_id."' and uye_id='".$kullanici_id."'");
			$kazanma_oku=mysql_fetch_array($kazanma_sorgula);
			$tarih1=strtotime("+7 Days",strtotime($kazanma_oku["e_tarih"]));
			$tarih2=strtotime("now");

			$tarih = time();
			$your_date = strtotime($kazanma_oku["e_tarih"]);
			$datediff = $tarih - $your_date;						
			$date_count = round($datediff / (60 * 60 * 24));


			if($date_count <= 7){
				$cek = mysql_query("select * from ilanlar where id = '".$ilan_id."'");
				$oku = mysql_fetch_object($cek);
				$marka_cek = mysql_query("select * from marka where markaID = '".$oku->marka."'");
				$marka_oku = mysql_fetch_object($marka_cek);
				$arac_bilgileri = $oku->model_yili." / ".$marka_oku->marka_adi." / ".$oku->model." / ".$oku->tip;
				$insert=mysql_query("insert into yorumlar (ilan_id,uye_id,yorum,yorum_zamani,arac_bilgileri) values
				('".$ilan_id."','".$kullanici_id."','".$yorum."','".date("Y-m-d H:i:s")."','".$arac_bilgileri."')");
				if($insert && $update){
					$response=["message"=>"Başarıyla yorum yapıldı.","status"=>200];
				}else{
					$response=["message"=>"Hata.","status"=>500];
				}
			}else{
				$response=["message"=>"İşlemden sonra 7 gün geçmiştir.Yorum yapmak için uygun değildir."];
			}
		}else{
			$response=["message"=>"Daha önce yorum yapılmış.","status"=>500];
		}
		
		echo json_encode($response);
	}
	if(re("action")=="ihale_bildirim_sms"){
		$response=[];
		$bildirimler_cek=mysql_query("
										select 
											bildirimler.uye_id,bildirimler.ilan_id,
											user.id,
											ilanlar.model_yili,ilanlar.model,ilanlar.ihale_tarihi,ilanlar.ihale_saati,ilanlar.marka,ilanlar.tip,
											marka.marka_adi,marka.markaID						
										from
											bildirimler
										inner join 
											user on bildirimler.uye_id=user.id 
										inner join 
											ilanlar on bildirimler.ilan_id=ilanlar.id 
										inner join
											marka on ilanlar.marka=marka.markaID 
										where ilanlar.durum=1
									");
		while($bildirim_oku=mysql_fetch_object($bildirimler_cek)){
			$ihale_bitis=$bildirim_oku->ihale_tarihi." ".$bildirim_oku->ihale_saati;
			$model_yili=$bildirim_oku->model_yili;
			$marka=$bildirim_oku->marka_adi;
			$model=$bildirim_oku->model;
			$tip=$bildirim_oku->tip;
			$user_id=$bildirim_oku->uye_id;

			$mesaj="";
			$tarih1=strtotime("-30 minutes",strtotime($ihale_bitis));
			if(date("Y-m-d H:i:s",$tarih1)==date("Y-m-d H:i:s")){
				$mesaj="İlgilendiğiniz ".$model_yili." ".$marka." ".$model." ".$tip." aracın ihalesinin bitmesine 30 dakika kaldı.";
				$a=coklu_sms_gonder($user_id,$mesaj,9);
				$response=["asd"=>$a,"ff"=>$user_id,"gf"=>$mesaj,];
			}else{
				$response=["a"=>$ihale_bitis,"b"=>date("Y-m-d H:i:s",$tarih1),"c"=>date("Y-m-d H:i:s")];
			}
		}
		echo json_encode($response);
	}
	if(re("action")=="admin_onayla"){
		$response=[];
		$admin_id=re("admin_id");
		$onay_kod_girilen=re("onay_kod");
		$onayli_admin=mysql_query("select * from onayli_adminler where admin_id='".$admin_id."'");
		$onayli_admin_oku=mysql_fetch_object($onayli_admin);
		$onay_kod=$onayli_admin_oku->kod;
		
		
		if($onay_kod_girilen!=$onay_kod){
			$response=["message"=>"Kod Yanlış ","status"=>500];
		}else{
			$guncelle=mysql_query("update onayli_adminler set durum=1 where admin_id='".$admin_id."'");
			$kullanici_cek = mysql_query("SELECT * FROM kullanicilar where id='".$admin_id."' ");
			$kullanici_oku = mysql_fetch_assoc($kullanici_cek);
			if($kullanici_oku['durum'] == 2 && $guncelle )
			{
				$response=["message"=>"Hesabınız pasif durumda","status"=>500];
				
			}else if($guncelle){
				$_SESSION['kid'] = $kullanici_oku['id'];
				$_SESSION['yetki'] = $kullanici_oku['yetki'];
				$_SESSION['isim'] = $kullanici_oku['adi'].' '.$kullanici_oku['soyadi'];
				$response=["message"=>"İşlem başarılı","status"=>200];
			}else{
				$response=["message"=>"Hata oluştu ","status"=>500];
			}
		}
		
		
		echo json_encode($response);
	}
	if(re("action")=="admin_giris"){
		$response=[];
		
		$kullanici_adi=re("kullanici_adi");
		$sifre=re("sifre");
		$guvenlik_kodu=re("guvenlik_kodu");
		if($kullanici_adi == ""){
			$response=["message"=>"Kullanici adını giriniz","status"=>500];
		}else if($sifre =="" ){
			$response=["message"=>"Şifre giriniz","status"=>500];
		}else if($guvenlik_kodu!=$_SESSION["guvenlik_kodu"]){
			$response=["message"=>"Güvenlik kodu hatalı ","status"=>500];
		}else{
			$kullanici_cek = mysql_query("SELECT * FROM kullanicilar WHERE kullanici_adi='".re('kullanici_adi')."' AND sifre='".md5(re('sifre'))."' AND durum!='0' ");
			$kullanici_oku = mysql_fetch_assoc($kullanici_cek);
			if($kullanici_oku['id'] == "")
			{
				$response=["message"=>"Kullanıcı bulunamadı.","status"=>500];
			}else{
				if($kullanici_oku['durum'] == 2){
					$response=["message"=>"Hesabınız pasif durumda.","status"=>500];
				}else {
					$_SESSION['kid'] = $kullanici_oku['id'];
					$_SESSION['yetki'] = $kullanici_oku['yetki'];
					$_SESSION['isim'] = $kullanici_oku['adi'].' '.$kullanici_oku['soyadi'];
					if(re("remember")=="1") {
						$a=setcookie ("member_login",re('kullanici_adi'),time()+ (10 * 365 * 24 * 60 * 60));
						$b=setcookie ("member_password",re('sifre'));
					} else {
						if(isset($_COOKIE["member_login"])) {
							setcookie ("member_login","");
							setcookie ("member_password","");
						}
					}
					eski_ilanlari_sil();
					$response=["message"=>"Giriş başarılı","a"=>$a,"b"=>$b,"status"=>200];
				}
				/*
					$onayli_admin=mysql_query("select * from onayli_adminler where admin_id='".$kullanici_oku['id']."'");
					$onayli_admin_oku=mysql_fetch_object($onayli_admin);
					if($onayli_admin_oku->durum==0){
						$response=["onay_durum"=>0,"status"=>200,"admin_id"=>$kullanici_oku['id'],"onay_kodu"=>$onayli_admin_oku->kod];
					}else if($kullanici_oku['durum'] == 2){
						$response=["message"=>"Hesabınız pasif durumda.","status"=>500];
					}else {
						$_SESSION['kid'] = $kullanici_oku['id'];
						$_SESSION['yetki'] = $kullanici_oku['yetki'];
						$_SESSION['isim'] = $kullanici_oku['adi'].' '.$kullanici_oku['soyadi'];
						$response=["message"=>"Giriş başarılı","status"=>200];
					}
				*/
			}
		}
		echo json_encode($response);
	}

	function eski_ilanlari_sil(){
		$sure_cek = mysql_query("select * from eski_ilan_sil");
		$sure_oku = mysql_fetch_object($sure_cek);
		$sure = $sure_oku->ay_sayi;
		$now = date('Y-m-d');
		$yeni_trh = strtotime("-".$sure." months",strtotime($now));
		$bitis_tarihi = date("Y-m-d",$yeni_trh);
		$cek = mysql_query("select * from ilanlar where ihale_tarihi < '".$bitis_tarihi."' and durum <> 2");
		// var_dump("select * from ilanlar where ihale_tarihi < '".$bitis_tarihi."' and durum <> 2");
		while($oku = mysql_fetch_object($cek)){
			$kontrol = mysql_query("select * from kazanilan_ilanlar where ilan_id = '".$oku->id."'");
			if(mysql_num_rows($kontrol) == 0){
				$kontrol2 = mysql_query("select * from satilan_araclar where ilan_id = '".$oku->id."'");
				if(mysql_num_rows($kontrol2) == 0){
					mysql_query("update ilanlar set durum = 2, eski_ilan_sil = 1 where id = '".$oku->id."'");
				}				
			}
		}
	}


	
	if(re("action")=="teklif_sonrasi_tarih"){
		$response=[];
		$id=re("ilan_id");
		$teklif=re("teklif");
		$yeni_saat=re("yeni_saat");
		$ilan_cek=mysql_query("select * from ilanlar where id='".$id."'");
		$ilan_oku=mysql_fetch_assoc($ilan_cek);
		$sigorta_cek=mysql_query("select * from sigorta_ozellikleri where id='".$ilan_oku["sigorta"]."'");
		$sigorta_oku=mysql_fetch_object($sigorta_cek);

		//$belirlenen=(int)$sigorta_oku->bu_sure_altinda_teklif;
		
		if($yeni_saat!=""){
			$ihale_bitis=$ilan_oku["ihale_tarihi"]." ".$yeni_saat.":00";
		}else{
			$ihale_bitis=$ilan_oku["ihale_tarihi"]." ".$ilan_oku["ihale_saati"];
		}
		
		// $ihale_bitis=$ilan_oku["ihale_tarihi"]." ".$ilan_oku["ihale_saati"];
		
		$sigorta_sure_uzatma_durumu=$sigorta_oku->sure_uzatma;
		$sigorta_dakikanin_altinda=$sigorta_oku->dakikanin_altinda;
		$sigorta_dakika_uzar=$sigorta_oku->dakika_uzar;
		$sigorta_saniyenin_altinda=$sigorta_oku->saniyenin_altinda;
		$sigorta_saniye_uzar=$sigorta_oku->saniye_uzar;

		$kac_saniyenin_altinda = $sigorta_dakikanin_altinda * 60;
		$bitis_first = strtotime(date($ilan_oku["ihale_tarihi"]." ".$ilan_oku["ihale_saati"]));
		$suan = strtotime(date('Y-m-d H:i:s'));
		$fark = $bitis_first - $suan;	
		// echo $fark;
		if($sigorta_sure_uzatma_durumu=="1"){
			$yeni_trh=strtotime("+".$sigorta_dakika_uzar." minutes",strtotime($ihale_bitis));
			$yeni_trh=date("Y-m-d H:i:s",$yeni_trh);
			//$yeni_trh = date('Y-m-d H:i:s', strtotime($ihale_bitis. "+".$sigorta_dakika_uzar." minutes"));

			$date=date("Y-m-d H:i:s");
			$tarih=strtotime("-".$sigorta_dakikanin_altinda." minutes",strtotime($ihale_bitis));
			$tarih=date("Y-m-d H:i:s",$tarih);
			
			$ihale_son_str = strtotime($tarih);
			$suan_str = strtotime(date("Y-m-d H:i:s"));
			$sonuc=($ihale_son_str-$suan_str)/60;
			$t_cek=mysql_query("select * from teklifler where ilan_id='".$id."' and durum=1 group by uye_id order by teklif_zamani ");
			while($t_oku=mysql_fetch_object($t_cek)){
				$tt_cek=mysql_query("select * from teklifler where ilan_id='".$id."' and uye_id='".$t_oku->uye_id."' order by teklif_zamani desc limit 1 ");
				$tt_oku=mysql_fetch_object($tt_cek);
				if($i_oku["son_teklif"]=$tt_oku->teklif){
					$son_teklif_uye_id=$tt_oku->uye_id;
				}
			}
			// if($date>$tarih){
			if($fark<$kac_saniyenin_altinda){
				if($sonuc<$sigorta_saniyenin_altinda && $son_teklif_uye_id!="283") {
					$yeni_trh2=strtotime($yeni_trh);
					$kapanis_saat=date("H:i",$yeni_trh2);
					$response=["tarih"=>date("Y-m-d H:i:s",$yeni_trh2),"degisiklik"=>"true","kapanis_saat"=>$kapanis_saat,"status"=>200];
				}else{
					$kapanis_saat=date("H:i",strtotime($yeni_trh));
					$response=["tarih"=>date("Y-m-d H:i:s",strtotime($yeni_trh)),"degisiklik"=>"true","kapanis_saat"=>$kapanis_saat,"status"=>200];
				}
			}else{
				if($sonuc<$sigorta_saniyenin_altinda && $son_teklif_uye_id!="283" ) {
					$yeni_trh2=strtotime($yeni_trh);
					// $kapanis_saat=date("H:i",$yeni_trh2);
					$kapanis_saat=date("H:i",$bitis_first);
					$response=["tarih"=>$ihale_bitis,"degisiklik"=>"false","kapanis_saat"=>$kapanis_saat,"status"=>200];
				}else{
					// $kapanis_saat=date("H:i",strtotime($ihale_bitis));
					$kapanis_saat=date("H:i",$bitis_first);
					$response=["tarih"=>$ihale_bitis,"degisiklik"=>"false","kapanis_saat"=>$kapanis_saat,"status"=>200];
				}
				/*
				if($sonuc<$sigorta_saniyenin_altinda && $son_teklif_uye_id!="283" ) {
					$yeni_trh2=strtotime($yeni_trh);
					$kapanis_saat=date("H:i",$yeni_trh2);
					$response=["tarih"=>date("Y-m-d H:i:s",$yeni_trh2),"degisiklik"=>"false","kapanis_saat"=>$kapanis_saat,"status"=>200];
				}else{
					$kapanis_saat=date("H:i",strtotime($ihale_bitis));
					$response=["tarih"=>date("Y-m-d H:i:s",strtotime($ihale_bitis)),"degisiklik"=>"false","kapanis_saat"=>$kapanis_saat,"status"=>200];
				}
				*/
			}
			
		}else{
			$ihale_son_str = strtotime($ihale_bitis);
			$suan_str = strtotime(date("Y-m-d H:i:s"));
			$sonuc=($ihale_son_str-$suan_str)/60;
			$t_cek=mysql_query("select * from teklifler where ilan_id='".$id."' and durum=1 group by uye_id order by teklif_zamani ");
			while($t_oku=mysql_fetch_object($t_cek)){
				$tt_cek=mysql_query("select * from teklifler where ilan_id='".$id."' and uye_id='".$t_oku->uye_id."' order by teklif_zamani desc limit 1 ");
				$tt_oku=mysql_fetch_object($tt_cek);
				if($i_oku["son_teklif"]=$tt_oku->teklif){
					$son_teklif_uye_id=$tt_oku->uye_id;
				}
			}
			
			if($sonuc>=$sigorta_saniyenin_altinda && $son_teklif_uye_id!="283" ) {
				$yeni_trh2=strtotime($yeni_trh)+$sigorta_saniye_uzar;
				$kapanis_saat=date("H:i",$yeni_trh2);
				$response=["tarih"=>date("Y-m-d H:i:s",$yeni_trh2),"degisiklik"=>"true","kapanis_saat"=>$kapanis_saat,"status"=>200];
			}else{
				$kapanis_saat=date("H:i",strtotime($ihale_bitis));
				$response=["tarih"=>date("Y-m-d H:i:s",strtotime($ihale_bitis)),"degisiklik"=>"false","kapanis_saat"=>$kapanis_saat,"status"=>200];
			}
			
		}
		echo json_encode($response);
	}


	if(re("action")=="bilgi_yenile"){
		$response=[];
		
		$uye_cek=mysql_query("select * from user where kurumsal_user_token='".$uye_token."' or user_token='".$uye_token."' ");
		$uye_oku=mysql_fetch_array($uye_cek);
		$uye_id=$uye_oku["id"];
		//$ilan_cek=mysql_query("select ilanlar.* from ilanlar inner join teklifler on teklifler.ilan_id=ilanlar.id where ilanlar.durum=1 and teklifler.durum=1 group by ilanlar.id"); 

		$ilan_cek=mysql_query("select ilanlar.* from ilanlar  where ilanlar.durum=1 ");//Optimize edilebilir.

		$ilan_cek = mysql_query("SELECT *,concat(ihale_tarihi,' ',ihale_saati) as ihale_son FROM ilanlar WHERE ihale_son_gosterilme>='".date("Y-m-d H:i:s")."'ORDER BY ihale_son ASC");
		$acik_array=array();
		while($ilan_oku=mysql_fetch_array($ilan_cek)){
			$en_yksk="";

			$sql_teklif=mysql_query("select * from teklifler where ilan_id='".$ilan_oku['id']."' and uye_id='".$uye_id."' and durum=1 order by teklif_zamani desc limit 1");
		
			$teklif_say=mysql_num_rows($sql_teklif);
			$row_teklif=mysql_fetch_object($sql_teklif);			
			if($ilan_oku["ihale_turu"] == 1){
				if($row_teklif->teklif == $ilan_oku['son_teklif'] &&  $ilan_oku['ihale_turu']=="1"  ){
					$en_yksk =' <b style="color: green; text-align:center;float:right">En yüksek teklif sizindir.</b><br/>
								<b style="color: red; text-align:center;float:right">'.money($row_teklif->teklif).' ₺ teklif verdiniz.</b>
							  ';
				}else if($row_teklif->teklif == ""){
					$en_yksk =' <b style="color: red; text-align:center;">Henüz teklif vermediniz.</b>';
				}else if($row_teklif->teklif != $ilan_oku['son_teklif'] && $row_teklif->teklif != "" && $teklif_say!=0 ){
					$en_yksk =' <b style="color: red; text-align:center;">'.money($row_teklif->teklif).' ₺ teklif verdiniz.</b>';
				}
			}else{
				if($teklif_say != 0){
					$en_yksk = '<b style="color: red; text-align:center;">'.money($row_teklif->teklif).' ₺ teklif verdiniz.</b>';
				}else{
					$en_yksk =' <b style="color: red; text-align:center;">Henüz teklif vermediniz.</b>';
				}
				
			}
			
			
			
				
			$sql_teklif2=mysql_query("select * from teklifler where ilan_id='".$ilan_oku['id']."' and uye_id='".$uye_id."' and durum=1 order by teklif_zamani desc limit 1");
			
			$bitis_tarihi=$ilan_oku["ihale_tarihi"]." ".$ilan_oku["ihale_saati"];
			$ihale_son_str = strtotime($bitis_tarihi);
			$suan_str = strtotime(date("Y-m-d H:i:s"));
			$sonuc=($ihale_son_str-$suan_str)/60;
			
			if($uye_token!=""){	
				if($sonuc<30){ 
					$kullanici_grubu = kullanici_grubu_cek($uye_token);
					if($kullanici_grubu==1){
						$user_package_status=true;
					}else{
						$user_package_status=false;
					}
					$kazanilan_sorgu=mysql_query("select * from kazanilan_ilanlar where ilan_id='".$ilan_id."' ");
					if(mysql_num_rows($kazanilan_sorgu)==0){
						$ilan_status=1;
					}else{
						$ilan_status=0;
					}
					/*
					if($uye_oku["paket"]==1 || $uye_oku["paket"] == 2 || $uye_oku["paket"] == 22){
						if($ilan_oku["ihale_tarihi"]." ".$ilan_oku["ihale_saati"] > date('Y-m-d H:i:s')){
							$kazanilan_sorgu=mysql_query("select * from kazanilan_ilanlar where ilan_id='".$ilan_id."' ");
							if(mysql_num_rows($kazanilan_sorgu)==0){
								$ilan_status=1;
								$user_package_status=true;
							}else{
								$ilan_status=0;
								$user_package_status=false;
							}
						}else{
							$ilan_status=0;
							$user_package_status=false;
						}
					}else{
						if($ilan_oku["ihale_tarihi"]." ".$ilan_oku["ihale_saati"] > date('Y-m-d H:i:s')){
							if($ilan_oku["ihale_tarihi"]." ".$ilan_oku["ihale_saati"] > date('Y-m-d H:i:s')){
								$kazanilan_sorgu=mysql_query("select * from kazanilan_ilanlar where ilan_id='".$ilan_id."' ");
								if(mysql_num_rows($kazanilan_sorgu)==0){
									$ilan_status=1;
									$user_package_status=true;
								}else{
									$ilan_status=0;
									$user_package_status=false;
								}
							}else{
								$ilan_status=0;
								$user_package_status=false;
							}
						}else{
							$ilan_status=1;
							$user_package_status=true;
						}
					}
					*/
					
					/*
					if($uye_oku["paket"]==21){
						if($ilan_oku["ihale_tarihi"]." ".$ilan_oku["ihale_saati"] > date('Y-m-d H:i:s')){
							$kazanilan_sorgu=mysql_query("select * from kazanilan_ilanlar where ilan_id='".$ilan_id."' ");
							if(mysql_num_rows($kazanilan_sorgu)==0){
								$ilan_status=1;
								$user_package_status=true;
							}else{
								$ilan_status=0;
								$user_package_status=false;
							}
						}else{
							$ilan_status=0;
							$user_package_status=false;
						}
					}else{
						
						$ilan_status=0;
						$user_package_status=false;
					}
					*/
				}else{
					$ilan_status=1;
					$user_package_status=true;
					/*
					if($uye_oku["paket"]==21 || $uye_oku["paket"]==2 ){
						$kazanilan_sorgu=mysql_query("select * from kazanilan_ilanlar where ilan_id='".$ilan_id."'  ");
						if(mysql_num_rows($kazanilan_sorgu)==0){
							$ilan_status=1;
							$user_package_status=true;
						}else{
							$ilan_status=0;
							$user_package_status=false;
						}
					}else{
						$ilan_status=0;
						$user_package_status=false;
					}
					*/
				}
				
				if($ilan_oku["son_teklif"]>0){
					$teklif=$ilan_oku["son_teklif"];
				}else{
					$teklif=$ilan_oku["acilis_fiyati"];
				}

				
				// 02-01-2022 tarihinde eklendi. İhale bittikten sonra 5 dakika daha listede görünecek. Bu 5 dakika boyunca en yüksek teklif kısmı görünecek sonra kilit olarak gösterilecek.
				if($ilan_oku["ihale_son_gosterilme"] >= date('Y-m-d H:i:s')){
					$ilan_status=1;
				}else{
					$ilan_status = 0;
				}
							
				$ilanlar_array[]=["ilan_id"=>$ilan_oku["id"],"kullanici_grubu"=>$kullanici_grubu,"son_teklif"=>$teklif,"uye_ilan_bilgileri"=>$en_yksk,"ilan_status"=>$ilan_status,"user_package_status"=>$user_package_status];
			}else{
				
				if($sonuc<30){ 
					$ilan_status=0;
					$user_package_status=false;
				}else{
					$ilan_status=1;
					$user_package_status=true;
				}
				
				if($ilan_oku["son_teklif"]>0){
					$teklif=$ilan_oku["son_teklif"];
				}else{
					$teklif=$ilan_oku["acilis_fiyati"];
				}

				
				// 02-01-2022 tarihinde eklendi. İhale bittikten sonra 5 dakika daha listede görünecek. Bu 5 dakika boyunca en yüksek teklif kısmı görünecek sonra kilit olarak gösterilecek.
				if($ilan_oku["ihale_son_gosterilme"] >= date('Y-m-d H:i:s')){
					$ilan_status=1;
				}else{
					$ilan_status = 0;
				}
				
				$ilanlar_array[]=["ilan_id"=>$ilan_oku["id"],"son_teklif"=>$teklif,"ilan_status"=>$ilan_status,"user_package_status"=>$user_package_status ];
			}
			
			
			
			
		}
		$response=["ilan_bilgileri"=>$ilanlar_array];
		
		echo json_encode($response);
	}
	if(re("action")=="bilgi_yenile_arac_detay"){
		$response=[];
		$ilan_id=re("ilan_id");

		$uye_cek=mysql_query("select * from user where kurumsal_user_token='".$uye_token."' or user_token='".$uye_token."' ");
		$uye_oku=mysql_fetch_array($uye_cek);
		$uye_id=$uye_oku["id"];
		$ilan_cek=mysql_query("select ilanlar.* from ilanlar  where ilanlar.id='".$ilan_id."' ");
		$ilan_oku=mysql_fetch_array($ilan_cek);
		$en_yksk="";
		$sql_teklif=mysql_query("select * from teklifler where ilan_id='".$ilan_id."' and uye_id='".$uye_id."' and durum=1 order by teklif_zamani desc limit 1");
		$teklif_say=mysql_num_rows($sql_teklif);
		$row_teklif=mysql_fetch_object($sql_teklif);
		if($row_teklif->teklif == $ilan_oku['son_teklif'] &&  $ilan_oku['ihale_turu']=="1"  ){
			$en_yuksek_mesaj='<i style="color: green; text-align:center;float:right">En yüksek teklif sizindir.</i>';
			$en_yuksek_mesaj2='<i style="color: red; text-align:center;float:right">'.money($row_teklif->teklif).' ₺ teklif verdiniz.</i>';
			$en_yksk =' <i style="color: green; text-align:center;float:right">En yüksek teklif sizindir.</i><br/>
						<i style="color: red; text-align:center;float:right">'.money($row_teklif->teklif).' ₺ teklif verdiniz.</i>
					  ';
		}else if($row_teklif->teklif == ""){
			
			$en_yuksek_mesaj='';
			$en_yuksek_mesaj2='<i style="color: red; text-align:center;float:right">Henüz teklif vermediniz.</i>';
			$en_yksk =' <i style="color: red; text-align:center;">Henüz teklif vermediniz.</i>';
			
		}else if($row_teklif->teklif != $ilan_oku['son_teklif'] && $row_teklif->teklif != "" && $teklif_say!=0 ){
			
			$en_yuksek_mesaj='';
			$en_yuksek_mesaj2='<i style="color: red; text-align:center;float:right">'.money($row_teklif->teklif).' ₺ teklif verdiniz.</i>';
			$en_yksk =' <i style="color: red; text-align:center;">'.money($row_teklif->teklif).' ₺ teklif verdiniz.</i>';
		}

		$sql_teklif2=mysql_query("select * from teklifler where ilan_id='".$ilan_id."' and uye_id='".$uye_id."' and durum=1 order by teklif_zamani desc limit 1");
		
		
		$bitis_tarihi=$ilan_oku["ihale_tarihi"]." ".$ilan_oku["ihale_saati"];
		$ihale_son_str = strtotime($bitis_tarihi);
		$suan_str = strtotime(date("Y-m-d H:i:s"));
		$sonuc=($ihale_son_str-$suan_str)/60;
		if($uye_token!=""){
			if($sonuc<30){ 
				if($uye_oku["paket"]==1 || $uye_oku["paket"] == 2 || $uye_oku["paket"] == 22){
					if($ilan_oku["ihale_tarihi"]." ".$ilan_oku["ihale_saati"] > date('Y-m-d H:i:s')){
						$kazanilan_sorgu=mysql_query("select * from kazanilan_ilanlar where ilan_id='".$ilan_id."' ");
						if(mysql_num_rows($kazanilan_sorgu)==0){
							$ilan_status=1;
							$user_package_status=true;
						}else{
							$ilan_status=0;
							$user_package_status=false;
						}
					}else{
						$ilan_status=0;
						$user_package_status=false;
					}
				}else{
					if($ilan_oku["ihale_tarihi"]." ".$ilan_oku["ihale_saati"] > date('Y-m-d H:i:s')){
						if($ilan_oku["ihale_tarihi"]." ".$ilan_oku["ihale_saati"] > date('Y-m-d H:i:s')){
							$kazanilan_sorgu=mysql_query("select * from kazanilan_ilanlar where ilan_id='".$ilan_id."' ");
							if(mysql_num_rows($kazanilan_sorgu)==0){
								$ilan_status=1;
								$user_package_status=true;
							}else{
								$ilan_status=0;
								$user_package_status=false;
							}
						}else{
							$ilan_status=0;
							$user_package_status=false;
						}
					}else{
						$ilan_status=1;
						$user_package_status=true;
					}
				}
				/*
				if($uye_oku["paket"]==21){
					if($ilan_oku["ihale_tarihi"]." ".$ilan_oku["ihale_saati"] > date('Y-m-d H:i:s')){
						$kazanilan_sorgu=mysql_query("select * from kazanilan_ilanlar where ilan_id='".$ilan_id."' ");

						if(mysql_num_rows($kazanilan_sorgu)==0){
							$ilan_status=1;
							$user_package_status=true;
						}else{
							$ilan_status=0;
							$user_package_status=false;
						}
					}else{
						$ilan_status=0;
						$user_package_status=false;
					}
				}else{
					$ilan_status=0;
					$user_package_status=false;
				}
				*/
			}else{	
				$ilan_status=1;
				$user_package_status=true;
				/*
				if($uye_oku["paket"]==21 || $uye_oku["paket"]==2 ){
					$kazanilan_sorgu=mysql_query("select * from kazanilan_ilanlar where ilan_id='".$ilan_id."'  ");
			
					if(mysql_num_rows($kazanilan_sorgu)==0){
						$ilan_status=1;
						$user_package_status=true;
					}else{
						$ilan_status=0;
						$user_package_status=false;
					}
				}else{
					$ilan_status=0;    
					$user_package_status=false;
				}
				*/
			}
			
			if($ilan_oku["son_teklif"]>0){
				$teklif=$ilan_oku["son_teklif"];
			}else{
				$teklif=$ilan_oku["acilis_fiyati"];
			}
			
			$response=["son_teklif"=>$teklif,"uye_ilan_bilgileri"=>$en_yksk,"en_yuksek_mesaj"=>$en_yuksek_mesaj,"en_yuksek_mesaj2"=>$en_yuksek_mesaj2,"ilan_status"=>$ilan_status,"user_package_status"=>$user_package_status];
		}else{
	
			if($sonuc<30){ 
				$ilan_status=0;
				$user_package_status=false;
			}else{
				
				$ilan_status=1;
				$user_package_status=true;
			}
				
			if($ilan_oku["son_teklif"]>0){
				$teklif=$ilan_oku["son_teklif"];
			}else{
				$teklif=$ilan_oku["acilis_fiyati"];
			}
			
			$response=["aa"=>"aa","son_teklif"=>$teklif,"ilan_status"=>$ilan_status,"user_package_status"=>$user_package_status];
		}
		
		echo json_encode($response);
	}
	if(re("action")=="panel_arac_kodu"){
		
		$response=[];
		$aranan=re("aranan");
		$ilan_sorgula=mysql_query("SELECT * FROM ilanlar where  concat(plaka,arac_kodu) like '%".$aranan."%' ");
		$ilan_say=mysql_num_rows($ilan_sorgula);
		$dogrudan_sorgula=mysql_query("SELECT * FROM dogrudan_satisli_ilanlar where concat(plaka,arac_kodu) LIKE '%".$aranan."%'");
		$dogrudan_say=mysql_num_rows($dogrudan_sorgula);
		
		if($ilan_say>0){
			$response=["tur"=>"ilan","status"=>200];
		}else if($dogrudan_say>0){
			$response=["tur"=>"dogrudan","status"=>2000];
		}else{
			$response=["tur"=>"","status"=>500,"asda"=>$aranan];
		}
		
		echo json_encode($response);
	}
	
	if(re("action")=="panel_satilan_sil"){
		
		$response=[];
		$text=[];
		$secilenler=$_POST["secilenler"];
		
		for($i=0;$i<count($secilenler);$i++){
			$sql=mysql_query("
				DELETE FROM
					satilan_araclar
				WHERE
					id='".$secilenler[$i]."'
			");
			if($sql!=true){
				$text[]="hata";
			}
		}
		
		if(empty($text)){
			$response=["message"=>"İşlem başarılı","status"=>200];
		}else{
			$response=["message"=>"Hata","status"=>500];
		}
		
		echo json_encode($response);
	}
	
	if(re("action")=="musteri_temsilcisi_kontrolu"){
		$response=[];
		$user_id=re("user_id");
		$grup=re("grup");
		$admin_id="";
		if($grup==21){
			$uye_cek = mysql_query("select * from user where id = '".$user_id."'");
			$uye_oku = mysql_fetch_object($uye_cek);
			if($uye_oku->temsilci_id != 0){
				$admin_id = $uye_oku->temsilci_id;
			}else{
				// $sql=mysql_query("SELECT * FROM prm_notlari WHERE uye_id='".$uye_id."' AND durum = 1 ORDER BY id DESC LIMIT 1 ");
				$sql=mysql_query("SELECT * FROM prm_notlari WHERE uye_id='".$user_id."' ORDER BY id DESC LIMIT 1 ");
				$fetch=mysql_fetch_assoc($sql);
				if(mysql_num_rows($sql)>0){
					$admin_id=$fetch["ekleyen"];
				}else{
					/*
					$admin_sql=mysql_query("SELECT * FROM kullanicilar WHERE departman='Müşteri Temsilcisi'");
					while($admin_fetch=mysql_fetch_array($admin_sql)){
						$temsilci_sql=mysql_query("SELECT * FROM user WHERE temsilci_id='".$admin_fetch["id"]."'");
						$temsilci_say=mysql_num_rows($temsilci_sql);
						$array[]=["temsilci_id"=>$admin_fetch["id"],"temsil_sayisi"=>$temsilci_say];
					}
					usort($array, function ($item1, $item2) {
						if ($item1['temsil_sayisi'] == $item2['temsil_sayisi']) return 0;
						return $item1['temsil_sayisi'] < $item2['temsil_sayisi'] ? -1 : 1;
					});
					$admin_id=$array[0]["temsilci_id"];
					*/
					$admin_cek = mysql_query("SELECT kullanicilar.id, (SELECT COUNT(*) FROM prm_notlari WHERE durum = 1 AND ekleyen = kullanicilar.id) prm_notlari FROM kullanicilar ORDER BY prm_notlari ASC");
					$admin_oku = mysql_fetch_object($admin_cek);
					$admin_id = $admin_oku->id;
				}
			}
		}
		$response=["admin_id"=>$admin_id,"status"=>200];
		echo json_encode($response);
	}
	if(re("action")=="parca_guncelle"){
		$response=[];
		$secilen_parca=re("secilen_parca");
		$secilen_parca_not=re("secilen_parca_not");
		$parca=re("parca");
		$int_parca=intval($parca);
		$parca_not=re("parca_not");
		$ilan_id=re("ilan_id");
		$kazanilan_ilan=mysql_query("SELECT * FROM kazanilan_ilanlar WHERE ilan_id='".$ilan_id."'");
		if(mysql_num_rows($kazanilan_ilan)>0){
			$update=mysql_query("UPDATE kazanilan_ilanlar SET $secilen_parca=$int_parca, $secilen_parca_not='$parca_not' WHERE  ilan_id='".$ilan_id."' ");
			if($update){
				$response=["message"=>"başarıyla kaydedildi","status"=>200];
			}else{
				$response=["message"=>"UPDATE kazanilan_ilanlar SET $secilen_parca=$int_parca, $secilen_parca_not=$parca_not WHERE ilan_id='".$ilan_id."'","status"=>500]; 
			}
			
		}else{
			$insert=mysql_query("INSERT INTO kazanilan_ilanlar (ilan_id,".$secilen_parca.",".$secilen_parca_not.") VALUES ('".$ilan_id."','".$parca."','".$parca_not."')");
			if($insert){
				$response=["message"=>"başarıyla kaydedildi","status"=>200];
			}else{
				$response=["message"=>"hata oluştu","status"=>500];
			}
			
		}	
		echo json_encode($response);
	}
	if(re("action")=="mtv_guncelle"){
		$response=[];

		$mtv=re("mtv");
		$int_mtv=intval($mtv);
		$mtv_not=re("mtv_not");
		$ilan_id=re("ilan_id");
		$kazanilan_ilan=mysql_query("SELECT * FROM kazanilan_ilanlar WHERE ilan_id='".$ilan_id."'");
		if(mysql_num_rows($kazanilan_ilan)>0){
			$update=mysql_query("UPDATE kazanilan_ilanlar SET mtv=$int_mtv, mtv_not='$mtv_not' WHERE ilan_id='".$ilan_id."'");
			if($update){
				$response=["message"=>"başarıyla kaydedildi","status"=>200];
			}else{
				$response=["message"=>"hata oluştu","status"=>500];
			}
			
		}else{
			$insert=mysql_query("INSERT INTO kazanilan_ilanlar (ilan_id,mtv,mtv_not) VALUES ('".$ilan_id."','".$parca."','".$parca_not."')");
			if($insert){
				$response=["message"=>"başarıyla kaydedildi","status"=>200];
			}else{
				$response=["message"=>"hata oluştu","status"=>500];
			}
			
		}		
		echo json_encode($response);
	}
	if(re("action")=="odeme_bildirimi_ekle"){
		$response=[];
		$ilan_id=re("ilan_id");
		$kazanilan_sql=mysql_query("SELECT * FROM kazanilan_ilanlar WHERE ilan_id='".$ilan_id."'");
		$kazanilan_fetch=mysql_fetch_array($kazanilan_sql);
		$dosya_adi =$_FILES['odeme_bildirimi_dosya']['name']; 		// uzantiya beraber dosya adi 
		$dosya_boyutu =$_FILES['odeme_bildirimi_dosya']['size'];    		// byte cinsinden dosya boyutu 
		$dosya_gecici =$_FILES['odeme_bildirimi_dosya']['tmp_name'];		//gecici dosya adresi 
		$file_type =$_FILES['odeme_bildirimi_dosya']['type'];		//dosya tipi
		// $yenisim=md5(md5(microtime())).$dosya_adi; 				//karmasik yeni isim.pdf 					 
		$yenisim=md5(md5(microtime())).".pdf"; 				//karmasik yeni isim.pdf 					 
		$klasor="images/pdf"; // yuklenecek dosyalar icin yeni klasor 
		$allowed = array("application/pdf");
		if ($dosya_boyutu > 20971520) {
			$response = ["message"=>"Maksimum 20 Mb lık dosya yuklenebilir.","status"=>500];
		}else if(!in_array($file_type, $allowed)){
			$response = ["message"=>"Sadece pdf uzantılı dosyalar yüklenebilir","status"=>500];
		}else{
			$test=move_uploaded_file($dosya_gecici,"$klasor/".$yenisim);//yoksa yeni ismiyle kaydet 
			if($test==true){
				if(mysql_num_rows($kazanilan_sql)>0){
					$update=mysql_query("UPDATE kazanilan_ilanlar SET odeme_bildirimi='".$yenisim."' WHERE ilan_id='".$ilan_id."'");
					if($update){
						$response=["odeme_bildirimi"=>$yenisim,"message"=>"Ödeme bildirimi eklendi","status"=>200];
					}else{
						$response=["message"=>"Hata oluştu","status"=>500];
					}
				} else {
					$insert=mysql_query("INSERT INTO kazanilan_ilanlar (ilan_id,durum,odeme_bildirimi) VALUES ('".$ilan_id."','1','".$yenisim."')");
					if($insert){
						$response=["odeme_bildirimi"=>$yenisim,"odeme_bildirimi_link"=>$system_base_url."/images/pdf/".$yenisim,"message"=>"Ödeme bildirimi eklendi","status"=>200];
					}else{
						$response=["message"=>"Hata oluştu","status"=>500];
					}		
				}
			}
			else {
				$response = ["message"=>"Dosya yükleme işlemi başarısız oldu","status"=>500];
			}
		}
		echo json_encode($response);
	}

	if(re("action")=="prm_ekle"){
		$response=[];
		$admin_id = $_SESSION['kid'];
		$gelen_id = re('id');
		$bugun = date('Y-m-d H:i:s');
		$iki_ay_once = date( 'Y-m-d H:i:s', strtotime('-60 days'));
		$sayi=0;
		$admin_limit_cek = mysql_query("SELECT * FROM prm_notlari WHERE ekleyen = '".$admin_id."' ");
		//$admin_limit_say = mysql_num_rows($admin_limit_cek);
		while($admin_limit_oku=mysql_fetch_array($admin_limit_cek)){
			$tarih=$admin_limit_oku["tarih"];
			$tarih=date("Y-m-d",strtotime($tarih));
			if($tarih==date("Y-m-d")){
				$sayi++;
			}
		}

		$admin_cek = mysql_query("SELECT * FROM kullanicilar WHERE id = '".$admin_id."'");
		$admin_oku = mysql_fetch_assoc($admin_cek);
		$admin_limit = $admin_oku['prm_limiti'];
		if($sayi >= $admin_limit){
			$response=["message"=>"Günlük limtiniz doldu","status"=>500];
		}else{
			$not_cek = mysql_query("SELECT * FROM prm_notlari WHERE uye_id = '".$gelen_id."'");
			$not_sayi = mysql_num_rows($not_cek);
			$not_yaz = mysql_fetch_assoc($not_cek);
			$tarih = $not_yaz['tarih'];
			if($not_sayi == 0 ){
				mysql_query("INSERT INTO `prm_notlari` (`id`, `uye_id`, `not`, `tarih`, `gizlilik`, `ekleyen`) VALUES (NULL, '".$gelen_id."', 'Kendisiyle görüştüm Gold üye olma olasılığı yüksektir', '".$bugun."', '', '".$admin_id."')");
				mysql_query("INSERT INTO `yapilan_is` (`id`, `admin_id`, `yaptigi`,`aciklama`, `ekleme_zamani`, `ilan_id`, `dogrudan_id`, `uye_id`) VALUES (NULL, '".$admin_id."', '4','', '".$bugun."','','','".$gelen_id."');"); 
				$yuklenen_cek = mysql_query("SELECT * FROM yuklenen_evraklar WHERE user_id ='".$gelen_id."' group by gonderme_zamani order by id desc");
				$yuklenenler = mysql_num_rows($yuklenen_cek); 
				$evraklar = mysql_query("SELECT * FROM uye_notlari WHERE uye_id ='".$gelen_id."' group by tarih order by id desc");
				$evrak_say = mysql_num_rows($evraklar);
				$prm_cek = mysql_query("SELECT * FROM prm_notlari WHERE uye_id ='".$gelen_id."'");
				$prm_say = mysql_num_rows($prm_cek); 
				$toplam_not=$prm_say+$evrak_say+$yuklenenler;
				$response=["message"=>"PRM notu eklendi","toplam_not"=>$toplam_not,"status"=>200];
			}
			else{
				$sure_kontrol = mysql_query("SELECT * FROM prm_notlari WHERE uye_id = '".$gelen_id."' AND tarih BETWEEN '".$iki_ay_once."' AND '".$bugun."'");
				$sure_kontrol_sayi = mysql_num_rows($sure_kontrol);
				if($sure_kontrol_sayi > 0){
					$response=["message"=>"PRM notu daha önce eklenmiş","status"=>500];					
				}else{
					$sure_kontrol_oku = mysql_fetch_object($sure_kontrol);
					if($sure_kontrol_oku->durum == 2){
						mysql_query("update `prm_notlari` set tarih='".$bugun."',ekleyen='".$admin_id."' where uye_id='".$gelen_id."'");  
						mysql_query("INSERT INTO `yapilan_is` (`id`, `admin_id`, `yaptigi`,`aciklama`, `ekleme_zamani`, `ilan_id`, `dogrudan_id`, `uye_id`) VALUES (NULL, '".$admin_id."', '4','', '".$bugun."','','','".$gelen_id."');"); 
						$yuklenen_cek = mysql_query("SELECT * FROM yuklenen_evraklar WHERE user_id ='".$gelen_id."' group by gonderme_zamani order by id desc");
						$yuklenenler = mysql_num_rows($yuklenen_cek); 
						$evraklar = mysql_query("SELECT * FROM uye_notlari WHERE uye_id ='".$gelen_id."' group by tarih order by id desc");
						$evrak_say = mysql_num_rows($evraklar);
						$prm_cek = mysql_query("SELECT * FROM prm_notlari WHERE uye_id ='".$gelen_id."'");
						$prm_say = mysql_num_rows($prm_cek); 
						$toplam_not=$prm_say+$evrak_say+$yuklenenler;
						$response=["message"=>"PRM notu güncellendi","toplam_not"=>$toplam_not,"status"=>200];
					}else{
						$response=["message"=>"Daha önce PRM notu eklenmiş. Yeni PRM notu ekleyemezsiniz.","toplam_not"=>$toplam_not,"status"=>500];
					}
					/*				
					mysql_query("update `prm_notlari` set tarih='".$bugun."',ekleyen='".$admin_id."' where uye_id='".$gelen_id."'");  
					mysql_query("INSERT INTO `yapilan_is` (`id`, `admin_id`, `yaptigi`,`aciklama`, `ekleme_zamani`, `ilan_id`, `dogrudan_id`, `uye_id`) VALUES (NULL, '".$admin_id."', '4','', '".$bugun."','','','".$gelen_id."');"); 
					$yuklenen_cek = mysql_query("SELECT * FROM yuklenen_evraklar WHERE user_id ='".$gelen_id."' group by gonderme_zamani order by id desc");
					$yuklenenler = mysql_num_rows($yuklenen_cek); 
					$evraklar = mysql_query("SELECT * FROM uye_notlari WHERE uye_id ='".$gelen_id."' group by tarih order by id desc");
					$evrak_say = mysql_num_rows($evraklar);
					$prm_cek = mysql_query("SELECT * FROM prm_notlari WHERE uye_id ='".$gelen_id."'");
					$prm_say = mysql_num_rows($prm_cek); 
					$toplam_not=$prm_say+$evrak_say+$yuklenenler;
					$response=["message"=>"PRM notu güncellendi","toplam_not"=>$toplam_not,"status"=>200];
					*/
				}
			}
		}
		
		echo json_encode($response);
		
	}
	if(re("action")=="tanitim_sms_gonder"){
		
		$id=re("id");
		$select=mysql_query("Select * from tanitim_sms_ayarlari where durum='1'");
		$mesaj_cek=mysql_fetch_assoc($select);
		coklu_sms_gonder($id,strip_tags($mesaj_cek["gonderilen_sms"]),7);
		$response=["message"=>"Tanıtım sms başarıyla gönderildi","status"=>200];
		echo json_encode($response);
	}
	if(re("action")=="sifre_hatirlat_sms"){
		$id=re("id");
		$numara_cek=mysql_query("Select* from user where id='".$id."'");
		$numara=mysql_fetch_assoc($numara_cek);
		$gsm=$numara["telefon"];
		$yeni_sifre = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789"),0,6);
		$sifre_guncelle = mysql_query("update user set sifre = '".md5($yeni_sifre)."' where id='".$id."'");
		$sifre="Pertdunyasi.com kullanıcı girişi bilgileriniz:Onaylı cep No:".$gsm." Şifre:". $yeni_sifre;
		coklu_sms_gonder($id,$sifre,8);
		$response=["message"=>"Şifre hatırlatma işlemi başarıyla gerçekleştirdi","status"=>200];
		echo json_encode($response);

	}
	if(re("action")=="sifre_hatirlat_sms"){
		$id=re("id");
		$numara_cek=mysql_query("Select* from user where id='".$id."'");
		$numara=mysql_fetch_assoc($numara_cek);
		$gsm=$numara["telefon"];
		$yeni_onay = substr(str_shuffle("0123456789"),0,6);
		$guncelle=mysql_query("update onayli_kullanicilar set kod='".$yeni_onay."' where user_id='".$id."' ");
		$text="Pertdunyasi.com yeni onay kodunuz: ".$yeni_onay;
		coklu_sms_gonder($id,$text,11);
		$response=["message"=>"Doğrulama kodu yenileme işlemi başarıyla gerçekleştirdi","status"=>200];
		echo json_encode($response);

	}

	if(re('action') == "panel_mesaji_sil"){
		$mesaj_id = re('mesaj_id');
		$sql = mysql_query("delete from mesajlar where id = '".$mesaj_id."'");
		if($sql){
			echo json_encode(["status" => 200, "message" => "Mesaj silindi"]);
		}else{
			echo json_encode(["status" => 300, "message" => "İşlem sırasında bir hata oluştu. Lütfen daha sonra tekrar deneyiniz."]);
		}
	}


	if(re('action') == "panel_mesaji_sil_yeni"){
		$mesaj_id = re('mesaj_id');
		$sql = mysql_query("update chat_messages set status = 2 where id = '".$mesaj_id."'");
		if($sql){
			echo json_encode(["status" => 200, "message" => "Mesaj silindi"]);
		}else{
			echo json_encode(["status" => 300, "message" => "İşlem sırasında bir hata oluştu. Lütfen daha sonra tekrar deneyiniz."]);
		}
	}


	if(re("action")=="panel_teklif_onayla"){
		$gelen_id=re("teklif_id");
		$response=[];
		$teklif_bul = mysql_query("select * from teklifler where id = '".$gelen_id."'");
		$teklif_oku = mysql_fetch_assoc($teklif_bul);
		$ilan_bul = mysql_query("select * from ilanlar where id = '".$teklif_oku['ilan_id']."'");
		$ilan_oku = mysql_fetch_assoc($ilan_bul);
		$sigorta_bul = mysql_query("select * from sigorta_ozellikleri where id = '".$ilan_oku['sigorta']."'");
		$sigorta_oku = mysql_fetch_assoc($sigorta_bul);    
		if($sigorta_oku['sure_uzatma'] == 1){
			$dakikanin_altinda = $sigorta_oku['dakikanin_altinda'];
			$dakika_uzar = $sigorta_oku['dakika_uzar'];
			$genel_kapanis = $ilan_oku['ihale_tarihi']." ".$ilan_oku['ihale_saati'];
			$suanki_zaman = date('Y-m-d H:i:s');
			$a = date('Y-m-d H:i:s', strtotime('+'.$dakikanin_altinda.'minutes', strtotime($suanki_zaman)));	        
			if($a > $genel_kapanis){            
				$suan_saat = date('H:i:s');
				$guncellenen_saat = date('H:i:s', strtotime('+'.$dakika_uzar.'minutes', strtotime($suan_saat)));            
				$guncelle = mysql_query("update ilanlar set durum = 1,sistem_sure_uzatma_durumu=0, ihale_tarihi = '".date('Y-m-d')."', ihale_saati = '".$guncellenen_saat."' where id = '".$ilan_oku['id']."'");
				$teklifi_onayla = mysql_query("update teklifler set durum = 1 where id = '".$gelen_id."'");        
				if($ilan_oku['son_teklif'] < $teklif_oku['teklif']){
					$son_teklif_guncelle = mysql_query("update ilanlar set son_teklif = '".$teklif_oku['teklif']."'");
				}
				$response=["message"=>"Teklif başarıyla onaylandı ","status"=>200 ];
			}
		}else{
			$teklifi_onayla = mysql_query("update teklifler set durum = 1 where id = '".$gelen_id."'");   
			if($teklifi_onayla){
				$response=["message"=>"Teklif başarıyla onaylandı ","status"=>200 ];
			}else{
				$response=["message"=>"İşlem sırasında bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.","status"=>300 ];
			}
		}
		echo json_encode($response);

		/*
		$response=[];
		$id=re("teklif_id");
		$teklif_cek=mysql_query("select * from teklifler where id='".$id."' ");
		$teklif_oku=mysql_fetch_object($teklif_cek);
		$teklif=$teklif_oku->teklif;
		$ilan_cek=mysql_query("select * from ilanlar where id='".$teklif_oku->ilan_id."'");
		$ilan_oku=mysql_fetch_object($ilan_cek);
	
		$sql = mysql_query("update teklifler set durum = 1 where id = '".$id."'");
		if($sql){
			$cek = mysql_query("select * from teklifler where ilan_id = '".$teklif_oku->ilan_id."' and durum = 1 order by teklif desc limit 1");
			$oku = mysql_fetch_object($cek);
			mysql_query("update ilanlar set son_teklif = '".$oku->teklif."' where id = '".$teklif_oku->ilan_id."'");
			$response=["message"=>"Teklif başarıyla onaylandı ","status"=>200 ];
		}else{
			$response=["message"=>"İşlem sırasında bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.","status"=>300 ];
		}
		echo json_encode($response);
		*/
	}

	function yorum_marka_getir($id){
		$cek = mysql_query("select * from marka where markaID = '".$id."'");
		$oku = mysql_fetch_object($cek);
		return $oku->marka_adi;
	}

	if(re('action') == "ilan_yorum_icin_getir"){
		$uye_id = re('uye_id');
		$kazanilan_var_mi_cek = mysql_query("select * from kazanilan_ilanlar where uye_id = '".$uye_id."' and durum = 3 order by e_tarih desc");
		if(mysql_num_rows($kazanilan_var_mi_cek) == 0){			
			$yorum_yapsin = 0;
		}else{			
			$kazanilan_var_mi_oku = mysql_fetch_object($kazanilan_var_mi_cek);
			$kazanilan_id = $kazanilan_var_mi_oku->ilan_id;
			$yorum_cek = mysql_query("select * from yorumlar where ilan_id = '".$kazanilan_id."' and uye_id = '".$uye_id."'");

			$tarih = time();
			$your_date = strtotime($kazanilan_var_mi_oku->e_tarih);
			$datediff = $tarih - $your_date;						
			$date_count = round($datediff / (60 * 60 * 24));


			if(mysql_num_rows($yorum_cek) == 0 && $date_count <= 7){
				$yorum_yapsin = 1;
			}else{
				$yorum_yapsin = 0;
			}
			$cek = mysql_query("select * from ilanlar where id = '".$kazanilan_id."'");
			$oku = mysql_fetch_object($cek);
		}
		
		$listingMap[] = [
			"id" => $kazanilan_id,
			"marka" => yorum_marka_getir($oku->marka),
			"model" => $oku->model,
			"tip" => $oku->tip,
			"model_yili" => $oku->model_yili,
			"yorum_yapsin" => $yorum_yapsin,
			"date_count" => $date_count,
		];
		echo json_encode(response($listingMap));
	}

	if(re('action') == "ilan_yorum_yap"){
		$uye_id = re('uye_id');
		$yorum = re('yorum');
		$ilan_id = re('ilan_id');
		$date_time = date('Y-m-d H:i:s');
		$sql = mysql_query("INSERT INTO `yorumlar` (`id`, `ilan_id`, `uye_id`, `yorum`, `yorum_zamani`, `cevap`, `cevaplayan`, `cevap_zamani`, `durum`) VALUES 
		(NULL, '".$ilan_id."', '".$uye_id."', '".$yorum."', '".$date_time."', '', '', '', '0');");
		if($sql){
			mysql_query("update kazanilan_ilanlar set modal_durum=1 where uye_id='".$uye_id."' and ilan_id='".$ilan_id."'");
			$listingMap[] = ["status" => 200, "message" => "Yorumunuz başarılı bir şekilde gönderildi"];
		}else{
			$listingMap[] = ["status" => 300, "message" => "İşlem sırasında bir hata oluştu. Lütfen daha sonra tekrar deneyin"];
		}
		echo json_encode(response($listingMap));
	}

	if(re('action') == "model_getir"){
		$marka = re('marka');
		$cek = mysql_query("select * from model where marka_adi = '".$marka."'");
		while($oku = mysql_fetch_object($cek)){
			$listingMap[] = [
				"modelID" => $oku->modelID,
				"marka_id" => $oku->marka_id,
				"model_adi" => $oku->model_adi,
				"marka_adi" => $oku->marka_adi
			];
		}
		echo json_encode(response($listingMap));
	}

	if(re('action') == "getChatRoomMessages"){
		$room_id = re('room_id');
		$user_id = re('user_id');echo json_encode(response(chatRoomMessages($room_id,$user_id))); // ayar sayfasında
	}

	if(re('action') == "sendChatRoomMessage"){
		$room_id = re('room_id');
		$user_id = re('user_id');
		$message = re('message');
		echo json_encode(response(sendChatRoomMessage($room_id,$user_id,$message)));
	}

	if(re('action') == "deleteChatMessage"){
		$message_id = re('message_id');
		echo json_encode(response(deleteChatMessage($message_id)));
	}

	if(re('action') == "deleteChatRoom"){
		$room_id = re('room_id');
		echo json_encode(response(deleteChatRoom($room_id)));
	}

	if(re('action') == "dogrudan_room_sil"){
		$room_id = re('room_id');
		mysql_query("delete from chat_room where id = '".$room_id."'");
		mysql_query("delete from chat_messages where room_id = '".$room_id."'");
		$listingMap[] = [
			"status" => 200,
			"message" => "silindi"
		];
		echo json_encode(response($listingMap));
	}


	if(re('action') == "getChatRooms"){
		$user_id = re('user_id');
		echo json_encode(response(user_chat_rooms($user_id)));
	}


	if(re('action') == "panel_dogrudan_mesaj_sayi"){
		$hepsini_cek = mysql_query("SELECT * FROM dogrudan_satisli_ilanlar WHERE durum = 1 AND bitis_tarihi > '".date("Y-m-d H:i:s")."' and panelden_eklenme = 1 order by bitis_tarihi asc");

		while($hepsini_oku = mysql_fetch_object($hepsini_cek)){
			$sayi = 0;
			$id = $hepsini_oku->id;
			$room_cek = mysql_query("select * from chat_room where dogrudan_satis_id = '".$id."' and status = 1");
			while($room_oku = mysql_fetch_object($room_cek)){
				$sayi += mysql_num_rows(mysql_query("select * from chat_messages where is_admin_see = 0 and status = 1 and room_id = '".$room_oku->id."'"));
			}
			$listingMap[] = [
				"room_count" => mysql_num_rows($room_cek),
				"unread" => $sayi,
				"ilan_id" => $hepsini_oku->id
			];
		}
		echo json_encode(response($listingMap));
	}


?>
 
