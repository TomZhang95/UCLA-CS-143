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
					<br><br>

					Browsering Content :<br><br>
					&nbsp;&nbsp;<a href="show_actor_info.php">Show Actor Information</a><br><br>
					&nbsp;&nbsp;<a href="show_movie_info.php">Show Movie Information</a><br><br>
					<br><br>

					Search Interface:<br><br>
					&nbsp;&nbsp;<a href="search.php">Search Actor/Movie</a><br><br>

					<br>
				</td>

				<!---------------------------------- Contents Cell---------------------------------->
				<td valign="top">
					<p>
						<form action="add_movie_actor_relation.php" method="GET">
													
						<?php
							//Connect to db ----------------------------------------------------------
							$connection = mysqli_connect("127.0.0.1", "cs143", "") or die(mysqli_connect_error());
							mysqli_select_db($connection, "CS143");

							//Create query for movie list  ---------------------------------------------
							$query="SELECT id, title, year, rating
										FROM Movie
										ORDER BY title";

							$movie_data = mysqli_query($connection, $query) or die (mysqli_error($connection));

							//Print movie list ---------------------------------------------------------
							echo '<h3>Movie Title:</h3><br>';
							echo '<select name="movie">';
							
							while ($row = mysqli_fetch_array($movie_data)) {
								$mid = $row["id"];
								$title = $row["title"];
								$year = $row["year"];
								$rating = $row["rating"];
								$movie_list = "<option value=\"$mid\">".$title." (".$year.") [".$rating."]</option>";
								
								echo $movie_list;
							}
							echo '</select><br>';
							mysqli_free_result($movie_data);

							//Create query for actor list  ---------------------------------------------
							$query="SELECT id, first, last, YEAR(dob) AS birth, YEAR(dod) AS death
										FROM Actor
										ORDER BY first, last";

							$actor_data = mysqli_query($connection, $query) or die (mysqli_error($connection));

							//Print movie list ---------------------------------------------------------
							echo '<h3>Actor:</h3><br>';
							echo '<select name="actor">';

							while ($row = mysqli_fetch_array($actor_data)) {
								$aid = $row["id"];
								$first = $row["first"];
								$last = $row["last"];
								$dob = $row["birth"];
								$dod = $row["death"];
								if ($dod == NULL)
									$dod = "Present";

								$actor_list = "<option value=\"$aid\">".$first." ".$last." (".$dob."~".$dod.") </option>";

								echo $actor_list;
							}
							echo '</select><br>';

							mysqli_free_result($actor_data);
							//------------------------------ PHP ENDS ------------------------------
						?>


						<h3>Role:</h3><br>
						<input type="text" name="role" value="<?php echo htmlspecialchars($_GET['role']);?>" maxlength="35"><br>
						<input type="submit" value="Add"/>

						</form>

						<?php
						//Insert relation to database -----------------------------------------------
						//Get inputs from above
						$mid=$_GET["movie"];
						$aid=$_GET["actor"];
						$role=trim($_GET["role"]);

						if ($role=="" || $mid=="" || $aid=="") {
							die('You must select a movie, an actor, and type the role.');
						}
						else {
							$role = mysqli_real_escape_string($connection, $role);

							$query = "INSERT INTO MovieActor (mid, aid, role)
										VALUES (".$mid.", ".$aid.", '".$role."')";

							$result = mysqli_query($connection, $query) or die (mysqli_error($connection));

							echo 'Adding success';
						}
						//------------------------------ PHP ENDS ------------------------------
						?>
					</p>

				</td>
			</tr>
		</table>

	</body>
</html>