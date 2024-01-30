<?php

                /****************/
                /* NON UTILISER */
                /****************/

  // Initialiser la session
 /* session_start();
  // Vérifiez si l'utilisateur est connecté, sinon redirigez-le vers la page de connexion
  if(!isset($_SESSION["user_in"])){
    header("Location: ../../index.php");
    exit(); 
  } */
?>
<?php //require_once($_SERVER['DOCUMENT_ROOT'] . "/controller/dmcreate.php"); 
require_once ("../../controller/dmcreate.php");
?>

<!DOCTYPE html>
<html>
  <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Délégué Médical | Ajout</title>
  </head>
<body>
  <div class="container mt-3">

<form action="../../controller/dmcreate.php" id="labo-form" method="POST">
    <h4>Ajout DM par Labo</h4>
      <div class="row">
          <div class="col-lg-5">
          </div>
            <div class="col-lg-1">
              <p><button name="submit" id="submit-btn" class="btn btn-success">Ajouter</button></p> 
            </div>
           <div class="col-lg-1">
          <a href="/pages/DM/index.php"><p><button type="button" class="btn btn-danger">Annuler</button></p></a>
        </div>
      </div>

        <div class="row">
          <div class="col-lg-1">
                <div class="form-check">
                Actif 
                <input class="form-check-input" type="checkbox" name="isActif" id="">
                  <!-- <input class="form-check-input" type="checkbox" value="" id="" name="actif" checked> -->
                  <label class="form-check-label" for="actif">
                  </label>
                </div>
          </div>
        </div>
  <br>
   <div class="row">
        <div class="col-lg-1">  
            Matriculle : 
        </div>
        <div class="col-lg-3">  
            <input type="text" name="matriculle" placeholder="Matriculle"> 
        </div>
    </div>
<br>
    <div class="row">
        <div class="col-lg-1">  
            Prénom : 
        </div>
        <div class="col-lg-3">  
            <input type="text" name="prenom" placeholder="Prénom" autocomplete="off"> 
        </div>
    </div>
<br>
    <div class="row">
        <div class="col-lg-1">  
            Email : 
        </div>
        <div class="col-lg-3">  
            <input type="text" name="email" placeholder="Email"> 
        </div>
    </div>
<br>   
<br>
<!-- </form> -->

<!--Return Valeur dans la table farticle-->
<!-- <form action="../../controller/dmcreate.php" method="POST"> -->
    
<table id='nj_table' class="display nowrap" style="width:100%">
  <thead>
    <tr>
      <th scope="col">Code Labo</th>
      <th scope="col">Labo</th>
      <th scope="col">Actif</th>
    </tr>
  </thead>
  <!-- <tbody>
    <?php
      foreach ($articles as $labo) { ?>
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
      </tr>
    <?php } ?>
    </tbody> -->
  </table>  
  <!-- script récuperation data anaty base -->
    <script>
      const articles = JSON.parse(`<?= json_encode($articles) ?>`);
      $(document).ready(function () {
        const table = $('#nj_table').DataTable({
          data: articles,
          columns: [
            {
              data: "labo",
            },
            {
              data: "nom_labo",
            },
            {
              data: "labo",
              render: (data, type, row) => {
                return `
                <div class="form-check">
                  <input class="form-check-input article-actif" type="checkbox" data-actif="${data}">
                  <label class="form-check-label" for="flexCheckChecked">
                    Actif
                  </label>
                </div>
                `
              }
            },
          ],
        })
      });

      $("#nj_table > tbody").on('click', 'tr', function(event) {
        // Get DM data on click
        const row = table.row( this ).data();  
        showModal(row);
      })

      $("body #submit-btn").click((event) => {
        event.preventDefault();
        const formData = {};
        const checkedEl = $(".article-actif:checkbox:checked").toArray().map(el => $(el).data("actif"))

        $("body #labo-form").serializeArray().forEach(el => {
          formData[el.name] = el.value;
        })

        /**
         * @todo Do submit here with ajax
         * @see https://api.jquery.com/jquery.ajax/
         */
        
      /*************************************************** */
      /**            SEND DATA TO THE CONTROLLER           */
      /*************************************************** */
     
        $.ajax({
          type: "POST",
          url: "../../controller/dmcreate.php",
          data: {
            action: "sendData",
            checked: checkedEl,
            formData: formData
          },
            success: function (response) {
            console.log(response);
          }
        });
      
      })
      
    </script>
     </div>
    </form>
  </body>
</html>