<!DOCTYPE html>
<html lang="fr">         
<head>
		      <meta charset="utf-8"/>
		      <link rel="stylesheet" style="text/css" href="styleTableau.css"/> 
			    <title>Site E-Commerce </title> 
</head>
<body>
<?php
                                     // CONNEXION A LA BASE DE DONNEES OK "RUNCATE TABLE `table` pour vider les id lors des tests !
    try{  
    	  $user = 'root';     
    	  $pass= '';
    	  $connect = new PDO ('mysql:host=localhost;dbname=siteecommerce',$user,$pass);  //new pour initialiser et mes variables de connection $connect!!
    	  $connect->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_WARNING);     //appel de ma DB
    	    echo ' Je suis bien connecté.<br/>';	   
        $nom=$_POST['nom'];                                  //encapsulation des données de l'utilisateur du formulaire en POST
        $prenom=$_POST['prenom'];
        $login=$_POST['login'];
        $password=$_POST['password'];
        $ville=$_POST['ville'];
        
        //var_dump($_POST);
        if ((isset($_POST['login']) && !empty($_POST['login'])) && (isset($_POST['password']) && !empty($_POST['password']))&&(isset($_POST['nom']) && !empty($_POST['nom']))&&(isset($_POST['prenom']) && !empty($_POST['prenom']))&&(isset($_POST['ville']) && !empty($_POST['ville']))) {
          echo'Test de validation formulaire ok le programme continue...'."<br/>";      //premier test pour obliger le "user" à renseigner le formulaire avec isset et !empty!
        if (isset($_POST['login'])) echo 'syntaxe magique htmlentities '.htmlentities(trim($_POST['login'])).' ';    //  pour la sécurité voir $var = addslashes(htmlspecialchars($var)); encore mieux  ou $mot_de_passe = md5($_POST['login']); idéal ?
        if (isset($_POST['password'])) echo htmlentities(trim($_POST['password'])).' ';   //idem alert Xss 
        session_start ();
        // on enregistre les paramètres de notre visiteur comme variables de session ($login et $pwd) 
        $_SESSION['login'] = $_POST['login'];            
        $_SESSION['password'] = $_POST['password'];
        }
        else{   
        echo '<a href="formulaireEcommerce.php">Vous devez renseigner le formulaire, cliquer sur ce lien SVP</a><br/>'; //sinon retour au formulaire !  
          }
        } 
    catch (PDOException $e){                           //mon catch pour les erreurs de connection
	    echo "probléme : ".$e;
       }
                                                          // try de test login 
    try {
        $connect-> setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_WARNING);//appel de ma DB
    	  $connect->beginTransaction();
    	
       $requete= "INSERT INTO utilisateur (login, password, nom, prenom, ville, dateInscription) VALUES ('".$login."','".$password."', '".$nom."', '".$prenom."', '".$ville."', NOW())";                                 //syntaxe tordue('".$x----."') !
       $connect->exec($requete);
       $connect->commit();              //pour excécuter la requète
          echo  'Saisie enregistrée dans la base.<br/>'; 
        //var_dump($resultat);
       $requete2= 'SELECT COUNT(*) AS login FROM utilisateur WHERE login = "'.$login.'"';// vérification du login On compte ds la table utilisateur la ou les lignes où le champ login est égale au login posté avec SELET(*)  AS...
       $resultat =$connect->query($requete2);
       $r=$resultat->fetch(PDO::FETCH_ASSOC); 

         if ($r['login']==1){                                    // ma condition pour le login $r['login'] variable FETCH_ASSOC (Array !)
      	    echo 'Le login est inseré dans la base.<br/>';                         //Etape validation du login du programme
              }
         else {
  	        echo '<a href="formulaireEcommerce.php">Le login est utilisé, Cliquez sur ce lien et saisir un autre login SVP</a><br/> ';

              }
                                                          //test de password > 7 
       $requete3= 'SELECT COUNT(*) AS password FROM utilisateur WHERE password = "'.$password.'"';
       $resultat =$connect->query($requete3);
       $r=$resultat->fetch(PDO::FETCH_ASSOC); 
         if(strlen($_SESSION['password']) >= 7){                    //ma condition pour le password >= à 7 avec ma session['password']
           echo 'Le password est valide.<br/>';                         //Etape validation du password du programme
              } 
         else {
            echo '<a href="formulaireEcommerce.php">Le password est trop court, Cliquez sur ce lien et saisir un password de plus de 6 caratères SVP </a> ';
              }
       } 

    catch (PDOException $e){                              //mon exception avec rollback
	   $connect->rollback();              
	   echo "erreur :".$e->getmessage();  
              }

                                                        //Mon Try pour récupérer les variables mail, nom, ville...
    try {
          $connect->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_WARNING);   //rappel de new ma DB
          $connect->beginTransaction();                          //choix beginTransation();
          $requete4 ="SELECT * FROM utilisateur";                // ma select de requete sur l'ensemble de ma db utilisateur
          $connect->commit();                                  
          $resultat =$connect->query($requete4);

          echo "<table>";   
          echo "<tr><th>Nom</th><th>Prenom</th><th>Ville</th><th>Login</th><th>Password</th></tr>"; //le tableau pour récupérer mes données

          while ($r=$resultat->fetch(PDO::FETCH_ASSOC)){   
         //mon while qui recherche mes variables et affiche mes Mails, prenom, ville avec fletch_ASSOC pour un tableau  associatif ! $r pour créer une nouvelle variable sinon boucle infinie de $resultat !
          echo "<tr><td>". $r['nom']."</td><td>".$r['prenom']."</td><td>".$r['ville']."</td><td>".$r['login']
          ."</td><td>".$r['password']."</td></tr>";   //je demande d'afficher nom, prenom,  ville et date d'inscription ds un tableau  
          }
        echo "</table>"; 
          }
    catch (Exception $e){   
          $connect->rollback();                                 // rollback permet de recuperer si erreur
          echo "erreur :".$e->getmessage();
          }

                                                       //ferneture de la connection
$connect=null;

?>

<br/>
  <div class="connection">
    <form method ="POST" action ="">       <!--mon formulaire connection en cours de construction vers une table connection !-->
     <fieldset class="form2">
        <legend>Connection</legend><br/> 
        <p>
        <label for="login">id</label>
        <input type="text" name="id" class="id" />
        </p>
        <p>
        <label for="password">Utilisateur</label>
        <input type="password" name="utilisateur" class="utilisateur" />
        </p>
        <p>  
        <label for="name">Date d'inscription</label>
        <input type="text" name="dateInscription" class="dateInscription">
        </p> 
        <input type="submit" value="Valider">
        <input type="reset" name="reset" value="Reset">
      </fieldset>
    </form>
  </div>
  <p class="motPasseOublie">You forgot your password or username... <a href="" class="Click"><u>cliquer ici</u></a> 
                                                
</body>
</html>