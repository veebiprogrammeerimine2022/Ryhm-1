<?php
	require_once "../../../config_vp2022.php";
	
    $first_name = null;
    $last_name = null;
    $email = null;
    $gender = null;
    $birth_month = null;
    $birth_year = null;
    $birth_day = null;
    $birth_date = null;
    $month_names_et = ["jaanuar", "veebruar", "märts", "aprill", "mai", "juuni","juuli", "august", "september", "oktoober", "november", "detsember"];

    //muutujad võimalike veateadetega
    $first_name_error = null;
    $last_name_error = null;
    $birth_month_error = null;
    $birth_year_error = null;
    $birth_day_error = null;
    $birth_date_error = null;
    $gender_error = null;
    $email_error = null;
    $password_error = null;
    $confirm_password_error = null;

	if($_SERVER["REQUEST_METHOD"] === "POST"){
		if(isset($_POST["user_data_submit"])){
			
			$first_name = $_POST["first_name_input"];
			$last_name = $_POST["last_name_input"];
			$gender = $_POST["gender_input"];
			
			$birth_day = $_POST["birth_day_input"];
			$birth_month = $_POST["birth_month_input"];
			$birth_year = $_POST["birth_year_input"];
			if(empty($birth_day_error) and empty($birth_month_error) and empty($birth_year_error)){
				if(checkdate($birth_month, $birth_day, $birth_year)){
					$temp_date = new DateTime($birth_year ."-" .$birth_month ."-" .$birth_day);
					$birth_date = $temp_date->format("Y-m-d");
				} else {
					$birth_date_error = "Valitud kuupäev pole reaalne!";
				}
			}
			
			$email = $_POST["email_input"];
			
			
            //kui kõik kombes, salvestame uue kasutaja
            if(empty($firstname_error) and empty($last_name_error) and empty($birth_month_error) and empty($birth_year_error) and empty($birth_day_error) and empty($birth_date_error) and empty($gender_error) and empty($email_error) and empty($password_error) and empty($confirm_password_error)){
				//salvestame andmetabelisse
				$conn = new mysqli($server_host, $server_user_name, $server_password, $database);
				$conn->set_charset("utf8");
				$stmt = $conn->prepare("INSERT INTO vp_users_1 (firstname, lastname, birthdate, gender, email, password) VALUES(?,?,?,?,?,?)");
				echo $conn->error;
				//krüpteerime salasõna
				$pwd_hash = password_hash($_POST["password_input"], PASSWORD_DEFAULT);
				$stmt->bind_param("sssiss", $first_name, $last_name, $birth_date, $gender, $email, $pwd_hash);
				$stmt->execute();
				echo $stmt->error;
				$stmt->close();
				$conn->close();
			}
		}//if submit lõppeb	
	}//if POST lõppeb		
?>

<!DOCTYPE html>
<html lang="et">
  <head>
    <meta charset="utf-8">
	
  </head>
  <body>
	
	<hr>
    <h2>Loo endale kasutajakonto</h2>
		
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	  <label for="first_name_input">Eesnimi:</label><br>
	  <input name="first_name_input" id="first_name_input" type="text" value="<?php echo $first_name; ?>"><span><?php echo $first_name_error; ?></span><br>
      <label for="lastname_input">Perekonnanimi:</label><br>
	  <input name="last_name_input" id="last_name_input" type="text" value="<?php echo $last_name; ?>"><span><?php echo $last_name_error; ?></span>
	  <br>
	  
	  <input type="radio" name="gender_input" id="gender_input_1" value="2" <?php if($gender == "2"){echo " checked";} ?>><label for="gender_input_1">Naine</label>
	  <input type="radio" name="gender_input" id="gender_input_2" value="1" <?php if($gender == "1"){echo " checked";} ?>><label for="gender_input_2">Mees</label><br>
	  <span><?php echo $gender_error; ?></span>
	  <br>
	  <!--
	  <select name="birth_year_input">
		<option value="" selected disabled>aasta</option>
		<option value="2012">2012</option>
		<option value="2013" selected>2013</option>
		...
	  </select>
	  -->
	  <label for="birth_day_input">Sünnikuupäev: </label>
	  <?php
	    //sünnikuupäev
	    echo '<select name="birth_day_input" id="birth_day_input">' ."\n";
		echo "\t \t" .'<option value="" selected disabled>päev</option>' ."\n";
		for($i = 1; $i < 32; $i ++){
			echo "\t \t" .'<option value="' .$i .'"';
			if($i == $birth_day){
				echo " selected";
			}
			echo ">" .$i ."</option> \n";
		}
		echo "\t </select> \n";
	  ?>
	  	  <label for="birth_month_input">Sünnikuu: </label>
	  <?php
	    echo '<select name="birth_month_input" id="birth_month_input">' ."\n";
		echo "\t \t" .'<option value="" selected disabled>kuu</option>' ."\n";
		for ($i = 1; $i < 13; $i ++){
			echo "\t \t" .'<option value="' .$i .'"';
			if ($i == $birth_month){
				echo " selected ";
			}
			echo ">" .$month_names_et[$i - 1] ."</option> \n";
		}
		echo "</select> \n";
	  ?>
	  <label for="birth_year_input">Sünniaasta: </label>
	  <?php
		echo '<select name="birth_year_input">' ."\n";
		echo '<option value="" selected disabled>aasta</option>' ."\n";
		for ($i = date("Y") - 10; $i >= date("Y") - 105; $i --){
			echo '<option value="' .$i .'"';
			if($i == $birth_year){
				echo " selected";
			}
			echo ">" .$i ."</option> \n";
		}
		echo "</select> \n";
	  ?>
	  <span><?php echo $birth_date_error ." " .$birth_day_error ." " .$birth_month_error ." " .$birth_year_error; ?></span>
	  
	  <br>
	  <label for="email_input">E-mail (kasutajatunnus):</label><br>
	  <input type="email" name="email_input" id="email_input" value="<?php echo $email; ?>"><span><?php echo $email_error; ?></span><br>
	  <label for="password_input">Salasõna (min 8 tähemärki):</label><br>
	  <input name="password_input" id="password_input" type="password"><span><?php echo $password_error; ?></span><br>
	  <label for="confirm_password_input">Korrake salasõna:</label><br>
	  <input name="confirm_password_input" id="confirm_password_input" type="password"><span><?php echo $confirm_password_error; ?></span><br>
	  <input name="user_data_submit" type="submit" value="Loo kasutaja">
	</form>
	<hr>
    
  </body>
</html>