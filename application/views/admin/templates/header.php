<?php
$user_admin = $this->session->user_admin;
?>

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
        <!-- Menu -->

        <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
          <div class="app-brand demo">
            <a href="index.html" class="app-brand-link">
              <span class="app-brand-logo demo">
              <i class='bx bxs-building-house' style="font-size: xx-large;"></i>
              </span>
              <span class="app-brand-text demo menu-text fw-bolder ms-2">Construction</span>
            </a>

            <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
              <i class="bx bx-chevron-left bx-sm align-middle"></i>
            </a>
          </div>

          <div class="menu-inner-shadow"></div>

          <ul class="menu-inner py-1">
            <li class="menu-item">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-book"></i>
                <div data-i18n="Layouts">Devis</div>
              </a>

              <ul class="menu-sub">
                <li class="menu-item">
                  <a href="<?= site_url('admin/devis/to_liste_devis') ?>" class="menu-link">
                    <div data-i18n="Without menu">Liste</div>
                  </a>
                </li>
              </ul>
            </li>
            <li class="menu-item">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-down-arrow-alt"></i>
                <div data-i18n="Layouts">Import</div>
              </a>

              <ul class="menu-sub">
                <li class="menu-item">
                  <a href="<?= site_url('admin/import/to_maison_travaux_devis') ?>" class="menu-link">
                    <div data-i18n="Without menu">Maison - Travaux - Devis</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="<?= site_url('admin/import/to_paiement') ?>" class="menu-link">
                    <div data-i18n="Without menu">Paiement</div>
                  </a>
                </li>
              </ul>
            </li>
            <li class="menu-item">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-list-ul"></i>
                <div data-i18n="Layouts">Liste et modification</div>
              </a>

              <ul class="menu-sub">
                <li class="menu-item">
                  <a href="<?= site_url('admin/crud/to_type_travaux') ?>" class="menu-link">
                    <div data-i18n="Without menu">Type travaux</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="<?= site_url('admin/crud/to_type_finition') ?>" class="menu-link">
                    <div data-i18n="Without menu">Type finition</div>
                  </a>
                </li>
              </ul>
            </li>
            <li class="menu-item">
              <a href="<?= site_url("admin/dashboard") ?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-trending-up"></i>
                <div data-i18n="Layouts">Tableau de bord</div>
              </a>
            </li>
          </ul>
          <!-- <ul class="menu-inner py-1">
            <li class="menu-item">
              <a href="<?= site_url('admin/auth/logout') ?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-exit"></i>
                <div data-i18n="Layouts">Deconnexion</div>
              </a>
            </li>
          </ul> -->
         
        </aside>
        <!-- / Menu -->

        <!-- Layout container -->
        <div class="layout-page">
        <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">

<div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
  <ul class="navbar-nav flex-row align-items-center ms-auto">
     
    <li class="nav-item lh-1 me-3">
      <?= $user_admin->email_admin ?>
    </li>
    <!-- User -->
    <li class="nav-item navbar-dropdown dropdown-user dropdown">
      <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
        <div class="avatar avatar-online">
          <img src="<?= base_url('assets/img/avatars/1.png') ?>" alt="" class="w-px-40 h-auto rounded-circle">
        </div>
      </a>
      <ul class="dropdown-menu dropdown-menu-end">
        <li>
          <div class="dropdown-divider"></div>
        </li>
        <li>
          <a class="dropdown-item" href="<?= site_url('admin/auth/logout') ?>">
            <i class="bx bx-power-off me-2"></i>
            <span class="align-middle">Se deconnecter</span>
          </a>
        </li>
      </ul>
    </li>
    <!--/ User -->
  </ul>
</div>
</nav>
      <li class="menu-item ms-5 mt-3">
        <button data-bs-toggle="modal" data-bs-target="#reset_data" type="button" class="btn btn-warning">Reinitialiser donnees</button>
      </li>
      <div class="modal" id="reset_data" aria-labelledby="modalToggleLabel" tabindex="-1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="modalToggleLabel">Reinitialiser les donnees ?</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <a href="<?= site_url("data/reset") ?>"><button type="submit" class="btn btn-warning">Oui</button></a>
                <button data-bs-dismiss="modal" type="button" class="btn btn-info ms-3">Non</button>
              </div>
            </div>
        </div>
      </div>