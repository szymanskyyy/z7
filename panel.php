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
<html>      
<form action="wyloguj.php">
	<button type="submit">Wyloguj</button>
</form><br>
<h2>Witaj <?php echo $_COOKIE['nick'] ?>!</h2><br>
<?php
    $connect = new mysqli('localhost','31570676_zad7','QWEasd123.','31570676_zad7');
    $idu = $_COOKIE['idu'];
    $Query = $connect -> query("SELECT * FROM logi WHERE idu LIKE $idu");
        if($Query -> num_rows != 0){
            $logs = $Query -> fetch_assoc();
            $data_error = $logs['datatime'];
            echo "<p style='color: red'>Ostatnia próba nieudanego logowania: $data_error</p>";
        }
        else {
            echo "Nie zarejestrowano nieudanych prób logowania na Twoje konto<br><br>";
        }
    function delLogs($idu){
        global $connect;
        $connect -> query("DELETE FROM `logi` WHERE idu LIKE $idu");
    }
    if(isset($_POST['delLogs'])){
        delLogs($idu);
    }
?>
<form action="" method="POST">
    <input type="submit" name="delLogs" value="Usuń logi">
</form>
<br>
<h2>Załaduj plik:</h2><br>
<form action="odbierz.php" method="POST" ENCTYPE="multipart/form-data">      
    Nazwa podfolderu: <input type="text" name="folderName"/><br><br>  
    <input type="file" name="plik"/>              
    <input type="submit" value="Wyślij plik"/>       
</form><br><br>
<h2>Stwórz folder:</h2><br>
<form action="newfolder.php" method="post">
   Nazwa: <input type="text" required name="newfolder"><br><br>
   Stwórz nowy foler: <input type="submit" value='Stwórz folder' name="addFolder">
</form>
<br><br>
<h2>Podkatalogi:</h2><br>
<?php
    $folder = $_COOKIE['nick'];
    if ($handle = @opendir("$folder")) {
        while ($file = @readdir($handle)) {
            if ($file != "." && $file != "..") {
                if($next_step = @opendir("$folder/$file")){
                    echo "$folder/$file";
                    echo "<ol>";
                    while($files = @readdir($next_step)){
                        if ($files != "." && $files != "..") {
                            echo "<u1><a href='$folder/$file/$files'>".$files."</a></u1>";
                        }
                    }
                    echo "</ol>";
                }
                else
                {
                    $thelist .= "<u1><a href='$folder/$file'>".$file."</a></u1>";
                }
            }
        }
    }
    closedir($handle);
?>
<h2>Katalog główny:</h2>
<ul><?php echo $thelist; ?></ul>
</body>
</html>
