<?php
include_once '../util/SystemVariables.php';
include_once '../util/DatabaseUtils.php';
include_once 'logincheck.php';

$failureMsg = null;

if(!isset($_GET['id']) && !is_numeric($_GET['id'])){
	header("location:index.php");
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
$paramImage = SystemVariables::$COLUMN_IMAGE;
$paramDetail =  SystemVariables::$COLUMN_DETAIL;
$paramDate =  SystemVariables::$COLUMN_DATE;
$paramHeadline =  SystemVariables::$COLUMN_HEADLINE;

$id = $_GET['id'];
$title = "";
$summary = "";
$image = "";
$detail =  "";
$isChecked = "";

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
$result = DatabaseUtils::retrieveNew($id);
while($row = mysql_fetch_array($result))
{
	$title = $row[SystemVariables::$COLUMN_TITLE];
	$summary = $row[SystemVariables::$COLUMN_SUMMARY];
	$image = $row[SystemVariables::$COLUMN_IMAGE];
	$detail =  $row[SystemVariables::$COLUMN_DETAIL];
	$date =  $row[SystemVariables::$COLUMN_DATE];
	
	if($row[SystemVariables::$COLUMN_HEADLINE] == "1"){
		$isChecked = "checked";
	}
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

<form action="save.php" method="POST" enctype="multipart/form-data">
<div class="editTable">
<input type="hidden" value="<?php echo $id;?>" id="<?php echo $paramId;?>" name="<?php echo $paramId;?>">
<input type="hidden" value="<?php echo $date;?>" id="<?php echo $paramDate;?>" name="<?php echo $paramDate;?>">
<input type="hidden" value="news" id="<?php echo $paramPage;?>" name="<?php echo $paramPage;?>">
<input type="hidden" value="<?php echo $type;?>" id="<?php echo $paramType;?>" name="<?php echo $paramType;?>">
<table>
	<tr>
		<td>Başlık</td>
		<td><input type="text" name="<?php echo $paramTitle?>" id="<?php echo $paramTitle?>" value="<?php echo $title;?>"></td>
	</tr>
	<tr>
		<td>Özet</td>
		<td><input type="text" name="<?php echo $paramSummary;?>" id="<?php echo $paramSummary;?>" value="<?php echo $summary;?>"></td>
	</tr>
	<tr>
		<td>Manşet</td>
		<td>Haber manşette gösterilsin mi?<input type="checkbox" name="<?php echo $paramHeadline;?>" style="width: 10%; border: 1px solid black;" <?php echo $isChecked;?>></td>
	</tr>	
	<tr>
		<td>Haber Resmi</td>
		<td>
			<img src="../images/news/<?php echo $image;?>"><br>
			<input type="file" name="<?php echo $paramImage;?>" id="<?php echo $paramImage;?>"/>
		</td>
	</tr>
	<tr>
		<td>Detay</td>
		<td>
			<textarea cols="80" id="<?php echo $paramDetail;?>" name="<?php echo $paramDetail;?>" rows="10">
				<?php echo $detail;?>
			</textarea>
		</td>
	</tr>
	<tr>
		<td colspan="2" style="text-align: center;">
			<input type="submit" value="Kaydet" style="width: 10%; cursor: pointer; border: 1px solid black;"/>
			<input type="button" value="İptal" onclick="javascript:location.href='index.php'" style="width: 10%; cursor: pointer; border: 1px solid black;"/>
		</td>
	</tr>			
</table>
</div>
</form>

<script type="text/javascript">
	var editor = CKEDITOR.replace( 'DETAIL',{
	    toolbar : 'Full',
	    skin:'kama'
	});

	CKFinder.setupCKEditor( editor, '../js/ckfinder/' );
</script>

<?php 
$adminContent = ob_get_contents();
ob_end_clean();
include('../admin/master.php');
?>