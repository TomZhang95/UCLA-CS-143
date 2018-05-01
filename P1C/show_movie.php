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
					<h2> Movie Information: </h2><br>

					<?php
						//Connect to db ----------------------------------------------------------
						$connection = mysqli_connect("127.0.0.1", "cs143", "") or die(mysqli_connect_error());
						mysqli_select_db($connection, "CS143");
						$mid = $_GET["mid"];

						//Create query for ACTOR info ------------------------------------------
						$query="SELECT title, year, rating, company
									FROM Movie 
									WHERE
									id =".$mid;

						$movie_data = mysqli_query($connection, $query) or die (mysqli_error($connection));

						$row = mysqli_fetch_row($movie_data);
						echo '<b>Movie Title: </b>'.$row[0].'<br>';
						echo '<b>Year: </b>'.$row[1].'<br>';

						if ($row[2] == NULL)
							echo '<b>MPAA: </b> N/A <br>';
						else
							echo '<b>MPAA: </b> '.$row[2].'<br>';

						if ($row[3] == NULL)
							echo '<b>Company: </b> N/A <br>';
						else
							echo '<b>Company: </b> '.$row[3].'<br>';

						//------------------------------ PHP ENDS ------------------------------
					?>

					<br><br>

					<h2>Actors in Movie:</h2><br>

					<?php
					//Get and print role and movie info ----------------------------------------

					$relation_query = "SELECT aid, role FROM MovieActor WHERE mid = ".$mid;

					$relation_data = mysqli_query($connection, $relation_query) or die (mysqli_error($connection));

					echo '<table border="1" cellPadding="5"> ';
					echo '<td align="center"><b>Title</b></td><td align="center"><b>Role</b></td>';

					while ($row = mysqli_fetch_array($relation_data)) {
						$actor_query = "SELECT first, last FROM Actor WHERE id=".$row["aid"];

						$actor_data = mysqli_query($connection, $actor_query) or die (mysqli_error($connection));

						$tmp = mysqli_fetch_array($actor_data);

						$name = "<a href='show_actor.php?aid=".$row["aid"]."'>".$tmp["first"]." ".$tmp["last"]."</a>";

						$role = $row["role"];

						echo '<tr align="left">';
						echo '<td>'.$name.'</td><td>"'.$role.'"</td>';

					}
					echo '</table><br><br>';
					//------------------------------ PHP ENDS ------------------------------
					?>

					<h2>Search Actor/Movie:</h2><br>

					<form action="search.php" method="GET">
						<input type="text" name="input" value="<?php echo htmlspecialchars($_GET['input']);?>" maxlength="35"><br/>		
						<input type="submit" value="Search"/>
					</form>


					<h2>Comments and User Rating:</h2><br>
					<?php
					$rating_query = "SELECT avg(rating)
							FROM Review
							WHERE mid='$mid'";

					$rating_data = mysqli_query($connection, $rating_query) or die (mysqli_error($connection));

					$row = mysqli_fetch_array($rating_data);

					$avg = $row[0];

					echo '<font color="2D70AE">Average Rating '. number_format($avg, 1) .' Stars</font><br><br>'; 

					$comment_query = "SELECT name, time, rating, comment
										FROM Review 
										WHERE mid='$mid'";
					$comment_data = mysqli_query($connection, $comment_query) or die (mysqli_error($connection));

					while ($row = mysqli_fetch_array($comment_data)) {
						$name = $row[0];
						$time = $row[1];
						$rating = $row[2];
						$comment = $row[3];

						echo '<font color="2D70AE">'. $name .':</font><br>';
						echo 'Rating: '. $rating . ' Stars<br>';
						echo $time . '<br>';
						echo $comment.'<br><br>';

					}

					?>
					<br>
				</td>
			</tr>
		</table>

	</body>
</html>