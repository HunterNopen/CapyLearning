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
    header("Location: main_page.php");
}
if (!isset($_SESSION['messages'])){
    $_SESSION['messages'][]="NO UPDATES DONE";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <title>Settings</title>
    <style>
        *{
            font-size: 30px;
        }
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f1f1f1;
        }

        form {
            width: 80%;
            height: fit-content;
            margin: auto;
        }

        fieldset {
            border: 2px solid;
            height: fit-content;
            width: 500px;
            margin: auto;
            padding: 20px;
            background-color: #fff;
        }

        legend {
            font-weight: bold;
            font-size: 1.2em;
            margin-bottom: 10px;
        }

        input[type="submit"] {
            padding: 10px 20px;
            background-color: crimson;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background-color: #29394BFF;
        }
    </style>
</head>
<body>

<section>
    <form method="POST" class="register">
        <fieldset>
            <legend>Updates</legend>
            <?php
                foreach($_SESSION['messages'] as $messages){
                    echo '<div class="message">
                            <span>'.$messages.'</span>
                            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
                          </div>';
                }
            ?>
            <input type="submit" name="back" value="UPDATE MORE">     <a href="user_profile.php">PROFILE</a>
        </fieldset>
    </form>
</body>
</html>
<?php
if(isset($_POST['back'])){
    unset($_SESSION['messages']);
    header("Location: settings.php");
    exit();
}
?>
