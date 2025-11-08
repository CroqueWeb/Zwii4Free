  <!DOCTYPE html>
  <html lang="fr">
  <head>
  <title>Compresser pendant le transfert</title>
  <link rel="stylesheet" href="bootstrap.min.css">
  <link rel="stylesheet" href="mtb.css">
  </head>
  <!-- fichier modifié le 15/04/2018 -->
  <body>
  <header id="masthead" class="site-header" role="banner">
  <div class="container-fluid">
  <div class="row">
  <div class="col-lg-12">
  <div class="site-branding">
  <h1 class="site-title">Compresser pendant le transfert</h1>
  </div>
  </div>
  </div>
  </div>
  </header>
  <br>
  <div class="container-fluid">
  <div class="row">
  <div class="col-md-6 col-xs-12">
  <form method="post" enctype="multipart/form-data">
  <table>
  <tr>
  <td><label>Image</label><input type="file" name="uploadImg" value="" /></td>
  </tr>
  <tr>
  <td><label>Largeur</label><input type="text" name="width" value=""></td>
  </tr>
  <tr>
  <td><label>Hauteur</label><input type="text" name="height" value=""></td>
  </tr>
  <tr>
  <td><label>Qualit&eacute;</label><input type="text" name="quality" value=""></td>
  </tr>
  <tr>
  <td><input type="submit" name="submit" value="Ok" /></td>
  </tr>
  </table>
  </form>
  </div>
  <div class="col-md-6 col-xs-12">
  <ul>
  <li>Formats pris en compte : &nbsp;jpg&nbsp;&nbsp;jpeg&nbsp;&nbsp;gif&nbsp;&nbsp;png</li>
  <li>Poids maximum : 5 Mo</li>
  <li>Largeur et hauteur en pixels : > 0</li>
  <li>Taux de compression jpg ou gif :  0-100</li>
  <li>Qualit&eacute; png : 0-9</li>
  </ul>
  <?php
  $success = false;
  if(isset($_POST['submit']) && !empty($_POST['submit'])) {
  if(isset($_FILES['uploadImg']['name']) && @$_FILES['uploadImg']['name'] != "") {
  if($_FILES['uploadImg']['error'] > 0) {
  echo '<h4>Votre image dépasse le poids accepté par votre serveur</h4>';
  } else {
  if($_FILES['uploadImg']['size'] / 1024 <= 5120) {
  if($_FILES['uploadImg']['type'] == 'image/jpeg' ||
  $_FILES['uploadImg']['type'] == 'image/pjpeg' ||
  $_FILES['uploadImg']['type'] == 'image/png' ||
  $_FILES['uploadImg']['type'] == 'image/gif'){

  $upload_directory = '../../../site/file/source/images-compressees/';
  $source_file = $_FILES['uploadImg']['tmp_name'];
  $target_file = $upload_directory . $_FILES['uploadImg']['name'];
  $quality    = $_POST['quality'];

  // Obtention des infos largeur et hauteur nécessaires au calcul
  $image_info = getimagesize($source_file);
  $width = $image_info[0];
  $height = $image_info[1];
  // Redimensionnement avec ratio, proportions de l'image respectées
  $newwidth = (isset($_POST['width'])) ? (int) $_POST['width'] : 0;
  $newheight = (isset($_POST['height'])) ? (int) $_POST['height'] : 0;
  // Si les nouvelles dimensions sont supérieures aux originales
  if ($newwidth > $width || $newheight > $height)
  {
  echo "<h4 style=\"color:red;\">Dimensions de l'original : ".$width." x ".$height."</h4>";
  }
  // Si l'une des dimensions n'est pas spécifiée, la manquante est définie de façon à ne pas être une contrainte
  if (!$newwidth && $newheight)
  {
  $newwidth = 99999999999999;
  }
  elseif ($newwidth && !$newheight)
  {
  $newheight = 99999999999999;
  }
  // Configuration des ratios nécessaires au redimensionnement
  // On les compare pour déterminer comment redimensionner l'image (en fonction de la hauteur ou en fonction de la largeur)
  $xRatio = $newwidth / $width;
  $yRatio = $newheight / $height;
  // Redimensionnement de l'image en fonction de la largeur
  if ($xRatio * $height < $newheight)
  {
  $tnHeight = ceil($xRatio * $height);
  $tnWidth = $newwidth;
  }
  // Redimensionnement de l'image en fonction de la hauteur
  else
  {
  $tnWidth = ceil($yRatio * $width);
  $tnHeight = $newheight;
  }
  // Voila !
  $success = compress_image($source_file, $target_file, $tnWidth, $tnHeight, $quality);
  if($success) {
  // Optional. The original file is uploaded to the server only for the comparison purpose.
  copy($source_file, $upload_directory . "original_" . $_FILES['uploadImg']['name']);
  }
  }
  } else {
  echo '<h4>Pas plus de 5Mo !</h4>';
  }
  }
  } else {
  echo '<h4>Choisissez une image !</h4>';
  }
  }

  function compress_image($source_file, $target_file, $nwidth, $nheight, $quality) {
  //Return an array consisting of image type, height, widh and mime type.
  $image_info = getimagesize($source_file);
  if(!($nwidth > 0)) $nwidth = $image_info[0];
  if(!($nheight > 0)) $nheight = $image_info[1];

  if(!empty($image_info)) {
  switch($image_info['mime']) {
  case 'image/jpeg' :
  if($quality == '' || $quality < 0 || $quality > 100) $quality = 75; //Default quality
  // Create a new image from the file or the url.
  $image = imagecreatefromjpeg($source_file);
  $thumb = imagecreatetruecolor($nwidth, $nheight);
  //Resize the $thumb image
  imagecopyresized($thumb, $image, 0, 0, 0, 0, $nwidth, $nheight, $image_info[0], $image_info[1]);
  // Output image to the browser or file.
  return imagejpeg($thumb, $target_file, $quality);
  break;

  case 'image/png' :
  if($quality == '' || $quality < 0 || $quality > 9) $quality = 6; //Default quality
  // Create a new image from the file or the url.
  $image = imagecreatefrompng($source_file);
  $thumb = imagecreatetruecolor($nwidth, $nheight);
  //Resize the $thumb image
  imagecopyresized($thumb, $image, 0, 0, 0, 0, $nwidth, $nheight, $image_info[0], $image_info[1]);
  // Output image to the browser or file.
  return imagepng($thumb, $target_file, $quality);
  break;

  case 'image/gif' :
  if($quality == '' || $quality < 0 || $quality > 100) $quality = 75; //Default quality
  // Create a new image from the file or the url.
  $image = imagecreatefromgif($source_file);
  $thumb = imagecreatetruecolor($nwidth, $nheight);
  //Resize the $thumb image
  imagecopyresized($thumb, $image, 0, 0, 0, 0, $nwidth, $nheight, $image_info[0], $image_info[1]);
  // Output image to the browser or file.
  return imagegif($thumb, $target_file, $quality); //$success = true;
  break;

  default:
  echo '<h4>Ce type de fichier n\'est pas support&eacute; !</h4>';
  break;
  }
  }
  }
  ?>
  <!-- Displaying original and compressed images -->
  <?php if($success) { ?>
  <table>
  <tr>
  <td>
  <a href="<?php echo $upload_directory  . "original_" . $_FILES['uploadImg']['name']?>" target="_blank" title="Voir l'image"><img src='<?php echo $upload_directory  . "original_" . $_FILES['uploadImg']['name']?>'></a><br>100% : <?php echo round(filesize($upload_directory . "original_" . $_FILES['uploadImg']['name'])/1024,2) . " Ko";
  $imageToDelete = $upload_directory  . "original_" . $_FILES['uploadImg']['name']; ?>
  </td>
  <td>
  <?php
  if (empty($_POST['quality'])) { $compress = "Défaut : "; }
  else { $compress = $quality . "% : "; }
  ?>
  <a href="<?php echo $upload_directory . $_FILES['uploadImg']['name']?>" target="_blank" title="Voir l'image"><img src='<?php echo $upload_directory . $_FILES['uploadImg']['name']?> '></a><br><?php echo $compress . round(filesize($upload_directory . $_FILES['uploadImg']['name'])/1024, 2) . " Ko"; ?>
  </td>
  </tr>
  <tr>
  <td colspan="2">
  <a href="unlink.php?unlinkOriginal=<?php echo $imageToDelete;?>" title="... pour ne conserver que la version compress&eacute;e sur le serveur.">Supprimer la version originale ?</a>
  </td>
  </tr>
  </table>
  <?php } ?>
  </div>
  </div>
  </div>
  </body>
