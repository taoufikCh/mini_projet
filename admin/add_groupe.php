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
            <h6 class="m-0 font-weight-bold text-primary">Formulaire d'ajouter un groupe</h6>
        </div>
        
        <?php if(isset($_GET['failed'])){
                 echo '<div class="card bg-danger text-white shadow"><div class="card-body">'.$_GET['failed'].'</div></div>';
        } ?>
        <div class="card-body">

        <form id="add" action="save_groupe.php" method="post">
            <div class="mb-3 row">
              <label for="nomGroupe" class="col-md-3 form-label">Nom de groupe : </label>
              <div class="col-md-9">
                <input type="text" class="form-control" id="nomGroupe" name="nomGroupe" required>
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
