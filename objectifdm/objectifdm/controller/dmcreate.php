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
  // Initialiser la session
  session_start();
  // Vérifiez si l'utilisateur est connecté, sinon redirigez-le vers la page de connexion
  if(!isset($_SESSION["user_in"])){
    header("Location: ../../index.php");
    exit(); 

    $_SESSION['identifiant'] = $_POST['identifiant'];
  }
  $dmusercre = $_SESSION['identifiant'] ;

  //var_dump($_SESSION["user_in"]);die;
              /**************************************************/
              /*     Page Controller pour la création du DM     */
              /**************************************************/
    
      /***********************************************/
      /* Récupérer les données	pour la page ajout DM */
      /**********************************************/
 
        $req = "select DISTINCT '' as labo, '' as nom_labo,labo, nom_labo from objectifdm.view_article  ";        
        $stmt = $conn->prepare($req);
        $stmt->execute();
        $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);

        /**********************************************/
        /* GET DATA FROM PAGES DM 'AJOUTER' avec AJAX*/
        /*********************************************/
  
        const HTTP_OK = 200;
        const HTTP_BAD_REQUEST = 400;
        const HTTP_METHOD_NOT_ALLOWED = 405;
        
        
        if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtoupper($_SERVER['HTTP_X_REQUESTED_WITH']) == 'XMLHTTPREQUEST')
        {
          $response_code = HTTP_BAD_REQUEST;
          // $message = "Veuillez choisir un labo ou remplir les champs vides";

        
          if ($_POST['action'] == "sendData" && isset($_POST['DATA_DM']))
          {
            $response_code = HTTP_OK;
            $check = $_POST['DATA_DM'];
            $form = $_POST['formData'];
            // $message ="DM enregistrer";
            $erreur ="Utilisateur deja existant";
            
            //var_dump($_SESSION['identifiant']);die;

            $identifiant = $_SESSION['identifiant'];

            //var_dump($identifiant);die;
            // var_dump($check);die;
            // var_dump($_POST["formData"]);die;

          $prenom = "";
          $matriculle = "";
          $email= "";
          

          $keys = array_keys($_POST["formData"]);
          $value =  array_values($_POST["formData"]);
          $prenom_key = $keys[1];
          $prenom_value = $value[1];
          $matriculle_key = $keys[0];
          $matriculle_value = $value[0];
          $email_key = $keys[2];
          $email_value = $value[2];

          
          /*************************************/
          /** GET dmmail data in database FDM  */
          /*************************************/ 
                  
          $query = "SELECT count(*) FROM fdm WHERE trim(upper(dmprenom))=trim(upper(?)) AND dmactif=true	";       
          $stmt = $conn->prepare($query);
          $stmt->execute([
            $prenom_value
          ]);
          $stats = $stmt->fetchAll(); 

          // var_dump($stats);die;
          
          foreach($stats as $t){
            //var_dump($t[0]);die;
            $v = $t[0];
             if ($v > 0){
                // echo('Utilisateur déjà existant');
              echo('Utilisateur déjà existant');

              // var_dump($v);

              alert($erreur);
                
            } else{
                  // echo('Utilisateur enregistrer');
                  echo('Utilisateur Enregistrer');
                  // var_dump($v); die;
                    //Insertion  dans la base des checkbox (done))       
                    foreach ($_POST["DATA_DM"] as $valeur)  {
                      if ($prenom_key == "prenom" and $matriculle_key == "matriculle"){
                        $prenom = $prenom_value;
                        $matriculle = $matriculle_value; 
                        $mail = $email_value;

                        $query = "INSERT INTO flabodm (lablabo,lab_dmmatricule,lab_dmprenom,labdatecre) values (?,?,?,current_timestamp)";
                        $result = $conn->prepare($query);
                        $result->execute([
                          $valeur,
                          $matriculle,
                          $prenom,
                        ]);                      
                    } 
                  }
                    //INSERTION DANS FDM (DONE)
                      $insert ="INSERT INTO fdm (dmmatricule,dmprenom,dmmail,dmrespo,dmdatecre,dmusercre) VALUES (?,?,?,?,current_timestamp,?)";
                      $res = $conn->prepare($insert);
                        $res->execute([
                        $matriculle,
                        $prenom,
                        $mail,
                        $identifiant,
                        $dmusercre
                      ]);                                         
                    }   
                  //var_dump($data);die;  
              // reponse($message);  
           }        
         }      
        }
        else 
        {
          // $response_code = HTTP_METHOD_NOT_ALLOWED;
          // $message = "Method not allowed";
          // reponse($response_code,$message);
        }
        
        function reponse ($message)
        {        
          $response = [
            //"response_code" => $response_code,
             $message
          ];
          echo json_encode($response);
        }

        function alert($erreur)
        {
          $error = [
            //"response_code" => $response_code,
             $erreur
          ];
          echo json_encode($error);
        }
        