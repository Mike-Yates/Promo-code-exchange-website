<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
  
  <title>Feedback Form</title>    
</head>
<body>

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
    
    
    <h1>Thanks For Your Feedback <font color="green" style="font-style:italic">
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
	<form action="http://localhost/my-project/feedback.php" method="get">
        <input type="submit" value="Edit" class="btn btn-dark" />
      </form>
	
	
	<h5>What suggestions do you have to improve Promo Code Exchange?</h5>
	You answered:
	<font color="green" style="font-style:italic">  
	<?php if (isset($_COOKIE['suggestions'])) echo $_COOKIE['suggestions'] ?>
	</font>
	<form action="http://localhost/my-project/question1.php" method="get">
        <input type="submit" value="Edit" class="btn btn-dark" />
      </form>
	
	
	<h5>Rate Promo Code Exchange, 1 to 5!</h5>
	You answered: 
	<font color="green" style="font-style:italic">  
	<?php if (isset($_COOKIE['suggestions'])) echo $_SESSION['rating'] ?>
	</font>
	<form action="http://localhost/my-project/question3.php" method="get">
        <input type="submit" value="Edit" class="btn btn-dark" />
      </form>
	</div>
	
    <br/> 
    <br/> 

	
   <form action="index.html" method="get">
        <input type="submit" value="Return to Home" class="btn btn-dark" />
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
		header('Location: success.php');
	}	
}
 
?>

</body>
</html>
