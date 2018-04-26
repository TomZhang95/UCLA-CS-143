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
					<b> Add Review for Movies: </b><br>
					<p>
						<form action="add_review.php" method="GET">
							
					
						Movie Title:	<br/>
									<select name="id">
										<?php
									//establish connection with the MySQL database
									$db_connection = mysqli_connect("127.0.0.1", "cs143", "") or die(mysqli_connect_error());
									
									//choose database to use
									mysqli_select_db($db_connection, "CS143");
									//select all movie ids, titles, and years and place as options into dropdown
									$movieRS=mysqli_query($db_connection, "SELECT id, title, year FROM Movie ORDER BY title ASC") or die(mysqli_error($db_connection));
									$movieOptions="";
									
									$urlID=$_GET['id'];
									
									while ($row=mysqli_fetch_array($movieRS))
									{
										$id=$row["id"];
										$title=$row["title"];
										$year=$row["year"];
										
										//if movie ID matches the GET id specified in the URL, select that option by default
										if($id==$urlID)
											$movieOptions.="<option value=\"$id\" selected>".$title." [".$year."]</option>";
										else
											$movieOptions.="<option value=\"$id\">".$title." [".$year."]</option>";	
									}
										?>
									<?=$movieOptions?>
								</select><br/></br>
							Rating:	<br/> <select name="rating">
								<option value="10"> 100% </option>
								<option value="9"> 90% </option>
								<option value="8"> 80% </option>
								<option value="7"> 70% </option>
								<option value="6"> 60% </option>
								<option value="5"> 50% </option>
								<option value="4"> 40% </option>
								<option value="3"> 30% </option>
								<option value="2"> 20% </option>
								<option value="1"> 10% </option>
							</select><br/><br/>
							Comments: <br/><textarea name="comment" cols="80" rows="10" value=><?php echo htmlspecialchars($_GET['comment']);?></textarea><br/>
							<br/>
							Reviewer Name:	<input type="text" name="name" value="<?php echo htmlspecialchars($_GET['name']);?>" maxlength="20"><br/><br/>
							<input type="submit" value="Submit Review"/>
							</form>

					</p>
		<?php
		
		//get the user's inputs
		$dbName=trim($_GET["name"]);
		$dbMovie=$_GET["id"];
		$dbRating=$_GET["rating"];
		$dbComment=trim($_GET["comment"]);
		
		//pass in user inputs
		if($dbName=="" && $dbMovie=="" && $dbRating=="" && $dbComment=="")
		{
			//don't display a message, since no insert attempt was made (or the page just loaded)
		}
		else if($dbMovie=="")
		{
			echo "You must select a movie from the list.";
		}
		else if ($dbRating=="" || $dbRating>10 || $dbRating<1)
		{
			echo "You must select a valid rating.";
		}
		else //if we have reached this clause, no errors were found; process the query normally
		{
			//if reviewer left name blank, show as Anonymous
			if($dbName=="")
				$dbName = "Anonymous";
			
			//escape single-quotes in the inputs to make sure it doesn't break the string up
			// $dbName = mysql_escape_string($dbName);
			// $dbMovie = mysql_escape_string($dbMovie);
			// $dbComment = mysql_escape_string($dbComment);
			
			$dbQuery = "INSERT INTO Review (name, time, mid, rating, comment) VALUES('$dbName', now(), '$dbMovie', '$dbRating', '$dbComment')";
						
			//issue a query using database connection
			//if query is erroneous, produce error message "gracefully"
			$rs = mysqli_query($db_connection, $dbQuery) or die(mysql_error($db_connection));
			
			//present a success message`
			echo "Thanks! Movie review added successfully.<br/>";
			//echo "<a href=\"showMovieInfo.php?id=".$dbMovie."\">Back to Movie</a>";
		}
		
		//close the database connection
		mysqli_close($db_connection);
	?>
				</td>
			</tr>
		</table>

	</body>
</html>