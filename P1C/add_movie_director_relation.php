<!DOCTYPE html>
<html>
	<!---------------------------------- Top Cell---------------------------------->
	<head> 
		<meta charset="utf-8"> 
		<title>Project 1C Movie Database</title> 
		<link rel="stylesheet" href="style.css">
	</head>

	<body>
		<table cellspacing="0" cellpadding="0" style="width:100%; height:100%">
			<tr>
				<td style="background-color:#2D70AE;" colspan="2">
					<center><mark class="h1title2">movie</mark><mark class="h1title">Base</mark></center>
					<center><mark class="italicwhite">#1 database movies by Reinaldo Daniswara and Tianyang Zhang</mark></center>
				</td>
			</tr>
			<!---------------------------------- Left Cell---------------------------------->
			<tr>
				<td style="background-color:#F6FBFD ;width:200px;vertical-align:top;">
					<mark class="leftorder">Add New Content:</mark><br>
					<ul>
						<li><a href="add_actor_director.php">Add Actor/Director</a>
						<li><a href="add_movie_info.php">Add Movie Information</a>
						<li><a href="add_movie_actor_relation.php">Add Movie/Actor Relation</a>
						<li><a href="add_movie_director_relation.php">Add Movie/Director Relation</a>
						<li><a href="add_review.php">Add Review for Movies</a>
					</ul>	
					
					<br><br>

					Search Interface:<br>
					<ul>
						<li><a href="search.php">Search Actor/Movie</a><br><br>
					</ul>
					<br>
				</td>

				<!---------------------------------- Contents Cell---------------------------------->
				<td valign="top">
					<p>
						<form action="add_movie_director_relation.php" method="GET">
													
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
							echo '<mark class="cellcontent">Movie Title:</mark><br><br>';
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

							//Create query for director list  ---------------------------------------------
							$query="SELECT id, first, last, YEAR(dob) AS birth, YEAR(dod) AS death
										FROM Director
										ORDER BY first, last";

							$director_data = mysqli_query($connection, $query) or die (mysqli_error($connection));

							//Print movie list ---------------------------------------------------------
							echo '<br><mark class="cellcontent">Director:</mark><br><br>';
							echo '<select name="director">';

							while ($row = mysqli_fetch_array($director_data)) {
								$did = $row["id"];
								$first = $row["first"];
								$last = $row["last"];
								$dob = $row["birth"];
								$dod = $row["death"];
								if ($dod == NULL)
									$dod = "Present";

								$director_list = "<option value=\"$did\">".$first." ".$last." (".$dob."~".$dod.") </option>";

								echo $director_list;
							}
							echo '</select><br><br>';

							mysqli_free_result($director_data);
							//------------------------------ PHP ENDS ------------------------------
						?>


						<input type="submit" value="Add"/>

						</form>

						<?php
						//Insert relation to database -----------------------------------------------
						//Get inputs from above
						$mid=$_GET["movie"];
						$did=$_GET["director"];

						if ($did=="" || $mid=="") {
							die('You must select a movie and an director.');
						}
						else {
							$role = mysqli_real_escape_string($connection, $role);

							$query = "INSERT INTO MovieDirector (mid, did)
										VALUES (".$mid.", ".$did.")";

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