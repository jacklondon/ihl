<?php 
include('../../../ayar.php');
function pre_up($str){
    $str = str_replace('i', 'İ', $str);
    $str = str_replace('ı', 'I', $str);
    return $str;
}
if (re('modeladi')){
    $modeladi = re('modeladi');  
    $model_cek = mysql_query("SELECT * FROM model WHERE marka_id = '".$modeladi."' order by model_adi asc");
    $html .= '<option disabled selected value="">- SEÇİNİZ -</option>';
    while($model_oku = mysql_fetch_array($model_cek)){
        $html .= '<option value="'.$model_oku['model_adi'].'" style="text-transform:uppercase;">'. mb_strtoupper(pre_up($model_oku['model_adi'])).'</option>';
    }
    echo $html;
}
?>