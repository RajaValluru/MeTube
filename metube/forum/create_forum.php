<?php
session_start();
global $fname;

if(!isset($_SESSION['userid'])){
  $_SESSION['userid']='1';
 header("Location: ../login.php");
}
include_once "../config.php";

/*  $servername = "mysql1.cs.clemson.edu";
  $database = "metube_daniel_raja_rzn2";
  $username = "mtbdnlrj_vf75";
  $password = "metube123";
*/
  // Create connection

  $conn = mysqli_connect($dbhost, $dbuser, $dbpass, $database);
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
  

  

  $title = mysqli_real_escape_string($conn,$_POST['title']);
  $accesstype = "";
   
  #creating access type string
  $accesstype .=isset($_POST['public'])?"1":"0";
  $accesstype .=isset($_POST['family'])?"1":"0";
  $accesstype .=isset($_POST['friends'])?"1":"0";
  $accesstype .=isset($_POST['aquaintance'])?"1":"0";

  $description =mysqli_real_escape_string( $conn,$_POST['description']);


  $sql = "INSERT INTO forum (userid, title, description, accesstype)
          VALUES ('$userid', '$title', '$description','$accesstype')";
  if(mysqli_query($conn, $sql)){
      echo "Records added successfully.";
  } else{
      echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
  }
  mysqli_close($conn);
}






?>



<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="../metube_style.css">

</head>
<body>
 <div class="navbar">
  <a href="../index.php">Home</a>
  <a href="create_forum.php">Create a Forum</a>
  <a href="search_view.php">Search for Forum</a>
   <div class="navbar-right">
    <?php echo "<a>Hello $fname</a>";
    if($userid==1){echo "<a href='../login.php'>Login</a>";}
    else{echo "<a href='../logout.php'>Logout</a>";}?>
  </div>
  
</div>
<h3>Create your Forum</h3>

<div class="container">
  <form action="create_forum.php" method="post">
    <label for="title">Forum Title</label>
    <input type="text" id="title" name="title" placeholder="Forum Title:">

    
    <label for="description">Description</label>
    <textarea name="description" placeholder="Write something.." style="height:200px"></textarea>

    <label for="access">Access Type:</label><br>
    <input type="checkbox" name="public" value="Public" checked>
    <label for="public">Public</label><br>
    <input type="checkbox" name="family" value="Family">
    <label for="family">Family</label><br>
    <input type="checkbox" name="friends" value="Friends">
    <label for="friends">Friends</label><br>
    <input type="checkbox" name="aquaintance" value="Aquaintance">
    <label for="aquaintance">Aquaintances</label><br><br>

    <input type="submit" name="submit" value="submit">
  </form>
</div>

</body>
</html>
