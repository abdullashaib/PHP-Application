<?php

//including the required files
require_once 'include/DbOperation.php';
require_once 'include/includes.php';

htmlTop();

$db = new DbOperation();

$id = $_GET['id'];

$constituent = $db->getConstituent($id);

$results = $db->getWordsConstituents($id);

$shehia = $db->getShehiaConstituents($id);

$pollings = $db->getPollingConstituents($id);

//echo "This is the master page for displaying voters from categories listed below. In Zanzibar, there are five diferent elections.";
/*
 *  Beginning of displaying words
 */ 
 
echo "<h2> List of Words in " . $constituent . " Constituent </h2>";

echo "<table class='table table-bordered'>" .
     " <tr>" .
     "  <th>#</th>" .
     "  <th>Word</th>" .
     "</tr>";
     
$i=1;

while($row = $results->fetch_assoc()){
  $id = $row['id'];
  echo "<tr> " .
       "  <td>" . $i ."</td>" .
       "  <td><a href='wordVoters.php?id=$id'>" . $row['name'] . "</a></td>" .
       "</tr>";
       
   $i++;
   
}

echo "</table>";

/*
 *  Beginning of displaying shehia
 */
 
echo "<h2> List of Shehia in " . $constituent . " Constituent </h2>";

echo "<table class='table table-bordered'>" .
     " <tr>" .
     "  <th>#</th>" .
     "  <th>Shehia</th>" .
     "</tr>";
     
$i=1;

while($rr = $shehia->fetch_assoc()){
   $id = $rr['id'];
  echo "<tr> " .
       "  <td>" . $i ."</td>" .
       "  <td><a href='shehiaVoters.php?id=$id'>" . $rr['name'] . "</a></td>" .
       "</tr>";
       
   $i++;
   
}

echo "</table>";


/*
 *  Beginning of displaying polling stations
 */
 
echo "<h2> List of Polling Stations in " . $constituent . " Constituent </h2>";

echo "<table class='table table-bordered'>" .
     " <tr>" .
     "  <th>#</th>" .
     "  <th>Polling Station</th>" .
     "</tr>";
     
$i=1;

while($r = $pollings->fetch_assoc()){
  $id = $r['id'];
  echo "<tr> " .
       "  <td>" . $i ."</td>" .
       "  <td><a href='pollVoters.php?id=$id'>" . $r['name'] . "</a></td>" .
       "</tr>";
       
   $i++;
   
}

echo "</table>";

htmlBottom();