UPDATE devis set duree_construction = dateheure_fin_travaux - dateheure_debut_travaux;

Update devis set nom_tm_devis = 'contemporaine' WHERE id_devis = 'D_10';
Update devis set nom_tm_devis = 'traditionnelle' WHERE id_devis = 'D_11';
Update devis set nom_tm_devis = 'moderne' WHERE id_devis = 'D_12';
Update devis set nom_tm_devis = 'traditionnelle' WHERE id_devis = 'D_13';
Update devis set nom_tm_devis = 'moderne' WHERE id_devis = 'D_14';
Update devis set nom_tm_devis = 'traditionnelle' WHERE id_devis = 'D_15';

UPDATE devis set nom_tf_devis = 'VIP' WHERE id_devis = 'D_10';
UPDATE devis set nom_tf_devis = 'Premium' WHERE id_devis = 'D_11';
UPDATE devis set nom_tf_devis = 'Gold' WHERE id_devis = 'D_12';
UPDATE devis set nom_tf_devis = 'Standard' WHERE id_devis = 'D_13';
UPDATE devis set nom_tf_devis = 'Premium' WHERE id_devis = 'D_14';
UPDATE devis set nom_tf_devis = 'Standard' WHERE id_devis = 'D_15';

UPDATE devis set surface_tm_devis = (SELECT surface_tm FROM type_maison WHERE id_tm = id_tm_devis);
UPDATE devis set ref_devis = id_devis;
UPDATE paiement set ref_paiement = id_paiement;
