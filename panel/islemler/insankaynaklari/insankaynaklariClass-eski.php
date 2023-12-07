<?php

class insanKaynaklari {

	private $ikFields = array(
			"ad",
			"soyad",
			"telefon",
			"mail",
			"dogum_tarihi",
			"cinsiyet",
			"uyruk",
			"ehliyet",
			"medeni_hal",
			"engelli_durumu",
			"egitim_durumu",
			"egitim_seviyesi",
			"is_toplam_tecrube",
			"calisma_durumu",
			"aciklama",
			"pozisyon",
			"ucret_talebi"
		);

	public function _styleForm($form) {
		$pozisyon = array(
			1 => "Mağaza Görevlisi",
			2 => "Depo -&gt; Şoför",
			3 => "Depo -&gt; Araç bakımcı",
			4 => "Depo -&gt; Diğer",
			5 => "Mali İşler -&gt; Muhasebe",
			6 => "Mali İşler -&gt; Finans",
			7 => "Mali İşler -&gt; Personel",
			8 => "Mali İşler -&gt; İdari İşler",
			9 => "Satın Alma",
			10 => "Bilişim Sistemleri – Bilgi İşlem",
			11 => "Diğer Pozisyonlar"
		);
		$egitimSeviye = array(
			"io" => "İlkokul",
			"oo" => "Ortaokul",
			"li" => "Lise",
			"ls" => "Lisans",
			"yls" => "Yüksek Lisans"
		);
		$form->cinsiyet 			= ($form->cinsiyet == 'E' ? 'Bay':'Bayan');
		$form->uyruk 				= ($form->uyruk == 'TC' ? 'Türkiye Cumhuriyeti':'Diğer');
		$form->ehliyet 				= ($form->ehliyet == 'V' ? 'Var':'Yok');
		$form->medeni_hal 			= ($form->medeni_hal == 'E' ? 'Evli':'Bekar');
		$form->engelli_durumu 		= ($form->engelli_durumu == 'V' ? 'Engelli':'Değil');
		$form->egitim_durumu 		= ($form->egitim_durumu == 'M' ? 'Mezun':($form->egitim_durumu == 'D' ? 'Devam Ediyor':'Terk'));
		$form->egitim_seviyesi		= $egitimSeviye[$form->egitim_seviyesi];
		$form->calisma_durumu 		= ($form->calisma_durumu == 'E' ? 'Çalışıyor':'Çalışmıyor');
		$form->tarih 				= date('d.m.Y H:i',$form->tarih);
		$form->egitim 				= $form->egitim_seviyesi.' - '.$form->egitim_durumu;
		$form->aciklama 			= strip_tags($form->aciklama);
		$form->pozisyon 			= $pozisyon[$form->pozisyon];
		return $form;
	}

	public function getAll() {
		$query = "SELECT *, UPPER(CONCAT(ad,' ',soyad)) AS tamad FROM ik_basvuru ORDER BY tarih DESC";
		$result = mysql_query($query);
		$output = array();
		if (mysql_num_rows($result) == 0)
			return false;
		while ($form = mysql_fetch_object($result)) {
			$output[] = $this->_styleForm($form);
		}
		return $output;
	}

	public function get($id) {
		$query = "SELECT *, UPPER(CONCAT(ad,' ',soyad)) AS tamad FROM ik_basvuru WHERE id = '".$id."' ORDER BY id DESC";
		$result = mysql_query($query);
		if (mysql_num_rows($result) == 0)
			return false;
		$form = mysql_fetch_object($result);
		return $this->_styleForm($form);
	}

	public function add($data) {
		$keys = array();
		$vals = array();
		foreach ($data as $key => $val) {
			$check = false;
			for($i=0; $i<count($this->ikFields); $i++) {
				if ($this->ikFields[$i] == $key)
					$check = true;
			}
			if ($check === true) {
				$keys[] = $key;
				$vals[] = escape($val);
			}
		}
		$keys[] = 'tarih';
		$vals[] = time();

		$keys = implode(',',$keys);
		$vals = "'".implode("','",$vals)."'";
		$query = "INSERT INTO ik_basvuru ($keys) VALUES ($vals)";
		$result = mysql_query($query);
		return $result;
	}
}

$ik = new insanKaynaklari();