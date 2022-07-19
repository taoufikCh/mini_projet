<?php
session_start();
include('includes/header.php');
include('includes/navbar.php');

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
            <h6 class="m-0 font-weight-bold text-primary">Formulaire d'ajouter une matière</h6>
        </div>
        <div class="card-body">

        <?php if(isset($_GET['status'])){
            echo '<div class="card bg-info text-white shadow"><div class="card-body">'.$_GET['status'].'</div></div>';
        } ?>
        <form id="addUser" action="save_matiere.php" method="post">
            <div class="mb-3 row">
              <label for="name_subject" class="col-md-3 form-label">Nom de la matière : </label>
              <div class="col-md-9">
                <input type="text" class="form-control" id="name_subject" name="name" required>
              </div>
            </div>
            <div class="mb-3 row">
              <label for="coefficient" class="col-md-3 form-label">Coefficient : </label>
              <div class="col-md-9">
                <input type="number" class="form-control" required id="coefficient" name="coefficient" min="1" max="5">
              </div>
            </div>
            <div class="mb-3 row">
              <label for="hours_cours" class="col-md-3 form-label">Nombre d'heures de cours : </label>
              <div class="col-md-9">
                <input type="number" class="form-control" id="hours_cours" name="hours_cours" min="0" required>
              </div>
            </div>
            <div class="mb-3 row">
              <label for="hours_tp" class="col-md-3 form-label">Nombres d'heures de TP : </label>
              <div class="col-md-9">
                <input type="number" class="form-control" id="hours_tp" name="hours_tp" min="0" required>
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



<?php
include('includes/footer.php');
include('includes/scripts.php');
?>
