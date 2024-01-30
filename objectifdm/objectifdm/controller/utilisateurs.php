<?php
// require_once($_SERVER['DOCUMENT_ROOT'] . "/config/database.php");
require_once ("../../config/database.php");


							/*****************/
                            /* NON UTILISER  */
                            /*****************/

        /************************************************************/
        /** Controller pour la création d'un utilisateurs pour test */
        /************************************************************/

	//insertion dans la base de données
				if( isset ($_POST['identifiant']) AND isset($_POST['password'])){
				$identifiant = $_POST['identifiant'];
				$password = $_POST['password']; 

				$sql = "INSERT INTO fparams(parusers,parpassword,parmultik,pardatecres) VALUES ('$identifiant','$password','1.20',current_timestamp)";
				//var_dump($sql);

				$result=$conn->query($sql);
				//var_dump($result);
				//echo 'Insertion réussie';	
				header('Location:../../../pages/utilisateurs/index.php');
				exit();
  				echo"<script>alert('Insertion réussite')</script>";			  
				if(!$result){
				echo 'non result';
				}
			}
 ?>


