<?php
require_once ("../../config/database.php");
require_once ("../../controller/editController.php");
require_once ("../../pages/accueil/index.php");


//require_once($_SERVER['DOCUMENT_ROOT'] . "/controller/genere.php");

// Initialiser la session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Vérifiez si l'utilisateur est connecté, sinon redirigez-le vers la page de connexion
if (!isset($_SESSION["user_in"])) {
    header("Location: ../../index.php");
    exit();
}
?>

<h4><div id="title"><i><u>Détails du DM </u></i> : <span id="title-value"></span></div></h4>
<!-- <div align='Center'><u>Objectif Atteintes </u>: <span id='test_val'></span>/<span id='realrow'></span></div> -->
<button type="button" class="btn btn-warning" id="export">Exporter en Excel</button>
<br>
<br>
<div class="align-center">
<!-- <p>Decocher pour Supprimer un ou plusieurs Articles</p> -->
</div>
<div class="tableFixHead">
<table class="table table-striped table-hover" id="edit">
  <thead>
    <tr>
      <th scope="col" style="display:none" class="noExl">id</th>
      <th scope="col">Date</th>
      <th scope="col">Articles</th>
      <th scope="col">Libellés</th>
      <th scope="col">Labo</th>
      <th scope="col">Quantité Vente</th>
      <th scope="col">Évolution</th>     
      <th scope="col">Objectif</th>
      <th scope="col">Stock</th>
      <th scope="col">A.Offre</th>
      <th scope="col">Vente Normal</th>
      <th scope="col">Vente en cours</th>
      <th scope="col">Taux réalisation</th>
      <th scope="col">Actif</th>
      <th scope="col">Commentaire</th>
      <th scope="col"></th>
      <th scope="col" style="display:none">Délégué Médical</th>
      <th scope="col" style="display:none">Mois</th>
      <th scope="col" style="display:none">Année</th>

      <!-- <th scope="col"></th> -->
    </tr>
  </thead>
  <tbody>
  </tbody>
</table>
</div>
<script>

// let COM = [];


$('#edit tbody').on('change', '#com', function () { 
//  console.log('change')
        let currentrow = $(this).closest('tr');
        const val = currentrow.find('td:eq(15) > input').val();

        // console.log("tonga eto am val")
         console.log('valeur commentaire :'+val);

    /*****************************************/
    /**     GET VALUE COMMENTAIRE           */
    /****************************************/

        // let test = currentrow.find('td:eq(7)').text();
        let comment = currentrow.find('td:eq(14)').css("background", '#B1E7B0');
        comment.text(val);
        
        //  console.log(comment)

        // $(document).on("keypress","#com", (event) => {
        $(document).on("click", "#modif", (event) => {
            //console.log(val)
        // const selectedComs = $('#edit tbody input[type="checkbox"]:not(:checked)').toArray().map(el => $(el).data('articles'))
        const selectedComs = $('#edit tbody input[type="checkbox"]:checked').toArray().map(el => $(el).data('articles'))
        const rows = DM.filter(obj => selectedComs.includes(obj.articles))

        // console.log(selectedComs);

         console.log(rows);  
         
        let id_edit = currentrow.find('td:eq(0)').text();
        console.log(id_edit);

        // if (selectedComs == ''){
        //   const Toast = Swal.mixin({
        //     toast: true,
        //     position: 'top-end',
        //     showConfirmButton: false,
        //     timer: 4000,
        //     timerProgressBar: true,
        //     onOpen: (toast) => {
        //       toast.addEventListener('mouseenter', Swal.stopTimer)
        //       toast.addEventListener('mouseleave', Swal.resumeTimer)
        //     }
        //   });

        //   Toast.fire({
        //     icon: 'warning',
        //     title: 'Veuillez Décocher pour ajouter un commentaire'
        //   });
        //   return;
        // }
          // else {

      /********************************************/
       /**   SEND DATA TO UPDATE DATABASE          */
      /********************************************/
      $.ajax({
             type: "POST",
             url: "../../controller/homeUpdate.php",
             data: {
               action: "updateSelected",
                val,
                rows,
                id_edit,
           },
           success: function (response) {
               console.log(response.message);


            //    Swal.fire({
            //           // position: 'top-end',
            //           icon: 'success',
            //           title: 'Commentaire ajouter',
            //           showConfirmButton: false,
            //           timer: 1500
            //           })

            // var delay = 1500; 
            // setTimeout(function(){ window.location = '../../pages/accueil/index.php'; }, delay);
            
               //alert('Insertion Réussite');
              //window.location.replace('/pages/DM/index.php')

            }
        })

    //}

    })
})

              /****************************/
              /**   Export Data to Excel  */
              /****************************/

                $("#export").click(function(){
                $("#edit").table2excel({
                  exclude:".noExl",
                  name:"Worksheet Name",
                  filename:"Objectif DM ",//do not include extension
                  fileext:".xlsx" // file extension
                })
              })


</script>
