<?php
include('../../bdd/bdd.php');
session_start();
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
        }else echo"identifiant ou mot de passe incorect";
        
        
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
                  <li><a href="location.php">Mes locations</a></li>
                  <li><a href="contact.php">Contact</a></li>
                  <li class="btn-cta"><a href="reservation.php"><span>Reservation</span></a></li>
                  <li><a href="deco.php">Se déconnecter</a></li>
                </ul>
              </div>
            </div>
          </div>
        </nav>

        <header id="gtco-header" class="gtco-cover gtco-cover-md" role="banner" style="height:85px; background-image: url(images/img_bg_1.jpg)" data-stellar-background-ratio="0.5">
          <div class="overlay"></div>

        </header>



        <div class="gtco-section">
          <div class="gtco-container">
            <div class="row">
              <div class="col-md-8 col-md-offset-2 text-center gtco-heading">
                <h2 class="cursive-font primary-color">Voitures disponibles</h2>
                <p>Voici les voitures disponibles pour la période du
                  <?php echo $_POST['dateDeb']; ?> au
                    <?php echo $_POST['dateRet']; ?> pour la station
                      <?php echo $_POST['station']; ?>.</p>
              </div>
            </div>
            <div class="row">
              <?php
// On récupére les champs
if(isset($_POST['station']))      $station=$_POST['station'];

if(isset($_POST['dateDeb']))      $dateDeb=$_POST['dateDeb'];

if(isset($_POST['hDeb']))      $hDeb=$_POST['hDeb'];

if(isset($_POST['dateRet']))      $dateRet=$_POST['dateRet'];

if(isset($_POST['hRet']))      $hRet=$_POST['hRet'];

// On vérifie si les champs sont vides
if(empty($station) OR empty($dateDeb) OR empty($hDeb) OR empty($dateRet) OR empty($hRet))
{
    echo '<font color="red">Attention, les champs doivent être remplis !</font>';
}

else
{
    $result = pg_query($bdd, "SELECT v.marque, v.modele, t.prix_jour
    FROM vehicules v, types t, stations s
    WHERE v.station_id=s.id AND s.nom='$station' AND v.type_id=t.id AND v.etat!='En réparation' AND v.etat!='Hors service' AND v.etat!='Transfert' AND v.etat!='Supprimé' AND v.etat!='Fin de service'
    GROUP BY t.prix_jour, v.modele, v.marque");
    if (!$result) {
        echo "Une erreur est survenue.\n";
        exit;
    }
    while ($row = pg_fetch_row($result)){
        ?>
                <div class="col-lg-4 col-md-4 col-sm-6">
                  <form action="confirmerReservation.php" method="post">
                    <input type="hidden" name="station" value="<?php echo $_POST['station']?>">
                    <input type="hidden" name="dateDeb" value="<?php echo $_POST['dateDeb']?>">
                    <input type="hidden" name="hDeb" value="<?php echo $_POST['hDeb']?>">
                    <input type="hidden" name="dateRet" value="<?php echo $_POST['dateRet']?>">
                    <input type="hidden" name="hRet" value="<?php echo $_POST['hRet']?>">
                    <input type="hidden" name="hDeb" value="<?php echo $_POST['hDeb']?>">
                    <input type="hidden" name="marque" value="<?php echo $row[0]?>">
                    <input type="hidden" name="modele" value="<?php echo $row[1]?>">
                    <input type="hidden" name="prixJour" value="<?php echo $row[2]?>">
                    <input type="submit" name="reserver" class="btn btn-primary btn-block" value="Réserver">
                    <a href="images/img_1.jpg" class="fh5co-card-item image-popup">
                      <figure>
                        <div class="overlay"><i class="ti-plus"></i></div>
                        <img src="
                        <?php
        switch ($row[1]) {
            case "Niva":
                echo "images/ladaniva.jpg";
                break;
            case "C2":
                echo "images/c2.jpg";
                break;
            case "P1":
                echo "images/p1.jpg";
                break;
            case "Duster":
                echo "images/duster.jpg";
                break;
            case "Talisman":
                echo "images/img_4.jpg";
                break;
            case "FTypeR":
                echo "images/img_2.jpg";
                break;
            default:
                echo "images/voiture.jpg";
    }
    ?>
                          " alt="Image" class="img-responsive">
                      </figure>
                      <div class="fh5co-text">
                        <h2><?php echo $row[0];?> : <?php echo $row[1]; ?></h2>
                        <p><span class="price cursive-font"><?php echo $row[2]; ?>€ prix/jour</span></p>
                      </div>
                    </a>
                  </form>
                </div>
                <?php
}
}
?>
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