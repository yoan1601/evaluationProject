-- insert paiement 
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

-- histotique_travaux
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


-- v_import_type_maison
CREATE OR REPLACE view v_import_type_maison AS (
    SELECT 
        type_maison,
        description,
        surface,
        duree_travaux
    FROM import_maison_travaux
    GROUP BY 
        type_maison,
        description,
        surface,
        duree_travaux
);

-- type travaux
CREATE OR REPLACE VIEW v_type_travaux_libcomplet AS (
    SELECT 
    tt.*,
    u.*
    FROM type_travaux tt
    LEFT JOIN unite u ON tt.id_unite_tt = u.id_unite
    WHERE tt.etat_tt > 0 
);

-- montant devis par mois par annee
CREATE OR REPLACE VIEW v_montant_devis_mois_annee AS (
    SELECT 
        m.month AS mois,
        y.year AS annee,
        COALESCE(SUM(d.prix_total_devis), 0) AS montant_total
    FROM 
        generate_series(1, 12) AS m(month)
    CROSS JOIN 
        (SELECT DISTINCT EXTRACT(YEAR FROM dateheure_creation_devis) AS year FROM devis) AS y
    LEFT JOIN 
        devis d ON EXTRACT(MONTH FROM d.dateheure_creation_devis) = m.month AND EXTRACT(YEAR FROM d.dateheure_creation_devis) = y.year
    GROUP BY 
        m.month, y.year
    ORDER BY 
        y.year, m.month 
);


select * from v_montant_devis_mois_annee WHERE annee = 2024;

CREATE OR REPLACE VIEW v_devis_libcomplet AS (
    SELECT 
    d.*,
    tm.*,
    tf.*,
    c.*,
    COALESCE(v_p.paiement_total, 0) as paiement_total,
    (COALESCE(v_p.paiement_total, 0) / d.prix_total_devis)*100 AS pourcentage_paiement
    FROM devis d
    JOIN type_maison tm ON tm.id_tm = d.id_tm_devis
    JOIN type_finition tf ON tf.id_tf = d.id_tf_devis
    JOIN clients c ON c.id_cli = d.id_client_devis 
    LEFT JOIN v_paiement_devis v_p ON v_p.id_devis_paiement = d.id_devis 
    WHERE d.etat_devis > 0 
);

-- paiement 
CREATE OR REPLACE VIEW v_paiement_devis AS (
    SELECT 
    id_devis_paiement,
    SUM(montant_paiement) AS paiement_total
    FROM paiement
    WHERE etat_paiement > 0
    GROUP BY id_devis_paiement
);


-- type maison avec son prix actuel
-- la vue
CREATE OR REPLACE VIEW v_type_maison AS (
    SELECT 
        tm.*,
        v_travaux_gp_tm.prix_total_tm
    FROM v_travaux_groupby_tm v_travaux_gp_tm
    JOIN type_maison tm ON tm.id_tm = v_travaux_gp_tm.id_tm_travaux AND tm.etat_tm > 0
);

-- avoir prix total de chaque type maison dans v_travaux
CREATE OR REPLACE VIEW v_travaux_groupby_tm AS (
    SELECT 
    vw.id_tm_travaux,
    SUM(vw.prix_total_tt) AS prix_total_tm
    FROM v_travaux vw 
    GROUP BY vw.id_tm_travaux
);

-- avoir prix total de chaque type travaux dans travaux
CREATE OR REPLACE VIEW v_travaux AS (
    SELECT 
    w.*,
    w.quantite_tt_travaux * tt.pu_tt AS prix_total_tt
    FROM travaux w 
    JOIN type_travaux tt ON tt.id_tt = w.id_tt_travaux AND tt.etat_tt > 0
);

CREATE OR REPLACE VIEW v_travaux_libcomplet AS (
    SELECT 
    w.*,
    tt.*,
    u.*,
    w.quantite_tt_travaux * tt.pu_tt AS prix_total_tt
    FROM travaux w 
    JOIN type_travaux tt ON tt.id_tt = w.id_tt_travaux AND tt.etat_tt > 0
    JOIN unite u ON tt.id_unite_tt = u.id_unite
);

