<?php

    // calculation
    function minus($a, $b) {
        return $a - $b;
    }


    // resize image
    function resizeImage( $image, $target_width, $target_height, $quality ) {

        // set up
        $folder = 'uploads/';
        $file = explode(".", $image);
        $image_name = $file[0];
        $extension = $file[1];

        // check file exists
        if (file_exists($folder.$image)) {

            // get source image info
            $source_image_info = list( $source_width, $source_height, $source_type ) = getimagesize( $folder.$image );

            // get the aspect ratio
            $source_aspect_ratio = $source_width / $source_height;


            // get ratios of width & height
            $widthDiff = $source_width / $target_width;
            $heightDiff = $source_height / $target_height;
            $ratio = min( array($widthDiff, $heightDiff) );


            // work out new width & height
            $newHeight = round($source_height / $ratio);
            $newWidth = round($source_width / $ratio);
        

            // create new image
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
                $sourceImage = imagecreatefromjpeg($folder.$image);

            } else if ($extension == 'gif') {
                $sourceImage = imagecreatefromgif($folder.$image);

            } else if ($extension == 'png') {
                $sourceImage = imagecreatefrompng($folder.$image);

            }

            $newImage = imagecreatetruecolor($target_width, $target_height);
            imagecopyresampled($newImage, $sourceImage, $amount_to_crop_y, $amount_to_crop_x, 0, 0, $newWidth, $newHeight, $source_width, $source_height);
            
            // create new image
            if ($extension == 'jpg' || $extension == 'jpeg') {
                imagejpeg($newImage, $folder . $image_name . '_' . $datetime . '_' . $target_width . 'x' . $target_height . '.' . $extension, $quality);    
            
            } else if ($extension == 'gif') {
                imagegif($newImage, $folder . $image_name . '_' . $datetime . '_' . $target_width . 'x' . $target_height . '.' . $extension, $quality);
            
            } else if ($extension == 'png') {
                imagepng($newImage, $folder . $image_name . '_' . $datetime . '_' . $target_width . 'x' . $target_height . '.' . $extension, $quality);
            
            }
        }
    }

?>