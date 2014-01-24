#GD Image Resizer#

Resize & crop images using GD Library for PHP.

##Example useage (Function)##

```
resizeImage( 'uploads/', 'test.jpg', 90, 800, 600 );
//resizeImage( $folder, $image, $quality, $target_width, $target_height );
```

##Example useage (Class)##

```
$images = array( 'uploads/test.jpg', 'uploads/test.png' );
$sizes = array( array(800, 600), array(200, 150) );

foreach ($images as $image) {

	$rszr = new imageResizer( $image );
	$newImg = $rszr->resize( $sizes );

}
```