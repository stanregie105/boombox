<?php

// Connect to mysql server and database
$conn = mysqli_connect('localhost', 'root', '', 'project');

// If not connected stop executing
if (!$conn) {
    die('Not connected');
}

// query holds all your normal sql query
$sql = 'select * from driver_info';

// Run query
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
<style>
table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

td, th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
}

tr:nth-child(even) {
    background-color: #dddddd;
}
</style>
</head>
<body>

<h2>HTML Table</h2>

<table>
  <tr>
    <th>ID</th>
    <th>First Name</th>
    <th>Last Name</th>
    <th>plate_number</th>
    <th>Email</th>
    <th>Chasis Number</th>
    <th>Engine Number</th>
    <th>Workplace</th>
    <th>Postal Code</th>
  </tr>
  <?php
    while($row = mysqli_fetch_assoc($result)) {
    ?>
        <tr>
            <td><?php echo $row["driver_id"]; ?></td>
            <td><?php echo $row["first_name"]; ?></td>
            <td><?php echo $row["last_name"]; ?></td>
            <td><?php echo $row["plate_number"]; ?></td>
            <td><?php echo $row["Email_address"]; ?></td>
            <td><?php echo $row["Chasis_number"]; ?></td>
            <td><?php echo $row["Engine_number"]; ?></td>
            <td><?php echo $row["Workplace"]; ?></td>
            <td><?php echo $row["postal_code"]; ?></td>
            
        </tr>
    <?php
    }
  ?>
 
</table>
 <?php
// define variables and set to empty values
$driver_id = $first_name = $last_name =$plate_number= $Email_address = $Chasis_number = "";

if (isset($_POST['submit'])) {
  $first_name = $_POST["first_name"];
  $last_name = $_POST["last_name"];
  $last_name = $_POST["plate_number"];
  $Email_address = $_POST["Email_address"];
  $Chasis_number = $_POST["Chasis_number"];
  $Engine_number = $_POST["Engine_number"];
  $Workplace = $_POST["Workplace"];
  $postal_code = $_POST["postal_code"];
  $result=mysqli_query($conn, "INSERT INTO driver_info (first_name,last_name,plate_number,Email_address,Chasis_number,Engine_number,Workplace,postal_code) VALUES('$first_name','$last_name','$Email_address','$Chasis_number','$Engine_number','$Workplace','$postal_code')");
  if($result){
      echo '<br> input data is successful';
      header("Refresh:0");
  }else{
      echo '<br> input data is not valid';
  }
}

?>
<html>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
  first_name: <input type="text" name="first_name">
  <br><br>
  last_name: <input type="text" name="last_name">
  <br><br>
  last_name: <input type="text" name="plate_
  number">
  <br><br>
  Email_address: <input type="text" name="Email_address">
  <br><br>
  Chasis_number: <input type="text" name="Chasis_number">
  <br><br>
  Engine_number: <input type="text" name="Engine_number">
  <br><br>
  Workplace: <input type="text" name="Workplace">
  <br><br>
  postal_code: <input type="text" name="postal_code">
  <br><br>
  <input type="submit" name="submit" value="Submit">  
  
</form>

</body>
</html>
