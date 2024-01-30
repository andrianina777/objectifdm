function showModal(){
    const  modal = new bootstrap.Modal(document.getElementById('modalform')) 
   modal.show(); 
   }

   $(document).ready( function () {
    
   const table = $('#an_table').DataTable({
      language: {
        url: '../../plugins/datatables/datatables:fr-FR.json'
     }
     
    })

    // $('#an_table tbody').on('click', '#disable-dm', function () {
    //   const row = table.row( this ).data(); 
    //   var data = table.row($(this).parents('tr')).data();
    // });


      $('#an_table tbody').on( 'click', '#disable-dm', function () {
      const row = table.row( this ).data(); 
      var data = table.row($(this).parents('tr')).data();

      /******************************************/
      /**   Alert confirm Delete                */
      /******************************************/
      Swal.fire({
      title: 'Souhaitez-vous supprimer : '+ data[0] +' qui dispose d\'un labo : '+ data[2] +'?',
      // text: "Cette action est irreversible",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#3085d6',
      confirmButtonText: 'Supprimer'
       }).then((result) => {

      if (result.isConfirmed) {

        table
              .row( $(this).parents('tr') )
              .remove()
              .draw();

      /******************************************/
      /**   Ajax send Data in controller        */
      /******************************************/
        $.ajax({
        type: "POST",
        url: "../../controller/dmSupp.php",
        data: {
            action: "dmDelete",
            data
          
        },
        success: function (response) {
            console.log(response.message);
            // alert('Suppression Réussite');
            //window.location.replace('/pages/accueil/index.php')
            //window.location.reload(true)

        }
    });
          //  Swal.fire(
          // 'Supprimer',
          // data[0]+ ' Supprimer avec Succès',
          // 'success'
          //  )
      }
    })
    console.log(data);

      });
                     
      // console.log(data);
     

      //     /******************************************/
      //     /**   Alert confirm Delete                */
      //     /******************************************/
      //     Swal.fire({
      //     title: 'Voulez-vous vraiment supprimer '+ data[0] +' qui à un labo : '+ data[2] +'?',
      //     text: "Cette action est irreversible",
      //     icon: 'warning',
      //     showCancelButton: true,
      //     confirmButtonColor: '#3085d6',
      //     cancelButtonColor: '#d33',
      //     confirmButtonText: 'Supprimer'
      //   }).then((result) => {

      //     if (result.isConfirmed) {
      //          Swal.fire(
      //         'Supprimer',
      //         'DM Supprimer avec Succès',
      //         'success'
      //       )
      //     }
      //   })

    /*********************************************/
    /*** Fonctionnalités du boutton modifier    */
    /********************************************/

    $('#an_table tbody').on( 'click', '#edit_lab', function () {
      const row = table.row( this ).data(); 
      var dm_data = table.row($(this).parents('tr')).data();

      // console.log(data)
                      
      /*********************************************/
      /**   Ajax send Data FOR EDIT in controller */
      /********************************************/
      $.ajax({
        type: "POST",
        url: "../../controller/edit_labo.php",
        data: {
            action: "editer",
            dm_data
          
        },
        success: function (response) {
            // console.log(response.message);
          DM_LIST = response.labo;
          // console.log(response.labo);
          
          // for (obj in DM_LIST){
          //   console.log(obj[lab_dmmatricule])
          // }

          let test = DM_LIST[0]
          //  console.log(test)

          for (obj in test){
            // console.log(test[obj])
            let data = test[obj];
            // console.log(data)
             
            // $("#matriculle").val(data)                    

          }
           const matriculle_modif = DM_LIST.map(({ lab_dmmatricule }) => lab_dmmatricule);
            // console.log(matriculle_modif[0])

            const name = DM_LIST.map(({ lab_dmprenom }) => lab_dmprenom);
            // console.log(name[0])

            var nameLabo = name[0];

            console.log(nameLabo)                                           

            // $("#matriculle_modif").val(matriculle_modif[0]);
            $("#name").val(nameLabo);

            // $("#list_dm").val(labo);

          $('table#list_labo tbody').html('')
              response.labo.forEach(obj => {
          $('table#list_labo tbody').append(`
              <tr>
                <td>${obj.lablabo}</td>
              </tr>
              `)
            
            })

        }
      });
      
            /**************************************************/
            /**      SCRIPT WHO CONTROL THE ADD LABO	       */
            /*************************************************/
              
            DATA_DM_EDIT = []

        function generateEdit() {
          const rows = $("#list_dm tbody")
          console.log(DATA_DM_EDIT);
          rows.html("")
          DATA_DM_EDIT.forEach(valeur => {
            rows.append(`
              <tr>
                <td>
                  ${valeur}
                </td>
                <td><button class="btn btn-danger btn-sm" data-dm="${valeur}" id="dm_delete">x</button></td>
              </tr>
            `);
          })

          $("#dm_added").closest("tr").remove()
        }

        $(document).on("click", "#dm_delete", (e) => {
        const dm = $(e.target).data("dm")
        DATA_DM_EDIT = DATA_DM_EDIT.filter(el => el !== dm)
        generateEdit()
        })

        $(document).on("click", "#dm_add", () => {
          event.preventDefault();
          if (!DATA_DM_EDIT.includes($("#dm_added").val())) {
            DATA_DM_EDIT.push($("#dm_added").val())
          }
          generateEdit()
          $("#add-dm").prop("disabled", false)
        })

        /*************************************************** */
        /**            GET DATA TO THE PAGE		           */
        /*************************************************** */

        $("body #edit").click((event) => {
        event.preventDefault();

        if ( DATA_DM_EDIT == ''){
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
            title: 'Veuillez ajouter un labo'
          });
          return;
        } 

        else {
          
        }

        /*************************************************** */
        /**            SEND DATA TO THE CONTROLLER           */
        /*************************************************** */
        $.ajax({
        type: "POST",
        url: "../../controller/edit_labo.php",
        data: {
        action: "editData",
        DATA_DM_EDIT,
        dm_data
          
        },
        success: function (response) {
        console.log(response.message);

        // alert(response);
        //  window.location.replace('/pages/DM/index.php')
                                        
        Swal.fire({
                      // position: 'top-end',
                      icon: 'success',
                      title: 'Ajout du Labo Réussite',
                      showConfirmButton: false,
                      timer: 1500
                      })

            var delay = 1500; 
            setTimeout(function(){ window.location = '../../pages/DM/index.php'; }, delay);

        }

        }); 
      })

         /***********************************************/
         /**   Ajax send nameLabo to page edit_labo.php */
        /***********************************************/
                                                       
          $.ajax({                            
              type: "POST",                    
              url: "../../controller/selected.php",   
              data: {                          
                     action: "getName",           
                     dm_data                                                                                        
                    },
                    success: function (response) {
                      //console.log('test')
                    LABO_LIST = response.laboList;
                    //console.log(response.laboList); 
                    $('#dm_added').html('')
                    response.laboList.forEach(obj => {
                    $("#dm_added").append(`
                      <option> ${obj.labo} </option>
                      `)  
                    }) 

          } 
                                                                                       
    })                                        
   })
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
  window.location.replace('../../pages/login/index.php')
}})

})