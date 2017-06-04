<?php
include_once '../util/SystemVariables.php';
include_once '../util/DatabaseUtils.php';
include_once 'logincheck.php';

$failureMsg = null;

if(!isset($_GET['id']) && !is_numeric($_GET['id'])){
	header("location:user.php");
}

if(isset($_GET[SystemVariables::$FAILURE_MSG])){
	$failureMsg = $_GET[SystemVariables::$FAILURE_MSG];
}

ob_start();

$paramId = SystemVariables::$COLUMN_ID;
$paramPage = SystemVariables::$PARAM_PAGE;
$paramType = SystemVariables::$PARAM_TYPE;
$paramUsername = SystemVariables::$COLUMN_USERNAME;
$paramPassword = SystemVariables::$COLUMN_PASSWORD;

$id = $_GET['id'];
$username = "";
$password = "";

$type = "update";
$result = DatabaseUtils::retrieveUser($id);
while($row = mysql_fetch_array($result)) {
	$username = $row[SystemVariables::$COLUMN_USERNAME];
	$password = $row[SystemVariables::$COLUMN_PASSWORD];
}

if($id == "0"){
	$type = "add";
}
?>

<?php 
if($failureMsg != null){?>
	<script>
		alert('<?php echo $failureMsg;?>');
	</script>
<?php
}
?>

<form action="save.php" method="POST">
<div class="editTable">
<input type="hidden" value="<?php echo $id;?>" id="<?php echo $paramId;?>" name="<?php echo $paramId;?>">
<input type="hidden" value="users" id="<?php echo $paramPage;?>" name="<?php echo $paramPage;?>">
<input type="hidden" value="<?php echo $type;?>" id="<?php echo $paramType;?>" name="<?php echo $paramType;?>">
<table>
	<tr>
		<td>Kullanıcı Adı</td>
		<td><input type="text" name="<?php echo $paramUsername?>" id="<?php echo $paramUsername?>" value="<?php echo $username;?>"></td>
	</tr>
	<tr>
		<td>Şifre</td>
		<td><input type="password" name="<?php echo $paramPassword;?>" id="<?php echo $paramPassword;?>" value="<?php echo $password;?>"></td>
	</tr>
	<tr>
		<td colspan="2" style="text-align: center;">
			<input type="submit" value="Kaydet" style="width: 20%; cursor: pointer; border: 1px solid black;"/>
			<input type="button" value="İptal" onclick="javascript:location.href='user.php'" style="width: 20%; cursor: pointer; border: 1px solid black;"/>
		</td>
	</tr>			
</table>
</div>
</form>

<?php 
$adminContent = ob_get_contents();
ob_end_clean();
include('../admin/master.php');
?>