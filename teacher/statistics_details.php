<?php
session_start();
include('includes/header.php');
include('includes/navbar.php');

include('config/dbconn.php');


$id_subject = $_POST['subject'];
$id_groupe = $_POST['groupe'];

$id_ens = $_SESSION['auth_user']['codeuser'];

$query_mat="SELECT * from matieres where id_mat='".$id_subject."'";
$res_mat=mysqli_query($con, $query_mat);
$data_mat = mysqli_fetch_assoc($res_mat);

$query_gr="SELECT * from groupe WHERE idGroupe='".$id_groupe."'";
$res_gr = mysqli_query($con, $query_gr) or die ( mysqli_error());
$data_gr = mysqli_fetch_assoc($res_gr);

$query_course = "SELECT * from coursesession 
     where id_matiere='".$id_subject."' and id_groupe='".$id_groupe."' and id_ens='".$id_ens."'";

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
        $list_id[] = $info['id_seance'];
    }
    

      
}
//echo var_dump($list_id);

$query_assiduite = "SELECT * from assiduite where id_course IN (" . implode(',', array_map('intval', $list_id)) . ") ORDER BY id_etudiant";
$res_assiduite = mysqli_query($con, $query_assiduite);

//$query_assd_student = "SELECT DISTINCT assiduite.id_etudiant from assiduite where id_course IN (" . implode(',', array_map('intval', $list_id)) . ") ORDER BY id_etudiant";
//$res_list_std = mysqli_query($con, $query_assd_student);

$query_assd_student="SELECT DISTINCT assiduite.id_etudiant, etudiant.* from assiduite
LEFT JOIN etudiant ON assiduite.id_etudiant = etudiant.numEtd WHERE assiduite.id_course IN (" . implode(',', array_map('intval', $list_id)) . ")";
$res_list_std=mysqli_query($con, $query_assd_student);

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
            <h6 class="m-0 font-weight-bold text-primary">Les moyennes des étudiants</h6>
        </div>
        <div class="card-body" >
           <?php $inf_10 = 0;
           $sup_10 = 0;
           ?>
           <table class="table"  width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Les notes</th>
                        <th>Somme des notes</th>
                        <th>Moyenne</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $nbr_students = 0;
                    foreach($res_list_std as $student){
                        $nbr_students +=1;
                        $s=0;
                        $moy = 0;
                         ?>
                        <tr>
                            <td><?php echo $student['nomEtd']; ?></td>
                            <td><?php echo $student['prenomEtd']; ?></td>
                            <td>
                            <?php foreach($res_assiduite as $info){
                                if($student['id_etudiant']===$info['id_etudiant']){
                                    $s+=$info['note_test'];
                                    echo ' | '.$info['note_test'];
                                }
                            }
                        ?>
                            </td>
                            <td><?php echo $s; ?></td>
                             <td><?php $moy = $s/$nbr_test; 
                                if($moy>= 10){ $sup_10 +=1; }
                                else { $inf_10 +=1;}
                                echo round($moy, 2); ?>
                             </td>  
                        </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Répartition des étudiants selon leur moyenne (supérieure/ inférieure à 10) de la matière</h6>
        </div>
        <div class="card-body" >
            <?php $m_sup_10 = round($sup_10*100/$nbr_students, 2);
            $m_onf_10 = round($inf_10*100/$nbr_students, 2);
            ?>
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
        '>=10',
        '<10',
    ],
    datasets: [{
        label: 'My First Dataset',
        data: [<?php echo $m_sup_10.' , '.$m_onf_10 ; ?>],
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
