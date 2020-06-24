<?php ob_start(); ?>

<div class="jumbotron jumbotron-fluid">
    <div class="container">
        <h1 class="display-4 text-center"><?= $media->getTitle(); ?></h1>
        <div class="text-center">
            <span class="badge badge-pill badge-primary"><?= $media->getType(); ?></span>
            <span class="badge badge-pill badge-primary"><?= $md->genre; ?></span>
            <span class="badge badge-pill badge-primary"><?= $time_total; ?></span>
        </div>
        <div class="text-center">
            <a class="my-4 btn btn-danger btn-lg" href="?action=watch&media=<?= $media->getId(); ?>" role="button"><i class="fas fa-film"></i> Voir la bande annonce</a>
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
            <?= ($episode['duration'] / 60 < 60) ? strftime("%M min", $episode['duration']) :strftime("%Hh et %M min", $episode['duration']); ?>
        </span>
    </div>
    <div class="serie-detail">
        <p><?= $episode['summary'] ?></p>
        <p>
            <div class="text-right">
                <a class="btn btn-danger text-white" href="<?= "?action=watch&media=".$media->getId()."&id=".$episode["id"]; ?>"><i class="fas fa-play"></i> Play</a>
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