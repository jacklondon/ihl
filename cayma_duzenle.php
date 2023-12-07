<?php 
session_start();
include 'ayar.php';
$response = [];
$statusCode = 404;
?>

<?php 
if(re('action')=="cayma_duzenle"){
    $cayma_id = re('cayma_id');
    $iban_no = re('iban_no');
    $cayma_guncelle = mysql_query("update cayma_bedelleri set iban = '".$iban_no."' where id = '".$cayma_id."'");
    if($cayma_guncelle){
        echo json_encode(["message" => "IBAN Numarası Güncellendi", "iban_no" => $iban_no,"status" => 200]);
    }else{
        echo json_encode(["message" => "Hata", "status" => 400]);
    }
}
?>