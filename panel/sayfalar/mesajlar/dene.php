<form method="POST">
        <div class="row-fluid">
            <div class="span9">
                <input type="text" name="cevap" class="span12">
            </div>
            <div class="span3">
                <input type="submit" class="btn blue" name="mesaji" value="Cevapla">
            </div>
        </div>
</form> 
<?php 
if(re('mesaji')=="Cevapla"){
    $tarih = date('Y-m-d H:i:s');
    mysql_query("INSERT INTO `mesajlar`(`id`, `ilan_id`, `gonderen_id`, `alan_id`, `dogrudan_satis_id`, `mesaj`, `gonderme_zamani`, `gonderen_token`, `alan_token`)
    VALUES 
    (NULL, '".$ID."', '', '', '".$chat_oku['gonderen_token']."', '".re('cevap')."', '".$tarih."', '','' );");
}
?> 

<?php 
$mesaj_cek = mysql_query("SELECT * FROM mesajlar GROUP BY ilan_id");
while($mesaj_oku = mysql_fetch_array($mesaj_cek)){
    $ilan_bul = mysql_query("SELECT * FROM ilanlar WHERE id = '".$mesaj_oku['ilan_id']."'");
    $ilan_oku = mysql_fetch_assoc($ilan_bul);
    $model_yili = $ilan_oku['model_yili'];
    $model = $ilan_oku['model'];
    $sehir = $ilan_oku['sehir'];
    $ilce = $ilan_oku['ilce'];
    $plaka = $ilan_oku['plaka'];
    $markasi = $ilan_oku['marka'];
    $marka_cek = mysql_query("SELECT * FROM marka WHERE markaID = '".$markasi."'");
    $marka_oku = mysql_fetch_assoc($marka_cek);
    $marka = $marka_oku['marka_adi'];
    $ID = $ilan_oku['id'];
    $chat_cek = mysql_query("SELECT * FROM mesajlar WHERE ilan_id = '".$ID."' ORDER BY gonderme_zamani ASC GROUP BY gonderen_token");
    $gonderen_bul = mysql_query("SELECT * FROM user WHERE id = '".$mesaj_oku['gonderen_id']."'");
    $gonderen_oku = mysql_fetch_assoc($gonderen_bul);
    $gonderen = $gonderen_oku['ad'];
    $telefon = $gonderen_oku['telefon'];
?>

<div class="accordion" id="accordion" style="margin-top: 2%; margin-bottom:-1% !important;">
  <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#a<?= $mesaj_oku['id'] ?>">
        <i class="fas fa-angle-down"> <?= $plaka." >>>> ". $model_yili." ".$marka." ".$model." /".$sehir." ".$ilce." >>>> ".$gonderen." ".$telefon ?></i>
      </a>
    </div>
    <div id="a<?= $mesaj_oku['id'] ?>" class="accordion-body collapse out">
      <div class="accordion">
      <?php while($chat_oku = mysql_fetch_array($chat_cek)){
        echo $chat_oku['gonderen_id'];
    ?>
        <div class="row-fluid" style="color:green;">
            <textarea name="gelen_mesaj" class="span12" rows="2" readonly style="background-color: white; color:red;"><?= $chat_oku['mesaj'] ?></textarea>
        </div>
        <?php } ?>
      </div>
    </div>
  </div>
</div>

<?php } ?>



