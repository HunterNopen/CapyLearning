<?php
session_start();
//$dbuser = 'root';
//$dbpass = '';
//$db = new PDO("mysql:host=localhost;dbname=CapyLearning", $dbuser,$dbpass);
$dbuser = 's28856';
$dbpass = 'Rom.Hera';
$host='szuflandia.pjwstk.edu.pl';
$db=new PDO("mysql:host=$host;dbname=s28856", $dbuser,$dbpass);

if(isset($_GET['idUser'])){
    $user_id=$_GET['idUser'];
    $is_tutor_user=$db->prepare("SELECT * FROM tutors WHERE idUser=?;");
    $is_tutor_user->execute([$user_id]);
    if($is_tutor_user->rowCount()>0){
        header("Location: main_page.php");
    }
}else header("Location: main_page.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <title>Register</title>
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
            width: 30%;
            height: fit-content;
            margin: 0 auto;
        }

        fieldset {
            border: 2px solid;
            height: 320px;
            width: fit-content;
            margin: auto;
            padding: 20px;
            background-color: #fff;
        }

        legend {
            font-weight: bold;
            font-size: 1.2em;
            margin-bottom: 10px;
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 14px;
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
<section class="form-container">
    <form method="POST" class="register">
        <fieldset>
            <legend>Become a Tutor</legend>
            <div class="flex">
                <div class="col">
                    PublicName: <input type="text" name="publicName" id="publicName" placeholder="(Enter your login)" required></br>
                    File(proof yours qualification): <input type="file" name="docs" id="docs"  required>
                </div>
            </div>
            <input type="submit" name="submit" value="SUBMIT">
    </form>
    <section class="form-container">
        <?php
            if(isset($_POST['publicName']) && isset($_POST['docs'])){
                $db->query("INSERT INTO tutors(idUser, publicName) VALUES ('$user_id', '${_POST['publicName']}')");
                header("Location: main_page.php");
            }
        ?>
</body>
</html>

