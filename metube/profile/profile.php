<?php
session_start();
global $fname;
global $forumid;
if(isset($_GET['a']) ){
	echo ($_GET['a']);
    $_SESSION['forumid']=$_GET['a'];
    $forumid=$_GET['a'];
 }
if($_SESSION["userid"] == '1' or !isset($_SESSION['userid'])){
  $_SESSION['userid']='1';
  header("Location: ../login.php");
}

$servername = "mysql1.cs.clemson.edu";
  $database = "metube_daniel_raja_rzn2";
  $username = "mtbdnlrj_vf75";
  $password = "metube123";
  // Create connection

  $conn = mysqli_connect($servername, $username, $password, $database);
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
global $userid;
  $userid = $_SESSION['userid'];
  $search = mysqli_real_escape_string($conn,$_POST['search']);
  
  $userid=$_SESSION['userid'];
  $sql = "SELECT * 
          FROM users
          WHERE userID=$userid;";
  
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
      $fname = $row['fname'];
    }
  }


if(isset($_POST['submit']) ) {
  echo "It submitted";
  $first = mysqli_real_escape_string($conn,$_POST['first']);
  $last = mysqli_real_escape_string($conn,$_POST['last']);


  $sql = "Update users set fname='$first',lname='$last' where userid=$userid;";
  if(mysqli_query($conn, $sql)){
      echo "Records added successfully.";
  } else{
      echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
  }
header("Location: /profile/profile.php");
}
if(isset($_POST['passwordchange']) ) {
  echo "It submitted";
  $cp = mysqli_real_escape_string($conn,$_POST['cp']);
  $np = mysqli_real_escape_string($conn,$_POST['np']);


  $sql = "Update users set password='$np' where userid=$userid AND password='cp';";
  if(mysqli_query($conn, $sql)){
      echo "Records added successfully.";
  } else{
      echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
  }

}

  mysqli_close($conn);







?>



<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body {font-family: Arial, Helvetica, sans-serif;}
* {box-sizing: border-box;}

input[type=text], select, textarea {
  width: 100%;
  padding: 12px;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
  margin-top: 6px;
  margin-bottom: 16px;
  resize: vertical;
}

input[type=submit] {
  background-color: #4CAF50;
  color: white;
  padding: 12px 20px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

input[type=submit]:hover {
  background-color: #45a049;
}

.container {
  border-radius: 5px;
  background-color: #f2f2f2;
  padding: 20px;
}
 /* The navigation bar */
.navbar {
  overflow: hidden;
  background-color: #333;
  position: fixed; /* Set the navbar to fixed position */
  top: 0; /* Position the navbar at the top of the page */
  width: 100%; /* Full width */
}

/* Links inside the navbar */
.navbar a {
  float: left;
  display: block;
  color: #f2f2f2;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
}

/* Change background on mouse-over */
.navbar a:hover {
  background: #ddd;
  color: black;
}
.navbar-right {
  float: right;
}

/* Main content */
.main {
  margin-top: 30px; /* Add a top margin to avoid content overlay */
} 
</style>
</head>
<body>
 <div class="navbar">
  <a href="../index.php">Home</a>
   <div class="navbar-right">
    <?php echo "<a>Hello $fname</a>";
    if($userid==1){echo "<a href='../login.php'>Login</a>";}
    else{echo "<a href='../signout.php'>Logout</a>";}?>
  </div>
  
</div>
<h3>Update Profile</h3>

<div class="container">
  <?php
if(!isset($_SESSION['userid'])){
  $_SESSION['userid']='1';
  //redirect to sign in
}


$servername = "mysql1.cs.clemson.edu";
  $database = "metube_daniel_raja_rzn2";
  $username = "mtbdnlrj_vf75";
  $password = "metube123";
  // Create connection

  $conn = mysqli_connect($servername, $username, $password, $database);
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }


  $userid = $_SESSION['userid'];
  
  $sql = "SELECT * 
          FROM users
          WHERE userid=$userid;";
  $result = $conn->query($sql);


  if ($result->num_rows > 0) {
    // output data of each row
   
    
    while($row = $result->fetch_assoc()) {
      
      $firstname=$row['fname'];
      $lastname = $row['lname'];
    
    }
    
  } else {
    echo "0 results";
  }

  if(mysqli_query($conn, $sql)){
 } else{
      echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
  }

  
  ?>
      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    
      First Name:<br>
      <input type='text' name="first" placeholder="<?php echo $firstname;?>">
      Last Name:<br>
      <input type='text' name = "last" placeholder="<?php echo $lastname;?>">
      
      <input type="submit" name="submit" value="Update Name">
      </form>

      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
      Current Password:<br>
      <input type='password' name="cp" placeholder="Current Password"><br>
      New Password:<br>
      <input type='password' name = "np" placeholder="New Password"><br>

      <input type="submit" name="passwordchange" value="Update Password">
      </form>
      
</div>

</body>
</html>
