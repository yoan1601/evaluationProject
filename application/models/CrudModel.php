<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CrudModel extends CI_Model {

    public function importExcelSeance() {
        $this->load->library('MYPDF');
        $tmpfname = "test.xlsx";
		$excelReader = PHPExcel_IOFactory::createReaderForFile($tmpfname);
		$excelObj = $excelReader->load($tmpfname);
		$worksheet = $excelObj->getSheet(0);
		$lastRow = $worksheet->getHighestRow();
		
		echo "<table>";
		for ($row = 1; $row <= $lastRow; $row++) {
			 echo "<tr><td>";
			 echo $worksheet->getCell('A'.$row)->getValue();
			 echo "</td><td>";
			 echo $worksheet->getCell('B'.$row)->getValue();
			 echo "</td><tr>";
		}
    }
	
    public function create($data, $table) {
		return $this->db->insert($table, $data);
	}

    public function update($id_name, $id, $data, $table) {
		$this->db->where($id_name, $id);
        return $this->db->update($table, $data);
	}

    public function delete($id_name, $id, $table, $isEtat = 1, $etat_name = null, $deletedState = 0) { // si $isEtat = 0 -> delete definitif
        $this -> db -> where($id_name, $id);
        if($isEtat == 0) {
            return $this -> db -> delete($table);
        }
        return $this->db->update($table, array($etat_name => $deletedState));
    }

    public function find_by_id($table, $id_name, $id_value) {
        $this->db->where($id_name, $id_value);
        $query = $this->db->get($table);
        return $query->row();
    }

    public function all($table, $etat_name = null, $deletedState = 0, $id = null, $search = []) {
        if ($etat_name != null) $this->db->where($etat_name.' > ' , $deletedState);
        if ($id != null) {
            $this->db->order_by($id, 'DESC');
        }
    
        // Recherche
        if (count($search) > 0) {
            foreach ($search as $key => $keywords) {
                if (!empty($keywords)) {
                    $this->db->group_start();
                    foreach ($keywords as $keyword) {
                        $this->db->or_like('LOWER('.$key.')', strtolower($keyword));
                    }
                    $this->db->group_end();
                }
            }
        }
    
        $query = $this->db->get($table);
        return $query->result();
    }
    

    public function all_paginate($table, $etat_name = null, $deletedState = 0, $id = null, $ci_url = '', $offset = 5, $search = []) {
        $this->load->library('Pagination_bootstrap');

        $pagination = new Pagination_Bootstrap();

        if($etat_name != null) $this->db->where($etat_name.' > ' , $deletedState);
        if($id != null) {
            $this->db->order_by($id, 'DESC');
        }

        // Recherche
        if (count($search) > 0) {
            foreach ($search as $key => $keywords) {
                if (!empty($keywords)) {
                    $this->db->group_start();
                    foreach ($keywords as $keyword) {
                        $this->db->or_like('LOWER('.$key.')', strtolower($keyword));
                    }
                    $this->db->group_end();
                }
            }
        }
    
        
        $query = $this->db->get($table);

        //nb de lignes par page
        $pagination->offset($offset);

        //avoir nb de pages
        $data['results'] = $pagination->config($ci_url, $query);
        $data['pagination'] = $pagination;

        return $data;
    }
}
