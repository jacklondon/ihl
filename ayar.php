
<?php
error_reporting(1);
include("ayar_conf.php");
ob_start();
session_start();

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

$system_base_url = "https://ihale.pertdunyasi.com";
$baglan = mysql_connect($host, $kullanici, $sifre) or die("Mysql Baglanamadi");
mysql_select_db($vtadi, $baglan) or die("Vt Baglanamadi");
mysql_query("SET NAMES 'utf8'");
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET COLLATION_CONNECTION = 'utf8_turkish_ci' ");
date_default_timezone_set('Europe/Istanbul');
$sql_on_ek = "";


require_once "PhpMailler/PHPMailer.php";
require_once "PhpMailler/POP3.php";
require_once "PhpMailler/SMTP.php";
require_once "PhpMailler/OAuth.php";








$mesaj = "";
function alert($mesaj)
{
	echo '<script type="text/javascript">alert("' . $mesaj . '");</script>';
}

function sql_temizle($veri)
{
	$search = array(' OR ', 'AND ', '>', ' =', '--', 'xp_', 'like ', 'drop ', 'create ', 'modify ', 'rename ', 'alter ', 'cast ', 'join ', 'union ', 'where ', ' insert', 'delete ', 'update ', "and ", " or ", "LIKE ", "DROP ", "CREATE ", "MODIFY ", "RENA ME ", "ALTER ", "CAST ", "JOIN ", "UNION ", "WHERE ", "INSERT ", "DELETE ", "UPDATE ");
	$replace = array(' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ');
	$veri = str_replace($search, $replace, $veri);
	return mysql_real_escape_string($veri);
}

function re($veri)
{
	$search = array(' OR ', ' AND ', 'xp_', 'like ', 'drop ', 'create ', 'modify ', 'rename ', 'alter ', 'cast ', 'join ', 'union ', 'where ', 'insert ', 'delete ', 'update ', " and ", " or ", "LIKE ", "DROP ", "CREATE ", "MODIFY ", "RENA ME ", "ALTER ", "CAST ", "JOIN ", "UNION ", "WHERE ", "INSERT ", "DELETE ", "UPDATE ");
	$replace = array(' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ');
	$veri = str_replace($search, $replace, $_REQUEST[$veri]);
	return mysql_real_escape_string($veri);
}

function prear($arr)
{
	echo "<pre>";
	print_r($arr);
	echo "</pre>";
}
function response($data, $httpStatusCode = 200, $message = "İşlem Gerçekleştirildi")
{
	return ["message" => $message, "data" => $data, "status" => $httpStatusCode];
}

function yonlendir($sayfa)
{
	echo '<meta http-equiv="refresh" content="0;URL=' . $sayfa . '">';
}

function GetIP()
{
	if (getenv("HTTP_CLIENT_IP")) {
		$ip = getenv("HTTP_CLIENT_IP");
	} elseif (getenv("HTTP_X_FORWARDED_FOR")) {
		$ip = getenv("HTTP_X_FORWARDED_FOR");
		if (strstr($ip, ',')) {
			$tmp = explode(',', $ip);
			$ip = trim($tmp[0]);
		}
	} else {
		$ip = getenv("REMOTE_ADDR");
	}
	return $ip;
}


function buyukHarf($kelime)
{
	$cikti = "";
	$kelime_bol = explode(" ", $kelime);
	for ($i = 0; $i <= count($kelime_bol); $i++) {
		if ($kelime_bol[$i] != "") {
			$ilk = mb_strtoupper(mb_substr($kelime_bol[$i], 0, 1, "utf-8"), "utf-8");
			$diger = mb_strtolower(mb_substr($kelime_bol[$i], 1, null, "utf-8"), "utf-8");

			$cikti .= $ilk . $diger . " ";
		}
	}

	return $cikti;
}

function mesaj_tarih_duzenle($tarih)
{
	if ($tarih == "0000-00-00 00:00:00") {
		$yeni_tarih = "----";
	} else {
		$yeni_tarih = date("d/m/Y H:i:s", strtotime($tarih));
	}
	return $yeni_tarih;
}





function coklu_sms_gonder($user_id, $mesaj_icerik, $sms_kategori)
{

	$select = mysql_query("Select * from user where id='" . $user_id . "'");
	$veri_cek = mysql_fetch_assoc($select);

	$phone_number = trim($veri_cek["telefon"]);

	$trim_phone = telefon_formatla($phone_number);

	$bosluklu_mesaj = str_replace(' ', '%20', $mesaj_icerik);

	SMSgonderHttpGET($trim_phone, $bosluklu_mesaj, $sms_kategori);
}

//Sms Servisi Function End 

//Telefon Formatla Begın
function telefon_formatla($tel_no)
{
	$sol_karakter_sil = str_replace('(', '', $tel_no);
	$sag_karakter_sil = str_replace(')', '', $sol_karakter_sil);
	$tre_sil = str_replace('-', '', $sag_karakter_sil);

	return $tre_sil;
}
//Telefon Formatla End


//NetGsm Api Begın

function SMSgonderHttpGET($numara, $mesaj, $sms_kategori)
{

	$url = "https://api.netgsm.com.tr/sms/send/get/?usercode=8503030800&password=1397ea1479&gsmno=" . $numara . "&message=" . $mesaj . "&msgheader=EA%20Bilisim";


	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	$http_response = curl_exec($ch);
	$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

	if ($http_code != 200) {
		echo "$http_code $http_response\n";
		return false;
	}
	$balanceInfo = $http_response;
	//echo "MesajID : $balanceInfo";

	$date_time = Date("Y-m-d H:i:s");

	$insert = mysql_query("insert into sms_kaydet (sms_kategori_id,sms_icerigi,numara,e_tarihi,bulkid,durum) values ('" . $sms_kategori . "','" . $mesaj . "','" . $numara . "','" . $date_time . "','" . $balanceInfo . "','1') ");

	return $balanceInfo;
}

/*

     function ilanSehir($sehir_id)
     {
          $sehir_cek=mysql_query("select * from sehir where sehirID='".$sehir_id."'");
          $sehir_oku=mysql_fetch_assoc($sehir_cek);

          $gorsel='https://sistemal.net.tr/tasarim/tirnak_yonetim/uploads/cities/'.$sehir_oku['image_path'];

          if($sehir_oku['image_path']=="")
          {
               $gorsel='images/sistem/sehir_bos.png';
          }

          $sehir_bas='<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                         <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_sehir_dis" style="background-image:url(\''.$gorsel.'\')"></div>
                         <div class="card-body">
                              <h5 class="card-title text-center">'.$sehir_oku['sehiradiust'].'</h5>
                         </div>
                    </div>';

          return $sehir_bas;
     }

     function aracTipi($tip_id)
     {
          $arac_tip_cek=mysql_query("select * from vehicle_types where id='".$tip_id."'");
          $arac_tip_oku=mysql_fetch_assoc($arac_tip_cek);

          return $arac_tip_oku['name'];
     }

     function dorseTipi($tip_id)
     {
          $arac_tip_cek=mysql_query("select * from dorse_types where id='".$tip_id."'");
          $arac_tip_oku=mysql_fetch_assoc($arac_tip_cek);

          return $arac_tip_oku['name'];
     }

     function siteBilgi($bilgi)
     {
            $site_bilgileri_cek=mysql_query("select * from system_settings where settingKey='".$bilgi."'");
            $site_bilgileri_oku=mysql_fetch_assoc($site_bilgileri_cek);

            return $site_bilgileri_oku['settingValue'];
     }

     if($_SESSION['k_id']!="" and $_SESSION['k_id']!="0")
     {
          $giris_cek=mysql_query("select * from users where id='".$_SESSION['k_id']."'");
          $giris_oku=mysql_fetch_assoc($giris_cek);
     }
     */
//Faruk

function kullanici_grubu_cek($kullanici_token)
{
	$grup = 0;
	if ($kullanici_token != "") {
		$select = mysql_query("Select * from user where (user_token='" . $kullanici_token . "') or (kurumsal_user_token='" . $kullanici_token . "') ");
		// var_dump("Select * from user where (user_token='" . $kullanici_token . "') or (kurumsal_user_token='" . $kullanici_token . "') ");
		$kullanici_grubu = mysql_fetch_assoc($select);
		if ($kullanici_grubu["paket"] == 21 || $kullanici_grubu["paket"] != 1 || $kullanici_grubu["paket"] != 2 || $kullanici_grubu["paket"] != 22) {
			$grup = 1;
		} else if ($kullanici_grubu["paket"] == 22) {
			$grup = 2;
		} else if ($kullanici_grubu["paket"] == 1) {
			$grup = 3;
		} else if ($kullanici_grubu["paket"] == 2) {
			$grup = 4;
		} else {
			$grup = 0;
		}
		if($kullanici_grubu["paket"] == 1){
			$grup = 0;
		}
	} else {
		$grup = 0;
	}


	return $grup;
}

function kullanici_grubu_yeni($token)
{
	$cek = mysql_query("Select * from user where (user_token='" . $token . "') or (kurumsal_user_token='" . $token . "') ");
	$oku = mysql_fetch_object($cek);
	if (mysql_num_rows($cek) == 0) {
		return 0;
	} else {
		if ($oku->paket == 21) {
			return 1;
		} else {
			return 2;
		}
	}
}


$select = mysql_query("Select * from eski_ilan_sil where id='1'");
$veri_cek = mysql_fetch_assoc($select);

//ilanlari_sil($veri_cek["silme_tarihi"]);

function ilanlari_sil($tarih_baslangic)
{
	$select = mysql_query("select ilanlar.* from ilanlar inner join kazanilan_ilanlar on ilanlar.id != kazanilan_ilanlar.id where ilanlar.eklenme_zamani < '" . $tarih_baslangic . "'");
	while ($ilanlar = mysql_fetch_array($select)) {
		$statu = mysql_query("Select * from kazanilan_ilanlar where ilan_id='" . $ilanlar["id"] . "' ");
		$veri_cek = mysql_num_rows($statu);

		if ($veri_cek != 0) {
			$update = mysql_query("Update ilanlar set durum='2' where id='" . $ilanlar["id"] . "'");
		} else {
			null;
		}
	}
}

function SMSHttpGET()
{


	$url = "https://api.netgsm.com.tr/sms/report/?usercode=8503030800&password=1397ea1479&bulkid=123456&type=0&status=100&version=2";

	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	$http_response = curl_exec($ch);
	$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

	if ($http_code != 200) {
		echo "$http_code $http_response\n";
		return false;
	}
	$balanceInfo = $http_response;
	echo "MesajID : $balanceInfo";
	return $balanceInfo;
}

// SMSHttpGET();



///##### Mobilde Çalışıyor !!!!! ###### ///////
use PHPMailer\PHPMailer\PHPMailer;

const _HOST = "mail.eabilisim.net.tr";
const _PORT = 587;
const _USERNAME = "ugur.kabak@eabilisim.net.tr";
const _PASSWORD = "02DDA9fa.";


function sendEmail($email, $name, $subject, $messageBody, $contactForm = false)
{

	$mail = new PHPMailer();

	///##### Mobilde Çalışıyor !!!!! ###### ///////
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


	if ($contactForm == true) $mail->AddAddress(_USERNAME, _USERNAME);
	else $mail->AddAddress($email, $name);


	$mail->CharSet = 'UTF-8';
	$mail->Subject = $subject;
	$mail->Body = $messageBody;
	$mail->SMTPKeepAlive = true;
	$mail->IsHTML(true);



	$send = $mail->Send();


	if (!$send) return false;

	return true;
}
function para($parasi)
{
	$para = $parasi;
	$para_cikan = number_format($para, 0, ',', '.');
	return $para_cikan;
}
function money($price)
{
	return number_format($price, 0, ',', '.');
}
function full_tarih_duzenle($tarih)
{
	$yeni_tarih = date("d-m-Y H:i:s", strtotime($tarih));
	return $yeni_tarih;
}
function tarih_duzenle($tarih)
{
	$yeni_tarih = date("d-m-Y", strtotime($tarih));
	return $yeni_tarih;
}
function getOS()
{

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

function getBrowser()
{

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
		'/mobile/i'    => 'Handheld Browser',
		'/yabrowser/i'    => 'Yandex'
	);

	foreach ($browser_array as $regex => $value)
		if (preg_match($regex, $a1))
			$browser = $value;

	return $browser;
}
function gosterilme_durumu($ilan_id)
{
	$ilan_cek = mysql_query("SELECT * FROM ilanlar where id='" . $ilan_id . "' ");
	$ilan_oku = mysql_fetch_object($ilan_cek);
	$ilan_son_gosterilme = $ilan_oku->ihale_son_gosterilme;
	$suan = date("Y-m-d H:i:s");
	$gosterilme_sonuc = strtotime($ilan_son_gosterilme) - strtotime($suan);
	if ($ilan_getirilen > $ilan_oku->ihale_turu == "1") {
		$son_teklif = mysql_query("select * from teklifler where ilan_id='" . $ilan_id . "' and durum=1 order by teklif_zamani limit 1");
		$son_teklif_oku = mysql_fetch_object($son_teklif);
		$son_teklif_uye_id = $son_teklif_oku->uye_id;
	} else {
		$son_teklif = mysql_query("select * from teklifler where durum=1 and ilan_id='" . $ilan_id . "' group by uye_id order by teklif_zamani");
		while ($son_teklifler_oku = mysql_fetch_array($son_teklif)) {
			$uye_son_teklif = mysql_query("select * from teklifler where durum=1 and uye_id='" . $son_teklifler_oku["uye_id"] . "' and ilan_id='" . $ilan_id . "' order by teklif_zamani limit 1");
			$uye_son_teklif_oku = mysql_fetch_array($uye_son_teklif);
			if ($ilan_getirilen->son_teklif == $uye_son_teklif_oku["teklif"]) {
				$son_teklif_uye_id = $uye_son_teklif_oku["uye_id"];
			}
		}
	}
	if ($gosterilme_sonuc > 0 && $son_teklif_uye_id != '283') {
		$gosterilme = "true";
	} else {
		$gosterilme = "false";
	}

	return $gosterilme;
}

$ziyaretci_cek = mysql_query("select * from ziyaretciler where ip='" . getIP() . "'");
$ziyaretci_oku = mysql_fetch_object($ziyatetci_cek);
if (mysql_num_rows($ziyaretci_cek) == 0) {
	$a1 = $_SERVER['HTTP_USER_AGENT'];
	$ekle = mysql_query("insert into ziyaretciler (ip,isletim_sistemi,tarih,durum) values ('" . getIP() . "','" . getOS() . "','" . date("Y-m-d H:i:s") . "','1')");
} else {
	$a1 = $_SERVER['HTTP_USER_AGENT'];
	$guncelle = mysql_query("update ziyaretciler set tarih='" . date("Y-m-d H:i:s") . "',isletim_sistemi='" . getOS() . "' where ip='" . getIP() . "'");
}


function baslangic_komisyon($ilan_id, $verilen_teklif)
{
	$sorgu = mysql_query("select * from ilanlar where id='" . $ilan_id . "' ");
	$row = mysql_fetch_object($sorgu);

	if ($row->pd_hizmet > 0) {
		$hizmet_bedel = $row->pd_hizmet;
	} else {
		$hesaplama = $row->hesaplama;
		$sorgu = mysql_query("SELECT * FROM komisyon_oranlari WHERE sigorta_id = '" . $row->sigorta . "'");
		$oran = array();
		$standart_net = array();
		$luks_net = array();
		$standart_onbinde = array();
		$luks_onbinde = array();

		while ($sonuc = mysql_fetch_array($sorgu)) {
			array_push($oran, $sonuc['komisyon_orani']);
			array_push($standart_net, $sonuc['net']);
			array_push($luks_net, $sonuc['lux_net']);
			array_push($standart_onbinde, $sonuc['onbinde']);
			array_push($luks_onbinde, $sonuc['lux_onbinde']);
		}
		$oran_sayisi = count($oran);
		if ($hesaplama == "Standart") {
			$durum = false;
			for ($i = 0; $i < $oran_sayisi; $i++) {
				if ($verilen_teklif <= $oran[$i]) {
					$oran1 = $oran[$i];
					$standart_net1 = $standart_net[$i];
					$standart_onbinde1 = $standart_onbinde[$i];
					$ek_gider = $verilen_teklif * $standart_onbinde1 / 10000;
					$son_komisyon = ceil($ek_gider + $standart_net1);
					break;
				} else {
					$durum = true;
				}
			}
			$max_index = 0;
			for ($j = 0; $j < $oran_sayisi; $j++) {
				if ($oran[$j] == max($oran)) {
					$max_index = $j;
				}
			}
			if ($durum == true) {
				if ($verilen_teklif > max($oran)) {
					$oran1 = max($oran);
					$standart_net1 = $standart_net[$max_index];
					$standart_onbinde1 = (int)$standart_onbinde[$max_index];
					$ek_gider = $verilen_teklif * $standart_onbinde1 / 10000;
					$son_komisyon = ceil($ek_gider + $standart_net1);
				}
			}
		} else {
			$durum = false;
			for ($i = 0; $i < $oran_sayisi; $i++) {
				if ($verilen_teklif <= $oran[$i]) {
					$oran1 = $oran[$i];
					$luks_net1 = $luks_net[$i];
					$luks_onbinde1 = $luks_onbinde[$i];
					$ek_gider = $verilen_teklif * $luks_onbinde1 / 10000;
					$son_komisyon = ceil($ek_gider + $luks_net1);

					break;
				} else {
					$durum = true;
				}
			}
			$max_index = 0;
			for ($j = 0; $j < $oran_sayisi; $j++) {
				if ($oran[$j] == max($oran)) {
					$max_index = $j;
				}
			}
			if ($durum == true) {
				if ($verilen_teklif > max($oran)) {
					$oran1 = max($oran);
					$luks_net1 = $luks_net[$max_index];
					$luks_onbinde1 = (int)$luks_onbinde[$max_index];
					$ek_gider = $verilen_teklif * $luks_onbinde1 / 10000;
					$son_komisyon = ceil($ek_gider + $luks_net1);
				}
			}
		}

		$hizmet_bedel = $son_komisyon;
	}
	return $hizmet_bedel;
}

function chat_room_kontrol_ilan($ilan_id)
{
	$cek = mysql_query("select * from ilanlar where id = '".$ilan_id."'");
	if(mysql_num_rows($cek) != 0){
		return 1;
	}else{
		return 0;
	}
}

function chat_room_kontrol_dogrudan($ilan_id)
{
	$cek = mysql_query("select * from dogrudan_satisli_ilanlar where id = '".$ilan_id."'");
	if(mysql_num_rows($cek) != 0){
		return 1;
	}else{
		return 0;
	}
}


function okunmamis_mesaj_sayisi($room_id,$user_id){
	
	$sayi = 0;
	$cek = mysql_query("select * from chat_messages where room_id = '".$room_id."' and status = 1 and is_seen = 0");
	while($oku = mysql_fetch_object($cek)){
		if($oku->gonderen_type == 2){
			$sayi += 1;
		}else{
			if($oku->gonderen_id != $user_id){
				$sayi += 1;
			}
		}
	}
	return $sayi;
	
	// return mysql_num_rows(mysql_query("select * from chat_messages where room_id = '".$room_id."' and status = 1 and gonderen_id <> '".$user_id."' and is_seen = 0"));
}

function chat_arac_detay_ilan($ilan_id){
	$cek = mysql_query("select * from ilanlar where id = '".$ilan_id."'");
	// var_dump("select * from ilanlar where id = '".$ilan_id."'");
	$oku = mysql_fetch_object($cek);
	$marka_cek = mysql_query("select * from marka where markaID = '".$oku->marka."'");
	$marka_oku = mysql_fetch_object($marka_cek);
	$model_cek = mysql_query("select * from model where modelID = '".$oku->model."'");
	$model_oku = mysql_fetch_object($model_cek);
	$marka = $marka_oku->marka_adi;
	$model = $model_oku->model_adi;
	$tip = $oku->tip;
	$kapanis = full_tarih_duzenle($oku->ihale_tarihi." ".$oku->ihale_saati);
	$detay = $oku->model_yili." ".$marka." ".$model." ".$tip;

	if($oku->ihale_tarihi." ".$oku->ihale_saati > date('Y-m-d H:i:s')){
		$devam_ediyor = 1;
	}else{
		$devam_ediyor = 0;
	}

	$listingMap[] = [
		"devam_ediyor" => $devam_ediyor,
		"detay" => $detay,
		"kapanis" => $kapanis,
		"plaka" => $oku->plaka,
		"kod" => $oku->arac_kodu,
		"resim" => ilan_kapak_resim($ilan_id),
		"link" => "../arac_detay.php?id=".$ilan_id."&q=ihale"
	];
	return $listingMap;
}

function ilan_kapak_resim($ilan_id){
	$cek = mysql_query("SELECT * FROM ilan_resimler WHERE ilan_id = '".$ilan_id."'");
	$oku = mysql_fetch_object($cek);
	return "../images/".$oku->resim;
}


function chat_arac_detay_dogrudan($id){
	$cek = mysql_query("select * from dogrudan_satisli_ilanlar where id = '".$id."'");
	// var_dump("select * from dogrudan_satisli_ilanlar where id = '".$id."'");
	$oku = mysql_fetch_object($cek);
	$detay = $oku->model_yili." ".$oku->marka." ".$oku->model." ".$oku->uzanti;
	$kapanis = tarih_duzenle($oku->bitis_tarihi);
	if($oku->bitis_tarihi > date('Y-m-d H:i:s')){
		$devam_ediyor = 1;
	}else{
		$devam_ediyor = 0;
	}
	$listingMap[] = [
		"devam_ediyor" => $devam_ediyor,
		"detay" => $detay,
		"kapanis" => $kapanis,
		"plaka" => $oku->plaka,
		"kod" => $oku->arac_kodu,
		"resim" => dogrudan_kapak_resim($id),
		"link" => "../arac_detay.php?id=".$id."&q=dogrudan"
	];
	return $listingMap;
}

function dogrudan_kapak_resim($id){
	$cek = mysql_query("SELECT * FROM dogrudan_satisli_resimler WHERE ilan_id = '".$id."'");
	$oku = mysql_fetch_object($cek);
	return "../images/".$oku->resim;
}

function mesaj_alan_user($id){
	$cek = mysql_query("select * from user where id = '".$id."'");
	$oku = mysql_fetch_object($cek);
	if($oku->user_token != ""){
		$type = '<span class="badge badge-success">Bireysel Üye</span>';
		$ad = $oku->ad;
	}else{
		$type = '<span class="badge badge-warning">Kurumsal Üye</span>';
		$ad = $oku->unvan;
	}
	$listingMap[] = [
		"id" => $oku->id,
		"ad" => $ad,
		"type" => $type,
	];
	return $listingMap;
}

function mesaj_alan_admin($room_id){
	$cek = mysql_query("select * from chat_messages where room_id = '".$room_id."' and gonderen_type = 2 and status = 1");
	$oku = mysql_fetch_object($cek);
	$admin_id = $oku->gonderen_id;
	$admin_cek = mysql_query("select * from kullanicilar where id = '".$admin_id."'");
	$admin_oku = mysql_fetch_object($admin_cek);
	$type = '<span class="badge badge-danger">Admin</span>';
	$listingMap[] = [
		"id" => $admin_oku->id,
		"ad" => "Admin(".$admin_oku->kullanici_adi.")",
		"type" => $type
	];
	return $listingMap;
}


function user_chat_rooms($user_id)
{
	$cek = mysql_query("select * from chat_room where status = 1 and (gonderen_id = '".$user_id."' or alan_id = '".$user_id."') order by last_message_time desc");
	while($oku = mysql_fetch_object($cek)){
		if($oku->ilan_id <> 0){
			$arac_durum = chat_room_kontrol_ilan($oku->ilan_id);
			$arac_detay = chat_arac_detay_ilan($oku->ilan_id);
		}else{
			$arac_durum = chat_room_kontrol_dogrudan($oku->dogrudan_satis_id);
			$arac_detay = chat_arac_detay_dogrudan($oku->dogrudan_satis_id);
		}
		if($oku->alan_id != 0){
			if($oku->alan_id == $user_id){
				$user = mesaj_alan_user($oku->gonderen_id);
			}else{
				$user = mesaj_alan_user($oku->alan_id);
			}
			
		}else{
			$user = mesaj_alan_admin($oku->id);
		}
		if($arac_durum == 1){
			$listingMap[] = [
				"id" => $oku->id,
				"arac_detay" => $arac_detay,
				"ilan_id" => $oku->ilan_id,
				"dogrudan_satis_id" => $oku->dogrudan_satis_id,
				"gonderen_id" => $oku->gonderen_id,
				"alan_id" => $oku->alan_id,
				"last_mesage" => $oku->last_message,
				"last_message_time" => mesaj_tarih_duzenle($oku->last_message_time),
				"add_time" => mesaj_tarih_duzenle($oku->add_time),
				"status" => $oku->status,
				"unread_count" => okunmamis_mesaj_sayisi($oku->id,$user_id),
				"user" => $user
			];
		}
	}
	return $listingMap;
}

function mesaj_gonderen_user($id){
	$cek = mysql_query("select * from user where id = '".$id."'");
	$oku = mysql_fetch_object($cek);
	if($oku->user_token != ""){
		$type = '<span class="badge badge-success">Bireysel Üye</span>';
		$ad = $oku->ad;
	}else{
		$type = '<span class="badge badge-warning">Kurumsal Üye</span>';
		$ad = $oku->unvan;
	}
	$listingMap[] = [
		"id" => $oku->id,
		"ad" => $ad,
		"type" => $type,
	];
	return $listingMap;
}

function mesaj_gonderen_admin($id){
	$admin_cek = mysql_query("select * from kullanicilar where id = '".$id."'");
	$admin_oku = mysql_fetch_object($admin_cek);
	$type = '<span class="badge badge-danger">Admin</span>';
	$listingMap[] = [
		"id" => $admin_oku->id,
		"ad" => "Admin(".$admin_oku->kullanici_adi.")",
		"type" => $type
	];
	return $listingMap;
}

function chatRoomMessages($room_id,$user_id){
	$cek = mysql_query("select * from chat_messages where room_id = '".$room_id."' and status = 1 order by id asc");
	// var_dump("select * from chat_messages where room_id = '".$room_id."' and status = 1 order by id asc");
	// mysql_query("update chat_messages set is_seen = 1 where gonderen_id <> '".$user_id."' and room_id = '".$room_id."'");
	mysql_query("update chat_messages set is_seen = 1 where room_id = '".$room_id."' and gonderen_id <> '".$user_id."'");
	while($oku = mysql_fetch_object($cek)){
		if($oku->gonderen_type == 1){
			$gonderen = mesaj_gonderen_user($oku->gonderen_id);
		}else{
			$gonderen = mesaj_gonderen_admin($oku->gonderen_id);
		}
		$listingMap[] = [
			"id" => $oku->id,
			"room_id" => $oku->room_id,
			"gonderen_id" => $oku->gonderen_id,
			"gonderen_type" => $oku->gonderen_type,
			"gonderen" => $gonderen,
			"mesaj" => $oku->mesaj,
			"add_time" => mesaj_tarih_duzenle($oku->add_time),
			"status" => $oku->status,
			"is_seen" => $oku->is_seen,
			"is_admin_see" => $oku->is_admin_see
		];
	}
	return $listingMap;
}


function sendChatRoomMessage($room_id,$user_id,$message){
	$add_time = date('Y-m-d H:i:s');
	$sql = mysql_query("insert into chat_messages(room_id,gonderen_id,gonderen_type,mesaj,add_time,status) values ('".$room_id."','".$user_id."',1,'".$message."','".$add_time."',1)");
	if($sql){
		$listingMap[] = [
			"result" => "success",
			"message" => "Mesaj Gönderildi",
		];
	}else{
		$listingMap[] = [
			"result" => "error",
			"message" => "İşlem sırasında bir hata oluştu. Lütfen daha sonra tekrar deneyin"
		];
	}
	return $listingMap;
}

function deleteChatMessage($message_id){
	$add_time = date('Y-m-d H:i:s');
	$sql = mysql_query("update chat_messages set status = 2 where id = '".$message_id."'");
	if($sql){
		$listingMap[] = [
			"result" => "success",
			"message" => "Mesaj silindi",
		];
	}else{
		$listingMap[] = [
			"result" => "error",
			"message" => "İşlem sırasında bir hata oluştu. Lütfen daha sonra tekrar deneyin"
		];
	}
	return $listingMap;
}


function deleteChatRoom($room_id){
	$add_time = date('Y-m-d H:i:s');
	$sql = mysql_query("update chat_room set status = 2 where id = '".$room_id."'");
	if($sql){
		$listingMap[] = [
			"result" => "success",
			"message" => "Mesajlar silindi",
		];
	}else{
		$listingMap[] = [
			"result" => "error",
			"message" => "İşlem sırasında bir hata oluştu. Lütfen daha sonra tekrar deneyin"
		];
	}
	return $listingMap;
}

// $ilan_cek = mysql_query("select * from ilanlar where durum = 1");
$ilan_cek = mysql_query("select * from ilanlar");
while($ilan_oku = mysql_fetch_object($ilan_cek)){
	$tarih = $ilan_oku->ihale_tarihi." ".$ilan_oku->ihale_saati;
	$selectedTime = date('Y-m-d H:i:s');
	$endTime = strtotime("+5 minutes", strtotime($tarih));
	$sonuc = date('Y-m-d H:i:s',$endTime);
	mysql_query("update ilanlar set ihale_son_gosterilme = '".$sonuc."' where id = '".$ilan_oku->id."'");
}


function marka_getir($id){
	$cek = mysql_query("select * from marka where markaID = '".$id."'");
	$oku = mysql_fetch_object($cek);
	return $oku->marka_adi;
}

function ilan_kapak_resim_yeni($ilan_id){
	$cek = mysql_query("SELECT * FROM ilan_resimler WHERE ilan_id = '".$ilan_id."'");
	if(mysql_num_rows($cek) == 0){
		return "images/default.png";
	}else{
		$oku = mysql_fetch_object($cek);
		return "images/".$oku->resim;
	}	
}

function son_gezdiklerim($uye_id){
	$ip_adresi = getIP();
	if($uye_id != "" && $uye_id != 0){
		$uye_cek = mysql_query("select * from user where id = '".$uye_id."'");
		$uye_oku = mysql_fetch_object($uye_cek);
		$paket = $uye_oku->paket;
		$gezilen_cek = mysql_query("select * from gezilen_ilanlar where uye_id = '".$uye_id."' group by ilan_id order by add_time desc");
	}else{
		$paket = 2;
		$gezilen_cek = mysql_query("select * from gezilen_ilanlar where ip_adresi = '".$ip_adresi."' group by ilan_id order by add_time desc");
	}
	while($gezilen_oku = mysql_fetch_object($gezilen_cek)){
		$cek = mysql_query("select * from ilanlar where id = '".$gezilen_oku->ilan_id."'");
		$oku = mysql_fetch_object($cek);
		if($oku->durum == 1){
			$liste_durum = ilan_liste_durum($oku->sigorta,$paket);
			$listingMap[] = [
				"id" => $oku->id,
				"marka" => marka_getir($oku->marka),
				"model" => $oku->model,
				"arac_kodu" => $oku->arac_kodu,
				"tip" => $oku->tip,
				"model_yili" => $oku->model_yili,
				"son_teklif" => $oku->son_teklif,
				"ihale_tarihi" => $oku->ihale_tarihi,
				"ihale_saati" => $oku->ihale_saati,
				"durum" => $oku->durum,
				"ihale_turu" => $oku->ihale_turu,
				"sistem_sure_uzatma_durumu" => $oku->sistem_sure_uzatma_durumu,
				"sigorta" => $oku->sigorta,
				"ihale_son_gosterilme" => $oku->ihale_son_gosterilme,
				"resim" => ilan_kapak_resim_yeni($oku->id),
				"paket" => $paket,
				"liste_durum" => $liste_durum
			];
		}		
	}
	return $listingMap;
}



function ilan_liste_durum($sigorta_id,$paket_id){
	$cek = mysql_query("select * from sigortalar where sigorta_id = '".$sigorta_id."' and paket_id = '".$paket_id."'");
	$oku = mysql_fetch_object($cek);
	$listingMap[] = [
		"sigorta_id" => $oku->sigorta_id,
		"paket_id" => $oku->paket_id,
		"secilen_yetki_id" => $oku->secilen_yetki_id,
		"detay_gorur" => $oku->detay_gorur,
		"tarih" => $oku->tarih
	];
	return $listingMap;
}


function vitrin_ilanlari_new(){
	if($_SESSION['u_token'] != "" && $_SESSION['k_token'] == ""){
		$uye_token = $_SESSION['u_token'];
	   }elseif($_SESSION['u_token'] == "" && $_SESSION['k_token'] != ""){
		  $uye_token = $_SESSION['k_token'];
	   }else{
		$uye_token="";
	}
	if($uye_token == ""){
		$paket = 2;
	}else{
		$uye_cek = mysql_query("select * from user where user_token = '".$uye_token."' or kurumsal_user_token = '".$uye_token."'");
		$uye_oku = mysql_fetch_object($uye_cek);
		$paket = $uye_oku->paket;
	}

	$ilan_id_array = array();

	$sigorta_cek = mysql_query("select * from sigorta_ozellikleri where vitrin = 'on' and vitrin_adet > 0");
	while($sigorta_oku = mysql_fetch_object($sigorta_cek)){
		$vitrin_adet = $sigorta_oku->vitrin_adet;
		$sigorta_id = $sigorta_oku->id;
		$arac_cek = mysql_query("select * from ilanlar where durum = 1 and ihale_son_gosterilme >= '".date('Y-m-d H:i:s')."' and sigorta = '".$sigorta_id."' order by rand() limit ".$vitrin_adet);
		while($arac_oku = mysql_fetch_object($arac_cek)){
			array_push($ilan_id_array, $arac_oku->id);
			$liste_durum_sigorta = ilan_liste_durum($sigorta_id,$paket);
			if($liste_durum_sigorta[0]["secilen_yetki_id"] != 1){
				$listingMap[] = [
					"id" => $arac_oku->id,
					"marka" => marka_getir($arac_oku->marka),
					"model" => $arac_oku->model,
					"arac_kodu" => $arac_oku->arac_kodu,
					"tip" => $arac_oku->tip,
					"model_yili" => $arac_oku->model_yili,
					"son_teklif" => $arac_oku->son_teklif,
					"ihale_tarihi" => $arac_oku->ihale_tarihi,
					"ihale_saati" => $arac_oku->ihale_saati,
					"durum" => $arac_oku->durum,
					"ihale_turu" => $arac_oku->ihale_turu,
					"sistem_sure_uzatma_durumu" => $arac_oku->sistem_sure_uzatma_durumu,
					"sigorta" => $arac_oku->sigorta,
					"ihale_son_gosterilme" => $arac_oku->ihale_son_gosterilme,
					"resim" => ilan_kapak_resim_yeni($arac_oku->id),
					"paket" => $paket,
					"liste_durum" => $liste_durum_sigorta
				];
			}
		}
	}


	$cek = mysql_query("select * from ilanlar where id NOT IN ('".implode("', '",$ilan_id_array)."') and vitrin = 'on' and durum = 1 and ihale_son_gosterilme >= '".date('Y-m-d H:i:s')."' order by rand()");
	while($oku = mysql_fetch_object($cek)){
		$liste_durum = ilan_liste_durum($oku->sigorta,$paket);
		if($liste_durum[0]["secilen_yetki_id"] != 1){
			$listingMap[] = [
				"id" => $oku->id,
				"marka" => marka_getir($oku->marka),
				"model" => $oku->model,
				"arac_kodu" => $oku->arac_kodu,
				"tip" => $oku->tip,
				"model_yili" => $oku->model_yili,
				"son_teklif" => $oku->son_teklif,
				"ihale_tarihi" => $oku->ihale_tarihi,
				"ihale_saati" => $oku->ihale_saati,
				"durum" => $oku->durum,
				"ihale_turu" => $oku->ihale_turu,
				"sistem_sure_uzatma_durumu" => $oku->sistem_sure_uzatma_durumu,
				"sigorta" => $oku->sigorta,
				"ihale_son_gosterilme" => $oku->ihale_son_gosterilme,
				"resim" => ilan_kapak_resim_yeni($oku->id),
				"paket" => $paket,
				"liste_durum" => $liste_durum
			];
		}
	}
	return $listingMap;
}


function son_eklenen_ilanlar($limit){
	if($_SESSION['u_token'] != "" && $_SESSION['k_token'] == ""){
		$uye_token = $_SESSION['u_token'];
	}elseif($_SESSION['u_token'] == "" && $_SESSION['k_token'] != ""){
		$uye_token = $_SESSION['k_token'];
	}else{
		$uye_token="";
	}

	if($uye_token == ""){
		$paket = 2;
	}else{
		$uye_cek = mysql_query("select * from user where user_token = '".$uye_token."' or kurumsal_user_token = '".$uye_token."'");
		$uye_oku = mysql_fetch_object($uye_cek);
		$paket = $uye_oku->paket;
	}
	
	$cek = mysql_query("SELECT *,concat(ihale_tarihi,' ',ihale_saati) as ihale_son FROM ilanlar WHERE durum = 1 AND ihale_son_gosterilme >= '".date("Y-m-d H:i:s")."' ORDER BY eklenme_zamani DESC LIMIT $limit");
	while($oku = mysql_fetch_object($cek)){
		$liste_durum = ilan_liste_durum($oku->sigorta,$paket);
		if($liste_durum[0]["secilen_yetki_id"] != 1){
			$listingMap[] = [
				"id" => $oku->id,
				"marka" => marka_getir($oku->marka),
				"model" => $oku->model,
				"arac_kodu" => $oku->arac_kodu,
				"tip" => $oku->tip,
				"model_yili" => $oku->model_yili,
				"son_teklif" => $oku->son_teklif,
				"ihale_tarihi" => $oku->ihale_tarihi,
				"ihale_saati" => $oku->ihale_saati,
				"durum" => $oku->durum,
				"ihale_turu" => $oku->ihale_turu,
				"sistem_sure_uzatma_durumu" => $oku->sistem_sure_uzatma_durumu,
				"sigorta" => $oku->sigorta,
				"ihale_son_gosterilme" => $oku->ihale_son_gosterilme,
				"resim" => ilan_kapak_resim_yeni($oku->id),
				"liste_durum" => $liste_durum
			];
		}
	}
	return $listingMap;
}





?>