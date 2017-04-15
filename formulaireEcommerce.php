<!DOCTYPE html>
<html lang="fr">         
<head>
          
		      <meta charset="utf-8"/>
		       <link rel="stylesheet" style="text/css" href="styleTableau.css"/> <!--link css-->
			      <title>Formulaire Utilisateur E-Commerce  HC</title> 
</head>
<body>
  <h1>Formulaire E-Commerce </h1>
  <br/>
    <div class ="formulaire">                         <!-- div formulaire pour déplacer mon formulaire-->
      <form method ="POST" action ="test_3.php">      <!--mon formulaire linker vers ma cible-->

       <fieldset class="form1">                       <!--class pour le fieldset CSS-->
        <legend>Utilisateur</legend><br/> 
          <p>
          <label for="login">Login</label>
          <input type="text" name="login" class="login" />
          </p>
          <p>
          <label for="password">Password</label>
          <input type="password" name="password" class="password" />
          </p>
          <p>  
          <label for="name">Nom </label>
          <input type="text" name="nom" class="nom" />
          </p>
          <p>
          <label for="prenom">Prénom</label>
          <input type="text" name="prenom" class="prenom" />
          </p>
          <p>
          <label for="ville">Ville</label>
          <input type="text" name="ville" class="ville" />
          </p>
          <input type="submit" value="Valider">
          <input type="reset" name="reset" value="Reset">
        </fieldset>
      </form>
    </div>

<footer>     
  &copy; <?=date ("d.m.Y") ?>  - H.COLIN    <!--affiche l'année dans html affiche la date du jour !!!('d/m/Y') &copy copyright !-->
</footer>
</html>