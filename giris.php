<?php
session_start();

if (isset($_SESSION["id"])){
    header("Refresh:2;url=profilEkran.php");
}

if (!isset($_POST["formGiris"])){
    echo "<script>
                alert('Formu Doldurunuz');
                window.location.href='girisEkran.php';
          </script>";
    exit;
}


if (!isset($_POST["eposta"])){
    echo "E-Posta Girilmedi";
    exit(0);
}
else if (!filter_var($_POST["eposta"],FILTER_VALIDATE_EMAIL)){
    echo "E-Posta Geçerli Değil";
    exit(0);
}
if (!isset($_POST["sifre"])){
    echo "Şifre Girilmedi";
    exit(0);
}

//Veritabanı Bağlantısı
include "vtBaglanti.php";

$eposta = $_POST["eposta"];
$sifre = $_POST["sifre"];
$sql = "SELECT * from uyeler where email = :email";
$vtd = $vt->prepare($sql);
$vtd->execute(Array("email"=>$_POST["eposta"]));
$gelenVeri=$vtd->fetch(PDO::FETCH_ASSOC);

if (password_verify($_POST["sifre"], $gelenVeri["sifre"])){
    $_SESSION["id"] = $gelenVeri["id"];
    $_SESSION["eposta"] = $gelenVeri["email"];
    $_SESSION["ad"] = $gelenVeri["Ad"];
    $_SESSION["soyad"] = $gelenVeri["Soyad"];
    $_SESSION["kullaniciAd"] = $gelenVeri["kullaniciAd"];
    echo "Giriş Başarılı !";
    //echo $_SESSION["id"] . "<br>" . htmlentities($_SESSION["eposta"]) . "<br>". htmlentities($_SESSION["ad"]) . "<br>" . htmlentities($_SESSION["soyad"]) . "<br>";
    header('Location:anaSayfa.php');
}
else {
    echo "<script>
  alert('Hatalı Giriş');
  window.location.href='girisEkran.php';
  </script>";
}
exit;
?>
