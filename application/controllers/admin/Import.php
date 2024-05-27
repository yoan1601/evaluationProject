<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Import extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */

    public function __construct() {
        parent::__construct();
        $this->load->helper('format');
    }

	public function index()
	{
        $this->to_maison_travaux_devis();
	}

    public function import_paiement() {
        setup_docs();

        $file_paiement = $_FILES['paiement'];
        $this->import->clean_import_paiement_base();
        $this->import->insert_import_paiement($file_paiement);

        // gestion erreur
        $errors = [];
        function customErrorHandler($errno, $errstr, $errfile, $errline) {
            global $errors;
            $errors[] = $errstr; // Stocker l'erreur dans la variable $errors
        }

        // Utiliser set_error_handler() pour définir la fonction comme gestionnaire d'erreurs
        set_error_handler('customErrorHandler');

        $this->db->trans_start();

        $import_paiement = $this->crud->all('import_paiement', null);

        $errors = [];
        $errors = $this->import->get_error_import_paiement($import_paiement, $errors);

        $this->import->insert_paiement();
        // var_dump($errors);

        if(count($errors) == 0){
            $this->db->trans_commit();
        } else {
            $this->db->trans_rollback();
            $this->import->clean_import_paiement_base();
        }

        $data['errors'] = $errors; // Passer les erreurs à la vue

        // // Restaurer le gestionnaire d'erreurs par défaut
        restore_error_handler();

        $this->load->view('admin/import/paiement', $data);
    }

	public function import_maison_travaux_devis() {
        // import
        // import maison_travaux_devis
        setup_docs();

        $file_maison_travaux = $_FILES['maison_travaux'];
        $this->import->insert_import_maison_travaux($file_maison_travaux);

        $file_import_devis = $_FILES['devis'];
        $this->import->insert_import_devis($file_import_devis);

        // gestion erreur
        $errors = [];
        function customErrorHandler($errno, $errstr, $errfile, $errline) {
            global $errors;
            $errors[] = $errstr; // Stocker l'erreur dans la variable $errors
        }

        // Utiliser set_error_handler() pour définir la fonction comme gestionnaire d'erreurs
        set_error_handler('customErrorHandler');

        $this->db->trans_start();

        $import_maison_travaux = $this->crud->all('import_maison_travaux', null);
        $import_devis = $this->crud->all('import_devis', null);

        $errors = [];
        $errors = $this->import->get_error_import_maison_travaux($import_maison_travaux, $errors);
        $errors = $this->import->get_error_import_devis($import_devis, $errors);

        $this->import->insert_maison_travaux();
        $this->import->insert_devis();

        if(count($errors) == 0){
            $this->db->trans_commit();
        } else {
            $this->db->trans_rollback();
            $this->import->clean_import_maison_travaux_devis_base();
        }

        $data['errors'] = $errors; // Passer les erreurs à la vue

        // // Restaurer le gestionnaire d'erreurs par défaut
        restore_error_handler();

        $this->load->view('admin/import/maison_travaux_devis', $data);
    }

    public function to_maison_travaux_devis() {
        $this->load->view('admin/import/maison_travaux_devis');
    }

    public function to_paiement() {
        $this->load->view('admin/import/paiement');
    }
}