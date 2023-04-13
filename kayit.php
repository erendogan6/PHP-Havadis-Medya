<?php
session_start();

if (isset($_SESSION["id"])){
    header("Refresh:2;url=profilEkran.php");
}

if (!isset($_POST["formGiris"])){
    echo "<script> alert('Formu Doldurunuz!'); window.location.href='kayitEkran.php'; </script>";
    exit;
}

if (!isset($_POST["ad"])){
    echo "<script> alert('Ad Girilmedi'); window.location.href='kayitEkran.php'; </script>";
    exit;
}
else if (strlen($_POST["ad"])<2){
    echo "<script> alert('Ad En Az 2 Karakter İçermelidir'); window.location.href='kayitEkran.php'; </script>";
    exit;
}

else if (strlen($_POST["ad"])>254){
    echo "<script> alert('Ad En Fazla 254 Karakter İçermelidir'); window.location.href='kayitEkran.php'; </script>";
    exit;
}

if (!isset($_POST["soyad"])){
    echo "<script> alert('Soyad Girilmedi'); window.location.href='kayitEkran.php'; </script>";
    exit;
}
else if (strlen($_POST["soyad"])<2){
    echo "<script> alert('Soyad En Az 2 Karakter İçermelidir'); window.location.href='kayitEkran.php'; </script>";
    exit;
}
else if (strlen($_POST["soyad"])>254){
    echo "<script> alert('Soyad En Fazla 254 Karakter İçermelidir'); window.location.href='kayitEkran.php'; </script>";
    exit;
}

if (!isset($_POST["yas"])){
    echo "<script> alert('Yaş Girilmedi'); window.location.href='kayitEkran.php'; </script>";
    exit;
}

if (!isset($_POST["kullaniciAd"])){
    echo "<script> alert('Kullanıcı Adı Girilmedi'); window.location.href='kayitEkran.php'; </script>";
    exit;
}

else if (strlen($_POST["kullaniciAd"])>254){
    echo "<script> alert('Kullanıcı Adı En Fazla 254 Karakter İçermelidir'); window.location.href='kayitEkran.php'; </script>";
    exit;
}

else if (strlen($_POST["kullaniciAd"])<2){
    echo "<script> alert('Kullanıcı Adı En Az 2 Karakter İçermelidir'); window.location.href='kayitEkran.php'; </script>";
    exit;
}


try {
    $tarih = new DateTime($_POST["yas"]);
} catch (Exception $e) {
}
$sinir = $tarih;
$sinir->add(new DateInterval("P18Y"));

if ($sinir > new DateTime()){
    echo "<script> alert('Platforma Üye Olabilmek İçin En Az 18 Yaşında Olmalısınız'); window.location.href='kayitEkran.php'; </script>";
    exit;
}
if (!isset($_POST["cinsiyet"])){
    echo "<script> alert('Cinsiyet Seçilmedi'); window.location.href='kayitEkran.php'; </script>";
    exit;
}
if (!isset($_POST["eposta"])){
    echo "<script> alert('E-Posta Girilmedi'); window.location.href='kayitEkran.php'; </script>";
    exit;
}
else if (!filter_var($_POST["eposta"],FILTER_VALIDATE_EMAIL)){
    echo "<script> alert('E-Posta Geçerli Değil'); window.location.href='kayitEkran.php'; </script>";
    exit;
}
else if (strlen($_POST["eposta"])>254){
    echo "<script> alert('Eposta En Fazla 254 Karakter İçermelidir'); window.location.href='kayitEkran.php'; </script>";
    exit;
}

if (!isset($_POST["sifre"])){
    echo "<script> alert('Şifre Girilmedi'); window.location.href='kayitEkran.php'; </script>";
    exit;
}

else if (strlen($_POST["sifre"])>254){
    echo "<script> alert('Şifre En Fazla 254 Karakter İçermelidir'); window.location.href='kayitEkran.php'; </script>";
    exit;
}

if (!isset($_POST["sifre2"])){
    echo "<script> alert('2.Şifre Girilmedi'); window.location.href='kayitEkran.php'; </script>";
    exit;
}

if ($_POST["sifre"]==$_POST["sifre2"]){
    $s1 = password_hash($_POST["sifre"],PASSWORD_DEFAULT);
}
else{
    echo "<script> alert('Şifreler Aynı Değil'); window.location.href='kayitEkran.php'; </script>";
    exit;
}
// Veri tabanı bağlantısı
include "vtBaglanti.php";

$ad = trim($_POST["ad"]);
$soyad = trim($_POST["soyad"]);
$yas = trim($_POST["yas"]);
$cinsiyet = trim($_POST["cinsiyet"]);
$eposta = trim($_POST["eposta"]);
$kullaniciAd = trim($_POST["kullaniciAd"]);

//Bu eposta ile mevcut kayıt var mı?
$sql = "SELECT * from uyeler where email = :email";
$ifade = $vt->prepare($sql);
$ifade->execute(Array("email"=>$eposta));
$gelenVeri=$ifade->fetch(PDO::FETCH_ASSOC);

// Eğer mevcut kayıt var ise uyarı ver
if (isset($gelenVeri["email"])){
    echo "<script> alert('Bu E-Posta İle Kayıt Mevcut !'); window.location.href='kayitEkran.php'; </script>";
    exit;
}

//Bu kullanıcı adı ile mevcut kayıt var mı?
$sql = "SELECT * from uyeler where kullaniciAd = :kullaniciAd";
$ifade = $vt->prepare($sql);
$ifade->execute(Array("kullaniciAd"=>$kullaniciAd));
$gelenVeri=$ifade->fetch(PDO::FETCH_ASSOC);

// Eğer mevcut kayıt var ise uyarı ver
if (isset($gelenVeri["kullaniciAd"])){
    echo "<script> alert('Bu E-Posta İle Kayıt Mevcut !'); window.location.href='kayitEkran.php'; </script>";
    exit;
}

echo "ÜYELİK BİLGİLERİ: ".
    "<br/>".
    "AD: " . htmlentities($ad) .
    "<br/>".
    "SOYAD: " . htmlentities($soyad) .
    "<br/>" .
    "Yaş: " . htmlentities($yas).
    "<br/>" .
    "Cinsiyet: " . htmlentities($cinsiyet).
    "<br/>".
    "E-Posta: " . htmlentities($eposta) .
    "<br/>".
    "Kullanıcı Ad: " . htmlentities($kullaniciAd);

// Kayıt İşlemleri

$sql = "insert into uyeler (Ad,Soyad,yas,email,sifre,cinsiyet,kullaniciAd) values (:Ad,:Soyad,:yas,:email,:sifre,:cinsiyet,:kullaniciAd)";
$ifade = $vt->prepare($sql);
$ifade->execute(Array(":Ad"=>$ad, ":Soyad"=>$soyad, ":yas"=>$yas, ":email"=>$eposta, ":sifre"=>$s1, ":cinsiyet"=>$cinsiyet,"kullaniciAd"=>$kullaniciAd));


//bağlantının kapatılması
$vt = null;
echo "<script> alert('Kayıt Başarılı');  </script>";
header('Location:anaSayfa.php');
?>
