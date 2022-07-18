<?php
session_start();
include('admin/config/dbconn.php');
if(isset($_POST['login_btn']))
{
    $email=mysqli_real_escape_string($con,$_POST['email']);
    $password=mysqli_real_escape_string($con,$_POST['password']);
    $crypt_passowrd = md5($password);
    $your_are = mysqli_real_escape_string($con,$_POST['you_are']);

    if($your_are==="1"){
        $verifloginquery="SELECT * from users WHERE mail='$email' and password='$crypt_passowrd' LIMIT 1";
        $veriflogin_run=mysqli_query($con, $verifloginquery);
        if (mysqli_num_rows( $veriflogin_run)>0)
        {
            foreach($veriflogin_run as $data){
                $user_id=$data['codeuser'];
                $user_prenomnom=$data['prenom']. ' ' .$data['nom'];
                $user_mail=$data['mail'];
                $user_role=$data['userrole'];
            }
            $_SESSION['auth']=true;
            $_SESSION['role']="1";
            $_SESSION['auth_role']="$user_role";// 1=admin; 0=user
            $_SESSION['auth_user']=['codeuser'=>$user_id,
                                    'user_prenomnom'=>$user_prenomnom,
                                    'user_mail'=>$user_mail,
            ];
            if($_SESSION['auth_role']=='1') // admin
            {
                $_SESSION['message']="Bienvenue ".$user_prenomnom;
                header("Location: admin/index.php");
                exit(0);
            }
            elseif($_SESSION['auth_role']=='0') // user
            {
                header("Location: index.php");
                exit(0);
            }
        }
        else
        {
            $_SESSION['message']="Paramètre d'accès incorrecte ";
            header("Location: login.php");
            exit(0);
        }
    }
    elseif($your_are==="2"){
        $verifloginquery="SELECT * from enseignant WHERE adresseMail='$email' and password='$crypt_passowrd' LIMIT 1";
        $veriflogin_run=mysqli_query($con, $verifloginquery);
        if (mysqli_num_rows( $veriflogin_run)>0)
        {
            foreach($veriflogin_run as $data){
                $user_id=$data['numEns'];
                $user_prenomnom=$data['prenom']. ' ' .$data['nom'];
                $user_mail=$data['adresseMail'];
            }
            $_SESSION['auth']=true;
            $_SESSION['role']="2";
            $_SESSION['auth_user']=['codeuser'=>$user_id,
                                    'user_prenomnom'=>$user_prenomnom,
                                    'user_mail'=>$user_mail,
            ];
            $_SESSION['message']="Bienvenue ".$user_prenomnom;
            header("Location: teacher/index.php");
            exit(0); 
        }
        else
        {
            $_SESSION['message']="Paramètre d'accès incorrecte ";
            header("Location: login.php");
            exit(0);
        }

    }
    else{

        $verifloginquery="SELECT * from etudiant WHERE adresseMailEtd='$email' AND password='$crypt_passowrd' LIMIT 1";
        $veriflogin_run=mysqli_query($con, $verifloginquery);
        if (mysqli_num_rows( $veriflogin_run)>0)
        {
            foreach($veriflogin_run as $data){
                $user_id=$data['numEtd'];
                $user_prenomnom=$data['prenomEtd']. ' ' .$data['nomEtd'];
                $user_mail=$data['adresseMail'];
            }
            $_SESSION['auth']=true;
            $_SESSION['role']="3";
            $_SESSION['auth_user']=['codeuser'=>$user_id,
                                    'user_prenomnom'=>$user_prenomnom,
                                    'user_mail'=>$user_mail,
            ];
            $_SESSION['message']="Bienvenue ".$user_prenomnom;
            header("Location: student/index.php");
            exit(0); 
        }
        else
        {
            $_SESSION['message']="Paramètre d'accès incorrecte ";
            header("Location: login.php");
            exit(0);
        }

    }

    
} 
else
{
    $_SESSION['message']="Accès interdit ";
    header("Location: login.php");
    exit(0);
}
?>