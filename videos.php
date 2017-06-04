<?php
include_once 'inc/includes.php';
include_once 'util/SystemVariables.php';
include_once 'util/DatabaseUtils.php';

ob_start();
?>

<script type="text/javascript" src="js/jwplayer.js"></script>

<?php 
$result = DatabaseUtils::retrieveLastVideo();
$link = "";
while($row = mysql_fetch_array($result))
{
	$link = $row[SystemVariables::$COLUMN_LINK];
}
?>

<script type="text/javascript">
$(window).load(function(){
	jwplayer("container").setup({
		flashplayer: "swf/player.swf",
		file: "<?php echo $link;?>",
		height: 400,
		width: 940
	});
});
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
					<span class="color-1">Sporcu</span> videoları
				</h2>

				<?php 
				$result = DatabaseUtils::retrieveFiveVideos();
				$videos = "";
				while($row = mysql_fetch_array($result))
				{
					$id = $row[SystemVariables::$COLUMN_ID];
					$title = $row[SystemVariables::$COLUMN_TITLE];
					$summary = $row[SystemVariables::$COLUMN_SUMMARY];
					$date =  $row[SystemVariables::$COLUMN_DATE];
					$date = DatabaseUtils::stringToDate($date);
					$link = $row[SystemVariables::$COLUMN_LINK];
					parse_str( parse_url( $link, PHP_URL_QUERY ), $array_of_vars );

					$videos .= 	"<p class=\"p2\">";
					$videos .= 		"<strong>".$title."</strong>";
					$videos .= 		"<strong> ( ".$date." ) </strong>";
					$videos .= 	"</p>";
					$videos .= "<div class=\"videoContent\">";
					$videos .= 	"<a href=\"videodetail.php?p=videos&id=".$id."\">";
					$videos .= 	"<img src=\"http://img.youtube.com/vi/".$array_of_vars['v']."/0.jpg\" class=\"img-border img-indent\" style=\"height:100px;\">";
					$videos .= "</a>";
					$videos .= 	"<a href=\"videodetail.php?p=videos&id=".$id."\" class=\"p5\">".$summary."</a>";
					$videos .= 	"<a href=\"videodetail.php?p=videos&id=".$id."\" class=\"videoButton\">Videoyu İzle</a>";
					$videos .= 	"<div style=\"clear:both;\"></div>";
					$videos .= "</div>";
				}
				echo $videos;
				?>				
			</div>
			<div class="col-2">
				<h2 class="p6">
					<span class="color-1">Diğer</span> videolar
				</h2>
				
				
				<?php 
				$result = DatabaseUtils::retrieveVideos();
				$videoList = "<ul class=\"list-2\">";
				while($row = mysql_fetch_array($result))
				{
					$videoList .= "<li><a href=\"videodetail.php?p=videos&id=".$row[SystemVariables::$COLUMN_ID]."\">".$row[SystemVariables::$COLUMN_TITLE]."</a></li>";
				}
				$videoList .= "</ul>";
				
				echo $videoList;
				?>					
				
				<!--
				<p class="p2 top-6">
					<strong>Nam liber tempor cum</strong>
				</p>
				<p class="p4">Option congue nihil imperdiet doming id quod mazim
					placerat facer possim assum:</p>
				-->
			</div>
		</div>
	</div>
</div>

<?php
$content = ob_get_contents();
ob_end_clean();
include('master.php');
?>