<?php
	session_start();
	//kontrollin, kas oleme sisse loginud
	if(!isset($_SESSION["user_id"])){
		header("Location: page.php");
		exit();
	}
	
	//logime välja
	if(isset($_GET["logout"])){
		session_destroy();
		header("Location: page.php");
		exit();
	}
	
	require_once "fnc_user.php";
	require_once "fnc_general.php";
	
	$description = null;
	$notice = null;

	if($_SERVER["REQUEST_METHOD"] == "POST"){
		if(isset($_POST["profile_submit"])){
			$description = test_input($_POST["description_input"]);
			$new_bg_color = test_input($_POST["bg_color_input"]);
			$new_txt_color = test_input($_POST["txt_color_input"]);
			$notice = store_user_profile($description, $new_bg_color, $new_txt_color);
		}//if profile_submit
	}//if method==POST
	
	$description = read_user_description();
	
	require_once "header.php";
	
	echo "<p>Sisse loginud: " .$_SESSION["firstname"] ." " .$_SESSION["lastname"] .".</p> \n";
?>
<ul>
	<li><a href="?logout=1">Logi välja</a></li>
	<li><a href="home.php">Avalehele</a></li>
</ul>

<h2>Kasutajaprofiil</h2>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <label for="description_input">Lühikirjeldus</label>
        <br>
        <textarea name="description_input" id="description_input" rows="10" cols="80" placeholder="Minu lühikirjeldus ..."><?php echo $description; ?></textarea>
        <br>
        <label for="bg_color_input">Taustavärv</label>
        <br>
        <input type="color" name="bg_color_input" id="bg_color_input" value="<?php echo $_SESSION["user_bg_color"]; ?>">
        <br>
        <label for="txt_color_input">Tekstivärv</label>
        <br>
        <input type="color" name="txt_color_input" id="txt_color_input" value="<?php echo $_SESSION["user_txt_color"]; ?>">
        <br>
        <input type="submit" name="profile_submit" value="Salvesta">
    </form>
    <span><?php echo $notice; ?></span>

<?php require_once "footer.php";?>