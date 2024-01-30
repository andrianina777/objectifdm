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

const HTTP_OK = 200;
const HTTP_BAD_REQUEST = 400;
const HTTP_METHOD_NOT_ALLOWED = 405;

            /************************************************************/
            /* Récupère les labo dans le select du page DM(Ajouter DM ) */
            /************************************************************/

if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtoupper($_SERVER['HTTP_X_REQUESTED_WITH']) == 'XMLHTTPREQUEST') {
        $response_code = HTTP_BAD_REQUEST;
        
        if ($_POST['action'] == "editer") {
            $response_code = HTTP_OK;
            $data = $_POST['dm_data'];

            // var_dump($data);die;

            $keys = array_keys($_POST["dm_data"]);
            $value = array_values($_POST["dm_data"]);

            $dm = $keys[0];
            $dm_value = $value[0];
            
            // var_dump($dm_value);die;

                //Récupérer les données

            $sql="SELECT DISTINCT lab_dmmatricule,lab_dmprenom,lablabo FROM flabodm WHERE lab_dmprenom = '$dm_value'";								   	
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // var_dump($res);
        echo header("Content-type: Application/json;"); 
        echo json_encode([
            "labo" => $res
         ]);   
        
         result($res);

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


            /****************************************************************************/
            /* Requete pour inserer les Labo séléctionner(UPDATE LABO dans la page DM ) */
            /****************************************************************************/

    if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtoupper($_SERVER['HTTP_X_REQUESTED_WITH']) == 'XMLHTTPREQUEST') {
        $response_code = HTTP_BAD_REQUEST;
        
        if ($_POST['action'] == "editData") {
            $response_code = HTTP_OK;
            $data_edit = $_POST['DATA_DM_EDIT'];
            $dm = $_POST['dm_data'];

            //  var_dump($dm);die;

            $keys = array_keys($_POST["dm_data"]);
            $value = array_values($_POST["dm_data"]);

            $dm = $keys[0];
            $dm_one = $value[0];

            // var_dump($dm_one);die;
            foreach ($_POST["DATA_DM_EDIT"] as $labo_add)  {

            // var_dump($labo_add);die;

            $query = "INSERT INTO flabodm(lablabo,lab_dmprenom,labdatemdf) VALUES ('$labo_add','$dm_one',current_timestamp)";
            $result = $conn->prepare($query);
            $result->execute();   

            }           
        }
    }