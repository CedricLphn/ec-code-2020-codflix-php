<?php ob_start(); ?>
Nothing to do
<?php $content = ob_get_clean(); ?>

<?php require(__DIR__ . '/dashboard.php'); ?>