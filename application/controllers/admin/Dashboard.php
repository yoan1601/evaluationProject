<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

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
        $this->to_dashboard();
	}

	public function to_dashboard_pdf($annee = 2024) {
		$data['devis_total'] = $this->devis->get_devis_total();
		if($data['devis_total'] == null) {
			$data['devis_total'] = 0;
		}
		$data['paiement_total'] = $this->devis->get_paiement_total();
		if($data['paiement_total'] == null) {
			$data['paiement_total'] = 0;
		}
		$montant_devis_mois_annee = $this->dashboard->get_montant_devis_mois_annee($annee);
		$montant_devis_chart = $this->dashboard->construct_montant_devis_chart($montant_devis_mois_annee);
		$data['mois'] = $montant_devis_chart[0];
		$data['montants'] = $montant_devis_chart[1];
		$data['colors'] = $montant_devis_chart[2];
		$data['annee'] = $annee;

		$this->load->view('admin/devis/dashboard_pdf', $data);
	}

    public function to_dashboard() {
		$config = $this->dashboard->annee_validation_config();

		$this->form_validation->set_rules($config);

		$data['devis_total'] = $this->devis->get_devis_total();
		if($data['devis_total'] == null) {
			$data['devis_total'] = 0;
		}
		$data['paiement_total'] = $this->devis->get_paiement_total();
		if($data['paiement_total'] == null) {
			$data['paiement_total'] = 0;
		}

		$annee = date('Y');
		if ($this->form_validation->run() == FALSE)
		{
			$montant_devis_mois_annee = $this->dashboard->get_montant_devis_mois_annee($annee);
			$montant_devis_chart = $this->dashboard->construct_montant_devis_chart($montant_devis_mois_annee);
			$data['mois'] = $montant_devis_chart[0];
			$data['montants'] = $montant_devis_chart[1];
			$data['colors'] = $montant_devis_chart[2];
			$data['annee'] = $annee;
			$this->load->view('admin/devis/dashboard', $data);
		}
		else
		{
			if($this->input->post('annee')) {
				$annee = $this->input->post('annee');
			}
			$montant_devis_mois_annee = $this->dashboard->get_montant_devis_mois_annee($annee);
			$montant_devis_chart = $this->dashboard->construct_montant_devis_chart($montant_devis_mois_annee);
			$data['mois'] = $montant_devis_chart[0];
			$data['montants'] = $montant_devis_chart[1];
			$data['colors'] = $montant_devis_chart[2];
			$data['annee'] = $annee;
			$this->load->view('admin/devis/dashboard', $data);
		}
    }
}
