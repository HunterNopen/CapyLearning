<?php
session_start();
//$dbuser = 'root';
//$dbpass = '';
//$db = new PDO("mysql:host=localhost;dbname=CapyLearning", $dbuser,$dbpass);
$dbuser = 's28856';
$dbpass = 'Rom.Hera';
$host='szuflandia.pjwstk.edu.pl';
$db=new PDO("mysql:host=$host;dbname=s28856", $dbuser,$dbpass);
if(isset($_GET['tag'])){
    $tag=$_GET['tag'] ;
}
else $tag='';

if(isset($_SESSION['idUser'])){
    $user_id = $_SESSION['idUser'];
}else{
    $user_id = '';
}

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

    <h1 class="heading">Taged courses</h1>

    <div class="box-container">
        <?php
        if($tag){
        $courses_selected = $db->prepare("SELECT * FROM courses WHERE statusCourse = 'active' AND tags=? ORDER BY dateUp DESC");
        $courses_selected->execute([$tag]);}
        else{
            $courses_selected = $db->prepare("SELECT * FROM courses WHERE statusCourse = 'active' ORDER BY dateUp DESC");
            $courses_selected->execute();
        }
        if($courses_selected->rowCount() > 0){
            while($fetched_courses = $courses_selected->fetch(PDO::FETCH_ASSOC)){
                $course_id = $fetched_courses['idCourse'];

                $select_tutor = $db->prepare("SELECT * FROM tutors WHERE idTutor = ?");
                $select_tutor->execute([$fetched_courses['idTutor']]);
                $fetched_tutor = $select_tutor->fetch(PDO::FETCH_ASSOC);
                $get_image_course=$db->query("SELECT image FROM users WHERE idUser='${fetched_tutor['idUser']}'");
                $image_tutor=$get_image_course->fetch();
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
                    <a href="this_course.php?get_id=<?= $course_id; ?>" class="inline-button">view playlist</a>
                </div>
                <?php
            }
        }else{
            echo '<p class="empty_courses">no courses found by your tag!</p>';
            ?>
                </div>
            <h1 class="heading">Others courses</h1>
            <div class="box-container">
                <?php
                $courses_others = $db->prepare("SELECT * FROM courses WHERE statusCourse = 'active' AND tags=? ORDER BY dateUp DESC");
                $courses_others->execute(["all"]);
                if($courses_others->rowCount() > 0){
                    while($fetched_courses_others = $courses_others->fetch(PDO::FETCH_ASSOC)){
                        $course_id_others = $fetched_courses_others['idCourse'];

                        $select_tutor = $db->prepare("SELECT * FROM tutors WHERE idTutor = ?");
                        $select_tutor->execute([$fetched_courses_others['idTutor']]);
                        $fetched_tutor = $select_tutor->fetch(PDO::FETCH_ASSOC);
                        $get_image_course=$db->query("SELECT image FROM users WHERE idUser='${fetched_tutor['idUser']}'");
                        $image_tutor=$get_image_course->fetch();
                        ?>
                        <div class="box">
                            <div class="tutor">
                                <img src="<?=$image_tutor['image']?>">
                                <div>
                                    <h3>Tutor: <?= $fetched_tutor['publicName']; ?></h3>
                                    <span>Upload date: <?= $fetched_courses_others['dateUp']; ?></span>
                                </div>
                            </div>
                            <img src="<?= $fetched_courses_others['image'];?>" class="thumb" alt="">
                            <h3 class="title">Title: <?= $fetched_courses_others['nameCourse']; ?></h3>
                            <a href="this_course.php?get_id=<?= $course_id_others; ?>" class="inline-button">view playlist</a>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
        <?php
        }
        ?>

    </div>
</section>












<footer class="footer">

    &copy; PROJECT @ <?= date('Y'); ?> by <i>Roman Herasymov</i> | Have a great day!

</footer>

</body>
</html>

