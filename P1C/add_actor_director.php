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
					<b> Add Actor/Director: </b><br>
					<p>
						<form action="add_actor_director.php" method="GET">
							Type:	<input type="radio" name="type" value="Actor" <?php echo (htmlspecialchars($_GET['type'])=='Actor')?'checked':''?>>Actor
									<input type="radio" name="type" value="Director" <?php echo (htmlspecialchars($_GET['type'])=='Director')?'checked':''?>>Director<br/>
							First Name:	<input type="text" name="first" maxlength="20" value="<?php echo htmlspecialchars($_GET['first']);?>"><br/>
							Last Name:	<input type="text" name="last" maxlength="20" value="<?php echo htmlspecialchars($_GET['last']);?>"><br/>
							Sex:	<input type="radio" name="sex" value="Male" <?php echo (htmlspecialchars($_GET['sex'])=='Male')?'checked':''?>>Male
									<input type="radio" name="sex" value="Female" <?php echo (htmlspecialchars($_GET['sex'])=='Female')?'checked':''?>>Female<br/>
							Date of Birth:	<input type="text" name="dob" maxlength="10" value="<?php echo htmlspecialchars($_GET['dob']);?>"> (YYYY-MM-DD)<br/>
							Date of Death:	<input type="text" name="dod" maxlength="10" value="<?php echo htmlspecialchars($_GET['dod']);?>"> (YYYY-MM-DD, if applicable)<br/>
							<br/>
							<input type="submit" value="Add me!!"/>
						</form>

					</p>
					<?php
						//Connect to db ----------------------------------------------------------
						$connection = mysqli_connect("127.0.0.1", "cs143", "") or die(mysqli_connect_error());
						mysqli_select_db($connection, "CS143");

						//record all the input
						$dbType=trim($_GET["type"]);
						$dbFirst=trim($_GET["first"]);
						$dbLast=trim($_GET["last"]);
						$dbSex=trim($_GET["sex"]);
						$dbDOB=trim($_GET["dob"]);
						$dbDOD=trim($_GET["dod"]);
						//$input = $_GET["input"];

						//parse the date ----------------

						$dateDOB = date_parse($dbDOB);
						$dateDOD = date_parse($dbDOD);


						$maxIDrs = mysqli_query($connection, "SELECT MAX(id) FROM MaxPersonID") or die(mysqli_error($connection));
						$maxIDArray = mysqli_fetch_array($maxIDrs);
						$maxID = $maxIDArray[0];
						$newMaxID = $maxID + 1;


						//Create query for ACTOR search ------------------------------------------
						if($dbType=="" && $dbFirst=="" && $dbLast=="" && $dbSex=="" && $dbDOB=="" && $dbDOD=="") //everything is empty
						{
							echo "Please input some informations to add";
						}
						else if($dbType=="")
						{
							echo "You must select either Actor or Director to input.";
						}
						else if($dbFirst=="" || $dbLast=="")
						{
							echo "You must enter a valid first and last name.";
						}
						else if(preg_match('/[^A-Za-z\s\'-]/', $dbFirst) || preg_match('/[^A-Za-z\s\'-]/', $dbLast))
						{
							echo "Only letters, spaces, single-quotes, and hyphens are allowed in the $dbType name.";
						}
						else if($dbType=='Actor' && $dbSex=="")
						{
							echo "You must specify the Actor's sex.";
						}
						else if($dbDOB=="" || !checkdate($dateDOB["month"], $dateDOB["day"], $dateDOB["year"]))
						{
							echo "You must specify a valid date of birth.";
						}
						else if($dbDOD!="" && !checkdate($dateDOD["month"], $dateDOD["day"], $dateDOD["year"]))
						{
							echo "If you specify a date of death, it must be valid.";
						}
						else //if we have reached this clause, no errors were found; process the query normally
						{
							//escape single-quotes in the inputs to make sure it doesn't break the string up
							//$dbLast = mysqli_real_escape_string($dbLast);
							//$dbFirst = mysqli_real_escape_string($dbFirst);
							
		
							if($dbType=="Actor")
								{
									if($dbDOD=="")
										$dbQuery = "INSERT INTO Actor (id, last, first, sex, dob, dod) VALUES('$newMaxID', '$dbLast', '$dbFirst', '$dbSex', '$dbDOB', NULL)";
									else
										$dbQuery = "INSERT INTO Actor (id, last, first, sex, dob, dod) VALUES('$newMaxID', '$dbLast', '$dbFirst', '$dbSex', '$dbDOB', '$dbDOD')";
								}
							else //Director
								{
									if($dbDOD=="")
										$dbQuery = "INSERT INTO Director (id, last, first, dob, dod) VALUES('$newMaxID', '$dbLast', '$dbFirst', '$dbDOB', NULL)";
									else
										$dbQuery = "INSERT INTO Director (id, last, first, dob, dod) VALUES('$newMaxID', '$dbLast', '$dbFirst', '$dbDOB', '$dbDOD')";
								}
			
			//issue a query using database connection
			//if query is erroneous, produce error message "gracefully"
								$result = mysqli_query($connection, $dbQuery) or die(mysqli_error($connection));
			
			//update the max person ID
								mysqli_query($connection, "UPDATE MaxPersonID SET id=$newMaxID WHERE id=$maxID") or die(mysqli_error($connection));
			
			//present a success message`
								echo "New $dbType added with first name $dbFirst, last name $dbLast (with id=$newMaxID).";
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