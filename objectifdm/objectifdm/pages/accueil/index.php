<?php
  // Initialiser la session
  session_start();
  // Vérifiez si l'utilisateur est connecté, sinon redirigez-le vers la page de connexion
  if(!isset($_SESSION["user_in"])){
    header("Location: ../../index.php");
    exit(); 
  }
// require_once($_SERVER['DOCUMENT_ROOT'] . "/controller/accueil.php");
require_once ("../../controller/accueil.php");

  // Get list délégué dans select
  $sqlDm = "SELECT dmseq, dmmatricule, dmprenom FROM fdm WHERE dmactif=true";
  $stmtDm = $conn->prepare($sqlDm);
  $stmtDm->execute();
  $listDm = $stmtDm->fetchAll();


  // Get list mois dans select
  $sqlmois = "SELECT mois_num,mois FROM mois";
  //$sqlLabo = "SELECT distinct labseq,lablabo FROM flabodm";
  $stmtMois = $conn->prepare($sqlmois);
  $stmtMois->execute();
  $listMois = $stmtMois->fetchAll();

  // Get list années dans select
    $sqlyear = "SELECT annee_num,annee FROM annees";
  //$sqlLabo = "SELECT distinct labseq,lablabo FROM flabodm";
    $stmtYear = $conn->prepare($sqlyear);
    $stmtYear->execute();
    $listYear = $stmtYear->fetchAll();

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
    <title>Objectif | DM</title>
    <link rel="stylesheet" type="text/css" href="../../assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../../assets/css/style.css">
    <link rel="stylesheet" type="text/css" href="../../plugins/datatables/datatables.min.css">
    <link rel="icon" type="image/png" sizes="16x16" href="../../assets/images/icos.ico">
    <script src="../../plugins/datatables/jquery-3.6.0.min.js"></script>
    <script src="../../assets/js/bootstrap.js"> </script>
    <script type="text/javascript" src="../../plugins/datatables/datatables.min.js"></script>
    <script src="../../plugins/sweetalert2/sweetalert2.min.js"></script>
    <script src="../../plugins/datatables/moment.min.js"></script>
    <script src="../../plugins/datatables/fr.min.js"></script>
    <script src="../../plugins/jquery/jquery.table2excel.js"></script>

  </head>

<body>
  <div class="p-1 bg-secondary text-white text-center">
    <div class="row">
      <div class="col-lg-10">
      </div>

      <div class="col-lg-2">

        <?php if(isset($_SESSION["user_in"]) && $_SESSION["user_in"] === true){ ?>
        <!-- <a href="../../index.php"> -->
          <button type="button" class="btn btn-danger" id='logout'><img src=../../assets/images/icons.png>  Déconnexion</button>
        <!-- </a> -->
        <?php } ?>
      </div>
      <!-- <h1>Office pharmaceutique Malgache | ACCUEIL </h1> -->
      <!-- <p></p> -->
    </div>
  </div>

  <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #e3f2fd;">

    <div class="container-fluid">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active" href="../../pages/accueil/index.php">OBJECTIF</a>
        </li>
        
        <li class="nav-item">
          <a class="nav-link" href="../../pages/DM/index.php">DÉLÉGUÉ MÉDICAL</a>
        </li>

          <div class="user">
          <b><u>User</u>: </b> <?= $_SESSION["identifiant"]?> 
          </div>
        

        <div id="maj">
          <!-- <?= $_SESSION["identifiant"]?>"><?= $_SESSION["identifiant"]?></p> -->
        
          <b>Dernière mise  jour le  </b> 
          <?php foreach($lastDate as $key => $dateLast) { ?>
                <p value="<?= $dateLast['date'] ?>"><?= $dateLast['date'] ?></p>
              <?php } ?>
        </div>
      </ul>
    </div>
  </nav>

  <div class="container mt-3">
    <h2>Objectif</h2>
    <!-- <p>Veuillez Choisir : Année - Mois - DM</p> -->
    
<form action="../../pages/accueil/index.php" method="POST">
    <div class="row">
      <!-- <div class="col-lg-2">
        <div class="input-group mb-3">
          <span class="input-group-text" id="basic-addon1">Année</span>
          <select name="annee" class="form-select form-select-sm" aria-label=".form-select-sm example">
              <option value="null" selected>---</option>
                <?php foreach($listYear as $key => $DmItem) { ?>
                <option value="<?= $DmItem['annee'] ?>"><?= $DmItem['annee'] ?></option>
              <?php } ?>
         </select>
        </div>
      </div> -->

      <!-- <div class="col-lg-2">
      </div> -->

      <!-- <div class="col-lg-2">
        <div class="input-group mb-3">
          <span class="input-group-text" id="basic-addon1">Mois</span>
              <select name="mois" class="form-select form-select-sm" aria-label=".form-select-sm example">
              <option value="null" selected>---</option>
              <?php foreach($listMois as $key => $DmItem) { ?>
                <option value="<?= $DmItem['mois_num'] ?>"><?= $DmItem['mois'] ?></option>
              <?php } ?>
         </select>
        </div>
      </div> -->


    <!-- <div class="col-lg-2">
    </div> -->

    <!-- <div class="col-lg-2">
      <div class="input-group mb-3">
        <span class="input-group-text" id="basic-addon1">DM</span>
           <select name="dm_search" class="form-select form-select-sm" aria-label=".form-select-sm example">
            <option value="null" selected>---</option>
              <?php foreach($listDm as $key => $DmItem) { ?>
                <option value="<?= $DmItem['dmseq'] ?>"><?= $DmItem['dmprenom'] ?></option>
              <?php } ?>
            </select>  
         </div> 
      </div> -->

      <div class="col-lg-2">
       <!-- <button type="submit" name="search_dm" class="btn btn-outline-success">Recherche</button> -->
      </div>
    </div>
</form>
    <br>

    <div class="row">
      <div class="col-lg-3">
        <!-- <button type="button" class="btn btn-primary">Générer Objectif du mois </button> -->

        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#genere">Génerer Objectif
          du mois</button>
        <!-- Modal -->
        <div class="modal fade" id="genere" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                
                <h5 class="modal-title" id="exampleModalLabel">Générer Objectif du mois</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">

                <?php require_once"../../pages/accueil/genere.php"; ?>

              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-success" id="valid" name="delete">Valider</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-9">
  </div>
  </div>
<br>
  <!-- Modal Modifier-->
  <div class="modal fade" id="modalform" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Détails</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

          <?php include '../../pages/accueil/edit.php';?>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Annuler</button>
          <button type="button" class="btn btn-success" id="modif">Valider</button>
          <!-- <button type="button" class="btn btn-success" id="modifier">Modifier</button> -->
        </div>
      </div>
    </div>
  </div>
  <br>
  <table id='nj_table' class="display" style="width:100%">
    <thead>
      <tr>
        <th>Année</th>
        <th>Mois</th>
        <th>DM</th>
        <th>Détails</th>
      </tr>
    </thead>
    <tbody>
  </tbody>
  </table>

 <?php $result = "test"; ?>

  <script>
    let DM = [];

     $(document).ready(function () {
      const dmList = JSON.parse(`<?= json_encode($dm) ?>`);



      const table = $("#nj_table").DataTable({
        data: dmList,
        columns: [
          {
            data: "dmdatecre", //render: function(data, type, full) {return moment(new Date(data)).locale('fr-fr').format('YYYY  ');}
            // DataTable.render.datetime('YYYY'),
         
         },
          {
            
            data: "dmmonth",//render: function(data, type, full) { return moment(new Date(data)).locale('fr-fr').format('MMMM');}
            

          },
          {
            data: "dmprenom",
          },
          {
            defaultContent: '<button type="button" class="btn btn-outline-success" id="detail">Détail</button>',
          }
          
        ],

        language: {
            url: '../../plugins/datatables/datatables:fr-FR.json'
        }

        
      }) 
       

      $("#nj_table > tbody").on('click', '#detail', function(event) {
        // Get DM data on double click
        const row = table.row( this ).data();  
        showModal(row);

        var data = table.row($(this).parents('tr')).data();

        console.log(data);
        
        /******************************/
        /**   TITLE OF DETAIL PAGE  */
        /*****************************/
        $("body #title-value").html(data.dmprenom + " - " + data.dmmonth + " "  + data.dmdatecre);
      
        /**************************************************************************/
        /**     SEND DATA TO THE CONTROLLER  AND SEND DATA TO PAGES EDIT.PHP      */
        /**************************************************************************/

        $.ajax({
            type: "POST",
            url: "../../controller/editController.php",
            data: {
                action: "getData",
                data
            },
            success: function (response) {
              //console.log(response);
              //OBJECTIF_LIST = response.dm;
              DM = response.dm;
               console.log(response.dm)
              $('table#edit tbody').html('')
              response.dm.forEach(obj => {
                    $('table#edit tbody').append(`
                    <tr>
                            <td width="5%" style = "display:none" class="noExl">${obj.id}</td>
                            <td width="9%">${obj.t_date}</td>
                            <td width="10%"class="articles">${obj.articles}</td>
                            <td width="20%">${obj.libelles}</td>
                            <td width="5%">${obj.labos}</td>
                            <td width="5%">${obj.qteder}</td>
                            <td width="5%"><input type="text" class="form-control" value="${obj.evolution}" disabled></td>                           
                            <td width="5%">${obj.objectif}</td>
                            <td id="stock"></td>
                            <td id="AO"></td>
                            <td id="VN"></td>
                            <td width="10%"><div id ="qte"></div>${obj.venteqte}</td>
                            <td>${obj.taux}</td>
                            <td><input type="checkbox" class="noExl" id="actif" data-articles="${obj.articles}" value="${obj.actifobj}" checked></td>
                            <td class="commentaire" data-commentaire="${obj.coms}" value="${obj.coms}">${obj.coms}</td>
                            <td width="5%"><input type='text' id ='com'></td>
                            <td style="display:none">${obj.t_dm}</td>
                            <td style="display:none">${obj.t_mois}</td>
                            <td style="display:none">${obj.t_annee}</td>
                           
                        </tr>
                    `)
                    // <td class="commentaire" data-commentaire="${obj.objcommantaire}" value="${obj.objcommantaire}"></td>
                    //         <td><input type="text" id=""></td>
                    //         <td><button type="button" id="comment" class="btn btn-outline-success">Commenter</button></td>
                    //Valeur vente en cours :${obj.objventeqteencours}
                    //Valeur taux de réalisation : ${obj.objtaux}
                })  
                      
            }        
      })       

      /****************************************************/
      /**      SELECTOR JQUERY FOR UNCHECKED ELEMENT      */
      /****************************************************/

      $(document).on("click", "#modif" ,(event) => {
        
        // event.preventDefault();
        const selectedArticles = $('#edit tbody input[type="checkbox"]:not(:checked)').toArray().map(el => $(el).data('articles'))

        // if(selectedArticles == ''){
        // alert ('Veuillez décocher un des articles pour pouvoir Supprimer')
        //   Swal.fire({
        //   // position: 'top-end',
        //   icon: 'info',
        //   title: 'Veuillez décocher l\'un des éléments afin de pouvoir les retirer',
        //   showConfirmButton: false,
        //   timer: 2000
        // })


       //  const Toast = Swal.mixin({
       //  toast: true,
       //  position: 'top-end',
       //  showConfirmButton: false,
       //  timer: 4000,
       //  timerProgressBar: true,
       //  onOpen: (toast) => {
       //    toast.addEventListener('mouseenter', Swal.stopTimer)
       //    toast.addEventListener('mouseleave', Swal.resumeTimer)
       //  }
       //  });

       //  Toast.fire({
       //  icon: 'warning',
       //  title: 'Veuillez décocher un ou plusieurs éléments afin de pouvoir les retirer'
       // });
        // return;

        // }
// else{
        const row = DM.filter(obj => selectedArticles.includes(obj.articles))
        // console.log(row)
        // console.log(selectedArticles)     

        
              /******************************************/
              /**   Alert confirm Delete                */
              /******************************************/
                Swal.fire({
                title: 'Voulez-vous vraiment Modifier ?',
                // text: "Cette action est irreversible",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Modifier'
                 }).then((result) => {

                if (result.isConfirmed) {
 

        /******************************************************************/
        /**    UPDATE DATA SELECTED TO DATABASE  ON DELETE ALL UNCHECKED */
        /*****************************************************************/

        $.ajax({
            type: "POST",
            url: "../../controller/homeEdit.php",
            data: {
                action: "editSelected",
                row,
                data
                
              
            },
            success: function (response) {
                console.log(response.message);
                // alert('Suppression Réussite');
                //window.location.replace('/pages/accueil/index.php')
                //window.location.reload(true)

                Swal.fire({
                      // position: 'top-end',
                      icon: 'success',
                      title: 'Modification faite',
                      showConfirmButton: false,
                      timer: 1500
                      })

            var delay = 1500; 
            setTimeout(function(){ window.location = '../../pages/accueil/index.php'; }, delay);
            }
            
        });     
            // Swal.fire(
            //             'Supprimer',
            //             ' Supprimer avec Succès     -      Veuillez réactualisez la page afin que la modification prenne effet',
            //             'success'
            //           )
                    }
                })
            // }

            $('#edit').change(function() {

            })
        })
      });
    });


          /****************************/
          /*** Confirm Deconnexion   */
          /***************************/
          $(document).on("click", "#logout" ,(event) => {

            Swal.fire({
                title: 'Vous-voulez vraiment déconnecter?',
                // text: "You won't be able to revert this!",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Déconnecter'
              }).then((result) => {
            if (result.isConfirmed) {
              window.location.replace('../login/index.php')
            }})

          })



    /********************************************/
    /**   FONCTIONNALITES DU BOUTON COMMENTER   */
    /********************************************/
  
      //     $('#edit tbody').on('click', '#comment', function () {
      //         let currentrow = $(this).closest('tr');
      //         const val = currentrow.find('td:eq(8) > input').val();
      //         // const val = $.trim($("#val").val());

      //         // console.log(val);

      //         let comment = currentrow.find('td:eq(7)').css("background", '#B1E7B0');
      //         comment.text(val);

      //         const articles = currentrow.find(".articles")?.[0]

      //         // console.log(articles)

      //         DM = DM.map(obj => {
      //             if (obj.obj_article.trim() === $(articles).text().trim()) {
      //                 return {
      //                     ...obj,
      //                     comment,
      //                     commentaire: val
      //                 }
      //             } else {
      //                 return obj
      //             }
                  
      //         })
      //     $(document).on("click", "#modifier" ,(event) => {
      //     // event.preventDefault();
      //     // console.log('cliqued')


      // })
</script>
   <script type="text/javascript" src="../../assets/js/accueil.js"></script>
</body>

<style>
  
.user {
  position:fixed;
  right: 200px;
}
</style>

</html>