<?php 

function session() {

   	session_start();
   	
   	if(isset($_SESSION["NAME_USER"])) {
        return ['login' => $_SESSION["NAME_USER"]];
    }
    else {
        return [];
    }
}