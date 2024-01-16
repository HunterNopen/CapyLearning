<?php
session_start();
//$dbuser = 'root';
//$dbpass = '';
//$db = new PDO("mysql:host=localhost;dbname=CapyLearning", $dbuser,$dbpass);
$dbuser = 's28856';
$dbpass = 'Rom.Hera';
$host='szuflandia.pjwstk.edu.pl';
$db=new PDO("mysql:host=$host;dbname=s28856", $dbuser,$dbpass);

if(isset($_GET['idUser'])){
    $user_id=$_GET['idUser'];
    $is_admin_user=$db->prepare("SELECT * FROM admins WHERE idUser=?;");
    $is_admin_user->execute([$user_id]);
    if($is_admin_user->rowCount()>0){
        header("Location: main_page.php");
    }else{
        $db->query("INSERT INTO admins(idUser) VALUES('$user_id')");
        header("Location: admin.php");
        exit();
    }
}else header("Location: main_page.php");

?>



