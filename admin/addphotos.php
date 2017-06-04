<?php
include_once '../util/SystemVariables.php';
include_once '../util/DatabaseUtils.php';
include_once 'logincheck.php';

$failureMsg = null;

if(isset($_GET[SystemVariables::$FAILURE_MSG])){
	$failureMsg = $_GET[SystemVariables::$FAILURE_MSG];
}

ob_start();

$paramPhoto = SystemVariables::$COLUMN_PHOTO;
$paramPage = SystemVariables::$PARAM_PAGE;
$paramType = SystemVariables::$PARAM_TYPE;

$type = "add";
?>

<?php 
if($failureMsg != null){?>
	<script>
		alert('<?php echo $failureMsg;?>');
	</script>
<?php
}
?>

<script type="text/javascript">
function upload(){
	var tableHtml=$("#upload_table tbody").html();
	var trHtml=$(".upload_tr").html();
	$("#upload_table tbody").html('<tr class="upload_tr">' + trHtml + '</tr>' + tableHtml); 
}
</script>

<form action="save.php" method="POST" enctype="multipart/form-data">
<div class="editTable">
<input type="hidden" value="photos" id="<?php echo $paramPage;?>" name="<?php echo $paramPage;?>">
<input type="hidden" value="<?php echo $type;?>" id="<?php echo $paramType;?>" name="<?php echo $paramType;?>">
<table id="upload_table">
	<tr class="upload_tr">
		<td>Fotoğraf</td>
		<td><input type="file" name="<?php echo $paramPhoto?>[]" id="<?php echo $paramPhoto?>[]"></td>
	</tr>
	<tr>
		<td colspan="2" style="text-align: center;">
			<input type="button" value="Birden Çok Fotoğraf" onclick="upload()" style="width: 50%; cursor: pointer; border: 1px solid black;"/>
			<input type="submit" value="Kaydet" style="width: 20%; cursor: pointer; border: 1px solid black;"/>
			<input type="button" value="İptal" onclick="javascript:location.href='photos.php'" style="width: 20%; cursor: pointer; border: 1px solid black;"/>
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