<?php $this->load->view('admin/templates/header') ?>
<script src="<?= base_url('assets/js/Chart.js') ?>"></script>
<!-- Content wrapper -->
<div class="content-wrapper">

    <!-- Content -->

    <div class="container-fluid flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Tableau de bord /</span> Devis</h4>
        <div class="row">
            <!-- <div class="col-md-4">
                <div class="card mb-4">
                    <form action="<?= site_url("statistique/chiffre_affaire") ?>" method="post">
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="defaultFormControlInput" class="form-label">Date debut</label>
                                <input class="form-control" type="date" name="date_debut" id="html5-date-input" required>
                            </div>
                            <div class="mb-3">
                                <label for="defaultFormControlInput" class="form-label">Date fin</label>
                                <input class="form-control" type="date" name="date_fin" id="html5-date-input" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Filtrer</button>
                        </div>
                    </form>
                </div>
            </div> -->
            <div class="col-md-6">
                <div class="card mb-4">
                    <!-- <h5 class="card-header">Entre <span class="text-primary"><?= format_date('2024-05-13') ?></span> et <span class="text-primary"><?= format_date('2024-05-13') ?></span></h5> -->
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                                <img src="<?= base_url("assets/img/icons/unicons/wallet-info.png") ?>" alt="Credit Card" class="rounded">
                            </div>
                        </div>
                        <span class="fw-semibold d-block mb-1">Montant total des <span class="text-warning">DEVIS</span></span>
                        <h3 class="card-title text-nowrap mb-1"><?= format_currency($devis_total) ?> Ar</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card mb-4">
                    <!-- <h5 class="card-header">Entre <span class="text-primary"><?= format_date('2024-05-13') ?></span> et <span class="text-primary"><?= format_date('2024-05-13') ?></span></h5> -->
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                                <img src="<?= base_url("assets/img/icons/unicons/paypal.png") ?>" alt="Pay pal" class="rounded">
                            </div>
                        </div>
                        <span class="fw-semibold d-block mb-1">Montant total de <span class="text-primary">paiement effectué</span></span>
                        <h3 class="card-title text-nowrap mb-1"><?= format_currency($paiement_total) ?> Ar</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Montant des devis par mois</h4>
            <div class="col-md-4">
                <div class="card mb-4">
                    <form action="<?= site_url("admin/dashboard/to_dashboard") ?>" method="post">
                        <div class="card-body">
                            <div class="mb-3">
                                <div style="color: red;"><?= form_error('annee') ?></div>
                                <label for="defaultFormControlInput" class="form-label">Année</label>
                                <input class="form-control" type="text" name="annee" value="<?= $annee ?>" id="html5-date-input" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Filtrer</button>
                            <!-- <a class="ms-3" href="<?= site_url("admin/dashboard/to_dashboard_pdf/".$annee) ?>" target="_blank"><button type="button" class="btn btn-warning">Exporter PDF</button></a> -->
                        </div>
                    </form>
                    
                </div>
            </div>
            <div class="card mb-3">
                <canvas id="myChart" class="mx-auto" style="width:100%;"></canvas>
            </div>
        </div>
    </div>
</div>
<!-- / Content -->

<script>
        var xValues = <?= $mois ?>;
        var yValues = <?= $montants ?>;
        var barColors = <?= $colors ?>;

        new Chart("myChart", {
            type: "bar",
            data: {
                labels: xValues,
                datasets: [{
                    backgroundColor: barColors,
                    borderWidth: 2,
                    data: yValues
                }]
            },
            options: {
                legend: {display: false},
                title: {
                    display: true,
                    text: "Montant des devis par mois - année <?= $annee ?>"
                }
            }
        });
</script>
<?php $this->load->view('admin/templates/footer') ?>