<?php

error_reporting(0);

//including the required files
require_once 'include/DbOperation.php';
require_once 'include/includes.php';

htmlTop();

$db = new DbOperation();

$results = $db->getVotersShehia($_GET['id']);

$shehia = $db->getShehia($_GET['id']);

?>


<h2> List of Voters in <?php echo $shehia ?> Word</h2>

<table class="table table-bordered">
  <tr>
    <th>#</th>
    <th>Full Name</th>
    <th>Date of Birth</th>
    <th>Gender</th>
    <th>Address</th>
    <th>Polling Station</th>
    <th>Voter ID #</th>
  </tr>

<?php     
$i=1;

while($row = $results->fetch_assoc()){

  $id = $row['id'];
  
  echo "<tr> " .
       "  <td>" . $i ."</td>" .
       "  <td>" . $row['firstname'] . " " . $row['middlename'] . " " . $row['lastname'] . "</td>" .
       "  <td>" . $row['datebirth'] ."</td>" .
       "  <td>" . $row['gender'] ."</td>" .
       "  <td>" . $row['residentialaddress'] ."</td>" .
       "  <td>" . $row['name'] ."</td>" .
       "  <td>" . $row['voterIDnumber'] ."</td>" .
       "</tr>";
                                                         
   $i++;
   
}

echo "</table>";

htmlBottom();