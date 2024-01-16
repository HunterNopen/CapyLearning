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
    header('location:main_page.php');
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

<section class="profile">

    <h1 class="heading">profile details</h1>

    <div class="details">

        <div class="user">
            <img src="<?= $fetched_profile['image']; ?>" alt="">
            <h3><?= $fetched_profile['loginUser']; ?></h3>
            <p><?php $is_tutor_user=$db->prepare("SELECT * FROM tutors WHERE idUser=?;");
                $is_tutor_user->execute([$user_id]);
                if($user_id && $is_tutor_user->rowCount()>0){
                    $tutor_info=$is_tutor_user->fetch(PDO::FETCH_ASSOC);
                echo "CapyTutor";}
                else echo "CapyStudent";?></p>
            <h3><?= $tutor_info['publicName']; ?></h3>
            <a href="settings.php" class="inline-button">update profile</a>
        </div><br>
        <h2><div class="">About yourself: <?=$fetched_profile['about']?>
    </div></h2>
        <div class="box-container">

            <div class="box">
                <div class="flex">
                    <i class="fas fa-bookmark"></i>
                    <div>
                        <h3><?php $getSaved=$db->query("SELECT COUNT(idCourse) FROM savedCourses WHERE idUser='$user_id'");
                            $savedOnes=$getSaved->fetch(PDO::FETCH_ASSOC);
                        echo $savedOnes['COUNT(idCourse)'];?></h3>
                        <span>saved playlists</span>
                    </div>
                </div>
                <a href="saved_courses.php" class="inline-button">view playlists</a>
            </div>

            <div class="box">
                <div class="flex">
                    <i class="fas fa-comment"></i>
                    <div>
                        <h3><?php $getSaved=$db->query("SELECT COUNT(idComment) FROM comments WHERE idUser='$user_id'");
                            $savedOnes=$getSaved->fetch(PDO::FETCH_ASSOC);
                            echo $savedOnes['COUNT(idComment)'];?></h3>
                        <span>video comments</span>
                    </div>
                </div>
                <a href="my_comments.php" class="inline-button">view comments</a>
            </div>

        </div>

    </div>

</section>













<footer class="footer">

    &copy; PROJECT @ <?= date('Y'); ?> by <i>Roman Herasymov</i> | Have a great day!

</footer>

</body>
</html>

