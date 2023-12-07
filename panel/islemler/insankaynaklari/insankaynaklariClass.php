<?php

class insanKaynaklari {

	private $cvDirectory = "cv-gonderilen/";
	private $ikFields = array(
			"ad",
			"soyad",
			"dogum_yeri",
			"dogum_tarihi",
			"mail",
			"cinsiyet",
			"uyruk",
			"tc_no",
			"medeni_durum",
			"kan_grubu",
			"adres",
			"baba_adi",
			"baba_meslek",
			"ana_adi",
			"ana_meslek",
			"es_adi",
			"es_meslek",
			"es_isadres",
			"es_gorev",
			"acil_durum_sahsi",
			"cocuk_sayisi",
			"cocuk_yaslari",
			"emekli_tahsis_no",
			"askerlik_durum",
			"ehliyet",
			"sigara_kullanimi",
			"bedensel_engel",
			"calisma_durum",
			"bizimle_calisan_akraba",
			"sabika_kaydi",
			"davaniz_varmi",
			"iskur_kaydi",
			"tel_ev",
			"tel_gsm",
			"ilkogretim_okul",
			"ilkogretim_bas_bit",
			"lise_okul",
			"lise_bas_bit",
			"unv_okul",
			"unv_bas_bit",
			"master_okul",
			"master_bas_bit",
			"is_adi",
			"is_gorev",
			"is_giris_cikis",
			"is_yetkili",
			"is_telefon",
			"referans_adi",
			"referans_gorev",
			"referans_tel",
			"referans_tanima_suresi",
			"cv",
			"tarih",
			"aciklama",
			"ucret_talep",
			"pozisyon"
		);
	private $chars = array('q','w','e','r','t','y','u','o','p','i','l','k','j','h','g','f','d','s','a','z','x','c','v','b','n','m','-','0','1','2','3','4','5','6','7','8','9');
	private $allowedExt = array('JPG','BMP','DOC','DOCX','XLS','XLSX','PNG','TIFF','JPEG');

	private function convertJSONFields($data,$fields) {
		foreach ($fields as $field) {
			$jsonOutput = '';
			$arrayOutput = array();
			foreach ($data[$field] as $idx => $inpVal) {
				$arrayOutput[] = escape($inpVal);
			}
			$jsonOutput = json_encode($arrayOutput);
			$data[$field] = $jsonOutput;
		}
		return $data;
	}

	private function convertKeyToVal($data) {
		$keys = array();
		$vals = array();
		foreach ($data as $key => $val) {
			$keys[] = $key;
			$vals[] = $val;
		}
		$keys = implode(',',$keys);
		$vals = "'".implode("','",$vals)."'";
		return array('keys'=>$keys,'vals'=>$vals);
	}

	public function filterFields($data) {
		$newData = array();
		foreach ($data as $key => $val) {
			foreach ($this->ikFields as $ikf) {
				if ($key == $ikf) { // Eğer gönderilen veri , kabul edilen fieldların içerisinde ise
					if (is_string($val))
						$newData[$key] = escape($val);
				}
			}
		}
		return $newData;
	}

	private function randName() {
		$rand = '';
		$rand .= time().'-';
		for ($i=0; $i<10; $i++)
			$rand .= $this->chars[rand(0,count($this->chars)-1)];
		return $rand;
	}

	private function checkExt($ext) {
		$return = false;
		foreach ($this->allowedExt as $allow) {
			if ($allow == strtoupper($ext))
				$return = true;
		}
		return $return;
	}

	private function uploadCV($filesKey) {
		$file = $_FILES[$filesKey];
		$fileName = $file['name'];
		$fileExt = pathinfo($fileName,PATHINFO_EXTENSION);
		if ($this->checkExt($fileExt) == false)
			return ''; // RETURN IF UPLOAD UNALLOWED EXTENSION
		do {
			$newFilename = $this->randName().'.'.$fileExt;
		} while (file_exists($this->cvDirectory.$newFilename));
		if (move_uploaded_file($file['tmp_name'], $this->cvDirectory.$newFilename)) {
			return $newFilename;
		}
		return '';
	}

	private function insertDB($stringData) {
		$query = "INSERT INTO ik_basvuru_2 (".$stringData['keys'].") VALUES (".$stringData['vals'].")";
		$result = mysql_query($query);
		return $result;
	}

	public function add($data) {
		$cv = '';
		if (isset($_FILES['cv']))
			if ($_FILES['cv']['name'] != '')
				$cv = $this->uploadCV('cv');
		$data = $this->convertJSONFields($data,array('is_adi','is_gorev','is_giris_cikis','is_yetkili','is_telefon','referans_adi','referans_gorev','referans_tel','referans_tanima_suresi'));
		$data = $this->filterFields($data);
		$data['tarih'] = time();
		$stringData = $this->convertKeyToVal($data);
		if ($this->insertDB($stringData))
			return true;
		return false;
	}

	public function getAll() {
		$query = "SELECT *,UPPER(CONCAT(ad,' ',soyad)) AS tamad FROM ik_basvuru_2";
		$result = mysql_query($query);
		//var_dump(mysql_fetch_object($result));
		$out = new stdClass();
		if (mysql_num_rows($result) > 0) {
			while ($item = mysql_fetch_object($result)) {
				$key = 'item'.$item->id;
				$out->$key = $item;
			}
			return $out;
		}
		else
			return false;
	}

	public function get($id) {
		$id = escape($id);
		$query = "SELECT *,UPPER(CONCAT(ad,' ',soyad)) AS tamad FROM ik_basvuru_2 WHERE id = '".$id."'";
		$result = mysql_query($query);
		if (mysql_num_rows($result) > 0) {
			$out = mysql_fetch_object($result);
		}
		else {
			$out = false;
		}
		return $out;
	}

	public function convertJSONtoArray($data,$keys) {
		$out = array();
		foreach ($keys as $key) {
			$json = $data->$key;
			$out[$key] = json_decode($json);
		}
		$found = 0;
		for($i=0; $i<count($out); $i++) {
			$itemCount = 0;
			foreach ($keys as $key) {
				$itemCount++;
				if ($out[$key][$i] == '')
					$found++;
			}
			if ($found == $itemCount) {
				foreach ($keys as $key) {
					unset($out[$key][$i]);
					$found = 0;
				}
			}
		}
		return $out;
	}


}

$ik = new insanKaynaklari();