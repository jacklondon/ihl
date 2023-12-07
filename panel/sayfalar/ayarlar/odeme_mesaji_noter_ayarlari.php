<?php 
session_start();
$mesaj_id = re("id");
$mesaj_cek = mysql_query("SELECT * FROM odeme_mesaji");
$mesaj_getir=mysql_fetch_object($mesaj_cek);
?>
<form method="POST" name="form" id="form" action="">
<?php include('islemler/ayarlar/odeme_mesaji_ekle.php'); ?>
<!-- <div class="row-fluid" style="margin-top:2%;">
    <div class="span3"></div>
    <div class="span9">
        <p style="color: red;">Lütfen "{}" parantez içerisindeki bilgileri değiştirmeyiniz."--PLAKA GELECEK--"
            yazsısı alanına Plaka yazabilirsiniz.Noter giderini aşağıda bulunan alandan düzenleyebilirsiniz.
        </p>
    </div>
</div> -->
<!--<div class="row-fluid" style="margin-top:3%;" >
    <div class="span3" >
        <div>SMS içeriği :</div>
    </div>
    <div class="span9">
        <textarea name="sms_icerigi" class="span12"  rows="15"></textarea>
    </div>
</div>-->
<div class="row-fluid" style="margin-top:2%;">
    <div class="span3">
        <p>Noter & Takipçi Gideri :</p>
    </div>
    <div class="span9">
        <input type="number" name="noter_takipci_gideri" value="<?=$mesaj_getir->noter_takipci_gideri ?>" class="span3">
        <input type="hidden" name="noter_id" value="<?=$mesaj_getir->id ?>" class="span3">
    </div>
</div>
<div class="row-fluid">
    <div class="span3"></div>
    <div class="span9">
        <input type="submit" class="btn" name="odeme_mesajini" value="Kaydet" style="background-color: rgb(88,103,221); color:white;">
    </div>
</div>
</form>



<!--<table style="margin-top: 3%; table-layout: fixed; width: 100%;" class="table table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th colspan="3">Mesaj</th>
            <th>Noter, Takipçi Gideri</th>
        </tr>
    </thead>
    <tbody>
    <?php 
        $sayac=1;
        while($mesaj_oku = mysql_fetch_array($mesaj_cek)){
    ?>
        <tr>
            <td><?= $sayac++ ?></td>
            <td colspan="3" style="word-wrap: break-word"><?=$mesaj_oku["icerik"]?></td>
            <td><?=$mesaj_oku["noter_takipci_gideri"]?></td>
            
        </tr>
        <? } ?>
    </tbody>
</table>-->


