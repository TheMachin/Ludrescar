<?php
session_start();
include('../../bdd/bdd.php');

?>

<!DOCTYPE HTML>
<html>
	<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>LudresCar &mdash; </title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Free HTML5 Website Template by GetTemplates.co" />
	<meta name="keywords" content="free website templates, free html5, free template, free bootstrap, free website template, html5, css3, mobile first, responsive" />
	<meta name="author" content="GetTemplates.co" />

  	<!-- Facebook and Twitter integration -->
	<meta property="og:title" content=""/>
	<meta property="og:image" content=""/>
	<meta property="og:url" content=""/>
	<meta property="og:site_name" content=""/>
	<meta property="og:description" content=""/>
	<meta name="twitter:title" content="" />
	<meta name="twitter:image" content="" />
	<meta name="twitter:url" content="" />
	<meta name="twitter:card" content="" />

	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Kaushan+Script" rel="stylesheet">
	
	<!-- Animate.css -->
	<link rel="stylesheet" href="css/animate.css">
	<!-- Icomoon Icon Fonts-->
	<link rel="stylesheet" href="css/icomoon.css">
	<!-- Themify Icons-->
	<link rel="stylesheet" href="css/themify-icons.css">
	<!-- Bootstrap  -->
	<link rel="stylesheet" href="css/bootstrap.css">

	<!-- Magnific Popup -->
	<link rel="stylesheet" href="css/magnific-popup.css">

	<!-- Bootstrap DateTimePicker -->
	<link rel="stylesheet" href="css/bootstrap-datetimepicker.min.css">

	<!-- Owl Carousel  -->
	<link rel="stylesheet" href="css/owl.carousel.min.css">
	<link rel="stylesheet" href="css/owl.theme.default.min.css">

	<!-- Theme style  -->
	<link rel="stylesheet" href="css/style.css">

	<!-- Modernizr JS -->
	<script src="js/modernizr-2.6.2.min.js"></script>
	<!-- FOR IE9 below -->
	<!--[if lt IE 9]>
	<script src="js/respond.min.js"></script>
	<![endif]-->

	</head>
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


//si ce que l'on rentre existe
	if($email&&$password&&$repeatpassword&&$nom&&$prenom&&$datenaiss&&$adresse&&$numtel){
		
		$requete="select * from utilisateurs where email=$1;";
                $result= pg_prepare($bdd,'checkMail',$requete);
                $result = pg_execute($bdd, "checkMail", array($email));
                $count= pg_num_rows($result);
                

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
						
						die("inscription terminee !<a href='indexco.php'>connectez-vous</a>");
					}else echo"les mots de passes ne sont pas identique";

									}else echo "mot de passe trop court";
			}else echo "l'adresse mail est incorrecte";
		}else echo "adresse mail deja utilise";
	}else echo "Veuillez saisir tous les champs";
}
?>

	<div class="gtco-loader"></div>
	
	<div id="page">

	<!-- <div class="page-inner"> -->
	<nav class="gtco-nav" role="navigation">
		<div class="gtco-container">
			
			<div class="row">
				<div class="col-sm-4 col-xs-12">
					<div id="gtco-logo"><a href="index.php">LudresCar <em>.</em></a></div>
				</div>
				<div class="col-xs-8 text-right menu-1">
					<ul>
						<li><a href="vehicules.html">Véhicules</a></li>
						<li><a href="contact.php">Contact</a></li>
						<li class="btn-cta"><a href="Inscription.php"><span>Inscription</span></a></li>
					</ul>	
				</div>
			</div>
			
		</div>
	</nav>
	
	<header id="gtco-header" class="gtco-cover gtco-cover-md" role="banner" style="background-image: url(images/img_bg_1.jpg)" data-stellar-background-ratio="0.5">
		<div class="overlay"></div>
		<div class="gtco-container">
			<div class="row">
				<div class="col-md-12 col-md-offset-0 text-left">
					

					<div class="row row-mt-15em">
						<div class="col-md-12 mt-text animate-box" data-animate-effect="fadeInUp">
							<span class="intro-text-small">LudresCar</span>
							<h1 class="cursive-font">Quand la voiture rencontre la location.</h1>	
						</div>
					</div>	
				</div>
			</div>
		</div>
	</header>
	

	<div id="gtco-subscribe">
		<div class="gtco-container">
			<div class="row animate-box">
				<div class="col-md-8 col-md-offset-2 text-center gtco-heading">
					<h2 class="cursive-font">Votre Inscription</h2>
					<p>N'hésiter pas à vous inscrire.</p>
				</div>
			</div>
			<div class="row animate-box">
				<div class="col-md-8 col-md-offset-2">
					<form class="form-inline" action="Inscription.php"method="post">
						<div class="col-md-12 col-sm-12">
							<div class="form-group">
		    					 <input type="text" name="email" placeholder="Votre Email" class="form-control" >
							</div>
						</br>
							<div class="form-group">
								<input type="password" class="form-control" name="password"placeholder="Votre mot de passe">
							</div>
						</br>
							<div class="form-group">
								<input type="password" class="form-control"name="repeatpassword"placeholder="répétez ton mot de passe ! ">
							</div>
						</br>
						</br>
							<div class="form-group">
								<input type="text" class="form-control" name="nom"placeholder="votre nom">
							</div>
						</br>
							<div class="form-group">
								<input type="text" class="form-control" name="prenom"placeholder="votre prénom">
							</div>
						</br>
							<div class="form-group">
								<input type="date" class="form-control" name="datenaiss"placeholder="date de naissance"min="1914-03-27" >
								<br/>
								<br/>
							</div>
								</br>
							<div class="form-group">
								<input type="text" class="form-control" name="adresse"placeholder="votre adresse">
								<br/>
							</div>

								<div class="form-group">
								<input type="text" class="form-control" name="numtel"placeholder="votre numeros de telephone">
								<br/>
								<br/>
							</div>
						</div>
						<div class="col-md-6 col-sm-6">
							<input class="btn btn-default btn-block" type="submit" name="submit" value="s'inscrire">
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<footer id="gtco-footer" role="contentinfo" style="background-image: url(images/img_bg_1.jpg)" data-stellar-background-ratio="0.5">
		<div class="overlay"></div>
		<div class="gtco-container">
			<div class="row row-pb-md">

				

				
				<div class="col-md-12 text-center">
					<div class="gtco-widget">
						<h3>Nous contacter</h3>
						<ul class="gtco-quick-contact">
							<li><a href="#"><i class="icon-phone"></i> +1 234 567 890</a></li>
							<li><a href="#"><i class="icon-mail2"></i> info@ludrescar.fr</a></li>
						</ul>
					</div>
					<div class="gtco-widget">
						<h3>Réseaux sociaux</h3>
						<ul class="gtco-social-icons">
							<li><a href="#"><i class="icon-twitter"></i></a></li>
							<li><a href="#"><i class="icon-facebook"></i></a></li>
							<li><a href="#"><i class="icon-linkedin"></i></a></li>
							<li><a href="#"><i class="icon-dribbble"></i></a></li>
						</ul>
					</div>
				</div>
			</div>

			

		</div>
	</footer>
	<!-- </div> -->

	</div>

	<div class="gototop js-top">
		<a href="#" class="js-gotop"><i class="icon-arrow-up"></i></a>
	</div>
	
	<!-- jQuery -->
	<script src="js/jquery.min.js"></script>
	<!-- jQuery Easing -->
	<script src="js/jquery.easing.1.3.js"></script>
	<!-- Bootstrap -->
	<script src="js/bootstrap.min.js"></script>
	<!-- Waypoints -->
	<script src="js/jquery.waypoints.min.js"></script>
	<!-- Carousel -->
	<script src="js/owl.carousel.min.js"></script>
	<!-- countTo -->
	<script src="js/jquery.countTo.js"></script>

	<!-- Stellar Parallax -->
	<script src="js/jquery.stellar.min.js"></script>

	<!-- Magnific Popup -->
	<script src="js/jquery.magnific-popup.min.js"></script>
	<script src="js/magnific-popup-options.js"></script>
	
	<script src="js/moment.min.js"></script>
	<script src="js/bootstrap-datetimepicker.min.js"></script>


	<!-- Main -->
	<script src="js/main.js"></script>

	</body>
</html>

