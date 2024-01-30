<?php
// require_once($_SERVER['DOCUMENT_ROOT'] . "/config/database.php");
require_once ("../config/database.php");
                            /****************************************************************************/
                            /*     Page Controller pour la suppression du labo dans la table 'flabodm'  */
                            /****************************************************************************/

const HTTP_OK = 200;
const HTTP_BAD_REQUEST = 400;
const HTTP_METHOD_NOT_ALLOWED = 405;


if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtoupper($_SERVER['HTTP_X_REQUESTED_WITH']) == 'XMLHTTPREQUEST') {
    $response_code = HTTP_BAD_REQUEST;
    //$message = "Veuillez choisir un labo ou remplir les champs vides";

    if ($_POST['action'] == "dmDelete") {
        $response_code = HTTP_OK;
        $data = $_POST['data'];

        //var_dump($data);die;
        $keys = array_keys($_POST["data"]);
        $value = array_values($_POST["data"]);

        $labo = $keys[2];
        $labo_value = $value[2];
        
        $dm_value = $value[0];

        // $labo =  trim($labo_value);

        // var_dump($labo_value);die;
        //var_dump($dm_value);die;

    //Requete suppression du ligne
        $sql = "DELETE FROM flabodm WHERE trim(lablabo) ='$labo_value' AND lab_dmprenom = '$dm_value'";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        
    //Requete update du ligne
        // $update = "UPDATE flabodm SET labactif = false WHERE lablabo = '$labo_value' "
        // $stmt = $conn->prepare($update);
        // $stmt->execute();

    }
}