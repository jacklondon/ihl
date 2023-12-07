<?php 
	session_start();
	$admin_id = $_SESSION['kid'];
	// $admin_id=139;
	$uye_cek = mysql_query("SELECT * FROM user WHERE temsilci_id = '".$admin_id."'");
	// $hepsini_cek = mysql_query("select ilanlar.*, mesajlar.gonderme_zamani from ilanlar inner join mesajlar on (mesajlar.ilan_id=ilanlar.id and mesajlar.gonderme_zamani>NOW() - INTERVAL 3 DAY) 
	// inner join user on (mesajlar.gonderen_token=user.user_token or mesajlar.gonderen_token=user.kurumsal_user_token ) where user.temsilci_id='".$admin_id."' group by ilanlar.id ");

	$hepsini_cek = mysql_query("select ilanlar.*, chat_room.last_message_time from ilanlar inner join chat_room on (chat_room.ilan_id=ilanlar.id and chat_room.last_message_time>NOW() - INTERVAL 3 DAY) 
	inner join user on chat_room.gonderen_id=user.id where user.temsilci_id='".$admin_id."' group by ilanlar.id order by chat_room.last_message_time desc");
	// var_dump("select ilanlar.*, chat_room.last_message_time from ilanlar inner join chat_room on (chat_room.ilan_id=ilanlar.id and chat_room.last_message_time>NOW() - INTERVAL 3 DAY) 
	// inner join user on chat_room.gonderen_id=user.id where user.temsilci_id='".$admin_id."' group by ilanlar.id order by chat_room.last_message_time desc");
?>
<style>
	table {
		border-collapse: collapse;
		border-spacing: 0;
		width: 100%;
		border: 1px solid #ddd;
	}
	.table tr td{
		font-size: 15px;
	}
	th, td {
		text-align: left;
		padding: 8px;
	}
	i{
		padding: 8px;
	}
</style>
<style>
	.blink {
		animation: blinker 0.9s linear infinite;
		color: red;
		font-size: 15px;
		font-weight: bold;
		font-family: sans-serif;
	}
	@keyframes blinker {  
		50% { opacity: 0; }
	}
</style>
<style>
	.yan {
		animation: blinker 0.9s linear infinite;
		color: red;
		font-size: 15px;
		font-weight: bold;
		font-family: sans-serif;
	}
	@keyframes blinker {  
		50% { opacity: 0; }
	}
</style>
<style>
    .modal {
		position: fixed;
		left: 0;
		top: 0;   
		margin: auto;   
		right: 0;
	}
</style>
	<form method="POST" action="?modul=ihaleler&sayfa=toplu_sil" >
		<?php
			$admin_yetki_cek=mysql_query("Select * from kullanicilar where id='".$admin_id."' ");
			$admin_yetki_oku=mysql_fetch_assoc($admin_yetki_cek);
			$yetkiler=$admin_yetki_oku["yetki"];
			$yetki_parcala=explode("|",$yetkiler);
			$btn='';
			$btn2='';
			/*
			if (in_array(2, $yetki_parcala) && in_array(1, $yetki_parcala) ) { 
			  $btn='<input type="submit" name="secili_sil" class="btn-danger" value="Seçili Olanları Sil">';
			  $btn2='<input type="submit" name="secili_uzat" class="btn-primary" value="Seçili Olanların Süresini Uzat">';
			}  else if(in_array(2, $yetki_parcala) && !in_array(1, $yetki_parcala)){
				$btn='<input type="submit" name="secili_sil" class="btn-danger" value="Seçili Olanları Sil">';
			    $btn2='';
			} else if(!in_array(2, $yetki_parcala) && in_array(1, $yetki_parcala)){
				$btn='';
			    $btn2='<input type="submit" name="secili_uzat" class="btn-primary" value="Seçili Olanların Süresini Uzat">';
			}   else{
				$btn='';
			    $btn2='';
			}
			*/
		?>    
		<style>
			a.disabled {
				pointer-events: none;
				cursor: default;
			}
		</style>  
		<style>
		.chec
		{
			opacity:1!important;
			z-index:999!important;
		}
		</style>
		<div style="overflow-x:auto; margin-top:20px;">
			<a><? echo $btn ?></a>
			<a><? echo $btn2 ?></a>
			<table class="table table-bordered" cellspacing="1" cellpadding="1" style="margin-top:10px;">
				<tr>
					<!-- <td><input type="checkbox" id="checkle" class="checkall btn btn-blue chec2" style="padding:20px;opacity:1!important; z-index:999;">Tümünü Seç</td> -->
					<td>Düzenle</td>
					<td>Görseller</td>
					<td>Kod</td>
					<td>Plaka</td>
					<td>İl Adı</td>
					<td>Detaylar</td>
					<td>Sayaç</td>
					<td>Kapanış Zamanı</td>
					<td>En Yüksek</td>
					<td>Teklifleri İncele</td>
					<td>Mesaj</td>
					<td>Favori</td>
					<td>Notlar</td>
					<td>Sigorta</td>
				</tr>
				<?php $sira=0; $ihale_say=mysql_num_rows($hepsini_cek);?>
					<input type="hidden" id="ihale_say" value="<?=$ihale_say ?>" />	
					<?php 
					$acik_mavi_array=array();
					$koyu_yesil_array=array();
					$acik_yesil_array=array();
					$toz_pembe_array=array();
					$krem_array=array(); 
					$hepsi_array=array();
					while($hepsini_oku = mysql_fetch_array($hepsini_cek)){
						$tablo_rengi="";
						$teklif_cek = mysql_query("SELECT * FROM teklifler WHERE ilan_id = '".$hepsini_oku['id']."' and durum=1 order by teklif_zamani desc limit 1");
						$teklifini_oku = mysql_fetch_assoc($teklif_cek);
						$teklifler=mysql_query("select * from teklifler where ilan_id='".$hepsini_oku['id']."' and durum=1 order by teklif_zamani desc ");
						$toplam_teklif = mysql_num_rows($teklifler);
						// $mesaj_cek = mysql_query("SELECT * FROM mesajlar WHERE ilan_id = '".$hepsini_oku['id']."' ");
						// $mesaj_sayi = mysql_num_rows($mesaj_cek);

						$mesaj_sayi = okunmamis_mesaj_sayi($hepsini_oku["id"]);


						$favori_cek = mysql_query("SELECT * FROM favoriler WHERE ilan_id = '".$hepsini_oku['id']."'");
						$favori_sayi = mysql_num_rows($favori_cek);
						$not_cek = mysql_query("SELECT * FROM ilan_notlari WHERE ilan_id = '".$hepsini_oku['id']."' group by tarih order by id desc");
						$not_sayi = mysql_num_rows($not_cek);
						$resim_cek = mysql_query("select * from ilan_resimler where ilan_id = '".$hepsini_oku['id']."'");
						$resim_oku = mysql_fetch_assoc($resim_cek);
						$resim = $resim_oku['resim'];
						if($resim==""){
							$resim="default.png";
						}
						$sigorta_cek = mysql_query("SELECT * FROM sigorta_ozellikleri WHERE id = '".$hepsini_oku['sigorta']."'");
						$sigorta_oku = mysql_fetch_assoc($sigorta_cek);
						$sigorta_adi = $sigorta_oku['sigorta_adi'];
						$suan = date('Y-m-d H:i:s');
						$newTime = date("Y-m-d H:i:s",strtotime(date("Y-m-d H:i:s")." -2 minutes"));
						$zaman_ilan = $hepsini_oku['ihale_tarihi']." ".$hepsini_oku['ihale_saati'];
						$yan = "";
						if($suan > $zaman_ilan){
							$yan = "yan";
						}
						$gelen_id = $hepsini_oku["id"];
						$marka_getir = mysql_query("select * from marka where markaID = '".$hepsini_oku['marka']."'");
						$marka_gel = mysql_fetch_assoc($marka_getir);
						$marka_adi = $marka_gel['marka_adi'];
						$style = '';
						$class  = '';
						if($hepsini_oku['profil']=="Hurda Belgeli"){
							$class = "blink" ;
							$color2 = "red !important";
						}elseif($hepsini_oku['profil']=="Plakalı"){         
							$color2 = "color:green;font-weight:bold";            
						}elseif($hepsini_oku['profil'] == "Çekme Belgeli/Pert Kayıtlı"){
							$color2 = "color:#000000";
						}else{
							$color2 = "color:#000000";
						}
						$statu_cek = mysql_query("SELECT * FROM kazanilan_ilanlar WHERE ilan_id = '".$gelen_id."'");
						$statu_oku = mysql_fetch_assoc($statu_cek);
						$teklifi_cek = mysql_query("SELECT * FROM teklifler WHERE durum=1 and ilan_id = '".$gelen_id."'");
						$teklifi_oku = mysql_fetch_assoc($teklifi_cek);
						$teklif_durum = $teklifi_oku['admin_teklif'];
						$teklif_fiyat = $teklifi_oku['teklif'];
						if($toplam_teklif>0){
							if($statu_oku['durum'] == "0" || $statu_oku['durum'] == "1" || $statu_oku['durum'] == "2" || $statu_oku['durum'] == "3" || $statu_oku['durum'] == "4"){
								$tablo_rengi = "#1b8d3d"; //Koyu yeşil
								$ihale_trh=$hepsini_oku["ihale_tarihi"];
								$ihale_st=$hepsini_oku["ihale_saati"];
								$srgl=mysql_query("select ilanlar.* from ilanlar inner join teklifler on teklifler.ilan_id=ilanlar.id  where ilanlar.durum=1 and ilanlar.ihale_tarihi='".$ihale_trh."' and ilanlar.ihale_saati='".$ihale_st."' and teklifler.durum=1 group by ilanlar.id");
								if(mysql_num_rows($srgl)>0){
									while($oku=mysql_fetch_object($srgl)){
										$mesaj_sayi = okunmamis_mesaj_sayi($oku->id);
										if(!in_array($oku->id,$hepsi_array) && $mesaj_sayi > 0){
											array_push($hepsi_array,$oku->id);
											$tarih_ihale=$oku->ihale_tarihi.' '. $oku->ihale_saati;
											$kapanis_zamani=date("d-m-Y H:i:s", strtotime($oku->ihale_tarihi. " ". $oku->ihale_saati));
											$teklifler=mysql_query("select * from teklifler where ilan_id='".$oku->id."' and durum=1 order by teklif_zamani desc ");
											$toplam_teklif = mysql_num_rows($teklifler);
											// $mesaj_cek = mysql_query("SELECT * FROM mesajlar WHERE ilan_id = '".$oku->id."' ");
											// $mesaj_sayi = mysql_num_rows($mesaj_cek);
											$favori_cek = mysql_query("SELECT * FROM favoriler WHERE ilan_id = '".$oku->id."'");
											$favori_sayi = mysql_num_rows($favori_cek);
											$not_cek = mysql_query("SELECT * FROM ilan_notlari WHERE ilan_id = '".$oku->id."' group by tarih order by id desc");
											$not_sayi = mysql_num_rows($not_cek);
											$sigorta_cek = mysql_query("SELECT * FROM sigorta_ozellikleri WHERE id = '".$oku->sigorta."'");
											$sigorta_oku = mysql_fetch_assoc($sigorta_cek);
											$sigorta_adi = $sigorta_oku['sigorta_adi'];
											$style = '';
											$class  = '';
											if($oku->profil=="Hurda Belgeli"){
												$class = "blink" ;
												//$color = "red";
											}elseif($oku->profil=="Plakalı"){         
												$color = "green";            
											}elseif($oku->profil == "Çekme Belgeli/Pert Kayıtlı"){
												$color = "#000000";
											}else{
												$color="#000000";
											}
											$resim_cek = mysql_query("select * from ilan_resimler where ilan_id = '".$oku->id."'");
											$resim_oku = mysql_fetch_assoc($resim_cek);
											$resim = $resim_oku['resim'];
											if($resim==""){
												$resim="default.png";
											}
											$stat_cek = mysql_query("SELECT * FROM kazanilan_ilanlar WHERE ilan_id = '".$oku->id."'");
											$stat_oku = mysql_fetch_assoc($stat_cek);
											$tklif_cek = mysql_query("SELECT * FROM teklifler WHERE durum=1 and ilan_id = '".$oku->id."' order by teklif_zamani desc limit 1");
											$tklifini_oku = mysql_fetch_assoc($tklif_cek);
											$tklif_sayi = mysql_num_rows($tklif_cek);
											if($stat_oku['durum'] == "0" || $stat_oku['durum'] == "1" || $stat_oku['durum'] == "2" || $stat_oku['durum'] == "3" || $stat_oku['durum'] == "4"){
												$tablo_rengi = "#1b8d3d"; //Koyu yeşil
											}else if($oku->ihale_turu == "1" && $tklifini_oku['uye_id']!='283'){
												if($oku->durum == "-1"){
														$tablo_rengi = "#00a2ff"; //Açık mavi       
												}else{
													$tablo_rengi = "#b4e61d"; //Açık yeşil      
												}
											}else if($oku->ihale_turu== "1" && $tklifini_oku['uye_id']=='283'){
												$tablo_rengi = "#feadc8";  //Toz pembe
											}else {
												if($oku->ihale_turu== "2" && $tklifini_oku['uye_id']=='283'){
													$tablo_rengi = "#ffd0b0";//Krem rengi
												}else{
													$tablo_rengi = "#ffd0b0";//Krem rengi
												}
											}
											if($tablo_rengi=="#1b8d3d"){
												$t_color="color:#fff;";
												$color="#fff";
											}else{
												$t_color="";
											}
											$arac_detaylari=$oku->model_yili." ".$marka_adi." ".$oku->model." ".$oku->tip." <span style='".$color2."' class='".$class."'>".$oku->profil."</span>";
											if($oku->link!=""){
												$sgrt_adi='<a style="'.$t_color.'" href="'.$oku->link.'" target="_blank">'.$sigorta_adi.'</a>';
											}else{
												$sgrt_adi='<span style="'.$t_color.'">'.$sigorta_adi.'</span>';
											}
											$td.='
												<tr id="tr_'.$oku->id.'" style="background-color: '.$tablo_rengi.'; '.$t_color.' ">
													<td><a target="_blank" href="?modul=ilanlar&sayfa=ilan_ekle&id='.$oku->id.'"><i class="fas fa-edit"></i></a></td>
													<td><a onclick="tabTrigger()" href="?modul=ilanlar&sayfa=ilan_ekle&id='.$oku->id.'" target="_blank"><img style="width: 50px; height:50px;" src="../images/'.$resim.'" alt=""></a></td>
													<td>'.$oku->arac_kodu.'</td>
													<td>'.$oku->plaka.'</td>    
													<td>'.$oku->sehir.'</td>  
													<td style="color:'.$color.';" ><a href="../arac_detay.php?id='.$oku->id.'&q=ihale" style="color:'.$color.';" target="_blank">'.$arac_detaylari.'</a></td>    
													<td id="sayac'.$sira.'">
														<input type="hidden" id="ihale_sayac'.$sira.'" value="'.$tarih_ihale.'" >
														<input type="hidden" id="id_'.$sira.'" value="'.$oku->id.'">
													</td> 
													<td>
														<a style="cursor: pointer;'.$t_color.'" class="view_guncelle kapanis_zamani'.$sira.'" id="'.$oku->id.'">'.$kapanis_zamani.'</a>
													</td>
													<td class="'.$yan.'"><a class="view_uyeye_teklif_ver" style="'.$t_color.'" id="sonteklif_'.$oku->id.'">'.money($oku->son_teklif).'₺</a></td>   
													<!-- <td class="'.$yan.'">'.$oku->son_teklif.'</td>     -->
													<input type="hidden" id="teklif_sayisi'.$sira.'" value="'.$toplam_teklif.'" >
													<td><a style="'.$t_color.'" class="view_ilan_teklifleri" id="teklifler_'.$oku->id.'"><i class="fas fa-gavel">'.$toplam_teklif.'</i></a></td>    
													<td><a style="'.$t_color.'" class="view_ilan_mesajlari" id="mesajlar_'.$oku->id.'"><i class="fas fa-envelope">'.$mesaj_sayi.'</i></a></td>    
													<td><a style="'.$t_color.'" class="view_ilan_favorileri" id="'.$oku->id.'"><i class="fas fa-heart">'.$favori_sayi.'</i></a></td>    
													<td><a style="'.$t_color.'" class="view_ilan_notlari" id="'.$oku->id.'"><i class="fas fa-align-justify">'.$not_sayi.'</i></a></td>    
													<td>'.$sgrt_adi.'</td>
												</tr>
											';
											$sira++;
										}
									}
								}else{
									if(!in_array($hepsini_oku['id'],$hepsi_array)){
										$tarih_ihale=$hepsini_oku['ihale_tarihi'].' '. $hepsini_oku['ihale_saati'];
										$kapanis_zamani=date("d-m-Y H:i:s", strtotime($hepsini_oku["ihale_tarihi"]. " ". $hepsini_oku["ihale_saati"]));
										if($tablo_rengi=="#1b8d3d"){
											$t_color="color:#fff;";
											$color="#fff";
										}else{
											$t_color="";
										}
										if($hepsini_oku["link"]!=""){
											$sgrt_adi='<a style="'.$t_color.'" href="'.$hepsini_oku["link"].'" target="_blank">'.$sigorta_adi.'</a>';
										}else{
											$sgrt_adi='<span style="'.$t_color.'">'.$sigorta_adi.'</span>';
										}
										$arac_detaylari=$hepsini_oku["model_yili"]." ".$marka_adi." ".$hepsini_oku['model']." ".$hepsini_oku['tip']." <span style='".$color2."' class='".$class."'>".$hepsini_oku['profil']."</span>";
										$td.='
											<tr id="tr_'.$hepsini_oku["id"].'" style="background-color: '.$tablo_rengi.';'.$t_color.'  ">
												<td><a target="_blank" href="?modul=ilanlar&sayfa=ilan_ekle&id='.$gelen_id.'"><i class="fas fa-edit"></i></a></td>
												<td><a onclick="tabTrigger()" href="?modul=ilanlar&sayfa=ilan_ekle&id='.$gelen_id.'" target="_blank"><img style="width: 50px; height:50px;" src="../images/'.$resim.'" alt=""></a></td>
												<td>'.$hepsini_oku["arac_kodu"].'</td>
												<td>'.$hepsini_oku["plaka"].'</td>    
												<td>'.$hepsini_oku['sehir'].'</td>  
												<td style="color:'.$color.';" ><a href="../arac_detay.php?id='.$gelen_id.'&q=ihale" style="color:'.$color.';"  target="_blank">'.$arac_detaylari.'</a></td>    
												<td id="sayac'.$sira.'">
													<input type="hidden" id="ihale_sayac'.$sira.'" value="'.$tarih_ihale.'" >
													<input type="hidden" id="id_'.$sira.'" value="'.$hepsini_oku['id'].'">
												</td> 
												<td>
													<a style="cursor: pointer;'.$t_color.'" class="view_guncelle kapanis_zamani'.$sira.'" id="'.$hepsini_oku['id'].'">'.$kapanis_zamani.'</a>
												</td>
												<td class="'.$yan.'"><a style="'.$t_color.'" class="view_uyeye_teklif_ver" id="sonteklif_'.$hepsini_oku['id'].'">'.money($hepsini_oku["son_teklif"]).'₺</a></td>   
												<!-- <td class="'.$yan.'">'.$hepsini_oku["son_teklif"].'</td>     -->
												<input type="hidden" id="teklif_sayisi'.$sira.'" value="'.$toplam_teklif.'" >
												<td><a style="'.$t_color.'" class="view_ilan_teklifleri" id="teklifler_'.$hepsini_oku['id'].'"><i class="fas fa-gavel">'.$toplam_teklif.'</i></a></td>    
												<td><a style="'.$t_color.'" class="view_ilan_mesajlari" id="mesajlar_'.$hepsini_oku['id'].'"><i class="fas fa-envelope">'.$mesaj_sayi.'</i></a></td>    
												<td><a style="'.$t_color.'" class="view_ilan_favorileri" id="'.$hepsini_oku['id'].'"><i class="fas fa-heart">'.$favori_sayi.'</i></a></td>    
												<td><a style="'.$t_color.'" class="view_ilan_notlari" id="'.$hepsini_oku['id'].'"><i class="fas fa-align-justify">'.$not_sayi.'</i></a></td>    
												<td>'.$sgrt_adi.'</td>  
											</tr>
										';
										$sira++;
									}
								}
							}else if($hepsini_oku['ihale_turu']== "1" && $teklifini_oku['uye_id']!='283'){
								if($hepsini_oku['durum']== "-1"){
									$tablo_rengi = "#00a2ff"; //Açık mavi  
									$ihale_trh=$hepsini_oku["ihale_tarihi"];
									$ihale_st=$hepsini_oku["ihale_saati"];
									$srgl=mysql_query("select ilanlar.* from ilanlar inner join teklifler on teklifler.ilan_id=ilanlar.id  where ilanlar.durum=1 and ilanlar.ihale_tarihi='".$ihale_trh."' and ilanlar.ihale_saati='".$ihale_st."' and teklifler.durum=1 group by ilanlar.id");							//
									if(mysql_num_rows($srgl)>0){
										while($oku=mysql_fetch_object($srgl)){
											$mesaj_sayi = okunmamis_mesaj_sayi($oku->id);
											if(!in_array($oku->id,$hepsi_array) && $mesaj_sayi > 0){
												array_push($hepsi_array,$oku->id);
												$tarih_ihale=$oku->ihale_tarihi.' '. $oku->ihale_saati;
												$kapanis_zamani=date("d-m-Y H:i:s", strtotime($oku->ihale_tarihi. " ". $oku->ihale_saati));
												$teklifler=mysql_query("select * from teklifler where ilan_id='".$oku->id."' and durum=1 order by teklif_zamani desc ");
												$toplam_teklif = mysql_num_rows($teklifler);
												// $mesaj_cek = mysql_query("SELECT * FROM mesajlar WHERE ilan_id = '".$oku->id."'");
												// $mesaj_sayi = mysql_num_rows($mesaj_cek);
												$mesaj_sayi = okunmamis_mesaj_sayi($oku->id);
												$favori_cek = mysql_query("SELECT * FROM favoriler WHERE ilan_id = '".$oku->id."'");
												$favori_sayi = mysql_num_rows($favori_cek);
												$not_cek = mysql_query("SELECT * FROM ilan_notlari WHERE ilan_id = '".$oku->id."' group by tarih order by id desc");
												$not_sayi = mysql_num_rows($not_cek);
												$sigorta_cek = mysql_query("SELECT * FROM sigorta_ozellikleri WHERE id = '".$oku->sigorta."'");
												$sigorta_oku = mysql_fetch_assoc($sigorta_cek);
												$sigorta_adi = $sigorta_oku['sigorta_adi'];
												$style = '';
												$class  = '';
												if($oku->profil=="Hurda Belgeli"){
													$class = "blink" ;
													$color2 = "color:red;";
												}elseif($oku->profil=="Plakalı"){         
													$color2 = "color:green;font-weight:bold";            
												}elseif($oku->profil == "Çekme Belgeli/Pert Kayıtlı"){
													$color2 = "color:#000000";
												}else{
													$color2 = "color:#000000";
												}
												$resim_cek = mysql_query("select * from ilan_resimler where ilan_id = '".$oku->id."'");
												$resim_oku = mysql_fetch_assoc($resim_cek);
												$resim = $resim_oku['resim'];
												if($resim==""){
													$resim="default.png";
												}
												$stat_cek = mysql_query("SELECT * FROM kazanilan_ilanlar WHERE ilan_id = '".$oku->id."'");
												$stat_oku = mysql_fetch_assoc($stat_cek);
												$tklif_cek = mysql_query("SELECT * FROM teklifler WHERE durum=1 and ilan_id = '".$oku->id."' order by teklif_zamani desc limit 1");
												$tklifini_oku = mysql_fetch_assoc($tklif_cek);
												$tklif_sayi = mysql_num_rows($tklif_cek);
												if($stat_oku['durum'] == "0" || $stat_oku['durum'] == "1" || $stat_oku['durum'] == "2" || $stat_oku['durum'] == "3" || $stat_oku['durum'] == "4"){
													$tablo_rengi = "#1b8d3d"; //Koyu yeşil
												}else if($oku->ihale_turu == "1" && $tklifini_oku['uye_id']!='283'){
													if($oku->durum == "-1"){
															$tablo_rengi = "#00a2ff"; //Açık mavi       
													}else{
														$tablo_rengi = "#b4e61d"; //Açık yeşil      
													}
												}else if($oku->ihale_turu== "1" && $tklifini_oku['uye_id']=='283'){
													$tablo_rengi = "#feadc8";  //Toz pembe
												}else {
													if($oku->ihale_turu== "2" && $tklifini_oku['uye_id']=='283'){
														$tablo_rengi = "#ffd0b0";//Krem rengi
													}else{
														$tablo_rengi = "#ffd0b0";//Krem rengi
													}
												}
												if($tablo_rengi=="#1b8d3d"){
													$t_color="color:#fff;";
													$color="#fff";
												}else{
													$t_color="";
												}
												$arac_detaylari=$oku->model_yili." ".$marka_adi." ".$oku->model." ".$oku->tip." <span style='".$color2."' class='".$class."'>".$oku->profil."</span>";
												if($oku->link!=""){
													$sgrt_adi='<a style="'.$t_color.'" href="'.$oku->link.'" target="_blank">'.$sigorta_adi.'</a>';
												}else{
													$sgrt_adi='<span style="'.$t_color.'">'.$sigorta_adi.'</span>';
												}
												$td.='
													<tr id="tr_'.$oku->id.'" style="background-color: '.$tablo_rengi.'; '.$t_color.' ">
														<td><a target="_blank" href="?modul=ilanlar&sayfa=ilan_ekle&id='.$oku->id.'"><i class="fas fa-edit"></i></a></td>
														<td><a onclick="tabTrigger()" href="?modul=ilanlar&sayfa=ilan_ekle&id='.$oku->id.'" target="_blank"><img style="width: 50px; height:50px;" src="../images/'.$resim.'" alt=""></a></td>
														<td>'.$oku->arac_kodu.'</td>
														<td>'.$oku->plaka.'</td>    
														<td>'.$oku->sehir.'</td>  
														<td style="color:'.$color.';" ><a href="../arac_detay.php?id='.$oku->id.'&q=ihale" style="color:'.$color.';" target="_blank">'.$arac_detaylari.'</a></td>    
														<td id="sayac'.$sira.'">
															<input type="hidden" id="ihale_sayac'.$sira.'" value="'.$tarih_ihale.'" >
															<input type="hidden" id="id_'.$sira.'" value="'.$oku->id.'">
														</td> 
														<td>
															<a style="cursor: pointer;'.$t_color.'" class="view_guncelle kapanis_zamani'.$sira.'" id="'.$oku->id.'">'.$kapanis_zamani.'</a>
														</td>
														<td class="'.$yan.'"><a class="view_uyeye_teklif_ver" style="'.$t_color.'" id="sonteklif_'.$oku->id.'">'.money($oku->son_teklif).'₺</a></td>   
														<!-- <td class="'.$yan.'">'.$oku->son_teklif.'</td>     -->
														<input type="hidden" id="teklif_sayisi'.$sira.'" value="'.$toplam_teklif.'" >
														<td><a style="'.$t_color.'" class="view_ilan_teklifleri" id="teklifler_'.$oku->id.'"><i class="fas fa-gavel">'.$toplam_teklif.'</i></a></td>    
														<td><a style="'.$t_color.'" class="view_ilan_mesajlari" id="mesajlar_'.$oku->id.'"><i class="fas fa-envelope">'.$mesaj_sayi.'</i></a></td>    
														<td><a style="'.$t_color.'" class="view_ilan_favorileri" id="'.$oku->id.'"><i class="fas fa-heart">'.$favori_sayi.'</i></a></td>    
														<td><a style="'.$t_color.'" class="view_ilan_notlari" id="'.$oku->id.'"><i class="fas fa-align-justify">'.$not_sayi.'</i></a></td>    
														<td>'.$sgrt_adi.'</td>    
													</tr>
												';
												$sira++;
											}
										}
									}else{
										if(!in_array($hepsini_oku['id'],$hepsi_array)){
											$tarih_ihale=$hepsini_oku['ihale_tarihi'].' '. $hepsini_oku['ihale_saati'];
											$kapanis_zamani=date("d-m-Y H:i:s", strtotime($hepsini_oku["ihale_tarihi"]. " ". $hepsini_oku["ihale_saati"]));
											if($tablo_rengi=="#1b8d3d"){
												$t_color="color:#fff;";
												$color="#fff";
											}else{
												$t_color="";
											}
											if($hepsini_oku["link"]!=""){
												$sgrt_adi='<a style="'.$t_color.'" href="'.$hepsini_oku["link"].'" target="_blank">'.$sigorta_adi.'</a>';
											}else{
												$sgrt_adi='<span style="'.$t_color.'">'.$sigorta_adi.'</span>';
											}
											$arac_detaylari=$hepsini_oku["model_yili"]." ".$marka_adi." ".$hepsini_oku['model']." ".$hepsini_oku['tip']." <span style='".$color2."' class='".$class."'>".$hepsini_oku['profil']."</span>";
											$td.='
												<tr id="tr_'.$hepsini_oku["id"].'" style="background-color: '.$tablo_rengi.';'.$t_color.'  ">
													<td><a target="_blank" href="?modul=ilanlar&sayfa=ilan_ekle&id='.$gelen_id.'"><i class="fas fa-edit"></i></a></td>
													<td><a onclick="tabTrigger()" href="?modul=ilanlar&sayfa=ilan_ekle&id='.$gelen_id.'" target="_blank"><img style="width: 50px; height:50px;" src="../images/'.$resim.'" alt=""></a></td>
													<td>'.$hepsini_oku["arac_kodu"].'</td>
													<td>'.$hepsini_oku["plaka"].'</td>    
													<td>'.$hepsini_oku['sehir'].'</td>  
													<td style="color:'.$color.';" ><a href="../arac_detay.php?id='.$gelen_id.'&q=ihale" style="color:'.$color.';"  target="_blank">'.$arac_detaylari.'</a></td>    
													<td id="sayac'.$sira.'">
														<input type="hidden" id="ihale_sayac'.$sira.'" value="'.$tarih_ihale.'" >
														<input type="hidden" id="id_'.$sira.'" value="'.$hepsini_oku['id'].'">
													</td> 
													<td>
														<a style="cursor: pointer;'.$t_color.'" class="view_guncelle kapanis_zamani'.$sira.'" id="'.$hepsini_oku['id'].'">'.$kapanis_zamani.'</a>
													</td>
													<td class="'.$yan.'"><a style="'.$t_color.'" class="view_uyeye_teklif_ver" id="sonteklif_'.$hepsini_oku['id'].'">'.money($hepsini_oku["son_teklif"]).'₺</a></td>   
													<!-- <td class="'.$yan.'">'.$hepsini_oku["son_teklif"].'</td>     -->
													<input type="hidden" id="teklif_sayisi'.$sira.'" value="'.$toplam_teklif.'" >
													<td><a style="'.$t_color.'" class="view_ilan_teklifleri" id="teklifler_'.$hepsini_oku['id'].'"><i class="fas fa-gavel">'.$toplam_teklif.'</i></a></td>    
													<td><a style="'.$t_color.'" class="view_ilan_mesajlari" id="mesajlar_'.$hepsini_oku['id'].'"><i class="fas fa-envelope">'.$mesaj_sayi.'</i></a></td>    
													<td><a style="'.$t_color.'" class="view_ilan_favorileri" id="'.$hepsini_oku['id'].'"><i class="fas fa-heart">'.$favori_sayi.'</i></a></td>    
													<td><a style="'.$t_color.'" class="view_ilan_notlari" id="'.$hepsini_oku['id'].'"><i class="fas fa-align-justify">'.$not_sayi.'</i></a></td>    
													<td>'.$sgrt_adi.'</td>    
												</tr>
											';
											$sira++;
										}
									}
								}else{
									$tablo_rengi = "#b4e61d"; //Açık yeşil    
									$ihale_trh=$hepsini_oku["ihale_tarihi"];
									$ihale_st=$hepsini_oku["ihale_saati"];
									$srgl=mysql_query("select ilanlar.* from ilanlar inner join teklifler on teklifler.ilan_id=ilanlar.id  where ilanlar.durum=1 and ilanlar.ihale_tarihi='".$ihale_trh."' and ilanlar.ihale_saati='".$ihale_st."' and teklifler.durum=1 group by ilanlar.id");							//
									if(mysql_num_rows($srgl)>0){
										while($oku=mysql_fetch_object($srgl)){
											$mesaj_sayi = okunmamis_mesaj_sayi($oku->id);
											if(!in_array($oku->id,$hepsi_array) && $mesaj_sayi > 0 ){
												array_push($hepsi_array,$oku->id);
												$tarih_ihale=$oku->ihale_tarihi.' '. $oku->ihale_saati;
												$kapanis_zamani=date("d-m-Y H:i:s", strtotime($oku->ihale_tarihi. " ". $oku->ihale_saati));
												$teklifler=mysql_query("select * from teklifler where ilan_id='".$oku->id."' and durum=1 order by teklif_zamani desc ");
												$toplam_teklif = mysql_num_rows($teklifler);											
												// $mesaj_cek = mysql_query("SELECT * FROM mesajlar WHERE ilan_id = '".$oku->id."' ");
												// $mesaj_sayi = mysql_num_rows($mesaj_cek);
												$mesaj_sayi = okunmamis_mesaj_sayi($oku->id);
												$favori_cek = mysql_query("SELECT * FROM favoriler WHERE ilan_id = '".$oku->id."'");
												$favori_sayi = mysql_num_rows($favori_cek);
												$not_cek = mysql_query("SELECT * FROM ilan_notlari WHERE ilan_id = '".$oku->id."' group by tarih order by id desc");
												$not_sayi = mysql_num_rows($not_cek);
												$sigorta_cek = mysql_query("SELECT * FROM sigorta_ozellikleri WHERE id = '".$oku->sigorta."'");
												$sigorta_oku = mysql_fetch_assoc($sigorta_cek);
												$sigorta_adi = $sigorta_oku['sigorta_adi'];
												$style = '';
												$class  = '';
												if($oku->profil=="Hurda Belgeli"){
													$class = "blink" ;
													$color2 = "color:red;";
												}elseif($oku->profil=="Plakalı"){         
													$color2 = "color:green;font-weight:bold";            
												}elseif($oku->profil == "Çekme Belgeli/Pert Kayıtlı"){
													$color2 = "color:#000000";
												}else{
													$color2 ="#000000";
												}
												$resim_cek = mysql_query("select * from ilan_resimler where ilan_id = '".$oku->id."'");
												$resim_oku = mysql_fetch_assoc($resim_cek);
												$resim = $resim_oku['resim'];
												if($resim==""){
													$resim="default.png";
												}
												$stat_cek = mysql_query("SELECT * FROM kazanilan_ilanlar WHERE ilan_id = '".$oku->id."'");
												$stat_oku = mysql_fetch_assoc($stat_cek);
												$tklif_cek = mysql_query("SELECT * FROM teklifler WHERE durum=1 and ilan_id = '".$oku->id."' order by teklif_zamani desc limit 1");
												$tklifini_oku = mysql_fetch_assoc($tklif_cek);
												$tklif_sayi = mysql_num_rows($tklif_cek);
												if($stat_oku['durum'] == "0" || $stat_oku['durum'] == "1" || $stat_oku['durum'] == "2" || $stat_oku['durum'] == "3" || $stat_oku['durum'] == "4"){
													$tablo_rengi = "#1b8d3d"; //Koyu yeşil
												}else if($oku->ihale_turu == "1" && $tklifini_oku['uye_id']!='283'){
													if($oku->durum == "-1"){
															$tablo_rengi = "#00a2ff"; //Açık mavi       
													}else{
														$tablo_rengi = "#b4e61d"; //Açık yeşil      
													}
												}else if($oku->ihale_turu== "1" && $tklifini_oku['uye_id']=='283'){
													$tablo_rengi = "#feadc8";  //Toz pembe
												}else {
													if($oku->ihale_turu== "2" && $tklifini_oku['uye_id']=='283'){
														$tablo_rengi = "#ffd0b0";//Krem rengi
													}else{
														$tablo_rengi = "#ffd0b0";//Krem rengi
													}
												}
												if($tablo_rengi=="#1b8d3d"){
													$t_color="color:#fff;";
													$color="#fff";
												}else{
													$t_color="";
												}
												$arac_detaylari=$oku->model_yili." ".$marka_adi." ".$oku->model." ".$oku->tip." <span style='".$color2."' class='".$class."'>".$oku->profil."</span>";
												if($oku->link!=""){
													$sgrt_adi='<a style="'.$t_color.'" href="'.$oku->link.'" target="_blank">'.$sigorta_adi.'</a>';
												}else{
													$sgrt_adi='<span style="'.$t_color.'">'.$sigorta_adi.'</span>';
												}
												$td.='
													<tr  id="tr_'.$oku->id.'" style="background-color: '.$tablo_rengi.'; '.$t_color.' ">
														<td><a target="_blank" href="?modul=ilanlar&sayfa=ilan_ekle&id='.$oku->id.'"><i class="fas fa-edit"></i></a></td>
														<td><a onclick="tabTrigger()" href="?modul=ilanlar&sayfa=ilan_ekle&id='.$oku->id.'" target="_blank"><img style="width: 50px; height:50px;" src="../images/'.$resim.'" alt=""></a></td>
														<td>'.$oku->arac_kodu.'</td>
														<td>'.$oku->plaka.'</td>    
														<td>'.$oku->sehir.'</td>  
														<td style="color:'.$color.';"><a href="../arac_detay.php?id='.$oku->id.'&q=ihale" style="color:'.$color.';" target="_blank">'.$arac_detaylari.'</a></td>    
														<td id="sayac'.$sira.'">
															<input type="hidden" id="ihale_sayac'.$sira.'" value="'.$tarih_ihale.'" >
															<input type="hidden" id="id_'.$sira.'" value="'.$oku->id.'">
														</td> 
														<td>
															<a style="cursor: pointer;'.$t_color.'" class="view_guncelle kapanis_zamani'.$sira.'" id="'.$oku->id.'">'.$kapanis_zamani.'</a>
														</td>
														<td class="'.$yan.'"><a class="view_uyeye_teklif_ver" style="'.$t_color.'" id="sonteklif_'.$oku->id.'">'.money($oku->son_teklif).'₺</a></td>   
														<!-- <td class="'.$yan.'">'.$oku->son_teklif.'</td>     -->
														<input type="hidden" id="teklif_sayisi'.$sira.'" value="'.$toplam_teklif.'" >
														<td><a style="'.$t_color.'" class="view_ilan_teklifleri" id="teklifler_'.$oku->id.'"><i class="fas fa-gavel">'.$toplam_teklif.'</i></a></td>    
														<td><a style="'.$t_color.'" class="view_ilan_mesajlari" id="mesajlar_'.$oku->id.'"><i class="fas fa-envelope">'.$mesaj_sayi.'</i></a></td>    
														<td><a style="'.$t_color.'" class="view_ilan_favorileri" id="'.$oku->id.'"><i class="fas fa-heart">'.$favori_sayi.'</i></a></td>    
														<td><a style="'.$t_color.'" class="view_ilan_notlari" id="'.$oku->id.'"><i class="fas fa-align-justify">'.$not_sayi.'</i></a></td>    
														<td>'.$sgrt_adi.'</td>    
													</tr>
												';
												$sira++;
											}
										}
									}else{
										if(!in_array($hepsini_oku['id'],$hepsi_array)){
											$tarih_ihale=$hepsini_oku['ihale_tarihi'].' '. $hepsini_oku['ihale_saati'];
											$kapanis_zamani=date("d-m-Y H:i:s", strtotime($hepsini_oku["ihale_tarihi"]. " ". $hepsini_oku["ihale_saati"]));
											if($tablo_rengi=="#1b8d3d"){
												$t_color="color:#fff;";
												$color="#fff";
											}else{
												$t_color="";
											}
											$arac_detaylari=$hepsini_oku["model_yili"]." ".$marka_adi." ".$hepsini_oku['model']." ".$hepsini_oku['tip']." <span style='".$color2."' class='".$class."'>".$hepsini_oku['profil']."</span>";
											if($hepsini_oku["link"]!=""){
												$sgrt_adi='<a style="'.$t_color.'" href="'.$hepsini_oku["link"].'" target="_blank">'.$sigorta_adi.'</a>';
											}else{
												$sgrt_adi='<span style="'.$t_color.'">'.$sigorta_adi.'</span>';
											}
											$td.='
												<tr id="tr_'.$hepsini_oku["id"].'" style="background-color: '.$tablo_rengi.';'.$t_color.'  ">
													<td><a target="_blank" href="?modul=ilanlar&sayfa=ilan_ekle&id='.$gelen_id.'"><i class="fas fa-edit"></i></a></td>
													<td><a onclick="tabTrigger()" href="?modul=ilanlar&sayfa=ilan_ekle&id='.$gelen_id.'" target="_blank"><img style="width: 50px; height:50px;" src="../images/'.$resim.'" alt=""></a></td>
													<td>'.$hepsini_oku["arac_kodu"].'</td>
													<td>'.$hepsini_oku["plaka"].'</td>    
													<td>'.$hepsini_oku['sehir'].'</td>  
													<td style="color:'.$color.';" ><a href="../arac_detay.php?id='.$gelen_id.'&q=ihale" style="color:'.$color.';"  target="_blank">'.$arac_detaylari.'</a></td>    
													<td id="sayac'.$sira.'">
														<input type="hidden" id="ihale_sayac'.$sira.'" value="'.$tarih_ihale.'" >
														<input type="hidden" id="id_'.$sira.'" value="'.$hepsini_oku['id'].'">
													</td> 
													<td>
														<a style="cursor: pointer;'.$t_color.'" class="view_guncelle kapanis_zamani'.$sira.'" id="'.$hepsini_oku['id'].'">'.$kapanis_zamani.'</a>
													</td>
													<td class="'.$yan.'"><a style="'.$t_color.'" class="view_uyeye_teklif_ver" id="sonteklif_'.$hepsini_oku['id'].'">'.money($hepsini_oku["son_teklif"]).'₺</a></td>   
													<!-- <td class="'.$yan.'">'.$hepsini_oku["son_teklif"].'</td>     -->
													<input type="hidden" id="teklif_sayisi'.$sira.'" value="'.$toplam_teklif.'" >
													<td><a style="'.$t_color.'" class="view_ilan_teklifleri" id="teklifler_'.$hepsini_oku['id'].'"><i class="fas fa-gavel">'.$toplam_teklif.'</i></a></td>    
													<td><a style="'.$t_color.'" class="view_ilan_mesajlari" id="mesajlar_'.$hepsini_oku['id'].'"><i class="fas fa-envelope">'.$mesaj_sayi.'</i></a></td>    
													<td><a style="'.$t_color.'" class="view_ilan_favorileri" id="'.$hepsini_oku['id'].'"><i class="fas fa-heart">'.$favori_sayi.'</i></a></td>    
													<td><a style="'.$t_color.'" class="view_ilan_notlari" id="'.$hepsini_oku['id'].'"><i class="fas fa-align-justify">'.$not_sayi.'</i></a></td>    
													<td>'.$sgrt_adi.'</td>    
												</tr>
											';
											$sira++;
										}
									}								
								}
							}else if($hepsini_oku['ihale_turu']== "1" && $teklifini_oku['uye_id']=='283'){
								$tablo_rengi = "#feadc8";  //Toz pembe
								$ihale_trh=$hepsini_oku["ihale_tarihi"];
								$ihale_st=$hepsini_oku["ihale_saati"];
								$srgl=mysql_query("select ilanlar.* from ilanlar inner join teklifler on teklifler.ilan_id=ilanlar.id  where ilanlar.durum=1 and ilanlar.ihale_tarihi='".$ihale_trh."' and ilanlar.ihale_saati='".$ihale_st."' and teklifler.durum=1 group by ilanlar.id");							//
								if(mysql_num_rows($srgl)>0){
									while($oku=mysql_fetch_object($srgl)){
										$mesaj_sayi = okunmamis_mesaj_sayi($oku->id);
										if(!in_array($oku->id,$hepsi_array) && $mesaj_sayi > 0){
											array_push($hepsi_array,$oku->id);
											$tarih_ihale=$oku->ihale_tarihi.' '. $oku->ihale_saati;
											$kapanis_zamani=date("d-m-Y H:i:s", strtotime($oku->ihale_tarihi. " ". $oku->ihale_saati));
											$teklifler=mysql_query("select * from teklifler where ilan_id='".$oku->id."' and durum=1 order by teklif_zamani desc ");
											$toplam_teklif = mysql_num_rows($teklifler);
											// $mesaj_cek = mysql_query("SELECT * FROM mesajlar WHERE ilan_id = '".$oku->id."' ");
											// $mesaj_sayi = mysql_num_rows($mesaj_cek);
											$mesaj_sayi = okunmamis_mesaj_sayi($oku->id);
											$favori_cek = mysql_query("SELECT * FROM favoriler WHERE ilan_id = '".$oku->id."'");
											$favori_sayi = mysql_num_rows($favori_cek);
											$not_cek = mysql_query("SELECT * FROM ilan_notlari WHERE ilan_id = '".$oku->id."' group by tarih order by id desc");
											$not_sayi = mysql_num_rows($not_cek);
											$sigorta_cek = mysql_query("SELECT * FROM sigorta_ozellikleri WHERE id = '".$oku->sigorta."'");
											$sigorta_oku = mysql_fetch_assoc($sigorta_cek);
											$sigorta_adi = $sigorta_oku['sigorta_adi'];
											$style = '';
											$class  = '';
											if($oku->profil=="Hurda Belgeli"){
												$class = "blink" ;
												$color2 = "color:red;";
											}elseif($oku->profil=="Plakalı"){         
												$color2 = "color:green;font-weight:bold";            
											}elseif($oku->profil == "Çekme Belgeli/Pert Kayıtlı"){
												$color2 = "color:#000000";
											}else{
												$color2 = "color:#000000";
											}
											$resim_cek = mysql_query("select * from ilan_resimler where ilan_id = '".$oku->id."'");
											$resim_oku = mysql_fetch_assoc($resim_cek);
											$resim = $resim_oku['resim'];
											if($resim==""){
												$resim="default.png";
											}
											$stat_cek = mysql_query("SELECT * FROM kazanilan_ilanlar WHERE ilan_id = '".$oku->id."'");
											$stat_oku = mysql_fetch_assoc($stat_cek);
											$tklif_cek = mysql_query("SELECT * FROM teklifler WHERE durum=1 and ilan_id = '".$oku->id."' order by teklif_zamani desc limit 1");
											$tklifini_oku = mysql_fetch_assoc($tklif_cek);
											$tklif_sayi = mysql_num_rows($tklif_cek);
											if($stat_oku['durum'] == "0" || $stat_oku['durum'] == "1" || $stat_oku['durum'] == "2" || $stat_oku['durum'] == "3" || $stat_oku['durum'] == "4"){
												$tablo_rengi = "#1b8d3d"; //Koyu yeşil
											}else if($oku->ihale_turu == "1" && $tklifini_oku['uye_id']!='283'){
												if($oku->durum == "-1"){
														$tablo_rengi = "#00a2ff"; //Açık mavi       
												}else{
													$tablo_rengi = "#b4e61d"; //Açık yeşil      
												}
											}else if($oku->ihale_turu== "1" && $tklifini_oku['uye_id']=='283'){
												$tablo_rengi = "#feadc8";  //Toz pembe
											}else {
												if($oku->ihale_turu== "2" && $tklifini_oku['uye_id']=='283'){
													$tablo_rengi = "#ffd0b0";//Krem rengi
												}else{
													$tablo_rengi = "#ffd0b0";//Krem rengi
												}
											}
											if($tablo_rengi=="#1b8d3d"){
												$t_color="color:#fff;";
												$color="#fff";
											}else{
												$t_color="";
											}
											$arac_detaylari=$oku->model_yili." ".$marka_adi." ".$oku->model." ".$oku->tip." <span style='".$color2."' class='".$class."'>".$oku->profil."</span>";
											if($oku->link!=""){
												$sgrt_adi='<a style="'.$t_color.'" href="'.$oku->link.'" target="_blank">'.$sigorta_adi.'</a>';
											}else{
												$sgrt_adi='<span style="'.$t_color.'">'.$sigorta_adi.'</span>';
											}
											$td.='
												<tr id="tr_'.$oku->id.'" style="background-color: '.$tablo_rengi.'; '.$t_color.' ">
													<td><a target="_blank" href="?modul=ilanlar&sayfa=ilan_ekle&id='.$oku->id.'"><i class="fas fa-edit"></i></a></td>
													<td><a onclick="tabTrigger()" href="?modul=ilanlar&sayfa=ilan_ekle&id='.$oku->id.'" target="_blank"><img style="width: 50px; height:50px;" src="../images/'.$resim.'" alt=""></a></td>
													<td>'.$oku->arac_kodu.'</td>
													<td>'.$oku->plaka.'</td>    
													<td>'.$oku->sehir.'</td>  
													<td style="color:'.$color.';" ><a href="../arac_detay.php?id='.$oku->id.'&q=ihale" style="color:'.$color.';" target="_blank">'.$arac_detaylari.'</a></td>    
													<td id="sayac'.$sira.'">
														<input type="hidden" id="ihale_sayac'.$sira.'" value="'.$tarih_ihale.'" >
														<input type="hidden" id="id_'.$sira.'" value="'.$oku->id.'">
													</td> 
													<td>
														<a style="cursor: pointer;'.$t_color.'" class="view_guncelle kapanis_zamani'.$sira.'" id="'.$oku->id.'">'.$kapanis_zamani.'</a>
													</td>
													<td class="'.$yan.'"><a class="view_uyeye_teklif_ver" style="'.$t_color.'" id="sonteklif_'.$oku->id.'">'.money($oku->son_teklif).'₺</a></td>   
													<!-- <td class="'.$yan.'">'.$oku->son_teklif.'</td>     -->
													<input type="hidden" id="teklif_sayisi'.$sira.'" value="'.$toplam_teklif.'" >
													<td><a style="'.$t_color.'" class="view_ilan_teklifleri" id="teklifler_'.$oku->id.'"><i class="fas fa-gavel">'.$toplam_teklif.'</i></a></td>    
													<td><a style="'.$t_color.'" class="view_ilan_mesajlari" id="mesajlar_'.$oku->id.'"><i class="fas fa-envelope">'.$mesaj_sayi.'</i></a></td>    
													<td><a style="'.$t_color.'" class="view_ilan_favorileri" id="'.$oku->id.'"><i class="fas fa-heart">'.$favori_sayi.'</i></a></td>    
													<td><a style="'.$t_color.'" class="view_ilan_notlari" id="'.$oku->id.'"><i class="fas fa-align-justify">'.$not_sayi.'</i></a></td>    
													<td>'.$sgrt_adi.'</td>    
												</tr>
											';
											$sira++;
										}
									}
								}else{
									if(!in_array($hepsini_oku['id'],$hepsi_array)){
										$arac_detaylari=$hepsini_oku["model_yili"]." ".$marka_adi." ".$hepsini_oku['model']." ".$hepsini_oku['tip']." <span style='".$color2."' class='".$class."'>".$hepsini_oku['profil']."</span>";
										$tarih_ihale=$hepsini_oku['ihale_tarihi'].' '. $hepsini_oku['ihale_saati'];
										$kapanis_zamani=date("d-m-Y H:i:s", strtotime($hepsini_oku["ihale_tarihi"]. " ". $hepsini_oku["ihale_saati"]));
										if($tablo_rengi=="#1b8d3d"){
											$t_color="color:#fff;";
											$color="#fff";
										}else{
											$t_color="";
										}
										if($hepsini_oku["link"]!=""){
											$sgrt_adi='<a style="'.$t_color.'" href="'.$hepsini_oku["link"].'" target="_blank">'.$sigorta_adi.'</a>';
										}else{
											$sgrt_adi='<span style="'.$t_color.'">'.$sigorta_adi.'</span>';
										}
										$td.='
											<tr id="tr_'.$hepsini_oku["id"].'" style="background-color: '.$tablo_rengi.';'.$t_color.'  ">
												<td><a target="_blank" href="?modul=ilanlar&sayfa=ilan_ekle&id='.$gelen_id.'"><i class="fas fa-edit"></i></a></td>
												<td><a onclick="tabTrigger()" href="?modul=ilanlar&sayfa=ilan_ekle&id='.$gelen_id.'" target="_blank"><img style="width: 50px; height:50px;" src="../images/'.$resim.'" alt=""></a></td>
												<td>'.$hepsini_oku["arac_kodu"].'</td>
												<td>'.$hepsini_oku["plaka"].'</td>    
												<td>'.$hepsini_oku['sehir'].'</td>  
												<td style="color:'.$color.';" ><a href="../arac_detay.php?id='.$gelen_id.'&q=ihale" style="color:'.$color.';"  target="_blank">'.$arac_detaylari.'</a></td>    
												<td id="sayac'.$sira.'">
													<input type="hidden" id="ihale_sayac'.$sira.'" value="'.$tarih_ihale.'" >
													<input type="hidden" id="id_'.$sira.'" value="'.$hepsini_oku['id'].'">
												</td> 
												<td>
													<a style="cursor: pointer;'.$t_color.'" class="view_guncelle kapanis_zamani'.$sira.'" id="'.$hepsini_oku['id'].'">'.$kapanis_zamani.'</a>
												</td>
												<td class="'.$yan.'"><a style="'.$t_color.'" class="view_uyeye_teklif_ver" id="sonteklif_'.$hepsini_oku['id'].'">'.money($hepsini_oku["son_teklif"]).'₺</a></td>   
												<!-- <td class="'.$yan.'">'.$hepsini_oku["son_teklif"].'</td>     -->
												<input type="hidden" id="teklif_sayisi'.$sira.'" value="'.$toplam_teklif.'" >
												<td><a style="'.$t_color.'" class="view_ilan_teklifleri" id="teklifler_'.$hepsini_oku['id'].'"><i class="fas fa-gavel">'.$toplam_teklif.'</i></a></td>    
												<td><a style="'.$t_color.'" class="view_ilan_mesajlari" id="mesajlar_'.$hepsini_oku['id'].'"><i class="fas fa-envelope">'.$mesaj_sayi.'</i></a></td>    
												<td><a style="'.$t_color.'" class="view_ilan_favorileri" id="'.$hepsini_oku['id'].'"><i class="fas fa-heart">'.$favori_sayi.'</i></a></td>    
												<td><a style="'.$t_color.'" class="view_ilan_notlari" id="'.$hepsini_oku['id'].'"><i class="fas fa-align-justify">'.$not_sayi.'</i></a></td>    
												<td>'.$sgrt_adi.'</td>    
											</tr>
										';
										$sira++;
									}
								}
							}else {
								if($hepsini_oku['ihale_turu']== "2" && $teklifini_oku['uye_id']=='283'){
									$tablo_rengi = "#ffd0b0";//Krem rengi
									$ihale_trh=$hepsini_oku["ihale_tarihi"];
									$ihale_st=$hepsini_oku["ihale_saati"];
									$srgl=mysql_query("select ilanlar.* from ilanlar inner join teklifler on teklifler.ilan_id=ilanlar.id  where ilanlar.durum=1 and ilanlar.ihale_tarihi='".$ihale_trh."' and ilanlar.ihale_saati='".$ihale_st."' and teklifler.durum=1 group by ilanlar.id");							//
									if(mysql_num_rows($srgl)>0){
										while($oku=mysql_fetch_object($srgl)){
											$mesaj_sayi = okunmamis_mesaj_sayi($oku->id);
											if(!in_array($oku->id,$hepsi_array) && $mesaj_sayi > 0){
												array_push($hepsi_array,$oku->id);
												$tarih_ihale=$oku->ihale_tarihi.' '. $oku->ihale_saati;
												$kapanis_zamani=date("d-m-Y H:i:s", strtotime($oku->ihale_tarihi. " ". $oku->ihale_saati));
												$teklifler=mysql_query("select * from teklifler where ilan_id='".$oku->id."' and durum=1 order by teklif_zamani desc ");
												$toplam_teklif = mysql_num_rows($teklifler);
												// $mesaj_cek = mysql_query("SELECT * FROM mesajlar WHERE ilan_id = '".$oku->id."' ");
												// $mesaj_sayi = mysql_num_rows($mesaj_cek);
												$mesaj_sayi = okunmamis_mesaj_sayi($oku->id);
												$favori_cek = mysql_query("SELECT * FROM favoriler WHERE ilan_id = '".$oku->id."'");
												$favori_sayi = mysql_num_rows($favori_cek);
												$not_cek = mysql_query("SELECT * FROM ilan_notlari WHERE ilan_id = '".$oku->id."' group by tarih order by id desc");
												$not_sayi = mysql_num_rows($not_cek);
												$sigorta_cek = mysql_query("SELECT * FROM sigorta_ozellikleri WHERE id = '".$oku->sigorta."'");
												$sigorta_oku = mysql_fetch_assoc($sigorta_cek);
												$sigorta_adi = $sigorta_oku['sigorta_adi'];

												$style = '';
												$class  = '';
												if($oku->profil=="Hurda Belgeli"){
													$class = "blink" ;
													$color2 = "color:red;";
												}elseif($oku->profil=="Plakalı"){         
													$color2 = "color:green;font-weight:bold";            
												}elseif($oku->profil == "Çekme Belgeli/Pert Kayıtlı"){
													$color2 = "color:#000000";
												}else{
													$color2 = "color:#000000";
												}
												$resim_cek = mysql_query("select * from ilan_resimler where ilan_id = '".$oku->id."'");
												$resim_oku = mysql_fetch_assoc($resim_cek);
												$resim = $resim_oku['resim'];
												if($resim==""){
													$resim="default.png";
												}
												$stat_cek = mysql_query("SELECT * FROM kazanilan_ilanlar WHERE ilan_id = '".$oku->id."'");
												$stat_oku = mysql_fetch_assoc($stat_cek);
												$tklif_cek = mysql_query("SELECT * FROM teklifler WHERE durum=1 and ilan_id = '".$oku->id."' order by teklif_zamani desc limit 1");
												$tklifini_oku = mysql_fetch_assoc($tklif_cek);
												$tklif_sayi = mysql_num_rows($tklif_cek);
												if($stat_oku['durum'] == "0" || $stat_oku['durum'] == "1" || $stat_oku['durum'] == "2" || $stat_oku['durum'] == "3" || $stat_oku['durum'] == "4"){
													$tablo_rengi = "#1b8d3d"; //Koyu yeşil
												}else if($oku->ihale_turu == "1" && $tklifini_oku['uye_id']!='283'){
													if($oku->durum == "-1"){
															$tablo_rengi = "#00a2ff"; //Açık mavi       
													}else{
														$tablo_rengi = "#b4e61d"; //Açık yeşil      
													}
												}else if($oku->ihale_turu== "1" && $tklifini_oku['uye_id']=='283'){
													$tablo_rengi = "#feadc8";  //Toz pembe
												}else {
													if($oku->ihale_turu== "2" && $tklifini_oku['uye_id']=='283'){
														$tablo_rengi = "#ffd0b0";//Krem rengi
													}else{
														$tablo_rengi = "#ffd0b0";//Krem rengi
													}
												}
												if($tablo_rengi=="#1b8d3d"){
													$t_color="color:#fff;";
													$color="#fff";
												}else{
													$t_color="";
												}
												$arac_detaylari=$oku->model_yili." ".$marka_adi." ".$oku->model." ".$oku->tip." <span style='".$color2."' class='".$class."'>".$oku->profil."</span>";
												
												if($oku->link!=""){
													$sgrt_adi='<a style="'.$t_color.'" href="'.$oku->link.'" target="_blank">'.$sigorta_adi.'</a>';
												}else{
													$sgrt_adi='<span style="'.$t_color.'">'.$sigorta_adi.'</span>';
												}
												$td.='
													<tr id="tr_'.$oku->id.'" style="background-color: '.$tablo_rengi.'; '.$t_color.' ">
														<td><a target="_blank" href="?modul=ilanlar&sayfa=ilan_ekle&id='.$oku->id.'"><i class="fas fa-edit"></i></a></td>
														<td><a onclick="tabTrigger()" href="?modul=ilanlar&sayfa=ilan_ekle&id='.$oku->id.'" target="_blank"><img style="width: 50px; height:50px;" src="../images/'.$resim.'" alt=""></a></td>
														<td>'.$oku->arac_kodu.'</td>
														<td>'.$oku->plaka.'</td>    
														<td>'.$oku->sehir.'</td>  
														<td style="color:'.$color.';" ><a href="../arac_detay.php?id='.$oku->id.'&q=ihale" style="color:'.$color.';" target="_blank">'.$arac_detaylari.'</a></td>    
														<td id="sayac'.$sira.'">
															<input type="hidden" id="ihale_sayac'.$sira.'" value="'.$tarih_ihale.'" >
															<input type="hidden" id="id_'.$sira.'" value="'.$oku->id.'">
														</td> 
														<td>
															<a style="cursor: pointer;'.$t_color.'" class="view_guncelle kapanis_zamani'.$sira.'" id="'.$oku->id.'">'.$kapanis_zamani.'</a>
														</td>
														<td class="'.$yan.'"><a class="view_uyeye_teklif_ver" style="'.$t_color.'" id="sonteklif_'.$oku->id.'">'.money($oku->son_teklif).'₺</a></td>   
														<!-- <td class="'.$yan.'">'.$oku->son_teklif.'</td>     -->
														<input type="hidden" id="teklif_sayisi'.$sira.'" value="'.$toplam_teklif.'" >
														<td><a style="'.$t_color.'" class="view_ilan_teklifleri" id="teklifler_'.$oku->id.'"><i class="fas fa-gavel">'.$toplam_teklif.'</i></a></td>    
														<td><a style="'.$t_color.'" class="view_ilan_mesajlari" id="mesajlar_'.$oku->id.'"><i class="fas fa-envelope">'.$mesaj_sayi.'</i></a></td>    
														<td><a style="'.$t_color.'" class="view_ilan_favorileri" id="'.$oku->id.'"><i class="fas fa-heart">'.$favori_sayi.'</i></a></td>    
														<td><a style="'.$t_color.'" class="view_ilan_notlari" id="'.$oku->id.'"><i class="fas fa-align-justify">'.$not_sayi.'</i></a></td>    
														<td>'.$sgrt_adi.'</td>   
													</tr>
												';
												$sira++;
											}
										}
									}else{
										if(!in_array($hepsini_oku['id'],$hepsi_array)){
											$arac_detaylari=$hepsini_oku["model_yili"]." ".$marka_adi." ".$hepsini_oku['model']." ".$hepsini_oku['tip']." <span style='".$color2."' class='".$class."'>".$hepsini_oku['profil']."</span>";
											$tarih_ihale=$hepsini_oku['ihale_tarihi'].' '. $hepsini_oku['ihale_saati'];
											$kapanis_zamani=date("d-m-Y H:i:s", strtotime($hepsini_oku["ihale_tarihi"]. " ". $hepsini_oku["ihale_saati"]));
											if($tablo_rengi=="#1b8d3d"){
												$t_color="color:#fff;";
												$color="#fff";
											}else{
												$t_color="";
											}
														
											if($hepsini_oku["link"]!=""){
												$sgrt_adi='<a style="'.$t_color.'" href="'.$hepsini_oku["link"].'" target="_blank">'.$sigorta_adi.'</a>';
											}else{
												$sgrt_adi='<span style="'.$t_color.'">'.$sigorta_adi.'</span>';
											}
											$td.='
												<tr id="tr_'.$hepsini_oku["id"].'" style="background-color: '.$tablo_rengi.';'.$t_color.'  ">
													<td><a target="_blank" href="?modul=ilanlar&sayfa=ilan_ekle&id='.$gelen_id.'"><i class="fas fa-edit"></i></a></td>
													<td><a onclick="tabTrigger()" href="?modul=ilanlar&sayfa=ilan_ekle&id='.$gelen_id.'" target="_blank"><img style="width: 50px; height:50px;" src="../images/'.$resim.'" alt=""></a></td>
													<td>'.$hepsini_oku["arac_kodu"].'</td>
													<td>'.$hepsini_oku["plaka"].'</td>    
													<td>'.$hepsini_oku['sehir'].'</td>  
													<td style="color:'.$color.';" ><a href="../arac_detay.php?id='.$gelen_id.'&q=ihale" style="color:'.$color.';"  target="_blank">'.$arac_detaylari.'</a></td>    
													<td id="sayac'.$sira.'">
														<input type="hidden" id="ihale_sayac'.$sira.'" value="'.$tarih_ihale.'" >
														<input type="hidden" id="id_'.$sira.'" value="'.$hepsini_oku['id'].'">
													</td> 
													<td>
														<a style="cursor: pointer;'.$t_color.'" class="view_guncelle kapanis_zamani'.$sira.'" id="'.$hepsini_oku['id'].'">'.$kapanis_zamani.'</a>
													</td>
													<td class="'.$yan.'"><a style="'.$t_color.'" class="view_uyeye_teklif_ver" id="sonteklif_'.$hepsini_oku['id'].'">'.money($hepsini_oku["son_teklif"]).'₺</a></td>   
													<!-- <td class="'.$yan.'">'.$hepsini_oku["son_teklif"].'</td>     -->
													<input type="hidden" id="teklif_sayisi'.$sira.'" value="'.$toplam_teklif.'" >
													<td><a style="'.$t_color.'" class="view_ilan_teklifleri" id="teklifler_'.$hepsini_oku['id'].'"><i class="fas fa-gavel">'.$toplam_teklif.'</i></a></td>    
													<td><a style="'.$t_color.'" class="view_ilan_mesajlari" id="mesajlar_'.$hepsini_oku['id'].'"><i class="fas fa-envelope">'.$mesaj_sayi.'</i></a></td>    
													<td><a style="'.$t_color.'" class="view_ilan_favorileri" id="'.$hepsini_oku['id'].'"><i class="fas fa-heart">'.$favori_sayi.'</i></a></td>    
													<td><a style="'.$t_color.'" class="view_ilan_notlari" id="'.$hepsini_oku['id'].'"><i class="fas fa-align-justify">'.$not_sayi.'</i></a></td>    
													<td>'.$sgrt_adi.'</td>   
												</tr>
											';
											$sira++;
										}
									}
								}else{
									$tablo_rengi = "#ffd0b0";//Krem rengi
									$ihale_trh=$hepsini_oku["ihale_tarihi"];
									$ihale_st=$hepsini_oku["ihale_saati"];
									$srgl=mysql_query("select ilanlar.* from ilanlar inner join teklifler on teklifler.ilan_id=ilanlar.id  where ilanlar.durum=1 and ilanlar.ihale_tarihi='".$ihale_trh."' and ilanlar.ihale_saati='".$ihale_st."' and teklifler.durum=1 group by ilanlar.id");							//
									if(mysql_num_rows($srgl)>0){
										while($oku=mysql_fetch_object($srgl)){
											$mesaj_sayi = okunmamis_mesaj_sayi($oku->id);
											if(!in_array($oku->id,$hepsi_array) && $mesaj_sayi > 0){
												array_push($hepsi_array,$oku->id);
												$tarih_ihale=$oku->ihale_tarihi.' '. $oku->ihale_saati;
												$kapanis_zamani=date("d-m-Y H:i:s", strtotime($oku->ihale_tarihi. " ". $oku->ihale_saati));
												$teklifler=mysql_query("select * from teklifler where ilan_id='".$oku->id."' and durum=1 order by teklif_zamani desc ");
												$toplam_teklif = mysql_num_rows($teklifler);
												// $mesaj_cek = mysql_query("SELECT * FROM mesajlar WHERE ilan_id = '".$oku->id."'");
												// $mesaj_sayi = mysql_num_rows($mesaj_cek);
												$mesaj_sayi = okunmamis_mesaj_sayi($oku->id);
												$favori_cek = mysql_query("SELECT * FROM favoriler WHERE ilan_id = '".$oku->id."'");
												$favori_sayi = mysql_num_rows($favori_cek);
												$not_cek = mysql_query("SELECT * FROM ilan_notlari WHERE ilan_id = '".$oku->id."' group by tarih order by id desc");
												$not_sayi = mysql_num_rows($not_cek);
												$sigorta_cek = mysql_query("SELECT * FROM sigorta_ozellikleri WHERE id = '".$oku->sigorta."'");
												$sigorta_oku = mysql_fetch_assoc($sigorta_cek);
												$sigorta_adi = $sigorta_oku['sigorta_adi'];
												$style = '';
												$class  = '';
												if($oku->profil=="Hurda Belgeli"){
													$class = "blink" ;
													$color2 = "color:red;";
												}elseif($oku->profil=="Plakalı"){         
													$color2 = "color:green;font-weight:bold";            
												}elseif($oku->profil == "Çekme Belgeli/Pert Kayıtlı"){
													$color2 = "color:#000000";
												}else{
													$color2 = "color:#000000";
												}
												$resim_cek = mysql_query("select * from ilan_resimler where ilan_id = '".$oku->id."'");
												$resim_oku = mysql_fetch_assoc($resim_cek);
												$resim = $resim_oku['resim'];
												if($resim==""){
													$resim="default.png";
												}
												$stat_cek = mysql_query("SELECT * FROM kazanilan_ilanlar WHERE ilan_id = '".$oku->id."'");
												$stat_oku = mysql_fetch_assoc($stat_cek);
												$tklif_cek = mysql_query("SELECT * FROM teklifler WHERE durum=1 and ilan_id = '".$oku->id."' order by teklif_zamani desc limit 1");
												$tklifini_oku = mysql_fetch_assoc($tklif_cek);
												$tklif_sayi = mysql_num_rows($tklif_cek);
												if($stat_oku['durum'] == "0" || $stat_oku['durum'] == "1" || $stat_oku['durum'] == "2" || $stat_oku['durum'] == "3" || $stat_oku['durum'] == "4"){
													$tablo_rengi = "#1b8d3d"; //Koyu yeşil
												}else if($oku->ihale_turu == "1" && $tklifini_oku['uye_id']!='283'){
													if($oku->durum == "-1"){
															$tablo_rengi = "#00a2ff"; //Açık mavi       
													}else{
														$tablo_rengi = "#b4e61d"; //Açık yeşil      
													}
												}else if($oku->ihale_turu== "1" && $tklifini_oku['uye_id']=='283'){
													$tablo_rengi = "#feadc8";  //Toz pembe
												}else {
													if($oku->ihale_turu== "2" && $tklifini_oku['uye_id']=='283'){
														$tablo_rengi = "#ffd0b0";//Krem rengi
													}else{
														$tablo_rengi = "#ffd0b0";//Krem rengi
													}
												}
												
												if($tablo_rengi=="#1b8d3d"){
													$t_color="color:#fff;";
													$color="#fff";
												}else{
													$t_color="";
												}
												$arac_detaylari=$oku->model_yili." ".$marka_adi." ".$oku->model." ".$oku->tip." <span style='".$color2."' class='".$class."'>".$oku->profil."</span>";
												if($oku->link!=""){
													$sgrt_adi='<a style="'.$t_color.'" href="'.$oku->link.'" target="_blank">'.$sigorta_adi.'</a>';
												}else{
													$sgrt_adi='<span style="'.$t_color.'">'.$sigorta_adi.'</span>';
												}
												$td.='
													<tr id="tr_'.$oku->id.'" style="background-color: '.$tablo_rengi.'; '.$t_color.' ">
														<td><a target="_blank" href="?modul=ilanlar&sayfa=ilan_ekle&id='.$oku->id.'"><i class="fas fa-edit"></i></a></td>
														<td><a onclick="tabTrigger()" href="?modul=ilanlar&sayfa=ilan_ekle&id='.$oku->id.'" target="_blank"><img style="width: 50px; height:50px;" src="../images/'.$resim.'" alt=""></a></td>
														<td>'.$oku->arac_kodu.'</td>
														<td>'.$oku->plaka.'</td>    
														<td>'.$oku->sehir.'</td>  
														<td style="color:'.$color.';" ><a href="../arac_detay.php?id='.$oku->id.'&q=ihale" style="color:'.$color.';" target="_blank">'.$arac_detaylari.'</a></td>    
														<td id="sayac'.$sira.'">
															<input type="hidden" id="ihale_sayac'.$sira.'" value="'.$tarih_ihale.'" >
															<input type="hidden" id="id_'.$sira.'" value="'.$oku->id.'">
														</td> 
														<td>
															<a style="cursor: pointer;'.$t_color.'" class="view_guncelle kapanis_zamani'.$sira.'" id="'.$oku->id.'">'.$kapanis_zamani.'</a>
														</td>
														<td class="'.$yan.'"><a class="view_uyeye_teklif_ver" style="'.$t_color.'" id="sonteklif_'.$oku->id.'">'.money($oku->son_teklif).'₺</a></td>   
														<!-- <td class="'.$yan.'">'.$oku->son_teklif.'</td>     -->
														<input type="hidden" id="teklif_sayisi'.$sira.'" value="'.$toplam_teklif.'" >
														<td><a style="'.$t_color.'" class="view_ilan_teklifleri" id="teklifler_'.$oku->id.'"><i class="fas fa-gavel">'.$toplam_teklif.'</i></a></td>    
														<td><a style="'.$t_color.'" class="view_ilan_mesajlari" id="mesajlar_'.$oku->id.'"><i class="fas fa-envelope">'.$mesaj_sayi.'</i></a></td>    
														<td><a style="'.$t_color.'" class="view_ilan_favorileri" id="'.$oku->id.'"><i class="fas fa-heart">'.$favori_sayi.'</i></a></td>    
														<td><a style="'.$t_color.'" class="view_ilan_notlari" id="'.$oku->id.'"><i class="fas fa-align-justify">'.$not_sayi.'</i></a></td>    
														<td>'.$sgrt_adi.'</td>  
													</tr>
												';
												$sira++;
											}
										}
									}else{
										if(!in_array($hepsini_oku['id'],$hepsi_array)){
											$arac_detaylari=$hepsini_oku["model_yili"]." ".$marka_adi." ".$hepsini_oku['model']." ".$hepsini_oku['tip']." <span class='".$class."'>".$hepsini_oku['profil']."</span>";
											$tarih_ihale=$hepsini_oku['ihale_tarihi'].' '. $hepsini_oku['ihale_saati'];
											$kapanis_zamani=date("d-m-Y H:i:s", strtotime($hepsini_oku["ihale_tarihi"]. " ". $hepsini_oku["ihale_saati"]));
											if($tablo_rengi=="#1b8d3d"){
												$t_color="color:#fff;";
												$color="#fff";
											}else{
												$t_color="";
											}
											if($hepsini_oku["link"]!=""){
												$sgrt_adi='<a style="'.$t_color.'" href="'.$hepsini_oku["link"].'" target="_blank">'.$sigorta_adi.'</a>';
											}else{
												$sgrt_adi='<span style="'.$t_color.'">'.$sigorta_adi.'</span>';
											}
											$td.='
												<tr id="tr_'.$hepsini_oku["id"].'" style="background-color: '.$tablo_rengi.';'.$t_color.'  ">
													<td><a target="_blank" href="?modul=ilanlar&sayfa=ilan_ekle&id='.$gelen_id.'"><i class="fas fa-edit"></i></a></td>
													<td><a onclick="tabTrigger()" href="?modul=ilanlar&sayfa=ilan_ekle&id='.$gelen_id.'" target="_blank"><img style="width: 50px; height:50px;" src="../images/'.$resim.'" alt=""></a></td>
													<td>'.$hepsini_oku["arac_kodu"].'</td>
													<td>'.$hepsini_oku["plaka"].'</td>    
													<td>'.$hepsini_oku['sehir'].'</td>  
													<td style="color:'.$color.';" ><a href="../arac_detay.php?id='.$gelen_id.'&q=ihale" style="color:'.$color.';"  target="_blank">'.$arac_detaylari.'</a></td>    
													<td id="sayac'.$sira.'">
														<input type="hidden" id="ihale_sayac'.$sira.'" value="'.$tarih_ihale.'" >
														<input type="hidden" id="id_'.$sira.'" value="'.$hepsini_oku['id'].'">
													</td> 
													<td>
														<a style="cursor: pointer;'.$t_color.'" class="view_guncelle kapanis_zamani'.$sira.'" id="'.$hepsini_oku['id'].'">'.$kapanis_zamani.'</a>
													</td>
													<td class="'.$yan.'"><a style="'.$t_color.'" class="view_uyeye_teklif_ver" id="sonteklif_'.$hepsini_oku['id'].'">'.money($hepsini_oku["son_teklif"]).'₺</a></td>   
													<!-- <td class="'.$yan.'">'.$hepsini_oku["son_teklif"].'</td>     -->
													<input type="hidden" id="teklif_sayisi'.$sira.'" value="'.$toplam_teklif.'" >
													<td><a style="'.$t_color.'" class="view_ilan_teklifleri" id="teklifler_'.$hepsini_oku['id'].'"><i class="fas fa-gavel">'.$toplam_teklif.'</i></a></td>    
													<td><a style="'.$t_color.'" class="view_ilan_mesajlari" id="mesajlar_'.$hepsini_oku['id'].'"><i class="fas fa-envelope">'.$mesaj_sayi.'</i></a></td>    
													<td><a style="'.$t_color.'" class="view_ilan_favorileri" id="'.$hepsini_oku['id'].'"><i class="fas fa-heart">'.$favori_sayi.'</i></a></td>    
													<td><a style="'.$t_color.'" class="view_ilan_notlari" id="'.$hepsini_oku['id'].'"><i class="fas fa-align-justify">'.$not_sayi.'</i></a></td>    
													<td>'.$sgrt_adi.'</td>  
												</tr>
											';
											$sira++;
										}	
									}
								}
							}
						}else{
							$tablo_rengi = "#fff";
							$arac_detaylari=$hepsini_oku["model_yili"]." ".$marka_adi." ".$hepsini_oku['model']." ".$hepsini_oku['tip']." <span style='".$color2."' class='".$class."'>".$hepsini_oku['profil']."</span>";
							$tarih_ihale=$hepsini_oku['ihale_tarihi'].' '. $hepsini_oku['ihale_saati'];
							$kapanis_zamani=date("d-m-Y H:i:s", strtotime($hepsini_oku["ihale_tarihi"]. " ". $hepsini_oku["ihale_saati"]));
							if($hepsini_oku["link"]!=""){
								$sgrt_adi='<a style="'.$t_color.'" href="'.$hepsini_oku["link"].'" target="_blank">'.$sigorta_adi.'</a>';
							}else{
								$sgrt_adi='<span style="'.$t_color.'">'.$sigorta_adi.'</span>';
							}
							$td.='
								<tr id="tr_'.$hepsini_oku["id"].'"  style="background-color: '.$tablo_rengi.'; ">
									<td><a target="_blank" href="?modul=ilanlar&sayfa=ilan_ekle&id='.$gelen_id.'"><i class="fas fa-edit"></i></a></td>
									<td><a onclick="tabTrigger()" href="?modul=ilanlar&sayfa=ilan_ekle&id='.$gelen_id.'" target="_blank"><img style="width: 50px; height:50px;" src="../images/'.$resim.'" alt=""></a></td>
									<td>'.$hepsini_oku["arac_kodu"].'</td>
									<td>'.$hepsini_oku["plaka"].'</td>    
									<td>'.$hepsini_oku['sehir'].'</td>  
									<td style="color:'.$color.';" ><a href="../arac_detay.php?id='.$gelen_id.'&q=ihale" style="color:'.$color.';"  target="_blank">'.$arac_detaylari.'</a></td>    
									<td id="sayac'.$sira.'">
										<input type="hidden" id="ihale_sayac'.$sira.'" value="'.$tarih_ihale.'" >
										<input type="hidden" id="id_'.$sira.'" value="'.$hepsini_oku['id'].'">
									</td> 
									<td>
										<a style="cursor: pointer;" class="view_guncelle kapanis_zamani'.$sira.'" id="'.$hepsini_oku['id'].'">'.$kapanis_zamani.'</a>
									</td>
									<td class="'.$yan.'"><a class="view_uyeye_teklif_ver" id="sonteklif_'.$hepsini_oku['id'].'">'.money($hepsini_oku["son_teklif"]).'₺</a></td>   
									<!-- <td class="'.$yan.'">'.$hepsini_oku["son_teklif"].'</td>     -->
									<input type="hidden" id="teklif_sayisi'.$sira.'" value="'.$toplam_teklif.'" >
									<td><a class="view_ilan_teklifleri" id="teklifler_'.$hepsini_oku['id'].'"><i class="fas fa-gavel">'.$toplam_teklif.'</i></a></td>    
									<td><a class="view_ilan_mesajlari" id="mesajlar_'.$hepsini_oku['id'].'"><i class="fas fa-envelope">'.$mesaj_sayi.'</i></a></td>    
									<td><a class="view_ilan_favorileri" id="'.$hepsini_oku['id'].'"><i class="fas fa-heart">'.$favori_sayi.'</i></a></td>    
									<td><a class="view_ilan_notlari" id="'.$hepsini_oku['id'].'"><i class="fas fa-align-justify">'.$not_sayi.'</i></a></td>    
									<td>'.$sgrt_adi.'</td>
								</tr>
							';
							$sira++;
						}
					?>
				<?php  } echo $td; ?>
			</table>
		</div>
	</form>
<script>
	function tabTrigger(){
		localStorage.setItem("gorsel_trigger","1");
	}
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="js/uyeler_modal.js?v=<? echo time();?>"></script>

<!-- Guncelleme-->
<div style="width:75%;" class="modal fade" id="tarih_guncelle">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
		<h3 id="myModalLabel">Tarihi Değiştir</h3>
	</div>
	<div class="modal-dialog">
		<div class="modal-body" id="ihale_guncelle">
		</div>
	</div>
</div>
<!-- Guncelleme Modal Bitiş-->
<!-- İlan Fav-->
<div style="width:75%;" class="modal fade" id="ilan_fav">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
	</div>
	<div class="modal-dialog">
		<div class="modal-body" id="fav_ilan">
		</div>
	</div>
</div>
<!-- İlan Fav Bitiş-->
<!-- İlan Mesaj-->
<div style="width:75%;" class="modal fade" id="ilan_mesaj">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
	</div>
	<div class="modal-dialog">
		<div class="modal-body" id="mesaj_ilan">
		</div>
	</div>
</div>
<!-- İlan Mesaj Bitiş-->
<!-- İlan Teklif-->
<div style="width:75%;" class="modal fade" id="ilan_teklif">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
	</div>
	<div class="modal-dialog">
		<div class="modal-body" id="teklif_ilan">
		</div>
	</div>
</div>
<!-- İlan Teklif-->

<?php 
	if((re('ihale_tarih_degisir')=="Kaydet")){
		$guncel_tarih = re('tarih_guncelle');
		$guncel_saat = re('saat_guncelle');
		$ilanin_id = re('ilanin_id');
		mysql_query("UPDATE ilanlar SET ihale_tarihi = '".$guncel_tarih."', ihale_saati = '".$guncel_saat."', durum = 1 WHERE id='".$ilanin_id."'");
	}
?>

<!-- Üye Adına Teklif -->
<div style="" class="modal fade" id="uyeye_teklif">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
	</div>
   <div class="modal-dialog">
		<div class="modal-body" id="uyenin_teklifi">
		</div>
   </div>
</div>
<!-- Üye Adına Teklif Bitiş-->




<script>
	function sureleri_uzat(){
		if($(".chec").is(':checked')){
			return confirm ("Seçili süreleri uzatmak istediğinize emin misiniz?");
		}else{
			alert("Seçim yapmalısınız");
			return false;
		}
	}
    function createCountDown(elementId,sira) 
    {
		var zaman =document.getElementById("ihale_sayac"+sira).value;
		var id =document.getElementById("id_"+sira).value;
		var countDownDate = new Date(zaman).getTime();
		var x = setInterval(function() 
		{
			jQuery.ajax({
			url: "https://ihale.pertdunyasi.com/check.php",
				type: "POST",
				dataType: "JSON",
				data: {
					action: "panel_ilan_guncelle",
					kapanis_zamani: $(".kapanis_zamani"+sira).html(),
					ilan_id:id,
				},
				success: function(response) {
					var son_teklif=$("#sonteklif_"+id).html();
					son_teklif=String(son_teklif);
					son_teklif=son_teklif.replace('.','');
					son_teklif=son_teklif.replace("₺","");	
					var yeni_sonteklif=formatMoney(response.son_teklif)+'₺';
					$("#sonteklif_"+id).html(yeni_sonteklif);
					$(".kapanis_zamani"+sira).html(response.ihale_tarihi);
					$("#tr_"+id).css("background-color",response.renk);


					var $teklif_sayi = `<i class="fas fa-gavel" aria-hidden="true">${response.toplam_teklif}</i>`;
					var $mesaj_sayi = `<i class="fas fa-envelope" aria-hidden="true">${response.mesaj_sayi}</i>`;
					if(response.onaydaki_sayi == 1){
						$('#teklifler_'+id).html($teklif_sayi+'<p style="background-color:#0966f2; color:white;padding:5px;" class="blink"> YENİ</p>');
					}else{
						if(response.onay_bekleyen_teklif_var_mi == "1"){
							$('#teklifler_'+id).html($teklif_sayi+'<p style="background-color:red;color:white;padding:5px;" class="blink"> YENİ</p>');
						}else{
							if(response.yeni_teklif != 0){
								$('#teklifler_'+id).html($teklif_sayi+'<p style="background-color:red;color:white;padding:5px;" class="blink"> YENİ</p>');
							}else{
								$('#teklifler_'+id).html($teklif_sayi);
							}							
						}
					}
					if(response.okunmamis_mesaj_var_mi == "1"){
						$('#mesajlar_'+id).html($mesaj_sayi + '<p style="background-color:red; color: white;padding:5px;" class="blink"> Yeni</p>');
					}else{
						$('#mesajlar_'+id).html($mesaj_sayi);
					}



					countDownDate=countDownDate+response.milisaniye; 	
				}
			});
			var now = new Date().getTime();
			var distance = (countDownDate) - (now);
			var days = Math.floor(distance / (1000 * 60 * 60 * 24));
			var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));			
			var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
			if(minutes<10){
				if(minutes<2 && (hours==0 || hours=="00" ) && (days==0 || days=="00" )){
					var teklif_sayisi=$("#teklif_sayisi"+sira).val();
					if(teklif_sayisi>0){
						$(".kapanis_zamani"+sira).addClass("yan");	
					}else{
						$(".kapanis_zamani"+sira).removeClass("yan");
					}
				}else{
					$(".kapanis_zamani"+sira).removeClass("yan");
				}
				minutes="0"+minutes;
			}
			if(hours<10){
				hours="0"+hours;
			}
			var seconds = Math.floor((distance % (1000 * 60)) / 1000);
			if(seconds<10){
				seconds="0"+seconds;
			}
			document.getElementById(elementId).innerHTML = days + " gün " + hours + ":"+ minutes + ":" + seconds + "";
			if (distance < 0) 
			{
				sure_doldu(id);
				clearInterval(x);
				document.getElementById(elementId).innerHTML = "Süre Doldu";
			}
		}, 1000);
	}
	for (var i = 0; i < ihale_say.value; i++) {
		createCountDown("sayac"+i,i);
	}
</script>

<!-- İlan Notları Başlangıç-->
<div class="modal fade" id="ilan_notlari">
	<button type="button" class="close" style="margin-right: 2%; margin-top:2%;" data-dismiss="modal" aria-hidden="true"></button>
	<div class="modal-dialog">
		<div class="modal-body" id="ilanin_notlarini">
		</div>
	</div>
</div>
<?php 
	if(re('notu') =='Kaydet'){
		$eklenecek_not = re('eklenecek_not');
		$gelen_id = re('gelen_id');    
		$gizlilik = re('gizlilik');
		$tarih = date('Y-m-d H:i:s');
		if(isset($_FILES['files'])){     // dosya tanımlanmıs mı? 
			$errors= array(); 
			foreach($_FILES['files']['tmp_name'] as $key => $tmp_name ){ 
				$dosya_adi =$_FILES['files']['name'][$key]; 		// uzantiya beraber dosya adi 
				$dosya_boyutu =$_FILES['files']['size'][$key];    		// byte cinsinden dosya boyutu 
				$dosya_gecici =$_FILES['files']['tmp_name'][$key];		//gecici dosya adresi 
				$yenisim=md5(microtime()).$dosya_adi; 				//karmasik yeni isim.pdf 
				$klasor="../assets"; // yuklenecek dosyalar icin yeni klasor 
				$test=move_uploaded_file($dosya_gecici,"$klasor/".$yenisim);//yoksa yeni ismiyle kaydet 
				if($test==true){
					$yol='assets/'.$yenisim;
					$a=mysql_query("INSERT INTO `ilan_notlari` (`id`, `ilan_id`, `ekleyen`, `ilan_notu`, `gizlilik`, `tarih`, `dosya`) 
					VALUES (NULL, '".$gelen_id."', '".$admin_id."', '".$eklenecek_not."', '".$gizlilik."', '".$tarih."', '".$yenisim."')")or die(mysql_error()); 
					mysql_query("INSERT INTO `yapilan_is` (`id`, `admin_id`, `yaptigi`,`aciklama`, `ekleme_zamani`, `ilan_id`, `dogrudan_id`, `uye_id`) VALUES 
					(NULL, '".$admin_id."', '2','".$eklenecek_not."', '".$tarih."','".$gelen_id."','0','0');"); 
					if($a){
					echo '<script>alert("Başarıyla Eklendi..");</script>';
					header("Location:?modul=ihaleler&sayfa=tum_ihaleler");
				   }
				}
				else {
					$a=mysql_query("INSERT INTO `ilan_notlari` (`id`, `ilan_id`, `ekleyen`, `ilan_notu`, `gizlilik`, `tarih`, `dosya`) 
					VALUES (NULL, '".$gelen_id."', '".$admin_id."', '".$eklenecek_not."', '".$gizlilik."', '".$tarih."', '1')")or die(mysql_error()); 
					mysql_query("INSERT INTO `yapilan_is` (`id`, `admin_id`, `yaptigi`,`aciklama`, `ekleme_zamani`, `ilan_id`, `dogrudan_id`, `uye_id`) VALUES 
					(NULL, '".$admin_id."', '2','".$eklenecek_not."', '".$tarih."','".$gelen_id."','0','0');"); 
					header("Location:?modul=ihaleler&sayfa=tum_ihaleler");
				}
			} 
		}
	}

?>
<script>
	var clicked = false;
	$(".checkall").on("click", function() {
		$(".chec").prop("checked", !clicked);
		clicked = !clicked;
		this.innerHTML = clicked ? 'Seçimleri Kaldır' : 'Tümünü Seç';
	});
	function markaGetir(){
		var sayi=document.getElementsByClassName("checked").length;
        var i;
		var array=[];
		for(i=0;i<sayi;i++){
			var a=document.getElementsByClassName('checked')[i].innerHTML;
			a=a.split(" ");
			a[3]=a[3].split("=");
			a[3][1]=a[3][1].replace('""','"');
			a[2]=a[2].split("=");
			a[2][1]=a[2][1].replace('""','"');
			if(a[2][1]=='"marka[]"'){
				array.push({marka_id:a[3][1]});
			}
		}
		jQuery.ajax({
			url: "https://ihale.pertdunyasi.com/check.php",
			type: "POST",
			dataType: "JSON",
			data: {
				action: "panel_model",
				json_array:JSON.stringify(array),
			},
			success: function(response) {
				console.log(response);
				if(response.status == 200){
					$('#model').html(response.str);
				} else {
				}
			}
		});
    }
	function formatMoney(n) {
		var n= (Math.round(n * 100) / 100).toLocaleString();
		n=n.replaceAll(',', '.')
		return n;
	}
	function sure_doldu(id){
		jQuery.ajax({
			url: "https://ihale.pertdunyasi.com/check.php",
			type: "POST",
			dataType: "JSON",
			data: {
				action: "sure_doldu",
				id:id
			},
			success: function(response) {
				if (response.status == 200) {
					//window.location="ihaledeki_araclar.php";
				}
			}
		});
	}
	function data_update(){
		jQuery.ajax({
			url: "https://ihale.pertdunyasi.com/check.php",
			type: "POST",
			dataType: "JSON",
			data: {
				action: "panel_ilanlar_guncelle",
			},
			success: function(response) {
				jQuery.each(response, function (index, value) {
					var son_teklif=$("#sonteklif_"+value.id).html();
					if(son_teklif!=undefined){
						son_teklif=String(son_teklif);
						son_teklif=son_teklif.replace('.','');
						son_teklif=son_teklif.replace("₺","");	
						if(son_teklif!=value.son_teklif){
							var yeni_sonteklif=formatMoney(value.son_teklif)+'₺';
							$("#sonteklif_"+value.id).html(yeni_sonteklif);
						}
					}
				});
			}
		});
	}
	var baslat=setInterval(function(){
		//data_update();
	},3000)
</script>