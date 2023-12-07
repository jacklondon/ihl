<?php 
session_start();
include 'ayar.php';
$response = [];
$statusCode = 404;
if(re("action")=="teklif_say")
{
$sor_teklif_sayisini = mysql_query("select * from teklifler");
$bildirim_teklif_sayi_gelen = mysql_num_rows($sor_teklif_sayisini);
$oku_teklif_sayisini = mysql_fetch_assoc($sor_teklif_sayisini);
if($sor_teklif_sayisini){
    $listingMap[]=[
        "ilan_sayisi"=>$bildirim_teklif_sayi_gelen,
    ];
}
if (mysql_num_rows($sor_teklif_sayisini) > 0) $statusCode = 200;
$response = ["message" => "Üyelik Paketleri Getirildi", "Üyelik Paketleri Detay" => $sor_teklif_sayisini, "status" => $statusCode];
echo json_encode(response($listingMap, $statusCode));
}
?>