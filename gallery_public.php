<?php
	//session_start();
	require_once "classes/SessionManager.class.php";
	SessionManager::sessionStart("vp", 0, "~rinde/vp_2022/Ryhm-1/", "greeny.cs.tlu.ee");
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
	
	$privacy = 2;
	$page = 1;
	$limit = 5;
	$photo_count = count_photos($privacy);
	//kontrollime, mis lehel ja kas see on võimalik
	if(!isset($_GET["page"]) or $_GET["page"] < 1){
		$page = 1;
	} elseif(round($_GET["page"] - 1) * $limit >= $photo_count){
		$page = ceil($photo_count / $limit);
	} else {
		$page = $_GET["page"];
	}
	
	$style_sheets = ["styles/gallery.css", "styles/modal.css"];
	$javascripts = ["javascript/modal.js"];
	require_once "header.php";
	
	echo "<p>Sisse loginud: " .$_SESSION["firstname"] ." " .$_SESSION["lastname"] .".</p> \n";
?>
<ul>
	<li><a href="?logout=1">Logi välja</a></li>
	<li><a href="home.php">Avalehele</a></li>
</ul>
<hr>

<!--Modaalaken fotode suuremalt näitamiseks-->
<dialog id="modal" class="modalarea">
	<span id="modalclose" class="modalclose">&times;</span>
	<div class="modalhorizontal">
		<div class="modalvertical">
			<p id="modalcaption"></p>
			<img src="pics/empty.png" alt="Galeriipilt" id="modalimage">
			
			<br>
			<input id="rate1" name="rating" type="radio" value="1"><label for="rate1">1</label>
			<input id="rate2" name="rating" type="radio" value="2"><label for="rate2">2</label>
			<input id="rate3" name="rating" type="radio" value="3"><label for="rate3">3</label>
			<input id="rate4" name="rating" type="radio" value="4"><label for="rate4">4</label>
			<input id="rate5" name="rating" type="radio" value="5"><label for="rate5">5</label>
			<button id="storeRating" type="button">Salvesta hinne</button>
			<br>
			<p id="avgrating"></p>
			
		</div>
	</div>
</dialog>

<h2>Avalike piltide galerii</h2>
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
	<?php echo read_public_photos($privacy, $page, $limit); ?>
</div>

<?php require_once "footer.php"; ?>