<header class="header">

    <section class="flex">

        <a href="main_page.php" class="logotype"><img src="images_source/capybara_main.webp" width="70px" height="70px" alt=""> CapyLearning.</a>

        <form action="search.php" method="get" class="search-form">
            <input type="text" name="search" placeholder="search courses..." required maxlength="100">
            <button type="submit" class="fas fa-search" name="search_course_button"></button>
        </form>

        <div class="icons">
            <div id="menu-button" class="fas fa-bars"></div>
            <div id="search-button" class="fas fa-search"></div>
            <div id="user-button" class="fas fa-user"></div>
            <div id="toggle-button" class="fas fa-sun"></div>
        </div>

    </section>

</header>

<div class="side-bar">

    <div class="close-side-bar">
        <i class="fas fa-times"></i>
    </div>

    <div class="profile">
        <?php
        $get_user_profile=$db->prepare("SELECT * FROM users WHERE idUser=?");
        $get_user_profile->execute([$user_id]);
        if($get_user_profile->rowCount()>0){
            $user_profile=$get_user_profile->execute([$user_id]);
            $fetched_profile = $get_user_profile->fetch(PDO::FETCH_ASSOC);
            ?>
            <img src="<?=$fetched_profile['image'];?>">
            <h3><?=$fetched_profile['loginUser'];?></h3>
            <span><?php
                $is_tutor_user=$db->prepare("SELECT * FROM tutors WHERE idUser=?;");
                $is_tutor_user->execute([$user_id]);
                if($user_id && $is_tutor_user->rowCount()>0){
                    echo "CapyTutor";}
                else echo "CapyStudent";
                ?></span>
            <a href="user_profile.php" class="button">view profile</a>
            <div class="flex-button">
                <a href="logout.php" onclick="return confirm('logout from this website?');" class="delete-button">logout</a>
                <a href="register.php" class="option-button">register+</a>
            </div>
            <?php
            $is_admin=$db->query("SELECT * FROM admins WHERE idUser='$user_id'");
            if($is_admin->rowCount()>0){
                ?>
            <a href="admin.php?idUser=<?=$user_id?>" class="option-button">admin panel</a>
            <?php
            }
        }else{
            ?>
            <img src="images_source/pochita_student.jpg">
            <h3>please login or register</h3>
            <div class="flex-button">
                <a href="login.php" class="option-button">login</a>
                <a href="register.php" class="option-button">register</a>
            </div>
            <?php
        }
        ?>
    </div>

    <nav class="navbar">
        <a href="main_page.php"><i class="fas fa-home"></i><span>home</span></a>
        <a href="saved_courses.php"><i class="fas fa-question"></i><span>saved courses</span></a>
        <a href="courses.php"><i class="fas fa-graduation-cap"></i><span>courses</span></a>
        <a href="top_courses.php"><i class="fas fa-chalkboard-user"></i><span>top community</span></a>
        <a href="https://mail.google.com/"><i class="fas fa-headset"></i><span>contact us</span></a>
        <a href="image.php"><i class="fas fa-address-book"></i><span>image</span></a>
    </nav>

</div>