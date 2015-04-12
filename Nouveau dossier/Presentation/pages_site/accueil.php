<!DOCTYPE html>
<html>
	<head>
		<meta charset = "utf-8" />
		<link rel="stylesheet" href="../CSS/enregistrement.css" />
		<title>Evaluez vous de près</title>
	</head>
	
	<body>
	<div id="conteneur">    
    <h1 id="header"><a href="#" title="bienvenue dans votre miroir"><marquee>BIENVENUE DANS VOTRE MIROIR</marquee></a></h1>
	<nav>
	<form  action = "controleur.php" method = "post">
      <ul id="champinsc">
        <li> Adresse électronique <input type = "email" name ="email"/>&nbsp&nbsp&nbsp</li>
        <li> Mot de passe <input type = "password" name = "mdp" />&nbsp&nbsp&nbsp</li>
        <li><input type = "submit" value = "connexion" name="submit2" /></li>
      </ul>
	 </form>
	  <ul id="gererconex">
		<li><input type = "checkbox" name = "case" id = "se souvenir de moi"/>se souvenir de moi</li>
		<li><a href = "#inscription" style = "color: black; margin-left: 140px;">mot de passe oublié ?</a></li>
	  	<li><br>
		<?php  if(isset($_POST["submit2"]) && isset($msg2)){echo $msg2."  ";} ?>
		<?php  if(isset($_POST["submit2"]) && isset($msg3)){echo $msg3;} ?> </li>
	  </ul>
	  
    </nav>
	<div id="contenu">
		<div id = imgart>
			<img src ="../Image/MonSourire.png"  alt = "slide 1"/>
			<img src ="../Image/MaRobe.png"  alt = "slide 2"/>
			<img src ="../Image/MesCheveux.png" alt="Slide 3" /> 
			<img src ="../Image/MesYeux.png" alt="Slide 4" /> 
			<img src ="../Image/MesLunettes.png" alt="Slide 5" /> 
		</div>
		<!--<button id="slideShowButton"></button> <!-- Optional button element. -->
		<script src="test4.js"></script>
		
		<div id = insc>
				<form  action = "controleur.php" method = "post">
					<h2>Inscription gratuite</h2>
					<hr color = red style ="width: 300px; margin-left: 75%;"> <br>
					Identifiant*
					<input type = "text" name ="nomi" style = "margin-left: 50px;"/ value="<?php if(isset($_POST["nomi"])) echo $_POST["nomi"]; ?>"><br><br>
					<?php  if(isset($_POST["submit1"]) && isset($msg1)){echo $msg1;} ?><br><br>
					Adresse email*
					<input type = "text" name ="emaili" style = "margin-left: 28px;"/ value="<?php if(isset($_POST["emaili"])) echo $_POST["emaili"]; ?>"><br><br>
					<?php  if(isset($_POST["submit1"]) && isset($msg2)){echo $msg2;} ?><br><br>
					Mot de passe*
					<input type = "password" name ="mdp" style = "margin-left: 32px;"/><br><br>
					<?php  if(isset($_POST["submit1"]) && isset($msg3)){echo $msg3;} ?><br><br>
					<input type = "submit" name="submit1" value = "            s'inscrire              " style = "text-decoration:red;"/>
				</form>
		</div>
		
		<!--<p id =sour><b></b></p>-->
		<div id = "sections">
					<img src ="../Image/sourire.png"/>
					<img src ="../Image/cheveux.png"/>
					<img src ="../Image/robe.png"/>
					<img src ="../Image/yeux.png"/>
					<img src ="../Image/lunettes.png"/>
		</div>
		<div id = slogan>
			<p><h2>Slogan</h2><p/>
			xxxxxxxxxxxxxxxxxxxxxxxxx<br>xxxxxxxxxxxxxxxxxxxxxxxxx<br>xxxxxxxxxxxxxxxxxxxxxxxxx<br><br><br><br>
		</div>
		<hr color = "red">
		
		<footer>
		<a href="#">A propos</a>&nbsp&nbsp&nbsp
		<a href="Formulaire.php">Nous Contacter</a>&nbsp&nbsp&nbsp
		<a href="#">Confidentialité</a>&nbsp&nbsp&nbsp
		<a href="#">Mentions légales</a>&nbsp&nbsp&nbsp
		<a href="../Genie_logiciel/acceuil.htm">Pages Génie logiciel</a>
		
		
		</footer>
	</div>
	
	
	</body>
	
</html>