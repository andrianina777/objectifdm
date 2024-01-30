<?php
// require_once($_SERVER['DOCUMENT_ROOT'] . "/config/database.php");
require_once ("../config/database.php");

const HTTP_OK = 200;
const HTTP_BAD_REQUEST = 400;
const HTTP_METHOD_NOT_ALLOWED = 405;


session_start();
// Vérifiez si l'utilisateur est connecté, sinon redirigez-le vers la page de connexion
if(!isset($_SESSION["user_in"])){
  header("Location: ../../index.php");
  exit(); 
  $_SESSION['identifiant'] = $_POST['identifiant'];
}

$dmusercre = $_SESSION['identifiant'] ;

        /*****************************************************************************************************/
        /** Controller du pages DM/edit_labo.php (C'est qui affiche les labos non ajouter dans la créations) */
        /*****************************************************************************************************/

if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtoupper($_SERVER['HTTP_X_REQUESTED_WITH']) == 'XMLHTTPREQUEST') {
        $response_code = HTTP_BAD_REQUEST;
        //$message = "Veuillez choisir un labo ou remplir les champs vides";

        if ($_POST['action'] == "getName") {
            $response_code = HTTP_OK;
            $nameLabo = $_POST['dm_data'];
            $keys = array_keys($_POST["dm_data"]);
            $value = array_values($_POST["dm_data"]);

            $dm = $keys[0];
            $dm_value = $value[0];


			//var_dump($dm_value);
            
			// Get list labo dans select
			// $queryLabo = "SELECT DISTINCT labo FROM view_article WHERE labo NOT IN (SELECT DISTINCT lablabo FROM flabodm WHERE lab_dmprenom='$dm_value') ORDER BY labo ASC";
            
			// $queryLabo = "SELECT DISTINCT labo FROM view_article inner join flabsup on lab_labo=labo";

			$queryLabo = "SELECT DISTINCT labo FROM view_article inner join flabsup on lab_labo=labo WHERE labo NOT IN (SELECT DISTINCT lablabo FROM flabodm WHERE lab_dmprenom='$dm_value')  and lab_sup='$dmusercre' ORDER BY labo ASC";

			// $queryLabo = "SELECT lablabo FROM flabodm";
			$stmt = $conn->prepare($queryLabo);
			$stmt->execute();
			$resultLabo = $stmt->fetchAll();

			//var_dump($resultLabo);
			
			echo header("Content-type: Application/json;"); 
			echo json_encode([
				"laboList" => $resultLabo
			 ]);   
			 result($resultLabo);
		}
	}
    else {
                // $response_code = HTTP_METHOD_NOT_ALLOWED;
                // $message = "Method not allowed";
                // reponse($response_code,$message);
            }
            
            function result($message)
            {
                $response = [
                    //"response_code" => $response_code,
                    //  $message
                
                ];
            
                //echo json_encode($response);
            }