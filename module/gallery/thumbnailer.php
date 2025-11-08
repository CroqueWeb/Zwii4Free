<?php
// création des miniatures par @CroqueWeb
if (!isset($_GET['img']))
{
	exit(0);
}
if (isset($_GET['ratio']))
{
	$ratio = $_GET['ratio'];
}
else
{
	$ratio = 180;
}
$img = '../../'.$_GET['img'];
$dossiercache = '../../site/file/cache';
if(!is_dir($dossiercache))
{
	@mkdir($dossiercache,0755);
}
$par = substr(strrchr($img, '/'), 1);
$url_par = str_replace('/'.$par,'',$img);
$cache = substr(strrchr($url_par, '/'), 1);
if(!is_dir($dossiercache.'/'.$cache))
{
	@mkdir($dossiercache.'/'.$cache);
}
$extension = strrchr($par,'.');
$vignette = str_replace($extension,'',$par);
$miniature = $dossiercache.'/'.$cache.'/'.$vignette.'.jpg';
if(!file_exists($miniature))
{
	$imginfo = getimagesize($img);
	$mime = $imginfo['mime'];
	if ((function_exists('exif_read_data')) && ($mime == 'image/jpeg'))
	{
		$exif = exif_read_data($img);
		$image = imagecreatefromstring(file_get_contents($img));
		$orientation = isset($exif['Orientation']) === true ? $exif['Orientation'] : '';
		if ( (!empty($orientation)) && ($orientation != 1) )
		{
			switch($orientation)
			{
				case 3:
					$image = imagerotate($image,180,0);
					break;
				case 6:
					$image = imagerotate($image,-90,0);
					break;
				case 8:
					$image = imagerotate($image,90,0);
					break;
			}
			imagejpeg($image, $img, 90);
		}
	}
	$largeur = $imginfo[0];
	$hauteur = $imginfo[1];
	$type = $imginfo[2];
	if($type == 1)
	{
		$src = imagecreatefromgif($img);
	}
	elseif($type == 2)
	{
		$src = imagecreatefromjpeg($img);
	}
	elseif($type == 3)
	{
		$src = imagecreatefrompng($img);
	}
	if ($largeur > $hauteur)
	{
		$im = imagecreatetruecolor(round(($ratio/$hauteur)*$largeur), $ratio);
		imagecopyresampled($im, $src, 0, 0, 0, 0, round(($ratio/$hauteur)*$largeur), $ratio, $largeur, $hauteur);
	}
	else
	{
		$im = imagecreatetruecolor($ratio, round(($ratio/$largeur)*$hauteur));
		imagecopyresampled($im, $src, 0, 0, 0, 0, $ratio, round($hauteur*($ratio/$largeur)), $largeur, $hauteur);
	}
	imagejpeg($im, $miniature);
	imagedestroy($im);
}
header('Content-Type: image/jpeg');
$data = file_get_contents($miniature);
echo $data;
clearstatcache();
?>
