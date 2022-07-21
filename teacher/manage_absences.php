<?php
session_start();
include('includes/header.php');
include('includes/navbar.php');

include('config/dbconn.php');

$query_mat="SELECT * from matieres";
$res_mat=mysqli_query($con, $query_mat);

$sql_info_course="SELECT * from coursesession WHERE id_seance='".$id."'";
$res_course = mysqli_query($con, $sql_info_course);
$row = mysqli_fetch_assoc($result);

if($row['status_abs']==="0" && $row['date_seance'] <= '' && $row['heure_fin'] <= ''){
    $sql="SELECT * from etudiant WHERE groupe='".$row['id_groupe']."'";
    $students=mysqli_query($con, $sql);
    foreach($students as $data){
        $sql = "INSERT INTO `matieres`( `nom_mat`, `coefMat`, `NbreHeureCours`, `NbreHeureTP`) VALUES 
        ('$name', '$coef', '$cours', '$tp' )";
        $query= mysqli_query($con,$sql);
    }
}


$id=$_GET['id_seance'];

$query="SELECT coursesession.*, matieres.nom_mat, groupe. from coursesession
LEFT JOIN matieres ON coursesession.IdMatiere = matieres.id_mat WHERE subject_groupe.idGroupe='".$id."'";
$res=mysqli_query($con, $query);

$sql_info_course="SELECT * from coursesession WHERE id_seance='".$id."'";
$res_course = mysqli_query($con, $sql_info_course);
$row = mysqli_fetch_assoc($result);

$sql_groupe="SELECT * from groupe WHERE idGroupe='".$row['id_groupe']."'";
$res_groupe = mysqli_query($con, $sql_groupe) or die ( mysqli_error());
$groupe = mysqli_fetch_assoc($res_groupe);

$sql="SELECT * from etudiant WHERE groupe='".$row['id_groupe']."'";
$students=mysqli_query($con, $sql);
 
?>

 <!-- Begin Page Content -->
 <div class="container-fluid">
    <!-- Page Heading -->

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Suivi Absences</h6>
        </div>
        <?php if(isset($_GET['success'])){
                echo '<div class="card bg-success text-white shadow"><div class="card-body">'.$_GET['success'].'</div></div>';
               } ?>
                        <?php if(isset($_GET['failed'])){
                                echo '<div class="card bg-danger text-white shadow"><div class="card-body">'.$_GET['failed'].'</div></div>';
                        } ?>
        <div class="card-body">
            <div style="background-color:#fddddd">
                <h5>Information sur la séance du cours</h5>
                <div class="mb-3 row">
                <label class="col-md-3 form-label">Nom du groupe : </label>
                <div class="col-md-3"><?php echo $data['nomGroupe']; ?></div>
                <label class="col-md-3 form-label">Date de création : </label>
                <div class="col-md-3"><?php echo $data['dateCreation']; ?></div>
                </div>  
            </div>
            <div style="color:#000">
                <b>Information sur l'enseignant</b><br>
                <table class="table"  width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Prénom</th>
                            <th>Nom</th>
                            <th>Date naissance</th>
                            <th>Email</th>
                            <th>Date Embauche</th>
                            <th>Grade</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr style="background-color:#fddddd">
                            <td><?php echo $data['prenom']; ?></td>
                            <td><?php echo $data['nom']; ?></td>
                            <td><?php echo $data['dateNaissance']; ?></td>
                            <td><?php echo $data['adresseMail']; ?></td>
                            <td><?php echo $data['dateEmbauche']; ?></td>
                            <td><?php echo $data['grade']; ?></td>
                        </tr>
                    </tbody>
                </table>
            </div> 
            <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Les matières</h6>
                            </div>
                           
                            <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Matière</th>
                                            <th>Operations</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 0;
                                        foreach($res as $data){
                                            $i++; ?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $data['nom_mat']; ?></td>
                                            <td>
                                                <a href="" data-target="#modal_delete<?php echo $data['idSG']?>" data-toggle="modal" class="icon-lg text-danger ">
                                                    <i class="fas fa-trash"></i>
                                                </a>    
                                            </td>
                                        </tr>                                        
                                        <div class="modal fade" id="modal_delete<?php echo $data['idSG']?>" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Suppression d'une matière</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <b><span class="text-danger">Souhaitez -vous supprimer cette affectation!</span></b>
                                                </div>
                                                <div class="modal-footer">
                                                    <a type="button" class="btn btn-danger" href="delete_subject_groupe.php?id_sub=<?php echo $data['idSG']?>&id_groupe=<?php echo $id?>">Supprimer</a>
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                                                    
                                                </div>
                                                </div>
                                            </div>
                                            </div>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            </div>
                        </div>
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Les étudiants du groupe</h6>
                            </div>
                            
                            <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Prénom</th>
                                            <th>Nom</th>
                                            <th>Email</th>
                                            <th>Num Inscription</th>
                                            <th>Date Inscription</th>
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                        <?php foreach($student as $data){ ?>
                                        <tr>
                                            <td><?php echo $data['numEtd']; ?></td>
                                            <td><?php echo $data['prenomEtd']; ?></td>
                                            <td><?php echo $data['nomEtd']; ?></td>
                                            <td><?php echo $data['adresseMailEtd']; ?></td>
                                            <td><?php echo $data['numInscription']; ?></td>
                                            <td><?php echo $data['dateInscription']; ?></td>
                                        </tr>                                        
                                        
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            </div>
                        </div>
                       
                            
                            
                        </div>
                    </div>
</div>
<!-- /.container-fluid -->
<div class="modal fade" id="modal_add" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
           <div class="modal-header">
                    <h5 class="modal-title">Affecter une matière à un groupe</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                     </button>
                   </div>
                   <form id="" action="save_subject_groupe.php" method="post"> 
                     <div class="modal-body">
                     
                            <input type="hidden"  id="id_groupe" name="id_groupe" value="<?php echo $id; ?>" required>
                            <div class="mb-4 row">
                            <label for="subject" class="col-md-4 form-label" style="color:#000"><b>Choisir une matière : </b></label>
                            <div class="col-md-8">
                                <select name="subject" id="subject" class="form-control" required>
                                    <option value=""><--Choisir--></option>
                                    <?php foreach($res_mat as $mat){ ?>
                                        <option value="<?php echo $mat['id_mat'] ?>"><?php echo $mat['nom_mat']; ?></option>
                                <?php } ?>  
                                </select>
                            </div>
                            </div>
            
           
                    </div>
                   <div class="modal-footer">
                   <button type="submit" class="btn btn-danger">Affecter</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                                                    
                </div>
            </div>
        </form> 
    </div>
</div>

<?php
include('includes/footer.php');
include('includes/scripts.php');
?>
