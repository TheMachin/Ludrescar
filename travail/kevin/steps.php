


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="media/cmp.jpg">

    <title>Campus France</title>

    <!-- Bootstrap core CSS -->
    <link href="http://getbootstrap.com/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap theme -->
    <link href="http://getbootstrap.com/dist/css/bootstrap-theme.min.css" rel="stylesheet">
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="http://getbootstrap.com/assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">



    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="http://getbootstrap.com/assets/js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

   <?php 
require "lib/pigs_dropin.php"
?>
        <style type="text/css">
body {
  margin-top:40px;
}
.stepwizard-step p {
  margin-top: 10px;
}
.stepwizard-row {
  display: table-row;
}
.stepwizard {
  display: table;
  width: 50%;
  position: relative;
}
.stepwizard-step button[disabled] {
  opacity: 1 !important;
  filter: alpha(opacity=100) !important;
}
.stepwizard-row:before {
  top: 14px;
  bottom: 0;
  position: absolute;
  /* ici cest la ligne */
  content: " ";
  width: 100%;
  height: 1px;
  background-color: #ccc;
  z-order: 0;
}
.stepwizard-step {
  display: table-cell;
  text-align: center;
  position: relative;
}
.btn-circle {
  width: 30px;
  height: 30px;
  text-align: center;
  padding: 6px 0;
  font-size: 12px;
  line-height: 1.428571429;
  border-radius: 15px;
}
</style>
  </head>

  <body role="document">
    <!-- script pour le tooltip-->
 <script src="app/tooltip/wz_tooltip.js"></script>


    <!-- Fixed navbar -->
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Campus France</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li><a href="http://localhost/projet_csi/"><?php echo _("Accueil"); ?></a></li>
            <li class="active"><a href="steps.php"><?php echo _("Inscription"); ?></a></li>
            <li><a href="connexion.php"><?php echo _("Connexion"); ?></a></li>
            
                <!-- les drapeaux -->
             <li ><a href="http://localhost/projet_csi/steps.php?lang=en_us"><img src="media/en.gif"></a></li>
             <li ><a href="http://localhost/projet_csi/steps.php?lang=ar_AR"><img src="media/arab.png"></a></li>
             <li ><a href="http://localhost/projet_csi/steps.php?lang=ch_CH"><img src="media/chin.gif"></a></li>
             <li ><a href="http://localhost/projet_csi/steps.php"><img src="media/fr.png"></a></li

          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
  </br>
  </br>
  </br>
<div class="container">

      <div class="stepwizard col-md-offset-3">
    <div class="stepwizard-row setup-panel">
          <div class="stepwizard-step">
        <a href="#step-1" type="button" class="btn btn-primary btn-circle">1</a>
        <p><?php echo _("Etape 1"); ?></p>
      </div>
          <div class="stepwizard-step">
        <a href="#step-2" type="button" class="btn btn-default btn-circle" disabled="disabled">2</a>
        <p><?php echo _("Etape 2"); ?></p>
      </div>
          <div class="stepwizard-step">
        <a href="#step-3" type="button" class="btn btn-default btn-circle" disabled="disabled">3</a>
        <p><?php echo _("Etape 3"); ?></p>
      </div>
        </div>
  </div>

      <form role="form" action="register.php" method="post">
    <div class="row setup-content" id="step-1">
          <div class="col-xs-6 col-md-offset-3">
        <div class="col-md-12">
              <div class="form-group">
                <span class="input-group-addon"><?php echo _("Nom"); ?></span>
            <input  maxlength="100" type="text" name="nom" required="required" class="form-control" placeholder="<?php echo _("Entrer votre nom"); ?>"  />
          </div>
              <div class="form-group">
             <span class="input-group-addon"><?php echo _("Prenom"); ?></span>
            <input maxlength="100" type="text" name="prenom" required="required" class="form-control" placeholder="<?php echo _("Entrer votre prénom"); ?>" />
          </div>
              <div class="form-group">
             <span class="input-group-addon"><?php echo _("Adresse"); ?></span>
            <textarea required="required" name="adresse" class="form-control" placeholder="<?php echo _("Entrer votre adresse"); ?>" ></textarea>
          </div>
           <div class="form-group">
             <span class="input-group-addon"><?php echo _("Pays"); ?></span>
            <input maxlength="200" type="text" name="pays" required="required" class="form-control" placeholder="<?php echo _("Entrer votre pays"); ?>" />
          </div>

          <div class="form-group">
             <span class="input-group-addon"><?php echo _("Téléphone"); ?></span>
            <input maxlength="20" type="text" name="tel" required="required" class="form-control" placeholder="<?php echo _("Entrer votre numéros de téléphone"); ?>" />
          </div>
         
              <button class="btn btn-primary nextBtn btn-lg pull-right" type="button" ><?php echo _("Suivant"); ?></button>
            </div>
      </div>
        </div>
    <div class="row setup-content" id="step-2">
          <div class="col-xs-6 col-md-offset-3">
        <div class="col-md-12">
                <div class="form-group">
           <span class="input-group-addon"><?php echo _("Email"); ?></span>
           <input maxlength="200" type="email" name="email" required="required" class="form-control" placeholder="<?php echo _("Entrer votre email"); ?>"/>
          </div>

          <div class="form-group">
             <span class="input-group-addon"><?php echo _("Votre mot de passe"); ?></span>
            <input maxlength="200" data-minlength="6" type="password" name="password" required="required" class="form-control" placeholder="<?php echo _("Entrer votre mot de passe"); ?>" />
          </div>
              <div class="form-group">
           <span class="input-group-addon"><?php echo _("Répéter votre mot de passe"); ?></span>
            <input maxlength="200" data-minlength="6" type="password" name="repeatpassword" required="required" class="form-control" placeholder="<?php echo _("Entrer de nouveau votre mot de passe"); ?>"  />
          </div>
            
             
              <button class="btn btn-primary nextBtn btn-lg pull-right" type="button" ><?php echo _("Suivant"); ?></button>
            </div>
      </div>
        </div>
    <div class="row setup-content" id="step-3">
          <div class="col-xs-6 col-md-offset-3">
        <div class="col-md-12">
        </br>
        
            <div class="form-group">
              <span class="input-group-addon"><?php echo _("Cocher les éléments que vous voulez envoyer"); ?></span>
               </br>
 <input type="checkbox" name="checkbox[]"value="diplome_candidat"> <?php echo _("Votre diplome "); ?></br>
 <input type="checkbox" name="checkbox[]"value="niveau_etude"> <?php echo _("Votre niveau d'étude "); ?></br>
  <input type="checkbox" name="checkbox[]"value="cv"><?php echo _("Votre cv"); ?></br>
  <input type="checkbox" name="checkbox[]"value="Feuille_note"> <?php echo _("Votre feuille de note"); ?></br>
  <input type="checkbox" name="checkbox[]"value="certificat_langue"> <?php echo _("Votre feuille de langue francaise"); ?></br>


    </div><!-- /input-group -->
  </div><!-- /.col-lg-6 -->

              <button class="btn btn-success btn-block pull-right" type="submit"><?php echo _("Inscription"); ?></button>
            </br>

            </div>
      </div>
        </div>
  </form>
    </div>

   </br>
        </br>
          </br>
        </br>
<!-- footer bas de page identique a chaque page -->
<footer>
<div class="col-lg-12">
  <div style="
  bottom: 0px;
  width: 100%;
  height: 60px;
  background-color: #D1D1D1;
  border-top: 1px solid #BBB;"class="panel panel-default">
</br>

<!-- affichage des informations de gauche concernant les droits reserve et la date -->
<div>
<a style="color:black;"href="#">&nbsp;&nbsp;&copy;&nbsp;&nbsp; <?php echo _("Tout droits réservés"); ?>&nbsp;&nbsp;<?php echo date("Y")?></a>
<span style="float:right; margin-right:1%;">

  <!-- logo et lien facebook -->

  <a href="https://fr-fr.facebook.com/CampusFranceParis" target="_blank"><img style="margin-top:-30%;"src="img/f.png" alt="facebook"height="32px"onmouseout="UnTip()" onmouseover="Tip('<i>&nbsp;<?php echo _("lien facebook"); ?></i>')"/></a>

  <!-- logo et affichage du mail du comite -->

  <a id="mail"class="glyphicon glyphicon-envelope" style="color:black;font-size:32px;cursor:pointer;"onmouseout="UnTip()" onmouseover="Tip('<i>&nbsp;www.campusfrance@inscription.fr</i>')"></a>

</span>
</div>
</div>
</footer>


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="http://getbootstrap.com/dist/js/bootstrap.min.js"></script>
    <script src="http://getbootstrap.com/assets/js/docs.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="http://getbootstrap.com/assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
  <script type="text/javascript">
  $(document).ready(function () {
  var navListItems = $('div.setup-panel div a'),
      allWells = $('.setup-content'),
      allNextBtn = $('.nextBtn');

  allWells.hide();

  navListItems.click(function (e) {
    e.preventDefault();
    var $target = $($(this).attr('href')),
        $item = $(this);

    if (!$item.hasClass('disabled')) {
      navListItems.removeClass('btn-primary').addClass('btn-default');
      $item.addClass('btn-primary');
      allWells.hide();
      $target.show();
      /* si il y a un input qui n'a pas de rép alors on a un focus
      pour remove focus on utilise .blur*/
      $target.find('input:eq(0)').focus();
    }
  });

  allNextBtn.click(function(){
    var curStep = $(this).closest(".setup-content"),
      curStepBtn = curStep.attr("id"),
      nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
      curInputs = curStep.find("input[type='text'],input[type='url'],textarea[textarea],input[type='email'],input[type='password']"),
      isValid = true;

    $(".form-group").removeClass("has-error");
    for(var i=0; i<curInputs.length; i++){
      if (!curInputs[i].validity.valid){
        isValid = false;
        $(curInputs[i]).closest(".form-group").addClass("has-error");
      }
    }

    if (isValid)
      /*  La méthode trigger () déclenche l'événement spécifié et le comportement par défaut d'un événement (comme la soumission du formulaire) pour les éléments sélectionnés.
      $( selector ).trigger( event,eventObj,param1,param2,... ) 

      */
      nextStepWizard.removeAttr('disabled').trigger('click');
  });

  $('div.setup-panel div a.btn-primary').trigger('click');
});
  </script>
</html>



