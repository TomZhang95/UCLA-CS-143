<!DOCTYPE html>
<html>
	<!---------------------------------- Top Cell---------------------------------->
	<head> 
		<meta charset="utf-8"> 
		<title>Project 1C Movie Database</title> 
	</head>

	<body>
		<table border="1" style="width:100%; height:100%">
			<tr>
				<td style="background-color:Black;" colspan="2">
					<h1 style="color:White"> Movie Database </h1>
				</td>
			</tr>
			<!---------------------------------- Left Cell---------------------------------->
			<tr>
				<td style="background-color:AliceBlue;width:200px;vertical-align:top;">
					Add New Content<br><br>
					&nbsp;&nbsp;<a href="add_actor_director.php">Add Actor/Director</a><br><br>
					&nbsp;&nbsp;<a href="add_movie_info.php">Add Movie Information</a><br><br>
					&nbsp;&nbsp;<a href="add_movie_actor_relation.php">Add Movie/Actor Relation</a><br><br>
					&nbsp;&nbsp;<a href="add_movie_director_relation.php">Add Movie/Director Relation</a><br><br>
					&nbsp;&nbsp;<a href="add_review.php">Add Review for Movies</a><br><br>
					<br><br>

					Search Interface:<br><br>
					&nbsp;&nbsp;<a href="search.php">Search Actor/Movie</a><br><br>
					<br>
				</td>

				<!---------------------------------- Contents Cell---------------------------------->
				<td valign="top">
					<b> Search Actor/Movie: </b><br>
					<p>
						<form action="search.php" method="GET">
						
							<input type="text" name="input" value="<?php echo htmlspecialchars($_GET['input']);?>" maxlength="35"><br/>		
							<input type="submit" value="Search"/>
						</form>
					</p>
					<?php
						//Connect to db ----------------------------------------------------------
						$connection = mysqli_connect("127.0.0.1", "cs143", "") or die(mysqli_connect_error());
						mysqli_select_db($connection, "CS143");
						$input = $_GET["input"];

						$s = mysqli_real_escape_string($connection, $input);

						if ($s == "")
							die("Input is empty!");

						$terms=explode(' ', $s);

						$length = count($terms);

						//Create query for ACTOR search ------------------------------------------
						$query="SELECT id, first AS First_Name, last AS Last_Name, 
									dob AS Date_of_Birth
									FROM Actor 
									WHERE
									(first LIKE '%$terms[0]%' OR last LIKE '%$terms[0]%') ";

						for ($i=1; $i<$length; $i++) {
							$query = $query."AND (first LIKE '%$terms[$i]%' OR last LIKE '%$terms[$i]%') ";
						}

						$query = $query."ORDER BY First_Name, Last_Name";


						$result = mysqli_query($connection, $query) or die (mysqli_error($connection));

						//Print actor searching result -------------------------------------------
						echo '<h2> Actor Searching Result: </h2>';

						echo '<table border="1" cellPadding="5"> ';

						$i = 0;
						while($i < mysqli_num_fields($result)) {
							$col = mysqli_fetch_field($result);

							//Print header in Bold
							if ($col->name != 'id') {
							echo '<td align="center"><b>' . $col->name . '</b></td>';
							}
							
							$i = $i + 1;
						}

						$i = 0;
						while($row = mysqli_fetch_row($result)) {
							echo '<tr align="center">';
							$len = count($row);
							$aid=$row[0];

							for($j=1; $j<$len; $j++) {
								$current_row = $row[$j];
								if($current_row == NULL)
									echo '<td>N/A</td>';
								else {
									$current_row = "<a href='show_actor.php?aid=".$aid."'>".$current_row."</a>";
									echo '<td>' . $current_row . '</td>';
								}
							}

							echo '</tr>';
							$i = $i + 1;
						}
						echo '</table>';

						//Create query for MOVIE search ------------------------------------------
						$query="SELECT id, title AS Title, year AS Year, rating AS Rating
									FROM Movie 
									WHERE
									(title LIKE '%$terms[0]%')";

						for ($i=1; $i<$length; $i++) {
							$query = $query."AND (title LIKE '%$terms[$i]%') ";
						}

						$query = $query."ORDER BY Title";


						$result = mysqli_query($connection, $query) or die (mysqli_error($connection));

						//Print movie searching result -------------------------------------------
						echo '<br><br><h2> Movie Searching Result: </h2>';

						echo '<table border="1" cellPadding="5"> ';

						$i = 0;
						while($i < mysqli_num_fields($result)) {
							$col = mysqli_fetch_field($result);
							//Print header in Bold
							if ($col->name != 'id') {
							echo '<td align="center"><b>' . $col->name . '</b></td>';
							}

							$i = $i + 1;
						}

						$i = 0;
						while($row = mysqli_fetch_row($result)) {
							echo '<tr align="center">';
							$len = count($row);
							$mid = $row[0];

							for($j=1; $j<$len; $j++) {
								$current_row = $row[$j];
								if($current_row == NULL)
									echo '<td>N/A</td>';
								else {
									$current_row = "<a href='show_movie.php?mid=".$mid."'>".$current_row."</a>";
									echo '<td>' . $current_row . '</td>';
								}
							}

							echo '</tr>';
							$i = $i + 1;
						}
						echo '</table>';

						//------------------------------ PHP ENDS ------------------------------
					?>
				</td>
			</tr>
		</table>

	</body>
</html>