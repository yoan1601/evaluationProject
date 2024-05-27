<?php $this->load->view('admin/templates/header') ?>

<!-- Content wrapper -->
<div class="content-wrapper">

    <!-- Content -->

    <div class="container-fluid flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Devis /</span> Liste</h4>
        <div class="card">
        <h5 class="card-header">Liste des devis</h5>
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>Ref</th>
                        <th>Client</th>
                        <th>Lieu</th>
                        <th>Maison</th>
                        <th>Surface</th>
                        <th>Finition</th>
                        <th>Date devis</th>
                        <th>Debut travaux</th>
                        <th>Fin travaux</th>
                        <th style="text-align: right;">Prix total</th>
                        <th style="text-align: right;">Paiement effectué</th>
                        <th style="text-align: right;">% Paiement</th>
                        <th></th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    <?php foreach ($all_devis as $devis) { ?>
                        <tr>
                            <td class="<?= $devis->bg_color ?>" style="color: white;"><?= $devis->ref_devis ?></td>
                            <td><?= $devis->numero_cli ?></td>
                            <td><?= $devis->lieu_devis ?></td>
                            <td><?= $devis->nom_tm_devis ?></td>
                            <td><?= format_currency($devis->surface_tm_devis) ?></td>
                            <td><?= $devis->nom_tf_devis ?></td>
                            <td><?= format_date($devis->dateheure_creation_devis) ?></td>
                            <td><?= format_date($devis->dateheure_debut_travaux) ?></td>
                            <td><?= format_date($devis->dateheure_fin_travaux) ?></td>
                            <td style="text-align: right;"><?= format_currency($devis->prix_total_devis) ?> Ar</td>
                            <td style="text-align: right;"><?= format_currency($devis->montant_paye_devis) ?> Ar</td>
                            <td style="text-align: right"><?= format_currency($devis->pourcentage_paiement) ?> %</td>
                            <td class="<?= $devis->bg_color ?>" style="color: white;"></td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item text-center" href="<?= site_url("admin/devis/to_liste_travaux/".$devis->id_devis) ?>"><i class="bx bx-pdf me-1"></i> Liste des travaux</a>
                                        <a class="dropdown-item text-center" href="<?= site_url("admin/devis/to_liste_paiement/".$devis->id_devis) ?>"><i class="bx bx-pdf me-1"></i> Liste des paiements</a>
                                        <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#modalToggle<?= $devis->id_devis ?>"><i class="bx bx-money me-1"></i> Detail</a>
                                    </div>
                                    <div class="modal fade" id="modalToggle<?= $devis->id_devis ?>" aria-labelledby="modalToggleLabel" tabindex="-1" style="display: none;" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="modalToggleLabel">Details <?= $devis->ref_devis ?></h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <h6 class="fw-bold py-3 mb-2"><span class="text-muted fw-light">Reference :</span> <?= $devis->ref_devis ?></h6>
                                                    <h6 class="fw-bold py-3 mb-2"><span class="text-muted fw-light">Client :</span> <?= $devis->numero_cli ?></h6>
                                                    <h6 class="fw-bold py-3 mb-2"><span class="text-muted fw-light">Lieu :</span> <?= $devis->lieu_devis ?></h6>
                                                    <h6 class="fw-bold py-3 mb-2"><span class="text-muted fw-light">Type de maison :</span> <?= $devis->nom_tm_devis ?></h6>
                                                    <h6 class="fw-bold py-3 mb-2"><span class="text-muted fw-light">Finition :</span> <?= $devis->nom_tf_devis ?> (<?= $devis->aug_tf_devis ?> %)</h6>
                                                    <h6 class="fw-bold py-3 mb-2"><span class="text-muted fw-light">Prix total :</span> <?= format_currency($devis->prix_total_devis) ?> Ar</h6>
                                                    <h6 class="fw-bold py-3 mb-2"><span class="text-muted fw-light">Montant déjà payé :</span> <?= format_currency($devis->montant_paye_devis) ?> Ar</h6>
                                                    <h6 class="fw-bold py-3 mb-2"><span class="text-muted fw-light">Reste à payer :</span> <?= format_currency($devis->prix_total_devis - $devis->montant_paye_devis) ?> Ar</h6>
                                                    <h6 class="fw-bold py-3 mb-2"><span class="text-muted fw-light"> % Paiement :</span> <?= format_currency($devis->pourcentage_paiement) ?> %</h6>
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