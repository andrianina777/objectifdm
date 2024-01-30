<?php
  // require_once($_SERVER['DOCUMENT_ROOT'] . "/config/database.php");
require_once ("../../config/database.php");

  //var_dump($_POST['getlabo']);die;
                                                  /*****************/
                                                  /* NON UTILISER  */
                                                  /*****************/

                /*********************************************************************************************/
                /* Affichage du données dans la page index.php du DM  et Requête pour la filtre de recherche */
                /*********************************************************************************************/

session_start();
// Vérifiez si l'utilisateur est connecté, sinon redirigez-le vers la page de connexion
if(!isset($_SESSION["user_in"])){
  header("Location: ../../index.php");
  exit(); 
  $_SESSION['identifiant'] = $_POST['identifiant'];
}

$dmusercre = $_SESSION['identifiant'] ;


  //$sql = "SELECT labo,lab_dmprenom,lablabo FROM flabodm INNER JOIN farticle ON flabodm.labseq = farticle.arseq";

  // $sql = "SELECT distinct lab_dmprenom,lab_dmmatricule,lablabo,nom_labo FROM flabodm LEFT JOIN objectifdm.view_article ON labo = lablabo";
  $sql = "SELECT distinct lab_dmprenom,lab_dmmatricule,lablabo,nom_labo FROM flabodm LEFT JOIN objectifdm.view_article ON labo = lablabo inner join objectifdm.flabsup on lab_labo=labo where lab_sup='$dmusercre'";
    if (isset($_POST['search'])){
        if(isset($_POST['dm'])){
           $dm = $_POST['dm'];
          //var_dump($labo);die;

        //Mandeha
        $sql.= " WHERE flabodm.lab_dmmatricule = " . $dm .  " ; " ;        
        }
      } 
    
      /*  if (isset($_POST['search'])){
        if (isset($_POST['getlabo'])){
          $labo = $_POST['getlabo'];

          var_dump($labo);die;
          
          $sql.= " WHERE flabodm.labseq = " . $labo . " ; " ;
      }
    }*/
      $stmt = $conn->prepare($sql);
      $stmt->execute();
      $laboList = $stmt->fetchAll(PDO::FETCH_ASSOC); 

