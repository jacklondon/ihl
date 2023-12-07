<?php 
	include('../ayar_conf.php');
	error_reporting(0);
	ob_start();
	session_start();
	$baglan=mysql_connect($host,$kullanici,$sifre) or die("Mysql Baglanamadi"); 
	mysql_select_db($vtadi,$baglan) or die ("Vt Baglanamadi"); 
	mysql_query("SET NAMES 'utf8'");
	mysql_query("SET CHARACTER SET utf8");
	mysql_query("SET COLLATION_CONNECTION = 'utf8_turkish_ci' "); 
	$system_base_url="https://ihale.pertdunyasi.com";
	require_once "PhpMailler/PHPMailer.php";
    require_once "PhpMailler/POP3.php";
    require_once "PhpMailler/SMTP.php";
    require_once "PhpMailler/OAuth.php";


	function referans_image(){
		return "https://ihale.pertdunyasi.com/";
	}

	
	//Engelli IP'ler çekiliyor
	$ipleri_cek = mysql_query("select * from s_engelli_ip where durum='1' ORDER BY e_tarihi ASC ");
	while($ipleri_oku = mysql_fetch_array($ipleri_cek))
	{
		if($_SERVER['REMOTE_ADDR'] == $ipleri_oku['ip'])
		{
			exit;
		}
	}
	
	$ozellik_cek=mysql_query("select * from site_tasarim");
	$ozellik_oku=mysql_fetch_assoc($ozellik_cek);
	
	function re($veri)
	{
		$search = array(' OR ',' AND ',' xp_ ',' like ',' drop ',' create ',' modify ',' rename ',' alter ',' cast ',' join ',' union ',' where ',' insert ',' delete ',' update '," and "," or "," LIKE "," DROP "," CREATE ","MODIFY ","RENA ME "," ALTER ","CAST ","JOIN ","UNION ","WHERE ","INSERT " ,"DELETE ","UPDATE ");
		$replace = array(' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ');
		$veri = str_replace($search,$replace,$_REQUEST[$veri]);
		return mysql_real_escape_string($veri);
	}
	
	function escape($veri)
	{
		$search = array(' OR ',' AND ',' xp_ ',' like ',' drop ',' create ',' modify ',' rename ',' alter ',' cast ',' join ',' union ',' where ',' insert ',' delete ',' update '," and "," or "," LIKE "," DROP "," CREATE ","MODIFY ","RENA ME "," ALTER ","CAST ","JOIN ","UNION ","WHERE ","INSERT " ,"DELETE ","UPDATE ");
		$replace = array(' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ');
		$veri = str_replace($search,$replace,$veri);
		return mysql_real_escape_string($veri);
	}
	
	$mesaj = "";
	function alert($mesaj)
	{
		echo '<script type="text/javascript">alert("'.$mesaj.'");</script>';
	}
	function money($price){
		return number_format($price, 0, ',', '.');
	}
	function mkcevir($tarih)
	{
		$bol=explode(".",$tarih);
		return mktime(0,0,0,$bol[1],$bol[0],$bol[2]);
	}
	
	function mkcevir2($tarih)
	{
		$bol=explode(".",$tarih);
		return mktime(23,59,59,$bol[1],$bol[0],$bol[2]);
	}

	function buyukHarf($kelime)
	{
		$cikti="";
		$kelime_bol=explode(" ",$kelime);
		for($i=0;$i<=count($kelime_bol);$i++)
		{
			if($kelime_bol[$i]!="")
			{
				$ilk=mb_strtoupper(mb_substr($kelime_bol[$i],0,1,"utf-8"),"utf-8");
				$diger=mb_strtolower(mb_substr($kelime_bol[$i],1,null,"utf-8"),"utf-8");

				$cikti.=$ilk.$diger." ";
			}
		}

		return $cikti;
	}
	
	
	function tr($text) 
	{
		$text = trim($text);
		$search = array('Ç','ç','Ğ','ğ','ı','İ','Ö','ö','Ş','ş','Ü','ü',' ','*','/');
		$replace = array('C','c','G','g','i','I','O','o','S','s','U','u','_','-','_');
		$new_text = str_replace($search,$replace,$text);
		return $new_text;
	}  
	
	function ay($gelen)
	{
		$gelen_burda = $gelen;
		
		if($gelen_burda == 1) { $gelen_cikti = "Ocak"; }
		if($gelen_burda == 2) { $gelen_cikti = "Şubat"; }
		if($gelen_burda == 3) { $gelen_cikti = "Mart"; }
		if($gelen_burda == 4) { $gelen_cikti = "Nisan"; }
		if($gelen_burda == 5) { $gelen_cikti = "Mayıs"; }
		if($gelen_burda == 6) { $gelen_cikti = "Haziran"; }
		if($gelen_burda == 7) { $gelen_cikti = "Temmuz"; }
		if($gelen_burda == 8) { $gelen_cikti = "Ağustos"; }
		if($gelen_burda == 9) { $gelen_cikti = "Eylül"; }
		if($gelen_burda == 10) { $gelen_cikti = "Ekim"; }
		if($gelen_burda == 11) { $gelen_cikti = "Kasım"; }
		if($gelen_burda == 12) { $gelen_cikti = "Aralık"; }
		
		return $gelen_cikti;
	}
	
	function ay_kisa($gelen)
	{
		$gelen_burda = $gelen;
		
		if($gelen_burda == 1) { $gelen_cikti = "Ocak"; }
		if($gelen_burda == 2) { $gelen_cikti = "Şubt"; }
		if($gelen_burda == 3) { $gelen_cikti = "Mart"; }
		if($gelen_burda == 4) { $gelen_cikti = "Nisn"; }
		if($gelen_burda == 5) { $gelen_cikti = "Mays"; }
		if($gelen_burda == 6) { $gelen_cikti = "Hazn"; }
		if($gelen_burda == 7) { $gelen_cikti = "Temz"; }
		if($gelen_burda == 8) { $gelen_cikti = "Ağus"; }
		if($gelen_burda == 9) { $gelen_cikti = "Eylül"; }
		if($gelen_burda == 10) { $gelen_cikti = "Ekim"; }
		if($gelen_burda == 11) { $gelen_cikti = "Kasm"; }
		if($gelen_burda == 12) { $gelen_cikti = "Arlk"; }
		
		return $gelen_cikti;
	}
	
	function kisalt($deger,$cumle)
	{
		$cumlesi='';
		$bak=strlen($cumle);
		if ($bak <= $deger)
		{
			$cumlesi=$cumle;
		}
		else
		{
			for ($i=0; $i<=$deger; $i++)
			{
				$cumlesi.=$cumle[$i];
			}
			
			$cumlesi.='...';
		}
		return $cumlesi;
	}
	
	function para($parasi)
	{
		$para = $parasi;
		$para_cikan = number_format($para, 2, ',', '.');
		return $para_cikan;
	}

	//Uye Gurpları Listele Function Begın

	function uye_gruplari_cek($uye_grup)
	{
		$select=mysql_query("Select * from uye_grubu where id='".$uye_grup."'");
		$grup_cek=mysql_fetch_assoc($select);

		return $grup_cek["grup_adi"];
	}



	//Uye Gurpları Listele Function End


	//Admin Bul Function Begın

	function admin_bul($token)
	{
		$select=mysql_query("Select * from kullanicilar where token='".$token."'");
		$admin_cek=mysql_fetch_assoc($select);

		return ucfirst($admin_cek["adi"])."  ".ucfirst($admin_cek["soyadi"]);
	}




	//Admin Bul Function End
	
	function resimYukle($klasor,$adi,$tipi,$genislik,$yukseklik,$yeniisim)
	{
		$dosya="".$klasor."".$adi;
		if(($tipi=='image/jpg') || ($tipi=='image/jpeg') || ($tipi=='image/pjpeg') ){
		$resim=imagecreatefromjpeg($dosya); // Yklenen resimden oluacak yeni bir JPEG resmi oluturuyoruz..
		}elseif($tipi=='image/gif'){
		$resim=imagecreatefromgif($dosya); // Yklenen resimden oluacak yeni bir JPEG resmi oluturuyoruz..
		}elseif($tipi == 'image/png'){
			$resim=imagecreatefrompng($dosya);
			}


		$boyutlar=getimagesize($dosya); // Resmimizin boyutlarn reniyoruz.

		if($boyutlar[0]<$genislik){
			$genislik=$boyutlar[0];
		}
		if($boyutlar[1]<$yukseklik){
			$yukseklik=$boyutlar[1];
			}


		$yeniresim=imagecreatetruecolor($genislik,$yukseklik); // Oluturulan bo resmi istediimiz boyutlara getiriyoruz..
		imagecopyresampled($yeniresim, $resim, 0, 0, 0, 0, $genislik, $yukseklik, $boyutlar[0], $boyutlar[1]);
		$hedefdosya="".$klasor."".$yeniisim.""; // Yeni resimin kaydedilecei konumu belirtiyoruz..
		if(($tipi=='image/jpg') || ($tipi=='image/jpeg') || ($tipi=='image/pjpeg') ){
		imagejpeg($yeniresim,$hedefdosya,100); // Ve resmi istediimiz konuma kaydediyoruz..
		}elseif($tipi=='image/gif'){
		imagegif($yeniresim,$hedefdosya,100); // Ve resmi istediimiz konuma kaydediyoruz..
		}elseif($tipi == 'image/png'){
		imagejpeg($yeniresim,$hedefdosya,100); // Ve resmi istediimiz konuma kaydediyoruz..	
			}
		return $yeniisim;
	}
	
	
	if ( re('giris') == "Giris" )
	{
		$giris = true;
		if(re('kullanici_adi') == "") { $giris = false; }
		if(re('sifre') == "") { $giris = false; }
		if($_POST['guvenlik_kodu'] != $_SESSION['guvenlik_kodu']){$giris=true;}
		
		
		if($giris == true)
		{
			$kullanici_cek = mysql_query("SELECT * FROM kullanicilar WHERE kullanici_adi='".re('kullanici_adi')."' AND sifre='".md5(re('sifre'))."' AND durum!='0' ");
			$kullanici_oku = mysql_fetch_assoc($kullanici_cek);
			
			if($kullanici_oku['id'] == "")
			{
				alert("Kullanıcı Adı veya Şifreniz yanlış");
			}
			else
			{
				$onayli_admin=mysql_query("select * from onayli_adminler where admin_id='".$kullanici_oku['id']."'");
				$onayli_admin_oku=mysql_fetch_object($onayli_admin);
				
				if($onayli_admin_oku->durum==0){
					/*echo '
						<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
						<script>
							var onay_kodu="'.$onayli_admin_oku->kod.'";
							var durum=true;
							while(durum==true){
								let person = prompt("GSM Onay Kodu:");
								if (person == onay_kodu ) {
									jQuery.ajax({
										url: "https://ihale.pertdunyasi.com/check.php",
										type: "POST",
										dataType: "JSON",
										data: {
											action: "admin_onayla",
											admin_id:"'.$kullanici_oku['id'].'",
										},
										success: function(data) {
											if(data.status==200){
												window.location.href = "sistem.php";
											}else{
												alert(data.message);
											}
											
										}
									});
									break;
								} else if(person=="" || person==null){
									break;
								}
							}
						</script>
					
						
					';*/

					
					//header("Location: sistem.php");
				}else{
						if($kullanici_oku['durum'] == 2)
						{
							alert("Hesabınız pasif durumda..");
						}
						
						if($kullanici_oku['durum'] == 1)
						{
							$_SESSION['kid'] = $kullanici_oku['id'];
							$_SESSION['yetki'] = $kullanici_oku['yetki'];
							$_SESSION['isim'] = $kullanici_oku['adi'].' '.$kullanici_oku['soyadi'];
						}
				}
				
			}
		}
		else
		{
			alert('Lütfen Tüm Alanları Doğru Şekilde Doldurunuz.');
		}
	}
	
	
	function git($sayfa,$sure = 0)
	{
		echo '<meta http-equiv="refresh" content="'.$sure.';URL='.$sayfa.'">';
	}
	
	
	if(re('sayfa') == "cikis")
	{
		session_destroy();
		header("Location: index.php");
	}
	function response($data, $httpStatusCode = 200, $message = "İşlem Gerçekleştirildi"){
		return ["message" => $message, "data" => $data, "status" => $httpStatusCode];
   }

	
	function log_kaydet($modul,$sayfa,$islem,$sonuc,$durum)
	{
		if ( $durum == "" ) { $durum="2"; }
		
		/* durum;
			1 başarılı işlemler
			2 hatalı işlemler
			3 uyarı işlemleri
			*/
		mysql_query("insert into prg_loglar (id,lk,fk,zaman,kullanici,modul,sayfa,yapılan_islem,sonuc,durum)values(null,'".$_SESSION['lk']."','".$_SESSION['fk']."','".time()."','".$_SESSION['kid']."','".$modul."','".$sayfa."','".$islem."','".$sonuc."','".$durum."')");
	}
	

	//coklu_sms_gonder(25,"EA bilişim Deneme Mesajıdır");
     //Sms Servisi Function Begın

     function coklu_sms_gonder($user_id,$mesaj_icerik,$sms_kategori)
     {
         
          $select=mysql_query("Select * from user where id='".$user_id."'");
          $veri_cek=mysql_fetch_assoc($select);

          $phone_number=trim($veri_cek["telefon"]);
                
          $trim_phone=telefon_formatla($phone_number);
        
          $bosluklu_mesaj=str_replace(' ', '%20', $mesaj_icerik);

          SMSgonderHttpGET($trim_phone,$bosluklu_mesaj,$sms_kategori);
     }

     //Sms Servisi Function End 

	 function coklu_sms_gonder_admin($user_id,$mesaj_icerik,$sms_kategori)
     {
         
          $select=mysql_query("Select * from kullanicilar where id='".$user_id."'");
          $veri_cek=mysql_fetch_assoc($select);

          $phone_number=trim($veri_cek["tel"]);
                
          $trim_phone=telefon_formatla($phone_number);
        
          $bosluklu_mesaj=str_replace(' ', '%20', $mesaj_icerik);

          SMSgonderHttpGET($trim_phone,$bosluklu_mesaj,$sms_kategori);
     }

     //Telefon Formatla Begın
     function telefon_formatla($tel_no)
     {
          $sol_karakter_sil=str_replace('(', '', $tel_no);
          $sag_karakter_sil=str_replace(')', '', $sol_karakter_sil);
          $tre_sil=str_replace('-', '', $sag_karakter_sil);

          return $tre_sil;
     }
     //Telefon Formatla End


//NetGsm Api Begın
      
function SMSgonderHttpGET($numara,$mesaj,$sms_kategori){

  $url= "https://api.netgsm.com.tr/sms/send/get/?usercode=8503030800&password=1397ea1479&gsmno=".$numara."&message=".$mesaj."&msgheader=EA%20Bilisim";
//   $url= "https://api.netgsm.com.tr/sms/send/get/?usercode=5327183376 &password=Pd8589977&gsmno=".$numara."&message=".$mesaj."&msgheader=PERTDUNYASI";
  

  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  $http_response = curl_exec($ch);
  $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

  if($http_code != 200){
    echo "$http_code $http_response\n";
    return false;
  }
  $balanceInfo = $http_response;
//  echo "MesajID : $balanceInfo";

  $date_time=Date("Y-m-d H:i:s");

  $insert=mysql_query("insert into sms_kaydet (sms_kategori_id,sms_icerigi,numara,e_tarihi,bulkid,durum) values ('".$sms_kategori."','".$mesaj."','".$numara."','".$date_time."','".$balanceInfo."','1') ");

  return $balanceInfo;
}    


     //NetGsm Api 
	 



	 //Netgsm Api Sorgulama Begın

	function SMSHttpGET($bulkid){

		$url= "https://api.netgsm.com.tr/sms/report/?usercode=8503030800&password=1397ea1479&bulkid=".$bulkid."&type=0&status=100&version=2";
	  
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$http_response = curl_exec($ch);
		$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		// print_r($http_response);
		// print_r($http_code);
	  
		if($http_code != 200){
			echo "$http_code $http_response\n";
			return false;
		}
		$balanceInfo = $http_response;
		$dizi = explode (" ",$balanceInfo);

		return $dizi;
	}
	  
	 // SMSHttpGET();


	 //Sms Mesaj Kodları Function Begın

	 function mesaj_kodlari($kod)
	 {
		  $durum="";
		 if($kod==0)
		 {
			$durum= "İletilmeyi Bekleyen";
		 }
		 if($kod==1)
		 {
			
			$durum="İletilmiş";
		 }
		 if($kod==2)
		 {
			$durum= "Zaman Aşımına Uğramış";
		 }
		 if($kod==3)
		 {
			$durum= "Hatalı veya kısıtlı Numara";
		 }
		 if($kod==4)
		 {
			$durum= "Operatöre gönderilemedi";
		 }
		 if($kod==11)
		 {
			$durum= "Operatör tarafından kabul edilmemiş olanlar";
		 }
		 if($kod==12)
		 {
			$durum= "Gönderim hatası olanlar";
		 }
		
		 if($kod==13)
		 {
			$durum="Mükerrer olanlar";
		 }
		 if($kod==100)
		 {
			$durum= "Tüm mesaj durumları";
		 }
		 if($kod==103)
		 {
			$durum= "Başarısız Görev";
		 }		
		 return $durum;
	 }


	 function operator_sms($kod)
	 {
		 $operator="";
		 if($kod==10)
		 {
			 $operator="Vodafone";
		 }
		 if($kod==20)
		 {
			 $operator="Avea";
		 }
		 if($kod==30)
		 {
			 $operator="Turkcell";
		 }
		 if($kod==40)
		 {
			 $operator="NetGSM";
		 }
		 if($kod==50)
		 {
			 $operator="TTNET Mobil";
		 }
		 if($kod==60)
		 {
			 $operator="Türk Telekom";
		 }
		 if($kod==70)
		 {
			 $operator="Diğer Operatörler";
		 }

		 return $operator;
	 }

	 function hata_kodlari($kod)
	 {
		$hata_kodu="";
		if($kod==0)
		{
			$hata_kodu="Hata Yok";
		}
		if($kod==101)
		{
			$hata_kodu="Mesaj Kutusu Dolu";
		}
		if($kod==102)
		{
			$hata_kodu="Kapalı yada Kapsama Dışında";
		}
		if($kod==103)
		{
			$hata_kodu="Meşgul";
		}
		if($kod==104)
		{
			$hata_kodu="Hat Aktif Değil";
		}
		if($kod==105)
		{
			$hata_kodu="Hatalı Numara";
		}
		if($kod==106)
		{
			$hata_kodu="SMS red, Karaliste";
		}
		if($kod==111)
		{
			$hata_kodu="Zaman Aşımı";
		}
		if($kod==112)
		{
			$hata_kodu="Mobil Cihaz Sms Gönderimine Kapalı";
		}
		if($kod==113)
		{
			$hata_kodu="Mobil Cihaz Desteklemiyor";
		}
		if($kod==114)
		{
			$hata_kodu="önlendirme Başarısız";
		}
		if($kod==115)
		{
			$hata_kodu="Çağrı Yasaklandı";
		}
		if($kod==116)
		{
			$hata_kodu="Tanımlanamayan Abone";
		}
		if($kod==117)
		{
			$hata_kodu="Yasadışı Abone";
		}
		if($kod==119)
		{
			$hata_kodu="Sistemsel Hata";
		}


		return $hata_kodu;
	}
	 


	 //Sms Mesaj Kodları Function End


	 //Netgsm Api Sorgulama End
	
	
	$doviz_cek = mysql_query("select * from s_dovizler where durum='1' and aktif='1' ");
	$doviz_oku = mysql_fetch_assoc($doviz_cek);
	$doviz = $doviz_oku['sembol'];
	
	
	
	
	if(re('bireysel_gir') == "GİRİŞ")
	{
		if(re('bireysel_kullanici_adi') != "" and re('bireysel_sifre') != "")
		{
			$kullanici_cek = mysql_query("select * from kullanicilar where kullanici_adi='".re('bireysel_kullanici_adi')."' and sifre='".md5(sha1(re('bireysel_sifre')))."' and durum='1' and (grup='1' or yetki='9') ");
			if(mysql_num_rows($kullanici_cek) != 0)
			{
				$kullanici_oku = mysql_fetch_assoc($kullanici_cek);
				$_SESSION['b_kullanici'] = $kullanici_oku['id'];
				$_SESSION['b_bayi'] = 0;
				mysql_query("update kullanicilar set son_giris='".mktime()."' where id='".$kullanici_oku['id']."' ");
			}
			else
			{
				alert("Kullanıcı adı veya Şifre Yanlış");
			}
		}
		else
		{
			alert("Lütfen boş alan bırakmayınız");
		}
	}
	
	if(re('bayi_gir') == "GİRİŞ")
	{
		if(re('bayiKullanici') != "" and re('bayiSifre') != "")
		{
			$kullanici_cek = mysql_query("select * from kullanicilar where kullanici_adi='".re('bayiKullanici')."' and sifre='".md5(sha1(re('bayiSifre')))."' and durum='1' and (grup='2' or yetki='9') ");
			if(mysql_num_rows($kullanici_cek) != 0)
			{
				$kullanici_oku = mysql_fetch_assoc($kullanici_cek);
				
				if($kullanici_oku['bayi'] == 1)
				{
					$_SESSION['b_kullanici'] = $kullanici_oku['id'];
					$_SESSION['b_bayi'] = 1;
					mysql_query("update kullanicilar set son_giris='".mktime()."' where id='".$kullanici_oku['id']."' ");
				}
				else
				{
					alert("Bayi aktivasyonu henüz tamamlanmamış");
				}
			}
			else
			{
				alert("Kullanıcı adı veya Şifre Yanlış");
			}
		}
		else
		{
			alert("Lütfen boş alan bırakmayınız");
		}
	}
	
	
	
	
	$sepet_id = 0;
	if($_SESSION['b_kullanici'] == "")
	{
		$sepet_cek = mysql_query("select * from s_sepet where ip='".$_SERVER['REMOTE_ADDR']."' and kullanici_id='0' and durum='1' ");
		$sepet_oku = mysql_fetch_assoc($sepet_cek);
		
		if($sepet_oku['id'] != "")
		{
			$sepet_id = $sepet_oku['id'];
		}
		else
		{
			mysql_query("insert into s_sepet (ip,e_tarihi,durum) values ('".$_SERVER['REMOTE_ADDR']."','".mktime()."','1') ");
			$sepet_id = mysql_insert_id();
		}
	}
	else
	{
		$sepet_cek = mysql_query("select * from s_sepet where kullanici_id='".$_SESSION['b_kullanici']."' and durum='1' ");
		$sepet_oku = mysql_fetch_assoc($sepet_cek);
		
		if($sepet_oku['ip'] != $_SERVER['REMOTE_ADDR'])
		{
			mysql_query("update s_sepet set ip='".$_SERVER['REMOTE_ADDR']."' where id='".$sepet_oku['id']."' ");
		}
		
		if($sepet_oku['id'] != "")
		{
			$sepet_id = $sepet_oku['id'];
		}
		else
		{
			mysql_query("insert into s_sepet (kullanici_id,ip,e_tarihi,durum) values ('".$_SESSION['b_kullanici']."','".$_SERVER['REMOTE_ADDR']."','".mktime()."','1') ");
			$sepet_id = mysql_insert_id();
		}
		
		$kullanici_cek = mysql_query("select * from kullanicilar where id='".$_SESSION['b_kullanici']."' and durum='1' ");
		if(mysql_num_rows($kullanici_cek) == 0)
		{
			session_destroy();
		}
		else
		{
			$kullanici_oku = mysql_fetch_assoc($kullanici_cek);
		}
	}
	
	if(re('s_urun_sil') != "")
	{
		mysql_query("update s_sepet_urunler set durum='0', s_tarihi='".mktime()."' where id='".re('s_urun_sil')."' ");
		header("Location: index.php?page=sepetim_detay");
	}
	
	if(re('sepetguncelle') == "Hepsini Güncelle")
	{
		$s_urun_cek = mysql_query("select * from s_sepet_urunler where sepet_id='".$sepet_id."' and durum!='0' ORDER BY e_tarihi ASC, id ASC ");
		while($s_urun_oku = mysql_fetch_array($s_urun_cek))
		{
			mysql_query("update s_sepet_urunler set adet='".re('adet_'.$s_urun_oku['id'])."', g_tarihi='".mktime()."' where id='".$s_urun_oku['id']."' ");
		}
	}
	
	if(re('sepete_ekle') != "")
	{
		$sepet_cek = mysql_query("select * from s_sepet_urunler where urun_id='".re('sepete_ekle')."' and sepet_id='".$sepet_id."' and durum='1' ");
		if(mysql_num_rows($sepet_cek) == 0)
		{
			$urun_cek6 = mysql_query("select * from s_urunler where id='".re('sepete_ekle')."' and durum='1' ");
			$urun_oku6 = mysql_fetch_assoc($urun_cek6);
			
			if($_SESSION['b_bayi'] == 1)
			{
				$fiyatim = $urun_oku6['fiyat2'];
			}
			else
			{
				$fiyatim = $urun_oku6['fiyat'];
			}
			
			mysql_query("insert into s_sepet_urunler (urun_id,sepet_id,kullanici_id,ip,adet,stok_kod,fiyat,e_tarihi,durum) values ('".re('sepete_ekle')."','".$sepet_id."','".$_SESSION['b_kullanici']."','".$_SERVER['REMOTE_ADDR']."','1','','".doviz_getir($fiyatim,$urun_oku6['f_doviz'])."','".mktime()."','1') ");
		}
		else
		{
			$sepet_oku = mysql_fetch_assoc($sepet_cek);
			$s_adet = $sepet_oku['adet'] + 1;
			
			mysql_query("update s_sepet_urunler set adet='".$s_adet."', g_tarihi='".mktime()."' where id='".$sepet_oku['id']."' ");
		}
	}
	
	$t_urun_say = 0;
	$toplam_tutar = 0;
	$fiyati = 0;
	$sepet_urun_ceks = mysql_query("select * from s_sepet_urunler where sepet_id='".$sepet_id."' and durum!='0' ORDER BY e_tarihi ASC, id ASC ");
	while($sepet_urun_okus = mysql_fetch_array($sepet_urun_ceks))
	{
		$t_urun_say = $t_urun_say + $sepet_urun_okus['adet'];
		
		$urun_cek5 = mysql_query("select * from s_urunler where id='".$sepet_urun_okus['urun_id']."' and durum='1' ");
		$urun_oku5 = mysql_fetch_assoc($urun_cek5);
		
		if($_SESSION['b_bayi'] == 1)
		{
			$fiyatim = $urun_oku5['fiyat2'];
		}
		else
		{
			$fiyatim = $urun_oku5['fiyat'];
		}
		
		$fiyati = doviz_getir($fiyatim,$urun_oku5['f_doviz']) * $sepet_urun_okus['adet'];
		$toplam_tutar = $toplam_tutar + $fiyati;
		
		mysql_query("update s_sepet_urunler set fiyat='".doviz_getir($fiyatim,$urun_oku5['f_doviz'])."' where id='".$sepet_urun_okus['id']."' ");
	}
	$toplam_tutar = $toplam_tutar * 1.18;
	mysql_query("update s_sepet set genel_toplam='".$toplam_tutar."', g_tarihi='".mktime()."' where id='".$sepet_id."' ");
	
	$sepet_tutar = 0;
	$sepet_t_cek = mysql_query("select * from s_sepet where id='".$sepet_id."' ");
	$sepet_t_oku = mysql_fetch_assoc($sepet_t_cek);
	$sepet_tutar = $sepet_t_oku['genel_toplam'];
	
	
	
	if(re('yorumu') == "Yorum Ekle")
	{
		if($_SESSION['b_kullanici'] == "" and re('urun') == "")
		{
			alert("Lütfen Giriş yapınız");
		}
		else
		{
			if(re('baslik') == "" and re('yorum') == "")
			{
				alert("Lütfen Boş Alan Bırakmayınız..");
			}
			else
			{
				$kullanici_cek = mysql_query("select * from kullanicilar where id='".$_SESSION['b_kullanici']."' and durum='1' ");
				$kullanici_oku = mysql_fetch_assoc($kullanici_cek);
				
				$ek_durum = '2';
				if($kullanici_oku['yetki'] == 9) { $ek_durum = '1'; }
								
				mysql_query("insert into s_urunler_yorumlar (kullanici_id,urun_id,ip,baslik,yorum,e_tarihi,durum) values ('".$_SESSION['b_kullanici']."','".re('urun')."','".$_SERVER['REMOTE_ADDR']."','".re('baslik')."','".re('yorum')."','".mktime()."','".$ek_durum."') ");
				alert("Yorumunuz Eklenmiştir..");
				echo '<meta http-equiv="refresh" content="0;URL=?page=urundetay&urun='.re('urun').'">';
			}
		}
	}
	
	
	
	$site_cek = mysql_query("select * from site_ozellikleri where durum='1' ");
	$site_oku = mysql_fetch_assoc($site_cek);
	
	function GetIP(){
         if(getenv("HTTP_CLIENT_IP")) {
              $ip = getenv("HTTP_CLIENT_IP");
         } elseif(getenv("HTTP_X_FORWARDED_FOR")) {
              $ip = getenv("HTTP_X_FORWARDED_FOR");
              if (strstr($ip, ',')) {
                   $tmp = explode (',', $ip);
                   $ip = trim($tmp[0]);
              }
         } else {
         $ip = getenv("REMOTE_ADDR");
         }
         return $ip;
     }
	
	
	
	
	
	
	
	
	
	
	function doviz_getir($fiyat,$doviz)
	{
		if($doviz == 0)
		{
			$doviz_cek = mysql_query("select * from s_dovizler where aktif='1' ");
			$doviz_oku = mysql_fetch_assoc($doviz_cek);
		}
		else
		{
			$doviz_cek = mysql_query("select * from s_dovizler where id='".$doviz."' ");
			$doviz_oku = mysql_fetch_assoc($doviz_cek);
		}
		
		$sonuc = $fiyat * $doviz_oku['tutar'];
		
		return $sonuc;
	}
	
	
	$max_kat = 10;
	$max_uyum = 20;
	$max_urun = 18;
	
	use PHPMailer\PHPMailer\PHPMailer;
	//E-mail sabitleri
	const _HOST = "mail.eabilisim.net.tr";
	const _PORT = 587;
	const _USERNAME = "omer.aksungur@eabilisim.net.tr";
	const _PASSWORD = "Aksungur123.";


	function sendEmail($email, $name, $subject, $messageBody, $contactForm = false){

	  $mail = new PHPMailer();

	  $mail->isSMTP();
	  $mail->SMTPDebug = 0;
	  $mail->SMTPAuth = true;
	  $mail->Host = _HOST;
	  $mail->Port = _PORT;
	  $mail->Username = _USERNAME;
	  $mail->Password = _PASSWORD;
	  $mail->SetFrom(_USERNAME, _USERNAME);
		$mail->SMTPSecure = "tls";
		$mail->SMTPOptions = array(
			'ssl' => [
			  'verify_peer' => false,
			  'verify_peer_name' => false,
			  'allow_self_signed' => true,
	   ],
	  );


	  if($contactForm == true ) $mail->AddAddress(_USERNAME, _USERNAME);
	  else $mail->AddAddress($email, $name);


	  $mail->CharSet = 'UTF-8';
	  $mail->Subject = $subject;
	  $mail->Body = $messageBody;
	  $mail->SMTPKeepAlive = true;
	  $mail->IsHTML(true);
	  

	  $send = $mail->Send(); 
	  

	  if(!$send) return false;

	  return true;
	}

	function online_sorgulama()
	{
		    $bes_dakika_once=date('Y-m-d H:i:s', time() - 300);
			$kullanici_id=array();
			$online_guncelle=mysql_query("Select * from user where son_islem_zamani<= '".$bes_dakika_once."' ");
			while($online_cek=mysql_fetch_array($online_guncelle))
			{
			array_push($kullanici_id,$online_cek["id"]);
			}
			$toplam_sayi=count($kullanici_id);
			for($i=0;$i<$toplam_sayi;$i++)
			{
				$update_islem_zamani=mysql_query("update user set online_durum='0' where id='".$kullanici_id[$i]."'");
			}
	}
	function getOS() { 

		global $a1;

		$os_platform  = "Unknown OS Platform";

		$os_array     = array(
							  '/windows nt 10/i'      =>  'Windows 10',
							  '/windows nt 6.3/i'     =>  'Windows 8.1',
							  '/windows nt 6.2/i'     =>  'Windows 8',
							  '/windows nt 6.1/i'     =>  'Windows 7',
							  '/windows nt 6.0/i'     =>  'Windows Vista',
							  '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
							  '/windows nt 5.1/i'     =>  'Windows XP',
							  '/windows xp/i'         =>  'Windows XP',
							  '/windows nt 5.0/i'     =>  'Windows 2000',
							  '/windows me/i'         =>  'Windows ME',
							  '/win98/i'              =>  'Windows 98',
							  '/win95/i'              =>  'Windows 95',
							  '/win16/i'              =>  'Windows 3.11',
							  '/macintosh|mac os x/i' =>  'Mac OS X',
							  '/mac_powerpc/i'        =>  'Mac OS 9',
							  '/linux/i'              =>  'Linux',
							  '/ubuntu/i'             =>  'Ubuntu',
							  '/iphone/i'             =>  'iPhone',
							  '/ipod/i'               =>  'iPod',
							  '/ipad/i'               =>  'iPad',
							  '/android/i'            =>  'Android',
							  '/blackberry/i'         =>  'BlackBerry',
							  '/webos/i'              =>  'Mobile'
						);

		foreach ($os_array as $regex => $value)
			if (preg_match($regex, $a1))
				$os_platform = $value;

		return $os_platform;
	}

	function getBrowser() {

		global $a1;

		$browser        = "Unknown Browser";

		$browser_array = array(
								'/msie/i'      => 'Internet Explorer',
								'/firefox/i'   => 'Firefox',
								'/safari/i'    => 'Safari',
								'/chrome/i'    => 'Chrome',
								'/edge/i'      => 'Edge',
								'/opr/i'     => 'Opera',
								'/netscape/i'  => 'Netscape',
								'/maxthon/i'   => 'Maxthon',
								'/konqueror/i' => 'Konqueror',
								'/mobile/i'    => 'Handheld Browser'
						 );

		foreach ($browser_array as $regex => $value)
			if (preg_match($regex, $a1))
				$browser = $value;

		return $browser;
	}

	function chatRoomUnreadCount($room_id){
		$cek = mysql_query("select* from chat_messages where room_id = '".$room_id."' and gonderen_type = 1 and is_admin_see = 0");
		return mysql_num_rows($cek);
	}

	function okunmamis_mesaj_sayi($ilan_id){
		$cek = mysql_query("select * from chat_room where ilan_id = '".$ilan_id."' and status = 1");
		// $sayi = 0;
		// while($oku = mysql_fetch_object($cek)){
		// 	$sayi += chatRoomUnreadCount($oku->id);
		// }
		// return $sayi;
		return mysql_num_rows($cek);
	}

	

?>
