<?php
include_once 'inc/includes.php';
include_once 'util/SystemVariables.php';
include_once 'util/DatabaseUtils.php';

ob_start();
?>

<script src="js/uCarousel.js"></script>
<script src="js/tms-0.4.1.js"></script>
	
<script type="text/javascript">
$(document).ready(function(){
	$('.gallery')._TMS({
		show:0,
		pauseOnHover:true,
		prevBu:'.prev',
		nextBu:'.next',
		playBu:'.play',
		duration:700,
		preset:'fade',
		pagination:$('.img-pags').uCarousel({show:4,shift:0}),
		pagNums:false,
		slideshow:7000,
		numStatus:true,
		banners:false,
		waitBannerAnimation:true,
		progressBar:false
	});
});
</script>

<div class="grid_12">
	<div id="slide">
		<div class="gallery">
		<?php 
			$result = DatabaseUtils::retrievePhotos();
			$images = "<ul class=\"items\">";
			while($row = mysql_fetch_array($result)){
				//$images .= "<li><img src=\"images/gallery/".$row[SystemVariables::$COLUMN_PHOTO]."\" alt=\"\"></li>";
				$images .= "<li><img src=\"util/TimThumb.php?src=images/gallery/".$row[SystemVariables::$COLUMN_PHOTO]."&h=525&w=940\" alt=\"\"></li>";
			}
			$images .= "</ul>";
			
			echo $images;
		?>
		</div>
		<a href="#" class="prev"></a><a href="#" class="next"></a>
	</div>
</div>

<div class="grid_12 top-1">
	<div class="block-3 box-shadow">
		<h2 class="p4">
			<span class="color-1">Fotoğraf</span> galerisi
		</h2>
		<div class="pag">
			<div class="img-pags">
				<?php 
					$result = DatabaseUtils::retrievePhotos();
					$imagesT = "<ul>";
					while($row = mysql_fetch_array($result)){
						$imagesT .= "<li><a href=\"#\"><span><img src=\"util/TimThumb.php?src=images/gallery/".$row[SystemVariables::$COLUMN_PHOTO]."&w=200&h=140\" alt=\"\"></span></a></li>";
					}
					$imagesT .= "</ul>";
					
					echo $imagesT;
				?>			
			</div>
		</div>
	</div>
</div>

<?php
$content = ob_get_contents();
ob_end_clean();
include('master.php');
?>