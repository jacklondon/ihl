<?php 
session_start();
$hepsini_cek = mysql_query("SELECT * FROM sigorta_ozellikleri");

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
<div class="form-control" style="margin-top: 2%;">
  <div class="row-fluid">
    <div class="span6">
      <form class="navbar-search pull-left">
        <input type="text" class="search-query" placeholder="Ara">
      </form>
    </div>
    <div class="span6">
      <a href="?modul=ayarlar&sayfa=sigorta_sirketi_ayarlari">
        <input type="submit" class="btn blue" name="yeni_sigorta_sirketi" value="Yeni Sigorta Şirketi Ekle">
      </a> 
    </div>
  </div>
</div>
<div style="overflow-x:auto; overflow-y:auto; margin-top:2%;">
<table width="100%" border="0" class="table" cellspacing="4" cellpadding="2" style="margin-top:3%;">
  <tbody>
    <tr>
      <td>#</td>
      <td>Sigorta Şirketi</td>
      <td>Düzenle</td>
      <td>Komisyon Oranları</td>
      <td>Sil</td>
    </tr>
    <?php 
        $sayac=1;
        while($hepsini_oku = mysql_fetch_array($hepsini_cek)){
		
          $sigorta_id = $hepsini_oku["id"];
    ?>
    <tr>
      <td><?=$sayac++?></td>
      <td><?=$hepsini_oku["sigorta_adi"]?></td>
      <td><a href="?modul=ayarlar&sayfa=sigorta_sirketi_ayarlari&id=<?=$sigorta_id?>" style="text-decoration:none; color:black;" name="duzenle"><i class="fas fa-edit"></i></a></td>
      <td><a href="?modul=ayarlar&sayfa=komisyon_oranlari&id=<?=$sigorta_id?>" style="text-decoration:none; color:black;" name="komisyon_duzenle"><i class="fas fa-align-justify"></i></a></td>
      <td><a style="display: <?php if($sigorta_id == 1){ echo "none" ;} ?>;" href="?modul=ayarlar&sayfa=data_sil&id=<?= $sigorta_id ?>&q=sig_sil" onclick="return confirm('Silmek istediğinize emin misiniz ?')"><i style="color:black;" class="fas fa-trash"></i></a></td>
    </tr>
    <?php } ?>
  </tbody>
</table>
</div>

