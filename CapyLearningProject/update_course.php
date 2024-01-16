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
}else header('location:main_page.php');

if(isset($_GET['id_course'])){
    $idCourse = $_GET['id_course'];
}else header('location:main_page.php');

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

$my_course=$db->query("SELECT * FROM courses WHERE idCourse='$idCourse'");
$materials_course=$db->query("SELECT * FROM coursematerials WHERE idCourse='$idCourse'");
$my_course=$my_course->fetch(PDO::FETCH_ASSOC);
$materials_course=$materials_course->fetch(PDO::FETCH_ASSOC);

if(isset($_POST['name']) && isset($_POST['tags']) && isset($_POST['image']) && isset($_POST['description'])){
    if($_POST['name']!=$my_course['nameCourse']){
        $db->query("UPDATE courses SET nameCourse='${_POST['name']}' WHERE idCourse='$idCourse'");
    }
    if($_POST['tags']!=$my_course['tags']){
        $db->query("UPDATE courses SET tags='${_POST['tags']}' WHERE idCourse='$idCourse'");
    }
    if($_POST['image']!=$my_course['image']){
        $db->query("UPDATE courses SET image='${_POST['image']}' WHERE idCourse='$idCourse'");
    }
    if($_POST['description']!=$materials_course['description']){
        $db->query("UPDATE coursematerials SET description='${_POST['description']}' WHERE idCourse='$idCourse'");
    }
    if (isset($_POST['submit'])){
        header("Location: main_page.php");
    }
    if (isset($_POST['submitEx'])){
        $exercises=$db->query("SELECT * FROM practice WHERE idCourse='$idCourse'");
        if($exercises->rowCount()>0) {
            header("Location: update_exercises.php?course_id=$idCourse&exercise=1");
            exit();
        }
        else{
            header("Location: create_exercises.php?course_id=$idCourse&exercise=1");
            exit();
        }
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

    <h1 class="heading">My course</h1>
    <div style="font-size: 20px">
        <form method="post">
            <fieldset style="border: 2px dashed crimson; width: fit-content; height: fit-content; padding: 15px">
                Course name:<input type="text" name="name" value="<?=$my_course['nameCourse']?>" required><br>
                Image: <input type="text" name="image" value="<?=$my_course['image']?>" placeholder="provide with link..."><br>
                Tags: <select name="tags">
                    <option selected><?=$my_course['tags']?></option>
                    <option>all</option>
                    <option>development</option>
                    <option>business</option>
                    <option>design</option>
                    <option>marketing</option>
                    <option>music</option>
                    <option>photography</option>
                    <option>software</option>
                    <option>science</option>
                </select><br>
                Description: <textarea name="description" style="width: 150px; height: 150px; border: 1px solid #ccc;" required><?=$materials_course['description']?></textarea><br>
                <div id="videos-container">
                    <div class="video-input">
                        <input type="text" name="videos[]" placeholder="Enter video URL">
                        <button class="remove-video-btn">Remove</button>
                    </div>
                </div>
                <button id="add-video-btn">Add Video</button><br>
                <button type="submit" name="submit" class="inline-option-button">UPDATE</button>  OR   <button type="submit" name="submitEx" class="inline-option-button">UPDATE TASKS</button>
            </fieldset>
        </form>
    </div>
</section>




<footer class="footer">

    &copy; PROJECT @ <?= date('Y'); ?> by <i>Roman Herasymov</i> | Have a great day!

</footer>




<script>
    function addVideoInput(event) {
        event.preventDefault();
        var container = document.getElementById('videos-container');
        var videoInput = document.createElement('div');
        videoInput.classList.add('video-input');
        videoInput.innerHTML = `
                <input type="text" name="videos[]" placeholder="Enter video URL">
                <button class="remove-video-btn">Remove</button>
            `;
        container.appendChild(videoInput);
    }


    function removeVideoInput(event) {
        event.preventDefault();
        var videoInput = event.target.parentNode;
        videoInput.parentNode.removeChild(videoInput);
    }


    document.getElementById('add-video-btn').addEventListener('click', addVideoInput);


    document.addEventListener('click', function(event) {
        if (event.target && event.target.classList.contains('remove-video-btn')) {
            removeVideoInput(event);
        }
    });

    function getVideos() {
        var videoInputs = document.querySelectorAll('.video-input input[name="videos[]"]');
        var videos = Array.from(videoInputs).map(function(input) {
            return input.value;
        });
        console.log(videos);
    }

</script>


</body>
</html>


