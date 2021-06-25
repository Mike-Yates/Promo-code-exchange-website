<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
  
  <title>Promo Code Feedback</title>    
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="http://localhost:4200/">PCE</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="http://localhost:4200/">Home<span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="http://localhost:4200/profile">My Profile</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="http://localhost:4200/apprequest">New App Requests</a>
      </li>
	  <li class="nav-item">
        <a class="nav-link" href="http://localhost/my-project/login3.php">Feedback</a>
      </li>
    </ul>
  </div>
</nav>

<?php
require('connectdb.php');

// require: if a required file is not found, require() produces a fatal error, the rest of the script won't run
// include: if a required file is not found, include() throws a warning, the rest of the script will run
?>

<?php
// authenticate before or after starting session is fine 
session_start(); 
//check if theres a session yet for this user (look in the memory space)
// creates a unique id and sends to user, who writes in a cookie file 
if (isset($_SESSION['user'])){ // if the user is already loged in, they should skip this login page 
	// redirect 
	header('Location: feedback.php');  
} 
?>
  
  <div class="container">
    <h1>Promo Code Exchange Login</h1>
    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
      Username: <input type="text" name="username" class="form-control" autofocus required placeholder="Must be at least 5 characters" /> <br/>
      Password: <input type="password" name="pwd" class="form-control" required placeholder="Must be at least 5 characters" /> <br/>
      <input type="submit" value="Sign in" class="btn btn-light" />   
    </form>
	</br> 
	<form action="http://localhost/my-project/newaccount.php" method="get">
        <input type="submit" value="Create New Account" class="btn btn-dark" />
      </form>	
  </div>

<?php 
// $results; 
if($_SERVER['REQUEST_METHOD'] == 'POST' && strlen($_POST['username']) > 4 && strlen($_POST['pwd']) > 4)
{
	//do authentication
	global $db;
	$username_form = $_POST['username'];
	$query = "SELECT user_password FROM user_info WHERE user_name=:username_placeholder"; 
	
	
	$statement = $db->prepare($query);
	$statement->bindValue(':username_placeholder', $username_form); // treats it as plain string, doesn't compile the code 

	
	$statement->execute(); 
	
	$results = $statement->fetch(); // get array of all rows
	// fetch() returns an array of one row 
	$statement->closeCursor(); // release the hold on the instance 
	
	
	if(password_verify($_POST['pwd'], $results[0])) {
		// If the password inputs matched the hashed password in the database
		createTable(); 
		insertData(); 
		$_SESSION['user'] = $_POST['username']; 
		$_SESSION['pwd'] = password_hash($_POST['pwd'], PASSWORD_DEFAULT); 
		// dropTable(); 
		header('Location: feedback.php');
	} else {
		// display error message 
	}
	
}

?> 

<?php 
/*************************/
/** create table **/
function createTable()
{
	global $db;  // connect db creates a connection pdo, we already connected 
		
	// create table is not case sensitive, the table name that follows is 
	// list the column names after 
	// primary key disallows duplicates 
	
	$query = "CREATE TABLE user_info ( 
		user_name VARCHAR(30) PRIMARY KEY, 
		user_password VARCHAR(255) NOT NULL, 
		usefulness VARCHAR(255) NOT NULL, 
		suggestions VARCHAR(255) NOT NULL, 
		rating VARCHAR(20) NOT NULL 	)"; 
	// this is only executed if the table does not exist yet 
	$statement = $db->prepare($query);  // create an executable version of query 
	$statement->execute(); // execute query 
	
	$statement->closeCursor(); // release the cursor so other queries can run it
	
}
?>

<?php 
/*************************/
/** insert data **/
function insertData()
{
   global $db; 

   $username_form= $_POST['username']; 
   $user_password_form = password_hash($_POST['pwd'], PASSWORD_DEFAULT); 
  
   
   $query = "INSERT INTO user_info (user_name, user_password, usefulness, suggestions, rating) VALUES (:username_placeholder, :password_placeholder, '', '', '')"; 
   // : takes in string quiry , prevent sql injection!
   // these string quarys are templates, like placeholders 
   
   $statement = $db->prepare($query);
   $statement->bindValue(':username_placeholder', $username_form); // treats it as plain string, doesn't compile the code 
   $statement->bindValue(':password_placeholder', $user_password_form); 
   
   // up into this point, we've just been preparing 
   $statement->execute(); 
   $statement->closeCursor(); 
	
}
?>

<?php 
/*************************/
/** drop table **/
function dropTable()
{
	global $db; 
	$query = "DROP TABLE user_info"; 
	
	$statement = $db->prepare($query); 
	$statement->execute(); 
	
	$statement->closeCursor(); 
}
?>




</body>
</html>
