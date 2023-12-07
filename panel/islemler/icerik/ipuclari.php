<?php
	// İP UÇLARI ACTION PAGE
	class ipUclari {

		public function getAll() {
			$query = "SELECT * FROM ip_uclari ORDER BY id DESC";
			$result = mysql_query($query);
			$data = array();
			if (mysql_num_rows($result) == 0)
				return false;
			while ($iu = mysql_fetch_object($result)) {
				$data[] = $iu;
			}
			return $data;
		}

		public function get($id) {
			$id = escape($id);
			$query = "SELECT * FROM ip_uclari WHERE id = '".$id."'";
			$result = mysql_query($query);
			if (mysql_num_rows($result) == 0)
				return false;
			$iu = mysql_fetch_object($result);
			return $iu;
		}

		public function add($data) {
			foreach ($data as $key => $val)
				$data[$key] = escape($val);
			$newData = array();
			$newData['baslik'] = $data['baslik'];
			$newData['icerik'] = $data['icerik'];
			$keys = implode(',', $keys);
			$vals = "'".implode("','", $vals)."'";
			$q = "INSERT INTO ip_uclari (baslik,icerik) VALUES ('".$newData['baslik']."','".$newData['icerik']."')";
			$r = mysql_query($q);
			return $r;
		}

		public function delete($id) {
			$id = escape($id);
			return mysql_query("DELETE FROM ip_uclari WHERE id = '".$id."'");
		}

		public function edit($data) {
			foreach ($data as $key => $val) {
				$data[$key] = escape($val);
			}
			$newData = array();
			$newData['baslik'] = $data['baslik'];
			$newData['icerik'] = $data['icerik'];
			$id = $data['id'];
			$query = "UPDATE ip_uclari SET baslik = '".$newData['baslik']."', icerik = '".$newData['icerik']."' WHERE id = '".$id."'";
			return mysql_query($query);
		}
	}

	$iu = new ipUclari();



	if (isset($_GET['id'])) {
		if ($_GET['id'] == '0') {
			$action = 'ADD';
		}
		else {
			if (isset($_GET['sil'])) {
				$iu->delete($_GET['sil']);
				header('Location: sistem.php?modul=icerik&sayfa=ipuclari');
			} else {
				$action = 'EDIT';
				$post = $iu->get($_GET['id']);
				if ($post === false)
					header('Location: sistem.php?modul=icerik&sayfa=ipuclari');
			}
		}
	} else {
		$action = 'LIST';
		$posts = $iu->getAll();
	}

	if (isset($_POST['action'])) {
		switch ($_POST['action']) {
			case 'add':
				$iu->add($_POST);
			break;
			case 'edit':
				$iu->edit($_POST);
				header('Location: sistem.php?modul=icerik&sayfa=ipuclari');
			break;
			
			default:
				# code...
			break;
		}
	}