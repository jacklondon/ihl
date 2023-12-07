

<div class="row-fluid" style="margin-top:2%;">
<a href="?modul=ayarlar&sayfa=marka_model" type="submit" class="btn span4" style="background-color: rgb(88,103,221); color:white; text-decoration:none;">Modelleri Gör</a>
</div>
<form method="POST" name="form" id="form">
    <?php include 'islemler/ayarlar/model_ekle.php'; ?>
<div class="row-fluid" style="margin-top: 2%;">
<div class="span6">
    <label for="model">Model Adı</label>
    <input type="text" name="model_adi" class="span12" required>
    </div>
    <div class="span6">
    <?php $marka_cek = mysql_query("SELECT * FROM marka ORDER BY marka_adi ASC"); ?>
    <label for="marka">Marka</label>
    <select name="marka" id="marka" class="span12" required>
        <option value="">Marka Seçiniz</option>
        <?php while($marka_oku = mysql_fetch_array($marka_cek)){ ?>
        <option value="<?= $marka_oku['markaID'] ?>"><?= $marka_oku['marka_adi'] ?></option>
        <?php } ?>
    </select>
    </div>
</div>
<div class="row-fluid">
    <input type="submit" class="btn-primary span4" name="modeli" value="Ekle">   
</div>
</form>