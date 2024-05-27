CREATE SCHEMA IF NOT EXISTS "public";

CREATE SEQUENCE aug_type_finition_id_aug_tf_seq START WITH 1 INCREMENT BY 1;

CREATE SEQUENCE description_maison_id_descri_seq START WITH 1 INCREMENT BY 1;

CREATE SEQUENCE duree_type_maison_id_duree_tm_seq START WITH 1 INCREMENT BY 1;

CREATE SEQUENCE historique_travaux_id_histo_seq START WITH 1 INCREMENT BY 1;

CREATE SEQUENCE import_devis_ligne_seq START WITH 1 INCREMENT BY 1;

CREATE SEQUENCE import_maison_travaux_ligne_seq START WITH 1 INCREMENT BY 1;

CREATE SEQUENCE import_paiement_ligne_seq START WITH 1 INCREMENT BY 1;

CREATE SEQUENCE prix_type_travaux_id_prix_tt_seq START WITH 1 INCREMENT BY 1;

CREATE SEQUENCE seq_id_admin START WITH 1 INCREMENT BY 1;

CREATE SEQUENCE seq_id_client START WITH 1 INCREMENT BY 1;

CREATE SEQUENCE seq_id_devis START WITH 1 INCREMENT BY 1;

CREATE SEQUENCE seq_id_paiement START WITH 1 INCREMENT BY 1;

CREATE SEQUENCE seq_id_tf START WITH 1 INCREMENT BY 1;

CREATE SEQUENCE seq_id_tm START WITH 1 INCREMENT BY 1;

CREATE SEQUENCE seq_id_tt START WITH 1 INCREMENT BY 1;

CREATE SEQUENCE seq_id_unite START WITH 1 INCREMENT BY 1;

CREATE SEQUENCE travaux_id_travaux_seq START WITH 1 INCREMENT BY 1;

CREATE  TABLE admins ( 
	id_admin             varchar(50) DEFAULT ('ADMIN_'::text || nextval('seq_id_admin'::regclass)) NOT NULL  ,
	nom_admin            varchar(500)  NOT NULL  ,
	email_admin          varchar(500)  NOT NULL  ,
	pwd_admin            varchar(500)  NOT NULL  ,
	etat_admin           integer DEFAULT 10 NOT NULL  ,
	CONSTRAINT admins_pkey PRIMARY KEY ( id_admin )
 );

CREATE  TABLE clients ( 
	id_cli               varchar DEFAULT ('CLI_'::text || nextval('seq_id_client'::regclass)) NOT NULL  ,
	numero_cli           varchar(500)  NOT NULL  ,
	etat_cli             integer DEFAULT 10 NOT NULL  ,
	CONSTRAINT clients_pkey PRIMARY KEY ( id_cli )
 );

CREATE  TABLE import_devis ( 
	ligne                integer DEFAULT nextval('import_devis_ligne_seq'::regclass) NOT NULL  ,
	ref_devis            text    ,
	type_maison          text    ,
	finition             text    ,
	taux_finition        text    ,
	date_devis           text    ,
	date_debut           text    ,
	lieu                 text    ,
	client               text    
 );

CREATE  TABLE import_maison_travaux ( 
	ligne                integer DEFAULT nextval('import_maison_travaux_ligne_seq'::regclass) NOT NULL  ,
	type_maison          text    ,
	description          text    ,
	surface              text    ,
	code_travaux         text    ,
	type_travaux         text    ,
	unite                text    ,
	prix_unitaire        text    ,
	quantite             text    ,
	duree_travaux        text    
 );

CREATE  TABLE import_paiement ( 
	ligne                integer DEFAULT nextval('import_paiement_ligne_seq'::regclass) NOT NULL  ,
	ref_paiement         text    ,
	date_paiement        text    ,
	montant              text    ,
	ref_devis            text    
 );

CREATE  TABLE type_finition ( 
	id_tf                varchar DEFAULT ('TF_'::text || nextval('seq_id_tf'::regclass)) NOT NULL  ,
	nom_tf               varchar(500)  NOT NULL  ,
	aug_tf               numeric(10,2) DEFAULT 0 NOT NULL  ,
	etat_tf              integer DEFAULT 10 NOT NULL  ,
	CONSTRAINT type_finition_pkey PRIMARY KEY ( id_tf ),
	CONSTRAINT type_finition_nom_tf_key UNIQUE ( nom_tf ) 
 );

CREATE  TABLE type_maison ( 
	id_tm                varchar DEFAULT ('TM_'::text || nextval('seq_id_tm'::regclass)) NOT NULL  ,
	nom_tm               varchar(500)  NOT NULL  ,
	etat_tm              integer DEFAULT 10 NOT NULL  ,
	duree_tm             numeric(10,2)  NOT NULL  ,
	surface_tm           numeric(12,2) DEFAULT 128 NOT NULL  ,
	CONSTRAINT type_maison_nom_tm_key UNIQUE ( nom_tm ) ,
	CONSTRAINT type_maison_pkey PRIMARY KEY ( id_tm )
 );

CREATE  TABLE unite ( 
	id_unite             varchar DEFAULT ('U_'::text || nextval('seq_id_unite'::regclass)) NOT NULL  ,
	nom_unite            varchar(500)  NOT NULL  ,
	etat_unite           integer DEFAULT 10 NOT NULL  ,
	CONSTRAINT unite_pkey PRIMARY KEY ( id_unite )
 );

CREATE  TABLE aug_type_finition ( 
	id_tf_aug            varchar  NOT NULL  ,
	curr_aug_tf          numeric(10,2)  NOT NULL  ,
	dateheure_tf_aug     timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL  ,
	id_aug_tf            integer DEFAULT nextval('aug_type_finition_id_aug_tf_seq'::regclass) NOT NULL  ,
	CONSTRAINT aug_type_finition_pkey PRIMARY KEY ( id_aug_tf )
 );

CREATE  TABLE description_maison ( 
	id_descri            integer DEFAULT nextval('description_maison_id_descri_seq'::regclass) NOT NULL  ,
	id_tm_descri         varchar  NOT NULL  ,
	descri               text  NOT NULL  ,
	CONSTRAINT description_maison_pkey PRIMARY KEY ( id_descri )
 );

CREATE  TABLE devis ( 
	id_devis             varchar DEFAULT ('D_'::text || nextval('seq_id_devis'::regclass)) NOT NULL  ,
	id_tm_devis          varchar  NOT NULL  ,
	id_tf_devis          varchar  NOT NULL  ,
	dateheure_creation_devis timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL  ,
	dateheure_debut_travaux timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL  ,
	dateheure_fin_travaux timestamp    ,
	prix_total_devis     numeric(13,2) DEFAULT 0 NOT NULL  ,
	montant_paye_devis   numeric(13,2) DEFAULT 0 NOT NULL  ,
	etat_devis           integer DEFAULT 10 NOT NULL  ,
	id_client_devis      varchar  NOT NULL  ,
	aug_tf_devis         numeric(10,2)  NOT NULL  ,
	prix_brut_devis      numeric(13,2) DEFAULT 0 NOT NULL  ,
	duree_construction   interval    ,
	nom_tm_devis         varchar    ,
	nom_tf_devis         varchar    ,
	surface_tm_devis     numeric(12,2) DEFAULT 128   ,
	lieu_devis           text DEFAULT 'Imerintsiatosika'::text   ,
	ref_devis            text    ,
	CONSTRAINT devis_pkey PRIMARY KEY ( id_devis )
 );

CREATE  TABLE duree_type_maison ( 
	id_tm_duree          varchar  NOT NULL  ,
	curr_duree_tm        numeric(10,2)  NOT NULL  ,
	dateheure_tm_duree   timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL  ,
	id_duree_tm          integer DEFAULT nextval('duree_type_maison_id_duree_tm_seq'::regclass) NOT NULL  ,
	CONSTRAINT duree_type_maison_pkey PRIMARY KEY ( id_duree_tm )
 );

CREATE  TABLE historique_travaux ( 
	id_histo             integer DEFAULT nextval('historique_travaux_id_histo_seq'::regclass) NOT NULL  ,
	id_devis_histo       varchar  NOT NULL  ,
	id_tt_histo          varchar  NOT NULL  ,
	code_tt_histo        varchar  NOT NULL  ,
	nom_tt_histo         varchar  NOT NULL  ,
	id_unite_histo       varchar  NOT NULL  ,
	nom_unite_histo      varchar  NOT NULL  ,
	quantite_tt_histo    numeric(10,2)  NOT NULL  ,
	pu_tt_histo          numeric(10,2)  NOT NULL  ,
	prix_total_tt_histo  numeric(10,2)  NOT NULL  ,
	CONSTRAINT historique_travaux_pkey PRIMARY KEY ( id_histo )
 );

CREATE  TABLE paiement ( 
	id_paiement          varchar DEFAULT ('PAY_'::text || nextval('seq_id_paiement'::regclass)) NOT NULL  ,
	id_devis_paiement    varchar  NOT NULL  ,
	montant_paiement     numeric(13,2)  NOT NULL  ,
	dateheure_paiement   timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL  ,
	etat_paiement        integer DEFAULT 10 NOT NULL  ,
	ref_paiement         text    ,
	CONSTRAINT paiement_pkey PRIMARY KEY ( id_paiement ),
	CONSTRAINT paiement_ref_paiement_key UNIQUE ( ref_paiement ) 
 );

CREATE  TABLE type_travaux ( 
	id_tt                varchar DEFAULT ('TT_'::text || nextval('seq_id_tt'::regclass)) NOT NULL  ,
	nom_tt               varchar(1000)  NOT NULL  ,
	id_unite_tt          varchar  NOT NULL  ,
	pu_tt                numeric(10,2)  NOT NULL  ,
	etat_tt              integer DEFAULT 10 NOT NULL  ,
	code_tt              varchar    ,
	CONSTRAINT type_travaux_nom_tt_key UNIQUE ( nom_tt ) ,
	CONSTRAINT type_travaux_pkey PRIMARY KEY ( id_tt ),
	CONSTRAINT unique_code_tt UNIQUE ( code_tt ) 
 );

CREATE  TABLE prix_type_travaux ( 
	id_tt_prix           varchar  NOT NULL  ,
	curr_pu_tt           numeric(10,2)  NOT NULL  ,
	dateheure_tt_prix    timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL  ,
	id_prix_tt           integer DEFAULT nextval('prix_type_travaux_id_prix_tt_seq'::regclass) NOT NULL  ,
	CONSTRAINT prix_type_travaux_pkey PRIMARY KEY ( id_prix_tt )
 );

CREATE  TABLE travaux ( 
	id_tm_travaux        varchar  NOT NULL  ,
	id_tt_travaux        varchar  NOT NULL  ,
	quantite_tt_travaux  numeric(10,2)  NOT NULL  ,
	etat_travaux         integer DEFAULT 10 NOT NULL  ,
	id_travaux           integer DEFAULT nextval('travaux_id_travaux_seq'::regclass) NOT NULL  ,
	CONSTRAINT travaux_pkey PRIMARY KEY ( id_travaux )
 );

ALTER TABLE aug_type_finition ADD CONSTRAINT aug_type_finition_id_tf_aug_fkey FOREIGN KEY ( id_tf_aug ) REFERENCES type_finition( id_tf );

ALTER TABLE description_maison ADD CONSTRAINT description_maison_id_tm_descri_fkey FOREIGN KEY ( id_tm_descri ) REFERENCES type_maison( id_tm );

ALTER TABLE devis ADD CONSTRAINT devis_id_client_devis_fkey FOREIGN KEY ( id_client_devis ) REFERENCES clients( id_cli );

ALTER TABLE devis ADD CONSTRAINT devis_id_tf_devis_fkey FOREIGN KEY ( id_tf_devis ) REFERENCES type_finition( id_tf );

ALTER TABLE devis ADD CONSTRAINT devis_id_tm_devis_fkey FOREIGN KEY ( id_tm_devis ) REFERENCES type_maison( id_tm );

ALTER TABLE duree_type_maison ADD CONSTRAINT duree_type_maison_id_tm_duree_fkey FOREIGN KEY ( id_tm_duree ) REFERENCES type_maison( id_tm );

ALTER TABLE historique_travaux ADD CONSTRAINT historique_travaux_id_devis_histo_fkey FOREIGN KEY ( id_devis_histo ) REFERENCES devis( id_devis );

ALTER TABLE paiement ADD CONSTRAINT paiement_id_devis_paiement_fkey FOREIGN KEY ( id_devis_paiement ) REFERENCES devis( id_devis );

ALTER TABLE prix_type_travaux ADD CONSTRAINT prix_type_travaux_id_tt_prix_fkey FOREIGN KEY ( id_tt_prix ) REFERENCES type_travaux( id_tt );

ALTER TABLE travaux ADD CONSTRAINT travaux_id_tm_travaux_fkey FOREIGN KEY ( id_tm_travaux ) REFERENCES type_maison( id_tm );

ALTER TABLE travaux ADD CONSTRAINT travaux_id_tt_travaux_fkey FOREIGN KEY ( id_tt_travaux ) REFERENCES type_travaux( id_tt );

ALTER TABLE type_travaux ADD CONSTRAINT type_travaux_id_unite_tt_fkey FOREIGN KEY ( id_unite_tt ) REFERENCES unite( id_unite );

CREATE VIEW v_import_type_maison AS SELECT import_maison_travaux.type_maison,
    import_maison_travaux.description,
    import_maison_travaux.surface,
    import_maison_travaux.duree_travaux
   FROM import_maison_travaux
  GROUP BY import_maison_travaux.type_maison, import_maison_travaux.description, import_maison_travaux.surface, import_maison_travaux.duree_travaux;

CREATE VIEW v_montant_devis_mois_annee AS SELECT m.month AS mois,
    y.year AS annee,
    COALESCE(sum(d.prix_total_devis), (0)::numeric) AS montant_total
   FROM ((generate_series(1, 12) m(month)
     CROSS JOIN ( SELECT DISTINCT date_part('year'::text, devis.dateheure_creation_devis) AS year
           FROM devis) y)
     LEFT JOIN devis d ON (((date_part('month'::text, d.dateheure_creation_devis) = (m.month)::double precision) AND (date_part('year'::text, d.dateheure_creation_devis) = y.year))))
  GROUP BY m.month, y.year
  ORDER BY y.year, m.month;

CREATE VIEW v_paiement_devis AS SELECT paiement.id_devis_paiement,
    sum(paiement.montant_paiement) AS paiement_total
   FROM paiement
  WHERE (paiement.etat_paiement > 0)
  GROUP BY paiement.id_devis_paiement;

CREATE VIEW v_travaux AS SELECT w.id_tm_travaux,
    w.id_tt_travaux,
    w.quantite_tt_travaux,
    w.etat_travaux,
    w.id_travaux,
    (w.quantite_tt_travaux * tt.pu_tt) AS prix_total_tt
   FROM (travaux w
     JOIN type_travaux tt ON ((((tt.id_tt)::text = (w.id_tt_travaux)::text) AND (tt.etat_tt > 0))));

CREATE VIEW v_travaux_groupby_tm AS SELECT vw.id_tm_travaux,
    sum(vw.prix_total_tt) AS prix_total_tm
   FROM v_travaux vw
  GROUP BY vw.id_tm_travaux;

CREATE VIEW v_travaux_libcomplet AS SELECT w.id_tm_travaux,
    w.id_tt_travaux,
    w.quantite_tt_travaux,
    w.etat_travaux,
    w.id_travaux,
    tt.id_tt,
    tt.nom_tt,
    tt.id_unite_tt,
    tt.pu_tt,
    tt.etat_tt,
    tt.code_tt,
    u.id_unite,
    u.nom_unite,
    u.etat_unite,
    (w.quantite_tt_travaux * tt.pu_tt) AS prix_total_tt
   FROM ((travaux w
     JOIN type_travaux tt ON ((((tt.id_tt)::text = (w.id_tt_travaux)::text) AND (tt.etat_tt > 0))))
     JOIN unite u ON (((tt.id_unite_tt)::text = (u.id_unite)::text)));

CREATE VIEW v_type_maison AS SELECT tm.id_tm,
    tm.nom_tm,
    tm.etat_tm,
    tm.duree_tm,
    tm.surface_tm,
    v_travaux_gp_tm.prix_total_tm
   FROM (v_travaux_groupby_tm v_travaux_gp_tm
     JOIN type_maison tm ON ((((tm.id_tm)::text = (v_travaux_gp_tm.id_tm_travaux)::text) AND (tm.etat_tm > 0))));

CREATE VIEW v_type_travaux_libcomplet AS SELECT tt.id_tt,
    tt.nom_tt,
    tt.id_unite_tt,
    tt.pu_tt,
    tt.etat_tt,
    tt.code_tt,
    u.id_unite,
    u.nom_unite,
    u.etat_unite
   FROM (type_travaux tt
     LEFT JOIN unite u ON (((tt.id_unite_tt)::text = (u.id_unite)::text)))
  WHERE (tt.etat_tt > 0);

CREATE VIEW v_devis_libcomplet AS SELECT d.id_devis,
    d.id_tm_devis,
    d.id_tf_devis,
    d.dateheure_creation_devis,
    d.dateheure_debut_travaux,
    d.dateheure_fin_travaux,
    d.prix_total_devis,
    d.montant_paye_devis,
    d.etat_devis,
    d.id_client_devis,
    d.aug_tf_devis,
    d.prix_brut_devis,
    d.duree_construction,
    d.nom_tm_devis,
    d.nom_tf_devis,
    d.surface_tm_devis,
    d.lieu_devis,
    d.ref_devis,
    tm.id_tm,
    tm.nom_tm,
    tm.etat_tm,
    tm.duree_tm,
    tm.surface_tm,
    tf.id_tf,
    tf.nom_tf,
    tf.aug_tf,
    tf.etat_tf,
    c.id_cli,
    c.numero_cli,
    c.etat_cli,
    COALESCE(v_p.paiement_total, (0)::numeric) AS paiement_total,
    ((COALESCE(v_p.paiement_total, (0)::numeric) / d.prix_total_devis) * (100)::numeric) AS pourcentage_paiement
   FROM ((((devis d
     JOIN type_maison tm ON (((tm.id_tm)::text = (d.id_tm_devis)::text)))
     JOIN type_finition tf ON (((tf.id_tf)::text = (d.id_tf_devis)::text)))
     JOIN clients c ON (((c.id_cli)::text = (d.id_client_devis)::text)))
     LEFT JOIN v_paiement_devis v_p ON (((v_p.id_devis_paiement)::text = (d.id_devis)::text)))
  WHERE (d.etat_devis > 0);

INSERT INTO admins( id_admin, nom_admin, email_admin, pwd_admin, etat_admin ) VALUES ( 'ADMIN_1', 'Admin', 'admin@gmail.com', 'root', 10);