<?php
    session_start();
//    $dbuser = 'root';
//    $dbpass = '';
//    $db = new PDO("mysql:host=localhost;dbname=CapyLearning", $dbuser,$dbpass);

    $dbuser = 's28856';
    $dbpass = 'Rom.Hera';
    $db=new PDO("mysql:host=localhost;dbname=s28856", $dbuser,$dbpass);

    if(isset($_SESSION['idUser'])){
        $user_id = $_SESSION['idUser'];
    }else{
        $user_id = '';
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CapyLearning</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<?php include "header_include.php"; ?>

<section class="quick-select">

    <h1 class="heading">quick options</h1>
    <?php
    if($get_user_profile->rowCount()>0){

    ?>
    <div class="box-container">
    <?php
    }else{
    ?>
    <div class="box-container">
        <div class="box" style="text-align: center;">
            <h3 class="title">please login or register</h3>
            <div class="flex-button" style="padding-top: .5rem;">
                <a href="login.php" class="option-button">login</a>
                <a href="register.php" class="option-button">register</a>
            </div>
        </div>
        <?php
        }
        ?>
        <div class="box">
            <h3 class="title">top categories</h3>
            <div class="flex">
                <a href="courses.php?tag=development"><i class="fas fa-code"></i><span>development</span></a>
                <a href="courses.php?tag=business"><i class="fas fa-chart-simple"></i><span>business</span></a>
                <a href="courses.php?tag=design"><i class="fas fa-pen"></i><span>design</span></a>
                <a href="courses.php?tag=marketing"><i class="fas fa-chart-line"></i><span>marketing</span></a>
                <a href="courses.php?tag=music"><i class="fas fa-music"></i><span>music</span></a>
                <a href="courses.php?tag=photography"><i class="fas fa-camera"></i><span>photography</span></a>
                <a href="courses.php?tag=software"><i class="fas fa-cog"></i><span>software</span></a>
                <a href="courses.php?tag=science"><i class="fas fa-vial"></i><span>science</span></a>
            </div>
        </div>

        <div class="box">
            <h3 class="title">popular topics</h3>
            <div class="flex">
                <a href="courses.php?tag=development"><i class="fab fa-html5"></i><span>HTML</span></a>
                <a href="courses.php?tag=development"><i class="fab fa-css3"></i><span>CSS</span></a>
                <a href="courses.php?tag=development"><i class="fab fa-js"></i><span>javascript</span></a>
                <a href="courses.php?tag=development"><i class="fab fa-react"></i><span>react</span></a>
                <a href="search.php?search=php"><i class="fab fa-php"></i><span>PHP</span></a>
                <a href="courses.php?tag=development"><i class="fab fa-bootstrap"></i><span>bootstrap</span></a>
            </div>
        </div>
        <?php
        $is_tutor_user=$db->prepare("SELECT * FROM tutors WHERE idUser=?;");
        $is_tutor_user->execute([$user_id]);
        if($user_id && $is_tutor_user->rowCount()>0){
            $fetched_me_tutor=$is_tutor_user->fetch(PDO::FETCH_ASSOC);
        ?>
            <div class="box tutor">
                <h3 class="title">Welcome <?=$fetched_me_tutor['publicName']?></h3>
                <p>You logged in also as a Tutor!</p><br>
                <h3 class="title">You could create your own courses now!</h3><br>
                <a href='create_course.php' class="inline-option-button">CREATE MY COURSE</a><br>
                <p>OR</p>
                <a href='my_courses.php?id_tutor=<?=$fetched_me_tutor['idTutor']?>' class="inline-option-button">VIEW MY COURSES</a>
            </div>
        <?php
        }else{
        ?>
        <div class="box tutor">
            <h3 class="title">become a tutor</h3>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsa, laudantium.</p>
            <?php if($user_id){?>
            <a href="tutor_become.php?idUser=<?=$user_id?>" class="inline-button">get started</a>
            <?php }?>
        </div>
        <?php
        }
        ?>
    </div>

</section>



<section class="courses">

    <h1 class="heading">latest courses</h1>

    <div class="box-container">
        <?php
        $courses_selected = $db->prepare("SELECT * FROM courses WHERE statusCourse = 'active' ORDER BY dateUp DESC LIMIT 5");
        $courses_selected->execute();
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
            echo '<p class="empty_courses">no courses added yet!</p>';
        }
        ?>

    </div>

    <div class="more-button">
        <a href="courses.php" class="inline-option-button">view more</a>
    </div>

</section>












<footer class="footer">

    &copy; PROJECT @ <?= date('Y'); ?> by <i>Roman Herasymov</i> | Have a great day!

</footer>

</body>
</html>