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
/**********************************************************************/
/* Controller pour envoyer les cases à cocher dans la base de données */
/**********************************************************************/

if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtoupper($_SERVER['HTTP_X_REQUESTED_WITH']) == 'XMLHTTPREQUEST') {

    if ($_POST['action'] == "sendSelected") {
        $response_code = HTTP_OK;
        $selected = $_POST['row'];
        $form = $_POST['formData'];
        $coms = $_POST['valcoms'];
         
        //    var_dump($coms);die;

          // echo($selected)


        try {
            foreach ($selected as $v) {
                $stmt = $conn->prepare("INSERT INTO fobject (obj_labo, obj_article, obj_libelle, obj_prenom, objannee, objmois,obj_multik,objventeqteder, objqteobj, objdatecre,objusercre,objusermdf,objcommantaire) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)");
                $stmt->execute([
                    $v["labos"],
                    $v["articles"],
                    $v["libelles"],
                    $form["dm"],
                    $form["annee"],
                    $form["mois"],
                    $v["evolution"],
                    $v["qteder"],
                    $v["objectif"],
                    date('Y-m-d H:i:s'),
                    $dmusercre,
                    $dmusercre,
                    $coms
                    
                    
                ]);
            }
            
            echo header("Content-type: Application/json");
            echo json_encode([
                    "message" => "Objectif enregister"
                    
            ]);
        } catch (ErrorException $exception) {
            throw new ErrorException("Objectif non enregister");
        }
    }
}

