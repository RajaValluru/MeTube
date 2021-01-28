<?php
session_start();
global $fname;
global $forumid;

include_once "../config.php";

if(isset($_GET['a']) ){
	echo ($_GET['a']);
    $_SESSION['forumid']=$_GET['a'];
    $forumid=$_GET['a'];
 }
if(!isset($_SESSION['userid'])){
  $_SESSION['userid']='1';
  //redirect to sign in
}


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
  if(!isset($_SESSION['userid'])){
  $_SESSION['userid']='1';
 header("Location: ../login.php");
}
  echo "It submitted";
  
  $description =mysqli_real_escape_string( $conn,$_POST['description']);


  $sql = "INSERT INTO post (ForumID, userID, upvotes, description)
          VALUES ('$forumid', '$userid', '0','$description')";
  if(mysqli_query($conn, $sql)){
      echo "Records added successfully.";
  } else{
      echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
  }
header("Location: view_forum.php?a=$forumid");
}

  mysqli_close($conn);







?>



<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="../metube_style.css">
</style>
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
<h3>View Discussion</h3>

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
          FROM forum
          WHERE ForumID=$forumid;";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    // output data of each row
   
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
      echo "<td>". $row['Title'] ."</a></td>";
      echo "<td>" . $userinfo['fname']." ".$userinfo['lname'] ."</td>";
      echo "<td>" . $row['TimeStamp'] ."</td>";
      echo "<td>" . $row['Description'] ."</td>";
      echo "</tr>";
      
      //echo "<b>Discussion Title: </b>" . $row['Title']. "<br><b>User: </b>" . $row["UserID"]. "<br><b>Description:</b> " . $row["Description"]. "<br><br><br>";
    }
    echo "</table><br><br><br><br>";
  } else {
    echo "0 results";
  }

  if(mysqli_query($conn, $sql)){
 } else{
      echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
  }

  
  $sql = "SELECT * 
          FROM post
          WHERE ForumID=$forumid;";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    // output data of each row
   
    echo "<table border='1'>";
    echo "<tr>";
     // echo "<td><b>Upvotes</b></td>";
      echo "<td><b>User</b></td>";
      echo "<td><b>Time</b></td>";
      echo "<td><b>Post</b></td>";
      echo "</b></tr>";
    while($row = $result->fetch_assoc()) {
      $sql = "SELECT fname,lname 
          FROM users
          WHERE userid=".$row['UserID'].";";
  		$username = $conn->query($sql);
  		$userinfo= $username->fetch_assoc();
      echo "<tr>";
      //echo "<td>". $row['Upvotes'] ."</a></td>";
      echo "<td>" . $userinfo['fname']." ".$userinfo['lname'] ."</td>";
      echo "<td>" . $row['TimeStamp'] ."</td>";
      echo "<td>" . $row['Description'] ."</td>";
      echo "</tr>";
      
      //echo "<b>Discussion Title: </b>" . $row['Title']. "<br><b>User: </b>" . $row["UserID"]. "<br><b>Description:</b> " . $row["Description"]. "<br><br><br>";
    }
    echo "</table><br><br><br><br>";
  } else {
    echo "0 results";
  }

  if(mysqli_query($conn, $sql)){
 } else{
      echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
  }
  mysqli_close($conn);

?>

<h5>Add new Post</h5>


  <form action="<?php echo "view_forum.php?a=$forumid" ?>" method="post">
    
    <label for="description">Post Description</label>
    <textarea name="description" placeholder="Write something.." style="height:100px"></textarea>

    <input type="submit" name="submit" value="submit">
  </form>
</div>

</body>
</html>
