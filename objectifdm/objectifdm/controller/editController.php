<?php
// require_once($_SERVER['DOCUMENT_ROOT'] . "/config/database.php");
// include ("../config/database.php");
$host = '192.168.130.223';
$dbname = 'postgres';
$username = 'postgres';
$password = '123s0l31l';
$port ='5432';

$db = "pgsql:host=$host;port=$port;dbname=$dbname;user=$username;password=$password";
try{
  $conn = new PDO($db);
  $conn->exec('SET search_path TO objectifdm');
} catch (PDOException $e){
  echo 'Non connecter' . $e->getMessage();
  die;
}	
// Initialiser la session
  // session_start();
  // Vérifiez si l'utilisateur est connecté, sinon redirigez-le vers la page de connexion
//   if(!isset($_SESSION["user_in"])){
//     header("Location: ../../index.php");
//     exit(); 
//  }

/**********************************************/
/* GET DATA FROM PAGES DM 'AJOUTER' avec AJAX*/
/*********************************************/

// const HTTP_OK = 200;
// const HTTP_BAD_REQUEST = 400;
// const HTTP_METHOD_NOT_ALLOWED = 405;


if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtoupper($_SERVER['HTTP_X_REQUESTED_WITH']) == 'XMLHTTPREQUEST') {
    // $response_code = HTTP_BAD_REQUEST;
    //$message = "Veuillez choisir un labo ou remplir les champs vides";

    if ($_POST['action'] == "getData") {
        // $response_code = HTTP_OK;
        $data = $_POST['data'];

        //  var_dump($data);die;

        $dm = "";
        $annee = "";
        $mois = "";

        $keys = array_keys($_POST["data"]);
        $value = array_values($_POST["data"]);

        $dm = $keys[2];
        $dm_value = $value[2];

        $annee = $keys[0];
        $annee_value = $value[0];

        $mois = $keys[1];
        $mois_value = $value[1];

        // var_dump($annee_value);die;

        //var_dump($dm_value);die;
        $annee = $annee_value;
        $mois = $mois_value;
        $dm = $dm_value;
        

        //Requête de récupération de Data
        // $query = "SELECT objseq,obj_article,obj_libelle,obj_labo,objventeqteder,obj_multik,objqteobj,actifobj,objventeqteencours,objtaux,objcommantaire FROM fobject INNER JOIN mois ON mois_num = objmois WHERE obj_prenom=? and objannee=? and mois=? ";
        $query = "SELECT * FROM objectifdm.get_objectif('$annee_value','$mois_value','$dm_value')";
        // $query = "SELECT * FROM objectifdm.get_objectif('2022','Juillet','DIALY')";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);


        //  var_dump($result);die;


        echo header("Content-type: Application/json;"); 
        echo json_encode([
            "dm" => $result
         ]);       
    }

  result($result);
  
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


