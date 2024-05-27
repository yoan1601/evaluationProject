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
  class="light-style customizer-hide"
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

    <title>Login</title>

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
    <link rel="stylesheet" href="<?= base_url('assets/vendor/css/core.css" class="template-customizer-core-css') ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/vendor/css/theme-default.css') ?>" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="<?= base_url('assets/css/demo.css') ?>" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') ?>" />

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="<?= base_url('assets/vendor/css/pages/page-auth.css') ?>" />
    <!-- Helpers -->
    <script src="<?= base_url('assets/vendor/js/helpers.js') ?>"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="<?= base_url('assets/js/config.js') ?>"></script>
  </head>

  <body>
    <!-- Content -->

    <div class="container-xxl">
      <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner">
          <!-- Register -->
          <div class="card">
            <?php echo form_open('client/auth/check'); ?>
            <div class="card-body">
              <!-- Logo -->
              <div class="app-brand justify-content-center">
                  <i class='bx bxs-building-house' style="font-size: xx-large;"></i>
                  <span class="app-brand-text demo text-body fw-bolder">Construction</span>
              </div>
              <!-- /Logo -->
              <h4 class="mb-2"><span style="color: #696cff;"></span> Bienvenue chez Construction 👋</h4>
              <p class="mb-4">Veuillez vous connecter</p>
              <?php if ($this->session->flashdata('message')) { ?>
                <div style="color: red;"><?= $this->session->flashdata('message') ?></div>
              <?php } ?>
              <!-- <form id="formAuthentication" class="mb-3" action="<?= site_url('film') ?>" method="POST"> -->
                <div class="mb-3">
                  <div style="color: red;"><?= form_error('tel') ?></div>
                  <label for="tel" class="form-label">Numero de telephone</label>
                  <input
                    type="text"
                    class="form-control"
                    id="tel"
                    name="tel"
                    value="<?= set_value('tel') ?>"
                    placeholder="Entrez votre numero de telephone"
                    autofocus
                  />
                </div>
                <div class="mb-3">
                  <button class="btn btn-primary d-grid w-100" type="submit">Se connecter</button>
                </div>
                <!-- <p class="text-center">
                  <span>Vous êtes nouveau ?</span>
                  <a href="<?= site_url("client/auth/to_register") ?>">
                    <span>Créer un compte</span>
                  </a>
                </p> -->
                <!-- <p class="text-center">
                  <span>Administrateur ?</span>
                  <a href="<?= site_url("admin/auth") ?>">
                    <span>Se connecter en tant qu'admin</span>
                  </a>
                </p> -->
              <!-- </form> -->
            </div>
          </div>
          <!-- /Register -->
        </div>
      </div>
    </div>

    <!-- / Content -->

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
  </body>
</html>