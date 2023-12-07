<?php 
    $cek = mysql_query("select * from cayma_bedelleri where durum = 2");
    $talepler = "";
    while($oku = mysql_fetch_object($cek)){
        $uye_cek = mysql_query("select * from user where id = '".$oku->uye_id."'");
        $uye_oku = mysql_fetch_object($uye_cek);
        if($uye_oku->user_token != ""){
            $firma = "Bireysel Üye";
            $uye_ad = $uye_oku->ad;
        }elseif($uye_oku->kurumsal_user_token != ""){
            $firma = $uye_oku->unvan;
            $uye_ad = "Kurumsal Üye";
        }
        $talepler .= '<tr>
            <td>'.$oku->id.'</td>
            <td>'.$firma.'</td>
            <td>'.$uye_ad.'</td>
            <td><b>'.money($oku->tutar).' ₺</b></td>
            <td>TR'.$oku->iban.'</td>
            <td>'.$oku->hesap_sahibi.'</td>
            <td>'.date("d-m-Y H:i:s", strtotime($oku->iade_talep_tarihi)).'</td>
            <td><a style="text-decoration: none;" href="?modul=uyeler&sayfa=uye_duzenle&id='.$oku->uye_id.'" target="_blank"><i class="fas fa-edit"></i></a></td>
        </tr>';
    }
?>

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Üye Firma</th>
            <th>Üye Ad Soyad</th>
            <th>Talep Edilen Tutar</th>
            <th>IBAN</th>
            <th>Banka Hesabı Sahibi</th>
            <th>Talep Tarihi</th>
            <th>İşlem</th>
        </tr>
    </thead>
    <tbody>
        <?= $talepler ?>
    </tbody>
</table>