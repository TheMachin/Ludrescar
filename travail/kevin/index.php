<?php
// demarrage de session
session_start();
include('inc/config.php');
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type"content="text/html;charset=UTF-8";/>
<title>accueil</title>

</head>
<body>
<?php
if(isset($_SESSION['co']))
{
	echo"bienvenue , ";
	echo($_SESSION['username']); 
	echo'<br/>'.' <a href="Deco.php">Deconnexion</a>';
}else
echo'<p> bienvenue, sur le site de limaga</p>'.'<br/>'.'<p> tu peux t\'inscrires <a href="register.php"> ici</a>,ou alors te <a href="login.php">connecter</a>';
?>
</body>
</html>