<?php

	include 'ayar.php';
	
	session_start();
	$admin_id=$_SESSION['kid'];
	// $admin_id=139;
	$admin_yetki_cek=mysql_query("Select * from kullanicilar where id='".$admin_id."' ");
	$admin_yetki_oku=mysql_fetch_assoc($admin_yetki_cek);
	$admin_prim = $admin_yetki_oku["prim_orani"];
	$yetki="true";
	$yetkiler=$admin_yetki_oku["yetki"];
	$yetki_parcala=explode("|",$yetkiler);
	if (!in_array(10, $yetki_parcala)  ) { 
		$yetki="false";
	}
	
	$action=re("q");
	$sira = 1;
	$columns=array();
	$data=array();	
	$columns=array(
		'SIRA',
		'ÖDEME TARİHİ',
		'ÖDEYEN',
		'KOD',
		'PLAKA',
		'MARKA MODEL',
		'SİGORTA',
		'ÜYE ADI',
		'SATIŞ KİMİN ADINA YAPILDI',
		'SATIŞ TARİHİ',
		'MALİYET',
		'SATILAN FİYAT',
		'PD HİZMET BEDELİ',
		'EKSTRA KAZANÇ',
		'AÇIKLAYICI NOTLAR',
		'TOPLAM KAR/ZARAR'
	);
	$columns_uyelerin_aldiklari=array(
		'SIRA',
		'ÖDEME TARİHİ',
		'ÖDEYEN',
		'KOD',
		'PLAKA',
		'MARKA MODEL',
		'SİGORTA',
		'ÜYE ADI',
		'SATIŞ KİMİN ADINA YAPILDI',
		'SATIŞ TARİHİ',
		'SATILAN FİYAT',
		'PD HİZMET BEDELİ',
	);
	function exportExcel2($filename,$columns=array(),$data=array(),$replaceDotCol=array()){
		header('Content-Encoding: UTF-8');
		header('Content-Type: text/plain; charset=utf-8'); 
		header("Content-disposition: attachment; filename=".$filename.".xls");
		echo "\xEF\xBB\xBF"; // UTF-8 BOM
      
		$say=count($columns);
		  
		echo '<table id="excel" border="1"><tr>';
		foreach($columns as $v){
			echo '<th style="background-color: #cecece;">'.trim($v).'</th>';
		}
		echo '</tr>';

		foreach($data as $val){
			echo '<tr>';
			for($i=0; $i < $say; $i++){
				if(in_array($i,$replaceDotCol)){
					if($val[count($say)-1]=="1"){
						echo '<td style="" >'.str_replace('.',',',$val[$i]).'</td>';
					}else{
						if($i==0){
							echo '<td style="" >'.str_replace('.',',',$val[$i]).'</td>';
						}else{
							echo '<td>'.str_replace('.',',',$val[$i]).'</td>';
						}
					}
				}else{
					if($val[count($say)-1]=="1"){
						echo '<td style="" >'.str_replace('.',',',$val[$i]).'</td>';
					}else{
						if($i==0){
							echo '<td style="" >'.str_replace('.',',',$val[$i]).'</td>';
						}else{
							echo '<td>'.str_replace('.',',',$val[$i]).'</td>';
						}
					}
				}
			}
			echo '</tr>';
		}
	}
	function exportExcel($filename,$columns=array(),$data=array(),$replaceDotCol=array(),$sayi,$toplam,$tur=""){
		header('Content-Encoding: UTF-8');
		header('Content-Type: text/plain; charset=utf-8'); 
		header("Content-disposition: attachment; filename=".$filename.".xls");
		echo "\xEF\xBB\xBF"; // UTF-8 BOM
      
		$say=count($columns);
		if($tur==""){
			echo '<tr> <td colspan="12">Toplam '.$sayi.' adet sonuç içinde Toplam Ciro '.money($toplam).' ₺  </td></tr>';
		}else if($tur=="primlerim"){
			echo '<tr> <td colspan="13">Toplam '.$sayi.' adet sonuç içinde Toplam Prim '.money($toplam).' ₺  </td></tr>';
		}else{
			echo '<tr> <td colspan="5">Toplam '.$sayi.' adet sonuç içinde Toplam Cayma Bedeli '.money($toplam).' ₺  </td></tr>';
		}
		echo '<table id="excel" border="1"><tr>';
		foreach($columns as $v){
			//echo '<th style=" background-color: rgb(255,255,0);">'.trim($v).'</th>';
			echo '<th style=" background-color: #d9d9d9;">'.trim($v).'</th>';
		}
		echo '</tr>';
		
		
		
		foreach($data as $val){
			
			if($val[17] == 1 || $val[13] == 1){
				$background = "red";
				$color = "white";
			}else{
				$background = "none";
				$color = "black";
			}
			// $color = "none";
			echo '<tr style="background: '.$background.'; color: '.$color.'">';
			for($i=0; $i < $say; $i++){
	  
				if(in_array($i,$replaceDotCol)){
					if($val[count($say)-1]=="1"){
						// echo '<td style=" background-color: red;color: #ffffff;" >'.str_replace('.',',',$val[$i]).'</td>';
						echo '<td>'.str_replace('.',',',$val[$i]).'</td>';
					}else{
						if($i==0){
							echo '<td>'.str_replace('.',',',$val[$i]).'</td>';
						}else{
							echo '<td>'.str_replace('.',',',$val[$i]).'</td>';
						}
					}
					
					
				}else{
					if($val[count($say)-1]=="1"){
						echo '<td>'.str_replace('.',',',$val[$i]).'</td>';
					}else{
						if($i==0){
							echo '<td>'.str_replace('.',',',$val[$i]).'</td>';
						}else{
							echo '<td>'.str_replace('.',',',$val[$i]).'</td>';
						}
					}
					/*if($i==0){
						echo '<td style=" background-color: rgb(51,51,153);color: #ffffff;">'.$val[$i].'</td>';
					}else{
						echo '<td>'.$val[$i].'</td>';
					}*/
				}
			}
			echo '</tr>';
		}
	}
	if($action=="tarihleri"){
		$listeleme=re("listeleme");
		if($listeleme=="odeme_tarihi_desc"){
			$order_by="order by odeme_tarihi desc";
		}else if($listeleme=="odeme_tarihi_asc"){
			$order_by="order by odeme_tarihi asc";
		}else if($listeleme=="tarih_desc"){
			$order_by="order by tarih desc";
		}else if($listeleme=="tarih_asc"){
			$order_by="order by tarih asc";
		}else{
			$order_by="order by odeme_tarihi desc";
		}
		$BAS=re("tarih1");
		$SON=re("tarih2");
		$filtre = mysql_query("SELECT * FROM satilan_araclar WHERE odeme_tarihi BETWEEN '".$BAS."' AND '".$SON."' ".$order_by." ");
		$filterCount = mysql_num_rows($filtre);
		$ayYil = mysql_query("SELECT SUM(ciro) AS ciro FROM satilan_araclar WHERE  MONTH(tarih) = '$BAS' AND YEAR(tarih)= '$SON' and durum=0 and ciro > 0"); 
		$AyYilToplam = mysql_fetch_assoc($ayYil); 
		// if($yetki=="true"){
		// 	$AyYilCiro = (int) $AyYilToplam['ciro'];
		// }else{
		// 	$AyYilCiro = "?";
		// }
		$AyYilCiro = (int) $AyYilToplam['ciro'];
		$isim="SATILAN_ARACLAR"."-".$BAS."-".$SON;
		$replaceDotCol=array(10,11); //ilk kolon sıfır olmak üzere belirtilen kolonlarda "," işareti ile "." işareti değiştirilir.
		$total = 0;
		$sonuc = 0;
		while($filtre_yaz = mysql_fetch_array($filtre)){
			//SATIRLAR
			// if($yetki=="true"){
				$maliyet = $filtre_yaz["maliyet"];
				$maliyet2 = money($filtre_yaz["maliyet"])." ₺";
				$satilan_fiyat = $filtre_yaz["satilan_fiyat"];
				$satilan_fiyat2 = money($filtre_yaz["satilan_fiyat"])." ₺";
				$pd_hizmet = $filtre_yaz["pd_hizmet"];
				$pd_hizmet2 = money($filtre_yaz["pd_hizmet"])." ₺";
				$ekstra_kazanc = $filtre_yaz["ektra_kazanc"];
				$ekstra_kazanc2 = money($filtre_yaz["ektra_kazanc"])." ₺";
				$ciro = $filtre_yaz["ciro"];
				$durum_ilk = $satilan_fiyat + $pd_hizmet + $ekstra_kazanc;
				$durum_iki = $durum_ilk - $maliyet;
				if($durum_iki > 0){
					$toplam_kar_zarar = $durum_iki." ₺ KAR";
				}elseif($durum_iki == 0){
					$toplam_kar_zarar = "0 ₺";
				}else{
					$toplam_kar_zarar = money($durum_iki)." ₺ ZARAR";
				}
			// }else{
			// 	$maliyet2 = "?";
			// 	$satilan_fiyat2 = money($filtre_yaz["satilan_fiyat"])." ₺";
			// 	$pd_hizmet2 = money($filtre_yaz["pd_hizmet"])." ₺";
			// 	$ekstra_kazanc2 = "?";
			// 	$ciro2 = "?";
			// 	$toplam_kar_zarar = "?";
			// }
			if($filtre_yaz["tarih"] == "0000-00-00"){
				$tarih = "";
			}else{
				$tarih = date("d-m-Y", strtotime($filtre_yaz['tarih']));
			}
			$total += $durum_iki;
			if($filtre_yaz["ciro"] > 0 && $filtre_yaz["durum"] == 0){
				$sonuc += $filtre_yaz["ciro"];
			}
			$data[]=array(
				$sira,
				$filtre_yaz["odeme_tarihi"],
				$filtre_yaz["parayi_gonderen"],
				$filtre_yaz["kod"],
				$filtre_yaz["plaka"],
				$filtre_yaz["marka_model"],
				$filtre_yaz["sigorta"],
				$filtre_yaz["araci_alan"],
				$filtre_yaz["satis_adi"],
				$tarih,
				$maliyet2,
				$satilan_fiyat2,
				$pd_hizmet2,
				$ekstra_kazanc2,
				$filtre_yaz["aciklayici_not"],
				$toplam_kar_zarar,
				$durum_iki,
				$filtre_yaz["durum"]
			);
			$sira++;
		}	
		//$data[]=array("Toplam $filterCount adet sonuç içinde Toplam Ciro $AyYilCiro ₺");
		exportExcel($isim,$columns,$data,$replaceDotCol,$filterCount,$sonuc);
	}
	
	if($action=="secili_tarihi"){
		$listeleme=re("listeleme");
		if($listeleme=="odeme_tarihi_desc"){
			$order_by="order by odeme_tarihi desc";
		}else if($listeleme=="odeme_tarihi_asc"){
			$order_by="order by odeme_tarihi asc";
		}else if($listeleme=="tarih_desc"){
			$order_by="order by tarih desc";
		}else if($listeleme=="tarih_asc"){
			$order_by="order by tarih asc";
		}else{
			$order_by="order by odeme_tarihi desc";
		}			
		$BAS=re("tarih1");
		$SON=re("tarih2");
		$filtre = mysql_query("SELECT * FROM satilan_araclar WHERE  MONTH(odeme_tarihi)= '$BAS' AND YEAR(odeme_tarihi)= '$SON' ".$order_by." ");
		$filterCount = mysql_num_rows($filtre);
		$ayYil = mysql_query("SELECT SUM(ciro) AS ciro FROM satilan_araclar WHERE  MONTH(tarih) = '$BAS' AND YEAR(tarih)= '$SON' and durum=0"); 
		$AyYilToplam = mysql_fetch_assoc($ayYil); 
		// if($yetki=="true"){
			$AyYilCiro = (int) $AyYilToplam['ciro'];
		// }else{
		// 	$AyYilCiro = "?";
		// }
		$isim="SATILAN_ARACLAR"."-".$BAS."-".$SON;
		$replaceDotCol=array(10,11); //ilk kolon sıfır olmak üzere belirtilen kolonlarda "," işareti ile "." işareti değiştirilir.
		$total = 0;
		while($filtre_yaz = mysql_fetch_array($filtre)){
			//SATIRLAR
			// if($yetki=="true"){
				$maliyet = $filtre_yaz["maliyet"];
				$maliyet2 = money($filtre_yaz["maliyet"])." ₺";
				$satilan_fiyat = $filtre_yaz["satilan_fiyat"];
				$satilan_fiyat2 = money($filtre_yaz["satilan_fiyat"])." ₺";
				$pd_hizmet = $filtre_yaz["pd_hizmet"];
				$pd_hizmet2 = money($filtre_yaz["pd_hizmet"])." ₺";
				$ekstra_kazanc = $filtre_yaz["ektra_kazanc"];
				$ekstra_kazanc2 = money($filtre_yaz["ektra_kazanc"])." ₺";
				$ciro = $filtre_yaz["ciro"];
				$durum_ilk = $satilan_fiyat + $pd_hizmet + $ekstra_kazanc;
				$durum_iki = $durum_ilk - $maliyet;
				if($durum_iki > 0){
					$toplam_kar_zarar = $durum_iki." ₺ KAR";
				}elseif($durum_iki == 0){
					$toplam_kar_zarar = "0 ₺";
				}else{
					$toplam_kar_zarar = money($durum_iki)." ₺ ZARAR";
				}
			// }else{
			// 	$maliyet2 = "?";
			// 	$satilan_fiyat2 = money($filtre_yaz["satilan_fiyat"])." ₺";
			// 	$pd_hizmet2 = money($filtre_yaz["pd_hizmet"])." ₺";
			// 	$ekstra_kazanc2 = "?";
			// 	$ciro2 = "?";
			// 	$toplam_kar_zarar = "?";
			// }
			if($filtre_yaz["tarih"] == "0000-00-00"){
				$tarih = "";
			}else{
				$tarih = date("d-m-Y", strtotime($filtre_yaz['tarih']));
			}
			if($filtre_yaz["durum"] == 0){
				$total += $durum_iki;
			}
			$data[]=array(
				$sira,
				$filtre_yaz["odeme_tarihi"],
				$filtre_yaz["parayi_gonderen"],
				$filtre_yaz["kod"],
				$filtre_yaz["plaka"],
				$filtre_yaz["marka_model"],
				$filtre_yaz["sigorta"],
				$filtre_yaz["araci_alan"],
				$filtre_yaz["satis_adi"],
				$tarih,
				$maliyet2,
				$satilan_fiyat2,
				$pd_hizmet2,
				$ekstra_kazanc2,
				$filtre_yaz["aciklayici_not"],
				$toplam_kar_zarar,
				$durum_iki,
				$filtre_yaz["durum"]
			);
			$sira++;
		}	
		//$data[]=array("Toplam $filterCount adet sonuç içinde Toplam Ciro $AyYilCiro ₺");
		exportExcel($isim,$columns,$data,$replaceDotCol,$filterCount,$total);
	} 
	if($action=="arama"){
		$listeleme=re("listeleme");
		if($listeleme=="odeme_tarihi_desc"){
			$order_by="order by odeme_tarihi desc";
		}else if($listeleme=="odeme_tarihi asc"){
			$order_by="order by odeme_tarihi asc";
		}else if($listeleme=="tarih_desc"){
			$order_by="order by tarih desc";
		}else if($listeleme=="tarih_asc"){
			$order_by="order by tarih asc";
		}else{
			$order_by="order by odeme_tarihi desc";
		}			
		$aranan=re("aranan");
		//$filtre = mysql_query("SELECT * FROM satilan_araclar WHERE  MONTH(tarih)= '$BAS' AND YEAR(tarih)= '$SON' ".$order_by." ");
		$filtre = mysql_query("SELECT * FROM satilan_araclar WHERE concat(plaka,' ',kod,' ',marka_model,' ',sigorta,' ',satis_adi,' ',maliyet,' ',pd_hizmet,' ',ektra_kazanc,' ',notlar,' ',parayi_gonderen,' ',araci_alan,' ',satilan_fiyat,' ',aciklayici_not,' ',ciro)  
		like '%".re('aranan')."%' $order_by");

		$filterCount = mysql_num_rows($filtre);
		//$ayYil = mysql_query("SELECT SUM(ciro) AS ciro FROM satilan_araclar WHERE  MONTH(tarih) = '$BAS' AND YEAR(tarih)= '$SON' and durum=0"); 
		$ayYil = mysql_query("
			SELECT 
				SUM(ciro) as ciro
			FROM
				satilan_araclar 
			WHERE 
				prim > 0 AND
				concat(plaka,' ',kod,' ',marka_model,' ',sigorta,' ',satis_adi,' ',maliyet,' ',pd_hizmet,' ',ektra_kazanc,' ',notlar,' ',parayi_gonderen,' ',araci_alan,' ',satilan_fiyat,' ',aciklayici_not,' ',ciro)  like '%".re('aranan')."%'  AND
				durum=0
			$order_by 
		"); 
		// if($yetki=="true"){
			$AyYilCiro = (int) $AyYilToplam['ciro'];
		// }else{
		// 	$AyYilCiro = "?";
		// }
		$isim="SATILAN_ARACLAR";
		$replaceDotCol=array(10,11); //ilk kolon sıfır olmak üzere belirtilen kolonlarda "," ile "." değiştirilir.
		$total = 0;
		while($filtre_yaz = mysql_fetch_array($filtre)){
			//SATIRLAR
			// if($yetki=="true"){
				$maliyet = $filtre_yaz["maliyet"];
				$maliyet2 = money($filtre_yaz["maliyet"])." ₺";
				$satilan_fiyat = $filtre_yaz["satilan_fiyat"];
				$satilan_fiyat2 = money($filtre_yaz["satilan_fiyat"])." ₺";
				$pd_hizmet = $filtre_yaz["pd_hizmet"];
				$pd_hizmet2 = money($filtre_yaz["pd_hizmet"])." ₺";
				$ekstra_kazanc = $filtre_yaz["ektra_kazanc"];
				$ekstra_kazanc2 = money($filtre_yaz["ektra_kazanc"])." ₺";
				$ciro = $filtre_yaz["ciro"];
				$durum_ilk = $satilan_fiyat + $pd_hizmet + $ekstra_kazanc;
				$durum_iki = $durum_ilk - $maliyet;
				if($durum_iki > 0){
					$toplam_kar_zarar = money($durum_iki)." ₺ KAR";
				}elseif($durum_iki == 0){
					$toplam_kar_zarar = "0 ₺";
				}else{
					$toplam_kar_zarar = money($durum_iki)." ₺ ZARAR";
				}
			// }else{
			// 	$maliyet2 = "?";
			// 	$satilan_fiyat2 = money($filtre_yaz["satilan_fiyat"])." ₺";
			// 	$pd_hizmet2 = money($filtre_yaz["pd_hizmet"])." ₺";
			// 	$ekstra_kazanc2 = "?";
			// 	$ciro2 = "?";
			// 	$toplam_kar_zarar = "?";
			// }
			$total += $durum_iki;
			$data[]=array(
				$sira,
				$filtre_yaz["odeme_tarihi"],
				$filtre_yaz["parayi_gonderen"],
				$filtre_yaz["kod"],
				$filtre_yaz["plaka"],
				$filtre_yaz["marka_model"],
				$filtre_yaz["sigorta"],
				$filtre_yaz["araci_alan"],
				$filtre_yaz["satis_adi"],
				$filtre_yaz["tarih"],
				$maliyet2,
				$satilan_fiyat2,
				$pd_hizmet2,
				$ekstra_kazanc2,
				$filtre_yaz["aciklayici_not"],
				$toplam_kar_zarar,
				$durum_iki,
				$filtre_yaz["durum"]
			);
			$sira++;
		}	
		//$data[]=array("Toplam $filterCount adet sonuç içinde Toplam Ciro $AyYilCiro ₺");
		exportExcel($isim,$columns,$data,$replaceDotCol,$filterCount,$total);
	} 
	if($action=="tarihsiz"){
		$listeleme=re("listeleme");
		if($listeleme=="odeme_tarihi_desc"){
			$order_by="order by odeme_tarihi desc";
		}else if($listeleme=="odeme_tarihi_asc"){
			$order_by="order by odeme_tarihi asc";
		}else if($listeleme=="tarih_desc"){
			$order_by="order by tarih desc";
		}else if($listeleme=="tarih_asc"){
			$order_by="order by tarih asc";
		}else{
			$order_by="order by odeme_tarihi desc";
		}
		$result = mysql_query('SELECT SUM(ciro) AS ciro FROM satilan_araclar where durum=0'); 
		$row = mysql_fetch_assoc($result); 
		$month = date('m');
		$buay = mysql_query("SELECT IFNULL(SUM(ciro), 0) AS ciro,IFNULL(SUM(prim), 0) as prim FROM satilan_araclar WHERE MONTH(odeme_tarihi) = '" . $month . "' and durum=0 ");
		$buay_getir = mysql_fetch_assoc($buay);
		$buay_ciro = $buay_getir['ciro'];
		// if($yetki=="true"){
			$sum = (int) $buay_ciro;
		// }else{
		// 	$sum = "?";
		// }
		// $satilan_cek = mysql_query("SELECT * FROM satilan_araclar ".$order_by." ");
		$satilan_cek = mysql_query("SELECT * FROM satilan_araclar WHERE MONTH(odeme_tarihi) = MONTH(CURRENT_DATE()) $order_by ");
		$satilan_sayi = mysql_num_rows($satilan_cek);
		$tarih=date("Y-m-d H:i:s");
		$isim="SATILAN_ARACLAR_".$tarih;
		$replaceDotCol=array(10,11); //ilk kolon sıfır olmak üzere belirtilen kolonlarda "," ile "." değiştirilir.
		while($satilan_oku = mysql_fetch_array($satilan_cek)){ 
			// if($yetki=="true"){
				$maliyet = $satilan_oku["maliyet"];
				$maliyet2 = money($satilan_oku["maliyet"])." ₺";
				$satilan_fiyat = $satilan_oku["satilan_fiyat"];
				$satilan_fiyat2 = money($satilan_oku["satilan_fiyat"])." ₺";
				$pd_hizmet = $satilan_oku["pd_hizmet"];
				$pd_hizmet2 = money($satilan_oku["pd_hizmet"])." ₺";
				$ekstra_kazanc = $satilan_oku["ektra_kazanc"];
				$ekstra_kazanc2 = money($satilan_oku["ektra_kazanc"])." ₺";
				$ciro = $satilan_oku["ciro"];
				if($ciro > 0){
					$ciro2 = para($satilan_oku["ciro"])." ₺ Kar";
				}else{
					$ciro2 = para($satilan_oku["ciro"])." ₺ Zarar";
				}
				$durum_ilk = $satilan_fiyat + $pd_hizmet + $ekstra_kazanc;
				$durum_iki = $durum_ilk - $maliyet;
				if($durum_iki > 0){
					$toplam_kar_zarar = money($durum_iki)." ₺ KAR";
				}elseif($durum_iki == 0){
					$toplam_kar_zarar = "0 ₺";
				}else{
					$toplam_kar_zarar = money($durum_iki)." ₺ ZARAR";
				}
			// }else{
			// 	$maliyet2 = "?";
			// 	$satilan_fiyat2 = money($satilan_oku["satilan_fiyat"])." ₺";
			// 	$pd_hizmet2 = money($satilan_oku["pd_hizmet"])." ₺";
			// 	$ekstra_kazanc2 = "?";
			// 	$ciro2 = "?";
			// 	$toplam_kar_zarar = "?";
			// }
			if($satilan_oku["tarih"] == "0000-00-00"){
				$tarih = "";
			}else{
				$tarih = date("d-m-Y", strtotime($satilan_oku['tarih']));
			}
			$data[]=array(
				$sira,
				$satilan_oku["odeme_tarihi"],
				$satilan_oku["parayi_gonderen"],
				$satilan_oku["kod"],
				$satilan_oku["plaka"],
				$satilan_oku["marka_model"],
				$satilan_oku["sigorta"],
				$satilan_oku["araci_alan"],
				$satilan_oku["satis_adi"],
				$tarih,
				$maliyet2,
				$satilan_fiyat2,
				$pd_hizmet2,
				$ekstra_kazanc2,
				$satilan_oku["aciklayici_not"],
				$ciro2,
				$ciro,
				$satilan_oku["durum"]
			);
			$sira++;
		}
		//$data[]=array("Toplam $satilan_sayi adet sonuç içinde Toplam Ciro $sum ₺");
		exportExcel($isim,$columns,$data,$replaceDotCol,$satilan_sayi,$sum);
	}
	// Bana Özel-Primlerim Aldıkları
	if($action=="primlerim_tarihleri"){
		$columns=array(
			'SIRA',
			'ÖDEME TARİHİ',
			'ÖDEYEN',
			'KOD',
			'PLAKA',
			'MARKA MODEL',
			'SİGORTA',
			'ÜYE ADI',
			'SATIŞ KİMİN ADINA YAPILDI',
			'SATIŞ TARİHİ',
			'SATILAN FİYAT',
			'PD HİZMET BEDELİ',
			'PRİM'
		);
		$listeleme=re("listeleme");
		if($listeleme=="odeme_tarihi_desc"){
			$order_by="order by odeme_tarihi desc";
		}else if($listeleme=="odeme_tarihi_asc"){
			$order_by="order by odeme_tarihi asc";
		}else if($listeleme=="tarih_desc"){
			$order_by="order by tarih desc";
		}else if($listeleme=="tarih_asc"){
			$order_by="order by tarih asc";
		}else{
			$order_by="order by odeme_tarihi desc";
		}
		$BAS=re("tarih1");
		$SON=re("tarih2");
		//$filtre_cek = mysql_query("SELECT * FROM satilan_araclar WHERE tarih BETWEEN '".$BAS."' AND '".$SON."' ".$order_by." ");
		// $filtre_cek_sql = "SELECT satilan_araclar.* FROM satilan_araclar INNER JOIN user ON user.id=satilan_araclar.uye_id INNER JOIN 
		// prm_notlari ON satilan_araclar.uye_id=prm_notlari.uye_id WHERE prm_notlari.durum=1 AND satilan_araclar.prim > 0 AND user.temsilci_id='".$admin_id."'";
		// if(re('tarih1') != ""){
		// 	$filtre_cek_sql .= " AND satilan_araclar.odeme_tarihi >= '".re('tarih1')."'";
		// }
		// if(re('tarih2') != ""){
		// 	$filtre_cek_sql .= " AND satilan_araclar.odeme_tarihi <= '".re('tarih2')."'";
		// }
		$filtre_cek_sql = "SELECT satilan_araclar.* FROM satilan_araclar INNER JOIN user ON user.id=satilan_araclar.uye_id INNER JOIN prm_notlari ON prm_notlari.uye_id = satilan_araclar.uye_id 
		WHERE user.temsilci_id='".$admin_id."' AND prm_notlari.durum = 1 ";
		if(re('tarih1') != ""){
			$filtre_cek_sql .= " AND satilan_araclar.odeme_tarihi >= '".re('tarih1')."' ";
		}
		if(re('tarih2') != ""){
			$filtre_cek_sql .= " AND satilan_araclar.odeme_tarihi <= '".re('tarih2')."' ";
		}
		$filtre_cek_sql .= $order_by;
		$filtre_cek = mysql_query($filtre_cek_sql);
		$filtre_cek_prim = mysql_query($filtre_cek_sql);
		/*
		$filtre_cek = mysql_query("SELECT satilan_araclar.* FROM satilan_araclar INNER JOIN user ON user.id=satilan_araclar.uye_id INNER JOIN 
		prm_notlari ON satilan_araclar.uye_id=prm_notlari.uye_id WHERE prm_notlari.durum=1 AND satilan_araclar.prim > 0 AND user.temsilci_id='".$admin_id."' AND
		satilan_araclar.tarih BETWEEN '".re('tarih1')."' AND '".re('tarih2')."' $order_by ");
		*/
		$filtre_sayi = mysql_num_rows($filtre_cek); 
		$ToplamFiltre = 0;
		while($filtre_oku_prim = mysql_fetch_array($filtre_cek_prim)){
			$prim_first = $filtre_oku_prim["pd_hizmet"] * $admin_prim;
			if($filtre_oku_prim["durum"] != 1){
				$ToplamFiltre += $prim_first / 100;
			}
		
		}
		// if($yetki=="true"){
		// 	$ToplamFiltre = (int) $filtreToplam['prim'];
		// }else{
		// 	$ToplamFiltre = "?";
		// }
		$isim="SATILAN_ARACLAR"."-".$BAS."-".$SON;
		$replaceDotCol=array(10,11,12); //ilk kolon sıfır olmak üzere belirtilen kolonlarda "," ile "." değiştirilir.
		while($filtre_oku = mysql_fetch_array($filtre_cek)){
			//SATIRLAR
			// if($yetki=="true"){
				$maliyet = $filtre_oku["maliyet"];
				$satilan_fiyat = $filtre_oku["satilan_fiyat"];
				$pd_hizmet = $filtre_oku["pd_hizmet"];
				$ekstra_kazanc = $filtre_oku["ektra_kazanc"];
				$ciro = $filtre_oku["ciro"];
			// }else{
			// 	$maliyet = "?";
			// 	$satilan_fiyat = "?";
			// 	$pd_hizmet = "?";
			// 	$ekstra_kazanc = "?";
			// 	$ciro = "?";
			// }
			if($filtre_oku["odeme_tarihi"] == "0000-00-00"){
				$tarih1 = "";
			}else{
				$tarih1 = date("d-m-Y", strtotime($filtre_oku['odeme_tarihi']));
			}
			if($filtre_oku["tarih"] == "0000-00-00"){
				$tarih2 = "";
			}else{
				$tarih2 = date("d-m-Y", strtotime($filtre_oku['tarih']));
			}
			$data[]=array(
				$sira,
				$tarih1,
				$filtre_oku["parayi_gonderen"],
				$filtre_oku["kod"],
				$filtre_oku["plaka"],
				$filtre_oku["marka_model"],
				$filtre_oku["sigorta"],
				$filtre_oku["araci_alan"],
				$filtre_oku["satis_adi"],
				$tarih2,
				$satilan_fiyat,
				$pd_hizmet,
				$filtre_oku["prim"],
				$filtre_oku["durum"]
			);
			$sira++;
		}	
		//$data[]=array("Toplam $filtre_sayi adet sonuç içinde Toplam Ciro $ToplamFiltre ₺");
		exportExcel($isim,$columns,$data,$replaceDotCol,$filtre_sayi,$ToplamFiltre,"primlerim" );
	}
	if($action=="primlerim_secili_tarihi"){
		$columns=array(
			'SIRA',
			'KOD',
			'ÖDEME TARİHİ',
			'ÖDEYEN',
			'PLAKA',
			'MARKA MODEL',
			'SİGORTA',
			'ÜYE ADI',
			'SATIŞ KİMİN ADINA YAPILDI',
			'SATIŞ TARİHİ',
			'SATILAN FİYAT',
			'PD HİZMET BEDELİ',
			'PRİM'
		);
		$listeleme=re("listeleme");
		if($listeleme=="odeme_tarihi_desc"){
			$order_by="order by odeme_tarihi desc";
		}else if($listeleme=="odeme_tarihi_asc"){
			$order_by="order by odeme_tarihi asc";
		}else if($listeleme=="tarih_desc"){
			$order_by="order by tarih desc";
		}else if($listeleme=="tarih_asc"){
			$order_by="order by tarih asc";
		}else{
			$order_by="order by odeme_tarihi desc";
		}			
		$BAS=re("tarih1"); //ay
		$SON=re("tarih2"); //yıl
		$filtre_sql = "SELECT satilan_araclar.* FROM satilan_araclar INNER JOIN user ON user.id=satilan_araclar.uye_id INNER JOIN prm_notlari ON prm_notlari.uye_id = satilan_araclar.uye_id
		WHERE user.temsilci_id='".$admin_id."' AND satilan_araclar.prim > 0 AND prm_notlari.durum = 1 ";
		if($BAS != 0){
			$filtre_sql .= " AND MONTH(satilan_araclar.odeme_tarihi) = '".$BAS."'";
		}
		if($SON != ""){
			$filtre_sql .= " AND YEAR(satilan_araclar.odeme_tarihi) = '".$SON."' ";
		}
		$filtre_sql .= $order_by;
		// echo $filtre_sql;
		$filtre = mysql_query($filtre_sql);
		$filtre_cek_prim = mysql_query($filtre_sql);
		/*
		$filtre = mysql_query("SELECT satilan_araclar.* FROM satilan_araclar INNER JOIN user ON user.id=satilan_araclar.uye_id INNER JOIN 
		prm_notlari ON satilan_araclar.uye_id=prm_notlari.uye_id WHERE prm_notlari.durum=1 AND satilan_araclar.prim > 0 AND user.temsilci_id='".$admin_id."' AND
		MONTH(satilan_araclar.tarih) = '".$BAS."' AND YEAR(satilan_araclar.tarih)= '".$SON."' $order_by");
		*/
		$filterCount = mysql_num_rows($filtre);
		$AyYilCiro = 0;
		while($filtre_oku_prim = mysql_fetch_array($filtre_cek_prim)){
			$prim_first = $filtre_oku_prim["pd_hizmet"] * $admin_prim;
			// $AyYilCiro += $prim_first / 100;
			if($filtre_oku_prim["durum"] != 1){
				$AyYilCiro += $prim_first / 100;
			}
		}
		$isim="SATILAN_ARACLAR"."-".$BAS."-".$SON;
		$replaceDotCol=array(10,11,12); /*ilk kolon sıfır olmak üzere belirtilen kolonlarda "," ile "." değiştirilir.*/
		while($filtre_yaz = mysql_fetch_array($filtre)){
			/*SATIRLAR*/
			// if($yetki=="true"){
				$maliyet = $filtre_yaz["maliyet"];
				$satilan_fiyat = $filtre_yaz["satilan_fiyat"];
				$pd_hizmet = $filtre_yaz["pd_hizmet"];
				$ekstra_kazanc = $filtre_yaz["ektra_kazanc"];
				$ciro = $filtre_yaz["ciro"];
			// }else{
			// 	$maliyet = "?";
			// 	$satilan_fiyat = "?";
			// 	$pd_hizmet = "?";
			// 	$ekstra_kazanc = "?";
			// 	$ciro = "?";
			// }

			if($filtre_yaz["odeme_tarihi"] == "0000-00-00"){
				$tarih1 = "";
			}else{
				$tarih1 = date("d-m-Y", strtotime($filtre_yaz['odeme_tarihi']));
			}
			if($filtre_yaz["tarih"] == "0000-00-00"){
				$tarih2 = "";
			}else{
				$tarih2 = date("d-m-Y", strtotime($filtre_yaz['tarih']));
			}

			$data[]=array(
				$sira,
				$filtre_yaz["kod"],
				$tarih1,
				$filtre_yaz["parayi_gonderen"],
				$filtre_yaz["plaka"],
				$filtre_yaz["marka_model"],
				$filtre_yaz["sigorta"],
				$filtre_yaz["araci_alan"],
				$filtre_yaz["satis_adi"],
				$tarih2,
				$satilan_fiyat,
				$pd_hizmet,
				$filtre_yaz["prim"],
				$filtre_yaz["durum"]
			);
			$sira++;
		}	
		/*$data[]=array("Toplam $filterCount adet sonuç içinde Toplam Ciro $AyYilCiro ₺");*/
		exportExcel($isim,$columns,$data,$replaceDotCol,$filterCount,$AyYilCiro,"primlerim");
	}
	if($action=="primlerim_arama"){
		$columns=array(
			'SIRA',
			'ÖDEME TARİHİ',
			'ÖDEYEN',
			'KOD',
			'PLAKA',
			'MARKA MODEL',
			'SİGORTA',
			'ÜYE ADI',
			'SATIŞ KİMİN ADINA YAPILDI',
			'SATIŞ TARİHİ',
			'SATILAN FİYAT',
			'PD HİZMET BEDELİ',
			'PRİM'
		);
		$listeleme=re("listeleme");
		if($listeleme=="odeme_tarihi_desc"){
			$order_by="order by odeme_tarihi desc";
		}else if($listeleme=="odeme_tarihi asc"){
			$order_by="order by odeme_tarihi asc";
		}else if($listeleme=="tarih_desc"){
			$order_by="order by tarih desc";
		}else if($listeleme=="tarih_asc"){
			$order_by="order by tarih asc";
		}else{
			$order_by="order by odeme_tarihi desc";
		}			
		$aranan=re("aranan");
		//$filtre = mysql_query("SELECT * FROM satilan_araclar WHERE  MONTH(tarih)= '$BAS' AND YEAR(tarih)= '$SON' ".$order_by." ");
		$filtre = mysql_query("SELECT satilan_araclar.* FROM satilan_araclar INNER JOIN user ON user.id=satilan_araclar.uye_id INNER JOIN prm_notlari ON satilan_araclar.uye_id=prm_notlari.uye_id WHERE prm_notlari.durum=1 AND satilan_araclar.prim > 0 AND
		user.temsilci_id='".$admin_id."' AND concat(plaka,' ',kod,' ',marka_model,' ',sigorta,' ',satis_adi,' ',maliyet,' ',pd_hizmet,' ',ektra_kazanc,' ',notlar,' ',parayi_gonderen,' ',araci_alan,' ',satilan_fiyat,' ',aciklayici_not,' ',ciro) 
		like '%".re('aranan')."%' $order_by ");
		$filtre_cek_prim = mysql_query("SELECT satilan_araclar.* FROM satilan_araclar INNER JOIN user ON user.id=satilan_araclar.uye_id INNER JOIN prm_notlari ON satilan_araclar.uye_id=prm_notlari.uye_id WHERE prm_notlari.durum=1 AND satilan_araclar.prim > 0 AND
		user.temsilci_id='".$admin_id."' AND concat(plaka,' ',kod,' ',marka_model,' ',sigorta,' ',satis_adi,' ',maliyet,' ',pd_hizmet,' ',ektra_kazanc,' ',notlar,' ',parayi_gonderen,' ',araci_alan,' ',satilan_fiyat,' ',aciklayici_not,' ',ciro) 
		like '%".re('aranan')."%' $order_by ");

		$filterCount = mysql_num_rows($filtre);
		//$ayYil = mysql_query("SELECT SUM(ciro) AS ciro FROM satilan_araclar WHERE  MONTH(tarih) = '$BAS' AND YEAR(tarih)= '$SON' and durum=0"); 
		// $ayYil = mysql_query("
		// 						SELECT 
		// 							SUM(satilan_araclar.prim) as prim
		// 						FROM
		// 							satilan_araclar 
		// 						INNER JOIN 
		// 							user ON user.id=satilan_araclar.uye_id
		// 						INNER JOIN
		// 							prm_notlari ON satilan_araclar.uye_id=prm_notlari.uye_id 
		// 						WHERE 
		// 							prm_notlari.durum=1 AND
		// 							satilan_araclar.prim > 0 AND
		// 							user.temsilci_id='".$admin_id."' AND
		// 							concat(plaka,' ',kod,' ',marka_model,' ',sigorta,' ',satis_adi,' ',maliyet,' ',pd_hizmet,' ',ektra_kazanc,' ',notlar,' ',parayi_gonderen,' ',araci_alan,' ',satilan_fiyat,' ',aciklayici_not,' ',ciro)  like '%".re('aranan')."%'  AND
		// 							satilan_araclar.durum=0
		// 						$order_by 
		// 					"); 
		
				
		// if($yetki=="true"){
		// 	$AyYilCiro = (int) $AyYilToplam['prim'];
		// }else{
		// 	$AyYilCiro = "?";
		// }
		$AyYilCiro = 0;
		while($filtre_oku_prim = mysql_fetch_array($filtre_cek_prim)){
			$prim_first = $filtre_oku_prim["pd_hizmet"] * $admin_prim;
			// $AyYilCiro += $prim_first / 100;
			if($filtre_oku_prim["durum"] != 1){
				$AyYilCiro += $prim_first / 100;
			}
		}
		
		$isim="SATILAN_ARACLAR";

		$replaceDotCol=array(10,11,12); //ilk kolon sıfır olmak üzere belirtilen kolonlarda "," ile "." değiştirilir.
		while($filtre_yaz = mysql_fetch_array($filtre)){
			//SATIRLAR
			// if($yetki=="true"){
				$maliyet = $filtre_yaz["maliyet"];
				$satilan_fiyat = $filtre_yaz["satilan_fiyat"];
				$pd_hizmet = $filtre_yaz["pd_hizmet"];
				$ekstra_kazanc = $filtre_yaz["ektra_kazanc"];
				$ciro = $filtre_yaz["ciro"];
			// }else{
			// 	$maliyet = "?";
			// 	$satilan_fiyat = "?";
			// 	$pd_hizmet = "?";
			// 	$ekstra_kazanc = "?";
			// 	$ciro = "?";
			// }

			if($filtre_yaz["odeme_tarihi"] == "0000-00-00"){
				$tarih1 = "";
			}else{
				$tarih1 = date("d-m-Y", strtotime($filtre_yaz['odeme_tarihi']));
			}
			if($filtre_yaz["tarih"] == "0000-00-00"){
				$tarih2 = "";
			}else{
				$tarih2 = date("d-m-Y", strtotime($filtre_yaz['tarih']));
			}
			
			$data[]=array(
				$sira,
				$tarih1,
				$filtre_yaz["parayi_gonderen"],
				$filtre_yaz["kod"],
				$filtre_yaz["plaka"],
				$filtre_yaz["marka_model"],
				$filtre_yaz["sigorta"],
				$filtre_yaz["araci_alan"],
				$filtre_yaz["satis_adi"],
				$tarih2,
				$satilan_fiyat,
				$pd_hizmet,
				$filtre_yaz["prim"],
				$filtre_yaz["durum"]
			);
			$sira++;
		}	
		//$data[]=array("Toplam $filterCount adet sonuç içinde Toplam Ciro $AyYilCiro ₺");
		exportExcel($isim,$columns,$data,$replaceDotCol,$filterCount,$AyYilCiro,"primlerim");

	} 
	
	if($action=="primlerim_tarihsiz"){
		$columns=array(
			'SIRA',
			'ÖDEME TARİHİ',
			'ÖDEYEN',
			'KOD',
			'PLAKA',
			'MARKA MODEL',
			'SİGORTA',
			'ÜYE ADI',
			'SATIŞ KİMİN ADINA YAPILDI',
			'SATIŞ TARİHİ',
			'SATILAN FİYAT',
			'PD HİZMET BEDELİ',
			'PRİM'
		);
		$listeleme=re("listeleme");
		if($listeleme=="odeme_tarihi_desc"){
			$order_by="order by odeme_tarihi desc";
		}else if($listeleme=="odeme_tarihi_asc"){
			$order_by="order by odeme_tarihi asc";
		}else if($listeleme=="tarih_desc"){
			$order_by="order by tarih desc";
		}else if($listeleme=="tarih_asc"){
			$order_by="order by tarih asc";
		}else{
			$order_by="order by odeme_tarihi desc";
		}
		
		//$result = mysql_query('SELECT SUM(ciro) AS ciro FROM satilan_araclar where durum=0'); 
		/*
		$result = mysql_query("SELECT SUM(satilan_araclar.prim) as prim FROM satilan_araclar INNER JOIN user ON user.id=satilan_araclar.uye_id INNER JOIN prm_notlari ON 
		satilan_araclar.uye_id=prm_notlari.uye_id WHERE prm_notlari.durum=1 AND satilan_araclar.prim > 0 AND user.temsilci_id='".$admin_id."' AND satilan_araclar.durum=0"); 
		$row = mysql_fetch_assoc($result); 

		if($yetki=="true"){
			$sum = (int) $row['prim'];
		}else{
			$sum = "?";
		}
		*/

		//$satilan_cek = mysql_query("SELECT * FROM satilan_araclar ".$order_by." ");
		/*
		$satilan_cek = mysql_query("SELECT satilan_araclar.* FROM satilan_araclar INNER JOIN user ON user.id=satilan_araclar.uye_id INNER JOIN
			prm_notlari ON satilan_araclar.uye_id=prm_notlari.uye_id WHERE prm_notlari.durum=1 AND satilan_araclar.prim > 0 AND
			user.temsilci_id='".$admin_id."' $order_by ");
		*/


		$satilan_cek = mysql_query("SELECT satilan_araclar.* FROM satilan_araclar INNER JOIN user ON user.id=satilan_araclar.uye_id 
		INNER JOIN prm_notlari ON prm_notlari.uye_id = satilan_araclar.uye_id WHERE satilan_araclar.prim > 0 AND prm_notlari.durum = 1 AND
		user.temsilci_id='".$admin_id."' AND MONTH(satilan_araclar.odeme_tarihi) = '".date('m')."' $order_by ");

		$filtre_cek_prim = mysql_query("SELECT satilan_araclar.* FROM satilan_araclar INNER JOIN user ON user.id=satilan_araclar.uye_id 
		INNER JOIN prm_notlari ON prm_notlari.uye_id = satilan_araclar.uye_id WHERE satilan_araclar.prim > 0 AND prm_notlari.durum = 1 AND
		user.temsilci_id='".$admin_id."' AND MONTH(satilan_araclar.odeme_tarihi) = '".date('m')."' $order_by ");
		$sum = 0;
		while($filtre_oku_prim = mysql_fetch_array($filtre_cek_prim)){
			$prim_first = $filtre_oku_prim["pd_hizmet"] * $admin_prim;
			// $sum += $prim_first / 100;
			if($filtre_oku_prim["durum"] != 1){
				$sum += $prim_first / 100;
			}
		}



		$satilan_sayi = mysql_num_rows($satilan_cek);
		$tarih=date("Y-m-d H:i:s");
		$isim="SATILAN_ARACLAR_".$tarih;
		$replaceDotCol=array(10,11,12); //ilk kolon sıfır olmak üzere belirtilen kolonlarda "," ile "." değiştirilir.
		while($satilan_oku = mysql_fetch_array($satilan_cek)){ 
			// if($yetki=="true"){
				$maliyet = $satilan_oku["maliyet"];
				$satilan_fiyat = $satilan_oku["satilan_fiyat"];
				$pd_hizmet = $satilan_oku["pd_hizmet"];
				$ekstra_kazanc = $satilan_oku["ektra_kazanc"];
				$ciro = $satilan_oku["ciro"];
			// }else{
			// 	$maliyet = "?";
			// 	$satilan_fiyat = "?";
			// 	$pd_hizmet = "?";
			// 	$ekstra_kazanc = "?";
			// 	$ciro = "?";
			// }

			if($satilan_oku["odeme_tarihi"] == "0000-00-00"){
				$tarih1 = "";
			}else{
				$tarih1 = date("d-m-Y", strtotime($satilan_oku['odeme_tarihi']));
			}
			if($satilan_oku["tarih"] == "0000-00-00"){
				$tarih2 = "";
			}else{
				$tarih2 = date("d-m-Y", strtotime($satilan_oku['tarih']));
			}
			
			$data[]=array(
				$sira,
				$tarih1,
				$satilan_oku["parayi_gonderen"],
				$satilan_oku["kod"],
				$satilan_oku["plaka"],
				$satilan_oku["marka_model"],
				$satilan_oku["sigorta"],
				$satilan_oku["araci_alan"],
				$satilan_oku["satis_adi"],
				$tarih2,
				$satilan_fiyat,
				$pd_hizmet,
				$satilan_oku["prim"],
				$satilan_oku["durum"]
			);
			$sira++;
		}
		//$data[]=array("Toplam $satilan_sayi adet sonuç içinde Toplam Ciro $sum ₺");
		exportExcel($isim,$columns,$data,$replaceDotCol,$satilan_sayi,$sum,"primlerim");
	}

	//Bana Özel-Üyelerimin Aldıkları
	if($action=="uyelerimin_aldiklari_tarihleri"){
		
		$listeleme=re("listeleme");
		if($listeleme=="odeme_tarihi_desc"){
			$order_by="order by odeme_tarihi desc";
		}else if($listeleme=="odeme_tarihi asc"){
			$order_by="order by odeme_tarihi asc";
		}else if($listeleme=="tarih_desc"){
			$order_by="order by tarih desc";
		}else if($listeleme=="tarih_asc"){
			$order_by="order by tarih asc";
		}else{
			$order_by="order by odeme_tarihi desc";
		}
		
		$BAS=re("tarih1");
		$SON=re("tarih2");
		//$filtre_cek = mysql_query("SELECT * FROM satilan_araclar WHERE tarih BETWEEN '".$BAS."' AND '".$SON."' ".$order_by." ");
		$filtre_cek = mysql_query("SELECT satilan_araclar.* FROM satilan_araclar INNER JOIN user ON user.id=satilan_araclar.uye_id WHERE 
					user.temsilci_id='".$admin_id."' AND satilan_araclar.tarih BETWEEN '".re('tarih1')."' AND '".re('tarih2')."' $order_by");
								
		$filtre_sayi = mysql_num_rows($filtre_cek); 
		//$tarihFiltre = mysql_query("SELECT SUM(ciro) AS ciro FROM satilan_araclar WHERE tarih BETWEEN '".$BAS."' AND '".$SON."' and durum=0"); 
		$tarihFiltre = mysql_query("SELECT SUM(satilan_araclar.ciro) as ciro FROM satilan_araclar INNER JOIN user ON user.id=satilan_araclar.uye_id WHERE user.temsilci_id='".$admin_id."' AND
					satilan_araclar.tarih BETWEEN '".re('tarih1')."' AND '".re('tarih2')."' AND satilan_araclar.durum=0 $order_by"); 
		$filtreToplam = mysql_fetch_assoc($tarihFiltre); 
		// if($yetki=="true"){
			$ToplamFiltre = (int) $filtreToplam['ciro'];
		// }else{
		// 	$ToplamFiltre = "?";
		// }
		
		$isim="SATILAN_ARACLAR"."-".$BAS."-".$SON;
		$replaceDotCol=array(10,11); //ilk kolon sıfır olmak üzere belirtilen kolonlarda "," ile "." değiştirilir.
		$filtre_toplam = 0;
		while($filtre_oku = mysql_fetch_array($filtre_cek)){
			//SATIRLAR
			if($filtre_oku["durum"] == 0){
				$toplam_filtre += $filtre_oku["pd_hizmet"]; 
			}
			// if($yetki=="true"){
				$maliyet = $filtre_oku["maliyet"];
				$satilan_fiyat = $filtre_oku["satilan_fiyat"];
				$pd_hizmet = $filtre_oku["pd_hizmet"];
				$ekstra_kazanc = $filtre_oku["ektra_kazanc"];
				$ciro = $filtre_oku["ciro"];
			// }else{
			// 	$maliyet = "?";
			// 	$satilan_fiyat = "?";
			// 	$pd_hizmet = "?";
			// 	$ekstra_kazanc = "?";
			// 	$ciro = "?";
			// }
			$maliyet = $filtre_oku["maliyet"];
			$satilan_fiyat = $filtre_oku["satilan_fiyat"];
			$pd_hizmet = $filtre_oku["pd_hizmet"];
			$ekstra_kazanc = $filtre_oku["ektra_kazanc"];
			$ciro = $filtre_oku["ciro"];
			
			if($filtre_oku["tarih"] != "0000-00-00"){
				$tarih = date("d-m-Y",strtotime($filtre_oku['tarih']));
			}else{
				$tarih = "";
			}

			$data[]=array(
				$sira,	
				$tarih,
				$filtre_oku["parayi_gonderen"],
				$filtre_oku["kod"],
				$filtre_oku["plaka"],
				$filtre_oku["marka_model"],
				$filtre_oku["sigorta"],
				$filtre_oku["araci_alan"],
				$filtre_oku["satis_adi"],
				$tarih,
				$satilan_fiyat,
				$pd_hizmet,
				$filtre_oku["durum"]
			);
			$sira++;
		}	
		//$data[]=array("Toplam $filtre_sayi adet sonuç içinde Toplam Ciro $ToplamFiltre ₺");
		exportExcel($isim,$columns_uyelerin_aldiklari,$data,$replaceDotCol,$filtre_sayi,$filtre_toplam);
	}
	if($action=="uyelerimin_aldiklari_secili_tarihi"){
		$listeleme=re("listeleme");
		if($listeleme=="odeme_tarihi_desc"){
			$order_by="order by odeme_tarihi desc";
		}else if($listeleme=="odeme_tarihi asc"){
			$order_by="order by odeme_tarihi asc";
		}else if($listeleme=="tarih_desc"){
			$order_by="order by tarih desc";
		}else if($listeleme=="tarih_asc"){
			$order_by="order by tarih asc";
		}else{
			$order_by="order by odeme_tarihi desc";
		}			

		$BAS=re("tarih1");
		$SON=re("tarih2");
		/*$filtre = mysql_query("SELECT * FROM satilan_araclar WHERE  MONTH(tarih)= '$BAS' AND YEAR(tarih)= '$SON' ".$order_by." ");*/
		$filtre = mysql_query("SELECT satilan_araclar.* FROM satilan_araclar INNER JOIN user ON user.id=satilan_araclar.uye_id WHERE user.temsilci_id='".$admin_id."' AND
			MONTH(satilan_araclar.odeme_tarihi) = '".$BAS."' AND YEAR(satilan_araclar.odeme_tarihi)= '".$SON."' $order_by");

		// $filtre = mysql_query("SELECT satilan_araclar.* FROM satilan_araclar INNER JOIN user ON user.id=satilan_araclar.uye_id
		// 	WHERE user.temsilci_id='".$admin_id."' AND MONTH(satilan_araclar.odeme_tarihi) = '".$BAS."' AND YEAR(satilan_araclar.odeme_tarihi)= '".$gelen_yil."' $order_by");


		$filterCount = mysql_num_rows($filtre);
		/*$ayYil = mysql_query("SELECT SUM(ciro) AS ciro FROM satilan_araclar WHERE  MONTH(tarih) = '$BAS' AND YEAR(tarih)= '$SON' and durum=0"); */
		$ayYil = mysql_query("
									SELECT 
										SUM(satilan_araclar.ciro) as ciro
									FROM
										satilan_araclar 
									INNER JOIN 
										user ON user.id=satilan_araclar.uye_id
									WHERE 
										user.temsilci_id='".$admin_id."' AND
										MONTH(satilan_araclar.tarih) = '".$BAS."' AND YEAR(satilan_araclar.tarih)= '".$SON."'
										satilan_araclar.durum=0
									$order_by 
								"); 
		$AyYilToplam = mysql_fetch_assoc($ayYil); 
		
				
		// if($yetki=="true"){
			$AyYilCiro = (int) $AyYilToplam['ciro'];
		// }else{
		// 	$AyYilCiro = "?";
		// }
		
		$isim="SATILAN_ARACLAR"."-".$BAS."-".$SON;
		$filtre_toplam = 0;

		$replaceDotCol=array(10,11); //ilk kolon sıfır olmak üzere belirtilen kolonlarda "," ile "." değiştirilir.
		while($filtre_yaz = mysql_fetch_array($filtre)){
			if($filtre_yaz["durum"] == 0){
				$filtre_toplam += $filtre_yaz["pd_hizmet"]; 
			}
			//SATIRLAR
			// if($yetki=="true"){
				$maliyet = $filtre_yaz["maliyet"];
				$satilan_fiyat = $filtre_yaz["satilan_fiyat"];
				$pd_hizmet = $filtre_yaz["pd_hizmet"];
				$ekstra_kazanc = $filtre_yaz["ektra_kazanc"];
				$ciro = $filtre_yaz["ciro"];
			// }else{
			// 	$maliyet = "?";
			// 	$satilan_fiyat = "?";
			// 	$pd_hizmet = "?";
			// 	$ekstra_kazanc = "?";
			// 	$ciro = "?";
			// }
			$maliyet = $filtre_yaz["maliyet"];
			$satilan_fiyat = $filtre_yaz["satilan_fiyat"];
			$pd_hizmet = $filtre_yaz["pd_hizmet"];
			$ekstra_kazanc = $filtre_yaz["ektra_kazanc"];
			$ciro = $filtre_yaz["ciro"];
			if($filtre_yaz["odeme_tarihi"] != "0000-00-00"){
				$odeme_tarihi = date("d-m-Y",strtotime($filtre_yaz['odeme_tarihi']));
			}else{
				$odeme_tarihi = "";
			}
			if($filtre_yaz["tarih"] != "0000-00-00"){
				$tarih = date("d-m-Y",strtotime($filtre_yaz['tarih']));
			}else{
				$tarih = "";
			}

			
			$data[]=array(
				$sira,
				$odeme_tarihi,
				$filtre_yaz["parayi_gonderen"],
				$filtre_yaz["kod"],
				$filtre_yaz["plaka"],
				$filtre_yaz["marka_model"],
				$filtre_yaz["sigorta"],
				$filtre_yaz["araci_alan"],
				$filtre_yaz["satis_adi"],
				$tarih,
				$satilan_fiyat,
				$pd_hizmet,
				$filtre_yaz["durum"]
			);
			$sira++;
		}	
		// if($yetki=="true"){
		// 	$filtre_toplam = (int) $filtre_toplam;
		// }else{
		// 	$filtre_toplam = "?";
		// }
		// $filtre_toplam = (int) $filtre_toplam;
		//$data[]=array("Toplam $filterCount adet sonuç içinde Toplam Ciro $AyYilCiro ₺");
		exportExcel($isim,$columns_uyelerin_aldiklari,$data,$replaceDotCol,$filterCount,$filtre_toplam);

	} 
	if($action=="uyelerimin_arama"){
		$listeleme=re("listeleme");
		if($listeleme=="odeme_tarihi_desc"){
			$order_by="order by odeme_tarihi desc";
		}else if($listeleme=="odeme_tarihi asc"){
			$order_by="order by odeme_tarihi asc";
		}else if($listeleme=="tarih_desc"){
			$order_by="order by tarih desc";
		}else if($listeleme=="tarih_asc"){
			$order_by="order by tarih asc";
		}else{
			$order_by="order by odeme_tarihi desc";
		}			

		$aranan=re("aranan");
		//$filtre = mysql_query("SELECT * FROM satilan_araclar WHERE  MONTH(tarih)= '$BAS' AND YEAR(tarih)= '$SON' ".$order_by." ");
		$filtre = mysql_query("
								SELECT 
									satilan_araclar.*
								FROM
									satilan_araclar 
								INNER JOIN 
									user ON user.id=satilan_araclar.uye_id
								WHERE 
									user.temsilci_id='".$admin_id."' AND
									concat(plaka,' ',kod,' ',marka_model,' ',sigorta,' ',satis_adi,' ',maliyet,' ',pd_hizmet,' ',ektra_kazanc,' ',notlar,' ',parayi_gonderen,' ',araci_alan,' ',satilan_fiyat,' ',aciklayici_not,' ',ciro)  like '%".re('aranan')."%' 
								$order_by
							");
		$filterCount = mysql_num_rows($filtre);
		//$ayYil = mysql_query("SELECT SUM(ciro) AS ciro FROM satilan_araclar WHERE  MONTH(tarih) = '$BAS' AND YEAR(tarih)= '$SON' and durum=0"); 
		$ayYil = mysql_query("
								SELECT 
									SUM(satilan_araclar.ciro) as ciro
								FROM
									satilan_araclar 
								INNER JOIN 
									user ON user.id=satilan_araclar.uye_id
								WHERE 
									user.temsilci_id='".$admin_id."' AND
									concat(plaka,' ',kod,' ',marka_model,' ',sigorta,' ',satis_adi,' ',maliyet,' ',pd_hizmet,' ',ektra_kazanc,' ',notlar,' ',parayi_gonderen,' ',araci_alan,' ',satilan_fiyat,' ',aciklayici_not,' ',ciro)  like '%".re('aranan')."%' AND
									satilan_araclar.durum=0
								$order_by 
							"); 
		$AyYilToplam = mysql_fetch_assoc($ayYil); 
		
				
		// if($yetki=="true"){
			$AyYilCiro = (int) $AyYilToplam['ciro'];
		// }else{
		// 	$AyYilCiro = "?";
		// }
		
		$isim="SATILAN_ARACLAR";

		$replaceDotCol=array(10,11); //ilk kolon sıfır olmak üzere belirtilen kolonlarda "," ile "." değiştirilir.
		$toplam_filtre = 0;
		while($filtre_yaz = mysql_fetch_array($filtre)){
			if($filtre_yaz["durum"] == 0){
				$toplam_filtre += $filtre_yaz["pd_hizmet"]; 
			}
		
			//SATIRLAR
			// if($yetki=="true"){
				$maliyet = $filtre_yaz["maliyet"];
				$satilan_fiyat = $filtre_yaz["satilan_fiyat"];
				$pd_hizmet = $filtre_yaz["pd_hizmet"];
				$ekstra_kazanc = $filtre_yaz["ektra_kazanc"];
				$ciro = $filtre_yaz["ciro"];
			// }else{
			// 	$maliyet = "?";
			// 	$satilan_fiyat = "?";
			// 	$pd_hizmet = "?";
			// 	$ekstra_kazanc = "?";
			// 	$ciro = "?";
			// }
			$maliyet = $filtre_yaz["maliyet"];
			$satilan_fiyat = $filtre_yaz["satilan_fiyat"];
			$pd_hizmet = $filtre_yaz["pd_hizmet"];
			$ekstra_kazanc = $filtre_yaz["ektra_kazanc"];
			$ciro = $filtre_yaz["ciro"];

			if($filtre_yaz["tarih"] != "0000-00-00"){
				$tarih = date("d-m-Y",strtotime($filtre_yaz['tarih']));
			}else{
				$tarih = "";
			}

			
			$data[]=array(
				$sira,
				$tarih,
				$filtre_yaz["parayi_gonderen"],
				$filtre_yaz["kod"],
				$filtre_yaz["plaka"],
				$filtre_yaz["marka_model"],
				$filtre_yaz["sigorta"],
				$filtre_yaz["araci_alan"],
				$filtre_yaz["satis_adi"],
				$tarih,
				$satilan_fiyat,
				$pd_hizmet,
				$filtre_yaz["durum"]
			);
			$sira++;
		}	
		//$data[]=array("Toplam $filterCount adet sonuç içinde Toplam Ciro $AyYilCiro ₺");
		exportExcel($isim,$columns_uyelerin_aldiklari,$data,$replaceDotCol,$filterCount,$toplam_filtre);

	} 
	if($action=="uyelerimin_aldiklari_tarihsiz"){
			
		$listeleme=re("listeleme");
		if($listeleme=="odeme_tarihi_desc"){
			$order_by="order by odeme_tarihi desc";
		}else if($listeleme=="odeme_tarihi_asc"){
			$order_by="order by odeme_tarihi asc";
		}else if($listeleme=="tarih_desc"){
			$order_by="order by tarih desc";
		}else if($listeleme=="tarih_asc"){
			$order_by="order by tarih asc";
		}else{
			$order_by="order by odeme_tarihi desc";
		}
		
		//$result = mysql_query('SELECT SUM(ciro) AS ciro FROM satilan_araclar where durum=0'); 
		$result = mysql_query("SELECT SUM(satilan_araclar.ciro) as ciro FROM satilan_araclar INNER JOIN user ON user.id=satilan_araclar.uye_id
		WHERE user.temsilci_id='".$admin_id."' AND satilan_araclar.durum=0 "); 
		$row = mysql_fetch_assoc($result); 
		$sum = $row['ciro'];
		
		// if($yetki=="true"){
			$sum = (int) $row['ciro'];
		// }else{
		// 	$sum = "?";
		// }

		//$satilan_cek = mysql_query("SELECT * FROM satilan_araclar ".$order_by." ");
		/*
		$satilan_cek = mysql_query("SELECT satilan_araclar.* FROM satilan_araclar INNER JOIN user ON user.id=satilan_araclar.uye_id
		WHERE user.temsilci_id='".$admin_id."' $order_by ");
		*/


		$month = date('m');
		$satilan_cek = mysql_query("SELECT satilan_araclar.* FROM satilan_araclar INNER JOIN user ON user.id=satilan_araclar.uye_id
		WHERE user.temsilci_id='".$admin_id."' AND MONTH(satilan_araclar.odeme_tarihi) = '".$month."' $order_by ");
		$satilan_sayi = mysql_num_rows($satilan_cek);
		$tarih=date("Y-m-d H:i:s");
		$isim="SATILAN_ARACLAR_".$tarih;
		$toplam_filtre = 0;
		$replaceDotCol=array(10,11); //ilk kolon sıfır olmak üzere belirtilen kolonlarda "," ile "." değiştirilir.
		while($satilan_oku = mysql_fetch_array($satilan_cek)){ 
			if($satilan_oku["durum"] == 0){
				$toplam_filtre += $satilan_oku["pd_hizmet"];
			}
		
			/*
			if($yetki=="true"){
				$maliyet = $satilan_oku["maliyet"];
				$satilan_fiyat = $satilan_oku["satilan_fiyat"];
				$pd_hizmet = $satilan_oku["pd_hizmet"];
				$ekstra_kazanc = $satilan_oku["ektra_kazanc"];
				$ciro = $satilan_oku["ciro"];
			}else{
				$maliyet = "?";
				$satilan_fiyat = "?";
				$pd_hizmet = "?";
				$ekstra_kazanc = "?";
				$ciro = "?";
			}
			*/
			$maliyet = $satilan_oku["maliyet"];
			$satilan_fiyat = $satilan_oku["satilan_fiyat"];
			$pd_hizmet = $satilan_oku["pd_hizmet"];
			$ekstra_kazanc = $satilan_oku["ektra_kazanc"];
			$ciro = $satilan_oku["ciro"];

			if($satilan_oku["tarih"] != "0000-00-00"){
				$tarih = date("d-m-Y",strtotime($satilan_oku['tarih']));
			}else{
				$tarih = "";
			}
			
			$data[]=array(
				$sira,
				$tarih,
				$satilan_oku["parayi_gonderen"],
				$satilan_oku["kod"],
				$satilan_oku["plaka"],
				$satilan_oku["marka_model"],
				$satilan_oku["sigorta"],
				$satilan_oku["araci_alan"],
				$satilan_oku["satis_adi"],
				$tarih,
				$satilan_fiyat,
				$pd_hizmet,
				$satilan_oku["durum"]
			);
			$sira++;
		}
		//$data[]=array("Toplam $satilan_sayi adet sonuç içinde Toplam Ciro $sum ₺");
		// exportExcel($isim,$columns_uyelerin_aldiklari,$data,$replaceDotCol,$satilan_sayi,$sum);
		exportExcel($isim,$columns_uyelerin_aldiklari,$data,$replaceDotCol,$satilan_sayi,$toplam_filtre);
	}
	

	if($action=="muhasebe_uye_bakiyeleri"){		
		$columns=array('SIRA','ÜYE ID','ÜYELİK TİPİ','ÜYE ADI SOYADI/FİRMA ADI','ÜYE GRUBU','TUTAR');
		$toplam = 0;
		$sira=1;
		$cek = mysql_query("SELECT SUM(tutar) as toplam,uye_id,durum FROM cayma_bedelleri WHERE durum = 1 GROUP BY uye_id");
		$bakiye_sayi = mysql_num_rows($cek);
		$tarih=date("Y-m-d H:i:s");
		$isim="ÜYE_BAKİYELERİ_".$tarih;
		$replaceDotCol=array(); //ilk kolon sıfır olmak üzere belirtilen kolonlarda "," ile "." değiştirilir.
		while($oku = mysql_fetch_object($cek)){
			$uye_cek = mysql_query("select * from user where id = '".$oku->uye_id."'");
			if(mysql_num_rows($uye_cek) != 0){
				$uye_oku = mysql_fetch_object($uye_cek);
				$borclar_toplam = mysql_query("SELECT SUM(tutar) as toplam_borclar FROM cayma_bedelleri WHERE uye_id='" . $oku->uye_id . "' AND durum=6 ");
				$toplam_borclar = mysql_fetch_object($borclar_toplam);
				$toplam_cayma = $oku->toplam - $toplam_borclar->toplam_borclar;
				$toplam += $toplam_cayma;
				if($uye_oku->user_token != ""){
					$uye_adi = $uye_oku->ad;
					$uyelik_tipi = "Bireysel";
				}else{
					$uye_adi = $uye_oku->unvan;
					$uyelik_tipi = "Kurumsal";
				}
				$paket_bul = mysql_query("SELECT * FROM uye_grubu WHERE id = '".$uye_oku->paket."'");
				$paket_oku = mysql_fetch_object($paket_bul);
				$data[]=array(
					$sira,
					$oku->uye_id,
					$uyelik_tipi,
					$uye_adi,
					$paket_oku->grup_adi,
					money($toplam_cayma)." ₺"
				);
				$sira++;
			}
		}
		exportExcel($isim,$columns,$data,$replaceDotCol,$bakiye_sayi,$toplam,"muhasebe");
	}	
	


	if($action=="performans_tarihler_arasini"){
		$columns=array(
			'SIRA',
			'YAPILAN İŞ',
			'AÇIKLAMALAR',
			'EKLEYEN',
			'EKLEME ZAMANİ',

		);
		$sira = 1;
		$bas=re("ilk_tarih");
		$son=re("ikinci_tarih");
		//$is_cek = mysql_query("SELECT * FROM yapilan_is WHERE ekleme_zamani BETWEEN '".$bas."' AND '".$son."' order by ekleme_zamani desc ");
		$is_cek = mysql_query("SELECT * FROM yapilan_is WHERE ekleme_zamani BETWEEN '".re('ilk_tarih')." 00:00:00"."' AND '".re('ikinci_tarih')." 23:59:59"."' order by ekleme_zamani desc ");
		
		
		$isim="PERFORMANSLAR"."-".$bas."-".$son;

		$replaceDotCol=array(); //ilk kolon sıfır olmak üzere belirtilen kolonlarda "," ile "." değiştirilir.
		while($is_oku = mysql_fetch_array($is_cek)){ 
            
            $yapilan_is = $is_oku['yaptigi'];
            $admi_id = $is_oku['admin_id'];
            $aracin_id = $is_oku['ilan_id'];
            $admin_cek = mysql_query("SELECT * FROM kullanicilar WHERE id = '".$admi_id."'");
            $admin_oku = mysql_fetch_assoc($admin_cek);
            $admin_ad = $admin_oku['adi']." ".$admin_oku['soyadi'];
            if($yapilan_is == 1){
                $ilan_cek = mysql_query("SELECT * FROM ilanlar WHERE id='".$is_oku['ilan_id']."'");
                $ilan_oku = mysql_fetch_assoc($ilan_cek);
                $ilan_no = $ilan_oku['arac_kodu'];
                $yapilan_is = "İlan Ekle"." / ".$ilan_oku['arac_kodu'];
				$aciklama=$is_oku['aciklama'];
            }elseif($yapilan_is == 2){     
                $ilan_cek = mysql_query("SELECT * FROM ilanlar WHERE id='".$is_oku['ilan_id']."'");
                $ilan_oku = mysql_fetch_assoc($ilan_cek);           
                $yapilan_is = "İlan Notu"." / ".$ilan_oku['arac_kodu'];
				if($is_oku['gizlilik']==0){
					if($admin_id==$is_oku["admin_id"]){
						$aciklama=$is_oku['aciklama'];
					}else{
						$aciklama="Sadece ekleyen admin görebilir";
					}
				}else if($is_oku['gizlilik']==1){
					if (count($yetki_parcala)==13) { 
						$aciklama=$is_oku['aciklama'];
					}else{
						$aciklama="Sadece tam yetkili adminler görebilir";
					}
				}else{
					$aciklama="Sadece ekleyen admin görebilir";
				}
            }elseif($yapilan_is == 3){     
                $uye_bul = mysql_query("SELECT * FROM user WHERE id = '".$is_oku['uye_id']."'");
                $uye_yaz = mysql_fetch_assoc($uye_bul);
                $uye_ad = $uye_yaz['ad'];
                $yapilan_is = "Üye Notu"." / ".$uye_ad;
				$aciklama=$is_oku['aciklama'];
            }elseif($yapilan_is == 4){     
                $uye_bul = mysql_query("SELECT * FROM user WHERE id = '".$is_oku['uye_id']."'");
                $uye_yaz = mysql_fetch_assoc($uye_bul);
                $uye_ad = $uye_yaz['ad'];
                $yapilan_is = "PRM Notu"." / ".$uye_ad;
				$aciklama=$is_oku['aciklama'];
            }
			$data[]=array(
				$sira,
				$yapilan_is,
				$aciklama,
				$admin_ad,
				date("d-m-Y H:i:s", strtotime($is_oku['ekleme_zamani'])) 
			);
			$sira++;
		} 
		exportExcel2($isim,$columns,$data,$replaceDotCol);
	}
	/*
	if($action=="performans_tarihler_arasini"){
		$columns=array(
			'SIRA',
			'YAPILAN İŞ',
			'AÇIKLAMALAR',
			'EKLEYEN',
			'EKLEME ZAMANİ',
		);
		$sira = 1;
		$bas=re("ilk_tarih");
		$son=re("ikinci_tarih");
		$is_cek = mysql_query("SELECT * FROM yapilan_is WHERE ekleme_zamani BETWEEN '".$bas."' AND '".$son."' order by ekleme_zamani desc ");
		
		
		$isim="PERFORMANSLAR"."-".$bas."-".$son;

		$replaceDotCol=array(); //ilk kolon sıfır olmak üzere belirtilen kolonlarda "," ile "." değiştirilir.
		while($is_oku = mysql_fetch_array($is_cek)){ 
            
            $yapilan_is = $is_oku['yaptigi'];
            $admi_id = $is_oku['admin_id'];
            $aracin_id = $is_oku['ilan_id'];
            $admin_cek = mysql_query("SELECT * FROM kullanicilar WHERE id = '".$admi_id."'");
            $admin_oku = mysql_fetch_assoc($admin_cek);
            $admin_ad = $admin_oku['adi']." ".$admin_oku['soyadi'];
            if($yapilan_is == 1){
                $ilan_cek = mysql_query("SELECT * FROM ilanlar WHERE id='".$is_oku['ilan_id']."'");
                $ilan_oku = mysql_fetch_assoc($ilan_cek);
                $ilan_no = $ilan_oku['arac_kodu'];
                $yapilan_is = "İlan Ekle"." / ".$ilan_oku['arac_kodu'];
				$aciklama=$is_oku['aciklama'];
            }elseif($yapilan_is == 2){     
                $ilan_cek = mysql_query("SELECT * FROM ilanlar WHERE id='".$is_oku['ilan_id']."'");
                $ilan_oku = mysql_fetch_assoc($ilan_cek);           
                $yapilan_is = "İlan Notu"." / ".$ilan_oku['arac_kodu'];
				if($is_oku['gizlilik']==0){
					if($admin_id==$is_oku["admin_id"]){
						$aciklama=$is_oku['aciklama'];
					}else{
						$aciklama="Sadece ekleyen admin görebilir";
					}
				}else if($is_oku['gizlilik']==1){
					if (count($yetki_parcala)==13) { 
						$aciklama=$is_oku['aciklama'];
					}else{
						$aciklama="Sadece tam yetkili adminler görebilir";
					}
				}else{
					$aciklama="Sadece ekleyen admin görebilir";
				}
            }elseif($yapilan_is == 3){     
                $uye_bul = mysql_query("SELECT * FROM user WHERE id = '".$is_oku['uye_id']."'");
                $uye_yaz = mysql_fetch_assoc($uye_bul);
                $uye_ad = $uye_yaz['ad'];
                $yapilan_is = "Üye Notu"." / ".$uye_ad;
				$aciklama=$is_oku['aciklama'];
            }elseif($yapilan_is == 4){     
                $uye_bul = mysql_query("SELECT * FROM user WHERE id = '".$is_oku['uye_id']."'");
                $uye_yaz = mysql_fetch_assoc($uye_bul);
                $uye_ad = $uye_yaz['ad'];
                $yapilan_is = "PRM Notu"." / ".$uye_ad;
				$aciklama=$is_oku['aciklama'];
            }
			$data[]=array(
				$sira,
				$yapilan_is,
				$aciklama,
				$admin_ad,
				date("d-m-Y H:i:s", strtotime($is_oku['ekleme_zamani'])) 
			);
			$sira++;
			
			
		} 
		exportExcel2($isim,$columns,$data,$replaceDotCol);

	}
	*/
	if($action=="performans_secili_tarihi"){
		$columns=array(
			'SIRA',
			'YAPILAN İŞ',
			'AÇIKLAMALAR',
			'EKLEYEN',
			'EKLEME ZAMANİ',
		);
		$sira = 1;
		$bas=re("ay");
		$son=re("yil");
		$is_cek = mysql_query("SELECT * FROM yapilan_is WHERE MONTH(ekleme_zamani) = '$bas' AND YEAR(ekleme_zamani)= '$son' order by ekleme_zamani desc ");
		
		
		$isim="PERFORMANSLAR"."-".$bas."-".$son;

		$replaceDotCol=array(); //ilk kolon sıfır olmak üzere belirtilen kolonlarda "," ile "." değiştirilir.
		while($is_oku = mysql_fetch_array($is_cek)){ 
            
            $yapilan_is = $is_oku['yaptigi'];
            $admi_id = $is_oku['admin_id'];
            $aracin_id = $is_oku['ilan_id'];
            $admin_cek = mysql_query("SELECT * FROM kullanicilar WHERE id = '".$admi_id."'");
            $admin_oku = mysql_fetch_assoc($admin_cek);
            $admin_ad = $admin_oku['adi']." ".$admin_oku['soyadi'];
            if($yapilan_is == 1){
                $ilan_cek = mysql_query("SELECT * FROM ilanlar WHERE id='".$is_oku['ilan_id']."'");
                $ilan_oku = mysql_fetch_assoc($ilan_cek);
                $ilan_no = $ilan_oku['arac_kodu'];
                $yapilan_is = "İlan Ekle"." / ".$ilan_oku['arac_kodu'];
				$aciklama=$is_oku['aciklama'];
            }elseif($yapilan_is == 2){     
                $ilan_cek = mysql_query("SELECT * FROM ilanlar WHERE id='".$is_oku['ilan_id']."'");
                $ilan_oku = mysql_fetch_assoc($ilan_cek);           
                $yapilan_is = "İlan Notu"." / ".$ilan_oku['arac_kodu'];
				if($is_oku['gizlilik']==0){
					if($admin_id==$is_oku["admin_id"]){
						$aciklama=$is_oku['aciklama'];
					}else{
						$aciklama="Sadece ekleyen admin görebilir";
					}
				}else if($is_oku['gizlilik']==1){
					if (count($yetki_parcala)==13) { 
						$aciklama=$is_oku['aciklama'];
					}else{
						$aciklama="Sadece tam yetkili adminler görebilir";
					}
				}else{
					$aciklama="Sadece ekleyen admin görebilir";
				}
            }elseif($yapilan_is == 3){     
                $uye_bul = mysql_query("SELECT * FROM user WHERE id = '".$is_oku['uye_id']."'");
                $uye_yaz = mysql_fetch_assoc($uye_bul);
                $uye_ad = $uye_yaz['ad'];
                $yapilan_is = "Üye Notu"." / ".$uye_ad;
				$aciklama=$is_oku['aciklama'];
            }elseif($yapilan_is == 4){     
                $uye_bul = mysql_query("SELECT * FROM user WHERE id = '".$is_oku['uye_id']."'");
                $uye_yaz = mysql_fetch_assoc($uye_bul);
                $uye_ad = $uye_yaz['ad'];
                $yapilan_is = "PRM Notu"." / ".$uye_ad;
				$aciklama=$is_oku['aciklama'];
            }
			$data[]=array(
				$sira,
				$yapilan_is,
				$aciklama,
				$admin_ad,
				date("d-m-Y H:i:s", strtotime($is_oku['ekleme_zamani'])) 
			);
			$sira++;
			
			
		} 
		exportExcel2($isim,$columns,$data,$replaceDotCol);

	}
	if($action=="aktif_cayma_excel"){		
		$columns=array(
			'ÜYE ID VE ADI',
			'ÜYE GRUBU',
			'PARANIN GELDİĞİ TARİH',
			'PARAYI GÖNDEREN',
			'IBAN',
			'AÇIKLAMALAR',
			'TUTAR'
		);
		$sira = 1;
		$cayma=mysql_query("
			SELECT
				cayma_bedelleri.*,
				user.id as user_id,
				user.ad as user_ad,
				user.unvan as user_unvan,
				user.user_token as user_token,
				user.kurumsal_user_token as kurumsal_user_token,
				uye_grubu.grup_adi as user_paket
			FROM
				cayma_bedelleri
			INNER JOIN
				user
			ON
				user.id=cayma_bedelleri.uye_id
			INNER JOIN
				uye_grubu
			ON
				user.paket=uye_grubu.id
			WHERE
				durum=1
			ORDER BY
				paranin_geldigi_tarih desc
		");
		
		
		$isim="AKTIF_CAYMALAR".date("d-m-Y H:i");
		$toplam = 0;
		$replaceDotCol=array();
		while($cayma_fetch=mysql_fetch_array($cayma)){
			if($cayma_fetch["kurumsal_user_token"]!=""){
				$user_ad=$cayma_fetch["user_unvan"];
			}else{
				$user_ad=$cayma_fetch["user_ad"];
			}
			$toplam += $cayma_fetch["tutar"];
			$data[]=array(
				$cayma_fetch["user_id"]."-".$user_ad,
				$cayma_fetch["user_paket"],
				date("d-m-Y",strtotime($cayma_fetch["paranin_geldigi_tarih"])),
				$cayma_fetch["hesap_sahibi"] ,
				"TR".strval($cayma_fetch["iban"]) ,
				$cayma_fetch["aciklama"] ,
				$cayma_fetch["tutar"]
			);
			$sira++;
		} 
		$data[]=array(
			'',
			'',
			'',
			'',
			'',
			'TOPLAM',
			$toplam
		);
		$sira++;
		exportExcel2($isim,$columns,$data,$replaceDotCol);

	}
	if($action=="iade_talepleri_excel"){
		$columns=array(
			'ÜYE ID VE ADI',
			'ÜYE GRUBU',
			'PARANIN GELDİĞİ TARİH',
			'PARAYI GÖNDEREN',
			'IBAN',
			'AÇIKLAMALAR',
			'TUTAR',
			'İADE TALEP TARİHİ'
		);
		$sira = 1;
		$cayma=mysql_query("
			SELECT
				cayma_bedelleri.*,
				user.id as user_id,
				user.ad as user_ad,
				user.unvan as user_unvan,
				user.user_token as user_token,
				user.kurumsal_user_token as kurumsal_user_token,
				uye_grubu.grup_adi as user_paket
			FROM
				cayma_bedelleri
			INNER JOIN
				user
			ON
				user.id=cayma_bedelleri.uye_id
			INNER JOIN
				uye_grubu
			ON
				user.paket=uye_grubu.id
			WHERE
				durum=2
			ORDER BY
				iade_talep_tarihi desc
		");
		
		
		$isim="IADE_TALEPLERI_".date("d-m-Y H:i");
		$toplam = 0;
		$replaceDotCol=array();
		while($cayma_fetch=mysql_fetch_array($cayma)){
			$toplam += $cayma_fetch["tutar"];
			if($cayma_fetch["kurumsal_user_token"]!=""){
				$user_ad=$cayma_fetch["user_unvan"];
			}else{
				$user_ad=$cayma_fetch["user_ad"];
			}
			$data[]=array(
				$cayma_fetch["user_id"]."-".$user_ad,
				$cayma_fetch["user_paket"],
				date("d-m-Y",strtotime($cayma_fetch["paranin_geldigi_tarih"])),
				$cayma_fetch["hesap_sahibi"] ,
				$cayma_fetch["aciklama"] ,
				"TR".strval($cayma_fetch["iban"]) ,
				$cayma_fetch["tutar"], 
				$cayma_fetch["iade_talep_tarihi"], 
			);
			$sira++;
		} 
		$data[]=array(
			'',
			'',
			'',
			'',
			'',
			'TOPLAM',
			$toplam,
			''
		);
		$sira++;
		exportExcel2($isim,$columns,$data,$replaceDotCol);
		
	}
	if($action=="iade_edilenler_excel"){
		$columns=array(
			'ÜYE ID VE ADI',
			'ÜYE GRUBU',
			'PARANIN GELDİĞİ TARİH',
			'İADE EDİLDİĞİ TARİH',
			'HESAP SAHİBİ',
			'IBAN',
			'AÇIKLAMALAR',
			'TUTAR'
		);
		$ay=re("ay");
		$yii=re("yil");
		$listeleme="iade_tarihi";
		if($ay!=""){
			$where="MONTH(".$listeleme.") = '$ay' AND YEAR(".$listeleme.") = '$yil'";
			$isim="IADE_EDILENLER_".$ay."_".$yil;
		}else if($yil!=""){
			$where="YEAR(".$listeleme.") = '$yil'";
			$isim="IADE_EDILENLER_".$yil;
		}else{
			$year_start = strtotime('first day of January', time());
			$year_start_date=date('Y-m-d', $year_start);
			$year_end = strtotime('last day of December', time());
			$year_end_date=date('Y-m-d', $year_end);
			$where=$listeleme." BETWEEN '".$year_start_date."' AND '".$year_end_date."' ";
			$isim="IADE_EDILENLER_".date("d-m-Y H:i");
		}
		$cayma=mysql_query("
			SELECT
				cayma_bedelleri.*,
				user.id as user_id,
				user.ad as user_ad,
				user.unvan as user_unvan,
				user.user_token as user_token,
				user.kurumsal_user_token as kurumsal_user_token,
				uye_grubu.grup_adi as user_paket
			FROM
				cayma_bedelleri
			INNER JOIN
				user
			ON
				user.id=cayma_bedelleri.uye_id
			INNER JOIN
				uye_grubu
			ON
				user.paket=uye_grubu.id
			WHERE
				durum=3 AND
				".$where."
			ORDER BY
				".$listeleme." desc
		");
		
		$toplam = 0;
		$replaceDotCol=array();
		while($cayma_fetch=mysql_fetch_array($cayma)){
			if($cayma_fetch["kurumsal_user_token"]!=""){
				$user_ad=$cayma_fetch["user_unvan"];
			}else{
				$user_ad=$cayma_fetch["user_ad"];
			}
			$toplam += $cayma_fetch["tutar"];
			$data[]=array(
				$cayma_fetch["user_id"]."-".$user_ad,
				$cayma_fetch["user_paket"],
				date("d-m-Y",strtotime($cayma_fetch["paranin_geldigi_tarih"])),
				date("d-m-Y",strtotime($cayma_fetch["iade_tarihi"])),
				$cayma_fetch["hesap_sahibi"] ,
				"TR".strval($cayma_fetch["iban"]) ,
				$cayma_fetch["aciklama"],
				$cayma_fetch["tutar"]
			);
			$sira++;
		} 
		$data[]=array(
			'',
			'',
			'',
			'',
			'',
			'',
			'TOPLAM',
			$toplam
		);
		$sira++;
		exportExcel2($isim,$columns,$data,$replaceDotCol);
	}
	if($action=="mahsup_edilenler_excel"){
		$columns=array(
			'ÜYE ID VE ADI',
			'ÜYE GRUBU',
			'PARANIN GELDİĞİ TARİH',
			'MAHSUP TARİHİ',
			'KONU ARAÇ',
			'AÇIKLAMALAR',
			'TUTAR'
		);
		$ay=re("ay");
		$yii=re("yil");
		$listeleme="mahsup_tarihi";
		if($ay!=""){
			$where="MONTH(".$listeleme.") = '$ay' AND YEAR(".$listeleme.") = '$yil'";
			$isim="MAHSUP_EDILENLER_".$ay."_".$yil;
		}else if($yil!=""){
			$where="YEAR(".$listeleme.") = '$yil'";
			$isim="MAHSUP_EDILENLER_".$yil;
		}else{
			$year_start = strtotime('first day of January', time());
			$year_start_date=date('Y-m-d', $year_start);
			$year_end = strtotime('last day of December', time());
			$year_end_date=date('Y-m-d', $year_end);
			$where=$listeleme." BETWEEN '".$year_start_date."' AND '".$year_end_date."' ";
			$isim="MAHSUP_EDILENLER_".date("d-m-Y H:i");
		}
		$cayma=mysql_query("
			SELECT
				cayma_bedelleri.*,
				user.id as user_id,
				user.ad as user_ad,
				user.unvan as user_unvan,
				user.user_token as user_token,
				user.kurumsal_user_token as kurumsal_user_token,
				uye_grubu.grup_adi as user_paket
			FROM
				cayma_bedelleri
			INNER JOIN
				user
			ON
				user.id=cayma_bedelleri.uye_id
			INNER JOIN
				uye_grubu
			ON
				user.paket=uye_grubu.id
			WHERE
				durum=4 AND
				".$where."
			ORDER BY
				".$listeleme." desc
		");
		
		$toplam = 0;
		$replaceDotCol=array();
		while($cayma_fetch=mysql_fetch_array($cayma)){
			if($cayma_fetch["kurumsal_user_token"]!=""){
				$user_ad=$cayma_fetch["user_unvan"];
			}else{
				$user_ad=$cayma_fetch["user_ad"];
			}
			$toplam += $cayma_fetch["tutar"];
			$data[]=array(
				$cayma_fetch["user_id"]."-".$user_ad,
				$cayma_fetch["user_paket"],
				date("d-m-Y",strtotime($cayma_fetch["paranin_geldigi_tarih"])),
				date("d-m-Y",strtotime($cayma_fetch["mahsup_tarihi"])),
				"#".$cayma_fetch["arac_kod_plaka"]." / ".$cayma_fetch["arac_detay"],
				$cayma_fetch["aciklama"],
				$cayma_fetch["tutar"]
			);
			$sira++;
		} 
		$data[]=array(
			'',
			'',
			'',
			'',
			'',
			'TOPLAM',
			$toplam
		);
		$sira++;
		exportExcel2($isim,$columns,$data,$replaceDotCol);
	}
	if($action=="cayilanlar_excel"){
		$columns=array(
			'ÜYE ID VE ADI',
			'ÜYE GRUBU',
			'PARANIN GELDİĞİ TARİH',
			'BLOKE TARİHİ',
			'KONU ARAÇ',
			'AÇIKLAMALAR',
			'TUTAR'
		);
		$ay=re("ay");
		$yii=re("yil");
		$listeleme="bloke_tarihi";
		if($ay!=""){
			$where="MONTH(".$listeleme.") = '$ay' AND YEAR(".$listeleme.") = '$yil'";
			$isim="CAYİLAN_ARACLAR_".$ay."_".$yil;
		}else if($yil!=""){
			$where="YEAR(".$listeleme.") = '$yil'";
			$isim="CAYİLAN_ARACLAR_".$yil;
		}else{
			$year_start = strtotime('first day of January', time());
			$year_start_date=date('Y-m-d', $year_start);
			$year_end = strtotime('last day of December', time());
			$year_end_date=date('Y-m-d', $year_end);
			$where=$listeleme." BETWEEN '".$year_start_date."' AND '".$year_end_date."' ";
			$isim="CAYİLAN_ARACLAR_".date("d-m-Y H:i");
		}
		$cayma=mysql_query("
			SELECT
				cayma_bedelleri.*,
				user.id as user_id,
				user.ad as user_ad,
				user.unvan as user_unvan,
				user.user_token as user_token,
				user.kurumsal_user_token as kurumsal_user_token,
				uye_grubu.grup_adi as user_paket
			FROM
				cayma_bedelleri
			INNER JOIN
				user
			ON
				user.id=cayma_bedelleri.uye_id
			INNER JOIN
				uye_grubu
			ON
				user.paket=uye_grubu.id
			WHERE
				durum=5 AND
				".$where."
			ORDER BY
				".$listeleme." desc
		");
		
		$toplam = 0;
		$replaceDotCol=array();
		while($cayma_fetch=mysql_fetch_array($cayma)){
			if($cayma_fetch["kurumsal_user_token"]!=""){
				$user_ad=$cayma_fetch["user_unvan"];
			}else{
				$user_ad=$cayma_fetch["user_ad"];
			}
			$toplam += $cayma_fetch["tutar"];
			$data[]=array(
				$cayma_fetch["user_id"]."-".$user_ad,
				$cayma_fetch["user_paket"],
				date("d-m-Y",strtotime($cayma_fetch["paranin_geldigi_tarih"])),
				date("d-m-Y",strtotime($cayma_fetch["bloke_tarihi"])),
				"#".$cayma_fetch["arac_kod_plaka"]." / ".$cayma_fetch["arac_detay"],
				$cayma_fetch["aciklama"],
				$cayma_fetch["tutar"]
			);
			$sira++;
		} 
		$data[]=array(
			'',
			'',
			'',
			'',
			'',
			'TOPLAM',
			$toplam
		);
		$sira++;
		exportExcel2($isim,$columns,$data,$replaceDotCol);
	}
	if($action=="bloke_bekleyen_excel"){
		$columns=array(
			'ÜYE ID VE ADI',
			'ÜYE GRUBU',
			'BORÇ TARİHİ',
			'KONU ARAÇ',
			'AÇIKLAMALAR',
			'TUTAR'
		);
		$cayma=mysql_query("
			SELECT
				cayma_bedelleri.*,
				user.id as user_id,
				user.ad as user_ad,
				user.unvan as user_unvan,
				user.user_token as user_token,
				user.kurumsal_user_token as kurumsal_user_token,
				uye_grubu.grup_adi as user_paket
			FROM
				cayma_bedelleri
			INNER JOIN
				user
			ON
				user.id=cayma_bedelleri.uye_id
			INNER JOIN
				uye_grubu
			ON
				user.paket=uye_grubu.id
			WHERE
				durum=6
			ORDER BY
				bloke_tarihi desc
		");
		
		
		$isim="BLOKE_BEKLEYENLER_".date("d-m-Y H:i");;
		$toplam = 0;
		$replaceDotCol=array();
		while($cayma_fetch=mysql_fetch_array($cayma)){
			if($cayma_fetch["kurumsal_user_token"]!=""){
				$user_ad=$cayma_fetch["user_unvan"];
			}else{
				$user_ad=$cayma_fetch["user_ad"];
			}
			$toplam += $cayma_fetch["tutar"];
			$data[]=array(
				$cayma_fetch["user_id"]."-".$user_ad,
				$cayma_fetch["user_paket"],
				date("d-m-Y",strtotime($cayma_fetch["bloke_tarihi"])),
				"#".$cayma_fetch["arac_kod_plaka"]." / ".$cayma_fetch["arac_detay"] ,
				$cayma_fetch["aciklama"] ,
				$cayma_fetch["tutar"] ,
			);
			$sira++;
		} 
		$data[]=array(
			'',
			'',
			'',
			'',
			'TOPLAM',
			$toplam
		);
		$sira++;
		exportExcel2($isim,$columns,$data,$replaceDotCol);
		
	}
	if($action=="tahsil_edilenler_excel"){
		$columns=array(
			'ÜYE ID VE ADI',
			'ÜYE GRUBU',
			'BORÇ TARİHİ',
			'TAHSİL TARİHİ',
			'KONU ARAÇ',
			'AÇIKLAMALAR',
			'TUTAR'
		);
		$sira = 1;
		$cayma=mysql_query("SELECT cayma_bedelleri.*, user.id as user_id,user.ad as user_ad,user.unvan as user_unvan,user.user_token as user_token,user.kurumsal_user_token as kurumsal_user_token,
		uye_grubu.grup_adi as user_paket FROM cayma_bedelleri INNER JOIN user ON user.id=cayma_bedelleri.uye_id INNER JOIN uye_grubu ON user.paket=uye_grubu.id WHERE durum=7 ORDER BY tahsil_tarihi desc");
		
		
		$isim="TAHSIL_EDILENLER".date("d-m-Y H:i");;
		$toplam = 0;
		$replaceDotCol=array();
		while($cayma_fetch=mysql_fetch_array($cayma)){
			if($cayma_fetch["kurumsal_user_token"]!=""){
				$user_ad=$cayma_fetch["user_unvan"];
			}else{
				$user_ad=$cayma_fetch["user_ad"];
			}
			$toplam += $cayma_fetch["tutar"];
			$data[]=array(
				$cayma_fetch["user_id"]."-".$user_ad,
				$cayma_fetch["user_paket"],
				date("d-m-Y",strtotime($cayma_fetch["borc_tarihi"])),
				date("d-m-Y",strtotime($cayma_fetch["tahsil_tarihi"])),
				"#".$cayma_fetch["arac_kod_plaka"]." / ".$cayma_fetch["arac_detay"] ,
				$cayma_fetch["aciklama"] ,
				$cayma_fetch["tutar"] 
			);
			$sira++;
		} 
		$data[]=array(
			'',
			'',
			'',
			'',
			'',
			'TOPLAM',
			$toplam
		);
		$sira++;
		exportExcel2($isim,$columns,$data,$replaceDotCol);
		
	}
	
	
 ?>