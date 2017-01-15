<?php
session_start();
include('inc/config.php');

?>
<!DOCTYPE html>
<html>
<head>

<meta http-equiv="Content-Type"content="text/html;charset=UTF-8";/>

<title>login</title>

</head>
<!--form est la balise pour creer un formulaire-->
<body>

<?php
//si on appuie sur le bouton submit
if (isset($_POST['submit']))
{
	#htmlentities est la pour une securite et trim est la pour eviter les espaces dans le usrename
	$username =htmlentities(trim($_POST['username']));
	$password =htmlentities(trim($_POST['password']));
	
//echo "test";
/*pour tester */

//si ce que l'on rentre existe
	if($username&&$password){
	$password=md5($password);
$requete="select * from users where username='$username'and password='$password';";
					$stmt=$bdd->prepare($requete);
					$stmt->execute();
					$row=$stmt->fetch(PDO::FETCH_OBJ);
					if($row==1){
							//creation de session
						$_SESSION['co']=1;
						$_SESSION['username']=$username;



						header('Location:index.php');
					}else echo"identifiant ou mot de passe incorect";


	}else echo "Veuillez saisir tout les champs";
}
?>
<!--action est le registre ou on est et apres la methode -->
<form action="login.php"method="post">
<input type="text" name="username"placeholder="ton pseudo ! "> <br/>
<input type="password" name="password"placeholder="ton mot de passe ! ">
<br/>
<!--avec ce type et value c est la creation dun bouton-->
<input type="submit" name="submit" value="s'inscrire">

</form>

</body>
</html>