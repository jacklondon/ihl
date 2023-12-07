<?php
    if(re('a') == "b"){
        $name = re('name');
        $link = re('link');
        $add_time = date('Y-m-d H:i:s');
        $sql = mysql_query("insert into yararli_linkler(name,link,add_time,status) values ('".$name."','".$link."','".$add_time."',1)");
        header('refresh: 1');
    }

    $cek = mysql_query("select * from yararli_linkler where status <> 2");
    $sira = 1;
    while($oku = mysql_fetch_object($cek)){
        if($oku->update_time == "0000-00-00 00:00:00"){
            $update_time = "--------";
        }else{
            $update_time = date("d-m-Y H:i:s", strtotime($oku->update_time));
        }

        $table .= '<tr>
            <td style="text-align: center;">'.$sira++.'</td>
            <td style="text-align: center;">'.$oku->name.'</td>
            <td style="text-align: center;">'.$oku->link.'</td>
            <td style="text-align: center;">'.date("d-m-Y H:i:s", strtotime($oku->add_time)).'</td>
            <td style="text-align: center;">'.$update_time.'</td>
            <td style="text-align: center;"><a class="btn green" href="?modul=ayarlar&sayfa=yararli_link_duzenle&q='.$oku->id.'"><i class="fas fa-edit"></i> Düzenle</a></td>
            <td style="text-align: center;">
            <a class="btn red" onclick="return confirm(\'Emin misiniz ?\')" href="?modul=data_sil&sayfa=sil&id='.$oku->id.'&q=yararli_linkler"><i class="fas fa-trash"></i> Sil</a>
            </td>
        </tr>';
    }

?>

<div class="row-fluid" style="margin-top:20px;">
    <div class="span12">
        <div class="portlet box blue">
            <div class="portlet-title">
                <h4><i class="icon-reorder"></i>Yararlı Link Ekle</h4>
            </div>
            <div class="portlet-body form">                    
                <form method="POST">
                    <div class="control-group span4">
                        <label class="control-label" for="inputEmail">Link Adı</label>
                        <div class="controls">
                        <input type="text" class="span12" required name="name" placeholder="Link Adı">
                        </div>
                    </div>
                    <div class="control-group span8">
                        <label class="control-label" for="inputEmail">Link Url</label>
                        <div class="controls">
                        <input type="text" class="span12" required name="link" placeholder="Link Url">
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="controls">
                        <button type="submit" name="a" value="b" class="btn blue">Yararlı Link Ekle</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
		

<div class="row-fluid" style="margin-top:20px;">
    <div class="span12">
        <div class="portlet box blue">
            <div class="portlet-title">
                <h4><i class="icon-reorder"></i>Yararlı Linkler</h4>
            </div>
            <div class="portlet-body form">                    
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th style="text-align: center;">#</th>
                        <th style="text-align: center;">Link Adı</th>
                        <th style="text-align: center;">Link Url</th>
                        <th style="text-align: center;">Ekleme Tarihi</th>
                        <th style="text-align: center;">Güncelleme Tarihi</th>
                        <th style="text-align: center;">Düzenle</th>
                        <th style="text-align: center;">Sil</th>
                    </tr>
                </thead>
                <tbody>
                    <?= $table ?>
                </tbody>
            </table>
            </div>
        </div>
    </div>
</div>
		






