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
        // $this->to_liste_devis();
		$this->to_creer_devis();
	}

	public function verify_paiement() {
		$id_devis = $_POST['id_devis'];
 		$montant = $_POST['montant'];

		$message = [
			"ok" => 1,
			"montant" => $montant,
			"nouveau_montant_total" => $montant,
			"id_devis" => $id_devis
		];

		$devis = $this->crud->find_by_id('v_devis_libcomplet', 'id_devis', $id_devis);
	
		if($devis) {
			$nouveau_montant_total = $devis->montant_paye_devis + $montant;
			if($devis->prix_total_devis < $nouveau_montant_total) {
				$message["ok"] = 0;
				$message["nouveau_montant_total"] = $nouveau_montant_total;
				$message["prix_total_devis"] = $devis->prix_total_devis;
			}
		}
		echo json_encode($message);
	}

	public function export_to_PDF($id_devis = 'D_10') {
		$this->devis->export_PDF($id_devis);
	}

    public function to_liste_devis() {
		$user_client = $this->session->user_client;
		$data['all_devis'] = $this->devis->find_by_client($user_client->id_cli);
        $this->load->view('client/devis/liste', $data);
    }

    public function to_creer_devis() {
		$type_maisons = $this->crud->all('v_type_maison', $etat_name = 'etat_tm', $deletedState = 0, $id = 'id_tm');
		$data['all_type_maisons'] = $this->tm->set_descritpions($type_maisons);
		$data['all_type_finitions'] = $this->crud->all('type_finition', $etat_name = 'etat_tf', $deletedState = 0, $id = 'id_tf');
        $this->load->view('client/devis/creation', $data);
    }

	public function paiement() {
		$config = $this->devis->paiement_validation_config();

		$this->form_validation->set_rules($config);

		if ($this->form_validation->run() == FALSE)
		{
			$user_client = $this->session->user_client;
			$data['all_devis'] = $this->devis->find_by_client($user_client->id_cli);
			$this->load->view('client/devis/liste', $data);
		}
		else
		{
			$ref_paiement = $this->input->post('ref_paiement');
			$id_devis = $this->input->post('id_devis');
			$montant = $this->input->post('montant');
			$dateheure_paiement = $this->input->post('dateheure_paiement');
			$this->db->trans_start();
			try {
				$this->devis->effectuer_paiement($id_devis, $montant, $dateheure_paiement, $ref_paiement);
				$this->db->trans_commit();
			} catch (\Throwable $th) {
				var_dump($th);
				$this->db->trans_rollback();
			}
			redirect('client/devis');
		}
	}

	public function creer_devis() {
		$data['ref_devis'] = trim($this->input->post("ref_devis"));
		$data['lieu_devis'] = trim($this->input->post("lieu_devis"));
		$data['id_tm_devis'] = $this->input->post("id_tm");
		$data['id_tf_devis'] = $this->input->post("id_tf");
		$data['dateheure_debut_travaux'] = $this->input->post("dateheure_debut_travaux");
		$data['dateheure_creation_devis'] = $this->input->post("dateheure_creation_devis");
		// maka detail type_maison
		$type_maison = $this->crud->find_by_id('v_type_maison', 'id_tm', $data['id_tm_devis']);
		$data['dateheure_fin_travaux'] = add_to_date_time($data['dateheure_debut_travaux'], $type_maison->duree_tm, $unite = 'jour');

		$type_finition = $this->crud->find_by_id('type_finition', 'id_tf', $data['id_tf_devis']);
		// $data['prix_total_devis'] = $type_maison->prix_total_tm + ($type_maison->prix_total_tm * ($type_finition->aug_tf / 100.0));
		$data['id_client_devis'] = $this->session->user_client->id_cli;
		$data['aug_tf_devis'] = $type_finition->aug_tf;
		$data['prix_brut_devis'] = $type_maison->prix_total_tm;

		$data['nom_tm_devis'] = $type_maison->nom_tm;
		$data['nom_tf_devis'] = $type_finition->nom_tf;

		// var_dump($data);
		$this->devis->insert_devis($data);
		redirect("client/devis");
	}
}
