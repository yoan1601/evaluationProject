<?php defined('BASEPATH') or exit('No direct script access allowed');

class AuthClientModel extends CI_Model {
    public function register_validation_config() {
        $config = array(
            array(
                'field' => 'nom',
                'label' => 'nom',
                'rules' => array('trim','required', 'is_unique[clients.nom_cli]'),
                'errors' => array(
                    'required' => 'Vous devez fournir un %s.',
                    'is_unique' => 'Ce %s existe déjà, veuillez fournir un autre nom.'
                )
            ),
            
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
                    'rules' => array('trim','required','valid_email', 'is_unique[clients.email_cli]'),
                    'errors' => array(
                        'required' => 'Vous devez fournir un %s.',
                        'valid_email' => 'Vous devez fournir un %s valide.',
                        'is_unique' => 'Cet %s existe déjà.'
                )
            )
        );

        return $config;
    }

    public function login_validation_config() {
        $config = array(
            array(
                    'field' => 'tel',
                    'label' => 'numero de telephone',
                    'rules' => array('trim','required'),
                    'errors' => array(
                        'required' => 'Vous devez fournir un %s.'
                    ),
            )
        );

        return $config;
    }

    public function register($nom, $email, $password) {
        $data = [
            'nom_cli' => trim($nom),
            'email_cli' => trim($email),
            'pwd_cli' => trim($password)
        ];
        $this->db->insert('clients', $data);
    }

    public function authenticate($tel) {
        $this->db->where('numero_cli', trim($tel));
        $query = $this->db->get('clients');
        if($query->num_rows() > 0) {
            return $query->row();
        } else {
            $data = [
                'numero_cli' => trim($tel)
            ];
            $this->db->insert('clients', $data);
            $query = $this->db->get('clients');
            return $query->row();
        }
    }

    // public function authenticate($email, $password) {
    //     $this->db->where('email_cli', trim($email));
    //     $query = $this->db->get('clients');
    //     if($query->num_rows() > 0) {
    //         foreach ($query->result() as $row) {
    //             $pwd = $row->pwd_cli;
    //             if($pwd == trim($password)) {
    //                 return '';
    //             } else {
    //                 return 'Mauvais mot de passe';
    //             }
    //         }
    //     } else {
    //         return 'Mauvais adresse email';
    //     }
    // }

    public function get_user_client($email, $password) {
        $this->db->where('email_cli', trim($email));
        $this->db->where('pwd_cli', trim($password));
        $query = $this->db->get('clients');

        if ($query->num_rows() == 1) {
            return $query->row(); 
        } else {
            return false; 
        }
    }
}
