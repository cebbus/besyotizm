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

if($msg=="videoupdated"){
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
}else if($msg=="videoadded"){
	?>
	<script>
	$(function() {
		$( "#dialog-message_add" ).css("visibility","visible");
	    $( "#dialog-message_add" ).dialog({
			modal: true,
	        buttons: {
	        	Ok: function() {
	            	$( this ).dialog( "close" );
	            	$( "#dialog-message_add" ).css("visibility","hidden");
				}
			}
		});	
	});	
	</script>
	<?php	
}else if($msg=="videodeleted"){
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
		$( "#dialog-message_show_main" ).css("visibility","visible");
	    $( "#dialog-message_show_main" ).dialog({
			modal: true,
	        buttons: {
	        	Ok: function() {
	            	$( this ).dialog( "close" );
	            	$( "#dialog-message_show_main" ).css("visibility","hidden");
				}
			}
		});	
	});	
	</script>
	<?php	
}
?>

<script>
$(function(){
	$('table.paginated').each(function() {
	    var currentPage = 0;
	    var numPerPage = 10;
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

function deleteVideo(id){
	$( "#dialog-confirm" ).css("visibility","visible");
	$( "#dialog-confirm" ).dialog({
	    resizable: false,
	    height:175,
	    modal: true,
	    buttons: {
	        Ok: function() {
		        location.href='delete.php?id='+id+'&PAGE=video';
	        },
	        Cancel: function() {
	            $( this ).dialog( "close" );
	            $( "#dialog-confirm" ).css("visibility","hidden");
	        }
	    }
	});
}	

function updateShowSettings(){
	var checkedId = '',
		unCheckedId = '';

	var inputArr = $('input').get();
	
	for(var i = 0; i < inputArr.length; i++){
		if(inputArr[i].type == 'checkbox'){
			if(inputArr[i].checked==true)
				checkedId += inputArr[i].id + ',';
			else
				unCheckedId += inputArr[i].id + ',';
				
		}
	}
	
	if(checkedId != '' || unCheckedId != ''){
		if(checkedId != '')
			checkedId = checkedId.substring(0, checkedId.length-1);
		if(unCheckedId != '')
			unCheckedId = unCheckedId.substring(0, unCheckedId.length-1);
				
		$('#checkedId').val(checkedId);
		$('#uncheckedId').val(unCheckedId);
		document.getElementById('showVideosForm').submit();
	}
}
</script>

<?php 
$table = 
"<thead>".
	"<tr>".
		"<th scope=\"col\" style=\"width:34%\">Başlık</td>".
		"<th scope=\"col\" style=\"width:52%\">Özet</th>".
		"<th scope=\"col\" style=\"width:8%\">Ana Sayfa</th>".
		"<th scope=\"col\" style=\"width:3%\">Düzenle</td>".
		"<th scope=\"col\" style=\"width:3%\">Sil</td>".
	"</tr>".
"</thead>";

$table .= "<tbody>";

$result = DatabaseUtils::retrieveVideos();
while($row = mysql_fetch_array($result))
{
	$title = $row[SystemVariables::$COLUMN_TITLE];
	if(strlen($title) > 200){
		$title = substr($title, 0, 200). " ...";
	}
	
	$summary = $row[SystemVariables::$COLUMN_SUMMARY];
	if(strlen($summary) > 200){
		$summary = substr($summary, 0, 200). " ...";
	}
	
	$showMain = $row[SystemVariables::$COLUMN_SHOW_MAIN];
	
	$checkBoxStr = "<input type=\"checkbox\" id=\"".$row[SystemVariables::$COLUMN_ID]."\">";
	if($showMain == 1){
		$checkBoxStr = "<input type=\"checkbox\" id=\"".$row[SystemVariables::$COLUMN_ID]."\" checked=\"true\">";
	}	
	
	$table .= 
	"<tr>".
		"<td>".$title."</td>".
		"<td>".$summary."</td>".
		"<td>".$checkBoxStr."</td>".
		"<td><a href=\"editvideos.php?id=".$row[SystemVariables::$COLUMN_ID]."\"><img src='../images/edit.png'></a></td>".
		"<td><a href=\"#\" onclick=\"deleteVideo('".$row[SystemVariables::$COLUMN_ID]."');\"><img src='../images/delete.png'></a></td>".
	"</tr>";
}

$table .= "</tbody>";

echo "<table id=\"box-table-a\" class=\"paginated\">".$table."</table>";
?>

<input type="button" value="Seçilenleri Onayla" 
	style="margin-top:3px; padding:3px; cursor: pointer; border: 1px solid black;" 
	onclick="updateShowSettings()">

<form action="save.php" method="post" id="showVideosForm">
	<input type="hidden" name="<?php echo SystemVariables::$PARAM_PAGE;?>" id="<?php echo SystemVariables::$PARAM_PAGE;?>" value="showVideosMainPage">
	<input type="hidden" name="checkedId" id="checkedId">
	<input type="hidden" name="uncheckedId" id="uncheckedId">
</form>

<div id="dialog-message" title="İşlem Başarılı" style="visibility: hidden;">
    <p>
        <span class="ui-icon ui-icon-circle-check" style="float: left; margin: 0 7px 50px 0;"></span>
        Video Güncellendi.
    </p>
</div>

<div id="dialog-message_add" title="İşlem Başarılı" style="visibility: hidden;">
    <p>
        <span class="ui-icon ui-icon-circle-check" style="float: left; margin: 0 7px 50px 0;"></span>
        Video Eklendi.
    </p>
</div>

<div id="dialog-message_delete" title="İşlem Başarılı" style="visibility: hidden;">
    <p>
        <span class="ui-icon ui-icon-circle-check" style="float: left; margin: 0 7px 50px 0;"></span>
        Video Silindi.
    </p>
</div>

<div id="dialog-confirm" title="Emin misiniz?" style="visibility: hidden;">
    <p><span class="ui-icon ui-icon-alert" style="float: left; margin: 0 7px 20px 0;"></span>
    Seçtiğiniz video silinecek. İşlemi yapmak istediğinize emin misiniz?</p>
</div>

<div id="dialog-message_show_main" title="İşlem Başarılı" style="visibility: hidden;">
    <p>
        <span class="ui-icon ui-icon-circle-check" style="float: left; margin: 0 7px 50px 0;"></span>
        Ana sayfada video gösterme / gizleme işlemi başarıyla yapıldı.
    </p>
</div>

<?php
$adminContent = ob_get_contents();
ob_end_clean();
include('../admin/master.php');
?>