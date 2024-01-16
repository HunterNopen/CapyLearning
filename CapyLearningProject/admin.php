<?php
session_start();
//$dbuser = 'root';
//$dbpass = '';
//$db = new PDO("mysql:host=localhost;dbname=CapyLearning", $dbuser,$dbpass);
$dbuser = 's28856';
$dbpass = 'Rom.Hera';
$host='szuflandia.pjwstk.edu.pl';
$db=new PDO("mysql:host=$host;dbname=s28856", $dbuser,$dbpass);

if(isset($_GET['idUser']) || isset($_SESSION['idUser'])){
$user_id=$_GET['idUser'];
$is_admin_user=$db->prepare("SELECT * FROM admins WHERE idUser=?;");
$is_admin_user->execute([$user_id]);
if($is_admin_user->rowCount()==0){
    header("Location: main_page.php");
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

<div class="courses">
    <h1 class="heading">Courses</h1>
    <div class="box-container">
        <?php
        $courses = $db->prepare("SELECT * FROM courses ORDER BY dateUp DESC");
        $courses->execute();
        if($courses->rowCount() > 0){
            while($fetched_courses = $courses->fetch(PDO::FETCH_ASSOC)){
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
                    <a href="update_course.php?id_course=<?= $course_id; ?>" class="inline-option-button">update playlist</a>
                    <a href="delete_course.php?id_course=<?= $course_id; ?>&id_tutor=<?=$fetched_tutor['idTutor']?>" class="inline-option-button">DELETE</a>
                </div>
                <?php
            }
        }
        ?>
    </div>
    <h1 class="heading">Users</h1>
    <div class="box-container">
        <?php
        $users = $db->prepare("SELECT * FROM users");
        $users->execute();
        if($users->rowCount() > 0){
            while($fetched_user = $users->fetch(PDO::FETCH_ASSOC)){
                $user_id = $fetched_user['idUser'];
                ?>
                <div class="box">
                    <div class="tutor">
                        <img src="<?=$fetched_user['image']?>">
                        <div>
                            <h3>Login: <?= $fetched_user['loginUser']; ?></h3>
                            <h3>Email: <?= $fetched_user['email']; ?></h3>
                        </div>
                    </div>
                    <a href="settings.php?id_user=<?= $user_id; ?>" class="inline-option-button">update user</a>
                    <a href="tutor_become.php?idUser=<?= $user_id; ?>" class="inline-option-button">make tutor</a>
                    <a href="admin_become.php?idUser=<?= $user_id; ?>" class="inline-option-button">make admin</a>
                </div>
                <?php
            }
        }
        ?>
    </div>
    <h1 class="heading">Users</h1>
    <div class="box-container">
        <?php
        $tutors = $db->prepare("SELECT * FROM tutors");
        $tutors->execute();
        if($tutors->rowCount() > 0){
            while($fetched_tutor = $tutors->fetch(PDO::FETCH_ASSOC)){
                $tutor_id = $fetched_tutor['idTutor'];
                $fetched_image=$db->query("SELECT image FROM users JOIN tutors t on users.idUser = t.idUser");
                $fetched_image=$fetched_image->fetch(PDO::FETCH_ASSOC);
                ?>
                <div class="box">
                    <div class="tutor">
                        <img src="<?=$fetched_image['image']?>">
                        <div>
                            <h3>Tutor Name: <?= $fetched_tutor['publicName']; ?></h3>
                        </div>
                    </div>
                    <a href="delete_tutor.php?idTutor=<?= $tutor_id; ?>" class="inline-option-button">resign</a>
                </div>
                <?php
            }
        }
        ?>
    </div>




</div>














</body>
</html>


