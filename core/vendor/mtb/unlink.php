<?php
if (isset($_GET['unlinkOriginal'])) {
  $imageToDelete = $_GET['unlinkOriginal'];
  unlink($imageToDelete);
  }
  header('Location: ../../../core/vendor/mtb/index.php');
?>
