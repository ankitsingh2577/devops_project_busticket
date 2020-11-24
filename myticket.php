<?php
//import the config,php file to establish database connectivity
require('database.php');
//turn on buffer output
ob_start();

//retrive professor assigned lecture from cookies
$email=$_COOKIE["email"];

// If cookies is empty them redirect to login page
if($email==""){
  header("Location: login.php");
}
//If cookies is present then page will load
else{ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>My Ticket</title>
    
    <link rel="stylesheet" href="style.css">
     
     <script type = "text/javascript">
      history.pushState(null, null, location.href);
      history.back(); history.forward();
      window.onpopstate = function () { history.go(1); };
  </script>
     
</head>

<body>
    <div id="bg">
        
    </div>
 
 <div><a class="logout" href="login.php" onclick="logout_cookie()">Logout</a></div>   
<div><a class="home" style="text-decoration:none" href="index.php">Home</a></div>
<div><a class="ticket" style="text-decoration:none" href="myticket.php">My Ticket</a></div>
<div><a class="my-account" style="text-decoration:none" href="account.php">Account</a></div>
    
    <div class="tab-header"><h1 style="text-align: center; font-weight: bold; color: #FFFFFF; font-family: sans-serif; margin-top: -46px";>! Bus Ticket Booking System !</h1></div>
    <div><p class="book-ticket">MY TICKET</p></div>
    <div class="home-container">

        <div class="ticket-container" id="scroll_ticket">
    
        	<form action="" method="post">
        		        <?php
	
	$response = array("error" => FALSE);
	$query = "SELECT * FROM book_ticket WHERE email = :email";
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
			
        	<div class="card">
        		<table class="ticket_table" id="ticket_view">
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
						<th scope="row">Mobile Number :</th>
						<td id="mobile"><?php echo $row['mobile_number']?></td>
					</tr>
					<tr>
						<th scope="row">Ticket Number :</th>
						<td><?php echo $row['ticket_number']?></td>
					</tr>
					<tr>
						<th scope="row">Origin :</th>
						<td><?php echo $row['origin']?></td>
					</tr>
					<tr>
						<th scope="row">Destination :</th>
						<td><?php echo $row['destination']?></td>
					</tr>
					<tr>
						<th scope="row">Date :</th>
						<td><?php echo $row['date']?></td>
					</tr>
					<tr>
					    <th scope="row"><a href="date_change.php"><img src="pencil.png" alt="pencil" class="pencil"><?php 
					    $ticket=$row['ticket_number'];
					    setcookie("ticket", "$ticket", time()+30*24*60*60, "/");?> </img></a>
					    </th>
					<td>
					    <a href="delete.php?ticket_number=<?php echo $row['ticket_number'];?>"><img src="bin.png" alt="bin" class="bin"> 
					    </img></a>
					</td>
					</tr>
                
                </table>
</div>

<?php }
}

else{?>

<h2 style="text-align: center; color: #000000; font-family: sans-serif; margin-top: 120px";> No Ticket found! book your ticket</h2>

<?php }

?>

</form>
       
</div>
</div>
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
