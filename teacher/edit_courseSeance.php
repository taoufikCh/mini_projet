<?php
session_start();
include('includes/header.php');
include('includes/navbar.php');
include('config/dbconn.php');

$id_ens=$_SESSION['auth_user']['codeuser'];


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
            <h6 class="m-0 font-weight-bold text-primary">Formulaire de modifier une séance du cours</h6>
        </div>
        
        <?php if(isset($_GET['failed'])){
                 echo '<div class="card bg-danger text-white shadow"><div class="card-body">'.$_GET['failed'].'</div></div>';
        } ?>
        <div class="card-body">
        <?php $id = $_GET['id_seance'];
                $query="SELECT * from coursesession WHERE id_seance='".$id."'";
                #$res=mysqli_query($con, $query);

                $result = mysqli_query($con, $query);
                $row = mysqli_fetch_assoc($result);
                if ($row && $id_ens===$row['id_ens']) {
                ?>
        <form id="addUser" action="update_courceSeance.php?id_row=<?php echo $id ; ?>" method="post">
            <div class="mb-3 row">
                <label for="subject" class="col-md-3 form-label mb-3" style="color:#000"><b>Matière : </b></label>
                <div class="col-md-3">
                    <select name="subject" id="subject" class="form-control" required>
                    <option value="">Choisir une matière</option>
                        <?php foreach($res_mat as $mat){ ?>
                            <option value="<?php echo $mat['id_mat'] ?>" <?php if($mat['id_mat']===$row['id_matiere']) echo "selected"; ?> ><?php echo $mat['nom_mat']; ?></option>
                        <?php } ?>  
                    </select>
                </div>
                <label for="date_seance" class="col-md-3 form-label mb-2"><b>Date de la séance : </b></label>
                <div class="col-md-3">
                    <input type="date" class="form-control" id="date_seance" value="<?php echo $row['date_seance']; ?>" name="date_seance" required>
                </div>
            </div>
            <div class="mb-3 row">
              <label for="heure_debut" class="col-md-3 form-label mb-2"><b>Heure de début : </b></label>
              <div class="col-md-3">
                <input type="time" class="form-control" id="heure_debut" value="<?php echo $row['heure_debut']; ?>" name="heure_debut" >
              </div>
              <label for="heure_fin" class="col-md-3 form-label mb-2"><b>Heure de fin : </b></label>
              <div class="col-md-3">
                <input type="time" class="form-control" id="heure_fin" value="<?php echo $row['heure_fin']; ?>" name="heure_fin" required>
              </div>
            </div>
            <div class="mb-3 row">
              <label for="type_seance" class="col-md-3 form-label mb-2"><b>Type de la séance : </b></label>
              <div class="col-md-3">
                <select name="type_seance" id="type_seance" class="form-control" required>
                        <option value="1" <?php if($row['type_seance']==="1") echo "selected"; ?> >Cours</option>
                        <option value="2" <?php if($row['type_seance']==="2") echo "selected"; ?> >TP</option>
                    </select>
              </div>
              <label for="non" class="col-md-3 form-label mb-2"><b>Test d'évaluation : </b></label>
              <div class="col-md-3">
                    <label for="non">Non</label>
                    <input type="radio" id="non" name="test_eval" value="0" <?php if($row['test_evaluation']==="0") echo "checked"; ?> > &emsp;&emsp;
                    <label for="oui">Oui</label>
                    <input type="radio" id="oui" name="test_eval" value="1" <?php if($row['test_evaluation']==="1") echo "checked"; ?>>
              </div>
            </div>
            <?php $query_groupe="SELECT groupe.*, subject_groupe.* from groupe 
                                LEFT JOIN subject_groupe ON groupe.idGroupe = subject_groupe.idGroupe 
                                WHERE subject_groupe.IdMatiere='".$row['id_matiere']."'"; 
                                    $res_groupe=mysqli_query($con, $query_groupe); ?>
            <div class="mb-3 row">
              <label for="groupe" class="col-md-3 form-label mb-2"><b>Groupe : </b></label>
              <div class="col-md-3">
                <select name="groupe" id="groupe" class="form-control" required>
                  <option value="">Choisir le groupe</option>
                  <?php foreach($res_groupe as $gr){ ?>
                      <option value="<?php echo $gr['idGroupe'] ?>" <?php if($gr['idGroupe']===$row['id_groupe']) echo "selected"; ?> ><?php echo $gr['nomGroupe']; ?></option>
                    <?php } ?>
                </select>
              </div>
            </div>
            <div class="text-center">
              <button type="submit" class="btn btn-primary">Mettre à jour</button>
            </div>
          </form>  
          <?php } else{
              echo "page introuvable";
          }             ?>             
        </div>
    </div>
</div>
<!-- /.container-fluid -->


<script>
  $(function(){
    

    $('#subject').on('change',function() {
       id_mat = $('#subject option:selected').val();
       //alert(id_mat);
      $.ajax({
        url: 'getgroupe.php',
        method: 'post',
        data: {id_mat: id_mat},
        //dataType: 'json',
        success: function(response){

        response = JSON.parse(response);
        //console.log(response);

        var len = response.length;
        
        //console.log("len="+len);

          $("#groupe").empty();
          $("#groupe").append("<option value=''>Choisir le groupe</option>");
          for( var i = 0; i<len; i++){
              var id = response[i]['idGroupe'];
              var name = response[i]['nomGroupe'];
             //console.log("nomGroupe:" + name + "id = "+id);
              $("#groupe").append("<option value='"+id+"'>"+name+"</option>");

            //console.log("i="+i);
          }

        },
        error: function(xhr, status, error){
        //console.error(xhr);
        alert("ko");
        }
      });

    });    

  });


</script>
<?php
include('includes/footer.php');
include('includes/scripts.php');
?>
