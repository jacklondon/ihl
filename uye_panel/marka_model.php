<?php 
include('../ayar.php');
if ( re('modeladi')){
    $modeladi = re('modeladi');  
    // ilçelerini bul
    $model_cek = mysql_query("SELECT * FROM model WHERE marka_id = $modeladi order by model_adi asc ");
    $html .= '<option value="">Seçiniz...</option>';
    echo $modeladi;
    while($model_oku = mysql_fetch_array($model_cek)){
        $html .= '<option value="'.$model_oku['model_adi'].'">'. $model_oku['model_adi'].'</option>';
    }
    echo $html;
}
?>