<?php
session_start();
header('Cache-control: private'); // IE 6 FIX

if(isSet($_GET['l'])){
	$lang = $_GET['l'];
	$_SESSION['l'] = $lang;
}else if(isSet($_SESSION['l'])){
	$lang = $_SESSION['l'];
}else{
	$lang = 'tr';
}

switch ($lang) {
  case 'en':
  $lang_file = 'lang.en.php';
  break;

  case 'tr':
  $lang_file = 'lang.tr.php';
  break;

  default:
  $lang_file = 'lang.tr.php';
}

include_once 'inc/'.$lang_file;
?>