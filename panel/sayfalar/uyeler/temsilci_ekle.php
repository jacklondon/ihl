<?php 
session_start();
$admin_id=$_SESSION['kid'];
$gelen_id = re('id');
$kullanici_cek = mysql_query("SELECT * FROM user WHERE id= '".$gelen_id."'");
$admin_cek = mysql_query("SELECT * FROM kullanicilar");
?>
<form method="POST" style="margin-top: 5%;">
<?php include 'islemler/uyeler/temsilci_ekle.php'; ?>
    <div class="row-fluid">
        <?php while($uye_oku = mysql_fetch_array($kullanici_cek)){ ?>
        <label for="IDofInput">Üye Adı Soyadı</label>     
        <input type="text" readonly class="span6" value="<?= $uye_oku['ad'] ?>">   
        <label for="IDofInput">Telefon Numarası</label>
        <input type="text" name="telefonu" class="span6" readonly value="<?= $uye_oku['telefon'] ?>">
        <?php } ?>
        <label for="IDofInput">Yetkili Seçin</label>
        <select name="temsilci" id="temsilci" class="span6">
            <option value="">Temsilci Seçin</option>
            <?php while($admin_oku = mysql_fetch_array($admin_cek)){ ?>
            <option value="<?= $admin_oku['id'] ?>"><?= $admin_oku['adi'] ?></option>
            <?php } ?>
        </select>
    </div>
    <div class="form-actions">
        <input type="submit" name="temsilciyi" class="btn blue" value="Kaydet" />
    </div>
</form>
