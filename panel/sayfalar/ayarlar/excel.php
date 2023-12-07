<?php
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
	function exportExcel($filename,$columns=array(),$data=array(),$replaceDotCol=array()){
		header('Content-Encoding: UTF-8');
		header('Content-Type: text/plain; charset=utf-8'); 
		header("Content-disposition: attachment; filename=".$filename.".xls");
		echo "\xEF\xBB\xBF"; // UTF-8 BOM
      
		$say=count($columns);
		  
		echo '<table id="excel" border="1"><tr>';
		foreach($columns as $v){
			echo '<th style="background-color:#FFA500">'.trim($v).'</th>';
		}
		echo '</tr>';
	  
		foreach($data as $val){
			echo '<tr>';
			for($i=0; $i < $say; $i++){
	  
				if(in_array($i,$replaceDotCol)){
					echo '<td>'.str_replace('.',',',$val[$i]).'</td>';
				}else{
					echo '<td>'.$val[$i].'</td>';
				}
			}
			echo '</tr>';
		}
	}
	if($action=="tarihleri"){
		$BAS=re("tarih1");
		$SON=re("tarih2");
		$filtre_cek = mysql_query("SELECT * FROM satilan_araclar WHERE tarih BETWEEN '".$BAS."' AND '".$SON."' ");
		$filtre_sayi = mysql_num_rows($filtre_cek); 
		$tarihFiltre = mysql_query("SELECT SUM(ciro) AS ciro FROM satilan_araclar WHERE tarih BETWEEN '".$BAS."' AND '".$SON."' "); 
		$filtreToplam = mysql_fetch_assoc($tarihFiltre); 
		$ToplamFiltre = $filtreToplam['ciro'];
		$isim="SATILAN_ARACLAR"."-".$BAS."-".$SON;
		$replaceDotCol=array(10,11,12,13,15); //ilk kolon sıfır olmak üzere belirtilen kolonlarda "," ile "." değiştirilir.
		while($filtre_oku = mysql_fetch_array($filtre_cek)){
			//SATIRLAR
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
				$filtre_oku["maliyet"],
				$filtre_oku["satilan_fiyat"],
				$filtre_oku["pd_hizmet"],
				$filtre_oku["ektra_kazanc"],
				$filtre_oku["notlar"],
				$filtre_oku['ciro']
			);
			$sira++;
		}	
		$data[]=array("Toplam $filtre_sayi adet sonuç içinde Toplam Ciro $ToplamFiltre ₺");
		exportExcel($isim,$columns,$data,$replaceDotCol);
	}
	if($action=="secili_tarihi"){
					

		$BAS=re("tarih1");
		$SON=re("tarih2");
		$filtre = mysql_query("SELECT * FROM satilan_araclar WHERE  MONTH(tarih)= '$BAS' AND YEAR(tarih)= '$SON' ");
		$filterCount = mysql_num_rows($filtre);
		$ayYil = mysql_query("SELECT SUM(ciro) AS ciro FROM satilan_araclar WHERE  MONTH(tarih) = '$BAS' AND YEAR(tarih)= '$SON' "); 
		$AyYilToplam = mysql_fetch_assoc($ayYil); 
		$AyYilCiro = $AyYilToplam['ciro'];
		$isim="SATILAN_ARACLAR"."-".$BAS."-".$SON;

		$replaceDotCol=array(10,11,12,13,15); //ilk kolon sıfır olmak üzere belirtilen kolonlarda "," ile "." değiştirilir.
		while($filtre_yaz = mysql_fetch_array($filtre)){
			//SATIRLAR
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
				$filtre_yaz["maliyet"],
				$filtre_yaz["satilan_fiyat"],
				$filtre_yaz["pd_hizmet"],
				$filtre_yaz["ektra_kazanc"],
				$filtre_yaz["notlar"],
				$filtreToplam['ciro']
			);
			$sira++;
		}	
		$data[]=array("Toplam $filterCount adet sonuç içinde Toplam Ciro $AyYilCiro ₺");
		exportExcel($isim,$columns,$data,$replaceDotCol);

	} 
	if($action=="tarihsiz"){
			

		$result = mysql_query('SELECT SUM(ciro) AS ciro FROM satilan_araclar'); 
		$row = mysql_fetch_assoc($result); 
		$sum = $row['ciro'];
		$satilan_cek = mysql_query("SELECT * FROM satilan_araclar");
		$satilan_sayi = mysql_num_rows($satilan_cek);
		$tarih=date("Y-m-d H:i:s");
		$isim="SATILAN_ARACLAR_".$tarih;
		$replaceDotCol=array(10,11,12,13,15); //ilk kolon sıfır olmak üzere belirtilen kolonlarda "," ile "." değiştirilir.
		while($satilan_oku = mysql_fetch_array($satilan_cek)){ 
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
				$satilan_oku["maliyet"],
				$satilan_oku["satilan_fiyat"],
				$satilan_oku["pd_hizmet"],
				$satilan_oku["ektra_kazanc"],
				$satilan_oku["notlar"],
				$satilan_oku['ciro']
			);
			$sira++;
		}
		$data[]=array("Toplam $satilan_sayi adet sonuç içinde Toplam Ciro $sum ₺");
		exportExcel($isim,$columns,$data,$replaceDotCol);


	}

 ?>