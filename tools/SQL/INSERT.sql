INSERT INTO seance
	( id_seance, id_film_seance, id_salle_seance, date_heure_debut_seance, date_heure_fin_seance, etat_seance) VALUES 
    ( 'SEANCE_' || NEXTVAL('seq_id_seance'), 'F_1', 'SALLE_1', timestamp'2024-03-30 10:30', timestamp'2024-03-30 12:00', 1 ),
    ( 'SEANCE_' || NEXTVAL('seq_id_seance'), 'F_2', 'SALLE_3', timestamp'2024-03-30 12:30', timestamp'2024-03-30 14:00', 1 ),
    ( 'SEANCE_' || NEXTVAL('seq_id_seance'), 'F_1', 'SALLE_2', timestamp'2024-03-30 14:30', timestamp'2024-03-30 16:00', 1 );