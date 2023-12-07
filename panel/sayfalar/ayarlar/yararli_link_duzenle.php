<?php
    $gelen_id = re('q');
    if(re('a') == "b"){
        $name = re('name');
        $link = re('link');
        $update_time = date('Y-m-d H:i:s');
        $sql = mysql_query("update yararli_linkler set name = '".$name."', link = '".$link."', update_time = '".$update_time."' where id = '".$gelen_id."'");
        header('refresh: 1');
    }

    $cek = mysql_query("select * from yararli_linkler where id = '".$gelen_id."'");
    $oku = mysql_fetch_object($cek);
?>

<div class="row-fluid" style="margin-top:20px;">
    <div class="span12">
        <div class="portlet box blue">
            <div class="portlet-title">
                <h4><i class="icon-reorder"></i>Yararlı Link Düzenle</h4>
            </div>
            <div class="portlet-body form">                    
                <form method="POST">
                    <div class="control-group span4">
                        <label class="control-label" for="inputEmail">Link Adı</label>
                        <div class="controls">
                        <input type="text" class="span12" required name="name" placeholder="Link Adı" value="<?= $oku->name ?>">
                        </div>
                    </div>
                    <div class="control-group span8">
                        <label class="control-label" for="inputEmail">Link Url</label>
                        <div class="controls">
                        <input type="text" class="span12" required name="link" placeholder="Link Url" value="<?= $oku->link ?>">
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="controls">
                        <button type="submit" name="a" value="b" class="btn blue">Yararlı Link Güncelle</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
		


		






