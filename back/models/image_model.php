<?php
class image_model extends CI_Model
{
	// crop image
	function crop_image($folder,$img){
		//folder 330/  with traailing slash
		//img  img.jpg no trailing slash
		$img_name='./upload/'.$folder.$img;
		$image = imagecreatefromjpeg($img_name);
		$filename = './upload/'.$folder.'thumb_'.$img;

		$thumb_width = 120;
		$thumb_height = 80;

		$width = imagesx($image);
		$height = imagesy($image);

		$original_aspect = $width / $height;
		$thumb_aspect = $thumb_width / $thumb_height;


		$thumb = imagecreatetruecolor( $thumb_width, $thumb_height );

		// Resize and crop
		imagecopyresized($thumb,
						   $image,
						   0, 
						   0, 
						   0, 0,
						   $thumb_width, $thumb_height,
						   $width, $height);
		imagejpeg($thumb, $filename, 80);
	}
	function imageResize_300($imgName){

	// Configuration
	$config['source_image'] = './upload/'.$imgName;
	$config['new_image'] = './upload/large_'.$imgName;
	$config['maintain_ratio'] = TRUE;
	$config['width'] = 400;
	$config['height'] = 300;


	// Load the Library
	$this->load->library('image_lib', $config);
	
	// resize image
	$this->image_lib->resize();

	// handle if there is any problem
	if ( ! $this->image_lib->resize()){
		echo $this->image_lib->display_errors();
	}
	else{
	 $this->image_lib->clear();
	}
}
	function imageResize_100($imgName){

	// Configuration
	$config['source_image'] = './upload/'.$imgName;
	$config['new_image'] = './upload/thumb_'.$imgName;
	$config['maintain_ratio'] = TRUE;
	$config['width'] = 100;
	$config['height'] = 100;


	// Load the Library
	$this->load->library('image_lib', $config);
	
	// resize image
	$this->image_lib->resize();

	// handle if there is any problem
	if ( ! $this->image_lib->resize()){
		echo $this->image_lib->display_errors();
	}
	else{
	 $this->image_lib->clear();
	}
}
function watermark($filename){
echo $filename;
        $image_cfg = array();
        $image_cfg['image_library'] = 'GD';
        $image_cfg['source_image'] = 'upload/' . $filename;
        $image_cfg['wm_overlay_path'] = 'upload/watermark1.png';
        $image_cfg['new_image'] = 'upload/m_'.$filename;
        $image_cfg['wm_type'] = 'overlay';
        $image_cfg['wm_opacity'] = '10';
        $image_cfg['wm_vrt_alignment'] = 'bottom';
        $image_cfg['wm_hor_alignment'] = 'right';
		$this->load->library('image_lib', $image_cfg);

		$this->image_lib->watermark();
        $this->image_lib->clear();
		echo $this->image_lib->display_errors();
//        die();

    }
}
?>