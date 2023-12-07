<?php 
if(re('sigorta_sirketini')=="Kaydet"){
    $sirket_adi = re('sirket_adi');
    $hizli_teklif1 = re('hizli_teklif1');
    $hizli_teklif2 = re('hizli_teklif2');
    $hizli_teklif3 = re('hizli_teklif3');
    $hizli_teklif4 = re('hizli_teklif4');
    $sure_uzatma = re('sure_uzatma');
    $dakikanin_altinda = re('dakikanin_altinda');
    $dakika_uzar = re('dakika_uzar');
    $saniyenin_altinda = re('saniyenin_altinda');
    $saniye_uzar = re('saniye_uzar');
    $uyari_notu = re('uyari_notu');
    $altin_dakika = re('altin_dakika');
    $sigorta_aciklamasi = re('sigorta_aciklamasi');
    $park_ucreti = re('park_ucreti');
    $cekici_ucreti = re('cekici_ucreti');
    $sigorta_dosya_masrafi = re('sigorta_dosya_masrafi');
    $minumum_artis = re('minumum_artis');
    $teklif_onay = re('teklif_onay');
    $onaylama_mesaji = re('onaylama_mesaji');
    //$teklif_uyari_sesi = re('teklif_uyari_sesi');
    $sigorta_dakika = re('sigorta_dakika');
    $sure_altinda_teklif_verilirse = re('sure_altinda_teklif_verilirse');
    $bu_mesaji_alsin = re('bu_mesaji_alsin');
    $pd_hizmeti = re('pd_hizmeti');
    $ihale_tipi = re('ihale_tipi');
    $vitrin = re('vitrin');
    $vitrin_adet = re('vitrin_sayi');
    $tarih = date('H:i:s');
	
	$errors= array(); 
	$allowed = array("audio/mpeg",'audio/mpg', 'audio/mpeg3', 'audio/mp3','audio/wav');

	$dosya_adi =$_FILES['file']['name']; 		// uzantiya beraber dosya adi 
	$dosya_boyutu =$_FILES['file']['size'];    		// byte cinsinden dosya boyutu 
	$dosya_gecici =$_FILES['file']['tmp_name'];		//gecici dosya adresi 
	$file_type =$_FILES['file']['type'];	
	$yenisim=md5(microtime()).$dosya_adi; 					
	if($dosya_boyutu > 20971520){ 
		$errors[]='Maksimum 20 Mb lık dosya yuklenebilir.'; 
	}
	
	if(!in_array($file_type, $allowed)) {
		if($dosya_adi!=""){
			$errors[]='mp3 ve wav uzantılı dosyalar yüklenebilir.'; 
		}else{
			$errors[]='Gold üye teklif uyari sesi seçmelisiniz.'; 
		}
	}
	
	$dosya_adi2 =$_FILES['teklif_uyari_sesi']['name']; 		// uzantiya beraber dosya adi 
	$dosya_boyutu2 =$_FILES['teklif_uyari_sesi']['size'];    		// byte cinsinden dosya boyutu 
	$dosya_gecici2 =$_FILES['teklif_uyari_sesi']['tmp_name'];		//gecici dosya adresi 
	$file_type2 =$_FILES['teklif_uyari_sesi']['type'];	
	$yenisim2=md5(microtime()).$dosya_adi2; 					
	if($dosya_boyutu2 > 20971520){ 
		$errors[]='Maksimum 20 Mb lık dosya yuklenebilir.'; 
	}
	if(!in_array($file_type2, $allowed)) {
		if($dosya_adi2!=""){
			$errors[]='mp3 ve wav uzantılı dosyalar yüklenebilir.'; 
		}else{
			$errors[]='Teklif uyari sesi seçmelisiniz.'; 
		}
	}
	$klasor="https://ihale.pertdunyasi.com/panel/images/sounds/"; // yuklenecek dosyalar icin yeni klasor 
	$klasor2="images/sounds/"; // yuklenecek dosyalar icin yeni klasor 
	if(empty($errors)==true){  //eger hata yoksa 
		$test=move_uploaded_file($dosya_gecici,"$klasor2/".$yenisim);//yoksa yeni ismiyle kaydet 
		$test2=move_uploaded_file($dosya_gecici2,"$klasor2/".$yenisim2);//yoksa yeni ismiyle kaydet 
		if($test==false && $test2==false ){
			//echo "<script>alert('Dosya yüklenemedi.')</script>"; 
		}else{
			    mysql_query("INSERT INTO `sigorta_ozellikleri` (`id`, `sigorta_adi`, `hizli_teklif_1`, `hizli_teklif_2`, 
				`hizli_teklif_3`, `hizli_teklif_4`, `sure_uzatma`, `dakikanin_altinda`, `dakika_uzar`,`saniyenin_altinda`, `saniye_uzar`, `uyari_notu`, 
				`sigorta_aciklamasi`, `park_ucreti`,`sigorta_cekici_ucreti`,  `sigorta_dosya_masrafi`, `minumum_artis`, `teklif_uyari_sesi`, 
				`sigorta_bitis_saati`, `bu_sure_altinda_teklif`, `alacagi_mesaj`, `teklif_onay_mekanizmasi`, 
				`teklif_iletme_mesaji`, `ihale_tipi`, `vitrin`, `vitrin_adet`, `pd_hizmeti`, `gold_uyari_sesi`, `gold_uyari_dakika`) VALUES 
				(NULL, '".$sirket_adi."', '".$hizli_teklif1."', '".$hizli_teklif2."', '".$hizli_teklif3."', '".$hizli_teklif4."', 
				'".$sure_uzatma."', '".$dakikanin_altinda."', '".$dakika_uzar."', '".$saniyenin_altinda."', '".$saniye_uzar."', '".$uyari_notu."', '".$sigorta_aciklamasi."', 
				'".$park_ucreti."', '".$cekici_ucreti."', '".$sigorta_dosya_masrafi."', '".$minumum_artis."', '".$klasor.$yenisim2."', 
				'".$sigorta_dakika."', '".$sure_altinda_teklif_verilirse."', '".$bu_mesaji_alsin."', '".$teklif_onay."', 
				'".$onaylama_mesaji."', '".$ihale_tipi."', '".$vitrin."', '".$vitrin_adet."', '".$pd_hizmeti."', '".$klasor.$yenisim."','".$altin_dakika."');");

				$sigorta_bul = mysql_query("SELECT * FROM sigorta_ozellikleri WHERE sigorta_adi = '".$sirket_adi."' AND hizli_teklif_1 = '".$hizli_teklif1."'
				 AND hizli_teklif_2 = '".$hizli_teklif2."' AND hizli_teklif_3 = '".$hizli_teklif3."'
				AND hizli_teklif_4 = '".$hizli_teklif4."' AND sigorta_aciklamasi = '".$sigorta_aciklamasi."' AND 
				uyari_notu = '".$uyari_notu."' AND pd_hizmeti = '".$pd_hizmeti."' AND sure_uzatma = '".$sure_uzatma."'");

				$sigorta_oku = mysql_fetch_assoc($sigorta_bul);
				$sigorta_id = $sigorta_oku['id'];
				$grup_bul = mysql_query("SELECT * FROM uye_grubu");
				$grup_sayi = mysql_num_rows($grup_bul);
				
				$arttir=0;
				while($grup_oku=mysql_fetch_array($grup_bul)){
					if($_POST["detay_".$arttir] == null){
						$_POST["detay_".$arttir]=0;
					}
					$grup_id = $grup_oku['id'];
					mysql_query("INSERT INTO `sigortalar` (`id`, `sigorta_id`, `paket_id`, `secilen_yetki_id`, `detay_gorur`, `tarih`) VALUES
					(NULL, '".$sigorta_id."', '".$grup_id."', '".$_POST["yetki_durum".$arttir]."', '".$_POST["detay_".$arttir]."', '".$tarih."');");
					$arttir++;
				}
				$komisyon_ekle=mysql_query("insert into komisyon_oranlari
							(sigorta_id,komisyon_orani,net,onbinde,lux_net,lux_onbinde) 
							values 
							('". $sigorta_id."','0','0','0','0','0' ) ");
							
				if($vitrin=="on" && $vitrin_adet>0){
					$ilan_get=mysql_query("select * from ilanlar where durum=1 and vitrin!='on' and sigorta='".$sigorta_id."'");//Vitrinde olabilecek potansiyel ilanlar
					$ilan_ssay=mysql_num_rows($ilan_get);
					if($vitrin_adet>$ilan_ssay){
						$vitrin_adet=$ilan_ssay;
					}
					while($durum=true){
						$guncelle=mysql_query("
							update 
								ilanlar as i
							inner join
								(Select
									* 
								from 
									ilanlar
								where
									durum = 1 and 
									vitrin !='on' and
									sigorta ='".$sigorta_id."'
								order by
									rand() 
								limit 1
								) as i2
							on 
								i.id = i2.id
							set
								i.vitrin = 'on';"
						);
						
						$ilan_sorg=mysql_query("select * from ilanlar where durum=1 and vitrin='on' and sigorta='".$sigorta_id."' ");
						$ilan_say=mysql_num_rows($ilan_sorg);
						if($ilan_say==$vitrin_adet){
							break;
						}
					}	
					
				}
			
		}

	
	}else{ 
		$mesaj='';
		for($b=0;$b<count($errors);$b++){
			$mesaj.=$errors[$b].",";
		}
		echo "<script>alert('".$mesaj."')</script>"; 
	} 

}



?>






<!-- $statusMsg = '';
// File upload path
$targetDir = "../sesler/";
$fileName = basename($_FILES["altin_zil_sesi"]["name"]);
$targetFilePath = $targetDir . $fileName;
$fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
if(!empty($_FILES["file"]["name"])){
    // Allow certain file formats
    $allowTypes = array('mp3','wav','aud','mid','aif ','cda','m4a');
    if(in_array($fileType, $allowTypes)){
        // Upload file to server
        if(move_uploaded_file($_FILES["altin_zil_sesi"]["tmp_name"], $targetFilePath)){
            // Insert image file name into database
          
                mysql_query("UPDATE sigorta_ozellikleri SET gold_uyari_sesi = '".$fileName."' WHERE id = '".$sigorta_id."'");
            
            if($insert){
                $statusMsg = " ".$fileName. "  başarıyla yüklendi.";
            }else{
                $statusMsg = "Dosya yükleme başarısız, lütfen tekrar deneyin.";
            } 
        }else{
            $statusMsg = "Dosya yüklenirken bir hatayla karşılaşıldı";
        }
    }else{
        $statusMsg = 'Hatalı Format Yüklediniz.';
    }
}else{
    $statusMsg = 'Lütfen dosya seçin.';
}

// Display status message
echo $statusMsg;
$statusMsg = '';

// File upload path
$targetDir = "../sesler/";
$fileName = basename($_FILES["teklif_uyari_sesi"]["name"]);

$targetFilePath = $targetDir . $fileName;
$fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);

if(!empty($_FILES["teklif_uyari_sesi"]["name"])){
    // Allow certain file formats
    $allowTypes = array('mp3','wav','aud','mid','aif ','cda','m4a');
    if(in_array($fileType, $allowTypes)){
        // Upload file to server
        if(move_uploaded_file($_FILES["teklif_uyari_sesi"]["tmp_name"], $targetFilePath)){
            // Insert image file name into database
            mysql_query("UPDATE sigorta_ozellikleri SET teklif_uyari_sesi = '".$fileName."' WHERE id = '".$sigorta_id."'");
            
            if($insert){
                $statusMsg = " ".$fileName. "  başarıyla yüklendi.";
            }else{
                $statusMsg = "Dosya yükleme başarısız, lütfen tekrar deneyin.";
            } 
        }else{
            $statusMsg = "Dosya yüklenirken bir hatayla karşılaşıldı";
        }
    }else{
        $statusMsg = 'Hatalı Format Yüklediniz.';
    }
}else{
    $statusMsg = 'Lütfen dosya seçin.';
}

// Display status message
echo $statusMsg;
    
 -->