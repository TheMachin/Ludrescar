<?php
session_start();
include('../../bdd/bdd.php');
include('../classe/CompteUtilisateur.php');
include('../classe/Utilisateur.php');
?>

  <!DOCTYPE HTML>
  <html>

  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>LudresCar &mdash; </title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Facebook and Twitter integration -->
    <meta property="og:title" content="" />
    <meta property="og:image" content="" />
    <meta property="og:url" content="" />
    <meta property="og:site_name" content="" />
    <meta property="og:description" content="" />
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
        }else echo"identifiant ou mot de passe incorrect";
        
        
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
                <div id="gtco-logo"><a href="index.php">LudresCar <em>.</em> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php if(isset($_SESSION['co']))
{
    echo($_SESSION['email']);
}
?></a></div>
              </div>
              <div class="col-xs-8 text-right menu-1">
                <ul>
                  <li><a href="vehicules.php">Véhicules</a></li>
                  <li><a href="location.php">Mes locations</a></li>
                  <li><a href="contact.php">Contact</a></li>
                  <li class="btn-cta"><a href="reservation.php"><span>Reservation</span></a></li>
                  <li><a href="deco.php">Se déconnecter</a></li>
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

                <?php

// On récupére les champs
if(isset($_POST['station']))      $station=$_POST['station'];

if(isset($_POST['dateDeb']))      $dateDeb=$_POST['dateDeb'];

if(isset($_POST['hDeb']))      $hDeb=$_POST['hDeb'];

if(isset($_POST['dateRet']))      $dateRet=$_POST['dateRet'];

if(isset($_POST['marque']))      $marque=$_POST['marque'];

if(isset($_POST['modele']))      $modele=$_POST['modele'];

if(isset($_POST['prixJour']))      $prixJour=$_POST['prixJour'];

if(isset($_POST['hRet']))      $hRet=$_POST['hRet'];

if(!empty($_POST['reserver'])){
    $result = pg_query($bdd, "SELECT v.no_immat, v.marque, v.modele, t.prix_jour, t.prix_km, v.carburant, v.nb_place, s.id
    FROM vehicules v, types t, stations s
    WHERE v.station_id=s.id AND s.nom='$station' AND v.type_id=t.id AND v.etat!='En réparation' AND v.etat!='Hors service' AND v.etat!='Transfert' AND v.marque='$marque'
    AND v.modele='$modele' LIMIT 1");
    if (!$result) {
        echo "Une erreur est survenue.\n";
        exit;
    }
    while ($row = pg_fetch_row($result)){
        ?>
                  <div class="row row-mt-15em">
                    <div class="col-md-7 mt-text animate-box" data-animate-effect="fadeInUp">
                      <span class="intro-text-small">Véhicule : <?php echo $marque;?> <?php echo $modele;?></span>
                      <span class="intro-text-small">Carburant : <?php echo $row[5];?></span>
                      <span class="intro-text-small">Places : <?php echo $row[6];?></span>
                      <span class="intro-text-small">Prix : <?php echo $prixJour;?>€ prix/jour</span>
                    </div>
                    <div class="col-md-4 col-md-push-1 animate-box" data-animate-effect="fadeInRight">
                      <div class="form-wrap">
                        <div class="tab">

                          <div class="tab-content">
                            <div class="tab-content-inner active" data-content="signup">
                              <h3 class="cursive-font">Confirmation de réservation</h3>
                              <form action="confirmerReservation.php" method="post">
                                <div class="row form-group">
                                  <div class="col-md-12">
                                    <label for="date-start">Station :
                                      <?php echo $station?>
                                    </label>
                                  </div>
                                </div>
                                <div class="row form-group">
                                  <div class="col-md-12">
                                    <label for="date-start">Date départ :
                                      <?php echo $dateDeb?>
                                    </label>
                                  </div>
                                </div>
                                <div class="row form-group">
                                  <div class="col-md-12">
                                    <label for="date-start">Heure départ :
                                      <?php echo $hDeb?>
                                    </label>
                                  </div>
                                </div>
                                <div class="row form-group">
                                  <div class="col-md-12">
                                    <label for="date-start">Date retour :
                                      <?php echo $dateRet?>
                                    </label>
                                  </div>
                                </div>
                                <div class="row form-group">
                                  <div class="col-md-12">
                                    <label for="date-start">Heure retour :
                                      <?php echo $hRet?>
                                    </label>
                                  </div>
                                </div>
                                <div class="row form-group">
                                  <div class="col-md-12">
                                    <input type="hidden" name="station" value="<?php echo $row[7]?>">
                                    <input type="hidden" name="dateDeb" value="<?php echo $dateDeb?>">
                                    <input type="hidden" name="hDeb" value="<?php echo $hDeb?>">
                                    <input type="hidden" name="dateRet" value="<?php echo $dateRet?>">
                                    <input type="hidden" name="hRet" value="<?php echo $hRet?>">
                                    <input type="hidden" name="marque" value="<?php echo $marque?>">
                                    <input type="hidden" name="modele" value="<?php echo $modele?>">
                                    <input type="hidden" name="prixJour" value="<?php echo $prixJour?>">
                                    <input type="hidden" name="prixKM" value="<?php echo $row[4]?>">
                                    <input type="hidden" name="immat" value="<?php echo $row[0];?>">
                                    <input type="submit" name="confirm" class="btn btn-primary btn-block" value="Je reserve">
                                  </div>
                                </div>
                              </form>
                            </div>


                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <?php
    }
}
//si on confirme la reservation
if(!empty($_POST['confirm'])){
    $etatLoc="Réservé";
    
    if(!empty($_POST['immat'])) {     $immat=$_POST['immat'];}
    
    
    
    if(!empty($_SESSION['utilisateur'])){
        $utilisateur= unserialize($_SESSION['utilisateur']);
    }
    
    $userID=$utilisateur->getId();
    
    if(isset($_POST['station']))      $station=$_POST['station'];
    
    if(isset($_POST['dateDeb']))      $dateDeb=$_POST['dateDeb'];
    
    if(isset($_POST['hDeb']))      $hDeb=$_POST['hDeb'];
    
    if(isset($_POST['dateRet']))      $dateRet=$_POST['dateRet'];
    
    if(isset($_POST['hRet']))      $hRet=$_POST['hRet'];
    
    if(isset($_POST['marque']))      $marque=$_POST['marque'];
    
    if(isset($_POST['modele']))      $modele=$_POST['modele'];
    
    if(isset($_POST['station']))      $station=$_POST['station'];
    
    $request = "INSERT INTO locations(
    date_deb, date_fin_prev, etatlocation, heure_deb, heure_fin, vehicule_immat, station_depart_id, station_arrivee_id,
    utilisateur_id)
    VALUES ($1, $2, $3, $4, $5, $6, $7, $8, $9);";
    $result = pg_prepare($bdd,'',$request);
    $result = pg_execute($bdd, "",array($dateDeb, $dateRet, $etatLoc, $hDeb, $hRet, $immat, $station, $station, $userID));
    ?>
                    <div class="col-md-7 mt-text animate-box" data-animate-effect="fadeInUp">
                      <span class="intro-text-small">ludresCar</span>
                      <h1 class="cursive-font">Merci pour votre réservation!</h1>
                    </div>
                    <?php
}
?>
              </div>
            </div>
          </div>
        </header>

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