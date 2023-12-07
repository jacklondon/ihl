<?php 
include('../../../ayar.php');
if ( re('plakaKodu')){
    $plakaKodu = re('plakaKodu');  
    // modellerini bul
    $ilce_cek = mysql_query("SELECT * FROM ilce WHERE il_plaka = $plakaKodu ");
	if(mysql_num_rows($ilce_cek)>0){
		//$html .= '<option>- İlçe seçin -</option>';
		echo $plakaKodu;
		while($ilce_oku = mysql_fetch_array($ilce_cek)){
			$html .= '<option value="'.$ilce_oku['ilce_adi'].'">'. $ilce_oku['ilce_adi'].'</option>';
		}
		echo $html;
	}else{
		//$html .= '<option>- İlçe seçin -</option>';
		echo $plakaKodu;
		$il_sql=mysql_query("select * from sehir where sehiradi= '$plakaKodu'");
		$il_fetch=mysql_fetch_assoc($il_sql);
		$il_plaka=$il_fetch["sehirID"];
		$ilce_sql=mysql_query("SELECT * FROM ilce WHERE il_plaka = $il_plaka ");
		
		while($ilce_oku = mysql_fetch_array($ilce_sql)){
			$html .= '<option value="'.$ilce_oku['ilce_adi'].'">'. $ilce_oku['ilce_adi'].'</option>';
		}
		echo $html;
	}
    
}
?>