<?php
function login($nick,$haslo){
    $connect = new mysqli('localhost','31570676_zad7','QWEasd123.','31570676_zad7');
    mysqli_set_charset($connect, "utf8"); 
    $yourQuery = $connect -> query("SELECT * FROM users WHERE nick LIKE '$nick'");
    $person = $yourQuery -> fetch_assoc();
    if($_COOKIE['blokada'] != 1){
        if($person['nick'] == $nick && $person['haslo'] == $haslo){
            $idu = $person['idu'];
            setcoovvkie('idu',"$idu");
            setcookie('nick',"$nick");
            echo "<script>window.location = './panel.php'</script>";
        }
        else {
            $idu = $person['idu'];
            $Query = $connect -> query("SELECT * FROM logi WHERE idu LIKE $idu");
            if($Query -> num_rows != 0){
                $logs = $Query -> fetch_assoc();
                $next_fail = $logs['bledy_logowania'] - 1;
                if($next_fail == 0){
                    setcookie('blokada', 1 ,time()+60);
                    $connect -> query("UPDATE `logi` SET `bledy_logowania`=2 WHERE idu LIKE $idu");
                    echo "<p style='color:red;'>Twoje konto zostało zablokowane. Spróbuj ponownie za minutę.</p>";
                }
                else{
                    echo "<p style='color:red;'>Nieprawidłowe dane logowania. Pozostała $next_fail próby logowania!</p>";
                    $connect -> query("UPDATE `logi` SET `bledy_logowania`=$next_fail WHERE idu LIKE $idu");
                }
                
            }
            else{
                echo "<p style='color:red;'>Nieprawidłowe dane logowania. Pozostały 2 próby!</p>";
                $connect -> query("INSERT INTO `logi`(`idl`, `idu`, `bledy_logowania`) 
                VALUES (NULL,$idu,2)");
            }  
        }
    }
    else{
        echo "<p style='color:red;'>Twoje konto zostało zablokowane. Spróbuj ponownie później.</p>";
    }
}
if(isset($_POST['zaloguj'])){
    $login = $_POST['login'];
    $pass1 = $_POST['pass1'];
    login($login,$pass1);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <title>Szymański</title>
    <style>
        body {
            padding: 50px;
        }
    </style>
</head>
<body>
<h2>Zaloguj:</h2>
<form action="" method="post">
        Login: <br><input type="text" value="<?php echo "$_COOKIE[nick]";?>"required name="login"><br><br>
        Hasło: <br><input type="password" required name="pass1"><br><br>
        <input type="submit" name="zaloguj" value="Zaloguj">
    </form><br>
    <a href="./rejestracja.php">Rejestracja</a>
</body>
</html>
