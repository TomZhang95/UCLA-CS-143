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
					<mark class="cellcontent"> Add new Movies! </mark><br>
					<p>
						<form action="add_movie_info.php" method="GET">			
							Movie Title  <br/> 
							<input type="text" placeholder="Movie name..." name="title" maxlength="20" value="<?php echo htmlspecialchars($_GET['title']);?>"><br/><br/> 
							Company  <br/> 
							<input type="text" placeholder="Company name..." name="company" maxlength="50" value="<?php echo htmlspecialchars($_GET['company']);?>"><br/><br/> 
							Year <br/>  
							<input type="text" placeholder="YYYY" name="year" maxlength="4" value="<?php echo htmlspecialchars($_GET['year']);?>"><br/><br/>
							MPAA Rating : <select name="mpaarating">
								<option value="G" <?php echo (htmlspecialchars($_GET['mpaarating'])=='G')?'selected':''?>>G</option>
								<option value="PG" <?php echo (htmlspecialchars($_GET['mpaarating'])=='PG')?'selected':''?>>PG</option>
								<option value="PG-13" <?php echo (htmlspecialchars($_GET['mpaarating'])=='PG-13')?'selected':''?>>PG-13</option>
								<option value="R" <?php echo (htmlspecialchars($_GET['mpaarating'])=='R')?'selected':''?>>R</option>
								<option value="NC-17" <?php echo (htmlspecialchars($_GET['mpaarating'])=='NC-17')?'selected':''?>>NC-17</option>
								<option value="surrendere" <?php echo (htmlspecialchars($_GET['mpaarating'])=='surrendere')?'selected':''?>>surrendere</option>
							</select><br/>
							Genre :
							<table border="0" style="width:600px">
								<tr>
									<td><input type="checkbox" name="genre[]" value="Action">Action</input></td>
									<td><input type="checkbox" name="genre[]" value="Adult">Adult</input></td>
									<td><input type="checkbox" name="genre[]" value="Adventure">Adventure</input></td>
									<td><input type="checkbox" name="genre[]" value="Animation">Animation</input></td>
								</tr>
								<tr>
									<td><input type="checkbox" name="genre[]" value="Comedy">Comedy</input></td>
									<td><input type="checkbox" name="genre[]" value="Crime">Crime</input></td>
									<td><input type="checkbox" name="genre[]" value="Documentary">Documentary</input</td>
									<td><input type="checkbox" name="genre[]" value="Drama">Drama</input></td>
								</tr>
								<tr>
									<td><input type="checkbox" name="genre[]" value="Family">Family</input></td>
									<td><input type="checkbox" name="genre[]" value="Fantasy">Fantasy</input></td>
									<td><input type="checkbox" name="genre[]" value="Horror">Horror</input></td>
									<td><input type="checkbox" name="genre[]" value="Musical">Musical</input></td>
								</tr>
								<tr>	
									<td><input type="checkbox" name="genre[]" value="Mystery">Mystery</input></td>
									<td><input type="checkbox" name="genre[]" value="Romance">Romance</input></td>
									<td><input type="checkbox" name="genre[]" value="Sci-Fi">Sci-Fi</input></td>
									<td><input type="checkbox" name="genre[]" value="Short">Short</input></td>
								</tr>
								<tr>
									<td><input type="checkbox" name="genre[]" value="Thriller">Thriller</input></td>
									<td><input type="checkbox" name="genre[]" value="War">War</input></td>
									<td><input type="checkbox" name="genre[]" value="Western">Western</input></td>
									<td><input type="checkbox" name="genre[]" value="Other">Other</input></td>
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

						$get_title=trim($_GET["title"]);
						$get_company=trim($_GET["company"]);
						$get_year=trim($_GET["year"]);
						$get_rating=$_GET["mpaarating"];
						$get_genre=$_GET["genre"];

						$maximum_id = mysqli_query($connection, "SELECT MAX(id) FROM MaxMovieID") or die(mysqli_error($connection));
						$maximum_id_arr = mysqli_fetch_array($maximum_id);
						$maxID = $maximum_id_arr[0];
						$max_id_rs = $maxID + 1;


						//Create query for add Movie ------------------------------------------
						if($get_title=="" && $get_company=="" && $get_year=="")
						{
							//don't display a message, since no insert attempt was made (or the page just loaded)
						}
						else if ($get_title=="")
						{
							echo "Please enter a movie title";
						}
						else if($get_year=="" || $get_year<=1800 || $get_year>=2100)
						{
							echo "Please enter a valid movie production year. (Between 1800 and 2100)";
						}
						
						else 
						{
							// $get_title = mysql_escape_string($get_title);
							// $get_company = mysql_escape_string($get_company);
						
							if($get_company=="")
								$query = "INSERT INTO Movie (id, title, year, rating, company) VALUES('$max_id_rs', '$get_title', '$get_year', '$get_rating', '$get_company')";
							else
								$query = "INSERT INTO Movie (id, title, year, rating, company) VALUES('$max_id_rs', '$get_title', '$get_year', '$get_rating', '$get_company')";
							
							//issue a query using database connection
							//if query is erroneous, produce error message "gracefully"
							$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
							
							//update the max movie ID
							$idquery = "UPDATE MaxMovieID SET id=$max_id_rs WHERE id=$maxID";
							mysqli_query($connection, $idquery) or die(mysql_error($connection));
							
							for($i=0; $i < count($get_genre); $i++)
							{
								$genreQuery = "INSERT INTO MovieGenre (mid, genre) VALUES ('$max_id_rs', '$get_genre[$i]')";
								$genreRS = mysqli_query($connection, $genreQuery) or die(mysql_error($connection));
							}
							
							//present a success message`
							echo "$get_title added to database with id=$max_id_rs";
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