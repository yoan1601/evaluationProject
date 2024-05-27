<?php
defined('BASEPATH') OR exit('No direct script access allowed');
    if(!function_exists("read_csv_data")){
        function read_csv_data($nom_fichier, $ligneDeb = 1, $ligneFin = -1, $separateur= ',', $enclosure = '"')
        {
            $fichier = FCPATH . 'files/docs/' . $nom_fichier;
            if (!file_exists($fichier) || !is_readable($fichier)) {
                return FALSE;
            }
        
            $donnees = array();
            if (($fichier_handle = fopen($fichier, 'r')) !== FALSE) {
                $nligne = 1;
                while (($ligne = fgetcsv($fichier_handle, 1000, $separateur, $enclosure)) !== FALSE) {
                    if($ligneFin > 0) {
                        if($nligne >= $ligneDeb && $nligne <= $ligneFin) {
                            $donnees[] = $ligne;
                        }
                    }
                    else {
                        if($nligne >= $ligneDeb) {
                            $donnees[] = $ligne;
                        }
                    }
                    $nligne ++;
                }
                fclose($fichier_handle);
            }
            return $donnees;
        }
        
    }
    if(!function_exists("setup_photo")){
        function setup_photo($path = "./files/images/film/"){
            $config['upload_path']=$path;
            $config['allowed_types']='jpeg|jpg|png|JPG|PNG';
            $ci=& get_instance();
            $ci->upload->initialize($config);
        }
    }
    if(!function_exists("setup_docs")){
        function setup_docs($path = "./files/docs"){
            $config['upload_path']= $path;
            $config['allowed_types']='jpeg|jpg|png|pdf|csv|JPG|PNG|xlsx|xls|ods';
            $ci=& get_instance();
            $ci->upload->initialize($config);
        }
    }
    if(!function_exists("upload")){
        function upload($name){
            $ci=& get_instance();
            try{
                $ci->upload->do_upload($name);
                return $ci->upload->data('file_name');
            }catch(Exception $e){
                // redirect('admin/modifSociete/0');
                echo $e->getMessage();
            }
        }
    }
    
    if(!function_exists("multiUpload")){
        function multiUpload($files){
            $ci=& get_instance();
            $target_dir="./files/docs/";
            $names=array();
            for($i=0; $i<count($files["name"]); $i++){
                $target_file=$target_dir.basename($files["name"][$i]);
                move_uploaded_file($files["tmp_name"][$i], $target_file);
                array_push($names, $files["name"][$i]);
            }
            return $names;
        }
    }
?>
