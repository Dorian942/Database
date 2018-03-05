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
                Faites votre reservation
            </h1>
          </div>
        </div>
      </div>
    </header>
	
	
			<div id="maincontent">
			
			
				<form method="post" action="" class="inscription" enctype="multipart/form-data">
				  <div class="container">
				  
					<label><b>Nom : </b></label><?php echo $_SESSION['Nom']; ?><br> 
					<label><b>Prenom : </b></label><?php echo $_SESSION['Prenom']; ?><br> 
					<label><b>Adresse : </b></label><?php echo $_SESSION['Adresse']; ?><br> 
					<label><b>Piece d'identite : </b></label>  
					<?php 
					
					if  ($_SESSION['Piece_Identite'] == NULL	)
					{
						 
					} else 
						
					?>
					<br>
					
					Importer une Piece D identite:
					<input type="file" name="avatar" id="avatar">
			
					
				<br>
						
						
						
				  
					<label><b>Vehicule</b></label>
	<select class="form-control" name="select" id="sel1">
	<option style="display:none;" value="default" selected disabled>Selectionnez un Vehicule</option>
	
	
	<?php
	$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
	$pdoConnect = new PDO('mysql:host=localhost;dbname=test', 'root', '',   $pdo_options);
	$pdoQuery = "SELECT * FROM vehicule" ; 
	$pdoResult = $pdoConnect->query($pdoQuery);
	$pdoRowCount = $pdoResult->rowCount();
	$stmt = $pdoConnect->prepare('SELECT * FROM vehicule') ; 
	$stmt->execute();
	$vehicule = $stmt->fetchAll(); 
	
	foreach($vehicule as $row)
	{
		
		?>
		<option>
		<?php 
		echo $row['Marque'];
		?>
		</option>
		<?php
	}
	
	?>
	</select><br>
					
					
					<label><b>Date Debut</b></label>
					<input type="date"  name="date_debut" id="date" value="<?php echo date('Y-m-d'); ?>"required>
					

					<label><b>Date fin</b></label>
					<input type="date"  name="date_fin" id="date" value="<?php echo date('Y-m-d'); ?>"required><br>
					
					

					<input type="checkbox" name="assure" value="value1" /> Assurance
					<p>En prenant une assurance vous acceptez nous <a href="#">CGU</a>.</p>
					
					<div class="clearfix">
					  <button type="button"  class="cancelbtn">Annuler</button>
					  <button type="submit" class="signupbtn">Valider</button>
					</div>
				  </div>
				</form>
			</div>
	
		
		
  </body>
  
  
  
  
  
  </html>
  
  <?php
  
  
  $sel1 = isset($_POST['select']) ? $_POST['select'] : NULL;
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
						$chemin = "C:/wamp64/www/Projetv2/user/PieceIdentite/".$_SESSION['Client_ID'].".".$extensionUpload ;
						$resultat = move_uploaded_file($_FILES['avatar']['tmp_name'], $chemin) ;
						if($resultat)
						{
							$updateavatar = $bdd->prepare('UPDATE client SET Piece_Identite = :Piece_Identite WHERE Client_ID = :Client_ID') ; 
							$updateavatar->execute(array(
								'Piece_Identite' => $_SESSION['Client_ID'].".".$extensionUpload,
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
				
  if($sel1 != NULL)
  {
  if(isset($_POST['date_debut']) AND isset($_POST['date_fin']))
    {
			$stmt = $bdd->query('SELECT Tarif FROM vehicule WHERE Marque = \'' . $sel1 . '\' ') ; 
			$donne = $stmt->fetch();
			$tarif = $donne['Tarif'];
					
					if (isset($_POST['assure'])) $assurance = '1'; else $assurance = '0';
		
					echo $assurance ; 
					
					
					$date_debut = date('Y-m-d', strtotime($_POST['date_debut']));
					$date_fin = date('Y-m-d', strtotime($_POST['date_fin']));
					
					$date_debut1 = strtotime($date_debut) ; 
					$date_fin1 = strtotime($date_fin) ;
					
					$duree = $date_fin1 - $date_debut1;
					$jour = $duree / 86400;
					if($assurance == 1)
					{
						$ifassurance = 120 ;
						
					}else $ifassurance = 0 ;
					
					$prix = $jour * $tarif + $ifassurance;
					
					date_default_timezone_set('Europe/Paris');
					$date = date('y/m/d h:i:s ', time());
					
					
				
					
	
        try
        {
    
            $req = $bdd->prepare('INSERT INTO devis(Duree, Type_Vehicule, Prix, Assurance, Devis_Date, Client_ID, Facture_ID, Vehicule_ID) VALUES(:Duree, :Type_Vehicule, :Prix, :Assurance, :Devis_Date, :Client_ID, :Facture_ID, :Vehicule_ID)');
            $req->execute(array(
			
            'Duree' => $jour,
            'Type_Vehicule' => $sel1,
            'Prix' => $prix,
			'Assurance' => $assurance ,
            'Devis_Date' => $date ,
            'Client_ID' => $_SESSION['Client_ID'],
            'Facture_ID' => null,
            'Vehicule_ID' => null
            
			
            ));
			
		}catch(Exception $e)
        {
            die('Erreur : '.$e->getMessage());
        
		
		}
		
		header('Location: facture.php ');
    }
  }
  
?>