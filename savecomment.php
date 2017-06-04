<?php
include_once 'util/SystemVariables.php';
include_once 'util/DatabaseUtils.php';

if (!empty($_POST)) {
	
	$id = $_POST[SystemVariables::$COLUMN_ID];
	$nameSurname = $_POST[SystemVariables::$COLUMN_NAME_SURNAME];
	$mail = $_POST[SystemVariables::$COLUMN_EMAIL];
	$message = $_POST[SystemVariables::$COLUMN_MESSAGE];
	$page = $_POST[SystemVariables::$COLUMN_PAGE];
	
	if (empty($error)) {
		DatabaseUtils::addComment($id, $nameSurname, $mail, $message, $page);		
		$result[] = SystemVariables::$SUCCESS_MSG;
	} else {
		/*
		 Eğer hata varsa json olarak geri bildirelecek olan 
		 $result değişkenine $error dizisindeki hata mesajlarını atıyoruz.
		*/
		$result = $error;
	}
} else {
	$result[] = SystemVariables::$FAILURE_MSG;
}

echo json_encode($result);
?>