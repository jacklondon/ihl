  <?php 
session_start();
$admin_id=$_SESSION['kid'];
//$uyeleri_cek = mysql_query("SELECT * FROM user WHERE temsilci_id = '".$admin_id."'");
$mesaj_cek = mysql_query("SELECT * FROM iletisim_formu order by id desc");
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
  <!-- <a href="?modul=slider&sayfa=slider_ekle">
      <input type="submit" class="btn blue" name="yeni_slider_ekle" value="Footer Oluştur">
   </a> -->
</div>
<div style="overflow-x:auto; overflow-y:auto; margin-top:2%;">
<table width="100%" border="0" cellspacing="4" cellpadding="2" style="margin-top:3%;">
  <tbody>
    <tr>
      <td>#</td>
      <td>Ad</td>
      <td>Soyad</td>
      <td>Email</td>
      <td>Mesaj</td>
      <td>Tarih</td>
    </tr>
    <?php  while($row = mysql_fetch_array($mesaj_cek)){ ?>
    <tr>
      <td><?=$sira?></td>
      <td><?=$row['ad'] ?></td>
      <td><?=$row['soyad'] ?></td>
      <td><?=$row['email'] ?></td>
      <td><?=$row['mesaj'] ?></td>
      <td><?=$row['olusturulma_zamani'] ?></td>
    </tr>
    <?php $sira++; } ?>
  </tbody>
</table>
</div>





