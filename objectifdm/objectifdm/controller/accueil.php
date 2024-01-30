<?php   
    //require_once($_SERVER['DOCUMENT_ROOT'] . "/config/database.php");
    require_once ("../../config/database.php");

        /**************************************************************************/
        /*        Controller pour la page d'accueil + filtre de recherche         */
        /**************************************************************************/

        // Vérifiez si l'utilisateur est connecté, sinon redirigez-le vers la page de connexion
        if(!isset($_SESSION["user_in"])){
          header("Location: ../../index.php");
          exit(); 
        
        
          $_SESSION['identifiant'] = $_POST['identifiant'];
          
        }
        
        $dmusercre = $_SESSION['identifiant'] ;

        //  $sql = "SELECT objannee as dmdatecre ,mois as dmmonth,obj_prenom as dmprenom FROM fobject INNER JOIN mois ON mois_num=objmois GROUP BY objannee,mois,obj_prenom ";
$sql = "SELECT objannee as dmdatecre ,mois as dmmonth,obj_prenom as dmprenom FROM objectifdm.fobject INNER JOIN objectifdm.mois ON mois_num=objmois  inner join objectifdm.flabsup on trim(lab_labo)=trim(obj_labo) where lab_sup='$dmusercre'
GROUP BY objannee,mois,obj_prenom";

         
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $dm = $stmt->fetchAll(PDO::FETCH_ASSOC);
