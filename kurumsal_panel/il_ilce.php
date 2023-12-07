<?php 
include('../ayar.php');
if (re('plakaKodu')){
    $plakaKodu = re('plakaKodu');  
    // ilçelerini bul
    $ilce_cek = mysql_query("SELECT * FROM ilce WHERE il_plaka = $plakaKodu ");
	var_dump("SELECT * FROM ilce WHERE il_plaka = $plakaKodu ");
    $html .= '<option>- İlçe seçin -</option>';
    echo $plakaKodu;
    while($ilce_oku = mysql_fetch_array($ilce_cek)){
        $html .= '<option value="'.$ilce_oku['ilce_adi'].'">'. $ilce_oku['ilce_adi'].'</option>';
    }
    echo $html;
}
?>