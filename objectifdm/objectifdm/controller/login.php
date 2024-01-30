<?php

// require_once($_SERVER['DOCUMENT_ROOT'] . "/config/database.php");

require_once ("../config/database.php");

        /****************************************/
        /** Controller du pages login/index.php */
        /****************************************/

	//Récupérer les données
	$sql="SELECT parusers,parpassword  FROM fparams WHERE (parusers=? and parpassword=?)";									   
					
	$stmt = $conn->prepare($sql);
	$stmt->execute([
		$_POST['identifiant'],
		$_POST['password']
	]);
	$res = $stmt->fetchObject();

	if ($res > 0){
		session_start();
		$_SESSION['user_in'] = true;
		$_SESSION['identifiant'] = $_POST['identifiant'];
		header("location: ../pages/accueil/index.php");
		// echo 'Connected successfuly';

		
	} else{
		//echo"<script>alert('Identifiant ou mot de passe incorrect');</script>";	
		header("location: ../pages/login/index.php");
		//echo 'erreur de connexion';
	}
	