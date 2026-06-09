<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="description" content="Nowak Klasa 3Dg">
	<title>Strona główna</title>
</head>
<body>
    <h2 align="center">AKTUALIZACJA DANYCH PRACOWNIKÓW</h2>
    <?php

        ini_set('display_errors', '0'); # wyłączenie komunikatów systemowych
        mysqli_report(MYSQLI_REPORT_ERROR);

        $baza = 'baza_testowa_g04';
	$host = 'localhost';
	$user = 'root';
	$passwd = '';	

	#podłączenie do bazy danych
        $id_conn = mysqli_connect($host, $user, $passwd, $baza);

        $conn_err = mysqli_connect_errno();
        
        if ($conn_err)
        {
            switch($conn_err)
    	    {
	        case 1049:
	            $kom="Nieprawidłowa nazwa bazy danych (" . $baza . ")";
    		    break;
	        case 2002:
	            $kom="Nieprawidłowa nazwa hosta (" . $host . ")";
		    break;
                case 1045:
	            $kom="Nieprawidłowe hasło";
		    break;
   	        default:
                    $kom="Inny błąd " . mysqli_connect_error();
                    break;
	    }
            echo "Błąd połączenia z MySQL nr " . $conn_err . ": " . $kom;
            exit; 
        }
	//////////////////////////////////////////////////////
         //echo "---> ". $_POST['nazwisko'] . ' ' . $_POST['imie'] . ' ' . $_POST['id'];       
	 if (!empty($_POST['nazwisko']) & !empty($_POST['imie']) & !empty($_POST['id'])) {
       
            $id      = $_POST['id'];
   	    $nazwisko= $_POST['nazwisko'];
	    $imie    = $_POST['imie'];
	    $username= $_POST['username'];
	    $stan    = $_POST['title'];
	    $depid   = $_POST['dept_id'];
	    $salary  = $_POST['salary'];
	    $startdt = $_POST['start_dt'];
	    $manid   = $_POST['man_id'];
	    $uwagi   = $_POST['uwagi'];

        $sql_upd = "UPDATE emp
                       SET emp.username   = '$username',
                           emp.title      = '$stan', 
                           emp.dept_id    = '$depid', 
                           emp.salary     = '$salary', 
                           emp.start_date = '$startdt', 
                           emp.manager_id = '$manid', 
                           emp.comments   = '$uwagi', 
                           emp.last_name  = '$nazwisko', 
                           emp.first_name = '$imie'
                     WHERE emp.id = '$id';";

        
		echo '<br><br>';
       
	        if (!mysqli_query($id_conn, $sql_upd))
 		{
	           $errno = mysqli_errno($id_conn);
	           if (!$wynik) {
		        switch($errno)
    		        {
		    	        case 1054:
		        	    $kom="Błąd 1054: Nieznana kolumna (" .mysqli_error($id_conn) . ")";
				    break;
			        case 1146:
			            $kom="Błąd 1146: Tabela nie istnieje (" .mysqli_error($id_conn) . ")";
				    break;
			        case 1064:
			            $kom="Błąd 1064: Błąd składni SQL (" .mysqli_error($id_conn) . ")";
				    break;
				case 1452:
		        	    $kom="Błąd 1452: Dane spoza słownika (" . $stan . ' '. $depid . ' '. $manid. ")";
				    break;
		   	        default:
        		            $kom="Inny błąd: " . mysqli_errno($id_conn) . " (" .mysqli_error($id_conn) . ")";
	        	            break;
	 	       }
	               echo 'Nie mogę wykonać zapytania: ' . $kom;
	           } else echo "Dane pracownika $imie $nazwisko zostały poprawnie zapisane do bazy $baza <br>";
   		
		}
	 }
	//////////////////////////////////////////////////////
        $zapytanie = "SELECT emp.id,
                             emp.last_name,
                             emp.first_name,
  			     emp.title
                     FROM emp;";
        $wynik = mysqli_query($id_conn, $zapytanie);

        $errno = mysqli_errno($id_conn);

        if (!$wynik) {
	    switch($errno)
    	    {
	        case 1054:
	            $kom="Błąd 1054: Nieznana kolumna (" .mysqli_error($id_conn) . ")";
		    break;
	        case 1146:
	            $kom="Błąd 1146: Tabela nie istnieje (" .mysqli_error($id_conn) . ")";
		    break;
	        case 1064:
	            $kom="Błąd 1064: Błąd składni SQL (" .mysqli_error($id_conn) . ")";
		    break;
   	        default:
                    $kom="Inny błąd: " . mysqli_errno($id_conn) . " (" .mysqli_error($id_conn) . ")";
                    break;
	   }
           echo 'Nie mogę wykonać zapytania: ' . $kom;
           mysqli_close($id_conn);  # zamyka połączenie z bazą
   	   exit;
        }
    ?>
	    <form action='update_Listy.php' method='post'>
         		<select id="emp_id" name="emp_id" onchange='this.form.submit()'>
			    <?php
			         $w_emp = mysqli_fetch_array($wynik);
			         $emp_name = $w_emp['id'] . ' ' . $w_emp['last_name'] . ' ' . $w_emp['first_name'] . ' (' . $w_emp['title'] . ')';
			    ?>
			         <option value=<?php printf("%s", "'" . $w_emp['id'] . "'"); ?> selected><?php printf("%s", $emp_name); ?></option>
			    <?php
			         while ($w_emp = mysqli_fetch_array($wynik))   
			         {  
  			             $emp_name = $w_emp['id'] . ' ' . $w_emp['last_name'] . ' ' . $w_emp['first_name'] . ' (' . $w_emp['title'] . ')';
			    ?>  
			             <option value=<?php printf("%s", "'" . $w_emp['id'] . "'"); ?>><?php printf("%s", $emp_name); ?></option>
			    <?php
			         }    
			    ?> 
		       </select> 
		</form>
    <br><br>
 
    <?php
        if (!empty($_POST['emp_id'])) {
	    $emp_id = $_POST['emp_id'];
	    #echo $emp_id;
	} else { 
           $emp_id = 0;	   
           exit;
        }
        $zapytanie = "SELECT emp.id,
                             emp.last_name,
                             emp.first_name,
  			     emp.username,
			     emp.start_date AS dt_st,
                             emp.salary,
                             emp.title,
                             emp.dept_id,
                             emp.manager_id,
                             emp.comments
                     FROM emp
                    WHERE emp.id = $emp_id ;";
        $wynik = mysqli_query($id_conn, $zapytanie);

        $errno = mysqli_errno($id_conn);

        if (!$wynik) {
	    switch($errno)
    	    {
	        case 1054:
	            $kom="Błąd 1054: Nieznana kolumna (" .mysqli_error($id_conn) . ")";
		    break;
	        case 1146:
	            $kom="Błąd 1146: Tabela nie istnieje (" .mysqli_error($id_conn) . ")";
		    break;
	        case 1064:
	            $kom="Błąd 1064: Błąd składni SQL (" .mysqli_error($id_conn) . ")";
		    break;
   	        default:
                    $kom="Inny błąd: " . mysqli_errno($id_conn) . " (" .mysqli_error($id_conn) . ")";
                    break;
	   }
           echo 'Nie mogę wykonać zapytania: ' . $kom;
           mysqli_close($id_conn);  # zamyka połączenie z bazą
   	   exit;
        }
	$w_emp = mysqli_fetch_array($wynik);
	$id =$w_emp['id'];
	$naz=$w_emp['last_name'];
	$imi=$w_emp['first_name'];
	$uid=$w_emp['username'];
	$tit=$w_emp['title'];
	$did=$w_emp['dept_id'];
  	$sal=$w_emp['salary'];
	$sdt=$w_emp['dt_st'];
	$mid=$w_emp['manager_id'];
	$uwa=$w_emp['comments'];

	$sql_tit = "SELECT name FROM title;";
	$wyn_tit = mysqli_query($id_conn, $sql_tit);
	if (mysqli_errno($id_conn)) 
	{
	  echo "Błąd w zapytania o stanowiska: " . $baza . ' (' . mysqli_error($id_conn) . ')';
	  mysqli_close($id_conn);
	  exit;
	}

	$sql_emp = "SELECT DISTINCT prac.manager_id, 
	                            szef.last_name,
				    szef.first_name
	               	    FROM emp AS szef, emp as prac
			   WHERE szef.id = prac.manager_id;";
	$wyn_emp = mysqli_query($id_conn, $sql_emp);
	if (mysqli_errno($id_conn)) 
	{
	  echo "Błąd w zapytania o managera: " . $baza . ' (' . mysqli_error($id_conn) . ')';
	  mysqli_close($id_conn);
	  exit;
	}

        if (!$mid=='') {
		$sql_emp2 = "SELECT emp.id, 
		                    emp.last_name,
				    emp.first_name
	    	               FROM emp 
	  		      WHERE emp.id = $mid;";
		$wyn_emp2 = mysqli_query($id_conn, $sql_emp2);
		if (mysqli_errno($id_conn)) 
		{
		  echo "Błąd w zapytania 2 o managera: " . $baza . ' (' . mysqli_error($id_conn) . ')';
		  mysqli_close($id_conn);
		  exit;
		}
	}


    ?>


      <table cellspacing="0" cellpadding="0" border="0" style="width: 26%;" align="Left">
      <tbody align="Left">
 	<form action='_MN_update_Listy.php' method='post'>
      	    <tr><td width="250">ID:</td><td><input type='text' name='id'    value=<?php echo $id  ?>></td></tr>
            <tr><td>Nazwisko:   </td><td><input type='text' name='nazwisko' value=<?php echo $naz ?>></td></tr>
	    <tr><td>Imię:       </td><td><input type='text' name='imie'     value=<?php echo $imi ?> ></td></tr>
	    <tr><td>Użytkownik: </td><td><input type='text' name='username'   value=<?php echo $uid ?>></td></tr>
            <tr><td>Stanowisko: </td><td>

		  <select id="Stanowiska" name="title">
		  <?php	
                        if($tit == '') {
                                $tit = NULL;
                                $title = 'Brak danych';
                        } else $title = $tit; 
                  ?>
			<option value=<?php printf("%s", "'" . $tit . "'"); ?> selected><?php printf("%s", $title); ?></option>
                         
		  <?php
			   while ($w_tit = mysqli_fetch_array($wyn_tit))   
			   {  
			       $title = $w_tit['name']; 
                               if ($title==$tit) continue;
		  ?>  
	  	               <option value=<?php printf("%s", "'" . $title . "'"); ?>><?php printf("%s", $title); ?></option>
		  <?php
			   }  
   
		  ?> 
  		  </select></td></tr> 
               
            <tr><td>Departament:</td><td><input type='text' name='departament'   value=<?php echo $did?>></td></tr>
		  
	    </select></td></tr> 

	    <tr><td>Zarobki:    </td><td><input type='text' name='salary'   value=<?php echo $sal ?>></td></tr> 
	    <tr><td>Data:       </td><td><input type='text' name='start_dt' value=<?php echo $sdt ?>></td></tr> 

            <tr><td>Manager:</td><td><select id="Manager" name="man_id">
                  <?php   
			   if($mid != 0) {
				 $empi = $w_emp['manager_id'];
		                 $w_emp2 = mysqli_fetch_array($wyn_emp2);
			         $empn = $w_emp2['last_name'] . ' ' . $w_emp2['first_name'];
                           } else { 
				$empi = NULL;  
                                $empn = 'Brak danych';
                           }


		  ?>
			   <option value=<?php printf("%s",   $empi ); ?> selected><?php printf("%s", $empi . ' ' . $empn); ?></option>
		  <?php
			   while ($w_emp = mysqli_fetch_array($wyn_emp))   
			   {  
				$empi = $w_emp['manager_id'];
   			        if ($empi==$mid) continue;   
				$empn = $w_emp['last_name'] . ' ' .$w_emp['first_name'];
				   
		  ?>  
			       <option value=<?php printf("%s",  $empi ); ?>><?php printf("%s", $empi . ' ' . $empn); ?></option>
		  <?php
			   }    
		  ?> 
	    </select></td></tr> 
 	    <tr><td>Uwagi:      </td><td><input type='text' name='uwagi'    value=<?php echo $uwa ?>></td></tr>
	    <tr><td><p><input type='submit' value='Wyślij'></td></tr>
	</form>
      </tbody>
      </table>     

</body>
</html>