<!DOCTYPE html>
<html>
	<head>
		<meta charset = "utf-8" />
		<link rel="stylesheet" href = "Formulaire.css"/>
		<title>Formulaire de Contact</title>
	</head>
	
	<body>
	
		<div id = "bloc_form">
			<header>
					<!--<img src = "EnteteForm.png" alt = "logo du site" id = "logo">-->
					<h1>Formulaire de Contact</h1>
				
				
				<nav>
					<ul>
						<li><a href="#">Acceuil</a></li>
						<li><a href="#">Publier</a></li>
						<li><a href="#">Mon Profil</a></li>
						<li><a href="#">Mes Notes</a></li>
						<li><a href="#">Amis</a></li>
						<li><a href="#">Recherche avancée&nbsp;&nbsp;&nbsp;<input type = "text" name ="Recherche avancée" /></a></li>
					</ul>
				</nav>
			</header>
			
		
		
			<div id = "corps_page">
				<p><b>Une question, des conseils d’utilisation ou toute autre information ?</b></p>
				<p> LookandNote s'engage à vous répondre dans les plus brefs délais !</p>
			</div>
			
			<div id = "champs_Form">
			
										<!--Vérification des champs du formulaire-->
										<?php
										
										$_POST['civil'] = ""; $_POST['email'] = ""; $_POST['nom'] = ""; $_POST['prenom'] = ""; $_POST['sujet'] = ""; $_POST['message'] = ""; $_POST['EnvoyerDonnee'] = "";
										if (($_POST['civil'] <> "") && ($_POST['email'] <> "") &&($_POST['nom'] <> "") &&($_POST['prenom'] <> "") &&($_POST['sujet'] <> "") &&($_POST['message'] <> ""))
											{
											echo "Nous vous remercions, Votre demande a bien &eacute;t&eacute; prise en compte";
											exit;
											}
										
										?>
				
				<form method = "post" action = "Formulaire.php"><fieldset>
					<br>
					<table>
					
										<!--gestion de la civilité-->
										<?php
											if (($_POST['civil'] =="") && ($_POST['EnvoyerDonnee'] <> ""))
											echo "<font color = 'FF0000'> La civilité doit être indiquée !</font><br>";
										?>
					
					<tr>
						<th >Civilité *</th>
						<td><input type="radio" name="civil" value="M" >Monsieur&nbsp;
						<input type="radio" name="civil" value="Mme" >Madame&nbsp;
						<input type="radio" name="civil" value="Mlle" >Mademoiselle</td>
					</tr>
										
										<!--gestion de l'adresse e-mail-->
										<?php
											if (($_POST['email'] =="") && ($_POST['EnvoyerDonnee'] <> ""))
											echo "<font color = 'FF0000'> L\'e-mail doit être indiqué !</font><br>";
										?>
										
					<tr>
						<th>Adresse E-mail *</th>
						<td><input type="text" name="email" size="50pxe" maxlength="20"></td>
					</tr>
					
										<!--gestion du nom-->
										<?php
											if (($_POST['nom'] =="") && ($_POST['EnvoyerDonnee'] <> ""))
											echo "<font color = 'FF0000'> Le nom doit être indiqué !</font><br>";
										?>
					
					<tr>
						<th>Nom *</th>
						<td><input type="text" name="nom" size="50pxe" maxlength="20"></td>
					</tr>
					
										<!--gestion du prénom-->
										<?php
											if (($_POST['prenom'] =="") && ($_POST['EnvoyerDonnee'] <> ""))
											echo "<font color = 'FF0000'> Le pr&eacute;nom doit être indiqué !</font><br>";
										?>
										
					<tr>
						<th>Prénom *</th>
						<td><input type="text" name="prenom" size="50pxe" maxlength="20"></td>
					</tr>
					
										<!--gestion du sujet-->
										<?php
											if (($_POST['sujet'] == "") && ($_POST['EnvoyerDonnee'] <> ""))
											echo "<font color = 'FF0000'> Le sujet doit être indiqué !</font><br>";
										?>
										
					<tr>
						<th>Sujet d'intérrogation *</th>
						<td><input type="text" name="sujet" size="50pxe" maxlength="20"></td>
					</tr>
					
										<!--gestion du message-->
										<?php
											if (($_POST['message'] =="") && ($_POST['EnvoyerDonnee'] <> ""))
											echo "<font color = 'FF0000'> Le message doit être indiqué !</font><br>";
										?>
										
										
					<tr>
						<th>message *</th>
						<td><textarea name="message" rows="10" cols="52"></textarea></td>
					</tr>
					
					</table>
					<br>
					* :champ obligatoire.
					<input type="submit" name = "EnvoyerDonnee" value="    Envoyer    " style = "margin-left: 30%;color: white; background: orange; font-size: 1.3em;"/>
				</fieldset>
				</form>
			</div>
			<hr style = "margin-top: 1%;">
			<footer>
				<a href="A propos">A propos</a>&nbsp&nbsp&nbsp
				<a href="Confidentialité">Confidentialité</a>&nbsp&nbsp&nbsp
				<a href="Mentions légales">Mentions légales</a>&nbsp&nbsp&nbsp
				<a href="Mentions légales">Pages Génie logiciel</a>
			</footer>
		</div>
		
	</body>
</html>