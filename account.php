<?php
//Import the database file to establish connectivity with database
require('database.php');
//Turn on buffer output
ob_start();

//Retrive email from cookies
$email=$_COOKIE["email"];

// Redirect to login page if cookie is empty
if($email==""){
  header("Location: login.php");
}

else{ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>My Account Page</title>
    <!-- Loads the stylesheet style.css for colourful GUI with diffrent fonts and layout -->
    <link rel="stylesheet" href="style.css">
     <script type = "text/javascript">
	//Disables the back press option     
      history.pushState(null, null, location.href);
      history.back(); history.forward();
      window.onpopstate = function () { history.go(1); };
  </script>
</head>

<body onload="javascript:fetchValues()">
    <div id="bg">
        
    </div>
 <div><a class="logout" href="login.php" onclick="logout_cookie()">Logout</a></div>
<div><a class="home" style="text-decoration:none" href="index.php">Home</a></div> 
<div><a class="ticket" style="text-decoration:none" href="myticket.php">My Ticket</a></div> 
<div><a class="my-account" style="text-decoration:none" href="account.php">Account</a></div> 
    
    <div class="tab-header"><h1 style="text-align: center; font-weight: bold; color: #FFFFFF; font-family: sans-serif; margin-top: -46px";>! Bus Ticket Booking System !</h1></div>
    <div><p class="book-ticket">My Account</p></div>
    <div class="home-container">
        <div class="ticket-container">
            <?php
	//Stores users data in array
	$response = array("error" => FALSE);
	$query = "SELECT * FROM users WHERE email = :email";
        $query_params = array(
        ':email' => $email	
    );
	
	try {
        $stmt = $database->prepare($query);
        $result = $stmt->execute($query_params);
}

    catch (PDOException $ex) {
        $response["error"] = true;
        $response["message"] = "Database Error1. Please Try Again!";
        die(json_encode($response));
    }
	
    if($result!=0){
            while($row = $stmt->fetch())
              {?>
        	<img src="user_img.png" alt="Avatar" class="avatar">
      		<table class="table">
      		    <caption> </caption>
				<tr>
				  <th scope="row">Name :</th>
				  <td><?php echo $row['name']?></td>
				</tr>
				<tr>
				  <th scope="row">Email :</th>
				  <td><?php echo $row['email']?></td>
				</tr>
				<tr>
				  <th scope="row">Mobile :</th>
				  <td><?php echo $row['mobile_number']?></td>
				</tr>
    </table>
    <?php }
}
?>
    </div></div> 
    
</body>
	<script>
  function logout_cookie(){
    document.cookie = "name" + "=;expires=Thu, 25 march 1999 00:00:00 GMT; path=/"
    document.cookie = "email" + "=;expires=Thu, 25 march 1999 00:00:00 GMT; path=/"
    document.cookie = "mobile" + "=;expires=Thu, 25 march 1999 00:00:00 GMT; path=/"
     document.cookie = "ticket" + "=;expires=Thu, 25 march 1999 00:00:00 GMT; path=/"
  }
</script>
</html>
<?php }?>
