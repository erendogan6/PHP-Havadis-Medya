<?php session_start();
if (isset($_SESSION["id"])) {
    header("Location: anaSayfa.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang = "tr">
<head>
    <title>Havadis</title>
<meta charset="UTF-8">
    <script src="https://www.google.com/recaptcha/api.js"></script>
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
  height: 100%;
  width: 100%;
}

.icerik {
  padding-left: 25px;
  padding-right: 25px;
  display: flex;
  flex-flow: column;
  z-index: 5;
}

.merhaba {
  font-weight: 200;
  margin-top: 30px;
  text-align: center;
  font-size: 40px;
}


.window {
  color: #fff;
  font-family: roboto,sans-serif;
  position: relative;
  display: flex;
  flex-flow: column;
  box-shadow: 0 15px 50px 10px rgba(0, 0, 0, 0.2);
  box-sizing: border-box;
  height: 90vh;
  width: 360px;
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
			  <div class='merhaba'>Bilgilerinizi Giriniz</div>
			  <div class='girisAlani'>
				  <form action="giris.php" method="post">
				<input type='email' name="eposta" placeholder='E-Posta' class='girisSatiri tamGenislik'>
				<input type='password' name="sifre" placeholder='Şifre' class='girisSatiri tamGenislik'>
				  <input class='buton tamGenislik' type="Submit" name="formGiris" value="Giriş Yap">
				  </form>
			  </div>

        <div><button onclick="location.href='index.html'" class='buton tamGenislik'>Geri Dön</button></div>
		</div>
	  </div>
	</div>
	</body>
</html>
