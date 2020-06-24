<?php ob_start(); ?>
<div class="jumbotron jumbotron-fluid landscape cover text-white">
    <div class="container">
        <h1 class="display-4">Mon historique</h1>
        <p class="lead">Approuvé par la NSA évidemment...</p>
    </div>
</div>

<table class="table">
    <thead class="thead-dark">
        <tr>
            <th scope="col">Nom</th>
            <th scope="col">Commencé le</th>
            <th scope="col">Terminé le</th>
            <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($history as $media) : ?>
            <tr>
                <th scope="row"><?= $media["media_title"] ?><?= $media["serie_title"] != NULL ? ': Episode ' . $media["episode"] . ' saison ' . $media["season"] : ''; ?></th>
                <td><?= $media['start_date'] ?></td>
                <td><?= $media['finish_date'] == NULL ? '-' : $media['finish_date'] ?></td>
                <td><a class="btn btn-danger text-white"><i class="fas fa-trash-alt"></i></a></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<div class="text-center">
    <button type="button" class="btn btn-danger text-white" data-toggle="modal" data-target="#staticBackdrop"><i class="fas fa-trash-alt"></i> Supprimer mon historique</button>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#staticBackdrop">
        Launch static backdrop modal
    </button>
</div>

<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Voulez-vous supprimer votre historique ?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Supprimer votre historique nuira à l'expérience utilisateur et aux Big Browser
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">En faite non</button>
                <button type="button" class="btn btn-danger" id="confirm">Supprimer mon historique</button>
            </div>
        </div>
    </div>
</div>


<?php $content = ob_get_clean(); ?>

<?php require('dashboard.php'); ?>

<script>
    $('#myModal').on('shown.bs.modal', function() {
        $('#staticBackdrop').trigger('focus')

    })

    $("#confirm").click(() => {
        $("#confirm").prop('disabled', true);
        //$('#staticBackdrop').modal('hide');
    })
</script>