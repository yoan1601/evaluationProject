<?php $this->load->view('admin/templates/header') ?>

<!-- Content wrapper -->
<div class="content-wrapper">

    <!-- Content -->

    <div class="container-fluid flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Liste et modification /</span> Type finition</h4>
        <div class="card">
        <h5 class="card-header">Liste des types finition</h5>
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>Finition</th>
                        <th style="text-align: right;">Taux</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    <?php foreach ($all_type_finition as $tf) { ?>
                        <tr>
                            <td><?= $tf->nom_tf ?></td>
                            <td style="text-align: right;"><?= format_currency($tf->aug_tf) ?> %</td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#modifier<?= $tf->id_tf ?>"><i class="bx bx-edit-alt me-1"></i> Modifier</a>
                                    </div>
                                    <!-- Modal modifier -->
                                    <div class="modal fade" id="modifier<?= $tf->id_tf ?>" aria-labelledby="modalToggleLabel" tabindex="-1" style="display: none;" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="modalToggleLabel">Modifier <?= $tf->id_tf ?></h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="<?= site_url('admin/crud/u_tf') ?>" method="post">
                                                        <input type="hidden" name="id_tf" value="<?= $tf->id_tf ?>">
                                                        <div class="mb-3">
                                                            <label for="exampleFormControlInput1" class="form-label">Finition</label>
                                                            <input type="text" class="form-control" id="exampleFormControlInput1" value="<?= $tf->nom_tf ?>" name="nom_tf">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="exampleFormControlInput1" class="form-label">Taux</label>
                                                            <input type="text" class="form-control" id="exampleFormControlInput1" value="<?= $tf->aug_tf ?>" name="aug_tf">
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