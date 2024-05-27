<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DashboardModel extends CI_Model {

    public function annee_validation_config() {
        $config = array(
            array(
                'field' => 'annee',
                'label' => 'annee',
                'rules' => array('trim','required', 'integer', 'greater_than[0]'),
                'errors' => array(
                    'required' => 'Vous devez fournir une %s.',
                    'integer' => 'Vous devez fournir une valeur entiere.',
                    'greater_than' => 'Vous devez fournir une valeur positive.'
                )
            )
        );

        return $config;
    }

    public function construct_montant_devis_chart($montant_devis_mois_annee) {
        $data = [];
        // mois
        $str = "['Janvier', 'Fervrier', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Decembre']";
        $data [] = $str;

        // montant 
        $stat = '[';
        foreach ($montant_devis_mois_annee as $key => $montant) {
            $stat .= '"'.$montant->montant_total.'",';
        }
        $stat = substr($stat, 0, strlen($stat) - 1);
        $stat .= "]";
        // misy data
        if($stat != "]") {
            $data [] = $stat;
        } else {
            $stat = '[';
            $default = 0;
            for ($i=0; $i < 12; $i++) { 
                $stat .= '"'.$default.'",';
            }
            $stat = substr($stat, 0, strlen($stat) - 1);
            $stat .= "]";
            $data [] = $stat;
        }

        // colors
        // $colors = ["red", "green","blue","orange","brown"];
        $colors = ["rgba(255, 0, 0, 0.5)", "rgba(0, 255, 0, 0.5)","rgba(0, 0, 255, 0.5)","rgba(255, 165, 0, 0.5)","rgba(165, 42, 42, 0.5)"];
        $color_str = '[';
        foreach ($montant_devis_mois_annee as $key => $montant) {
            $color_str .= '"'.$colors[$key % count($colors)].'",';
        }
        $color_str = substr($color_str, 0, strlen($color_str) - 1);
        $color_str .= "]";
        if($color_str != "]") {
            $data [] = $color_str;
        } else {
            $color_str = '[';
            $default = 0;
            for ($i=0; $i < 12; $i++) { 
                $color_str .= '"'.$colors[$i % count($colors)].'",';
            }
            $color_str = substr($color_str, 0, strlen($color_str) - 1);
            $color_str .= "]";
            $data [] = $color_str;
        }

        return $data;
    }
    
    public function get_montant_devis_mois_annee($annee = 2024) {
        $this->db->where('annee', $annee);
        $this->db->order_by('mois', 'ASC');
        $query = $this->db->get('v_montant_devis_mois_annee');
        return $query->result();
    }
}
