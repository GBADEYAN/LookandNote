<?php
  session_start();
function session_go($v1,$v2){
  if(!empty($v1) && !empty($v2)){

  $_SESSION["nom"] = stripslashes(htmlentities($v1,ENT_QUOTES,'UTF-8'));echo "var session nom :".$_SESSION["nom"];
  $_SESSION["email"] = stripslashes(htmlentities($v2,ENT_QUOTES,'UTF-8'));
  
  return array($_SESSION["nom"],$_SESSION["email"]);
}
}

?>
