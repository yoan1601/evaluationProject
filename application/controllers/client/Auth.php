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
		$this->load->view('client/login');
	}

	public function to_register()
	{
		$this->load->view('client/register');
	}

	public function register()
	{
		$config = $this->authClient->register_validation_config();

		$this->form_validation->set_rules($config);

		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('client/register');
		}
		else
		{
			$nom = $this->input->post('nom');
			$email = $this->input->post('email');
			$motdepasse = $this->input->post('password');
			$this->authClient->register($nom, $email, $motdepasse);
			$user = $this->authClient->get_user_client(trim($email), trim($motdepasse));
			if($user)  {
				$this->session->set_userdata('user_client', $user);
				$this->load->view('client/landing');
			} else {
				$this->session->set_flashdata('message', "oups quelque chose s'est mal passée");
				redirect('client/register');
			}
		}
	}

	public function check() {
		$config = $this->authClient->login_validation_config();

		$this->form_validation->set_rules($config);

		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('client/login');
		}
		else
		{
			$tel = $this->input->post('tel');
			// $motdepasse = $this->input->post('password');
			$user = $this->authClient->authenticate($tel);
			$this->session->set_userdata('user_client', $user);
			redirect('client/devis');
		}
	}

	public function logout() {
        $this->session->unset_userdata('user_client'); 
        redirect('client/auth');
	}
}
