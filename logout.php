<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
  
  <title>PHP State Maintenance (Cookies)</title>    
</head>
<body>
  
  <?php
  session_start(); 
  
  ?>
  
  <?php   
  /*if(count($_COOKIE)>0)
	  foreach($_COOKIE as $key => $val){
		  unset($_COOKIE[$key]); // server side cookie removed 
		  
		  setcookie($key, '', time()-3600); // have browser remove from client side 
	  }
	  header("refresh:5; url=login.php"); // redirect within 5 seconds 
	  */ 
  ?>
  
  <div class="container">
    <h1>CS4640 Survey</h1>
    Successfully logged out 
  </div>
  <form action="http://localhost:4200/" method="get">
        <input type="submit" value="Return to Home" class="btn btn-dark" />
      </form>
  </div>
  
<?php 
if(count($_SESSION) > 0)
{
	foreach($_SESSION as $key => $val) 
	{ // pair of keys and values 
		unset($_SESSION[$key]); // will remove pair of key and value from session object 
	}
	session_destroy(); // removes the session instance (session object)
	setcookie('PHPSESSID', '', time()-3600, "/"); // the last argument specify path 
	
}
?>



</body>
</html>
