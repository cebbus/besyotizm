<?php
class DatabaseUtils{
	
	static $host = "localhost";
	static $username = "root";
	static $password = "";
	static $db_name = "autism";

	static $conn = null;
	
	static function open() {
		self::$conn = mysql_connect(self::$host, self::$username, self::$password)or die("cannot connect");
		mysql_select_db(self::$db_name)or die("cannot select DB");
		mysql_query("SET NAMES UTF8");
	}
	
	static function close() {
		mysql_close(self::$conn);
	}
	
	static function checkUser($username, $password){
		self::open();
		$username = stripslashes($username);
		$password = stripslashes($password);
		$username = mysql_real_escape_string($username);
		$password = mysql_real_escape_string($password);		
		$sql="SELECT * FROM ".SystemVariables::$TABLE_USER." WHERE ".
			SystemVariables::$COLUMN_USERNAME."='$username' and ".
			SystemVariables::$COLUMN_PASSWORD."='$password'";
		$result=mysql_query($sql);
		$count=mysql_num_rows($result);
		self::close();
		return $count;
	}
	
	static function retrieveNews(){
		self::open();
		$query="SELECT * FROM ".SystemVariables::$TABLE_NEWS." ORDER BY ".
			SystemVariables::$COLUMN_DATE. " DESC";
		$result=mysql_query($query);
		self::close();
		return $result;
	}
	
	static function retrieveFiveNews(){
		self::open();
		$query="SELECT * FROM ".SystemVariables::$TABLE_NEWS.
			" WHERE ".SystemVariables::$COLUMN_HEADLINE."=0".
			" ORDER BY ".SystemVariables::$COLUMN_DATE. " DESC LIMIT 5";
		$result=mysql_query($query);
		self::close();
		return $result;
	}	
	
	static function retrieveHeadlineNews(){
		self::open();
		$query="SELECT * FROM ".SystemVariables::$TABLE_NEWS.
			" WHERE ".SystemVariables::$COLUMN_HEADLINE."=1".
			" ORDER BY ".SystemVariables::$COLUMN_DATE. " DESC";
		$result=mysql_query($query);
		self::close();
		return $result;
	}	
	
	static function retrieveNew($id){
		self::open();
		$query="SELECT * FROM ".SystemVariables::$TABLE_NEWS.
			" WHERE ".SystemVariables::$COLUMN_ID." = ".$id;
		$result=mysql_query($query);
		self::close();
		return $result;
	}
	
	static function updateNew($id, $title, $summary, $detail, $date, $image, $headline){
		self::open();
		$query = "UPDATE ".SystemVariables::$TABLE_NEWS." SET ".
				SystemVariables::$COLUMN_TITLE."='".$title."',".
				SystemVariables::$COLUMN_SUMMARY."='".$summary."',".
				SystemVariables::$COLUMN_DETAIL."='".$detail."',".
				SystemVariables::$COLUMN_DATE."='".$date."',".
				SystemVariables::$COLUMN_HEADLINE."=".$headline."";
		
		if(strlen($image) > 0){
			$query .= ",".SystemVariables::$COLUMN_IMAGE."='".$image."'";
		}
		
		$query .=  " WHERE ".SystemVariables::$COLUMN_ID."=".$id;
		mysql_query($query);
		self::close();
	}
	
	static function addNew($title, $summary, $detail, $date, $image, $headline){
		self::open();
		$query = "INSERT INTO ".SystemVariables::$TABLE_NEWS." VALUES ('','".$title."', '".$summary."', '".$detail."','".$image."','".$date."',".$headline.")";
		//echo $query;
		mysql_query($query);
		self::close();
	}
		
	static function deleteNew($id){
		self::open();
		$query = "DELETE FROM ".SystemVariables::$TABLE_NEWS." WHERE ".SystemVariables::$COLUMN_ID."=". $id;
		mysql_query($query);
		$query = "DELETE FROM ".SystemVariables::$TABLE_COMMENTS." WHERE ".SystemVariables::$COLUMN_EVENT_ID."=". $id;
		mysql_query($query);
		self::close();
	}

	static function retrieveUsers(){
		self::open();
		$query="SELECT * FROM ".SystemVariables::$TABLE_USER;
		$result=mysql_query($query);
		self::close();
		return $result;
	}

	static function retrieveUser($id){
		self::open();
		$query="SELECT * FROM ".SystemVariables::$TABLE_USER.
		" WHERE ".SystemVariables::$COLUMN_ID." = ".$id;
		$result=mysql_query($query);
		self::close();
		return $result;
	}
	
	static function updateUser($id, $username, $password){
		self::open();
		$query = "UPDATE ".SystemVariables::$TABLE_USER." SET ".
				SystemVariables::$COLUMN_USERNAME."='".$username."',".
				SystemVariables::$COLUMN_PASSWORD."='".$password."'".
				" WHERE ".SystemVariables::$COLUMN_ID."=".$id;
	
		mysql_query($query);
		self::close();
	}

	static function addUser($username, $password){
		self::open();
		$query = "INSERT INTO ".SystemVariables::$TABLE_USER." VALUES ('','".$username."', '".$password."')";
		mysql_query($query);
		self::close();
	}	
	
	static function deleteUser($id){
		self::open();
		$query = "DELETE FROM ".SystemVariables::$TABLE_USER." WHERE ID=". $id;
		mysql_query($query);
		self::close();
	}	
	
	static function deleteComment($id){
		self::open();
		$query = "DELETE FROM ".SystemVariables::$TABLE_COMMENTS." WHERE ID=". $id;
		mysql_query($query);
		self::close();
	}

	static function retrieveWaitingForApproval($table, $page){
		self::open();
		$query="SELECT n.".SystemVariables::$COLUMN_TITLE.", c.* FROM ".SystemVariables::$TABLE_COMMENTS." c,".$table." n".
				" WHERE ". SystemVariables::$COLUMN_APPROVAL."=0 AND ".
				SystemVariables::$PARAM_PAGE."='".$page."' AND ".
				"c.".SystemVariables::$COLUMN_EVENT_ID."=n.".SystemVariables::$COLUMN_ID;
		$result=mysql_query($query);
		self::close();
		return $result;
	}
	
	static function addComment($id, $nameSurname, $mail, $message, $page){
		self::open();
		$nameSurname = stripslashes($nameSurname);
		$mail = stripslashes($mail);
		$message = stripslashes($message);
		$nameSurname = mysql_real_escape_string($nameSurname);
		$mail = mysql_real_escape_string($mail);
		$message = mysql_real_escape_string($message);
		$query = "INSERT INTO ".SystemVariables::$TABLE_COMMENTS." VALUES ('',".$id.", '".$nameSurname."', '".$mail."', '".$message."', 0, '".$page."')";
		mysql_query($query);
		self::close();
	}
	
	static function retrieveApproved($table, $page){
		self::open();
		$query="SELECT n.".SystemVariables::$COLUMN_TITLE.", c.* FROM ".SystemVariables::$TABLE_COMMENTS." c,".$table." n".
				" WHERE ". SystemVariables::$COLUMN_APPROVAL."=1 AND ".
				SystemVariables::$PARAM_PAGE."='".$page."' AND ".
				"c.".SystemVariables::$COLUMN_EVENT_ID."=n.".SystemVariables::$COLUMN_ID;
		$result=mysql_query($query);
		self::close();
		return $result;
	}	

	static function retrieveComment($id, $page){
		self::open();
		$query="SELECT * FROM ".SystemVariables::$TABLE_COMMENTS.
				" WHERE ". SystemVariables::$COLUMN_APPROVAL."=1 AND ".
				SystemVariables::$COLUMN_PAGE."='".$page."' AND ".
				SystemVariables::$COLUMN_EVENT_ID."=".$id;
		$result=mysql_query($query);
		self::close();
		return $result;
	}
	
	static function approveComment($checkedId){
		self::open();
		$query="UPDATE ".SystemVariables::$TABLE_COMMENTS.
			" SET ". SystemVariables::$COLUMN_APPROVAL."=1 WHERE ".
			SystemVariables::$COLUMN_ID." IN (".$checkedId.")";
		mysql_query($query);
		self::close();
	}	
	
	static function removeApproveComment($uncheckedId){
		self::open();
		$query="UPDATE ".SystemVariables::$TABLE_COMMENTS.
		" SET ". SystemVariables::$COLUMN_APPROVAL."=0 WHERE ".
		SystemVariables::$COLUMN_ID." IN (".$uncheckedId.")";
		mysql_query($query);
		self::close();
	}

	static function retrievePhotos(){
		self::open();
		$query="SELECT * FROM ".SystemVariables::$TABLE_PHOTOS;
		$result=mysql_query($query);
		self::close();
		return $result;
	}

	static function deletePhoto($id){
		self::open();
		$query = "DELETE FROM ".SystemVariables::$TABLE_PHOTOS." WHERE ID=". $id;
		mysql_query($query);
		self::close();
	}

	static function addPhoto($fileName){
		self::open();
		$query = "INSERT INTO ".SystemVariables::$TABLE_PHOTOS." VALUES ('','".$fileName."', 0)";
		mysql_query($query);
		self::close();
	}
	
	static function retrieveVideos(){
		self::open();
		$query="SELECT * FROM ".SystemVariables::$TABLE_VIDEOS." ORDER BY ".
			SystemVariables::$COLUMN_DATE. " DESC";
		$result=mysql_query($query);
		self::close();
		return $result;
	}
	
	static function retrieveFiveVideos(){
		self::open();
		$query="SELECT * FROM ".SystemVariables::$TABLE_VIDEOS.
			" ORDER BY ".SystemVariables::$COLUMN_DATE. " DESC LIMIT 5";
		$result=mysql_query($query);
		self::close();
		return $result;
	}
	
	static function retrieveTwoVideos(){
		self::open();
		$query="SELECT * FROM ".SystemVariables::$TABLE_VIDEOS.
		" ORDER BY ".SystemVariables::$COLUMN_DATE. " DESC LIMIT 2";
		$result=mysql_query($query);
		self::close();
		return $result;
	}	

	static function retrieveLastVideo(){
		self::open();
		$query="SELECT * FROM ".SystemVariables::$TABLE_VIDEOS.
		" ORDER BY ".SystemVariables::$COLUMN_DATE. " DESC LIMIT 1";
		$result=mysql_query($query);
		self::close();
		return $result;
	}	
	
	static function deleteVideo($id){
		self::open();
		$query = "DELETE FROM ".SystemVariables::$TABLE_VIDEOS." WHERE ID=". $id;
		mysql_query($query);
		self::close();
	}	
	
	static function retrieveVideo($id){
		self::open();
		$query="SELECT * FROM ".SystemVariables::$TABLE_VIDEOS.
		" WHERE ".SystemVariables::$COLUMN_ID." = ".$id;
		$result=mysql_query($query);
		self::close();
		return $result;
	}	
	
	static function updateVideo($id, $title, $summary, $link, $date){
		self::open();
		$title = stripslashes($title);
		$title = mysql_real_escape_string($title);
		$summary = stripslashes($summary);
		$summary = mysql_real_escape_string($summary);
		$link = stripslashes($link);
		$link = mysql_real_escape_string($link);		
		$query = "UPDATE ".SystemVariables::$TABLE_VIDEOS." SET ".
				SystemVariables::$COLUMN_TITLE."='".$title."',".
				SystemVariables::$COLUMN_SUMMARY."='".$summary."',".
				SystemVariables::$COLUMN_LINK."='".$link."',".
				SystemVariables::$COLUMN_DATE."='".$date."'".
				" WHERE ".SystemVariables::$COLUMN_ID."=".$id;
		mysql_query($query);
		self::close();
	}	
	
	static function addVideo($title, $summary, $link, $date){
		self::open();
		$title = stripslashes($title);
		$title = mysql_real_escape_string($title);	
		$summary = stripslashes($summary);
		$summary = mysql_real_escape_string($summary);
		$link = stripslashes($link);
		$link = mysql_real_escape_string($link);		
		$query = "INSERT INTO ".SystemVariables::$TABLE_VIDEOS." VALUES ('','".$title."', '".$summary."', '".$link."', '".$date."', 0)";
		mysql_query($query);
		self::close();
	}	
	
	static function stringToDate($str){
		$y = substr($str, 0, 4);
		$m = substr($str, 4, 2);
		$d = substr($str, 6, 2);
		return $d.".".$m.".".$y;
	}
	
	static function randString( $length ) {
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	
		$size = strlen( $chars );
		for( $i = 0; $i < $length; $i++ ) {
			$str .= $chars[ rand( 0, $size - 1 ) ];
		}
	
		return $str;
	}

	static function showPhotosOnMainPage($checkedId){
		self::open();
		$query="UPDATE ".SystemVariables::$TABLE_PHOTOS.
		" SET ". SystemVariables::$COLUMN_SHOW_MAIN."=1 WHERE ".
		SystemVariables::$COLUMN_ID." IN (".$checkedId.")";
		mysql_query($query);
		self::close();
	}
	
	static function hidePhotosOnMainPage($uncheckedId){
		self::open();
		$query="UPDATE ".SystemVariables::$TABLE_PHOTOS.
		" SET ". SystemVariables::$COLUMN_SHOW_MAIN."=0 WHERE ".
		SystemVariables::$COLUMN_ID." IN (".$uncheckedId.")";
		mysql_query($query);
		self::close();
	}

	static function retrieveMainPhotos(){
		self::open();
		$query="SELECT * FROM ".SystemVariables::$TABLE_PHOTOS.
		" WHERE ".SystemVariables::$COLUMN_SHOW_MAIN. " = 1";
		$result=mysql_query($query);
		self::close();
		return $result;
	}

	static function showVideosOnMainPage($checkedId){
		self::open();
		$query="UPDATE ".SystemVariables::$TABLE_VIDEOS.
		" SET ". SystemVariables::$COLUMN_SHOW_MAIN."=1 WHERE ".
		SystemVariables::$COLUMN_ID." IN (".$checkedId.")";
		mysql_query($query);
		self::close();
	}
	
	static function hideVideosOnMainPage($uncheckedId){
		self::open();
		$query="UPDATE ".SystemVariables::$TABLE_VIDEOS.
		" SET ". SystemVariables::$COLUMN_SHOW_MAIN."=0 WHERE ".
		SystemVariables::$COLUMN_ID." IN (".$uncheckedId.")";
		mysql_query($query);
		self::close();
	}

	static function retrieveMainVideos(){
		self::open();
		$query="SELECT * FROM ".SystemVariables::$TABLE_VIDEOS.
		" WHERE ".SystemVariables::$COLUMN_SHOW_MAIN. " = 1";
		$result=mysql_query($query);
		self::close();
		return $result;
	}	

}
?>