<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
  
  <title>Feedback Form</title>    
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
$usefulness_msg = NULL; 
if($_SERVER['REQUEST_METHOD'] == 'POST'){

if(empty($_POST['usefulness']))  // look at form to make sure the names match (emailaddr)
	$usefulness_msg = "Please answer Question"; 
}
 ?> 



<?php
// if(!isset($_COOKIE['user']))
//	header("Location: login.php"); 
session_start(); 
if (!isset($_SESSION['user'])){ // make sure the user is logged in alredy 
	// redirect 
	header('Location: login3.php');  
} else {
?>
     
  <div class="container">
    <div style="float:right; padding:30px;">    
      <form action="logout.php" method="get">
        <input type="submit" value="Log out" class="btn btn-dark" />
      </form>
    </div>    
    
    
    <h1>Welcome <font color="green" style="font-style:italic">
	<?php 
	// if (isset($_COOKIE['user'])) echo $_COOKIE['user']  
	 echo $_SESSION['user']
	?> 
	</font> </h1>
    <h3>Do you think Promo Code exchange is useful? Why or why not?</h3>
       
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">      
      <input type="text" name="usefulness" class="form-control" autofocus required /> <br/>
      <input type="submit" value="Submit" class="btn btn-light"  />   
    </form> 
  </div>
  
  <?php
	} // close the curly bracket frome arleir
	displayPreviousAnswer();
  ?> 
  
 
  
<?php 
// using the session method 
if($_SERVER['REQUEST_METHOD'] == 'POST')
{
	if(isset($_POST['usefulness']))
	{
		$_SESSION['usefulness'] = $_POST['usefulness'];
		// insert the date into database 
		insertData(); 
		header('Location: question1.php');
	}	
}
?>

<?php 
/*************************/
/** insert data **/
function insertData()
{
   global $db; 

   $answer1_form= $_POST['usefulness']; 
   $username_form = $_SESSION['user'];
   
   $query = "UPDATE user_info SET usefulness=:answer1_placeholder WHERE user_name=:username_placeholder"; 
   // : takes in string quiry , prevent sql injection!
   // these string quarys are templates, like placeholders 
   
   $statement = $db->prepare($query);
   $statement->bindValue(':username_placeholder', $username_form); // treats it as plain string, doesn't compile the code 
   $statement->bindValue(':answer1_placeholder', $answer1_form); // treats it as plain string, doesn't compile the code 
   
   // up into this point, we've just been preparing 
   $statement->execute(); 
   $statement->closeCursor(); 
	
}
?>

<?php  
/*************************/
/** display answer from database **/
function displayPreviousAnswer()
{
	global $db; 
	$username_form = $_SESSION['user'];

	// format: select col1_name, col2_name, from table_name where condition1 and condition2
	$query = "SELECT usefulness FROM user_info WHERE user_name=:username_placeholder"; 
	
	$statement = $db->prepare($query);
	$statement->bindValue(':username_placeholder', $username_form); // treats it as plain string, doesn't compile the code 

	
	$statement->execute(); 
	
	$results = $statement->fetch(); // get array of all rows
	// fetch() returns an array of one row 
	
	$statement->closeCursor(); // release the hold on the instance 
	// allowing other quaries to use this instance 
	
	if($results[0] != ''){
	echo '<div class="container">' . "previous answer: " . '<font color="green" style="font-style:italic">' . $results[0] . '</font> </div>';	
	}
	$answer = $results[0]; 
	return $answer; 
}
?>

</body>
</html>
