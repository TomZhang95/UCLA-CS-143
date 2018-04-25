<html>
<head><title>Web Query Interface</title></head>

<body>
	<h1>Web Query Interface</h1>
	<br />
	Type a MySQL SELECT Query below:

	<p>
		<form action="query.php" method="GET">
			<textarea name="input" cols="100" rows="5"><?php echo htmlspecialchars($_GET['input']);?></textarea>
			<input type="submit" value="Submit" />
		</form>
	</p>

	<br />
	Result from Database:
	<br />

	<table border=1><tr align="center">

	<?php
		//echo 'connecting';
		$connection = mysqli_connect("127.0.0.1", "cs143", "") or die(mysqli_connect_error());
		//echo 'connected';
		mysqli_select_db($connection, "CS143");
		//echo 'selected database';
		$query = $_GET["input"];
		$data = mysqli_query($connection, $query) or die (mysqli_error($connection));
		//echo mysqli_fetch_field($data)->name;
		
		$i = 0;
		while($i < mysqli_num_fields($data)) {
			$col = mysqli_fetch_field($data);
			//Print header in Bold
			echo '<td><b>' . $col->name . '</b></td>';
			$i = $i + 1;
		}

		$i = 0;
		while($row = mysqli_fetch_row($data)) {
			echo '<tr align="center">';
			$len = count($row);
			$j = 0;
			while($j < $len) {
				$current_row = current($row);
				if($current_row == NULL)
					echo '<td>N/A</td>';
				else
					echo '<td>' . $current_row . '</td>';
					
				next($row);
				$j = $j + 1;
			}
			echo '</tr>';
			$i = $i + 1;
		}

		//Free space and connection will close automaticaly
		mysqli_free_result($data);
	?>

	</table>

</body>
</html>