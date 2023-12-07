<?php 
session_start();
$gelen_id = re('id');


$hepsini_cek = mysql_query("SELECT * FROM komisyon_oranlari WHERE sigorta_id = '".$gelen_id."' order by komisyon_orani asc");


?>

<style>
table {
  border-collapse: collapse;
  border-spacing: 0;
  width: 100%;
  border: 1px solid #ddd;
}

th, td {
  text-align: left;
  padding: 16px;
}

tr:nth-child(even) {
  background-color: #f2f2f2;
}
</style>


<div class="row-fluid"style="margin-top: 3%;">
    <div class="span9">
        <a href="?modul=ayarlar&sayfa=sigorta_sirketleri" type="submit" class="btn" style="background-color: rgb(88,103,221); color:white; text-decoration:none;">Sigorta Şirketleri</a>
    </div>
    <div class="span3">
        <a href="?modul=ayarlar&sayfa=komisyon_oranlari_ekle&id=<?=$gelen_id?>" class="btn" style="background-color: rgb(88,103,221); color:white; text-decoration:none;">Komisyon Oranı Ekle</a>
    </div>
</div>


<form method="post" name="form" id="form">
<table cellspacing="4" class="table" cellpadding="2" style="margin-top:3%;">
  <tbody>
    <tr>
      <td>#</td>
      <td>Komisyon Oranı</td>
      <td>Net</td>
      <td>10.000 (On binde)</td>
      <td>Ticari Net</td>
      <td>Ticari 10.000 (On binde)</td>
      <td>Sil</td>
    </tr>
    <?php 
        while($hepsini_oku = mysql_fetch_array($hepsini_cek)){

          $sayac++;
           $kom_id = $hepsini_oku["id"];
    ?>
    <tr>
    
      <td><?=$sayac?></td>
      <td style="font-weight:bold;font-size:16px;"><?=money($hepsini_oku["komisyon_orani"]) ?> ₺</td>
      <td><?=$hepsini_oku["net"]?></td>
      <td><?=$hepsini_oku["onbinde"]?></td>
      <td><?=$hepsini_oku["lux_net"]?></td>
      <td><?=$hepsini_oku["lux_onbinde"]?></td>
      <td><a href="?modul=ayarlar&sayfa=data_sil&id=<?= $kom_id ?>&q=kom_sil&g=<?= $gelen_id ?>" onclick="return confirm('Silmek istediğinize emin misiniz ?')" class="btn mini"><i class="fas fa-trash"></i></a></td>
      
    </tr>
    <?php } ?>
  </tbody>
</table>
</form>
