<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DataModel extends CI_Model {
    public function create_table_contrainte() {
        if ($this->db->simple_query("
            CREATE TEMPORARY TABLE temp_constraints AS
            SELECT conname constraintname, conrelid::regclass tablename, pg_get_constraintdef(oid) definition, contype 
            FROM pg_catalog.pg_constraint
            WHERE contype != 'c'
        ") == false) {
            return $this->db->error()['message'];
        };
        return null;
    }

    public function enlever_contraintes() {
        if ($this->db->simple_query("
            DO $$
            DECLARE constraint_name TEXT;
            DECLARE constraint_table TEXT;
            BEGIN
                FOR constraint_name, constraint_table IN
                SELECT constraintname ,  tablename FROM temp_constraints ORDER BY contype DESC
                    LOOP
                        EXECUTE 'ALTER TABLE ' || constraint_table || ' DROP CONSTRAINT IF EXISTS ' || constraint_name || ' CASCADE;';
                    END LOOP;
            END $$
        ") == false) {
            return $this->db->error()['message'];
        };
        return null;
    }

    public function reset_data($tables = []) {
        if(count($tables) > 0) {
            $sql = '';
            foreach ($tables as $key => $table) {
                $sql .= 'TRUNCATE TABLE '.$table.' RESTART IDENTITY CASCADE;';
            }
            if ($this->db->simple_query($sql) == false) {
                return $this->db->error()['message'];
            };
            return null;
        }
    }

    public function activer_contraintes() {
        if ($this->db->simple_query("
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
        ") == false) {
            return $this->db->error()['message'];
        };
        return null;
    }
}
