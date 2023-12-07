Ana sayfada önemli hızlı göz atabilmek amacıyla bazı alanları koyacağız bunlar;<br>
o Son 10 teklif<br>
o Son 10 Mesaj<br>
o Son 10 Üye (yeni üyelik)<br>
o Altın üye başvurusu yapan son 10 üye<br>
o Dosya Ekleyen son 10 üye<br>
o Cayma bedeli iade isteyenler<br>
o Kısayol İconları <br>
<style>
    thead{
        font-weight: 800;
    }
</style>
<?php 
$uye_cek = mysql_query("SELECT * FROM `user` ORDER BY kayit_tarihi DESC LIMIT 10");
?>
<table class="table"  cellspacing="1" cellpadding="1" style="margin-top: 3%; text-align:center;">
    <caption><h3>Üye Olan Son 2 Kullanıcı</h3></caption>
    <thead>
        <tr >
            <td>Ad </th>
            <td>Cinsiyet</th>
            <td>Şehir</th>
        </tr>
    </thead>
    <tbody>
        <?php while($uye_oku = mysql_fetch_array($uye_cek)){ ?>
        <tr>
            <td><?= $uye_oku["ad"]; ?></td>
            <td><?= $uye_oku["cinsiyet"]; ?></td>
            <td><?= $uye_oku["sehir"]; ?></td>
        </tr>
        <?php } ?>
    </tbody>
</table>

<?php 
$kurumsal_cek = mysql_query("SELECT * FROM `kurumsal_user` ORDER BY kayit_tarihi DESC LIMIT 10");
?>
<table class="table table-striped"  cellspacing="1" cellpadding="1" style="margin-top: 3%; text-align:center;">
    <caption><h3>Üye Olan Son 2 Kurumsal</h3></caption>
    <thead>
        <tr>
            <td>Ad </th>
            <td>Cinsiyet</th>
            <td>Şehir</th>
        </tr>
    </thead>
    <tbody>
        <?php while($kurumsal_oku = mysql_fetch_array($kurumsal_cek)){ ?>
        <tr>
            <td><?= $kurumsal_oku["ad"]; ?></td>
            <td><?= $kurumsal_oku["unvan"]; ?></td>
            <td><?= $kurumsal_oku["sehir"]; ?></td>
        </tr>
        <?php } ?>
    </tbody>
</table>



<?php
$bugun = date('Y-m-d');

$odemesi_gecen = mysql_query("SELECT * FROM ilanlar WHERE eklenme_zamani >= $bugun LIMIT 5");
?>
 
<table class="table table-striped" cellspacing="1" cellpadding="1" style="margin-top:3%; text-align:center">
<caption><h3>Ödemesi Geçen İlanlar</h3></caption>
<thead>
    <tr>
        <td>Plaka</td>
        <td>Marka</td>
        <td>Model</td>
        <td>Sigorta</td>
    </tr>
</thead>
<tbody>
    <?php while($odemesi_gecen_oku = mysql_fetch_array($odemesi_gecen)){?>
    <tr>
        <td><?= $odemesi_gecen_oku['plaka'] ?></td>
        <td><?= $odemesi_gecen_oku['marka'] ?></td>
        <td><?= $odemesi_gecen_oku['model'] ?></td>
        <td><?= $odemesi_gecen_oku['sigorta'] ?></td>
    </tr>
    <?php }  ?>

</tbody>
</table>


