<?php 
$kazanilan_id = re('id');
$islem = re('q');

//Onayla
if($islem == "onayla"){
    mysql_query("UPDATE kazanilanlar SET durum = 1 , statu = 'Ödeme Bekliyor' WHERE id='".$kazanilan_id."'");
    echo'<script>alert("Başarılı")</script>';
    echo'<script type="text/javascript">
    window.history.go(-1);
    </script>';
}
//Ödeme bekliyor
if($islem == "odeme"){
    mysql_query("UPDATE kazanilanlar SET durum = 2 , statu = 'Son İşlemde' WHERE id='".$kazanilan_id."'");
    echo'<script>alert("Başarılı")</script>';
    echo'<script type="text/javascript">
    window.history.go(-1);
    </script>';
}
//Satın Alınan
if($islem == "satildi"){
    mysql_query("UPDATE kazanilanlar SET durum = 3 , statu = 'Satın Alındı' WHERE id='".$kazanilan_id."'");
    echo'<script>alert("Başarılı")</script>';
    echo'<script type="text/javascript">
    window.history.go(-1);
    </script>';
}
//İptal Edildi
if($islem == "iptal"){
    mysql_query("UPDATE kazanilanlar SET durum = 4 , statu = 'İptal Edildi' WHERE id='".$kazanilan_id."'");
    echo'<script>alert("Başarılı")</script>';
    echo'<script type="text/javascript">
    window.history.go(-1);
    </script>';
}
?>