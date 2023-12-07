<?php 
$gelen_id = re('id');
$cek = mysql_query("select * from yuklenen_evrak_dosya where evrak_id = '".$gelen_id."'");
$error = "";
$post = $_POST; 
$file_folder = "../assets/";
if(extension_loaded('zip')){ 
    $zip = new ZipArchive();
    $zip_name = time().".zip";
    if($zip->open($zip_name, ZIPARCHIVE::CREATE)!==TRUE){ 
        $error .= "* Sorry ZIP creation failed at this time";
    }
    while($oku = mysql_fetch_object($cek)){
        $zip->addFile($file_folder.$oku->icerik);
    }
    $zip->close();
    if(file_exists($zip_name)){
        header('Content-type: application/zip');
        header('Content-Disposition: attachment; filename="'.$zip_name.'"');
        readfile($zip_name);
        unlink($zip_name);
    }
}else{
    $error .= "* You dont have ZIP extension";
}
