<?php
  // Initialiser la session
 /* session_start();
  // Vérifiez si l'utilisateur est connecté, sinon redirigez-le vers la page de connexion
  if(!isset($_SESSION["user_in"])){
    header("Location: ../../index.php");
    exit(); 
  } */
?>
                      
<?php //require_once($_SERVER['DOCUMENT_ROOT'] . "/controller/dmtab.php"); 
require_once ("../../controller/dmtab.php");?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Délégué Médical | Modifier</title>
      <link rel="stylesheet" type="text/css" href="../../assets/css/style.css">
    
        
</head>
<body>
<div class="container mt-3">
<form action="/controller/dmupdate.php" method="POST">
  <h4>Modifier DM par Labo</h4>
    <div class="row">
        <div class="col-lg-5">
        </div>
        <div class="col-lg-1">
         <p><button type="submit" name="submit" class="btn btn-success">Modifier</button></p> 
        </div>
        <div class="col-lg-1">
        <a href="/pages/DM/index.php"><p><button type="button" class="btn btn-danger">Annuler</button></p> </a>
        </div>
      </div>

   <div class="row">
        <div class="col-lg-1">  
            Matriculle : 
        </div>
        <div class="col-lg-3">  
            <!--Valeur à Récupérer dans la bases de données-->
        </div>
    </div>

<br>
    <div class="row">
        <div class="col-lg-1">  
            Prénom : 
        </div>
        <div class="col-lg-3">  
            <input type="text" name="prenom" placeholder="Prénom"> <!--Valeur à récuperer dans la base de données-->
        </div>
    </div>

    <br>
    <div class="row">
        <div class="col-lg-1">  
            Email :   
        </div>
        <div class="col-lg-3">  
            <input type="email" name="email" placeholder="Email"> <!--Valeur à récuperer dans la base de données-->
        </div>
    </div>
<br>   
<br>
</form>

<!--Return Valeur dans la table farticle-->
<form action="/controller/dmupdate.php" method="POST">
  
<table id='nj_table' class="display">
  
  <thead>
    <tr>
      <th scope="col">Code Labo</th>
      <th scope="col">Labo</th>
      <th scope="col">Actif</th>
    </tr>
  </thead>
  <tbody>

 <?php 
    //var_dump($res);
 foreach ($laboList as $labo) { ?>
  
        <tr>
          <td><?= $labo['labo']?></td>
          <td><?= $labo['nom_labo']?></td>
          <td>
          <div class="form-check">
             <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
             <label class="form-check-label" for="flexCheckChecked">
                 Actif
             </label>
          </div>
          </td>
        
      <?php } ?>
      
      </tr>
  </tbody>
</table>

</div>
</form>
   
    <script>
      $(document).ready(function () {
          $(' body #nj_table').DataTable();
          
      });
      </script>
</body>
</html>