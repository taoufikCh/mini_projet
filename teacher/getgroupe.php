<?php
 
 include('config/dbconn.php');


 
// POST Data
$id_matiere= $_POST['id_mat'];

//$query="SELECT groupe.*, subject_groupe.* from groupe LEFT JOIN subject_groupe ON groupe.idGroupe = subject_groupe.idGroupe WHERE subject_groupe.IdMatiere='".$id_matiere."'";

$query="SELECT groupe.*, subject_groupe.* from groupe 
LEFT JOIN subject_groupe ON groupe.idGroupe = subject_groupe.idGroupe 
WHERE subject_groupe.IdMatiere='".$id_matiere."'"; 

$res=mysqli_query($con, $query);

// $row = mysqli_fetch_assoc($res);
$list = [];
foreach($res as $data){
    //echo $data['idGroupe']." ".$data['nomGroupe']." ".$data['idGroupe']." ".$data['IdMatiere']."</br>"; 
    array_push($list, $data); 
}
$result = [];
	$result['first_name'] = "John";
	$result['last_name'] = "Doe";

	echo json_encode($list);


//$result['msg']=$res;
//echo json_encode($result);

//$Response = array('Success' => "Success", 'Content' => $res);
//echo $list;
//echo json_encode($list);
//exit;
 
?>