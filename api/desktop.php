<?php 

include_once '../ayar.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json");

$response = [];
$statusCode = 404;


if (re("action") == "get_count_teklif") {
	$teklif_cek = mysql_fetch_object(mysql_query("SELECT count(*) as TeklifCount FROM teklifler"));

	if($teklif_cek){
		//print_r($teklif_cek->TeklifCount);
		echo json_encode(["message" => "İşlem Başarılı","TeklifCount"=> $teklif_cek->TeklifCount , "status" => 200]);
	} else {
		echo json_encode(["message" => "İşlem Başarısız", "status" => 404]);
	}
}

if (re("action") == "get_count_bitmis_teklif") {
	//$teklif_cek = mysql_fetch_object(mysql_query("SELECT count(ilanlar.id) as TeklifCount  FROM ilanlar inner join teklifler on teklifler.ilan_id=ilanlar.id and teklifler.durum=1 WHERE CONCAT_WS('', ilanlar.ihale_tarihi, ilanlar.ihale_saati) <= '2021-10-08 11:36:00' and ilanlar.ihale_turu=1 GROUP by ilanlar.id"));

	$teklif_cek = mysql_num_rows(mysql_query("SELECT ilanlar.*  FROM ilanlar inner join teklifler on teklifler.ilan_id=ilanlar.id and teklifler.durum=1 WHERE CONCAT_WS(' ', ilanlar.ihale_tarihi, ilanlar.ihale_saati) <= '".date("Y-m-d H:i:s")."' and ilanlar.ihale_turu=1 GROUP by ilanlar.id"));

	if($teklif_cek > 0){
		//print_r($teklif_cek->TeklifCount);
		echo json_encode(["message" => "İşlem Başarılı","TeklifCount"=> $teklif_cek, "status" => 200]);
	} else {
		echo json_encode(["message" => "İşlem Başarısız", "status" => 404]);
	}
}

if (re("action") == "get_count_message") {
	$mesaj_cek = mysql_fetch_object(mysql_query("SELECT count(*) as MesajCount FROM mesajlar"));

	if($mesaj_cek){
		//print_r($teklif_cek->TeklifCount);
		echo json_encode(["message" => "İşlem Başarılı","MesajCount"=> $mesaj_cek->MesajCount , "status" => 200]);
	} else {
		echo json_encode(["message" => "İşlem Başarısız", "status" => 404]);
	}
}

if(re("action") == "last_teklif_detail"){

	$teklif_cek =mysql_fetch_object(mysql_query("select teklifler.id as Teklif_id, ilanlar.ihale_tarihi, ilanlar.ihale_tarihi, concat(ilanlar.ihale_tarihi,' ',ilanlar.ihale_saati) as ihale_bitis, teklifler.ilan_id, sigorta_ozellikleri.teklif_uyari_sesi as teklif_uyari_sesi,sigorta_ozellikleri.gold_uyari_sesi, sigorta_ozellikleri.gold_uyari_dakika from teklifler  inner join ilanlar on ilanlar.id=teklifler.ilan_id  inner join sigorta_ozellikleri on sigorta_ozellikleri.id=ilanlar.sigorta  ORDER BY teklifler.id DESC LIMIT 1"));



	$tarih1=strtotime("-".$teklif_cek->gold_uyari_dakika." minutes",strtotime($teklif_cek->ihale_bitis));

	$durum = "false";		
	if($teklif_cek->gold_uyari_dakika != 0) {
		if(date("Y-m-d H:i:s") > date("Y-m-d H:i:s",$tarih1)){
			$teklif_uyari_ses= $teklif_cek->gold_uyari_sesi;
			$durum = "true";
		}
	}
	if($durum == "false") {
		$teklif_uyari_ses= $teklif_cek->teklif_uyari_sesi;
		$durum = "true";
	}

	if($teklif_cek){

		echo json_encode([
			"message" => "İşlem Başarılı",
			"uyari"=> $durum ,
			"uyari_ses"=>$teklif_uyari_ses,
			"status" => 200
		]);
	} else {
		echo json_encode(["message" => "İşlem Başarısız", "status" => 500]);
	}
	
}

if(re("action") == "last_teklif_detail_gold"){

	$teklif_cek =mysql_fetch_object(mysql_query("
												select 
													teklifler.id as Teklif_id,
													ilanlar.ihale_tarihi,
													ilanlar.ihale_tarihi, 
													concat(ilanlar.ihale_tarihi,' ',ilanlar.ihale_saati) as ihale_bitis, 
													teklifler.ilan_id,
													sigorta_ozellikleri.teklif_uyari_sesi as teklif_uyari_sesi,
													sigorta_ozellikleri.gold_uyari_sesi, sigorta_ozellikleri.gold_uyari_dakika 
												from 
													teklifler 
												inner join 
													ilanlar on ilanlar.id=teklifler.ilan_id  
												inner join 
													sigorta_ozellikleri on sigorta_ozellikleri.id=ilanlar.sigorta 
												inner join
													user on user.id=teklifler.uye_id and user.paket=21
												ORDER BY
													teklifler.id DESC LIMIT 1
												"));



	$tarih1=strtotime("-".$teklif_cek->gold_uyari_dakika." minutes",strtotime($teklif_cek->ihale_bitis));

	$durum = "false";		
	if($teklif_cek->gold_uyari_dakika != 0) {
		if(date("Y-m-d H:i:s") > date("Y-m-d H:i:s",$tarih1)){
			$teklif_uyari_ses= $teklif_cek->gold_uyari_sesi;
			$durum = "true";
		}
	}

	if($teklif_cek){

		echo json_encode([
			"message" => "İşlem Başarılı",
			"uyari"=> $durum ,
			"uyari_ses"=>$teklif_uyari_ses,
			"status" => 200
		]);
	} else {
		echo json_encode(["message" => "İşlem Başarısız", "status" => 500]);
	}
	
}

?>