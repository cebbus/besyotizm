<?php 
include_once 'util/SystemVariables.php';
include_once 'util/DatabaseUtils.php';

$loginFailure = null;

if(isset($_POST['username']) && isset($_POST['password'])){
	$uname=$_POST['username'];
	$password=$_POST['password'];

	if(DatabaseUtils::checkUser($uname, $password)>0){
		session_start();
		$_SESSION[SystemVariables::$SESSION_USERNAME] = $uname;
		header("location:admin/index.php");
	}else{
		$loginFailure = true;
	}
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="utf-8">
<style type="text/css">
body {
	padding: 20%;
	font-family: Arial, Helvetica, sans-serif;
	font-weight: bold;
	font-size: 13px;
	margin: 0 auto;
	padding: 0 auto;
	background: #bebebe; 
}
table {
	margin: 0 auto;
	padding: 0 auto;
	border-collapse:collapse;
}
table, td, th {
	border:1px solid #444444;
	padding: 2px;
}
td {
	background-color: #555555;
	color: white;
}
.inp{
	padding-left: 1px;
	border-style: solid;
	border-color: black;
	border-width: 1px;
	font-family: Arial, Helvetica, sans-serif;
	padding-left: 1px;
}
</style>


<script type="text/javascript">
	function logError(){
		document.getElementById('loginStatus').innerHTML = 'Kullanıcı Adı veya Şifre Hatalı';
		document.getElementById('logStatus').style.backgroundColor = 'red';
	}
</script>

</head>
<body>
<form action="giris.php" method="post">
	<table>
		<tr>
			<td colspan="2" align="center" id="logStatus" style="background-color:green; color: white;">
				<span id="loginStatus">Kullanıcı Adı ve Şifreyi Giriniz</span>
			</td>
		</tr>	
		<tr>
			<td>Kullanıcı Adı</td>
			<td><input type="text" id="username" name="username" class="inp"></td>
		</tr>
		<tr>
			<td>Şifre</td>
			<td><input type="password" id="password" name="password" class="inp"></td>
		</tr>
		<tr>
			<td colspan="2" align="center"><input type="submit" value="Giriş"></td>
		</tr>		
	</table>
</form>

<?php 
if($loginFailure!=null && $loginFailure==true){
	?>
		<script>logError();</script>
	<?php
}
?>
</body>
</html>