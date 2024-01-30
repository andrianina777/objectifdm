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

        /***************************************************************/
        /** Controller pour les commentaires du pages accueil/edit.php */
        /***************************************************************/

        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtoupper($_SERVER['HTTP_X_REQUESTED_WITH']) == 'XMLHTTPREQUEST') {
            $response_code = HTTP_BAD_REQUEST;
                  
            if ($_POST['action'] == "updateSelected") {
                $response_code = HTTP_OK;
                $coms = $_POST['val'];
                $articles = $_POST['rows'];   
                $id_edit = $_POST['id_edit'];             
                // var_dump($coms);die;
                // var_dump($articles);die;
                // var_dump($id_edit);die;

            try {
                foreach($articles as $a){
                // $sql = "UPDATE fobject SET objcommantaire = '$coms', objdatemdf =current_timestamp WHERE obj_article =?";
                $stmt = $conn->prepare("UPDATE fobject SET objcommantaire = '$coms', objdatemdf =current_timestamp WHERE objseq ='$id_edit'");
                $stmt->execute();

                // $result = $conn->exec($sql);

                }
                echo header("Content-type: Application/json");
                echo json_encode([
                        "message" => "commentaires enregister"
                        
                ]);
            }
            catch (ErrorException $exception) {
                throw new ErrorException("commentaire non enregister");

            }
        }
    }