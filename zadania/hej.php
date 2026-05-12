<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <a href="">Jeszcze raz!</a>
    <?php 
    $tablica = ['papier' => 'papier',
                'kamien' => 'kamien',
                'nozyce' => 'nozyce'
                ];
    $losowa = array_rand($tablica, 1);
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        if($_POST['wybor'] == 'papier'){
            if($losowa == 'kamien'){
                $wynik = 'Wygrana';
            }
            elseif($losowa == $_POST['wybor']){
                $wynik = 'Remis';
            }
            else{
                $wynik = 'Przegrana';
            }
        };

        if($_POST['wybor'] == 'kamien'){
            if($losowa == 'nozyce'){
                $wynik = 'Wygrana';
            }
            elseif($losowa == $_POST['wybor']){
                $wynik = 'Remis';
            }
            else{
                $wynik = 'Przegrana';
            }
        };

        if($_POST['wybor'] == 'nozyce'){
            if($losowa == 'papier'){
                $wynik = 'Wygrana';
            }
            elseif($losowa == $_POST['wybor']){
                $wynik = 'Remis';
            }
            else{
                $wynik = 'Przegrana';
            }
        };
    };
    ?>
    <?php  
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        echo $wynik . '<br>';
        echo 'Twój wybór: ' . print_r($_POST['wybor'], true);
        echo '<br>Wybór ejaj: ' . print_r($losowa, true);
    }
    else {
        ?>
        <form method="post">
            <input type="checkbox" name="wybor" value="papier" id="papier"><label for="papier">Papier</label><br>
            <input type="checkbox" name="wybor" value="kamien" id="kamien"><label for="kamien">Kamień</label><br>
            <input type="checkbox" name="wybor" value="nozyce" id="nozyce"><label for="nozyce">Nożyce</label><br>
            <button type="submit" value="wyslij">Wyslij</button>
        </form>
        <?php } 
        ?>
</body>
</html>