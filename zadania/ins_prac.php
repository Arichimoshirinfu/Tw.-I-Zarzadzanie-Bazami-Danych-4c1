<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="description" content="Opis zawartości strony">
  	<title>Skrypt</title>
</head>
<body>
    <?php
        ini_set('display_errors', '0');
        mysqli_report(MYSQLI_REPORT_ERROR);

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

  	$naz=$_POST['nazwisko'];
	$imi=$_POST['imie'];
	$uid=$_POST['userid'];
	$tit=$_POST['title'];
	$did=$_POST['dept_id'];
  	$sal=$_POST['salary'];
	$sdt=$_POST['start_dt'];
	$mid=$_POST['man_id'];
	$uwa=$_POST['uwagi'];

        ##### STANOWISKO ##### 
        $sql_tit = "SELECT name FROM title;";
	$wyn_tit = mysqli_query($id_conn, $sql_tit);
        if (mysqli_errno($id_conn)) 
        {
            echo "Błąd w zapytania o stanowiska: " . $baza . ' (' . mysqli_error($id_conn) . ')';
	    mysqli_close($id_conn);
            exit;
        }

        $ok_tit=0;
        $titles = '';
        while($w_tit=mysqli_fetch_array($wyn_tit)) {
	    if ($w_tit['name']==$tit) {
 	  	$ok_tit=1;
            }
	    $titles = $titles . ', <br> -' . $w_tit['name'];			
	}          
	if ($ok_tit==0) {
	    echo 'Nie ma stanowiska "' . $tit . '", wybierz jedno z poniższych: '; 
            echo '<br>' . substr($titles,6);
            mysqli_close($id_conn);
            exit;   
	}

        
	if ($ok_man==0) {
	    echo 'Nie ma pracownika o numerze "' . $mid . '" - wybierz innego z bazy.';
            mysqli_close($id_conn);
            exit;   
	}

        $sql_wid = "SELECT job.salary_min, 
                           job.salary_max
                      FROM job
                     WHERE job.name = '$tit';";

	$wyn_wid = mysqli_query($id_conn, $sql_wid);
	if (mysqli_errno($id_conn)) 
	{
	  echo "Błąd w zapytania o widełki: " . $baza . ' (' . mysqli_error($id_conn) . ')';
	  mysqli_close($id_conn);
	  exit;
	}
        $w_wid = mysqli_fetch_array($wyn_wid);
	$wid_od = $w_wid['salary_min'];
	$wid_do = $w_wid['salary_max'];       

        if($sal<$wid_od || $sal>$wid_do) {
            echo 'Płaca poza widełkami przewidzianymi dla danego stanowiska (' . $wid_od . ' - ' . $wid_do . ')';
        }

        ######################
        $sql_ins = "INSERT INTO emp (id, first_name, last_name, userid, title, dept_id, 
                                     salary, start_date, manager_id, comments) 
                    VALUES (Null, '$imi','$naz','$uid','$tit','$did', 
                            '$sal', '$sdt','$mid', '$uwa' );";
        
	echo '<br><br>';
       
        if (!mysqli_query($id_conn, $sql_ins))
 	{
             echo 'Błąd zapisu do bazy: ' . mysqli_error($id_conn);
        } else {
	    echo "Dane zostały poprawnie zapisane do bazy " . $baza;
	}	       
        mysqli_close($id_conn) 
            or die("Nie można się rozłączyć z bazą MySQL!!"); 

    ?>
</body>
</html>