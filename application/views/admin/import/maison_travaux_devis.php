<?php $this->load->view('admin/templates/header') ?>

<!-- Content wrapper -->
<div class="content-wrapper">

    <!-- Content -->

    <div class="container-fluid flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Importation de données /</span> Maison - travaux et devis</h4>
        <div class="row mb-3">
            <div class="col-md-6 mx-auto">
                <div class="card">
                    <form action="<?= site_url("admin/import/import_maison_travaux_devis") ?>" method="post" enctype="multipart/form-data">
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="formFile" class="form-label">Maison - travaux</label>
                                <input class="form-control" type="file" id="formFile" name="maison_travaux" required>
                            </div>
                            <div class="mb-3">
                                <label for="formFile" class="form-label">Devis</label>
                                <input class="form-control" type="file" id="formFile" name="devis" required>
                            </div>
                            <button type="submit" class="btn btn-success">Importer</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-6">
                <?php
                if (isset($errors)) {
                    foreach ($errors as $key => $error) { ?>
                        <div class="alert alert-warning alert-dismissible" role="alert">
                            <?= $error ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                <?php }
                }
                ?>
            </div>
        </div>
    </div>
</div>
    <!-- / Content -->

<?php $this->load->view('admin/templates/footer') ?>