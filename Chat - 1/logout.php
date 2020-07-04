<html>
<head>
    <title>Chat Programı</title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.5.2.min.js"></script>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<?php 
		session_start();
		
		include "ayar.php";

		
		$uyeAdi=$_GET["kadi"];
		
		$update = $db->query("UPDATE mesajlar set online = 0 where uyeAdi='".$uyeAdi."'");
		echo "<div class='main'><span>Çıkış Yapılıyor...</span></div>";
		session_destroy();
		echo '<meta http-equiv="refresh" content="1;URL=index.php" />';

	 ?>
 </body>