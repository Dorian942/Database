<?php
	session_start(); // ici on continue la session
	if ((!isset($_SESSION['Client_ID'])) || ($_SESSION['Client_ID'] == ''))
	{
		echo 'Vous ne pouvez pas acceder a cette page'; 
		exit();
	}
		$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
		$bdd = new PDO('mysql:host=localhost;dbname=test', 'root', '',   $pdo_options);	
		$stmt = $bdd->query('SELECT * FROM devis WHERE Client_ID = \'' . $_SESSION['Client_ID'] . '\' ') ; 
		$getVehicule = $bdd->query('SELECT * FROM vehicule') ; 
		

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
                Pre-Facturation 
            </h1>
          </div>
        </div>
      </div>
    </header>
	
			<div id="maincontent">
				<form method="post" action="" class="inscription">
				  <div class="container">
				  	<label><b>Nom : </b></label><?php echo $_SESSION['Nom']; ?><br> 
					<label><b>Prenom : </b></label><?php echo $_SESSION['Prenom']; ?><br> 
					<label><b>Adresse : </b></label><?php echo $_SESSION['Adresse']; ?><br> 
				<?php 

					while($donne = $stmt->fetch())
					{ ?>
					<label><b>___________________________________________________________________________________________</b></label><br>
					
					<label><b>ID facture : </b></label><?php echo $donne['Devis_ID'];?><br> 		
					<label><b>Vehicule :</b></label><?php echo $donne['Type_Vehicule']; ?><br> 
					<?php 
					$getVehicule = $bdd->query('SELECT img FROM vehicule WHERE Marque = \'' . $donne['Type_Vehicule'] . '\'  ') ;
					$getVehiculeQuery = $getVehicule -> fetch() ; ?>
					<img class="element" src="<?php echo $getVehiculeQuery['img'] ?>"  height="50%" width="50%"><br>
					<label><b>Nombre de jours : </b></label><?php echo $donne['Duree']; ?><br>
					<label><b>Assurance : </b></label><?php echo $donne['Assurance']; ?><br>
					<label><b>Date de location :</b></label><?php echo $donne['Devis_Date']; ?><br>
					<label><b>Montant a payer :</b></label><?php echo $donne['Prix']; ?><br>

					<?php
					}
					?>
					
					<div class="clearfix">
					  <button type="button" class="cancelbtn">Annuler</button>
					  <button type="submit" class="signupbtn">Payer</button>
					</div>
				  </div>
				</form>
			</div>
	
		
		
  </body>
  </html>
  
  