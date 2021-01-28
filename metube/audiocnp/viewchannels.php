<?php
session_start();
if($_SESSION['userid'] == '1' or !isset($_SESSION['userid'])){
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


  $userid = $_SESSION['userid'];
  $search = mysqli_real_escape_string($conn,$_POST['search']);
  
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

  
  if(isset($_REQUEST['delete']))
  {
    $sql = "DELETE FROM audiochannel
            WHERE AChannel_id = ". $_REQUEST['channelid'].";";
    if(mysqli_query($conn, $sql)){
        echo "Channel deleted successfully.";
    } else{
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
    }
    
  }


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
  <a href="createchannel.php">Create Audio Channel</a>
  <a href="viewchannels.php">View Your Audio Channels</a>
  <div class="navbar-right">
    <?php echo "<a>Hello $fname</a>";
    if($userid==1){echo "<a href='../login.php'>Login</a>";}
    else{echo "<a href='../signout.php'>Logout</a>";}?>
  </div>
</div>
 <h3>Channels</h3>

<div class="container">
 





<?php
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

  

  $sql = "SELECT * from audiochannel where userid=$userid";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    // output data of each row
    echo "<table border='1'>";
    echo "<tr>";
      echo "<td><b>Channel Name</b></td>";
      echo "<td><b>Subscribers</b></td>";
      echo "<td><b>Delete</b></td>";
      echo "</b></tr>";
    while($row = $result->fetch_assoc()) {
      echo "<tr>";
      
      echo "<td><a href='channelpage.php?cid=".$row['AChannel_ID']."'>" . $row['ChannelName'] ."</a></td>";
      echo "<td>".$row['SubscriptionCount']."</td>";
      echo "<td><form method='post'> <input type='submit' name='delete' value='Delete'>
            <input type='hidden' name='channelid' value='".$row['AChannel_ID']."'>
       </form></td>";
      echo "</tr>";
    
    }
    echo "</table>";
  } else {
    echo "0 results";
  }

  if(mysqli_query($conn, $sql)){
      echo "<br><br>";
  } else{
      echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
  }
  mysqli_close($conn);

?>
</div>
</body>
</html>
