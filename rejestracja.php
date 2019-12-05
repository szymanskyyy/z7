<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <title>Szymański</title>
</head>
<body>
    <h1>Rejestracja:</h1>
    <form action="" method="post">
        Login: <br><input type="text" required name="login"><br><br>
        Hasło: <br><input type="password" required name="pass1"><br><br>
        Potwierdzenie hasła: <br><input type="password" name="pass2"><br><br>
        <input type="submit" name="rejestruj" value="Zarajestruj">
    </form>
<?php
function addToDataBase($nick,$haslo){
    $connect = new mysqli('localhost','31570676_zad7','QWEasd123.','31570676_zad7');
    mysqli_set_charset($connect, "utf8");
    mysqli_query($connect, "INSERT INTO `users`(`idu`, `nick`, `haslo`) 
    VALUES (NULL,'$nick','$haslo')");    
    mkdir($nick);
}
if(isset($_POST['rejestruj'])){
    $login = $_POST['login'];
    $pass1 = $_POST['pass1'];
    $pass2 = $_POST['pass2'];
    if($pass1 == $pass2){
        addToDataBase($login,$pass1);
        echo "<script>window.location = './index.php'</script>";
    }else{
        echo "<p style='color:red;'>Hasła nie są takie same!";
    }
}
?>
</body>
</html>