<?php $this->load->view('admin/templates/header') ?>

<!-- Content wrapper -->
<div class="content-wrapper">

    <!-- Content -->

    <div class="container-fluid flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Devis /</span> Liste des travaux</h4>
        <div class="card mb-3">
        <div class="modal-body">
            <h6 class="fw-bold py-3 mb-2"><span class="text-muted fw-light">Reference :</span> <?= $devis->ref_devis ?></h6>
            <h6 class="fw-bold py-3 mb-2"><span class="text-muted fw-light">Type de maison :</span> <?= $devis->nom_tm_devis ?></h6>
            <h6 class="fw-bold py-3 mb-2"><span class="text-muted fw-light">Lieu :</span> <?= $devis->lieu_devis ?></h6>
            <h6 class="fw-bold py-3 mb-2"><span class="text-muted fw-light">Surface :</span> <?= format_currency($devis->surface_tm_devis) ?></h6>
            <h6 class="fw-bold py-3 mb-2"><span class="text-muted fw-light">Finition :</span> <?= $devis->nom_tf_devis ?> (<?= $devis->aug_tf_devis ?> %)</h6>
            <h6 class="fw-bold py-3 mb-2"><span class="text-muted fw-light">Prix total :</span> <?= format_currency($devis->prix_total_devis) ?> Ar</h6>
            <h6 class="fw-bold py-3 mb-2"><span class="text-muted fw-light">Montant déjà payé :</span> <?= format_currency($devis->montant_paye_devis) ?> Ar</h6>
            <h6 class="fw-bold py-3 mb-2"><span class="text-muted fw-light">Reste à payer :</span> <?= format_currency($devis->prix_total_devis - $devis->montant_paye_devis) ?> Ar</h6>
        </div>
        </div>
        <div class="card mb-2">
            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Designation</th>
                            <th>Unite</th>
                            <th style="text-align: right;">Quantite</th>
                            <th style="text-align: right;">Prix unitaire</th>
                            <th style="text-align: right;">Total</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        <?php foreach ($liste_travaux as $travaux) { ?>
                            <tr>
                                <td><?= $travaux->code_tt_histo ?></td>
                                <td><?= $travaux->nom_tt_histo ?></td>
                                <td><?= $travaux->nom_unite_histo ?></td>
                                <td style="text-align: right;"><?= format_currency($travaux->quantite_tt_histo) ?></td>
                                <td style="text-align: right;"><?= format_currency($travaux->pu_tt_histo) ?> Ar</td>
                                <td style="text-align: right;"><?= format_currency($travaux->prix_total_tt_histo) ?> Ar</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="alert alert-warning" style="text-align: right;" role="alert"><span class="ms-3">Total travaux</span><span  class="ms-3"><strong><?= format_currency($devis->prix_brut_devis) ?> Ar</strong></span></div>
        <div class="alert alert-primary" style="text-align: right;" role="alert"><span class="ms-3">Taux finition</span><span  class="ms-3"><strong><?= format_currency($devis->aug_tf_devis) ?> %</strong></span></div>
        <div class="alert alert-primary" style="text-align: right;" role="alert"><span class="ms-3">Total devis</span><span  class="ms-3"><strong><?= format_currency($devis->prix_total_devis) ?> Ar</strong></span></div>
    </div>
    <!-- / Content -->

    <?php $this->load->view('admin/templates/footer') ?>