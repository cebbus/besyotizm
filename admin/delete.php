<?php
include_once '../util/SystemVariables.php';
include_once '../util/DatabaseUtils.php';
include_once 'logincheck.php';

$id = $_GET['id'];
if($_GET[SystemVariables::$PARAM_PAGE] == "news"){
	$img = $_GET['img'];
	DatabaseUtils::deleteNew($id);
	unlink("../images/news/".$img);
	header("location:index.php?".SystemVariables::$SUCCESS_MSG."=newsdeleted");
}else if($_GET[SystemVariables::$PARAM_PAGE] == "user"){
	DatabaseUtils::deleteUser($id);
	header("location:user.php?".SystemVariables::$SUCCESS_MSG."=userdeleted");
}else if($_GET[SystemVariables::$PARAM_PAGE] == "comment"){
	DatabaseUtils::deleteComment($id);
	header("location:comment.php?".SystemVariables::$SUCCESS_MSG."=commentdeleted");
}else if($_GET[SystemVariables::$PARAM_PAGE] == "photos"){
	$img = $_GET['img'];
	DatabaseUtils::deletePhoto($id);
	unlink("../images/gallery/".$img);
	unlink("../images/gallery/_thumbs".$img);
	header("location:photos.php?".SystemVariables::$SUCCESS_MSG."=photodeleted");
}else if($_GET[SystemVariables::$PARAM_PAGE] == "video"){
	DatabaseUtils::deleteVideo($id);
	header("location:videos.php?".SystemVariables::$SUCCESS_MSG."=videodeleted");
}
?>