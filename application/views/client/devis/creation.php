<?php $this->load->view('client/templates/header') ?>
<?php $now = new DateTime(); ?>

<!-- Content wrapper -->
<div class="content-wrapper">

    <!-- Content -->
    <div class="container-fluid flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Devis /</span> Creation</h4>
        <form action="<?= site_url("client/devis/creer_devis") ?>" method="post">
        <h5 class="fw-bold py-3 mb-2">Type de maison</h5>
        <div class="row mb-4">
            <?php foreach ($all_type_maisons as $type_maison) { ?>
                <div class="col-md-6 col-lg-4 mb-3">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title text-center"><?= $type_maison->nom_tm ?></h5>
                            <h3 class="card-title mb-4 text-center text-info">Ar <?= format_currency($type_maison->prix_total_tm) ?></h3>
                            <h5 class="card-title mb-4 text-center text-primary"><span class="text-muted">Duree</span> <?= format_currency($type_maison->duree_tm) ?> Jours</h5>
                            <?php foreach ($type_maison->descriptions as $descri) { ?>
                                <p class="card-text text-center">
                                    <?= $descri->descri ?>
                                </p>
                            <?php } ?>
                            <div class="form-check mt-3 d-flex justify-content-center">
                                <input name="id_tm" class="form-check-input" type="radio" value="<?= $type_maison->id_tm ?>" id="defaultRadio1" required>
                                <label class="form-check-label ms-3" for="defaultRadio1"> Je suis interressé(e) </label>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
        <h5 class="fw-bold py-3 mb-2">Type de finition</h5>
        <div class="row mb-5">
            <select class="form-select w-50" name="id_tf" id="exampleFormControlSelect1" aria-label="Default select example" required>
                <?php foreach ($all_type_finitions as $tf) { ?>
                    <option value="<?= $tf->id_tf ?>"><?= $tf->nom_tf ?> (prix total + <?= $tf->aug_tf ?>%)</option>
                <?php } ?>
            </select>
        </div>

        <div class="mb-3 row">
            <div class="col-md-6">
                <h5 class="fw-bold mb-2">Date du debut des travaux</h5>
                <div class="col-md-8">
                    <input class="form-control" type="datetime-local" value="<?= date_format($now,"Y-m-d H:i:s") ?>" name="dateheure_debut_travaux" id="html5-datetime-local-input" required>
                </div>
            </div>
            <div class="col-md-6">
            <h5 class="fw-bold mb-2">Date de création de ce devis</h5>
                <div class="col-md-8">
                    <input class="form-control" type="datetime-local" value="<?= date_format($now,"Y-m-d H:i:s") ?>" name="dateheure_creation_devis" id="html5-datetime-local-input" required>
                </div>
            </div>
        </div>

        <div class="mb-3 row">
            <div class="col-md-6">
                <h5 class="fw-bold mb-2">Reference du devis</h5>
                <div class="col-md-8">
                    <input class="form-control" type="text" name="ref_devis" id="html5-text-input" required>
                </div>
            </div>
            <div class="col-md-6">
            <h5 class="fw-bold mb-2">Lieu de construction</h5>
                <div class="col-md-8">
                    <input class="form-control" type="text" name="lieu_devis" id="html5-text-input" required>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-success">Creer le devis</button>
        </form>
    </div>
    <!-- / Content -->

    <?php $this->load->view('client/templates/footer') ?>