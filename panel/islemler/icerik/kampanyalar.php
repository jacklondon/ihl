<?php
	// KAMPANYALAR İŞLEM ---
	

	/**
	* Kampanyalar Mini Class
	*/
	class Kampanyalar {
		
		private $IMAGEDIR;

		function __construct() {
			$this->IMAGEDIR = dirname(dirname(dirname(dirname(__FILE__)))).'/images/';
		}

		public function getAll() {
			$query = "SELECT * FROM kampanyalar ORDER BY id DESC";
			$result = mysql_query($query);
			$data = array();
			while($kamp = mysql_fetch_object($result)) {
				$images = $this->getImages($kamp->id);
				$kamp->imgCount = 0;
				if ($images != false) {
					$kamp->imgCount = count($images);
					$kamp->images = $images;
				}
				$data[] = $kamp;
			}
			return $data;
		}

		public function getKamp($id) {
			$id = escape($id);
			$query = "SELECT * FROM kampanyalar WHERE id = '".$id."'";
			$result = mysql_query($query);
			$return = mysql_fetch_object($result);
			if (mysql_num_rows($result) > 0)
				return $return;
			else
				return false;
		}

		private function uploadImage($field) {
			$F = $_FILES[$field];
			$fileExt = pathinfo($F['name'],PATHINFO_EXTENSION);
			$rand = rand(100000,999999);
			$newFileName = "kampanya-".time().'-'.$rand.'.'.$fileExt;
			$fileTargetDir = $this->IMAGEDIR.$newFileName;
			$F['target'] = $fileTargetDir;
			if (move_uploaded_file($F['tmp_name'], $fileTargetDir)) {
				return $newFileName;
			}
			return false;
		}

		public function getImages($id) {
			$query = "SELECT * FROM kampanyalar_resimler WHERE id = '".$id."'";
			$result = mysql_query($query);
			$data = array();
			if (mysql_num_rows($result) == 0)
				return false;
			while ($img = mysql_fetch_object($result)) {
				$data[] = $img;
			}
			return $data;
		}

		public function add($data,$exId = false) {
			if (!isset($data['baslik']) || !isset($data['icerik']))
				return false;
			foreach ($data as $idx => $val)
				$data[$idx] = escape($val);
			$newData = array(
				"baslik" => $data['baslik'],
				"icerik" => $data['icerik']
			);
			if ($exId === false)
				$query = "INSERT INTO kampanyalar (baslik,icerik) VALUES ('".$newData['baslik']."','".$newData['icerik']."')";
			else
				$query = "INSERT INTO kampanyalar (id,baslik,icerik) VALUES ('".$data['id']."','".$newData['baslik']."','".$newData['icerik']."')";
			$result = mysql_query($query);
			if ($exId === false)
				$insertId = mysql_insert_id();
			else
				$insertId = $data['id'];

			// IMAGE UPLAOD EVENT
			$image = '';
			if (isset($_FILES['resim'])) {
				if ($_FILES['resim']['name'] != '') {
					$image = $this->uploadImage('resim');
					$query = "INSERT INTO kampanyalar_resimler (resim,kampanya_id) VALUES ('".$image."','".$insertId."')";
					$imgResult = mysql_query($query);
				}
			}
			// IMAGE UPLAOD EVENT

			return $result;
		}

		public function delete($id) {
			$id = escape($id);
			$query = "DELETE FROM kampanyalar WHERE id = '".$id."'";
			$result = mysql_query($query);
			$query2 = "DELETE FROM kampanyalar_resimler WHERE kampanya_id = '".$id."'";
			$result2 = mysql_query($query2);
			return $result;
		}

		public function edit($data) {
			if (!isset($data['id'])) 
				return false;
			else
				if ($data['id'] == '')
					return false;
			$this->delete($data['id']);
			$this->add($data,true);
			return true;
		}
	}

	$kampanyalar = new Kampanyalar();