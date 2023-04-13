<?php
session_start();
if (!isset($_SESSION["id"])) {
    header("Location: girisEkran.php");
}

if (!isset($_POST["formGiris"])) {
    header("Location: profilEkran.php");
}
//print_r($_POST);
//print_r($_FILES);
echo "<br>";
include "vtBaglanti.php";

if ($_FILES["dosya"]["error"] <> 0) { // Hata oluştu mu, dosya geldi mi?
    echo "<script>
    alert('Hata Meydana Geldi');
    window.location.href='paylasimEkran.php';
    </script>";
    exit;
}

if ($_FILES["dosya"]["size"] > 16000000) { // Dosya 16 MB'dan büyük mü
    echo "<script>
    alert('Dosya 16MB\'tan küçük olmalıdır!');
    window.location.href='paylasimEkran.php';
    </script>";
    exit;
}

// Resim dosyası mı onu kontrol et
$izinli = ['image/pjpeg', 'image/jpeg', 'image/JPG', 'image/X-PNG', 'image/PNG', 'image/png', 'image/x-png'];
if (!in_array($_FILES['dosya']['type'], $izinli)) {
    echo "<script>
                alert('Hatalı Dosya Türü');
                window.location.href='paylasimEkran.php';
          </script>";
    exit;
}

$degisiklik = 0;
$file_name = $_FILES['dosya']['name'];
$file_size = $_FILES['dosya']['size'];
if (isset($_FILES["dosya"]) && !empty($_FILES) && isset($_FILES) && $file_name!="" && $file_size>1){
    $hedef =  "profil/".time().$_SESSION["id"].$_FILES["dosya"]["name"];
    move_uploaded_file($_FILES["dosya"]["tmp_name"], $hedef);
    try {
    $sql = "UPDATE `uyeler` SET `profilResim` = :hedef WHERE email = :eposta";
    $komut = $vt->prepare($sql);
    $komut->execute(Array(":hedef"=>$hedef, ":eposta"=>$_SESSION["eposta"]));
    echo "<br>";
    echo "Resim Eklendi";
    }
    catch(PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }
}
$eskiSifre = trim($_POST["eskiSifre"]);
$yeniSifre1 = trim($_POST["yeniSifre1"]);
$yeniSifre2 = trim($_POST["yeniSifre2"]);
if (!empty($eskiSifre)){
    if (!empty($yeniSifre1) && !empty($yeniSifre2) ){
        if ($yeniSifre1==$yeniSifre2){
            $sql = "SELECT * from uyeler where email = :email";
            $vtd = $vt->prepare($sql);
            $vtd->execute(Array("email"=>$_SESSION["eposta"]));
            $gelenVeri=$vtd->fetch(PDO::FETCH_ASSOC);

            if (password_verify($eskiSifre, $gelenVeri["sifre"])) {
                $s1 = password_hash($yeniSifre1, PASSWORD_DEFAULT);
                $sql = "UPDATE `uyeler` SET `sifre` = :hedef WHERE email = :eposta";
                $komut = $vt->prepare($sql);
                $komut->execute(array(":hedef" => $s1, ":eposta" => $_SESSION["eposta"]));
                echo "<br>";
                echo "Şifre Değiştirildi";
                $degisiklik++;
            }
            else{
                echo "Eski Şifre Doğru Değil!";
            }
        }
        else{
            echo "<br>";
            echo "Şifreler Aynı Değil !";
        }
    }
    else{
        echo "<br>";
        echo "Yeni Şifreyi Girmediniz";
    }
}
$ad = trim($_POST["ad"]);
if (!empty($ad)){
    $sql = "UPDATE `uyeler` SET `Ad` = :hedef WHERE email = :eposta";
    $komut = $vt->prepare($sql);
    $komut->execute(Array(":hedef"=>$_POST["ad"], ":eposta"=>$_SESSION["eposta"]));
    echo "<br>";
    echo "Ad Değiştirildi";
    $degisiklik++;
}

$soyad = trim($_POST["soyad"]);
if (!empty($_POST["soyad"])){
    $sql = "UPDATE `uyeler` SET `Soyad` = :hedef WHERE email = :eposta";
    $komut = $vt->prepare($sql);
    $komut->execute(Array(":hedef"=>$_POST["soyad"], ":eposta"=>$_SESSION["eposta"]));
    echo "<br>";
    echo "Soyad Değiştirildi";
    $degisiklik++;
}

if ($degisiklik!=0){
$_SESSION = array(); // destroy all $_SESSION data
setcookie("PHPSESSID", "", time() - 3600, "/");
session_destroy();
}
$vt = null;
header("Refresh:2; url=girisEkran.php");
?>