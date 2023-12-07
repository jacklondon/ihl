<?php 
include('../../../ayar.php');
$gelen_id = re('id');
if($gelen_id)
{
    $output .= '';
    $output .='
    <form method="POST">
    <div class="modal-body">
      <div class="row-fluid">
          <label for="IDofInput">Yayın Bitiş Tarihi</label>
          <input type="datetime-local" name="tarih_guncelle" id="tarih_guncelle" required class="span12">
          <input type="hidden" name="ilanin_id" id="ilanin_id" value="'.$gelen_id.'">
      </div>
    </div>
    <div class="modal-footer">
      <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
      <input type="submit" name="ihale_tarih_degisir" value="Kaydet" class="btn blue">
    </div>
    </form> 
    ';
    echo $output;
}

?>
