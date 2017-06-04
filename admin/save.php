<?php
include_once '../util/SystemVariables.php';
include_once '../util/DatabaseUtils.php';
include_once 'logincheck.php';

$type = $_POST[SystemVariables::$PARAM_TYPE];
$page = $_POST[SystemVariables::$PARAM_PAGE];
$image = SystemVariables::$COLUMN_IMAGE;

if($page=='news'){
	if (file_exists("../images/news/" . $_FILES[$image]["name"])){
		$param = "?id=".$id."&".SystemVariables::$FAILURE_MSG."=".$_FILES["file"]["name"] . " isimli resim dosyası zaten mevcut. ";
		header("location:editnews.php".$param);
	} else if($_FILES[$image]["size"] > 0) {
		move_uploaded_file($_FILES[$image]["tmp_name"], "../images/news/" . $_FILES[$image]["name"]);
	}
	
	DatabaseUtils::open();
	$id = $_POST[SystemVariables::$COLUMN_ID];
	$title = $_POST[SystemVariables::$COLUMN_TITLE];
	$title = stripslashes($title);
	$title = mysql_real_escape_string($title);
	$summary = $_POST[SystemVariables::$COLUMN_SUMMARY];
	$summary = stripslashes($summary);
	$summary = mysql_real_escape_string($summary);	
	$detail = $_POST[SystemVariables::$COLUMN_DETAIL];
	$detail = stripslashes($detail);
	$detail = mysql_real_escape_string($detail);
	$date = $_POST[SystemVariables::$COLUMN_DATE];
	$imageFileName = $_FILES[$image]["name"];
	$headline = 0;
	if(isset($_POST[SystemVariables::$COLUMN_HEADLINE])){
		$headline = 1;
	}
	DatabaseUtils::close();
	
	if($type == "update"){
		DatabaseUtils::updateNew($id, $title, $summary, $detail, $date, $imageFileName, $headline);
		header("location:index.php?".SystemVariables::$SUCCESS_MSG."=newsupdated");
	}else if($type == "add"){
		DatabaseUtils::addNew($title, $summary, $detail, $date, $imageFileName, $headline);
		header("location:index.php?".SystemVariables::$SUCCESS_MSG."=newsadded");		
	}
}else if ($page == "users"){
	$id = $_POST[SystemVariables::$COLUMN_ID];
	$username = $_POST[SystemVariables::$COLUMN_USERNAME];
	$password = $_POST[SystemVariables::$COLUMN_PASSWORD];
	
	if($type == "update"){
		DatabaseUtils::updateUser($id, $username, $password);
		header("location:user.php?".SystemVariables::$SUCCESS_MSG."=userupdated");
	}else if($type == "add"){
		DatabaseUtils::addUser($username, $password);
		header("location:user.php?".SystemVariables::$SUCCESS_MSG."=useradded");
	}	
}else if ($page == "comment"){
	$checkedId = $_POST['checkedId'];
	if($checkedId != ""){
		DatabaseUtils::approveComment($checkedId);
	}
	
	$uncheckedId = $_POST['uncheckedId'];
	if($uncheckedId != ""){
		DatabaseUtils::removeApproveComment($uncheckedId);
	}
	
	header("location:comment.php?".SystemVariables::$SUCCESS_MSG."=processcomplate");
	
}else if ($page == "photos"){
	$fileCount=count($_FILES[SystemVariables::$COLUMN_PHOTO]['name']); 
	for($i=0;$i<$fileCount;$i++){ 
	    if(!empty($_FILES[SystemVariables::$COLUMN_PHOTO]['name'][$i])){
	    	$fileName =  $_FILES[SystemVariables::$COLUMN_PHOTO]['name'][$i];
	    	$fileName = DatabaseUtils::randString(5). $fileName;
	        move_uploaded_file($_FILES[SystemVariables::$COLUMN_PHOTO]['tmp_name'][$i],"../images/gallery/".$fileName);
	        DatabaseUtils::addPhoto($fileName);
	    } 
	}
	header("location:photos.php?".SystemVariables::$SUCCESS_MSG."=photoadded");
}else if ($page == "videos"){
	$id = $_POST[SystemVariables::$COLUMN_ID];
	$title = $_POST[SystemVariables::$COLUMN_TITLE];
	$summary = $_POST[SystemVariables::$COLUMN_SUMMARY];
	$date = $_POST[SystemVariables::$COLUMN_DATE];
	$link = $_POST[SystemVariables::$COLUMN_LINK];
	
	if($type == "update"){
		DatabaseUtils::updateVideo($id, $title, $summary, $link, $date);
		header("location:videos.php?".SystemVariables::$SUCCESS_MSG."=videoupdated");
	}else if($type == "add"){
		DatabaseUtils::addVideo($title, $summary, $link, $date);
		header("location:videos.php?".SystemVariables::$SUCCESS_MSG."=videoadded");
	}
}else if ($page == "showPhotosMainPage"){
	$checkedId = $_POST['checkedId'];
	if($checkedId != ""){
		DatabaseUtils::showPhotosOnMainPage($checkedId);
	}
	
	$uncheckedId = $_POST['uncheckedId'];
	if($uncheckedId != ""){
		DatabaseUtils::hidePhotosOnMainPage($uncheckedId);
	}
	
	header("location:photos.php?".SystemVariables::$SUCCESS_MSG."=processcomplate");
	
}else if ($page == "showVideosMainPage"){
	$checkedId = $_POST['checkedId'];
	if($checkedId != ""){
		DatabaseUtils::showVideosOnMainPage($checkedId);
	}
	
	$uncheckedId = $_POST['uncheckedId'];
	if($uncheckedId != ""){
		DatabaseUtils::hideVideosOnMainPage($uncheckedId);
	}
	
	header("location:videos.php?".SystemVariables::$SUCCESS_MSG."=processcomplate");
	
}
?>