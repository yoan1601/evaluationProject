-- insert devis
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
    type_travaux ttv ON tt.id_tt_travaux = ttv.id_tt;


-- insert travaux
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

-- insert type_travaux
INSERT INTO type_travaux (code_tt, nom_tt, id_unite_tt, pu_tt)
SELECT
  imt.code_travaux,
  imt.type_travaux,
  u.id_unite,
  imt.prix_unitaire::numeric(10,2)
FROM
  import_maison_travaux AS imt
JOIN
  unite AS u ON imt.unite = u.nom_unite;

-- insert unite
INSERT INTO unite (nom_unite)
SELECT unite
FROM import_maison_travaux
GROUP BY unite;

-- insert type_maison
-- Étape 1 : Insérez les informations de la vue v_import_type_maison dans la table type_maison
INSERT INTO type_maison (nom_tm, surface_tm, duree_tm)
SELECT type_maison, surface::numeric(12,2), duree_travaux::numeric(10,2)
FROM v_import_type_maison
RETURNING id_tm, type_maison; -- Récupérer les IDs insérés

-- Étape 2 : Utilisez les IDs insérés pour insérer les descriptions correspondantes dans la table description_maison
WITH inserted_ids AS (
  -- Récupérer les IDs insérés de la table type_maison
  INSERT INTO description_maison (id_tm_descri, descri)
  SELECT tm.id_tm, trim(unnest(string_to_array(vim.description, ','))) 
  FROM (SELECT id_tm, nom_tm FROM type_maison WHERE nom_tm IN (SELECT type_maison FROM v_import_type_maison)) AS tm
  JOIN v_import_type_maison AS vim ON tm.nom_tm = vim.type_maison
  RETURNING id_descri, id_tm_descri
)
SELECT id_descri, id_tm_descri
FROM inserted_ids;

-- sql import
COPY import_seance (numseance, film, categorie, salle, "date", heure) 
FROM 'F:\wamp64\www\evalCinepax\files\docs\donnees-import.csv' DELIMITER ';' CSV HEADER;