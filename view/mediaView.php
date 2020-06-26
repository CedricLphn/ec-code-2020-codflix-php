<?php ob_start(); ?>

<div id="" class="jumbotron jumbotron-fluid md-banner">
    <div class="overlay"></div>
    <div class="container ">
        <h1 class="display-4 text-center"><?= $media->getTitle(); ?></h1>
        <div class="text-center" id="info">
            <span class="badge <?= ($media->gettype == "Film") ? 'badge-warning' : 'badge-info' ?>"><?= $media->getType(); ?></span>
            <span class="badge badge-success"><?= $md->genre; ?></span>
            <span class="badge badge-dark"><?= $time_total; ?></span>
        </div>
        <div class="text-center">
            <a class="my-4 btn btn-danger btn-lg" href="?action=watch&media=<?= $media->getId(); ?>" role="button"><i class="fas fa-film"></i> Voir la bande annonce</a>
        </div>
        <div class="text-center watchlist">
            <i class="fa-heart pointer text-danger" id="favorite"></i>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row justify-content-md-center row-cols-2" id="actor">
    </div>

</div>
<div class="container-fluid">
    <p class="lead"><?= $media->getSummary(); ?></p>
    <?php
    if ($media->getType() == "Serie") {
        foreach ($serie as $key => $element) {

    ?>
            <div class="serie-season">
                <div class="title">
                    <h2>Saison <?= $key ?></h2>
                </div>
                <?php
                foreach ($serie[$key] as $episode) {
                ?>
                    <div class="serie-episode" style=" cursor:pointer;" onclick="toggle(<?= $episode['id'] ?>)">
                        <span class="text-left">
                            Episode <?= $episode['episode']; ?> : <?= $episode['title']; ?>
                        </span>
                        <span class="text-right" style="float:right;">
                            <?= ($episode['duration'] / 60 < 60) ? strftime("%M min", $episode['duration']) : strftime("%Hh et %M min", $episode['duration']); ?>
                        </span>
                    </div>
                    <div class="serie-detail" id="s<?= $episode['id'] ?>"" style=" display:none;">
                        <p><?= $episode['summary'] ?></p>
                        <p>
                            <div class="text-right">
                                <a class="btn btn-danger text-white" href="<?= "?action=watch&media=" . $media->getId() . "&id=" . $episode["id"]; ?>"><i class="fas fa-play"></i> Play</a>
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
    <script>
        var api_key = "b4d4c267aea648659aca8853a1f95666";
        var media_id = <?= $media->getId(); ?>;
        var media_title = "<?= $media->getTitle(); ?>";
    </script>
    <script src="public/js/media.js"></script>
