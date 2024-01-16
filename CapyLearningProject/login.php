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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
    <title>Login</title>
    <style>
        *{
            font-size: 30px;
        }
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f1f1f1;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 80vh;
        }

        form {
            width: 100%;
            height: fit-content;
            margin: 0 auto;
        }

        fieldset {
            border: 2px solid;
            height: 800px;
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
<form method="POST">
    <fieldset style="width: 30%;height: fit-content;margin-right: auto; margin-left: auto">
        <legend>Login</legend>
            <?php
            if (isset($_SESSION['email']) && isset($_SESSION['password'])) {
                echo "<br><div style='font-size: 50px; color: greenyellow'>You are already LOGGED IN!</div>";
                echo '<form><div class="flex-button">
                <a href="logout.php" onclick="return confirm("logout from this website?");" class="delete-button">logout</a></div>
                <a href="main_page.php" class="option-button">Return to main page</a></form></div>';
            } else {
                echo "<form> Email: <input type='text' name='email' id='email' placeholder='(Enter your email)' required></br>
                Password: <input type='password' name='password' id='password' placeholder='(Enter your password)' required></form>
                <input type='submit' name='submit' value='SUBMIT'>";

                if (isset($_POST['email']) && isset($_POST['password'])){
                    $loggedin=false;
                    $email = $_POST['email'];
                    $password = $_POST['password'];
                    $check_password=$db->prepare("SELECT email, passwordUser FROM users WHERE email = ? AND passwordUser = ?");
                    $check_password->execute([$email, $password]);
                    if($check_password->fetch(PDO::FETCH_ASSOC)){
                        $loggedin=true;
                        $get_user_id=$db->query("SELECT * FROM users WHERE email='$email'");
                        $get_fetched_user_id=$get_user_id->fetch(PDO::FETCH_ASSOC);
                        $_SESSION['idUser']=$get_fetched_user_id['idUser'];
                        $_SESSION['email']=$email;
                        $_SESSION['password']=$password;
                        header("Location: main_page.php");
                    }
                    if(!$loggedin){
                        echo "<br><div style='font-size: 100px; color: crimson'>Incorrect password or login!</div>";
                    }

                }
            }
            ?>
</form>
</body>
</html>
