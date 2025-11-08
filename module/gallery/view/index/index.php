<?php if($module::$galleries): ?>
	<?php $i = 1; ?>
	<?php $galleriesNb = count($module::$galleries); ?>
	<?php foreach($module::$galleries as $galleryId => $gallery): ?>
		<?php if($i % 4 === 1): ?>
			<div class="row">
		<?php endif; ?>
			<div class="col3">
				<a href="<?php echo helper::baseUrl() . $this->getUrl(0); ?>/<?php echo $galleryId; ?>" class="galleryPicture">
					<img src="<?php echo helper::baseUrl(false) ?>module/gallery/thumbnailer.php?img=<?php echo $module::$firstPictures[$galleryId]; ?>&ratio=240" alt="<?php echo $gallery['config']['name']; ?>">
					<div class="galleryName"><?php echo $gallery['config']['name']; ?></div>
				</a>
			</div>
		<?php if($i % 4 === 0 OR $i === $galleriesNb): ?>
			</div>
		<?php endif; ?>
		<?php $i++; ?>
	<?php endforeach; ?>
<?php else: ?>
	<?php echo template::speech('Aucune galerie.'); ?>
<?php endif; ?>
