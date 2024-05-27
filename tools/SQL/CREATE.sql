CREATE SEQUENCE seq_id_client;

CREATE SEQUENCE seq_id_admin;

CREATE SEQUENCE seq_id_tm;

CREATE SEQUENCE seq_id_tf;

CREATE SEQUENCE seq_id_tt;

CREATE SEQUENCE seq_id_unite;

CREATE SEQUENCE seq_id_devis;

CREATE SEQUENCE seq_id_paiement;

INSERT INTO type_maison
	( id_tm, nom_tm, etat_tm, duree_tm) VALUES
    ( DEFAULT, 'traditionnelle', DEFAULT, 26), 
    ( DEFAULT, 'contemporaine', DEFAULT, 35),
    ( DEFAULT, 'moderne', DEFAULT, 66.9);

INSERT INTO description_maison
	( id_descri, id_tm_descri, descri) VALUES 
    ( DEFAULT, 'TM_1', '2 Chambres' ),
    ( DEFAULT, 'TM_1', '1 Toilette' ),
    ( DEFAULT, 'TM_1', '1 Cuisine' );

INSERT INTO description_maison
	( id_descri, id_tm_descri, descri) VALUES 
    ( DEFAULT, 'TM_2', '3 Chambres' ),
    ( DEFAULT, 'TM_2', '1 Toilette' ),
    ( DEFAULT, 'TM_2', '1 Cuisine' ),
    ( DEFAULT, 'TM_2', '1 Roof-top' );

INSERT INTO description_maison
	( id_descri, id_tm_descri, descri) VALUES 
    ( DEFAULT, 'TM_3', '2 Etages' ),
    ( DEFAULT, 'TM_3', '4 Chambres' ),
    ( DEFAULT, 'TM_3', '2 Toilette' ),
    ( DEFAULT, 'TM_3', '2 Cuisine' ),
    ( DEFAULT, 'TM_3', '1 Roof-top' );

INSERT INTO type_finition
	( id_tf, nom_tf, aug_tf, etat_tf) VALUES 
    ( DEFAULT, 'Standard', 0, DEFAULT ),
    ( DEFAULT, 'Gold', 25, DEFAULT ),
    ( DEFAULT, 'Premium', 35.6, DEFAULT ),
    ( DEFAULT, 'VIP', 45.86, DEFAULT );

INSERT INTO unite
	( id_unite, nom_unite, etat_unite) VALUES 
    ( DEFAULT, 'm3', DEFAULT ),
    ( DEFAULT, 'm2', DEFAULT ),
    ( DEFAULT, 'fft', DEFAULT );

INSERT INTO type_travaux
	( id_tt, code_tt, nom_tt, id_unite_tt, pu_tt, etat_tt) VALUES 
    ( DEFAULT, '001', 'mur de soutenement et demi Cloture ht 1m', 'U_1', 190000.00, DEFAULT ),
    ( DEFAULT, '101', 'Décapage des terrains meubles', 'U_2', 3072.87, DEFAULT ),
    ( DEFAULT, '102', 'Dressage du plateforme', 'U_2', 3736.26, DEFAULT ),
    ( DEFAULT, '103', 'Fouille d ouvrage terrain ferme', 'U_1', 9390.93, DEFAULT ),
    ( DEFAULT, '104', 'Remblai d ouvrage', 'U_1', 37563.26, DEFAULT ),
    ( DEFAULT, '105', 'Travaux d implantation', 'U_3', 152656.00, DEFAULT ),
    ( DEFAULT, '201', 'maçonnerie de moellons, ep= 35cm', 'U_1', 172114.40, DEFAULT ),
    ( DEFAULT, '2021', 'beton armée dosée à 350kg/m3 semelles isolée', 'U_1', 573215.80, DEFAULT ),
    ( DEFAULT, '2022', 'beton armée dosée à 350kg/m3 amorces poteaux', 'U_1', 573215.80, DEFAULT ),
    ( DEFAULT, '2023', 'beton armée dosée à 350kg/m3 chaînage bas', 'U_1', 573215.80, DEFAULT ),
    ( DEFAULT, '203', 'remblai technique', 'U_1', 37563.26, DEFAULT ),
    ( DEFAULT, '204', 'herrissonage ep=10', 'U_1', 73245.40, DEFAULT ),
    ( DEFAULT, '205', 'beton ordinaire dosée à 300kg/m3 pour form', 'U_1', 487815.80, DEFAULT ),
    ( DEFAULT, '206', 'chape de 2cm', 'U_1', 33566.54, DEFAULT );

-- Traditionnelle
INSERT INTO travaux
( id_travaux, id_tm_travaux, id_tt_travaux, quantite_tt_travaux) VALUES
( DEFAULT, 'TM_1', 'TT_1', 26.8),
( DEFAULT, 'TM_1', 'TT_2', 101.36),
( DEFAULT, 'TM_1', 'TT_3', 101.36),
( DEFAULT, 'TM_1', 'TT_4', 24.44),
( DEFAULT, 'TM_1', 'TT_5', 15.59);


-- Contemporaine
INSERT INTO travaux
( id_travaux, id_tm_travaux, id_tt_travaux, quantite_tt_travaux) VALUES
( DEFAULT, 'TM_2', 'TT_1', 26.8),
( DEFAULT, 'TM_2', 'TT_2', 101.36),
( DEFAULT, 'TM_2', 'TT_3', 101.36),
( DEFAULT, 'TM_2', 'TT_4', 24.44),
( DEFAULT, 'TM_2', 'TT_5', 15.59),
( DEFAULT, 'TM_2', 'TT_6', 1 ),
( DEFAULT, 'TM_2', 'TT_7', 9.62 ),
( DEFAULT, 'TM_2', 'TT_8', 0.53 ),
( DEFAULT, 'TM_2', 'TT_9', 0.56 ),
( DEFAULT, 'TM_2', 'TT_10',2.44 );


-- Moderne
INSERT INTO travaux
( id_travaux, id_tm_travaux, id_tt_travaux, quantite_tt_travaux) VALUES
( DEFAULT, 'TM_3', 'TT_1', 26.8),
( DEFAULT, 'TM_3', 'TT_2', 101.36),
( DEFAULT, 'TM_3', 'TT_3', 101.36),
( DEFAULT, 'TM_3', 'TT_4', 24.44),
( DEFAULT, 'TM_3', 'TT_5', 15.59),
( DEFAULT, 'TM_3', 'TT_6', 1 ),
( DEFAULT, 'TM_3', 'TT_7', 9.62 ),
( DEFAULT, 'TM_3', 'TT_8', 0.53 ),
( DEFAULT, 'TM_3', 'TT_9', 0.56 ),
( DEFAULT, 'TM_3', 'TT_10',2.44 ),
( DEFAULT, 'TM_3', 'TT_11', 15.59 ),
( DEFAULT, 'TM_3', 'TT_12', 7.80 ),
( DEFAULT, 'TM_3', 'TT_13', 5.46 ),
( DEFAULT, 'TM_3', 'TT_14',77.97 );