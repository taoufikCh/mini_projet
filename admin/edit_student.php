<?php
session_start();
include('includes/header.php');
include('includes/navbar.php');

include('config/dbconn.php');
$query_groupe="SELECT * from groupe";
$res_groupe=mysqli_query($con, $query_groupe);

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
            <h6 class="m-0 font-weight-bold text-primary">Formulaire de modification un étudiant</h6>
        </div>
        <?php if(isset($_GET['failed'])){
                 echo '<div class="card bg-danger text-white shadow"><div class="card-body">'.$_GET['failed'].'</div></div>';
        } ?>
        <div class="card-body">

        <?php 

                $id = $_GET['id_student'];
                $query="SELECT * from etudiant WHERE numEtd='".$id."'";
                #$res=mysqli_query($con, $query);

                $result = mysqli_query($con, $query) or die ( mysqli_error());
                $row = mysqli_fetch_assoc($result);
                if ($row) {
                ?>
        <form id="edit" action="update_student.php?id_student=<?php echo $id ; ?>" method="post">
            <div class="mb-3 row">
              <label for="firstname" class="col-md-3 form-label">Prénom : </label>
              <div class="col-md-9">
                <input type="text" class="form-control" id="firstname" name="firstname" value="<?php echo $row['prenomEtd']; ?>" required>
              </div>
            </div>
            <div class="mb-3 row">
              <label for="lastname" class="col-md-3 form-label">Nom : </label>
              <div class="col-md-9">
                <input type="text" class="form-control" id="lastname" name="lastname" value="<?php echo $row['nomEtd']; ?>" required>
              </div>
            </div>
            <div class="mb-3 row">
              <label for="birthday" class="col-md-3 form-label">Date de naissance : </label>
              <div class="col-md-9">
                <input type="date" class="form-control" id="birthday" name="birthday" value="<?php echo $row['DateNaissanceEtd']; ?>" min="1950-01-01" max="<?= date('Y-m-d'); ?>">
              </div>
            </div>
            <div class="mb-3 row">
              <label for="email" class="col-md-3 form-label">Adresse Email : </label>
              <div class="col-md-9">
                <input type="email" class="form-control" id="email" name="email" value="<?php echo $row['adresseMailEtd']; ?>" required>
              </div>
            </div>
            <div class="mb-3 row">
              <label for="num_inscrit" class="col-md-3 form-label">Numéro d'inscription : </label>
              <div class="col-md-9">
                <input type="text" class="form-control" id="num_inscrit" name="num_inscrit" value="<?php echo $row['numInscription']; ?>" required>
              </div>
            </div>
            <div class="mb-3 row">
              <label for="date_inscrit" class="col-md-3 form-label">Date d'inscription : </label>
              <div class="col-md-9">
                <input type="date" class="form-control" id="date_inscrit" name="date_inscrit" value="<?php echo $row['dateInscription']; ?>" required>
              </div>
            </div>
            <div class="mb-3 row">
              <label for="groupe" class="col-md-3 form-label">Groupe : </label>
              <div class="col-md-9">
                <select name="groupe" id="groupe" class="form-control">
                  <option value=""><--Choisir--></option>
                   <?php foreach($res_groupe as $gr){ ?>
                      <option value="<?php echo $gr['idGroupe'] ?>" <?php if($gr['idGroupe']===$row['groupe']) echo "selected"; ?> ><?php echo $gr['nomGroupe']; ?></option>
                    <?php } ?>  
                </select>
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
