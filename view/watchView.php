<?php ob_start(); ?>
<div class="navbar" style="clear: both;">
  <span style="float:left;"> <a class="btn btn-danger text-white" href="?media=<?= htmlentities($_GET['media']) ?>"><i class="fas fa-chevron-left"></i></a></span>
  <span>
    <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#exampleModalCenter">
      <?= ($type == "movie") ? $media->getTitle() . " - Trailer" : $media->getMediaTitle(); ?>
    </button>
  </span>
  </p>
</div>
<div id="movie">
  <iframe class="fullscreen" width="560" height="315" src="<?= $type == "movie" ? $media->getTrailerUrl() : $media->getMediaUrl(); ?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
</div>
<!-- Button trigger modal -->


<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"><?= $type == "movie" ? $media->getTitle() : "Résumé de l'épisode ".$media->getEpisode(). " de ". $media->getMediaTitle() ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?= $media->getSummary(); ?>
      </div>
    </div>
  </div>
</div>

<?php $content = ob_get_clean(); ?>
<script>
  $('#myModal').on('shown.bs.modal', function() {
    $('#myInput').trigger('focus')
  })
</script>
<?php require('base.php'); ?>