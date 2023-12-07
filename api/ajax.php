<?php 
include_once '../ayar.php';
header("Content-Type: application/json");
$response = [];
$statusCode = 404;
?>

<?php 

    function select_sql($table_name, $query = null)
    {
        $deneme = array();
        $select = mysql_query("SELECT `COLUMN_NAME` 
            FROM `INFORMATION_SCHEMA`.`COLUMNS` 
            WHERE `TABLE_SCHEMA`='pert_dunyasi' 
                AND `TABLE_NAME`='" . $table_name . "' ");

        while ($veri_cek = mysql_fetch_array($select))
        {
            array_push($deneme, $veri_cek["COLUMN_NAME"]);
        }

        if ($query != null)
        {
            $status_query = " WHERE " . $query;
        }

        $counter = 0;
        $listingMap = array();
        $select2 = mysql_query("SELECT * FROM " . $table_name . $status_query);
        while ($veri_cek2 = mysql_fetch_array($select2))
        {
            for ($i = 0;$i < count($deneme);$i++)
            {
                $listingMap[$counter][$deneme[$i]] = $veri_cek2[$deneme[$i]];
            }

            $counter++;
        }

        return $listingMap;
    }

    function uye_id_getir($user_token){
        if($user_token != ""){
            $cek = mysql_query("select * from user where user_token = '".$user_token."'");
            if(mysql_num_rows($cek) != 0){
                $oku = mysql_fetch_object($cek);
                return $oku->id;
            }else{
                $cek2 = mysql_query("select * from user where kurumsal_user_token = '".$user_token."'");
                if(mysql_num_rows($cek2) != 0){
                    $oku2 = mysql_fetch_object($cek2);
                    return $oku2->id;
                }else{
                    return 0;
                }
            }
        }else{
            return 0;
        }        
    }
    
    function uye_paket_getir($uye_id){
        if($uye_id == 0){
            return 2;
        }else{
            return select_sql("user","id = '".$uye_id."'")[0]["paket"];
        }
    }


    /*
    function ilan_liste_durum($ilan_id){

    }
    function ihaledeki_ilanlar($user_token=""){
        $date_time = date('Y-m-d H:i:s');
        $uye_id = uye_id_getir($user_token);
        $paket = uye_paket_getir($uye_id);
        $cek = mysql_query("select *,CONCAT(`ihale_tarihi`, ' ', `ihale_saati`) as bitis_tarihi from ilanlar where durum = 1");
        while($oku = mysql_fetch_object($cek)){
            $sigorta = $oku->sigorta;
            $sigorta_yetkisi = select_sql("sigortalar","sigorta_id = '".$sigorta."' and paket_id = '".$paket."'");
            if($sigorta_yetkisi[0]["secilen_yetki_id"] == 2 || $sigorta_yetkisi["secilen_yetki_id"] == 3){
                $detay_gorme = $sigorta_yetkisi[0]["detay_gorur"];
                if($oku->bitis_tarihi > $date_time){
                    $listeleme = 1;
                }else{
                    $listeleme = ilan_liste_durum($oku->id);
                }

            }
        }
    }
    */

    function ilan_fav_durum($ilan_id,$uye_id){
        $cek = mysql_query("select * from favoriler where uye_id = '".$uye_id."' and ilan_id = '".$ilan_id."'");
        if(mysql_num_rows($cek) == 0){
            $listingMap[] = [
                "color" => "gray",
                "title" => "Araç favorilerinize eklenecektir"
            ];
        }else{
            $listingMap[] = [
                "color" => "orange",
                "title" => "Araç favorilerinizden kaldırılacaktır"
            ];
        }
    }

    function ilan_bildirim_durum($ilan_id,$uye_id){
        $cek = mysql_query("select * from bildirimler where uye_id = '".$uye_id."' and ilan_id = '".$ilan_id."'");
        if(mysql_num_rows($cek) == 0){
            $listingMap[] = [
                "color" => "gray",
                "title" => "Araç bildirimi açılacaktır."
            ];
        }else{
            $listingMap[] = [
                "color" => "orange",
                "title" => "Araç bildirimi kapatılacaktır."
            ];
        }
    }

    function ihaledeki_ilanlar($user_token,$offset,$sayfada){
        $cek = mysql_query("
            SELECT 
                *,
                concat(ihale_tarihi,' ',ihale_saati) as ihale_son 
            FROM 
                ilanlar 
            WHERE 
                durum = 1
            ORDER BY ihale_son ASC 
                LIMIT $offset, $sayfada
        ");
        $uye_id = uye_id_getir($user_token);
        while($oku = mysql_fetch_object($cek)){
            $fav_durum = ilan_fav_durum($oku->id,$uye_id);
            $bildirim_durum = ilan_bildirim_durum($oku->id,$uye_id);
        }
    }

?>

