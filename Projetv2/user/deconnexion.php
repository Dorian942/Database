<?php 
session_start();

// Suppression des variables de session et de la session
$_SESSION = array();
session_destroy();

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
              <li><a href="../index.php" class="normal-link">Acceuil</a></li>
                <li><a href="../login.php" class="normal-link">S'inscrire</a></li>
                <li><a class="btn btn-primary" href="../login.php">Se Connecter</a></li>
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
                A bientôt sur Yolocation
            </h1>
          </div>
        </div>
      </div>
    </header>
	
	<div id="wrapper">
			<center>
			<br>
			<br>
			<br>
			<br>
			<br>
			<br>
			<div id="maincontent">
				<div class="imgcontainer">
					<img src="http://www.renault-5.net/supercinq/logo_ByeBye.jpg" alt="bye" class="bye">
				</div>
				<h2>A bientôt</h2>
			</div>
			</center>
		
		</div>	
	
	
	</body>
	
	</html>