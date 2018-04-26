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
					<b> Add new Movies! </b><br>
					<p>
						<form action="add_movie_info.php" method="GET">			
							Movie Title  <br/> 
							<input type="text" name="title" maxlength="20" value="<?php echo htmlspecialchars($_GET['title']);?>"><br/><br/> 
							Company  <br/> 
							<input type="text" name="company" maxlength="50" value="<?php echo htmlspecialchars($_GET['company']);?>"><br/><br/> 
							Year <br/>  
							<input type="text" name="year" maxlength="4" value="<?php echo htmlspecialchars($_GET['year']);?>"><br/><br/>
							MPAA Rating : <select name="mpaarating">
								<option value="G" <?php echo (htmlspecialchars($_GET['mpaarating'])=='G')?'selected':''?>>G</option>
								<option value="NC-17" <?php echo (htmlspecialchars($_GET['mpaarating'])=='NC-17')?'selected':''?>>NC-17</option>
								<option value="PG" <?php echo (htmlspecialchars($_GET['mpaarating'])=='PG')?'selected':''?>>PG</option>
								<option value="PG-13" <?php echo (htmlspecialchars($_GET['mpaarating'])=='PG-13')?'selected':''?>>PG-13</option>
								<option value="R" <?php echo (htmlspecialchars($_GET['mpaarating'])=='R')?'selected':''?>>R</option>
								<option value="surrendere" <?php echo (htmlspecialchars($_GET['mpaarating'])=='surrendere')?'selected':''?>>surrendere</option>
							</select><br/>
							Genre :
							<table border="0" style="width:600px">
								<tr>
									<td><input type="checkbox" name="genre[]" value="Action">Action</input></td>
									<td><input type="checkbox" name="genre[]" value="Adult">Adult</input></td>
									<td><input type="checkbox" name="genre[]" value="Adventure">Adventure</input></td>
									<td><input type="checkbox" name="genre[]" value="Animation">Animation</input></td>
									<td><input type="checkbox" name="genre[]" value="Comedy">Comedy</input></td>
								</tr>
								<tr>
									<td><input type="checkbox" name="genre[]" value="Crime">Crime</input></td>
									<td><input type="checkbox" name="genre[]" value="Documentary">Documentary</input</td>
									<td><input type="checkbox" name="genre[]" value="Drama">Drama</input></td>
									<td><input type="checkbox" name="genre[]" value="Family">Family</input></td>
									<td><input type="checkbox" name="genre[]" value="Fantasy">Fantasy</input></td>
								</tr>
								<tr>
									<td><input type="checkbox" name="genre[]" value="Horror">Horror</input></td>
									<td><input type="checkbox" name="genre[]" value="Musical">Musical</input></td>
									<td><input type="checkbox" name="genre[]" value="Mystery">Mystery</input></td>
									<td><input type="checkbox" name="genre[]" value="Romance">Romance</input></td>
									<td><input type="checkbox" name="genre[]" value="Sci-Fi">Sci-Fi</input></td>
								</tr>
								<tr>
									<td><input type="checkbox" name="genre[]" value="Short">Short</input></td>
									<td><input type="checkbox" name="genre[]" value="Thriller">Thriller</input></td>
									<td><input type="checkbox" name="genre[]" value="War">War</input></td>
									<td><input type="checkbox" name="genre[]" value="Western">Western</input></td>
								</tr>
							</table> 

							<br/>
							<input type="submit" value="Add Movie"/>
						</form>

					</p>
					<?php
						//Connect to db ----------------------------------------------------------
						$connection = mysqli_connect("127.0.0.1", "cs143", "") or die(mysqli_connect_error());
						mysqli_select_db($connection, "CS143");

						$dbTitle=trim($_GET["title"]);
						$dbCompany=trim($_GET["company"]);
						$dbYear=trim($_GET["year"]);
						$dbRating=$_GET["mpaarating"];
						$dbGenre=$_GET["genre"];

						$maxIDrs = mysqli_query($connection, "SELECT MAX(id) FROM MaxMovieID") or die(mysqli_error($connection));
						$maxIDArray = mysqli_fetch_array($maxIDrs);
						$maxID = $maxIDArray[0];
						$newMaxID = $maxID + 1;


						//Create query for add Movie ------------------------------------------
						if($dbTitle=="" && $dbCompany=="" && $dbYear=="")
						{
							//don't display a message, since no insert attempt was made (or the page just loaded)
						}
						else if ($dbTitle=="")
						{
							echo "Please enter a movie title";
						}
						else if($dbYear=="" || $dbYear<=1800 || $dbYear>=2100)
						{
							echo "Please enter a valid movie production year.";
						}
						
						else //if we have reached this clause, no errors were found; process the query normally
						{
							// $dbTitle = mysql_escape_string($dbTitle);
							// $dbCompany = mysql_escape_string($dbCompany);
						
							if($dbCompany=="")
								$dbQuery = "INSERT INTO Movie (id, title, year, rating, company) VALUES('$newMaxID', '$dbTitle', '$dbYear', '$dbRating', '$dbCompany')";
							else
								$dbQuery = "INSERT INTO Movie (id, title, year, rating, company) VALUES('$newMaxID', '$dbTitle', '$dbYear', '$dbRating', '$dbCompany')";
							
							//issue a query using database connection
							//if query is erroneous, produce error message "gracefully"
							$result = mysqli_query($connection, $dbQuery) or die(mysqli_error($connection));
							
							//update the max movie ID
							mysqli_query($connection, "UPDATE MaxMovieID SET id=$newMaxID WHERE id=$maxID") or die(mysql_error($connection));
							
							for($i=0; $i < count($dbGenre); $i++)
							{
								$genreQuery = "INSERT INTO MovieGenre (mid, genre) VALUES ('$newMaxID', '$dbGenre[$i]')";
								$genreRS = mysqli_query($connection, $genreQuery) or die(mysql_error($connection));
							}
							
							//present a success message`
							echo "New movie added (with id=$newMaxID).";
						}
						
						//close the database connection
						mysqli_close($connection);

						//------------------------------ PHP ENDS ------------------------------
					?>
				</td>
			</tr>
		</table>

	</body>
</html>