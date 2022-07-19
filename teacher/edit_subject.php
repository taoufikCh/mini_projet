<?php
session_start();
include('includes/header.php');
include('includes/navbar.php');

include('config/dbconn.php');


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
            <h6 class="m-0 font-weight-bold text-primary">Formulaire de modification une matière</h6>
        </div>
        <div class="card-body">
        <?php if(isset($_GET['status'])){
            echo '<div class="card bg-info text-white shadow"><div class="card-body">'.$_GET['status'].'</div></div>';
        } ?>
        <?php 

                $id = $_GET['id_subject'];
                $query="SELECT * from matieres WHERE id_mat='".$id."'";
                #$res=mysqli_query($con, $query);

                $result = mysqli_query($con, $query) or die ( mysqli_error());
                $row = mysqli_fetch_assoc($result);
                if ($row) {
                ?>
        <form id="editSubject" action="update_subject.php?id_subject=<?php echo $id ; ?>" method="post">
            <div class="mb-3 row">
              <label for="name_subject" class="col-md-3 form-label">Nom de la matière : </label>
              <div class="col-md-9">
                <input type="text" class="form-control" id="name_subject" name="name" value="<?php echo $row['nom_mat']; ?>">
              </div>
            </div>
            <div class="mb-3 row">
              <label for="coefficient" class="col-md-3 form-label">Coefficient : </label>
              <div class="col-md-9">
                <input type="number" class="form-control" min="1" max="5" id="coefficient" name="coefficient" value="<?php echo $row['coefMat']; ?>" required>
              </div>
            </div>
            <div class="mb-3 row">
              <label for="hours_cours" class="col-md-3 form-label">Nombre d'heures de cours : </label>
              <div class="col-md-9">
                <input type="number" class="form-control" id="hours_cours" min="0" name="hours_cours" value="<?php echo $row['NbreHeureCours']; ?>" required>
              </div>
            </div>
            <div class="mb-3 row">
              <label for="hours_tp" class="col-md-3 form-label">Nombres d'heures de TP : </label>
              <div class="col-md-9">
                <input type="number" class="form-control" min="0" id="hours_tp" name="hours_tp" value="<?php echo $row['NbreHeureTP']; ?>" required>
              </div>
            </div>
            <div class="text-center">
              <button type="submit" class="btn btn-success">Mettre à jour</button>
            </div>
          </form>  
          <?php } else{
              echo "page introuvable";
          }             ?>
        </div>
    </div>
</div>
<!-- /.container-fluid -->



<?php
include('includes/footer.php');
include('includes/scripts.php');
?>
