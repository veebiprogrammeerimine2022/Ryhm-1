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
	
	require_once "fnc_gallery.php";
	
	$page = 1;
	$limit = 5;
	$photo_count = count_own_photos();
	//kontrollime, mis lehel ja kas see on võimalik
	if(!isset($_GET["page"]) or $_GET["page"] < 1){
		$page = 1;
	} elseif(round($_GET["page"] - 1) * $limit >= $photo_count){
		$page = ceil($photo_count / $limit);
	} else {
		$page = $_GET["page"];
	}
	
	$style_sheets = "styles/gallery.css";
	require_once "header.php";
	
	echo "<p>Sisse loginud: " .$_SESSION["firstname"] ." " .$_SESSION["lastname"] .".</p> \n";
?>
<ul>
	<li><a href="?logout=1">Logi välja</a></li>
	<li><a href="home.php">Avalehele</a></li>
</ul>
<h2>Minu oma piltide galerii</h2>
<p>
<?php
	//Eelmine leht | Järgmine leht
	//<span>Eelmine leht</span> | <span><a href="?page=2">Järgmine leht</a></span>
	if($page > 1){
		echo '<span><a href="?page=' .($page - 1) .'">Eelmine leht</a></span>';
	} else {
		echo "<span>Eelmine leht</span>";
	}
	echo " | ";
	if($page * $limit < $photo_count){
		echo '<span><a href="?page=' .($page + 1) .'">Järgmine leht</a></span>';
	} else {
		echo "<span>Järgmine leht</span>";
	}
?>
</p>
<div class="gallery">
	<?php echo read_own_photos($page, $limit); ?>
</div>

<?php require_once "footer.php"; ?>