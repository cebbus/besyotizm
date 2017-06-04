<?php
session_start();
if(!isset($_SESSION[SystemVariables::$SESSION_USERNAME])){
	header("location:../index.php");
}
?>