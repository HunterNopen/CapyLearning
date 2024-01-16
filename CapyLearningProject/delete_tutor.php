<?php
session_start();
//$dbuser = 'root';
//$dbpass = '';
//$db = new PDO("mysql:host=localhost;dbname=CapyLearning", $dbuser,$dbpass);
$dbuser = 's28856';
$dbpass = 'Rom.Hera';
$host='szuflandia.pjwstk.edu.pl';
$db=new PDO("mysql:host=$host;dbname=s28856", $dbuser,$dbpass);
if(isset($_GET['idTutor'])){
    $tutor_id=$_GET['idTutor'];
        $db->query("DELETE FROM tutors WHERE idTutor='$tutor_id'");
        header("Location: admin.php");
        exit();
}else header("Location: main_page.php");

?>




