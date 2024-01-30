<?php
// require_once($_SERVER['DOCUMENT_ROOT'] . "/config/database.php");
require_once ("../../config/database.php");

//require_once($_SERVER['DOCUMENT_ROOT'] . "/controller/genere.php");

// Initialiser la session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Vérifiez si l'utilisateur est connecté, sinon redirigez-le vers la page de connexion
if (!isset($_SESSION["user_in"])) {
    header("Location: ../../index.php");
    exit();
    $_SESSION['identifiant'] = $_POST['identifiant'];
}

$dmusercre = $_SESSION['identifiant'] ;

// Get list délégué dans select
// $sqlDm = "SELECT dmseq, dmmatricule, dmprenom FROM fdm WHERE dmactif=true";
$sqlDm = "SELECT  DISTINCT dmseq, dmmatricule, dmprenom FROM objectifdm.fdm inner join objectifdm.flabodm on trim(lab_dmprenom)=trim(dmprenom) inner join objectifdm.flabsup on trim(lab_labo)=trim(lablabo) 
WHERE dmactif=true and lab_sup='$dmusercre' order by dmprenom";

$stmtDm = $conn->prepare($sqlDm);
$stmtDm->execute();
$listDm = $stmtDm->fetchAll();


//Get list Labo par rapport au DM
// $labo = "SELECT distinct lablabo ,lab_dmprenom FROM flabodm WHERE lab_dmprenom=?";
// $getLab = $conn->prepare($labo);
// $getLab->execute();
// $listLab = $getLab->fetchAll();

?>
<html>
<head>
    <link rel="stylesheet" href="../../assets/css/style.css">
    <script src="../../plugins/sweetalert2/sweetalert2.min.js"></script>
</head>
<body>
<?php include_once "../../layouts/spinner.php"; ?>
<form action='../../controller/genere.php' id="genere_form" method='POST'>
    <div class="container mt-3">
        
        <h4>Génération Objectif DM</h4>
           <div class="row">
            <div class="col-lg-2">
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">Année</span>
                    <select name="annee" id="annee" class="form-select form-select-sm"
                            aria-label=".form-select-sm example">
                        <option value="null" selected>---</option>
                        <?php foreach ($listYear as $key => $DmItem) { ?>
                            <option value="<?= $DmItem['annee'] ?>"><?= $DmItem['annee'] ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="col-lg-2">
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">Mois</span>
                    <select name="mois" id="mois" class="form-select form-select-sm"
                            aria-label=".form-select-sm example">
                        <option value="null" selected>---</option>
                        <?php foreach ($listMois as $key => $DmItem) { ?>
                            <option value="<?= $DmItem['mois_num'] ?>"><?= $DmItem['mois'] ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="col-lg-2">
                <div class="input-group mb-2">
                    <span class="input-group-text" id="basic-addon1">DM</span>
                    <select name="dm" id="dm" class="form-select form-select-sm" aria-label=".form-select-sm example">
                        <option value="null" selected>---</option>
                        <?php foreach ($listDm as $key => $DmItem) { ?>
                            <option id='dmSelected'
                                    value="<?= $DmItem['dmprenom'] ?>"><?= $DmItem['dmprenom'] ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>


            <div class="col-lg-2">
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">Labo</span>
                    <select name="labo" id="labo" class="form-select form-select-sm"
                            aria-label=".form-select-sm example">
                        <option value="null" selected>---</option>
                    </select>
                </div>
            </div>

            <div class="col-sm-3">
                <button class="btn btn-dark" id="charger">Charger</button>
            </div>
        </div>
</form>
<br>
<br>

<div class="tableFixHead">
<?php require_once('../../controller/genere.php'); ?>
    <table class="table table-striped table-hover" id="genere">
        <!-- <table id='an_table' class="display" style="width:100%"> -->
        <thead>
        <tr>
            <th scope="col">Labo</th>
            <th scope="col">Articles</th>
            <th scope="col">Libellés</th>
            <th scope="col">Stock</th>
            <th scope="col">Évolution(%)</th>
            <th scope="col">Actif</th>
            <th scope="col">Quantité vente</th>
            <th scope="col">Objectif</th>
            <th scope="col">Commentaire</th>
            <th scope="col"></th>
            <th scope="col">Action</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
<script>

$(document).ready(function(){
    var CurrentDate=new Date();

    $("#year").val(CurrentDate.getYear());
    $("#month").val(CurrentDate.getMonth());
    $("#day").val(CurrentDate.getDate());
  });


    /*************************************************************/
    /**     AFFICHE LES LABOS PAR RAPPORT AU DM SELECTIONNER    */
    /***********************************************************/

    $(document).ready(() => {
        const listDM = JSON.parse(`<?= json_encode($listLab) ?>`)
        $('#dm').on('change', (e) => {
            const prenomDM = e.target.value;
            if (prenomDM === 'null') {
                $('#labo').html('<option value="null" selected>---</option>')
            } else {
                $('#labo').html(
                    listDM.filter(labodm => labodm.lab_dmprenom === prenomDM)
                        .map(labodm => `<option value="${labodm.lablabo}">${labodm.lablabo}</option>`)
                        .join('')
                )
            }
        })
    })

    /*************************************************** */
    /**            GET DATA TO THE PAGE                  */
    /*************************************************** */

    let OBJECTIF_LIST = [];
    // let EVOL = [];

    $(document).on("click", "#charger", (event) => {
        event.preventDefault();
        //alert('boutton cliquer')
        const formData = {};


        $("body #genere_form").serializeArray().forEach(el => {
            formData[el.name] = el.value;
        })
        console.log(formData);

        /*************************************************** */
        /**            SEND DATA TO THE CONTROLLER           */
        /*************************************************** */
        showLoader(true);
        $.ajax({
            type: "POST",
            url: "../../controller/genere.php",
            data: {
                action: "sendGen",
                formData
            },
            success: function (response) {
                OBJECTIF_LIST = response.objectif;
                console.log(response.objectif);
                //window.location.replace('/pages/DM/index.php')
             $('table#genere tbody').html('')
                 response.objectif.forEach(obj => {
                    $('table#genere tbody').append(`
                        <tr class='cacher'>
                            <td><div id='labo'">${obj.labos}</div></td>
                            <td class="articles">${obj.articles}</td>
                            <td>${obj.libelles}</td>
                            <td></td>
                            <td width="10%"><input class="form-control form-control-sm" type="number" min="0" placeholder="10" value="${obj.evolution}" id="evolution"></td>
                            <td><input type="checkbox" name ="check" class="checkbox" id="actif" data-articles="${obj.articles}" value="${obj.actif}"></td>
                            <td width="10%"><div id ="qte">${obj.qteder}</div></td>
                            <td><input class="form-control form-control-sm" type="number" min="0" value="${obj.objectif}" id="objectif"></td>
                            <td width="10%" class="commentaire" data-commentaire="${obj.coms}" value="${obj.coms}"></td>
                            <td width="5%"><input type='text' id ='comgenere'></td>
                            <td><button type="button" id="calcul" class="btn btn-outline-success">calculer</button></td>
                        </tr>
                    `)
                    //$('td#actif').css('background-color','gray');
                    //valeur multik dans evolution ${obj.evolution}

                })
                showLoader(false);
            }
        });
    });


//     $('#genere tbody').on('change', '#com', function () { 
// //  console.log('change')
//         let currentrow = $(this).closest('tr');
//         const val = currentrow.find('td:eq(9) > input').val();

//         // console.log("tonga eto am val")
//         //  console.log('valeur commentaire :'+val);

//         /*****************************************/
//         /**     GET VALUE COMMENTAIRE           */
//         /****************************************/

//         // let test = currentrow.find('td:eq(7)').text();
//         let comment = currentrow.find('td:eq(8)').css("background", '#B1E7B0');
//         comment.text(val);
        
//         //   console.log(comment)

//         // $(document).on("keypress","#com", (event) => {
//         $(document).on("click", "#modif", (event) => {
//             //console.log(val)
//         // const selectedComs = $('#edit tbody input[type="checkbox"]:not(:checked)').toArray().map(el => $(el).data('articles'))
//         const selectedComs = $('#edit tbody input[type="checkbox"]:checked').toArray().map(el => $(el).data('articles'))
//         const rows = DM.filter(obj => selectedComs.includes(obj.articles))

//         // console.log(selectedComs);

//         // console.log(rows);

//         let id_edit = currentrow.find('td:eq(0)').text();
//         console.log(id_edit);

//         })
//     });



        /************************************** */
        /*    GET VALUE COMMENTAIRE GENERER    */
        /************************************* */

    let valcoms;
    
    $('#genere tbody').on('change', '#comgenere', function () { 
//  console.log('change')
        let currentrow = $(this).closest('tr');
        valcoms = currentrow.find('td:eq(9) > input').val();
         
        // console.log(valcoms)

        let commentaire = currentrow.find('td:eq(8)').css("background", '#B1E7B0');
        commentaire.text(valcoms);

        console.log('valeur commentaire generer :'+valcoms)

        $(document).on("click", "#valid", (event) => {
        const selectedComs = $('#genere tbody input[type="checkbox"]:checked').toArray().map(el => $(el).data('articles'))
        
        const rows = DM.filter(obj => selectedComs.includes(obj.articles))

         console.log('valeur Rows : '+rows)
        
        //  console.log(selectedComs);

        // console.log(rows);  
        let id_edit = currentrow.find('td:eq(0)').text();
        console.log(id_edit);

        })
    });

    
    /****************************************************/
    /**      SELECTOR JQUERY FOR CHECKED ELEMENT        */
    /****************************************************/

    $(document).on("click", "#valid", (event) => {
        event.preventDefault();
        const selectedArticles = $('#genere tbody input[type="checkbox"]:checked').toArray().map(el => $(el).data('articles'))
        const row = OBJECTIF_LIST.filter(obj => selectedArticles.includes(obj.articles))
        
        //console.log(row)
        //alert(row)
        // console.log(selectedArticles);


        //GET VALUE OF CHECKBOX
        // $('#genere tbody').on('click', '#calcul', function () {
        let currentrow = $(this).closest('tr');
        const checkboxValue =  $('#actif').val();      
        // checkboxValue.prop('checked',true);
        console.log(checkboxValue)

        // $(document).ready(function() {
        //     let isChecked = localStorage.getItem("checkedbox");
        //     // now set it
        //     $('#actif').prop('checked', isChecked)
        //     });

        //     $('#check').on('click', function() {
        //         localStorage.setItem("checkedbox", $(this).prop('checked'));
        //         // if you really want to submit the form when someone checks it...
        //         $('form').submit();
        //     })
            
        // })
         
        //console.log(row)

        
        const formData = {};
        console.log(formData);

        $("body #genere_form").serializeArray().forEach(el => {
            formData[el.name] = el.value;
        })

        if ( selectedArticles == ''){
        const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 4000,
        timerProgressBar: true,
        onOpen: (toast) => {
          toast.addEventListener('mouseenter', Swal.stopTimer)
          toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
      });

      Toast.fire({
        icon: 'warning',
        title: 'Veuillez Charger ou Cocher un ou plusieurs éléments afin de pouvoir les ajouter'
      });
      return;
        } else {

        /****************************************************/
        /**      SEND DATA SELECTED TO DATABASE             */
        /****************************************************/
        $.ajax({
            type: "POST",
            url: "../../controller/genereSend.php",
            data: {
                action: "sendSelected",
                row,
                formData,
                valcoms,
            },
            success: function (response) {
                console.log(response.message);
                // alert('Insertion Réussite');
          Swal.fire({
          // position: 'top-end',
          icon: 'info',
          title: 'Insertion Réussite',
          showConfirmButton: false,
          timer: 1000})
                // window.location.replace('/pages/accueil/index.php')
                // $("tr:contains("+selectedArticles+")").remove();
            var delay = 1000; 
            setTimeout(function(){ window.location = '../../pages/accueil/index.php'; }, delay);
        
            }

        });
            
        }

    })

    /********************************************/
    /**   FONCTIONNALITES DU BOUTON CALCULER    */
    /********************************************/

    $('#genere tbody').on('click', '#calcul', function () {
        let currentrow = $(this).closest('tr');
        let qte = currentrow.find('td:eq(6)').text();
        let quantite = qte;
        //console.log(result);
        // const evol = currentrow.find('td:eq(4) > input').val();
        const evolInput = currentrow.find('td:eq(4) > input');
        const evol = evolInput.val();
        // console.log(evol);

        let objectif = evol * quantite;
        let objectif_round =  Math.round(objectif);
        //alert ('Objectif : '+objectif);
        console.log(objectif);

        /**********************************************************************/
        /**  Renvoyer le nouveau valeur objectif dans la colonne de objectif  */
        /**********************************************************************/

        let object = currentrow.find('td:eq(7)').css("background", '#DEF5F4');
        object.val(objectif_round);
        const articles = currentrow.find(".articles")?.[0]
        OBJECTIF_LIST = OBJECTIF_LIST.map(obj => {
            if (obj.articles.trim() === $(articles).text().trim()) {
                return {
                    ...obj,
                    objectif_round,
                    evolution: evol,
                }
            } else {
                return obj
            }
        })
    })


    /*****************************************************************************/
    /**  Fonction Checkbox qui calcul automatiquement les valeurs de l'objectif */
    /****************************************************************************/

        $('#genere tbody').on('click', '#actif', function () {
        let currentrow = $(this).closest('tr');
        let qte = currentrow.find('td:eq(6)').text();
        let quantite = qte;
          //console.log(result);
        // const evol = currentrow.find('td:eq(4) > input').val();
        const evolInput = currentrow.find('td:eq(4) > input');
        const evol = evolInput.val();
        // console.log(evol);

        
        let objectif = evol * quantite;
        let objectif_round =  Math.round(objectif);
        //console.log(objectif_round)
        //alert ('Objectif : '+objectif);
        // console.log(objectif);

        /**********************************************************************/
        /**  Renvoyer le nouveau valeur objectif dans la colonne de objectif  */
        /**********************************************************************/

        let object = currentrow.find('td:eq(7)').css("background", '#DEF5F4');
        object.val(objectif_round);
        const articles = currentrow.find(".articles")?.[0]
        OBJECTIF_LIST = OBJECTIF_LIST.map(obj => {
            if (obj.articles.trim() === $(articles).text().trim()) {
                return {
                    ...obj,
                    objectif_round,
                    evolution: evol
                }
            } else {
                return obj
            }
        })
    })

    /***************************************************************************************/
    /**  Fonction Focus qui calcul automatiquement les valeurs après changement de valeur */
    /**************************************************************************************/
    $('#genere tbody').on('change', '#evolution', function () {
        // console.log('changed')
        let currentrow = $(this).closest('tr');
        let qte = currentrow.find('td:eq(6)').text();
        let quantite = qte;
          //console.log(result);
        const evolInput = currentrow.find('td:eq(4) > input');
        const evol = evolInput.val();
        // console.log(evol);

        let objectif = evol * quantite;
        let objectif_round =  Math.round(objectif);
        //alert ('Objectif : '+objectif);
        console.log(objectif);

        /**********************************************************************/
        /**  Renvoyer le nouveau valeur objectif dans la colonne de objectif  */
        /**********************************************************************/

        let object = currentrow.find('td:eq(7) >input');
        object.val(objectif_round);
        const articles = currentrow.find(".articles")?.[0]
        OBJECTIF_LIST = OBJECTIF_LIST.map(obj => {
            if (obj.articles.trim() === $(articles).text().trim()) {
                return {
                    ...obj,
                    objectif_round,
                    evolution: evol
                }
            } else {
                return obj
            }
        })
    })



    /***************************************************************************************************/
    /**  Fonction Focus qui calcul automatiquement les valeurs après changement de valeur de objectif */
    /**************************************************************************************************/
    $('#genere tbody').on('change', '#objectif', function () {
        // console.log('changed')
        let currentrow = $(this).closest('tr');
        let qte = currentrow.find('td:eq(6)').text();
        let quantite = qte;
          //console.log(result);
        // const objectif = currentrow.find('td:eq(7) > input').val();

        const objectifInput = currentrow.find('td:eq(7) > input');
        const objectif = objectifInput.val();
        // console.log(evol);

        let evol = objectif/ quantite;
        // let evol_round =  Math.round(evol);
        let evol_round = evol.toFixed(2);


        //alert ('Objectif : '+objectif);
        console.log(evol);

        /**********************************************************************/
        /**  Renvoyer le nouveau valeur objectif dans la colonne de Evolution */
        /**********************************************************************/

        let object = currentrow.find('td:eq(4) >input');
        object.val(evol_round);
        const articles = currentrow.find(".articles")?.[0]
        OBJECTIF_LIST = OBJECTIF_LIST.map(obj => {
            if (obj.articles.trim() === $(articles).text().trim()) {
                return {
                    ...obj,
                    evol_round,
                    evolution: evol
                }
            } else {
                return obj
            }
        })
    })
</script>
</body>
</html>