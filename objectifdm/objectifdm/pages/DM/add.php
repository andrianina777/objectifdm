<?php
		/************************************************************/
		/* Requete qui affiche les listes des labos dans le select */
		/***********************************************************/
		// Vérifiez si l'utilisateur est connecté, sinon redirigez-le vers la page de connexion
		
	if(!isset($_SESSION["user_in"])){
		header("Location: ../../index.php");
		exit(); 
		$_SESSION['identifiant'] = $_POST['identifiant'];		  
	}	
	$dmusercre = $_SESSION['identifiant'] ;
	
  // Get list labo dans select
  //$sqlDm = "SELECT distinct labo,nom_labo FROM farticle WHERE trim(labo)=trim(?)";
//   $sqlDm = "SELECT DISTINCT labo FROM view_article order by labo ASC";

  $sqlDm = "SELECT DISTINCT labo FROM view_article inner join objectifdm.flabsup on lab_labo=labo where lab_sup='$dmusercre' order by labo ASC";
  $stmtDm = $conn->prepare($sqlDm);
  $stmtDm->execute();
  $listDm = $stmtDm->fetchAll();
?>
<?php //require_once($_SERVER['DOCUMENT_ROOT'] . "/controller/dmcreate.php"); 
require_once ("../../controller/dmcreate.php");
?>

						<!-- Page de création de DM  -->

<!DOCTYPE html>
<html>
  <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Délégué Médical | Ajout</title>
		<script src="../../plugins/sweetalert2/sweetalert2.min.js"></script>
		<script src="../../plugins/jquery/jquery.validate.min.js"></script>
  </head>
<body>
<form action="../../controller/dmcreate.php" id="labo-form" method="POST">
	<div class="container mt-3">
		<h4>Ajout DM par Labo</h4>
			<div class="row">
				<div class="col-lg-5"></div>
				<div class="col-lg-1">
				<p><button name="submit" id="submit-btn" class="btn btn-success" >Enregistrer</button></p> 
				</div>
				<div class="col-lg-1">
				</div>
				<div class="col-lg-1">
				<a href="../../pages/DM/index.php"><p><button type="button" class="btn btn-danger">Annuler</button></p></a>
				</div>
			</div>

     <!--   <div class="row">
          	<div class="col-lg-1">
                <div class="form-check">Actif 
                <input class="form-check-input" type="checkbox" name="isActif" id="">
                  <label class="form-check-label" for="actif"></label>
                </div>
          	</div>
        </div> -->
  	<br>
   	<div class="row">
        <div class="col-lg-1">  
            Matriculle : 
        </div>
        <div class="col-lg-3">

        	<input type="number" class="form-control" name="matriculle" id='matriculle' placeholder="Matriculle"> 

        </div>
        <div class="col-lg-1">
        	<div id="notif">*</div>
        </div>
    </div>
	<br>
    <div class="row">
        <div class="col-lg-1">  
            Prénom : 
        </div>
        <div class="col-lg-3">  
            <input type="text" class="form-control" name="prenom" id="prenom" placeholder="Prénom" autocomplete="off">
        </div>
        <div class="col-lg-1">
        	<div id="notif">*</div>
        </div>
    </div>
	<br>
    <div class="row">
        <div class="col-lg-1">  
            Email : 
        </div>
        <div class="col-lg-3">  
            <input type="email" class="form-control" name="email" id='mail' placeholder="Email"> 
        </div>
        <div class="col-lg-1">
        	<div id="notif">*</div>
        </div>
    </div>
</form>

	<br>   
	<br>
	
	<div class="row">
		<div class="col-lg-1">
			Labo : 
		</div>
		<div class="col-lg-3">
		<select class="form-select form-select-sm" id="added-dm" aria-label=".form-select-sm example">
		<option value="null" selected>---</option>
		<?php foreach($listDm as $key => $listLabo) { ?>
                <option value="<?= $listLabo['labo'] ?>"><?= $listLabo['labo'] ?></option>
              <?php } ?>
  		</select>
		  </div>
		  <div class="col-lg-1">
		  <td><button class="btn btn-secondary btn-sm" id="ok-dm">+</button></td>
		</div>
	</div>
<!--<button id="add-dm" class="btn btn-danger btn-sm">Ajouter DM</button>-->
    					<table class="table" id="list_dm" style="width:100%">
							<thead>
								<tr>
									<th>Code Labo</th>
									<th>Action</th>
								</tr>
							</thead>
						<tbody>
					</tbody>
				</table>
			</div>
		</body>
	</html>
<script>		

	DATA_DM = []

	function generateGrid() {
		const row = $("#list_dm tbody")
		console.log(DATA_DM);
		row.html("")
		DATA_DM.forEach(val => {
			row.append(`
				<tr>
	  				<td>
	  					${val}
	  				</td>
					<td><button class="btn btn-danger btn-sm" data-dm="${val}" id="delete-dm">x</button></td>
	  			</tr>
			`);
		})

		$("#added-dm").closest("tr").remove()
	}

	$(document).on("click", "#delete-dm", (e) => {
		const dm = $(e.target).data("dm")
		DATA_DM = DATA_DM.filter(el => el !== dm)
		generateGrid()
	})
	
	$(document).on("click", "#ok-dm", () => {
		 event.preventDefault();
		if (!DATA_DM.includes($("#added-dm").val())) {
			DATA_DM.push($("#added-dm").val())
		}
		generateGrid()
		$("#add-dm").prop("disabled", false)
	})


      /*************************************************** */
      /**            GET DATA TO THE PAGE		           */
      /*************************************************** */

      $("body #submit-btn").click((event) => {
        event.preventDefault();
        const formData = {};
		//const selectedEl = DATA_DM

        $("body #labo-form").serializeArray().forEach(el => {
          formData[el.name] = el.value;
        })
			//  console.log(formData)
			//  console.log(formData.matriculle);
			 let matriculle = formData.matriculle;
			 let prenom = formData.prenom;
			 let email = formData.email;

			//  var mail = ;
			// //  console.log(mail)
			// for(var i = 0; i < mail.length; i++){
			// 		// console.log(mail[i]);
			// 		const obj = JSON.parse(mail[i]);
			// 		console.log(obj.dmmail)
			// 	}

			if(DATA_DM == '' || DATA_DM == 'null'){
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
					title: 'Veuillez Ajouter un ou plusieurs Labo'
				});
				return;
			}
			else 
				
			if (matriculle ==''){
				$('#matriculle').focus();			
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
					title: 'Matriculle vide'
				});
				return;
				
			}
			else
			if (prenom ==''){
				$('#prenom').focus();
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
					title: 'Prénom vide'
				});
				return;

			}
			else if (email ==''){
				$('#mail').focus();
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
					title: 'Email vide'
				});
				return;
			}
			else
						
			{
			//console.log(DATA_DM);
        
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
				DATA_DM,
				formData: formData
			},
				success: function (response) {
				console.log(response);

				if (response == 'Utilisateur déjà existant["Utilisateur deja existant"]'){
					// alert ('Utilisateur déjà existant');

					Swal.fire({
						icon: 'error',
						title: 'DM déjà enregistrer',
						text: 'Veuillez Entrer un(e) nouveau DM',
					})

					// Swal.fire({
					// // position: 'top-end',
					// icon: 'warning',
					// title: 'Utilisateur déjà existant',
					// showConfirmButton: false,
					// timer: 1500
					// })
				}
				else {
				// console.log(response.erreur);
				// Swal.fire({
				// // position: 'top-end',
				// icon: 'info',
				// title: 'Ajout du DM Réussite',
				// showConfirmButton: false,
				// timer: 1000})
				// Swal.fire('Ajout du DM Réussite')
				// alert(response);

				Swal.fire({
				// position: 'top-end',
				icon: 'success',
				title: 'Ajout du DM Réussite',
				showConfirmButton: false,
				timer: 1500
				})

				var delay = 1500; 
				setTimeout(function(){ window.location = '../../pages/DM/index.php'; }, delay);
				//  window.location.replace('/pages/DM/index.php')	
				}
	
			},
				error: function(error){
					console.log(error.erreur);
				}
			
		  }); 
		}
		
		
      })


</script>