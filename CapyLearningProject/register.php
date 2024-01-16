<?php
session_start();
//$dbuser = 'root';
//$dbpass = '';
//$db = new PDO("mysql:host=localhost;dbname=CapyLearning", $dbuser,$dbpass);
$dbuser = 's28856';
$dbpass = 'Rom.Hera';
$host='szuflandia.pjwstk.edu.pl';
$db=new PDO("mysql:host=$host;dbname=s28856", $dbuser,$dbpass);
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
        <legend>Registration</legend>
        <div class="flex">
            <div class="col">
            Login: <input type="text" name="login" id="login" placeholder="(Enter your login)" required></br>
            Email: <input type="text" name="email" id="email" placeholder="(Enter your email)" pattern="\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+" required></br>
            Password: <input type="password" name="password" id="password" placeholder="(6+ symbols, 1+ capital letter, 1 number, 1 special char)"  style="width: 350px" pattern="^(?=[^A-Z]*[A-Z])(?=\D*\d)(?=[^!@#$%^&*()<>?]*[!@#$%^&*()<>?])[^~]{6,}$" required>
        </div>
        </div>
        <input type="submit" name="submit" value="SUBMIT">
</form>
    <section class="form-container">
<?php
if(empty($_SESSION['email']) && empty($_SESSION['password'])){
    if(isset($_POST['login']) && isset($_POST['password']) && isset($_POST['email'])){
        if(preg_match("/\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+/", $_POST['email']) && preg_match("/^(?=[^A-Z]*[A-Z])(?=\D*\d)(?=[^!@#$%^&*()<>?]*[!@#$%^&*()<>?])[^~]{6,}$/", $_POST['password'])) {
            $notDup=true;
            $findDupNames=$db->query("SELECT * FROM users");
            while ($row = $findDupNames->fetch(PDO::FETCH_ASSOC)) {
                if ($row['email'] == $_POST['email']) {
                    $notDup=false;
                    echo "<br><div style='font-size: 50px; color: crimson'>Somebody is already under this email!</div>";
                    break;
                }
            }
            if($notDup){
                $_SESSION['email']=$_POST['email'];
                $_SESSION['password']=$_POST['password'];
                $result=$db->prepare("INSERT INTO users(loginUser, passwordUser, email) VALUES (?, ?, ?)");
                $result->execute([$_POST['login'],$_POST['password'],$_POST['email']]);
                $email=$_POST['email'];
                $get_user_id=$db->query("SELECT * FROM users WHERE email='$email'");
                $get_fetched_user_id=$get_user_id->fetch(PDO::FETCH_ASSOC);
                $_SESSION['idUser']=$get_fetched_user_id['idUser'];
                header("Location: main_page.php");
                exit();}
        }
        else echo "<br><div style='font-size: 100px; color: crimson'>Note: Incorrect form of Password or Login</div>";
    }
}
else header("Location: login.php");
?>
</body>
</html>
