<?php
  include '../../config/database.php';
  // Initialiser la session
  session_start();
  // Vérifiez si l'utilisateur est connecté, sinon redirigez-le vers la page de connexion
  if(!isset($_SESSION["user_in"])){
    header("Location: ../../index.php");
    exit(); 
  }

  // Get list délégué dans select
  $sqlDm = "SELECT distinct lab_dmmatricule,lab_dmprenom FROM public.flabodm";
  $stmtDm = $conn->prepare($sqlDm);
  $stmtDm->execute();
  $listDm = $stmtDm->fetchAll();

  // Get Date last mise à jour
    $req = "select distinct (v_bel_mois_annee.date - interval '1')::date from equagestion.v_bel_mois_annee";
    $stmtDate = $conn->prepare($req);
    $stmtDate->execute();
    $lastDate = $stmtDate->fetchAll();
  
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Délégué Médical</title>
          <link rel="stylesheet" type="text/css" href="../../assets/css/bootstrap.css">
          <link rel="stylesheet" type="text/css" href="../../plugins/datatables/datatables.min.css">
          <link rel="stylesheet" type="text/css" href="../../plugins/datatables/datatables.css">
          <link rel="icon" type="image/png" sizes="16x16" href="../../assets/images/icos.ico">
         <script src="../../plugins/datatables/jquery-3.6.0.min.js"></script>
        <script src="../../assets/js/bootstrap.js"> </script>
      <script type="text/javascript" src="../../plugins/datatables/datatables.min.js"></script> 
      <script src="../../plugins/jquery/jquery.validate.min.js"></script>
      <script src="../../plugins/sweetalert2/sweetalert2.min.js"></script>
  </head>
<body>
  <div class="p-1 bg-secondary text-white text-center">
    <div class="row">
          <div class="col-lg-10">
           </div>
          <div class="col-lg-2">
            <?php if(isset($_SESSION["user_in"]) && $_SESSION["user_in"] === true){ ?>
              <!-- <a href="../../index.php"> -->
                <button type="button" class="btn btn-danger" id="logout"><img src=../../assets/images/icons.png>  Déconnexion</button>
              <!-- </a> -->
            <?php } ?>
          </div>
        <!-- <h1>Office pharmaceutique Malgache | Délégué Médical </h1> -->
      </div>
  </div>
    <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #e3f2fd;">
      <div class="container-fluid">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" href="../../pages/accueil/index.php">OBJECTIF</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="../../pages/DM/index.php">DÉLÉGUÉ MEDICAL</a>
          </li>

        <div class="user">
          <b><u>User</u>: </b> <?= $_SESSION["identifiant"]?> 
        </div>

        <div id="maj">
          <b>Dernière mise  jour le  </b> 
          <?php foreach($lastDate as $key => $dateLast) { ?>
                <p value="<?= $dateLast['date'] ?>"><?= $dateLast['date'] ?></p>
              <?php } ?>
        </div>
        </ul>
      </div>
    </nav>

  <div class="container mt-3">
    <h2>Délégué Médical</h2>
      <!--<p>Choisir un des DM pour faire un recherche de DM : </p>-->
<form action="../../pages/DM/index.php" method="POST">
<!--<form action="/Controller/dmtab.php" method="POST">-->
    <div class="row">
        <div class="col-lg-2">
        <div class="input-group mb-3">
         <!-- <span class="input-group-text" id="basic-addon1">DM</span> -->
            <!-- <select name="dm" class="form-select form-select-sm" aria-label=".form-select-sm example"> -->
             <!-- <option value="null" selected>---</option> -->
              <?php foreach($listDm as $key => $DmItem) { ?>
                <!-- <option value="<?= $DmItem['lab_dmmatricule'] ?>"><?= $DmItem['lab_dmprenom'] ?></option> -->
              <?php } ?>
            <!-- </select>      -->
         </div>
        </div>
            <div class="col-lg-1">
            </div> 
           <!-- <div class="col-lg-2">
            </div> -->
        <div class="col-lg-2">

          <!--<select name="getlabo" class="form-select form-select-sm" aria-label=".form-select-sm example">
              <option value="null" selected>LABO</option>
            </select> -->

        </div>
     <!--   <div class="col-lg-2">   
        </div> -->
        <div class="col-lg-2">
            <!-- <button type="submit" class="btn btn-outline-success" name="search">Recherche</button> -->
        </div>
    </div>
</form>
<br>
      <!--Modal for create-->
        <div class="row">
            <div class="col-lg-3">
               <!-- <a href="../../pages/DM/create.php"><button type="button" class="btn btn-info">Ajouter</button></a> -->
                  <!-- Button trigger modal -->
                 <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#genere">Test</button>-->
                      <!-- Modal -->
                        <div class="modal fade" id="genere" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Ajouter</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                            <div class="modal-body">
                                
                              <?php include ('../../pages/DM/create.php') ?>
                              
                            </div>
                          <div class="modal-footer">
                        </div>
                      </div>
                    </div>
                  </div>

                  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add">Créer un DM</button>
                  <div class="modal fade" id="add" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title">Créer un DM</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          <?php include ('../../pages/DM/add.php') ?>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
               <div class="col-lg-9">
            </div>
          </div>
<br>
        <!--modal for modification-->

        <div class="modal fade" id="editlab" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title">Modifier un DM </h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          <?php include ('../../pages/DM/edit_labo.php') ?>
                        </div>
                      </div>
                    </div>
                  </div>
            <div class="row">
               <div class="col-lg-3">
                <!-- <a href="../../pages/DM/create.php"><button type="button" class="btn btn-info">Ajouter</button></a> -->
                  <!-- Modal -->
                    <div class="modal fade" id="" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Modifier</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                            <div class="modal-body">
                                  
                         <?php include ('../../pages/DM/modif.php') ?>  
                                  
                            </div>
                          <div class="modal-footer">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              <div class="col-lg-9">
            </div>
          </div>
    <!--Return valeur dans la base de données-->
          <table id='an_table' class="display" style="width:100%" class='dm'>
              <thead>
                <tr>
                  <th>DM</th>
                  <th></th>
                  <th>CODE LABO</th>
                  <th>LABO</th>
                  <th>Actif</th>
                </tr>
              </thead>
              <tbody>
                  <?php
                  //var_dump($res);
                  foreach ($laboList as $labo) { ?>
                  <tr ondblclick="showModal()">
                    <td width ='12%'><?= $labo['lab_dmprenom'] ?></td>
                    <td width ='15%'><button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editlab" id='edit_lab'>Ajouter labo</button></td>
                    <td><?= $labo['lablabo'] ?></td>
                    <td><?= $labo['nom_labo']?></td>
                    <td><button class="btn btn-danger btn-sm" id="disable-dm">x</button></td>
                    <?php } ?>
                  </tr>
                </tbody>
          </table>
      </div> 
   <script src='../../assets/js/DM/index.js'></script>
  </body>
  <style>
    
  .user {
    position:fixed;
    right: 200px;
  }
  </style>
</html>