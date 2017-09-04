<?php

error_reporting(0);

//including the required files
require_once 'include/DbOperation.php';
require_once 'include/includes.php';

$email = $_POST['email'];
$password = $_POST['password'];

htmlTop();

?>

<h2> List of constituents</h2>

<table class="table table-bordered">
  <tr>
    <th>#</th>
    <th>Constituent</th>
  </tr>

<?php

$db = new DbOperation();

$user = $db->getAllConstituents();

$i =1;

while( $row = $user->fetch_assoc()) {
    $id = $row['id'];
    echo "<tr>" .
         " <td>" . $i ."</td>" .
         " <td><a href='words.php?id=$id'>" . $row['constituency'] ."</a></td>" .
         "</tr>";
     $i++;    
}

?>
</table>
<!-- 
<form method="post">
  <div class="form-group row">
    <label for="exampleInputEmail1" class="col-sm-2 col-form-label">Email address</label>
    <div class="col-sm-8">
      <input type="email" class="form-control" id="email" name="email" placeholder="Enter email">
    </div>
  </div>
  <div class="form-group row">
    <label for="password" class="col-sm-2 col-form-label">Password</label>
    <div class="col-sm-8">
      <input type="password" class="form-control" name="password" id="password" placeholder="Password">
    </div>
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
-->
<?php htmlBottom(); ?>