<?php
session_start();
include('inc/config.php');
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type"content="text/html;charset=UTF-8";/>
<title>register</title>

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
	$repeatpassword =htmlentities(trim($_POST['repeatpassword']));
	$email=htmlentities(trim($_POST['email']));
	$nom=htmlentities(trim($_POST['nom']));
	$prenom=htmlentities(trim($_POST['prenom']));
	$datenaiss=htmlentities(trim($_POST['datenaiss']));
	$adresse=htmlentities($_POST['adresse']);
	$numtel=htmlentities(trim($_POST['numtel']));
	$niveau=($_POST['ListeElement']);
	
//echo "test";
/*pour tester */

//si ce que l'on rentre existe
	if($username&&$password&&$repeatpassword&&$email&&$nom&&$datenaiss&&$adresse&&$numtel&&$niveau){
		
		$requete="select * from users where username='$username';";
					$stmt=$bdd->prepare($requete);
					$stmt->execute();
					$row=$stmt->fetch(PDO::FETCH_OBJ);
					//compte le nombre de ligne de retour dans la preparation de la requete
					$count = $stmt->rowCount();
					
			//si il n'y a pas d'identification unique
		if($count==0)
		{

			//verification de la longueur du pseudo
			if(strlen($username)>= 4)
			{
				if(strlen($password) >= 4)
				{
				
					if($password==$repeatpassword)
					{
						
						$password=md5($password);

						$requete="insert into users values('$username','$password','$email','$nom','$prenom','$datenaiss','$adresse','$numtel','$niveau');";
						$stmt=$bdd->prepare($requete);
						$stmt->execute();
						
						
						// verification que l'email n'est pas vide puis un filtre qui valide l'email rentré
						// le filtre regarde si l'adresse email est deja valide donc pas necessaire de else
						if(!empty($email)&&filter_var($email, FILTER_VALIDATE_EMAIL))
						{
							
							$destinataire=$email;
							$sujet="bienvenue sur le site de limaga";
							$message="Bienvenue sur le site limaga $username \n
							email : $email;
							Votre inscription vous permettra de bénéficer de plsusieurs avantages:
							 Des avantages tarifaires sur les abonnements
							 Des avantages tarifaires sur la location de matériel
							 Des avantages tarifaires sur les articles de la boutique
							Le groupe aquatique limaga vous remercie de votre inscription et espère vous revoir très bientôt dans notre centre.";
							$entete="From: limaga_aquatique.fr \n Reply-To:$email";
							//preciser les paramètres rentrés pour l'envoi de l 'email '
							// premier  est l'adresse a qui on envoie l'email
							// le second est le sujet de l'envoi du mail
							// le troisieme et le dernier est tout simplement le corps de l'email que l'on envoie


							mail($destinataire,$sujet, $message,$entete);
							
								die("inscription terminee !<a href='login.php'>connectez-vous</a>");
						}
					}else echo"les mots de passes ne sont pas identique";
				}else echo "mot de passe trop court";
			}else echo "pseudo trop court au moins 4 caractères";
		}else echo "pseudo deja utilise";
	}else echo "Veuillez saisir tout les champs";
}
?>
<!--action est le registre ou on est et apres la methode -->
<form action="register.php"method="post">
<input type="text" name="username"placeholder="ton pseudo ! "> <br/>
<input type="password" name="password"placeholder="ton mot de passe ! ">
<br/>
<input type="password" name="repeatpassword"placeholder="répète ton mot de passe ! ">
<br/>
<!--placement de l'email de l'utilisateur-->
<input type="email"name="email"placeholder="placez votre email !";
<br/>
<!--avec ce type et value c est la creation dun bouton-->
<br/>
<p> champ a preciser en cas de livraison d article ou de probleme de paiement </p>
<input type="text"name="nom"placeholder="votre nom">
<br/>
<input type="text" name="prenom" placeholder="votre prenom">
<br/>
<p>votre date de naissance: </p>

<input type="date"name="datenaiss"placeholder=" aaaa/mm/jj "min="1914-03-27" >
<br/>
<input type="text"name="adresse"placeholder="votre adresse">
<br/>
<input type="text"name="numtel"placeholder="votre numeros de telephone">

<br/>
<p>nous avons besoin que nous renseigné sur votre niveaux de natation en cas de cours de natation</p>
<br/>
<!-- nous allons mettre en place une liste deroulante pour pouvoir choisir entre les differents niveraux de natation-->
<select name="ListeElement"size=1 > 
<optgroup label="niveau de natation">
   <option value="bébé dauphin ">bébé dauphin </option> 
   <option value="dauphin blanc">dauphin blanc</option> 
   <option value="dauphin violet">dauphin violet </option> 
   <option value="dauphin bleu">dauphin bleu  </option> 
   <option value="dauphin vert">dauphin vert </option> 
   <option value="dauphin jaune">dauphin jaune  </option> 
   <option value="dauphin orange">dauphin orange </option> 
   <option value="dauphin rouge"> dauphin rouge</option>
   <option value="dauphin arc-en-ciel ">dauphin arc-en-ciel </option>
   <option value="dauphin de bronze">dauphin de bronze</option>
   <option value="dauphin d argent">dauphin d argent </option>
   <option value="dauphin d or ">dauphin d or </option>
   </optgroup>
</select> 
<br/>
<br/>

<input type="submit" name="submit" value="s'inscrire">


</form>

</body>
</html>