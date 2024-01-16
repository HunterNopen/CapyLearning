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
}else{
    $user_id = '';
}
if(isset($_GET['get_id'])){
    $getIdCourse = $_GET['get_id'];
}else{
    header('location:main_page.php');
}

if(isset($_POST['savedList'])){

    if($user_id != ''){

        $list_id = $_POST['list_id'];

        $select_list = $db->prepare("SELECT * FROM savedCourses WHERE idUser = ? AND idCourse = ?");
        $select_list->execute([$user_id, $list_id]);

        if($select_list->rowCount() > 0){
            $remove_bookmark = $db->prepare("DELETE FROM savedCourses WHERE idUser = ? AND idCourse = ?");
            $remove_bookmark->execute([$user_id, $list_id]);
            $message[] = 'playlist removed!';
        }else{
            $insert_bookmark = $db->prepare("INSERT INTO savedcourses(idUser, idCourse) VALUES(?,?)");
            $insert_bookmark->execute([$user_id, $list_id]);
            $message[] = 'playlist saved!';
        }

    }else{
        $message[] = 'please login first!';
    }

}

if(isset($_POST['likesList'])){

    if($user_id != ''){

        $list_id = $getIdCourse;

        $select_likes = $db->prepare("SELECT * FROM likecourses WHERE idUser = ? AND idCourse = ?");
        $select_likes->execute([$user_id, $list_id]);

        if($select_likes->rowCount() > 0){
            $remove_like = $db->prepare("DELETE FROM likecourses WHERE idUser = ? AND idCourse = ?");
            $remove_like->execute([$user_id, $list_id]);
            $db->query("UPDATE courses SET likesNumber=likesNumber-1 WHERE idCourse='$getIdCourse'");
            $message_l[] = 'playlist disliked!';
        }else{
            $insert_like = $db->prepare("INSERT INTO likecourses(idUser, idCourse) VALUES(?,?)");
            $insert_like->execute([$user_id, $list_id]);
            $db->query("UPDATE courses SET likesNumber=likesNumber+1 WHERE idCourse='$getIdCourse'");
            $message_l[] = 'playlist liked!';
        }

    }else{
        $message_l[] = 'please login first!';
    }

}

if (isset($_COOKIE["course".$getIdCourse])){
    $messages[]="NO COMMENTS YET! 24 HOURS HASN'T EXPIRED";
}
else if(isset($_POST['comment']) && isset($_POST['submit'])){
    $commentMess=$_POST['comment'];
    setcookie("course$getIdCourse", "true", time()+8640);
    $comment=$_COOKIE["course$getIdCourse"];
    $messages[]="SUCCESSFULLY";
    $db->query("INSERT INTO comments(idUser, idCourse, comment) VALUES ('$user_id', '$getIdCourse', '$commentMess')");
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



<section class="playlist">

    <h1 class="heading">playlist details</h1>

    <div class="row">

        <?php
        $select_playlist = $db->prepare("SELECT * FROM courses WHERE idCourse = ? and statusCourse = ? LIMIT 1");
        $select_playlist->execute([$getIdCourse, 'active']);
        if($select_playlist->rowCount() > 0){
            $fetch_playlist = $select_playlist->fetch(PDO::FETCH_ASSOC);

            $playlist_id = $fetch_playlist['idCourse'];

            $count_videos = $db->prepare("SELECT * FROM courseMaterials WHERE idCourse = ?");
            $count_videos->execute([$playlist_id]);
            $total_videos = $count_videos->rowCount();

            $total_likes=$db->query("SELECT likesNumber FROM courses WHERE idCourse='$playlist_id'");
            $total_likes=$total_likes->fetch(PDO::FETCH_ASSOC);

            $select_tutor = $db->prepare("SELECT * FROM tutors WHERE idTutor = ? LIMIT 1");
            $select_tutor->execute([$fetch_playlist['idTutor']]);
            $fetch_tutor = $select_tutor->fetch(PDO::FETCH_ASSOC);

            $select_bookmark = $db->prepare("SELECT * FROM savedCourses WHERE idUser = ? AND idCourse = ?");
            $select_bookmark->execute([$user_id, $playlist_id]);

            $select_likes = $db->prepare("SELECT * FROM likecourses WHERE idUser = ? AND idCourse = ?");
            $select_likes->execute([$user_id, $playlist_id]);

            $select_tutor = $db->prepare("SELECT * FROM tutors WHERE idTutor = ?");
            $select_tutor->execute([$fetch_tutor['idTutor']]);
            $fetched_tutor = $select_tutor->fetch(PDO::FETCH_ASSOC);
            $get_image_course = $db->query("SELECT image FROM users WHERE idUser='${fetched_tutor['idUser']}'");
            $image_tutor = $get_image_course->fetch();
            $get_description = $db->prepare('SELECT description from coursematerials WHERE idCourse=?');
            $get_description->execute([$fetch_playlist['idCourse']]);
            $description = $get_description->fetch(PDO::FETCH_ASSOC);
            ?>

            <div class="col">
                <form method="post" class="save-list">
                    <input type="hidden" name="list_id" value="<?= $playlist_id; ?>">
                    <?php
                    if ($select_bookmark->rowCount() > 0) {
                        ?>
                        <button type="submit" name="savedList"><i class="fas fa-bookmark"></i><span>saved</span>
                        </button>
                        <?php
                    } else {
                        ?>
                        <button type="submit" name="savedList"><i class="far fa-bookmark"></i><span>save playlist</span>
                        </button>
                        <?php
                    }
                    if (isset($message)) {
                        foreach ($message as $message) {
                            echo '
      <div class="message">
         <span>' . $message . '</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>';
                        }
                    }
                    ?>
                </form>
                <form method="post" class="save-list">
                    <input type="hidden" name="list_id" value="<?= $playlist_id; ?>">
                    <?php
                    if ($select_likes->rowCount() > 0) {
                        ?>
                        <div style="font-size: 5rem; font-weight: bold;color: #ff00ff;text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5); box-sizing: unset"><?= $total_likes['likesNumber']; ?><button type="submit" name="likesList"><i class="fas fa-thumbs-up"></i><span>liked</span>
                            </button></div>
                        <?php
                    } else {
                        ?>
                        <div style="font-size: 5rem; font-weight: bold;color: #ff00ff;text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5); box-sizing: unset"><?= $total_likes['likesNumber']; ?></span><button type="submit" name="likesList"><i
                                        class="far fa-thumbs-down"></i><span>like playlist</span></button></div>
                        <?php
                    }
                    if (isset($message_l)) {
                        foreach ($message_l as $message) {
                            echo '
      <div class="message">
         <span>' . $message . '</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>';
                        }
                    }
                    ?></form>
                <div class="thumb">
                    <span><?= $total_videos; ?> videos</span>
                    <img src="<?= $fetch_playlist['image']; ?>" alt="" width="400px">
                </div>
            </div>

            <div class="col">
                <div class="tutor">
                    <img src="<?=$image_tutor['image']; ?>" alt="" width="200px">
                    <div>
                        <h3><?= $fetch_tutor['publicName']; ?></h3>
                        <span>Developer</span>
                    </div>
                </div>
                <div class="details">
                    <h3><?= $fetch_playlist['nameCourse']; ?></h3>
                    <p><?= $description['description']; ?></p>
                    <div class="date"><i class="fas fa-calendar"></i><span><?= $fetch_playlist['dateUp']; ?></span></div>
                </div>
            </div>

            <?php
        }else{
            echo '<p class="empty">this playlist was not found!</p>';
        }
        ?>

    </div>

</section>



<section class="videos-container">

    <h1 class="heading">playlist videos</h1>

    <div class="box-container">

        <?php
        $select_content = $db->query("SELECT * FROM courseMaterials JOIN courses ON coursematerials.idCourse = courses.idCourse AND coursematerials.idCourse='$getIdCourse' AND courses.statusCourse = 'active' ORDER BY dateUp DESC");
        if($select_content->rowCount() > 0){
            while($fetch_content = $select_content->fetch(PDO::FETCH_ASSOC)){
                $videos_get=$db->query("SELECT video FROM coursematerials WHERE idCourse='$getIdCourse'");
                $videos_get=$videos_get->fetch(PDO::FETCH_ASSOC);
                $videos=explode(",",$videos_get['video']);
                foreach ($videos as $video){
                ?>
                <a href="<?= $video ?>" class="box">
                    <i class="fas fa-play"></i>
                    <img src="<?= $fetch_playlist['image']; ?>" alt="">
                    <h3><?= $fetch_content['nameCourse']; ?></h3>
                </a>
                <?php
            }
            }
        }else{
            echo '<p class="empty">no videos added yet!</p>';
        }
        $exercises=$db->query("SELECT * FROM practice WHERE idCourse='$getIdCourse'");
        if($user_id && $exercises->rowCount()>0){
        ?>
            <a href='exercises.php?course_id=<?=$getIdCourse?>&exercise=1' class='inline-button'>START COURSE</a>
        <?php
        }
        ?>
    </div>

    <?php if($user_id){ ?>
    <div class="comment-section" id="comment-form">
            <h1 class="heading">COMMENTS</h1>
        <form method="post" action="this_course.php?get_id=<?=$getIdCourse;?>">
            <textarea id="comment" name="comment" rows="4" placeholder="Write your comment (1 time per course in 24 hours)" required></textarea>
            <button type="submit" id="submit" name="submit" class="inline-option-button">SEND</button>
        </form>
    </div>
        <?php
        if(isset($messages)){
            foreach($messages as $messages){
                echo '
      <div class="message">
         <span>'.$messages.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>';
            }
        }
    } ?>
        <h1 class="heading">latest comments</h1>
            <?php
            $comments_selected = $db->prepare("SELECT * FROM comments WHERE idCourse='$getIdCourse' ORDER BY dateUp DESC LIMIT 10");
            $comments_selected->execute();
            if($comments_selected->rowCount() > 0){
                while($fetched_comments = $comments_selected->fetch(PDO::FETCH_ASSOC)){
                    $comment_id = $fetched_comments ['idCourse'];

                    $select_user = $db->prepare("SELECT * FROM users WHERE idUser = ?");
                    $select_user->execute([$fetched_comments['idUser']]);
                    $fetched_user = $select_user->fetch(PDO::FETCH_ASSOC);
                    ?>
                    <div class="box">
                        <div class="tutor">
                            <img src="<?=$fetched_user['image']?>" width="50px">
                            <div>
                                <h3><?= $fetched_user['loginUser']; ?></h3>
                                <span>Upload date: <?= $fetched_comments['dateUp']; ?></span>
                            </div>
                        </div>
                        <h2 class="title"><?= $fetched_comments['comment']; ?></h2>
                    </div>
                    <?php
                }
            }else{
                echo '<p class="empty_courses">no comments added yet!</p>';
            }
            ?>

</section>







<footer class="footer">

    &copy; PROJECT @ <?= date('Y'); ?> by <i>Roman Herasymov</i> | Have a great day!

</footer>

</body>
</html>
