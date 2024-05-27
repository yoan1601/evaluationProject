<?php $this->load->view('admin/templates/header') ?>

<!-- Content wrapper -->
<div class="content-wrapper">

    <!-- Content -->

    <div class="container-fluid flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Liste et modification /</span> Type travaux</h4>
        <div class="card">
        <h5 class="card-header">Liste des types travaux</h5>
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Type</th>
                        <th>Unite</th>
                        <th style="text-align: right;">Prix unitaire</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    <?php foreach ($all_type_travaux as $tt) { ?>
                        <tr>
                            <td><?= $tt->code_tt ?></td>
                            <td><?= $tt->nom_tt ?></td>
                            <td><?= $tt->nom_unite ?></td>
                            <td style="text-align: right;"><?= format_currency($tt->pu_tt) ?> Ar</td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#modifier<?= $tt->id_tt ?>"><i class="bx bx-edit-alt me-1"></i> Modifier</a>
                                    </div>
                                    <!-- Modal modifier -->
                                    <div class="modal fade" id="modifier<?= $tt->id_tt ?>" aria-labelledby="modalToggleLabel" tabindex="-1" style="display: none;" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="modalToggleLabel">Modifier <?= $tt->id_tt ?></h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="<?= site_url('admin/crud/u_tt') ?>" method="post">
                                                        <input type="hidden" name="id_tt" value="<?= $tt->id_tt ?>">
                                                        <div class="mb-3">
                                                            <label for="exampleFormControlInput1" class="form-label">Code</label>
                                                            <input type="text" class="form-control" id="exampleFormControlInput1" value="<?= $tt->code_tt ?>" name="code_tt">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="exampleFormControlInput1" class="form-label">Type</label>
                                                            <input type="text" class="form-control" id="exampleFormControlInput1" value="<?= $tt->nom_tt ?>" name="nom_tt">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="defaultSelect" class="form-label">Unite</label>
                                                            <select id="defaultSelect" class="form-select" name="id_unite">
                                                                <?php foreach ($all_unite as $unite) { ?>
                                                                    <?php if($unite->id_unite == $tt->id_unite) { ?>
                                                                        <option value=<?= $unite->id_unite ?> selected><?= $unite->nom_unite ?></option>
                                                                    <?php } else { ?>
                                                                        <option value=<?= $unite->id_unite ?>><?= $unite->nom_unite ?></option>
                                                                    <?php } ?>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="exampleFormControlInput1" class="form-label">Prix unitaire</label>
                                                            <input type="text" class="form-control" id="exampleFormControlInput1" value="<?= $tt->pu_tt ?>" name="pu_tt">
                                                        </div>
                                                        <button type="submit" class="btn btn-warning">Modifier</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    </div>
    <!-- / Content -->

<?php $this->load->view('admin/templates/footer') ?>