<?php

class miniBlog {
		private $IMAGEDIR;

		function __construct() {
			$this->IMAGEDIR = dirname(dirname(dirname(dirname(__FILE__)))).'/images/';
		}

		public function getPost($id) {
			$id = escape($id);
			$query = "SELECT * FROM miniblog_posts WHERE id = '".$id."'";
			$result = mysql_query($query);
			if (mysql_num_rows($result) > 0)
				return mysql_fetch_object($result);
			else
				return false;
		}

		public function getAll($type = 0) {
			$query = "SELECT * FROM miniblog_posts WHERE type = '".$type."' ORDER BY tarih DESC";
			$result = mysql_query($query);
			$data = array();
			while ($post = mysql_fetch_assoc($result)) {
				$data[] = $post;
			}
			return $data;
		}

		private function uploadImage($field) {
			$F = $_FILES[$field];
			$fileExt = pathinfo($F['name'],PATHINFO_EXTENSION);
			$rand = rand(100000,999999);
			$newFileName = "miniblog-".time().'-'.$rand.'.'.$fileExt;
			$fileTargetDir = $this->IMAGEDIR.$newFileName;
			$F['target'] = $fileTargetDir;
			if (move_uploaded_file($F['tmp_name'], $fileTargetDir)) {
				return $newFileName;
			}
			return false;
		}

		public function addPost($data,$existId = false) {
			if ($data['icerik'] == '')
				return false;
			if (!isset($data['type']))
				$data['type'] = '0';
			if ($existId == true)
				$fileName = $data['resim'];
			else
				$fileName = '';
			if ($filename == '') {
				if (count($_FILES['resim']) > 0) {
					$uploadResult = $this->uploadImage('resim');
					if ($uploadResult !== false)
						$fileName = $uploadResult;
				}
			}
			if ($existId === true)
				$id = $data['id'];
			else
				$id = '';
			$query = "INSERT INTO miniblog_posts (id,tarih,baslik,icerik,resim,type) VALUES (".($id == '' ? 'NULL':'\''.$id.'\'').",'".time()."','".escape($data['baslik'])."','".escape($data['icerik'])."','".$fileName."','".$data['type']."')";
			
			/*echo "<pre>";
			var_dump($query);
			die();*/
			$result = mysql_query($query);
			return $result;
		}

		public function delPost($id,$removeImage = true) {
			$post = $this->getPost($id);
			if ($post === false)
				return false;
			if (trim($post->resim) !== '') {
				$fileDir = $this->IMAGEDIR.$post->resim;
				if (file_exists($fileDir))
					if ($removeImage === true)
						unlink($fileDir);
			}
			$result = mysql_query("DELETE FROM miniblog_posts WHERE id = '".$post->id."'");
			return $result;
		}

		public function editPost($data) {
			$post = $this->getPost(escape($data['id']));
			$this->delPost($post->id,false);
			$data['resim'] = $post->resim;
			return $this->addPost($data,true);
		}
	}