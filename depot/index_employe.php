<?php
session_start();
//include('../../bdd/bdd.php');

?>

<!DOCTYPE HTML>
<html>
	<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>LudresCar &mdash; </title>
	<meta name="viewport" content="width=device-width, initial-scale=1">


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
	$login =htmlentities(trim($_POST['login']));
	$password =htmlentities(trim($_POST['password']));
	
        //echo "test";
        /*pour tester */

        //si ce que l'on rentre existe
	if($login&&$password){
            $succes=TRUE;
            $bddE=NULL;

            $bddE= @pg_connect("host=localhost port=5432 dbname=ludrescar user=".$login." password=".$password);
            $stat = pg_connection_status($bddE);
            if ($stat !== PGSQL_CONNECTION_OK) {
                $succes=FALSE;
            }
            
            if($succes){
                // requete pour tout le monde 
                $requete_tous="select id from compteEmployes where login=$1;";
                $req= pg_prepare($bddE,'',$requete_tous);
                $req= pg_execute($bddE,'',array($login));
                $row = pg_fetch_row($req);
                // est-ce un technicien
                $requete_technicien="select * from Techniciens where id=$1";
                $req_t= pg_prepare($bddE,'',$requete_technicien);
                $req_t= pg_execute($bddE,'',array($row[0]));
                $count= pg_num_rows($req_t);
                
                if($count==1){
                                //creation de session
                    $_SESSION['co']=1;
                    $_SESSION['login']=$login; 
                    $_SESSION['idT']=$row[0]; 
                    $_SESSION['bdd']= serialize($bddE); 
                    header('Location:technicien/indexco.php');
                }
                $requete_responsable="select * from responsables where id=$1";
                $req_t= pg_prepare($bddE,'',$requete_responsable);
                $req_t= pg_execute($bddE,'',array($row[0]));
                $count= pg_num_rows($req_t);
                if($count==1){
                    $_SESSION['co']=1;
                    $_SESSION['login']=$login; 
                    $_SESSION['idR']=$row[0]; 
                    $_SESSION['bdd']= serialize($bddE); 
                    header('Location:responsable/indexco.php');
                }else{
                    echo "Pas technicien et pas responsable";
                }
            }else{
                echo "identifiant ou mot de passe incorect";
            }


	}else echo "Veuillez saisir tout les champs s'il vous plait !";
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
						<li><a href="vehicules.php">Véhicules</a></li>
						<li><a href="contact.php">Contact</a></li>
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
						<div class="col-md-7 mt-text animate-box" data-animate-effect="fadeInUp">
							<span class="intro-text-small">LudresCar</span>
							<h1 class="cursive-font">Quand la voiture rencontre la location.</h1>	
						</div>
						<div class="col-md-4 col-md-push-1 animate-box" data-animate-effect="fadeInRight">
							<div class="form-wrap">
								<div class="tab">
									
									<div class="tab-content">
										<div class="tab-content-inner active" data-content="signup">
											<h3 class="cursive-font">Connectez-vous !!</h3>
											<!--action est le registre ou on est et apres la methode -->
											<form action="index_employe.php"method="post">
												<div class="row form-group">
													<div class="col-md-12">
														<label for="#">Login</label>
														<input type="text" name="login" placeholder="" class="form-control">
													</div>
												</div>
												<div class="row form-group">
													<div class="col-md-12">
														<label for="date-end">Mot de passe</label>
														<input type="password" name="password"placeholder="" class="form-control">
													</div>
												</div>
												<div class="row form-group">
													<div class="col-md-12">
														<input type="submit" name="submit" class="btn btn-primary btn-block" value="se Connecter">
													</div>
												</div>
											</form>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>	
				</div>
			</div>
		</div>
	</header>

	<div id="gtco-counter" class="gtco-section">
		<div class="gtco-container">

			<div class="row">
				<div class="col-md-8 col-md-offset-2 text-center gtco-heading animate-box">
					<h2 class="cursive-font primary-color">Les chiffres</h2>
					<p>Ludrescar en quelques chiffres.</p>
				</div>
			</div>

			<div class="row">
				
				<div class="col-md-3 col-sm-6 animate-box" data-animate-effect="fadeInUp">
					<div class="feature-center">
						<span class="counter js-counter" data-from="0" data-to="50" data-speed="5000" data-refresh-interval="50">1</span>
						<span class="counter-label">milles utilisateurs</span>

					</div>
				</div>
				<div class="col-md-3 col-sm-6 animate-box" data-animate-effect="fadeInUp">
					<div class="feature-center">
						<span class="counter js-counter" data-from="0" data-to="325" data-speed="5000" data-refresh-interval="50">1</span>
						<span class="counter-label">Voitures</span>
					</div>
				</div>
				<div class="col-md-3 col-sm-6 animate-box" data-animate-effect="fadeInUp">
					<div class="feature-center">
						<span class="counter js-counter" data-from="0" data-to="32000" data-speed="5000" data-refresh-interval="50">1</span>
						<span class="counter-label">nombres locations</span>
					</div>
				</div>
				<div class="col-md-3 col-sm-6 animate-box" data-animate-effect="fadeInUp">
					<div class="feature-center">
						<span class="counter js-counter" data-from="0" data-to="2016" data-speed="5000" data-refresh-interval="50">1</span>
						<span class="counter-label">années de départ</span>

					</div>
				</div>
					
			</div>
		</div>
	</div>

	

	<div id="gtco-subscribe">
		<div class="gtco-container">
			<div class="row animate-box">
				<div class="col-md-8 col-md-offset-2 text-center gtco-heading">
					<h2 class="cursive-font">Vos commentaires</h2>
					<p>N'hésitez pas à nous exprimer vos commentaires.</p>
				</div>
			</div>
			<div class="row animate-box">
				<div class="col-md-8 col-md-offset-2">
					<form class="form-inline">
						<div class="col-md-6 col-sm-6">
							<div class="form-group">
								<label for="email" class="sr-only">Email</label>
								<input type="email" class="form-control" id="email" placeholder="Votre Email">
							</div>
						</div>
						<div class="col-md-6 col-sm-6">
							<button type="submit" class="btn btn-default btn-block">Envoyer</button>
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

