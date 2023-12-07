  <?php 
session_start();
$admin_id=$_SESSION['kid'];
//$uyeleri_cek = mysql_query("SELECT * FROM user WHERE temsilci_id = '".$admin_id."'");
$slider_cek = mysql_query("SELECT * FROM referans order by id asc");
$sira=1;
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
  padding: 8px;
}
i{
    color:black;
    padding: 8px;
}
tr:nth-child(even) {
  background-color: #f2f2f2;
}
</style>
<div class="form-control" style="margin-top: 2%;">
   <a href="?modul=referans&sayfa=referans_ekle">
      <input type="submit" class="btn blue" name="yeni_referans_ekle" value="Yeni Referans Ekle">
   </a>
</div>
<div style="overflow-x:auto; overflow-y:auto; margin-top:2%;">
<table width="100%" border="0" cellspacing="4" cellpadding="2" style="margin-top:3%;">
  <tbody>
    <tr>
      <td>#</td>
      <td>Resim</td>
      <td>Durum</td>
      <td>Düzenle</td>
      <td>Sil</td>      
    </tr>
    <?php  while($row = mysql_fetch_array($slider_cek)){ ?>
    <tr>
      <td><?= $sira?></td>

	  <td><img style="width:50px;height:50px;object-fit:cover;" src="<?=referans_image().$row["resim"]?>"/></td>
      <td><?= $row['durum'] == 1 ? $row['durum']="Aktif" : $row['durum']="Pasif" ?></td>
	  <td><a href="?modul=referans&sayfa=referans_guncelle&id=<?=$row["id"]?>" ><i class="fas fa-edit"></i></a></td>
      <td><a href="?modul=ayarlar&sayfa=data_sil&id=<?=$row["id"]?>&q=referans_sil"><i class="fas fa-trash"></i></a></td>
    </tr>
    <?php $sira=$sira+1; } ?>
  </tbody>
</table>
</div>



