<?php

	class imageResizer {
	
		public function __construct( $image )
		{
			$this -> imageObject = $image;
		}
	
		public function resize( $sizes )
		{
	
			$image = $this->imageObject;
			echo $image;
			 
			foreach ($sizes as $size) {
	
				// target sizes
				$target_width = $size[0];
				$target_height = $size[1];
	
				// image name
				$imageName = explode("/", $image);
				$imageName = end($imageName);
	
				// image folder
				$imageFolder = explode("/", $image);
				$imageFolderPieces = '';
	
				for ( $i = 0; $i < count($imageFolder) - 1; $i++ ) { 
					$imageFolderPieces .= $imageFolder[$i]."/";
				}
	
				// file pieces
				$file = explode(".", $imageName);
				$image_name = $file[0];
				$extension = $file[1];
	
				if (file_exists($image)) {
	
		            // get source image info
		            $source_image_info = list( $source_width, $source_height, $source_type ) = getimagesize( $image );
	
	
		            // work out the ratio between the source image w/h & the new image w/h
		            $widthDiff = $source_width / $target_width;
		            $heightDiff = $source_height / $target_height;
	
	
		            // get the smaller ratio of the two
		            $ratio = min( array($widthDiff, $heightDiff) );
	
	
		            // work out new width & height
		            $newHeight = round($source_height / $ratio);
		            $newWidth = round($source_width / $ratio);
		        
	
		            // work out whether to set the width or height as longer than specified
		            // idea being to set the shorter one as specified, then crop off the longer one down to size after
		            if ($newWidth > $target_width) {
	
		                // crop from left and right
		                $amount_to_crop = minus($newWidth, $target_width);
		                $amount_to_crop = $amount_to_crop / 2;
	
		                $amount_to_crop_x = 0;
		                $amount_to_crop_y = -$amount_to_crop;
	
		            } else {
	
		                // crop from top and bottom
		                $amount_to_crop = minus($newHeight, $target_height);
		                $amount_to_crop = $amount_to_crop / 2;
	
		                $amount_to_crop_x = -$amount_to_crop;
		                $amount_to_crop_y = 0;
	
		            }
	
		            // get current timestamp
		            $date = new DateTime();
		            $datetime = $date->getTimestamp(); 
	
		            if ($extension == 'jpg' || $extension == 'jpeg') {
		                $sourceImage = imagecreatefromjpeg($image);
	
		            } else if ($extension == 'gif') {
		                $sourceImage = imagecreatefromgif($image);
	
		            } else if ($extension == 'png') {
		                $sourceImage = imagecreatefrompng($image);
	
		            }
	
		            $newImage = imagecreatetruecolor($target_width, $target_height);
	
		            // retain transparency in PNGs
		            imagealphablending($newImage, false);
					imagesavealpha($newImage, true);
		            
		            imagecopyresampled($newImage, $sourceImage, $amount_to_crop_y, $amount_to_crop_x, 0, 0, $newWidth, $newHeight, $source_width, $source_height);
		            
		            // create new image
		            if ($extension == 'jpg' || $extension == 'jpeg') {
		                imagejpeg($newImage, $imageFolderPieces . $image_name . '_' . $datetime . '_' . $target_width . 'x' . $target_height . '.' . $extension, 90);    
		            
		            } else if ($extension == 'gif') {
		                imagegif($newImage, $imageFolderPieces . $image_name . '_' . $datetime . '_' . $target_width . 'x' . $target_height . '.' . $extension, 90);
		            
		            } else if ($extension == 'png') {
		                imagepng($newImage, $imageFolderPieces . $image_name . '_' . $datetime . '_' . $target_width . 'x' . $target_height . '.' . $extension, 0);
		            
		            }
	
				}
			}
	
			return $image;
			
		}
	}
	
	
	// calculation
	function minus($a, $b) {
		return $a - $b;
	}
 
?>
