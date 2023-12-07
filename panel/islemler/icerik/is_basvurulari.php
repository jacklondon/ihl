<?php

class IsBasvuruYonetim
{
	public $is_basvurulari_query;
	
	function __construct()
	{
		$this->is_basvurulari_query = mysql_query("SELECT * FROM ik_basvuru");
	}
	public function basvurulariGetir()
	{
		while ($basvuru = mysql_fetch_object($this->is_basvurulari_query)) {
			echo "<tr>";
			echo "<td>". $basvuru->ad ."</td>";
			echo "<td>". $basvuru->soyad ."</td>";
			echo "<td>". date('d.m.Y H:i',$basvuru->tarih) ."</td>";
			echo '<td><a href="?modul=icerik&sayfa=is_basvurulari&sil='.$basvuru->id.'" onclick="return confirm(\'Silmek İstediğinize Eminmisiniz ?\')" class="btn mini red"><i class="icon-trash"></i> Sil</a> <a href="basvuru.php?id='.$basvuru->id.'">Göster</a> <td>';
			echo "<tr>";
		}
	}
	public function basvuruGetir($basvuru){

	}
	public function basvurusil($id){
		$id = mysql_real_escape_string($id);
		$query = mysql_query("DELETE FROM ik_basvuru WHERE id = '$id'");
		header("Refresh:0");
	}
}

?>