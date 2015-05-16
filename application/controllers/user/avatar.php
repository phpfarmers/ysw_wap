<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Avatar extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		if (!$this->is_login())
		{
			@session_start();
			$_SESSION['redirect'] = $_SERVER['REQUEST_URI'];
			redirect(site_url('prompt'), 'refresh');
		}
	}

	public function index()
	{
		$this->load->model('user_model');
		$data['web_title'] = '用户头像-游商网';
		$data['web_keywords'] = '创业,游商网,融资网站,游戏品台';
		$data['web_description'] = '游商网,第一个做融资网络游戏的平台！';
		$avatar = $this->user_model->fetch_id('',' user_pic ');
		$large_image_name = $thumb_image_name = '';
		if($avatar)
		{
			$large_image_name = $avatar->user_pic;
			$thumb_image_name = '180_'.$avatar->user_pic;
		}
		//
		//Constants
		//You can alter these options
		$upload_dir = RESPATH.'/uploadfile/image/user'; 				// The directory for the images to be saved in
		$data['upload_path'] = '/uploadfile/image/user';				// The path to where the image will be saved
		$data['large_image_name'] = $large_image_name; 		// New name of the large image
		$data['thumb_image_name'] = $thumb_image_name; 	// New name of the thumbnail image
		$data['max_file'] = "1148576"; 						// Approx 1MB
		$data['max_width'] = "500";							// Max width allowed for the large image
		$data['thumb_width'] = "180";						// Width of thumbnail image
		$data['thumb_height'] = "180";

		
		//Image Locations
		$large_image_location = $upload_dir.'/'.$data['large_image_name'];
		$thumb_image_location = $upload_dir.'/'.$data['thumb_image_name'];
		//Create the upload directory with the right permissions if it doesn't exist
		if(!is_dir($upload_dir))
		{
			mkdir($upload_dir, 0777);
			chmod($upload_dir, 0777);
		}

		//Check to see if any images with the same names already exist
		if (file_exists($large_image_location) && $large_image_name)
		{
			if(file_exists($thumb_image_location)){
				$data['thumb_photo_exists'] = "<img src=\"".static_url($data['upload_path'].$data['thumb_image_name'])."\" alt=\"Thumbnail Image\"/>";
			}else{
				$data['thumb_photo_exists'] = "";
			}
			$data['large_photo_exists'] = "<img src=\"".static_url($data['upload_path'].$data['large_image_name'])."\" alt=\"Large Image\"/>";		
			$data['current_large_image_width'] = $this->_getWidth($large_image_location);
			$data['current_large_image_height'] = $this->_getHeight($large_image_location);
			
		} else {
			$data['large_photo_exists'] = "";
			$data['thumb_photo_exists'] = "";
			$data['current_large_image_width'] = '';
			$data['current_large_image_height'] = '';
		}

		if ($this->input->post("upload"))
		{
			//图片处理
				$configimg = array('upload_path' => RESPATH.'/uploadfile/image/user/',
				'allowed_types' => 'gif|jpg|png',
				'max_size' => '1000',
				//'max_width'  => '500',
				//'max_height'  => '230',
				'max_filename'	=> 40,//生成的文件名最大长度
				'file_name'	=> UUID,//上传后的文件名称
				'overwrite'	=> TRUE,//是否用生成的文件覆盖掉同名文件
				//'encrypt_name'	=> FALSE,//是否生成hash的文件名
				);
				$this->load->library('upload', $configimg);

				if ( ! $this->upload->do_upload('image'))
				{//.............................................................doing..............
					$error = $this->upload->display_errors('','');echo "<script>alert('".$error."');history.go(-1);</script>";exit;
				} 
				else
				{
					$this->load->library('image_lib');
					$dataimg =  $this->upload->data();
					$this->user_model->update_avatar($dataimg['orig_name']);
					/*
					*/
					//$configimgs['image_library'] = 'gd2';
					$configimgs['source_image'] = $dataimg['full_path'];
					$configimgs['quality'] = 100;
					$configimgs['maintain_ratio'] = TRUE;
					$configimgs['width'] = 500;
					$configimgs['height'] = 500;
					$configimgs['new_image'] = $dataimg['orig_name'];
					$this->image_lib->initialize($configimgs); 
					$this->image_lib->resize();

					$configimgs = array();
					//$configimgs['image_library'] = 'gd2';
					$configimgs['source_image'] = $dataimg['full_path'];
					$configimgs['maintain_ratio'] = TRUE;
					$configimgs['quality'] = 100;
					$configimgs['width'] = 180;
					$configimgs['height'] = 180;
					$configimgs['new_image'] = '180_'.$dataimg['orig_name'];
					$this->image_lib->initialize($configimgs); 
					$this->image_lib->resize();
					//change the avatar
					if(isset($_SESSION['avatar'])) $_SESSION['avatar'] = $dataimg['orig_name'];
					if($this->session->userdata('avatar')) $this->session->set_userdata(array('avatar'=>$dataimg['orig_name']));

					$configimgs = array();
					//$configimgs['image_library'] = 'gd2';
					$configimgs['source_image'] = $dataimg['full_path'];
					$configimgs['quality'] = 100;
					$configimgs['maintain_ratio'] = TRUE;
					$configimgs['width'] = 100;
					$configimgs['height'] = 100;
					$configimgs['new_image'] = '100_'.$dataimg['orig_name'];
					$this->image_lib->initialize($configimgs); 
					$this->image_lib->resize();
					
				}
			redirect(current_url(), 'refresh');
			exit();
			//
		}

		if ($this->input->post("upload_thumbnail") && strlen($data['large_photo_exists'])>0)
		{
			//Get the new coordinates to crop the image.
			$x1 = $this->input->post("x1");
			$y1 = $this->input->post("y1");
			$x2 = $this->input->post("x2");
			$y2 = $this->input->post("y2");
			$w = $this->input->post("w");
			$h = $this->input->post("h");
			//Scale the image to the thumb_width set above
			//$scale = $data['thumb_width']/$w;
			$this->load->library('image_lib');
			//copy start
				//$configimgs['image_library'] = 'gd2';
				$configimgs['source_image'] = $large_image_location;
				$configimgs['quality'] = 100;
				$configimgs['maintain_ratio'] = TRUE;
				$configimgs['width'] = 500;
				$configimgs['height'] = 500;
				$configimgs['new_image'] = $data['thumb_image_name'];
				$this->image_lib->initialize($configimgs);
				if ( ! $this->image_lib->resize())
				{
					echo $this->image_lib->display_errors();
				}
				$configimgs = array();
			//copy end
			//crop start
			//$configcrop['image_library'] = 'imagemagick';
			//$configcrop['library_path'] = '/usr/X11R6/bin/';
			//$configimgs['image_library'] = 'gd2';
			$configimgs['source_image'] = $thumb_image_location;
			$configimgs['quality'] = 100;
			$configimgs['maintain_ratio'] = FALSE;
			$configimgs['width'] = $w;
			$configimgs['height'] = $h;
			$configimgs['x_axis'] = $x1;
			$configimgs['y_axis'] = $y1;

			$this->image_lib->initialize($configimgs); 

			if ( ! $this->image_lib->crop())
			{
				echo $this->image_lib->display_errors();
			}
			$configimgs = array();
			//crop end
			//180 start
			//$configimgs['image_library'] = 'gd2';
			$configimgs['source_image'] = $thumb_image_location;
			$configimgs['quality'] = 100;
			$configimgs['maintain_ratio'] = TRUE;
			$configimgs['width'] = 180;
			$configimgs['height'] = 180;
			$this->image_lib->initialize($configimgs); 
			if ( ! $this->image_lib->resize())
			{
				echo $this->image_lib->display_errors();
			}
			
			$configimgs = array();
			//180 end
			//100 start
			//$configimgs['image_library'] = 'gd2';
			$configimgs['source_image'] = $thumb_image_location;
			$configimgs['quality'] = 100;
			$configimgs['maintain_ratio'] = TRUE;
			$configimgs['width'] = 100;
			$configimgs['height'] = 100;
			$configimgs['new_image'] = '100_'.$large_image_name;
			$this->image_lib->initialize($configimgs); 
			if ( ! $this->image_lib->resize())
			{
				echo $this->image_lib->display_errors();
			}
			//100 end
			//Reload the page again to view the thumbnail
			redirect(current_url(), 'refresh');
			exit();
		}

		//
		$this->load->view('include/header',$data);
		$this->load->view('include/user_left',$data);
		$this->load->view('user/avatar',$data);
		$this->load->view('include/footer',$data);
	}

	//
	//You do not need to alter these functions
	function _getHeight($image) {
		$sizes = getimagesize($image);
		$height = $sizes[1];
		return $height;
	}
	//You do not need to alter these functions
	function _getWidth($image) {
		$sizes = getimagesize($image);
		$width = $sizes[0];
		return $width;
	}

	//
}
