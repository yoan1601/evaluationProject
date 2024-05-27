<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ImportModel extends CI_Model {

    public function insert_import_paiement($file) {
        $data = read_csv_data($file['name'], $ligneDeb = 2, $ligneFin = -1, $separateur = ',', $enclosure = '"');
		$data = enlever_caracteres_speciaux_tableau($data);
        $all_entree = [];
        foreach ($data as $key => $ecriture) {
            $entree = array();
            $entree['ref_devis'] = trim($ecriture[0]);
            $entree['ref_paiement'] = trim($ecriture[1]);
            $entree['date_paiement'] = trim($ecriture[2]);
            $entree['montant'] = str_replace(',', '.', trim($ecriture[3]));
            // $this->crud->create($entree, 'import_paiement');
            if($this->check_ref_paiement_in_base($entree) == 0) {
                if($this->check_raha_efa_teo_ambony($entree, $all_entree) == 0) {
                    $this->crud->create($entree, 'import_paiement');
                    $all_entree [] = $entree;
                }
            }
        }
    }

    // ra efa anaty base de tsy miditra 
    public function check_ref_paiement_in_base($entree) {
        $paiement_in_base = $this->crud->find_by_id('paiement', 'ref_paiement', $entree['ref_paiement']);
        if($paiement_in_base) {
            return 1;
        }
        return 0;
    }

    // ra efa misy azy any am ligne ambony de tsy miditra le en cours
    public function check_raha_efa_teo_ambony($entree, $all_entree) {
        foreach ($all_entree as $key => $entree_eo_ambony) {
            if($entree_eo_ambony['ref_paiement'] == $entree['ref_paiement']) {
                return 1;
            }
        }
        return 0;
    }
    

    public function insert_import_devis($file) {
        $data = read_csv_data($file['name'], $ligneDeb = 2, $ligneFin = -1, $separateur = ',', $enclosure = '"');
		$data = enlever_caracteres_speciaux_tableau($data);
        foreach ($data as $key => $ecriture) {
            $entree = array();
            $entree['client'] = trim($ecriture[0]);
            $entree['ref_devis'] = trim($ecriture[1]);
            $entree['type_maison'] = trim($ecriture[2]);
            $entree['finition'] = trim($ecriture[3]);
            $entree['taux_finition'] = str_replace('%', '',(str_replace(',', '.', trim($ecriture[4]))));
            $entree['date_devis'] = trim($ecriture[5]);
            $entree['date_debut'] = trim($ecriture[6]);
			$entree['lieu'] = trim($ecriture[7]);
            $this->crud->create($entree, 'import_devis');
        }
    }

    public function insert_import_maison_travaux($file) {
        $data = read_csv_data($file['name'], $ligneDeb = 2, $ligneFin = -1, $separateur = ',', $enclosure = '"');
		$data = enlever_caracteres_speciaux_tableau($data);
        foreach ($data as $key => $ecriture) {
            $entree = array();
            $entree['type_maison'] = trim($ecriture[0]);
            $entree['description'] = trim($ecriture[1]);
            $entree['surface'] = str_replace(',', '.', trim($ecriture[2]));
            $entree['code_travaux'] = trim($ecriture[3]);
            $entree['type_travaux'] = trim($ecriture[4]);
            $entree['unite'] = trim($ecriture[5]);
			$entree['prix_unitaire'] = str_replace(',', '.', trim($ecriture[6]));
			$entree['quantite'] = str_replace(',', '.', trim($ecriture[7]));
			$entree['duree_travaux'] = str_replace(',', '.', trim($ecriture[8]));
            $this->crud->create($entree, 'import_maison_travaux');
        }
    }

    public function insert_paiement() {
        // insert paiement
        $this->insert_paiement_base();

        // maj colonne devis montant_paye_devis
        $this->maj_montant_paye_devis();
    }

    public function maj_montant_paye_devis() {
        if($this->db->simple_query("
            UPDATE devis
            SET montant_paye_devis = (
                SELECT COALESCE(SUM(p.montant_paiement), 0)
                FROM paiement p
                WHERE p.id_devis_paiement = devis.id_devis
            )
            WHERE id_devis IN (SELECT id_devis_paiement FROM paiement);
        ") == false) {
            return $this->db->error()['message'];
        };
    }

    public function insert_paiement_base() {
        if($this->db->simple_query("
            INSERT INTO paiement (
                id_devis_paiement,
                montant_paiement,
                dateheure_paiement,
                ref_paiement
            )
            SELECT
                d.id_devis,
                ip.montant::numeric(13,2),
                TO_TIMESTAMP(ip.date_paiement, 'DD/MM/YYYY'),
                ip.ref_paiement
            FROM
                import_paiement ip
            JOIN
                devis d ON ip.ref_devis = d.ref_devis;
        ") == false) {
            return $this->db->error()['message'];
        };
    return null;
    }

    public function insert_devis() {
        // 
        $this->insert_client();
        // type finition
        $this->insert_type_finition();
        // devis
        $this->insert_devis_base();
        // historique_devis
        $this->insert_historique_devis();
    }

    public function insert_maison_travaux() {
        $this->insert_type_maison();
        $this->insert_unite();
        $this->insert_type_travaux();
        $this->insert_travaux();
    }

    public function get_error_import_paiement($import_paiement, $errors = []) {
        $error_import_paiement = $this->import->validate_data_paiement($import_paiement);
            if(count($error_import_paiement) > 0) {
                $errstr = '';
                foreach ($error_import_paiement as $line => $error) {
                    $errstr .= "Erreur(s) à la ligne $line : " . implode(", ", $error) . "<br>";
                }
                $errors [] = $errstr;
            }
        return $errors;
    }

    public function get_error_import_devis($import_devis, $errors = []) {
        $error_import_devis = $this->import->validate_data_devis($import_devis);
            if(count($error_import_devis) > 0) {
                $errstr = '';
                foreach ($error_import_devis as $line => $error) {
                    $errstr .= "Erreur(s) à la ligne $line : " . implode(", ", $error) . "<br>";
                }
                $errors [] = $errstr;
            }
        return $errors;
    }

    public function get_error_import_maison_travaux($import_maison_travaux, $errors = []) {
        $error_import_maison_travaux = $this->import->validate_data_maison_travaux($import_maison_travaux);
            if(count($error_import_maison_travaux) > 0) {
                $errstr = '';
                foreach ($error_import_maison_travaux as $line => $error) {
                    $errstr .= "Erreur(s) à la ligne $line : " . implode(", ", $error) . "<br>";
                }
                $errors [] = $errstr;
            }
        return $errors;
    }

    public function clean_import_paiement_base() {
        if($this->db->simple_query("
            TRUNCATE TABLE import_paiement RESTART IDENTITY CASCADE;
        ") == false) {
            return $this->db->error()['message'];
        };
        return null;
    }

    public function clean_import_maison_travaux_devis_base() {
        if($this->db->simple_query("
            TRUNCATE TABLE import_maison_travaux RESTART IDENTITY CASCADE;
            TRUNCATE TABLE import_devis RESTART IDENTITY CASCADE;
        ") == false) {
            return $this->db->error()['message'];
        };
        return null;
    }

    public function insert_historique_devis() {
        try {
            if ($this->db->simple_query("
                INSERT INTO historique_travaux (
                    id_devis_histo,
                    id_tt_histo,
                    code_tt_histo,
                    nom_tt_histo,
                    id_unite_histo,
                    nom_unite_histo,
                    quantite_tt_histo,
                    pu_tt_histo,
                    prix_total_tt_histo
                )
                SELECT
                    d.id_devis,
                    tt.id_tt,
                    tt.code_tt,
                    tt.nom_tt,
                    ut.id_unite,
                    ut.nom_unite,
                    t.quantite_tt_travaux,
                    tt.pu_tt,
                    t.quantite_tt_travaux * tt.pu_tt AS prix_total_tt_histo
                FROM
                    devis d
                JOIN
                    travaux t ON d.id_tm_devis = t.id_tm_travaux
                JOIN
                    type_travaux tt ON t.id_tt_travaux = tt.id_tt
                JOIN
                    unite ut ON tt.id_unite_tt = ut.id_unite;
            ") == false) {
                return $this->db->error()['message'];
            };
            return null;
        } catch (Throwable $th) {
            var_dump($th);
        }
    }

    public function insert_devis_base() {
            try {
                if ($this->db->simple_query("
                INSERT INTO devis (
                    id_tm_devis,
                    id_tf_devis,
                    dateheure_creation_devis,
                    dateheure_debut_travaux,
                    dateheure_fin_travaux,
                    prix_total_devis,
                    montant_paye_devis,
                    etat_devis,
                    id_client_devis,
                    aug_tf_devis,
                    prix_brut_devis,
                    duree_construction,
                    nom_tm_devis,
                    nom_tf_devis,
                    surface_tm_devis,
                    ref_devis,
                    lieu_devis
                )
                SELECT
                    tm.id_tm,
                    tf.id_tf,
                    TO_TIMESTAMP(id.date_devis, 'DD/MM/YY') AS dateheure_creation_devis,
                    TO_TIMESTAMP(id.date_debut, 'DD/MM/YY') AS dateheure_debut_travaux,
                    TO_TIMESTAMP(id.date_debut, 'DD/MM/YY') + (tm.duree_tm || ' days')::interval AS dateheure_fin_travaux,
                    tm.prix_total_tm * (1 + (tf.aug_tf / 100)) AS prix_total_devis,
                    0,
                    10,
                    c.id_cli AS id_client_devis,
                    tf.aug_tf AS aug_tf_devis,
                    tm.prix_total_tm AS prix_brut_devis,
                    (tm.duree_tm || ' days')::interval AS duree_construction,
                    tm.nom_tm AS nom_tm_devis,
                    tf.nom_tf AS nom_tf_devis,
                    COALESCE(tm.surface_tm, 128) AS surface_tm_devis,
                    id.ref_devis AS ref_devis,
                    id.lieu AS lieu_devis
                FROM
                    import_devis id
                JOIN
                    v_type_maison tm ON id.type_maison = tm.nom_tm
                JOIN
                    type_finition tf ON id.finition = tf.nom_tf
                JOIN
                    clients c ON id.client = c.numero_cli
                JOIN
                    travaux tt ON tm.id_tm = tt.id_tm_travaux
                JOIN
                    type_travaux ttv ON tt.id_tt_travaux = ttv.id_tt
                GROUP BY 
                    tm.id_tm,
                    tm.duree_tm,
                    tf.id_tf,
                    id.date_devis,
                    id.date_debut,
                    tm.prix_total_tm,
                    tm.prix_total_tm * (1 + (tf.aug_tf / 100)),
                    c.id_cli,
                    tf.aug_tf,
                    tm.nom_tm,
                    tf.nom_tf,
                    tm.surface_tm,
                    id.ref_devis,
                    id.lieu
                ;
                ") == false) {
                    return $this->db->error()['message'];
                };
                return null;
            } catch (Throwable $th) {
                var_dump($th);
            }
    }

    public function insert_type_finition() {
        try {
            if ($this->db->simple_query("
                INSERT INTO type_finition (nom_tf, aug_tf)
                SELECT finition, taux_finition::numeric(10,2)
                FROM import_devis
                GROUP BY finition, taux_finition;
            ") == false) {
                return $this->db->error()['message'];
            };
            return null;
        } catch (Throwable $th) {
            var_dump($th);
        }
    }

    public function insert_client() {
        try {
            if ($this->db->simple_query("
                INSERT INTO clients (numero_cli)
                SELECT client
                FROM import_devis
                GROUP BY client;
            ") == false) {
                return $this->db->error()['message'];
            };
            return null;
        } catch (Throwable $th) {
            var_dump($th);
        }
    }

    public function insert_travaux() {
        try {
            if ($this->db->simple_query("
                INSERT INTO travaux (id_tm_travaux, id_tt_travaux, quantite_tt_travaux)
                SELECT
                    tm.id_tm,
                    tt.id_tt,
                    imt.quantite::numeric(10,2)
                FROM
                import_maison_travaux AS imt
                JOIN
                type_maison AS tm ON imt.type_maison = tm.nom_tm
                JOIN
                type_travaux AS tt ON imt.type_travaux = tt.nom_tt;
            ") == false) {
                return $this->db->error()['message'];
            };
            return null;
        } catch (Throwable $th) {
            var_dump($th);
        }
    }
    
    public function insert_type_travaux() {
        try {
            if ($this->db->simple_query("
                INSERT INTO type_travaux (code_tt, nom_tt, id_unite_tt, pu_tt)
                SELECT
                    imt.code_travaux,
                    imt.type_travaux,
                    u.id_unite,
                    imt.prix_unitaire::numeric(10,2)
                FROM
                    import_maison_travaux AS imt
                JOIN
                    unite AS u ON imt.unite = u.nom_unite
                GROUP BY 
                    imt.code_travaux,
                    imt.type_travaux,
                    u.id_unite,
                    imt.prix_unitaire::numeric(10,2);
            ") == false) {
                return $this->db->error()['message'];
            };
            return null;
        } catch (Throwable $th) {
            var_dump($th);
        }
    }

    public function insert_unite() {
        try {
            if ($this->db->simple_query("
                INSERT INTO unite (nom_unite)
                SELECT unite
                FROM import_maison_travaux
                GROUP BY unite;
            ") == false) {
                return $this->db->error()['message'];
            };
            return null;
        } catch (Throwable $th) {
            var_dump($th);
        }
    }

    public function insert_type_maison() {
        try {
            if ($this->db->simple_query("
                INSERT INTO type_maison (nom_tm, surface_tm, duree_tm)
                SELECT type_maison, surface::numeric(12,2), duree_travaux::numeric(10,2)
                FROM v_import_type_maison
                RETURNING id_tm, type_maison;

                WITH inserted_ids AS (
                    INSERT INTO description_maison (id_tm_descri, descri)
                    SELECT tm.id_tm, trim(unnest(string_to_array(vim.description, ','))) 
                    FROM (SELECT id_tm, nom_tm FROM type_maison WHERE nom_tm IN (SELECT type_maison FROM v_import_type_maison)) AS tm
                    JOIN v_import_type_maison AS vim ON tm.nom_tm = vim.type_maison
                    RETURNING id_descri, id_tm_descri
                  )
                SELECT id_descri, id_tm_descri
                FROM inserted_ids;
            ") == false) {
                return $this->db->error()['message'];
            };
            return null;
        } catch (Throwable $th) {
            var_dump($th);
        }
    }

    function validate_data_paiement($data) {
        $errors = [];

        // Parcours des données pour vérification
        foreach ($data as $row) {
            // Vérification de numseance
            if (!$this->isNumeric($row->montant)) {
                $errors[$row->ligne]['montant'] = 'montant non numerique';
            }

            if (!$this->isPositive($row->montant)) {
                $errors[$row->ligne]['montant'] = 'montant negative';
            }

            // Vérification de la date
            if (!$this->isValidDate($row->date_paiement)) {
                $errors[$row->ligne]['date_paiement'] = 'date paiement non valide';
            }
        }

        return $errors;
    }

    function validate_data_devis($data) {
        $errors = [];

        // Parcours des données pour vérification
        foreach ($data as $row) {
            // Vérification de numseance
            if (!$this->isNumeric($row->taux_finition)) {
                $errors[$row->ligne]['taux_finition'] = 'taux finition non numerique';
            }

            // if (!$this->isPositive($row->taux_finition)) {
            //     $errors[$row->ligne]['taux_finition'] = 'taux finition negative';
            // }

            // Vérification de la date
            if (!$this->isValidDate($row->date_devis)) {
                $errors[$row->ligne]['date_devis'] = 'date devis non valide';
            }
            
            // Vérification de la date
            if (!$this->isValidDate($row->date_debut)) {
                $errors[$row->ligne]['date_debut'] = 'date debut non valide';
            }
        }

        return $errors;
    }

    function validate_data_maison_travaux($data) {
        $errors = [];

        // Parcours des données pour vérification
        foreach ($data as $row) {
            // Vérification de numseance
            if (!$this->isNumeric($row->surface)) {
                $errors[$row->ligne]['surface'] = 'Surface non numerique';
            }

            if (!$this->isPositive($row->surface)) {
                $errors[$row->ligne]['surface'] = 'Surface negative';
            }

            if (!$this->isNumeric($row->prix_unitaire)) {
                $errors[$row->ligne]['prix_unitaire'] = 'prix_unitaire non numerique';
            }

            if (!$this->isPositive($row->prix_unitaire)) {
                $errors[$row->ligne]['prix_unitaire'] = 'prix_unitaire negatif';
            }

            if (!$this->isNumeric($row->quantite)) {
                $errors[$row->ligne]['quantite'] = 'quantite non numerique';
            }

            if (!$this->isPositive($row->quantite)) {
                $errors[$row->ligne]['quantite'] = 'quantite negative';
            }

            if (!$this->isNumeric($row->duree_travaux)) {
                $errors[$row->ligne]['duree_travaux'] = 'duree travaux non numerique';
            }

            if (!$this->isPositive($row->duree_travaux)) {
                $errors[$row->ligne]['duree_travaux'] = 'duree travaux negative';
            }

            // // Vérification de la date
            // if (!$this->isValidDate($row->date)) {
            //     $errors[$row->ligne]['date'] = 'Date non valide';
            // }

            // // Vérification de l'heure
            // if (!$this->isValidTime($row->heure)) {
            //     $errors[$row->ligne]['heure'] = 'Heure non valide';
            // }
        }

        return $errors;
    }

    function isPositive($str) {
        return $str >= 0;
    }

    function isNumeric($str) {
        return is_numeric($str);
    }

    function isValidDate($str) {
        $date = date_create_from_format('d/m/Y', $str);
        return $date !== false && !array_sum(date_get_last_errors());
    }

    function isValidTime($str) {
        return preg_match("/^(?:2[0-3]|[01][0-9]):[0-5][0-9]$/", $str);
    }
}
