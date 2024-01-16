<?php
session_start();

require_once('vendor/autoload.php');
$sandbox=new PHPSandbox\PHPSandbox();

//$dbuser = 'root';
//$dbpass = '';
//$db = new PDO("mysql:host=localhost;dbname=CapyLearning", $dbuser,$dbpass);
$dbuser = 's28856';
$dbpass = 'Rom.Hera';
$host='szuflandia.pjwstk.edu.pl';
$db=new PDO("mysql:host=$host;dbname=s28856", $dbuser,$dbpass);

if(isset($_GET['exercise'])){
    $exercise=$_GET['exercise'];
} else $exercise=1;
if(isset($_GET['course_id'])){
    $course_id=$_GET['course_id'] ;
} else header("Location: main_page.php");

if(isset($_SESSION['idUser'])){
    $user_id = $_SESSION['idUser'];
} else header("Location: main_page.php");

$getIdPractice=$db->query("SELECT idPractice FROM practice WHERE idCourse='$course_id' AND number='$exercise'");
$idPractice=$getIdPractice->fetch(PDO::FETCH_ASSOC);
$progressGet=$db->query("SELECT * FROM progress JOIN practice p on progress.idPractice='{$idPractice['idPractice']}' AND progress.idUser='$user_id'");
$progress=$progressGet->fetch(PDO::FETCH_ASSOC);
if ($progressGet->rowCount()==0){
    $db->query("INSERT INTO progress(idUser, idPractice) VALUES ('$user_id', '{$idPractice['idPractice']}')");
}
$progressGet=$db->query("SELECT * FROM progress JOIN practice p on progress.idPractice='{$idPractice['idPractice']}' AND progress.idUser='$user_id'");
$progress=$progressGet->fetch(PDO::FETCH_ASSOC);
$exercise_exercise=$db->query("SELECT * FROM practice WHERE idCourse='$course_id'");
$exercise_get=$db->query("SELECT * FROM practice WHERE idCourse='$course_id' AND number='$exercise'");
$exercise_info=$exercise_get->fetch(PDO::FETCH_ASSOC);
$numbers = [1, 2, 3, 4, 5];

function square(&$value, $key) {
    $value = $value * $value;
}

array_walk($numbers, 'square');
echo "AAAAAAAAAAAAAAAAAAAAAAAAAA $exercise";
echo "AAAAAAAAAAAAAAAAAAAAAAAAAAA ${progress['progress']}";
?>

<!DOCTYPE html>
<html lang="en">
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 20px;
    }

    .task {
        margin-bottom: 20px;
    }

    .task p {
        font-size: 18px;
        margin: 0;
    }

    .answer-form {
        margin-bottom: 20px;
    }

    .answer-input {
        width: 500px;
        height: 250px;
        padding: 10px;
        font-size: 16px;
        border: 2px solid #ccc;
    }

    .result-box {
        background-color: #f5f5f5;
        padding: 10px;
        font-size: 16px;
    }
</style>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Playlist</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<?php include "header_include.php"; ?>

<section class="courses">

    <h1 class="heading">Exercise <?=$exercise?></h1>
    <?php
    if($progress['progress']==0){
    ?>
    <div class="box-container">
    </div>
        <h1 class="heading">Task</h1>
        <div class="task">
            <p><?=$exercise_info['description']?></p>
            <p><?=$exercise_info['image']?></p>
            <p><?=$exercise_info['video']?></p>
        </div>

        <div class="answer-form">
            <form method="post">
                <textarea name='code' class="answer-input" placeholder="Enter your answer" required></textarea><br>
                <input type="submit" class="inline-option-button" value="Submit">
            </form>
        </div>
    <?php
    if(isset($_POST['code'])){
        $userCode = $_POST['code'];

        $userCode=str_replace("<?php", "", $userCode);
        $userCode=str_replace("?>", "", $userCode);
        try {
            $sandbox->setFuncValidator(function($userCode, PHPSandbox\PHPSandbox $sandbox){
                return (substr($userCode, 0, 7));
            });
            $sandbox->execute($userCode);
        ob_start();
        try{
            eval($userCode);
            $output = ob_get_clean();
        }
         catch (Throwable $e) {
            $output='ERROR!!!!!!!';
        }
        }
        catch (Throwable $e){
            $output='NO HACKING!';
        }
        ?>
        <div class="result-box" id="resultBox">
            Your output: <?=$output?><br>
            <?php
            if($output==$exercise_info['answer']){
                $db->query("UPDATE progress SET progress=1 WHERE idUser='$user_id' AND idPractice='{$idPractice['idPractice']}'");
                header("Location: exercises.php?course_id=$course_id&exercise=$exercise");
                if($exercise_exercise->rowCount()-1>$exercise){
            ?>
        </div>
    <a href='exercises.php?course_id=<?=$course_id?>&exercise=<?=++$exercise?>' class='inline-button'>NEXT TASK</a>
    <?php
            }
    }
    }
    }else{
        ?>
    <img src="images_source/completed.png" width="500px">
        <a href='main_page.php' class="inline-option-button">MAIN PAGE</a>
    <?php
    if($exercise_exercise->rowCount()>$exercise){
    ?>
        <a href='exercises.php?course_id=<?=$course_id?>&exercise=<?=++$exercise?>' class='inline-button'>NEXT TASK</a>
    <?php
    }
    }
    ?>
</section>











<footer class="footer">

    &copy; PROJECT @ <?= date('Y'); ?> by <i>Roman Herasymov</i> | Have a great day!

</footer>

</body>
</html>
