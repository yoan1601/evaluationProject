<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Devis extends CI_Controller {

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
        $this->to_liste_devis();
	}

    public function to_liste_devis() {
		$data['all_devis'] = $this->devis->all();
		$this->devis->set_color($data['all_devis']);
        $this->load->view('admin/devis/liste', $data);
    }

	public function to_liste_travaux($id_devis) {
		$data['devis'] = $this->crud->find_by_id('v_devis_libcomplet', 'id_devis', $id_devis);
		$data['liste_travaux'] = $this->devis->get_historique($id_devis);
		$this->load->view('admin/devis/liste_travaux', $data);
	}

	public function to_liste_paiement($id_devis) {
		$data['devis'] = $this->crud->find_by_id('v_devis_libcomplet', 'id_devis', $id_devis);
		$data['liste_paiement'] = $this->devis->get_paiements_by_devis($id_devis);
		$this->load->view('admin/devis/liste_paiement', $data);
	}
}
