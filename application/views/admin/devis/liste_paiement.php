<?php $this->load->view('admin/templates/header') ?>

<!-- Content wrapper -->
<div class="content-wrapper">

    <!-- Content -->

    <div class="container-fluid flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Devis /</span> Liste des paiements devis <?= $devis->ref_devis ?></h4>
        <div class="card mb-2">
            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Ref</th>
                            <th style="text-align: right;">Montant</th>
                            <th>Date de paiement</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        <?php foreach ($liste_paiement as $paiement) { ?>
                            <tr>
                                <td><?= $paiement->ref_paiement ?></td>
                                <td style="text-align: right;"><?= $paiement->montant_paiement ?> Ar</td>
                                <td><?= format_date($paiement->dateheure_paiement) ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- / Content -->

    <?php $this->load->view('admin/templates/footer') ?>