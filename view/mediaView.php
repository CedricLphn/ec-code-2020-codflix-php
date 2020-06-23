<?php ob_start(); ?>

<div class="jumbotron jumbotron-fluid">
    <div class="container">
        <h1 class="display-4 text-center"><?= $media->getTitle(); ?></h1>
        <div class="text-center">
            <span class="badge badge-pill badge-primary"><?= $media->getType(); ?></span>
            <span class="badge badge-pill badge-primary"><?= $md->genre; ?></span>
        </div>

    </div>
</div>
<p class="lead"><?= $media->getSummary(); ?></p>
<?php
if($media->getType() == "Serie") {
    foreach($serie as $key => $element) {
?>
<div class="serie-season">
    <div class="title">
        <h2>Saison <?= $key ?></h2>
    </div>
    <?php
    foreach($serie[$key] as $episode) {
    ?>
    <div class="serie-episode">
        <span class="text-left">
            Episode <?= $episode['episode']; ?> : <?= $episode['title']; ?>
        </span>
        <span class="text-right" style="float:right">
            <?= $episode['duree']; ?> MIN A MODIFIER
        </span>
    </div>
    <div class="serie-detail">
        <p><?= $episode['description'] ?></p>
        <p>
            <div class="text-right">
                <button type="button" class="btn btn-danger"><i class="fas fa-play"></i> Play</button>

            </div>
        </p>
    </div>
    <?php
    }
    ?>
</div>
<?php
    }
}

$content = ob_get_clean(); 
?>

<?php require('dashboard.php'); ?>