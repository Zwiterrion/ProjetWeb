<?php 

    require_once 'fxc/xhtml5.php';
    require_once 'templates.php';
    require_once 'Data.php';
    require_once 'session.php';

    $user = session();
    
    if( $_POST['password'] != '' && $_POST['password_verif'] != '' && 
    	$_POST['pseudo'] != ''  && $_POST['email'] != '' ) {
    	
    	$password = $_POST['password'];
    	$login = $_POST['pseudo'];
    	$nom = $_POST['email'];
    
        if($password != $_POST['password_verif']){
            header('Location: inscription.php?errorPassword');    
            exit();
        }
        if(strlen($login) > 10) {
            header('Location: inscription.php?errorLogin');    
            exit();
        }

        $accessBase = new Data();
    	$result = $accessBase->insertIntoBase($login, $password, $nom);

    	if($result){
    	
    		$_SESSION['NAME_USER'] = $_POST['pseudo'];
    		$_SESSION['PASSWORD'] = $_POST['password'];
            $_SESSION['Code_Abonne'] = $accessBase->checkIntoBase($login,$password);

    		 header('Location: index.php');
             exit(); 
    	}
    	else 
        {
    		header('Location: inscription.php?errorDejaPris');	
            exit();
    	}

	}

    


    
