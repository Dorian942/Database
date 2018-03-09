<?php
	session_start(); // ici on continue la session
	if ((!isset($_SESSION['Client_ID'])) || ($_SESSION['Client_ID'] == ''))
	{
		echo 'Vous ne pouvez pas acceder a cette page'; 
		exit();
	}

            $pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
            $bdd = new PDO('mysql:host=localhost;dbname=test', 'root', '',   $pdo_options);

        
?>

<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>YoLocation</title>

    <!-- Bootstrap core CSS -->
    <link href="../theme/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <link href="../theme/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="../theme/vendor/simple-line-icons/css/simple-line-icons.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">

    <!-- Custom styles for this template -->
    <link href="../theme/css/landing-page.min.css" rel="stylesheet">
    <link href="../css/main.css" rel="stylesheet">

  </head>
<!-- Partie principale -->
   
  <body>
  
		<!-- Navigation -->
    <nav class="navbar navbar-light bg-light static-top">
      <div class="container">
        <a class="navbar-brand" href="index.php">YoLocation</a>

        <ul class="navbar-right">
             <!--  <li><a href="admin.php" class="normal-link">View active orders</a></li> -->
             <!--  <li><a href="admin_products.php" class="normal-link">Products</a></li>  -->
             <!-- <li><a class="btn btn-secondary" href="order.php">Front-office</a></li>  -->
              <li><a href="../index.php" class="normal-link">Accueil</a></li>
                <li><a href="profil.php" class="normal-link">Mon Profil</a></li>
                <li><a class="btn btn-primary" href="deconnexion.php">Deconnexion</a></li>
             <!--  <li><a href="profile.php" class="normal-link">My profile</a></li>	-->
             <!--   <li><a href="old_orders.php" class="normal-link">My old orders</a></li> -->
             <!--   <li><a href="logout.php" class="normal-link">Logout</a></li> -->
             <!--   <li><a class="btn btn-primary" href="order.php">Order now</a></li>   -->
        </ul>
      </div>
    </nav>
	
	 <header class="masthead masthead-sm text-white text-center">
      <div class="overlay"></div>
      <div class="container">
        <div class="row">
          <div class="col-xl-9 mx-auto">
            <h1 class="mb-5">
                Adminstration
            </h1>
          </div>
        </div>
      </div>
    </header>

    <div id="maincontent">
    	Bienvenue <?php echo $_SESSION['Nom']; ?> !<br>			
		
		Ajouter un véhicule :<br>

		<form action="admin.php" method="post" name="ajouterVoiture" id="ajouterVoiture">

				<div class="form-group">
                        <label for="marque">Marque</label>
                        <input type="text" class="form-control" id="marque" name="nom" placeholder="Ford" required>
                </div>

                      <div class="form-group">
                        <label for="kilo">Kilometrage</label>
                        <input type="number" class="form-control" id="kilo" name="kilo" required>
                      </div>
                      <div class="form-group">
                        <label for="Emplacement">Emplacement</label>
                        <input type="number" class="form-control" id="Emplacement" name="Emplacement" required>
                      </div>
                      <div class="form-group">
                        <label for="Adresse">Adresse</label>
                        <input type="text" class="form-control" id="Adresse" name="Adresse" required>
                      </div>

        <button type="submit" class="btn btn-primary">Ajouter</button>
    </form>

    Ajouter un emplacement :<br>

		<form action="admin.php" method="post" name="ajouterEmplacement" id="ajouterEmplacement">

				<div class="form-group">
                        <label for="place_disp">Places disponibles</label>
                        <input type="number" class="form-control" id="place_disp" name="place_disp" placeholder="40" required>
                </div>

                      <div class="form-group">
                        <label for="place_max">Places maximum</label>
                        <input type="number" class="form-control" id="place_max" name="place_max" placeholder="200" required>
                </div>
                      <div class="form-group">
                        <label for="Adresse1">Adresse</label>
                        <input type="text" class="form-control" id="Adresse1" name="Adresse1" required>
                      </div>

        <button type="submit" class="btn btn-primary">Ajouter</button>
    </form>
        <?php
        if (isset($_POST['Marque']) && isset($_POST['Kilometrage'])) {
        try {
            $req = $bdd->prepare('INSERT INTO vehicule (Marque, Kilometrage, Adresse)
                                    VALUES (:Marque, :Kilometrage, :Adresse)');
            $req->bindValue(':Marque', $_POST['Marque']);
            $req->bindValue(':Kilometrage', $_POST['Kilometrage']);
            $req->bindValue(':Adresse', $_POST['Adresse']);


            $req->execute();
        } catch(PDOException $e) {
            echo 'Database Error : '. $e->getMessage();
            exit;
        }
    }

        if (isset($_POST['place_disp']) && isset($_POST['place_max']) && isset($_POST['Adresse1'])) {
        try {
            $req = $bdd->prepare('INSERT INTO emplacement (Places_Dispo, Place_max, Adresse) VALUES (:Places_Dispo, :Place_max, :Adresse1)');
            $req->bindValue(':Place_max', $_POST['place_max']);
            $req->bindValue(':Adresse1', $_POST['Adresse1']);
            $req->bindValue(':Places_Dispo', $_POST['place_disp']);

            $req->execute();
        } catch(PDOException $e) {
            echo 'Database Error : '. $e->getMessage();
            exit;
        }
    }
        ?>

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