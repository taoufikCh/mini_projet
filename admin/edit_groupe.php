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
            <h6 class="m-0 font-weight-bold text-primary">Formulaire de modification un groupe</h6>
        </div>
        <?php if(isset($_GET['failed'])){
                 echo '<div class="card bg-danger text-white shadow"><div class="card-body">'.$_GET['failed'].'</div></div>';
        } ?>
        <div class="card-body">

        <?php 

                $id = $_GET['id_row'];
                $query="SELECT * from groupe WHERE idGroupe='".$id."'";
                #$res=mysqli_query($con, $query);

                $result = mysqli_query($con, $query) or die ( mysqli_error());
                $row = mysqli_fetch_assoc($result);
                if ($row) {
                ?>
        <form id="edit" action="update_groupe.php?id_row=<?php echo $id ; ?>" method="post">
        <div class="mb-3 row">
              <label for="nomGroupe" class="col-md-3 form-label">Nom de groupe : </label>
              <div class="col-md-9">
                <input type="text" class="form-control" id="nomGroupe" name="nomGroupe" value="<?php echo $row['nomGroupe']; ?>" required>
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
