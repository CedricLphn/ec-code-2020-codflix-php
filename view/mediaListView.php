<?php ob_start(); ?>
<div class="media-list" id="favorite">
    <?php require('watchlistView.php'); ?>
</div>

<div class="row">
    <div class="col-md-4 offset-md-8">
        <form method="get">
            <div class="form-group has-btn">
                <input type="search" id="search" name="title" value="<?= $search; ?>" class="form-control"
                       placeholder="Rechercher un film ou une série">

                <button type="button" class="btn btn-block bg-red">Valider</button>
            </div>
        </form>
    </div>
</div>

<div class="media-list" id="results">
    <?php require('api/searchView.php'); ?>
</div>

<?php $content = ob_get_clean(); ?>

<?php require('dashboard.php'); ?>

<script>
    $('#search').on('keypress', function (e) {
        if (e.keyCode == 13) {
        e.preventDefault();
        }
        
        let search = $("#search").val();

        $.ajax(`/api/?action=search&query=${search}`).done((data) => {
            $("#results").html(data);
        }).fail(() => {
            $("#results").text("Aucun résultat");
        })
    });
</script>