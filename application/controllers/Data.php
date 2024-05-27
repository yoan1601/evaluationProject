<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data extends CI_Controller {

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
	public function index()
	{
        // $this->session->set_flashdata('message', 'Tentative acces data controller /index');
		redirect('client/auth');
	}

	public function reset()
	{
        // echo 'Data reset';
		$tables = [
			'aug_type_finition',
			'clients',
			'description_maison',
			'devis',
			'duree_type_maison',
			'historique_travaux',
			'paiement',
			'prix_type_travaux',
			'travaux',
			'type_finition',
			'type_maison',
			'type_travaux',
			'unite',
			'import_devis',
			'import_maison_travaux',
			'import_paiement'
		];
		$this->db->trans_start();
		try {
			$this->data->create_table_contrainte();
			$this->data->enlever_contraintes();
			$this->data->reset_data($tables);
			$this->data->activer_contraintes();
			$this->db->trans_commit();
		} catch (Throwable $th) {
            $this->db->trans_rollback();
        }
		redirect('admin/dashboard');
	}
}
