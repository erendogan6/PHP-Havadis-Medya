<?php
session_start();
if (!isset($_SESSION["id"])) {
    header("Location: girisEkran.php");
}
if (!isset($_POST["yorum"])){
    echo "<script>
                alert('Geri Dönülüyor');
                window.location.href='anaSayfa.php.php';
          </script>";
    exit;
}

if (!isset($_POST["metinn"])){
    echo "<script>
                alert('Metin Girişi Yapmadınız');
                window.location.href='anaSayfa.php.php';
          </script>";
    exit;
}


include "vtBaglanti.php";

$sql = "INSERT INTO yorum(paylasimKod , yazanKod , icerik)VALUES(:paylasimKoddd,:yazanKod,:icerikk)";
$ifade = $vt->prepare($sql);

$ifade->execute(Array(
    ":paylasimKoddd"=>$_POST["paylasimKodd"],
    ":yazanKod"=>$_SESSION["id"],
    ":icerikk"=>$_POST["metinn"]));

$vt = null;
header('Location:anaSayfa.php');
?>