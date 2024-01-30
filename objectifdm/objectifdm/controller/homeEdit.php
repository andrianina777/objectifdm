<?php
// require_once($_SERVER['DOCUMENT_ROOT'] . "/config/database.php");
// require_once ("../../config/database.php");
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
        /**********************************************************/
        /**      Controller du page de détail (Accueil/index.php) */
        /**********************************************************/

        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtoupper($_SERVER['HTTP_X_REQUESTED_WITH']) == 'XMLHTTPREQUEST') {
          $response_code = HTTP_BAD_REQUEST;
                
          if ($_POST['action'] == "editSelected") {
              $response_code = HTTP_OK;
              $data = $_POST['row'];
              $dm = $_POST['data'];

              // var_dump($data);die;

              $dm = '';
              $mois = '';
              $annee = '';

              $keys = array_keys($_POST["data"]);
              $value = array_values($_POST["data"]);

              $dm_key = $keys[2];
              $dm_value = $value[2];

              $annee = $keys[0];
              $annee_value = $value[0];

              $mois = $keys[1];
              $mois_value = $value[1];

              // var_dump($dm_value);die;
              $annee = $annee_value;
              $mois = $mois_value;
              $dm = $dm_value;


            
              try {
                foreach ($data as $v) {
            // Requete delete on table fobject , delete all articles unselected
            //$sql = "DELETE FROM fobject WHERE obj_article ='$v[articles]' AND obj_prenom ='$dm' AND objannee ='$annee' AND objmois in (SELECT mois_num FROM mois WHERE mois ='$mois')";
              $sql = "UPDATE fobject SET obj_actif='false' where obj_article ='$v[articles]' AND obj_prenom ='$dm' AND objannee ='$annee' AND objmois in (SELECT mois_num FROM mois WHERE mois ='$mois')";
              $result = $conn->exec($sql);
             }               

                // echo header("Content-type: Application/json");
                // echo json_encode([
                //         "message" => "Articles deleted with success"]); 

              } 
              catch (ErrorException $exception) {
              throw new ErrorException("Articles non Supprimer");
            }
           
          }
        }