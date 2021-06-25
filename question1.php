<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
  
  <title>Feedback Form Cont.</title>    
</head>
<body>

<?php
require('connectdb.php');

// require: if a required file is not found, require() produces a fatal error, the rest of the script won't run
// include: if a required file is not found, include() throws a warning, the rest of the script will run
?>

<?php
// if(!isset($_COOKIE['user']))
//	header("Location: login.php"); 
session_start(); 
if (!isset($_SESSION['user'])){
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
    
    
    <h1>Thanks <font color="green" style="font-style:italic">
	<?php 
	// if (isset($_COOKIE['user'])) echo $_COOKIE['user']  
	 echo $_SESSION['user']
	?> 
	</font> </h1>
	
    <h5>Do you think Promo Code exchange is useful? Why or why not?</h5>
	You answered:
	<font color="green" style="font-style:italic">  
	<?php if (isset($_SESSION['usefulness'])) echo $_SESSION['usefulness']  ?>
	</font>
    <br/> 
	<h1>What suggestions do you have to improve Promo Code Exchange?</h1>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">      
      <input type="text" name="suggestions" class="form-control" autofocus required /> <br />
      <input type="submit" value="Submit" class="btn btn-light"  />   
    </form>
  </div>
  
  
  <?php
	} // close the curly bracket frome arleir
	displayPreviousAnswer();
  ?> 
  
  <?php 
  // using the cookie method 
  
  if($_SERVER['REQUEST_METHOD']=='POST'){
	if(isset($_POST['suggestions'])){
		setcookie('suggestions', $_POST['suggestions'], time()+3600); // every page can access these cookies 
		
		// insert data into database 
		insertData(); 
		
		header('Location: question3.php'); 
	}
  }
  
  ?> 

  
<?php 
/*************************/
/** insert data **/
function insertData()
{
   global $db; 

   $answer2_form= $_POST['suggestions']; 
   $username_form = $_SESSION['user'];
   
   $query = "UPDATE user_info SET suggestions=:answer2_placeholder WHERE user_name=:username_placeholder"; 
   // : takes in string quiry , prevent sql injection!
   // these string quarys are templates, like placeholders 
   
   $statement = $db->prepare($query);
   $statement->bindValue(':username_placeholder', $username_form); // treats it as plain string, doesn't compile the code 
   $statement->bindValue(':answer2_placeholder', $answer2_form); // treats it as plain string, doesn't compile the code 
   
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
	$query = "SELECT suggestions FROM user_info WHERE user_name=:username_placeholder"; 
	
	$statement = $db->prepare($query);
	$statement->bindValue(':username_placeholder', $username_form); // treats it as plain string, doesn't compile the code 

	
	$statement->execute(); 
	
	$results = $statement->fetch(); // get array of all rows
	// fetch() returns an array of one row 
	
	$statement->closeCursor(); // release the hold on the instance 
	// allowing other quaries to use this instance 
	
	echo '<div class="container">' . "previous answer: " . '<font color="green" style="font-style:italic; font-size:150%">' . $results[0] . '</font> </div>';	
	$answer = $results[0]; 
	return $answer; 
}
?>

</body>
</html>
