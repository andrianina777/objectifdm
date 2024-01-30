<?php //require_once($_SERVER['DOCUMENT_ROOT'] . "/controller/edit_labo.php"); 

require_once ("../../config/database.php");
?>


					<!-- Page d'ajout Labo (DM/edit_labo.php) -->
<!DOCTYPE html>
<html>
  <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Délégué Médical | Modifier</title>
		<script src="../../plugins/sweetalert2/sweetalert2.min.js"></script>
  </head>
<body>
<!-- <form action="/controller/dmcreate.php" id="labo-form" method="POST"> -->
	<div class="container mt-3">
		<h4>Ajouter des Labo </h4>
			<div class="row">
				<div class="col-lg-6"></div>
				<div class="col-lg-1">
				<p><button name="submit" id="edit" class="btn btn-success">Modifier</button></p>
				</div>
				<div class="col-lg-1">
					<a href="../../pages/DM/index.php"><p><button type="button" class="btn btn-danger">Annuler</button></p></a>
				</div>
			</div>

       <!-- <div class="row">
          	<div class="col-lg-5">
              <h4>  <div class="form-check"> Ajouter un ou plusieurs Labo </h4>
                </div>
          	</div> -->
        <!-- </div>  -->
  	
   	<!-- <div class="row"> -->
        <!-- <div class="col-lg-1">   -->
            <!-- Matriculle :  -->
        <!-- </div> -->
        <!-- <div class="col-lg-3">   -->
             <!-- <input type="text" class="form-control" placeholder="Matriculle" id='matriculle_modif' disabled> -->
         <!-- </div> -->
     <!-- </div> -->
	 <!-- <br>-->
	<div class="row">
        <div class="col-lg-1"> 
            Prénom : 
        </div>
        <div class="col-lg-3">  
		<input type="text" class="form-control" id="name" placeholder="Prénom" disabled>
        </div>
    </div> 
	
</form>
	<br>   
	<!-- <div class="row">
          	<div class="col-lg-5">
			  <h4><u>Liste des labos déjà enregistrer :</u></h4>

				<table class="table_stats" id="list_labo" style="width:100%">
					<thead>
						<tr>
							
						</tr>
					</thead>
						<tbody>
						</tbody>
				</table>
            </div>
        </div>
	<br> -->

	<div class="row">
		<div class="col-lg-1">
			Labo : 
		</div>
		<div class="col-lg-3">
		<select class="form-select form-select-sm" id="dm_added" aria-label=".form-select-sm example">
		<option value="null" selected>---</option>

  		</select>
		  </div>
		  <div class="col-lg-1">
		  <td><button class="btn btn-secondary btn-sm" id="dm_add">+</button></td>
		</div>
	</div>
<!--<button id="add-dm" class="btn btn-danger btn-sm">Ajouter DM</button>-->
   
    					<table class="table table-striped" id="list_dm" style="width:100%">
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