ALTER TABLE clients
ALTER COLUMN id_cli SET DEFAULT 'CLI_' || NEXTVAL('seq_id_client');

ALTER TABLE admins
ALTER COLUMN id_admin SET DEFAULT 'ADMIN_' || NEXTVAL('seq_id_admin');

ALTER TABLE type_maison
ALTER COLUMN id_tm SET DEFAULT 'TM_' || NEXTVAL('seq_id_tm');

ALTER TABLE type_finition
ALTER COLUMN id_tf SET DEFAULT 'TF_' || NEXTVAL('seq_id_tf');

ALTER TABLE type_travaux
ALTER COLUMN id_tt SET DEFAULT 'TT_' || NEXTVAL('seq_id_tt');

ALTER TABLE unite
ALTER COLUMN id_unite SET DEFAULT 'U_' || NEXTVAL('seq_id_unite');

ALTER TABLE devis
ALTER COLUMN id_devis SET DEFAULT 'D_' || NEXTVAL('seq_id_devis');

ALTER TABLE paiement
ALTER COLUMN id_paiement SET DEFAULT 'PAY_' || NEXTVAL('seq_id_paiement');

ALTER TABLE paiement ADD CONSTRAINT unique_ref_paiement unique(ref_paiement);

ALTER TABLE type_travaux ADD CONSTRAINT unique_code_tt unique(code_tt);
