<?php ob_start(); ?>

<div class="jumbotron jumbotron-fluid">
  <div class="container">
    <h1 class="display-4"><?= $media->getTitle(); ?></h1>
    <span class="badge badge-pill badge-primary"><?= $media->getType(); ?></span>
    <span class="badge badge-pill badge-primary"><?= $md->genre; ?></span>

</div>
</div>
<p class="lead"><?= $media->getSummary(); ?></p>

<?php $content = ob_get_clean(); ?>

<?php require('dashboard.php'); ?>
