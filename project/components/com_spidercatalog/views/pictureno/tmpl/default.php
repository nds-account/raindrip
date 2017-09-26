<?php
 /**
 * @package Spider Catalog
 * @author Web-Dorado
 * @copyright (C) 2012 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

 // This php file returnes image in image/jpeg format therefore direct access must be allowed




class SimpleImage {  


   var $image;


   var $image_type;


 


   function load($filename) {


   
      $image_info = getimagesize($filename);
if ($image_info=='')
{
		if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'
		    || $_SERVER['SERVER_PORT'] == 443) {
		
					    $http = 'https://';
}
else $http = 'http://';

$filename = str_replace ($http.$_SERVER['SERVER_NAME'].'/', '',$filename );
 $image_info = getimagesize($filename);
}

      $this->image_type = $image_info[2];


      if( $this->image_type == IMAGETYPE_JPEG ) {
$doc = JFactory::getDocument();
$doc->setMimeEncoding('image/jpeg');

        $this->image = imagecreatefromjpeg($filename);


      } elseif( $this->image_type == IMAGETYPE_GIF ) {
$doc = JFactory::getDocument();
$doc->setMimeEncoding('image/gif');

        $this->image = imagecreatefromgif($filename);


      } elseif( $this->image_type == IMAGETYPE_PNG ) {
$doc = JFactory::getDocument();
$doc->setMimeEncoding('image/png');

         $this->image = imagecreatefrompng($filename);


      }
     


   }


   function save($filename, $image_type=IMAGETYPE_PNG, $compression=75, $permissions=null) {


      if( $image_type == IMAGETYPE_JPEG ) {


         imagejpeg($this->image,$filename,$compression);


      } elseif( $image_type == IMAGETYPE_GIF ) {


         imagegif($this->image,$filename);         


      } elseif( $image_type == IMAGETYPE_PNG ) {


         imagepng($this->image,$filename);


      }   
    


      if( $permissions != null) {


         chmod($filename,$permissions);


      }


   }


   function output($image_type=IMAGETYPE_PNG) {

	$image_type=$this->image_type;

      if( $image_type == IMAGETYPE_JPEG ) {
         imagejpeg($this->image);


      } elseif( $image_type == IMAGETYPE_GIF ) {
         imagegif($this->image);         


      } elseif( $image_type == IMAGETYPE_PNG ) {
         imagepng($this->image);

      }  

   }


   function getWidth() {


      return imagesx($this->image);


   }


   function getHeight() {


      return imagesy($this->image);


   }


   function resizeToHeight($height) {


      $ratio = $height / $this->getHeight();


      $width = $this->getWidth() * $ratio;


      $this->resize($width,$height);


   }


   function resizeToWidth($width) {


      $ratio = $width / $this->getWidth();


      $height = $this->getheight() * $ratio;


      $this->resize($width,$height);


   }


   function scale($scale) {


      $width = $this->getWidth() * $scale/100;


      $height = $this->getheight() * $scale/100; 


      $this->resize($width,$height);


   }


function resize($width,$height) {
	$new_image = imagecreatetruecolor($width, $height);
	if( $this->image_type == IMAGETYPE_GIF || $this->image_type == IMAGETYPE_PNG ) {
		$current_transparent = imagecolortransparent($this->image);
		if($current_transparent != -1) {
			$transparent_color = imagecolorsforindex($this->image, $current_transparent);
			$current_transparent = imagecolorallocate($new_image, $transparent_color['red'], $transparent_color['green'], $transparent_color['blue']);
			imagefill($new_image, 0, 0, $current_transparent);
			imagecolortransparent($new_image, $current_transparent);
		} elseif( $this->image_type == IMAGETYPE_PNG) {
			imagealphablending($new_image, false);
			$color = imagecolorallocatealpha($new_image, 0, 0, 0, 127);
			imagefill($new_image, 0, 0, $color);
			imagesavealpha($new_image, true);
		}
	}
	imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
	$this->image = $new_image;	
}      


}


   $image = new SimpleImage();


   $image->load(JRequest::getVar('id'));


   if(JRequest::getVar('width',0)!=0 and JRequest::getVar('height',0)!=0 )


   	{


   		if( JRequest::getVar('width') / $image->getWidth() < JRequest::getVar('height') / $image->getHeight())


			{			if( JRequest::getVar('reverse',0)==1)   				$image->resizeToHeight(JRequest::getVar('height',0));			else


   				$image->resizeToWidth(JRequest::getVar('width'));


			}


		else


			{			if( JRequest::getVar('reverse',0)==1)   				$image->resizeToWidth(JRequest::getVar('width'));			else


   				$image->resizeToHeight(JRequest::getVar('height'));			


			}	


   	}


	else


	{


		if(JRequest::getVar('width',0)!=0)


			{


   				$image->resizeToWidth(JRequest::getVar('width',0));


			}


		else


			{


   				$image->resizeToHeight(JRequest::getVar('height',0));			


			}	


	}


   $image->output();


?>