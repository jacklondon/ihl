<?php 
$onay_bekleyen_cek = mysql_query("select * from teklifler where durum = 2 order by teklif_zamani desc");
$onay_bas = '';
$sira = 1;
while($onay_bekleyen_oku = mysql_fetch_array($onay_bekleyen_cek)){
    $ilan_cek = mysql_query("select * from ilanlar where id = '".$onay_bekleyen_oku['ilan_id']."'");
    $ilan_oku = mysql_fetch_assoc($ilan_cek);
    $ilan_marka_cek = mysql_query("select * from marka where markaID = '".$ilan_oku['marka']."'");
    $ilan_marka_oku = mysql_fetch_assoc($ilan_marka_cek);
    $teklif_veren_cek = mysql_query("select * from user where id = '".$onay_bekleyen_oku['uye_id']."'");
    $teklif_veren_oku = mysql_fetch_assoc($teklif_veren_cek);
    $teklif_zamani = $onay_bekleyen_oku['teklif_zamani'];
    $newDate = date("d-m-Y H:i:s", strtotime($teklif_zamani));
    $onay_bas .='<tr>
        <td>'.$sira++.'</td>
        <td><a href="?modul=ilanlar&sayfa=ilan_ekle&id='.$ilan_oku["id"].'" target="_blank">'.$ilan_oku["plaka"].' - '.$ilan_oku["arac_kodu"].'</a></td>
        <td><a href="../arac_detay.php?id='.$ilan_oku["id"].'&q=ihale" target="_blank">'.$ilan_oku["model_yili"].' '.$ilan_marka_oku["marka_adi"].' '.$ilan_oku["model"].' '.$ilan_oku["tip"].' '.$ilan_oku["profil"].'</a></td>
        <td>'.$teklif_veren_oku["ad"].'</td>
        <td>'.$onay_bekleyen_oku["teklif"].' TL</td>
        <td>'.$newDate.'</td>
        <td><a href="?modul=ihaleler&sayfa=teklif_islemleri&id='.$onay_bekleyen_oku["id"].'&q=onayla"><button type="button" class="btn-primary">Onayla</button></a></td>
        <td><a href="?modul=ihaleler&sayfa=teklif_islemleri&id='.$onay_bekleyen_oku["id"].'&q=reddet" onclick="return confirm(\'Teklifi Reddetmek İstediğinize Eminmisiniz ?\')"><button type="button" class="btn-danger">Reddet</button></a></td>
    </tr>';
}
?>
<div class="row-fluid">
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Sıra</th>
                    <th>Plaka / Araç Kodu</th>                   
                    <th>Araç Detayları</th>
                    <th>Teklif Veren</th>
                    <th>Teklif</th>
                    <th>Tarih</th>
                    <th>Onayla</th>
                    <th>Reddet</th>
                </tr>
            </thead>
            <tbody>
                <?= $onay_bas ?>
            </tbody>
        </table>
    </div>
</div>

