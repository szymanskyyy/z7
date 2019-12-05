<?php
$plik_tmp = $_FILES['plik']['tmp_name'];
$plik_nazwa = $_FILES['plik']['name'];
$folder = $_COOKIE['nick'];
$temporary_folder = $_POST['folderName'];

if(is_uploaded_file($plik_tmp)) {
    if ($_FILES['plik']['size'] > 1000000) {
        echo "Za duży plik"; 
    }
    else {  
        if (isset($_FILES['plik']['type'])) {
            echo 'Typ: '.$_FILES['plik']['type'].'<br/>'; 
        }
        if(!empty($temporary_folder)){
            move_uploaded_file($plik_tmp, "$folder/$temporary_folder/$plik_nazwa");
        }
        else {
            move_uploaded_file($plik_tmp, "$folder/$plik_nazwa");
        }
        echo "Pomyślnie przesłano plik: <em>$plik_nazwa</em>";
    }
}         
else {
    echo 'Błąd przy przesyłaniu danych!';
}
?>