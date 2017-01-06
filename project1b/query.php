<!DOCTYPE html>
<html>
<head><title>Jihoon's Movie Database</title></head>

<h1>Jihoon's Movie Database</h1>
(v.1.0 - Oct 15 2016) <br><br>
Type an SQL query in the following box: <br>
Ex) SELECT * FROM Actor WHERE id=10;
<br>
<p>
<form method="get">
  <TEXTAREA NAME="query" ROWS=10 COLS=50></TEXTAREA>
  <br>
  <input type="submit" value="Submit">
</form>
</p>

<?php
  $db = new mysqli('localhost', 'cs143', '', 'CS143');

  if($db->connect_errno > 0){
      die('Unable to connect to database [' . $db->connect_error . ']');
  }
  $inputQuery = $_GET['query'];
  $rs = $db->query($inputQuery);

  //Error handle
  if (!$rs) { 
    $errmsg = $db->error;
    print "Query failed: $errmsg <br />";
    exit(1);
  }
?>

<h3>Results from MySQL:</h3>
<html><body><table border=1 cellspacing=1 cellpadding=2><tr align=center>

<?php
  //Header row definition
  $finfo = $rs->fetch_fields();
  foreach ($finfo as $val) {
    echo '<td><b>' . $val->name . '</b></td>';
  }
  echo '</tr>';

  //Table content
  while($row = $rs->fetch_row()) {
    echo '<tr align=center>';
    foreach ($row as $rowField) {
      ($rowField==NULL)? $toPrint='N/A':$toPrint=$rowField;
      echo '<td>'. $toPrint . '</td>';
    }
  }
  echo '</table></body></html>';

  // Free up memories and close connection to db
  $rs->free();
  $db->close();
?>

</body>
</html>