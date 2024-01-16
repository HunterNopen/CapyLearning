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

    <h1 class="heading">Added comments</h1>

    <div class="box-container">
        <?php
        $comments_selected=$db->query("SELECT * FROM comments WHERE idUser='$user_id'");
        if($comments_selected->rowCount() > 0){
            while($fetched_comments = $comments_selected->fetch(PDO::FETCH_ASSOC)){
                $course_id = $fetched_comments['idCourse'];

                $select_user=$db->query("SELECT * FROM users WHERE idUser = '$user_id'");
                $fetched_user=$select_user->fetch(PDO::FETCH_ASSOC);

                $select_course = $db->query("SELECT * FROM courses WHERE idCourse = '$course_id'");
                $fetched_course = $select_course->fetch(PDO::FETCH_ASSOC);
                ?>
                <div class="box">
                            <div class="tutor">
                                <img src="<?=$fetched_user['image']?>" width="50px">
                                <div>
                                    <h3><?= $fetched_user['loginUser']; ?></h3>
                                    <span>Upload date: <?= $fetched_comments['dateUp']; ?></span>
                                </div>
                            </div><br>
                            <h2 class="title">Comment uploaded: <?= $fetched_comments['comment']; ?></h2>
                    <img src="<?= $fetched_course['image'];?>" class="thumb" alt="">
                    <h3 class="title">Title: <?= $fetched_course['nameCourse']; ?></h3>
                    <a href="this_course.php?get_id=<?= $course_id; ?>" class="inline-button">view playlist</a>
                </div>
                <?php
            }
        }else{
            echo '<p class="empty_courses">no comments added yet!</p>';}
        ?>
    </div>
</section>












<footer class="footer">

    &copy; PROJECT @ <?= date('Y'); ?> by <i>Roman Herasymov</i> | Have a great day!

</footer>

</body>
</html>



