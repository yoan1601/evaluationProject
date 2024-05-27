<?php $this->load->view('client/templates/header') ?>

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
                            <th>Lieu</th>
                            <th>Maison</th>
                            <th>Surface</th>
                            <th>Finition</th>
                            <th>Debut travaux</th>
                            <th>Fin travaux</th>
                            <th>Prix total</th>
                            <th>Deja paye</th>
                            <th>Reste à payer</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        <?php foreach ($all_devis as $devis) { ?>
                            <tr>
                                <td><?= $devis->ref_devis ?></td>
                                <td><?= $devis->lieu_devis ?></td>
                                <td><?= $devis->nom_tm_devis ?></td>
                                <td><?= format_currency($devis->surface_tm_devis) ?></td>
                                <td><?= $devis->nom_tf_devis ?></td>
                                <td><?= format_date($devis->dateheure_debut_travaux) ?></td>
                                <td><?= format_date($devis->dateheure_fin_travaux) ?></td>
                                <td><?= format_currency($devis->prix_total_devis) ?> Ar</td>
                                <td><?= format_currency($devis->montant_paye_devis) ?> Ar</td>
                                <td><?= format_currency($devis->prix_total_devis - $devis->montant_paye_devis) ?> Ar</td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item text-center" href="<?= site_url("client/devis/export_to_PDF/" . $devis->id_devis) ?>" target="_blank"><i class="bx bx-file-pdf me-1"></i> Exporter en PDF</a>
                                            <!-- si pas encore payé en totalité -->
                                            <?php if (true) { ?>
                                                <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#modalToggle<?= $devis->id_devis ?>"><i class="bx bx-money me-1"></i> Paiement</a>
                                            <?php } else { ?>
                                                <p class="text-success text-center">Payé en totalité</p>
                                            <?php } ?>
                                        </div>
                                        <div class="modal fade" id="modalToggle<?= $devis->id_devis ?>" aria-labelledby="modalToggleLabel" tabindex="-1" style="display: none;" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="modalToggleLabel">Paiement <?= $devis->id_devis ?></h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <h6 class="fw-bold py-3 mb-2"><span class="text-muted fw-light">Ref :</span> <?= $devis->ref_devis ?></h6>
                                                        <h6 class="fw-bold py-3 mb-2"><span class="text-muted fw-light">Lieu :</span> <?= $devis->lieu_devis ?></h6>
                                                        <h6 class="fw-bold py-3 mb-2"><span class="text-muted fw-light">Type de maison :</span> <?= $devis->nom_tf_devis ?></h6>
                                                        <h6 class="fw-bold py-3 mb-2"><span class="text-muted fw-light">Finition :</span> <?= $devis->nom_tf_devis ?> (<?= $devis->aug_tf_devis ?> %)</h6>
                                                        <h6 class="fw-bold py-3 mb-2"><span class="text-muted fw-light">Prix total :</span> <?= format_currency($devis->prix_total_devis) ?> Ar</h6>
                                                        <h6 class="fw-bold py-3 mb-2"><span class="text-muted fw-light">Montant déjà payé :</span> <?= format_currency($devis->montant_paye_devis) ?> Ar</h6>
                                                        <h6 class="fw-bold py-3 mb-2"><span class="text-muted fw-light">Reste à payer :</span> <?= format_currency($devis->prix_total_devis - $devis->montant_paye_devis) ?> Ar</h6>
                                                        <form action="<?= site_url("client/devis/paiement") ?>" id="paiement_form<?= $devis->id_devis ?>" name="paiement_form<?= $devis->id_devis ?>" method="post">
                                                            <input type="hidden" id="id_devis<?= $devis->id_devis ?>" name="id_devis" value="<?= $devis->id_devis ?>">
                                                            <div class="row d-flex justify-content-between mb-3">
                                                                <div class="col-md-6">
                                                                    <label for="defaultInput" class="form-label">Reference de paiement <span class="text-warning">(Unique)</span></label>
                                                                    <div style="color: red;"><?= form_error('ref_paiement') ?></div>
                                                                    <input id="defaultInput" class="form-control" type="text" name="ref_paiement" value=<?= set_value('ref_paiement') ?> required>
                                                                </div>
                                                            </div>
                                                            <div class="alert alert-danger" id="montant_ajax_error<?= $devis->id_devis ?>" role="alert" style="display: none;"></div>
                                                            <div class="row d-flex justify-content-between mb-3">
                                                                <div class="col-md-6">
                                                                    <label for="defaultInput" class="form-label">Montant</label>
                                                                    <div style="color: red;"><?= form_error('montant') ?></div>
                                                                    <input id="montant<?= $devis->id_devis ?>" class="form-control" type="number" name="montant" value=<?= set_value('montant') ?> min="0" step="0.01" required>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label for="defaultInput" class="form-label">Date heure paiement</label>
                                                                    <div style="color: red;"><?= form_error('dateheure_paiement') ?></div>
                                                                    <input class="form-control" type="datetime-local" value="2024-05-13T12:30:00" id="html5-datetime-local-input" name="dateheure_paiement" value=<?= set_value('dateheure_paiement') ?> required>
                                                                </div>
                                                            </div>
                                                            <button type="button" onclick="verifyPaiement('<?= $devis->id_devis ?>')" class="btn btn-success">Effectuer le paiement</button>
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
    <script>
        function verifyPaiement(id_devis) {
            const montant = document.getElementById('montant' + id_devis).value;
            const montant_ajax_error = document.getElementById("montant_ajax_error" + id_devis);

            if ((montant.trim() == '') === true) {
                montant_ajax_error.style.display = 'block';
                montant_ajax_error.innerHTML = `<p>Veuillez fournir un montant</p>`;
            } else {
                var xhr = newXhr();
                xhr.addEventListener("load", function() {

                    var resultat = JSON.parse(xhr.responseText);
                    if (resultat.ok == 0) {
                        montant_ajax_error.style.display = 'block';

                        const formatter = new Intl.NumberFormat('mg-MG', {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2,
                        });

                        montant_ajax_error.innerHTML = `<p>Avec ce montant ${formatter.format(resultat.montant)} Ar</p><p> votre paiement total ${formatter.format(resultat.nouveau_montant_total)} Ar</p><p>a dépassé le montant total du devis ${formatter.format(resultat.prix_total_devis)} Ar</p>`;
                    } else {
                        montant_ajax_error.innerHTML = '';
                        montant_ajax_error.style.display = 'none';
                        document.getElementById('paiement_form' + id_devis).submit();
                    }

                    // return chargeProduit;
                });

                xhr.open("POST", '<?= site_url('client/devis/verify_paiement') ?>');
                //envoie du formulaire fictif
                const formHTML = document.createElement("form");
                //numero
                var input = document.createElement("input");
                input.setAttribute('type', 'hidden');
                input.setAttribute('name', 'id_devis');
                input.value = id_devis;
                formHTML.appendChild(input);
                //idproduit
                input = document.createElement("input");
                input.setAttribute('type', 'hidden');
                input.setAttribute('name', 'montant');
                input.value = montant;
                formHTML.appendChild(input);
                const formJSON = new FormData(formHTML);
                xhr.send(formJSON);
            }
        }

        function newXhr() {
            var xhr;
            try {
                xhr = new ActiveXObject('Msxml2.XMLHTTP');
            } catch (e) {
                try {
                    xhr = new ActiveXObject('Microsoft.XMLHTTP');
                } catch (e2) {
                    try {
                        xhr = new XMLHttpRequest();
                    } catch (e3) {
                        xhr = false;
                    }
                }
            }

            return xhr;
        }
    </script>
    <!-- / Content -->

    <?php $this->load->view('client/templates/footer') ?>