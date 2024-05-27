<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');

    if(!function_exists("enlever_caracteres_speciaux_tableau")) {
        function enlever_caracteres_speciaux_tableau($tableau) {
            $retour = [];
            foreach ($tableau as $key => $ligne) {
                // $retour[$key] = enlever_accents($chaine);
                // var_dump(enlever_accents($chaine));
                // var_dump($chaine);
                $words = [];
                foreach($ligne as $id => $word) {
                    $words [] = enlever_accents($word);
                }
                $retour [] = $words;
            }
            return $retour;
        }
    }

    // if(!function_exists("enlever_caracteres_speciaux")) {
    //     function enlever_caracteres_speciaux($chaine) {
    //         // Remplace tous les caractères non alphabétiques et non numériques par une chaîne vide
    //         $chaine_propre = preg_replace('/[^a-zA-Z0-9]/',  ' ', $chaine);
    //         return $chaine_propre;
    //     }
    // }

    function enlever_accents($chaine) {
        // // Convertit les caractères avec accents en caractères sans accent
        // $chaine_propre = iconv('UTF-8', 'ASCII//TRANSLIT', $chaine);
        // return $chaine_propre;
        $newchaine=str_replace("è", "e", trim($chaine));
        $newchaine=str_replace("é", "e", trim($newchaine));
        $newchaine=str_replace("ê", "e", trim($newchaine));
        $newchaine=str_replace("ë", "e", trim($newchaine));
        $newchaine=str_replace("à", "a", trim($newchaine));
        $newchaine=str_replace("â", "a", trim($newchaine));
        $newchaine=str_replace("ä", "a", trim($newchaine));
        $newchaine=str_replace("ç", "c", trim($newchaine));
        $newchaine=str_replace("º", "o.", trim($newchaine));
        $newchaine=str_replace("î", "i", trim($newchaine));
        return $newchaine;
    }

    if(!function_exists("decomposer_duree")) {
        function decomposer_duree($duree_en_jours) {
            $jours = floor($duree_en_jours);
            $fraction_de_jour = $duree_en_jours - $jours;

            $heures = floor($fraction_de_jour * 24);
            $minutes = round(($fraction_de_jour * 24 - $heures) * 60);

            return array(
                'jours' => $jours,
                'heures' => $heures,
                'minutes' => $minutes
            );
        }
    }

    if(!function_exists("add_to_date_time")) {
        function add_to_date_time($datetime_str, $to_add, $unite = 'jour') {
            // Convertir la date de début des travaux en objet DateTime
            $datetime = new DateTime($datetime_str);

            // Ajouter la durée de la maison (en jours) à la date de début des travaux
            $result_datetime = clone $datetime; // Clone pour éviter de modifier la date de début

            $duree_decomposed = decomposer_duree($to_add);

            // var_dump($duree_decomposed);

            if($unite == 'jour') {
                // $result_datetime->add(new DateInterval('P' . $to_add . 'D')); // Ajouter la durée en jours
                date_add($result_datetime, date_interval_create_from_date_string($duree_decomposed['jours']." days ".$duree_decomposed['heures']." hours ".$duree_decomposed['minutes']." minutes"));
            } 
            // else if ($unite == 'heure') {
            //     date_add($result_datetime, date_interval_create_from_date_string(intval($to_add)." hours"));
            // } else if ($unite == 'mois') {
            //     date_add($result_datetime, date_interval_create_from_date_string(intval($to_add)." months"));
            // } else if ($unite == 'annee') {
            //     date_add($result_datetime, date_interval_create_from_date_string(intval($to_add)." years"));
            // }
            else {// par defaut jour
                // date_add($result_datetime, date_interval_create_from_date_string(intval($to_add)." days"));
                date_add($result_datetime, date_interval_create_from_date_string($duree_decomposed['jours']." days ".$duree_decomposed['heures']." hours ".$duree_decomposed['minutes']." minutes"));
            }

            // Convertir la date de fin des travaux en format souhaité
            return $result_datetime->format('Y-m-d H:i:s');
        }
    }
?>