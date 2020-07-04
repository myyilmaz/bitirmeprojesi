<?php
    session_start();
	//session_destroy()
    include "ayar.php"; //Ayar.php dosyasını sayfamıza include ettik yani sayfamıza girildiğinde ayar.php kodumuz çalışacak

    header("Content-type: text/html; charset=ISO-8859-9;");
	setlocale(LC_TIME, 'tr_TR'); //Mesajların sağ tarafında çıkan mesaj atma saatinin hani ülke saatine göre belirleneceğini ayarlıyoruz 
    $tip   	   = strip_tags(trim($_POST["tip"])); 
	$kullanici = $_SESSION["uyeAdi"];
    $tarih     = date('y-m-d H:i:s', strtotime('0 years 0 weeks 0 months +60 minutes'));

    Switch($tip){ //İf yapısı oluşturulur 
        //Mesaj Gönderme
        case "gonder"; //Eğer durum "gonder" ise aşağıdaki kısım çalışacak,
		 $mesaj	   = iconv("UTF-8","ISO-8859-9",strip_tags($_POST["mesaj"])); //iconv yapısı ile çektiğimiz verideki türkçe karakterlerin bozulmasını engelliyoruz
            if(empty($mesaj)){ //if yapısı ile de mesaj alanı boş ise ekrana çıkacak yazıyı belirliyoruz
                echo "bos";
            }else{ //Eğer boş değil ise kullanıcı adı, mesaj, tarih vb. bilgileri veritabanından çekiyoruz
				$db->exec("INSERT INTO mesajlar (uyeAdi,mesaj,tarih,online) VALUES ('$kullanici','$mesaj','$tarih+2','1')");
				}

        break;

        //sohbet Guncelleme
        case "guncelle"; //Eğer durum "guncelle" ise aşağıdaki kısım çalışacak,
			if($veri = $db->query('SELECT * FROM mesajlar where online="1" and tarih >="'.$_SESSION['giris_tarihi'].'"'))
                    {	
                        foreach($veri as $row) {
                          echo "<div class='sohbetMesaji'>
						  <span style='float:left;margin-top: 5px; width:90px;'>
                          <strong >{$row[1]}</strong></span>
                    <span class='message_area'>".chunk_split($row[2],70,'<br />')."</span><span class='date'>{$row[3]}</span>

					</div><br /><br />";
                        }
                    }
                else
                    {
                        echo 'Sorguda bir hata meydana geldi.';
                        $error = $db->errorInfo();
                        echo 'Hata mesajı: ' . $error[2];
                    }
        $db = null; 
        break;
  
    }
?>