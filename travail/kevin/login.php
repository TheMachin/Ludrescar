<?php
session_start();
include('../../bdd/bdd.php');

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
	$email =htmlentities(trim($_POST['email']));
	$password =htmlentities(trim($_POST['password']));
	
//echo "test";
/*pour tester */

//si ce que l'on rentre existe
	if($email&&$password){
	$password=md5($password);
$requete="select * from utilisateurs u, compteutilisateurs cu where u.email=$1 and cu.mdp=$2 and cu.id=u.compteutilisateur_id;";
					$req= pg_prepare($bdd,'connexion',$requete);
                                        $req= pg_execute($bdd,'connexion',array($email,$password));
					$count= pg_num_rows($req);
					if($count==1){
							//creation de session
						$_SESSION['co']=1;
						$_SESSION['email']=$email;



						header('Location:index.php');
					}else echo"identifiant ou mot de passe incorect";


	}else echo "Veuillez saisir tout les champs s'il vous plait !";
}
?>
<!--action est le registre ou on est et apres la methode -->
<form action="login.php"method="post">
<input type="text" name="email"placeholder="ton email ! "> <br/>
<input type="password" name="password"placeholder="ton mot de passe ! ">
<br/>
<!--avec ce type et value c est la creation dun bouton-->
<input type="submit" name="submit" value="s'inscrire">

</form>

</body>
</html>