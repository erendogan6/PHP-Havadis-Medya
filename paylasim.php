<?php
session_start();
if (!isset($_SESSION["id"])) {
    header("Location: girisEkran.php");
}
if (!isset($_POST["formGiris"])) {
    header("Location: paylasimEkran.php");
}


if ($_FILES["dosya"]["error"] <> 0) { // Hata oluştu mu, dosya geldi mi?
    echo "<script>
    alert('Hata Meydana Geldi');
    window.location.href='paylasimEkran.php';
    </script>";
    exit;
}

if ($_FILES["dosya"]["size"] > 16000000) { // Dosya 16 MB'dan büyük mü
    echo "<script>
                alert('Dosya Boyutu Çok Büyük');
                window.location.href='paylasimEkran.php';
          </script>";
    exit;
}

// Resim dosyası mı onu kontrol et
$izinli = array('image/pjpeg', 'image/jpeg', 'image/JPG','image/jpg' ,'image/X-PNG', 'image/PNG', 'image/png', 'image/x-png');
if (!in_array($_FILES['dosya']['type'], $izinli)) {
    echo "<script>
                alert('Hatalı Dosya Türü');
                window.location.href='paylasimEkran.php';
          </script>";
    exit;
}
include "vtBaglanti.php";
$file_name = $_FILES['dosya']['name'];
$file_size = $_FILES['dosya']['size'];
if (isset($_FILES["dosya"]) && !empty($_FILES) && $file_name!="" && $file_size>1){
    $hedef =  "paylasim/".time().$_SESSION["id"].$_FILES["dosya"]["name"];
    move_uploaded_file($_FILES["dosya"]["tmp_name"], $hedef);
    try {
        $sql = "INSERT INTO `paylasim` (`paylasan`, `dosyaYolu`) VALUES (:paylasanID,:hedef)";
        $komut = $vt->prepare($sql);
        $komut->execute(Array(":hedef"=>$hedef, ":paylasanID"=>$_SESSION["id"]));
        echo "<br>";
        echo "Resim Eklendi";
    }
    catch(PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }
}

if (isset($_POST["aciklama"])){
    $sql1 = "select paylasimKod from paylasim where paylasan=:yazanKod order by paylasimTarihi desc ";
    $ifade = $vt->prepare($sql1);
    $ifade->execute(Array(":yazanKod"=>$_SESSION["id"]));
    $gelenVeri = $ifade->fetch(PDO::FETCH_ASSOC);
    $paylasimKod = $gelenVeri["paylasimKod"];

    $sql2 = "INSERT INTO yorum(paylasimKod , yazanKod , icerik)VALUES(:paylasimKoddd,:yazanKod,:icerikk)";
    $ifade = $vt->prepare($sql2);

    $ifade->execute(Array(
        ":paylasimKoddd"=>$paylasimKod,
        ":yazanKod"=>$_SESSION["id"],
        ":icerikk"=>$_POST["aciklama"]));
    echo "<br/>";
    echo "Açıklama Eklendi";
}

$vt = null;
header("Refresh:1; url=anaSayfa.php");
?>