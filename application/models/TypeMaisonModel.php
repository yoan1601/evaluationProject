<?php defined('BASEPATH') or exit('No direct script access allowed');

class TypeMaisonModel extends CI_Model {

    public function get_travaux($id_tm) {
        $this->db->where('id_tm_travaux', $id_tm);
        $query = $this->db->get('v_travaux_libcomplet');
        return $query->result();
    }

    public function set_descritpions($type_maisons) {
        foreach ($type_maisons as $key => $tm) {
            $tm->descriptions = $this->get_descriptions($tm->id_tm);
        }
        return $type_maisons;
    }

    public function get_descriptions($id_tm) {
        $this->db->where('id_tm_descri', $id_tm);
        $query = $this->db->get('description_maison');
        return $query->result();
    }
}
