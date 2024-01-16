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

$idTutor=$db->query("SELECT idTutor FROM tutors JOIN users u on tutors.idUser = u.idUser");
$idTutor=$idTutor->fetch(PDO::FETCH_ASSOC);
$id_tutor=$idTutor['idTutor'];

if( isset($_POST['name']) && isset($_POST['description']) && isset($_POST['image'])){
        $db->query("INSERT INTO courses(idTutor, nameCourse, image, tags) VALUES ('$id_tutor', '${_POST['name']}', '${_POST['image']}','${_POST['tags']}') ");
        $select_course_id=$db->query("SELECT * FROM courses WHERE idTutor = '$id_tutor' ORDER BY idCourse DESC LIMIT 1");
        $select_course_id=$select_course_id->fetch(PDO::FETCH_ASSOC);
        $course_id=$select_course_id['idCourse'];
        $db->query("INSERT INTO coursematerials(idCourse, description, video) VALUES ('$course_id', '${_POST['description']}', '${_POST['videos[]']}') ");
    if(isset($_POST['submitEx'])){
        header("Location: create_exercises.php?course_id=$course_id&exercise=1");
        exit();}
    if(isset($_POST['submit'])){
        header("Location: main_page.php");
        exit();}
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
        Course name:<input type="text" name="name" required><br>
        Image: <input type="text" name="image" placeholder="provide with link..."><br>
        Tags: <select name="tags">
            <option selected>all</option>
            <option>development</option>
            <option>business</option>
            <option>design</option>
            <option>marketing</option>
            <option>music</option>
            <option>photography</option>
            <option>software</option>
            <option>science</option>
        </select><br>
        Description: <textarea name="description" style="width: 150px; height: 150px; border: 1px solid #ccc;" required></textarea><br>
        <div id="videos-container">
            <div class="video-input">
                <input type="text" name="videos[]" placeholder="Enter video URL">
                <button class="remove-video-btn">Remove</button>
            </div>
        </div>
        <button id="add-video-btn">Add Video</button><br>
        <button type="submit" name="submit" class="inline-option-button">CREATE</button>  OR   <button type="submit" name="submitEx" class="inline-option-button">MAKE TASKS</button>
    </fieldset>
</form>
    </div>
</section>




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
    }
</script>

<footer class="footer">

    &copy; PROJECT @ <?= date('Y'); ?> by <i>Roman Herasymov</i> | Have a great day!

</footer>

</body>
</html>

