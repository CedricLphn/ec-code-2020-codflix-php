<?php ob_start(); ?>
<div class="container">
    <?php if (isset($success_msg)) : ?>
        <div class="alert alert-success" role="alert">
            <?= $success_msg ?>
        </div>
    <?php elseif (isset($error_msg)) : ?>
        <div class="alert alert-danger" role="alert">
            <?= $error_msg ?>
        </div>
    <?php
    endif;
    ?>

    <!--
        EMAIL
    -->

    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <form id="email" method="post" action="index.php?action=profil" class="custom-form">
                    <h5 class="card-header">Mon adresse email</h5>
                    <div class="card-body">
                        <h5 class="card-title">Changer mon adresse e-mail</h5>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">@</span>
                            </div>
                            <input type="text" value="<?= $user['email']; ?>" class="form-control" disabled>
                        </div>
                        <div class="form-group">
                            <label for="new_email">Nouvel adresse e-mail</label>
                            <input type="email" class="form-control" id="new_email" name="new_email">
                        </div>
                        <div class="form-group">
                            <label for="confirm_email">Retaper votre adresse email</label>
                            <input type="email" class="form-control" id="confirm_email" name="confirm_email">
                        </div>
                        <div class="text-right">
                            <input type="hidden" name="action" value="email" /><input type="submit" class="btn btn-primary text-right" name="Valider" value="Changer mon adresse e-mail" />
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>

    <!--
        PASSWORD
    -->

    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <form id="email" method="post" action="index.php?action=profil" class="custom-form">
                    <h5 class="card-header">Mon mot de passe</h5>
                    <div class="card-body">
                        <h5 class="card-title">Changer mon mot de passe</h5>
                        <div class="form-group">
                            <label for="password">Ancien mot de passe</label>
                            <input type="password" class="form-control" id="password" name="password">
                        </div>
                        <div class="form-group">
                            <label for="new_password">Nouveau mot de passe</label>
                            <input type="password" class="form-control" id="new_password" name="new_password">
                        </div>
                        <div class="form-group">
                            <label for="confirm">Confirmer votre mot de passe</label>
                            <input type="password" class="form-control" id="confirm" name="confirm">
                        </div>
                        <div class="text-right">
                            <input type="hidden" name="action" value="password" /><input type="submit" class="btn btn-primary text-right" name="Valider" value="Changer mon mot de passe" />
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>

    <!--
        DELETE ACCOUNT
    -->


    <div class="row">
        <div class="col-12">
            <div class="card">
                <h5 class="card-header">Supprimer mon compte</h5>
                <div class="card-body">
                    <div class="text-center">
                        <img src="public/img/disuasion.jpg" width="40%" />
                    </div>
                    <p class="card-text">Quitter Cod'Flix, c'est quitter une famille. Chaque fois que tu y songe, pense à ce chat qui risque sa vie pour que tu restes. Nous avons vécu beaucoup de belles choses, ce chat t'apprécie énormement mais nous comprenons ton choix...</p>
                    <form id="email" method="post" action="index.php?action=profil" class="custom-form">
                        <div class="form-group">
                            <label for="delete_account">Mot de passe... pour une dernière fois.</label>
                            <input type="password" class="form-control" name="delete_account" id="delete_account">
                        </div>
                        <div class="text-right">
                            <input type="hidden" name="action" value="delete" /><input type="submit" class="btn btn-danger text-right" name="Valider" value="Supprimer mon compte" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $content = ob_get_clean(); ?>

<?php require(__DIR__ . '/dashboard.php'); ?>