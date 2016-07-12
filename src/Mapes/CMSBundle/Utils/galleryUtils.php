<?PHP

namespace Mapes\CMSBundle\Utils;

class galleryUtils{

        public function __construct($sf_web_dir)
        {
            $this->sf_web_dir = $sf_web_dir;
        }
        
	public function getImageResize($url, $resizeString, $width, $height)
	{
		
		$imageFile = $this->sf_web_dir.$url;
		$imageSize = getimagesize($imageFile);
		if($resizeString != "")
		{
			// in|0,34,400,234|out|400,266
			$items = explode("|", $resizeString);
			$coords = explode(",", $items[1]);
			$references = explode(",", $items[3]);
		}
		else
		{
			//Automatically set items;
			$coords = array(0,0,$imageSize[0], $imageSize[1]);
			$imageRatio = $imageSize[0]/$imageSize[1];
			$targetRatio = $width/$height;
			$references = $imageSize;
			if($imageRatio > $targetRatio)
			{
				//Real image is too wide, so bring width in
				
				$newWidth = $imageSize[1] * $targetRatio;
				$difference = round(($imageSize[0] - $newWidth) / 2);
				$coords[0] = $difference;
				$coords[2] = $difference + $newWidth;
			}
			else if($imageRatio < $targetRatio)
			{
				//Real image is too tall, so bring height in
				$newHeight = $imageSize[0] / $targetRatio;
				$difference = round(($imageSize[1] - $newHeight) / 2);
				$coords[1] = $difference;
				$coords[3] = $difference + $newHeight;
				
				//print_r($coords); exit;
			}
		}
		
			
		$endString = "_".implode("_",$coords).".jpg";
		if(is_file($imageFile.$endString))
			return $url.$endString;
		


		$ratioX =  $imageSize[0] / $references[0];
		//$ratioY = $imageSize[1] / $references[1];
		
		
		if(strtolower(substr($imageFile, -4)) == ".png")
			$myImage = imagecreatefrompng($imageFile);
		else
			$myImage = imagecreatefromjpeg($imageFile);		
		
		$thumb = imagecreatetruecolor($width, $height); 		
  		imagecopyresampled($thumb, $myImage, 0, 0,$coords[0] * $ratioX, $coords[1] * $ratioX, $width, $height, ($coords[2] - $coords[0])  * $ratioX, ($coords[3] - $coords[1])  * $ratioX); 
  		
  		imagejpeg($thumb, $imageFile.$endString, 92);
  		imagedestroy($thumb);
  		
  		return $url.$endString;
	}
        
        public function getThumbnail($file_path_with_name, $w=30, $h=30) {

           $thumbnail_image = false;

           if ($file_path_with_name != "") :

             $file_path = dirname($file_path_with_name);
             $file_name = basename($file_path_with_name);

             $original_path = $this->sf_web_dir. $file_path_with_name;

             $thumbnail_path = $this->sf_web_dir. $file_path . '/_thumbs' . $w . '/' . $file_name;

             if (file_exists($thumbnail_path)):

               $thumbnail_image = $file_path. '/_thumbs' . $w . '/' . $file_name;

               // recreate thumbnail if original is newer

               $original_age = floor(time() - filemtime($original_path) / 60); // in minutes

               $thumbnail_age = floor(time() - filemtime($thumbnail_path) / 60);

               if ($original_age < $thumbnail_age) :

                 $thumbnail_image = $file_path. $this->createThumbnail($this->sf_web_dir.$file_path, $file_name, $w, $h);

               endif;



             // if it does not exist yet create it

             elseif (file_exists($original_path)):

               $thumbnail_image = $file_path. $this->createThumbnail($this->sf_web_dir.$file_path, $file_name, $w, $h);

             endif;

           endif;

           return $thumbnail_image;

         }    

         public function createThumbnail($file_path, $file_name, $w, $h) {

                $thumbnail_image = false;
                try
                {

                      if (!is_dir($file_path . '/_thumbs' . $w)) :
                          mkdir($file_path . '/_thumbs' . $w);
                      endif;

                      $file = new \sfThumbnailPlugin_sfThumbnail($w, $h, true, false);
                      $file->loadFile($file_path . '/' . $file_name);
                      $file->save($file_path . '/_thumbs' . $w . '/' . $file_name, $file->getMime());

                      if (file_exists($file_path . '/_thumbs' . $w . '/' . $file_name)) :
                            $file_path_array = explode("/", $file_path);
                            //$last_dir = end($file_path_array  );
                            $thumbnail_image = '/_thumbs' . $w . '/' . $file_name;
                      endif;
                }catch(Exception $c){
                /*   if ($w <= 80)
                      $image_path = '/site/images/default-icon-small.png';
                  else
                      $image_path = '/site/images/default-icon.png';*/
                }

                return $thumbnail_image;
          }          

}