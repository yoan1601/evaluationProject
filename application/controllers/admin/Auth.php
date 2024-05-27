<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

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
		$this->load->view('admin/login');
	}

	public function check() {
		$config = $this->authAdmin->login_validation_config();

		$this->form_validation->set_rules($config);

		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('admin/login');
		}
		else
		{
			$email = $this->input->post('email');
			$motdepasse = $this->input->post('password');
			$resultat = $this->authAdmin->authenticate($email, $motdepasse);
			
			if($resultat == '') {
				$user = $this->authAdmin->get_user_admin($email, $motdepasse);
				$this->session->set_userdata('user_admin', $user);
				redirect('admin/dashboard');
			} else {
				$this->session->set_flashdata('message', $resultat);
				redirect('admin/auth');
			}
		}
	}

	public function logout() {
        $this->session->unset_userdata('user_admin'); 
        redirect('admin/auth');
	}
}
