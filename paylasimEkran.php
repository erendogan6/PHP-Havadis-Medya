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
        html {
            margin: 0;
            height: 100%;
        }
        input {
            border: none;
            font-family: roboto,sans-serif;
        }
        .girisSatiri:focus {
            outline: none;
            border-color: #fff;
        }
        .buton {
            cursor: pointer;
            background: none;
            border: 2px solid rgba(255, 255, 255, 0.65);
            border-radius: 50px;
            align-self: flex-end;
            font-size: 25px;
            font-family: roboto,sans-serif;
            font-weight:bold;
            line-height: 60px;
            margin-top: 30px;
            margin-bottom: 25px;
            color: #fff;
        }
        .buton:hover {
            background: none;
            color: #fff;
        }
        .girisSatiri {
            background: none;
            margin-bottom: 10px;
            line-height: 60px;
            color: #fff;
            font-family: roboto,sans-serif;
            font-weight: 300;
            letter-spacing: 0;
            font-size: 20px;
            border-bottom: 2px solid rgba(255, 255, 255, 0.65);
            transition: all .2s ease;
        }
        .tamGenislik {
            width: 100%;
        }
        .girisAlani {
            margin-top: 25px;
            font-family: roboto,sans-serif;
        }
        .container {
            display: flex;
            align-items: center;
            justify-content: center;
            background:none;
            height: 150vh;
            width: 100%;
        }
        .window {
            color: #fff;
            font-family: roboto,sans-serif;
            position: relative;
            display: flex;
            flex-flow: column;
            box-shadow: 0 15px 50px 10px rgba(0, 0, 0, 0.2);
            box-sizing: border-box;
            height: 150vh;
            width: 360px;
        }

        .icerik {
            padding-left: 25px;
            padding-right: 25px;
            display: flex;
            flex-flow: column;
            z-index: 5;
            height: 150vh;
        }

        .merhaba {
            font-weight: 200;
            margin-top: 15px;
            text-align: center;
            font-size: 30px;
        }

        body{
            width: 100%;
            height: 150vh;
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
        a{
            text-decoration: none;
            color: #fff;
        }
    </style>
</head>
<body>
<div class='container'>
    <div class='window'>
        <div class='icerik'>
            <div class='merhaba'>Hoşgeldiniz <?php echo htmlentities($_SESSION["ad"]) ." ". htmlentities($_SESSION["soyad"])?> </div>
            <div class='girisAlani'>
                <form action="paylasim.php" method="post" enctype="multipart/form-data">
                    <image style="border-radius: 30%; height: 250px;width: 250px;margin-left:10% " id="profileImage" src="resim/blank.png"></image>
                    <br>
                    <label class="girisSatiri tamGenislik">Paylaşım Resmini Seçiniz</label>
                    <input type='file' id="dosya" name="dosya">
                    <input type='text' name="aciklama" placeholder='Açıklama Giriniz' class='girisSatiri tamGenislik'>
                    <input type="submit" name="formGiris" class='buton tamGenislik' value="Paylaşım Yap">
                </form>

                <div><button onclick="location.href='anaSayfa.php'" class='buton tamGenislik'>Geri Dön</button></div>
            </div>
        </div>
    </div>
</div>
</body>
</html>