<?php
$user_admin = $this->session->user_admin;
?>
<script src="<?= base_url('assets/js/Chart.js') ?>"></script>
<!DOCTYPE html>

<!-- =========================================================
* Sneat - Bootstrap 5 HTML Admin Template - Pro | v1.0.0
==============================================================

* Product Page: https://themeselection.com/products/sneat-bootstrap-html-admin-template/
* Created by: ThemeSelection
* License: You must have a valid license purchased in order to legally use the theme for your project.
* Copyright ThemeSelection (https://themeselection.com)

=========================================================
 -->
<!-- beautify ignore:start -->
<html
  lang="en"
  class="light-style layout-menu-fixed"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="<?= base_url('assets/') ?>"
  data-template="vertical-menu-template-free"
>
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <title>Eval</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?= base_url('assets/img/favicon/favicon.ico') ?>" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="<?= base_url('assets/vendor/fonts/boxicons.css') ?>" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/vendor/css/core.css') ?>" class="template-customizer-core-css" />
    <link rel="stylesheet" href="<?= base_url('assets/vendor/css/theme-default.css') ?>" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="<?= base_url('assets/css/demo.css') ?>" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') ?>" />

    <!-- Bootstrap table -->
    <link rel="stylesheet" href="<?= base_url('assets/bootstrap-table/bootstrap-table.min.css') ?>">

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="<?= base_url('assets/vendor/js/helpers.js') ?>"></script>
    <!-- print CSS -->
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/print.css') ?>">

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="<?= base_url('assets/js/config.js') ?>"></script>
  </head>

  <body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
      <div class="content-wrapper">

    <!-- Content -->

    <div id="printJS-stat" onclick="exportPDF()" class="container-fluid flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Tableau de bord /</span> Devis</h4>
        <div class="row">
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
<script>
  const exportPDF = () => {
    window.print();
  }
</script>
    </div>
<!-- Footer -->
<footer class="content-footer footer bg-footer-theme">
    <div class="container-fluid d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
        
    </div>
</footer>
<!-- / Footer -->

<div class="content-backdrop fade"></div>
</div>
<!-- Content wrapper -->
</div>
<!-- / Layout page -->
</div>

<!-- Overlay -->
<div class="layout-overlay layout-menu-toggle"></div>
</div>
<!-- / Layout wrapper -->


<!-- Core JS -->
<!-- build:js assets/vendor/js/core.js -->
<script src="<?= base_url('assets/vendor/libs/jquery/jquery.js') ?>"></script>
<script src="<?= base_url('assets/vendor/libs/popper/popper.js') ?>"></script>
<script src="<?= base_url('assets/vendor/js/bootstrap.js') ?>"></script>
<script src="<?= base_url('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') ?>"></script>

<script src="<?= base_url('assets/vendor/js/menu.js') ?>"></script>
<!-- endbuild -->

<!-- Vendors JS -->

<!-- Main JS -->
<script src="<?= base_url('assets/js/main.js') ?>"></script>

<!-- Page JS -->

<!-- Place this tag in your head or just before your close body tag. -->
<script async defer src="https://buttons.github.io/buttons.js"></script>

<!-- Bootstrap-table -->
<script src="<?= base_url('assets/bootstrap-table/bootstrap-table.min.js') ?>"></script>

<!-- ajax -->
<script src="<?= base_url('assets/js/ajax.js') ?>"></script>
<!-- print -->
<script src="<?= base_url('assets/js/print.js') ?>"></script>
</body>

</html>