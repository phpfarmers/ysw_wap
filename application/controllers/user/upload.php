<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Upload extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		if (!$this->is_login())
		{
			@session_start();
			$_SESSION['redirect'] = $_SERVER['REQUEST_URI'];
			redirect(site_url('prompt'), 'refresh');
		}
		$this->load->library('image_lib');
	}

	public function img()
	{
		$module = $this->uri->segment(4);
		$array = array('user','product','article','task');
		$module = $module && in_array($module,$array)?$module:'product';
		$this->_img($module);
	}

	public function preview()
	{
		$this->_preview();
	}

	/**
	 *
	 *
	 */
	protected function _img($module='product')
	{
		$datedirtime = $this->uri->segment(5)?$this->uri->segment(5):time();
		$product_uuid = $this->uri->segment(6)?$this->uri->segment(6):'';
		$datedirname = date('Y-m-d',$datedirtime);
		// Support CORS
		// header("Access-Control-Allow-Origin: *");
		// other CORS headers if any...
		if ($this->input->server('REQUEST_METHOD') == 'OPTIONS') {
			exit; // finish preflight CORS requests here
		}


		if ( $this->input->get_post('debug') ) 
		{
			$random = rand(0, intval($this->input->get_post( 'debug' )) );
			if ( $random === 0 )
			{
				header("HTTP/1.0 500 Internal Server Error");
				exit;
			}
		}

		// header("HTTP/1.0 500 Internal Server Error");
		// exit;


		// 5 minutes execution time
		@set_time_limit(5 * 60);

		// Uncomment this one to fake upload time
		usleep(5000);

		// Settings
		//$targetDir = ini_get("upload_tmp_dir") . DIRECTORY_SEPARATOR . "plupload";die($targetDir);
		//$targetDir = ini_get("upload_tmp_dir") . DIRECTORY_SEPARATOR . "tmp/plupload";
		$targetDir = 'upload_tmp';
		$uploadDir = RESPATH."/uploadfile/image/".$datedirname;
		$cleanupTargetDir = true; // Remove old files
		$maxFileAge = 5 * 3600; // Temp file age in seconds


		// Create target dir
		if (!file_exists($targetDir)) {
			@mkdir($targetDir,0777);
		}

		// Create target dir
		if (!file_exists($uploadDir)) {
			@mkdir($uploadDir,0777);
		}

		// Get a file name
		if ($this->input->get_post("name")) {
			$fileName = $this->input->get_post("name");
		} elseif (!empty($_FILES)) {
			$fileName = $_FILES["file"]["name"];
		} else {
			$fileName = uniqid("file_");
		}
		$fileSize = $_FILES["file"]["size"];
		
		if(FALSE !== strpos($fileName,'.'))
		{
			$fileReName = uniqid().substr($fileName,strrpos($fileName,'.'));
		}
		elseif(FALSE === strpos($fileName,'.'))
		{
			$fileReName = uniqid().$fileName;
		}
		$md5File = @file('md5list.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
		$md5File = $md5File ? $md5File : array();

		if ($this->input->get_post("md5") && array_search($this->input->get_post("md5"), $md5File ) !== FALSE ) {
			die('{"jsonrpc" : "2.0", "result" : null, "id" : "id", "exist": 1}');
		}

		$filePath = $targetDir . DIRECTORY_SEPARATOR . $fileName;
		$uploadPath = $uploadDir . DIRECTORY_SEPARATOR . $fileReName;

		// Chunking might be enabled
		$chunk = $this->input->get_post("chunk") ? intval($this->input->get_post("chunk")) : 0;
		$chunks = $this->input->get_post("chunks") ? intval($this->input->get_post("chunks")) : 1;


		// Remove old temp files
		if ($cleanupTargetDir) {
			if (!is_dir($targetDir) || !$dir = opendir($targetDir)) {
				die('{"jsonrpc" : "2.0", "error" : {"code": 100, "message": "Failed to open temp directory."}, "id" : "id"}');
			}

			while (($file = readdir($dir)) !== false) {
				$tmpfilePath = $targetDir . DIRECTORY_SEPARATOR . $file;

				// If temp file is current file proceed to the next
				if ($tmpfilePath == "{$filePath}_{$chunk}.part" || $tmpfilePath == "{$filePath}_{$chunk}.parttmp") {
					continue;
				}

				// Remove temp file if it is older than the max age and is not the current file
				if (preg_match('/\.(part|parttmp)$/', $file) && (@filemtime($tmpfilePath) < time() - $maxFileAge)) {
					@unlink($tmpfilePath);
				}
			}
			closedir($dir);
		}


		// Open temp file
		if (!$out = @fopen("{$filePath}_{$chunk}.parttmp", "wb")) {
			die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
		}

		if (!empty($_FILES)) {
			if ($_FILES["file"]["error"] || !is_uploaded_file($_FILES["file"]["tmp_name"])) {
				die('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}');
			}

			// Read binary input stream and append it to temp file
			if (!$in = @fopen($_FILES["file"]["tmp_name"], "rb")) {
				die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
			}
		} else {
			if (!$in = @fopen("php://input", "rb")) {
				die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
			}
		}

		while ($buff = fread($in, 4096)) {
			fwrite($out, $buff);
		}

		@fclose($out);
		@fclose($in);

		rename("{$filePath}_{$chunk}.parttmp", "{$filePath}_{$chunk}.part");

		$index = 0;
		$done = true;
		for( $index = 0; $index < $chunks; $index++ ) {
			if ( !file_exists("{$filePath}_{$index}.part") ) {
				$done = false;
				break;
			}
		}
		if ( $done ) {
			if (!$out = @fopen($uploadPath, "wb")) {
				die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
			}

			if ( flock($out, LOCK_EX) ) {
				for( $index = 0; $index < $chunks; $index++ ) {
					if (!$in = @fopen("{$filePath}_{$index}.part", "rb")) {
						break;
					}

					while ($buff = fread($in, 4096)) {
						fwrite($out, $buff);
					}

					@fclose($in);
					@unlink("{$filePath}_{$index}.part");
				}

				flock($out, LOCK_UN);
			}
			@fclose($out);

			//insert productalbum
			$this->load->model('productalbum_model');
			$data = array('uuid'=>UUID,'album_uuid'=>uniqid(),'url'=>$fileReName,'create_time'=>$datedirtime,'size'=>$fileSize);
			if($product_uuid)
				$data['product_uuid'] = $product_uuid;
			$this->productalbum_model->insert($data);
		}

		//图像处理开始
		$this->load->library('image_lib');
		//500
		//$configimgs['image_library'] = 'gd2';
		$configimgs['source_image'] = $uploadPath;
		$configimgs['quality'] = 100;
		$configimgs['maintain_ratio'] = TRUE;
		$configimgs['width'] = 500;
		$configimgs['height'] = 500;
		$configimgs['new_image'] = '500_'.$fileReName;
		$this->image_lib->initialize($configimgs); 
		$this->image_lib->resize();
		//180
		$configimgs = array();
		//$configimgs['image_library'] = 'gd2';
		$configimgs['source_image'] = $uploadPath;
		$configimgs['quality'] = 100;
		$configimgs['maintain_ratio'] = TRUE;
		$configimgs['width'] = 180;
		$configimgs['height'] = 180;
		$configimgs['new_image'] = '180_'.$fileReName;
		$this->image_lib->initialize($configimgs); 
		$this->image_lib->resize();
		//图像处理结束
		// Return Success JSON-RPC response
		die('{"jsonrpc" : "2.0", "result" : null, "id" : "id"}');
		
	}

	/**
	 * 此页面用来协助 IE6/7 预览图片，因为 IE 6/7 不支持 base64
	 */
	protected function _preview()
	{
		

		$DIR = 'uploadfile/preview';
		// Create target dir
		if (!file_exists($DIR)) {
			@mkdir($DIR);
		}

		$cleanupTargetDir = true; // Remove old files
		$maxFileAge = 5 * 3600; // Temp file age in seconds

		if ($cleanupTargetDir) {
			if (!is_dir($DIR) || !$dir = opendir($DIR)) {
				die('{"jsonrpc" : "2.0", "error" : {"code": 100, "message": "Failed to open temp directory."}, "id" : "id"}');
			}

			while (($file = readdir($dir)) !== false) {
				$tmpfilePath = $DIR . DIRECTORY_SEPARATOR . $file;

				// Remove temp file if it is older than the max age and is not the current file
				if (@filemtime($tmpfilePath) < time() - $maxFileAge) {
					@unlink($tmpfilePath);
				}
			}
			closedir($dir);
		}

		$src = file_get_contents('php://input');

		if (preg_match("#^data:image/(\w+);base64,(.*)$#", $src, $matches)) {

			$previewUrl = sprintf(
				"%s://%s%s",
				isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
				$_SERVER['HTTP_HOST'],
				$_SERVER['REQUEST_URI']
			);
			$previewUrl = str_replace("preview.php", "", $previewUrl);


			$base64 = $matches[2];
			$type = $matches[1];
			if ($type === 'jpeg') {
				$type = 'jpg';
			}

			$filename = md5($base64).".$type";
			$filePath = $DIR.DIRECTORY_SEPARATOR.$filename;

			if (file_exists($filePath)) {
				die('{"jsonrpc" : "2.0", "result" : "'.$previewUrl.'preview/'.$filename.'", "id" : "id"}');
			} else {
				$data = base64_decode($base64);
				file_put_contents($filePath, $data);
				die('{"jsonrpc" : "2.0", "result" : "'.$previewUrl.'preview/'.$filename.'", "id" : "id"}');
			}

		} else {
			die('{"jsonrpc" : "2.0", "error" : {"code": 100, "message": "un recoginized source"}}');
		}
	}
}
