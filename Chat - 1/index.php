<?php include "ayar.php"; session_set_cookie_params(0); session_start(); ?>
<html>

<head>
	<title>Chat Programı</title>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.5.2.min.js"></script>
	<link rel="stylesheet" type="text/css" href="style.css">
	<link rel="stylesheet" type="text/css" href="https://www.w3schools.com/w3css/4/w3.css">

	<script type="text/javascript">
		//Javascript ile sohbet mesajını gönderme işlemi ve sohbet güncelleme işlemi yapılır...
		var count = 0; //count adında değişken tanımlanır ve değeri 0 yapılır...
		document.onkeydown = mesajGonder; //Tuşa basıldığında mesajGonder fonksiyonunun çalışmasını sağlar...
		function mesajGonder(
			x) { //Mesaj gönderme işlemi için gereken fonksiyonun başlangıcı, belirtilen tuşa basıldığında burası çalışır...
			var tus; //tus adında değişken belirtilir...
			tus = x.which; //Enter tuşuna basıldığında mesaj gönderilmesi için yazılır...
			if (tus == 13) { //Enter tuşuna basıldığında gerçekleşecek olaylar "if" yapısı ile yazıldı...

				$("textarea[name=mesaj]").attr("disabled", "disabled"); //
				var mesaj = $("textarea[name=mesaj]")
					.val(); //mesaj diye değişken oluşturuldu, içindeki veri ise form elemanı olan textareadan çekildi...
				$.ajax( //ajax kullanılır çünkü ajax yapısı ile sayfa yenilemeden sadece içerideki veriler güncellenir...
					{
						type: "POST", //formun type'ı belirlenir...
						url: "chat.php", //formun çalıştıracağı php kodunun url'si yazılır...
						data: {
							"tip": "gonder",
							"mesaj": mesaj
						},
						success: function (sonuc) { //İşlem başarılı ise fonksiyon çalıştırılır...
							if (sonuc ==
								"bos"
								) { //İf yapısı ile mesaj yazılıcak yer denetlenir eğer mesaj kısmı boş ise aşağıdaki işlemler yapılır... 
								alert(
									"Lütfen boş mesaj göndermeyin."
									); //mesaj kısmı boş olduğu için bu mesajı kullanıcıya gösterdik...
								$("textarea[name=mesaj]").removeAttr(
									"disabled"); //removeAttr ile silme işlemini yapıyoruz...
							} else { // else ile yukarda if'de yazdığımız koşul karşılanmaz ise yapılacak işlem belirlenir...
								$("textarea[name=mesaj]").removeAttr(
									"disabled"
									); //yukarıda mesaj alanı boş ise dedik burda ise dolu ise yapılacağını seçtik
								$("textarea[name=mesaj]").val(
									""); //mesaj yazma alanı yeni mesajlar yazılması için temizlendi...
								sohbetGuncelle(); //Sohbet alanı güncellendi...

							}
						}
					}
				)
			}
		}

		function sohbetGuncelle() {
			$.ajax( //ajax kullanılır çünkü ajax yapısı ile sayfa yenilemeden sadece içerideki veriler güncellenir yani sayfa yenilenmeden sogbet güncellenir...
				{
					type: "POST", //formun type'ı belirlenir...
					url: "chat.php", //formun çalıştıracağı php kodunun url'si yazılır...
					data: {
						"tip": "guncelle"
					},
					success: function (sonuc) { //İşlem başarılı ise fonksiyon çalıştırılır...
						$("#sohbetIcerik").html(sonuc);
						if ($(".sohbetMesaji").length > count) { //
							$("#sohbetIcerik").animate({
								scrollTop: $("#sohbetIcerik").height()
							}, 100);
							count = $(".sohbetMesaji").length;
						}
					},
					error: function () {
						alert("hata");
					}
				}
			);
		}
		setInterval("sohbetGuncelle()", 1500);
		sohbetGuncelle();
	</script>
</head>

<body bgcolor="white">
	<?php if(isset($_SESSION['oturum'])){ ?>
	<div id="sohbetGenel">
		<div id="sohbetIcerik">

		</div>
		<div id="mesajGonder">
			<h3>Mesaj Gönder: <br>("Enter" Tuşu ile mesajlarınızı gönderebilirsiniz...)</h3>
			<textarea name="mesaj" cols="0" rows="0"></textarea><br>
		</div>

		<?php 
				echo "<a href='logout.php?kadi=".$_SESSION['uyeAdi']."'><div class='logout'>
				<p>Çıkış Yap</p></div></a>";
			?>
	</div>
	<?php }else{

				if($_POST){
					$uyeAdi=$_POST["kadi"];
					if(!empty($uyeAdi)){
						echo '<div id="giris">';
						
						$sorgu = $db->query("select * from mesajlar where uyeAdi='".$uyeAdi."' and online='1'")->fetchColumn();
						
						
						if($sorgu>0){
							
							echo'<font color="red">Bu kullanıcı adıyla giriş yapılmış. Lütfen başka bir kullanıcı adı deneyin...</font><meta http-equiv="refresh" content="1;URL=index.php" />';
						   
							
						}else{
							
							$_SESSION["oturum"]=true;
							$date = date("d.m.y H:i:s");
							
							$_SESSION["uyeAdi"]=$uyeAdi;
							$_SESSION["giris_tarihi"]=date("y-m-d H:i:s");
							header("Location:index.php");
						  
							}
						echo'</div>';
					}else{
						echo '<script>alert("Boş Bırakmayın.");</script><meta http-equiv="refresh" content="1;URL=index.php" />';
						
					}
				}else{


				?>

	<form action="" method="post" style="border: 1px solid #F896A9;width: 800px;height: 400px;margin: 30px auto;">
		Kullanıcı Adı:
		<input type="text" name="kadi" class="giris_in">
		<input type="submit" class="button" value="Giriş Yap">
	</form>


	<?php } } ?>
</body>

</html>