<?php
include_once '../util/SystemVariables.php';
include_once '../util/DatabaseUtils.php';
include_once 'logincheck.php';

ob_start();
$msg = null;
if(isset($_GET[SystemVariables::$SUCCESS_MSG])){
	$msg = $_GET[SystemVariables::$SUCCESS_MSG];
}else if(isset($_GET[SystemVariables::$FAILURE_MSG])){
	$msg = $_GET[SystemVariables::$FAILURE_MSG];
}

function createTableHead(){
	$tableHead = 
		"<thead>".
			"<tr>".
				"<th scope=\"col\" style=\"width:20%\">Başlık</td>".
				"<th scope=\"col\" style=\"width:10%\">Ad Soyad</td>".
				"<th scope=\"col\" style=\"width:10%\">Email</td>".
				"<th scope=\"col\" style=\"width:54%\">Yorum</td>".
				"<th scope=\"col\" style=\"width:3%\">Onay</td>".
				"<th scope=\"col\" style=\"width:3%\">Sil</td>".
			"</tr>".
		"</thead>";
	return $tableHead;
}

function createTableBody($row, $isApprove){
	$newsTitle = $row[SystemVariables::$COLUMN_TITLE];
	$nameSurname = $row[SystemVariables::$COLUMN_NAME_SURNAME];
	$email = $row[SystemVariables::$COLUMN_EMAIL];
	$message = $row[SystemVariables::$COLUMN_MESSAGE];
	
	$approveStr = "approve";
	if(!$isApprove){
		$approveStr = "removeApprove";
	}
	
	$tableBody =
	"<tr>".
		"<td>".$newsTitle."</td>".
		"<td>".$nameSurname."</td>".
		"<td>".$email."</td>".
		"<td>".$message."</td>".
		"<td><input type=\"checkbox\" id=\"".$approveStr."_".$row[SystemVariables::$COLUMN_ID]."\" ></td>".
		"<td><a href=\"#\" onclick=\"deleteComment('".$row[SystemVariables::$COLUMN_ID]."');\"><img src='../images/delete.png'></a></td>".
	"</tr>";
	return $tableBody;
}

if($msg=="commentdeleted"){
?>
	<script>
	$(function() {
		$( "#dialog-message_delete" ).css("visibility","visible");
	    $( "#dialog-message_delete" ).dialog({
			modal: true,
	        buttons: {
	        	Ok: function() {
	            	$( this ).dialog( "close" );
	            	$( "#dialog-message_delete" ).css("visibility","hidden");
				}
			}
		});	
	});	
	</script>
	<?php	
}else if ($msg=="processcomplate"){
?>
	<script>
	$(function() {
		$( "#dialog-message" ).css("visibility","visible");
	    $( "#dialog-message" ).dialog({
			modal: true,
	        buttons: {
	        	Ok: function() {
	            	$( this ).dialog( "close" );
	            	$( "#dialog-message" ).css("visibility","hidden");
				}
			}
		});	
	});	
	</script>
	<?php	
}
?>

<script>
function deleteComment(id){
	$( "#dialog-confirm" ).css("visibility","visible");
	$( "#dialog-confirm" ).dialog({
	    resizable: false,
	    height:175,
	    modal: true,
	    buttons: {
	        Ok: function() {
		        location.href='delete.php?id='+id+'&PAGE=comment';
	        },
	        Cancel: function() {
	            $( this ).dialog( "close" );
	            $( "#dialog-confirm" ).css("visibility","hidden");
	        }
	    }
	});
}	

function approveComment(){
	var id = '';

	var inputArr = $('input').get();
	
	for(var i = 0; i < inputArr.length; i++){
		if(inputArr[i].type == 'checkbox' && 
			inputArr[i].id.indexOf('approve_')==0 && 
			inputArr[i].checked==true){
			
			id += inputArr[i].id.substring(8, inputArr[i].id.length)+',';
		}
	}
	
	if(id != ''){
		id = id.substring(0, id.length-1);
		$('#checkedId').val(id);
		document.getElementById('commentForm').submit();
	}
}

function removeApproveComment(){
	var id = '';

	var inputArr = $('input').get();
	
	for(var i = 0; i < inputArr.length; i++){
		if(inputArr[i].type == 'checkbox' && 
			inputArr[i].id.indexOf('removeApprove_')==0 && 
			inputArr[i].checked==true){
			
			id += inputArr[i].id.substring(14, inputArr[i].id.length)+',';
			
		}
	}

	if(id != ''){
		id = id.substring(0, id.length-1);
		$('#uncheckedId').val(id);
		document.getElementById('commentForm').submit();
	}
}

$(function(){
	$('table.paginated').each(function() {
	    var currentPage = 0;
	    var numPerPage = 5;
	    var $table = $(this);
	    $table.bind('repaginate', function() {
	        $table.find('tbody tr').hide().slice(currentPage * numPerPage, (currentPage + 1) * numPerPage).show();
	    });
	    $table.trigger('repaginate');
	    var numRows = $table.find('tbody tr').length;
	    var numPages = Math.ceil(numRows / numPerPage);
	    var $pager = $('<div class="pager"></div>');
	    for (var page = 0; page < numPages; page++) {
	        $('<span class="page-number"></span>').text(page + 1).bind('click', {
	            newPage: page
	        }, function(event) {
	            currentPage = event.data['newPage'];
	            $table.trigger('repaginate');
	            $(this).addClass('active').siblings().removeClass('active');
	        }).appendTo($pager).addClass('clickable');
	    }
	    $pager.insertAfter($table).find('span.page-number:first').addClass('active');
	});
});
</script>

<p style="background-color: blue; font-weight: bold; font-size: 13px;
	padding-left: 8px; color: white; width: 84.3%">Onay Bekleyen Yorumlar</p>
<?php 
$table = createTableHead();

$table .= "<tbody>";

$result = DatabaseUtils::retrieveWaitingForApproval(SystemVariables::$TABLE_NEWS, 
	SystemVariables::$PARAM_COMMENT_NEWS_PAGE);
while($row = mysql_fetch_array($result))
{
	$table .= createTableBody($row, true);
}

$result = DatabaseUtils::retrieveWaitingForApproval(SystemVariables::$TABLE_VIDEOS,
		SystemVariables::$PARAM_COMMENT_VIDEOS_PAGE);
while($row = mysql_fetch_array($result))
{
	$table .= createTableBody($row, true);
}

$table .= "</tbody>";

echo "<table id=\"box-table-a\" class=\"paginated\">".$table."</table>";
?>
<input type="button" value="Seçilenleri Onayla" 
	style="margin-top:3px; padding:3px; cursor: pointer; border: 1px solid black;" 
	onclick="approveComment()">
	
<br><br>
<p style="background-color: blue; font-weight: bold; font-size: 13px;
	padding-left: 8px; color: white; width: 84.3%">Onaylanmış Yorumlar</p>
<?php 
$table = createTableHead();

$table .= "<tbody>";

$result = DatabaseUtils::retrieveApproved(SystemVariables::$TABLE_NEWS,
		SystemVariables::$PARAM_COMMENT_NEWS_PAGE);
while($row = mysql_fetch_array($result))
{
	$table .= createTableBody($row, false);
}

$result = DatabaseUtils::retrieveApproved(SystemVariables::$TABLE_VIDEOS,
		SystemVariables::$PARAM_COMMENT_VIDEOS_PAGE);
while($row = mysql_fetch_array($result))
{
	$table .= createTableBody($row, false);
}

$table .= "</tbody>";

echo "<table id=\"box-table-a\" class=\"paginated\">".$table."</table>";
?>
<input type="button" value="Seçilenlerin Onayını Kaldır" 
	style="margin-top:3px; padding:3px; cursor: pointer; border: 1px solid black;" 
	onclick="removeApproveComment()">
	
<form action="save.php" method="post" id="commentForm">
	<input type="hidden" name="<?php echo SystemVariables::$PARAM_PAGE;?>" id="<?php echo SystemVariables::$PARAM_PAGE;?>" value="comment">
	<input type="hidden" name="checkedId" id="checkedId">
	<input type="hidden" name="uncheckedId" id="uncheckedId">
</form>

<div id="dialog-message" title="İşlem Başarılı" style="visibility: hidden;">
    <p>
        <span class="ui-icon ui-icon-circle-check" style="float: left; margin: 0 7px 50px 0;"></span>
        Yorum onaylama ve onay kaldırma işlemleri yapıldı.
    </p>
</div>

<div id="dialog-message_delete" title="İşlem Başarılı" style="visibility: hidden;">
    <p>
        <span class="ui-icon ui-icon-circle-check" style="float: left; margin: 0 7px 50px 0;"></span>
        Yorum Silindi.
    </p>
</div>

<div id="dialog-confirm" title="Emin misiniz?" style="visibility: hidden;">
    <p><span class="ui-icon ui-icon-alert" style="float: left; margin: 0 7px 20px 0;"></span>
    Seçtiğiniz yorum silinecek. İşlemi yapmak istediğinize emin misiniz?</p>
</div>

<?php
$adminContent = ob_get_contents();
ob_end_clean();
include('../admin/master.php');
?>