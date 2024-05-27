-- table des contraintes (TEMPORAIRE)
CREATE TEMPORARY TABLE temp_constraints AS
SELECT conname constraintname, conrelid::regclass tablename, pg_get_constraintdef(oid) definition, contype 
FROM pg_catalog.pg_constraint
WHERE contype != 'c';

-- desactiver contraintes
DO $$
DECLARE constraint_name TEXT;
DECLARE constraint_table TEXT;
BEGIN
    FOR constraint_name, constraint_table IN
    SELECT constraintname ,  tablename FROM temp_constraints ORDER BY contype DESC
        LOOP
            EXECUTE 'ALTER TABLE ' || constraint_table || ' DROP CONSTRAINT IF EXISTS ' || constraint_name || ' CASCADE;';
        END LOOP;
END $$;

TRUNCATE TABLE aug_type_finition RESTART IDENTITY CASCADE;
TRUNCATE TABLE clients RESTART IDENTITY CASCADE;
TRUNCATE TABLE description_maison RESTART IDENTITY CASCADE;
TRUNCATE TABLE devis RESTART IDENTITY CASCADE;
TRUNCATE TABLE duree_type_maison RESTART IDENTITY CASCADE;
TRUNCATE TABLE historique_travaux RESTART IDENTITY CASCADE;
TRUNCATE TABLE import_devis RESTART IDENTITY CASCADE;
TRUNCATE TABLE import_maison_travaux RESTART IDENTITY CASCADE;
TRUNCATE TABLE import_paiement RESTART IDENTITY CASCADE;
TRUNCATE TABLE paiement RESTART IDENTITY CASCADE;
TRUNCATE TABLE prix_type_travaux RESTART IDENTITY CASCADE;
TRUNCATE TABLE travaux RESTART IDENTITY CASCADE;
TRUNCATE TABLE type_finition RESTART IDENTITY CASCADE;
TRUNCATE TABLE type_maison RESTART IDENTITY CASCADE;
TRUNCATE TABLE type_travaux RESTART IDENTITY CASCADE;
TRUNCATE TABLE unite RESTART IDENTITY CASCADE;

-- activer contraintes
DO $$
DECLARE constraint_table TEXT;
DECLARE constraint_definition TEXT;
BEGIN
    FOR constraint_table, constraint_definition IN 
    SELECT tablename, definition FROM temp_constraints ORDER BY contype DESC
        LOOP
            EXECUTE 'ALTER TABLE ' || constraint_table || ' ADD ' || constraint_definition || ';';
        END LOOP;
    DROP TABLE IF EXISTS temp_constraints;
END $$;