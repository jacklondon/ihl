<?php 
session_start();
include '../../../ayar.php';
$response = [];
$statusCode = 404;
?>

<?php 

if(re('action')=="hazir_sec"){
    $deger = re('deger');
    $mesaji_cek = mysql_query("select * from hazir_mesajlar where id = '".$deger."'");
    $mesaj_oku = mysql_fetch_assoc($mesaji_cek);
    $mesaj_icerik = $mesaj_oku['sms_icerigi'];
    $mesaj_kat_bul = mysql_query("select * from hazir_mesaj_kategori where id = '".$mesaj_oku['kategori_id']."'");    
    $mesaj_kat_oku = mysql_fetch_assoc($mesaj_kat_bul);
    $kisa_ad = $mesaj_kat_oku['kisa_ad'];  
    
    echo json_encode(["message" => "Sms içeriği getirildi", "mesaj_icerik" => $mesaj_icerik, "kisa_ad" => $kisa_ad , "status" => 200]);
}

if(re('action')=="mesaj_guncelle"){
    $mesaj_id = re('mesaj_id');
    $sms_icerigi = re('sms_icerigi');
    $guncelle = mysql_query("update hazir_mesajlar set sms_icerigi = '".$sms_icerigi."' where id = '".$mesaj_id."'");
    if($guncelle){
        echo json_encode(["message" => "Sms içeriği başarılı bir şekilde güncellendi", "mesaj_id" => $mesaj_id , "status" => 200]);
    }else{
        echo json_encode(["message" => "Sms içeriği güncellenirken hata oluştu. Lütfen Tekrar Deneyiniz.", "mesaj_id" => $mesaj_id , "status" => 400]);
    }
}

if(re('action')=="mesaj_sil"){
    $mesaj_id = re('mesaj_id');
    $sms_icerigi = re('sms_icerigi');
    $sil = mysql_query("delete from hazir_mesajlar where id = '".$mesaj_id."'");
    if($sil){
        echo json_encode(["message" => "Hazır Mesaj Başarılı Bir Şekilde Silindi", "mesaj_id" => $mesaj_id , "status" => 200]);
    }else{
        echo json_encode(["message" => "Hazır mesaj silinirken bir hata oluştu. Lütfen Tekrar Deneyiniz.", "mesaj_id" => $mesaj_id , "status" => 400]);
    }
}


if(re('action')=="mesaji_aktif_et"){
    $mesaj_id = re('mesaj_id');
    $mesaj_bul = mysql_query("select * from hazir_mesajlar where id = '".$mesaj_id."'");
    $mesaj_oku = mysql_fetch_assoc($mesaj_bul);
    $mesaj_kat_bul = mysql_query("select * from hazir_mesaj_kategori where id = '".$mesaj_oku['kategori_id']."'");
    $mesaj_kat_oku = mysql_fetch_assoc($mesaj_kat_bul);

    $pasif_et = mysql_query("update hazir_mesajlar set aktif = 0 where kategori_id = '".$mesaj_kat_oku['id']."'");
    if($pasif_et){
        $aktif_et = mysql_query("update hazir_mesajlar set aktif = 1 where id = '".$mesaj_id."'");
        if($aktif_et){
            echo json_encode(["message" => "Hazır Mesaj Başarılı Bir Şekilde Aktif Edildi", "mesaj_id" => $mesaj_id , "status" => 200]);
        }else{
            echo json_encode(["message" => "Lütfen Tekrar Deneyiniz", "mesaj_id" => $mesaj_id , "status" => 300]);
        }
    }else{
        echo json_encode(["message" => "Beklenmeyen bir hata oluştu. Lütfen Tekrar Deneyiniz", "mesaj_id" => $mesaj_id , "status" => 400]);
    }
    

}

?>

