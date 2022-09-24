<?php
	$author_name = "Andrus Rinde";
	//echo $author_name;
	$full_time_now = date("d.m.Y H:i:s");
	$weekday_names_et = ["esmaspäev", "teisipäev", "kolmapäev", "neljapäev", "reede", "laupäev", "pühapäev"];
	//echo $weekday_names_et[2];
	$weekday_now = date("N");
	$hour_now = date("H");
	$part_of_day = "suvaline hetk";
	//   == on võrdne   !=   pole võrdne   <    >   <=   >=
	if($weekday_now <= 5){
		if($hour_now < 7 or $hour_now >= 23){
			$part_of_day = "uneaeg";
		}
		if($hour_now == 7){
			$part_of_day = "hommikune virgumise aeg";
		}
		//   and   or
		if($hour_now >= 8 and $hour_now < 18){
			$part_of_day = "koolipäev";
		}
		if($hour_now >= 18 and $hour_now < 23){
			$part_of_day = "vaba aeg";
		}
	}
	if($weekday_now == 6){
		if($hour_now < 8){
			$part_of_day = "uneaeg";
		}
		if($hour_now >= 8 and $hour_now < 23){
			$part_of_day = "vaba aeg";
		}
		if($hour_now >= 23){
			$part_of_day = "mõnusa logelemise aeg";
		}
	}
	if($weekday_now == 7){
		if($hour_now < 9){
			$part_of_day = "uneaeg";
		}
		if($hour_now >= 9 and $hour_now < 19){
			$part_of_day = "vaba aeg";
		}
		if($hour_now >= 19){
			$part_of_day = "uueks nädalaks valmistumise aeg";
		}
	}
	
	//vaatame semestri pikkust ja kulgemist
	$semester_begin = new DateTime("2022-09-05");
	$semester_end = new DateTime("2022-12-18");
	$semester_duration = $semester_begin->diff($semester_end);
	//echo $semester_duration;
	$semester_duration_days = $semester_duration->format("%r%a");
	//echo $semester_duration_days;
	$from_semester_begin = $semester_begin->diff(new DateTime("now"));
	$from_semester_begin_days = $from_semester_begin->format("%r%a");
	
	//loendan massiivi (array) liikmeid
	//echo count($weekday_names_et);
	//juhuslik arv
	//echo mt_rand(1, 9);
	//juhuslik element massiivist
	//echo $weekday_names_et[mt_rand(0, count($weekday_names_et) - 1)];
	
	$old_wisdom_list = ["Tarkus ei küsi süüa, vaid annab süüa.", "Homseks hoia leiba, mitte tööd.", "Hommik on õhtust targem.", "Kus viga näed laita, seal tule ja aita.", "Sõnahoobid on vahest valusamad, kui käehoobid.", "Ega rumalaid künta ja külvata, nemad kasvavad ise.", "Laps on perekonna peegel.", "Väikesed lapsed, väiksed mured, suured lapsed, suured mured.", "Kes hunti kardab, see ärgu metsa mingu.", "Ei meri sellest alane, kui koer äärest lakub.", "Targad sõdivad sõnaga, rumalad rusikaga.", "Ära vanasse kaevu enne sülita, kui uus valmis."];
	//$random_wisdom = $old_wisdom_list[mt_rand(0, count($old_wisdom_list) - 1)];
	
	//loeme fotode kataloogi sisu
	$photo_dir = "photos/";
	//$all_files = scandir($photo_dir);
	//uus_massiiv = array_slice(massiiv,mis kohast alates);
	$all_files = array_slice(scandir($photo_dir),2);
	//echo $all_files;
	//var_dump($all_files);
	
	//   <img src="kataloog/fail" alt="tekst">
	$photo_html = null;
	
	//tsükkel
	// muutuja väärtuse suurendamine: $muutuja = $muutuja + 5
	//$muutuja += 5
	// kui suureneb 1 võrra $muutuja ++
	// on ka -=   --
	/*for($i = 0; $i < count($all_files); $i ++){
		echo $all_files[$i] ."\n";
	}*/
	/*foreach($all_files as $file_name){
		echo $file_name ." | ";
	}*/
	
	//loetlen lubatud failitüübid  (jpg  png)
	//   MIME    
	$allowed_photo_types = ["image/jpeg", "image/png"];
	$photo_files = [];
	foreach($all_files as $file_name){
		$file_info = getimagesize($photo_dir .$file_name);
		//var_dump($file_info);
		if(isset($file_info["mime"])){
			if(in_array($file_info["mime"], $allowed_photo_types)){
				array_push($photo_files, $file_name);
			}
		}
	}
	var_dump($photo_files);
	$photo_html = '<img src="' .$photo_dir .$photo_files[mt_rand(0, count($photo_files) - 1)] .'" alt="Tallinna pilt">';
	
	//vormi info kasutamine
	// $_POST
	//var_dump($_POST);
	$adjective_html = null;
	if(isset($_POST["todays_adjective_input"]) and !empty($_POST["todays_adjective_input"])){
		$adjective_html = "<p>Tänase kohta on arvatud: " .$_POST["todays_adjective_input"] .".</p>";
	}
	
	//teen fotode rippmenüü
	//   <option value="0">tln_1.JPG</option>
	$select_html = '<option value="" selected disabled>Vali pilt</option>';
	for($i = 0; $i < count($photo_files); $i ++){
		$select_html .= '<option value="' .$i .'">';
		$select_html .= $photo_files[$i];
		$select_html .= "</option> \n";
	}
	
	if(isset($_POST["photo_select"]) and $_POST["photo_select"] >= 0){
		//kõik, mis teha tahame ...
		
	}
	
	
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title><?php echo $author_name; ?>, veebiprogrammeerimine</title>
</head>
<body>
	<img src="pics/vp_banner_gs.png" alt="bänner">
	<h1><?php echo $author_name; ?>, veebiprogrammeerimine</h1>
	<p>See leht on loodud õppetöö raames ja ei sisalda tõsist infot!</p>
	<p>Õppetöö toimus <a href="https://www.tlu.ee">Tallinna Ülikoolis</a> Digitehnoloogiate instituudis.</p>
	
	<p>Lehe avamise hetk: <?php echo $weekday_names_et[$weekday_now - 1] .", " .$full_time_now; ?>.</p>
	<p>Praegu on <?php echo $part_of_day; ?>.</p>
	<p>Semester edeneb: <?php echo $from_semester_begin_days ."/" .$semester_duration_days; ?></p>
	
	<a href="https://www.tlu.ee">
		<img src="pics/tlu_37.jpg" alt="Tallinna Ülikooli Astra õppehoone">
	</a>
	<p>Väike tarkusetera: <?php echo $old_wisdom_list[mt_rand(0, count($old_wisdom_list) - 1)]; ?>
	<!--Siin on väike omadussõnade vorm-->
	<form method="POST">
		<input type="text" id="todays_adjective_input" name="todays_adjective_input" placeholder="omadussõna tänase kohta">
		<input type="submit" id="todays_adjective_submit" name="todays_adjective_submit" value="Saada omadussõna">
	</form>
	<?php echo $adjective_html; ?>
	<hr>
	<form method="POST">
		<select id="photo_select" name="photo_select">
			<?php echo $select_html; ?>
		</select>
		<input type="submit" id="photo_submit" name="photo_submit" value="OK">
	</form>
	<?php echo $photo_html; ?>
	<hr>
</body>
</html>
