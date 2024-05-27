<?php

 require("connect.php");
 include("utile.php");
 $connexion = getConnectionPqsql();

 $id_devis = $_POST['id_devis'];
 $montant = $_POST['montant'];

 // fetch  
 $sql = "SELECT * from v_devis_libcomplet WHERE id_devis_paiement = ".$id_devis;

 $resultats=$connexion->query($sql);

 $resultats->setFetchMode(PDO::FETCH_OBJ); // on dit qu'on veut que le résultat soit récupérable sous forme d'objet

 header( "Content-Type: application/json");

 $l_devis = [];
 while( $ligne = $resultats->fetch() ) {  //OR while( $ligne = $resultats->fetch(PDO::FETCH_OBJ){ et en enlevant la ligne au dessus

    $l_devis [] = $ligne;

 }

 $message = [
    "ok" => 1,
    "montant" => $montant,
    "nouveau_montant_total" => $montant,
    "id_devis" => $id_devis
 ];

 if(count($l_devis) > 0) {
    $devis = $l_devis[0];
    $nouveau_montant_total = $montant_effectue + $montant;
    if($devis->prix_total_devis < $nouveau_montant_total) {
        $message["ok"] = 0;
        $message["nouveau_montant_total"] = $nouveau_montant_total;
        $message["prix_total_devis"] = $devis->prix_total_devis;
    }
 }

$resultats->closeCursor(); // on ferme le curseur des résultats

//echo $retour;

echo json_encode($message);

?>
