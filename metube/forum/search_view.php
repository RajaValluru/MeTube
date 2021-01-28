<?php
session_start();

include_once "../config.php";
/*  $servername = "mysql1.cs.clemson.edu";
  $database = "database";
  $username = "mtbdnlrj_vf75";
  $password = "metube123";
*/
  // Create connection

  $conn = mysqli_connect($dbhost, $dbuser, $dbpass, $database);
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }


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
    else{echo "<a href='../signout.php'>Logout</a>";}?>
  </div>
</div>
 <h3>Search for a Discussion</h3>

<div class="container">
  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    <label for="title">Search</label>
    <input type="text" name="search" placeholder="Key phrase">


    <input type="submit" name="submit" value="submit">
  </form>





<?php
include_once "../config.php";

if(!isset($_SESSION['userid'])){
  $_SESSION['userid']='1';
  //redirect to sign in
}

if(isset($_POST['submit']) ) {


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


  $userid = $_SESSION['userid'];
  $search = mysqli_real_escape_string($conn,$_POST['search']);
  

  $sql = "SELECT * 
          FROM forum
          WHERE ((description RLIKE '%".$search."%') OR (title RLIKE '%".$search."%')) AND accesstype LIKE '1%';";
  $result = $conn->query($sql);



  if ($result->num_rows > 0) {
    // output data of each row
    echo "Results:<br>";
    echo "<table border='1'>";
    echo "<tr>";
      echo "<td><b>Title</b></td>";
      echo "<td><b>User</b></td>";
      echo "<td><b>Time</b></td>";
      echo "<td><b>Description</b></td>";
      echo "</b></tr>";
    while($row = $result->fetch_assoc()) {
      $sql = "SELECT fname,lname 
          FROM users
          WHERE userid=".$row['UserID'].";";
      $username = $conn->query($sql);
      $userinfo= $username->fetch_assoc();
      echo "<tr>";
      echo "<td><a href='view_forum.php?a=".$row['ForumID']."'>". $row['Title'] ."</a></td>";
      echo "<td>" . $userinfo['fname']." ".$userinfo['lname'] ."</td>";
      echo "<td>" . $row['TimeStamp'] ."</td>";
      echo "<td>" . $row['Description'] ."</td>";
      echo "</tr>";
      
      //echo "<b>Discussion Title: </b>" . $row['Title']. "<br><b>User: </b>" . $row["UserID"]. "<br><b>Description:</b> " . $row["Description"]. "<br><br><br>";
    }
    echo "</table>";
  } else {
    echo "0 results";
  }

  if(mysqli_query($conn, $sql)){
      echo "<br><br>Records retrieved successfully.";
  } else{
      echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
  }
  mysqli_close($conn);
}
?>
</div>
</body>
</html>
