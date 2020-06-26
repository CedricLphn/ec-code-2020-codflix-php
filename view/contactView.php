<?php ob_start(); ?>

<div class="landscape">
    <div class="bg-black">
        <div class="row no-gutters">
            <div class="col-md-6 full-height bg-white">
                <div class="auth-container">
                    <h2><span>Cod</span>'Flix</h2>
                    <h3>Un problème, une question ? Nous avons la solution</h3>

                    <form method="post" action="index.php?action=contact" class="custom-form">
                        <?php
                        if (!isset($success_msg)) {
                        ?>

                        <div class="form-group">
                            <label for="email">Adresse email</label>
                            <input type="email" name="email" value="<?= $contact->email; ?>" id="email"
                                class="form-control" />
                        </div>

                        <div class="form-group">
                            <label for="email">Objet de la demande</label>
                            <input name="subject" value="<?= $contact->subject; ?>" id="email" class="form-control" />
                        </div>

                        <div class="form-group">
                            <label for="message">Votre message :</label>
                            <textarea name="message" class="form-control" id="message" placeholder="Mon message"
                                rows="3"><?= $contact->message ?></textarea>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <a href="index.php" class="btn btn-block bg-blue">Retour</a>
                                </div>
                                <div class="col-md-6">
                                    <input type="submit" name="Valider" class="btn btn-block bg-red" />
                                </div>
                            </div>
                        </div>
                        <span class="error-msg">
                            <?= isset($error_msg) ? $error_msg : null; ?>
                        </span>
                        <?php
                        } else {
                        ?>
                        <span class="error-msg text-success">
                            <?= $success_msg ?>
                        </span>
                        <hr />
                        <div class="row">
                            <div class="col-md-12">
                                <a href="index.php" class="btn btn-block bg-danger">Retour</a>
                            </div>
                        </div>
                        <?php
                        }
                        ?>
                    </form>
                </div>
            </div>
            <div class="col-md-6 full-height">
                <div class="auth-container">
                    <h1>Contact</h1>
                </div>
            </div>
        </div>
    </div>
</div>


<?php $content = ob_get_clean(); ?>

<?php require(__DIR__ . '/base.php'); ?>