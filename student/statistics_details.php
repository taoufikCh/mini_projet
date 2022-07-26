<?php
session_start();
include('includes/header.php');
include('includes/navbar.php');

include('config/dbconn.php');

$id_subject = $_POST['subject'];
$id_student = $_SESSION['auth_user']['codeuser'];

$query="SELECT groupe from etudiant WHERE numEtd = '$id_student'";
$res_groupe = mysqli_query($con, $query) or die (mysqli_error($con));
$row = mysqli_fetch_assoc($res_groupe);

$id_groupe = $row['groupe'];

$sql_subject="SELECT subject_groupe.*, matieres.* from subject_groupe
LEFT JOIN matieres ON subject_groupe.IdMatiere = matieres.id_mat WHERE subject_groupe.idGroupe='".$id_groupe."'";
$res_subject=mysqli_query($con, $sql_subject);
/////
$query_mat="SELECT * from matieres where id_mat='".$id_subject."'";
$res_mat=mysqli_query($con, $query_mat);
$data_mat = mysqli_fetch_assoc($res_mat);

$query_gr="SELECT * from groupe WHERE idGroupe='".$id_groupe."'";
$res_gr = mysqli_query($con, $query_gr) or die ( mysqli_error());
$data_gr = mysqli_fetch_assoc($res_gr);

$query_course = "SELECT * from coursesession 
     where id_matiere='".$id_subject."' and id_groupe='".$id_groupe."' ";
$res = mysqli_query($con, $query_course);

$heure_cours = 0;
$heure_tp = 0;
$nbr_test = 0;
$list_id = array();;
foreach($res as $info){
    $heure_debut = strtotime($info['date_seance']." ".$info['heure_debut']);
    $heure_fin = strtotime($info['date_seance']." ".$info['heure_fin']);
    $totalSecondsDiff = abs($heure_debut-$heure_fin); // en seconde
    $totalHoursDiff   = $totalSecondsDiff/3600; // en hours
    if($info['type_seance']==="1") $heure_cours+= $totalHoursDiff;
    else $heure_tp+= $totalHoursDiff;

    if($info['test_evaluation']==="1") {
        $nbr_test+=1;   
    }
    $list_id[] = $info['id_seance']; 

    $query_assiduite="SELECT * from assiduite WHERE id_course= '".$info['id_seance']."'";
    $res_assiduite=mysqli_query($con, $query_assiduite);
    $exist = false;
    foreach($res_assiduite as $assiduite){
        if($id_student===$assiduite['id_etudiant'])
        {
                $exist = true;
        }
    }
    if(!$exist){
        $id_course = $info['id_seance'];
        $id_etudiant = $id_student;
        $sql_insert = "INSERT INTO `assiduite`(`id_course`, `id_etudiant`) VALUES ('$id_course', '$id_etudiant')";
        $query= mysqli_query($con,$sql_insert);
    }
}

$query_assiduite="SELECT assiduite.* , coursesession.* from assiduite
LEFT JOIN coursesession ON assiduite.id_course = coursesession.id_seance WHERE assiduite.id_etudiant= '$id_student' and assiduite.id_course IN (" . implode(',', array_map('intval', $list_id)) . ")";
$res_assiduite=mysqli_query($con, $query_assiduite);

//$len = mysqli_num_rows($res_assiduite);

//echo "nbr student " .$nbr_student;  COUNT ( DISTINCT id_etudiant ) AS nbr_student 
?>
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.0.0/dist/chart.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
 <!-- Begin Page Content -->
 <div class="container-fluid">
    <!-- Page Heading -->

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Statistique sur une matière par groupe</h6>
        </div>
        <div class="card-body" >
            <div style="background-color:#d8e0e7; padding-left:20px; padding-top:10px; border-radius:10px">
                <div class="mb-3 row">
                    <label class="col-md-4 form-label font-weight-bold text-danger">Nom de la matière : </label>
                    <div class="col-md-3"><label class="form-label font-weight-bold "><?php echo $data_mat['nom_mat']; ?></label></div>
                </div>
                <div class="mb-3 row">
                    <label class="col-md-4 form-label font-weight-bold text-danger">Nom du groupe : </label>
                    <div class="col-md-3"><label class="form-label font-weight-bold "><?php echo $data_gr['nomGroupe']; ?></label></div>
                </div>
                <div class="mb-3 row">
                    <label class="col-md-4 form-label font-weight-bold text-danger">Nombre d'heures de cours réalisées : </label>
                    <div class="col-md-3"><label class="form-label font-weight-bold "><?php echo $heure_cours."/".$data_mat['NbreHeureCours']; ?></label></div>
                </div> 
                <div class="mb-3 row">
                    <label class="col-md-4 form-label font-weight-bold text-danger">Nombre d'heures de TP réalisées : </label>
                    <div class="col-md-3"><label class="form-label font-weight-bold "><?php echo $heure_tp."/".$data_mat['NbreHeureTP']; ?></label></div>
                </div>  
                <div class="mb-3 row">
                    <label class="col-md-4 form-label font-weight-bold text-danger">Nombre de Test d'évaluation réalisés : </label>
                    <div class="col-md-3"><label class="form-label font-weight-bold "><?php echo $nbr_test; ?></label></div>
                </div> 
            </div>
        </div>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Suivi absences et notes </h6>
        </div>
        <div class="card-body" >
           <?php $nbr_abs = 0;
           $sup_10 = 0;
           ?>
           <table class="table"  width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Date de la séances</th>
                        <th>Heure début</th>
                        <th>Heure Fin</th>
                        <th>Type</th>
                        <th>Test d'évaluat°</th>
                        <th>Absence</th>
                        <th>Note</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    if($res_assiduite){
                        $nbr_absence = 0;
                        $nbr_present = 0;

                        foreach($res_assiduite as $assiduite){
                            if($assiduite['isAbsent']==="1"){
                                $nbr_absence+=1;
                            }
                            else{
                                $nbr_present+=1;
                            } 
                            
                            ?>
                            <tr>
                                <td><?php echo $assiduite['date_seance']; ?></td>
                                <td><?php echo $assiduite['heure_debut']; ?></td>
                                <td><?php echo $assiduite['heure_fin']; ?></td>
                                <td>
                                    <?php if($assiduite['type_seance']=="1") echo "Cours";
                                        if($assiduite['type_seance']=="2") echo "TP";  ?>
                                </td>
                                <td>
                                    <?php if($assiduite['test_evaluation']=="0") echo "Non";
                                        if($assiduite['test_evaluation']=="1") echo "Oui";  ?>
                                </td>
                                <td>
                                    <?php if($assiduite['isAbsent']=="0") echo "Non";
                                        if($assiduite['isAbsent']=="1") echo "Oui";  ?>
                                </td>
                                <td><?php echo $assiduite['note_test']; ?></td> 
                            </tr>
                    <?php } 
                    } else {}?>
                    
                </tbody>
            </table>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Taux d'absences en % de cette matière</h6>
        </div>
        <div class="card-body" >
            <div class="text-center col-md-12">
                 <center>
                    <div style="display: block; box-sizing: border-box; height: 350px; width: 350px; ">
                    <canvas id="Chart"></canvas>
                    </div>
                </center>
            </div>
        </div>
    <div>                      
</div>
</div>
</div>

<script>
    const data = {
    labels: [
        'OUI',
        'NON',
    ],
    datasets: [{
        label: 'My First Dataset',
        data: [<?php echo $nbr_absence.' , '.$nbr_present ; ?>],
        backgroundColor: [
        'rgb(237, 125, 49)',
        'rgb(91, 155, 213)',
        ],
        hoverOffset: 2
    }]
    };

    var options = {
           tooltips: {
         enabled: false
    },
             plugins: {
            datalabels: {
                formatter: (value, ctx) => {
                
                  let sum = 0;
                  let dataArr = ctx.chart.data.datasets[0].data;
                  dataArr.map(data => {
                      sum += data;
                  });
                  let percentage = (value*100 / sum).toFixed(2)+"%";
                  return percentage;

              
                },
                color: '#f12a4d',
                     }
        }
    };

    const config = {
        type: 'pie',
        data: data,
        options: {
            plugins : {
                tooltip:{
                    enabled: false
                },
                datalabels: {
                    formatter: (value, ctx) => {
                
                        let sum = 0;
                        let dataArr = ctx.chart.data.datasets[0].data;
                        dataArr.map(data => {
                            sum += data;
                        });
                        let percentage = (value*100 / sum).toFixed(2)+"%";
                        return percentage;

              
                    },
                    color: '#fff',
                },
                legend: {
					display: true,
					position: "right",
					labels: {
						boxWidth: 30,
						fontColor: "#000",
						fontFamily: "Montserrat",
						fullWidth: true
					} 
				},
            }
        },
        plugins: [ChartDataLabels]
    };

  const myChart = new Chart(
    document.getElementById('Chart').getContext('2d'),
    config
  );
</script>
<?php
include('includes/footer.php');
include('includes/scripts.php');
?>
