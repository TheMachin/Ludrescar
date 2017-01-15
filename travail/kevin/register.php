<?php
session_start();
include('../../bdd/bdd.php');
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
	$password =htmlentities(trim($_POST['password']));
	$repeatpassword =htmlentities(trim($_POST['repeatpassword']));
	$email=htmlentities(trim($_POST['email']));
	$nom=htmlentities(trim($_POST['nom']));
	$prenom=htmlentities(trim($_POST['prenom']));
	$datenaiss=htmlentities(trim($_POST['datenaiss']));
	$adresse=htmlentities($_POST['adresse']);
	$numtel=htmlentities(trim($_POST['numtel']));
	
//echo "test";
/*pour tester */

//si ce que l'on rentre existe
	if($email&&$password&&$repeatpassword&&$nom&&$prenom&&$datenaiss&&$adresse&&$numtel){
		
		$requete="select * from utilisateurs where email=$1;";
                $result= pg_prepare($bdd,'checkMail',$requete);
                $result = pg_execute($bdd, "checkMail", array($email));
                $count= pg_num_rows($result);
                
					/*$stmt=$bdd->prepare($requete);
					$stmt->execute();
					$row=$stmt->fetch(PDO::FETCH_OBJ);
					//compte le nombre de ligne de retour dans la preparation de la requete
					$count = $stmt->rowCount();*/
					
			//si il n'y a pas d'identification unique
		if($count==0)
		{

			//verification de la longueur du pseudo
			if(!empty($email)&&filter_var($email, FILTER_VALIDATE_EMAIL))
			{
				if(strlen($password) >= 4)
				{
				
					if($password==$repeatpassword)
					{
						
						$password=md5($password);
                                                $dateins=new DateTime('now');
                                                $dateins=$dateins->format('Y-m-d');
						$requete="insert into compteutilisateurs(mdp) values($1)";
                                                $result= pg_prepare($bdd,'insert compte user',$requete);
                                                $result= pg_execute($bdd,'insert compte user',array($password));
                                                
                                                $reqLastId= pg_query($bdd,'SELECT max(id) from compteutilisateurs');
                                                $lastid= pg_fetch_result($reqLastId,0,0);
                                                
                                                
                                                
                                                $requete="insert into utilisateurs values($1,$2,$3,$4,$5,$6,$7,$8,$9,$10);";
						$requete= pg_prepare($bdd,'insert user',$requete);
						$requete= pg_execute($bdd,'insert user',array($lastid,$nom,$prenom,$datenaiss,$dateins,$numtel,$email,$adresse,0,$lastid));
						
						
						// verification que l'email n'est pas vide puis un filtre qui valide l'email rentré
						// le filtre regarde si l'adresse email est deja valide donc pas necessaire de else
						/*if(!empty($email)&&filter_var($email, FILTER_VALIDATE_EMAIL))
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
						}*/
                                                die("inscription terminee !<a href='login.php'>connectez-vous</a>");
					}else echo"les mots de passes ne sont pas identique";
				}else echo "mot de passe trop court";
			}else echo "l'adresse mail est incorrecte";
		}else echo "adresse mail deja utilise";
	}else echo "Veuillez saisir tous les champs";
}
?>
<!--action est le registre ou on est et apres la methode -->
<form action="register.php"method="post">
<input type="text" name="email"placeholder="ton email ! "> <br/>
<input type="password" name="password"placeholder="ton mot de passe ! ">
<br/>
<input type="password" name="repeatpassword"placeholder="répète ton mot de passe ! ">
<br/>

<!--avec ce type et value c est la creation dun bouton-->
<br/>
<p> Nom et prénom </p>
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
<br/>
<br/>

<input type="submit" name="submit" value="s'inscrire">


</form>

</body>
</html>