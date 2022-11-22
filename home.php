<?php
	//session_start();
	require_once "classes/SessionManager.class.php";
	SessionManager::sessionStart("vp", 0, "~rinde/vp_2022/Ryhm-1/", "greeny.cs.tlu.ee");
	
	if(!isset($_SESSION["user_id"])){
		//jõuga viiakse page.php lehele
		header("Location: page.php");
		exit();
	}
	
	//logime välja
	if(isset($_GET["logout"])){
		session_destroy();
		header("Location: page.php");
		exit();
	}
	
	//tegelen küpsistega
	$last_visitor = "pole teada";
	
	if(isset($_COOKIE["lastvisitor"]) and !empty($_COOKIE["lastvisitor"])){
		$last_visitor = $_COOKIE["lastvisitor"];
	}
	
	//salvestan küpsise
	//nimi, väärtus, aegumistähtaeg, veebikataloog, domeen, https kasutamine,
	//https      isset($_SERVER["HTTPS"])
	setcookie("lastvisitor", $_SESSION["firstname"] ." " .$_SESSION["lastname"],time() + (60 * 60 * 24 * 8), "~rinde/vp_2022/Ryhm-1/", "greeny.cs.tlu.ee", true, true);
	//küpsise kustutamine: expire ehk aegumistähtaeg pannakse minevikus:   time() - 3000
	
	require_once "header.php";
	
	echo "<p>Sisse loginud: " .$_SESSION["firstname"] ." " .$_SESSION["lastname"] .".</p> \n";
	
	if($last_visitor != $_SESSION["firstname"] ." " .$_SESSION["lastname"]){
		echo "<p>Viimati oli sisseloginud: " .$last_visitor ."</p> \n";
	}
?>
<ul>
	<li>Logi <a href="?logout=1">välja</a></li>
	<li><a href="user_profile.php">Minu kasutajaprofiil</a></li>
	<li>Fotode galeriisse <a href="gallery_photo_upload.php">lisamine</a></li>
	<li><a href="gallery_public.php">Avalike fotode galerii</a></li>
	<li><a href="gallery_own.php">Minu fotod</a></li>
</ul>
<?php require_once "footer.php"; ?>