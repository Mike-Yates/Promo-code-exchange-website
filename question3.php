<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
  
  <title>Feedback Form Final Question</title>    
</head>
<body>

<?php
require('connectdb.php');

// require: if a required file is not found, require() produces a fatal error, the rest of the script won't run
// include: if a required file is not found, include() throws a warning, the rest of the script will run
?>

<?php 
$usefulness_msg = NULL; 
if($_SERVER['REQUEST_METHOD'] == 'POST'){

if(empty($_POST['rating']))  // look at form to make sure the names match 
	$rating_msg = "Please answer Question with integer 1 to 5"; 
}
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
	<h5>What suggestions do you have to improve Promo Code Exchange?</h5>
	You answered:
	<font color="green" style="font-style:italic">  
	<?php if (isset($_COOKIE['suggestions'])) echo $_COOKIE['suggestions'] ?>
	</font>
	
    <br/> 
	<h1>Rate Promo Code Exchange, 1 to 5!</h1>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">      
      <input type="text" name="rating" class="form-control" autofocus required /> <br />
	  
      <input type="submit" value="Submit" class="btn btn-light"  />   
    </form>
  </div>
  
  
  <?php
	} // close the curly bracket frome earlier
  ?> 
  
  

  
<?php 
// using the session method 

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
	if(isset($_POST['rating']))
	{
		$_SESSION['rating'] = $_POST['rating'];
		// insert data into my database 
		insertData(); 
		
		header('Location: success.php');
	}	
}
 
?>

<?php 
/*************************/
/** insert data **/
function insertData()
{
   global $db; 

   $answer3_form= $_POST['rating']; 
   $username_form = $_SESSION['user'];
   
   $query = "UPDATE user_info SET rating=:answer3_placeholder WHERE user_name=:username_placeholder"; 
   // : takes in string quiry , prevent sql injection!
   // these string quarys are templates, like placeholders 
   
   $statement = $db->prepare($query);
   $statement->bindValue(':username_placeholder', $username_form); // treats it as plain string, doesn't compile the code 
   $statement->bindValue(':answer3_placeholder', $answer3_form); // treats it as plain string, doesn't compile the code 
   
   // up into this point, we've just been preparing 
   $statement->execute(); 
   $statement->closeCursor(); 
	
}
?>

</body>
</html>
