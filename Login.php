<?php

  require_once('src/init.php');
  
    $formErreur = array();
    if(isset($_POST['form_enregistrer'])) {
        // Validate data
        if(!isset($_POST['nom']) || $_POST['nom'] == '' || strlen($_POST['nom']) > 40) {
          $formErreur[] = "Le nom de famille n'est pas valide, il doit faire moins de 40 caractères.";
        }
        if(!isset($_POST['prenom']) || $_POST['prenom'] == '' || strlen($_POST['prenom']) > 40) {
          $formErreur[] = "Le prénom n'est pas valide, il doit faire moins de 40 caractères.";
        }
        if(!isset($_POST['adresse']) || $_POST['adresse'] == '' || strlen($_POST['adresse']) > 60) {
          $formErreur[] = "L'adresse doit faire moins de 60 caractères.";
        }
        if(!isset($_POST['email']) || $_POST['email'] == '') {
            $formErreur[] = "Une adresse Email est nécéssaire.";
        } else {
            if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                $formErreur[] = "Cet Email n'est pas valide.";
            } else {
                $userByEmail = $userManager->getUserByEmail($_POST['email']);
                if($userByEmail) {
                    $formErreur[] = "Cet email existe déjà.";
                }
            }
        }
        if(!isset($_POST['psw']) || $_POST['psw'] == '') {
            $formErreur[] = "Un mot de passe est requis.";
        }

        if(!isset($_POST['pswConfirm']) || $_POST['pswConfirm'] == '') {
            $formErreur[] = "Confirmez votre mot de passe s'il vous plait.";
        }

        if(isset($_POST['psw']) && isset($_POST['pswConfirm']) && $_POST['psw'] != $_POST['pswConfirm']) {
            $formErreur[] = "Les mots de passe doivent correspondre.";
        }
        echo $_POST['email'];
        if(!$formErreur) {
          $user = new User();
          $user->setEmail($_POST['email'])
              ->setNom($_POST['nom'])
              ->setPrenom($_POST['prenom'])
              ->setAdresse($_POST['adresse'])
              ->setPsw($_POST['psw']);
              /**
              ->setActive(false)
              ->setIsAdmin(false);
**/
          $userManager->registerUser($user);

          $registerSuccess = true;
        }
    }

    $loginErreur = null;
    if(isset($_POST['form_login'])) {
      if(!isset($_POST['email']) || !isset($_POST['psw']) || !$_POST['email'] || !$_POST['psw']) {
        $loginErreur = "Il vous faut un Email et un mot de passe.";
      } else {
        $user = $userManager->getUserByEmail($_POST['email']);
        if($user && UserManager::checkPasswordHash($_POST['psw'], $user->getPsw())) {
          Core::login($user);
          header('Location: index.php');
        } else {
          $loginErreur = "Erreur de login.";
        }
      }
    }
?>

<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>YoLocation</title>

    <!-- Bootstrap core CSS -->
    <link href="theme/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <link href="theme/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="theme/vendor/simple-line-icons/css/simple-line-icons.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">

    <!-- Custom styles for this template -->
    <link href="theme/css/landing-page.min.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">

  </head>

    <body>

    <!-- Navigation -->
    <nav class="navbar navbar-light bg-light static-top">
      <div class="container">
        <a class="navbar-brand" href="index.php">YoLocation</a>

        <ul class="navbar-right">
             <!--  <li><a href="admin.php" class="normal-link">View active orders</a></li> -->
             <!--  <li><a href="admin_products.php" class="normal-link">Products</a></li>  -->
             <!-- <li><a class="btn btn-secondary" href="order.php">Front-office</a></li>  -->
              <li><a href="index.php" class="normal-link">Accueil</a></li>
                <li><a href="register.php" class="normal-link">S'inscrire</a></li>
                <li><a class="btn btn-primary" href="register.php">Se connecter</a></li>
             <!--  <li><a href="profile.php" class="normal-link">My profile</a></li>    -->
             <!--   <li><a href="old_orders.php" class="normal-link">My old orders</a></li> -->
              <!--   <li><a href="logout.php" class="normal-link">Logout</a></li> -->
              <!--   <li><a class="btn btn-primary" href="order.php">Order now</a></li>   -->
        </ul>
      </div>
    </nav>
    <!-- Partie principale -->
    <header class="masthead masthead-sm text-white text-center">
      <div class="overlay"></div>
      <div class="container">
        <div class="row">
          <div class="col-xl-9 mx-auto">
            <h1 class="mb-5">
                Connectez-vous ou inscrivez-vous pour confirmer votre réservation!
            </h1>
          </div>
        </div>
      </div>
    </header>

    <!-- Formulaires -->
    <section class="pt-5 features-icons bg-white">
      <div class="container">
        <?php if(isset($registerSuccess) && $registerSuccess) { ?>
          <div class="alert alert-success">
             Votre compte a été créé. Un Email de confirmation vous a été envoyé.
          </div>
        <?php } ?>

        <div class="row">
          <div class="col-lg-6">
            <div class="features-icons-item mx-auto mb-5 mb-lg-0 mb-lg-3">
              <center><h3>S'enregistrer</h3></center><br />
                <form action="login.php" method="post">

            <?php if($formErreur) { ?>
                <div class="alert alert-danger">
                  Certains paramètres sont invalides :
                    <ul>
                        <?php foreach($formErreur as $e) {
                            echo '<li>'.$e.'</li>';
                        } ?>
                    </ul>
                </div>
            <?php } ?>

              <div class="form-group">
                        <label for="nom">Nom</label>
                        <input type="text" class="form-control" id="nom" name="nom" placeholder="John" required value="<?php echo isset($_POST['nom']) ? $_POST['nom'] : '' ?>">
                      </div>

                      <div class="form-group">
                        <label for="prenom">Prenom</label>
                        <input type="text" class="form-control" id="prenom" name="prenom" placeholder="Smith" required value="<?php echo isset($_POST['prenom']) ? $_POST['prenom'] : '' ?>">
                      </div>

                      <div class="form-group">
                        <label for="adresse">Adresse</label>
                        <input type="text" class="form-control" id="adresse" name="adresse" placeholder="50 rue des beaux gosses tavu" required value="<?php echo isset($_POST['adresse']) ? $_POST['adresse'] : '' ?>">
                      </div>

                      <div class="form-group">
                        <label for="email">Adresse Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="john@domaine.fr" required value="<?php echo isset($_POST['email']) ? $_POST['email'] : '' ?>">
                      </div>
                      <div class="form-group">
                        <label for="psw">Mot de passe</label>
                        <input type="password" class="form-control" id="psw" name="psw" placeholder="Votre mot de passe" required>
                      </div>

                      <div class="form-group">
                        <label for="pswConfirm">Confirmez votre mot de passe</label>
                        <input type="password" class="form-control" id="pswConfirm" name="pswConfirm" placeholder="Votre mot de passe" required>
                      </div>

            <input type="hidden" name="form_enregistrer" value="form_enregistrer" />

                      <div class="pt-4 text-center">
              <button type="submit" class="btn btn-primary">S'inscrire</button>
            </div>
                    </form>
            </div>
          </div>
          <div class="col-lg-6 border-blue-left">
            <div class="features-icons-item mx-auto mb-5 mb-lg-0 mb-lg-3">
                <center><h3>S'inscrire'</h3></center><br />

                <?php if($loginErreur) { ?>
                    <div class="alert alert-danger">
                      <?php echo $loginErreur; ?>
                    </div>
                <?php } ?>

                <form action="login.php" method="post">
                            <div class="form-group">
                                <label for="email">Adresse Email</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="john@domaine.fr" required>
                            </div>
                            <div class="form-group">
                                <label for="psw">Mot de passe</label>
                                <input type="password" class="form-control" id="psw" name="psw" required>
                            </div>

                    <input type="hidden" name="form_login" value="form_login" />

                            <div class="pt-4 text-center">
                        <button type="submit" class="btn btn-primary">Se connecter</button>
                    </div>
                        </form>
            </div>
          </div>
        </div>
      </div>
    </section>

    <footer class="footer bg-light">
      <div class="container">
        <div class="row">
          <div class="col-lg-6 h-100 text-center text-lg-left my-auto">
            <ul class="list-inline mb-2">
              <li class="list-inline-item">
                <a href="index.php">Accueil</a>
              </li>
              <li class="list-inline-item">&sdot;</li>
              <li class="list-inline-item">
                <a href="#.php">Profil</a>
              </li>
              <li class="list-inline-item">&sdot;</li>
              <li class="list-inline-item">
               
                  <a href="#.php">Se déconnecter</a>
                
                  <a href="register.php">S'inscrire</a>
                  <li class="list-inline-item">&sdot;</li>
                  <a href="login.php">Se connecter</a>
                
              </li>

              
                <li class="list-inline-item">&sdot;</li>
                <li class="list-inline-item">
                  <a href="#">Administrateur</a>
                </li>
              
            </ul>
            <p class="text-muted small mb-4 mb-lg-0">
              &copy; 2018 &sdot; Yolocation Ltd. Tous droits réservés.
              Merci à <a class="text-muted" href="https://startbootstrap.com/template-overviews/landing-page/">StartBootstrap</a> pour le template.
            </p>
          </div>
          <div class="col-lg-6 h-100 text-center text-lg-right my-auto">
            <ul class="list-inline mb-0">
              <li class="list-inline-item mr-3">
                <a href="#">
                  <i class="fa fa-facebook fa-2x fa-fw"></i>
                </a>
              </li>
              <li class="list-inline-item mr-3">
                <a href="#">
                  <i class="fa fa-twitter fa-2x fa-fw"></i>
                </a>
              </li>
              <li class="list-inline-item">
                <a href="#">
                  <i class="fa fa-instagram fa-2x fa-fw"></i>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </footer>

    <!-- Bootstrap core JavaScript -->
    <script src="theme/vendor/jquery/jquery.min.js"></script>
    <script src="theme/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <?php
      if(isset($javascriptFiles)) {
        foreach($javascriptFiles as $js) {
          echo '<script src="'.$js.'"></script>';
        }
      }
    ?>

  </body>


    </body>

</html>