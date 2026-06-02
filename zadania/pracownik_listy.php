<!doctype html>
<html lang="pl">
  <head>
      <meta charset="utf-8">
      <title>Formularz</title>
  </head>
  <body>

    <h2>Pracownicy</h2>
    <?php

	ini_set('display_errors', '0');
        mysqli_report(MYSQLI_REPORT_ERROR);

	$host  = 'localhost'; 
	$user  = 'root';
	$haslo = '';
	$baza  = 'baza_testowa_fa3';

	$id_conn = mysqli_connect($host, $user, $haslo, $baza);
	if (mysqli_connect_errno()) 
	{
	  echo "Błąd połączenia z MySQL z bazą: " . $baza . ' (' . mysqli_connect_error() . ')';
	  exit;
	}

	$sql_tit = "SELECT name FROM title;";
	$wyn_tit = mysqli_query($id_conn, $sql_tit);
	if (mysqli_errno($id_conn)) 
	{
	  echo "Błąd w zapytania o stanowiska: " . $baza . ' (' . mysqli_error($id_conn) . ')';
	  mysqli_close($id_conn);
	  exit;
	}

	$sql_dept = "SELECT dept.id AS 'id', 
	                    dept.name, 
			    region.name AS 'region'
	               FROM dept INNER JOIN region ON region.id = dept.region_id
	           ORDER BY dept.id;";
	$wyn_dept = mysqli_query($id_conn, $sql_dept);
	if (mysqli_errno($id_conn)) 
	{
	  echo "Błąd w zapytania o departament: " . $baza . ' (' . mysqli_error($id_conn) . ')';
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
	  echo "Błąd w zapytania o departament: " . $baza . ' (' . mysqli_error($id_conn) . ')';
	  mysqli_close($id_conn);
	  exit;
	}

    ?>


<table cellspacing="0" cellpadding="0" border="0" style="width: 26%;" align="Left">
<tbody align="Left">
<form action='_ins_prac.php' method='post'>
	<tr><td width="160">Nazwisko:</td><td><input type='text' name='nazwisko' required></td></tr>
<tr><td>Imię:       </td><td><input type='text' name='imie'  required   ></td></tr>
<tr><td>Użytkownik: </td><td><input type='text' name='userid'   ></td></tr>
<tr><td>Stanowisko: </td><td>

	  <select id="Stanowiska" name="title">
	  <?php $tit = '';
		   $w_tit = mysqli_fetch_array($wyn_tit);
		   $title = $w_tit['name'];
	  ?>
		   <option value=<?php printf("%s", "'" . $title . "'"); ?> selected><?php printf("%s", $title); ?></option>
	  <?php
		   while ($w_tit = mysqli_fetch_array($wyn_tit))   
		   {  
		   $title = $w_tit['name']; 
	  ?>  
		       <option value=<?php printf("%s", "'" . $title . "'"); ?>><?php printf("%s", $title); ?></option>
	  <?php
		   }  
   
	  ?> 
	 </select> 
		</td></tr> 
                
		<tr><td>Departament</td><td>
		<select name="dept_id" id="dept_id">
		<?php 
		   $w_dep = mysqli_fetch_array($wyn_dept);
		   $dept = $w_dep['name'];
		   $dept_id = $w_dep['id'];
		   $dept_region = $w_dep['region'];
		?>
			<option value=<?php printf("%s", "'" . $dept_id . "'"); ?> selected><?php printf("%s", $dept_id . " " . $dept . " " . $dept_region);?></option>

			<?php 
			while ($w_dept = mysqli_fetch_array($wyn_dept)){
				$dept = $w_dept['name'];
				$dept_id = $w_dept['id'];
		   		$dept_region = $w_dept['region'];
			
			?>
			<option value=<?php printf("%s", "'" . $dept_id . "'"); ?> ><?php printf("%s", $dept_id . " " . $dept . " " . $dept_region); ?></option>
			<?php } ?>

		</select>
	

</td></tr>

<tr><td>Zarobki:    </td><td><input type='text' name='salary'   ></td></tr> 
<tr><td>Data:       </td><td><input type='text' name='start_dt' ></td></tr> 
<tr><td>Manager:</td><td>
<select id="man_id" name="man_id">
	  <?php $emp = '';
		   $w_emp = mysqli_fetch_array($wyn_emp);
		   $empn = $w_emp['last_name'] . ' ' .$w_emp['first_name'];
		   $empi = $w_emp['manager_id'];
	  ?>
		   <option value=<?php printf("%s",   $empi ); ?> selected><?php printf("%s", $empi . ' ' . $empn); ?></option>
	  <?php
		   while ($w_emp = mysqli_fetch_array($wyn_emp))   
		   {  
		   $empn = $w_emp['last_name'] . ' ' .$w_emp['first_name'];
		   $empi = $w_emp['manager_id'];
	  ?>  
			   <option value=<?php printf("%s",  $empi ); ?>><?php printf("%s", $empi . ' ' . $empn); ?></option>
	  <?php
		   }    
	  ?> 
	 </select> 
<tr><td>Uwagi:      </td><td><input type='text' name='uwagi'    ></td></tr>

<tr><td><p><input type='submit' value='Wyślij'></td></tr>
</form>
    </body>
</html>



