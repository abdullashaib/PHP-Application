<?php

//including the required files
require_once 'include/DbOperation.php';
require_once 'include/includes.php';

htmlTop();

$db = new DbOperation();

$results = $db->getAllConstituents();

echo "<h2> List of Constituents</h2>";

echo "<table class='table table-bordered'>" .
     " <tr>" .
     "  <th>#</th>" .
     "  <th>Constituent</th>" .
     "</tr>";
     
$i=1;

while($row = $results->fetch_assoc()){

  $id = $row['id'];
  
  echo "<tr> " .
       "  <td>" . $i ."</td>" .
       "  <td><a href='words.php?id=$id'>" . $row['constituency'] . "</a></td>" .
       "</tr>";
       
   $i++;
   
}

echo "</table>";

htmlBottom();