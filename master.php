<!DOCTYPE html>
<html lang="tr">
<head>
    <title><?php echo $lang['PAGE_TITLE']?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" media="screen" href="css/reset.css">
    <link rel="stylesheet" type="text/css" media="screen" href="css/style.css">
    <link rel="stylesheet" type="text/css" media="screen" href="css/grid_12.css">
    <link rel="stylesheet" type="text/css" media="screen" href="css/slider.css">
    <link rel="stylesheet" type="text/css" media="screen" href="css/slidorion.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="css/demo.css">
    <link href='http://fonts.googleapis.com/css?family=Ubuntu' rel='stylesheet' type='text/css'>
    <script src="js/jquery-1.7.min.js"></script>
    <script src="js/jquery.easing.1.3.js"></script>   
    <script src="js/tms-0.3.js"></script>
	<script src="js/tms_presets.js"></script>  	
    <script src="js/cufon-yui.js"></script>
    <script src="js/Coolvetica_400.font.js"></script>
    <!--  <script src="js/Asap_400.font.js"></script> -->
	<script src="js/Kozuka_M_500.font.js"></script>
    <script src="js/cufon-replace.js"></script>
    <script src="js/FF-cash.js"></script>
    <script src="js/jquery.slidorion.min.js"></script>
	<!--[if lt IE 8]>
       <div style=' clear: both; text-align:center; position: relative;'>
         <a href="http://windows.microsoft.com/en-US/internet-explorer/products/ie/home?ocid=ie6_countdown_bannercode">
           <img src="http://storage.ie6countdown.com/assets/100/images/banners/warning_bar_0000_us.jpg" border="0" height="42" width="820" alt="You are using an outdated browser. For a faster, safer browsing experience, upgrade for free today." />
        </a>
      </div>
    <![endif]-->
    <!--[if lt IE 9]>
   		<script type="text/javascript" src="js/html5.js"></script>
    	<link rel="stylesheet" type="text/css" media="screen" href="css/ie.css">
	<![endif]-->
		
	<script type="text/javascript">
		function getUrlVars() {
		    var vars = {};
		    var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
		        vars[key] = value;
		    });
		    return vars;
		}
	
		$(document).ready(function(){
			var curr = "_"+getUrlVars()["p"];
			if(curr == "_undefined"){
				return;
			}
				
			var liArr = $('ul.menu li').get();
				
			for(var i = 0; i < liArr.length; i++){
				liArr[i].className = "";
				if(liArr[i].id==curr){
					liArr[i].className = "current";
					break;
				}
			}

			startList = function() { 
			    if (document.all&&document.getElementById) { 
			        navRoot = document.getElementById("menu"); 
			        for(var i = 0; i < liArr.length; i++){
			            node = iArr[i]; 
		                node.onmouseover=function() { 
		                this.className+=" over"; 
		                } 
		                node.onmouseout=function() { 
		                this.className=this.className.replace(" over", ""); 
		                } 
			        } 
			    } 
			} 
			
			window.onload=startList;			
		});		
	</script>
</head>

<body>
<div class="main">
	<div class="bg-img"></div>
<!--==============================header=================================-->
    <header>
    <!-- <div class="box-shadow" style="margin: 0 10px 0 10px;"> -->

        <nav>
        	<div class="social-icons">
            	<a href="http://www.facebook.com/besyotizm" target="_blank" class="icon-2"></a>
            	<a href="http://www.twitter.com/besyotizm" target="_blank" class="icon-1"></a>
            </div>
            <ul class="menu">
                <li id="_index" class="current" style="margin-left: 15px;"><a href="index.php?p=index"><?php echo $lang['MENU_HOME']?></a></li>
                <li id="_services"><a href="services.php?p=services"><?php echo $lang['MENU_SERVICES']?></a>
                	<ul>
                		<li><a href="#">Spor Aktivitelerimiz</a>
                			<ul>
                				<li><a href="#">Yüzme</a></li>
                				<li><a href="#">Masa Tenisi</a></li>
                				<li><a href="#">Fitness</a></li>
                				<li><a href="#">Jimnastik</a></li>
                				<li><a href="#">Bisiklet</a></li>
                				<li><a href="#">Kürek</a></li>
                				<li><a href="#">Plates</a></li>
                				<li><a href="#">Kayak</a></li>
                				<li><a href="#">Paten</a></li>
                				<li><a href="#">Doğa Yürüyüşü</a></li>
                				<li><a href="#">Badminton</a></li>
                				<li><a href="#">Tenis</a></li>
                			</ul>
                		</li>
                		<li><a href="#">Yaşam Becerileri</a>
                			<ul>
                				<li><a href="#">Günlük Yaşam Becerisi</a></li>
                				<li><a href="#">Özbakım Becerisi</a></li>
                				<li><a href="#">Topluma Entegrasyon</a></li>
                				<li><a href="#">Bağımsız Birey Gelişimi</a></li>
                				<li><a href="#">İletişim - Etkileşim Becerisi</a></li>
                			</ul>
                		</li>
                	</ul>
                </li>
                <li id="_videos"><a href="videos.php?p=videos"><?php echo $lang['MENU_SPORTS_VIDEO']?></a></li>
                <li id="_vis"><a href="misvis.php?p=vis"><?php echo $lang['MENU_VIS']?></a></li>
                <li id="_gallery"><a href="gallery.php?p=gallery"><?php echo $lang['MENU_GALLERY']?></a></li>
                <li id="_contacts"><a href="contacts.php?p=contacts"><?php echo $lang['MENU_CONTACT']?></a></li>
            </ul>
        </nav>
    <!-- </div> -->
    
    <img style="float:left; margin-left: 10px;" width="940px" height="250px" src="images/header_2.jpg" alt="besyotizm logo"/>
    <div style="clear: both;"></div>
    <div class="box-shadow" style="margin: 10px 10px 0 10px;">
    	<p id="headslogan"><?php echo $lang['SLOGAN']?></p>
    </div>
    </header>   
<!--==============================content================================-->
    <section id="content">
    	<div class="ic"></div>
    	<div class="container_12">
    		<?php echo $content;?>
    		<div class="clear"></div>
		</div>
    	
    </section> 
<!--==============================footer=================================-->
    <footer>
        <p>© 2013 Besyotizm</p>
        <!-- <p><?php echo $lang['SLOGAN']?></p> -->
        <p>Görüş, öneri ve istek için iletişim formunu kullanabilir ayrıca haberlerimize yorum yapabilirsiniz.</p>
		<p>Sitenin tüm hakları saklıdır. İzinsiz kopyalanamaz ve çoğaltılamaz.</p>
    </footer>	
</div>    
<script>
	Cufon.now();
</script>
</body>
</html>