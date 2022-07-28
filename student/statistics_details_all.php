<?php
session_start();
include('includes/header.php');
include('includes/navbar.php');

include('config/dbconn.php');

//$id_subject = $_POST['subject'];
$id_student = $_SESSION['auth_user']['codeuser'];

$query="SELECT groupe from etudiant WHERE numEtd = '$id_student'";
$res_groupe = mysqli_query($con, $query) or die (mysqli_error($con));
$row = mysqli_fetch_assoc($res_groupe);

$id_groupe = $row['groupe'];

$sql_subject="SELECT subject_groupe.*, matieres.* from subject_groupe
LEFT JOIN matieres ON subject_groupe.IdMatiere = matieres.id_mat WHERE subject_groupe.idGroupe='".$id_groupe."'";
$res_subject=mysqli_query($con, $sql_subject);

$list_id_subject = array();;
foreach($res_subject as $info){
    $list_id_subject[] = $info['IdMatiere'];  
}

$query_course = "SELECT * from coursesession where id_matiere IN (" . implode(',', array_map('intval', $list_id_subject)) . ") and id_groupe='".$id_groupe."' ";
$res = mysqli_query($con, $query_course);
$list_id = array();
foreach($res as $info){
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
    $list_id[] = $info['id_seance'];
}

$query_course1 = "SELECT coursesession.*  , matieres.*, assiduite.* from coursesession 
LEFT JOIN matieres ON coursesession.id_matiere = matieres.id_mat
LEFT JOIN assiduite ON assiduite.id_course = coursesession.id_seance 
where assiduite.id_etudiant= '$id_student' and coursesession.id_matiere IN (" . implode(',', array_map('intval', $list_id_subject)) . ") and coursesession.id_groupe='".$id_groupe."'
GROUP BY  matieres.id_mat";
$res_course = mysqli_query($con, $query_course1);
/////
$query_count_test = " SELECT id_matiere, count(test_evaluation) as t_e FROM coursesession WHERE test_evaluation = 1 and id_matiere IN (" . implode(',', array_map('intval', $list_id_subject)) . ") and id_groupe='".$id_groupe."'  GROUP BY id_matiere";
$res_count_test = mysqli_query($con, $query_count_test);

//$query_count_absent = " SELECT assiduite.*, coursesession.id_matiere, count(assiduite.isAbsent) as nbr_absence FROM assiduite
//LEFT JOIN assiduite ON assiduite.id_course = coursesession.id_seance 
//WHERE test_evaluation = 1 and id_matiere IN (" . implode(',', array_map('intval', $list_id_subject)) . ") and id_groupe='".$id_groupe."'  GROUP BY id_matiere";
//$res_count_test = mysqli_query($con, $query_count_test);

$query_assiduite="SELECT assiduite.* , coursesession.* from assiduite
LEFT JOIN coursesession ON assiduite.id_course = coursesession.id_seance WHERE assiduite.id_etudiant= '$id_student' and assiduite.id_course IN (" . implode(',', array_map('intval', $list_id)) . ")
";
$res_assiduite=mysqli_query($con, $query_assiduite);
?>
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.0.0/dist/chart.min.js">
    
</script>

 <!-- Begin Page Content -->
 <div class="container-fluid">
    <!-- Page Heading -->

    <!-- DataTales Example -->

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
                        <th>Matière</th>
                        <th>Nbre absence</th>
                        <th>Nbre test_evaluation</th>
                        <th>Somme des notes</th>
                        <th>Moyenne</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    if($res_course){
                        $labels="";
                        $moyennes="";
                        foreach($res_course as $cource){
                            $nbr_absence = 0;
                            $somme_notes = 0;
                            $moy = 0;
                            $n_test= 0; ?> 
                        <tr>
                            <td><?php echo $cource['nom_mat']; 
                            $labels = $labels.",'".$cource['nom_mat']."'" ; 
                            ?>
                            </td>
                            <td>
                                <?php foreach($res_assiduite as $nbr_absent){
                                    if($nbr_absent['id_matiere']===$cource['id_matiere']){
                                        //echo 'is absent '.$nbr_absent['isAbsent'];
                                        if($nbr_absent['isAbsent']==="1"){
                                            $nbr_absence+=1;  
                                        } 
                                    } 
                                }
                                echo $nbr_absence;
                                ?>
                            </td> 
                            <td>
                                <?php foreach($res_count_test as $nbr_test){
                                    if($nbr_test['id_matiere']===$cource['id_matiere']){
                                         echo $nbr_test['t_e'];
                                         $n_test = $nbr_test['t_e'];
                                    } 
                                }
                                ?>
                            </td> 
                            <td>
                            <?php foreach($res_assiduite as $note_test){
                                    //echo '<br>test_ id_mat = '.$note_test['id_matiere'];
                                    //echo '<br>course id_mat = '.$cource['id_matiere'];
                                    //echo '<br>test_evaluation = '.$note_test['test_evaluation'];
                                    //echo '<br>note_test = '.$note_test['note_test'].'<br>';
                                    if($note_test['id_matiere']===$cource['id_matiere']){
                                        if($note_test['test_evaluation']==="1"){
                                            $x_note= number_format((float)$note_test['note_test'], 2, '.', '');
                                            $somme_notes+=$x_note;
                                        } 
                                    }
                                }
                                echo $somme_notes;
                                ?>
                            </td>
                            <td><?php if($n_test >0) {$moy = number_format((float) $somme_notes/$n_test, 2, '.', '');
                            echo $moy;
                             } 
                             $moyennes = $moyennes.",'".$moy."'" ; 
                            ?></td>
                            
                        </tr>
                    <?php }
                        $labels = substr($labels, 1); 
                        $moyennes = substr($moyennes, 1); 
                    } else {}?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Graphique à barres de la moyenne des matières</h6>
        </div>
        <div class="card-body" >
            <div class="text-center col-md-12">
                 <center>
                    <div style="display: block; box-sizing: border-box; ">
                    <canvas id="myChart" style="width:100%;max-width:600px; max-height:400px">></canvas>
                    </div>
                </center>
            </div>
        </div>
    <div>                      
</div>
</div>
</div>

<script>
var xValues = [<?php echo $labels; ?>,'algo', 'AI'];
var yValues = [<?php echo $moyennes; ?>, '14', '13.5'];
var l = yValues.length;
//var barColors = ["red", "green","blue"];
let colorArray = [  '#ff0040','#FF6633', '#3366E6', '#00E680', '#FF3380', '#6680B3', '#B33300', 
                    '#991AFF', '#0080ff', '#ffbf00', '#ff8000', '#ff4000',
                    '#009933', '#ff80d5', '#3366cc', '#339966', '#996600', 
                    '#990033', '#ff8c1a', '#999966', '#ff9900', '#0066ff',
                    '#808080', '#99ccff', '#336600', '#CC80CC', '#E64D66', 
                    '#E6B333', '#66E64D', '#1AB399', '#809980', '#00E680',
                    '#B366CC', '#FFB399', '#99E6E6', '#4D8000', '#FF99E6', 
                    '#80B300', '#4D80CC', '#E6331A', '#6666FF', '#B34D4D',
                    '#00B3E6', '#66994D', '#9900B3', '#4DB380', '#FF4D4D'];

const shuffled = [...colorArray].sort(() => 0.5 - Math.random());
let barColors = shuffled.slice(0, l);
console.log(barColors);

new Chart("myChart", {
  type: "bar",
  
  data: {
    labels: xValues,
    datasets: [{
      backgroundColor: barColors,
      data: yValues
    }]
  },
  options: {
        plugins: {
            legend: {
                display: false,
                
            }
        }
    }
});
   
</script>
<?php
include('includes/footer.php');
include('includes/scripts.php');
?>
