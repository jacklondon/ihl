
<form method="post" style="margin-top: 150px;">
<div class="row-fluid">
    <div class="span6">
        <input type="time" name="saat">
    </div>
    <div class="span6">
        <input type="submit" class="btn-primary" name="deneme" value="kaydet">
    </div>
</div>
</form>

<?php 
if(re('deneme')=="kaydet"){
    mysql_query("update ilanlar set ihale_saati = '".re('saat')."' where id = 305");
}
?>