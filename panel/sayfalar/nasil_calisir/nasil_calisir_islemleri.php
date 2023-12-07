 <?php 
session_start();
$admin_id=$_SESSION['kid'];
//$uyeleri_cek = mysql_query("SELECT * FROM user WHERE temsilci_id = '".$admin_id."'");
$nasil_calisir_cek = mysql_query("SELECT * FROM nasil_calisir");
$nasil_calisir_menu_cek = mysql_query("SELECT * FROM nasil_calisir_menu order by id asc");
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
<div style="overflow-x:auto; overflow-y:auto; margin-top:2%;">
<table width="100%" border="0" cellspacing="4" cellpadding="2" style="margin-top:3%;">
  <tbody>
    <tr>
      <td>#</td>
      <td>Başlık</td>
      <td>Resim</td>
      <td>Düzenle</td>   
    </tr>
    <?php while($row = mysql_fetch_array($nasil_calisir_cek)){ ?>
    <tr>
		<td>#</td>
      <td><?= $row['baslik'] ?></td>
	  <td><img style="width:100px;height:100px;object-fit:cover;" src="https://ihale.pertdunyasi.com/<?=$row["resim"]?>"/></td>	
	  <td><a href="?modul=nasil_calisir&sayfa=nasil_calisir_guncelle&id=<?=$row["id"]?>" ><i class="fas fa-edit"></i></a></td>
    </tr>
    <?php } ?>
  </tbody>
</table>
<table width="100%" border="0" cellspacing="4" cellpadding="2" style="margin-top:3%;">
  <tbody>
    <tr>
      <td>#</td>
      <td>Başlık</td>
      <td>Açıklama</td>
      <td>Düzenle</td>
    </tr>
    <?php $sira=1; while($row = mysql_fetch_array($nasil_calisir_menu_cek)){ ?>
    <tr>
      <td><?= $sira?></td>
      <td><?= $row['baslik'] ?></td>
      <td><?= $row['aciklama'] ?></td>
	  <td><a href="?modul=nasil_calisir&sayfa=nasil_calisir_menu_guncelle&id=<?=$row["id"]?>" ><i class="fas fa-edit"></i></a></td>
    </tr>
    <?php $sira=$sira+1; } ?>
  </tbody>
</table>
</div>



