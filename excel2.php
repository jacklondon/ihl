<?php

	include 'ayar.php';
	
	session_start();
	$admin_id=$_SESSION['kid'];
	$admin_yetki_cek=mysql_query("Select * from kullanicilar where id='".$admin_id."' ");
	$admin_yetki_oku=mysql_fetch_assoc($admin_yetki_cek);
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
		'KOD',
		'ÖDEME TARİHİ',
		'PARAYI GÖNDEREN',
		'ARAÇ PLAKASI',
		'MARKA MODEL',
		'SİGORTA',
		'ARACI ALAN ÜYE',
		'SATIŞ KİMİN ADINA YAPILDI',
		'SATIŞ TARİHİ',
		'Maliyeti',
		'SATILAN FİYAT',
		'PD HİZMET BEDELİ',
		'EKSTRA KAZANÇ',
		'AÇIKLAYICI NOTLAR',
		'TOPLAM KAR / ZARAR'
	);
	function exportExcel($filename,$columns=array(),$data=array(),$replaceDotCol=array(),$sayi,$toplam,$tur=""){
		header('Content-Encoding: UTF-8');
		header('Content-Type: text/plain; charset=utf-8'); 
		header("Content-disposition: attachment; filename=".$filename.".xls");
		echo "\xEF\xBB\xBF"; // UTF-8 BOM
      
		$say=count($columns);
		  
		echo '<table id="excel" border="1"><tr>';
		foreach($columns as $v){
			echo '<th style=" background-color: rgb(255,255,0);">'.trim($v).'</th>';
		}
		echo '</tr>';
		
		if($tur==""){
			echo '<tr> <td colspan="16">Toplam '.$sayi.' adet sonuç içinde Toplam Ciro '.$toplam.' ₺  </td></tr>';
		}else{
			echo '<tr> <td colspan="5">Toplam '.$sayi.' adet sonuç içinde Toplam Cayma Bedeli '.$toplam.' ₺  </td></tr>';
		}
	
		foreach($data as $val){
			
			echo '<tr>';
			for($i=0; $i < $say; $i++){
	  
				if(in_array($i,$replaceDotCol)){
					if($val[16]=="1"){
						echo '<td style=" background-color: red;color: #ffffff;" >'.str_replace('.',',',$val[$i]).'</td>';
					}else{
						if($i==0){
							echo '<td style=" background-color: rgb(51,51,153);color: #ffffff;" >'.str_replace('.',',',$val[$i]).'</td>';
						}else{
							echo '<td>'.str_replace('.',',',$val[$i]).'</td>';
						}
					}
					
					
				}else{
					if($val[16]=="1"){
						echo '<td style=" background-color: red;color: #ffffff;" >'.str_replace('.',',',$val[$i]).'</td>';
					}else{
						if($i==0){
							echo '<td style=" background-color: rgb(51,51,153);color: #ffffff;" >'.str_replace('.',',',$val[$i]).'</td>';
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
		$filtre_cek = mysql_query("SELECT * FROM satilan_araclar WHERE tarih BETWEEN '".$BAS."' AND '".$SON."' ".$order_by." ");
		$filtre_sayi = mysql_num_rows($filtre_cek); 
		$tarihFiltre = mysql_query("SELECT SUM(ciro) AS ciro FROM satilan_araclar WHERE tarih BETWEEN '".$BAS."' AND '".$SON."' and durum=0"); 
		$filtreToplam = mysql_fetch_assoc($tarihFiltre); 
		if($yetki=="true"){
			$ToplamFiltre = (int) $filtreToplam['ciro'];
		}else{
			$ToplamFiltre = "?";
		}
		
		$isim="SATILAN_ARACLAR"."-".$BAS."-".$SON;
		$replaceDotCol=array(10,11,12,13,15); //ilk kolon sıfır olmak üzere belirtilen kolonlarda "," ile "." değiştirilir.
		while($filtre_oku = mysql_fetch_array($filtre_cek)){
			//SATIRLAR
			
			if($yetki=="true"){
				$maliyet = $filtre_oku["maliyet"];
				$satilan_fiyat = $filtre_oku["satilan_fiyat"];
				$pd_hizmet = $filtre_oku["pd_hizmet"];
				$ekstra_kazanc = $filtre_oku["ektra_kazanc"];
				$ciro = $filtre_oku["ciro"];
			}else{
				$maliyet = "?";
				$satilan_fiyat = "?";
				$pd_hizmet = "?";
				$ekstra_kazanc = "?";
				$ciro = "?";
			}
			
			$data[]=array(
				$sira,
				$filtre_oku["kod"],
				$filtre_oku["tarih"],
				$filtre_oku["parayi_gonderen"],
				$filtre_oku["plaka"],
				$filtre_oku["marka_model"],
				$filtre_oku["sigorta"],
				$filtre_oku["araci_alan"],
				$filtre_oku["satis_adi"],
				$filtre_oku["tarih"],
				$maliyet,
				$satilan_fiyat,
				$pd_hizmet,
				$ekstra_kazanc,
				$filtre_oku["notlar"],
				$ciro,
				$filtre_oku["durum"],
			);
			$sira++;

		}	
		//$data[]=array("Toplam $filtre_sayi adet sonuç içinde Toplam Ciro $ToplamFiltre ₺");
		exportExcel($isim,$columns,$data,$replaceDotCol,$filtre_sayi,$ToplamFiltre );
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
		$filtre = mysql_query("SELECT * FROM satilan_araclar WHERE  MONTH(tarih)= '$BAS' AND YEAR(tarih)= '$SON' ".$order_by." ");
		$filterCount = mysql_num_rows($filtre);
		$ayYil = mysql_query("SELECT SUM(ciro) AS ciro FROM satilan_araclar WHERE  MONTH(tarih) = '$BAS' AND YEAR(tarih)= '$SON' and durum=0"); 
		$AyYilToplam = mysql_fetch_assoc($ayYil); 
		

		if($yetki=="true"){
			$AyYilCiro = (int) $AyYilToplam['ciro'];
		}else{
			$AyYilCiro = "?";
		}
		
		$isim="SATILAN_ARACLAR"."-".$BAS."-".$SON;

		$replaceDotCol=array(10,11,12,13,15); //ilk kolon sıfır olmak üzere belirtilen kolonlarda "," ile "." değiştirilir.
		while($filtre_yaz = mysql_fetch_array($filtre)){
			//SATIRLAR
			if($yetki=="true"){
				$maliyet = $filtre_yaz["maliyet"];
				$satilan_fiyat = $filtre_yaz["satilan_fiyat"];
				$pd_hizmet = $filtre_yaz["pd_hizmet"];
				$ekstra_kazanc = $filtre_yaz["ektra_kazanc"];
				$ciro = $filtre_yaz["ciro"];
			}else{
				$maliyet = "?";
				$satilan_fiyat = "?";
				$pd_hizmet = "?";
				$ekstra_kazanc = "?";
				$ciro = "?";
			}
			
			$data[]=array(
				$sira,
				$filtre_yaz["kod"],
				$filtre_yaz["tarih"],
				$filtre_yaz["parayi_gonderen"],
				$filtre_yaz["plaka"],
				$filtre_yaz["marka_model"],
				$filtre_yaz["sigorta"],
				$filtre_yaz["araci_alan"],
				$filtre_yaz["satis_adi"],
				$filtre_yaz["tarih"],
				$maliyet,
				$satilan_fiyat,
				$pd_hizmet,
				$ekstra_kazanc,
				$filtre_yaz["notlar"],
				$ciro,
				$filtre_yaz["durum"],
			);
			$sira++;
		}	
		//$data[]=array("Toplam $filterCount adet sonuç içinde Toplam Ciro $AyYilCiro ₺");
		exportExcel($isim,$columns,$data,$replaceDotCol,$filterCount,$AyYilCiro);

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

		if($yetki=="true"){
			$sum = (int) $row['ciro'];
		}else{
			$sum = "?";
		}

		$satilan_cek = mysql_query("SELECT * FROM satilan_araclar ".$order_by." ");
		$satilan_sayi = mysql_num_rows($satilan_cek);
		$tarih=date("Y-m-d H:i:s");
		$isim="SATILAN_ARACLAR_".$tarih;
		$replaceDotCol=array(10,11,12,13,15); //ilk kolon sıfır olmak üzere belirtilen kolonlarda "," ile "." değiştirilir.
		while($satilan_oku = mysql_fetch_array($satilan_cek)){ 
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
			
			$data[]=array(
				$sira,
				$satilan_oku["kod"],
				$satilan_oku["tarih"],
				$satilan_oku["parayi_gonderen"],
				$satilan_oku["plaka"],
				$satilan_oku["marka_model"],
				$satilan_oku["sigorta"],
				$satilan_oku["araci_alan"],
				$satilan_oku["satis_adi"],
				$satilan_oku["tarih"],
				$maliyet,
				$satilan_fiyat,
				$pd_hizmet,
				$ekstra_kazanc,
				$satilan_oku["notlar"],
				$ciro,
				$satilan_oku["durum"],
			);
			$sira++;
		}
		//$data[]=array("Toplam $satilan_sayi adet sonuç içinde Toplam Ciro $sum ₺");
		exportExcel($isim,$columns,$data,$replaceDotCol,$satilan_sayi,$sum);
	}
	
	// Bana Özel-Primlerim Aldıkları
	if($action=="primlerim_tarihleri"){
		
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
		$filtre_cek = mysql_query("SELECT 
									satilan_araclar.*
								FROM
									satilan_araclar 
								INNER JOIN 
									user ON user.id=satilan_araclar.uye_id
								INNER JOIN
									prm_notlari ON satilan_araclar.uye_id=prm_notlari.uye_id 
								WHERE 
									prm_notlari.durum=1 AND
									user.temsilci_id='".$admin_id."' AND
									satilan_araclar.tarih BETWEEN '".re('tarih1')."' AND '".re('tarih2')."'
								 $order_by 
							");
		$filtre_sayi = mysql_num_rows($filtre_cek); 
		//$tarihFiltre = mysql_query("SELECT SUM(ciro) AS ciro FROM satilan_araclar WHERE tarih BETWEEN '".$BAS."' AND '".$SON."' and durum=0"); 
		$tarihFiltre = mysql_query("SELECT 
										SUM(satilan_araclar.ciro)
									FROM
										satilan_araclar 
									INNER JOIN 
										user ON user.id=satilan_araclar.uye_id
									INNER JOIN
										prm_notlari ON satilan_araclar.uye_id=prm_notlari.uye_id 
									WHERE 
										prm_notlari.durum=1 AND
										user.temsilci_id='".$admin_id."' AND
										satilan_araclar.tarih BETWEEN '".re('tarih1')."' AND '".re('tarih2')."' AND
										satilan_araclar.durum=0
									 $order_by 
									");									
		$filtreToplam = mysql_fetch_assoc($tarihFiltre); 
		if($yetki=="true"){
			$ToplamFiltre = (int) $filtreToplam['ciro'];
		}else{
			$ToplamFiltre = "?";
		}
		
		$isim="SATILAN_ARACLAR"."-".$BAS."-".$SON;
		$replaceDotCol=array(10,11,12,13,15); //ilk kolon sıfır olmak üzere belirtilen kolonlarda "," ile "." değiştirilir.
		while($filtre_oku = mysql_fetch_array($filtre_cek)){
			//SATIRLAR
			
			if($yetki=="true"){
				$maliyet = $filtre_oku["maliyet"];
				$satilan_fiyat = $filtre_oku["satilan_fiyat"];
				$pd_hizmet = $filtre_oku["pd_hizmet"];
				$ekstra_kazanc = $filtre_oku["ektra_kazanc"];
				$ciro = $filtre_oku["ciro"];
			}else{
				$maliyet = "?";
				$satilan_fiyat = "?";
				$pd_hizmet = "?";
				$ekstra_kazanc = "?";
				$ciro = "?";
			}
			
			$data[]=array(
				$sira,
				$filtre_oku["kod"],
				$filtre_oku["tarih"],
				$filtre_oku["parayi_gonderen"],
				$filtre_oku["plaka"],
				$filtre_oku["marka_model"],
				$filtre_oku["sigorta"],
				$filtre_oku["araci_alan"],
				$filtre_oku["satis_adi"],
				$filtre_oku["tarih"],
				$maliyet,
				$satilan_fiyat,
				$pd_hizmet,
				$ekstra_kazanc,
				$filtre_oku["notlar"],
				$ciro,
				$filtre_oku["durum"],
			);
			$sira++;

		}	
		//$data[]=array("Toplam $filtre_sayi adet sonuç içinde Toplam Ciro $ToplamFiltre ₺");
		exportExcel($isim,$columns,$data,$replaceDotCol,$filtre_sayi,$ToplamFiltre );
	}
	if($action=="primlerim_secili_tarihi"){
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
		//$filtre = mysql_query("SELECT * FROM satilan_araclar WHERE  MONTH(tarih)= '$BAS' AND YEAR(tarih)= '$SON' ".$order_by." ");
		$filtre = mysql_query("
								SELECT 
									satilan_araclar.*
								FROM
									satilan_araclar 
								INNER JOIN 
									user ON user.id=satilan_araclar.uye_id
								INNER JOIN
									prm_notlari ON satilan_araclar.uye_id=prm_notlari.uye_id 
								WHERE 
									prm_notlari.durum=1 AND
									user.temsilci_id='".$admin_id."' AND
									MONTH(satilan_araclar.tarih) = '".$BAS."' AND YEAR(satilan_araclar.tarih)= '".$SON."'
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
								INNER JOIN
									prm_notlari ON satilan_araclar.uye_id=prm_notlari.uye_id 
								WHERE 
									prm_notlari.durum=1 AND
									user.temsilci_id='".$admin_id."' AND
									MONTH(satilan_araclar.tarih) = '".$BAS."' AND YEAR(satilan_araclar.tarih)= '".$SON."' AND
									satilan_araclar.durum=0
								$order_by 
							"); 

		$AyYilToplam = mysql_fetch_assoc($ayYil); 
		
		if($yetki=="true"){
			$AyYilCiro = (int) $AyYilToplam['ciro'];
		}else{
			$AyYilCiro = "?";
		}
		
		$isim="SATILAN_ARACLAR"."-".$BAS."-".$SON;

		$replaceDotCol=array(10,11,12,13,15); //ilk kolon sıfır olmak üzere belirtilen kolonlarda "," ile "." değiştirilir.
		while($filtre_yaz = mysql_fetch_array($filtre)){
			//SATIRLAR
			if($yetki=="true"){
				$maliyet = $filtre_yaz["maliyet"];
				$satilan_fiyat = $filtre_yaz["satilan_fiyat"];
				$pd_hizmet = $filtre_yaz["pd_hizmet"];
				$ekstra_kazanc = $filtre_yaz["ektra_kazanc"];
				$ciro = $filtre_yaz["ciro"];
			}else{
				$maliyet = "?";
				$satilan_fiyat = "?";
				$pd_hizmet = "?";
				$ekstra_kazanc = "?";
				$ciro = "?";
			}
			
			$data[]=array(
				$sira,
				$filtre_yaz["kod"],
				$filtre_yaz["tarih"],
				$filtre_yaz["parayi_gonderen"],
				$filtre_yaz["plaka"],
				$filtre_yaz["marka_model"],
				$filtre_yaz["sigorta"],
				$filtre_yaz["araci_alan"],
				$filtre_yaz["satis_adi"],
				$filtre_yaz["tarih"],
				$maliyet,
				$satilan_fiyat,
				$pd_hizmet,
				$ekstra_kazanc,
				$filtre_yaz["notlar"],
				$ciro,
				$filtre_yaz["durum"],
			);
			$sira++;
		}	
		//$data[]=array("Toplam $filterCount adet sonuç içinde Toplam Ciro $AyYilCiro ₺");
		exportExcel($isim,$columns,$data,$replaceDotCol,$filterCount,$AyYilCiro);

	}
	
	if($action=="primlerim_arama"){
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
								INNER JOIN
									prm_notlari ON satilan_araclar.uye_id=prm_notlari.uye_id 
								WHERE 
									prm_notlari.durum=1 AND
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
								INNER JOIN
									prm_notlari ON satilan_araclar.uye_id=prm_notlari.uye_id 
								WHERE 
									prm_notlari.durum=1 AND
									user.temsilci_id='".$admin_id."' AND
									concat(plaka,' ',kod,' ',marka_model,' ',sigorta,' ',satis_adi,' ',maliyet,' ',pd_hizmet,' ',ektra_kazanc,' ',notlar,' ',parayi_gonderen,' ',araci_alan,' ',satilan_fiyat,' ',aciklayici_not,' ',ciro)  like '%".re('aranan')."%'  AND
									satilan_araclar.durum=0
								$order_by 
							"); 
		
				
		if($yetki=="true"){
			$AyYilCiro = (int) $AyYilToplam['ciro'];
		}else{
			$AyYilCiro = "?";
		}
		
		$isim="SATILAN_ARACLAR";

		$replaceDotCol=array(10,11,12,13,15); //ilk kolon sıfır olmak üzere belirtilen kolonlarda "," ile "." değiştirilir.
		while($filtre_yaz = mysql_fetch_array($filtre)){
			//SATIRLAR
			if($yetki=="true"){
				$maliyet = $filtre_yaz["maliyet"];
				$satilan_fiyat = $filtre_yaz["satilan_fiyat"];
				$pd_hizmet = $filtre_yaz["pd_hizmet"];
				$ekstra_kazanc = $filtre_yaz["ektra_kazanc"];
				$ciro = $filtre_yaz["ciro"];
			}else{
				$maliyet = "?";
				$satilan_fiyat = "?";
				$pd_hizmet = "?";
				$ekstra_kazanc = "?";
				$ciro = "?";
			}
			
			$data[]=array(
				$sira,
				$filtre_yaz["kod"],
				$filtre_yaz["tarih"],
				$filtre_yaz["parayi_gonderen"],
				$filtre_yaz["plaka"],
				$filtre_yaz["marka_model"],
				$filtre_yaz["sigorta"],
				$filtre_yaz["araci_alan"],
				$filtre_yaz["satis_adi"],
				$filtre_yaz["tarih"],
				$maliyet,
				$satilan_fiyat,
				$pd_hizmet,
				$ekstra_kazanc,
				$filtre_yaz["notlar"],
				$ciro,
				$filtre_yaz["durum"],
			);
			$sira++;
		}	
		//$data[]=array("Toplam $filterCount adet sonuç içinde Toplam Ciro $AyYilCiro ₺");
		exportExcel($isim,$columns,$data,$replaceDotCol,$filterCount,$AyYilCiro);

	} 
	
	if($action=="primlerim_tarihsiz"){
			
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
		$result = mysql_query("
						SELECT 
							SUM(satilan_araclar.ciro) as ciro
						FROM
							satilan_araclar 
						INNER JOIN 
							user ON user.id=satilan_araclar.uye_id
						INNER JOIN
							prm_notlari ON satilan_araclar.uye_id=prm_notlari.uye_id 
						WHERE 
							prm_notlari.durum=1 AND
							user.temsilci_id='".$admin_id."' AND
							satilan_araclar.durum=0
						"); 
		$row = mysql_fetch_assoc($result); 

		if($yetki=="true"){
			$sum = (int) $row['ciro'];
		}else{
			$sum = "?";
		}

		//$satilan_cek = mysql_query("SELECT * FROM satilan_araclar ".$order_by." ");
		$satilan_cek = mysql_query("
							SELECT 
								satilan_araclar.*
							FROM
								satilan_araclar 
							INNER JOIN 
								user ON user.id=satilan_araclar.uye_id
							INNER JOIN
								prm_notlari ON satilan_araclar.uye_id=prm_notlari.uye_id 
							WHERE 
								prm_notlari.durum=1 AND
								user.temsilci_id='".$admin_id."'
							$order_by 
							");
		$satilan_sayi = mysql_num_rows($satilan_cek);
		$tarih=date("Y-m-d H:i:s");
		$isim="SATILAN_ARACLAR_".$tarih;
		$replaceDotCol=array(10,11,12,13,15); //ilk kolon sıfır olmak üzere belirtilen kolonlarda "," ile "." değiştirilir.
		while($satilan_oku = mysql_fetch_array($satilan_cek)){ 
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
			
			$data[]=array(
				$sira,
				$satilan_oku["kod"],
				$satilan_oku["tarih"],
				$satilan_oku["parayi_gonderen"],
				$satilan_oku["plaka"],
				$satilan_oku["marka_model"],
				$satilan_oku["sigorta"],
				$satilan_oku["araci_alan"],
				$satilan_oku["satis_adi"],
				$satilan_oku["tarih"],
				$maliyet,
				$satilan_fiyat,
				$pd_hizmet,
				$ekstra_kazanc,
				$satilan_oku["notlar"],
				$ciro,
				$satilan_oku["durum"],
			);
			$sira++;
		}
		//$data[]=array("Toplam $satilan_sayi adet sonuç içinde Toplam Ciro $sum ₺");
		exportExcel($isim,$columns,$data,$replaceDotCol,$satilan_sayi,$sum);
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
		$filtre_cek = mysql_query("SELECT 
										satilan_araclar.*
									FROM
										satilan_araclar 
									INNER JOIN 
										user ON user.id=satilan_araclar.uye_id
									WHERE 
										user.temsilci_id='".$admin_id."' AND
										satilan_araclar.tarih BETWEEN '".re('tarih1')."' AND '".re('tarih2')."'
									 $order_by 
								");
								
		$filtre_sayi = mysql_num_rows($filtre_cek); 
		//$tarihFiltre = mysql_query("SELECT SUM(ciro) AS ciro FROM satilan_araclar WHERE tarih BETWEEN '".$BAS."' AND '".$SON."' and durum=0"); 
		$tarihFiltre = mysql_query("SELECT 
										SUM(satilan_araclar.ciro) as ciro
									FROM
										satilan_araclar 
									INNER JOIN 
										user ON user.id=satilan_araclar.uye_id
									WHERE 
										user.temsilci_id='".$admin_id."' AND
										satilan_araclar.tarih BETWEEN '".re('tarih1')."' AND '".re('tarih2')."' AND
										satilan_araclar.durum=0
									 $order_by 
									"); 
		$filtreToplam = mysql_fetch_assoc($tarihFiltre); 
		if($yetki=="true"){
			$ToplamFiltre = (int) $filtreToplam['ciro'];
		}else{
			$ToplamFiltre = "?";
		}
		
		$isim="SATILAN_ARACLAR"."-".$BAS."-".$SON;
		$replaceDotCol=array(10,11,12,13,15); //ilk kolon sıfır olmak üzere belirtilen kolonlarda "," ile "." değiştirilir.
		while($filtre_oku = mysql_fetch_array($filtre_cek)){
			//SATIRLAR
			
			if($yetki=="true"){
				$maliyet = $filtre_oku["maliyet"];
				$satilan_fiyat = $filtre_oku["satilan_fiyat"];
				$pd_hizmet = $filtre_oku["pd_hizmet"];
				$ekstra_kazanc = $filtre_oku["ektra_kazanc"];
				$ciro = $filtre_oku["ciro"];
			}else{
				$maliyet = "?";
				$satilan_fiyat = "?";
				$pd_hizmet = "?";
				$ekstra_kazanc = "?";
				$ciro = "?";
			}
			
			$data[]=array(
				$sira,
				$filtre_oku["kod"],
				$filtre_oku["tarih"],
				$filtre_oku["parayi_gonderen"],
				$filtre_oku["plaka"],
				$filtre_oku["marka_model"],
				$filtre_oku["sigorta"],
				$filtre_oku["araci_alan"],
				$filtre_oku["satis_adi"],
				$filtre_oku["tarih"],
				$maliyet,
				$satilan_fiyat,
				$pd_hizmet,
				$ekstra_kazanc,
				$filtre_oku["notlar"],
				$ciro,
				$filtre_oku["durum"],
			);
			$sira++;

		}	
		//$data[]=array("Toplam $filtre_sayi adet sonuç içinde Toplam Ciro $ToplamFiltre ₺");
		exportExcel($isim,$columns,$data,$replaceDotCol,$filtre_sayi,$ToplamFiltre );
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
									MONTH(satilan_araclar.tarih) = '".$BAS."' AND YEAR(satilan_araclar.tarih)= '".$SON."'
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
										MONTH(satilan_araclar.tarih) = '".$BAS."' AND YEAR(satilan_araclar.tarih)= '".$SON."'
										satilan_araclar.durum=0
									$order_by 
								"); 
		$AyYilToplam = mysql_fetch_assoc($ayYil); 
		
				
		if($yetki=="true"){
			$AyYilCiro = (int) $AyYilToplam['ciro'];
		}else{
			$AyYilCiro = "?";
		}
		
		$isim="SATILAN_ARACLAR"."-".$BAS."-".$SON;

		$replaceDotCol=array(10,11,12,13,15); //ilk kolon sıfır olmak üzere belirtilen kolonlarda "," ile "." değiştirilir.
		while($filtre_yaz = mysql_fetch_array($filtre)){
			//SATIRLAR
			if($yetki=="true"){
				$maliyet = $filtre_yaz["maliyet"];
				$satilan_fiyat = $filtre_yaz["satilan_fiyat"];
				$pd_hizmet = $filtre_yaz["pd_hizmet"];
				$ekstra_kazanc = $filtre_yaz["ektra_kazanc"];
				$ciro = $filtre_yaz["ciro"];
			}else{
				$maliyet = "?";
				$satilan_fiyat = "?";
				$pd_hizmet = "?";
				$ekstra_kazanc = "?";
				$ciro = "?";
			}
			
			$data[]=array(
				$sira,
				$filtre_yaz["kod"],
				$filtre_yaz["tarih"],
				$filtre_yaz["parayi_gonderen"],
				$filtre_yaz["plaka"],
				$filtre_yaz["marka_model"],
				$filtre_yaz["sigorta"],
				$filtre_yaz["araci_alan"],
				$filtre_yaz["satis_adi"],
				$filtre_yaz["tarih"],
				$maliyet,
				$satilan_fiyat,
				$pd_hizmet,
				$ekstra_kazanc,
				$filtre_yaz["notlar"],
				$ciro,
				$filtre_yaz["durum"],
			);
			$sira++;
		}	
		//$data[]=array("Toplam $filterCount adet sonuç içinde Toplam Ciro $AyYilCiro ₺");
		exportExcel($isim,$columns,$data,$replaceDotCol,$filterCount,$AyYilCiro);

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
		
				
		if($yetki=="true"){
			$AyYilCiro = (int) $AyYilToplam['ciro'];
		}else{
			$AyYilCiro = "?";
		}
		
		$isim="SATILAN_ARACLAR";

		$replaceDotCol=array(10,11,12,13,15); //ilk kolon sıfır olmak üzere belirtilen kolonlarda "," ile "." değiştirilir.
		while($filtre_yaz = mysql_fetch_array($filtre)){
			//SATIRLAR
			if($yetki=="true"){
				$maliyet = $filtre_yaz["maliyet"];
				$satilan_fiyat = $filtre_yaz["satilan_fiyat"];
				$pd_hizmet = $filtre_yaz["pd_hizmet"];
				$ekstra_kazanc = $filtre_yaz["ektra_kazanc"];
				$ciro = $filtre_yaz["ciro"];
			}else{
				$maliyet = "?";
				$satilan_fiyat = "?";
				$pd_hizmet = "?";
				$ekstra_kazanc = "?";
				$ciro = "?";
			}
			
			$data[]=array(
				$sira,
				$filtre_yaz["kod"],
				$filtre_yaz["tarih"],
				$filtre_yaz["parayi_gonderen"],
				$filtre_yaz["plaka"],
				$filtre_yaz["marka_model"],
				$filtre_yaz["sigorta"],
				$filtre_yaz["araci_alan"],
				$filtre_yaz["satis_adi"],
				$filtre_yaz["tarih"],
				$maliyet,
				$satilan_fiyat,
				$pd_hizmet,
				$ekstra_kazanc,
				$filtre_yaz["notlar"],
				$ciro,
				$filtre_yaz["durum"],
			);
			$sira++;
		}	
		//$data[]=array("Toplam $filterCount adet sonuç içinde Toplam Ciro $AyYilCiro ₺");
		exportExcel($isim,$columns,$data,$replaceDotCol,$filterCount,$AyYilCiro);

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
		$result = mysql_query("
						SELECT 
							SUM(satilan_araclar.ciro) as ciro
						FROM
							satilan_araclar 
						INNER JOIN 
							user ON user.id=satilan_araclar.uye_id
						WHERE 
							user.temsilci_id='".$admin_id."' AND
							satilan_araclar.durum=0
						"); 
		$row = mysql_fetch_assoc($result); 
		$sum = $row['ciro'];
		
		if($yetki=="true"){
			$sum = (int) $row['ciro'];
		}else{
			$sum = "?";
		}

		//$satilan_cek = mysql_query("SELECT * FROM satilan_araclar ".$order_by." ");
		$satilan_cek = mysql_query("
						SELECT 
							satilan_araclar.*
						FROM
							satilan_araclar 
						INNER JOIN 
							user ON user.id=satilan_araclar.uye_id
						WHERE 
							user.temsilci_id='".$admin_id."'
						$order_by 
						");
		$satilan_sayi = mysql_num_rows($satilan_cek);
		$tarih=date("Y-m-d H:i:s");
		$isim="SATILAN_ARACLAR_".$tarih;
		$replaceDotCol=array(10,11,12,13,15); //ilk kolon sıfır olmak üzere belirtilen kolonlarda "," ile "." değiştirilir.
		while($satilan_oku = mysql_fetch_array($satilan_cek)){ 
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
			
			$data[]=array(
				$sira,
				$satilan_oku["kod"],
				$satilan_oku["tarih"],
				$satilan_oku["parayi_gonderen"],
				$satilan_oku["plaka"],
				$satilan_oku["marka_model"],
				$satilan_oku["sigorta"],
				$satilan_oku["araci_alan"],
				$satilan_oku["satis_adi"],
				$satilan_oku["tarih"],
				$maliyet,
				$satilan_fiyat,
				$pd_hizmet,
				$ekstra_kazanc,
				$satilan_oku["notlar"],
				$ciro,
				$satilan_oku["durum"],
			);
			$sira++;
		}
		//$data[]=array("Toplam $satilan_sayi adet sonuç içinde Toplam Ciro $sum ₺");
		exportExcel($isim,$columns,$data,$replaceDotCol,$satilan_sayi,$sum);
	}
	if($action=="muhasebe_uye_bakiyeleri"){
		$sira=1;
		$columns=array(
			'SIRA',
			'ÜYELİK TİPİ',
			'ÜYE ADI SOYADI/FİRMA ADI',
			'ÜYE GRUBU',
			'TUTAR'
		);
		$bakiye_cek = mysql_query("SELECT cayma_bedelleri.* FROM cayma_bedelleri inner join user on cayma_bedelleri.uye_id=user.id group by cayma_bedelleri.uye_id");
		/*$toplam_aktif = mysql_query('SELECT sum(cayma_bedelleri.net) as nettr FROM cayma_bedelleri inner join user on user.id=cayma_bedelleri.uye_id where durum=1'); 
		$toplam_getir = mysql_fetch_assoc($toplam_aktif); 
		$toplam_cayma = $toplam_getir['nettr'];

		$toplam_borc = mysql_query('SELECT sum(cayma_bedelleri.net) as nettr FROM cayma_bedelleri inner join user on user.id=cayma_bedelleri.uye_id where durum=2'); 
		$toplam_borc_getir = mysql_fetch_assoc($toplam_borc); 
		$toplam_borc_cayma = $toplam_getir['nettr'];
		$toplam_cayma=$toplam_cayma+toplam_borc_cayma;*/
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
		$toplam_cayma=$toplam_aktif_cayma["toplam_aktif_cayma"]-$toplam_iade_talepleri["toplam_iade_talepleri"]-$toplam_borclar["toplam_borclar"];
		


		$bakiye_sayi = mysql_num_rows($bakiye_cek);
		$tarih=date("Y-m-d H:i:s");
		$isim="ÜYE_BAKİYELERİ_".$tarih;
		$replaceDotCol=array(); //ilk kolon sıfır olmak üzere belirtilen kolonlarda "," ile "." değiştirilir.
		while($bakiye_oku = mysql_fetch_array($bakiye_cek)){ 
			$cayma="";
			$uye_id = $bakiye_oku['uye_id'];
			
			/*$toplam_aktif = mysql_query('SELECT SUM(net) AS net FROM cayma_bedelleri WHERE uye_id = "'.$uye_id.'" and durum=1'); 
			$toplam_getir = mysql_fetch_assoc($toplam_aktif); 
			$toplam_cayma = $toplam_getir['net'];

			$toplam_borc = mysql_query('SELECT SUM(net) AS net FROM cayma_bedelleri WHERE uye_id = "'.$uye_id.'" and durum=2'); 
			$toplam_borc_getir = mysql_fetch_assoc($toplam_borc); 
			$toplam_borc_cayma = $toplam_getir['net'];
			$cayma=$toplam_cayma+toplam_borc_cayma;*/
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
			$cayma=$toplam_aktif_cayma["toplam_aktif_cayma"]-$toplam_iade_talepleri["toplam_iade_talepleri"]-$toplam_borclar["toplam_borclar"];
			
			
			$uye_cek = mysql_query("select * from user where id = '".$uye_id."' limit 1");
			$uye_oku = mysql_fetch_array($uye_cek);
			
			if($uye_oku["user_token"]!=""){
				$uye_adi=$uye_oku['ad'];
				$uyelik_tipi="Bireysel";
			}else{
				$uye_adi=$uye_oku['unvan']." / ".$uye_oku['ad'];
				$uyelik_tipi="Kurumsal";
			}
			
			$paket_bul = mysql_query("SELECT * FROM uye_grubu WHERE id = '".$uye_oku['paket']."'");
			$paket_oku = mysql_fetch_assoc($paket_bul);
			if($cayma>0){
				$data[]=array(
					$sira,
					$uyelik_tipi,
					$uye_adi,
					$paket_oku['grup_adi'],
					$cayma
				);
				$sira++;
			}
		} 
		exportExcel($isim,$columns,$data,$replaceDotCol,$bakiye_sayi,$toplam_cayma,"muhasebe");
	}	
	
 ?>