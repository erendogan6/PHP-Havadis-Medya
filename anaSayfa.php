<?php session_start();
if (!isset($_SESSION["id"])) {
    header("Location: girisEkran.php");
}
?>
<!DOCTYPE html>
<html lang = "tr">
<head>
    <title>Havadis</title>
    <meta charset="UTF-8">
    <style>
        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        *:focus{
            outline: none;
        }

        body{
            width: 100%;
            height: 100%;
            position: relative;
            font-family: 'roboto', sans-serif;
            margin: 0;
            background: linear-gradient(-45deg, #ee7752, #e73c7e, #23a6d5, #23d5ab);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
        }
        @keyframes gradient {
            0% {
                background-position: 0 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0 50%;
            }
        }

        .navbar{
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100px;
            background: white;
            border-bottom: 1px solid #dfdfdf;
            display: flex;
            justify-content: center;
            padding: 5px 0;
        }


        .nav-wrapper{
            width: 100%;
            height: 100%;
            display: flex;
            justify-content:space-between;
            align-items: center;
        }

        .logo{
            height: 100%;
            width: 20%;
            cursor: pointer;
        }

        .arama{
            margin-right: 3%;
            width: 10%;
            height: 35%;
            background: #fafafa;
            border: 1px solid gray;
            border-radius: 35px;
            color: black;
            text-align: center;
        }


        .nav-items{
            margin-left:10%;
            align-items: center;
            justify-content: center;
            height: 25%;
            position: relative;
            margin-bottom: 1%;
            margin-right: 3%;
        }

        .ikon{
            height: 6vh;
            width: 7vh;
            cursor: pointer;
            margin: 0 15px;
            display: inline-block;
        }

        .profil{
            width:7%;
            cursor: pointer;
            height: 100%;
            border-radius: 50%;
            background-image: url(<?php
                        try {
                            $vt = new PDO("mysql:dbname=havadis;host=localhost;charset=utf8","root", "123456");
                            $vt->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        } catch (PDOException $e) {
                            echo $e->getMessage();
                        }
                        $sql = "select profilResim from uyeler where id = :id";
                        $komut = $vt->prepare($sql);
                        $komut-> execute(Array(":id"=>$_SESSION["id"]));
                        $gelenveri = $komut->fetch(PDO::FETCH_ASSOC);
                        echo $gelenveri["profilResim"];?>);
            background-size:cover;
        }

        .paylasim{
            width: 100%;
            height: auto;
            margin-top: 5%;
            font-family: 'Share Tech', sans-serif;
            border-bottom: black 7px dotted;
        }

        .bilgi{
            width: 100%;
            height: 10vh;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 6px;
        }

        .bilgi{
            width: auto;
            font-weight: bold;
            color: #000;
            font-size: 14px;
            margin-left: 10px;
        }


        .bilgi .kullanici{
            display: flex;
            align-items: center;
        }

        .bilgi .profil-pic{
            height: 7vh;
            width: 7vh;
            padding: 0;
            background: none;
            cursor:pointer;
        }

        .bilgi .profil-pic img{
            border: none;
        }

        .paylasim-resim{
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .paylasim-bilgi{
            width: 100%;
            padding: 2% 1% 1%;
        }

        .aciklama{
            margin: 1vh 0;
            font-size: 16px;
            line-height: 20px;
        }

        .aciklama span{
            font-weight: bold;
            margin-right: 10px;
        }

        .paylasim-saati{
            color: rgba(0, 0, 0, 0.5);
            font-size: 14px;
            font-weight: bold;
        }

        .yorum-wrapper{
            width: 100%;
            height: 7vh;
            display: flex;
            align-items: center;
            background: none;
        }

        .yorum-wrapper .icon{
            height: 30px;
        }

        .yorum-box{
            background: none;
            height: 100%;
            width: 50vh;
            border: none;
            font-size: 15px;
            font-weight: bold;
            margin-left: 5vh;
            color:green;
        }

        .yorum-buton{
            width: 20vh;
            height: 100%;
            background: none;
            border: none;
            font-size: 18px;
            font-weight: bold;
            color: purple;
            cursor: pointer;
        }

        .tepki-wrapper{
            width: 100%;
            height: 3vh;
            display: flex;
            align-items: center;
        }

        .tepki-wrapper .icon{
            height: 5vh;
            width: 5vh;
            margin: 0 20px 0 0;
            cursor: pointer;
        }

        .tepki-wrapper .icon.indir{
            margin-left: auto;
        }

        .main{
            width: 40%;
            display: flex;
            margin-top:5%;
            align-items: center;
            justify-content: center;
            margin-left: auto;
            margin-right: auto;
        }

        .left-col{
            display: flex;
            flex-direction: column;
        }

        .profil-pic{
            width: 70px;
            height: 70px;
            border-radius: 50%;
            overflow: hidden;
            padding: 3px;
            background: linear-gradient(45deg, rgb(255, 230, 0), rgb(255, 0, 128) 80%);
        }

        .profil-pic img{
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid #fff;
        }

        .kullaniciisim{
            width: 100%;
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            padding: 1vh;
            color: rgba(0, 0, 0, 0.5);
            cursor: pointer;
        }
    </style>
</head>
<body>
<nav class="navbar">
    <div class="nav-wrapper">
        <img src="resim/havadis.png" class="logo" alt="">
        <div class="nav-items">
            <a href="anaSayfa.php"><img src="resim/ev.png" class="ikon" alt=""></a>
            <a href="paylasimEkran.php"><img src="resim/yukle.png" class="ikon" alt=""></a>
        </div>
        <div class="profil" onclick="location.href='profilEkran.php'"> </div>
        <a href="cikis.php"><img src="resim/cikis.png" class="ikon" alt=""></a>
    </div>
</nav>
<div class="main">
    <div class="left-col">

        <?php
        include "vtBaglanti.php";
        $sql = "SELECT * FROM `paylasim` order by paylasimKod desc";
        $ifade = $vt->prepare($sql);
        $ifade->execute();
        while ($gelenveri = $ifade->fetch(PDO::FETCH_ASSOC)){
        $sql2 = "SELECT * from uyeler where id = :id";
        $ifade2 = $vt->prepare($sql2);
        $ifade2->execute(Array("id"=>$gelenveri["paylasan"]));
        $gelenProfil=$ifade2->fetch(PDO::FETCH_ASSOC);
        ?>
        <div class="paylasim">
            <div class="bilgi">
                <div class="kullanici">
                    <div class="profil-pic"><img src="<?php echo htmlentities($gelenProfil["profilResim"]) ?>" alt=""></div>
                    <p class="kullaniciisim"><?php echo htmlentities($gelenProfil["kullaniciAd"]) ?></p>
                </div>
            </div>
            <img src="<?php echo htmlentities($gelenveri["dosyaYolu"]) ?>" class="paylasim-resim" alt="">
            <div class="paylasim-bilgi">
                <div class="tepki-wrapper">
                    <p class="paylasim-saati"><?php echo $gelenveri["paylasimTarihi"] ?></p>
                    <a style="margin-left: auto" href ="<?php echo htmlentities($gelenveri["dosyaYolu"])?>" download="img"><img src="resim/indir.png" class="indir icon" alt=""></a>
                </div>
                <?php
                $sql3 = "SELECT yorum.icerik, uyeler.kullaniciAd, yorum.yorumTarih from yorum,uyeler where yorum.paylasimKod = :paylasimKod AND uyeler.id = yorum.yazanKod";
                $ifade3 = $vt->prepare($sql3);
                $ifade3->execute(Array("paylasimKod"=>$gelenveri["paylasimKod"]));
                while ($gelenYorum = $ifade3->fetch(PDO::FETCH_ASSOC)){

                ?>
                <p class="aciklama"><span><?php echo htmlentities($gelenYorum["kullaniciAd"])?></span><?php echo htmlentities($gelenYorum["icerik"])?></p>
                <p class="paylasim-saati"><?php echo htmlentities($gelenYorum["yorumTarih"]) ?></p>
                <?php } ?>
            </div>
            <div class="yorum-wrapper">
                <img src="resim/fikir.png" class="icon" alt="">
                <form action="yorum.php" method="POST">
                    <input type="hidden" name="paylasimKodd" value="<?php echo htmlentities($gelenveri["paylasimKod"])?>">
                    <input type="text" name="metinn" class="yorum-box" placeholder="Fikrini Belirt">
                    <button class="yorum-buton" name="yorum" value="yorum">Gönder</button>
                </form>
            </div>
        </div>
        <?php } ?>
    </div>
</div>
</body>
</html>