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

if($msg=="userupdated"){
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
}else if($msg=="useradded"){
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
}else if($msg=="userdeleted"){
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
}
?>

<script>
function deleteUser(id){
	$( "#dialog-confirm" ).css("visibility","visible");
	$( "#dialog-confirm" ).dialog({
	    resizable: false,
	    height:175,
	    modal: true,
	    buttons: {
	        Ok: function() {
		        location.href='delete.php?id='+id+'&PAGE=user';
	        },
	        Cancel: function() {
	            $( this ).dialog( "close" );
	            $( "#dialog-confirm" ).css("visibility","hidden");
	        }
	    }
	});
}	
</script>

<?php 
$table = 
"<thead>".
	"<tr>".
		"<th scope=\"col\" style=\"width:94%\">Kullanıcı Adı</td>".
		"<th scope=\"col\" style=\"width:3%\">Düzenle</td>".
		"<th scope=\"col\" style=\"width:3%\">Sil</td>".
	"</tr>".
"</thead>";

$table .= "<tbody>";

$result = DatabaseUtils::retrieveUsers();
while($row = mysql_fetch_array($result))
{
	$username = $row[SystemVariables::$COLUMN_USERNAME];
	
	$table .= 
	"<tr>".
		"<td>".$username."</td>".
		"<td><a href=\"editusers.php?id=".$row[SystemVariables::$COLUMN_ID]."\"><img src='../images/edit.png'></a></td>".
		"<td><a href=\"#\" onclick=\"deleteUser('".$row[SystemVariables::$COLUMN_ID]."');\"><img src='../images/delete.png'></a></td>".
	"</tr>";
}

$table .= "</tbody>";

echo "<table id=\"box-table-a\" class=\"paginated\">".$table."</table>";
?>

<div id="dialog-message" title="İşlem Başarılı" style="visibility: hidden;">
    <p>
        <span class="ui-icon ui-icon-circle-check" style="float: left; margin: 0 7px 50px 0;"></span>
        Kullanıcı Güncellendi.
    </p>
</div>

<div id="dialog-message_add" title="İşlem Başarılı" style="visibility: hidden;">
    <p>
        <span class="ui-icon ui-icon-circle-check" style="float: left; margin: 0 7px 50px 0;"></span>
        Kullanıcı Eklendi.
    </p>
</div>

<div id="dialog-message_delete" title="İşlem Başarılı" style="visibility: hidden;">
    <p>
        <span class="ui-icon ui-icon-circle-check" style="float: left; margin: 0 7px 50px 0;"></span>
        Kullanıcı Silindi.
    </p>
</div>

<div id="dialog-confirm" title="Emin misiniz?" style="visibility: hidden;">
    <p><span class="ui-icon ui-icon-alert" style="float: left; margin: 0 7px 20px 0;"></span>
    Seçtiğiniz kullanıcı silinecek. İşlemi yapmak istediğinize emin misiniz?</p>
</div>

<?php
$adminContent = ob_get_contents();
ob_end_clean();
include('../admin/master.php');
?>