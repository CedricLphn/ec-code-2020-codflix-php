<?php foreach( $medias as $media ): ?>
<div class="item">
    <a class="" href="index.php?media=<?= $media['id']; ?>">
        <div class="video">
            <div>
                <iframe allowfullscreen="" frameborder="0" src="<?= $media['trailer_url'].'?autoplay=1'?>"></iframe>
            </div>
            <div class="text-center">
                <h5><span
                        class="badge <?= $media['type'] == "Film" ? 'badge-warning': 'badge-info' ?>"><?= $media['type'] ?></span>
                </h5>

                <?php
                    if($search):
                    ?>
                <div class="badge badge-pill badge-danger"><?= date_format(date_create($media['release_date']), 'Y') ?>
                </div>
                <?php
                    endif;
                    ?>
            </div>
        </div>
        <div class="title">
            <?= $media['title']; ?>
        </div>
    </a>

</div>
<?php endforeach; ?>