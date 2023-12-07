<?php 
	include 'ayar.php';
	if(re("action")=="teklif_ver"){
		/*
		session_start();
		$token = $_SESSION['u_token'];
		$k_token = $_SESSION['k_token'];
		if($token != "" && $k_token == ""){
			$uye_token = $token;
		}elseif($token == "" && $k_token != ""){
			$uye_token = $k_token;
		}
		if(!isset($uye_token)){
			echo '<script>alert("Devam Etmek İçin Lütfen Giriş Yapın !")</script>';
			echo '<script>window.location.href = "index.php"</script>';
		}
		*/
		$teklif_tarihi = date('Y-m-d H:i:s');
		$response=[];
		$verilen_teklif = $_POST['verilen_teklif'];
		$kullaniciToken = $_POST['kullaniciToken'];
		$ilanID = re('ilanID');
		$uye_tkn = re('uye_token');
		//$hizmet_bedel = re('hizmet_bedel');
		$user_sql=mysql_query("select * from user where user_token='".$uye_tkn."' or kurumsal_user_token='".$uye_tkn."' ");
		$user_row=mysql_fetch_object($user_sql);
		$uyeID=$user_row->id;
		$uye_paket=$user_row->paket;
		$date = date('Y-m-d H:i:s');
		$ip = re("ip");
		$tarayici=re("tarayici");
		$isletim_sistemi=re("isletim_sistemi");
		$sozlesme_kontrol=re("sozlesme_kontrol");		
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
			}else{
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
			$hizmet_bedel = re('hizmet_bedel');
		}
		$sigorta_id=$row->sigorta;
		$sorgu2=mysql_query("select * from teklif_limiti where uye_id='".$uyeID."' ");
		$row2=mysql_fetch_object($sorgu2);
		$uyenin_durumu_cek = mysql_query("SELECT * FROM uye_durumlari WHERE uye_id = '".$uyeID."'");
		$uyenin_durumu = mysql_fetch_assoc($uyenin_durumu_cek);
		$uye_paket_cek=mysql_query("select * from uye_grubu where id='".$uye_paket."'");
		$uye_paket_oku=mysql_fetch_object($uye_paket_cek);
		$teklif_engelle = $uyenin_durumu['teklif_engelle'];
		$engelleme_nedeni = $uyenin_durumu['engelleme_nedeni'];
		$otomatik_teklif_engelle = $uyenin_durumu['otomatik_teklif_engelle'];
		$engelli_sigorta="false";
		$uye_engelli_sigortalar = explode(",",$uyenin_durumu['yasak_sigorta']);
		for($h=0;$h<count($uye_engelli_sigortalar);$h++){
			if($sigorta_id==$uye_engelli_sigortalar[$h]){
				$engelli_sigorta="true";
			}
		}
		$hurda_teklif = $uyenin_durumu['hurda_teklif'];
		$ilan_durumu_cek = mysql_query("SELECT * FROM ilanlar WHERE id = '".$ilanID."'");
		$ilan_durumu_oku = mysql_fetch_assoc($ilan_durumu_cek);
		$hurda_durumu = $ilan_durumu_oku['profil'];
		//Hurda Belgeli
		/*$toplam_aktif = mysql_query('SELECT SUM(net) AS net FROM cayma_bedelleri WHERE uye_id = "'.$uyeID.'" and durum=1'); 
		$toplam_getir = mysql_fetch_assoc($toplam_aktif); 
		$toplam_cayma = $toplam_getir['net'];
		$toplam_borc = mysql_query('SELECT SUM(net) AS net FROM cayma_bedelleri WHERE uye_id = "'.$uyeID.'" and durum=2'); 
		$toplam_borc_getir = mysql_fetch_assoc($toplam_borc); 
		$toplam_borc_cayma = $toplam_getir['net'];
		$cayma=$toplam_cayma-toplam_borc_cayma;*/
		$aktif_cayma_toplam=mysql_query("SELECT SUM(tutar) as toplam_aktif_cayma FROM cayma_bedelleri WHERE uye_id='".$uyeID."' AND durum=1");
		$toplam_aktif_cayma=mysql_fetch_assoc($aktif_cayma_toplam);
		$iade_talepleri_toplam=mysql_query("SELECT SUM(tutar) as toplam_iade_talepleri FROM cayma_bedelleri WHERE uye_id='".$uyeID."' AND durum=2");
		$toplam_iade_talepleri=mysql_fetch_assoc($iade_talepleri_toplam);
		$borclar_toplam=mysql_query("SELECT SUM(tutar) as toplam_borclar FROM cayma_bedelleri WHERE uye_id='".$uyeID."' AND durum=6");
		$toplam_borclar=mysql_fetch_assoc($borclar_toplam);
		/* 10.04.2022 tarihinde yorum satırına alındı. 54.maddenin chatinde belirtildi */
		// $cayma=$toplam_aktif_cayma["toplam_aktif_cayma"]-$toplam_iade_talepleri["toplam_iade_talepleri"]-$toplam_borclar["toplam_borclar"];
		$cayma=$toplam_aktif_cayma["toplam_aktif_cayma"]-$toplam_borclar["toplam_borclar"];

		if($row->hesaplama=="Standart"){
			if($row2->standart_limit != 0){
				$teklif_limiti=$row2->standart_limit;
			}else{
				//$teklif_limiti=$uye_paket_oku->standart_ust_limit;
				$teklif_limiti=0;
				$grup_cek=mysql_query("select * from uye_grubu_detaylari where grup_id='".$uye_paket."' and cayma_bedeli <= '".$cayma."' order by cayma_bedeli desc limit 1");
				$grup_oku = mysql_fetch_object($grup_cek);
				$teklif_limiti = $grup_oku->standart_ust_limit;	
			}
		}else{
			if($row2->luks_limit>0){
				$teklif_limiti=$row2->luks_limit;
			}else{
				$teklif_limiti=0;
				//$teklif_limiti=$uye_paket_oku->luks_ust_limit;
				$grup_cek=mysql_query("select * from uye_grubu_detaylari where grup_id='".$uye_paket."' and cayma_bedeli <= '".$cayma."' order by cayma_bedeli desc limit 1");
				$grup_oku = mysql_fetch_object($grup_cek);
				$teklif_limiti = $grup_oku->luks_ust_limit;	
			}
		}
		$sorgu3=mysql_query("select * from sigorta_ozellikleri where id='".$sigorta_id."'");
		$row3=mysql_fetch_object($sorgu3);
		$belirlenen=(int)$row3->bu_sure_altinda_teklif;
		$alacagi_mesaj=$row3->alacagi_mesaj;
		$sigorta_min_artis=$row3->minumum_artis;
		$sure_uzatma = $row3->sure_uzatma;
		$dakikanin_altinda = $row3->dakikanin_altinda;
		$dakika_uzar = $row3->dakika_uzar;
		if($row->ihale_turu==1){
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
						$response = ["message"=>"Sistem tarafından teklif vermeniz kısıtlanmıştır.Müşteri temsilcileri ile iletişime geçebilirsiniz.","status"=>500];
						$islem_durum = 0;
					}else if($engelli_sigorta=="true" ){
						$response = ["message"=>"İlanın sigorta şirketine ait olan araçlara teklif vermeniz kısıtlanmıştır.","status"=>500];
						$islem_durum = 0;
					}else{
						if($uye_tkn == ""){
							$response=["message"=>"Teklif verebilmek için giriş yapmalısınız","status"=>500];
							$islem_durum = 0;
						}else if($uye_tkn == $row->ihale_sahibi){
							$response=["message"=>"Kendi ihalenize teklif veremezsiniz.","status"=>500];
							$islem_durum = 0;
						}else if($row->ihale_tarihi." ".$row->ihale_saati < $teklif_tarihi){
							$response=["message"=>"İhalenin süresi dolmuştur.","status"=>500];
							$islem_durum = 0;
						}elseif($verilen_teklif == ""){
							$response=["message"=>"Teklfiniz boş olamaz","status"=>500];
							$islem_durum = 0;
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
							$response=["message"=>"Teklif limitini aştınız. Mevcut paketinizin teklif limiti '".money($teklif_limiti)."' ₺'dir. ","status"=>500];
							$islem_durum = 0;
						} 						
						else if($verilen_teklif < $row->son_teklif+$sigorta_min_artis){
							$response=["message"=>"Teklfiniz en yüksek teklifden en az $sigorta_min_artis ₺ fazla olmalı ","status"=>500];
							$islem_durum = 0;
						}  
						else{
							if($sozlesme_kontrol != 1){
								$sigort_cek_onay = mysql_query("select * from sigorta_ozellikleri where id = '".$row->sigorta."'");
								$sigorta_oku_onay = mysql_fetch_object($sigort_cek_onay);
								if($sigorta_oku_onay->teklif_onay_mekanizmasi == 1){
									$response=["message"=>"Teklif verebilmeniz için sözleşmeyi kabul etmelisiniz.","status"=>500];
									$islem_durum = 0;
								}else{
									$ihale_son=$row->ihale_tarihi." ".$row->ihale_saati;
									$ihale_son_str = strtotime($ihale_son);
									$suan_str = strtotime(date("Y-m-d H:i:s"));
									$sonuc=($ihale_son_str-$suan_str)/60;
									if($sonuc>=$belirlenen ){
										$teklif_durum=1;
										$ilan_teklifi=mysql_query("select * from teklifler where ilan_id='".$ilanID."' and durum=1 order by teklif_zamani desc limit 1"); 
										$ilan_teklifi_oku=mysql_fetch_object($ilan_teklifi);
										$teklif_uye_id=$ilan_teklifi_oku->uye_id;
										$ilan_cek = mysql_query("SELECT * FROM ilanlar WHERE id = '".$ilanID."' ");
										$ilan_oku = mysql_fetch_array($ilan_cek);
										$teklif = $ilan_oku['son_teklif'];
										if($verilen_teklif > $teklif){
											if($sonuc>=3 && $teklif_uye_id!='283'){//283 Kaynak Firma Uye ID
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
													// $date=date("Y-m-d H:i:s");
													$date=$teklif_tarihi;
													$tarih=strtotime("-".$sigorta_dakikanin_altinda." minutes",strtotime($ihale_bitis));
													$tarih=date("Y-m-d H:i:s",$tarih);
													if($date>$tarih){
														$gosterilme_tarih=strtotime($yeni_trh)+300; //Gösterilme süresi 5 dk fazla olması istendi
														$gosterilme_tarih=date("Y-m-d H:i:s",$gosterilme_tarih);
														// mysql_query("UPDATE ilanlar SET son_teklif = '".$verilen_teklif."',sistem_sure_uzatma_durumu='0',ihale_tarihi='".$yeni_t."',ihale_saati='".$yeni_s."',ihale_son_gosterilme='".$gosterilme_tarih."' WHERE id='".$ilanID."'");
														mysql_query("UPDATE ilanlar SET son_teklif = '".$verilen_teklif."',sistem_sure_uzatma_durumu='0' WHERE id='".$ilanID."'");
													}else{
														mysql_query("UPDATE ilanlar SET son_teklif = '".$verilen_teklif."',sistem_sure_uzatma_durumu='0' WHERE id='".$ilanID."'");
													}
												}else{
														mysql_query("UPDATE ilanlar SET son_teklif = '".$verilen_teklif."',sistem_sure_uzatma_durumu='0' WHERE id='".$ilanID."'");
												}
											}else{
												mysql_query("UPDATE ilanlar SET son_teklif = '".$verilen_teklif."' WHERE id='".$ilanID."'");
											}
										}
										if($_SESSION['u_token'] != ""){
											mysql_query("INSERT INTO `teklifler`(`id`,`ilan_id`,`uye_id`,`teklif`,`hizmet_bedeli`,`teklif_zamani`,`user_token`,`dogrudan_satisli_ilan_id`,`kurumsal_token`,ip,tarayici,isletim_sistemi,admin_teklif,admin_id,durum) 
												VALUES (NULL,'".$ilanID."','".$uyeID."','".$verilen_teklif."','".$hizmet_bedel."','".$date."','".$_SESSION['u_token']."','0','','".$ip."','".$tarayici."','".$isletim_sistemi."','0','0','".$teklif_durum."')");
										}elseif($_SESSION['k_token'] != ""){
											mysql_query("INSERT INTO `teklifler`(`id`,`ilan_id`,`uye_id`,`teklif`,`hizmet_bedeli`,`teklif_zamani`,`user_token`,`dogrudan_satisli_ilan_id`,`kurumsal_token`,ip,tarayici,isletim_sistemi,admin_teklif,admin_id,durum) 
												VALUES (NULL,'".$ilanID."','".$uyeID."','".$verilen_teklif."','".$hizmet_bedel."','".$date."','','0','".$_SESSION['k_token']."','".$ip."','".$tarayici."','".$isletim_sistemi."','0','0','".$teklif_durum."')");
										}
										$response=["message"=>"Teklif başarıyla verildi","status"=>200];
										$islem_durum = 1;
									}else{
										$teklif_durum=2;
										$onay_bekleyen_teklifler=mysql_query("select * from teklifler where ilan_id='".$ilanID."' and durum='2'");
										$ayni_teklif=false;
										while($onay_bekleyenler_oku=mysql_fetch_object($onay_bekleyen_teklifler)){
											if($verilen_teklif<=$onay_bekleyenler_oku->teklif){
												$ayni_teklif=true;
											}
										}
										if($ayni_teklif==true){
											$response=["message"=>"Bu teklif başka bir üye tarafından verildi ve onay bekliyor. Lütfen daha yüksek bir teklif vermeyi deneyiniz.","status"=>500];
											$islem_durum = 0;
										}
										else{
											if($_SESSION['u_token'] != ""){
												mysql_query("INSERT INTO `teklifler`(`id`,`ilan_id`,`uye_id`,`teklif`,`hizmet_bedeli`,`teklif_zamani`,`user_token`,`dogrudan_satisli_ilan_id`,`kurumsal_token`,ip,tarayici,isletim_sistemi,admin_teklif,admin_id,durum) 
													VALUES (NULL,'".$ilanID."','".$uyeID."','".$verilen_teklif."','".$hizmet_bedel."','".$date."','".$_SESSION['u_token']."','0','','".$ip."','".$tarayici."','".$isletim_sistemi."','0','0','".$teklif_durum."')");
											}elseif($_SESSION['k_token'] != ""){
												mysql_query("INSERT INTO `teklifler`(`id`,`ilan_id`,`uye_id`,`teklif`,`hizmet_bedeli`,`teklif_zamani`,`user_token`,`dogrudan_satisli_ilan_id`,`kurumsal_token`,ip,tarayici,isletim_sistemi,admin_teklif,admin_id,durum) 
													VALUES (NULL,'".$ilanID."','".$uyeID."','".$verilen_teklif."','".$hizmet_bedel."','".$date."','','0','".$_SESSION['k_token']."','".$ip."','".$tarayici."','".$isletim_sistemi."','0','0','".$teklif_durum."')");
											}
											$response=["message"=>$alacagi_mesaj,"status"=>200];
											$islem_durum = 1;
										}
									}
								}						
							}else{
								$ihale_son=$row->ihale_tarihi." ".$row->ihale_saati;
								$ihale_son_str = strtotime($ihale_son);
								$suan_str = strtotime(date("Y-m-d H:i:s"));
								$sonuc=($ihale_son_str-$suan_str)/60;
								if($sonuc>=$belirlenen ){
									$teklif_durum=1;
									$ilan_teklifi=mysql_query("select * from teklifler where ilan_id='".$ilanID."' and durum=1 order by teklif_zamani desc limit 1"); 
									$ilan_teklifi_oku=mysql_fetch_object($ilan_teklifi);
									$teklif_uye_id=$ilan_teklifi_oku->uye_id;
									$ilan_cek = mysql_query("SELECT * FROM ilanlar WHERE id = '".$ilanID."' ");
									$ilan_oku = mysql_fetch_array($ilan_cek);
									$teklif = $ilan_oku['son_teklif'];
									if($verilen_teklif > $teklif){
										if($sonuc>=3 && $teklif_uye_id!='283'){//283 Kaynak Firma Uye ID
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
												// $date=date("Y-m-d H:i:s");
												$date=$teklif_tarihi;
												$tarih=strtotime("-".$sigorta_dakikanin_altinda." minutes",strtotime($ihale_bitis));
												$tarih=date("Y-m-d H:i:s",$tarih);
												if($date>$tarih){
													$gosterilme_tarih=strtotime($yeni_trh)+300; //Gösterilme süresi 5 dk fazla olması istendi
													$gosterilme_tarih=date("Y-m-d H:i:s",$gosterilme_tarih);
													// mysql_query("UPDATE ilanlar SET son_teklif = '".$verilen_teklif."',sistem_sure_uzatma_durumu='0',ihale_tarihi='".$yeni_t."',ihale_saati='".$yeni_s."',ihale_son_gosterilme='".$gosterilme_tarih."' WHERE id='".$ilanID."'");
													mysql_query("UPDATE ilanlar SET son_teklif = '".$verilen_teklif."',sistem_sure_uzatma_durumu='0' WHERE id='".$ilanID."'");
												}else{
													mysql_query("UPDATE ilanlar SET son_teklif = '".$verilen_teklif."',sistem_sure_uzatma_durumu='0' WHERE id='".$ilanID."'");
												}
											}else{
													mysql_query("UPDATE ilanlar SET son_teklif = '".$verilen_teklif."',sistem_sure_uzatma_durumu='0' WHERE id='".$ilanID."'");
											}
										}else{
											mysql_query("UPDATE ilanlar SET son_teklif = '".$verilen_teklif."' WHERE id='".$ilanID."'");
										}
									}
									if($_SESSION['u_token'] != ""){
										mysql_query("INSERT INTO `teklifler`(`id`,`ilan_id`,`uye_id`,`teklif`,`hizmet_bedeli`,`teklif_zamani`,`user_token`,`dogrudan_satisli_ilan_id`,`kurumsal_token`,ip,tarayici,isletim_sistemi,admin_teklif,admin_id,durum) 
											VALUES (NULL,'".$ilanID."','".$uyeID."','".$verilen_teklif."','".$hizmet_bedel."','".$date."','".$_SESSION['u_token']."','0','','".$ip."','".$tarayici."','".$isletim_sistemi."','0','0','".$teklif_durum."')");
									}elseif($_SESSION['k_token'] != ""){
										mysql_query("INSERT INTO `teklifler`(`id`,`ilan_id`,`uye_id`,`teklif`,`hizmet_bedeli`,`teklif_zamani`,`user_token`,`dogrudan_satisli_ilan_id`,`kurumsal_token`,ip,tarayici,isletim_sistemi,admin_teklif,admin_id,durum) 
											VALUES (NULL,'".$ilanID."','".$uyeID."','".$verilen_teklif."','".$hizmet_bedel."','".$date."','','0','".$_SESSION['k_token']."','".$ip."','".$tarayici."','".$isletim_sistemi."','0','0','".$teklif_durum."')");
									}
									$response=["message"=>"Teklif başarıyla verildi","status"=>200];
									$islem_durum = 1;
								}else{
									$teklif_durum=2;
									$onay_bekleyen_teklifler=mysql_query("select * from teklifler where ilan_id='".$ilanID."' and durum='2'");
									$ayni_teklif=false;
									while($onay_bekleyenler_oku=mysql_fetch_object($onay_bekleyen_teklifler)){
										if($verilen_teklif<=$onay_bekleyenler_oku->teklif){
											$ayni_teklif=true;
										}
									}
									if($ayni_teklif==true){
										$response=["message"=>"Bu teklif başka bir üye tarafından verildi ve onay bekliyor. Lütfen daha yüksek bir teklif vermeyi deneyiniz.","status"=>500];
										$islem_durum = 0;
									}
									else{
										if($_SESSION['u_token'] != ""){
											mysql_query("INSERT INTO `teklifler`(`id`,`ilan_id`,`uye_id`,`teklif`,`hizmet_bedeli`,`teklif_zamani`,`user_token`,`dogrudan_satisli_ilan_id`,`kurumsal_token`,ip,tarayici,isletim_sistemi,admin_teklif,admin_id,durum) 
												VALUES (NULL,'".$ilanID."','".$uyeID."','".$verilen_teklif."','".$hizmet_bedel."','".$date."','".$_SESSION['u_token']."','0','','".$ip."','".$tarayici."','".$isletim_sistemi."','0','0','".$teklif_durum."')");
										}elseif($_SESSION['k_token'] != ""){
											mysql_query("INSERT INTO `teklifler`(`id`,`ilan_id`,`uye_id`,`teklif`,`hizmet_bedeli`,`teklif_zamani`,`user_token`,`dogrudan_satisli_ilan_id`,`kurumsal_token`,ip,tarayici,isletim_sistemi,admin_teklif,admin_id,durum) 
												VALUES (NULL,'".$ilanID."','".$uyeID."','".$verilen_teklif."','".$hizmet_bedel."','".$date."','','0','".$_SESSION['k_token']."','".$ip."','".$tarayici."','".$isletim_sistemi."','0','0','".$teklif_durum."')");
										}
										$response=["message"=>$alacagi_mesaj,"status"=>200];
										$islem_durum = 1;
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
					$response = ["message"=>"Sistem tarafından teklif vermeniz kısıtlanmıştır.Müşteri temsilcileri ile iletişime geçebilirsiniz.","status"=>500];
					$islem_durum = 0;
				}else{
					if($uye_tkn == ""){
						$response=["message"=>"Teklif verebilmek için giriş yapmalısınız","status"=>500];
						$islem_durum = 0;
					}else if($uye_tkn == $row->ihale_sahibi){
						$response=["message"=>"Kendi ihalenize teklif veremezsiniz.","status"=>500];
						$islem_durum = 0;
					}else if($row->ihale_tarihi." ".$row->ihale_saati < $teklif_tarihi){
						$response=["message"=>"İhalenin süresi dolmuştur.","status"=>500];
						$islem_durum = 0;
					}elseif($verilen_teklif == ""){
						$response=["message"=>"Teklfiniz boş olamaz","status"=>500];
						$islem_durum = 0;
					}  
					else if($verilen_teklif <= $row->acilis_fiyati  ){
						$response=["message"=>"Teklifiniz taban fiyat koşulunu sağlamamaktadır. İhalenin taban fiyatı $row->acilis_fiyati ₺'dir. ","status"=>500];
						$islem_durum = 0;
					}	
					else if($verilen_teklif % $sigorta_min_artis != 0){
						$response=["message"=>"Teklifiniz $sigorta_min_artis ₺ katları olmalı","status"=>500];
						$islem_durum = 0;
					}
					else if($verilen_teklif > $teklif_limiti ){
						$response=["message"=>"Teklif limitini aştınız. Mevcut paketinizin teklif limiti  '".money($teklif_limiti)."' ₺'dir. ","status"=>501];
						$islem_durum = 0;
					} 					
					else if($engelli_sigorta=="true" ){
						$response = ["message"=>"İlanın sigorta şirketine ait olan araçlara teklif vermeniz kısıtlanmıştır.","status"=>500];
						$islem_durum = 0;
					}
					else if($verilen_teklif < $row->son_teklif+$sigorta_min_artis){
						$response=["message"=>"Teklfiniz en yüksek teklifden en az $sigorta_min_artis ₺ fazla olmalı ","status"=>500];
						$islem_durum = 0;
					}  
					else{
						if($sozlesme_kontrol !=1){
							$sigort_cek_onay = mysql_query("select * from sigorta_ozellikleri where id = '".$row->sigorta."'");
							$sigorta_oku_onay = mysql_fetch_object($sigort_cek_onay);
							if($sigorta_oku_onay->teklif_onay_mekanizmasi == 1){
								$response=["message"=>"Teklif verebilmeniz için sözleşmeyi kabul etmelisiniz.","status"=>500];
								$islem_durum = 0;
							}else{
								$ihale_son=$row->ihale_tarihi." ".$row->ihale_saati;
								$ihale_son_str = strtotime($ihale_son);
								$suan_str = strtotime(date("Y-m-d H:i:s"));
								$sonuc=($ihale_son_str-$suan_str)/60;
								if($sonuc>=$belirlenen ){
									$teklif_durum=1;
									$ilan_teklifi=mysql_query("select * from teklifler where ilan_id='".$ilanID."' and durum=1 order by teklif_zamani desc limit 1"); 
									$ilan_teklifi_oku=mysql_fetch_object($ilan_teklifi);
									$teklif_uye_id=$ilan_teklifi_oku->uye_id;
									$ilan_cek = mysql_query("SELECT * FROM ilanlar WHERE id = '".$ilanID."' ");
									$ilan_oku = mysql_fetch_array($ilan_cek);
									$teklif = $ilan_oku['son_teklif'];
									if($verilen_teklif > $teklif){
										if($sonuc>=3 && $teklif_uye_id!='283'){//283 Kaynak Firma Uye ID
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
												// $date=date("Y-m-d H:i:s");
												$date=$teklif_tarihi;
												$tarih=strtotime("-".$sigorta_dakikanin_altinda." minutes",strtotime($ihale_bitis));
												$tarih=date("Y-m-d H:i:s",$tarih);
												if($date>$tarih){
													$gosterilme_tarih=strtotime($yeni_trh)+300; //Gösterilme süresi 5 dk fazla olması istendi
													$gosterilme_tarih=date("Y-m-d H:i:s",$gosterilme_tarih);
													// mysql_query("UPDATE ilanlar SET ihale_son_gosterilme='".$gosterilme_tarih."',son_teklif = '".$verilen_teklif."',sistem_sure_uzatma_durumu='0',ihale_tarihi='".$yeni_t."',ihale_saati='".$yeni_s."' WHERE id='".$ilanID."'");
													mysql_query("UPDATE ilanlar SET ihale_son_gosterilme='".$gosterilme_tarih."',son_teklif = '".$verilen_teklif."' WHERE id='".$ilanID."'");
												}else{
													mysql_query("UPDATE ilanlar SET son_teklif = '".$verilen_teklif."',sistem_sure_uzatma_durumu='0' WHERE id='".$ilanID."'");
												}
											}else{
													mysql_query("UPDATE ilanlar SET son_teklif = '".$verilen_teklif."',sistem_sure_uzatma_durumu='0' WHERE id='".$ilanID."'");
											}
										}else{
											mysql_query("UPDATE ilanlar SET son_teklif = '".$verilen_teklif."' WHERE id='".$ilanID."'");
										}
									}
									if($_SESSION['u_token'] != ""){
										mysql_query("INSERT INTO `teklifler`(`id`,`ilan_id`,`uye_id`,`teklif`,`hizmet_bedeli`,`teklif_zamani`,`user_token`,`dogrudan_satisli_ilan_id`,`kurumsal_token`,ip,tarayici,isletim_sistemi,admin_teklif,admin_id,durum) 
											VALUES (NULL,'".$ilanID."','".$uyeID."','".$verilen_teklif."','".$hizmet_bedel."','".$date."','".$_SESSION['u_token']."','0','','".$ip."','".$tarayici."','".$isletim_sistemi."','0','0','".$teklif_durum."')");
									}elseif($_SESSION['k_token'] != ""){
										mysql_query("INSERT INTO `teklifler`(`id`,`ilan_id`,`uye_id`,`teklif`,`hizmet_bedeli`,`teklif_zamani`,`user_token`,`dogrudan_satisli_ilan_id`,`kurumsal_token`,ip,tarayici,isletim_sistemi,admin_teklif,admin_id,durum) 
											VALUES (NULL,'".$ilanID."','".$uyeID."','".$verilen_teklif."','".$hizmet_bedel."','".$date."','','0','".$_SESSION['k_token']."','".$ip."','".$tarayici."','".$isletim_sistemi."','0','0','".$teklif_durum."')");
									}
									$response=["message"=>"Teklif başarıyla verildi","status"=>200];
									$islem_durum = 1;
								}else{
									$teklif_durum=2;
									$onay_bekleyen_teklifler=mysql_query("select * from teklifler where ilan_id='".$ilanID."' and durum='2'");
									$ayni_teklif=false;
									while($onay_bekleyenler_oku=mysql_fetch_object($onay_bekleyen_teklifler)){
										if($verilen_teklif<=$onay_bekleyenler_oku->teklif){
											$ayni_teklif=true;
										}
									}
									if($ayni_teklif==true){
										$response=["message"=>"Bu teklif başka bir üye tarafından verildi ve onay bekliyor. Lütfen daha yüksek bir teklif vermeyi deneyiniz.","status"=>500];
										$islem_durum = 0;
									}else{
										if($_SESSION['u_token'] != ""){
											mysql_query("INSERT INTO `teklifler`(`id`,`ilan_id`,`uye_id`,`teklif`,`hizmet_bedeli`,`teklif_zamani`,`user_token`,`dogrudan_satisli_ilan_id`,`kurumsal_token`,ip,tarayici,isletim_sistemi,admin_teklif,admin_id,durum) 
												VALUES (NULL,'".$ilanID."','".$uyeID."','".$verilen_teklif."','".$hizmet_bedel."','".$date."','".$_SESSION['u_token']."','0','','".$ip."','".$tarayici."','".$isletim_sistemi."','0','0','".$teklif_durum."')");
										}elseif($_SESSION['k_token'] != ""){
											mysql_query("INSERT INTO `teklifler`(`id`,`ilan_id`,`uye_id`,`teklif`,`hizmet_bedeli`,`teklif_zamani`,`user_token`,`dogrudan_satisli_ilan_id`,`kurumsal_token`,ip,tarayici,isletim_sistemi,admin_teklif,admin_id,durum) 
												VALUES (NULL,'".$ilanID."','".$uyeID."','".$verilen_teklif."','".$hizmet_bedel."','".$date."','','0','".$_SESSION['k_token']."','".$ip."','".$tarayici."','".$isletim_sistemi."','0','0','".$teklif_durum."')");
										}
										$response=["message"=>$alacagi_mesaj,"status"=>200];
										$islem_durum = 1;
									}
								}
							}
						}else{
							$ihale_son=$row->ihale_tarihi." ".$row->ihale_saati;
							$ihale_son_str = strtotime($ihale_son);
							$suan_str = strtotime(date("Y-m-d H:i:s"));
							$sonuc=($ihale_son_str-$suan_str)/60;
							if($sonuc>=$belirlenen ){
								$teklif_durum=1;
								$ilan_teklifi=mysql_query("select * from teklifler where ilan_id='".$ilanID."' and durum=1 order by teklif_zamani desc limit 1"); 
								$ilan_teklifi_oku=mysql_fetch_object($ilan_teklifi);
								$teklif_uye_id=$ilan_teklifi_oku->uye_id;
								$ilan_cek = mysql_query("SELECT * FROM ilanlar WHERE id = '".$ilanID."' ");
								$ilan_oku = mysql_fetch_array($ilan_cek);
								$teklif = $ilan_oku['son_teklif'];
								if($verilen_teklif > $teklif){
									if($sonuc>=3 && $teklif_uye_id!='283'){//283 Kaynak Firma Uye ID
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
											// $date=date("Y-m-d H:i:s");
											$date=$teklif_tarihi;
											$tarih=strtotime("-".$sigorta_dakikanin_altinda." minutes",strtotime($ihale_bitis));
											$tarih=date("Y-m-d H:i:s",$tarih);
											if($date>$tarih){
												$gosterilme_tarih=strtotime($yeni_trh)+300; //Gösterilme süresi 5 dk fazla olması istendi
												$gosterilme_tarih=date("Y-m-d H:i:s",$gosterilme_tarih);
												// mysql_query("UPDATE ilanlar SET ihale_son_gosterilme='".$gosterilme_tarih."',son_teklif = '".$verilen_teklif."',sistem_sure_uzatma_durumu='0',ihale_tarihi='".$yeni_t."',ihale_saati='".$yeni_s."' WHERE id='".$ilanID."'");
												mysql_query("UPDATE ilanlar SET ihale_son_gosterilme='".$gosterilme_tarih."',son_teklif = '".$verilen_teklif."' WHERE id='".$ilanID."'");
											}else{
												mysql_query("UPDATE ilanlar SET son_teklif = '".$verilen_teklif."',sistem_sure_uzatma_durumu='0' WHERE id='".$ilanID."'");
											}
										}else{
												mysql_query("UPDATE ilanlar SET son_teklif = '".$verilen_teklif."',sistem_sure_uzatma_durumu='0' WHERE id='".$ilanID."'");
										}
									}else{
										mysql_query("UPDATE ilanlar SET son_teklif = '".$verilen_teklif."' WHERE id='".$ilanID."'");
									}
								}
								if($_SESSION['u_token'] != ""){
									$test = 1;
									mysql_query("INSERT INTO `teklifler`(`id`,`ilan_id`,`uye_id`,`teklif`,`hizmet_bedeli`,`teklif_zamani`,`user_token`,`dogrudan_satisli_ilan_id`,`kurumsal_token`,ip,tarayici,isletim_sistemi,admin_teklif,admin_id,durum) 
										VALUES (NULL,'".$ilanID."','".$uyeID."','".$verilen_teklif."','".$hizmet_bedel."','".$date."','".$_SESSION['u_token']."','0','','".$ip."','".$tarayici."','".$isletim_sistemi."','0','0','".$teklif_durum."')");
								}elseif($_SESSION['k_token'] != ""){
									$test = 2;
									mysql_query("INSERT INTO `teklifler`(`id`,`ilan_id`,`uye_id`,`teklif`,`hizmet_bedeli`,`teklif_zamani`,`user_token`,`dogrudan_satisli_ilan_id`,`kurumsal_token`,ip,tarayici,isletim_sistemi,admin_teklif,admin_id,durum) 
										VALUES (NULL,'".$ilanID."','".$uyeID."','".$verilen_teklif."','".$hizmet_bedel."','".$date."','','0','".$_SESSION['k_token']."','".$ip."','".$tarayici."','".$isletim_sistemi."','0','0','".$teklif_durum."')");
								}
								$response=["message"=>"Teklif başarıyla verildi","status"=>200];
								$islem_durum = 1;
							}else{
								$teklif_durum=2;
								$onay_bekleyen_teklifler=mysql_query("select * from teklifler where ilan_id='".$ilanID."' and durum='2'");
								$ayni_teklif=false;
								while($onay_bekleyenler_oku=mysql_fetch_object($onay_bekleyen_teklifler)){
									if($verilen_teklif<=$onay_bekleyenler_oku->teklif){
										$ayni_teklif=true;
									}
								}
								if($ayni_teklif==true){
									$response=["message"=>"Bu teklif başka bir üye tarafından verildi ve onay bekliyor. Lütfen daha yüksek bir teklif vermeyi deneyiniz.","status"=>500];
									$islem_durum = 0;
								}
								else{
									if($_SESSION['u_token'] != ""){
										mysql_query("INSERT INTO `teklifler`(`id`,`ilan_id`,`uye_id`,`teklif`,`hizmet_bedeli`,`teklif_zamani`,`user_token`,`dogrudan_satisli_ilan_id`,`kurumsal_token`,ip,tarayici,isletim_sistemi,admin_teklif,admin_id,durum) 
											VALUES (NULL,'".$ilanID."','".$uyeID."','".$verilen_teklif."','".$hizmet_bedel."','".$date."','".$_SESSION['u_token']."','0','','".$ip."','".$tarayici."','".$isletim_sistemi."','0','0','".$teklif_durum."')");
									}elseif($_SESSION['k_token'] != ""){
										mysql_query("INSERT INTO `teklifler`(`id`,`ilan_id`,`uye_id`,`teklif`,`hizmet_bedeli`,`teklif_zamani`,`user_token`,`dogrudan_satisli_ilan_id`,`kurumsal_token`,ip,tarayici,isletim_sistemi,admin_teklif,admin_id,durum) 
											VALUES (NULL,'".$ilanID."','".$uyeID."','".$verilen_teklif."','".$hizmet_bedel."','".$date."','','0','".$_SESSION['k_token']."','".$ip."','".$tarayici."','".$isletim_sistemi."','0','0','".$teklif_durum."')");
									}
									$response=["message"=>$alacagi_mesaj,"status"=>200];
									$islem_durum = 1;
								}
							}
						}
					}
				}
			}
			// İhale türü 1 ise bitiş
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
						$response = ["message"=>"Sistem tarafından teklif vermeniz kısıtlanmıştır.Müşteri temsilcileri ile iletişime geçebilirsiniz.","status"=>500];
						$islem_durum = 0;
					}else if($engelli_sigorta=="true" ){
						$response = ["message"=>"İlanın sigorta şirketine ait olan araçlara teklif vermeniz kısıtlanmıştır.","status"=>500];
						$islem_durum = 0;
					}else{
						if($uye_tkn == ""){
							$response=["message"=>"Teklif verebilmek için giriş yapmalısınız","status"=>500];
							$islem_durum = 0;
						}else if($uye_tkn == $row->ihale_sahibi){
							$response=["message"=>"Kendi ihalenize teklif veremezsiniz.","status"=>500];
							$islem_durum = 0;
						}else if($row->ihale_tarihi." ".$row->ihale_saati < $teklif_tarihi){
							$response=["message"=>"İhalenin süresi dolmuştur.","status"=>500];
							$islem_durum = 0;
						}else if($verilen_teklif == ""){
							$response=["message"=>"Teklfiniz boş olamaz","status"=>500];
							$islem_durum = 0;
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
							$response=["message"=>"Teklif limitini aştınız. Mevcut paketinizin teklif limiti '".money($teklif_limiti)."' ₺'dir. ","status"=>502];
							$islem_durum = 0;
						} 						
						else if($verilen_teklif < $row->acilis_fiyati+$sigorta_min_artis){
							$response=["message"=>"Teklfiniz taban fiyattan en az $sigorta_min_artis ₺ fazla olmalı ","status"=>500];
							$islem_durum = 0;
						}else{
							if($sozlesme_kontrol !=1){
								$sigort_cek_onay = mysql_query("select * from sigorta_ozellikleri where id = '".$row->sigorta."'");
								$sigorta_oku_onay = mysql_fetch_object($sigort_cek_onay);
								if($sigorta_oku_onay->teklif_onay_mekanizmasi == 1){
									$response=["message"=>"Teklif verebilmeniz için sözleşmeyi kabul etmelisiniz.","status"=>500];
									$islem_durum = 0;
								}else{
									$ihale_son=$row->ihale_tarihi." ".$row->ihale_saati;
									$ihale_son_str = strtotime($ihale_son);
									$suan_str = strtotime(date("Y-m-d H:i:s"));
									$sonuc=($ihale_son_str-$suan_str)/60;
									if($sonuc>=$belirlenen ){
										$teklif_durum=1;
										if($_SESSION['u_token'] != ""){
										mysql_query("INSERT INTO `teklifler`(`id`,`ilan_id`,`uye_id`,`teklif`,`hizmet_bedeli`,`teklif_zamani`,`user_token`,`dogrudan_satisli_ilan_id`,`kurumsal_token`,ip,tarayici,isletim_sistemi,admin_teklif,admin_id,durum) 
											VALUES (NULL,'".$ilanID."','".$uyeID."','".$verilen_teklif."','".$hizmet_bedel."','".$date."','".$_SESSION['u_token']."','0','','".$ip."','".$tarayici."','".$isletim_sistemi."','0','0','".$teklif_durum."')");
										}elseif($_SESSION['k_token'] != ""){
											mysql_query("INSERT INTO `teklifler`(`id`,`ilan_id`,`uye_id`,`teklif`,`hizmet_bedeli`,`teklif_zamani`,`user_token`,`dogrudan_satisli_ilan_id`,`kurumsal_token`,ip,tarayici,isletim_sistemi,admin_teklif,admin_id,durum) 
												VALUES (NULL,'".$ilanID."','".$uyeID."','".$verilen_teklif."','".$hizmet_bedel."','".$date."','','0','".$_SESSION['k_token']."','".$ip."','".$tarayici."','".$isletim_sistemi."','0','0','".$teklif_durum."')");
										}
										$teklif_cek=mysql_query("select * from teklifler where ilan_id='".$ilanID."' and durum=1 group by uye_id order by teklif_zamani ");
										$teklifler_array=array();
										$kaynak_firma_teklifi='';
										while($teklif_oku=mysql_fetch_object($teklif_cek)){
											$teklifleri_cek=mysql_query("select * from teklifler where ilan_id='".$ilanID."' and uye_id='".$teklif_oku->uye_id."' order by teklif_zamani desc limit 1 ");
											$teklifleri_oku=mysql_fetch_object($teklifleri_cek);
											$pushla=array_push($teklifler_array,$teklifleri_oku->teklif);
											if($teklif_oku->uye_id=='283'){
												$kaynak_firma_teklifi=$teklifleri_oku->teklif;
											}
										}
										$ilani_guncelle=mysql_query("update ilanlar set son_teklif='".max($teklifler_array)."' where id='".$ilanID."'");
										$i_cek=mysql_query("select * from ilanlar where id='".$ilanID."'");
										$i_oku=mysql_fetch_array($i_cek);
										$t_cek=mysql_query("select * from teklifler where ilan_id='".$ilanID."' and durum=1 group by uye_id order by teklif_zamani ");
										while($t_oku=mysql_fetch_object($t_cek)){
											$tt_cek=mysql_query("select * from teklifler where ilan_id='".$ilanID."' and uye_id='".$t_oku->uye_id."' order by teklif_zamani desc limit 1 ");
											$tt_oku=mysql_fetch_object($tt_cek);
											if($i_oku["son_teklif"]=$tt_oku->teklif){
												$son_teklif_uye_id=$tt_oku->uye_id;
											}
										}
										if($sonuc>=3){
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
												// $date=date("Y-m-d H:i:s");
												$date=$teklif_tarihi;
												$tarih=strtotime("-".$sigorta_dakikanin_altinda." minutes",strtotime($ihale_bitis));
												$tarih=date("Y-m-d H:i:s",$tarih);
												if($date>$tarih){//Kaynak firma uye id 283
													$gosterilme_tarih=strtotime($yeni_trh)+300; //Gösterilme süresi 5 dk fazla olması istendi
													$gosterilme_tarih=date("Y-m-d H:i:s",$gosterilme_tarih);
													if($son_teklif_uye_id!="283"){
														// $ilani_guncelle=mysql_query("update ilanlar set ihale_son_gosterilme='".$gosterilme_tarih."',sistem_sure_uzatma_durumu='0',ihale_tarihi='".$yeni_t."',ihale_saati='".$yeni_s."' where id='".$ilanID."'");
														$ilani_guncelle=mysql_query("update ilanlar set sistem_sure_uzatma_durumu='0' where id='".$ilanID."'");
													}else{
														// $ilani_guncelle=mysql_query("update ilanlar set ihale_son_gosterilme='".$gosterilme_tarih."',ihale_tarihi='".$yeni_t."',ihale_saati='".$yeni_s."' where id='".$ilanID."'");
													}
												}else{
													if($son_teklif_uye_id!="283"){
														$ilani_guncelle=mysql_query("update ilanlar set sistem_sure_uzatma_durumu='0' where id='".$ilanID."'");
													}
												}
											}else{
												if($son_teklif_uye_id!="283"){
													$ilani_guncelle=mysql_query("update ilanlar set sistem_sure_uzatma_durumu='0' where id='".$ilanID."'");
												}
											}
										}
										if($ilani_guncelle){
											$response=["message"=>"Teklif başarıyla verildi","status"=>200 ];
											$islem_durum = 1;
										}else{
											$response=["message"=>"hata","status"=>500 ];
											$islem_durum = 0;
										}
									}else{
										$teklif_durum=2;
										$onay_bekleyen_teklifler=mysql_query("select * from teklifler where ilan_id='".$ilanID."' and durum='2'");
										$ayni_teklif=false;
										while($onay_bekleyenler_oku=mysql_fetch_object($onay_bekleyen_teklifler)){
											if($verilen_teklif<=$onay_bekleyenler_oku->teklif){
												$ayni_teklif=true;
											}
										}
										if($ayni_teklif==true){
											$response=["message"=>"Bu teklif başka bir üye tarafından verildi ve onay bekliyor. Lütfen daha yüksek bir teklif vermeyi deneyiniz.","status"=>500];
											$islem_durum = 0;
										}
										else{
											if($_SESSION['u_token'] != ""){
												mysql_query("INSERT INTO `teklifler`(`id`,`ilan_id`,`uye_id`,`teklif`,`hizmet_bedeli`,`teklif_zamani`,`user_token`,`dogrudan_satisli_ilan_id`,`kurumsal_token`,ip,tarayici,isletim_sistemi,admin_teklif,admin_id,durum) 
													VALUES (NULL,'".$ilanID."','".$uyeID."','".$verilen_teklif."','".$hizmet_bedel."','".$date."','".$_SESSION['u_token']."','0','','".$ip."','".$tarayici."','".$isletim_sistemi."','0','0','".$teklif_durum."')");
											}elseif($_SESSION['k_token'] != ""){
												mysql_query("INSERT INTO `teklifler`(`id`,`ilan_id`,`uye_id`,`teklif`,`hizmet_bedeli`,`teklif_zamani`,`user_token`,`dogrudan_satisli_ilan_id`,`kurumsal_token`,ip,tarayici,isletim_sistemi,admin_teklif,admin_id,durum) 
													VALUES (NULL,'".$ilanID."','".$uyeID."','".$verilen_teklif."','".$hizmet_bedel."','".$date."','','0','".$_SESSION['k_token']."','".$ip."','".$tarayici."','".$isletim_sistemi."','0','0','".$teklif_durum."')");
											}
											$response=["message"=>$alacagi_mesaj,"status"=>200];
											$islem_durum = 1;
										}
									}	
								}
							}else{
								$ihale_son=$row->ihale_tarihi." ".$row->ihale_saati;
								$ihale_son_str = strtotime($ihale_son);
								$suan_str = strtotime(date("Y-m-d H:i:s"));
								$sonuc=($ihale_son_str-$suan_str)/60;
								if($sonuc>=$belirlenen ){
									$teklif_durum=1;
									if($_SESSION['u_token'] != ""){
									mysql_query("INSERT INTO `teklifler`(`id`,`ilan_id`,`uye_id`,`teklif`,`hizmet_bedeli`,`teklif_zamani`,`user_token`,`dogrudan_satisli_ilan_id`,`kurumsal_token`,ip,tarayici,isletim_sistemi,admin_teklif,admin_id,durum) 
										VALUES (NULL,'".$ilanID."','".$uyeID."','".$verilen_teklif."','".$hizmet_bedel."','".$date."','".$_SESSION['u_token']."','0','','".$ip."','".$tarayici."','".$isletim_sistemi."','0','0','".$teklif_durum."')");
									}elseif($_SESSION['k_token'] != ""){
										mysql_query("INSERT INTO `teklifler`(`id`,`ilan_id`,`uye_id`,`teklif`,`hizmet_bedeli`,`teklif_zamani`,`user_token`,`dogrudan_satisli_ilan_id`,`kurumsal_token`,ip,tarayici,isletim_sistemi,admin_teklif,admin_id,durum) 
											VALUES (NULL,'".$ilanID."','".$uyeID."','".$verilen_teklif."','".$hizmet_bedel."','".$date."','','0','".$_SESSION['k_token']."','".$ip."','".$tarayici."','".$isletim_sistemi."','0','0','".$teklif_durum."')");
									}
									$teklif_cek=mysql_query("select * from teklifler where ilan_id='".$ilanID."' and durum=1 group by uye_id order by teklif_zamani ");
									$teklifler_array=array();
									$kaynak_firma_teklifi='';
									while($teklif_oku=mysql_fetch_object($teklif_cek)){
										$teklifleri_cek=mysql_query("select * from teklifler where ilan_id='".$ilanID."' and uye_id='".$teklif_oku->uye_id."' order by teklif_zamani desc limit 1 ");
										$teklifleri_oku=mysql_fetch_object($teklifleri_cek);
										$pushla=array_push($teklifler_array,$teklifleri_oku->teklif);
										if($teklif_oku->uye_id=='283'){
											$kaynak_firma_teklifi=$teklifleri_oku->teklif;
										}
									}
									$ilani_guncelle=mysql_query("update ilanlar set son_teklif='".max($teklifler_array)."' where id='".$ilanID."'");
									$i_cek=mysql_query("select * from ilanlar where id='".$ilanID."'");
									$i_oku=mysql_fetch_array($i_cek);
									$t_cek=mysql_query("select * from teklifler where ilan_id='".$ilanID."' and durum=1 group by uye_id order by teklif_zamani ");
									while($t_oku=mysql_fetch_object($t_cek)){
										$tt_cek=mysql_query("select * from teklifler where ilan_id='".$ilanID."' and uye_id='".$t_oku->uye_id."' order by teklif_zamani desc limit 1 ");
										$tt_oku=mysql_fetch_object($tt_cek);
										if($i_oku["son_teklif"]=$tt_oku->teklif){
											$son_teklif_uye_id=$tt_oku->uye_id;
										}
									}
									if($sonuc>=3){
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
											// $date=date("Y-m-d H:i:s");
											$date=$teklif_tarihi;
											$tarih=strtotime("-".$sigorta_dakikanin_altinda." minutes",strtotime($ihale_bitis));
											$tarih=date("Y-m-d H:i:s",$tarih);
											if($date>$tarih){//Kaynak firma uye id 283
												$gosterilme_tarih=strtotime($yeni_trh)+300; //Gösterilme süresi 5 dk fazla olması istendi
												$gosterilme_tarih=date("Y-m-d H:i:s",$gosterilme_tarih);
												if($son_teklif_uye_id!="283"){
													// $ilani_guncelle=mysql_query("update ilanlar set ihale_son_gosterilme='".$gosterilme_tarih."',sistem_sure_uzatma_durumu='0',ihale_tarihi='".$yeni_t."',ihale_saati='".$yeni_s."' where id='".$ilanID."'");
													$ilani_guncelle=mysql_query("update ilanlar set sistem_sure_uzatma_durumu='0' where id='".$ilanID."'");
												}else{
													// $ilani_guncelle=mysql_query("update ilanlar set ihale_son_gosterilme='".$gosterilme_tarih."',ihale_tarihi='".$yeni_t."',ihale_saati='".$yeni_s."' where id='".$ilanID."'");
												}
											}else{
												if($son_teklif_uye_id!="283"){
													$ilani_guncelle=mysql_query("update ilanlar set sistem_sure_uzatma_durumu='0' where id='".$ilanID."'");
												}
											}
										}else{
											if($son_teklif_uye_id!="283"){
												$ilani_guncelle=mysql_query("update ilanlar set sistem_sure_uzatma_durumu='0' where id='".$ilanID."'");
											}
										}
									}
									if($ilani_guncelle){
										$response=["message"=>"Teklif başarıyla verildi","status"=>200];
										$islem_durum = 1;
									}else{
										$response=["message"=>"hata","status"=>500];
										$islem_durum = 0;
									}
								}else{
									$teklif_durum=2;
									$onay_bekleyen_teklifler=mysql_query("select * from teklifler where ilan_id='".$ilanID."' and durum='2'");
									$ayni_teklif=false;
									while($onay_bekleyenler_oku=mysql_fetch_object($onay_bekleyen_teklifler)){
										if($verilen_teklif<=$onay_bekleyenler_oku->teklif){
											$ayni_teklif=true;
										}
									}
									if($ayni_teklif==true){
										$response=["message"=>"Bu teklif başka bir üye tarafından verildi ve onay bekliyor. Lütfen daha yüksek bir teklif vermeyi deneyiniz.","status"=>500];
										$islem_durum = 0;
									}
									else{
										if($_SESSION['u_token'] != ""){
											mysql_query("INSERT INTO `teklifler`(`id`,`ilan_id`,`uye_id`,`teklif`,`hizmet_bedeli`,`teklif_zamani`,`user_token`,`dogrudan_satisli_ilan_id`,`kurumsal_token`,ip,tarayici,isletim_sistemi,admin_teklif,admin_id,durum) 
												VALUES (NULL,'".$ilanID."','".$uyeID."','".$verilen_teklif."','".$hizmet_bedel."','".$date."','".$_SESSION['u_token']."','0','','".$ip."','".$tarayici."','".$isletim_sistemi."','0','0','".$teklif_durum."')");
										}elseif($_SESSION['k_token'] != ""){
											mysql_query("INSERT INTO `teklifler`(`id`,`ilan_id`,`uye_id`,`teklif`,`hizmet_bedeli`,`teklif_zamani`,`user_token`,`dogrudan_satisli_ilan_id`,`kurumsal_token`,ip,tarayici,isletim_sistemi,admin_teklif,admin_id,durum) 
												VALUES (NULL,'".$ilanID."','".$uyeID."','".$verilen_teklif."','".$hizmet_bedel."','".$date."','','0','".$_SESSION['k_token']."','".$ip."','".$tarayici."','".$isletim_sistemi."','0','0','".$teklif_durum."')");
										}
										$response=["message"=>$alacagi_mesaj,"status"=>200];
										$islem_durum = 1;
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
					$response = ["message"=>"Sistem tarafından teklif vermeniz kısıtlanmıştır.Müşteri temsilcileri ile iletişime geçebilirsiniz.","status"=>500];
					$islem_durum = 0;
				}else{
					if($uye_tkn == ""){
						$response=["message"=>"Teklif verebilmek için giriş yapmalısınız","status"=>500];
						$islem_durum = 0;
					}else if($uye_tkn == $row->ihale_sahibi){
						$response=["message"=>"Kendi ihalenize teklif veremezsiniz.","status"=>500];
						$islem_durum = 0;
					}else if($row->ihale_tarihi." ".$row->ihale_saati < $teklif_tarihi){
						$response=["message"=>"İhalenin süresi dolmuştur.","status"=>500];
						$islem_durum = 0;
					}else if($verilen_teklif == ""){
						$response=["message"=>"Teklfiniz boş olamaz","status"=>500];
						$islem_durum = 0;
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
						$response=["message"=>"Teklif limitini aştınız. Mevcut paketinizin teklif limiti '".money($teklif_limiti)."' ₺'dir. ","status"=>503];
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
						if($sozlesme_kontrol !=1){
							$sigort_cek_onay = mysql_query("select * from sigorta_ozellikleri where id = '".$row->sigorta."'");
							$sigorta_oku_onay = mysql_fetch_object($sigort_cek_onay);
							if($sigorta_oku_onay->teklif_onay_mekanizmasi == 1){
								$response=["message"=>"Teklif verebilmeniz için sözleşmeyi kabul etmelisiniz.","status"=>500];
								$islem_durum = 0;
							}else{
								$ihale_son=$row->ihale_tarihi." ".$row->ihale_saati;
								$ihale_son_str = strtotime($ihale_son);
								$suan_str = strtotime(date("Y-m-d H:i:s"));
								$sonuc=($ihale_son_str-$suan_str)/60;
								if($sonuc>=$belirlenen ){
									$teklif_durum=1;
									if($_SESSION['u_token'] != ""){
									mysql_query("INSERT INTO `teklifler`(`id`,`ilan_id`,`uye_id`,`teklif`,`hizmet_bedeli`,`teklif_zamani`,`user_token`,`dogrudan_satisli_ilan_id`,`kurumsal_token`,ip,tarayici,isletim_sistemi,admin_teklif,admin_id,durum) 
										VALUES (NULL,'".$ilanID."','".$uyeID."','".$verilen_teklif."','".$hizmet_bedel."','".$date."','".$_SESSION['u_token']."','0','','".$ip."','".$tarayici."','".$isletim_sistemi."','0','0','".$teklif_durum."')");
									}elseif($_SESSION['k_token'] != ""){
										mysql_query("INSERT INTO `teklifler`(`id`,`ilan_id`,`uye_id`,`teklif`,`hizmet_bedeli`,`teklif_zamani`,`user_token`,`dogrudan_satisli_ilan_id`,`kurumsal_token`,ip,tarayici,isletim_sistemi,admin_teklif,admin_id,durum) 
											VALUES (NULL,'".$ilanID."','".$uyeID."','".$verilen_teklif."','".$hizmet_bedel."','".$date."','','0','".$_SESSION['k_token']."','".$ip."','".$tarayici."','".$isletim_sistemi."','0','0','".$teklif_durum."')");
									}
									$kaynak_firma_teklifi='';
									$teklif_cek=mysql_query("select * from teklifler where ilan_id='".$ilanID."' and durum=1 group by uye_id order by teklif_zamani ");
									$teklifler_array=array();
									while($teklif_oku=mysql_fetch_object($teklif_cek)){
										$teklifleri_cek=mysql_query("select * from teklifler where ilan_id='".$ilanID."' and uye_id='".$teklif_oku->uye_id."' order by teklif_zamani desc limit 1 ");
										$teklifleri_oku=mysql_fetch_object($teklifleri_cek);
										$pushla=array_push($teklifler_array,$teklifleri_oku->teklif);
									}
									$ilani_guncelle=mysql_query("update ilanlar set son_teklif='".max($teklifler_array)."' where id='".$ilanID."'");
									$i_cek=mysql_query("select * from ilanlar where id='".$ilanID."'");
									$i_oku=mysql_fetch_array($i_cek);
									$t_cek=mysql_query("select * from teklifler where ilan_id='".$ilanID."' and durum=1 group by uye_id order by teklif_zamani ");
									while($t_oku=mysql_fetch_object($t_cek)){
										$tt_cek=mysql_query("select * from teklifler where ilan_id='".$ilanID."' and uye_id='".$t_oku->uye_id."' order by teklif_zamani desc limit 1 ");
										$tt_oku=mysql_fetch_object($tt_cek);
										if($i_oku["son_teklif"]=$tt_oku->teklif){
											$son_teklif_uye_id=$tt_oku->uye_id;
										}
									}
									if($sonuc>=3){
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
											// $date=date("Y-m-d H:i:s");
											$date=$teklif_tarihi;
											$tarih=strtotime("-".$sigorta_dakikanin_altinda." minutes",strtotime($ihale_bitis));
											$tarih=date("Y-m-d H:i:s",$tarih);
											
											if($date>$tarih){//Kaynak firma uye id 283
												$gosterilme_tarih=strtotime($yeni_trh)+300; //Gösterilme süresi 5 dk fazla olması istendi
												$gosterilme_tarih=date("Y-m-d H:i:s",$gosterilme_tarih);
												if($son_teklif_uye_id!="283"){
													// $ilani_guncelle=mysql_query("update ilanlar set ihale_son_gosterilme='".$gosterilme_tarih."',sistem_sure_uzatma_durumu='0',ihale_tarihi='".$yeni_t."',ihale_saati='".$yeni_s."' where id='".$ilanID."'");
													$ilani_guncelle=mysql_query("update ilanlar set sistem_sure_uzatma_durumu='0' where id='".$ilanID."'");
												}else{
													// $ilani_guncelle=mysql_query("update ilanlar set ihale_son_gosterilme='".$gosterilme_tarih."',ihale_tarihi='".$yeni_t."',ihale_saati='".$yeni_s."' where id='".$ilanID."'");
												}
											}else{
												if($son_teklif_uye_id!="283"){
													$ilani_guncelle=mysql_query("update ilanlar set sistem_sure_uzatma_durumu='0' where id='".$ilanID."'");
												}
											}
										}else{
											if($son_teklif_uye_id!="283"){
												$ilani_guncelle=mysql_query("update ilanlar set sistem_sure_uzatma_durumu='0' where id='".$ilanID."'");
											}
										}
									}
									if($ilani_guncelle){
										$response=["message"=>"Teklif başarıyla verildi","status"=>200];
										$islem_durum = 1;
									}else{
										$response=["message"=>"hata","status"=>500];
										$islem_durum = 0;
									}
								}else{
									$teklif_durum=2;
									$onay_bekleyen_teklifler=mysql_query("select * from teklifler where ilan_id='".$ilanID."' and durum='2'");
									$ayni_teklif=false;
									while($onay_bekleyenler_oku=mysql_fetch_object($onay_bekleyen_teklifler)){
										if($verilen_teklif<=$onay_bekleyenler_oku->teklif){
											$ayni_teklif=true;
										}
									}
									if($ayni_teklif==true){
										$response=["message"=>"Bu teklif başka bir üye tarafından verildi ve onay bekliyor. Lütfen daha yüksek bir teklif vermeyi deneyiniz.","status"=>500];
										$islem_durum = 0;
									}
									else{
										if($_SESSION['u_token'] != ""){
											mysql_query("INSERT INTO `teklifler`(`id`,`ilan_id`,`uye_id`,`teklif`,`hizmet_bedeli`,`teklif_zamani`,`user_token`,`dogrudan_satisli_ilan_id`,`kurumsal_token`,ip,tarayici,isletim_sistemi,admin_teklif,admin_id,durum) 
												VALUES (NULL,'".$ilanID."','".$uyeID."','".$verilen_teklif."','".$hizmet_bedel."','".$date."','".$_SESSION['u_token']."','0','','".$ip."','".$tarayici."','".$isletim_sistemi."','0','0','".$teklif_durum."')");
										}elseif($_SESSION['k_token'] != ""){
											mysql_query("INSERT INTO `teklifler`(`id`,`ilan_id`,`uye_id`,`teklif`,`hizmet_bedeli`,`teklif_zamani`,`user_token`,`dogrudan_satisli_ilan_id`,`kurumsal_token`,ip,tarayici,isletim_sistemi,admin_teklif,admin_id,durum) 
												VALUES (NULL,'".$ilanID."','".$uyeID."','".$verilen_teklif."','".$hizmet_bedel."','".$date."','0','','".$_SESSION['k_token']."','".$ip."','".$tarayici."','".$isletim_sistemi."','0','0','".$teklif_durum."')");
										}
										$response=["message"=>$alacagi_mesaj,"status"=>200];
										$islem_durum = 1;
									}
								}
							}
						}else{
							$ihale_son=$row->ihale_tarihi." ".$row->ihale_saati;
							$ihale_son_str = strtotime($ihale_son);
							$suan_str = strtotime(date("Y-m-d H:i:s"));
							$sonuc=($ihale_son_str-$suan_str)/60;
							if($sonuc>=$belirlenen ){
								$teklif_durum=1;
								if($_SESSION['u_token'] != ""){
								mysql_query("INSERT INTO `teklifler`(`id`,`ilan_id`,`uye_id`,`teklif`,`hizmet_bedeli`,`teklif_zamani`,`user_token`,`dogrudan_satisli_ilan_id`,`kurumsal_token`,ip,tarayici,isletim_sistemi,admin_teklif,admin_id,durum) 
									VALUES (NULL,'".$ilanID."','".$uyeID."','".$verilen_teklif."','".$hizmet_bedel."','".$date."','".$_SESSION['u_token']."','0','','".$ip."','".$tarayici."','".$isletim_sistemi."','0','0','".$teklif_durum."')");
								}elseif($_SESSION['k_token'] != ""){
									mysql_query("INSERT INTO `teklifler`(`id`,`ilan_id`,`uye_id`,`teklif`,`hizmet_bedeli`,`teklif_zamani`,`user_token`,`dogrudan_satisli_ilan_id`,`kurumsal_token`,ip,tarayici,isletim_sistemi,admin_teklif,admin_id,durum) 
										VALUES (NULL,'".$ilanID."','".$uyeID."','".$verilen_teklif."','".$hizmet_bedel."','".$date."','','0','".$_SESSION['k_token']."','".$ip."','".$tarayici."','".$isletim_sistemi."','0','0','".$teklif_durum."')");
								}
								$kaynak_firma_teklifi='';
								$teklif_cek=mysql_query("select * from teklifler where ilan_id='".$ilanID."' and durum=1 group by uye_id order by teklif_zamani ");
								$teklifler_array=array();
								while($teklif_oku=mysql_fetch_object($teklif_cek)){
									$teklifleri_cek=mysql_query("select * from teklifler where ilan_id='".$ilanID."' and uye_id='".$teklif_oku->uye_id."' order by teklif_zamani desc limit 1 ");
									$teklifleri_oku=mysql_fetch_object($teklifleri_cek);
									$pushla=array_push($teklifler_array,$teklifleri_oku->teklif);
								}
								$ilani_guncelle=mysql_query("update ilanlar set son_teklif='".max($teklifler_array)."' where id='".$ilanID."'");
								$i_cek=mysql_query("select * from ilanlar where id='".$ilanID."'");
								$i_oku=mysql_fetch_array($i_cek);
								$t_cek=mysql_query("select * from teklifler where ilan_id='".$ilanID."' and durum=1 group by uye_id order by teklif_zamani ");
								while($t_oku=mysql_fetch_object($t_cek)){
									$tt_cek=mysql_query("select * from teklifler where ilan_id='".$ilanID."' and uye_id='".$t_oku->uye_id."' order by teklif_zamani desc limit 1 ");
									$tt_oku=mysql_fetch_object($tt_cek);
									if($i_oku["son_teklif"]=$tt_oku->teklif){
										$son_teklif_uye_id=$tt_oku->uye_id;
									}
								}
								if($sonuc>=3){
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
										// $date=date("Y-m-d H:i:s");
										$date=$teklif_tarihi;
										$tarih=strtotime("-".$sigorta_dakikanin_altinda." minutes",strtotime($ihale_bitis));
										$tarih=date("Y-m-d H:i:s",$tarih);
										if($date>$tarih){//Kaynak firma uye id 283
											$gosterilme_tarih=strtotime($yeni_trh)+300; //Gösterilme süresi 5 dk fazla olması istendi
											$gosterilme_tarih=date("Y-m-d H:i:s",$gosterilme_tarih);
											if($son_teklif_uye_id!="283"){
												// $ilani_guncelle=mysql_query("update ilanlar set ihale_son_gosterilme='".$gosterilme_tarih."',sistem_sure_uzatma_durumu='0',ihale_tarihi='".$yeni_t."',ihale_saati='".$yeni_s."' where id='".$ilanID."'");
												$ilani_guncelle=mysql_query("update ilanlar set sistem_sure_uzatma_durumu='0' where id='".$ilanID."'");
											}else{
												// $ilani_guncelle=mysql_query("update ilanlar set ihale_son_gosterilme='".$gosterilme_tarih."',ihale_tarihi='".$yeni_t."',ihale_saati='".$yeni_s."' where id='".$ilanID."'");
											}
										}else{
											if($son_teklif_uye_id!="283"){
												$ilani_guncelle=mysql_query("update ilanlar set sistem_sure_uzatma_durumu='0' where id='".$ilanID."'");
											}
										}
									}else{
										if($son_teklif_uye_id!="283"){
											$ilani_guncelle=mysql_query("update ilanlar set sistem_sure_uzatma_durumu='0' where id='".$ilanID."'");
										}
									}
								}
								if($ilani_guncelle){
									$response=["message"=>"Teklif başarıyla verildi","status"=>200 ];
									$islem_durum = 1;
								}else{
									$response=["message"=>"hata","status"=>500 ];
									$islem_durum = 0;
								}
							}else{
								$teklif_durum=2;
								$onay_bekleyen_teklifler=mysql_query("select * from teklifler where ilan_id='".$ilanID."' and durum='2'");
								$ayni_teklif=false;
								while($onay_bekleyenler_oku=mysql_fetch_object($onay_bekleyen_teklifler)){
									if($verilen_teklif<=$onay_bekleyenler_oku->teklif){
										$ayni_teklif=true;
									}
								}
								if($ayni_teklif==true){
									$response=["message"=>"Bu teklif başka bir üye tarafından verildi ve onay bekliyor. Lütfen daha yüksek bir teklif vermeyi deneyiniz.","status"=>500];
									$islem_durum = 0;
								}
								else{
									if($_SESSION['u_token'] != ""){
										mysql_query("INSERT INTO `teklifler`(`id`,`ilan_id`,`uye_id`,`teklif`,`hizmet_bedeli`,`teklif_zamani`,`user_token`,`dogrudan_satisli_ilan_id`,`kurumsal_token`,ip,tarayici,isletim_sistemi,admin_teklif,admin_id,durum) 
											VALUES (NULL,'".$ilanID."','".$uyeID."','".$verilen_teklif."','".$hizmet_bedel."','".$date."','".$_SESSION['u_token']."','0','','".$ip."','".$tarayici."','".$isletim_sistemi."','0','0','".$teklif_durum."')");
									}elseif($_SESSION['k_token'] != ""){
										mysql_query("INSERT INTO `teklifler`(`id`,`ilan_id`,`uye_id`,`teklif`,`hizmet_bedeli`,`teklif_zamani`,`user_token`,`dogrudan_satisli_ilan_id`,`kurumsal_token`,ip,tarayici,isletim_sistemi,admin_teklif,admin_id,durum) 
											VALUES (NULL,'".$ilanID."','".$uyeID."','".$verilen_teklif."','".$hizmet_bedel."','".$date."','0','','".$_SESSION['k_token']."','".$ip."','".$tarayici."','".$isletim_sistemi."','0','0','".$teklif_durum."')");
									}
									$response=["message"=>$alacagi_mesaj,"status"=>200];
									$islem_durum = 1;
								}
							}
						}
					}
				}
			}
		}
		if($islem_durum == 1 && $teklif_durum == 1){
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
				// $suan = strtotime(date('Y-m-d H:i:s'));
				$suan = strtotime($teklif_tarihi);
				$fark = $ilan_bitis - $suan;
				if($fark < $kac_saniyenin_altinda){				
					$yeni_trh=strtotime("+".$uzayacak_dikaka." minutes",strtotime($ilan_bitis));
					$yeni_trh=date("Y-m-d H:i:s",$yeni_trh);
					$yeni_trh = date('Y-m-d H:i:s', strtotime('+'.$uzayacak_dikaka.' minutes', strtotime($ilan_oku->ihale_tarihi." ".$ilan_oku->ihale_saati)));
					$explode=explode(" ",$yeni_trh);
					$yeni_t=$explode[0];
					$yeni_s=$explode[1];
					$gosterilme_tarih=strtotime($yeni_trh)+300; //Gösterilme süresi 5 dk fazla olması istendi.
					$gosterilme_tarih = date('Y-m-d H:i:s',$gosterilme_tarih);
					mysql_query("UPDATE ilanlar SET ihale_tarihi='".$yeni_t."', ihale_saati='".$yeni_s."', ihale_son_gosterilme='".$gosterilme_tarih."' WHERE id='".$ilanID."'");
				}
			}
		}
		echo json_encode($response);
	}
	if(re("action")=="checked_kontrol"){
		$response=[];
		$ilanID = re('ilanID');
		$uye_tkn = re('uye_token');
		$user_sql=mysql_query("select * from user where user_token='".$uye_tkn."' or kurumsal_user_token='".$uye_tkn."' ");
		$user_row=mysql_fetch_object($user_sql);
		$uyeID=$user_row->id;
		$sorgu=mysql_query("select * from teklifler where ilan_id='".$ilanID."' and uye_id='".$uyeID."' ");
		if($sorgu){
			if(mysql_num_rows($sorgu)>=1){
				$response=["status"=>200,"a"=>"true"];
			}else{
				$response=["status"=>500,"a"=>"asdasd"];
			}
		}else{
			$response=["status"=>500,"a"=>"sorgu hata"];
		}
		echo json_encode($response);
	}	
	if(re("action")=="teklif_kontrol"){
		$response=[];
		$ilanID = re('ilanID');
		$komsiyon = re('son_komsiyon');
		$uye_tkn = re('uye_token');
		$user_sql=mysql_query("select * from user where user_token='".$uye_tkn."' or kurumsal_user_token='".$uye_tkn."' ");
		$user_row=mysql_fetch_object($user_sql);
		$uyeID=$user_row->id;
		
		$teklif = re('teklif');
		$sorgu=mysql_query("select * from ilanlar where id='".$ilanID."' ");
		$row=mysql_fetch_object($sorgu);
		$sigorta_id=$row->sigorta;
		$sorgu2=mysql_query("select * from teklif_limiti where uye_id='".$uyeID."' ");
		$row2=mysql_fetch_object($sorgu2);
		
		$uye_paket=$u_row->paket;
		$uye_paket_cek=mysql_query("select * from uye_grubu where id='".$uye_paket."'");
		$uye_paket_oku=mysql_fetch_object($uye_paket_cek);
		
		$uye_paket=$user_row->paket;
		$uye_paket_cek=mysql_query("select * from uye_grubu where id='".$uye_paket."'");
		$uye_paket_oku=mysql_fetch_object($uye_paket_cek);
		$aktif_cayma_toplam=mysql_query("SELECT SUM(tutar) as toplam_aktif_cayma FROM cayma_bedelleri WHERE uye_id='".$uyeID."' AND durum=1");
		$toplam_aktif_cayma=mysql_fetch_assoc($aktif_cayma_toplam);
		$iade_talepleri_toplam=mysql_query("SELECT SUM(tutar) as toplam_iade_talepleri FROM cayma_bedelleri WHERE uye_id='".$uyeID."' AND durum=2 ");
		$toplam_iade_talepleri=mysql_fetch_assoc($iade_talepleri_toplam);
		$borclar_toplam=mysql_query("SELECT SUM(tutar) as toplam_borclar FROM cayma_bedelleri WHERE uye_id='".$uyeID."' AND durum=6 ");
		$toplam_borclar=mysql_fetch_assoc($borclar_toplam);
		// $cayma=$toplam_aktif_cayma["toplam_aktif_cayma"]-$toplam_iade_talepleri["toplam_iade_talepleri"]-$toplam_borclar["toplam_borclar"];
		$cayma=$toplam_aktif_cayma["toplam_aktif_cayma"]-$toplam_borclar["toplam_borclar"];
		if($row->hesaplama=="Standart"){
			if($row2->standart_limit>0){
				$teklif_limiti=$row2->standart_limit;
			}else{
				$teklif_limiti = 0;		
				$grup_cek=mysql_query("select * from uye_grubu_detaylari where grup_id='".$uye_paket."' and cayma_bedeli <= '".$cayma."' order by cayma_bedeli desc limit 1");
				$grup_oku = mysql_fetch_object($grup_cek);
				$teklif_limiti =$grup_oku->standart_ust_limit;	
			}
		}else{
			if($row2->luks_limit>0){
				$teklif_limiti=$row2->luks_limit;
			}else{
				$teklif_limiti = 0;	
				$grup_cek=mysql_query("select * from uye_grubu_detaylari where grup_id='".$uye_paket."' and cayma_bedeli <= '".$cayma."' order by cayma_bedeli desc limit 1");
				$grup_oku = mysql_fetch_object($grup_cek);
				$teklif_limiti =$grup_oku->luks_ust_limit;	
			}
		}
		if($row->ihale_turu==1){
			$sorgu3=mysql_query("select * from sigorta_ozellikleri where id='".$sigorta_id."'");
			$row3=mysql_fetch_object($sorgu3);
			$sigorta_min_artis=$row3->minumum_artis;
			if($uye_tkn == ""){
				$response=["message"=>"Teklif verebilmek için giriş yapmalısınız","status"=>500];
			}elseif($row->ihale_tarihi." ".$row->ihale_saati < $teklif_tarihi){
				$response=["message"=>"İhalenin süresi dolmuştur.","status"=>500];
			}elseif($teklif == ""  ){
				$response=["message"=>"Lütfen teklifinizi belirleyin","status"=>500];
			}elseif($teklif % $sigorta_min_artis != 0){
				$response=["message"=>"Teklifiniz $sigorta_min_artis ₺ katları olmalı","status"=>500];
			}elseif($teklif < $row->acilis_fiyati  ){
				$response=["message"=>"Teklifiniz taban fiyat koşulunu sağlamamaktadır. İhalenin taban fiyatı $row->acilis_fiyati ₺'dir. ","status"=>500];
			}elseif($teklif > $teklif_limiti  ){
				$response=["message"=>"Teklif limitini aştınız. Mevcut paketinizin limiti '".money($teklif_limiti)."' ₺ dir. ","status"=>504];
			}elseif($teklif < $row->son_teklif+ $sigorta_min_artis){
				$response=["message"=>"Teklfiniz en yüksek teklifden en az $sigorta_min_artis ₺ fazla olmalı","status"=>500];
			}else{
				$response=["message"=>"","status"=>200];
			}
		}elseif($row->ihale_turu==2){
			if($uye_tkn == ""){
				$response=["message"=>"Teklif verebilmek için giriş yapmalısınız","status"=>500];
			}elseif($row->ihale_tarihi." ".$row->ihale_saati < $teklif_tarihi){
				$response=["message"=>"İhalenin süresi dolmuştur.","status"=>500];
			}elseif($teklif == ""){
				$response=["message"=>"Lütfen teklifinizi belirleyin. ","status"=>500];
			}elseif($teklif < $row->acilis_fiyati  ){
				$response=["message"=>"Teklifiniz taban fiyat koşulunu sağlamamaktadır. İhalenin taban fiyatı $row->acilis_fiyati ₺'dir. ","status"=>500];
			}elseif($teklif > $teklif_limiti  ){
				$response=["message"=>"Teklif limitini aştınız. Mevcut paketinizin limiti '".money($teklif_limiti)."' ₺ dir. ",""=>$row2->teklif_limiti,"status"=>505];
			}else{
				$response=["message"=>"","status"=>200];
			}
		}
		echo json_encode($response);
	}

	if(re("action")=="komisyon_cek"){
		$ilan_id=re("ilan_id");
		$gelen_teklif = re('girilen_teklif');
		if($gelen_teklif == ""){
			$cek = mysql_query("select * from ilanlar where id = '".$ilan_id."'");
			$oku = mysql_fetch_object($cek);
			$verilen_teklif=$oku->son_teklif;
		}else{
			$verilen_teklif=re("girilen_teklif");
		}
		$response=[];
		$sorgu=mysql_query("select * from ilanlar where id='".$ilan_id."' ");
		$row=mysql_fetch_object($sorgu);
		if($row->pd_hizmet>0){
			$hizmet_bedel=$row->pd_hizmet;
		}else{			
			$cek = mysql_query("select* from komisyon_oranlari where sigorta_id = '".$row->sigorta."' and komisyon_orani >= '".$verilen_teklif."' order by komisyon_orani asc");
			// var_dump("select* from komisyon_oranlari where sigorta_id = '".$row->sigorta."' and komisyon_orani >= '".$verilen_teklif."' order by komisyon_orani asc");
			$oku = mysql_fetch_object($cek);
			$hesaplama=$row->hesaplama;
			if($hesaplama=="Standart"){
				$net = $oku->net;
				$oran = $oku->onbinde;
			}else{
				$net = $oku->lux_net;
				$oran = $oku->lux_onbinde;
			}
			$ek_gider = $verilen_teklif * $oran / 10000;
			$son_komisyon = ceil($ek_gider + $net);
			$hizmet_bedel=$son_komisyon;
		}
		$response=["son_komisyon"=>$hizmet_bedel];
		echo json_encode($response);
	}
	
?>