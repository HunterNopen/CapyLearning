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

if(isset($message)){
    foreach($message as $message){
        echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
    }
}

?>

<!DOCTYPE html>
<html lang="en">
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

    <h1 class="heading">Saved courses</h1>

    <div class="box-container">
        <?php
        $courses_selected=$db->query("SELECT * FROM courses ORDER BY likesNumber DESC");
        if($courses_selected->rowCount() > 0){
            while($fetched_courses = $courses_selected->fetch(PDO::FETCH_ASSOC)){
                $course_id = $fetched_courses['idCourse'];

                $select_tutor = $db->prepare("SELECT * FROM tutors WHERE idTutor = ?");
                $select_tutor->execute([$fetched_courses['idTutor']]);
                $fetched_tutor = $select_tutor->fetch(PDO::FETCH_ASSOC);
                $get_image_course=$db->query("SELECT image FROM users WHERE idUser='${fetched_tutor['idUser']}'");
                $image_tutor=$get_image_course->fetch();

                $total_likes=$db->query("SELECT likesNumber from courses WHERE idCourse='$course_id'");
                $total_likes=$total_likes->fetch(PDO::FETCH_ASSOC);
                ?>
                <div class="box">
                    <div class="tutor">
                        <img src="<?=$image_tutor['image']?>">
                        <div>
                            <h3>Tutor: <?= $fetched_tutor['publicName']; ?></h3>
                            <span>Upload date: <?= $fetched_courses['dateUp']; ?></span>
                        </div>
                    </div>
                    <img src="<?= $fetched_courses['image'];?>" class="thumb" alt="">
                    <h3 class="title">Title: <?= $fetched_courses['nameCourse']; ?></h3>
                    <div style="font-size: 5rem; font-weight: bold;color: #ff00ff;text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5); box-sizing: unset"><?= $total_likes['likesNumber']; ?> likes</div><a href="this_course.php?get_id=<?= $course_id; ?>" class="inline-button">view playlist</a>
                </div>
                <?php
            }
        }else{
            echo '<p class="empty_courses">no courses saved yet!</p>';}
        ?>
    </div>
</section>









<footer class="footer">

    &copy; PROJECT @ <?= date('Y'); ?> by <i>Roman Herasymov</i> | Have a great day!

</footer>


</body>
</html>



