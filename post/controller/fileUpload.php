<?php
	class fileUpload {

		private function processFiles($images, $target_dir, $path) {
			$filePaths = array();
			foreach($images["name"] as $key => $value) {
				$target_file = $target_dir . basename($images["name"][$key]);
				$uploadOk = true;
				$imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
				// Check if image file is a actual image or fake image
				if(isset($_POST["submit"])) {
				    $check = @getimagesize($images["tmp_name"][$key]);
				    if($check !== false) {
				        $uploadOk = true;
				    } else {
				        $uploadOk = false;
				    }
				}
				// Check file size
				if ($images["size"][$key] > 5000000) {
				    $uploadOk = false;
				}
				// Allow certain file formats
				if($imageFileType !== "jpg" && $imageFileType !== "png" && $imageFileType !== "jpeg" && $imageFileType !== "gif" ) {
				    $uploadOk = false;
				}
				if ($uploadOk === true) {
				    if (move_uploaded_file($images["tmp_name"][$key], $target_file)) {
				    	$relativePath = $path . $images["name"][$key];
				    	$filePaths[$key] = $relativePath;
				    }
				}
			}
			return $filePaths;
		}

		public function upload($portfolioName, $files) {
			$portfolioPath = __DIR__ . "/../../portfolios";
			if (!file_exists($portfolioPath)) {
				mkdir($portfolioPath);
			}
			$target_dir = $portfolioPath . "/" . $portfolioName;
			if (!file_exists($target_dir)) {
				mkdir($target_dir);
			}
			$target_dir = $target_dir . "/";
			$path = "/portfolios/" . $portfolioName . "/";
			return $this->processFiles($files, $target_dir, $path);
		}
	}
?>