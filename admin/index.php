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

if($msg=="newsupdated"){
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
}else if($msg=="newsadded"){
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
}else if($msg=="newsdeleted"){
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

<script type="text/javascript">
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


function deleteNew(id,image){
	$( "#dialog-confirm" ).css("visibility","visible");
	$( "#dialog-confirm" ).dialog({
	    resizable: false,
	    height:175,
	    modal: true,
	    buttons: {
	        Ok: function() {
		        location.href='delete.php?id='+id+'&img='+image+'&PAGE=news';
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
		"<th scope=\"col\" style=\"width:36%\">Başlık</th>".
		"<th scope=\"col\" style=\"width:55%\">Özet</th>".
		"<th scope=\"col\" style=\"width:3%\">Resim</th>".
		"<th scope=\"col\" style=\"width:3%\">Düzenle</th>".
		"<th scope=\"col\" style=\"width:3%\">Sil</th>".
	"</tr>".
"</thead>";

$table .= "<tbody>";

$result = DatabaseUtils::retrieveNews();
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
	
	$table .= 
	"<tr>".
		"<td>".$title."</td>".
		"<td>".$summary."</td>".
		"<td><img class='preview' src='../images/image.png' id='../images/news/".$row[SystemVariables::$COLUMN_IMAGE]."'></td>".
		"<td><a href=\"editnews.php?id=".$row[SystemVariables::$COLUMN_ID]."\"><img src='../images/edit.png'></a></td>".
		"<td><a href=\"#\" onclick=\"deleteNew('".$row[SystemVariables::$COLUMN_ID]."','".$row[SystemVariables::$COLUMN_IMAGE]."');\"><img src='../images/delete.png'></a></td>".
	"</tr>";
}

$table .= "</tbody>";

echo "<table id=\"box-table-a\" class=\"paginated\">".$table."</table>";
?>

<div id="dialog-message" title="İşlem Başarılı" style="visibility: hidden;">
    <p>
        <span class="ui-icon ui-icon-circle-check" style="float: left; margin: 0 7px 50px 0;"></span>
        Haber Güncellendi.
    </p>
</div>

<div id="dialog-message_add" title="İşlem Başarılı" style="visibility: hidden;">
    <p>
        <span class="ui-icon ui-icon-circle-check" style="float: left; margin: 0 7px 50px 0;"></span>
        Haber Eklendi.
    </p>
</div>

<div id="dialog-message_delete" title="İşlem Başarılı" style="visibility: hidden;">
    <p>
        <span class="ui-icon ui-icon-circle-check" style="float: left; margin: 0 7px 50px 0;"></span>
        Haber Silindi.
    </p>
</div>

<div id="dialog-confirm" title="Emin misiniz?" style="visibility: hidden;">
    <p><span class="ui-icon ui-icon-alert" style="float: left; margin: 0 7px 20px 0;"></span>
    Seçtiğiniz haber silinecek. İşlemi yapmak istediğinize emin misiniz?</p>
</div>


<?php
$adminContent = ob_get_contents();
ob_end_clean();
include('../admin/master.php');
?>