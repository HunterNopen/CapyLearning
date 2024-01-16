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

if (isset($_GET['course_id']) && isset($_GET['exercise'])){
    $course_id=$_GET['course_id'];
    $exercise=$_GET['exercise'];
}else header("Location: main_page.php");

$idTutor=$db->query("SELECT idTutor FROM tutors JOIN users u on tutors.idUser = u.idUser");
$idTutor=$idTutor->fetch(PDO::FETCH_ASSOC);
$id_tutor=$idTutor['idTutor'];

if(isset($_POST['task']) && isset($_POST['answer'])){
    $db->query("INSERT INTO practice(idCourse,number, description, answer) VALUES ('$course_id', '$exercise', '${_POST['task']}', '${_POST['answer']}')");
    if (isset($_POST['submit'])){
        header("Location: main_page.php");
    }
    elseif (isset($_POST['submitEx'])){
        $exercise++;
        header("Location: create_exercises.php?course_id=$course_id&exercise=$exercise");
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
                Task description:<input type="text" name="task" placeholder=" volume of exercise..." required><br>
                Answer: <input type="text" name="answer" placeholder=" provide with link..."><br>
                Videos(optional):
                <div id="videos-container">
                    <div class="video-input">
                        <input type="text" name="videos[]" placeholder="Enter image URL">
                        <button class="remove-video-btn">Remove</button>
                    </div>
                </div>
                <button id="add-video-btn">Add Video</button><br>
                Images(optional):
                <div id="images-container">
                    <div class="image-input">
                        <input type="text" name="images[]" placeholder="Enter image URL">
                        <button class="remove-image-btn">Remove</button>
                    </div>
                </div>
                <button id="add-image-btn">Add Image</button><br>
                <button type="submit" name="submit" class="inline-option-button">CREATE</button>  OR   <button type="submit" name="submitEx" class="inline-option-button">MAKE MORE TASKS</button>
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

    function addImageInput(event) {
        event.preventDefault();
        var container = document.getElementById('images-container');
        var imageInput = document.createElement('div');
        imageInput.classList.add('image-input');
        imageInput.innerHTML = `
                <input type="text" name="images[]" placeholder="Enter video URL">
                <button class="remove-image-btn">Remove</button>
            `;
        container.appendChild(imageInput);
    }


    function removeImageInput(event) {
        event.preventDefault();
        var imageInput = event.target.parentNode;
        imageInput.parentNode.removeChild(imageInput);
    }


    document.getElementById('add-image-btn').addEventListener('click', addImageInput);


    document.addEventListener('click', function(event) {
        if (event.target && event.target.classList.contains('remove-image-btn')) {
            removeImageInput(event);
        }
    });

    function getImages() {
        var imageInputs = document.querySelectorAll('.image-input input[name="images[]"]');
        var images = Array.from(imageInputs).map(function(input) {
            return input.value;
        });
        console.log(images);
    }
</script>

</body>
</html>


