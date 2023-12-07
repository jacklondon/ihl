<?php 
   session_start();
   include('../../ayar.php');
    $token = $_SESSION['k_token'];
    if(!empty($token)){
      $uye_token = $token;
    }

    $gelen_id = re('id');
    $silinecek = re('q');
    $gidilecek = re('g');

    //Doğrudan Satış silme
if($silinecek ==  "dogrudan_sil"){
    mysql_query("DELETE FROM dogrudan_satisli_ilanlar WHERE id='".$gelen_id."'"); 
    header("Location:../dogrudan_satisli_ilanlarim.php");
}
if($silinecek ==  "dogrudan_yayindan_kaldir"){
    mysql_query("update dogrudan_satisli_ilanlar set durum=-4 WHERE id='".$gelen_id."'"); 
    header("Location:../dogrudan_satisli_ilanlarim.php");
}
    //İhale silme
if($silinecek ==  "ihale_sil"){
	$teklif_sorgu=mysql_query("select * from teklifler where durum=1 and ilan_id='".$gelen_id."'");
	$teklif_say=mysql_num_rows($teklif_sorgu);
	if($teklif_say!=0){
		echo '<script>alert("Teklif almış araç yayından kaldırılamaz")</script>';
		echo '<script>window.location.href = "../ihaledeki_ilanlarim.php";</script>';
	}else{
        mysql_query("update ilanlar set ihale_tarihi='".date("Y-m-d")."',ihale_saati='".date("00:00:00")."',durum='-4' WHERE id='".$gelen_id."'"); 
		header("Location:../ihaledeki_ilanlarim.php");
	}
    
}
    //Doğrduan Satışlı Resim
if($silinecek ==  "dogrudan_resim_sil"){
    mysql_query("DELETE FROM dogrudan_satisli_resimler WHERE id='".$gelen_id."'"); 
    header("Location:../dogrudan_duzenle.php?id=$gidilecek");
}
  

?>