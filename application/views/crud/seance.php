<?php $this->load->view('templates/header') ?>

<!-- Content wrapper -->
<div class="content-wrapper">

    <!-- Content -->

    <div class="container-fluid flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">CRUD /</span> Seance</h4>
        <div class="card-body">
            <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#new">Nouveau</button>
            <a class="ms-3" href="<?= site_url('seance/exportdata') ?>"><button type="button" class="btn btn-warning">Exporter</button></a>
        </div>
        <!-- Modal creation -->
        <div class="modal fade" id="new" aria-labelledby="modalToggleLabel" tabindex="-1" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalToggleLabel">Nouveau</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="<?= site_url('seance/c_seance') ?>" method="post">
                            <div class="mb-3">
                                <label for="defaultSelect" class="form-label">Film</label>
                                <select id="defaultSelect" class="form-select" name="id_film">
                                    <?php foreach ($all_film as $film) { ?>
                                        <option value=<?= $film->id_film ?>><?= $film->nom_film ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="defaultSelect" class="form-label">Salle</label>
                                <select id="defaultSelect" class="form-select" name="id_salle">
                                    <?php foreach ($all_salle as $salle) { ?>
                                        <option value=<?= $salle->id_salle ?>><?= $salle->nom_salle ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="mb-3 row">
                                <label for="html5-datetime-local-input" class="col-md-2 col-form-label">Debut</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="datetime-local" value="" id="html5-datetime-local-input" name="date_heure_debut_seance">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="html5-datetime-local-input" class="col-md-2 col-form-label">Fin</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="datetime-local" value="" id="html5-datetime-local-input" name="date_heure_fin_seance">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-success">Creer</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Fin Modal creation -->
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="card">
                    <form action="<?= site_url("seance/importdata") ?>" method="post" enctype="multipart/form-data">
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="formFile" class="form-label">Importation via CSV </label>
                                <input class="form-control" type="file" id="formFile" name="submited_file" required>
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
        <div class="card">
            <h5 class="card-header">Liste des seances</h5>
            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Film</th>
                            <th>Salle</th>
                            <th>Debut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        <?php foreach ($all_seance as $seance) { ?>
                            <tr>
                                <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong><?= $seance->nom_film ?></strong></td>
                                <td><?= $seance->nom_salle ?></td>
                                <td><?= format_date_time($seance->date_heure_debut_seance) ?></td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#modalToggle<?= $seance->id_seance ?>"><i class="bx bx-detail me-1"></i> Detail</a>
                                            <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#modifier<?= $seance->id_seance ?>"><i class="bx bx-edit-alt me-1"></i> Modifier</a>
                                            <a class="dropdown-item" href="<?= site_url('seance/d_seance/' . $seance->id_seance) ?>"><i class="bx bx-trash me-1"></i> Supprimer</a>
                                        </div>
                                        <!-- Modal detail -->
                                        <div class="modal fade" id="modalToggle<?= $seance->id_seance ?>" aria-labelledby="modalToggleLabel" tabindex="-1" style="display: none;" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="modalToggleLabel">Fiche <?= $seance->id_seance ?></h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <h6 class="fw-bold py-3 mb-2"><span class="text-muted fw-light">ID :</span> <?= $seance->id_seance ?></h6>
                                                        <h6 class="fw-bold py-3 mb-2"><span class="text-muted fw-light">Film :</span> <?= $seance->nom_film ?></h6>
                                                        <h6 class="fw-bold py-3 mb-2"><span class="text-muted fw-light">Salle :</span> <?= $seance->nom_salle ?></h6>
                                                        <h6 class="fw-bold py-3 mb-2 w-100"><span class="text-muted fw-light">Debut :</span> <?= $seance->date_heure_debut_seance ?></h6>
                                                        <h6 class="fw-bold py-3 mb-2 w-100"><span class="text-muted fw-light">Fin :</span> <?= $seance->date_heure_fin_seance ?></h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Fin Modal detail -->
                                        <!-- Modal modifier -->
                                        <div class="modal fade" id="modifier<?= $seance->id_seance ?>" aria-labelledby="modalToggleLabel" tabindex="-1" style="display: none;" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="modalToggleLabel">Modifier <?= $seance->id_seance ?></h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="<?= site_url('seance/u_seance') ?>" method="post">
                                                            <input type="hidden" name="id" value="<?= $seance->id_seance ?>">
                                                            <div class="mb-3">
                                                                <label for="defaultSelect" class="form-label">Film</label>
                                                                <select id="defaultSelect" class="form-select" name="id_film">
                                                                    <?php foreach ($all_film as $film) { ?>
                                                                        <option value=<?= $film->id_film ?>><?= $film->nom_film ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="defaultSelect" class="form-label">Salle</label>
                                                                <select id="defaultSelect" class="form-select" name="id_salle">
                                                                    <?php foreach ($all_salle as $salle) { ?>
                                                                        <option value=<?= $salle->id_salle ?>><?= $salle->nom_salle ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                            <div class="mb-3 row">
                                                                <label for="html5-datetime-local-input" class="col-md-2 col-form-label">Debut</label>
                                                                <div class="col-md-10">
                                                                    <input class="form-control" type="datetime-local" value="<?= $seance->date_heure_debut_seance ?>" id="html5-datetime-local-input" name="date_heure_debut_seance">
                                                                </div>
                                                            </div>
                                                            <div class="mb-3 row">
                                                                <label for="html5-datetime-local-input" class="col-md-2 col-form-label">Fin</label>
                                                                <div class="col-md-10">
                                                                    <input class="form-control" type="datetime-local" value="<?= $seance->date_heure_fin_seance ?>" id="html5-datetime-local-input" name="date_heure_fin_seance">
                                                                </div>
                                                            </div>
                                                            <button type="submit" class="btn btn-warning">Modifier</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Fin Modal modifier -->
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!--/ Layout Demo -->
    </div>
    <!-- / Content -->

    <?php $this->load->view('templates/footer') ?>