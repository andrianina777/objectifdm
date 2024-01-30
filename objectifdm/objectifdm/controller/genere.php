<?php
// require_once($_SERVER['DOCUMENT_ROOT'] . "/config/database.php");
// require_once ("../../config/database.php");
$host = '192.168.130.223';
$dbname = 'postgres';
$username = 'postgres';
$password = '123s0l31l';
$port ='5432';

$db = "pgsql:host=$host;port=$port;dbname=$dbname;user=$username;password=$password";

//$conn = null;

try{
    $conn = new PDO($db);
    $conn->exec('SET search_path TO objectifdm');
} catch (PDOException $e){
    echo 'Non connecter' . $e->getMessage();
    die;
}	

// Get list délégué dans select
$sqlDm = "SELECT dmseq, dmmatricule, dmprenom FROM public.fdm WHERE dmactif=true";
$stmtDm = $conn->prepare($sqlDm);
$stmtDm->execute();
$listDm = $stmtDm->fetchAll();


//Get list Labo par rapport au DM
$labo = "SELECT lablabo, lab_dmprenom FROM flabodm";
$getLab = $conn->prepare($labo);
$getLab->execute();
$listLab = $getLab->fetchAll(PDO::FETCH_ASSOC);


//Get Commentaire de chaque article
$commentaire = "SELECT objcommantaire FROM fobject";
$getCom = $conn->prepare($commentaire);
$getCom->execute();
$listCom = $getCom->fetchAll(PDO::FETCH_ASSOC); 

//var_dump($_POST);die;

/**************************************************************/
/* Controller pour Génerer objectif DM dans la page d'accueil */
/**************************************************************/


// $res = "SELECT labo,article FROM farticle";
$res="SELECT labo,article FROM objectifdm.view_article";
//$req="SELECT DISTINCT labo,nom_labo  FROM farticle";
//var_dump($sql);
$stmt = $conn->prepare($res);
$stmt->execute();
$res = $stmt->fetchAll();
//var_dump($res);

/**********************************************/
/* GET DATA FROM PAGES DM 'AJOUTER' avec AJAX*/
/*********************************************/

const HTTP_OK = 200;
const HTTP_BAD_REQUEST = 400;
const HTTP_METHOD_NOT_ALLOWED = 405;


if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtoupper($_SERVER['HTTP_X_REQUESTED_WITH']) == 'XMLHTTPREQUEST') {
    $response_code = HTTP_BAD_REQUEST;
    //$message = "Veuillez choisir un labo ou remplir les champs vides";

    if ($_POST['action'] == "sendGen") {
        $response_code = HTTP_OK;
        $form = $_POST['formData'];
        //$message ="DM enregistrer";

        // var_dump($_POST["formData"]);die;

        $annee = "";
        $mois = "";
        $dm = "";

        $keys = array_keys($_POST["formData"]);
        $value = array_values($_POST["formData"]);

        $annee_key = $keys[0];
        $annee_value = $value[0];

        $mois_key = $keys[1];
        $mois_value = $value[1];

        $dm_key = $keys[2];
        $dm_value = $value[2];

        $labo_key = $keys[3];
        $labo_value = $value[3];

        // var_dump($labo_value);die; 
        //var_dump($dm_value);die;


        /***********************************************/
        /*      Appel de la procédure stockée         */
        /**********************************************/

        //Récupération du data saisissez par l'utilisateur
        $annee = $annee_value;
        $mois = $mois_value;
        $dm = $dm_value;
        $labo = $labo_value;

        // var_dump($annee);die;
        // var_dump($mois);die;
        // var_dump($dm);die;

        //$recup ="SELECT *  FROM generer_obj_dm (?,?,?)";
        $recup = "SELECT *  FROM objectifdm.generer_obj_dm2 ('$annee','$mois','$dm','$labo')";
        // $recup ="SELECT *  FROM generer_obj_dm2 ('2022','7','DIALY')";
        $stmt = $conn->prepare($recup);
        $stmt->execute();
        $objectif = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // var_dump($objectif);die;
        //echo json_encode($objectif);

        echo header("Content-type: Application/json;");

        echo json_encode([
            "objectif" => $objectif
        ]);

    }
    reponse($objectif);
}
else    {
            // $response_code = HTTP_METHOD_NOT_ALLOWED;
            // $message = "Method not allowed";

            // reponse($response_code,$message);
        }


        function reponse($message)
        {
            $response = [
                //"response_code" => $response_code,
                //  $message
            ];

            //echo json_encode($response);
        }



