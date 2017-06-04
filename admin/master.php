<!DOCTYPE html>
<html lang="tr">
<head>
    <title>Otizm Club Yönetim Paneli</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" media="screen" href="../css/reset.css">
    <link rel="stylesheet" type="text/css" media="screen" href="../css/admin.css">
    <link rel="stylesheet" type="text/css" media="screen" href="../css/ui-lightness/jquery-ui-1.9.1.custom.min.css">
    <script src="../js/jquery-1.7.min.js"></script>
    <script src="../js/jquery.easing.1.3.js"></script>
    <script src="../js/jquery-ui-1.9.1.custom.min.js"></script>
    <script src="../js/image_tooltip.js"></script>
    <script src="../js/ckeditor/ckeditor.js"></script>
    <script src="../js/ckfinder/ckfinder.js"></script>
    
    <script type="text/javascript">
    $(function(){
        $("ul.menu li").hover(function(){
        
            $(this).addClass("hover");
            $('ul:first',this).css('visibility', 'visible');
            $('ul.menu ul').css('left',$(this).offset().left);
        
        }, function(){
        
            $(this).removeClass("hover");
            $('ul:first',this).css('visibility', 'hidden');
        
        });
        
        $("ul.menu li ul li:has(ul)").find("a:first").append(" &raquo; ");
    });
    </script>
</head>

<body>
<div class="main">
    <header>
        <h1 id="adminHeader">Otizm Club Yönetim Paneli</h1>
        
        <div class="menuContent">
        <ul class="menu">
            <li>
            	<a href="index.php">Haberleri Yönet</a>
				<ul>
        			<li><a href="editnews.php?id=0">Haber Ekle</a></li>
        			<li><a href="index.php">Haber Düzenle</a></li>
        		</ul>            	
            </li>
            <li><a href="comment.php">Yorumları Yönet</a></li>
			<li>
				<a href="photos.php">Galeri Yönet</a>
				<ul>
        			<li><a href="addphotos.php">Fotoğraf Ekle</a></li>
        			<li><a href="photos.php">Fotoğraf Düzenle</a></li>
        		</ul>  
			</li>
			<li>
				<a href="videos.php">Video Yönet</a>
				<ul>
        			<li><a href="editvideos.php?id=0">Video Ekle</a></li>
        			<li><a href="videos.php">Video Düzenle</a></li>
        		</ul>  
			</li>			
			<li>
				<a href="user.php">Kullanıcı Yönet</a>
				<ul>
        			<li><a href="editusers.php?id=0">Kullanıcı Ekle</a></li>
        			<li><a href="user.php">Kullanıcı Düzenle</a></li>
        		</ul>  
			</li>
			<li><a href="logout.php">Çıkış</a></li>
        </ul>
        <div style="clear: both;"></div>
        </div>
    </header>  
    
    <div id="content">
    	<?php echo $adminContent;?>
    </div>
    
    <!--
    <footer>
        <p>© 2012 Otizm Club</p>
    </footer>
    -->	
</div>    
</body>
</html>