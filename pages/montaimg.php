<?PHP
$text=$_GET['text'];
if ($config['site']['check_titles']==FALSE or in_array($text,$config['site']['allowed_titles']))
{
	if ( !file_exists('images/head/'.$text.'.png'))
	{
		$font="images/head/martel.ttf";
		$image = imagecreatefrompng ('images/head/headline.png');
		imagettftext ($image, 18, 0, 4, 20, imagecolorallocate($image, 240, 209, 164), $font, $text);
		imagepng($image, 'images/head/'.$text.'.png');
	}
	$img='images/head/'.$text.'.png';
	$pic=imagecreatefrompng($img);					
	header('Content-type: image/png');
	imagepng($pic);
}
?> 
