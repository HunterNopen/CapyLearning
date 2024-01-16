<?php
session_start();
//$dbuser = 'root';
//$dbpass = '';
//$db = new PDO("mysql:host=localhost;dbname=CapyLearning", $dbuser,$dbpass);
$dbuser = 's28856';
$dbpass = 'Rom.Hera';
$host='szuflandia.pjwstk.edu.pl';
$db=new PDO("mysql:host=$host;dbname=s28856", $dbuser,$dbpass);
if(isset($_SESSION['idUser'])){
    $user_id = $_SESSION['idUser'];
}else header("Location: main_page.php");

if(isset($_GET['id_course']) && isset($_GET['id_tutor'])){
    $idCourse=$_GET['id_course'];
    $idTutor=$_GET['id_tutor'];
}else header("Location: main_page.php");

$db->query("DELETE FROM courses WHERE idCourse='$idCourse'");
header("Location: my_courses.php?id_tutor=$idTutor");
exit();

?>


