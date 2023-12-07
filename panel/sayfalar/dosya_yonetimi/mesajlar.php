<?php 
$gelen_id = re('id');
$fav_cek = mysql_query("SELECT * FROM mesajlar WHERE ilan_id = '".$gelen_id."'");
$i = 1;
?>
<table class="table table-bordere table-striped">
<thead>
    <tr>
        <th>Sıra</th>
        <th>Üye Adı</th>
        <th>Üye Telefonu</th>
        <th>Mesaj</th>
        <th>Mesaj Zamanı</th>
    </tr>
</thead>
<tbody>
    <?php
while($fav_oku = mysql_fetch_array($fav_cek)){
    $uye_id = $fav_oku['gonderen_id'];
$uye_cek = mysql_query("SELECT * FROM user WHERE id ='".$uye_id."'");
while($uye_oku = mysql_fetch_array($uye_cek)){
    $uye_ad = $uye_oku['ad'];
    ?>

        <tr>
            <td><?= $i++ ?></td>
            <td><?= $uye_ad ?></td>
            <td><?= $uye_oku['telefon'] ?></td>
            <td><?= $fav_oku['mesaj'] ?></td>            
            <td><?= date("d-m-Y H:i:s",strtotime($fav_oku['gonderme_zamani'])) ?></td>
        </tr>
    
<?php }}
?>
</tbody>
 </table>