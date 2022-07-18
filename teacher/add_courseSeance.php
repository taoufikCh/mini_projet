<?php
session_start();
include('includes/header.php');
include('includes/navbar.php');
include('config/dbconn.php');

$id_ens=$_SESSION['auth_user']['codeuser'];
$query_groupe="SELECT * from groupe";
$res_groupe=mysqli_query($con, $query_groupe);

//$query="SELECT * from subject_affected WHERE idEns='$id'";
$query="SELECT subject_affected.*, matieres.* from subject_affected
LEFT JOIN matieres ON subject_affected.idMat = matieres.id_mat WHERE subject_affected.idEns='".$id_ens."'";
$res_mat=mysqli_query($con, $query);
?>

 <!-- Begin Page Content -->
 <div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"></h1>
        
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Formulaire d'ajouter une séance de cours</h6>
        </div>
        
        <?php if(isset($_GET['failed'])){
                 echo '<div class="card bg-danger text-white shadow"><div class="card-body">'.$_GET['failed'].'</div></div>';
        } ?>
        <div class="card-body">

        <form id="addUser" action="save_courceSeance.php" method="post">
            <div class="mb-3 row">
                <label for="subject" class="col-md-3 form-label mb-3" style="color:#000"><b>Matière : </b></label>
                <div class="col-md-3">
                    <select name="subject" id="subject" class="form-control" required>
                    <option value="">Choisir une matière</option>
                        <?php foreach($res_mat as $mat){ ?>
                            <option value="<?php echo $mat['id_mat'] ?>"><?php echo $mat['nom_mat']; ?></option>
                        <?php } ?>  
                    </select>
                </div>
                <label for="date_seance" class="col-md-3 form-label mb-2"><b>Date de la séance : </b></label>
                <div class="col-md-3">
                    <input type="date" class="form-control" id="date_seance" name="date_seance" required>
                </div>
            </div>
            <div class="mb-3 row">
              <label for="heure_debut" class="col-md-3 form-label mb-2"><b>Heure de début : </b></label>
              <div class="col-md-3">
                <input type="time" class="form-control" id="heure_debut" name="heure_debut" >
              </div>
              <label for="heure_fin" class="col-md-3 form-label mb-2"><b>Heure de fin : </b></label>
              <div class="col-md-3">
                <input type="time" class="form-control" id="heure_fin" name="heure_fin" required>
              </div>
            </div>
            <div class="mb-3 row">
              <label for="type_seance" class="col-md-3 form-label mb-2"><b>Type de la séance : </b></label>
              <div class="col-md-3">
                <select name="type_seance" id="type_seance" class="form-control" required>
                        <option value="1">Cours</option>
                        <option value="2">TP</option>
                    </select>
              </div>
              <label for="non" class="col-md-3 form-label mb-2"><b>Test d'évaluation : </b></label>
              <div class="col-md-3">
                    <label for="non">Non</label>
                    <input type="radio" id="non" name="test_eval" value="0" checked> &emsp;&emsp;
                    <label for="oui">Oui</label>
                    <input type="radio" id="oui" name="test_eval" value="1">
              </div>
            </div>

            <div class="mb-3 row">
              <label for="groupe" class="col-md-3 form-label mb-2"><b>Groupe : </b></label>
              <div class="col-md-3">
                <select name="groupe" id="groupe" class="form-control" required>
                  <option value="">Choisir le groupe</option>
                   <?php foreach($res_groupe as $mat){ ?>
                      <option value="<?php echo $mat['idGroupe'] ?>"><?php echo $mat['nomGroupe']; ?></option>
                    <?php } ?>  
                </select>
              </div>
            </div>
            <div class="text-center">
              <button type="submit" class="btn btn-primary">Ajouter</button>
            </div>
          </form>               
        </div>
    </div>
</div>
<!-- /.container-fluid -->


<script>
  $(function(){

    $('#subject').on('change',function() {
       id_mat = $('#subject option:selected').val();
       alert(id_mat);
      $.ajax({
        url: 'getgroupe.php',
        method: 'post',
        data: {id_mat: id_mat},
        dataType: 'json',
        success: function(response){
          alert("ok");
        //console.log(result);
        //var data = $.parseJSON(responce);

        var len = response.length;
        alert(response);

          $("#groupe").empty();
          $("#groupe").append("<option value=''><--select--></option>");
          for( var i = 0; i<len; i++){
              var id = response[i]['idGroupe'];
              var name = response[i]['nomGroupe'];
              //var stock = response[i]['piece_stock'];
              
              $("#groupe").append("<option value='"+id+"'>"+name+"</option>");

            console.log(i);
          }

        alert("okk");
        },
        error: function(xhr, status, error){
        //console.error(xhr);
        alert("ko");
        }
      });

    });    

  });


  function workWithResponse(result) {

    // jquery automatically converts the json into an object.
    // iterate through results and append to the target element

    $("#groupe option").remove();
    $('#groupe').append("<option value=''>Choisir le groupe</option>");
    $.each(result, function(key, value) {   
         $('#groupe')
             .append($("<option></option>")
                        .attr("value",key)
                        .text(value)); 
    });        
          }

</script>
<?php
include('includes/footer.php');
include('includes/scripts.php');
?>
