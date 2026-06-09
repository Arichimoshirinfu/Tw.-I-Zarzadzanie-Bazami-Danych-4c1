<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
    <?php

        $host  = 'localhost'; 
        $user  = 'root';
        $haslo = '';
        $baza  = 'baza_testowa';

        $id_conn = mysqli_connect($host, $user, $haslo, $baza);
        if (mysqli_connect_errno()) 
        {
            echo "Błąd połączenia z MySQL z bazą: " . $baza . ' (' . mysqli_connect_error() . ')';
            exit;
        }
        
    ?>

    

</body>
</html>