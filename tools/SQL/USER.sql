INSERT INTO authorite
	( id_auth, nom_auth) VALUES 
    ( DEFAULT, 'ADMIN' ),
    ( DEFAULT, 'CLIENT' );

INSERT INTO utilisateur
	( id_utilisateur, email, pwd) VALUES ( DEFAULT, 'yoan.rab@gmail.com', '1234' );

INSERT INTO utilisateur_auth
	( utilisateur, auth) VALUES 
    ( 1, 1 ),
    ( 1, 2 );
