<?php 

function fillWithZero($numero){
    $zeros = "";

    for ($i=0; $i < 5 - strlen($numero); $i++) { 
        $zeros = $zeros."0";
    }
    return $numero.$zeros;
    
}