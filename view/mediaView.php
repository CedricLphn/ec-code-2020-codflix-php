<?php ob_start(); ?>

<div id="" class="jumbotron jumbotron-fluid  md-banner">
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

</div>

<?php require('dashboard.php'); ?>
<script>
    let api_key = "b4d4c267aea648659aca8853a1f95666";
    $.ajax({
            url: 'https://api.themoviedb.org/3/search/tv?api_key=' + api_key + '&language=fr&query=<?= $media->getTitle() ?>',
            dataType: 'jsonp',
        })
        .then(function(response) {
            response = response.results[0];
            $("#info").append(`<span class="badge badge-primary">${response.vote_average}</span>`)
            $(".jumbotron").css("background-image", `url(http://image.tmdb.org/t/p/original/${response.backdrop_path})`)
            $(".jumbotron").css("background-size", `cover`)
            let id = response.id;
            $.ajax({
                    url: 'https://api.themoviedb.org/3/movie/' + id + '/credits?api_key=' + api_key + '',
                    dataType: 'jsonp',
                })
                .then(function(credit) {
                    for(let i = 0 ; i < 5; i++) {
                        let poster = credit.cast[i].profile_path != null ? `http://image.tmdb.org/t/p/w154/${credit.cast[i].profile_path}` : 'public/img/default.jpg'
                        let html = `
        <div class="col-lg-2 ">
            <div class="row">
                <img src="${poster}" />
            </div>
            <div class="row">
                ${credit.cast[i].name}
            </div>
        </div>`;
        console.log(html);
                        $("#actor").append(html);
                    }

                });
        });

    function toggle(block_id) {
        $(`#s${block_id}`).slideToggle();
    }
</script>