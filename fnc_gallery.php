<?php
	require_once "../../../config_vp2022.php";
	
		function read_public_photos($privacy){
        $photo_html = null;
        $conn = new mysqli($GLOBALS["server_host"], $GLOBALS["server_user_name"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$conn->set_charset("utf8");
        //$stmt = $conn->prepare("SELECT filename, alttext FROM vp_photos_1 WHERE privacy >= ? AND deleted IS NULL");
		$stmt = $conn->prepare("SELECT vp_photos_1.filename, vp_photos_1.alttext, vp_users_1.firstname, vp_users_1.lastname FROM vp_photos_1 JOIN vp_users_1 ON vp_photos_1.userid = vp_users_1.id WHERE vp_photos_1.privacy >= ? AND vp_photos_1.deleted IS NULL GROUP BY vp_photos_1.id");
        echo $conn->error;
        $stmt->bind_param("i", $privacy);
        $stmt->bind_result($filename_from_db, $alttext_from_db, $firstname_from_db, $lastname_from_db);
        $stmt->execute();
        while($stmt->fetch()){
			$photo_html .= '<img src="' .$GLOBALS["gallery_photo_normal_folder"] .$filename_from_db .'" alt="';
            if(empty($alttext_from_db)){
                $photo_html .= "Üleslaetud foto";
            } else {
                $photo_html .= $alttext_from_db;
            }
            $photo_html .= '">' ."\n";
            $photo_html .= "<p>Üles laadis: " .$firstname_from_db ." " .$lastname_from_db ."</p> \n";
        }
        $stmt->close();
		$conn->close();
		return $photo_html;
    }