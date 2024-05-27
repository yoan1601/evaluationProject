<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Crud extends CI_Controller {

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
        $this->to_type_travaux();
	}

	public function u_tt() {
		$id_tt = $this->input->post('id_tt');
		$code_tt = $this->input->post('code_tt');
        $nom_tt = $this->input->post('nom_tt');
		$id_unite = $this->input->post('id_unite');
		$pu_tt = $this->input->post('pu_tt');

        $data = array(
            'id_tt' => $id_tt, 
            'code_tt' => $code_tt, 
            'nom_tt' => $nom_tt, 
            'id_unite_tt' => $id_unite,
			'pu_tt' => $pu_tt
        );

        $this->crud->update('id_tt', $id_tt ,$data, 'type_travaux');
        redirect(site_url('admin/crud/to_type_travaux'));
	}

	public function u_tf() {
		$id_tf = $this->input->post('id_tf');
        $nom_tf = $this->input->post('nom_tf');
		$aug_tf = $this->input->post('aug_tf');

        $data = array(
            'id_tf' => $id_tf, 
            'nom_tf' => $nom_tf, 
			'aug_tf' => $aug_tf
        );

        $this->crud->update('id_tf', $id_tf ,$data, 'type_finition');
        redirect(site_url('admin/crud/to_type_finition'));
	}

    public function to_type_travaux() {
		$data['all_type_travaux'] = $this->crud->all('v_type_travaux_libcomplet', 'etat_tt', 0, 'id_tt');
		$data['all_unite'] = $this->crud->all('unite', 'etat_unite', 0, 'id_unite');
        $this->load->view('admin/crud/type_travaux', $data);
    }

    public function to_type_finition() {
		$data['all_type_finition'] = $this->crud->all('type_finition', 'etat_tf', 0, 'id_tf');
        $this->load->view('admin/crud/type_finition', $data);
    }
}
