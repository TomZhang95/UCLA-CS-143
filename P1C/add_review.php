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
					<mark class="cellcontent"> Add Review for Movies: </mark><br>
					<p>
						<form action="add_review.php" method="GET">
							
					
						Movie Title:	<br/>
									<select name="id">
										<?php
									//create connection with database for movie selection
									$connection = mysqli_connect("127.0.0.1", "cs143", "") or die(mysqli_connect_error());
									mysqli_select_db($connection, "CS143");

									//display movie into dropdown
									$movie_query = "SELECT id, title, year FROM Movie ORDER BY title ASC";
									$movie_result=mysqli_query($connection, $movie_query) or die(mysqli_error($connection));
									$movie_opt="";
									
									$get_ID=$_GET['id'];
									
									while ($row=mysqli_fetch_array($movie_result))
									{
										$id=$row["id"];
										$title=$row["title"];
										$year=$row["year"];
										
										//if movie ID matches the GET id specified in the URL, select that option by default
										if($id==$get_ID)
											$movie_opt.="<option value=\"$id\" selected>".$title." [".$year."]</option>";
										else
											$movie_opt.="<option value=\"$id\">".$title." [".$year."]</option>";	
									}
										?>
									<?=$movie_opt?>
								</select><br/></br>
							Rating:	<br/> <select name="rating">
								<option value="10"> 10 </option>
								<option value="9"> 9 </option>
								<option value="8"> 8 </option>
								<option value="7"> 7 </option>
								<option value="6"> 6 </option>
								<option value="5"> 5 </option>
								<option value="4"> 4 </option>
								<option value="3"> 3 </option>
								<option value="2"> 2 </option>
								<option value="1"> 1 </option>
							</select><br/><br/>
							Comments: <br/><textarea name="comment" placeholder="Your comment" value=><?php echo htmlspecialchars($_GET['comment']);?></textarea><br/>
							<br/>
							Reviewer Name:	<input type="text" placeholder="Your Name" name="name" value="<?php echo htmlspecialchars($_GET['name']);?>" maxlength="20"><br/><br/>
							<input type="submit" value="Submit Review"/>
							</form>

					</p>
		<?php
		
		//receive the input
		$get_name=trim($_GET["name"]);
		$get_movieID=$_GET["id"];
		$get_rating=$_GET["rating"];
		$get_comment=trim($_GET["comment"]);
		
		if($get_name=="" && $get_movieID=="" && $get_rating=="" && $get_comment==""){}
		else
		{
			//if reviewer left name blank, show as Anonymous
			if($get_name=="")
				$get_name = "Unknown";
			
			$query = "INSERT INTO Review (name, time, mid, rating, comment) VALUES('$get_name', now(), '$get_movieID', '$get_rating', '$get_comment')";
			$result = mysqli_query($connection, $query) or die(mysql_error($connection));
			
			echo "Thank You! Your review has been added.<br/>";
			// document.forms['comment_form'].reset();
		}
		mysqli_close($connection);
	?>
				</td>
			</tr>
		</table>

	</body>
</html>