<?php defined('BASEPATH') or exit('No direct script access allowed');

class AuthAdminModel extends CI_Model {
    public function login_validation_config() {
        $config = array(
            array(
                    'field' => 'password',
                    'label' => 'mot de passe',
                    'rules' => array('trim','required','min_length[4]','max_length[12]'),
                    'errors' => array(
                        'required' => 'Vous devez fournir un %s.',
                        'min_length' => 'Le %s doit contenir au moins %s caracteres.',
                        'max_length' => 'Le %s doit contenir au plus %s caracteres.',
                    ),
            ),
            array(
                    'field' => 'email',
                    'label' => 'email',
                    'rules' => array('trim','required','valid_email'),
                    'errors' => array(
                        'required' => 'Vous devez fournir un %s.',
                        'valid_email' => 'Vous devez fournir un %s valide.'
                )
            )
        );

        return $config;
    }

    public function authenticate($email, $password) {
        $this->db->where('email_admin', trim($email));
        $query = $this->db->get('admins');
        if($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $pwd = $row->pwd_admin;
                if($pwd == trim($password)) {
                    return '';
                } else {
                    return 'Mauvais mot de passe';
                }
            }
        } else {
            return 'Mauvais adresse email';
        }
    }

    public function get_user_admin($email, $password) {
        $this->db->where('email_admin', trim($email));
        $this->db->where('pwd_admin', trim($password));
        $query = $this->db->get('admins');

        if ($query->num_rows() == 1) {
            return $query->row(); 
        } else {
            return false; 
        }
    }
}
