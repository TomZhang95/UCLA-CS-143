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
					<h2> Actor Information: </h2><br>

					<?php
						//Connect to db ----------------------------------------------------------
						$connection = mysqli_connect("127.0.0.1", "cs143", "") or die(mysqli_connect_error());
						mysqli_select_db($connection, "CS143");
						$aid = $_GET["aid"];

						//Create query for ACTOR info ------------------------------------------
						$query="SELECT first AS First_Name, last AS Last_Name, sex AS Sex,
									dob AS Date_of_Birth, dod AS Date_of_Death
									FROM Actor 
									WHERE
									id =".$aid;

						$actor_data = mysqli_query($connection, $query) or die (mysqli_error($connection));

						$row = mysqli_fetch_row($actor_data);
						echo '<b>Actor Name: </b>'.$row[0].' '.$row[1].'<br>';
						echo '<b>Gender: </b>'.$row[2].'<br>';
						echo '<b>Date of Birth: </b>'.$row[3].'<br>';
						if ($row[4] == NULL)
							echo '<b>Date of Death: </b> N/A (Still Alive)<br>';
						else
							echo '<b>Date of Death: </b> '.$row[4];

						//------------------------------ PHP ENDS ------------------------------
					?>

					<br><br>

					<h2>Actor's Movie and Role:</h2><br>

					<?php
					//Get and print role and movie info ----------------------------------------

					$relation_query = "SELECT mid, role FROM MovieActor WHERE aid = ".$aid;

					$relation_data = mysqli_query($connection, $relation_query) or die (mysqli_error($connection));

					echo '<table border="1" cellPadding="5"> ';
					echo '<td align="center"><b>Title</b></td><td align="center"><b>Role</b></td>';

					while ($row = mysqli_fetch_array($relation_data)) {
						$movie_query = "SELECT title FROM Movie WHere id=".$row["mid"];

						$movie_data = mysqli_query($connection, $movie_query) or die (mysqli_error($connection));

						$tmp = mysqli_fetch_array($movie_data);

						$title = "<a href='show_movie.php?mid=".$row["mid"]."'>".$tmp["title"]."</a>";

						$role = $row["role"];

						echo '<tr align="left">';
						echo '<td>'.$title.'</td><td>"'.$role.'"</td>';

					}
					echo '</table><br><br>';
					//------------------------------ PHP ENDS ------------------------------
					?>

					<h2>Search Actor/Movie:</h2><br>

					<form action="search.php" method="GET">
						<input type="text" name="input" value="<?php echo htmlspecialchars($_GET['input']);?>" maxlength="35"><br/>		
						<input type="submit" value="Search"/>
					</form>
					<br>
				</td>
			</tr>
		</table>

	</body>
</html>