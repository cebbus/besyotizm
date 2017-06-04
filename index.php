<?php
include_once 'inc/includes.php';
include_once 'util/SystemVariables.php';
include_once 'util/DatabaseUtils.php';

ob_start();
?>

<script type="text/javascript" src="fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<script type="text/javascript" src="fancybox/jquery.easing-1.4.pack.js"></script>
<script type="text/javascript" src="fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<link rel="stylesheet" href="fancybox/jquery.fancybox-1.3.4.css" type="text/css" media="screen" />
	
<script>
	$(window).load(function(){
		$('.slider')._TMS({
			prevBu:'.prev',
			nextBu:'.next',
			pauseOnHover:true,
			pagNums:false,
			duration:800,
			easing:'easeOutQuad',
			preset:'Fade',
			slideshow:7000,
			pagination:'.pagination',
			waitBannerAnimation:false,
			banners:'fade'
		});

		$('#slidorion').slidorion({
			speed: 1000,
			interval: 4000,
			effect: 'slideLeft'
		});	
	});

	$(document).ready(function() {		
		$("a#single_image").fancybox();		
	});
</script>


<div class="grid_12">
	<div class="slider">
		<?php 
		$newsCount = 0;
		$result = DatabaseUtils::retrieveHeadlineNews();
		$headlineNews = "<ul class=\"items\">";
		while($row = mysql_fetch_array($result))
		{
			$newsCount += 1;
				
			$title = $row[SystemVariables::$COLUMN_TITLE];
			if(strlen($title) > 45){
				$title = substr($title, 0, 45). " ...";
			}
		
			$summary = $row[SystemVariables::$COLUMN_SUMMARY];
			if(strlen($summary) > 250){
				$summary = substr($summary, 0, 250). " ...";
			}
		
			$headlineNews .=
			"<li>".
				"<img src=\"images/news/".$row[SystemVariables::$COLUMN_IMAGE]."\" alt=\"\">".
				"<div class=\"banner\">".
					"<p class=\"font-1\">".$title."</p>".
					"<p class=\"font-2\">".$summary."</p>".
					"<a href=\"newsdetail.php?id=".$row[SystemVariables::$COLUMN_ID]."\">".$lang['READ_MORE']."</a>".
				"</div>".
			"</li>";
		}
		$headlineNews .= "</ul>";
		$headlineNews .= "<div class=\"pagination\"><ul>";
		while ($newsCount > 0){
			$headlineNews .= "<li><a href=\"#\"></a></li>";
			$newsCount = $newsCount-1;
		}
		$headlineNews .= "</ul></div>";
		
		echo $headlineNews;		
		?>
	</div>
</div>

<div class="grid_12 top-1">
	<div class="box-shadow">
		<div class="wrap block-2">
			<div class="col-1">
				<h2 class="p3"><?php echo $lang['LATEST_EVENTS'];?></h2>
				
				<div class="wrap box-1">
				<div id="slidorion">
					<?php 
						$result = DatabaseUtils::retrieveFiveNews();
						$fiveNew = "<div id=\"slider\">";
						while($row = mysql_fetch_array($result)){
							$fiveNew .= 
							"<div class=\"slide\">".
							"<a href=\"newsdetail.php?id=".$row[SystemVariables::$COLUMN_ID]."\">".
								"<img src=\"images/news/".$row[SystemVariables::$COLUMN_IMAGE]."\">".
							"</a>".
							"</div>";
						}
						$fiveNew .= "</div>";

						$result = DatabaseUtils::retrieveFiveNews();
						$fiveNew .= "<div id=\"accordion\">";
						while($row = mysql_fetch_array($result)){
							$title = $row[SystemVariables::$COLUMN_TITLE];
							if(strlen($title) > 50){
								$title = substr($title, 0, 50). " ...";
							}
						
							$summary = $row[SystemVariables::$COLUMN_SUMMARY];
							if(strlen($summary) > 200){
								$summary = substr($summary, 0, 200). " ...";
							}
						
							$fiveNew .=
							"<div class=\"link-header\">".$title."</div>".
							"<div class=\"link-content\">".
								"<a href=\"newsdetail.php?id=".$row[SystemVariables::$COLUMN_ID]."\">".
									$summary.
								"</a>".
							"</div>";
						}
						$fiveNew .= "</div>";
						
						echo $fiveNew;										
					?>
				</div>
				
				<br/><br/>
				<h2 class="p3"><span class="color-1">Videolar</span></h2>
				
				<?php 
					$result = DatabaseUtils::retrieveMainVideos();
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
						$videos .= 	"<p href=\"videodetail.php?p=videos&id=".$id."\" class=\"p5\">".$summary.""."</p>";
						$videos .= "<a href=\"videodetail.php?p=videos&id=".$id."\" class=\"videoButton\">Videoyu İzle</a>";
						$videos .= 	"<div style=\"clear:both;\"></div>";
						$videos .= "</div>";
					}
					echo $videos;
				?>
				
				<br/><br/>
				<h2 class="p3"><span class="color-1">Fotoğraflar</span></h2>	
				<?php 
					$result = DatabaseUtils::retrieveMainPhotos();
					$photos = "";
					while($row = mysql_fetch_array($result))
					{
						$photo = $row[SystemVariables::$COLUMN_PHOTO];
								
						$photos .= "<div class=\"photoContent\">";
						$photos .=  "<a id=\"single_image\" href=\"images/gallery/".$photo."\"><img class=\"img-border img-indent\" src=\"util/TimThumb.php?src=images/gallery/".$photo."&w=125&h=100\" alt=\"\"/></a>";
						$photos .= "</div>";
					}
					echo $photos;
				?>				
							
				</div>		
						
				<!--
				<div class="wrap box-1">
					<img src="images/page1-img1.jpg" alt=""
						class="img-border img-indent">
					<div class="extra-wrap">
						<p class="p2">
							<strong>Ut wisi enim ad minim veniamis nostrud</strong>
						</p>
						<p>Exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex
							ea commodo consequat. Duis autem vel eum iriure dolor in
							hendrerit in vulputate velit esse molestie consequat, vel illum
							dolore eu feugiat nulla facilisis at vero eros et accumsan et
							iusto odio dignissim.</p>
					</div>
				</div>
				<div class="wrap box-1 top-2">
					<img src="images/page1-img2.jpg" alt=""
						class="img-border img-indent">
					<div class="extra-wrap">
						<p>
							<strong>Duis autem vel eum iriure dolor</strong>
						</p>
						<p>Hendrerit in vulputate velit esse molestie consequat, vel illum
							dolore eu feugiat nulla facilisis at vero eros et accumsan et
							iusto odio dignissim qui blandit praesent luptatum zzril delenit
							augue duis dolore te feugait nulla facilis lorem ipsum dolor.</p>
					</div>
				</div>
				-->
			</div>
			
			<div class="col-2">
			
				<h2 class="p3"><?php echo $lang['ABOUT_US'];?></h2>
					<p>Otizmli bireylerde spor ve yaşam liderliği alanında Bursa'da ki
						ilk gençlik ve spor kulübüdür.</p><br>
						
					<p><b><u>Şehnaz Orhan</u></b><br>
						Yönetim ve Organizasyon Koordinatörü<br>
						<b>Lisans</b><br>
						Uludağ Üniversitesi İ.İ.B.F İşletme<br>
						<b>Yüksek Lisans</b><br>
						Uludağ Üniversitesi İ.İ.B.F Yönetim Organizasyon						
					</p><br>
					
					<p><b><u>Erdal Bağcı</u></b><br>
						Kulüp Başkanı ve Spor Direktörü<br>
						<b>Lisans</b><br>
						Kocaeli Üniversitesi Beden Eğitimi ve Spor Öğretmenliği				
					</p><br>	
					
					<p><b><u>Koray Özdemir</u></b><br>
						Genel Spor Koordinatörü<br>
						<b>Lisans</b><br>
						Kocaeli Üniversitesi Spor Yöneticiliği				
					</p><br>																
				<br><br>
				
				<h2 class="p3"><?php echo $lang['CONTACT_US'];?></h2>
				<table>					
					<tr style="border-bottom: 1px solid silver;">
						<td style="background-color: #DEDEDE; padding: 2px;"><b>Telefon </b></td>
						<td style="background-color: #EEE; padding: 2px;"> 0 532 461 16 25</td>
					</tr>
					<tr style="border-bottom: 1px solid silver;">
						<td style="background-color: #DEDEDE; padding: 2px;"><b>Telefon </b></td>
						<td style="background-color: #EEE; padding: 2px;"> 0 506 207 65 91</td>
					</tr>
					<tr style="border-bottom: 1px solid silver;">
						<td style="background-color: #DEDEDE; padding: 2px;"><b>Telefon </b></td>
						<td style="background-color: #EEE; padding: 2px;"> 0 546 578 05 90</td>
					</tr>					
					<tr style="border-bottom: 1px solid silver;">
						<td style="background-color: #DEDEDE; padding: 2px;"><b>Mail </b></td>
						<td style="background-color: #EEE; padding: 2px;"> besyotizm@hotmail.com</td>
					</tr>
					<tr style="border-bottom: 1px solid silver;">
						<td colspan="2" style="background-color: #DEDEDE; padding: 2px;">Nilüferköy Mah. Akasya Sk. NO:7/1</td>
					</tr>
					<tr style="border-bottom: 1px solid silver;">
						<td colspan="2" style="background-color: #DEDEDE; padding: 2px;">Nilüferköy / Osmangazi / Bursa</td>
					</tr>															
				</table>
				
				<br/>

				<!--
					<ul class="list-1">
						<li><a href="#">Lorem ipsum dolor sit amet</a></li>
						<li><a href="#">Consetetur sadipscing elitr sed</a></li>
						<li><a href="#">Diam nonumy eirmod tempor</a></li>
						<li><a href="#">Invidunt ut labore dolore</a></li>
						<li><a href="#">Magna aliquyam erat sed</a></li>
					</ul>
					
					 
					<div class="form-search">
						<h2>
							<span class="color-1">Find us</span> near you
						</h2>
						<form id="form-search" method="post">
							<input type="text" value="Enter your Zip"
								onBlur="if(this.value=='') this.value='Enter your Zip'"
								onFocus="if(this.value =='Enter your Zip' ) this.value=''" /> <a
								href="#"
								onClick="document.getElementById('form-search').submit()"
								class="search_button">Search</a>
						</form>
					</div>
					-->
			</div>
		</div>
	</div>
</div>

<!--
<div class="grid_12 top-1">
	<div class="block-1 box-shadow">
		<img src="images/ata.jpg" alt="" height="70" class="img-border img-indent">
		<img src="images/tb.jpg" alt="" height="70" class="img-border img-indent">
		<img src="images/gsgm.jpg" alt="" height="70" class="img-border img-indent">
		<img src="images/ossp.jpg" alt="" height="70" class="img-border img-indent">
		<img src="images/tmok.jpg" alt="" height="70" class="img-border img-indent">
		<div class="clear"></div>
	</div>

	<div class="block-1 box-shadow">
		<p class="font-3">
			Fitness Club is one of <a
				href="http://blog.templatemonster.com/free-website-templates/"
				target="_blank" class="color-1">free website templates</a> created
			by TemplateMonster. This website template is optimized for 1280X1024
			screen resolution. This <a
				href="http://blog.templatemonster.com/2012/04/02/free-website-template-jquery-slider-fitness-club/"
				class="color-1">Fitness Club Template</a> goes with 2 packages –
			with PSD source files and without them. PSD source files are
			available for free for the registered members of TemplateMonster.com.
		</p>
	</div>

</div>
-->

<?php
$content = ob_get_contents();
ob_end_clean();
include('master.php');
?>