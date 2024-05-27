<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DevisModel extends CI_Model {

    public function set_color($liste_devis) {
        foreach ($liste_devis as $key => $devis) {
            $devis->bg_color = '';
            if($devis->pourcentage_paiement < 50) {
                $devis->bg_color = 'bg-danger';
            } else if ($devis->pourcentage_paiement > 50) {
                $devis->bg_color = 'bg-success';
            }
        }
    }

    public function get_paiements_by_devis($id_devis) {
        $this->db->where('id_devis_paiement', $id_devis);
        $this->db->order_by('dateheure_paiement ', 'DESC');
        $query = $this->db->get('paiement');
        return $query->result();
    }

    public function export_PDF($id_devis = 'D_10')
    {
        $this->load->library('MYPDF');

        $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'utf-8', false);
        // Ajouter une page
        $pdf->AddPage();
        
        $devis = $this->crud->find_by_id('v_devis_libcomplet', 'id_devis', $id_devis);
        $surface_tm_devis = format_currency($devis->surface_tm_devis);
        $prix_total_devis = format_currency($devis->prix_total_devis);
        $montant_paye_devis = format_currency($devis->montant_paye_devis);
        $reste_a_payer = format_currency($devis->prix_total_devis - $devis->montant_paye_devis);
        $txt = <<<EOD
            <h3>Detail du devis</h3>
            <div>
                    <p><span>Reference : </span> <strong>$devis->ref_devis</strong></p>
                    <p><span>Lieu : </span> <strong>$devis->lieu_devis</strong></p>
                    <p><span>Type de maison : </span> <strong>$devis->nom_tm_devis</strong></p>
                    <p><span>Surface : </span> <strong>$surface_tm_devis</strong></p>
                    <p><span>Finition : </span><strong> $devis->nom_tf_devis</strong> ($devis->aug_tf_devis %)</p>
                    <p><span>Prix total : </span> <strong> $prix_total_devis Ar</strong></p>
                    <p><span>Montant déjà payé : </span><strong> $montant_paye_devis Ar</strong></p>
                    <p><span>Reste à payer : </span><strong> $reste_a_payer Ar</strong></p>
            </div>
        EOD;
            // print a block of text using Write()
            $pdf->writeHTMLCell(0, 0, '', '', $txt, 0, 1, 0, true, '', true);
            $pdf->Cell(0, 10, '', '', 1, 'L');

        $lignes = '';
        $liste_travaux = $this->devis->get_historique($id_devis);
        foreach ($liste_travaux as $key => $travaux) { 
            $quantite_tt_histo = format_currency($travaux->quantite_tt_histo);
            $pu_tt_histo = format_currency($travaux->pu_tt_histo);
            $prix_total_tt_histo = format_currency($travaux->prix_total_tt_histo);
            
            $lignes .= '<tr>
                <td>'.$travaux->code_tt_histo.'</td>
                <td>'.$travaux->nom_tt_histo.'</td>
                <td>'.$travaux->nom_unite_histo.'</td>
                <td style="text-align: right;">'.$quantite_tt_histo.'</td>
                <td style="text-align: right;">'.$pu_tt_histo.' Ar</td>
                <td style="text-align: right;">'.$prix_total_tt_histo.' Ar</td>
            </tr>';
        }

        $lignes_paiement = '';
        $devis = $this->crud->find_by_id('v_devis_libcomplet', 'id_devis', $id_devis);
		$liste_paiement = $this->devis->get_paiements_by_devis($id_devis);
        foreach ($liste_paiement as $key => $paiement) { 
            $montant_paiement = format_currency($paiement->montant_paiement);
            $dateheure_paiement = format_date($paiement->dateheure_paiement);
            $lignes_paiement .= '
            <tr>
            <td>'.$paiement->ref_paiement.'</td>
            <td style="text-align: right;">'.$montant_paiement.' Ar</td>
            <td>'.$dateheure_paiement.'</td>
            </tr>';
        }

        $prix_brut_devis = format_currency($devis->prix_brut_devis);
        $montant_paye_devis = format_currency($devis->montant_paye_devis);
        $listes_travavaux_html = <<<EOD
        <style>
            table, th, td {
                border: 1px solid black;
                border-collapse: collapse;
            }
        </style>
        <h3>Liste des travaux</h3>
        <div class="card mb-2">
            <div>
                <table cell="1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Designation</th>
                            <th>Unite</th>
                            <th style="text-align: right;">Quantite</th>
                            <th style="text-align: right;">Prix unitaire</th>
                            <th style="text-align: right;">Total</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        $lignes
                    </tbody>
                </table>
            </div>
            <div>
            <p><span>Montant total travaux : </span><strong>$prix_brut_devis Ar</strong></p>
            <p><span>Taux finition : </span><strong>$devis->aug_tf_devis %</strong></p>
            <p><span>Total devis : </span><strong>$prix_total_devis Ar</strong></p>
            </div>
        </div>

        <h3>Liste des paiements</h3>
        <div class="card mb-2">
            <div>
        <table class="table">
            <thead>
                <tr>
                    <th>Ref</th>
                    <th style="text-align: right;">Montant</th>
                    <th>Date de paiement</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                $lignes_paiement
            </tbody>
        </table>
        </div>
            <div>
            <p><span>Paiement total effectue : </span><strong>$montant_paye_devis Ar</strong></p>
            </div>
        </div>
        EOD;
            // print a block of text using Write()
            $pdf->writeHTMLCell(0, 0, '', '', $listes_travavaux_html, 0, 1, 0, true, '', true);
            $pdf->Cell(0, 10, '', '', 1, 'L');

        // ---------------------------------------------------------
        ob_clean();

        //Close and output PDF document
        $pdf->Output('devis.pdf', 'I');
    }

    public function get_paiement_total() {
        $query = $this->db->query('SELECT SUM(paiement_total) as paiement_total FROM v_paiement_devis');
        $row = $query->row();
        $devis_total = $row->paiement_total;
        return $devis_total;
    }

    public function get_devis_total() {
        $query = $this->db->query('SELECT SUM(prix_total_devis) as devis_total FROM devis');
        $row = $query->row();
        $devis_total = $row->devis_total;
        return $devis_total;
    }

    public function get_historique($id_devis) {
        $this->db->where('id_devis_histo', $id_devis);
        $this->db->order_by('code_tt_histo ', 'ASC');
        $query = $this->db->get('historique_travaux');
        return $query->result();
    }

    public function all() {
        $this->db->order_by('dateheure_creation_devis ', 'DESC');
        $query = $this->db->get('v_devis_libcomplet');
        return $query->result();
    }

    public function effectuer_paiement($id_devis, $montant, $dateheure_paiement, $ref_paiement) {
        $data = [
            'ref_paiement' => $ref_paiement,
            'id_devis_paiement' => $id_devis,
            'montant_paiement' => $montant,
            'dateheure_paiement' => $dateheure_paiement
        ];
        $this->crud->create($data, 'paiement');
        $devis = $this->crud->find_by_id('devis', 'id_devis', $id_devis);
        $this->crud->update('id_devis', $id_devis, ['montant_paye_devis' => $montant + $devis->montant_paye_devis], 'devis');
    }

    public function paiement_validation_config() {
        $config = array(
            array(
                'field' => 'ref_paiement',
                'label' => 'reference de paiement',
                'rules' => array('trim','required'),
                'errors' => array(
                    'required' => 'Vous devez fournir une %s.'
                )
            ),
            array(
                'field' => 'montant',
                'label' => 'montant',
                'rules' => array('trim','required', 'greater_than[0]'),
                'errors' => array(
                    'required' => 'Vous devez fournir un %s.',
                    'greater_than' => 'Le %s doit etre superieur à %s'
                )
            ),
            
            array(
                    'field' => 'dateheure_paiement',
                    'label' => 'date de paiement',
                    'rules' => array('trim','required'),
                    'errors' => array(
                        'required' => 'Vous devez fournir une %s.'
                    ),
            )
        );

        return $config;
    }

    public function find_by_client($id_cli) {
        $this->db->where('id_client_devis', $id_cli);
        $this->db->order_by('id_devis', 'DESC');
        $query = $this->db->get('v_devis_libcomplet');
        return $query->result();
    }

    public function insert_devis($data) {
        $this->db->trans_start();
        try {
            $this->db->insert('devis', $data);
            $id_devis = 'D_'.$this->db->insert_id();
            $sql = "UPDATE devis set prix_total_devis = (".$data['prix_brut_devis']." + (".$data['prix_brut_devis']." * (".$data['aug_tf_devis'].") / 100)) WHERE id_devis = '".$id_devis."'";
            if ($this->db->simple_query($sql) == false) {
                $this->db->trans_rollback();
                return $this->db->error()['message'];
            };

            // update interval
            $sql = "UPDATE devis set duree_construction = dateheure_fin_travaux - dateheure_debut_travaux WHERE id_devis = '".$id_devis."'";
            if ($this->db->simple_query($sql) == false) {
                $this->db->trans_rollback();
                return $this->db->error()['message'];
            };

            // insertion dans historique devis
            $travaux = $this->tm->get_travaux($data['id_tm_devis']);

            foreach ($travaux as $key => $tt) {
                $histo_data = [
                    'id_devis_histo' => $id_devis,
                    'id_tt_histo' => $tt->id_tt,
                    'code_tt_histo' => $tt->code_tt,
                    'nom_tt_histo' => $tt->nom_tt,
                    'id_unite_histo' => $tt->id_unite_tt,
                    'nom_unite_histo' => $tt->nom_unite,
                    'quantite_tt_histo' => $tt->quantite_tt_travaux,
                    'pu_tt_histo' => $tt->pu_tt,
                    'prix_total_tt_histo' => $tt->prix_total_tt
                ];
                $this->db->insert('historique_travaux', $histo_data);
            }

            $this->db->trans_commit();
            return null;
        } catch (\Throwable $th) {
            var_dump($th);
            $this->db->trans_rollback();
        }
       
    }

    public function create_table_contrainte() {
        if ($this->db->simple_query("
            CREATE TEMPORARY TABLE temp_constraints AS
            SELECT conname constraintname, conrelid::regclass tablename, pg_get_constraintdef(oid) definition, contype 
            FROM pg_catalog.pg_constraint
            WHERE contype != 'c'
        ") == false) {
            return $this->db->error()['message'];
        };
        return null;
    }
}
