<?php

session_start();
include('includes/header.php');
include('includes/navbar.php');

include('config/dbconn.php');

////
$id_student = $_SESSION['auth_user']['codeuser'];

$query="SELECT groupe from etudiant WHERE numEtd = '$id_student'";
$res_groupe = mysqli_query($con, $query) or die (mysqli_error($con));
$row = mysqli_fetch_assoc($res_groupe);

$id_groupe = $row['groupe'];

$sql_subject="SELECT subject_groupe.*, matieres.* from subject_groupe
LEFT JOIN matieres ON subject_groupe.IdMatiere = matieres.id_mat WHERE subject_groupe.idGroupe='".$id_groupe."'";
$res=mysqli_query($con, $sql_subject);
 
?>

 <!-- Begin Page Content -->
 <div class="container-fluid">
    <!-- Page Heading -->
   
        <!-- Ajout -->
        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Statistique des seances du cours de chaque matière</h6>
                            </div>
                           
                            <div class="card-body">
                                <form id="" action="statistics_details.php" method="post"> 
                                    <label for="subject" class="col-md-4 form-label" style="color:#000"><b>Choisir une matière : </b></label>
                                    <div class="col-md-4">
                                        <select name="subject" id="subject" class="form-control" required>
                                            <option value=""><--Choisir--></option>
                                            <?php foreach($res as $mat){ ?>
                                                <option value="<?php echo $mat['id_mat'] ?>"><?php echo $mat['nom_mat']; ?></option>
                                            <?php } ?>  
                                        </select>
                                    </div>
                                    <br>
                                    <div class="text-center col-md-4">
                                        <button type="submit" class="btn btn-danger">Afficher</button>
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

      $.ajax({
        url: 'getgroupe.php',
        method: 'post',
        data: {id_mat: id_mat},
        success: function(response){

            response = JSON.parse(response);
            var len = response.length;

            $("#groupe").empty();
            $("#groupe").append("<option value=''>Choisir le groupe</option>");
            for( var i = 0; i<len; i++){
                var id = response[i]['idGroupe'];
                var name = response[i]['nomGroupe'];
                $("#groupe").append("<option value='"+id+"'>"+name+"</option>");
            }
        },
        error: function(xhr, status, error){
            console.error(xhr);
            //alert("ko");
        }
      });

    });    

  });

</script>
<?php
include('includes/footer.php');
include('includes/scripts.php');
?>

