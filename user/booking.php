<?php
	session_start(); // ici on continue la session
	if ((!isset($_SESSION['Client_ID'])) || ($_SESSION['Client_ID'] == ''))
	{
		echo 'Vous ne pouvez pas acceder a cette page'; 
		exit();
	}

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

  <body>
  
		<!-- Navigation -->
    <nav class="navbar navbar-light bg-light static-top">
      <div class="container">
        <a class="navbar-brand" href="index.php">YoLocation</a>

        <ul class="navbar-right">
             <!--  <li><a href="admin.php" class="normal-link">View active orders</a></li> -->
             <!--  <li><a href="admin_products.php" class="normal-link">Products</a></li>  -->
             <!-- <li><a class="btn btn-secondary" href="order.php">Front-office</a></li>  -->
              <li><a href="index.php" class="normal-link">Home</a></li>
                <li><a href="register.php" class="normal-link">Register</a></li>
                <li><a class="btn btn-primary" href="register.php">Sign In</a></li>
             <!--  <li><a href="profile.php" class="normal-link">My profile</a></li>	-->
             <!--   <li><a href="old_orders.php" class="normal-link">My old orders</a></li> -->
             <!--   <li><a href="logout.php" class="normal-link">Logout</a></li> -->
             <!--   <li><a class="btn btn-primary" href="order.php">Order now</a></li>   -->
        </ul>
      </div>
    </nav>
	
	
	
	
			<div id="maincontent">
				<form method="post" action="" class="inscription">
				  <div class="container">
				  
					<label><b>Nom : </b></label><?php echo $_SESSION['Nom']; ?><br> 
					<label><b>Prenom : </b></label><?php echo $_SESSION['Prenom']; ?><br> 
					<label><b>Adresse : </b></label><?php echo $_SESSION['Adresse']; ?><br> 
					<label><b>Piece d'identite : </b></label>  
					<?php 
					
					if  ($_SESSION['Piece_Identite'] == '1'	)
					{
						echo 'Vous n avez pas encore importer de pice d identite' ;
					} else 
						echo 'vous avez importer une piece d identite' ; 
					
					
					?> <br>
						
				  
					<label><b>Vehicule</b></label>
					<input type=		"text" placeholder="Entrer Le Vehicule" name="vehicule" id="vehicule" required><br>
					
					<label><b>Date Debut</b></label>
					<input type="date"  name="date" id="date" required>
					<?php 
					
					$duree = 3;
					$tarif = 110;
					$prix = $duree * $tarif ;
					
					date_default_timezone_set('Europe/Paris');
					$date = date('y/m/d h:i:s ', time());
					
					
					?>
					
					

					<label><b>Date fin</b></label>
					<input type="date"  name="date" id="date"required><br>

					<input type="checkbox" name="asssure"/> Assurance
					<p>En prenant une assurance vous acceptez nous <a href="#">CGU</a>.</p>
					
					<?php 
					
					
					if (isset($_POST['assure'])) $assurance = '1'; else $assurance = '0';
					
					?>

					<div class="clearfix">
					  <button type="button" class="cancelbtn">Annuler</button>
					  <button type="submit" class="signupbtn">Valider</button>
					</div>
				  </div>
				</form>
			</div>
	
		
		
  </body>
  
  
  
  
  
  </html>
  
  <?php
	
        try
        {
            $pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
            $bdd = new PDO('mysql:host=localhost;dbname=test', 'root', '',   $pdo_options);
    
            $req = $bdd->prepare('INSERT INTO devis(Duree, Type_Vehicule, Prix, Assurance, Devis_Date, Client_ID, Facture_ID, Vehicule_ID) VALUES(:Duree, :Type_Vehicule, :Prix, :Assurance, :Devis_Date, :Client_ID, :Facture_ID, :Vehicule_ID)');
            $req->execute(array(
			
            'Duree' => $duree,
            'Type_Vehicule' => $_POST['vehicule'],
            'Prix' => $prix,
			'Assurance' => $assurance ,
            'Devis_Date' => $date ,
            'Client_ID' => $_SESSION['Client_ID'],
            'Facture_ID' => 2,
            'Vehicule_ID' => 3
            
			
            ));
			
		}catch(Exception $e)
        {
            die('Erreur : '.$e->getMessage());
        }
    
?>