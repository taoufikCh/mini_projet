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
            <h6 class="m-0 font-weight-bold text-primary">Formulaire d'ajouter un enseignant</h6>
        </div>
        
        <?php if(isset($_GET['failed'])){
                 echo '<div class="card bg-danger text-white shadow"><div class="card-body">'.$_GET['failed'].'</div></div>';
        } ?>
        <div class="card-body">

        <form id="addUser" action="save_teacher.php" method="post">
            <div class="mb-3 row">
              <label for="firstname" class="col-md-3 form-label">Prénom : </label>
              <div class="col-md-9">
                <input type="text" class="form-control" id="firstname" name="firstname" required>
              </div>
            </div>
            <div class="mb-3 row">
              <label for="lastname" class="col-md-3 form-label">Nom : </label>
              <div class="col-md-9">
                <input type="text" class="form-control" id="lastname" name="lastname" required>
              </div>
            </div>
            <div class="mb-3 row">
              <label for="birthday" class="col-md-3 form-label">Date de naissance : </label>
              <div class="col-md-9">
                <input type="date" class="form-control" id="birthday" name="birthday" min="1950-01-01" max="<?= date('Y-m-d'); ?>">
              </div>
            </div>
            <div class="mb-3 row">
              <label for="email" class="col-md-3 form-label">Adresse Email : </label>
              <div class="col-md-9">
                <input type="email" class="form-control" id="email" name="email" required>
              </div>
            </div>
            <div class="mb-3 row">
              <label for="date_embauche" class="col-md-3 form-label">Date embauche : </label>
              <div class="col-md-9">
                <input type="date" class="form-control" id="date_embauche" name="date_embauche" min="1975-01-01" max="<?= date('Y-m-d'); ?>" required>
              </div>
            </div>
            <div class="mb-3 row">
              <label for="grade" class="col-md-3 form-label">Grade : </label>
              <div class="col-md-9">
                <input type="text" class="form-control" id="grade" name="grade" required>
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
