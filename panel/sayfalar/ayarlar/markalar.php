<?php 
session_start();
$marka_cek = mysql_query("SELECT * FROM marka");
?>

<div class="row-fluid" style="margin-top:2%;">
    <div class="span6">
    <a href="?modul=ayarlar&sayfa=marka_model">  <button type="button" style="background-color: rgb(88,103,221); color:white;" class="btn span12">Marka Ekle</button></a>
    </div>
    <div class="span6"></div>
</div>

<div class="row-fluid" style="margin-top:2%;">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Sıra</th>
                <th>Marka Adı</th>
                <th>Düzenle</th>
                <th>Sil</th>
            </tr>
        </thead>
        <tbody>
            <?php 
             $sayac = 1;
                while($marka_oku = mysql_fetch_array($marka_cek)){                   
                    $marka_id = $marka_oku['markaID'];
            ?>
            <tr>
                <td><?=$sayac++ ?></td>
                <td><?= $marka_oku['marka_adi'] ?></td>
                <td><a href="?modul=ayarlar&sayfa=marka_model&id=<?= $marka_id ?>"  style="text-decoration:none; color:black;"><i class="fas fa-edit"></i></a></td>
                <td><a href="?modul=ayarlar&sayfa=data_sil&id=<?= $marka_id ?>&q=marka_sil" onclick="return confirm('Silmek istediğinize emin misiniz ?')"><i style="color:black;" class="fas fa-trash"></i></a></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>