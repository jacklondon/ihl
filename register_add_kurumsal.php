<?php 
session_start();
include 'ayar.php';
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
?>

<?php 

if(re('action')=="Kayit Ol"){
	$response=[];
    $unvan = buyukHarf(re('unvan'));
    $ad = buyukHarf(re('kurumsal_ad'));
    $sebep = re('sebep');
    $mail = re('k_email');
    $sehir = re('kurumsal_city');
    $kurumsal_ilce = re('kurumsal_ilce');
    $k_dogum_tarihi = re('k_dogum_tarihi');
    $telefon = re('k_tel');
    $gelen_sifre = re('k_sifre');
    $sifre_tekrar = re('k_sifre_tekrar');
    $sifre = md5(re('k_sifre'));
    $kayit_tarihi = date('Y-m-d H:i:s');
    $token = md5(uniqid(mt_rand(), true));
	$sorgu=mysql_query("select * from user where telefon='".$telefon."' ");
	$sorgu3=mysql_query("select * from user where mail='".$mail."' ");
	$sorgu4 = mysql_query("select * from sehir where sehirID = '".$sehir."'");
	$sonuc4 = mysql_fetch_assoc($sorgu4);
	$son_sehir = $sonuc4['sehiradi'];
	$str="ÜĞŞÇÖğıüşöçİ";
	$a=str_split_unicode($mail,1);
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
	$a=ltrim(rtrim(re("unvan")));
	$b=ltrim(rtrim(re("kurumsal_ad")));
	if($sayi != 0){
		$response=["message"=>"Email alanında türkçe karakter olmamalıdır.","status"=>500];
	}
	
	else if(!strstr($a," ")){
		$response=["message"=>"Firma Unvanı en az 2 kelime olmalıdır","status"=>500];
	}
	
	else if(!strstr($b," ")){
		$response=["message"=>"Ad soyad en az 2 kelime olmalıdır","status"=>500];
	}
    else if($gelen_sifre != $sifre_tekrar){
        $response=["message"=>"Şifreler uyuşmuyor lütfen tekrar deneyiniz","status"=>500];
    }else if( $unvan == "" || $ad == "" || $sebep == "" || $mail == "" || $telefon == "" || $sehir == "" || $gelen_sifre == "" || $sifre_tekrar == "" ){
		$response=["message"=>"Tüm alanları doldurmalısınız","status"=>500];
	}else if(strlen($telefon)!=14){
		$response=["message"=>" Telefon numaranız 11 rakamdan oluşmalıdır","status"=>500];
	}
	else if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
		$response=["message"=>"Email formatına uygun değil.","status"=>500];
	}
	else if(strlen($gelen_sifre)<6){
		$response=["message"=>"Şifreniz en az 6 haneli olmalıdır.","status"=>500];
	}
	else if(mysql_num_rows($sorgu)==1){
		$response=["message"=>"Telefon numarası kullanılmakta","status"=>500];
	}
	else if(mysql_num_rows($sorgu3)==1){
		$response=["message"=>"Email kullanılmakta","status"=>500];
	}
	else{
		/*
		$prm_cek = mysql_query("select ekleyen,durum,count(ekleyen) as toplam from prm_notlari where durum = 1 order by toplam desc");
		$prm_oku = mysql_fetch_object($prm_cek);
		if(mysql_num_rows($prm_cek) == 0){
			$admin_cek = mysql_query("SELECT kullanicilar.id, user.temsilci_id, COUNT(kullanicilar.id)AS toplam,(user.temsilci_id IS NOT NULL) AS temsilci_sayisi FROM kullanicilar LEFT JOIN user ON kullanicilar.id = user.temsilci_id 
			GROUP BY kullanicilar.id ORDER BY toplam ASC,temsilci_sayisi ASC");
			$admin_oku = mysql_fetch_object($admin_cek);
			$temsilci_id = $admin_oku->id;
		}else{
			$temsilci_id = $prm_oku->ekleyen;
		}
		*/
		$temsilci_id = 0;
       mysql_query("INSERT INTO `user` 
      (`id`, `ad`, `soyad`, `tc_kimlik`, `uye_olma_sebebi`, `cinsiyet`, `mail`, 
      `telefon`, `sabit_tel`, `sehir`,`ilce`, `meslek`, `ilgilendigi_turler`, `sifre`, `adres`, `kargo_adresi`, 
      `fatura_adresi`, `user_token`, `paket`, `unvan`, `vergi_dairesi`, `vergi_dairesi_no`, `kurumsal_user_token`, 
      `temsilci_id`, `kayit_tarihi`, `yedek_kisi`, `yedek_kisi_tel`, `risk`) 
      VALUES 
      (NULL, '".$ad."', '', '', '".$sebep."', '', '".$mail."', '".$telefon."', 
      '', '".$son_sehir."', '".$kurumsal_ilce."', '', '', '".$sifre."', '', '', '', '', 
      '1', '".$unvan."', '', '', '".$token."', '".$temsilci_id."', '".$kayit_tarihi."', '', '', '');");
		$uye_bul = mysql_query("SELECT * FROM user WHERE ad='".$ad."' AND telefon='".$telefon."' 
		AND mail='".$mail."'");
		$uye_cek = mysql_fetch_assoc($uye_bul);
		$uye_id = $uye_cek['id'];
		mysql_query("INSERT INTO `teklif_limiti` (`id`,`uye_id`,`teklif_limiti`,`standart_limit`, `luks_limit`) VALUES (NULL, '".$uye_id."',0,0,0)");    
		/*mysql_query("INSERT INTO `cayma_bedelleri` (`uye_id`,`uye_grubu`) 
		VALUES 
		('".$uye_id."',1)");  	*/
		mysql_query("INSERT INTO `dogum_tarihi` (`id`,`uye_id`,`dogum_tarihi`) VALUES (NULL, '".$uye_id."','".$k_dogum_tarihi."')");  	
		
		mysql_query("INSERT INTO `uye_durumlari` (`id`, `uye_id`, `demo_olacagi_tarih`, `grup`, `teklif_limiti`, `hurda_teklif`, `yasak_sigorta`, `kalici_mesaj`, `kalici_sistem_mesaji`, `teklif_engelle`, `engelleme_nedeni`, `uyelik_iptal`, `uyelik_iptal_nedeni`, `mesaj_gorme_durumu`)
		VALUES (NULL, '".$uye_id."', '', '1', '0', '', '', '', '', '', '', '', '', '');"); 		
		$response=["message"=>"Kayıt Başarılı","status"=>200];        
	}
		echo json_encode($response);
}



 // $sabit_tel = re('k_sabit_tel');

// $sorgu2=mysql_query("select * from user where sabit_tel='".$sabit_tel."' ");

/* else if((strlen($sabit_tel)>4 || $sabit_tel =="") && strlen($sabit_tel)!=14){
		$response=["message"=>"Sabit telefon numaranız 11 rakamdan oluşmalıdır","status"=>500];
	}*/




?>