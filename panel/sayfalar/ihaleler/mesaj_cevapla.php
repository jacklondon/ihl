<?php
include('../../../ayar.php');
echo("deed");
if(re("action")=="cevapla"){
	$response=[];
	$response=["dened"=>"asdas"];
	/*$ilan_id=re("ilan_id");
	$gonderen_id=re("gonderen_id");
	$mesaj=re("mesaj");
	$eski_mesaj=re("eski_mesaj");
	$admin_id=re("admin_id");
	$uye_sorgu=mysql_query("select * from user where id='".$gonderen_id."' ");
	$uye_row=mysql_fetch_object($uye_sorgu);
	if($uye_row->user_token != ""){
		$gonderen_token=$uye_row->user_token;
	}else if($uye_row->kurumsal_user_token != ""){
		$gonderen_token=$uye_row->kurumsal_user_token;
	}
	$sorgu=mysql_query("select * from kullanicilar where id='".$admin_id."' ");
	$row=mysql_fetch_object($sorgu);
	$admin_token=$row->token;
	$eski_kaydet=mysql_query("insert into mesajlar
		(id,ilan_id,gonderen_id,alan_id,dogrudan_satis_id,mesaj,gonderme_zamani,gonderen_token,alan_token) 
		values
		(null,'".$ilan_id."','".$gonderen_id."','".$admin_id."','','".$eski_mesaj."','".date("Y-m-d H:i:s")."','".$gonderen_token."','".$admin_token."') ");
	$kaydet=mysql_query("insert into mesajlar
		(id,ilan_id,gonderen_id,alan_id,dogrudan_satis_id,mesaj,gonderme_zamani,gonderen_token,alan_token) 
		values
		(null,'".$ilan_id."','".$admin_id."','".$gonderen_id."','','".$mesaj."','".date("Y-m-d H:i:s")."','".$admin_token."','".$gonderen_token."') ");*/
	echo json_encode($response);
}

 ?>