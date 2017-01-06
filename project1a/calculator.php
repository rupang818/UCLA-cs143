<!DOCTYPE html>
<html>
<head>
  <title>Jihoon's Calculator</title>
</head>

<body>
<h1>Jihoon's Calculator</h1>
(v.1.1 - Developed 10/4/16)
<br>
<p>
<form method="get">
  <input type="text" name="expr">
  <input type="submit" value="Calculate">
</form>
</p>
<?php
$number = '-?[0-9\.]';
$operators =  '[\+\-\*\/]';

function operate($o1, $o2, $o3){
  global $number, $operators;
  // Double check for the operands being numbers and the validity of the operator
  if (preg_match("/$number+/",$o1) && preg_match("/$operators/",$o2) && preg_match("/$number+/",$o3)) {
    switch($o2){
        case '+':
            $p = $o1 + $o3;
            break;
        case '-':
            $p = $o1 - $o3;
            break;
        case '*':
            $p = $o1 * $o3;
            break;
        case '/':
            if ($o3 == 0) {
              $p = "Division by zero error!";
              break;
            }
            $p = $o1 / $o3;
            break;
    }
  }
  return $p;
}

// This function goes through the expression, evaluates all mult/div commands in order
// and returns expression that just needs a simple left-to-right evaluation 
function preProcessExpr ($input) {
  global $number, $operators;
  // Go through input and process high-order (e.g. * and /) first
  preg_match("/^($number+)\s*([\+\-])\s*($number+)(.*)/",$input,$m);
  $multOrDiv = preg_match("/^($number+)\s*([\*\/])\s*($number+)\s*(.*)/",$input,$n);
  
  $r="";
  if (empty($input)) {
    return $r;
  } elseif (preg_match("/^\s*($number+)\s*$/",$input,$o)) {
    return $o[1];
  } elseif ($multOrDiv) {
    $evaluated = operate($n[1],$n[2],$n[3]);
    if (preg_match("/^$number+$/",$evaluated)) {
      return preProcessExpr("$evaluated$n[4]");
    } else {
      return $evaluated;
    }
  } else {
    $r = "$m[1]$m[2]";
    $retVal = preProcessExpr("$m[3]$m[4]");
    return "$r$retVal";
  }
}

function parseExpr($inputExpr){
  global $number, $operators;
  if (preg_match("/^\s*$number+\s*$/",$inputExpr)) {
    $retVal = $inputExpr;
  } elseif (preg_match("/^($number+)\s*($operators)\s*($number+)$/",$inputExpr,$m)) { 
    $retVal= operate($m[1],$m[2],$m[3]);
  } elseif(preg_match("/^((($number+)\s*($operators)\s*)+)($number+\s*$)/",$inputExpr,$m)) {    
    //strip the last operator and call parseExpr recursively  
    $pre = substr("$m[1]",0,-1);
    $lastNum = array_pop($m);
    $op = array_pop($m);    

    // Recursive call to itself (front first)
    $retVal = operate(parseExpr($pre),$op,$lastNum);
  } else {
    $retVal = "Invalid Expression!";
  }
  return $retVal;
}

// Don't display any Result, if no input is provided by the user
if (isset($_GET['expr'])) {
  ?><h2>Result</h2><?php
  $in = $_GET['expr'];
  $processed_in = preProcessExpr($in);
  // if the result is an error, return the string msg only
  $result = (preg_match("/error/",$processed_in)) ? $processed_in : parseExpr($processed_in);
  echo (preg_match("/[error|invalid]/i",$result)) ? $result : "$in = $result";
}
?>


</body>
</html>

