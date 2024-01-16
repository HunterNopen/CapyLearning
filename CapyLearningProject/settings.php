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
$get_user=$db->query("SELECT * FROM users WHERE idUser='$user_id'");
$info=$get_user->fetch(PDO::FETCH_ASSOC);
$is_tutor_user = $db->query("SELECT * FROM tutors WHERE idUser='$user_id';");
$tutorInfo=$is_tutor_user->fetch(PDO::FETCH_ASSOC);

if(isset($_POST['password']) && preg_match("/^(?=[^A-Z]*[A-Z])(?=\D*\d)(?=[^!@#$%^&*()<>?]*[!@#$%^&*()<>?])[^~]{6,}$/", $_POST['password'])){
    if($_POST['cur_password']==$info['passwordUser']){
        $db->query("UPDATE users SET passwordUser='${_POST['password']}' WHERE idUser='$user_id'");
        $message[]="Password updated!";
    }
    else $message[]="Password is illegal or wrong given current one!";
}
if(isset($_POST['login']) && $info['loginUser']!=$_POST['login']){
    $message[]="Updated login section!";
    $db->query("UPDATE users SET loginUser='${_POST['login']}' WHERE idUser='$user_id'");
}
if(isset($_POST["publicName"]) && $tutorInfo['publicName']!=$_POST["publicName"]){
    $message[]="Updated your Tutor Name section!";
    $db->query("UPDATE tutors SET publicName='${_POST['publicName']}' WHERE idUser='$user_id'");
}
if(isset($_POST['email']) && $info['email']!=$_POST['email'] && preg_match("/\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+/",$_POST['email'])){
    $message[]="Updated email section!";
    $db->query("UPDATE users SET email='${_POST['email']}' WHERE idUser='$user_id'");
}
if(isset($_POST['image_update']) && $info['image']!=$_POST['image_update']){
    $message[]="Updated image section!";
    $db->query("UPDATE users SET image='${_POST['image_update']}' WHERE idUser='$user_id'");
}
if(isset($_POST['about']) && $info['about']!=$_POST['about']){
    $message[]="Updated about section!";
    $db->query("UPDATE users SET about='${_POST['about']}' WHERE idUser='$user_id'");
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

<section>
    <form method="POST" class="register">
        <fieldset>
            <legend>Settings</legend>
            LoginUser: <input type="text" name="login" id="login" value=<?=$info['loginUser']?> required></br>
            <?php
            if ($user_id && $is_tutor_user->rowCount() > 0) {
                echo "Public Tutor Name:<input type='text' name='publicName' id='publicName' value='${tutorInfo['publicName']}'></br>";
            }
            ?>
            Email: <input type="text" name="email" id="email" value="<?=$info['email']?>" pattern="\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+"></br>
            <img src="<?=$info['image']?>" width="100px"> Your current image!<br><input type="file" name="image_update" id="image_update"><br>
            About myself: <br><input type="text" name="about" id="about" value="<?=$info['about']?>"><br>
            Type current password: <input type="password" name="cur_password" id="cur_password" placeholder="(6+ symbols, 1+ capital letter, 1 number, 1 special char)"  style="width: 350px" pattern="^(?=[^A-Z]*[A-Z])(?=\D*\d)(?=[^!@#$%^&*()<>?]*[!@#$%^&*()<>?])[^~]{6,}$"></br>
            Change Password: <input type="password" name="password" id="password" placeholder="(6+ symbols, 1+ capital letter, 1 number, 1 special char)"  style="width: 350px" pattern="^(?=[^A-Z]*[A-Z])(?=\D*\d)(?=[^!@#$%^&*()<>?]*[!@#$%^&*()<>?])[^~]{6,}$"></br>
            <input type="submit" name="update" value="UPDATE">   <input type="submit" name="delete" value="DELETE USER" class="inline-button">  <a href="user_profile.php">PROFILE</a>
            <?php
            if(isset($message)){
                foreach($message as $messages){
                    echo '<div class="message">
                            <span>'.$messages.'</span>
                            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
                          </div>';
                }
            }
            ?>
        </fieldset>
    </form>
</body>
</html>
<?php
if(isset($_POST['update'])){
    $_SESSION['messages']=$message;
   header("Location: show_updates.php");
    exit();
}
if(isset($_POST['delete'])){
    $db->query("DELETE FROM users WHERE idUser='$user_id'");
    session_destroy();
    header("Location: main_page.php");
}
?>