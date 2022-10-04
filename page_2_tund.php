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
	if($hour_now < 7){
		$part_of_day = "uneaeg";
	}
	//   and  &    or   |
	if($hour_now >= 8 and $hour_now < 18){
		$part_of_day = "koolipäev";
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
	echo $weekday_names_et[mt_rand(0, count($weekday_names_et) - 1)];
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
</body>
</html>
