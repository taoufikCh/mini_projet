<?php
session_start();
include('includes/header.php');
include('includes/navbar.php');

include('config/dbconn.php');
$id=$_GET['id_seance'];

$id_ens=$_SESSION['auth_user']['codeuser'];

//$sql_info_course="SELECT * from coursesession WHERE id_seance='".$id."'";
$query_course="SELECT coursesession.*, matieres.nom_mat, groupe.nomGroupe from coursesession
LEFT JOIN matieres ON coursesession.id_matiere = matieres.id_mat
LEFT JOIN groupe ON coursesession.id_groupe = groupe.idGroupe  WHERE coursesession.id_seance='".$id."' and id_ens='".$id_ens."'";

//$row = mysqli_fetch_assoc($con, $res_course);

$res_course = mysqli_query($con, $query_course) or die (mysqli_error($con));
$row = mysqli_fetch_assoc($res_course);

if($row['status_abs']==="0"){
    $date_course = new DateTime($row['date_seance'].' '.$row['heure_fin']) ;
    $now = new DateTime("now");
    if($date_course <= $now) {
        $sql="SELECT * from etudiant WHERE groupe='".$row['id_groupe']."'";
        $students=mysqli_query($con, $sql);
        foreach($students as $data){
            $id_course = $row['id_seance'];
            $id_etudiant = $data['numEtd'];
            $sql_insert = "INSERT INTO `assiduite`(`id_course`, `id_etudiant`) VALUES ('$id_course', '$id_etudiant')";
            $query= mysqli_query($con,$sql_insert);
        }
        $update = "UPDATE `coursesession` SET status_abs='1' WHERE id_seance='$id_course'"; 
        $sql2=mysqli_query($con,$update);
    } 
}
/*else{
    
    $sql="SELECT * from etudiant WHERE groupe='".$row['id_groupe']."'";
    $students=mysqli_query($con, $sql);
    foreach($students as $data){
        $id_course = $row['id_seance'];
        $id_etudiant = $data['numEtd'];
        $sql_insert = "INSERT INTO `assiduite`(`id_course`, `id_etudiant`) VALUES ('$id_course', '$id_etudiant')";
            $query= mysqli_query($con,$sql_insert);
    }
} */

$query_assid="SELECT assiduite.*, etudiant.* from assiduite
LEFT JOIN etudiant ON assiduite.id_etudiant = etudiant.numEtd WHERE assiduite.id_course='".$id."'";
$res_assuiduite=mysqli_query($con, $query_assid);
    
?>

 <!-- Begin Page Content -->
 <div class="container-fluid">
    <!-- Page Heading -->

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Information sur la séance du cours</h6>
        </div>
        <?php if(isset($_GET['success'])){
                echo '<div class="card bg-success text-white shadow"><div class="card-body">'.$_GET['success'].'</div></div>';
               } ?>
                        <?php if(isset($_GET['failed'])){
                                echo '<div class="card bg-danger text-white shadow"><div class="card-body">'.$_GET['failed'].'</div></div>';
                        } ?>
        <div class="card-body">
            <?php if($id_ens===$row['id_ens']){ ?>
                <div style="color:#000">
                    <table class="table"  width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Matière</th>
                                <th>Type</th>
                                <th>Date</th>
                                <th>Heure début</th>
                                <th>Heure fin</th>
                                <th>Groupe</th>
                                <th>Test </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr style="background-color:#fddddd">
                                <td><?php echo $row['nom_mat']; ?></td>
                                <td>
                                    <?php if($row['type_seance']=="1") echo "Cours";
                                        if($row['type_seance']=="2") echo "TP";  ?>
                                </td>
                                <td><?php echo $row['date_seance']; ?></td>
                                <td><?php echo $row['heure_debut']; ?></td>
                                <td><?php echo $row['heure_fin']; ?></td>
                                <td><?php echo $row['nomGroupe']; ?></td>
                                <td>
                                    <?php if($row['test_evaluation']=="0") echo "Non";
                                        if($row['test_evaluation']=="1") echo "Oui";  ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div> 
            
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Suivi Absences</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nom</th>
                                        <th>Prénom</th>
                                        <th>Absence</th>
                                        <th>Note Test</th>
                                    </tr>
                                </thead>
                            <tbody>
                                <?php foreach($res_assuiduite as $data){ ?>
                                    <tr>
                                        <td><?php echo $data['numEtd']; ?></td>
                                        <td><?php echo $data['nomEtd']; ?></td>
                                        <td><?php echo $data['prenomEtd']; ?></td>
                                        <td><input type="checkbox" id="sltAbs<?php echo $data['id_assiduite']; ?>" onchange="updateAbsence(<?php echo $data['id_assiduite']; ?>)" <?php if($data['isAbsent']==="1") echo "checked" ?> > </td>
                                        <td><?php if($row['test_evaluation']=="1"){?>
                                            <input type="number"  min="0" max="20.00" pattern="^\d+(?:\.\d{1,2})?$" step="0.01"  value="<?php echo $data['note_test']; ?>"  id="note_test<?php echo $data['id_assiduite']; ?>" onchange="ValidationNote(<?php echo $data['id_assiduite']; ?>)"  onkeyup="ValidationNote(<?php echo $data['id_assiduite']; ?>)"> 
                                            <a style="display: none" id="dvBtn<?php echo $data['id_assiduite']; ?>" href="#" class="btn btn-success btn-circle btn-sm" onClick="updateNote(<?php echo $data['id_assiduite']; ?>)">
                                                <i class="fas fa-check"></i>
                                            </a>
                                            
                                            <?php } ?> 
                                        </td>
                                    </tr>                                        
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php } 
                    else {
                            echo '<div class="card bg-danger text-white shadow"><div class="card-body">Accès interdit</div></div>';
                    } ?>
            </div>
        </div>
    </div>
</div>

<script>
    function updateAbsence(id){
        //alert(id);
        var getStatus = $("#sltAbs"+id).is(":checked");
        //alert(test);
        var isAbsent=0;
        if(getStatus) isAbsent=1;
        //alert(isAbsent);

        $.ajax({
        url: 'updateStatusAbsent.php',
        method: 'post',
        data: {id: id, absent: isAbsent},
        success: function(response){
            if(response){
                //alert('ok');
                $("#note_test"+id).val('0');
                tata['success']("Success", "La mise à jour a été effectuée avec succès", {
                    
                    duration: 3000,
                    position: 'tr',
                    progress: true,
                    holding: $('input[name=holding]').checked,
                    animate: 'fade',
                    closeBtn: true,
                })
            }
            else{ 
                tata['error']("Echec", "La mise à jour est échoué", {
                    
                    duration: 3000,
                    position: 'tr',
                    progress: true,
                    holding: $('input[name=holding]').checked,
                    animate: 'fade',
                    closeBtn: true,
                })
            }
        },
        error: function(xhr, status, error){
        //console.error(xhr);
        alert("ko");
        }
      });
    }
    function ValidationNote(id){
        
        var note = parseFloat($("#note_test"+id).val());
        
        $('#dvBtn'+id).show();
        //if(note===""){
          //  $("#note_test"+id).val(0);
        //}
        if(note<0){
            $("#note_test"+id).val(0);
        }
        else if(note>20){
            $("#note_test"+id).val(20);
        }
        else {
            //$("#note_test"+id).val(note.toFixed(2));
           
        }
         
    }
   
    
    function updateNote(id){
        console.log(id);
        var note = parseFloat($("#note_test"+id).val());
        console.log(note);
        note = note.toFixed(2);
        console.log(note);

        $.ajax({
        url: 'updateNoteTest.php',
        method: 'post',
        data: {id: id, note: note},
        success: function(response){

            console.log("response "+response);
            if(response){
                //alert('ok');

                

                tata['success']("Success", "La mise à jour a été effectuée avec succès", {
                    
                    duration: 3000,
                    position: 'tr',
                    progress: true,
                    holding: $('input[name=holding]').checked,
                    animate: 'fade',
                    closeBtn: true,
                })
                $('#dvBtn'+id).hide();
                $("#note_test"+id).val(note);
                
            }
            else{ 
                tata['error']("Echec", "La mise à jour est échoué", {
                    
                    duration: 3000,
                    position: 'tr',
                    progress: true,
                    holding: $('input[name=holding]').checked,
                    animate: 'fade',
                    closeBtn: true,
                })
            }
        },
        error: function(xhr, status, error){
        //console.error(xhr);
        alert("ko");
        }
      });
    }
  
</script>
<?php
include('includes/footer.php');
include('includes/scripts.php');
?>
