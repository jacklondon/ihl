<?php

/**
* İnsan Kaynakları
*/
class InsanKaynaklari {

	private $BASVURU_ID;

	private function _addSql($table,$data) {
		$keys = array();
		$values = array();
		foreach ($data as $key => $val) {
			$keys[] = $key;
			$values[] = $val;
		}
		$keysString 	= implode(',', $keys);
		$valuesString 	= "'".implode("','", $values)."'";
		$query 			= "INSERT INTO $table ($keysString) VALUES ($valuesString)";
		$result			= mysql_query($query);
		return $result;
	}

	private function _clear($data) {
		$newData = array();
		foreach ($data as $idx => $val) {
			if (is_string($val) || is_integer($val) || is_bool($val))
				$newData[$idx] = escape($val);
			if (is_array($val))
				$newData[$idx] = $this->_clear($val);
		}
		return $newData;
	}

	public function addBasvuru($data) {
		$data = $this->_clear($data);
		$newData = array();
		$newData['adi'] 							= $data['adi'];
		$newData['soyadi'] 							= $data['soyadi'];
		$newData['dogum_yeri'] 						= $data['dogum_yeri'];
		$newData['dogum_tarihi'] 					= $data['dogum_tarihi'];
		$newData['cinsiyet']	 					= $data['cinsiyet'];
		$newData['medeni_durum'] 					= $data['medeni_durum'];
		$newData['adres'] 							= $data['adres'];
		$newData['mail'] 							= $data['mail'];
		$newData['ehliyet'] 						= $data['ehliyet'];
		$newData['ecyp'] 							= $data['ecyp'];
		$newData['cocuklar'] 						= $data['cocuklar'];
		$newData['kardesler'] 						= $data['kardesler'];
		$newData['anne_baba_meslek'] 				= $data['anne_baba_meslek'];
		$newData['askerlik'] 						= $data['askerlik'];
		$newData['telefon_sabit'] 					= $data['telefon_sabit'];
		$newData['telefon_is'] 						= $data['telefon_is'];
		$newData['telefon_gsm'] 					= $data['telefon_gsm'];
		$newData['seyahat_engeli'] 					= $data['seyahat_engeli'];
		$newData['son_is_yeri_ucret_sosyal_olanak'] = $data['son_is_yeri_ucret_sosyal_olanak'];
		$newData['ucret_talep'] 					= $data['ucret_talep'];

		if ($newData['adi'] == '' || $newData['soyadi'] == '' || $newData['dogum_yeri'] == '' || $newData['dogum_tarihi'] == '' || $newData['cinsiyet'] == '' || $newData['medeni_durum'] == '' || $newData['adres'] == '' || $newData['ehliyet'] == '' || $newData['askerlik'] == '' || $newData['seyahat_engeli'] == '' || $newData['ucret_talep'] == '')
		return false;

		$sendDatabaseArray = array($newData);

		if ($this->_addSql('ik_basvuru',$sendDatabaseArray) == true) {
			$this->BASVURU_ID = mysql_insert_id();

			$this->addReferans($data['referanslar']);
			$this->addBilgisayar($data['bilgisayar']);
			$this->addDil($data['yabancidil']);
			$this->addSeminerKurs($data['seminerkurs']);
			$this->addIsStaj($data['isstaj']);
			$this->addEgitim($data['egitim']);

			return true;
		}
		return false;
	}

	private function addReferans($data) {
		foreach ($data as $idx => $referans) {
			$newData = array();
			$newData['sirket']		= $referans['sirket'];
			$newData['yetkili']		= $referans['yetkili'];
			$newData['pozisyon']	= $referans['pozisyon'];
			$newData['telefon']		= $referans['telefon'];
			$newData['referans_id'] = $this->BASVURU_ID;
			
			if ($newData['sirket'] == '' || $newData['yetkili'] == '' || $newData['pozisyon'] == '' || $newData['telefon'] == '' || $newData['referans_id'] == '')
				continue;
			else
				$this->_addSql('ik_referanslar',$newData);
		}
		return true;
	}

	private function addBilgisayar($data) {
		foreach ($data as $idx => $bilgisayar) {
			$newData = array();
			$newData['tip']			= $bilgisayar['tip'];
			$newData['derece']		= $bilgisayar['derece'];
			$newData['aciklama']	= $bilgisayar['aciklama'];
			$newData['referans_id'] = $this->BASVURU_ID;
			
			if ($newData['tip'] == '' || $newData['derece'] == '' || $newData['referans_id'] == '')
				continue;
			else
				$this->_addSql('ik_bilgisayar',$newData);
		}
		return true;
	}

	private function addDil($data) {
		foreach ($data as $idx => $yabanciDil) {
			$newData = array();
			$newData['dil']			= $yabanciDil['dil'];
			$newData['yer']			= $yabanciDil['yer'];
			$newData['sure']		= $yabanciDil['sure'];
			$newData['derece']		= $yabanciDil['derece'];
			$newData['referans_id'] = $this->BASVURU_ID;
			
			if ($newData['dil'] == '' || $newData['yer'] == '' || $newData['sure'] == '' || $newData['derece'] == '')
				continue;
			else
				$this->_addSql('ik_yabancidil',$newData);
		}
		return true;
	}

	private function addSeminerKurs($data) {
		foreach ($data as $idx => $seminerKurs) {
			$newData = array();
			$newData['adi']			= $seminerKurs['adi'];
			$newData['yeri']		= $seminerKurs['yeri'];
			$newData['suresi']		= $seminerKurs['suresi'];
			$newData['referans_id'] = $this->BASVURU_ID;
			
			if ($newData['adi'] == '' || $newData['yeri'] == '' || $newData['suresi'] == '')
				continue;
			else
				$this->_addSql('ik_seminerkurs',$newData);
		}
		return true;
	}

	private function addIsStaj($data) {
		foreach ($data as $idx => $isStaj) {
			$newData = array();
			$newData['tip']			= $isStaj['tip'];
			$newData['sirket']		= $isStaj['sirket'];
			$newData['bolum_gorev']	= $isStaj['bolum_gorev'];
			$newData['giris']		= $isStaj['giris'];
			$newData['ayrilis']		= $isStaj['ayrilis'];
			$newData['nedeni']		= $isStaj['nedeni'];
			$newData['referans_id'] = $this->BASVURU_ID;
			
			if ($newData['tip'] == '' || $newData['sirket'] == '' || $newData['bolum_gorev'] == '' || $newData['giris'] == '' || $newData['ayrilis'] == '' || $newData['nedeni'] == '')
				continue;
			else
				$this->_addSql('ik_staj_is',$newData);
		}
		return true;
	}

	private function addEgitim($data) {
		foreach ($data as $idx => $egitim) {
			$newData = array();
			$newData['egitim']			= $egitim['egitim'];
			$newData['okul']			= $egitim['okul'];
			$newData['bolum']			= $egitim['bolum'];
			$newData['giris_yil']		= $egitim['giris_yil'];
			$newData['mezuniyet_yil']	= $egitim['mezuniyet_yil'];
			$newData['referans_id'] 	= $this->BASVURU_ID;
			
			if ($newData['egitim'] == '' || $newData['okul'] == '' || $newData['bolum'] == '' || $newData['giris_yil'] == '' || $newData['mezuniyet_yil'] == '')
				continue;
			else
				$this->_addSql('ik_egitim',$newData);
		}
		return true;
	}
}