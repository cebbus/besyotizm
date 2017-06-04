<?php
include_once '../util/SystemVariables.php';
include_once '../util/DatabaseUtils.php';
include_once 'logincheck.php';

$failureMsg = null;

if(!isset($_GET['id']) && !is_numeric($_GET['id'])){
	header("location:videos.php");
}

if(isset($_GET[SystemVariables::$FAILURE_MSG])){
	$failureMsg = $_GET[SystemVariables::$FAILURE_MSG];
}

ob_start();

$paramId = SystemVariables::$COLUMN_ID;
$paramPage = SystemVariables::$PARAM_PAGE;
$paramType = SystemVariables::$PARAM_TYPE;
$paramTitle = SystemVariables::$COLUMN_TITLE;
$paramSummary = SystemVariables::$COLUMN_SUMMARY;
$paramDate =  SystemVariables::$COLUMN_DATE;
$paramLink =  SystemVariables::$COLUMN_LINK;

$id = $_GET['id'];
$title = "";
$summary = "";
$link = "";

$d=getdate();
$date = $d['year'];
if($d['mon'] < 10){
	$date = $date."0".$d['mon'];
}else{
	$date = $date.$d['mon'];
}

if($d['mday'] < 10){
	$date = $date."0".$d['mday'];
}else{
	$date = $date.$d['mday'];
}

$type = "update";
$result = DatabaseUtils::retrieveVideo($id);
while($row = mysql_fetch_array($result))
{
	$title = $row[SystemVariables::$COLUMN_TITLE];
	$summary = $row[SystemVariables::$COLUMN_SUMMARY];
	$date =  $row[SystemVariables::$COLUMN_DATE];
	$link = $row[SystemVariables::$COLUMN_LINK];
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
<input type="hidden" value="videos" id="<?php echo $paramPage;?>" name="<?php echo $paramPage;?>">
<input type="hidden" value="<?php echo $type;?>" id="<?php echo $paramType;?>" name="<?php echo $paramType;?>">
<input type="hidden" value="<?php echo $date;?>" id="<?php echo $paramDate;?>" name="<?php echo $paramDate;?>">
<table style="width: 800px;">
	<tr>
		<td>Başlık</td>
		<td><input type="text" name="<?php echo $paramTitle?>" id="<?php echo $paramTitle?>" value="<?php echo $title;?>"></td>
	</tr>
	<tr>
		<td>Özet</td>
		<td><input type="text" name="<?php echo $paramSummary;?>" id="<?php echo $paramSummary;?>" value="<?php echo $summary;?>"></td>
	</tr>
	<tr>
		<td>Video Linki</td>
		<td><input type="text" name="<?php echo $paramLink;?>" id="<?php echo $paramLink;?>" value="<?php echo $link;?>"></td>
	</tr>	
	<tr>
		<td colspan="2" style="text-align: center;">
			<input type="submit" value="Kaydet" style="width: 20%; cursor: pointer; border: 1px solid black;"/>
			<input type="button" value="İptal" onclick="javascript:location.href='videos.php'" style="width: 20%; cursor: pointer; border: 1px solid black;"/>
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
