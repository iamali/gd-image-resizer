GD Image Resizer
===

A PHP snippit to resize & crop images using GD Library.

Example useage
---------------

You can use it as a function like this:

```
resizeImage( 'uploads/', 'test.jpg', 90, 800, 600 );
//resizeImage( $folder, $image, $quality, $target_width, $target_height );
```

Or as a class like this:

```
$images = array( 'uploads/test.jpg', 'uploads/test.png' );
$sizes = array( array(800, 600), array(200, 150) );

foreach ($images as $image) {

	$rszr = new imageResizer( $image );
	$newImg = $rszr->resize( $sizes );

}
```
