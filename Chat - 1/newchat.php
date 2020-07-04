<?php 
	$dsn = 'mysql:host=localhost;dbname=webchat';//veritabanı adını yazıyoruz
	$user = 'root';//veritabanı kullanıcı adını yazıyoruz, localde oluşturduğumuz veritabanı olduğu için kullanıcı adı root olarak seçiliyor
	$password = '';//veritabanı şifresini yazıyoruz, localde oluşturduğumuz veritabanı olduğu için şifre alanı boş bırakılıyor
	 
	try {
		$db = new PDO($dsn, $user, $password);//Kullanıcı adını veritabanımıza kayıt ettik
		$db->exec('SET NAMES `UTF-8`');	//exec veritabanında bir satırın güncelleme, silme gibi işlemleri yapar binevi denetler diyebiliriz.
	} catch (PDOException $e) {
		echo 'Connection failed: ' . $e->getMessage(); //Veritabanına bağlanmada sorun yaşanırsa verilecek mesajı belirleneceği yer burasıdır.
	}
?>