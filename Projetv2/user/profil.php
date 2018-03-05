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
		$requser = $bdd->query('SELECT * FROM client WHERE Client_ID = \'' . $_SESSION['Client_ID'] . '\' ');
		$userinfo = $requser->fetch();


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
                Votre profil 
            </h1>
          </div>
        </div>
      </div>
    </header>
	
			<div id="maincontent">
				
				  <div class="container">
					
						<?php
						if(!empty($userinfo['Avatar']))
						{
						?>
							<center>
							<div class="imgcontainer">
								<img src ="Avatar/<?php echo $userinfo['Avatar']  ?> " alt="Profil Picture" class="avatar">
							</div>
							
						<?php
						}
						else
						{
						?>
					<div class="imgcontainer">
						<p> Ajoutez une Photo de profil <p>
						<img src="data:image/png;base64,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" alt="Profil" class="1avatar">
					</div>
					
					<?php
					} ?>
					
					<form action="" method="post" enctype="multipart/form-data">
					Choisissez une image:
					<input type="file" name="avatar" id="avatar">
					<input type="submit" value="Valider" name="submit">
					</form>
							</center>
			<?php
					if(isset($_FILES['avatar']) AND !empty($_FILES['avatar']['name']))
			{
				$taillemax= 2097152;
				$ExtensionsValides = array('jpg' , 'jepg', 'gif', 'png');
				
				
				if(($_FILES['avatar']['size']) <= $taillemax)
				{
					$extensionUpload = strtolower(substr(strrchr($_FILES['avatar']['name'], '.'),1 ));
					echo $extensionUpload;
					if(in_array($extensionUpload,$ExtensionsValides))
					{
						$chemin = "C:/wamp64/www/Projetv2/user/Avatar/".$_SESSION['Client_ID'].".".$extensionUpload ;
						$resultat = move_uploaded_file($_FILES['avatar']['tmp_name'], $chemin) ;
						if($resultat)
						{
							$updateavatar = $bdd->prepare('UPDATE client SET Avatar = :Avatar WHERE Client_ID = :Client_ID') ; 
							$updateavatar->execute(array(
								'Avatar' => $_SESSION['Client_ID'].".".$extensionUpload,
								'Client_ID' => $_SESSION['Client_ID']
								));
								
						}
						else
						{
							$msg = " erreur" ;
						}
					}
					else
					{
						$msg = "Mauvaise Extension";
					}
				}
				else
				{
					$msg = "La taille de votre photo de profil est trop grande";
				}
			}
				?>
				  
				  	<label><b>Nom : </b></label><?php echo $_SESSION['Nom']; ?><br> 
					<label><b>Prenom : </b></label><?php echo $_SESSION['Prenom']; ?><br> 
					<label><b>Adresse : </b></label><?php echo $_SESSION['Adresse']; ?><br> 
					<label><b>Historique de vos reservations : </b></label><br> 
					<?php 

					while($donne = $stmt->fetch())
					{ ?>
					<label><b>___________________________________________________________________________________________</b></label><br>
					<label><b>Date de location :</b></label><?php echo $donne['Devis_Date']; ?><br>

					<?php
					}
					?>
					
					
				  </div>
			</div>
	
		
		
  </body>
  </html>
  
  