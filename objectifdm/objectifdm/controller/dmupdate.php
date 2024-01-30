<?php
// require_once($_SERVER['DOCUMENT_ROOT'] . "/config/database.php");
require_once ("../../config/database.php");
                          /*****************/
                          /* NON UTILISER  */
                          /*****************/

      /***********************************************************************/
      /* Page pour mettre à jour les séléctions dans la page d'accueil DM   */
      /**********************************************************************/
    
          //insertion dans la base de données
            if( isset($_POST['prenom']) AND isset($_POST['email'])){
                $prenom = $_POST['prenom']; 
                $email = $_POST['email'];
          
                //var_dump($_POST['email']);


                //$sql = "INSERT INTO fparams(parusers,parpassword) VALUES ('$identifiant','$password')";

                        $sql = " UPDATE fdm SET dmprenom= '$prenom' and dmmail = '$email' ";
              
              // var_dump($sql);

              $result=$conn->query($sql);
                //var_dump($result);
                //echo 'Insertion réussie';	
                echo"<script language='javascript'>alert('Modification réussite')</script>";
                  header("location: ../pages/DM/index.php");
                if(!$result){
                echo 'non result';
                } 
            } 