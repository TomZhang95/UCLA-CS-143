<html>
<head><title>Calculator</title></head>
<body>

<h1>Calculator</h1>
(Project 1A by Tianyang Zhang & Reinaldo)<br />
Type an expression in the following box (e.g., 10.5+20*3/25).

<p>
	<form action="calculator.php" method="GET">
		<input type="text" name="input"><input type="submit" value="Calculate">
	</form>
</p>

<ul>
<li>Only numbers and +,-,* and / operators are allowed in the expression.
<li>The evaluation follows the standard operator precedence.
<li>The calculator does not support parentheses.
<li>The calculator handles invalid input "gracefully". It does not output PHP error messages.
</ul>
Here are some (but not limit to) reasonable test cases:
<ol>
  <li> A basic arithmetic operation: 3+4*5=23 </li>
  <li> An expression with floating point or negative sign: -3.2+2*4-1/3 = 4.46666666667, 3+-2.1*2 = -1.2 </li>
  <li> Some typos inside operation (e.g. alphabetic letter): Invalid input expression 2d4+1 </li>
</ol>

<?php
	$equation=$_GET["input"];
	$equation_without_space=str_replace(' ', '', $equation);
	$valid_expression=preg_match("/^[-+*.\/, 0-9]+$/",$equation);
	$divide_by_zero=preg_match("/\/[0]/",$equation);
	
	if($equation_without_space=="")
	{
	}
	elseif($divide_by_zero)
	{
		?>
			<h2>Result</h2>
		<?php
		echo "Invalid divide by zero.";
	}
	elseif($valid_expression)
	{
		?>
			<h2>Result</h2>
		<?php
		
		$error=@eval("\$answer=$equation;");
		
		if($error===FALSE)
		{
			echo "Invalid input " . $equation . ".";
		}
		else
		{
			echo $equation . " = " . $answer;
		}
	}
	else
	{
?>
		<h2>Result</h2>
<?php
		echo "Invalid input " . $equation . ".";
	}
?>
</body>
</html>