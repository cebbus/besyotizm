<?php
include_once 'inc/includes.php';
include_once 'util/SystemVariables.php';
include_once 'util/DatabaseUtils.php';

ob_start();

DatabaseUtils::open();
$id = $_GET['id'];
$id = stripslashes($id);
$id = mysql_real_escape_string($id);
DatabaseUtils::close();

if(!is_numeric($id)){
	header("location:index.php?");
}

$result = DatabaseUtils::retrieveVideo($id);
while($row = mysql_fetch_array($result))
{
	$title = $row[SystemVariables::$COLUMN_TITLE];
	$title1 = substr($title, 0, strpos($title, " "));
	$title2 = substr($title, strpos($title, " "), strlen($title));	
	$summary = $row[SystemVariables::$COLUMN_SUMMARY];
	$date =  $row[SystemVariables::$COLUMN_DATE];
	$date = DatabaseUtils::stringToDate($date);
	$link = $row[SystemVariables::$COLUMN_LINK];
}
?>

<script type="text/javascript" src="js/jwplayer.js"></script>

<script type="text/javascript">
$(window).load(function(){
	jwplayer("container").setup({
		flashplayer: "swf/player.swf",
		file: "<?php echo $link;?>",
		height: 400,
		width: 940
	});
});

function commentSubmit(){
	if($('#NAME_SURNAME').val().length < 4){
		alert('Ad Soyad giriniz.');
		return;
	}

	if($('#MESSAGE').val().length < 4){
		alert('Yorumunuzu giriniz.');
		return;
	}	

    $.ajax({
		type:'POST',
       	url:'savecomment.php',
       	data:$('#commentForm').serialize(),
       	success:function(respond){
           	$('#commentForm').each (function(){
            	this.reset();
            });
           	alert('Yorumunuz kaydedildi. Kısa bir süre sonra yayınlanacaktır.');
       	},
       	error:function (xhr, ajaxOptions, errorThrown){
       		alert('Yorum kaydedilirken bir hata oluştu.');
       	}
    });
}

function resetForm(){
   	$('#commentForm').each (function(){
    	this.reset();
    });
}
</script>

<div class="grid_12">
	<div id="slide">
		<div id="container">Loading the player ...</div>
	</div>
</div>

<div class="grid_12 top-1">
	<div class="box-shadow">
		<div class="wrap block-2">
			<div class="col-1">
				<h2 class="p3">
					<span class="color-1"><?php echo $title1;?></span> <?php echo $title2;?>
				</h2>
				<p class="p2">
					<strong style="float: left;"><?php echo $date;?></strong><br/>
				</p>
				<p class="p5"><?php echo $summary;?></p>
				<br/>
				<h2 class="p3"><span class="color-1">Yorumlar</span></h2>
				<?php 
				$result = DatabaseUtils::retrieveComment($id, SystemVariables::$PARAM_COMMENT_VIDEOS_PAGE);
				$com = "";
				while($row = mysql_fetch_array($result))
				{
					$nameSurname = $row[SystemVariables::$COLUMN_NAME_SURNAME];
					$mes = $row[SystemVariables::$COLUMN_MESSAGE];
					$com .= "<img src=\"images/comments-icon.jpg\" style=\"float:left; height:50px;\">";
					$com .= "<p class=\"p2\"><strong>".$nameSurname."</strong></p>";
					$com .= "<p class=\"p5\" style=\"border-bottom: 1px solid silver;\">".$mes."</p>";
				}
				echo $com;
				?>
			</div>
			<div class="col-2">
				<h2 class="p6">
					<span class="color-1">Diğer</span> videolar
				</h2>				
				
				<?php 
					$result1 = DatabaseUtils::retrieveVideos();
					$newsList = "<ul class=\"list-2\">";
					while($row = mysql_fetch_array($result1))
					{
						$newsList .= "<li><a href=\"videodetail.php?p=videos&id=".$row[SystemVariables::$COLUMN_ID]."\">".$row[SystemVariables::$COLUMN_TITLE]."</a></li>";
					}
					$newsList .= "</ul>";
					
					echo $newsList;
				?>
			</div>
		</div>
	</div>
</div>

<div class="grid_12 top-1">
	<div class="block-1 box-shadow">
		<h2 class="p3"><span class="color-1">Yorum</span> yazın</h2>
		<form id="commentForm" method="post" action="savecomment.php">
			<input type="hidden" id="<?php echo SystemVariables::$COLUMN_ID;?>" name="<?php echo SystemVariables::$COLUMN_ID;?>" value="<?php echo $id;?>"/>
			<input type="hidden" 
				id="<?php echo SystemVariables::$COLUMN_PAGE;?>" 
				name="<?php echo SystemVariables::$COLUMN_PAGE;?>" 
				value="<?php echo SystemVariables::$PARAM_COMMENT_VIDEOS_PAGE;?>"/>			
			<fieldset>
				<label>
					<input type="text" value="Ad Soyad"
						id="<?php echo SystemVariables::$COLUMN_NAME_SURNAME;?>"
						name="<?php echo SystemVariables::$COLUMN_NAME_SURNAME;?>" 
						onBlur="if(this.value=='') this.value='Ad Soyad'"
						onFocus="if(this.value =='Ad Soyad' ) this.value=''"> 
				</label> 
				<label>
					<input type="text" value="Email"
						id="<?php echo SystemVariables::$COLUMN_EMAIL;?>"
						name="<?php echo SystemVariables::$COLUMN_EMAIL;?>" 
						onBlur="if(this.value=='') this.value='Email'"
						onFocus="if(this.value =='Email' ) this.value=''"> 
				</label> 
				<label>
					<textarea
						id="<?php echo SystemVariables::$COLUMN_MESSAGE;?>"
						name="<?php echo SystemVariables::$COLUMN_MESSAGE;?>" 					
						onBlur="if(this.value==''){this.value='Yorum'}"
						onFocus="if(this.value=='Yorum'){this.value=''}">Yorum</textarea>
				</label>
				<div class="commentBtns">
					<a href="#" class="commentButton" onclick="resetForm()">TEMİZLE</a>
					<a href="#" class="commentButton" onClick="commentSubmit()">GÖNDER</a>
				</div>
			</fieldset>
		</form>
		<div class="clear"></div>
	</div>
</div>

<?php
$content = ob_get_contents();
ob_end_clean();
include('master.php');
?>